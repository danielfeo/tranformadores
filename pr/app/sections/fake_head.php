<div>
<div class="login">
   <div class="container">
      <div class="row">
         <div class="col-xs-12">
            <ul class="fr">
               <?php 
                  if ( isset($_SESSION['usuario']) ){
                  echo '<li><a href="CambiarDatosUsuario">Cambiar contraseña</a>';
                  echo '</li><li><a href="#" class="salir">Salir</a>';
                  echo '</li>';
                  }
                  ?>
            </ul>
         </div>
      </div>
   </div>
</div>
<div class="menu">
   <div class="container">
      <div class="row">
         <div class="col-xs-12">
            <ul class="Intranet">
               <!--class="current"-->
               <li><a href="http://www.redeamerica.org/Premiolatinoamericanoportugues.aspx">O Prêmio</a></li>
               <li><span>|</span></li>
               <li><a href="http://www.redeamerica.org/Premiolatinoamericanoportugues/Regulamento.aspx.aspx">Regulamento</a></li>
               <li><span>|</span></li>
               <li><a href="http://www.redeamerica.org/Premiolatinoamericanoportugues/Criteriosportugues.aspx">Critérios de avaliação</a></li>
               <li><span>|</span></li>
               <li>
                  <a href="http://www.redeamerica.org/Premiolatinoamericanoportugues/Experiencias.aspx">Experiências</a>
                  <ul class="Sub_Intranet">
                     <li><a href="http://www.redeamerica.org/Premiolatinoamericanoportugues/Experiencias/2013.aspx">2013</a></li>
                  </ul>
               </li>
               <li><span>|</span></li>
               <li><a href="http://www.redeamerica.org/Premiolatinoamericanoportugues/juri.aspx">Júri</a></li>
               <li><a href="/PremioLatinoamericano.aspx" class="idioma_es"></a></li>
            </ul>
            <br style="clear:left;">
         </div>
      </div>
   </div>
   <div class="banner">
      <div class="container">
         <div class="row">
            <div class="col xs-12">
               <div id="LogoRow">
                  <div class="LogoRowLeft">
                     <a href="http://www.redeamerica.org/Premiolatinoamericanoportugues.aspx">
                     <img src="http://www.redeamerica.org/Portals/_default/Skins/DarkKnight/Images/logo_transformadores.png" width="494" height="130"></a>
                  </div>
                  <div class="LogoRowRight">
                     <div class="RedesSociales">
                        <a class="RSMail" href="http://www.redeamerica.org/Contactenos.aspx"></a> 
                        <a class="RSYoutube" href="http://www.youtube.com/user/redeamerica2011" target="_blank"></a>
                        <a class="RSTwitter" href="http://twitter.com/#!/redeamerica" target="_blank"></a>
                        <a class="RSFacebook" href="https://www.facebook.com/pages/RedEAm%C3%A9rica/195482497145833" target="_blank"></a>
                     </div>
                     <div class="Fecha"><span id="dnn_dnnCURRENTDATE_lblDate" class="SkinFecha"><?php echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y');?></span></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>