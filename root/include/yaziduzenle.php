<?php

$id=$_GET["id"];
if (!$id) {
  header("Location:main.php");
}else{
  $yazi=$db->query("SELECT * FROM yazilar WHERE yazi_id=$id")->fetch(PDO::FETCH_ASSOC);
  if (!$yazi) {
    header("Location:main.php");
  }
}
if ($_POST["kayitguncelle"]) {
  require('class.upload.php');
  $yazi_yazarId                 = $_SESSION["kullanici_id"];
  $yazi_kategori                = p("yazi_kategori");
  $yazi_adi                     = p("yazi_adi");
  $yazi_link                    = seflink($yazi_adi);
  $yazi_description             = p("yazi_description");
  $yazi_keyword                 = p("yazi_keyword");
  $yazi_icerik                  = p("yazi_icerik");
  $tarih                        = date("Ymd-His");
  $yazi_kayitTarihi             = date("Y-m-d H:i:s");
  $yazi_iconResmi               = $_FILES["yazi_icon"]["tmp_name"];
  //echo '<script type="text/javascript">alert("'.$yazi_icerik.'");</script>';
  if (strlen($yazi_iconResmi)>4) {
    $image=new Upload($_FILES["yazi_icon"]);
    if ($image->uploaded) {

      //BİG//

      //resim boyutu kontrolü
      //$image->file_max_size='4096';
      //resim formatları belirleme
      $image->allowed=array('image/*');
      //yeniden resim adı oluşturma
      $image->file_new_name_body=$tarih.$yazi_link;
      //resim adının başına ekleme yapmak
      $image->file_new_name_pre=$yazi_link.'-';
      //resim boyutlandırma

      $image->Process("../img/Yazi/Big/");
      if ($image->processed) {

        //THUMB//
        $image->image_resize=true;
        $image->image_x=375;
        $image->image_y=150;

        //resim boyutu kontrolü
        //$image->file_max_size='4096';
        //resim formatları belirleme
        $image->allowed=array('image/*');
        //yeniden resim adı oluşturma
        $image->file_new_name_body=$tarih.$yazi_link;
        //resim adının başına ekleme yapmak
        $image->file_new_name_pre=$yazi_link.'-';
        //resmin önüne resim eklemek için
        //$image->image_watermark="asd.jpg";
        //resim boyutlandırma

        $image->Process("../img/Yazi/Thumb/");
        $yazi_icon=$image->file_dst_name;
        //echo "<script type='text/javascript'>alert('".$yazi_icon."');</script>";

        if ($image->processed) {
          $query=$db->prepare("UPDATE yazilar SET
            yazi_kategori = ?,
            yazi_adi = ?,
            yazi_yazarId = ?,
            yazi_link = ?,
            yazi_kisaAciklama = ?,
            yazi_keyword = ?,
            yazi_description = ?,
            yazi_icerik = ?,
            yazi_icon = ?,
            yazi_guncellemeTarihi = ?
            WHERE yazi_id=$id
            ");
            $insert=$query->execute(array(
              $yazi_kategori,
              $yazi_adi,
              $yazi_yazarId,
              $yazi_link,
              $yazi_description,
              $yazi_keyword,
              $yazi_description,
              $yazi_icerik,
              $yazi_icon,
              $yazi_kayitTarihi
            ));
            if ($insert) {
              echo
              '
              <section class="content-header">
              <h1>
              <i class="fa fa-archive"></i> Yazi Düzenle
              </h1>
              <div class="callout callout-success">
              <h4>Yazi Bilgileri Başarıyla Düzenlendi!</h4>
              <p>Teşekkürler.</p>
              </div>
              </section>
              ';
              header("Refresh:3; url=main.php?sayfa=yaziduzenle&id=$id");
            }
          }else{
            $hata=$image->error;
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-archive"></i> Yazi Düzenle
            </h1>
            <div class="callout callout-danger">
            <h4>'.$hata.'</h4>
            </div>
            </section>
            ';
          }
        }else{
          $hata=$image->error;
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-archive"></i> Yazi Düzenle
          </h1>
          <div class="callout callout-danger">
          <h4>'.$hata.'</h4>
          </div>
          </section>
          ';
        }
      }
    }else{
      $query=$db->prepare("UPDATE yazilar SET
        yazi_kategori = ?,
        yazi_adi = ?,
        yazi_yazarId = ?,
        yazi_link = ?,
        yazi_kisaAciklama = ?,
        yazi_keyword = ?,
        yazi_description = ?,
        yazi_icerik = ?,
        yazi_guncellemeTarihi = ?
        WHERE yazi_id=$id
        ");
        $insert=$query->execute(array(
          $yazi_kategori,
          $yazi_adi,
          $yazi_yazarId,
          $yazi_link,
          $yazi_description,
          $yazi_keyword,
          $yazi_description,
          $yazi_icerik,
          $yazi_kayitTarihi
        ));
        if ($insert) {
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-archive"></i> Yazi Düzenle
          </h1>
          <div class="callout callout-success">
          <h4>Yazi Bilgileri Başarıyla Düzenlendi!</h4>
          <p>Teşekkürler.</p>
          </div>
          </section>
          ';
          header("Refresh:3; url=main.php?sayfa=yaziduzenle&id=$id");
        }else{
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-archive"></i> Yazi Düzenle
          </h1>
          <div class="callout callout-success">
          <h4>Yazi Bilgileri Düzenlenemedi!</h4>
          <p>Teşekkürler.</p>
          </div>
          </section>
          ';
        }
      }


    }else{
      echo
      '
      <section class="content-header">
      <h1>
      <i class="fa fa-archive"></i> Yazi Düzenle
      </h1>
      <h3 class="text-center">'.$yazi["yazi_adi"].'</h3>
      </section>
      ';
    }
    ?>


    <!-- Main content -->

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="box-body">
              <div class="form-group">
                <label  class="col-sm-2 control-label">Kategori</label>
                <div class="col-sm-10">
                  <select aria-hidden="true" tabindex="-1" class="form-control select2 select2-hidden-accessible" name="yazi_kategori" style="width: 100%;">
                      <?php echo kategorisecili($db,$yazi["yazi_kategori"]); ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazi Adı</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Yazi Adı" type="text" name="yazi_adi" value="<?php echo $yazi["yazi_adi"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazi Description</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Yazi Kısa Açıklaması" type="text" name="yazi_description" value="<?php echo $yazi["yazi_description"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazi Keyword</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Yazi Keyword" type="text" name="yazi_keyword" value="<?php echo $yazi["yazi_keyword"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazi İçerik</label>
                <div class="col-sm-10">
                  <textarea class="ckeditor" cols="80" id="yazi_icerik" name="yazi_icerik" rows="10"><?php echo $yazi["yazi_icerik"]; ?></textarea>
                  <script language="javascript" type="text/javascript">
                  CKEDITOR.replace('yazi_icerik',{
                    filebrowserBrowseUrl: '/browser/browse.php',
                    filebrowserImageBrowseUrl: '/browser/browse.php?type=Images',
                    filebrowserUploadUrl: '/uploader/upload.php',
                    filebrowserImageUploadUrl: '/uploader/upload.php?type=Images',
                    filebrowserWindowWidth: '900',
                    filebrowserWindowHeight: '400',
                    filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?Type=Images',
                    filebrowserFlashBrowseUrl: '/ckfinder/ckfinder.html?Type=Flash',
                    filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                  });
                  </script>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazi İcon</label>
                <div class="col-sm-10">
                  <input id="exampleInputFile" type="file" name="yazi_icon">
                </div>
                <div class="col-sm-10">
                  <img src="../img/Yazi/Thumb/<?php echo $yazi["yazi_icon"]; ?>" alt="<?php echo $yazi["yazi_adi"]; ?>" />
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="submit" name="kayitguncelle" value="Kayıt Güncelle" class="btn btn-info pull-left col-md-3" >
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->




    <?php require_once("include/footerinc.php");?>
