<?php

namespace App\Http\Responses;

use App\Http\Models\Absence;
use App\Http\Responses\Transformers\AbsenceTransformer;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class AbsenceResponse extends Response
{
    /**
     * AbsenceResponse constructor.
     *
     * @param Absence $absence
     * @param int $status
     */
    public function __construct(Absence $absence, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($absence, new AbsenceTransformer(), 'absence'))->toArray(),
            $status
        );
    }
}
