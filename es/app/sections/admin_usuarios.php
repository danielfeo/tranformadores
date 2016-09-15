<?php
$items_paginas = 10;
$total = $app['mysql']->runQuery('SELECT COUNT(*) as total FROM usuarios')->getRows();
$paginas = ceil($total[0]['total'] / 10);
echo '<h3>Crear/Editar Usuarios</h3><br>';
echo '<div class="row formulario">';
		echo '<div class="col-xs-3 form-group">';
				echo '<label>Organización</label>';
				echo '<input type="text" name="organizacion" class="form-control" placeholder="Organización">';
		echo '</div>';
		echo '<div class="col-xs-3 form-group">';
				echo '<label>Email</label>';
				echo '<input type="text" name="usuario" class="form-control" placeholder="Email">';
		echo '</div>';
		echo '<div class="col-xs-3 form-group">';
				echo '<label>Contraseña</label>';
				echo '<input type="password" name="contraseña" class="form-control" placeholder="Clave">';
		echo '</div>';
		echo '<div class="col-xs-3 form-group">';
				echo '<h4><input type="checkbox" name="habilitado"> Habilitado</h4>';
				echo '<h4 style="padding-top: 0px;"><input type="checkbox" name="administrador"> Administrador</h4>';
		echo '</div>';
		echo '<div class="col-xs-4 form-group">';
				echo '<input type="hidden" name="id" value="">';
				echo '<input type="hidden" name="accion" value="registro">';
				echo '<h4><input type="button" name="crear_nuevo" class="btn btn-default enviar" value="Guardar">&nbsp<input name="cancelar" class="oculto jbtn red" type="button" value="Cancelar"></h4>';
		echo '</div>';
echo '</div>';

echo '<h2 class="titulo_tabla" >Usuarios</h2>';
echo '<table id="tabla_usuarios" width="100%" class="datos_administrador">';
	echo '<thead>';
		echo '<tr><th>Organización</th><th>Usuario</th><th>Habilitado</th><th>Administrador</th></th><th></th></th><th></th></tr>';
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
<script src="public/js/usuarios.js"></script>