@extends('layouts.admin')

@section('content')

        <!-- esto fue una prueba para usar ajax
            <div class="card card-notificacion">
            <div class="card-header">ajax sin collective</div>

            <div class="card-body">

                <form action="" method="get">
                    <select name="formaciones[]" id="formaciones"  style="width: 50%" >
                        <option></option>
                    </select>
                </form>


            </div>
        </div>
        -->
        <div class="card card-notificacion">
            <div class="card-header">forma simple sin ajax</div>

            <div class="card-body">

               {!! Form::open() !!}
               {!! Form::select('formas', $formaciones_list ?? [], null, ['id'=>'formas','placeholder' => '','style'=>'width: 50%']) !!}

               {!! Form::close() !!}

            </div>
        </div>









<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            //console.log('X-CSRF-TOKEN');
        }
    });

    $(document).ready(function() {
        /*$('#formaciones').select2({ //version con ajax (en este caso no es necesaria)
            placeholder:"Elige una formacion",
            theme: "classic",
            minimumResultsForSearch: Infinity, //para ocultar el search que en seste caso no hace falta
            //tags: true,
            //tokenSeparators: [','],
            ajax: {
                url: "{{ route('select/formacion') }}" ,
                dataType: 'json',
                delay: 250,
                data: function (params) {//en esta parte va el parmetro que se envia por medio de la request
                    return {
                        nombre: $.trim(params.term)
                    };
                },

                processResults: function(data)
                {
                    //console.log(data)

                    return {
                        results: data
                    };
                },
                cache: true

            }
        });*/


        $('#formas').select2({
            placeholder:"Elige una formacion",
            theme:"classic"
        });

    });


      //theme: "classic",
      //templateResult: formatState
      // templateSelection: formatState



</script>
@endsection
