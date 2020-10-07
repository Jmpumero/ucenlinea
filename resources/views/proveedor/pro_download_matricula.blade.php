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
                        Fecha de Inicio
                    </th>
                    <th  style="width: 15%" class="text-center" >
                        Matricula
                    </th>


                </tr>
            </thead>





        </table>
    </div>



    <div  id="div_matricula"  class="card-body" style="height: 400px; display: none;" >

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
                    <th  style="width: 15%" class="text-center" >
                        Rol
                    </th>





                </tr>
            </thead>





        </table>
        <div class="card-footer">
            <button id="btn_atras_M"  class="btn btn-outline-primary" ><i class="fas fa-arrow-alt-circle-left fa-2x"></i> </button>
        </div>
    </div>



<form hidden action="{{ url('matricula/externa') }}">
    {{ csrf_field() }}
    <input type="text"  name="for_id" hidden id="f_id">

    <input type="text"  name="user_id" hidden id="user_id" value="{{ Auth::user()->id }}">
    <button hidden id="btn_form_ev" type="submit"></button>
</form>



</div>



<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var form_name
    $(document).ready(function() {


        var tabla_f= $('#tabla_formaciones').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('formaciones/m/externa') }}",

            "columns": [
               //de momento no la uso {data: 'id'},

                {data: 'imagen',orderable: false, searchable: false,'render' : function (data, type, row) {
                                //console.log("<img src={{ URL::to('/') }}/admilte" + data + " width='70' class='img-thumbnail' />")
                                //console.log(data)
                                return "<img src={{ URL::to('/') }}/" + data + " width='85' class='img-thumbnail' />"
                            }},
                {data: 'nombre'},
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
    //var formacion_id




    $('body').on('click', '#btn_ver_m', function (e) {
        e.preventDefault();

       var formacion_id=$(this).data("id");
       //console.log(formacion_id);
        $('#f_id').val(formacion_id);


        $('#div_formaciones').toggle(1000);
        $('#div_matricula').toggle(1100);
        var nombre=$(this).data("nf");
        //nombre=nombre.replace("ver","")
        //var  regex = /(\d{4})\-(\d{2})\-(\d{2}) (\d{2}):(\d{2}):(\d{2})/g; //para quitar la fecha y hora yyyy-mm-dd

        //nombre=nombre.replace(regex,'') //limpiamos la cadena
        $('#titulo').text('Formas de descarga')


        //$('#btn_form_ev').trigger('click');
        //console.log()
        form_name=nombre





        var tabla_m= $('#tabla_matricula').DataTable({
            //console.log(formacion_id);
            "destroy":true,
            "paging": false,
            "responsive": true,
            "autoWidth": true,
            "searching": false,
            "serverSide": true,
            "processing": true,
            dom: 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',


            buttons: {
                dom: {
                    container:{
                    tag:'div',
                    className:'flexcontent'
                    },
                    buttonLiner: {
                    tag: null
                    }
                },




            buttons: [

                    {
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf"></i>PDF',
                        title:'Matricula para la formacion: '+ form_name + '-UVC',
                        titleAttr: 'PDF',
                        className: 'btns btn-app export pdf',
                        footer: true, //nose par q es esto
                        exportOptions: {
                        columns: [ 0, 1, 2, 3 ], //colummnas involucradas
                        stripHtml: false, /* Aquí indicamos que no se eliminen las imágenes */
                        },

                        customize:function(doc) {

                            doc.styles.title = {
                                color: '#4c8aa0',
                                fontSize: '30',
                                alignment: 'center'
                            }
                            doc.styles['td:nth-child(2)'] = {
                                width: '100px',
                                'max-width': '100px'
                            },
                            doc.styles.tableHeader = {
                                fillColor:'#4c8aa0',
                                color:'white',
                                alignment:'center'
                            },
                            doc.content[1].margin = [ 100, 0, 100, 0 ]

                        }

                    },

                    {
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel"></i>Excel',
                        title:'Matricula para la formacion: '+ form_name + '-UVC',
                        titleAttr: 'Excel',
                        className: 'btns btn-app export excel',
                        footer: true,
                        exportOptions: {
                        columns: [ 0, 1, 2, 3  ],
                        stripHtml: false, /* Aquí indicamos que no se eliminen las imágenes */
                        },


                    },
                    {
                        extend:    'csvHtml5',
                        text:      '<i class="fa fa-file-csv"></i>CSV',
                        title:'Matricula para la formacion: '+ form_name + '-UVC',
                        titleAttr: 'CSV',
                        className: 'btns btn-app export csv',
                        footer: true,
                        exportOptions: {
                        columns: [ 0, 1, 2, 3  ],
                        stripHtml: false, /* Aquí indicamos que no se eliminen las imágenes */
                        },

                    },
                    {
                        extend:    'print',
                        text:      '<i class="fa fa-print"></i>Imprimir',
                        title:'Matricula para la formacion: '+ form_name + '-UVC',
                        titleAttr: 'Imprimir',
                        className: 'btns btn-app export imprimir',
                        footer: true,
                        exportOptions: {
                        columns: [ 0, 1, 2, 3  ],
                        stripHtml: false, /* Aquí indicamos que no se eliminen las imágenes */
                        },

                    }

                ]


            },

            "ajax": {
                    'url': "{{route('externa/m')}}",
                    'type': "GET",
                    'data': { 'fid': formacion_id },
                    //'dataSrc': 'history'
                },

            "columns": [
                {data: 'ci'},
                {data: 'nombre'},
                //{data: 'apellido'},
                {data: 'email'},
                {data: 'rol_shortname'},


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










</script>
@endsection
