@extends('layouts.admin')
@section('content')
<div id="_postulados" class="card table-responsive"  >
    <div class="card-header">
      <h3 id="titulo" class="card-title" style="margin-bottom: 3%">Formaciones</h3>


    </div>

    <div id="div_formaciones"  class="card-body" style="height: 400px" >



        <table id="tabla_user" class="table  table-striped  projects text-center" style="width:100%">
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
                        Retirar
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


        var tabla_postulados= $('#tabla_user').DataTable({
                "destroy":true,
                "responsive": true,
                //"deferRender":  true,
                //"scroller":     true,
                //"searching": false,
                "serverSide": true,
                "processing": true,
                "ajax": "{{ route('tabla/retiro/estudiantes/uvc') }}",

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





    $('body').on('click', '#btn_retirar', function (e) {
        e.preventDefault();

        //$('#formacion_id').val($(this).data("f"));
        //$('#p_id').val($(this).data("uid"));


        $.ajax({

            url: "{{ route('rp/enviar/datos/retiro/uvc') }}",
            method:"GET",
            data: {
                "user_id": $(this).data("id"),
                "formacion_id": $(this).data("f"),
                },
            //data:$(this).serialize(),
            //dataType:"json",
            success:function(data)
            {

                $('#tabla_user').DataTable().ajax.reload();
                var toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });



                toast.fire({
                        icon: 'success',
                        title: 'Estudiante desmatriculado.'
                    })

            }
               /* var hmtl = '';
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
                $('#div_motivos').html(html);*/
                //console.log(html);



        });
        //console.log(nombre)


    });











</script>
@endsection
