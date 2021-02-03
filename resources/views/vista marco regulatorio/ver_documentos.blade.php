@extends('layouts.admin')

@section('content')



<div class="card">
        <div class="card-header">
            <h3 class="card-title"> <strong> Documentos del Marco Regulatorio</strong>  </h3>

        </div>
        @foreach ($datos as $item)


            @foreach ($item as $value)

                @if ($value!=[])
                    @php //dump($value[0]);
                     //dump($value[0]['rol']);
                    @endphp

                     <div style="margin-top: 2%">
                        @switch($value[0]['rol'])

                            @case('Responsable de Personal')
                                <span class=" badge badge-success" style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                                @break

                            @case('Responsable de Control de Estudio')
                                <span class=" badge badge-morado" style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Proveedor')
                                <span class=" badge badge-oro2" style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Facilitador')
                                <span class=" badge badge-verde-oscuro" style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Estudiante')
                                <span class=" badge badge-info" style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Supervisor')
                                <span class=" badge badge-primary" style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Responsable de Contenido')
                                <span class=" badge badge-secondary" style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Responsable Administrativo')
                                <span class=" badge badge-fabulous style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Responsable de TI')
                                <span class=" badge badge-dark style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Responsable Academico')
                                <span class=" badge badge-ver-azul style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                            @case('Admin')
                                <span class=" badge badge-naranja style="font-size: 100%" > {{$value[0]['rol']  }} </span>
                            @break

                        @endswitch

                         <div style="margin-left: 1%; margin-top:1%;" class="container" data-aos="fade-up">

                            <div class="row" data-aos="zoom-in" data-aos-delay="100">

                                @foreach ($value as $documento)

                                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                        <div class="member">
                                        <img src="{{ asset('adminlte/img/1pdf.png') }}" class="img-fluid" alt="" width="75"  href="{{ Storage::response($documento['ruta']) }}">

                                        <div class="member-content">
                                            <h4> <a href="{{ URL::to( 'descargar/documento/' . $documento['nombre_rol'])  }}" target="_blank">{{ $documento['nombre'] }}</a></h4>



                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endif

            @endforeach



        @endforeach
</div>



    <!-- /.card-body -->


  <form hidden id="form_borrar" method="GET">
    {{ csrf_field() }}
    <input type="text"  name="f_id_bp" hidden id="f_id_ev">
    <input type="text"  name="user_id_bp" hidden id="user_id_ev">
    <button hidden id="btn_form_borrar" type="submit"></button>
    </form>






  <script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            //console.log('X-CSRF-TOKEN');
        }
    });

    $(document).ready(function () {
       //$('img').EZView();


    });




  </script>
  @endsection('content')
