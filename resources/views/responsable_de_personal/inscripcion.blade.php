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
                     <!-- <form id="form_p" action="{{ url('pruebas/excel') }}" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <label for="archivo"><b>Archivo: </b></label><br>
                        <input id="archivo_inputp" type="file" name="archivo" required>
                        <input id="f_id" type="text" name="formacion" hidden>
                        <input id="btn_enviar_p" class="btn btn-success" type="submit" value="prueba" >
                      </form>-->

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



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            //console.log('X-CSRF-TOKEN');
        }
    });

    $(document).ready(function() {


        $('#formas').select2({
            placeholder:" Elige una formacion ",
            theme:"classic"
        });





    });


    var info //esto para el excel
    var postulado_select=false //para saber si pulso el boton
    var supervisor_select=false
    var cont_select_sup=false
    var formacion_select=false

    $('#archivo_inputp').click(function (e) {

        $('#f_id').val($('#formas').val());
    });//pruebas con el excelp

    //Para ver todos los expedientes
    $('#btn_evaluar').click(function (e) {
       // e.preventDefault();
       info= $('#tabla_postulados').DataTable().page.info();
       //console.log()
       if (info.recordsTotal>0) {
            $('#f_id_ev').val($('#formas').val());
            $('#btn_form_ev').trigger('click');
       }else{

        const t= Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-morado btn-alert',

            },
            buttonsStyling: false
        })


        t.fire({
        title: '<strong> !No hay usuarios en la lista para evaluar! </strong>',
        //text: data.success,
        icon: 'warning',
        confirmButtonText: 'Aceptar',
        width: '35%',
        //timerProgressBar:true,
        //timer: 2500
        })

       }


    });

    $('#formas').on('change', function () {
        if ($('#formas').val()) {


           //
            $("#btn_confirm_f").prop('disabled', false);
            $("#btn_agregar").prop('disabled', false);
            $("#btn_evaluar").prop('disabled', false);

        }

    });

    $('#btn_confirm_f').click(function (e) {
                e.preventDefault();
                formacion_select=true
                var id_form=$('#formas').val()
                $("#btn_deleted_all").prop('disabled', false);
                $('#_postulados').fadeIn(); //prueba de momento
               // console.log(id_form)
                var tabla_postulados= $('#tabla_postulados').DataTable({

                    "destroy":true,
                    "responsive": true,
                    "searching": false,
                    "serverSide": true,
                    "processing": true,
                    "ajax": "lista/postulados/"+id_form,

                    "columns": [
                        {data: 'ci'},
                        {data: 'name'},
                        //{data: 'apellido'},
                        {data: 'email'},
                        {data: 'supervisor','render' : function (data, type, row) {
                                return '<span class="badge badge-dark">'+data+'</span>'
                            }},


                        {data: 'action', name: 'btn', orderable: false},
                    ],

                    "language": {
                        "info": "_TOTAL_ registros",
                        "search": "Buscar",
                        "paginate": {
                            "next": "Siguiente",
                            "previous": "Anterior",
                        },
                        "lengthMenu": 'Mostrar <select >'+
                                    '<option value="10">10</option>'+
                                    '<option value="30">30</option>'+
                                    '<option value="-1">Todos</option>'+
                                    '</select> registros',
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "emptyTable": "No hay datos",
                        "zeroRecords": "No hay coincidencias",
                        "infoEmpty": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                        "infoFiltered": ""
                    },
                    "initComplete": function( settings, json ) {
                         info=tabla_postulados.page.info();
                        //console.log( info.recordsTotal)
                    }
                });

        });

