
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            //console.log('X-CSRF-TOKEN');
        }
    });

    $(document).ready(function() {


        $('#formas').select2({
            placeholder:" Elige una formacion ",
            theme:"classic"
        });

    });


    var info //esto para el excel
    var postulado_select=false //para saber si pulso el boton
    var supervisor_select=false
    var cont_select_sup=false
    var formacion_select=false

    $('#archivo_inputp').click(function (e) {

        $('#f_id').val($('#formas').val());
    });//pruebas con el excelp

    //Para ver todos los expedientes
    $('#btn_evaluar').click(function (e) {
       // e.preventDefault();
       info= $('#tabla_postulados').DataTable().page.info();
       //console.log()
       if (info.recordsTotal>0) {
            $('#f_id_ev').val($('#formas').val());
            $('#btn_form_ev').trigger('click');
       }else{

        const t= Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-morado btn-alert',

            },
            buttonsStyling: false
        })


        t.fire({
        title: '<strong> !No hay usuarios en la lista para evaluar! </strong>',
        //text: data.success,
        icon: 'warning',
        confirmButtonText: 'Aceptar',
        width: '35%',
        //timerProgressBar:true,
        //timer: 2500
        })

       }


    });

    $('#formas').on('change', function () {
        if ($('#formas').val()) {


           //
            $("#btn_confirm_f").prop('disabled', false);
            $("#btn_agregar").prop('disabled', false);
            $("#btn_evaluar").prop('disabled', false);

        }

    });

    $('#btn_confirm_f').click(function (e) {
                e.preventDefault();
                formacion_select=true
                var id_form=$('#formas').val()
                $("#btn_deleted_all").prop('disabled', false);
                $('#_postulados').fadeIn(); //prueba de momento
               // console.log(id_form)
                var tabla_postulados= $('#tabla_postulados').DataTable({

                    "destroy":true,
                    "responsive": true,
                    "searching": false,
                    "serverSide": true,
                    "processing": true,
                    "ajax": "lista/postulados/"+id_form,

                    "columns": [
                        {data: 'ci'},
                        {data: 'name'},
                        //{data: 'apellido'},
                        {data: 'email'},
                        {data: 'supervisor','render' : function (data, type, row) {
                                return '<span class="badge badge-dark">'+data+'</span>'
                            }},


                        {data: 'action', name: 'btn', orderable: false},
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
                    },
                    "initComplete": function( settings, json ) {
                         info=tabla_postulados.page.info();
                        //console.log( info.recordsTotal)
                    }
                });

        });

