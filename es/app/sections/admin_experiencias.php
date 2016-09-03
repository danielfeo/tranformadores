<?php
$items_paginas = 10;
$total = $app['mysql']->runQuery('SELECT COUNT(*) as total FROM experiencias')->getRows();
$paginas = ceil($total[0]['total'] / 10);
echo '<h2>Crear/Editar Experiencias</h2>';
echo '<div class="row formulario">';
		echo '<div class="col-xs-4">';
				echo '<h4>Fecha Inicio</h4>';
				echo '<input type="text" id="fecha_inicio" placeholder="Inicio">';
		echo '</div>';
		echo '<div class="col-xs-4">';
				echo '<h4>Fecha Fin</h4>';
				echo '<input type="text" id="fecha_fin" placeholder="Fin">';
		echo '</div>';
		echo '<div class="col-xs-12">';
				echo '<input type="hidden" name="id" value="">';
                echo '<input type="hidden" name="accion" value="guardar_experiencia">';
                echo '<h4><input type="button" name="crear_experiencia" class="jbtn green" value="Guardar">&nbsp<input name="cancelar" class="oculto jbtn red" type="button" value="Cancelar"></h4>';
		echo '</div>';
echo '</div>';
echo '<h2 class="titulo_tabla">Experiencias</h2>';
echo '<table id="tabla_experiencias" width="100%" class="datos_administrador">';
	echo '<thead>';
		echo '<tr><th>Id</th><th>Fecha Inicio</th><th>Fecha Finalización</th><th></th></th><th></tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '</tbody>';
echo '</table>';

echo '<div class="col-xs-12">';
	echo '<div class="paginador">';
	for($i=0; $i<$paginas; $i++ ){
		echo '<a href="#">'.($i+1).'</a>';
	}
	echo '</div>';
echo '</div>';

?>
<script src="public/js/experiencias.js"></script>