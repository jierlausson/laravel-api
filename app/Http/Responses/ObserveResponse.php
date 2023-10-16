<?php

namespace App\Http\Responses;

use App\Http\Models\Observe;
use App\Http\Responses\Transformers\ObserveTransformer;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class ObserveResponse extends Response
{
    /**
     * ObserveResponse constructor.
     *
     * @param Observe $user
     * @param int $status
     */
    public function __construct(Observe $user, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($user, new ObserveTransformer(), 'observe'))->toArray(),
            $status
        );
    }
}
