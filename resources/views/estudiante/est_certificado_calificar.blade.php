@extends('layouts.admin')
@section('content')
<div id="_postulados" class="card table-responsive"  >
    <div class="card-header">
      <h3 id="titulo" class="card-title" style="margin-bottom: 3%">Certificados de formaciones</h3>


    </div>

    <div id="div_formaciones"  class="card-body" style="height: 400px" >


        <!-- no esta mal pero de momento no me sirve
        <div class="card card-outline card-blue">
            <div class="row">
                <div class="col-4 text-center " style="margin-top: 1%;">
                    <div class="card-img" style="margin-bottom: 1%">
                        <img src="{{ asset(Auth::user()->avatar) }}"  width=60  class="img-thumbnail" alt="User Image">

                    </div>
                </div>
                <div class="col-4" style="margin-right: 0%">
                  Segunda de tres columnas
                </div>
                <div class="col-4" style="margin-top: 2%;">
                    <div class="card text-center" style="margin-right: 3%">
                        <button  type="button" name="delete" id ="btn_eliminar_p2"    data-id="1" class="btn btn-outline-danger  btn-lg"><i class="fas fa-trash"  style="margin-right: 0.3rem;" ></i>Borrar</button>
                    </div>

                </div>
              </div>
        </div>

    -->

        <table id="tabla_formaciones" class="table  table-striped  projects text-center" style="width:100%">
            <thead>
                <tr>

                    <th class="text-center" style="width: 15%">
                        Formación
                    </th>
                    <th  style="width: 15%">
                        Nombre
                    </th>


                    <th  style="width: 15%" class="text-center" >
                        Acción
                    </th>


                </tr>
            </thead>







        </table>
    </div>




    <div id="div_evalua_formacion" class="card card-outline card-p1" style="display: none;" >
        <div class="row text-center">

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p2" style="margin-bottom: 1%">

                        <strong class="strong-msj">¿El contenido del curso cumple con tus expectativas?</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>
                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="rateYo"></p>
                </div>
            </div>

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p2" style="margin-bottom: 1%">

                        <strong class="strong-msj">Califique las herramientas tecnologicas y recursos educativos empleados en la formacion</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="rateYo2"></p>
                </div>
            </div>

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p2" style="margin-bottom: 1%">

                        <strong class="strong-msj">Evalúe la cantidad de material entregado:  para cubrir los objetivos y programa del curso.</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="rateYo3"></p>
                </div>
            </div>

            <!--<div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card" style="margin-bottom: 1%">

                        <strong class="strong-msj">Evalúe la dificultad del curso (1 - facil, 5 - muy dificil)</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="rateYo4"></p>
                </div>
            </div>-->

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p2" style="margin-bottom: 1%">

                        <strong class="strong-msj">Valore el nivel de aprendizaje conseguido durante el curso</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="rateYo5"></p>
                </div>
            </div>

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p2" style="margin-bottom: 1%">

                        <strong class="strong-msj">Califique globalmente este modelo de enseñanza (cursos de educación a distancia a través de Internet)</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="rateYo6"></p>
                </div>
            </div>



        </div>
        <div class="card-footer text-center">
            <button style="display: none" id="btn_continuar"  class="btn-lg btn-success" ><i class="far fa-thumbs-up" style="margin-right: 0.5rem"></i>Continuar </button>
        </div>

    </div>

    <div id="div_evalua_facilitador" class="card card-outline card-p1" style="display: none;" >
        <div class="row text-center">

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p3" style="margin-bottom: 1%">

                        <strong class="strong-msj">¿El profesor muestra dominio de la asignatura?</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>
                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="ratefacilitador"></p>
                </div>
            </div>

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p3" style="margin-bottom: 1%">

                        <strong class="strong-msj">Facilita la enseñanza considerando el aprendizaje previo de los alumnos </strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="ratefacilitador2"></p>
                </div>
            </div>

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p3" style="margin-bottom: 1%">

                        <strong class="strong-msj">Utiliza un lenguaje académico comprensible para los alumnos</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="ratefacilitador3"></p>
                </div>
            </div>

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p3" style="margin-bottom: 1%">

                        <strong class="strong-msj">¿Ha comunicado el material del curso de forma efectiva?</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="ratefacilitador4"></p>
                </div>
            </div>

            <div class="row col-12" style="margin-left: 0%">
                <div class="col-5 text-center " style="margin-top: 1%; margin-left: 1%;">
                    <div class="card card-outline card-p3" style="margin-bottom: 1%">

                        <strong class="strong-msj">¿Aclara las dudas sobre su materia?</strong>
                    </div>
                </div>
                <div class="col-2 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p > </p>
                </div>

                <div class="col-4 text-center"    style="margin-right: 1%; margin-top: 1%;">
                    <p id="ratefacilitador5"></p>
                </div>
            </div>


        </div>
        <div class="card-footer text-center">
            <button style="display: none" id="btn_continuar_f"  class="btn-lg btn-success" ><i class="far fa-thumbs-up" style="margin-right: 0.5rem"></i>Continuar </button>
        </div>

    </div>



