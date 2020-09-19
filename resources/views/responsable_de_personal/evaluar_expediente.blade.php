@extends('layouts.admin')

@section('content')



<div class="card">
    <div class="card-header">
      <h3 class="card-title">Lista de Postulado</h3>

      <div class="card-tools">

            <button  type="button" id="btn_deleted_all" class="btn  btn-outline-danger" style="width: 100%;" data-toggle="tooltip"  data-form="{{ $formacion }}" title="" > <i class="fas fa-trash"  style="margin-right: 0.5rem;" ></i>Borrar Lista</button>

      </div>
       {{--@php dump($results); @endphp
       @php dump($formacion); @endphp--}}
    </div>
    <div class="card-body p-0">
        <div class="card table-responsive-md" style="height: 384px">
            <table id="table_ev" class="table table-striped table-responsive" style="height: 300px">
                <thead>
                    <tr>
                        <th >
                            C.I
                        </th>
                        <th class="text-center">
                            Nombre
                        </th>
                        <th class="text-center" >
                             Cursos realizados
                        </th>
                        <th class="text-center" >
                            Cursos finalizados
                        </th>
                        <th class="text-center">
                            Cursos abandonados
                        </th>
                        <th class="text-center">
                            Fecha ultimo curso
                        </th>
                        <th>
                            Acción
                        </th>






                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $item)
                    <tr >
                        <td class="text-center">
                            {{ $item['ci'] }}
                        </td>
                        <td >
                          {{ $item['nombre'] }}
                        </td>

                        <td class="text-center">
                          <span class="badge  badge-pill-new badge-morado">{{ $item['total_cursos'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-pill-new badge-success">{{ $item['cursos_ap'] }}</span>
                        </td>
                        <td class="text-center">

                          <span class="badge badge-pill-new badge-danger">{{ $item['cursos_ab'] }}</span>
                        </td>
                        <td class="text-center">
                            <strong> {{ $item['ult_curso'] }}</strong>
                        </td>
                        <td class="text-center" >
                            <button type="button" name="delete" id ="btn_eliminar_p2"    data-id="{{ $item['id'] }}" class="btn btn-outline-danger  btn-sm"><i class="fas fa-trash"  style="margin-right: 0.3rem;" ></i>Borrar</button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
    <!-- /.card-body -->
  </div>

  <form hidden id="form_borrar" method="GET">
    {{ csrf_field() }}
    <input type="text"  name="f_id_bp" hidden id="f_id_ev">
    <input type="text"  name="user_id_bp" hidden id="user_id_ev">
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
    var table
    $(document).ready(function () {

         table=$('#table_ev').DataTable({

            "responsive": true,
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

        });

    });

    $('body').on('click', '#btn_eliminar_p2', function () {

        //console.log($(this).parents('tr'))


        var p_id = $(this).data("id");
        var f_id=$('#btn_deleted_all').data("form");

        $('#f_id_ev').val(f_id);
        $('#user_id_ev').val($(this).data("id"));
        $('#btn_form_borrar').trigger('click');
        table .row( $(this).parents('tr') ).remove().draw();

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

                toast.fire({
                        icon: 'success',
                        title: 'Postulado Eliminado.'
                    })

            }
        });

    });
//Borrar todo
    $('#btn_deleted_all').click(function (e) {
        e.preventDefault();
        var f_id=$(this).data("form");
        var toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2800
            });
        if (table.rows().count()>0) {

            $('#f_id_dall').val(f_id);
            table .rows().remove().draw();
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

                    toast.fire({
                            icon: 'success',
                            title: 'Postulados Eliminados.'
                        })

                }
            });

        });



  </script>
  @endsection('content')
