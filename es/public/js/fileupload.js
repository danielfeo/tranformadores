$(function()
{
    var validar_archivos = function(e){
        var total = $('.archivos').find('p').length;
        if(total == 5)
             $('.file_uploader button').prop('disabled', true);
        else
            $('.file_uploader button').prop('disabled', false);
    }

    var mostrarProceso = function(e){
        if (e.loaded == e.total){
            $('.file_uploader button i').removeClass('fa-circle-o-notch fa-spin').addClass('fa-upload');
        }
    }

    $('.file_uploader').delegate('button', 'click', function(){
        var contenedor = $(this).closest('.file_uploader');
        $(this).find('i').removeClass('fa-upload').addClass('fa-circle-o-notch fa-spin');
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
                    contenedor.find('input[type="file"]').val('');
                    contenedor.find('div.archivos').append('<p><a href="'+data.url+'" data-role="file" target="_blank">'+data.file+'</a>&nbsp;<a href="#" data-role="delete" title="borrar"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a></p>');
                } else {
                    $.fn.SimpleModal({
                        model: 'modal',
                        btn_ok : 'Aceptar',
                        title:    'Error',
                        contents: 'No se pudo enviar el archivo, recuerde que los formatos admitidos son (PDF, DOCX, DOC, XLSX, XLS) y el tamaño maxímo es 5mb'
                    }).addButton("Aceptar", "btn primary", function(){
                        this.hide();
                    }).showModal();
                }
                validar_archivos();
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('.archivos').delegate('a[data-role="delete"]', 'click', function(e){
        var contenedor = $(this).closest('p');
        var archivo = contenedor.find('a[data-role="file"]');
        var modal = $.fn.SimpleModal({
            model: 'modal',
            btn_ok : 'Aceptar',
            title:    'Alerta',
            contents: '¿Desea eliminar este archivo?'
        }).addButton("Si", "btn primary", function(){
            this.hide();
            $.ajax({
                type: 'post',
                url:  'app/db/preguntas.php',
                dataType: "json",
                data:{
                    _accion : 'borrarArchivo',
                    _archivo : archivo.attr('href')
                },
                success: function(data){
                    if(data.estado == true){
                        window.location.reload();
                    }
                }
            });
        }).addButton("Cancelar", "btn").showModal();
        e.preventDefault();
    });

    validar_archivos();
});