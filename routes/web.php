<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/users'], function () use ($router) {
    $router->get('me', 'UserController@me');
    $router->post('login', 'UserController@login');
    $router->get('logout', 'UserController@logout');
    $router->post('create', 'UserController@create');
    $router->put('update', 'UserController@update');
    $router->put('updatePassword', 'UserController@updatePassword');
});
