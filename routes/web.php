<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });


$router->post('auth/login', [
    'uses' => "AuhtController@authenticate",
]);


$router->get('/', function () use ($router) {
    return response()->json([
        'server api' => 'API PAJAK DAERAH'
    ], 200);
});

//route   
$router->group(['middleware' => 'authlogin'], function () use ($router) {
    //authentitkasi terlebih dahulu 
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('/', 'AuthController@index');
    });

    $router->group(['prefix' => 'userlogin'], function () use ($router) {
        $router->post('', 'UserController@index');
        $router->get('show/{id}', 'UserController@show');
        $router->patch('update/{id}', 'UserController@update');
        $router->put('store', 'UserController@store');
        $router->delete('delete', 'UserController@destroy');
    });

    // income of area  
    // get income tax data instead of avail be to get only
    $router->group(['prefix' => 'pad'], function () use ($router) {
        $router->get('today', 'PendapatanController@pad_today');

        // $router->get('show/{id}', 'UserController@show');
        // $router->patch('update/{id}', 'UserController@update');
        // $router->put('store', 'UserController@store');
        // $router->delete('delete', 'UserController@destroy');

    });
    //data target rincian


    //authenticate
});
