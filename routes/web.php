<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {



    Route::get('postulados', 'UserInsFormacionController@index')->name('inscribir/estudiantes')
                                                        ->middleware('permission:inscribir estudiantes');

    Route::get('select/users', 'UserInsFormacionController@select_usuarios')->name('select/users'); //pendiente revisar

    Route::get('select/users_table', 'UserInsFormacionController@users_show')->name('selecionar/users_tabla'); //pendiente revisar

    Route::get('lista/postulados/{id}', 'UserInsFormacionController@show')->name('postulados.show'); //

    Route::get('postulado/eliminar/f/{id}', 'UserInsFormacionController@destroy')->name('postulados.destroy'); //pendiente revisar


    //Route::post('users/update', 'UserController@update')->name('productos.update');
});
/*
Route::get('/admin', function () {
    return view('prueba');
});*/
