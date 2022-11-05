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
    return 'Hello World!';
});

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use($router) {


    $router->get('authors', ['uses' => 'AuthorController@index']);

    $router->get('authors/{id}', ['uses' => 'AuthorController@show']);

    $router->post('authors', ['uses' => 'AuthorController@create']);

    $router->put('authors/{id}', ['uses' => 'AuthorController@update']);

    $router->delete('authors/{id}', ['uses' => 'AuthorController@destroy']);


});

$router->get('/users', ['uses' => 'UserController@index']);
$router->post('/register', ['uses' => 'UserController@register']);
$router->post('/login', ['uses' => 'UserController@login']);
