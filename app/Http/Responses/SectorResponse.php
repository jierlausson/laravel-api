<?php

namespace App\Http\Responses;

use App\Http\Models\Sector;
use App\Http\Responses\Transformers\SectorTransformer;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class SectorResponse extends Response
{
    /**
     * SectorResponse constructor.
     *
     * @param Sector $sector
     * @param int $status
     */
    public function __construct(Sector $sector, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($sector, new SectorTransformer(), 'sector'))->toArray(),
            $status
        );
    }
}
