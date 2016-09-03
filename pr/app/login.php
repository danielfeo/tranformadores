
        
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
                    <div class="col-xs-12">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-4">
                            <label for="organizacion" class="oculto">Organización<input type="text" placeholder="Organización" name="organizacion"></label>
                            <label for="usuario">E-mail<input type="text" placeholder="E-mail" name="usuario"></label>
                            <label for="clave">Senha<input type="password" placeholder="Senha" name="clave"></label>
                            <input type="hidden" value="ingresar" name="accion"> 
                            <input class="jbtn green" type="button" value="Entrar" name="guardar">
                            <a id="olvido" class="pull-right" style="padding-top:15px;"href="Recordar">Esqueceu a senha?</a>
                        </div>
                        <div class="col-xs-4"></div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-4">
                            <hr><button class="jbtn orange" id="registro">Cadastre-se</button>
                            <p>Apenas para membros da rede</p>
                        </div>
                        <div class="col-xs-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

    <script src="public/js/jquery-1.11.0.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
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
</html>