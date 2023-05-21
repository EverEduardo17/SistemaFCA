$(document).on('click', '.btn-constancia', function (e) {
    e.preventDefault();

    var url = $(this).data('url');
    var token = $('meta[name="csrf-token"]').attr('content');
    var idEstudiante = url.split('/').pop();

    $.ajax({
        url: url,
        type: 'DELETE',
        data: {
            '_token': token
        },
        success: function (data) {
            console.log('Eliminado exitosamente');
            var filaEstudiante = $('#fila-' + idEstudiante);
            filaEstudiante.closest('tr').remove();
        },
        error: function (data) {
            console.log('Ocurrió un error al eliminar');
        }
    });
});