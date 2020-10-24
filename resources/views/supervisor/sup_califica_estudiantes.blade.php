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
                       Fecha de culminacion
                    </th>
                    <th  style="width: 15%" class="text-center" >
                        Acción
                    </th>


                </tr>
            </thead>



        </table>
    </div>



    <div  id="div_matricula"  class="card-body" style="display: none;" >

        <table id="tabla_matricula" class="table  table-striped  projects text-center" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15%">
                        CI
                    </th>
                    <th  style="width: 25%">
                        Nombre
                    </th>

                    <th style="width: 25%" class="text-center">
                        Correo
                    </th>


                    <th style="width: 15%" class="text-center">
                        Calificar
                    </th>



                </tr>
            </thead>





        </table>
        <div class="card-footer">
            <button id="btn_atras_M"  class="btn btn-outline-primary" ><i class="fas fa-arrow-alt-circle-left fa-2x"></i> </button>
        </div>
    </div>






    <div id="div_evalua_postulado" class="card card-outline card-p1" style="display: none;" >
        <div class="row text-center">



                <div id="test" class="row col-12" style="margin-left: 0%" >

                <div class="col-5 text-center " data-aos="zoom-in" style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p3" style="margin-bottom: 1%">

                        <strong id="msj" class="strong-msj">.</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>
                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="rate_postulado"></p>
                </div>

            </div>



        </div>
        <div class="card-footer text-center">
            <button style="display: none" id="btn_continuar"  class="btn-lg btn-success" ><i class="far fa-adwar" style="margin-right: 0.5rem"></i>Calificar </button>
        </div>

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

    var form_name
    var band=true;
    var preguntas = ["Califique el desempeño laboral del postulado", "Que tan efectivo es el postulado en la empresa"," ¿Considera que el postulado logró asimilar el contenido de la formacion?","El postulado aplica lo aprendido en la formacion"];
    var i=0;
    var cont_resp=0;
    var total_valor=0;
    $(document).ready(function() {


        var tabla_f= $('#tabla_formaciones').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('sup/tabla/formaciones/disponibles') }}",

            "columns": [
               // {data: 'id'},

                {data: 'imagen',orderable: false, searchable: false,'render' : function (data, type, row) {
                                //console.log("<img src={{ URL::to('/') }}/admilte" + data + " width='70' class='img-thumbnail' />")
                                //console.log(data)
                                return "<img src={{ URL::to('/') }}/" + data + " width='85' class='img-thumbnail' />"
                            }},
                {data: 'nombre'},
                {data: 'fecha_de_culminacion'},
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




    $('body').on('click', '#btn_ver_m', function (e) {
        e.preventDefault();

       var formacion_id=$(this).data("id");
       //console.log(formacion_id);
        $('#f_id').val(formacion_id);


        $('#div_formaciones').toggle(1000);
        $('#div_matricula').toggle(1100);

        console.log(formacion_id)


        //nombre=nombre.replace(regex,'') //limpiamos la cadena
        $('#titulo').text('Formas de descarga')


        //$('#btn_form_ev').trigger('click');
        //console.log()






        var tabla_m= $('#tabla_matricula').DataTable({
            //console.log(formacion_id);
            "destroy":true,
            "paging": false, //muy necesario(ya que se usa ajax) para que exporte todos los usuario
            "responsive": true,
            "autoWidth": true,
            "searching": false,
            "serverSide": true,
            "processing": true,


            "ajax": {
                    'url': "{{route('sup/tabla/postulados')}}",
                    'type': "GET",
                    'data': { 'f_id': formacion_id},
                    //'dataSrc': 'history'
                },

            "columns": [
                {data: 'ci'},
                {data: 'name'},
                {data: 'email'},
                {data: 'action', name: 'btn', orderable: false, searchable: false},
               // { "defaultContent": "" }, //agrega una columna vacia
                //{data: 'id',"visible": false},

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

    $('body').on('click', '#btn_atras_M', function () {
        $('#div_matricula').toggle(1100);
        $('#div_formaciones').toggle(1000);

        $('#titulo').text('Formaciones')


    });




    $('body').on('click', '#btn_calificar', function (e) {
        e.preventDefault();

        $('#user_id').val($(this).data("id"));
       //console.log($(this).data("id"));
       //console.log( $('#formacion_id').val());
       // $('#f_id').val(formacion_id);

        if (band) {
            $('#div_matricula').toggle(1000);
            $('#div_evalua_postulado').toggle(1100);

        }else{
            $("#rate_postulado").rateYo("destroy");
            $('#test').toggle(800);

        }

        $('#msj').text(preguntas[cont_resp]);

        //iniciacion  de las preguntas
        $("#rate_postulado").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f10000", //RED
                "endColor"  : "#f3dd1a",  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(300);
                band=false;
                total_valor+=rating
                cont_resp++

                //console.log(preguntas[cont_resp])
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp==preguntas.length) {
                    $('#btn_continuar').toggle(600);


                }else{
                    $('#btn_calificar').trigger('click');
                }
               // console.log(total_valor_formacion);
            }
        });


        //


    });




    $('#btn_continuar').click(function (e) {
        e.preventDefault();
        $('#d_postulado').val(total_valor /preguntas.length);
        $('#btn_continuar').fadeOut();
        $('#div_evalua_postulado').fadeOut();
        $('#test').fadeIn();
        $("#rate_postulado").rateYo("destroy");
        total_valor=0;
        cont_resp=0;

        $('#btn_env_datos').trigger('click');

    });


    $('#form_datos').on('submit', function (event) {
        //console.log('hola')
        event.preventDefault();
        $.ajax({

            url: "{{ route('sup/califica/postulado') }}",
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
                //$('#div_evalua_facilitador').toggle(800);
                band=true;
                $('#div_formaciones').toggle(800);
                $('#d_postulado').val('');
                $('#user_id').val('');
                $('#tabla_formaciones').DataTable().ajax.reload();
                toast.fire({
                        icon: 'success',
                        title: 'Puntuacion Finalizada.'
                    })

            }
        });

    });





</script>
@endsection
