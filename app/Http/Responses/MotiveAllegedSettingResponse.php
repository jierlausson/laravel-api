<?php

namespace App\Http\Responses;

use App\Http\Models\MotiveAllegedSetting;
use App\Http\Responses\Transformers\MotiveAllegedSettingTransformer;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class MotiveAllegedSettingResponse extends Response
{
    /**
     * MotiveAllegedSettingResponse constructor.
     *
     * @param MotiveAllegedSetting $user
     * @param int $status
     */
    public function __construct(MotiveAllegedSetting $user, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($user, new MotiveAllegedSettingTransformer(), 'motiveAllegedSetting'))->toArray(),
            $status
        );
    }
}
