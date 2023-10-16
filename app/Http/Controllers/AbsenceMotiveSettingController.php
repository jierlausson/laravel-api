<?php

namespace App\Http\Controllers;

use App\Http\Models\AbsenceMotiveSetting;
use App\Http\Responses\AbsenceMotiveSettingCollectionResponse;
use App\Http\Responses\AbsenceMotiveSettingResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AbsenceMotiveSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return AbsenceMotiveSettingCollectionResponse|JsonResponse
     */
    public function index(Request $request)
    {
        $absenceMotiveSettingModel = new AbsenceMotiveSetting();
        $absenceMotiveSettingModel->setConnection($request->header('DB-Connection'));

        $query = $absenceMotiveSettingModel->newQuery();

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

        $motiveAllegedSettings = $paginator->getCollection();

        return new AbsenceMotiveSettingCollectionResponse($motiveAllegedSettings, $paginator);
    }

    /**
     * Display the specified resource.
     *
     * @param AbsenceMotiveSetting $absenceMotiveSettings
     *
     * @return AbsenceMotiveSettingResponse
     */
    public function show(AbsenceMotiveSetting $absenceMotiveSettings)
    {
        return new AbsenceMotiveSettingResponse($absenceMotiveSettings);
    }
}
