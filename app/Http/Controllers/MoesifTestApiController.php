<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests;

class MoesifTestApiController extends Controller
{
    //
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($v)
    {
        return new JsonResponse([
            "myname" => "xing",
            "state" => "dude",
            "value" => $v
        ]);
    }

    public function table()
    {
        return new JsonResponse([
            "myname" => "xing",
            "state" => "dude"
        ]);
    }
}
