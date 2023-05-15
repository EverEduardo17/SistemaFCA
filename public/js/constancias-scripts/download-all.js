$(document).on('click', '.download-all', function (e) {
    e.preventDefault();

    var fileName = $(this).data('file-name');
    var downloadUrl = $(this).data('href');
    $('#loading').modal('show');
    
    // Función para simular el progreso de la descarga
    function simulateDownloadProgress() {
        var progressBar = $('#loading .progress-bar');
        var valueMax = parseInt(progressBar.attr('aria-valuemax'));

        var totalIncrements = 4 * parseInt(progressBar.data('increment'));

        var currentProgress = parseInt(progressBar.attr('aria-valuenow'));
        var increment = parseInt(progressBar.data('increment'));
        console.log(currentProgress);

        if (currentProgress < valueMax) {
            var newProgress = currentProgress + increment;
            progressBar.attr('aria-valuenow', newProgress).css('width', newProgress + "%");
            setTimeout(simulateDownloadProgress, totalIncrements * (progressBar.data('increment')*32)/3);
        }
    }

    // Iniciar la simulación del progreso de la descarga
    simulateDownloadProgress();

    $.ajax({
        url: downloadUrl,
        method: 'GET',
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(data);
            link.download = fileName + " constancias.zip";
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();

            // Establecer el progreso en 100% y ocultar el modal
            $('#loading .progress-bar').attr('aria-valuenow', 100).css('width', '100%');
            var $modalDialog = $('#loading');
            $modalDialog.modal('show');

            function hideModal() {
                $modalDialog.modal('hide');
            }

            // retrasar el ocultar del modal para que se vea el 100%
            setTimeout(hideModal, 900);

            document.body.removeChild(link);
            location.reload();
        }
    });
});