//para borrar todo
    $('#btn_deleted_all').click(function (e) {
        e.preventDefault();
        var f_id=$('#formas').val()
        info= $('#tabla_postulados').DataTable().page.info();


        var toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2800
            });


        if (info.recordsTotal>0) {
            $('#f_id_dall').val(f_id);
            $('#btn_form_dall').trigger('click');

        }else{
            toast.fire({
                        icon: 'warning',
                        title: 'La lista ya esta vacia.'
                    })
        }

    });

    $('#form_dall').on('submit', function (event) {

        event.preventDefault();
        
            $.ajax({
                url: "{{ route('Eliminar.lista') }}",
                method:"GET",
                data:$(this).serialize(),
                //dataType:"json",
                success:function(data)
                {
                    var toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2800
                    });
                    $('#tabla_postulados').DataTable().ajax.reload();
                    toast.fire({
                            icon: 'success',
                            title: 'Postulados Eliminados.'
                        })

                }
            });

        });



    //primera forma
    /*$('body').on('click', '#btn_eliminar_p', function () {

        var postu_id = $(this).data("id");
        id_f=$('#formas').val();

        console.log(postu_id)
        console.log(id_f)

        var toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
            });

        $.ajax({
            url:"eliminar/postulado/f/"+postu_id+"/"+id_f,
            type: "get",
            success:function(data)
            {
                $('#tabla_postulados').DataTable().ajax.reload();
                toast.fire({
                    icon: 'success',
                    title: 'Eliminado correctamente.'
                })
            }
        })

    });*/

    //Borrar postulado version "todo uso..."
    $('body').on('click', '#btn_eliminar_p', function () {
        var p_id = $(this).data("id");
        var f_id=$('#formas').val();
        $('#f_id_p').val(f_id);
        $('#user_id_p').val($(this).data("id"));
        $('#btn_form_borrar').trigger('click');
        });

        $('#form_borrar').on('submit', function (event) {

            event.preventDefault();
            $.ajax({

                url: "{{ route('Postulados.destroy') }}",
                method:"GET",
                data:$(this).serialize(),
                //dataType:"json",
                success:function(data)
                {
                    var toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2800
                    });
                    $('#tabla_postulados').DataTable().ajax.reload();
                    toast.fire({
                            icon: 'success',
                            title: 'Postulado Eliminado.'
                        })

                }
            });

        });






    ///TRATAMIENTO DEL EXCEL

    /// CARGA DEL EXCEL///
    $('#btn_cargar').click(function (e) {
        e.preventDefault();
        $('#modal_excel').modal('show');

    });

    //DESCARGA EL EXCEL//
    $('#btn_download_excel').click(function (e) {

        $('#vf_id').val($('#formas').val());
        //$('#div_descarga').fadeOut();
    });



    //envia excel
    $('#form_excel').on('submit', function (event) {

        event.preventDefault();
        // 4 formas de hacer lo mismo
        /*console.log(new FormData(document.getElementById("form_excel")))
        console.log(new FormData($(this)[0]))
        console.log(new FormData(this))
        var formData = new FormData(this);
        formData.append('_token', $('input[name=_token]').val());
        console.log(formData)
        */
        var id_form=$('#formas').val()
        $.ajax({

                url: "inscribir/postulados/masivo/"+id_form,
                method:"POST",
                //data:$(this).serialize(),
                data:new FormData(this), //obtines los input del form
                //dataType:"json",
                contentType: false, //importante enviar este parametro en false
                processData: false,//importante enviar este parametro en false
                success:function(data)
                {
                    //console.log(data)
                    //console.log(data[2].cont_e)
                    $('#archivo_input').val(''); //limpia el campo del archivo
                    var newRows = "";
                    //console.log(data[0].status)
                    if(data[0].status==300) //Errores Postulados/Supervisores
                    {
                        $('#modal_e_excel').modal('show');
                        $('#div_t_errores').fadeIn();
                        $('#div_descarga').fadeIn();
                        $('#tabla_e_titulo').text('Total de errores: '+data[2].cont_e);
                        $("#tabla_errores tr").remove();
                        $.each(data[1].errores, function (i,valor) {
                            //console.log(valor)
                            var cad=valor.split('-')
                            $("#tabla_errores").append("<tr><td>" + cad[0] + "</td><td>  </td><td>"+cad[1]+"</td> </tr>");


                        });
                        $('#form_new_postu')[0].reset();
                        $('#tabla_postulados').DataTable().ajax.reload();

                    }

                    if(data[0].status==250  ) //Mal/sin encabezado
                    {

                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: true
                            })


                        t.fire({
                        title: '!ERROR !',
                        text: data[1].errores,
                        icon: 'error',
                        confirmButtonText: 'Continuar',
                        width: '35%',
                        timerProgressBar:true,

                        })

                    }
                    if(data[0].status==260  ) //Mal/sin encabezado
                    {

                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: true
                            })


                        t.fire({
                        title: '<strong>!ERROR !</strong>',
                        text: data[1].errores,
                        icon: 'error',

                        confirmButtonText: 'Continuar',
                        width: '35%',
                        timerProgressBar:true,

                        })

                    }

                    if(data[0].status==777) //Todo perfecto
                    {
                        //html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#form_new_postu')[0].reset();
                        $('#tabla_postulados').DataTable().ajax.reload();

                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: false
                            })


                        t.fire({
                        title: '!Guardado correctamente!',
                        text: data.success,
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        width: '35%',
                        timerProgressBar:true,
                        timer: 2500
                        })


                    }


                }
        });

        //$('#archivo_input').val('');
    //$('#btn_closed_m_excel').trigger('click');
    });

    ////agregar un estudiante////
    $('#btn_agregar').click(function (e) {
        e.preventDefault();
        $('#modal_agregar').modal('show');

        if ($('#card_supervisor').css('display')!='none') {
            //console.log('yiiiyi')
            $('#tabla_titulo').text('Selecione el nuevo postulado');
            $('#card_supervisor').css('display', 'none');
            $('#card_postulados').fadeIn();

        }

        $('#s_users').select2({
            placeholder:"Elige un nuevo postulado",
            theme: "classic",
           // minimumResultsForSearch: Infinity, //para ocultar el search que en seste caso no hace falta
            //tags: true,
            //tokenSeparators: [','],
            ajax: {
                url: "{{ route('select/users') }}" ,
                dataType: 'json',
                delay: 250,
                data: function (params) {//en esta parte va el parmetro que se envia por medio de la request
                    return {
                        ci: $.trim(params.term)
                    };
                },

                processResults: function(data)
                {
                    //console.log(data)

                    return {
                        results: data
                    };
                },
                cache: true

            }
        })

        postulado_select=false
        supervisor_select=false
        var tabla_postulados= $('#select_new_postulado').DataTable({

            "destroy":true,
            "responsive": true,
            //"deferRender":  true,
            //"scroller":     true,
            //"searching": false,
            "serverSide": true,
            "processing": true,
            "ajax": "select/users_table",

            "columns": [
                {data: 'ci'},
                {data: 'name'},
                //{data: 'apellido'},
                {data: 'prioridad','render' : function (data, type, row) {
                                if (data.toUpperCase()=='ALTA') {
                                    return '<span class="badge-pill badge-verde-b ">'+data.toUpperCase()+'</span>'
                                }
                                if (data.toUpperCase()=='MEDIA') {
                                    return '<span class="badge-pill badge-oro2 ">'+data.toUpperCase()+'</span>'
                                }

                                return '<span class="badge-pill badge-danger">'+data.toUpperCase()+'</span>'
                            }},



                {data: 'action', name: 'btn', orderable: false},
            ],

            "language": {
                "info": "_TOTAL_ registros",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior",
                },
                "lengthMenu": 'Mostrar <select >'+
                            '<option value="10">10</option>'+
                            '<option value="30">30</option>'+
                            '<option value="-1">Todos</option>'+
                            '</select> registros',
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "emptyTable": "No hay datos",
                "zeroRecords": "No hay coincidencias",
                "infoEmpty": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoFiltered": ""
            }
        });

    });

    $('#modal_agregar').on('click', '#btn_select_p', function () {
        //$('#card_postulado').fadeOut();
        postulado_select=true
        if (!cont_select_sup) {
            cont_select_sup=true
        }else{
            $('tr').css('background', '#ffffff');

        }
        $(this).closest('tr').css('background', '#24e695');




        $('#card_postulados').toggle(1000);
        $('#card_supervisor').fadeIn(1100);


        //LLENANDO EL FORM//

        $('#formacion_id').val($('#formas').val());
        $('#user_id').val($(this).data("id"));

        //console.log('gg?')




        $('#tabla_titulo').text('Selecione el Supervisor');

        var tabla_postulados= $('#select_new_supervisor').DataTable({

            "destroy":true,
            "responsive": true,
            //"searching": false,
            "serverSide": true,
            "processing": true,
            "ajax": "select/sup_table",

            "columns": [
                {data: 'ci'},
                {data: 'name'},
                //{data: 'email'},
                {data: 'action', name: 'btn', orderable: false},
            ],

            "language": {
                "info": "_TOTAL_ registros",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior",
                },
                "lengthMenu": 'Mostrar <select >'+
                            '<option value="10">10</option>'+
                            '<option value="30">30</option>'+
                            '<option value="-1">Todos</option>'+
                            '</select> registros',
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "emptyTable": "No hay datos",
                "zeroRecords": "No hay coincidencias",
                "infoEmpty": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoFiltered": ""
            }
        });


    });

    $('#modal_agregar').on('click', '#btn_atras_M', function () {
        $('#card_supervisor').toggle(1000);
        $('#card_postulados').toggle(1100);
        postulado_select=false
        supervisor_select=false

    });

    $('#modal_agregar').on('click', '#btn_select_sup', function () {

        $('#sp_id').val($(this).data("id"));

        if (!cont_select_sup) {
            cont_select_sup=true
        }else{
            $('tr').css('background', '#ffffff');

        }
        $(this).closest('tr').css('background', '#b8daba');
        supervisor_select=true

        //console.log($('#user_id').val())
        //console.log($('#formacion_id').val())



    });

    $('#form_new_postu').on('submit', function (event) {

        event.preventDefault();
        //console.log($(this).serialize())
        //console.log(postulado_select)
        if (postulado_select && supervisor_select && formacion_select) {
            $.ajax({

                    url: "{{ route('UserInsFormacion.store') }}",
                    method:"POST",
                    data:$(this).serialize(),
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.error)
                        {
                            //console.log(data.error)
                            const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-danger',

                                },
                                buttonsStyling: false
                            })


                            t.fire({
                            title: 'ERROR',
                            text: data.error,
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            width: '35%',
                            //timerProgressBar:true,
                            //timer: 2500
                            })
                        }
                        if(data.success)
                        {
                            //html = '<div class="alert alert-success">' + data.success + '</div>';
                            $('#form_new_postu')[0].reset();
                            $('#tabla_postulados').DataTable().ajax.reload();
                            //info= $('#tabla_postulados').DataTable().page.info();
                            //console.log(info.recordsTotal)

                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: false
                            })


                            t.fire({
                            title: '!Guardado correctamente!',
                            text: data.success,
                            icon: 'success',
                            confirmButtonText: 'Continuar',
                            width: '35%',
                            timerProgressBar:true,
                            timer: 2500
                            })

                            //$('#btn_closed_m').trigger('click');
                            //$('#modal_agregar').modal('hide'); desscuadra la cosa
                        }


                    }
                });


            }
                //$('#btn_closed_m').trigger('click');


    });
    ///***////

</script>
@endsection
