@extends('layouts.admin')

@section('content')


        <!-- esto fue una prueba para usar ajax
            <div class="card card-notificacion">
            <div class="card-header">ajax sin collective</div>

            <div class="card-body">

                <form action="" method="get">
                    <select name="formaciones[]" id="formaciones"  style="width: 50%" >
                        <option></option>
                    </select>
                </form>


            </div>
        </div>-->

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
                  <button disabled=true type="button" id="btn_expediente" class="btn  btn-outline-info"  style="width: 100%;" data-toggle="tooltip" title="Examinar"  >
                     <i class="fas fa-search" style="margin-right: 0.5rem; "></i>Expedientes</button>
                </a>

                <a>
                <button type="button" id="btn_carga" class="btn  btn-outline-success" style="width: 100%;" data-toggle="tooltip" title="Examinar" > <i class="fas fa-upload"  style="margin-right: 0.5rem;" ></i>Cargar Excel </button>
                </a>

                <a href="#">
                <button disabled=true type="button" id="btn_borrar_todo" class="btn  btn-outline-danger" style="width: 100%;" data-toggle="tooltip" title="" > <i class="fas fa-trash"  style="margin-right: 0.5rem;" ></i>Borrar Lista</button>
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

        <div><h3>esto es un div de prueba</h3></div>







           <!-- Modal -->
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


                    <!--cCON SELECT2-->
                    <div class=" card-body table-responsive-sm" style="text-align:center; display:none">

                        <div style="text-align:center;" >

                            {!! Form::select('estudiantes', $users_array ?? ['id'=>0,'text'=>'gg'], null, ['id'=>'s_users','placeholder' => '','class'=>'center-s','style'=>'50%']) !!}

                        </div>
                        <button style="margin-top:1%;" type="button" name="" id="btn_confirm_f" class="btn  btn-success" btn-lg btn-block" disabled=true>Confirmar</button>
                    </div>

                    <!---CON DATATABLE-->

                    <div   class="card-body table-responsive-sm " >

                        <table id="select_new_postulado" class="table table-striped projects text-center">
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

                                    <th style="width: 20%" class="text-center">
                                    Seleccionar
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>



                </div>

                <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-outline-success submitBtn" onclick="submitContactForm()">Guardar</button>
                    </div>
                </div>
        </div>
        </div>








<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            //console.log('X-CSRF-TOKEN');
        }
    });

    $(document).ready(function() {
        /*$('#formaciones').select2({ //version con ajax (en este caso no es necesaria)
            placeholder:"Elige una formacion",
            theme: "classic",
            minimumResultsForSearch: Infinity, //para ocultar el search que en seste caso no hace falta
            //tags: true,
            //tokenSeparators: [','],
            ajax: {
                url: "{{ route('select/users') }}" ,
                dataType: 'json',
                delay: 250,
                data: function (params) {//en esta parte va el parmetro que se envia por medio de la request
                    return {
                        nombre: $.trim(params.term)
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
        });*/

        $('#formas').select2({
            placeholder:" Elige una formacion ",
            theme:"classic"
        });

        /*$('#s_usuarios').select2({
            placeholder:" Elige un postulado ",
            theme:"classic"
        });*/



    });


    $('#formas').on('change', function () {
        if ($('#formas').val()) {


           //
            $("#btn_confirm_f").prop('disabled', false);
            $("#btn_agregar").prop('disabled', false);

        }

    });

    $('#btn_confirm_f').click(function (e) {
                e.preventDefault();
                var id_form=$('#formas').val()
                // $('#c_formaciones').toggle(1000); de momento no
                $('#_postulados').fadeIn(); //prueba de momento
                console.log(id_form)
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
                    }
                });

                //$('#tabla_postulados').DataTable().draw();
        });



    $('body').on('click', '#btn_eliminar_p', function () {

        var producto_id = $(this).data("id");

        console.log(producto_id);

        $.ajax({
            url:"postulado/eliminar/f/"+producto_id,
            type: "get",
            success:function(data)
            {
                $('#tabla_postulados').DataTable().ajax.reload();
            }
        })

    });

    $('#btn_agregar').click(function (e) {
        e.preventDefault();
        $('#modal_agregar').modal('show');

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
                {data: 'email'},



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



</script>
@endsection