</div>

<form hidden id="form_datos"  method="GET">
    {{ csrf_field() }}

    <!--<input type="text"  name="est_id" hidden id="est_id">-->
    <input type="text"  name="formacion_id" hidden id="formacion_id">
    <input type="text"  name="d_formacion" hidden id="d_formacion">
    <input type="text"  name="d_facilitador" hidden id="d_facilitador">

   <button hidden id="btn_env_datos" type="submit"></button>
</form>


<form hidden id="form_certificado" action="{{ route('certificado') }}" method="GET">
    {{ csrf_field() }}

    <!--<input type="text"  name="est_id" hidden id="est_id">-->
    <input type="text"  name="f_id" hidden id="f_id">
   <button hidden id="btn_env_f" type="submit"></button>
</form>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var total_valor_formacion=0;
    var cont_resp_form=0;
    var total_valor_facilitador=0;
    var cont_resp_facilitador=0;
    //var formacion_id;
    $(document).ready(function() {




        var tabla_f= $('#tabla_formaciones').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('est/formaciones/certificadas') }}",

            "columns": [
               // {data: 'id'},

                {data: 'imagen',orderable: false, searchable: false,'render' : function (data, type, row) {
                                //console.log("<img src={{ URL::to('/') }}/admilte" + data + " width='70' class='img-thumbnail' />")
                                //console.log(data)
                                return "<img src={{ URL::to('/') }}/" + data + " width='85' class='img-thumbnail' />"
                            }},
                {data: 'nombre'},
                //{data: 'nombre_empresa'},
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



// calificacion esta parte es sumamente inifeciente pero por falta tiempo... asi se queda

    $('body').on('click', '#btn_calificar', function (e) {
        e.preventDefault();

        $('#formacion_id').val($(this).data("id"));
       //console.log($(this).data("id"));
       //console.log( $('#formacion_id').val());
       // $('#f_id').val(formacion_id);


        $('#div_formaciones').toggle(1000);
        $('#div_evalua_formacion').toggle(1100);
        var nombre=$(this).data("nf");
        //console.log(nombre)

        //iniciacion  de las preguntas
        $("#rateYo").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f10000", //RED
                "endColor"  : "#f3dd1a",  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_formacion+=rating
                cont_resp_form++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_form==5) {
                    $('#btn_continuar').toggle(600);


                }
               // console.log(total_valor_formacion);
            }
        });

        $("#rateYo2").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f34141", //RED
                "endColor"  : "#f3dd1a"  //
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_formacion+=rating
                cont_resp_form++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_form==5) {
                    $('#btn_continuar').toggle(500);


                }
               // console.log(total_valor_formacion);
            }
        });

        $("#rateYo3").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f34141", //RED
                "endColor"  : "#f3dd1a"  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_formacion+=rating
                cont_resp_form++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_form==5) {
                    $('#btn_continuar').toggle(500);


                }
               // console.log(total_valor_formacion);
            }
        });


        $("#rateYo5").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f34141", //RED
                "endColor"  : "#f3dd1a"  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_formacion+=rating
                cont_resp_form++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_form==5) {
                    $('#btn_continuar').toggle(500);


                }
               // console.log(total_valor_formacion);
            }
        });

        $("#rateYo6").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f34141", //RED
                "endColor"  : "#f3dd1a"  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_formacion+=rating
                cont_resp_form++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_form==5) {
                    $('#btn_continuar').toggle(500);


                }
               // console.log(total_valor_formacion);
            }
        });
        //


    });


    $('#btn_continuar').click(function (e) {
        e.preventDefault();
        $('#div_evalua_formacion').toggle(500);
        $('#div_evalua_facilitador').toggle(500);

        $("#ratefacilitador").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f10000", //RED
                "endColor"  : "#f3dd1a"  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_facilitador+=rating
                cont_resp_facilitador++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_facilitador==5) {
                    $('#btn_continuar_f').toggle(600);


                }
                //console.log('gg'+total_valor_facilitador);
            }
        });

        $("#ratefacilitador2").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f10000", //RED
                "endColor"  : "#f3dd1a"  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_facilitador+=rating
                cont_resp_facilitador++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_facilitador==5) {
                    $('#btn_continuar_f').toggle(600);


                }
                //console.log('gg'+total_valor_facilitador);
            }
        });

        $("#ratefacilitador3").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f10000", //RED
                "endColor"  : "#f3dd1a"  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_facilitador+=rating
                cont_resp_facilitador++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_facilitador==5) {
                    $('#btn_continuar_f').toggle(600);


                }
                //console.log('gg'+total_valor_facilitador);
            }
        });

        $("#ratefacilitador4").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f10000", //RED
                "endColor"  : "#f3dd1a"  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_facilitador+=rating
                cont_resp_facilitador++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_facilitador==5) {
                    $('#btn_continuar_f').toggle(600);


                }
                //console.log('gg'+total_valor_facilitador);
            }
        });

        $("#ratefacilitador5").rateYo({
            halfStar: true,
            rating: 0.0,
            readOnly:false,
            multiColor: {
                "startColor": "#f10000", //RED
                "endColor"  : "#f3dd1a"  //GREEN
                },

            onSet: function (rating, rateYoInstance) {
                $(this).closest('.row').toggle(700);
                total_valor_facilitador+=rating
                cont_resp_facilitador++
               // $("#rateYo").rateYo("option", "readOnly", true);
                if (cont_resp_facilitador==5) {
                    $('#btn_continuar_f').toggle(600);


                }
                //console.log('gg'+total_valor_facilitador);
            }
        });


    });

    $('#btn_continuar_f').click(function (e) {
        e.preventDefault();
        $('#d_formacion').val(total_valor_formacion/5);
        $('#d_facilitador').val(total_valor_facilitador/5);

        //console.log($('#d_formacion').val());
        //console.log($('#d_facilitador').val());
        //console.log($('#formacion_id').val())
        total_valor_formacion=0;
        cont_resp_form=0;
        total_valor_facilitador=0;
        cont_resp_facilitador=0;
        $('#btn_env_datos').trigger('click');

    });

    $('#form_datos').on('submit', function (event) {

        event.preventDefault();
        $.ajax({

            url: "{{ route('est/califica/formacion') }}",
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
                $('#div_evalua_facilitador').toggle(800);
                $('#div_formaciones').toggle(900);
                $('#d_formacion').val('');
                $('#d_facilitador').val('');
                $('#formacion_id').val('');
                $('#tabla_formaciones').DataTable().ajax.reload();
                toast.fire({
                        icon: 'success',
                        title: 'Puntuacion Finalizada.'
                    })

            }
        });

    });


//fin calificacion

//ver certificado
    $('body').on('click', '#btn_ver_c', function (e) {
        e.preventDefault();
        $('#f_id').val($(this).data("id"));
        $('#btn_env_f').trigger('click');
        //console.log($('#f_id').val())
    });

    $('#form_certificado').on('sumit', function () {
        console.log('submit')

    });

//



    $('body').on('click', '#btn_atras_M', function () {
        $('#div_matricula').toggle(1100);
        $('#div_formaciones').toggle(1000);

        $('#titulo').text('Formaciones')


    });










</script>
@endsection
