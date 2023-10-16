<?php

namespace App\Http\Responses;

use App\Http\Models\Absence;
use App\Http\Responses\Transformers\AbsenceTransformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;

class AbsenceCollectionResponse extends Response
{
    /**
     * @param Absence[]|\Illuminate\Support\Collection $absences
     * @param LengthAwarePaginator $paginator
     */
    public function __construct($absences, $paginator)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());
        $resource = new Collection($absences, new AbsenceTransformer(), 'absence');
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return parent::__construct($fractal->createData($resource)->toArray());
    }
}
