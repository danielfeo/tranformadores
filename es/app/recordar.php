<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transformadores</title>
    <script src="public/js/jquery.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/simple-modal.js"></script>
    <script src="public/js/app.js"></script>
    <script src="public/js/usuarios.js"></script>
    <link rel="stylesheet" href="public/css/normalize.css">
    <link rel="stylesheet" href="public/css/bootstrap.css">
    <link rel="stylesheet" href="public/js/assets/css/simplemodal.css">
    <link rel="stylesheet" href="public/css/app.css">
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
                <div class="row login">
                    <div class="col-xs-12">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-4">
                            <label for="usuario">Correo<input type="text" placeholder="Correo" name="usuario"></label>
                            <input class="jbtn green" type="button" value="Enviar" name="enviar">
                            <a id="olvido" class="pull-right" style="padding-top:15px;"href="login">Ingresar</a>
                        </div>
                        <div class="col-xs-4"></div>
                    </div>
            </div>
        </div>
    </section>
</body>
</html>