<?php

namespace App\Http\Controllers;

use App\Http\Models\Absence;
use App\Http\Models\LevelSetting;
use App\Http\Models\Sector;
use App\Http\Models\User;
use App\Http\Models\UserSector;
use App\Http\Requests\Absence\AbsenceCreateRequest;
use App\Http\Responses\AbsenceCollectionResponse;
use App\Http\Responses\AbsenceResponse;
use Carbon\Carbon;
use Curl\Curl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AbsenceController extends Controller
{
    /**
     * @var Curl $curl
     */
    private Curl $curl;

    /**
     * AbsenceController constructor.
     *
     * @param Curl $curl
     */
    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return AbsenceCollectionResponse
     */
    public function index(Request $request)
    {
        $levelSettingModel = new LevelSetting();
        $levelSettingModel->setConnection($request->header('DB-Connection'));

        $userModel = new User();
        $userModel->setConnection($request->header('DB-Connection'));

        $user = $userModel->newQuery()->where('app_token_notificacao', 'LIKE', $request->header('FCM-Token'))->first();

        $levelSetting = $levelSettingModel->newQuery()->findOrFail($user->nivel_id);

        $currentDate = Carbon::now();

        $initialDate = Carbon::parse($currentDate)->startOfMonth();
        $lastDate = Carbon::parse($currentDate);

        $numberOfDaysInMonth = Carbon::parse($initialDate)->daysInMonth;

        $lastDate->day($numberOfDaysInMonth);

        if ($levelSetting->meta == 'Quinzenal') {
            $currentDay = $currentDate->day;

            if ($currentDay > 15) {
                $initialDate->day(16);
            } else {
                $lastDate->day(15);
            }
        }

        $userSectorModel = new UserSector();
        $userSectorModel->setConnection($request->header('DB-Connection'));

        $userSectors = $userSectorModel->newQuery()
            ->where('usuario_id', $user->id)
            ->where('rotina', 'observarAprovaAusencia')
            ->get();

        if (!is_null($userSectors) && $userSectors->count() > 0) {
            $sectorsSearchMultidimensional = [];
            $sectorsToSearch = [];

            foreach ($userSectors as $userSector) {
                $sectorModel = new Sector();
                $sectorModel->setConnection($request->header('DB-Connection'));

                $sector = $sectorModel->newQuery()->findOrFail($userSector->setor_id);

                if (!is_null($sector->setor_filho)) {
                    $sectorPermittedChildren = explode(',', $sector->setor_filho);

                    array_push($sectorsSearchMultidimensional, $sectorPermittedChildren);
                } else {
                    array_push($sectorsSearchMultidimensional, [$sector->id]);
                }

                $sectorsSearch = call_user_func_array('array_merge', $sectorsSearchMultidimensional);
                sort($sectorsSearch);

                $sectorsUnique = array_unique($sectorsSearch);

                $userSectorModel = new UserSector();
                $userSectorModel->setConnection($request->header('DB-Connection'));

                $sectorsHasUser = $userSectorModel->newQuery()
                    ->whereIn('setor_id', $sectorsUnique)
                    ->where('rotina', 'observarAprovaAusencia')
                    ->get();

                if (!is_null($sectorsHasUser) && $sectorsHasUser->count() > 0) {
                    foreach ($sectorsHasUser as $sectorHasUser) {
                        $sectorModel = new Sector();
                        $sectorModel->setConnection($request->header('DB-Connection'));

                        $sector = $sectorModel->newQuery()->findOrFail($sectorHasUser->setor_id);

                        if (!is_null($sector->setor_filho)) {
                            $sectorsToRemove = explode(',', $sector->setor_filho);

                            $sectorsDiff = array_diff($sectorsUnique, $sectorsToRemove);

                            if (count($sectorsDiff) > 0) {
                                array_push($sectorsToSearch, $sectorsDiff);
                            } else {
                                array_push($sectorsToSearch, $sectorsUnique);
                            }
                        } else {
                            array_push($sectorsToSearch, $sectorsUnique);
                        }
                    }
                }
            }

            $sectorsToSearch = call_user_func_array('array_merge', $sectorsToSearch);

            $absenceModel = new Absence();
            $absenceModel->setConnection($request->header('DB-Connection'));

            $query = $absenceModel->newQuery();

            if ($request->has("search_key") != null && $request->has("search_value") != null) {
                if (str_contains($request->query("search_value"), ',')) {
                    $array = explode(',', $request->query("search_value"));

                    $query->orWhereIn($request->query("search_key"), $array);

                } else {
                    $query->orWhere($request->query("search_key"), 'LIKE', '%' . $request->query("search_value") . '%');
                }
            }

            $query->whereNull('log_excluido_data')->whereNull('log_excluido_usuario_id');

            $query->where('usuario_id', '!=', $user->id);
            $query->whereIn('usuario_setor_id', $sectorsToSearch);
            $query->whereBetween('log_cadastro_data', [$initialDate->format('Y-m-d'), $lastDate->format('Y-m-d')]);
            $query->orderBy('id', 'DESC');

            /** @var LengthAwarePaginator $paginator */
            if ($request->has('limit')) {
                $paginator = $query->paginate($request->input('limit'))->appends($request->query());
            } else {
                $total = $query->count();
                $paginator = $query->paginate($total);
            }

            $absences = $paginator->getCollection();

            return new AbsenceCollectionResponse($absences, $paginator);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AbsenceCreateRequest $request
     *
     * @return AbsenceResponse|JsonResponse
     */
    public function store(AbsenceCreateRequest $request)
    {
        if (!is_null($request->get('id'))) {
            $absence = $this->putAbsence($request);
        } else {
            $absence = $this->postAbsence($request);
        }

        return new AbsenceResponse($absence);
    }

    public function postAbsence(Request $request)
    {
        $userModel = new User();
        $userModel->setConnection($request->header('DB-Connection'));

        $user = $userModel->newQuery()->where('app_token_notificacao', 'LIKE', $request->header('FCM-Token'))->first();

        $interaction = [];

        $interaction['log_cadastro_data'] = date('Y/m/d H:m:s', time());
        $interaction['log_cadastro_usuario_id'] = $user->id;

        $observeData = $request->except(['uuid', 'log_cadastro_data', 'log_cadastro_usuario_id']);

        $data = array_merge($observeData, $interaction);

        $absenceModel = new Absence();
        $absenceModel->setConnection($request->header('DB-Connection'));

        $absence = $absenceModel->newQuery()->create($data);

        $userSectorModel = new UserSector();
        $userSectorModel->setConnection($request->header('DB-Connection'));

        $userSectors = $userSectorModel->newQuery()
            ->where('setor_id', '<=', $absence->usuario_setor_id)
            ->where('rotina', 'observarAprovaAusencia')
            ->get();

        if ($userSectors->count() > 0) {
            $sectorsPermitted = [];

            foreach ($userSectors as $userSector) {
                array_push($sectorsPermitted, $userSector->setor_id);
            }

            $sectorsSearchMultidimensional = [];

            foreach ($sectorsPermitted as $sectorPermitted) {
                $sectorModel = new Sector();
                $sectorModel->setConnection($request->header('DB-Connection'));

                $sector = $sectorModel->newQuery()->findOrFail($sectorPermitted);

                if (!is_null($sector->setor_pai)) {
                    $sectorPermittedChildren = explode(',', $sector->setor_pai);

                    array_push($sectorsSearchMultidimensional, $sectorPermittedChildren);
                } else {
                    array_push($sectorsSearchMultidimensional, [$sector->id]);
                }
            }

            $sectorsSearch = call_user_func_array('array_merge', $sectorsSearchMultidimensional);
            rsort($sectorsSearch);

            $sectorsUnique = array_unique($sectorsSearch);

            $initialDate = Carbon::parse($absence->data_inicial)->format('d/m/Y');
            $finalDate = Carbon::parse($absence->data_final)->format('d/m/Y');

            $userSectorModel = new UserSector();
            $userSectorModel->setConnection($request->header('DB-Connection'));

            $usersSector = $userSectorModel->newQuery()->whereIn('setor_id', $sectorsUnique)->get();

            if ($usersSector->count() > 0) {
                $registrationsId = [];

                foreach ($usersSector as $userSector) {
                    if (($userSector->user->id != $user->id) && ($userSector->user->app_token_notificacao != null)) {
                        array_push($registrationsId, $userSector->user->app_token_notificacao);
                    }
                }

                $this->curl->setHeader("Authorization", "key=" . env("FCM_TOKEN_MESSAGING"));
                $this->curl->setHeader("Content-Type", "application/json");
                $this->curl->post("https://fcm.googleapis.com/fcm/send", [
                    'notification' => [
                        'priority' => 'high',
                        'title' => 'Nova solicitação de ausência pendente.',
                        'body' => $absence->user->nome . ' solicitou uma ausência para o período de ' . $initialDate . ' à ' . $finalDate . '.',
                    ],
                    'data' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'sound' => 'default',
                        'status' => 'done',
                        'title' => 'Nova solicitação de ausência pendente.',
                        'body' => $absence->user->nome . ' solicitou uma ausência para o período de ' . $initialDate . ' à ' . $finalDate . '.',
                        'to_page' => '/absences/' . $absence->id
                    ],
                    'registration_ids' => $registrationsId
                ]);
            }
        }

        return $absence;
    }

    public function putAbsence(Request $request)
    {
        $observeData = $request->except(['uuid', 'log_cadastro_data', 'log_cadastro_usuario_id']);

        $absenceModel = new Absence();
        $absenceModel->setConnection($request->header('DB-Connection'));

        $absence = $absenceModel->newQuery()->findOrFail($request->get('id'));
        $absence->update($observeData);

        $initialDate = Carbon::parse($absence->data_inicial)->format('d/m/Y');
        $finalDate = Carbon::parse($absence->data_final)->format('d/m/Y');

        if ($absence->situacao == "Aprovada") {
            if ($absence->user->app_token_notificacao != null) {
                $this->curl->setHeader("Authorization", "key=" . env("FCM_TOKEN_MESSAGING"));
                $this->curl->setHeader("Content-Type", "application/json");
                $this->curl->post("https://fcm.googleapis.com/fcm/send", [
                    'notification' => [
                        'priority' => 'high',
                        'title' => 'Sua solicitação de ausência foi aprovada!',
                        'body' => 'Sua ausência para o período de ' . $initialDate . ' à ' . $finalDate . ' foi aprovada por: ' . $absence->approvedBy->nome,
                    ],
                    'data' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'sound' => 'default',
                        'status' => 'done',
                        'title' => 'Sua solicitação de ausência foi aprovada!',
                        'body' => 'Sua ausência para o período de ' . $initialDate . ' à ' . $finalDate . ' foi aprovada por: ' . $absence->approvedBy->nome,
                        'to_page' => '/absences/' . $absence->id
                    ],
                    'to' => $absence->user->app_token_notificacao
                ]);
            }
        } else if ($absence->situacao == "Rejeitada") {
            if ($absence->user->app_token_notificacao != null) {
                $this->curl->setHeader("Authorization", "key=" . env("FCM_TOKEN_MESSAGING"));
                $this->curl->setHeader("Content-Type", "application/json");
                $this->curl->post("https://fcm.googleapis.com/fcm/send", [
                    'notification' => [
                        'priority' => 'high',
                        'title' => 'Sua solicitação de ausência foi rejeitada!',
                        'body' => 'Sua ausência para o período de ' . $initialDate . ' à ' . $finalDate . ' foi rejeitada por: ' . $absence->approvedBy->nome,
                    ],
                    'data' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'sound' => 'default',
                        'status' => 'done',
                        'title' => 'Sua solicitação de ausência foi rejeitada!',
                        'body' => 'Sua ausência para o período de ' . $initialDate . ' à ' . $finalDate . ' foi rejeitada por: ' . $absence->approvedBy->nome,
                        'to_page' => '/absences/' . $absence->id
                    ],
                    'to' => $absence->user->app_token_notificacao
                ]);
            }
        }

        return $absence;
    }

    /**
     * Display the specified resource.
     *
     * @param Absence $sector
     *
     * @return AbsenceResponse|JsonResponse
     */
    public function show(Absence $sector)
    {
        return new AbsenceResponse($sector);
    }

    /**
     * @param Request $request
     *
     * @return AbsenceCollectionResponse
     */
    public function absencesPendingApproval(Request $request)
    {
        $userModel = new User();
        $userModel->setConnection($request->header('DB-Connection'));

        $user = $userModel->newQuery()->where('app_token_notificacao', 'LIKE', $request->header('FCM-Token'))->first();

        $levelSettingModel = new LevelSetting();
        $levelSettingModel->setConnection($request->header('DB-Connection'));

        $levelSetting = $levelSettingModel->newQuery()->findOrFail($user->nivel_id);

        $currentDate = Carbon::now();

        $initialDate = Carbon::parse($currentDate)->startOfMonth();
        $lastDate = Carbon::parse($currentDate);

        $numberOfDaysInMonth = Carbon::parse($initialDate)->daysInMonth;

        $lastDate->day($numberOfDaysInMonth);

        if ($levelSetting->meta == 'Quinzenal') {
            $currentDay = $currentDate->day;

            if ($currentDay > 15) {
                $initialDate->day(16);
            } else {
                $lastDate->day(15);
            }
        }

        $userSectorModel = new UserSector();
        $userSectorModel->setConnection($request->header('DB-Connection'));

        $userSectors = $userSectorModel->newQuery()
            ->where('usuario_id', $user->id)
            ->where('rotina', 'observarAprovaAusencia')
            ->get();

        if (!is_null($userSectors) && $userSectors->count() > 0) {
            $sectorsSearchMultidimensional = [];
            $sectorsToSearch = [];

            foreach ($userSectors as $userSector) {
                $sectorModel = new Sector();
                $sectorModel->setConnection($request->header('DB-Connection'));

                $sector = $sectorModel->newQuery()->findOrFail($userSector->setor_id);

                if (!is_null($sector->setor_filho)) {
                    $sectorPermittedChildren = explode(',', $sector->setor_filho);

                    array_push($sectorsSearchMultidimensional, $sectorPermittedChildren);
                } else {
                    array_push($sectorsSearchMultidimensional, [$sector->setor_pai_id]);
                }

                $sectorsSearch = call_user_func_array('array_merge', $sectorsSearchMultidimensional);
                sort($sectorsSearch);

                $sectorsUnique = array_unique($sectorsSearch);

                $userSectorModel = new UserSector();
                $userSectorModel->setConnection($request->header('DB-Connection'));

                $sectorsHasUser = $userSectorModel->newQuery()
                    ->whereIn('setor_id', $sectorsUnique)
                    ->where('rotina', 'observarAprovaAusencia')
                    ->get();

                if (!is_null($sectorsHasUser) && $sectorsHasUser->count() > 0) {
                    foreach ($sectorsHasUser as $sectorHasUser) {
                        $sectorModel = new Sector();
                        $sectorModel->setConnection($request->header('DB-Connection'));

                        $sector = $sectorModel->newQuery()->findOrFail($sectorHasUser->setor_id);

                        if (!is_null($sector->setor_filho)) {
                            $sectorsToRemove = explode(',', $sector->setor_filho);

                            $sectorsDiff = array_diff($sectorsUnique, $sectorsToRemove);

                            if (count($sectorsDiff) > 0) {
                                array_push($sectorsToSearch, $sectorsDiff);
                            } else {
                                array_push($sectorsToSearch, $sectorsUnique);
                            }
                        } else {
                            array_push($sectorsToSearch, $sectorsUnique);
                        }
                    }

                    $sectorsToSearch = call_user_func_array('array_merge', $sectorsToSearch);

                    $absenceModel = new Absence();
                    $absenceModel->setConnection($request->header('DB-Connection'));

                    $query = $absenceModel->newQuery();

                    if ($request->has("search_key") != null && $request->has("search_value") != null) {
                        if (str_contains($request->query("search_value"), ',')) {
                            $array = explode(',', $request->query("search_value"));

                            $query->orWhereIn($request->query("search_key"), $array);

                        } else {
                            $query->orWhere($request->query("search_key"), 'LIKE', '%' . $request->query("search_value") . '%');
                        }
                    }

                    $query->whereNull('log_excluido_data')->whereNull('log_excluido_usuario_id');

                    $query->where('usuario_id', '!=', $user->id);
                    $query->whereIn('usuario_setor_id', $sectorsToSearch);
                    $query->whereMonth('data_inicial', $initialDate->format('m'));
                    $query->whereYear('data_inicial', $initialDate->format('Y'));
                    $query->where('situacao', 'Em aprovação');

                    /** @var LengthAwarePaginator $paginator */
                    if ($request->has('limit')) {
                        $paginator = $query->paginate($request->input('limit'))->appends($request->query());
                    } else {
                        $total = $query->count();
                        $paginator = $query->paginate($total);
                    }

                    $absences = $paginator->getCollection();

                    return new AbsenceCollectionResponse($absences, $paginator);
                }
            }
        }
    }

    public function absencesSolicitedApproval(Request $request)
    {
        $userModel = new User();
        $userModel->setConnection($request->header('DB-Connection'));

        $user = $userModel->newQuery()->where('app_token_notificacao', 'LIKE', $request->header('FCM-Token'))->first();

        $currentDate = Carbon::now();

        $initialDate = Carbon::parse($currentDate)->startOfMonth();

        $absenceModel = new Absence();
        $absenceModel->setConnection($request->header('DB-Connection'));

        $query = $absenceModel->newQuery();

        $query->whereNull('log_excluido_data')->whereNull('log_excluido_usuario_id');

        $query->where('usuario_id', $user->id);
        $query->whereMonth('data_inicial', $initialDate->format('m'));
        $query->whereYear('data_inicial', $initialDate->format('Y'));
        $query->orderBy('id', 'DESC');

        /** @var LengthAwarePaginator $paginator */
        if ($request->has('limit')) {
            $paginator = $query->paginate($request->input('limit'))->appends($request->query());
        } else {
            $total = $query->count();
            $paginator = $query->paginate($total);
        }

        $absences = $paginator->getCollection();

        return new AbsenceCollectionResponse($absences, $paginator);
    }
}
