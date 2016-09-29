    <?php include 'sections/fake_head.php' ?>
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
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 form-group oculto organizacion">
                                <label for="organizacion">Organización</label>
                                <input type="text" placeholder="Organización" class="form-control" name="organizacion">
                            </div>
                            <div class="col-md-4 col-md-offset-4 form-group">
                                <label for="usuario">Correo</label>
                                <input type="text" placeholder="Correo" class="form-control" name="usuario">
                            </div>
                            <div class="col-md-4 col-md-offset-4 form-group">
                                <label for="clave">Contraseña</label>
                                <input type="password" placeholder="Contraseña" class="form-control" name="clave">
                                <input type="hidden" value="ingresar" name="accion"> 
                            </div>
                            <div class="col-md-4 col-md-offset-4 form-group">
                                <label for="">Categoria</label>
                                <select name="categoria" id="" class="form-control">
                                    <option value="1">Categoria 1</option>
                                    <option value="2">Categoria 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 form-group">
                                <input class="btn btn-default enviar" type="button" value="Ingresar" name="guardar">
                                <a id="olvido" class="pull-right" style="padding-top:15px;" href="Recordar">Olvido su contraseña</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="height:300px">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'sections/fake_foot.php' ?>
    <script src="public/js/moment.min.js"></script>
    <script src="public/js/pt-br.js"></script>
    <script src="public/js/bootstrap-datetimepicker.min.js"></script>
    <script src="public/js/bootstrap-select.js"></script>
    <script src="public/js/jquery.scrollUp.js"></script>
    <script src="public/js/callScrollUp.js"></script>
    <script src="public/js/collapse.js"></script>
    <script src="public/js/menuTop.js"></script>
    <script src="public/js/analytics.js"></script>
    <script>
        $('#datetimepicker1').datetimepicker();
    </script>
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
                $(".nav-pills > li a").on("mouseover", function(event){
                    var $this = $(this).parent().find(">ul");
                    if($this.length == 0) return;
                    dnn.addIframeMask($this[0]);
                });
                $(".dropdown").attr("aria-haspopup", "true");
                $(".dropdownactive").attr("aria-haspopup", "true");
                $(".dropdown-menu").attr("aria-haspopup", "false");
            });
        })(jQuery);
    </script>
</body>
</html>