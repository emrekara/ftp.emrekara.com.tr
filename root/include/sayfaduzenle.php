<?php

$id=$_GET["id"];
if (!$id) {
  header("Location:main.php");
}else{
  $sayfa=$db->query("SELECT * FROM sayfalar WHERE sayfa_id=$id")->fetch(PDO::FETCH_ASSOC);
  if (!$sayfa) {
    header("Location:main.php");
  }
}
if ($_POST["kayitguncelle"]) {
  require('class.upload.php');
  $sayfa_yazarId                 = $_SESSION["kullanici_id"];
  $sayfa_ustId                   = p("sayfa_ustId");
  $sayfa_adi                     = p("sayfa_adi");
  $sayfa_link                    = seflink($sayfa_adi);
  $sayfa_description             = p("sayfa_description");
  $sayfa_keyword                 = p("sayfa_keyword");
  $sayfa_icerik                  = p("sayfa_icerik");
  $tarih                         = date("Ymd-His");
  $sayfa_kayitTarihi             = date("Y-m-d H:i:s");
  $sayfa_iconResmi               = $_FILES["sayfa_icon"]["tmp_name"];
  $sayfa_durum=1;

  //echo "<script type='text/javascript'>alert('".$sayfa_iconResmi."');</script>";
  if (strlen($sayfa_iconResmi)>4) {
    $image=new Upload($_FILES["sayfa_icon"]);
    if ($image->uploaded) {

      //BİG//

      //resim boyutu kontrolü
      //$image->file_max_size='4096';
      //resim formatları belirleme
      $image->allowed=array('image/*');
      //yeniden resim adı oluşturma
      $image->file_new_name_body=$tarih.$sayfa_adi;
      //resim adının başına ekleme yapmak
      $image->file_new_name_pre=$sayfa_adi.'-';
      //resim boyutlandırma
      $image->image_resize=true;
      $image->image_x=1000;
      $image->image_y=1000;
      $image->image_ratio_fill=true;

      $image->Process("../img/Sayfa/Big/");
      if ($image->processed) {

        //THUMB//

        //resim boyutu kontrolü
        //$image->file_max_size='4096';
        //resim formatları belirleme
        $image->allowed=array('image/*');
        //yeniden resim adı oluşturma
        $image->file_new_name_body=$tarih.$sayfa_adi;
        //resim adının başına ekleme yapmak
        $image->file_new_name_pre=$sayfa_adi.'-';
        //resmin önüne resim eklemek için
        //$image->image_watermark="asd.jpg";
        //resim boyutlandırma
        $image->image_resize=true;
        $image->image_x=250;
        $image->image_y=250;
        $image->image_ratio_fill=true;

        $image->Process("../img/Sayfa/Thumb/");
        $sayfa_icon=$image->file_dst_name;
        if ($image->processed) {
          $query=$db->prepare("UPDATE sayfalar SET
            sayfa_ustId = ?,
            sayfa_adi = ?,
            sayfa_yazarId = ?,
            sayfa_link = ?,
            sayfa_kisaAciklama = ?,
            sayfa_keyword = ?,
            sayfa_description = ?,
            sayfa_icerik = ?,
            sayfa_icon = ?,
            sayfa_durum = ?,
            sayfa_guncellemeTarihi = ?
            WHERE sayfa_id=$id
            ");
            $update=$query->execute(array(
              $sayfa_ustId,
              $sayfa_adi,
              $sayfa_yazarId,
              $sayfa_link,
              $sayfa_description,
              $sayfa_keyword,
              $sayfa_description,
              $sayfa_icerik,
              $sayfa_icon,
              $sayfa_durum,
              $sayfa_kayitTarihi
            ));
            if ($update) {
              echo
              '
              <section class="content-header">
              <h1>
              <i class="fa fa-archive"></i> Sayfa Düzenle
              </h1>
              <div class="callout callout-success">
              <h4>Sayfa Bilgileri Başarıyla Düzenlendi!</h4>
              <p>Teşekkürler.</p>
              </div>
              </section>
              ';
              header("Refresh:3; url=main.php?sayfa=sayfaduzenle&id=$id");
            }
          }else{
            $hata=$image->error;
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-archive"></i> Sayfa Düzenle
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
          <i class="fa fa-archive"></i> Sayfa Düzenle
          </h1>
          <div class="callout callout-danger">
          <h4>'.$hata.'</h4>
          </div>
          </section>
          ';
        }
      }
    }else{
      $query=$db->prepare("UPDATE sayfalar SET
        sayfa_ustId = ?,
        sayfa_adi = ?,
        sayfa_yazarId = ?,
        sayfa_link = ?,
        sayfa_kisaAciklama = ?,
        sayfa_keyword = ?,
        sayfa_description = ?,
        sayfa_icerik = ?,
        sayfa_durum = ?,
        sayfa_guncellemeTarihi = ?
        WHERE sayfa_id=$id
        ");
        $update=$query->execute(array(
          $sayfa_ustId,
          $sayfa_adi,
          $sayfa_yazarId,
          $sayfa_link,
          $sayfa_description,
          $sayfa_keyword,
          $sayfa_description,
          $sayfa_icerik,
          $sayfa_durum,
          $sayfa_kayitTarihi
        ));
        if ($update) {
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-archive"></i> Sayfa Düzenle
          </h1>
          <div class="callout callout-success">
          <h4>Sayfa Bilgileri Başarıyla Düzenlendi!</h4>
          <p>Teşekkürler.</p>
          </div>
          </section>
          ';
          header("Refresh:3; url=main.php?sayfa=sayfaduzenle&id=$id");
        }else{
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-archive"></i> Sayfa Düzenle
          </h1>
          <div class="callout callout-success">
          <h4>Sayfa Bilgileri Düzenlenemedi!</h4>
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
      <i class="fa fa-archive"></i> Sayfa Düzenle
      </h1>
      <h3 class="text-center">'.$sayfa["sayfa_adi"].'</h3>
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
                <label  class="col-sm-2 control-label">Ust Sayfa</label>
                <div class="col-sm-10">
                  <select aria-hidden="true" tabindex="-1" class="form-control select2 select2-hidden-accessible" name="sayfa_ustId" style="width: 100%;">
                    <option selected="selected" value="0">Ana Sayfa</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa Adı</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Sayfa Adı" type="text" name="sayfa_adi" value="<?php echo $sayfa["sayfa_adi"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa Description</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Sayfa Kısa Açıklaması" type="text" name="sayfa_description" value="<?php echo $sayfa["sayfa_description"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa Keyword</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Sayfa Keyword" type="text" name="sayfa_keyword" value="<?php echo $sayfa["sayfa_keyword"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa İçerik</label>
                <div class="col-sm-10">
                  <textarea class="ckeditor" cols="80" id="editor1" name="sayfa_icerik" rows="10"><?php echo $sayfa["sayfa_icerik"]; ?></textarea>
                  <script language="javascript" type="text/javascript">
                  CKEDITOR.replace('sayfa_icerik',{
                    filebrowserBrowseUrl: '/emrekara.com.tr/browser/browse.php',
                    filebrowserImageBrowseUrl: '/emrekara.com.tr/browser/browse.php?type=Images',
                    filebrowserUploadUrl: '/emrekara.com.tr/uploader/upload.php',
                    filebrowserImageUploadUrl: '/emrekara.com.tr/uploader/upload.php?type=Images',
                    filebrowserWindowWidth: '900',
                    filebrowserWindowHeight: '400',
                    filebrowserBrowseUrl: '/emrekara.com.tr/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '/emrekara.com.tr/ckfinder/ckfinder.html?Type=Images',
                    filebrowserFlashBrowseUrl: '/emrekara.com.tr/ckfinder/ckfinder.html?Type=Flash',
                    filebrowserUploadUrl: '/emrekara.com.tr/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '/emrekara.com.tr/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: '/emrekara.com.tr/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                  });
                  </script>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa İcon</label>
                <div class="col-sm-10">
                  <input id="exampleInputFile" type="file" name="sayfa_icon">
                </div>
                <div class="col-sm-10">
                  <img src="../img/Sayfa/Thumb/<?php echo $sayfa["sayfa_icon"]; ?>" alt="<?php echo $sayfa["sayfa_adi"]; ?>" />
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
