<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => 'admin',
        'namespace' => 'Admin'
    ],
    function (){
        Route::get('/ordersStatus/{id?}', 'OrdersController@indexWithStatus')->name('orders.Status');
        Route::resource('/orders', 'OrdersController'
            //, ['except' => ['index']]
        );
    }
);
// TODO для пользователя поазывать его заказы после реализации auth
Route::group(['prefix' => 'orders'], function (){
    Route::get('/', [
        'uses' => 'OrdersController@showAll',
        'as' => 'allOrders'
    ]);
    Route::get('/{id}', [
        'uses' => 'OrdersController@showOne',
    ])->where('id', '\d+')->name('showOneOrder');
});

Route::get('/', function () {
    return view('welcome');
})->name('main');
Route::group(
    [
        'prefix' => 'weather',
    ], function (){
        Route::get('/', [
            'uses' => 'WeatherController@index'
        ])->name('weather');
        Route::get('/ya', [
                'uses' => 'WeatherController@weatherYandexGuzzle'
            ]);
        Route::get('/ya/curl', [
            'uses' => 'WeatherController@weatherYandexCurl'
        ]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
