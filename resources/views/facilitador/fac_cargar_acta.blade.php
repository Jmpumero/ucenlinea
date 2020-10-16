@extends('layouts.admin')
@section('content')
<div id="_postulados" class="card table-responsive"  >
    <div class="card-header">
      <h3 id="titulo" class="card-title" style="margin-bottom: 3%">Formaciones</h3>


    </div>

    <div id="div_formaciones"  class="card-body" style="height: 400px" >

        <table id="tabla_formaciones" class="table  table-striped  projects text-center" style="width:100%">
            <thead>
                <tr>

                    <th class="text-center" style="width: 15%">
                        Formación
                    </th>
                    <th  style="width: 15%">
                        Nombre
                    </th>

                    <th style="width: 25%" class="text-center">
                       Empresa
                    </th>
                    <th  style="width: 15%" class="text-center" >
                        Acción
                    </th>


                </tr>
            </thead>





        </table>
    </div>



     <!-- Modal para importar el excel -->
     <div class="modal fade table-responsive"  id="modal_excel_act" role="dialog">
        <div id="modal_carga_act" class="modal-dialog modal-dialog-centered " >
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4>Carga de acta de culminacion</h4>
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
                       <input  hidden type="text" name="f_id" id="f_id" >

                </div>
               <!--para prueba-->
                  <!-- <form id="form_p" action="{{ url('pruebas/excel') }}" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label for="archivo"><b>Archivo: </b></label><br>
                    <input id="archivo_inputp" type="file" name="archivo" required>
                    <input hidden style="display: none" id="for_id" type="text" name="formacion" >
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



</div>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form_name
    $(document).ready(function() {


        var tabla_f= $('#tabla_formaciones').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('formaciones/actas/facilitador') }}",

            "columns": [
               // {data: 'id'},

                {data: 'imagen',orderable: false, searchable: false,'render' : function (data, type, row) {
                                //console.log("<img src={{ URL::to('/') }}/admilte" + data + " width='70' class='img-thumbnail' />")
                                //console.log(data)
                                return "<img src={{ URL::to('/') }}/" + data + " width='85' class='img-thumbnail' />"
                            }},
                {data: 'nombre_formacion'},
                {data: 'nombre_empresa'},
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
    //var formacion_id

//MODAL EXCEL
    $('body').on('click', '#btn_cargar', function (e) {
        e.preventDefault();
        $('#f_id').val($(this).data("id"));
        $('#modal_excel_act').modal('show');


    });






    $('#form_excel').on('submit', function (event) {

    event.preventDefault();


    $.ajax({

        url: "{{ route('facilitador/envia/actas') }}",
        method:"POST",
        //data:$(this).serialize(),
        data:new FormData(this), //obtines los input del form
        //dataType:"json",
        contentType: false, //importante enviar este parametro en false
        processData: false,//importante enviar este parametro en false
        success:function(data)
        {

            $('#archivo_input').val(''); //limpia el campo del archivo
            var newRows = "";



            if(data[0].status==500  ) //Mal/sin encabezado
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

            if(data[0].status==200) //Todo perfecto
            {
                //html = '<div class="alert alert-success">' + data.success + '</div>';

                $('#tabla_formaciones').DataTable().ajax.reload();

                const t= Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success btn-alert',

                        },
                        buttonsStyling: false
                    })


                t.fire({
                title: '!Acta cargada correctamente!',
                text: data.success,
                icon: 'success',
                confirmButtonText: 'Continuar',
                width: '35%',
                timerProgressBar:true,
                timer: 2500
                })


            }

            $('#btn_closed_m_excel').trigger('click'); //prueba
        }
    });

//$('#archivo_input').val('');
//$('#btn_closed_m_excel').trigger('click');
});






</script>
@endsection
