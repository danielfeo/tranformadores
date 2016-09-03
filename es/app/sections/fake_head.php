<div class="fluidTop">
    <div class="container">
        <div class="row">
            <div class="hidden-sm hidden-xs col-md-3 col-lg-2 fecha">
                <?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y');?>
            </div>
            <div class="hidden-xs col-sm-2 telefono" id="telefono">
                <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> (57 1) 310 0379
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 intranet" id="ingresarTransformadores">
                <div class="text-center">
                    <?php  if ( isset($_SESSION['usuario']) ) { ?>
                        <a data-toggle="modal" href="#defaultModal2" class="senha">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            Cambiar clave
                        </a>
                        <a href="#" class="saida">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                            Salir
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-2 idioma" id="idioma">
                <a href="/pt/Transformadores"><img alt="" src="img/icon-pt.png" />Portugu&ecirc;s</a>
            </div>
            <div class="col-xs-2 redes">
                <a href="//www.facebook.com/RedEAmerica/" target="_blank"><img src="img/fb.png"></a>
                <a href="//twitter.com/redeamerica" target="_blank"><img src="img/tw.png"></a>
                <a href="//www.youtube.com/user/redeamerica2011" target="_blank"><img src="img/yt.png"></a>
                <a href="//www.instagram.com/redeamerica/" target="_blank"><img src="img/it.png"></a>
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
              <form>
                <div class="form-group">
                  <label for="exampleInputPassword1">Clave anterior</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Clave"/>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword2">Clave nueva</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Clave"/>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-ingresar">CAMBIAR</button>
                </div>
              </form>
            </div>
        </div> <!--modal-content-->
    </div> <!--modal-dialog-->
</div> <!--modal-->
<div class="fluidHeader">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-sm-4 logo" id="logoTransformadores" >
                <a href="/Transformadores"><img alt="" src="img/logo-transformadores.png" /></a>
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
                                <a href="/Transformadores/Reglamento">Reglamento</a>
                                </li>
                                <li>
                                <a href="/Transformadores/Criterios-Evaluacion">Criterios de evaluaci&oacute;n</a>
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