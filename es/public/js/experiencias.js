$(function()
{

	var items_paginas = 10;

	$( "#fecha_inicio" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      dateFormat: 'yy-mm-dd',
      onClose: function( selectedDate ) {
        $( "#fecha_fin" ).datepicker( "option", "minDate", selectedDate );
      }
    });

    $( "#fecha_fin" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      dateFormat: 'yy-mm-dd',
      onClose: function( selectedDate ) {
        $( "#fecha_inicio").datepicker( "option", "maxDate", selectedDate );
    }
    });
	
	function paginador(pagina, items){
		var pagina_actual = (pagina - 1) * items;
		$.ajax({
			type: 'post',
			url:  'app/db/experiencias.php',
			dataType: 'json',
			data:{
				_accion : 'obtener_experiencias',
				_pagina : pagina_actual,
				_items: items
			},
			success: function(data){
				if(data.length > 0){
					var texto ="";
					for(var i=0; i<data.length; i++){
						texto += '<tr data-id="'+data[i].id_experiencia+'" >';
						texto += '<td data-campo="id_experiencia">'+data[i].id_experiencia+' </td><td data-campo="fecha_i">'+data[i].inicio+'</td><td data-campo="fecha_f" >'+data[i].fin+'</td><td align="center"><a data-rol="modificar" href="#"><i title="editar" class="fa fa-pencil-square-o"></i></a></td><td align="center"><a data-rol="eliminar" href="#"><i title="eliminar" class="fa fa-trash"></i></a></td>';
						texto += '</tr>';
					}
					$('#tabla_experiencias tbody').html(texto);
					var table2 = $('#tabla_experiencias').DataTable("language": {
			                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
			            },
			            "bDestroy": true);
					table2.draw('page');
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

	$('input[name="crear_experiencia"]').on('click', function(e){
		var fecha_i = $('#fecha_inicio').val();
		var fecha_f = $('#fecha_fin').val();
		var accion =  $('input[name="accion"]').val();
		var id = $('input[name="id"]').val();

		if( fecha_i != "" && fecha_f != "" ){
			console.log(fecha_i , fecha_f);
			$.ajax({
				type: 'post',
				url:  'app/db/experiencias.php',
				dataType: "json",
				data:{
					_accion : accion,
					_fecha_i : fecha_i,
					_fecha_f : fecha_f,
					_id : id
				},
				success: function(data){
					if (data.estado){
						var mensaje = '';
						if(accion == 'modificar'){
							mensaje = 'Experiencia modificada satisfactoriamente';
							console.log('mod');
						}else{
							mensaje = 'Experiencia creada satisfactoriamente';
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
		}else {
			if(fecha_i == "")
				$('#fecha_inicio').css('border-color','#F00');
			else
				$('#fecha_inicio').css('border-color','#ccc');
			if(fecha_f == "")
				$('#fecha_fin').css('border-color','#F00');
			else
				$('#fecha_fin').css('border-color','#ccc');
		}
	});

	$('#tabla_experiencias').delegate('a[data-rol="modificar"]', 'click', function(e){
		var tr = $(this).closest('tr');
		var id = tr.data('id');

		var fecha_i = tr.find('td[data-campo="fecha_i"]').text();
		var fecha_f = tr.find('td[data-campo="fecha_f"]').text();
		$('input[name="id"]').val(id);
		$('#fecha_inicio').val(fecha_i);
		$('#fecha_fin').val(fecha_f);
		$('input[name="crear_experiencia"]').val("Modificar");
		$('input[name="accion"]').val("modificar");
		$('input[name="cancelar"]').fadeIn();
		e.preventDefault();
	});

	$('input[name="cancelar"]').on('click', function(e){
		$('input[name="id"]').val("");
		$('#fecha_inicio').val("");
		$('#fecha_fin').val("");
		$('input[name="accion"]').val("crear_nuevo");
		$('input[name="crear_experiencia"]').val("Guardar");
		$('input[name="cancelar"]').fadeOut();
	});

	$('#tabla_experiencias').delegate('a[data-rol="eliminar"]', 'click', function(e){
		var tr = $(this).closest('tr');
		var id = tr.data('id');
		var mensaje = 'Esta seguro de eliminar esta experiencia';
		$.fn.SimpleModal({
			model: 'modal',
			btn_ok : 'Aceptar',
			title:    'Mensaje',
			contents: mensaje
		}).addButton("Si", "btn primary", function(){
			this.hide();
			$.ajax({
				type: 'post',
				url:  'app/db/experiencias.php',
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

});