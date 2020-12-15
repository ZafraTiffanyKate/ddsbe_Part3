<?php
/** @var \Laravel\Lumen\Routing\Router $router */
/*
|---------------------------------------------------------------------
-----
| Application Routes
|---------------------------------------------------------------------
-----
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function () use ($router) {
 return $router->app->version();
});
// unsecure routes
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users',['uses' => 'UserController@getUsers']);
});

$router->get('/users','UserController@index');
$router->post('/users','UserController@addUser');
$router->get('/users/{id}','UserController@showId');
$router->put('/users/{id}','UserController@updateUser');
$router->patch('/users/{id}','UserController@updateUser');
$router->delete('/users/{id}','UserController@deleteUser');

//userjob routes
$router->get('/usersjob','UserJobController@index');
$router->get('/userjob/{id}','UserJobController@show'); // get user by id