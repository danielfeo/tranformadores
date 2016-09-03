<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transformadores</title>
    <script src="public/js/jquery.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/app.js"></script>
    <script src="public/js/simple-modal.js"></script>
    <link rel="stylesheet" href="public/css/normalize.css">
    <link rel="stylesheet" href="public/css/bootstrap.css">
    <link rel="stylesheet" href="public/js/assets/css/simplemodal.css">
    <link rel="stylesheet" href="public/css/app.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css">
</head>
<body>
    <nav>
        <?php include 'sections/fake_head.php' ?>
    </nav>
    <section>
        <div id="breadcrump">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <span class="intro"></span>
                        <span ><a href="http://www.redeamerica.org/PremioLatinoamericano.aspx" class="SkinObject">Premio Latinoamericano</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table width="100%" class="menu_admin">
                            <tr> 
                                <th width="33.3%"><a id="bt_usuarios" class="<?php echo ($app['pagina'] == 'Usuarios' ? 'active' : '') ?>" href="Usuarios">Usuarios</a></th>
                                <th width="33.3%"><a id="bt_experiencias" class="<?php echo ($app['pagina'] == 'Experiencias' ? 'active' : '' ) ?>" href="Experiencias">Experiencias</a></th>
                                <th width="33.3%"><a id="bt_resultados" class="<?php echo ($app['pagina'] == 'Resultados' ? 'active' : '' ) ?>" href="Resultados">Resultados</a></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                            switch ($app['pagina']) {
                                case 'Usuarios':
                                    include ('sections/admin_usuarios.php');
                                break;
                                case 'Experiencias':
                                    include ('sections/admin_experiencias.php');
                                break;
                                case 'Resultados':
                                    include ('sections/resultados.php');
                                break;
                            }
                        ?>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</body>
</html>