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

        <table id="tabla_solicitudes" class="table  table-striped  projects text-center" style="width:100%">
            <thead>
                <tr>

                    <th class="text-center" style="width: 15%">

                    </th>
                    <th  style="width: 15%">
                        CI
                    </th>
                    <th  style="width: 15%">
                        Nombre
                    </th>

                    <th class="text-center" style="width: 15%">
                        Fecha de envio
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
    <div id="modal_solicitud" class="modal-dialog modal-dialog-centered  " >
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

                    <div class="form-group row">
                        <label for="solicitud" class="col-sm-6 col-form-label">Solicitud enviada:</label>
                        <div class="col-sm-6">
                          <input type="text" readonly class="form-control-plaintext" id="solicitud" value="email@example.com">
                        </div>
                    </div>


                  <div class="form-row">

                    <div class="form-group col-md-7">
                      <label for="inputpostulado">Nombre</label>
                      <input readonly type="text" class="form-control-plaintext " id="inputpostulado" value="Jose Jesus Medina Pumero">
                    </div>

                    <div class="form-group col-sm-1">
                    </div>

                    <div class="form-group col-md-4 text-center">
                      <label for="inputci">CI:</label>
                      <input readonly type="text" class="form-control-plaintext text-center" id="inputci" value="">
                    </div>
                  </div>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputformacion">Formación</label>
                            <input readonly type="text" class="form-control-plaintext " id="inputformacion" value="">
                          </div>

                          <div class="form-group col-sm-1">
                          </div>

                          <div class="form-group col-md-5 text-center">
                            <label for="inputfecha">Fecha de inicio:</label>
                            <input readonly type="text" class="form-control-plaintext text-center" id="inputfecha" value="">
                          </div>
                    </div>

                    <div class="form-group">
                        <label for="msj">Descripción:</label>
                        <div>
                          <textarea name="descripcion" readonly  id="msj"  cols="65" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="motivos" class="col-sm-3 col-form-label">Motivos:</label>
                        <div id="div_motivos" class="col-sm-9">

                        </div>
                    </div>



                    <!--<input type="text"  name="est_id" hidden id="est_id">-->
                    <input type="text"  name="formacion_id" hidden id="formacion_id">
                    <!--<input hidden type="tex"  name="descripcion"  id="descripcion">-->
                    <input type="text"  name="p_id" hidden id="p_id">

                   <button hidden id="btn_env_datos" type="submit"></button>
                </form>



        <!-- Modal Footer -->
            <div class="modal-footer">
                <input id="btn_enviar" class="btn btn-outline-success"  type="button" value="Procesar" >
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


    //var formacion_id;
    $(document).ready(function() {


        $("textarea").maxlength({
            // options here

        });


        var tabla_f= $('#tabla_solicitudes').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('solicitudes/postulados/retiro') }}",

            "columns": [
               // {data: 'id'},

                {data: 'avatar',orderable: false, searchable: false,'render' : function (data, type, row) {
                                //console.log("<img src={{ URL::to('/') }}/admilte" + data + " width='70' class='img-thumbnail' />")
                                //console.log(data)
                                return "<img src={{ URL::to('/') }}/" + data + " width='85' class='img-thumbnail' />"
                            }},
                {data: 'ci'},
                {data: 'name'},
                {data: 'created_at'},
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

    $('body').on('click', '#btn_ver', function (e) {
        e.preventDefault();

        $('#formacion_id').val($(this).data("f"));
        $('#p_id').val($(this).data("uid"));
        $('#modal_solicitud').modal('show');

        $.ajax({

            url: "{{ route('solicitud/datos/retiro') }}",
            method:"GET",
            data: {
                "user_id": $(this).data("uid"),
                "f_id": $(this).data("f"),
                },
            //data:$(this).serialize(),
            //dataType:"json",
            success:function(data)
            {
                var hmtl = '';
                $('#solicitud').val(data[0].f_solicitud);
                $('#inputpostulado').val(data[0].p_nombre);
                $('#inputci').val(data[0].p_ci);
                $('#inputformacion').val(data[0].f_nombre);
                $('#inputfecha').val(data[0].f_inicio);
                $('#msj').text(data[0].descripcion);

                html = '';
                for (let i = 0; i < data[0].motivos.length; i++) {

                     html += '<span class="badge-pill badge-primary">'+data[0].motivos[i]+'</span>'
                    //console.log(data[0].motivos[i]);

                }
                $('#div_motivos').html(html);
                //console.log(html);


            }
        });
        //console.log(nombre)


    });


    $('#btn_enviar').click(function (e) {
        e.preventDefault();
       // $('#descripcion').val($('#des_retiro').val()); no hace falta
        $('#f_motivos').val($('#select_motivos').val());
        $('#btn_env_datos').trigger('click');




    });

    $('#form_datos').on('submit', function (event) {

        event.preventDefault();
        $.ajax({

            url: "{{ route('procesa/solicitud/retiro') }}",
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
                $('#tabla_solicitudes').DataTable().ajax.reload();
                toast.fire({
                        icon: 'success',
                        title: 'Solicitud procesada.'
                    })

            }
        });

    });

    $('body').on('click', '#btn_atras_M', function () {
        $('#div_matricula').toggle(1100);
        $('#div_formaciones').toggle(1000);

        $('#titulo').text('Formaciones')


    });










</script>
@endsection
