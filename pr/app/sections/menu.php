<?php
$grupos = $app['mysql']->runQuery('SELECT * FROM grupos WHERE id_grupo = id_grupo_padre AND id_lenguaje = '.$app['lenguaje'].'')->getRows();
echo '<ul class="pasosInscripcion">';
    for ($i=0; $i<count($grupos); $i++)
        echo '<li><a class="it'.($i + 1).' '.($app['pagina'] == $grupos[$i]['url'] ? 'active' : '').'" href="'.$grupos[$i]['url'].'"><span class="visible-xs">'.($i + 1).'</span><span class="hidden-xs">'.$grupos[$i]['titulo'].'</a></li>';
echo '</ul>';