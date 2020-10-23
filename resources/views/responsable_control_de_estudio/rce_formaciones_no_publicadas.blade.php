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
                       Fecha de inicio
                    </th>
                    <th  style="width: 15%" class="text-center" >
                        Publicar
                    </th>


                </tr>
            </thead>



        </table>
    </div>











    <form hidden id="form_datos"  method="GET">
        {{ csrf_field() }}

        <!--<input type="text"  name="est_id" hidden id="est_id">-->
        <input type="text"  name="user_id" hidden id="user_id">
        <input type="text"  name="d_postulado" hidden id="d_postulado">
        <input type="text"  name="f_id" hidden id="f_id">

       <button hidden id="btn_env_datos" type="submit"></button>
    </form>



</div>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready(function() {


        var tabla_f= $('#tabla_formaciones').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('formaciones/sinpublicar') }}",

            "columns": [
               // {data: 'id'},

                {data: 'imagen',orderable: false, searchable: false,'render' : function (data, type, row) {
                                //console.log("<img src={{ URL::to('/') }}/admilte" + data + " width='70' class='img-thumbnail' />")
                                //console.log(data)
                                return "<img src={{ URL::to('/') }}/" + data + " width='85' class='img-thumbnail' />"
                            }},
                {data: 'nombre'},
                {data: 'fecha_de_inicio'},
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



    $('body').on('click', '#btn_publicar', function (e) {
        e.preventDefault();

       var formacion_id=$(this).data("id");
       //console.log(formacion_id);
        console.log(formacion_id)


        $.ajax({

            url: "{{ route('publicar') }}",
            method:"GET",
            data: {
                "f_id": $(this).data("id"),
                //"formacion_id": $(this).data("f"),
                },
            success:function(data)
            {
                var toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2800
                });

                $('#tabla_formaciones').DataTable().ajax.reload();
                toast.fire({
                        icon: 'success',
                        title: 'Formacion Publicada.'
                    })

            }
            });









    });



</script>
@endsection
