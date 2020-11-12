@extends('layouts.admin')
@section('content')
<div id="_postulados" class="card table-responsive"  >
    <div class="card-header">
      <h3 class="card-title" style="margin-bottom: 3%">Formaciones pendientes por matricular</h3>


    </div>
    <div   class="card-body" style="height: 400px" >

        <table id="tabla_formaciones" class="table  table-striped table-responsive projects text-center">
            <thead>
                <tr>
                    <th class="text-center" style="width: 15%">
                        ID
                    </th>
                    <th style="width: 15%">
                        Nombre
                    </th>

                    <th  style="width: 15%" class="text-center" >
                        Matricula actual
                    </th>
                    <th style="width: 15%" class="text-center">
                        Fecha de Inicio
                    </th>
                    <th style="width: 15%" class="text-center">
                     Acción
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



<div class="modal fade table-responsive"  id="modal_enroll" role="dialog">
    <div id="modal_matricula" class="modal-dialog modal-dialog-centered modal-lg" >
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
              <h4>Selecion de Facilitador</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>

            </div>

            <!-- Modal Body -->
            <form  id="form_facilitador"  >
                {{ csrf_field() }}
        <div class="modal-body">
            <p class="statusMsg"></p>
            <h5 id="tabla_titulo"></h5>

            <input type="text"  name="f_id" hidden id="f_id">
            <!--cCON SELECT2-->


            <!--- tabla postulado, pendiente con el tema de muchos usurios-->
            <div id="card_facilitadores" class=" card card-outline card-blue table-responsive-sm"  >
                <div   class="card-body  table-responsive" style="height: 363px"  >



                    <table id="select_facilitadores" class="table table-striped table-responsive-sm text-center" style="height: 245px" >

                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    Seleccionar
                                </th>
                                <th class="text-center" style="width: 10%">
                                    ID
                                </th>
                                <th style="width: 10%">
                                    Facilitador
                                </th>


                                <th style="width: 20%" class="text-center">
                                    Resumen
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>





        </div>

        <!-- Modal Footer -->
            <div class="modal-footer">
                <button id="btn_closed_m" type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>


                    <button  id="btn_form_facilitador" class="btn btn-outline-success" type="submit">Procesar</button>
                </form>

                </div>

            </div>
        </div>
    </div>
    </div>

    <!-- FIN modal agregar un postulado -->







<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        var tabla_f= $('#tabla_formaciones').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('matricular/estudiantes') }}",

            "columns": [
                {data: 'id'},
                {data: 'nombre'},
                {data: 'actual_matricula'},
                {data: 'fecha_de_inicio'},
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
    var formacion_id
    $('body').on('click', '#btn_enroll', function (e) {
        e.preventDefault();
        $('#modal_enroll').modal('show');
        formacion_id=$(this).data("id");
        $('#f_id').val(formacion_id);

        var tabla_facilitadores= $('#select_facilitadores').DataTable({

            "destroy":true,
            "responsive": true,
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('Mdl.facilitadores') }}",
            /*'columnDefs': [{
                'targets': 0,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
                }],*/

            "columns": [
                {data: 'id',orderable: false,searchable: false,'render' : function (data, type, row) {
                    //console.log(data)
                    return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';

                 }},

                {data: 'id'},
                {data: 'name'},
                {data: 'resumen'},
                //{data: 'action', name: 'btn', orderable: false},
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
                "infoEmpty": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoFiltered": ""
            }
            });
        });



    $('#form_facilitador').on('submit', function (e) {
       e.preventDefault();
        //console.log('enviando')
        //console.log($(this).serialize())
        console.log($("input:checkbox:checked").length)
        if (($("input:checkbox:checked").length)>0) {

            $.ajax({

                url: "{{ route('Mdl.matricular') }}",
                method:"GET",
                data:$(this).serialize(),
                //dataType:"json",

                success:function(data){

                    if(data[0].status==200) //Todo perfecto
                    {
                        $('#tabla_formaciones').DataTable().ajax.reload();
                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: false
                            })

                            $('#btn_closed_m').trigger('click');
                        t.fire({
                        title: '!Matriculado correctamente!',
                        text: data[1].msj,
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        width: '35%',
                        timerProgressBar:true,
                        timer: 2500
                        })


                    }

                    if(data[0].status==500  ) //Mal/sin encabezado
                    {

                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: true
                            })


                        t.fire({
                        title: '!ERROR !',
                        text: data[1].msj,
                        icon: 'error',
                        confirmButtonText: 'Continuar',
                        width: '35%',
                        timerProgressBar:true,

                        })

                    }

                }

            });

        }else{
            const t= Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success btn-alert',

                        },
                        buttonsStyling: true
                    })


                t.fire({
                title: 'Seleccione  uno o mas Facilitador(es)',
                //text: data[1].msj,
                icon: 'error',
                confirmButtonText: 'Continuar',
                width: '35%',
                timerProgressBar:true,

                })
        }
        /*
       $.ajax({

        url: "{{ route('Mdl.matricular') }}",
        method:"GET",
        data:$(this).serialize(),
        //dataType:"json",

        success:function(data){
            if(data[0].status==200) //Todo perfecto
            {
                $('#tabla_formaciones').DataTable().ajax.reload();
                const t= Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success btn-alert',

                        },
                        buttonsStyling: false
                    })


                t.fire({
                title: '!Matriculado correctamente!',
                text: data[1].msj,
                icon: 'success',
                confirmButtonText: 'Continuar',
                width: '35%',
                timerProgressBar:true,
                timer: 2500
                })


            }

            if(data[0].status==500  ) //Mal/sin encabezado
            {

                const t= Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-success btn-alert',

                        },
                        buttonsStyling: true
                    })


                t.fire({
                title: '!ERROR !',
                text: data[1].msj,
                icon: 'error',
                confirmButtonText: 'Continuar',
                width: '35%',
                timerProgressBar:true,

                })

            }

        }

    });
    */
   });
        //probando los check
    $(document).on('change','input[type="checkbox"]' ,function(e) {
    if(this.checked){
        //console.log($(this.value))
       // console.log($(this).val())
        //$('#id_fiscal').val(this.value);
    } //else $('#id_fiscal').val("");
    });


</script>
@endsection
