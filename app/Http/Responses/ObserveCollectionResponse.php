<?php

namespace App\Http\Responses;

use App\Http\Models\User;
use App\Http\Responses\Transformers\ObserveTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class ObserveCollectionResponse extends Response
{
    /**
     * @param User[]|\Illuminate\Support\Collection $users
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($users, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($users, new ObserveTransformer(), 'observe');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
