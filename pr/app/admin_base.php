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