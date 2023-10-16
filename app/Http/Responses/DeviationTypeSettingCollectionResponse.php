<?php

namespace App\Http\Responses;

use App\Http\Models\DeviationTypeSetting;
use App\Http\Responses\Transformers\DeviationTypeSettingTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class DeviationTypeSettingCollectionResponse extends Response
{
    /**
     * @param DeviationTypeSetting[]|\Illuminate\Support\Collection $deviationTypeSettings
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($deviationTypeSettings, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($deviationTypeSettings, new DeviationTypeSettingTransformer(), 'deviationTypeSetting');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
