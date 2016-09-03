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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="css/estilosTr.css">
    <title>Transformadores :: Datos generales de la experiencia </title>
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
                            <label for="organizacion" class="oculto">Organización<input type="text" placeholder="Organización" name="organizacion"></label>
                            <label for="usuario">Correo<input type="text" placeholder="Correo" name="usuario"></label>
                            <label for="clave">Contraseña<input type="password" placeholder="Contraseña" name="clave"></label>
                            <input type="hidden" value="ingresar" name="accion"> 
                            <input class="jbtn green" type="button" value="Ingresar" name="guardar">
                            <a id="olvido" class="pull-right" style="padding-top:15px;"href="Recordar">Olvido su contraseña</a>
                        </div>
                        <div class="col-xs-4"></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-4">
                            <hr><button class="jbtn orange" id="registro">Registrese</button>
                            <p>Solo para miembros de la Red</p>
                        </div>
                        <div class="col-xs-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>