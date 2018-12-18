<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Log;

use App\Http\Requests;
use Moesif\Sender\MoesifApi;

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
        // $moesifApi = MoesifApi::getInstance('eyJhcHAiOiIyMzc6NzkiLCJ2ZXIiOiIyLjAiLCJvcmciOiI2Mjg6NTMiLCJpYXQiOjE1Mzk4MjA4MDB9.g9qvm5y80mHNtqh5KkG4f6YTErP59-8JHotipsusNuM',  ['fork'=>true, 'debug'=>true]);

        Log::info('[Moesif] : obtainting $moesifAPi ');

        $moesifApi = MoesifApi::getInstance('your application id',  ['fork'=>true, 'debug'=>true]);


        $moesifApi->updateUser([
          'user_id' => 'updateuser_test1',
          'metadata' => [
            'name' => 'xing',
            'email' => 'xing@updateusertest.com',
            'special_value' => $v
          ]
        ]);

        return new JsonResponse([
            "myname" => "xing",
            "state" => "dude",
            "value" => $v,
            "moesifApi_null" => is_null($moesifApi)
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

      $moesifApi = MoesifApi::getInstance('eyJhcHAiOiIyMzc6NzkiLCJ2ZXIiOiIyLjAiLCJvcmciOiI2Mjg6NTMiLCJpYXQiOjE1Mzk4MjA4MDB9.g9qvm5y80mHNtqh5KkG4f6YTErP59-8JHotipsusNuM',  ['fork'=>true, 'debug'=>true]);

      $moesifApi->updateUser([
        'user_id' => 'test_bigjson',
        'metadata' => [
          'name' => 'xing',
          'email' => 'xing@updateusertest.com',
          'special_value' => 'test big json'
        ]
      ]);
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
