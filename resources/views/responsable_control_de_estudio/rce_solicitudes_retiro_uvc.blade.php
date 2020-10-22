@extends('layouts.admin')
@section('content')
<div id="_postulados" class="card table-responsive"  >
    <div class="card-header">
      <h3 id="titulo" class="card-title" style="margin-bottom: 3%">Formaciones</h3>


    </div>

    <div id="div_formaciones"  class="card-body" style="height: 400px" >



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
            "ajax": "{{ route('tabla/solicitud/retiro/uvc') }}",

            "columns": [
               // {data: 'id'},

                {data: 'avatar',orderable: false, searchable: false,'render' : function (data, type, row) {
                                //console.log("<img src={{ URL::to('/') }}/admilte" + data + " width='70' class='img-thumbnail' />")
                                //console.log(data)
                                return "<img src={{ URL::to('/') }}/" + data + " width='65' class='img-thumbnail' />"
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





    $('body').on('click', '#btn_retirar', function (e) {
        e.preventDefault();

        //$('#formacion_id').val($(this).data("f"));
        //$('#p_id').val($(this).data("uid"));


        $.ajax({

            url: "{{ route('procesar/solicitud/retiro/uvc') }}",
            method:"GET",
            data: {
                "user_id": $(this).data("id"),
                //"formacion_id": $(this).data("f"),
                },
            //data:$(this).serialize(),
            //dataType:"json",
            success:function(data)
            {

                $('#tabla_solicitudes').DataTable().ajax.reload();
                var toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });



                toast.fire({
                        icon: 'success',
                        title: 'Solicitud Procesada.'
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
