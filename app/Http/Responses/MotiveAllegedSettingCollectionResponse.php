<?php

namespace App\Http\Responses;

use App\Http\Models\MotiveAllegedSetting;
use App\Http\Responses\Transformers\MotiveAllegedSettingTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class MotiveAllegedSettingCollectionResponse extends Response
{
    /**
     * @param MotiveAllegedSetting[]|\Illuminate\Support\Collection $motiveAllegedSettings
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($motiveAllegedSettings, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($motiveAllegedSettings, new MotiveAllegedSettingTransformer(), 'motiveAllegedSetting');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
