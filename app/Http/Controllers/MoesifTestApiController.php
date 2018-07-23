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

    public function bigjson()
    {
      // we only support body size up to 100Kb.
      // so 2000 entries works. but
      // 3000 entries and above probalby wont work
      $entry = [
        "myname" => "xing",
        "state" => "dude"
      ];
      $result = array_fill(0, 2000, $entry);

      return new JsonResponse($result);
    }
}
