<?php
require_once("../sistem/ayar.php");
require_once("../sistem/fonksiyon.php");
$sayfa_link=$_GET["sayfa_link"];
if (!$sayfa_link) {
  header("Location:../Anasayfa");
}
$sayfa=$db->query("SELECT * FROM sayfalar WHERE sayfa_link='$sayfa_link' and sayfa_durum=1")->fetch(PDO::FETCH_ASSOC);
if (!$sayfa) {
  header("Location:../Anasayfa");
}
?>
<!DOCTYPE html>
<html>
<head>
  <base href="<?php echo ayarlar($db,"ayar_url"); ?>" />
  <meta charset="utf-8">
  <title><?php echo ayarlar($db,"ayar_title"); ?></title>
  <link rel="stylesheet" href="assets/css/custom.css" media="screen" charset="utf-8">
  <link rel="stylesheet" href="assets/css/bootstrap.css" media="screen" charset="utf-8">
  <link rel="stylesheet" href="assets/css/font-awesome.css" media="screen" charset="utf-8">
  <link rel="icon" href="favicon.ico">

  <meta name="title" content="<?php echo $sayfa["sayfa_adi"];?>" />
  <meta name="description" content="<?php echo $sayfa["sayfa_description"];?>" />
  <link rel="image_src" href="<?php ayarlar($db,"ayar_logo");?>" />

  <meta name="keyword" content="<?php echo $sayfa["sayfa_keyword"];?>">
</head>
<body>
  <?php require_once("../include/header.php"); ?>
  <div class="container-fluid main">
    <div class="row">
      <div class="col-md-9">
        <?php
        sayfaiceriklistele($db,$sayfa_link);
        ?>
      </div>
      <div class="col-md-3">
        <?php require_once("rightsidebar.php") ?>
      </div>
    </div>
    <?php require_once("../include/footer.php"); ?>
  </body>
  </html>
