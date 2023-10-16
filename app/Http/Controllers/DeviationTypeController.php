<?php

namespace App\Http\Controllers;

use App\Http\Models\DeviationTypeSetting;
use App\Http\Responses\DeviationTypeSettingCollectionResponse;
use App\Http\Responses\DeviationTypeSettingResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DeviationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return DeviationTypeSettingCollectionResponse|JsonResponse
     */
    public function index(Request $request)
    {
        $deviationTypeSettingModel = new DeviationTypeSetting();
        $deviationTypeSettingModel->setConnection($request->header('DB-Connection'));

        $query = $deviationTypeSettingModel->newQuery();

        if ($request->has("search_key") != null && $request->has("search_value") != null) {
            if (str_contains($request->query("search_value"), ',')) {
                $array = explode(',', $request->query("search_value"));

                $query->orWhereIn($request->query("search_key"), $array);

            } else {
                $query->orWhere($request->query("search_key"), 'LIKE', '%' . $request->query("search_value") . '%');
            }
        }

        $query->whereNull('log_excluido_data')->whereNull('log_excluido_usuario_id');


        /** @var LengthAwarePaginator $paginator */
        if ($request->has('limit')) {
            $paginator = $query->paginate($request->input('limit'))->appends($request->query());
        } else {
            $total = $query->count();
            $paginator = $query->paginate($total);
        }

        $deviationTypeSettings = $paginator->getCollection();

        $deviationsDisabled = $this->deviationsDisabled($request);

        foreach ($deviationTypeSettings as &$item) {
            if (in_array($item->id, $deviationsDisabled)) {
                $item->desabilitado = true;
            } else {
                $item->desabilitado = false;
            }
        }

        return new DeviationTypeSettingCollectionResponse($deviationTypeSettings, $paginator);
    }

    public function deviationsDisabled(Request $request): array
    {
        $deviationTypeSettingModel = new DeviationTypeSetting();
        $deviationTypeSettingModel->setConnection($request->header('DB-Connection'));

        $query = $deviationTypeSettingModel->newQuery()->whereNull('log_excluido_data')->whereNull('log_excluido_usuario_id');

        $data = [];

        foreach ($query->get() as $tmp) {
            if (strstr($tmp->tipo_desvio_filho, ',')) {
                array_push($data, $tmp->id);
            }
        }

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param DeviationTypeSetting $deviationTypeSetting
     *
     * @return DeviationTypeSettingResponse|JsonResponse
     */
    public function show(DeviationTypeSetting $deviationTypeSetting)
    {
        return new DeviationTypeSettingResponse($deviationTypeSetting);
    }
}
