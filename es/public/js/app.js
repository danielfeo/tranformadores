$(function()
{
    var url = "/transformadores";
    var lang = "es";
    var id_lang = $('.fluidBlanco').data('lenguaje');
    /**
     * [showDependiente muestra la pregunta dependiente]
     * @param  {[type]} e  [event]
     * @param  {[type]} id [id_pregunta a mostrar]
     * @return {[void]}
     */
     $('#exampleInputPassword1').on('focus',function(){
         $('#error').text('');
     });
     
     $("#form_cambio_clave").submit(function(e) {
        var formObj = $(this);
        var formURL = 'app/db/usuarios.php';
        var formData = new FormData(this);
        formData.append('_accion', 'cambiar_contraseña');
        $.ajax({
            url: formURL,
            type: 'POST',
            data: formData,
            mimeType: "multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            dataType:'json',
            success: function(data, textStatus, jqXHR) {
                if(!data.estado){
                    $('#error').text('La contraseña anterior no es valida!');
                    $('#form_cambio_clave')[0].reset();
                }else{
                $('#error').text('');
                $('#defaultModal2').modal('toggle');}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(data);
            }
        });
        e.preventDefault();
    });

    $('body').delegate('#acepto', 'click', function() {
        document.getElementById("enviar").disabled = false;
    });

    var showDependiente = function(e, id) 
    {
        $('div[data-rel="' + id + '"]').fadeIn();
    }

    var validar_multitext = function()
    {
        var total = $('.links').find('p').length;
        console.log(total);

        if(total >= 5)
            $('.addFile').prop('disabled', true);
        else
            $('.addFile').prop('disabled', false);
    }

    var renderMultitext = function(respuestas, rel) {
        var $lista = $('div[data-role="lista-multitext"][data-rel="' + rel + '"]');
        var data = respuestas.split(',');

        $lista.html('');
        $.each(data, function(i, e) {
            if (e)
                $lista.append('<p><a data-role="file" href="' + e + '">' + e + '</a>&nbsp;<a href="#" data-role="delete" title="borrar"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></a></p>')
        });

        validar_multitext();
    }

    $('#registro').on('click', function() {
        var accion = $('input[name="accion"]').val();
        switch (accion) {
            case 'ingresar':
                $('input[name="accion"]').val('registro');
                $('.form-group.organizacion').fadeIn();
                $('input[name="guardar"]').val("Cadastre-se");
                $('#registro').text("Entrar");
                $('input[name="usuario"]').css('border-color', '#ccc');
                $('input[name="clave"]').css('border-color', '#ccc');
                break;
            case 'registro':
                $('input[name="accion"]').val('ingresar');
                $('.form-group.organizacion').fadeOut();
                $('input[name="guardar"]').val("Entrar");
                $('#registro').text("Cadastre-se");
                $('input[name="organizacion"]').css('border-color', '#ccc');
                $('input[name="usuario"]').css('border-color', '#ccc');
                $('input[name="clave"]').css('border-color', '#ccc');
                break;
        }
    });

    $('div[data-dependiente]').each(function(i, e) {
        //obtiene pregunta padre
        var rel = $(this).data('dependiente');

        //obtiene id_pregunta actual
        var id = $(this).data('rel');

        //selecciona pregunta y según el tipo asigna el evento para mostrar la pregunta hija o dependiente.
        var pregunta = $('div[data-rel="' + rel + '"]');
        var tipo = pregunta.data('type');
        switch (tipo) {
            case 'radio':
                pregunta.find('input[name="pregunta_' + rel + '"]').on('change', function(e) {
                    showDependiente(e, id)
                });
                break;
        }
    });

    $('select[data-role="respuesta"]').each(function(i, e) {
        var value = $(this).data('value');
        if (value != '') {
            $(this).val(value);
        }
    });

    $('#guardar, .pagSeccion a, .pasosInscripcion a').on('click', function(e) {
        var respuestas = new Array();
        var url = "";
        if ($(this).prop('href') !== '')
            url= $(this).prop('href');

        $('div[data-role="pregunta"]').each(function(i, e) {
            var id = $(this).data('rel');
            var tipo = $(this).data('type');
            var respuesta = '';
            switch (tipo) {
                case 'textarea':
                case 'text':
                case 'select':
                case 'date':
                case 'multitext':
                    respuesta = $(this).find('[data-role="respuesta"]').val();
                    break;
                case 'radio':
                    respuesta = $(this).find('input[name="pregunta_' + id + '"]:checked').val();
                    break;
            }
                respuestas.push({
                id_pregunta: id,
                tipo: tipo,
                respuesta: respuesta
            });
        });

        var checked = $("input[id='acepto']:checked").length;
        if(checked){
            $.ajax({
            type: 'post',
            url: 'app/db/preguntas.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'guardarAcepto',
                _acepto: true
            } ,success: function(data){console.log(data);}});
        }
       
        $.ajax({
            type: 'post',
            url: 'app/db/preguntas.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'guardarPreguntas',
                _respuestas: respuestas
            },
            success: function(data){
                if(data.estado){
                    if(url == "" || typeof url == 'undefined')
                    {
                        $.fn.SimpleModal({
                            model: 'modal',
                            btn_ok : 'Aceptar',
                            title:    'Mensaje',
                            contents: 'Preguntas guardadas satisfactoriamente'
                        }).addButton("Aceptar", "btn primary", function(){
                            this.hide();
                            window.location.reload();
                        }).showModal();
                    } else {
                        window.location.href = url;
                    }
                }else{
                    $.fn.SimpleModal({
                        btn_ok:   'Aceptar',
                        title:    'Mensaje',
                        contents: 'No se pudo guardar las preguntas, por favor contacte con el administrador'
                    }).showModal();
                }
            }


        });

        e.preventDefault();
    });

    $('button[data-role="add-multitext"]').on('click', function(e) {
        var rel = $(this).data('rel');
        var url = $('input[data-role="multitext"][data-rel="' + rel + '"]').val();

        if (url != '') {
            url += ',';
            var $respuesta = $('input[data-role="respuesta"][data-rel="' + rel + '"]');
            $respuesta.val($respuesta.val() + url);
            renderMultitext($respuesta.val(), rel);
        }

        $('input[data-role="multitext"][data-rel="' + rel + '"]').val('');
    });

    $('div[data-role="lista-multitext"]').delegate('a[data-role="delete"]', 'click', function(e) {
        var data = "";
        var rel = $(this).closest('div[data-role="lista-multitext"]').data('rel');
        $(this).closest('p').remove();

        $('div[data-role="lista-multitext"][data-rel="' + rel + '"]').find('p').each(function(i, e) {
            data += $(this).find('>a').prop('href') + ',';
        });

        var $respuesta = $('input[data-role="respuesta"][data-rel="' + rel + '"]');
        $respuesta.val(data);
        renderMultitext($respuesta.val(), rel);

        e.preventDefault();
    });

    $('.secciones li a').on('click', function(e) {
        var respuestas = new Array();
        $('div[data-role="pregunta"]').each(function(i, e) {
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
                    respuesta = $(this).find('input[name="pregunta_' + id + '"]:checked').val();
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
            url: 'app/db/preguntas.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'guardarPreguntas',
                _respuestas: respuestas
            },
            success: function(data) {}
        });
    });

    $('#enviar').on('click', function(e) {
        var respuestas = new Array();
        $('div[data-role="pregunta"]').each(function(i, e) {
            var id = $(this).data('rel');
            var tipo = $(this).data('type');
            var respuesta = '';
            switch (tipo) {
                case 'textarea':
                case 'text':
                case 'select':
                case 'date':
                case 'multitext':
                    respuesta = $(this).find('[data-role="respuesta"]').val();
                    break;
                case 'radio':
                    respuesta = $(this).find('input[name="pregunta_' + id + '"]:checked').val();
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
            url: 'app/db/preguntas.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'guardarPreguntas',
                _respuestas: respuestas
            },
            success: function(data) {
                 $.ajax({
                    type: 'post',
                    url: 'app/db/preguntas.php',
                    dataType: 'json',
                    async: false,
                    data: {
                        _accion: 'enviarPreguntas',
                    },
                    success: function(data) {
                        if (data.estado) {
                            $.fn.SimpleModal({
                                model: 'modal',
                                btn_ok: 'Aceptar',
                                title: 'Alerta',
                                contents: id_lang == '1' ? 'Gracias por postular su experiencia' : 'Obrigada por candidatizar a sua experiência.'
                            }).addButton("Aceptar", "btn primary", function() {
                                this.hide();
                                window.location.reload();
                            }).showModal();
                        } else {
                            var mensaje = 'Diligencie las preguntas pendientes en las siguientes secciones: <br><br>';
                            mensaje += '<ul>';
                            for (var i = 0; i < data.preguntas.length; i++) {
                                mensaje += '<li> - ' + data.preguntas[i].titulo.replace(/<br>/g, '') + '</li>';
                            }
                            mensaje += '</ul>';
                            $.fn.SimpleModal({
                                model: 'modal',
                                btn_ok: 'Aceptar',
                                title: 'Alerta',
                                contents: mensaje
                            }).addButton("Aceptar", "btn primary", function() {
                                this.hide();
                                window.location.reload();
                            }).showModal();
                        }
                    }
                });
            }
        });
    });

    $('input[data-type="date"]').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    $('.saida').on('click', function(e) {
        var respuestas = new Array();
        $('div[data-role="pregunta"]').each(function(i, e) {
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
                    respuesta = $(this).find('input[name="pregunta_' + id + '"]:checked').val();
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
            url: 'app/db/preguntas.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'guardarPreguntas',
                _respuestas: respuestas
            },
            success: function(data) {}
        });

        $.ajax({
            type: 'post',
            url: 'app/db/usuarios.php',
            dataType: 'json',
            async: false,
            data: {
                _accion: 'cerrar_sesion'
            },
            complete: function() {
                window.location.href = url + '/' + lang;
            }
        });

        e.preventDefault();
    });

    validar_multitext();
});