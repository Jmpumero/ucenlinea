@extends('layouts.admin')
@section('content')
<div id="_postulados" class="card table-responsive"  >
    <div class="card-header">
      <h3 id="titulo" class="card-title" style="margin-bottom: 3%">Formaciones</h3>


    </div>

    <div id="div_formaciones"  class="card-body" style="height: 400px" >


        <!-- no esta mal pero de momento no me sirve
        <div class="card card-outline card-blue">
            <div class="row">
                <div class="col-4 text-center " style="margin-top: 1%;">
                    <div class="card-img" style="margin-bottom: 1%">
                        <img src="{{ asset(Auth::user()->avatar) }}"  width=60  class="img-thumbnail" alt="User Image">

                    </div>
                </div>
                <div class="col-4" style="margin-right: 0%">
                  Segunda de tres columnas
                </div>
                <div class="col-4" style="margin-top: 2%;">
                    <div class="card text-center" style="margin-right: 3%">
                        <button  type="button" name="delete" id ="btn_eliminar_p2"    data-id="1" class="btn btn-outline-danger  btn-lg"><i class="fas fa-trash"  style="margin-right: 0.3rem;" ></i>Borrar</button>
                    </div>

                </div>
              </div>
        </div>

    -->

        <table id="tabla_formaciones" class="table  table-striped  projects text-center" style="width:100%">
            <thead>
                <tr>

                    <th class="text-center" style="width: 15%">
                        Formación
                    </th>
                    <th  style="width: 15%">
                        Nombre
                    </th>


                    <th  style="width: 15%" class="text-center" >
                        Acción
                    </th>


                </tr>
            </thead>


        </table>
    </div>



</div>


  <!-- Modal  -->
  <div class="modal fade table-responsive"  id="modal_solicitud" role="dialog">
    <div id="modal_solicitud" class="modal-dialog modal-dialog-centered " >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4>Solicitud de retiro</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- Modal Body -->
        <div class="modal-body">
            <p class="statusMsg"></p>
            <h5 id="tabla_titulo"></h5>


                <form  id="form_datos"  method="GET">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label>Motivos de retiro</label>
                        <div class="select2-purple">
                          <select id="select_motivos" class="select2" multiple="multiple" data-placeholder="Seleccione" data-dropdown-css-class="select2-purple" style="width: 100%;">
                            @foreach ($results as $item)
                                <option>{{ $item->motivo }}</option>
                            @endforeach


                          </select>
                        </div>
                        <label>Justifique:</label>
                        <div>
                            <textarea id="des_retiro" maxlength="200" name="des_retiro" id="" cols="65" rows="4"></textarea>
                        </div>

                      </div>
                    <!--<input type="text"  name="est_id" hidden id="est_id">-->
                    <input type="text"  name="formacion_id" hidden id="formacion_id">
                    <!--<input hidden type="tex"  name="descripcion"  id="descripcion">-->
                    <input type="text"  name="f_motivos" hidden id="f_motivos">

                   <button hidden id="btn_env_datos" type="submit"></button>
                </form>



        <!-- Modal Footer -->
            <div class="modal-footer">
                <input id="btn_enviar" class="btn btn-success"  type="button" value="Enviar" >
                <button id="btn_closed_m" type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
            </form>
            </div>
        </div>
    </div>
</div>







<form hidden id="form_certificado" action="{{ route('certificado') }}" method="GET">
    {{ csrf_field() }}

    <!--<input type="text"  name="est_id" hidden id="est_id">-->
    <input type="text"  name="f_id" hidden id="f_id">
   <button hidden id="btn_env_f" type="submit"></button>
</form>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready(function() {


        $("textarea").maxlength({
            // options here

        });


        var tabla_f= $('#tabla_formaciones').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('est/tabla/retira/formacion') }}",

            "columns": [
               // {data: 'id'},

                {data: 'imagen',orderable: false, searchable: false,'render' : function (data, type, row) {
                                //console.log("<img src={{ URL::to('/') }}/admilte" + data + " width='70' class='img-thumbnail' />")
                                //console.log(data)
                                return "<img src={{ URL::to('/') }}/" + data + " width='85' class='img-thumbnail' />"
                            }},
                {data: 'nombre'},
                //{data: 'nombre_empresa'},
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
                "infoEmpty": "",
                "infoFiltered": ""
            }
        });


    });



// calificacion esta parte es sumamente inifeciente pero por falta tiempo... asi se queda

    $('body').on('click', '#btn_retirar', function (e) {
        e.preventDefault();

        $('#formacion_id').val($(this).data("id"));
        $('#modal_solicitud').modal('show');

        $('#select_motivos').select2()
        var nombre=$(this).data("nf");
        //console.log(nombre)


    });


    $('#btn_enviar').click(function (e) {
        e.preventDefault();
       // $('#descripcion').val($('#des_retiro').val()); no hace falta
        $('#f_motivos').val($('#select_motivos').val());
        $('#btn_env_datos').trigger('click');
        console.log($('#descripcion').val())
        console.log($('#f_motivos').val())



    });




    $('#form_datos').on('submit', function (event) {

        event.preventDefault();
        $.ajax({

            url: "{{ route('envia/solicitud/retiro') }}",
            method:"GET",
            data:$(this).serialize(),
            //dataType:"json",
            success:function(data)
            {
                var toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });


                $('#f_motivos').val('');
                $('#select_motivos').val('')
                $('#des_retiro').val('')
                $('#formacion_id').val('');
                $('#btn_closed_m').trigger('click');
                $('#tabla_formaciones').DataTable().ajax.reload();
                toast.fire({
                        icon: 'success',
                        title: 'Solicitud enviada.'
                    })

            }
        });

    });


//fin calificacion

//ver certificado
    $('body').on('click', '#btn_ver_c', function (e) {
        e.preventDefault();
        $('#f_id').val($(this).data("id"));
        $('#btn_env_f').trigger('click');
        //console.log($('#f_id').val())
    });

    $('#form_certificado').on('sumit', function () {
        console.log('submit')

    });

//



    $('body').on('click', '#btn_atras_M', function () {
        $('#div_matricula').toggle(1100);
        $('#div_formaciones').toggle(1000);

        $('#titulo').text('Formaciones')


    });










</script>
@endsection
