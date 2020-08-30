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
            <div class="card-header text-center">Formaciones disponibles </div>


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
                <button type="button" class="btn   btn-outline-primary" style="width: 100%;"> <i class="fas fa-user-plus"  style="margin-right: 0.5rem; "></i>Agregar</button>
                </a>

                <a href="#">
                  <button type="button" class="btn  btn-outline-info"  style="width: 100%;" data-toggle="tooltip" title="Examinar"  >
                     <i class="fas fa-search" style="margin-right: 0.5rem; "></i>Expedientes</button>
                </a>

                <a>
                <button type="button" class="btn  btn-outline-success" style="width: 100%;" data-toggle="tooltip" title="Examinar" > <i class="fas fa-clipboard-check"  style="margin-right: 0.5rem;" ></i>Inscribir Lista</button>
                </a>

                <a href="#">
                <button type="button" class="btn  btn-outline-danger" style="width: 100%;" data-toggle="tooltip" title="Examinar" > <i class="fas fa-trash"  style="margin-right: 0.5rem;" ></i>Borrar Lista</button>
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
                            <th style="width: 15%">
                                Apellido
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
                url: "{{ route('select/formacion') }}" ,
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


    });


      $('#formas').on('change', function () {
          if ($('#formas').val()) {

              var id_form=$('#formas').val()
              console.log(id_form)
              $("#btn_confirm_f").prop('disabled', false);
              $('#btn_confirm_f').click(function (e) {
                  e.preventDefault();
                 // $('#c_formaciones').toggle(1000); de momento no
                  $('#_postulados').fadeIn(); //prueba de momento


                    var tabla_inscritos= $('#tabla_postulados').DataTable({
                        "destroy":true,
                        "serverSide": true,
                        "processing": true,
                        "ajax": "lista/postulados/"+id_form,

                        "columns": [
                            {data: 'ci'},
                            {data: 'name'},
                            {data: 'apellido'},
                            {data: 'email'},
                            {data: 'supervisor_id'},


                            {data: 'action', name: 'btn', orderable: false, searchable: false},
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


          }

      });



</script>
@endsection
