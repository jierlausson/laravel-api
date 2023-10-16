<?php

namespace App\Http\Requests\Absence;

use App\Http\Requests\JsonRequest;


class AbsenceRequest extends JsonRequest
{
    /**
     * Return item ID
     *
     * @return mixed
     */
    public function getID()
    {
        return $this->route('absence')->id;
    }
}
