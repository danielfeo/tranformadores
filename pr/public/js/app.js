$(function(){
    var url = "/tranformadores";
    /**
     * [showDependiente muestra la pregunta dependiente]
     * @param  {[type]} e  [event]
     * @param  {[type]} id [id_pregunta a mostrar]
     * @return {[void]}
     */
    var showDependiente = function(e, id){
        $('div[data-rel="'+id+'"]').fadeIn();
    }

    $('#registro').on('click', function(){
        var accion = $('input[name="accion"]').val();
        switch(accion){
            case 'ingresar':
                $('input[name="accion"]').val('registro');
                $('.form-group.organizacion').fadeIn();
                $('input[name="guardar"]').val("Cadastre-se");
                $('#registro').text("Entrar");
                $('input[name="usuario"]').css('border-color','#ccc');
                $('input[name="clave"]').css('border-color','#ccc');
            break;
            case 'registro':
                $('input[name="accion"]').val('ingresar');
                $('.form-group.organizacion').fadeOut();
                $('input[name="guardar"]').val("Entrar");
                $('#registro').text("Cadastre-se");
                $('input[name="organizacion"]').css('border-color','#ccc');
                $('input[name="usuario"]').css('border-color','#ccc');
                $('input[name="clave"]').css('border-color','#ccc');
            break;
        }
    });

    $('div[data-dependiente]').each(function(i, e){
        //obtiene pregunta padre
        var rel = $(this).data('dependiente');
        
        //obtiene id_pregunta actual
        var id = $(this).data('rel');

        //selecciona pregunta y según el tipo asigna el evento para mostrar la pregunta hija o dependiente.
        var pregunta = $('div[data-rel="'+rel+'"]');
        var tipo = pregunta.data('type');
        switch(tipo){
            case 'radio':
                pregunta.find('input[name="pregunta_'+rel+'"]').on('change', function(e){
                    showDependiente(e, id)
                });
            break;
        }
    });

    $('select[data-role="respuesta"]').each(function(i, e){
        var value = $(this).data('value');
        if( value != '' ){
            $(this).val(value);
        }
    });

    $('#guardar').on('click', function(e){
        var respuestas = new Array();
        $('div[data-role="pregunta"]').each(function(i, e){
            var id = $(this).data('rel');
            var tipo = $(this).data('type');
            var respuesta = '';
            switch (tipo) {
                case 'textarea':
                case 'text':
                case 'select':
                case 'date':
                    respuesta = $(this).find('[data-role="respuesta"]').val();
                break;
                case 'radio':
                    respuesta = $(this).find('input[name="pregunta_'+id+'"]:checked').val();
                break;
            }
            respuestas.push({
                id_pregunta: id,
                tipo: tipo,
                respuesta: respuesta
            });
        });

        $.ajax({
            type: 'post',
            url:'app/db/preguntas.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'guardarPreguntas',
                _respuestas: respuestas
            },
            success: function(data){
                if(data.estado){
                    $.fn.SimpleModal({
                        model: 'modal',
                        btn_ok : 'Aceptar',
                        title:    'Mensaje',
                        contents: 'Preguntas guardadas satisfactoriamente'
                    }).addButton("Aceptar", "btn primary", function(){
                        this.hide();
                        window.location.reload();
                    }).showModal();
                }else{
                    $.fn.SimpleModal({
                        btn_ok:   'Aceptar',
                        title:    'Mensaje',
                        contents: 'No se pudo guardar las preguntas, por favor contacte con el administrador'
                    }).showModal();
                }
            }
        });
    });

    $('.secciones li a').on('click', function(e){
        var respuestas = new Array();
        $('div[data-role="pregunta"]').each(function(i, e){
            var id = $(this).data('rel');
            var tipo = $(this).data('type');
            var respuesta = '';
            switch (tipo) {
                case 'textarea':
                case 'text':
                case 'select':
                case 'date':
                    respuesta = $(this).find('[data-role="respuesta"]').val();
                break;
                case 'radio':
                    respuesta = $(this).find('input[name="pregunta_'+id+'"]:checked').val();
                break;
            }
            respuestas.push({
                id_pregunta: id,
                tipo: tipo,
                respuesta: respuesta
            });
        });

        $.ajax({
            type: 'post',
            url:'app/db/preguntas.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'guardarPreguntas',
                _respuestas: respuestas
            },
            success: function(data){
            }
        });
    });

    $('#enviar').on('click', function(e){
        $.ajax({
            type: 'post',
            url: 'app/db/preguntas.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'enviarPreguntas',
            },
            success: function(data){
                if(data.estado){
                    $.fn.SimpleModal({
                        model: 'modal',
                        btn_ok : 'Aceptar',
                        title:    'Alerta',
                        contents: 'Obrigada por candidatizar a sua experiência. Os resultados serão divulgados em fevereiro de 2015.'
                    }).addButton("Aceptar", "btn primary", function(){
                        this.hide();
                        window.location.reload();
                    }).showModal();
                }else{
                    var mensaje = 'Diligencie las preguntas pendientes en las siguientes secciones: <br><br>';
                    mensaje += '<ul>';
                    for (var i=0; i<data.preguntas.length; i++){
                        mensaje += '<li> - '+data.preguntas[i].titulo.replace(/<br>/g, '')+'</li>';
                    }
                    mensaje += '</ul>';
                    $.fn.SimpleModal({
                        model: 'modal',
                        btn_ok : 'Aceptar',
                        title:    'Alerta',
                        contents: mensaje
                    }).addButton("Aceptar", "btn primary", function(){
                        this.hide();
                        window.location.reload();
                    }).showModal();
                }
            }
        });
    });

    $('input[data-type="date"]').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    $('.saida').on('click' , function(e){
        $.ajax({
            type: 'post',
            url:  'app/db/usuarios.php',
            dataType: 'json',
            data:{
                _accion : 'cerrar_sesion'
            },
            complete: function(){
                window.location.href= url+'/pr';
            }
        });
        e.preventdefault(); 
    });

});