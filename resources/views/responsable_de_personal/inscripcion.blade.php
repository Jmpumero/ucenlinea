@extends('layouts.admin')

@section('content')

        <div class="card card-notificacion">
            <div class="card-header">Seleccione una formación:</div>

            <div class="card-body">

                <form action="" method="get">
                    <select name="formaciones[]" id="formaciones"  style="width: 50%" >
                        <option></option>
                    </select>
                </form>
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
        $('#formaciones').select2({
            placeholder:"Elige una formacion",
            minimumResultsForSearch: Infinity, //para ocultar el searh que en seste caso no hace falta
            //tags: true,
            //tokenSeparators: [','],
            ajax: {
                url: "{{ route('select/formacion') }}" ,
                dataType: 'json',
                delay: 250,
                /*data: function (params) {
                    /*return {
                        q: $.trim(params.term)
                    };
                },*/

                processResults: function(data)
                {
                    //console.log(data)

                    return {
                        results: data
                    };
                },
                cache: true

            }
        });
    });


</script>
@endsection
