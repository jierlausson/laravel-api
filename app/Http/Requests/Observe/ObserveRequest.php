<?php

namespace App\Http\Requests\Observe;

use App\Http\Requests\JsonRequest;


class ObserveRequest extends JsonRequest
{
    /**
     * Return item ID
     *
     * @return mixed
     */
    public function getID()
    {
        return $this->route('observe')->id;
    }
}
