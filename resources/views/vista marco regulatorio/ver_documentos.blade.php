@extends('layouts.admin')

@section('content')



<div class="card">
        <div class="card-header">
            <h3 class="card-title"></h3>

        </div>
        @foreach ($datos as $item)


            @foreach ($item as $value)

                @if ($value!=[])
                    @php //dump($value[0]);
                     //dump($value[0]['rol']);
                    @endphp

                     <div>
                        @if ($value[0]['rol']=='Supervisor')
                         <span class=" badge badge-primary" > {{$value[0]['rol']  }} </span>
                        @endif
                         <div class="container" data-aos="fade-up">

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
       $('img').EZView();


    });




  </script>
  @endsection('content')
