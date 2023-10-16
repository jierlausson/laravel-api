<?php

namespace App\Http\Controllers;

use App\Http\Models\LevelSetting;
use App\Http\Models\Observe;
use App\Http\Models\ObserveDetourMotive;
use App\Http\Models\User;
use App\Http\Requests\Observe\ObserveCreateRequest;
use App\Http\Responses\ObserveCollectionResponse;
use App\Http\Responses\ObserveDetourMotiveCollectionResponse;
use App\Http\Responses\ObserveResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ObserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return ObserveCollectionResponse|JsonResponse
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

        $observeModel = new Observe();
        $observeModel->setConnection($request->header('DB-Connection'));

        $query = $observeModel->newQuery();

        if ($request->has("search_key") != null && $request->has("search_value") != null) {
            if (str_contains($request->query("search_value"), ',')) {
                $array = explode(',', $request->query("search_value"));

                $query->orWhereIn($request->query("search_key"), $array);

            } else {
                $query->orWhere($request->query("search_key"), 'LIKE', '%' . $request->query("search_value") . '%');
            }
        }

        $query->whereNull('log_excluido_data')->whereNull('log_excluido_usuario_id');

        $query->where('usuario_id', $user->id);
        $query->whereBetween('log_cadastro_data', [$initialDate->format('Y-m-d H:m:s'), $lastDate->format('Y-m-d H:m:s')]);
        $query->orderBy('id', 'DESC');

        /** @var LengthAwarePaginator $paginator */
        if ($request->has('limit')) {
            $paginator = $query->paginate($request->input('limit'))->appends($request->query());
        } else {
            $total = $query->count();
            $paginator = $query->paginate($total);
        }

        $observes = $paginator->getCollection();

        return new ObserveCollectionResponse($observes, $paginator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ObserveCreateRequest $request
     *
     * @return ObserveResponse|JsonResponse
     */
    public function store(ObserveCreateRequest $request)
    {
        $interaction = [];

        date_default_timezone_set('America/Sao_Paulo');
        $interaction['log_sincronizado_data'] = date('Y/m/d H:m:s', time());

        $observeData = $request->all();

        $numberImplode = '';

        $observeModel = new Observe();
        $observeModel->setConnection($request->header('DB-Connection'));

        if ($observeModel->newQuery()->count() > 0) {
            $observes = $observeModel->newQuery()->get();
            $lastObserve = $observes->last();

            $number = $lastObserve->numero;
            $numberExplode = explode('/', $number);

            if ($numberExplode[1] == date('Y')) {
                $numberImplode = $numberExplode[0] + 1 . '/' . date('Y');
            } else {
                $numberImplode = '1' . '/' . date('Y');
            }
        } else {
            $numberImplode = '1' . '/' . date('Y');
        }

        $observeData['numero'] = $numberImplode;

        $data = array_merge($observeData, $interaction);

        $observeModel = new Observe();
        $observeModel->setConnection($request->header('DB-Connection'));

        $observe = $observeModel->newQuery()->create($data);

        if ($request->has('desvio_motivo') && $request->get('desvio_motivo') != null) {
            foreach ($request->get('desvio_motivo') as $detourMotive) {
                $observeDetourMotiveModel = new ObserveDetourMotive();
                $observeDetourMotiveModel->setConnection($request->header('DB-Connection'));

                $observeDetourMotiveModel->newQuery()->create([
                    'observar_id' => $observe->id,
                    'tipo_desvio_id' => $detourMotive['tipoDesvioId'],
                    'motivo_alegado_id' => $detourMotive['motivoAlegadoId'],
                ]);
            }
        }

        return new ObserveResponse($observe);
    }

    /**
     * Display the specified resource.
     *
     * @param Observe $observe
     *
     * @return ObserveResponse|JsonResponse
     */
    public function show(Observe $observe)
    {
        return new ObserveResponse($observe);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $observeId
     *
     * @return ObserveDetourMotiveCollectionResponse|JsonResponse
     */
    public function observeDeviationsMotive(Request $request, int $observeId)
    {
        $observeDetourMotiveModel = new ObserveDetourMotive();
        $observeDetourMotiveModel->setConnection($request->header('DB-Connection'));

        $query = $observeDetourMotiveModel->newQuery();

        $query->where('observar_id', $observeId);

        /** @var LengthAwarePaginator $paginator */
        $total = $query->count();
        $paginator = $query->paginate($total);

        $observeDeviationsMotive = $paginator->getCollection();

        return new ObserveDetourMotiveCollectionResponse($observeDeviationsMotive, $paginator);
    }
}
