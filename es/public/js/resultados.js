$(function(){

	

	
	var items_paginas = 10;
	var select = $('select[name="select_exp"]');

	function cargarSelect(){
		$.ajax({
			type: 'post',
			url:  'app/db/resultados.php',
			dataType: 'json',
			data:{
				_accion : 'obtener_experiencias'
			},
			success: function(data){
				if(data.length > 0){
					var options = "";
					for(var i=0; i<data.length; i++){
						options += '<option value='+data[i].id_experiencia+'>'+data[i].año+'</option>';
					}
					select.append(options);
				}else{

				}
			}
		});
	}

	function paginador(pagina, items){
		var pagina_actual = (pagina - 1) * items;
		$.ajax({
			type: 'post',
			url:  'app/db/resultados.php',
			dataType: 'json',
			data:{
				_accion : 'obtener_usuario_exp',
				_exp : select.val(),
				_pagina : pagina_actual,
				_items: items
			},
			success: function(data){
				if(data.length > 0){
					var texto = "";
					for(var i=0; i<data.length; i++){
						texto += '<tr data-id="'+data[i].id_usuario+'" >';
						texto += '<td>'+data[i].organizacion+'</td><td>'+data[i].email+'</td><td>'+data[i].fecha+'</td><td width="3%"><a target="_blank" href="pdf'+data[i].id_usuario+'-'+select.find('option:selected').text()+'"><i title="Descargar" class="fa fa-download"></i></a></td>';
						texto += '</tr>';
					}
					$('#tabla_experiencias_usuarios tbody').html(texto);
					var table = $('#tabla_experiencias_usuarios').DataTable("language": {
			                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
			            },
			            "bDestroy": true);
					table.draw('page');


				}else{

				}
					
				
			}
		});
	}

	function totalPaginas(){
		$.ajax({
			type: 'post',
			url:  'app/db/resultados.php',
			dataType: 'json',
			data:{
				_accion : 'obtener_total_pag',
				_exp : select.val()
			},
			success: function(data){
				console.log(data);
				var texto = "";
				for(var i=0; i<data['paginas']; i++ ){
					texto += '<a href="#">'+(i+1)+'</a>';
				}
				$('#pag').html(texto);
			}
		});
	}

	select.on('change', function(e){
		totalPaginas();
		paginador(1, items_paginas);
	});

	$('.paginador').delegate('a', 'click', function(e){
		$('.paginador a').removeClass('active');
		$(this).addClass('active');
		var pagina = $(this).text();
		paginador(pagina, items_paginas);
		e.preventDefault();
	});

	cargarSelect();
});