<?php

namespace App\Http\Controllers;

use Curl\Curl;

class CronjobController extends Controller
{
    /**
     * @var Curl $curl
     */
    private Curl $curl;

    /**
     * CronjobController constructor.
     *
     * @param Curl $curl
     */
    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }
}
