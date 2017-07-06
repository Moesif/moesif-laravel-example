<?php
namespace App\Http\Middleware;

use Closure;

use DateTime;
use DateTimeZone;

use Illuminate\Support\Facades\Log;
// use App\Http\Middleware\MoesifSenderThread;
use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\Moesif\MoesifApi;

require_once(dirname(__FILE__) . "/Moesif/MoesifApi.php");

class MoesifLaravel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // do action before response


        //calling middleware from controller.
        //$this->middleware('moesif:userId,sessionToken');

        // this gets all headers in array key value pairs.
        // $request->headers->all()
        $t = LARAVEL_START;
        $micro = sprintf("%06d",($t - floor($t)) * 1000000);
        $startDateTime = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        $startDateTime->setTimezone(new DateTimeZone("UTC"));

        Log::info('start time: '. $startDateTime->format('Y-m-d\TH:i:s.uP'));

        $response = $next($request);

        $applicationId = config('moesif.applicationId');
        $apiVersion = config('moesif.apiVersion');
        $maskRequestHeaders = config('moesif.maskRequestHeaders');
        $maskRequestBody = config('moesif.maskRequestBody');
        $maskResponseHeaders = config('moesif.maskResponseHeaders');
        $maskResponseBody = config('moesif.maskResponseBody');
        $identifyUserId = config('moesif.identifyUserId');
        $identifySessionId = config('moesif.identifySessionId');
        $shouldBeNull = config('moesif.notexist');

        // if (is_null($shouldBeNull)) {
        //     Log::info('yeah, should be null is true.');
        // }

        $requestData = [
            'time' => $startDateTime->format('Y-m-d\TH:i:s.uP'),
            'verb' => $request->method(),
            'uri' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'api_version' => $apiVersion
        ];



        $requestHeaders = [];
        foreach($request->headers->keys() as $key) {
            $requestHeaders[$key] = (string) $request->headers->get($key);
        }
        // can't use headers->all() because it is an array of arrays.
        // $request->headers->all();
        if(!is_null($maskRequestHeaders)) {
            $requestData['headers'] = $maskRequestHeaders($requestHeaders);
        } else {
            $requestData['headers'] = $requestHeaders;
        }

        if($request->isJson()) {
            // Log::info('request body is json');
            $requestBody = json_decode($request->getContent(), true);
            // Log::info('' . $requestBody);
            if (!is_null($maskRequestBody)) {
                $requestData['body'] = $maskRequestBody($requestBody);
            } else {
                $requestData['body'] = $requestBody;
            }
        } else {
            //Log::info('request body is not json');
        }

        $endTime = microTime(true);
        $micro = sprintf("%06d",($endTime - floor($endTime)) * 1000000);
        $endDateTime = new DateTime( date('Y-m-d H:i:s.'.$micro, $endTime) );
        $endDateTime->setTimezone(new DateTimeZone("UTC"));

        $responseData = [
            'time' => $endDateTime->format('Y-m-d\TH:i:s.uP'),
            'status' => $response->status()
        ];

        $jsonBody = json_decode($response->content(), true);

        if(!is_null($jsonBody)) {
            if (!is_null($maskResponseBody)) {
                $responseData['body'] = $maskResponseBody($jsonBody);
            } else {
                $responseData['body'] = $jsonBody;
            }
        } else {
            // that means that json can't be parsed.
            // so send the entire string for error analysis.
            $responseData['body'] = $response->content();
        }

        $responseHeaders = [];
        foreach($response->headers->keys() as $key) {
            $responseHeaders[$key] = (string) $response->headers->get($key);
        }

        if(!is_null($maskResponseHeaders)) {
            $responseData['headers'] = $maskResponseHeaders($responseHeaders);
        } else {
            $responseData['headers'] = $responseHeaders;
        }

        $data = [
            'request' => $requestData,
            'response' => $responseData
        ];

        $user = $request->user();

        if (!is_null($identifyUserId)) {
            $data['user_id'] = $identifyUserId($request, $response);
        } else if (!is_null($user)) {
            $data['user_id'] = $user['id'];
        }

        if (!is_null($identifySessionId)) {
            $data['session_token'] = $identifySessionId($request, $response);
        } else if ($request->hasSession()) {
            $data['session_token'] = $request->session()->getId();
        } else {
            $data['session_token'] = 'none';
        }
        // Log::info('user=' . $user);
        //
        // Log::info('inside MoesifLaravel middleware start request');
        // Log::info('verb=' . $request->method());
        // Log::info('url=' . $request->fullUrl());
        // Log::info('ip=' . $request->ip());
        // Log::info('header=' . implode(', ', $request->headers->keys()));
        // Log::info('user from request=' . $request->user());
        // $user = Auth::user();
        // Log::info('userId=' . $user['id']);

        // headerbag function all() returns the array dict of headers.
        // Log::info('res_status=' . $response->status());
        // $configTestVal = config('moesif.testval');
        // $configTestFunc = config('moesif.testfunc');


        // Log::info('got config val=' . $configTestVal);
        // Log::info('shouldn not have anything=' . config('moesif.notexistval'));
        // Log::info('res_headers=' . implode(', ', $response->headers->keys()));
        // Log::info('res_body=' . $response->content());
        // Log::info('got config func=' . $configTestFunc(10) );

        $moesifApi = MoesifApi::getInstance($applicationId, ['fork'=>true, 'debug'=>true]);

        $moesifApi->track($data);

        return $response;
    }
}
