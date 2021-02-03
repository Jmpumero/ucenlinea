@extends('layouts.admin')

@section('content')



<div class="card">
    <div class="card-header">
      <h3 class="card-title">Complete el formulario</h3>

      <div class="card-tools">


      </div>
       {{--@php dump($results); @endphp
       @php dump($formacion); @endphp--}}
    </div>


            <!-- /.card-header -->
            <!-- form start -->
            <form id="form_documento" method="POST"  accept-charset="UTF-8" enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="card-body">
              
                <div class="form-group">
                  <label for="rol">Rol</label>
                  <select name="rol" id="select_roles" class="select2-purple" data-placeholder="Seleccione un Rol" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option></option>
                    @foreach ($roles as $item)
                        <option>{{ $item->name }}</option>
                    @endforeach


                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Documento</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="exampleInputFile" name="archivo" required>
                      <label class="custom-file-label" for="exampleInputFile">Elige un documento</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text" id=""></span>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer text-center">
                <button type="submit"  id="btn_env" class="btn btn-outline-success">Guardar</button>
              </div>
            </form>
          </div>

    <!-- /.card-body -->


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

    $(document).ready(function () {
        $('#select_roles').select2()


    });

    //envia excel
    $('#form_documento').on('submit', function (event) {

    event.preventDefault();


    $.ajax({

        url: "{{ route('guardar/doc') }}",
        method:"POST",

        data:new FormData(this), //obtines los input del form 100%
        //dataType:"json",
        contentType: false, //importante enviar este parametro en false
        processData: false,//importante enviar este parametro en false
        success:function(data)
        {

            $('#archivo_input').val(''); //limpia el campo del archivo


            console.log(data)
            if(data[0].status==450  ) //Mal/sin encabezado
            {

                const t= Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success btn-alert',

                        },
                        buttonsStyling: true
                    })


                t.fire({
                title: '!ERROR !',
                text: data[1].error,
                icon: 'error',
                confirmButtonText: 'Continuar',
                width: '35%',
                timerProgressBar:true,

                })

            }


            if(data[0].status==200) //Todo perfecto
            {
                //html = '<div class="alert alert-success">' + data.success + '</div>';
                //$('#form_new_postu')[0].reset();


                const t= Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success btn-alert',

                        },
                        buttonsStyling: false
                    })


                t.fire({
                title: '!Guardado correctamente!',
                //text: data.success,
                icon: 'success',
                confirmButtonText: 'Continuar',
                width: '35%',
                timerProgressBar:true,
                //timer: 2500
                })


            }


        }
});

//$('#archivo_input').val('');
//$('#btn_closed_m_excel').trigger('click');
});


  </script>
  @endsection('content')
