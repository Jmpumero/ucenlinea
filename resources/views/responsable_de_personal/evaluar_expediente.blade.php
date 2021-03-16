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
    <div class="card-body ">

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


@include('scripts.script_rp_evaluar_expediente') {{-- se invoca el script personalizado de la vista --}}

@endsection('content')


