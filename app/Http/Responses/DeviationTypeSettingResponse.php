<?php

namespace App\Http\Responses;

use App\Http\Models\DeviationTypeSetting;
use App\Http\Responses\Transformers\DeviationTypeSettingTransformer;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class DeviationTypeSettingResponse extends Response
{
    /**
     * DeviationTypeSettingResponse constructor.
     *
     * @param DeviationTypeSetting $deviationTypeSetting
     * @param int $status
     */
    public function __construct(DeviationTypeSetting $deviationTypeSetting, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($deviationTypeSetting, new DeviationTypeSettingTransformer(), 'deviationTypeSetting'))->toArray(),
            $status
        );
    }
}
