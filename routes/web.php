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

//Route::get('validar/certificado','HomeController@verificar_certificado_index')->name('validar/certificado');

Route::get('valida/certificado','HomeController@verificar_certificado')->name('valida/certificado');

Route::get('validar/certificado', function () {
    return view('verificar_certificado.verificar_certificado');
});

//Route::get('formaciones/publicadas','HomeController@index_formaciones_publicadas')->name('formaciones/publicadas');

//Auth::routes(['formaciones/publicadas'=>false]);
Route::get('formaciones/publicadas','HomeController@index_formaciones_publicadas')->name('formaciones/publicadas');
/*Route::group(['middleware' => ['web']], function () {
    Route::get('formaciones/publicadas','HomeController@index_formaciones_publicadas')->name('formaciones/publicadas');
});*/

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

    Route::get('ver/solicitudes', 'ExpedienteUsuarioController@solicitudes_retiro_formacion_postulados_index')->name('solicitudes/postulados');

    Route::get('ver/solicitudes/retiro', 'ExpedienteUsuarioController@tabla_solicitudes_post_rp')->name('solicitudes/postulados/retiro');

    Route::get('ver/datos/retiro', 'ExpedienteUsuarioController@datos_modal_solicitudes_post_rp')->name('solicitud/datos/retiro');


    Route::get('procesar/datos/retiro', 'ExpedienteUsuarioController@procesar_solicitud_retiro')->name('procesa/solicitud/retiro');

    Route::get('retiro/estudiantes/uvc', 'ExpedienteUsuarioController@index_retiro_uvc')->name('retiro/estudiantes/uvc');

    Route::get('tabla/retiro/estudiantes/uvc', 'ExpedienteUsuarioController@tabla_postulados_retirar_uvc')->name('tabla/retiro/estudiantes/uvc');

    Route::get('rp/enviar/datos/retiro/uvc', 'ExpedienteUsuarioController@enviar_solicitud_retiro_uvc')->name('rp/enviar/datos/retiro/uvc');



    /** Responsable de control de estudio */

    Route::get('matriculacion', 'MdlInscripcionController@index')->name('matricular/estudiantes')->middleware('permission:matricular estudiantes en moodle');

    Route::get('facilitadores', 'MdlInscripcionController@facilitador_show')->name('Mdl.facilitadores');

    Route::get('matricular', 'MdlInscripcionController@enrolling')->name('Mdl.matricular');

    Route::get('solicitudes/retiro/formacion', 'ExpedienteUsuarioController@tabla_retiro_formacion_rp_rces')->name('solicitudes/retiro/formacion');

    Route::get('solicitudes/retiro/formacion', 'ExpedienteUsuarioController@tabla_retiro_formacion_rp_rces')->name('solicitudes/retiro/formacion');

    Route::get('retiro/formacion/postuado', 'ExpedienteUsuarioController@procesar_retiro_formacion')->name('retiro/postulado/formacion');

    Route::get('tabla/solicitud/retiro/uvc', 'ExpedienteUsuarioController@tabla_retiro_uvc_rp_rces')->name('tabla/solicitud/retiro/uvc');

    Route::get('procesar/solicitud/retiro/uvc', 'ExpedienteUsuarioController@procesar_retiro_uvc')->name('procesar/solicitud/retiro/uvc');


    Route::get('carga/doc/marco/regulatorio','HomeController@cargar_marco_regulatorio_index')->name('carga/doc/marco/regulatorio');

    Route::post('guardar/documento','HomeController@guardar_documento_marco_regulatorio')->name('guardar/doc');


    Route::get('formaciones/no/publicada','HomeController@index_formaciones_no_publicadas')->name('formaciones/sinpublicar');

    Route::get('publicar/formaciones','HomeController@publica_formacion')->name('publicar');

    //Route::post('pruebas/excel', 'UserInsFormacionController@pruebas')->name('f.pruebas');

    /** EXTRAS */
    //formaciones publicadas
   // Route::get('formaciones/publicadas','HomeController@index_formaciones_publicadas')->name('formaciones/publicadas');




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


Route::get('formacion/libre','MdlInscripcionController@libre_enroll')->name('inscribirse/formacion/libre');


Route::get('retirar/formacion', 'ExpedienteUsuarioController@retirar_formacion_index')->name('est/retira/formacion');
Route::get('t/retirar/formacion', 'ExpedienteUsuarioController@tabla_retira_formacion_index')->name('est/tabla/retira/formacion');

Route::get('solicitud/retirar/formacion', 'ExpedienteUsuarioController@enviar_solicitud_retiro')->name('envia/solicitud/retiro');


/** SUPERVISOR*/ //faltan los Midleware
Route::get('sup/formaciones/calificar', 'ExpedienteUsuarioController@index_supervisor')->name('supervisor/formaciones/principal');

Route::get('formaciones/calificar', 'ExpedienteUsuarioController@show_formaciones_supervisor')->name('sup/tabla/formaciones/disponibles');

Route::get('postulados/calificar', 'ExpedienteUsuarioController@show_postulados_supervisor')->name('sup/tabla/postulados');

Route::get('postulados/calificado', 'ExpedienteUsuarioController@calificar_postulado')->name('sup/califica/postulado');



});

Route::get('users/export/', 'UsersController@export');//prueba de descarga excel
