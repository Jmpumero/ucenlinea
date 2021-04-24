@extends('layouts.admin')

@section('content')




        <div class="card card-notifiacion table-responsive" id="c_formaciones">
            <div class="card-header text-center"><h2> Formaciones disponibles</h2> </div>


                <div class=" card-body table-responsive-sm" style="text-align:center;">

                    <div style="text-align:center;" >

                        {!! Form::select('formas', $formaciones_list ?? [], null, ['id'=>'formas','placeholder' => '','class'=>'center-s','style'=>'50%']) !!}

                    </div>
                    <button style="margin-top:1%;" type="button" name="" id="btn_confirm_f" class="btn  btn-success" btn-lg btn-block" disabled=true>Confirmar</button>
                </div>

        </div>
        <livewire:counter>

        <div id="_postulados" class="card table-responsive"  >
            <div class="card-header">
              <h3 class="card-title" style="margin-bottom: 3%">Lista de Postulados</h3>



              <div class="btn-group  table-responsive"  style="margin-left: 10%; " role="group" aria-label="Basic example">
                <a>
                <button   type="button" id="btn_agregar" class="btn   btn-outline-primary" style="width: 100%;"> <i class="fas fa-user-plus"  style="margin-right: 0.5rem; "></i>Agregar</button>
                </a>

                <a href="#">
                  <button disabled=true type="button" id="btn_evaluar" class="btn  btn-outline-info"  style="width: 100%;" data-toggle="tooltip" title="Examinar"  >
                     <i class="fas fa-search" style="margin-right: 0.5rem; "></i>Expedientes</button>
                </a>

                <a>
                <button type="button" id="btn_cargar" class="btn  btn-outline-success" style="width: 100%;" data-toggle="tooltip" title="Examinar" > <i class="fas fa-upload"  style="margin-right: 0.5rem;" ></i>Cargar Excel </button>
                </a>

                <a href="#">
                <button disabled=true type="button" id="btn_deleted_all" class="btn  btn-outline-danger" style="width: 100%;" data-toggle="tooltip" title="" > <i class="fas fa-trash"  style="margin-right: 0.5rem;" ></i>Borrar Lista</button>
                </a>

              </div>



            </div>
            <div   class="card-body  " >

                <table id="tabla_postulados" class="table table-striped projects text-center">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 15%">
                                C.I
                            </th>
                            <th style="width: 15%">
                                Nombre
                            </th>

                            <th  style="width: 15%" class="text-center" >
                                Correo
                            </th>
                            <th style="width: 15%" class="text-center">
                                Supervisor
                            </th>
                            <th style="width: 20%" class="text-center">
                            Acción
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>






        <!-----------MODALES------------->


           <!-- Modal agregar un postulado -->
           <div class="modal fade table-responsive"  id="modal_agregar" role="dialog">
            <div id="modal_agregar_op" class="modal-dialog modal-dialog-centered modal-lg" >
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4>Añadir un nuevo postulado</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>

                    <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <h5 id="tabla_titulo">Selecione el nuevo postulado:</h5>


                    <!--cCON SELECT2-->
                    <div class=" card-body table-responsive-sm" style="text-align:center; display:none;">

                        <div style="text-align:center;" >

                            {!! Form::select('estudiantes', $users_array ?? ['id'=>0,'text'=>'gg'], null, ['id'=>'s_users','placeholder' => '','class'=>'center-s','style'=>'50%']) !!}

                        </div>
                        <button style="margin-top:1%;" type="button" name="" id="btn_confirm_f" class="btn  btn-success" btn-lg btn-block" disabled=true>Confirmar</button>
                    </div>

                    <!--- tabla postulado, pendiente con el tema de muchos usurios-->
                    <div id="card_postulados" class=" card card-outline card-blue table-responsive-sm"  >
                        <div   class="card-body  table-responsive" style="height: 363px"  >

                            <table id="select_new_postulado" class="table table-striped table-responsive-sm text-center" style="height: 245px" >
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 15%">
                                            C.I
                                        </th>
                                        <th style="width: 15%">
                                            Nombre
                                        </th>

                                        <th  style="width: 15%" class="text-center" >
                                            Prioridad
                                        </th>

                                        <th style="width: 20%" class="text-center">
                                        Seleccionar
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                     <!--- tabla supervisor-->
                     <div style="display: none;" id="card_supervisor" class=" card card-outline card-green table-responsive-sm"  >
                        <div   class="card-body" style="height: 300px" >

                            <table id="select_new_supervisor"class="table table-striped table-responsive-sm text-center" style="height: 215px">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 15%">
                                            C.I
                                        </th>
                                        <th style="width: 15%">
                                            Nombre
                                        </th>

                                        <th style="width: 10%" class="text-center">
                                        Seleccione
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button id="btn_atras_M"  class="btn btn-outline-primary" ><i class="fas fa-arrow-alt-circle-left fa-2x"></i> </button>
                        </div>

                    </div>


                    <div id="form_oculto" class=" card-body table-responsive-sm" style="display:none;">
                        {!! Form::open(['action' => 'UserInsFormacionController@store','id'=>'form_new_postu']) !!}


                        <!--id del postulado-->
                        {{ Form::text('id_user', null, ['class' => 'form-control','hidden', 'id' => 'user_id','type'=>"hidden"]) }}

                         <!--id del supervisor-->
                         {{ Form::text('id_sp', null, ['class' => 'form-control','hidden', 'id' => 'sp_id','type'=>"hidden"]) }}

                          <!--id de la formacion-->
                        {{ Form::text('idf', null, ['class' => 'form-control','hidden', 'id' => 'formacion_id','type'=>"hidden"]) }}


                    </div>
                </div>

                <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button id="btn_closed_m" type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                        <div class="form-group">
                            {{ Form::submit('Guardar', ['class' => 'btn  btn-outline-success ','id' => 'btn_guardar_postu']) }}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- FIN modal agregar un postulado -->



         <!-- Modal para importar el excel -->
        <div class="modal fade table-responsive"  id="modal_excel" role="dialog">
            <div id="modal_agregar_op" class="modal-dialog modal-dialog-centered " >
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4>Carga masiva</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <h5 id="tabla_titulo">carga el archivo excel:</h5>


                    <div class="card text-center" >
                        <form id="form_excel" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <input  id="archivo_input" type="file" name="archivo" required>

                    </div>


                <!-- Modal Footer -->
                    <div class="modal-footer">
                        <input id="btn_enviar_excel" class="btn btn-success" type="submit" value="Enviar" >
                        <button id="btn_closed_m_excel" type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>



         <!-- Modal para Errores del excel -->
         <div class="modal fade table-responsive"  id="modal_e_excel" role="dialog">
            <div id="modal_e" class="modal-dialog modal-dialog-centered modal-lg" >
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header text-center">
                        <h4 id="titulo_header">Errores</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                <div class="modal-body text-center">
                    <p class="statusMsg"></p>
                    <h5 id="tabla_e_titulo"></h5>

                    <div  style="display: none;" id="div_t_errores" class="card-body table-responsive card-outline card-danger  "  >

                        <div class="table-responsive "  style="height: 250px;" > <!--para q pueda tener scroll-->
                            <table id="tabla_errores"   class="table table-striped projects">
                                <thead>
                                    <tr>
                                        <th class="text-center" >
                                            Fila:
                                        </th>
                                        <th >
                                            &nbsp
                                        </th>

                                        <th  class="text-center" >
                                            Errores
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>


                        <div class="card"></div>
                    </div>

                    <div style="display: none;" id="div_descarga" class="card card-outline card-green ">
                        <span>Para mas detalles descargue el informe de errores</span>
                        <form action="{{ url('download/export') }}">
                            {{ csrf_field() }}
                            <input type="text"  name="f_id_download" hidden id="vf_id">
                            <input type="text"  name="user_id_download" hidden id="vu_id" value="{{ Auth::user()->id }}">
                            <button id="btn_download_excel" type="submit" class="btn btn-sm btn-outline-primary"><i style="margin-right: 1%" class="fas fa-file-download fa-3x"></i></button>
                        </form>
                    </div>

                <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button id="btn_closed_m_excel" type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>

                        <div class="form-group">


                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!--FORMULARIOS HIDE-->
<!-- Formulario Oculto para los expedientes-->

<form hidden action="{{ url('postulados/evaluar/todos') }}">
    {{ csrf_field() }}
    <input type="text"  name="f_id_ev" hidden id="f_id_ev">
  <!-- una prueba <input type="text"  name="user_id_ev" hidden id="user_id_ev" value="{{ Auth::user()->id }}">-->
    <button hidden id="btn_form_ev" type="submit"></button>
</form>

<!--borrar postulado 2-->
<form hidden id="form_borrar" method="GET">
    {{ csrf_field() }}
    <input type="text"  name="f_id_bp" hidden id="f_id_p">
    <input type="text"  name="user_id_bp" hidden id="user_id_p">
    <button hidden id="btn_form_borrar" type="submit"></button>
</form>
<!--borrar lista-->
<form hidden id="form_dall"  method="GET">
    {{ csrf_field() }}
    <input type="text"  name="f_id_dall" hidden id="f_id_dall">
   <button hidden id="btn_form_dall" type="submit"></button>
</form>



@include('scripts.script_inscripcion')
@endsection
