


    <h1>GEGE</h1>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        //console.log('X-CSRF-TOKEN');
    }
});
var table
$(document).ready(function () {

     table=$('#table_ev').DataTable({

        "responsive": true,
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

    });

});


$('body').on('click', '#btn_eliminar_p2', function () {

    //console.log($(this).parents('tr'))


    var p_id = $(this).data("id");
    var f_id=$('#btn_deleted_all').data("form");

    $('#f_id_ev').val(f_id);
    $('#user_id_ev').val($(this).data("id"));
    $('#btn_form_borrar').trigger('click');
     table.row( $(this).parents('tr') ).remove().draw();

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

            toast.fire({
                    icon: 'success',
                    title: 'Postulado Eliminado.'
                })

        }
    });

});
//Borrar todo
$('#btn_deleted_all').on ('click',function (e) {
    e.preventDefault();
    var f_id=$(this).data("form");
    var toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2800
        });
    if (table.rows().count()>0) {

        $('#f_id_dall').val(f_id);
        table .rows().remove().draw();
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

                toast.fire({
                        icon: 'success',
                        title: 'Postulados Eliminados.'
                    })

            }
        });

    });

</script>

