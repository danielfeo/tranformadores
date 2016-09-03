<?php
echo '<h2>Experiencias</h2>';
echo '<div class="row formulario">';
		echo '<div class="col-xs-4">';
				echo '<h4>Seleccione una experiencia</h4>';
				echo '<select name="select_exp"><option value="">Seleccione</option></select>';
		echo '</div>';
echo '</div>';
echo '<h2 class="titulo_tabla">Usuarios</h2>';
echo '<table id="tabla_experiencias_usuarios" width="100%" class="datos_administrador">';
	echo '<thead>';
		echo '<tr><th>Organización</th><th>Usuario</th><th>Fecha</th><th></th></tr>';
	echo '</thead>';
	echo '<tbody>';
	echo '</tbody>';
echo '</table>';

echo '<div class="col-xs-12">';
	echo '<div id="pag" class="paginador">';
	echo '</div>';
echo '</div>';

?>
<script src="public/js/resultados.js"></script>