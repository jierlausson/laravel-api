<?php

namespace App\Http\Controllers;

use App\Http\Models\Sector;
use App\Http\Models\User;
use App\Http\Models\UserSector;
use App\Http\Responses\SectorCollectionResponse;
use App\Http\Responses\SectorResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return SectorCollectionResponse|JsonResponse
     */
    public function index(Request $request)
    {
        $sectorModel = new Sector();
        $sectorModel->setConnection($request->header('DB-Connection'));

        $query = $sectorModel->newQuery();

        if ($request->has("search_key") != null && $request->has("search_value") != null) {
            if (str_contains($request->query("search_value"), ',')) {
                $array = explode(',', $request->query("search_value"));

                $query->orWhereIn($request->query("search_key"), $array);

            } else {
                $query->orWhere($request->query("search_key"), 'LIKE', '%' . $request->query("search_value") . '%');
            }
        }

        $query->whereNull('log_excluido_data')->whereNull('log_excluido_usuario_id');

        $userSectorModel = new UserSector();
        $userSectorModel->setConnection($request->header('DB-Connection'));

        $userModel = new User();
        $userModel->setConnection($request->header('DB-Connection'));

        $user = $userModel->newQuery()->where('app_token_notificacao', 'LIKE', $request->header('FCM-Token'))->first();

        $userSectorsCount = $userSectorModel->newQuery()
            ->where('usuario_id', $user->id)
            ->where('rotina', 'observarLancamento')
            ->count();

        if ($userSectorsCount > 0) {
            $sectorsPermitted = [];

            $userSectorModel = new UserSector();
            $userSectorModel->setConnection($request->header('DB-Connection'));

            $userSectors = $userSectorModel->newQuery()
                ->where('usuario_id', $user->id)
                ->where('rotina', 'observarLancamento')
                ->get();

            foreach ($userSectors as $userSector) {
                array_push($sectorsPermitted, $userSector->setor_id);
            }

            $sectorsSearchMultidimensional = [];

            foreach ($sectorsPermitted as $sectorPermitted) {
                $sectorModel = new Sector();
                $sectorModel->setConnection($request->header('DB-Connection'));

                $sector = $sectorModel->newQuery()->findOrFail($sectorPermitted);
                $sectorPermittedChildren = explode(',', $sector->setor_filho);

                array_push($sectorsSearchMultidimensional, $sectorPermittedChildren);
            }

            $sectorsSearch = call_user_func_array('array_merge', $sectorsSearchMultidimensional);

            $query->whereIn('id', $sectorsSearch);
        }

        /** @var LengthAwarePaginator $paginator */
        if ($request->has('limit')) {
            $paginator = $query->paginate($request->input('limit'))->appends($request->query());
        } else {
            $total = $query->count();
            $paginator = $query->paginate($total);
        }

        $sectors = $paginator->getCollection();

        return new SectorCollectionResponse($sectors, $paginator);
    }

    /**
     * Display the specified resource.
     *
     * @param Sector $sector
     *
     * @return SectorResponse|JsonResponse
     */
    public function show(Sector $sector)
    {
        return new SectorResponse($sector);
    }
}
