<?php

namespace App\Http\Responses;

use App\Http\Models\User;
use App\Http\Responses\Transformers\UserTransformer;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;

class UserResponse extends Response
{
    /**
     * UserResponse constructor.
     *
     * @param User $user
     * @param int $status
     */
    public function __construct(User $user, $status = Response::HTTP_OK)
    {
        $fractal = (new Manager())->setSerializer(new JsonApiSerializer());

        return parent::__construct(
            $fractal->createData(new Item($user, new UserTransformer(), 'user'))->toArray(),
            $status
        );
    }
}