//para borrar todo
    $('#btn_deleted_all').click(function (e) {
        e.preventDefault();
        var f_id=$('#formas').val()
        info= $('#tabla_postulados').DataTable().page.info();


        var toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2800
            });


        if (info.recordsTotal>0) {
            $('#f_id_dall').val(f_id);
            $('#btn_form_dall').trigger('click');

        }else{
            toast.fire({
                        icon: 'warning',
                        title: 'La lista ya esta vacia.'
                    })
        }

    });
    $('#form_dall').on('submit', function (event) {

        event.preventDefault();

            $.ajax({
                url: "{{ route('Eliminar.lista') }}",
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
                    $('#tabla_postulados').DataTable().ajax.reload();
                    toast.fire({
                            icon: 'success',
                            title: 'Postulados Eliminados.'
                        })

                }
            });

        });



    //Borrar postulado version "todo uso..."
    $('body').on('click', '#btn_eliminar_p', function () {
        var p_id = $(this).data("id");
        var f_id=$('#formas').val();
        $('#f_id_p').val(f_id);
        $('#user_id_p').val($(this).data("id"));
        $('#btn_form_borrar').trigger('click');
        });

        $('#form_borrar').on('submit', function (event) {

            event.preventDefault();
            $.ajax({

                url: "{{ route('Postulados.destroy') }}",
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
                    $('#tabla_postulados').DataTable().ajax.reload();
                    toast.fire({
                            icon: 'success',
                            title: 'Postulado Eliminado.'
                        })

                }
            });

        });

    ///TRATAMIENTO DEL EXCEL

    /// CARGA DEL EXCEL///
    $('#btn_cargar').click(function (e) {
        e.preventDefault();
        $('#modal_excel').modal('show');

    });

    //DESCARGA EL EXCEL//
    $('#btn_download_excel').click(function (e) {

        $('#vf_id').val($('#formas').val());
        //$('#div_descarga').fadeOut();
    });



    //envia excel
    $('#form_excel').on('submit', function (event) {

        event.preventDefault();
        // 4 formas de hacer lo mismo
        /*console.log(new FormData(document.getElementById("form_excel")))
        console.log(new FormData($(this)[0]))
        console.log(new FormData(this))
        var formData = new FormData(this);
        formData.append('_token', $('input[name=_token]').val());
        console.log(formData)
        */
        var id_form=$('#formas').val()
        $.ajax({

                url: "inscribir/postulados/masivo/"+id_form,
                method:"POST",
                //data:$(this).serialize(),
                data:new FormData(this), //obtines los input del form
                //dataType:"json",
                contentType: false, //importante enviar este parametro en false
                processData: false,//importante enviar este parametro en false
                success:function(data)
                {

                    $('#archivo_input').val(''); //limpia el campo del archivo
                    var newRows = "";
                    //console.log(data[0].status)
                    if(data[0].status==300) //Errores Postulados/Supervisores
                    {
                        $('#modal_e_excel').modal('show');
                        $('#div_t_errores').fadeIn();
                        $('#div_descarga').fadeIn();
                        $('#tabla_e_titulo').text('Total de errores: '+data[2].cont_e);
                        $("#tabla_errores tr").remove();
                        $.each(data[1].errores, function (i,valor) {
                            //console.log(valor)
                            var cad=valor.split('-')
                            $("#tabla_errores").append("<tr><td>" + cad[0] + "</td><td>  </td><td>"+cad[1]+"</td> </tr>");


                        });
                        $('#form_new_postu')[0].reset();
                        $('#tabla_postulados').DataTable().ajax.reload();

                    }

                    if(data[0].status==250  ) //Mal/sin encabezado
                    {

                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: true
                            })


                        t.fire({
                        title: '!ERROR !',
                        text: data[1].errores,
                        icon: 'error',
                        confirmButtonText: 'Continuar',
                        width: '35%',
                        timerProgressBar:true,

                        })

                    }
                    if(data[0].status==260  ) //Mal/sin encabezado
                    {

                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: true
                            })


                        t.fire({
                        title: '<strong>!ERROR !</strong>',
                        text: data[1].errores,
                        icon: 'error',

                        confirmButtonText: 'Continuar',
                        width: '35%',
                        timerProgressBar:true,

                        })

                    }

                    if(data[0].status==777) //Todo perfecto
                    {
                        //html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#form_new_postu')[0].reset();
                        $('#tabla_postulados').DataTable().ajax.reload();

                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: false
                            })


                        t.fire({
                        title: '!Guardado correctamente!',
                        text: data.success,
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        width: '35%',
                        timerProgressBar:true,
                        timer: 2500
                        })


                    }


                }
        });


    });

    ////agregar un estudiante////
    $('#btn_agregar').click(function (e) {
        e.preventDefault();
        $('#modal_agregar').modal('show');

        if ($('#card_supervisor').css('display')!='none') {
            //console.log('yiiiyi')
            $('#tabla_titulo').text('Selecione el nuevo postulado');
            $('#card_supervisor').css('display', 'none');
            $('#card_postulados').fadeIn();

        }

        $('#s_users').select2({
            placeholder:"Elige un nuevo postulado",
            theme: "classic",
           // minimumResultsForSearch: Infinity, //para ocultar el search que en este caso no hace falta
            //tags: true,
            //tokenSeparators: [','],
            ajax: {
                url: "{{ route('select/users') }}" ,
                dataType: 'json',
                delay: 250,
                data: function (params) {//en esta parte va el parmetro que se envia por medio de la request
                    return {
                        ci: $.trim(params.term)
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
        })

        postulado_select=false
        supervisor_select=false
        var tabla_postulados= $('#select_new_postulado').DataTable({

            "destroy":true,
            "responsive": true,
            "serverSide": true,
            "processing": true,
            "ajax": "select/users_table",

            "columns": [
                {data: 'ci'},
                {data: 'name'},
                //{data: 'apellido'},
                {data: 'prioridad','render' : function (data, type, row) {
                                if (data.toUpperCase()=='ALTA') {
                                    return '<span class="badge-pill badge-verde-b ">'+data.toUpperCase()+'</span>'
                                }
                                if (data.toUpperCase()=='MEDIA') {
                                    return '<span class="badge-pill badge-oro2 ">'+data.toUpperCase()+'</span>'
                                }

                                return '<span class="badge-pill badge-danger">'+data.toUpperCase()+'</span>'
                            }},



                {data: 'action', name: 'btn', orderable: false},
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

    $('#modal_agregar').on('click', '#btn_select_p', function () {
        //$('#card_postulado').fadeOut();
        postulado_select=true
        if (!cont_select_sup) {
            cont_select_sup=true
        }else{
            $('tr').css('background', '#ffffff');

        }
        $(this).closest('tr').css('background', '#24e695');


        $('#card_postulados').toggle(1000);
        $('#card_supervisor').fadeIn(1100);


        //LLENANDO EL FORM//

        $('#formacion_id').val($('#formas').val());
        $('#user_id').val($(this).data("id"));

        $('#tabla_titulo').text('Selecione el Supervisor');

        var tabla_postulados= $('#select_new_supervisor').DataTable({

            "destroy":true,
            "responsive": true,
            //"searching": false,
            "serverSide": true,
            "processing": true,
            "ajax": "select/sup_table",

            "columns": [
                {data: 'ci'},
                {data: 'name'},

                {data: 'action', name: 'btn', orderable: false},
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

    $('#modal_agregar').on('click', '#btn_atras_M', function () {
        $('#card_supervisor').toggle(1000);
        $('#card_postulados').toggle(1100);
        postulado_select=false
        supervisor_select=false

    });

    $('#modal_agregar').on('click', '#btn_select_sup', function () {

        $('#sp_id').val($(this).data("id"));

        if (!cont_select_sup) {
            cont_select_sup=true
        }else{
            $('tr').css('background', '#ffffff');

        }
        $(this).closest('tr').css('background', '#b8daba');
        supervisor_select=true
    });

    $('#form_new_postu').on('submit', function (event) {

        event.preventDefault();

        if (postulado_select && supervisor_select && formacion_select) {
            $.ajax({

                    url: "{{ route('UserInsFormacion.store') }}",
                    method:"POST",
                    data:$(this).serialize(),
                    dataType:"json",
                    success:function(data)
                    {
                        var html = '';
                        if(data.error)
                        {
                            //console.log(data.error)
                            const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-danger',

                                },
                                buttonsStyling: false
                            })


                            t.fire({
                            title: 'ERROR',
                            text: data.error,
                            icon: 'error',
                            confirmButtonText: 'Cerrar',
                            width: '35%',

                            })
                        }
                        if(data.success)
                        {

                            $('#form_new_postu')[0].reset();
                            $('#tabla_postulados').DataTable().ajax.reload();


                        const t= Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success btn-alert',

                                },
                                buttonsStyling: false
                            })


                            t.fire({
                            title: '!Guardado correctamente!',
                            text: data.success,
                            icon: 'success',
                            confirmButtonText: 'Continuar',
                            width: '35%',
                            timerProgressBar:true,
                            timer: 2500
                            })


                        }


                    }
                });


            }


    });
    ///***////

</script>

