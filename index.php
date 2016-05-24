<?php
require_once("sistem/ayar.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo ayarlar($db,"ayar_title"); ?></title>
  <?php require_once("include/seo.php");?>

  <meta name="description" content="<?php echo ayarlar($db,"ayar_description"); ?>" >
  <meta name="keyword" content="<?php echo ayarlar($db,"ayar_keyword"); ?>">


  <!--Twitter-->
  <meta name="twitter:card" value="summary"/>
  <meta name="twitter:url" value="http://www.emrekara.com.tr/"/>
  <meta name="twitter:site" content="@emrekara9353">
  <meta name="twitter:title" content="<?php echo ayarlar($db,'ayar_title');?>"/>
  <meta name="twitter:creator" content="@emrekara9353"/>
  <meta name="twitter:description" content="<?php echo ayarlar($db,'ayar_description');?>"/>

  <!--Google Sheme-->
  <meta itemprop="name" content="Emre Kara | Web Master | Kişisel Blog">
  <meta itemprop="description" content="<?php echo ayarlar($db,'ayar,description');?>">
  <meta itemprop="image" content="http://www.emrekara.com.tr/img/Yazi/Big/20160428-001441YaYanmYYlYklarla_YaYYyorum.jpg">

  <!-- Open Graph -->
  <meta property="og:type" content="article">
  <meta property="article:author" content="https://www.facebook.com/emrekara93">
  <meta property="article:publisher" content="https://www.facebook.com/emrekara93">
  <meta property="og:title" content="Emre Kara | Web Master | Kişisel Blog">
  <meta property="og:description" content="<?php echo ayarlar($db,'ayar_description');?>">
  <meta property="og:image" content="http://www.emrekara.com.tr/img/Yazi/Big/20160428-001441YaYanmYYlYklarla_YaYYyorum.jpg">

</head>
<body>
  <?php require_once("include/header.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-9">
      <?php
      echo anasayfayazilistele($db);
      ?>
      </div>
      <div class="col-md-3">
        <?php require_once("include/rightsidebar.php"); ?>
      </div>
    </div>
  </div>
  <?php require_once("include/footer.php"); ?>
</body>
</html>
