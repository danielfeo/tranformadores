<?php
$items_paginas = 10;
$total = $app['mysql']->runQuery('SELECT COUNT(*) as total FROM usuarios')->getRows();
$categorias = $app['mysql']->runQuery('SELECT * FROM categoria')->getRows();
$paginas = ceil($total[0]['total'] / 10);

echo '<br><h4>Crear/Editar Usuarios</h4><br>';
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
				echo '<label>Categoria</label>';
				echo '<select name="categoria" class="form-control">';
					foreach ($categorias as $categoria) {
						echo '<option value="'.$categoria['id_categoria'].'">'.$categoria['descripcion'].'</option>';
					}
				echo '</select>';
		echo '</div>';
		echo '<div class="col-xs-12 form-group">';
			echo '<label class="checkbox-inline">';
		    	echo '<input type="checkbox" name="administrador"> Administrador';
		  	echo '</label>';
			echo '<label class="checkbox-inline">';
		    	echo '<input type="checkbox" name="habilitado"> Habilitado';
		  	echo '</label>';
		echo '</div>';
		echo '<div class="col-xs-4 form-group">';
				echo '<input type="hidden" name="id" value="">';
				echo '<input type="hidden" name="accion" value="registro">';
				echo '<input type="button" name="crear_nuevo" class="btn btn-default enviar" value="Guardar">&nbsp<input name="cancelar" class="oculto btn btn-default danger" type="button" value="Cancelar">';
		echo '</div>';
echo '</div>';

echo '<br><h4>Usuarios</h4><br>';
echo '<table id="tabla_usuarios" width="100%" class="table table-striped">';
	echo '<thead>';
		echo '<tr><th>Organización</th><th>Usuario</th><th>Categoria</th><th>Habilitado</th><th>Administrador</th></th><th></th></th><th></th></tr>';
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
<script src="public/js/usuarios.js"></script>