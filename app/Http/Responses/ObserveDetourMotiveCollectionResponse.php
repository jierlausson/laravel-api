<?php

namespace App\Http\Responses;

use App\Http\Models\ObserveDetourMotive;
use App\Http\Responses\Transformers\ObserveDetourMotiveTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class ObserveDetourMotiveCollectionResponse extends Response
{
    /**
     * @param ObserveDetourMotive[]|\Illuminate\Support\Collection $observeDetourMotives
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($observeDetourMotives, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($observeDetourMotives, new ObserveDetourMotiveTransformer(), 'observeDetourMotive');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
