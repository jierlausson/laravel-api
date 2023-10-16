<?php

namespace App\Http\Responses;

use App\Http\Models\Sector;
use App\Http\Responses\Transformers\SectorTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class SectorCollectionResponse extends Response
{
    /**
     * @param Sector[]|\Illuminate\Support\Collection $sectors
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($sectors, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($sectors, new SectorTransformer(), 'sector');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
