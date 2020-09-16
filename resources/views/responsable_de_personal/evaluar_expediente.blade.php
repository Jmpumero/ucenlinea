@extends('layouts.admin')

@section('content')



<div class="card">
    <div class="card-header">
      <h3 class="card-title">Lista de Candidatos</h3>




      <div class="card-tools">
        <button type="button" class="btn btn-morado"  data-toggle="tooltip" title="Evaluar">
          <i class="fas fa-clipboard-check icon-mg-sm"></i>Inscribir todos</button>
      </div>

      {{-- @phpdump($results);@endphp --}}
    </div>
    <div class="card-body p-0">
        <div class="card table-responsive-md" style="height: 300px">
            <table id="table_ev" class="table table-striped table-responsive" style="height: 300px">
                <thead>
                    <tr>
                        <th >
                            C.I
                        </th>
                        <th >
                            Nombre
                        </th>

                        <th  >
                             Cursos realizados
                        </th>
                        <th >
                            Cursos finalizados
                        </th>
                        <th>
                            Cursos abandonados
                        </th>
                        <th>
                            Fecha ultimo curso F
                        </th>
                        <th>
                            Acción
                        </th>






                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $item)
                    <tr>
                        <td class="text-center">
                            {{ $item['ci'] }}
                        </td>
                        <td >
                          {{ $item['nombre'] }}
                        </td>

                        <td class="text-center">
                          <span class="badge badge-info">{{ $item['total_cursos'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $item['cursos_ap'] }}</span>
                        </td>
                        <td class="text-center">

                          <span class="badge badge-danger">{{ $item['cursos_ab'] }}</span>
                        </td>
                        <td class="text-center">
                            {{ $item['ult_curso'] }}
                        </td>
                        <td class="text-center" >
                            <button type="button" name="delete" id ="btn_eliminar_p2"    data-id="{{ $item['id'] }}" class="btn-eliminar btn btn-danger btn-sm"><i class="fas fa-trash"  style="margin-right: 0.5rem;" ></i>Borrar</button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
    <!-- /.card-body -->
  </div>
  @endsection('content')
