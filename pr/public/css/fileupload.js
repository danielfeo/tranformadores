$(function(){
    var mostrarProceso = function(e){
    
    }

    $('.file_uploader').delegate('button', 'click', function(){
        var contenedor = $(this).closest('.file_uploader');
        var formData = new FormData();
        var file = contenedor.find('input[type="file"]')[0];
        formData.append('_archivo', file.files[0]);
        formData.append('_accion', 'cargarArchivo');
        $.ajax({
            type: 'post',
            url:'app/db/preguntas.php',
            dataType:'json',
            xhr: function() {
                myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress', mostrarProceso, false); 
                }
                return myXhr;
            },
            success: function(data){
                if(data.estado == '1'){
                    contenedor.find('div.archivos').append('<p><a href="'+data.url+'" target="_blank"><i class="fa fa-file-o"></i> '+data.file+'</a></p>');
                }
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    });
});