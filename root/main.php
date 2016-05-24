<?php
session_start();
ob_start();
require_once("../sistem/ayar.php");
$user=$_SESSION["kullanici_adi"];
$u=$db->query("SELECT * FROM kullanicilar Where kullanici_adi='$user'")->fetch(PDO::FETCH_ASSOC);
if (!$u) {
  echo 'Sakin ol şampiyon';
  header("Refresh:2; url=index.php");
}else{
  ?>
  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $u["kullanici_isim"]." ".$u["kullanici_soyisim"]." Root Paneli"; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/custom.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- DataTable-->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <script src="../ckeditor/ckeditor.js"></script>
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="main.php" class="logo">
          Root PANELİ
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Menü</span>
          </a>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../img/Avatar/Thumb/<?php echo $u["kullanici_avatar"]; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $u["kullanici_isim"]." ".$u["kullanici_soyisim"]; ?></p>
              <!-- Status -->
              <a href="cikis.php"><i class="fa fa-circle text-danger"></i> Çıkış Yap</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">MENÜLER</li>
            <li class="active"><a href="main.php?sayfa=uyelistele" title="Kullanıcılar"><i class="fa fa-user"></i> <span>Kullanıcılar</span></a></li>
            <li class="active"><a href="main.php?sayfa=kategorilistele" title="Kategoriler"><i class="fa fa-archive"></i> <span>Kategoriler</span></a></li>
            <li class="active"><a href="main.php?sayfa=sayfalistele" title="Sayfalar"><i class="fa fa-file"></i> <span>Sayfalar</span></a></li>
            <li class="active"><a href="main.php?sayfa=yazilistele" title="Yazılar"><i class="fa fa-file-text-o"></i> <span>Yazılar</span></a></li>
            <li class="active"><a href="main.php?sayfa=analitik" title="Ayarlar"><i class="fa fa-globe"></i> <span>Analitik</span></a></li>
            <li class="active"><a href="main.php?sayfa=ayarlar" title="Ayarlar"><i class="fa fa-cogs"></i> <span>Ayarlar</span></a></li>
            <!-- Optionally, you can add icons to the links
            <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
            <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
            <li class="treeview">
            <a href="main.php"><i class="fa fa-link"></i> <span>Kullanıcılar</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
            <li><a href="#">Kullanıcı Ekle</a></li>
            <li><a href="#"></a></li>
          </ul>
        </li>-->
      </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php
    $sayfa=$_GET["sayfa"];
    if (!$sayfa) {
      require_once("include/default.php");
    }else{
      require_once("include/".$sayfa.".php");
    }
    ?>
  </div><!-- /.content-wrapper -->

  <!-- Optionally, you can add Slimscroll and FastClick plugins.
  Both of these plugins are recommended to enhance the
  user experience. Slimscroll is required when using the
  fixed layout. -->
</body>
</html>
<?php
}
ob_end_flush();?>
