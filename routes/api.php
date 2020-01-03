<?php

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/firstapi', function (Request $request) {
    return new JsonResponse([["foo" => 1, "bar" => [1, 2, 3]], ["type2" => 200], ["arrraytype3" => array()]]);
});

Route::get('/thirdapi', function (Request $request) {
    return new JsonResponse(["foo" => 1, "bar" => [1, 2, 3]]);
});

Route::get('/shouldskip', function (Request $request) {
    return new JsonResponse(["testingskip" => 1, "testingbar" => [1, 2, 3]]);
});

Route::post('/postapi', function (Request $request) {
  return new JsonResponse(["success" => 1]);
});

Route::get('/nonjson', function (Request $request) {
  return response('<html><body><h1>abcdefg</h1></body></html>')
      ->header('My-header-1', 'Header1 val');
});

Route::post('/users/{id}', "UsersController@updateUser");

Route::post('/companies/{id}', "CompaniesController@updateCompany");

Route::get('/test/{v}', 'MoesifTestApiController@index');

Route::get('/test/table/{v}', 'MoesifTestApiController@table');

Route::post('/test/table/{v}', 'MoesifTestApiController@table');

Route::get('/bigjson', 'MoesifTestApiController@bigjson');
