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

    /** Responsable de personal */
    Route::get('postulados', 'UserInsFormacionController@index')->name('inscribir/estudiantes')->middleware('permission:inscribir estudiantes en formacion');

    Route::get('select/users', 'UserInsFormacionController@select_usuarios')->name('select/users'); //pendiente revisar

    Route::get('select/users_table', 'UserInsFormacionController@users_show')->name('selecionar/users_tabla'); //pendiente revisar

    Route::get('select/sup_table', 'UserInsFormacionController@sup_show')->name('selecionar/super'); //pendiente revisar

    Route::post('inscribir/postulados', 'UserInsFormacionController@store')->name('UserInsFormacion.store'); //añade un postulado a la formacion

    Route::post('inscribir/postulados/masivo/{id}', 'UserInsFormacionController@import_excel')->name('UserInsFormacion.import'); //añade un postulado a la formacion

    Route::get('lista/postulados/{id}', 'UserInsFormacionController@show')->name('postulados.show'); //buena falt midelware
    //Route::get('eliminar/postulado/f/{id}/{id_f}', 'UserInsFormacionController@destroy')->name('postulados.destroy'); //remplazada
    Route::get('eliminar/lista', 'UserInsFormacionController@destroy_all')->name('Eliminar.lista');
    Route::get('download/export', 'UserInsFormacionController@download_excel_er')->name('error_p.download');

    Route::get('postulados/evaluar/todos', 'UserInsFormacionController@expediente_estudiante_all')->name('p.evaluar');


    Route::get('eliminar/postulado/f', 'UserInsFormacionController@destroy')->name('Postulados.destroy'); //pendiente revisar

    Route::post('pruebas/excel', 'UserInsFormacionController@pruebas')->name('f.pruebas');
   //* fin rp*//

    /** Responsable de control de estudio */

    Route::get('matriculacion', 'MdlInscripcionController@index')->name('matricular/estudiantes')->middleware('permission:matricular estudiantes en moodle');

    Route::get('facilitadores', 'MdlInscripcionController@facilitador_show')->name('Mdl.facilitadores');

    Route::get('matricular', 'MdlInscripcionController@enrolling')->name('Mdl.matricular');


    Route::get('pruebas', 'MdlInscripcionController@pruebas')->name('gg.pruebas');

    /** Proveedor */

   // Route::get('matriculacion/externa', 'MdlInscripcionController@matriculacion_externa_index')->name('matricula/formacion/externa'); //OJO FALTA EL MIDDLEWARE

    Route::get('formaciones/matricula/externa', 'MdlInscripcionController@formaciones_externas')->name('formaciones/m/externa');

    Route::get('matricula/externa', 'MdlInscripcionController@show_external_enroll')->name('externa/m');


    /** FACILITADOR*/ //faltan los Midleware

Route::get('formaciones/matricula/facilitador', 'MdlInscripcionController@show_formaciones_facilitador')->name('formaciones/m/facilitador'); //muestras las formaciones del facilitador para luego obtner la matricula

Route::get('matricula/formacion', 'MdlInscripcionController@show_matricula_formacion')->name('facilitador/m');

Route::get('formaciones/facilitador', 'MdlInscripcionController@show_cargar_acta_facilitador')->name('formaciones/actas/facilitador');


Route::post('envia/acta/facilitador', 'MdlInscripcionController@import_acta_excel')->name('facilitador/envia/actas');


/** ESTUDIANTE*/ //faltan los Midleware
Route::get('formaciones/certificadas', 'ExpedienteUsuarioController@show_formaciones_calificar_certificado_index')->name('est/formaciones/certificadas'); //ve las formaciones/certificado

Route::get('califica/formacion', 'ExpedienteUsuarioController@califica_formacion_facilitador')->name('est/califica/formacion'); //califica formacion

Route::get('certificado/formacion', 'ExpedienteUsuarioController@certificado_donwload')->name('certificado');


/** SUPERVISOR*/ //faltan los Midleware
Route::get('sup/formaciones/calificar', 'ExpedienteUsuarioController@index_supervisor')->name('supervisor/formaciones/principal');

Route::get('formaciones/calificar', 'ExpedienteUsuarioController@show_formaciones_supervisor')->name('sup/tabla/formaciones/disponibles');

Route::get('postulados/calificar', 'ExpedienteUsuarioController@show_postulados_supervisor')->name('sup/tabla/postulados');





});

Route::get('users/export/', 'UsersController@export');//prueba de descarga excel
