<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Transformadores :: Dados Gerais da Experiência</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/simple-modal.js"></script>
    <script src="public/js/app.js"></script>
    <script src="public/js/usuarios.js"></script>
    <script src="public/js/fileupload.js"></script>
   <!-- <link rel="stylesheet" href="public/css/normalize.css">
    <link rel="stylesheet" href="public/css/bootstrap.css">-->

    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/bootstrap-select.css"><!-- 1 -->
    <link rel="stylesheet" href="public/css/bootstrap-datetimepicker.css"><!-- 2 -->
    <link rel="stylesheet" href="public/css/jquery-ui.css"><!-- 2 -->
    <link rel="stylesheet" href="public/css/estilosTr.css"><!-- 3 -->
    <link rel="stylesheet" href="public/js/assets/css/simplemodal.css">
    <!--<link rel="stylesheet" href="public/css/app.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <!--Datatables-->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">

    
    
</head>
<body>

   <div class="fluidTop">
      <div class="container">
         <div class="row">
            <div class="hidden-sm hidden-xs col-md-3 col-lg-2 fecha">
               miércoles, 24 de agosto de 2016
            </div>
            <div class="hidden-xs col-sm-2 telefono" id="telefono">
               <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> (57 1) 310 0379
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 intranet" id="ingresarTransformadores">
               <div class="text-center">
                  <?php if ( isset($_SESSION['usuario']) ){?>
                  <a data-toggle="modal" href="#defaultModal2" href="CambiarDatosUsuario" class="senha">
                     <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                     Cambiar clave
                  </a>
                  <a href="#" class="saida">
                     <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                     Salir
                  </a>
                  <?php }  ?>
               </div>
            </div>
            <div class="col-xs-2 idioma" id="idioma">
               
            </div>
            <div class="col-xs-2 redes">
               <a href="//www.facebook.com/RedEAmerica/" target="_blank"><img src="public/img/fb.png"></a>
               <a href="//twitter.com/redeamerica" target="_blank"><img src="public/img/tw.png"></a>
               <a href="//www.youtube.com/user/redeamerica2011" target="_blank"><img src="public/img/yt.png"></a>
               <a href="//www.instagram.com/redeamerica/" target="_blank"><img src="public/img/it.png"></a>
            </div>
         </div>
      </div>
   </div>
   <div id="defaultModal2" class="modal fade">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                   <h4>Cambiar clave</h4>
               </div>
               <div class="modal-body">
                 <form id='form_cambio_clave'>
                   <div class="form-group">
                     <label for="exampleInputPassword1">Clave anterior</label>
                       <input type="password" class="form-control" id="exampleInputPassword1" name="_contra_ant" placeholder="Clave"/>
                   </div>
                   <div class="form-group">
                     <label for="exampleInputPassword2">Clave nueva</label>
                       <input type="password" class="form-control" id="exampleInputPassword1" name="_contra_nueva" placeholder="Clave"/>
                   </div>
                   <div class="form-group text-center">
                       <button type="submit" class="btn btn-ingresar">CAMBIAR</button>
                   </div>
                   <span id="error"></span>
                 </form>
               </div>
           </div> <!--modal-content-->
       </div> <!--modal-dialog-->
   </div> 
   <div class="fluidHeader">
      <div class="container">
         <div class="row">
            <div class="col-xs-8 col-sm-4 logo" id="logoTransformadores" >
               <a href="/Transformadores"><img alt="" src="public/img/logo-transformadores.png" /></a>
            </div>
            <div class="col-xs-12 col-sm-8 boxMenus">
               
               <div class="row">
                  <div class="col-xs-12 menu navbar">
                     <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                      </div>
                      <div class="collapse navbar-collapse" id="menuTransformadores">
                        <ul class="nav nav-pills NavTransformadores">
                            <li>
                            <a class="" href="/Transformadores">El Premio</a>
                            </li>
                            <li>
                            <a href="/Transformadores/ComunidadesSostenibles">Comunidades Sostenibles</a>
                            </li>
                            <li>
                            <a href="/Transformadores/EmpresaComunidad">Empresa y Comunidad</a>
                            </li>
                            <li class="dropdown ">
                            <a href="#">Experiencias<strong class="hidden-desktop pull-right icon-chevron-down icon-white"></strong></a>
                            <ul class="dropdown-menu">
                                <li>
                                <a href="/Transformadores/Experiencias/2015">2015</a>
                                </li>
                                <li>
                                <a href="/Transformadores/Experiencias/2013">2013</a>
                                </li>
                            </ul>
                            </li>
                            <li>
                            <a href="/Transformadores/Jurados">Jurados</a>
                            </li>
                        </ul>
                      </div>
                  </div>
                  <!-- <a href="/Tutorial/index.html" target="_blank"><div class="tutorial"></div></a> -->
               </div>
            </div>
         </div>
      </div>
   </div>

