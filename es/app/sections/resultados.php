<?php
echo '<br><h4>Experiencias</h4><br>';
echo '<div class="row formulario">';
		echo '<div class="col-xs-3 form-group">';
				echo '<label>Seleccione una experiencia</label>';
				echo '<select name="select_exp" class="form-control"><option value="">Seleccione</option></select>';
		echo '</div>';
echo '</div>';
echo '<br><h4>Usuarios</h4><br>';
echo '<table id="tabla_experiencias_usuarios" width="100%" class="table table-striped">';
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