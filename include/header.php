<div class="container-fluid bg-cizgi"></div>
<div class="container-fluid header">
  <div class="row pb10 pt10">
    <div class="col-md-12">
      <div class="col-md-3">
        <a href="<?php echo ayarlar($db,"ayar_url"); ?>" title="<?php echo ayarlar($db,"ayar_title"); ?>">
          <img src="img/Ayar/Thumb/<?php echo ayarlar($db,"ayar_logo"); ?>" alt="<?php echo ayarlar($db,"ayar_title"); ?>" class="img-responsive logo" />
        </a>
      </div>
      <div class="col-md-9">
        <ul class="ust_menu">
          <li><a href="<?php echo ayarlar($db,"ayar_url"); ?>" title="Anasayfa <?php echo ayarlar($db,"ayar_title"); ?>">Anasayfa</a></li>
          <?php menulistele($db); ?>
          <!--<li><a href="iletisim" title="İletişim <?php echo ayarlar($db,"ayar_title"); ?>">İletişim</a></li>-->
          <?php menusosyalicon($db); ?>
        </ul>
      </div>
    </div>
  </div>
</div>
