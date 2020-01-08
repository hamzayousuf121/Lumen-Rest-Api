<?php

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
    //return $router->app->version();
    $response = [
        'status' => 1,
        'data' => "Laravel 5.5.* Lumen 5.5.0 RESTful API with OAuth2"
    ];

    return response()->json($response, 200, [], JSON_PRETTY_PRINT);
});

//'namespace' => 'App\Http\Controllers'
$router->group(['prefix' => ''], function ($app) {
    $app->post('register', 'UserController@create');

    $app->post('authorize', 'UserController@auth');

    $app->post('accesstoken', 'UserController@accesstoken');

    $app->post('refresh', 'UserController@refresh');

    $app->get('me', 'UserController@me');

    $app->get('logout', 'UserController@logout');

    $app->put('users/{id}', 'UserController@update');

    $app->get('users/{id}', 'UserController@view');

    $app->delete('users/{id}', 'UserController@deleteRecord');

    $app->get('users', 'UserController@index');

    //Suppliers

    $app->post('suppliers', 'SuppliersController@create');

    $app->put('suppliers/{id}', 'SuppliersController@update');

    $app->get('suppliers/{id}', 'SuppliersController@index');

    $app->delete('suppliers/{id}', 'SuppliersController@deleteRecord');

    $app->get('suppliers', 'SuppliersController@view');

    // Customers
    $app->post('customers', 'CustomersController@create');

    $app->put('customers/{id}', 'CustomersController@update');

    $app->get('customers/{id}', 'CustomersController@index');

    $app->delete('customers/{id}', 'CustomersController@deleteRecord');

    $app->get('customers', 'CustomersController@view');

    //Employees
    $app->post('employees', 'EmployeesController@create');

    $app->put('employees/{id}', 'EmployeesController@update');

    $app->get('employees/{id}', 'EmployeesController@index');

    $app->delete('employees/{id}', 'EmployeesController@deleteRecord');

    $app->get('employees', 'EmployeesController@view');


    // Orders
    $app->post('orders', 'OrdersController@create');

    $app->put('orders/{id}', 'OrdersController@update');

    $app->get('orders/{id}', 'OrdersController@index');

    $app->delete('orders/{id}', 'OrdersController@deleteRecord');

    $app->get('orders', 'OrdersController@view');

    // orders Details
    $app->post('orderdetails', 'OrderdetailsController@create');

    $app->put('orderdetails/{id}', 'OrderdetailsController@update');

    $app->get('orderdetails/{id}', 'OrderdetailsController@index');

    $app->delete('orderdetails/{id}', 'OrderdetailsController@deleteRecord');

    $app->get('orderdetails', 'OrderdetailsController@view');

    //Master
    
    $app->post('masters', 'MastersController@create');

    $app->put('masters/{id}', 'MastersController@update');

    $app->get('masters/{parent_id}/{table_type}', 'MastersController@index');

    $app->delete('masters/{id}', 'MastersController@deleteRecord');

    $app->get('masters','MastersController@view');


    // Products
    $app->post('products', 'ProductsController@create');

    $app->put('products/{id}', 'ProductsController@update');

    $app->get('products/{id}', 'ProductsController@index');

    $app->delete('products/{id}', 'ProductsController@deleteRecord');

    $app->get('products', 'ProductsController@view');

    // Transacion
    $app->post('transactions', 'TransactionsController@create');

    $app->put('transactions/{id}', 'TransactionsController@update');

    $app->get('transactions/{id}', 'TransactionsController@index');

    $app->delete('transactions/{id}', 'TransactionsController@deleteRecord');

    $app->get('transactions', 'TransactionsController@view');

    // Transaction Details
    $app->post('transactionsdetails', 'TransactondetailsController@create');

    $app->put('transactionsdetails/{id}', 'TransactondetailsController@update');

    $app->get('transactionsdetails/{id}', 'TransactondetailsController@index');

    $app->delete('transactionsdetails/{id}', 'TransactondetailsController@deleteRecord');

    $app->get('transactionsdetails', 'TransactondetailsController@view');
});
