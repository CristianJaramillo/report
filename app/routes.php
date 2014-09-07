<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Este es un ejmplo de que parametros pasamos a las plantillas 
| claro que sto sera manejado por el sistema de respuesta y busqueda. 
|
*/

// \Debugbar::disable();

Route::group(['before' => 'guest'], function(){

	// Página del home.
	Route::get('/', ['as' => 'sing-in', 'uses' => 'UserController@show']);
	// Página de registro.
	Route::get('sing-up', ['as' => 'sing-up', 'uses' => 'UserController@singUp']);
	// Página de restauración de contraseña.
	Route::get('restore', ['as' => 'restore', 'uses' => 'UserController@show']);
	// Página de ayuda.
	Route::get('help', ['as' => 'help', 'uses' => 'UserController@show']);

	Route::group(['before' => 'csrf'], function () {
		// Login de usuario.
		Route::post('/', ['as' => 'login', 'uses' => 'AuthController@login']);
		// Registro de usuario.
		Route::post('sing-up', ['as' => 'register', 'uses' => 'UserController@register']);
		// Registro de usuario.
		Route::post('restore', ['as' => 'recover', 'uses' => 'UserController@recover']);
	});

});

/*
 |
 | Account User
 |
 */
Route::group(['before' => 'auth'], function (){
	// Dashboard
	Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'UserController@dashboard']);
	// Página de perfil de usuario.
	Route::get('account/{user?}', ['as' => 'account', 'uses' => 'UserController@account']);
	// Logout de usuario.
	Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
	// Página de Table UI
	Route::get('table-ui', ['as' => 'table-ui', 'uses' => 'TableUIController@show']);
	// Peticiones de Table UI
	Route::post('ajax', ['as' => 'ajax', 'before' => 'csrf', 'uses' => 'TableUIController@ajax']);
});

/*
 |
 | View 
 |
 */
// Error 401
Route::get('401', function(){
	return App::abort(401);
});

// Error 403
Route::get('403', function(){
	return App::abort(403);
});

// Error 404
Route::get('404', function(){
	return App::abort(404);
});

// Error 500
Route::get('500', function(){
	return App::abort(500);
});