$(function(){


	//datatable usuarios//

	//js input file
	// We can attach the `fileselect` event to all file inputs on the page
	$(document).on('change', ':file', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});

	// We can watch for our custom `fileselect` event like this
	$(':file').on('fileselect', function(event, numFiles, label) {

 		var input = $(this).parents('.input-group').find(':text'),
      	log = numFiles > 1 ? numFiles + ' files selected' : label;

		if (input.length) 
		{
			input.val(log);
		} else {
			if( log ) alert(log);
		}
	});

	//js input file
	var url = '/tranformadores';
	var items_paginas = 10;

	function paginador(pagina, items){
		var pagina_actual = (pagina - 1) * items;
		$.ajax({
			type: 'post',
			url:  'app/db/usuarios.php',
			dataType: 'json',
			data:{
				_accion : 'obtener_usuarios',
				_pagina : pagina_actual,
				_items: items
			},
			success: function(data){
				if(data.length > 0){
					var texto ="";
					for(var i=0; i<data.length; i++){
						console.log(data);
						//if(data[i].id_rol == 1){check="checked";}else{check="";}
						texto += '<tr data-id="'+data[i].id_usuario+'" >';
						texto += '<td data-pass="'+data[i].pass+'" data-campo="organizacion">'+data[i].organizacion+'</td><td data-campo="email">'+data[i].email+'</td>               <td data-campo="categoria" data-cat="'+data[i].id_categoria+'">'+data[i].descripcion+'</td>            <td data-campo-hab=""'+data[i].habilitado+'" align="center"> '+(data[i].habilitado == 1 ? '<i class="fa fa-check-square-o"></i>'  : '<i class="fa fa-square-o"></i>') +' </td>            <td align="center">'+(data[i].id_rol == 1 ? '<i class="fa fa-check-square-o"></i>'  : '<i class="fa fa-square-o"></i>') +'</td>        <td align="center"><a data-rol="modificar" href="#"><i title="editar" class="fa fa-pencil-square-o"></i></a></td><td align="center"><a data-rol="eliminar" href="#"><i title="eliminar" class="fa fa-trash"></i></a></td>';
						
						texto += '</tr>';
					}
					$('#tabla_usuarios tbody').html(texto);

					var table = $('#tabla_usuarios').DataTable();
					table.draw('page');
				}else{

				}
			}
		});	
	} 

	paginador(1, items_paginas);

	$('.paginador a').on('click', function(e){
		$('.paginador a').removeClass('active');
		$(this).addClass('active');
		var pagina = $(this).text();
		paginador(pagina, items_paginas);
		e.preventDefault();
	});
	
	$('input[name="guardar"]').on('click', function(e){
		var organizacion = $('input[name="organizacion"]').val();
		var correo = $('input[name="usuario"]').val();
		var pass = $('input[name="clave"]').val();
		var accion =  $('input[name="accion"]').val();

		if (accion == 'registro'){
			if( organizacion != "" && correo != "" && pass != ""){
				$.ajax({
					type: 'post',
					url:  'app/db/usuarios.php',
					dataType: "json",
					data:{
						_organizacion : organizacion,
						_correo : correo,
						_pass : pass,
						_accion : 'registro',
						_habilitado : 0,
						_rol : 2
					},
					success: function (data){
						if (data.estado == 0){
							$.fn.SimpleModal({
								btn_ok:   'Aceptar',
								title:    'Mensaje',
								contents: 'No se pudo realizar el registro, contacte con el administrador. Gracias.'
							}).showModal();

						}else if(data.estado == 1){
							$.fn.SimpleModal({
								btn_ok:   'Aceptar',
								title:    'Gracias',
								contents: 'El registro se ha realizado satisfactoriamente, cuando su usuario sea habilitado se le enviará una notificación por correo y podrá acceder al formulario.'
							}).showModal();

						}else if(data.estado == 2){
							$.fn.SimpleModal({
								btn_ok:   'Aceptar',
								title:    'Mensaje',
								contents: 'Este usuario ya se encuentra registrado, si no recuerda su contraseña haga click en "Olvido su contraseña"'
							}).showModal();

						}
					},
					complete: function(){
						$('input[name="organizacion"]').val('');
						$('input[name="usuario"]').val('');
						$('input[name="clave"]').val('');
					}
				});	
			}else{
				if(organizacion == "")
					$('input[name="organizacion"]').css('border-color','#F00');
				else
					$('input[name="organizacion"]').css('border-color','#ccc');

				if(correo == "")
					$('input[name="usuario"]').css('border-color','#F00');
				else
					$('input[name="usuario"]').css('border-color','#ccc');

				if(pass == "")
					$('input[name="clave"]').css('border-color','#F00');
				else
					$('input[name="clave"]').css('border-color','#ccc');
			}
		}

		if (accion == 'ingresar'){
			if(correo != "" && pass != ""){
				$.ajax({
					type: 'post',
					url:  'app/db/usuarios.php',
					dataType: "json",
					data:{
						_correo: correo,
						_pass: pass,
						_accion: 'ingresar'
					},
					success: function (data){
					
						if (data.estado == 0){
							$.fn.SimpleModal({
								btn_ok:   'Aceptar',
								title:    'Mensaje',
								contents: 'Usuario y/o contraseña incorrecta, si no recuerda su contraseña haga click en "Olvido su contraseña"'
							}).showModal();
						}else if(data.estado == 2){
							$.fn.SimpleModal({
								btn_ok:   'Aceptar',
								title:    'Mensaje',
								contents: 'La fecha para enviar su formulario ya se venció.'
							}).showModal();
						}else if(data.estado == 3){
							$.fn.SimpleModal({
								btn_ok:   'Aceptar',
								title:    'Mensaje',
								contents: 'Su usuario aún no ha sido habilitado para diligenciar el formulario.'
							}).showModal();
						}else if(data.estado == 1){

							window.location.reload();
						}
					}
				});	
			}else{
				if(correo == "")
					$('input[name="usuario"]').css('border-color','#F00');
				else
					$('input[name="usuario"]').css('border-color','#ccc');

				if(pass == "")
					$('input[name="clave"]').css('border-color','#F00');
				else
					$('input[name="clave"]').css('border-color','#ccc');
			}
		} 
	});
	
	$('input[name="crear_nuevo"]').on('click', function(e){
		var accion = $('input[name="accion"]').val();
		var id = $('input[name="id"]').val();
		var organizacion = $('input[name="organizacion"]').val();
		var correo = $('input[name="usuario"]').val();
		var categoria = $('select[name="categoria"]').val();
		var pass = $('input[name="contraseña"]').val();
		var habilitado = $('input[name="habilitado"]').is(':checked') ? 1 : 0;
		var rol = $('input[name="administrador"]').is(':checked') ? 1 : 2;
		
		if( organizacion != "" && correo != "" && pass != "" ){
			$.ajax({
				type: 'post',
				url:  'app/db/usuarios.php',
				dataType: "json",
				data:{
					_accion : accion,
					_id : id,
					_organizacion : organizacion,
					_correo : correo,
					_categoria : categoria,
					_pass : pass,
					_habilitado : habilitado,
					_rol : rol
				},
				success: function(data){
					if (data.estado){
						var mensaje = '';
						if(accion == 'modificar'){
							mensaje = 'Usuario modificado satisfactoriamente';
						}else{
							mensaje = 'Usuario creado satisfactoriamente';
						}
						$.fn.SimpleModal({
							model: 'modal',
							btn_ok : 'Aceptar',
							title:    'Mensaje',
							contents: mensaje
						}).addButton("Aceptar", "btn primary", function(){
							this.hide();
							window.location.reload();
						}).showModal();
					}
				}
			});	
		} else {
			if(organizacion == "")
				$('input[name="organizacion"]').css('border-color','#F00');
			else
				$('input[name="organizacion"]').css('border-color','#ccc');
			if(correo == "")
				$('input[name="usuario"]').css('border-color','#F00');
			else
				$('input[name="usuario"]').css('border-color','#ccc');
			if(pass == "")
				$('input[name="contraseña"]').css('border-color','#F00');
			else
				$('input[name="contraseña"]').css('border-color','#ccc');
		}
	});
	
	$('#tabla_usuarios').delegate('a[data-rol="modificar"]', 'click', function(e){
		var tr = $(this).closest('tr');
		var id = tr.data('id');
		var orga = tr.find('td[data-campo="organizacion"]').text();
		var usua = tr.find('td[data-campo="email"]').text();
		var categoria = tr.find('td[data-campo="categoria"]').data('cat');
		var pass = tr.find('td[data-pass]').data('pass');
		var hab = tr.find('td[data-campo-hab]').data('campo-hab') == 1 ? true : false;
		var rol = tr.find('td[data-campo-rol]').data('campo-rol') == 1 ? true : false;
		$('input[name="id"]').val(id);
		$('input[name="organizacion"]').val(orga);
		$('input[name="usuario"]').val(usua);
		$('input[name="contraseña"]').val(pass);
		$('select[name="categoria"]').val(categoria);
		$('input[name="habilitado"]').prop('checked', hab);
		$('input[name="administrador"]').prop('checked', rol);
		$('input[name="crear_nuevo"]').val("Modificar");
		$('input[name="accion"]').val("modificar");
		$('input[name="cancelar"]').fadeIn();
		e.preventDefault();
	});

	$('#tabla_usuarios').delegate('a[data-rol="eliminar"]', 'click', function(e){
		var tr = $(this).closest('tr');
		var id = tr.data('id');
		var mensaje = 'Esta seguro de eliminar esta organizacion';
		$.fn.SimpleModal({
			model: 'modal',
			btn_ok : 'Aceptar',
			title:    'Mensaje',
			contents: mensaje
		}).addButton("Si", "btn primary", function(){
			this.hide();
			$.ajax({
				type: 'post',
				url:  'app/db/usuarios.php',
				dataType: "json",
				data:{
					_accion : 'eliminar',
					_id : id,
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

	$('input[name="cancelar"]').on('click', function(e){
		$('input[name="id"]').val("");
		$('input[name="organizacion"]').val("");
		$('input[name="usuario"]').val("");
		$('input[name="contraseña"]').val("");
		$('input[name="habilitado"]').attr('checked', false);
		$('input[name="administrador"]').attr('checked', false);
		$('input[name="accion"]').val("crear_nuevo");
		$('input[name="crear_nuevo"]').val("Guardar");
		$('input[name="cancelar"]').fadeOut();
	});

	$('input[name="enviar"]').on('click', function(e){
		var usuario = $('input[name="usuario"]').val();
		if( usuario != ""){
			$.ajax({
				type: 'post',
				url:  'app/db/usuarios.php',
				dataType: "json",
				data:{
					_accion : "recordar_contraseña",
					_usuario : usuario
				},
				success: function(data){
					if(data.estado == 1){
						$.fn.SimpleModal({
							btn_ok:   'Aceptar',
							title:    'Mensaje',
							contents: 'Se ha enviado la información a su correo. Gracias'
						}).showModal();
						$('input[name="usuario"]').val("");
					}else{
						$.fn.SimpleModal({
							btn_ok:   'Aceptar',
							title:    'Mensaje',
							contents: 'Este email no se encuentra registrado, verifique su información. Gracias '
						}).showModal();
					}
				}
			});
		}else{
			if(usuario == "")
				$('input[name="usuario"]').css('border-color','#F00');
			else
				$('input[name="usuario"]').css('border-color','#ccc');
		}
	e.preventDefault();
	});

	$('input[name="enviar_cont"]').on('click', function(e){
		var contra_ant =  $('input[name="clave_anterior"]').val();
		var contra_nueva = $('input[name="clave_nueva"]').val();
		if( contra_ant != "" && contra_nueva !=""){
			$.ajax({
				type: 'post',
				url:  'app/db/usuarios.php',
				dataType: "json",
				data:{
					_accion : "cambiar_contraseña",
					_contra_ant : contra_ant,
					_contra_nueva : contra_nueva
				},
				success: function(data){
					if(data.estado == 1){
						$.fn.SimpleModal({
							model: 'modal',
							btn_ok : 'Aceptar',
							title:    'Mensaje',
							contents: 'Contraseña modificada satisfactoriamente'
						}).addButton("Aceptar", "btn primary", function(){
							this.hide();
							window.location.href= url;
						}).showModal();
					}else{
						$.fn.SimpleModal({
							btn_ok:   'Aceptar',
							title:    'Mensaje',
							contents: 'La contraseña que ingreso no es la correcta'
						}).showModal();
					}
				}
			});
		}else{
			if( contra_ant == "")
				$('input[name="clave_anterior"]').css('border-color','#F00');
			else
				$('input[name="clave_anterior"]').css('border-color','#ccc');
			if( contra_nueva == "")
				$('input[name="clave_nueva"]').css('border-color','#F00');
			else
				$('input[name="clave_nueva"]').css('border-color','#ccc');			

		}
	});

	/*$('#tabla_usuarios').delegate('input[data-funcion="administrador"]','click',function (e) { 
		var id = $(this).data('rel'); 
		alert(id);
	});*/

});