<?php

namespace App\Http\Responses;

use App\Http\Models\AbsenceMotiveSetting;
use App\Http\Responses\Transformers\AbsenceMotiveSettingTransformer;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class AbsenceMotiveSettingResponse extends Response
{
    /**
     * AbsenceMotiveSettingResponse constructor.
     *
     * @param AbsenceMotiveSetting $absence
     * @param int $status
     */
    public function __construct(AbsenceMotiveSetting $absence, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($absence, new AbsenceMotiveSettingTransformer(), 'absenceMotiveSetting'))->toArray(),
            $status
        );
    }
}
