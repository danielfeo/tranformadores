<?php
$items_paginas = 10;
$total = $app['mysql']->runQuery('SELECT COUNT(*) as total FROM experiencias')->getRows();
$paginas = ceil($total[0]['total'] / 10);
echo '<br><h4>Crear/Editar Experiencias</h4><br>';
echo '<div class="row formulario">';
		echo '<div class="col-xs-3 form-group">';
				echo '<label>Fecha Inicio</label>';
				echo '<input type="text" class="form-control" id="fecha_inicio" placeholder="Inicio">';
		echo '</div>';
		echo '<div class="col-xs-3 form-group">';
				echo '<label>Fecha Fin</label>';
				echo '<input type="text" class="form-control" id="fecha_fin" placeholder="Fin">';
		echo '</div>';
		echo '<div class="col-xs-12 form-group">';
				echo '<input type="hidden" name="id" value="">';
                echo '<input type="hidden" name="accion" value="guardar_experiencia">';
                echo '<input type="button" name="crear_experiencia" class="btn btn-default enviar" value="Guardar">&nbsp<input name="cancelar" class="oculto btn btn-default danger" type="button" value="Cancelar">';
		echo '</div>';
echo '</div>';
echo '<br><h4>Experiencias</h4><br>';
echo '<table id="tabla_experiencias" width="100%" class="table table-striped">';
	echo '<thead>';
		echo '<tr><th>Id</th><th>Fecha Inicio</th><th>Fecha Finalización</th><th></th></th><th></tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '</tbody>';
echo '</table>';
/*
echo '<div class="col-xs-12">';
	echo '<div class="paginador">';
	for($i=0; $i<$paginas; $i++ ){
		echo '<a href="#">'.($i+1).'</a>';
	}
	echo '</div>';
echo '</div>';
*/
?>
<script src="public/js/experiencias.js"></script>