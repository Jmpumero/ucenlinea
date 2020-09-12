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

Route::get('postulados/gg', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {



    Route::get('postulados', 'UserInsFormacionController@index')->name('inscribir/estudiantes')
                                                        ->middleware('permission:inscribir estudiantes en formacion');

    Route::get('select/users', 'UserInsFormacionController@select_usuarios')->name('select/users'); //pendiente revisar

    Route::get('select/users_table', 'UserInsFormacionController@users_show')->name('selecionar/users_tabla'); //pendiente revisar

    Route::get('select/sup_table', 'UserInsFormacionController@sup_show')->name('selecionar/super'); //pendiente revisar

    Route::post('inscribir/postulados', 'UserInsFormacionController@store')->name('UserInsFormacion.store'); //añade un postulado a la formacion


    Route::post('inscribir/postulados/masivo/{id}', 'UserInsFormacionController@import_excel')->name('UserInsFormacion.import'); //añade un postulado a la formacion



    Route::get('lista/postulados/{id}', 'UserInsFormacionController@show')->name('postulados.show'); //buena falt midelware

    Route::get('eliminar/postulado/f/{id}', 'UserInsFormacionController@destroy')->name('postulados.destroy'); //pendiente revisar

    Route::get('eliminar/lista/{id}', 'UserInsFormacionController@destroy_all')->name('vaciar lista');


    Route::post('pruebas/excel', 'UserInsFormacionController@pruebas');
   // Route::post('pruebas/excel2', 'UserInsFormacionController@pruebas2');
    //Route::post('users/update', 'UserController@update')->name('productos.update');
});

Route::get('users/export/', 'UsersController@export');
