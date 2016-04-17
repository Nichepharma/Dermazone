<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::controller( 'home', 'HomeController' );
Route::get( '/', [ 'as' => 'home', 'uses' => 'HomeController@getIndex' ] );

Route::get( 'logout', 'UsersController@logout' );
Route::resource( 'users', 'UsersController' );

Route::any( 'login', 'UsersController@login' );
Route::any( 'signup', 'UsersController@signup' );
Route::get( 'profile', 'UsersController@profile' );
Route::any( 'forget_password', 'UsersController@forget_password' );
Route::any( 'reset_password', 'UsersController@reset_password' );
Route::post( 'change_password', 'UsersController@change_password' );

Route::resource('permissions','PermissionsController');
Route::controller('insights','InsightsController');
Route::controller('plan','PlanController');
Route::controller('kpi','KpiController');
Route::controller('customers','CustomersController');
Route::controller('applications','ApplicationsController');
Route::controller('users','UsersController');

Route::match(['get', 'post'], '/datalink', 'DatalinkController@index');
Route::match(['get', 'post'], '/operations123', 'OperationsController@index');


App::missing( function ( $exception ) {
	return Response::view( 'others.not_found', array(), 404 );
} );
