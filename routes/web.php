<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->group(
    ['prefix' => 'api/v1'],
    function () use ($router) {
        $router->post('/login', 'AuthController@login');
        $router->post('/users', 'UsersController@store');
    }
);
$router->group(
    ['middleware' => 'auth', 'prefix' => 'api/v1'],
    function ($router) {
        $router->post('/refresh-token', 'AuthController@refresh');
        $router->get('/user', 'AuthController@userProfile');

        $router->put('/users/{userId:[0-9]+}', 'UsersController@update');
        $router->delete('/users/{userId:[0-9]+}', 'UsersController@delete');

        $router->put('/books/{bookId:[0-9]+}', 'BooksController@update');
        $router->post('/books', 'BooksController@store');
        $router->delete('/books/{bookId:[0-9]+}', 'BooksController@delete');
        $router->get('/books', 'BooksController@index');

        $router->post('/users/{userId:[0-9]+}/books', 'UserBooksController@store');
        $router->get('/users/{userId:[0-9]+}/books', 'UserBooksController@index');
    }
);
