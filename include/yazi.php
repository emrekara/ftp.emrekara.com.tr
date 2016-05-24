<?php
/**
 * Created by PhpStorm.
 * User: EMRE
 * Date: 17.04.2016
 * Time: 20:25
 */
require_once("../sistem/ayar.php");
require_once("../sistem/fonksiyon.php");
$yazi_link=$_GET["yazi_link"];
if (!$yazi_link) {
    header("Location:../Anasayfa");
}else{
    $yazi=$db->query("SELECT * FROM yazilar WHERE yazi_link='$yazi_link' and yazi_durum=1")->fetch(PDO::FETCH_ASSOC);
    if (!$yazi) {
        header("Location:../Anasayfa");
    }
    $kullanici_isimSoyisim=kullanici($db,$yazi["yazi_yazarId"],"kullanici_isim")." ".kullanici($db,$yazi["yazi_yazarId"],"kullanici_soyisim");
}
?>
<!DOCTYPE html>
<html>
<head>
    <base href="<?php echo ayarlar($db,"ayar_url"); ?>" />
    <meta charset="utf-8">
    <title><?php echo $yazi["yazi_adi"]; ?></title>
    <link rel="stylesheet" href="assets/css/custom.css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="assets/css/bootstrap.css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="assets/css/font-awesome.css" media="screen" charset="utf-8">
    <link rel="icon" href="favicon.ico">

    <link rel="author" href="<?php echo ayarlar($db,"ayar_google");?>"/>
    <meta name="title" content="<?php echo $yazi["yazi_adi"];?>" />
    <meta name="description" content="<?php echo $yazi["yazi_description"];?>" />
    <meta name="keyword" content="<?php echo $yazi["yazi_keyword"];?>">
    <link rel="image_src" href="img/Yazi/Big/<?php echo $yazi["yazi_icon"];?>" />

</head>
<body>
<?php require_once("../include/header.php"); ?>
<div class="container-fluid main">
    <div class="row">
        <div class="col-md-9">
            <div class="blog row">
                <div class="col-md-12 blog-yazi ">
                    <div class="row ">
                        <div class="col-md-12 blog-baslik">
                            <h3><?php echo $yazi["yazi_adi"];?></h3>
                        </div>
                    </div>
                    <div class="row blog-bilgi">
                        <div class="col-md-12 blog-yazar">
                            <i class="fa fa-user"></i> Yazar: <span class="blog-yazar-icerik"><?php echo $kullanici_isimSoyisim;?></span> &nbsp;
                            <i class="fa fa-clock-o"></i> Tarih: <span class="blog-yazar-icerik"><?php echo $yazi["yazi_kayitTarihi"];?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <img class="img-responsive" src="img/Yazi/Big/<?php echo $yazi["yazi_icon"];?>" alt="<?php echo $yazi["yazi_adi"];?>">
                        </div>
                    </div>
                    <div class="row blog-icerik">
                        <div class="col-md-12">
                            <?php echo $yazi["yazi_icerik"];?>
                        </div>
                    </div>
                    <div class="row blog-paylas">
                        <div class="col-md-12">
                            <div class="ssb">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $yazi["yazi_link"];?>" title="Facebook ta Paylaş" target="_blank" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
                                <a href="https://twitter.com/home?status=<?php echo $yazi["yazi_link"];?>" title="Twitter da Paylaş" target="_blank" class="btn btn-twitter"><i class="fa fa-twitter"></i> Twitter</a>
                                <a href="https://plus.google.com/share?url=<?php echo $yazi["yazi_link"];?>" title="Google+ da Paylaş" target="_blank" class="btn btn-googleplus"><i class="fa fa-google-plus"></i> Google+</a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $yazi["yazi_link"];?>" title="LinkedIn de Paylaş" target="_blank" class="btn btn-linkedin"><i class="fa fa-linkedin"></i> LinkedIn</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <?php require_once("rightsidebar.php") ?>
        </div>
    </div>
    <?php require_once("../include/footer.php"); ?>
</body>
</html>
