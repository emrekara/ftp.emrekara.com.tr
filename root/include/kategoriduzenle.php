<?php

$id=$_GET["id"];
if (!$id) {
  header("Location:main.php");
}else{
  $kategori=$db->query("SELECT * FROM kategoriler WHERE kategori_id=$id")->fetch(PDO::FETCH_ASSOC);
  if (!$kategori) {
    header("Location:main.php");
  }
}
if ($_POST["kayitguncelle"]) {
  require('class.upload.php');
  $kategori_yazarId                 = $_SESSION["kullanici_id"];
  $kategori_ustId                   = p("kategori_ustId");
  $kategori_adi                     = p("kategori_adi");
  $kategori_link                    = seflink($kategori_adi);
  $kategori_description             = p("kategori_description");
  $kategori_keyword                 = p("kategori_keyword");
  $kategori_icerik                  = p("kategori_icerik");
  $tarih                            = date("Ymd-His");
  if (strlen($_FILES["kategori_icon"]["name"])>4) {
    $image=new Upload($_FILES["kategori_icon"]);
    if ($image->uploaded) {

      //BİG//

      //resim boyutu kontrolü
      //$image->file_max_size='4096';
      //resim formatları belirleme
      $image->allowed=array('image/*');
      //yeniden resim adı oluşturma
      $image->file_new_name_body=$tarih.$kullanici_adi;
      //resim adının başına ekleme yapmak
      $image->file_new_name_pre=$kullanici_adi.'-';
      //resim boyutlandırma
      $image->image_resize=true;
      $image->image_x=1000;
      $image->image_y=1000;
      $image->image_ratio_fill=true;

      $image->Process("../img/Kategori/Big/");
      if ($image->processed) {

        //THUMB//

        //resim boyutu kontrolü
        //$image->file_max_size='4096';
        //resim formatları belirleme
        $image->allowed=array('image/*');
        //yeniden resim adı oluşturma
        $image->file_new_name_body=$tarih.$kullanici_adi;
        //resim adının başına ekleme yapmak
        $image->file_new_name_pre=$kullanici_adi.'-';
        //resmin önüne resim eklemek için
        //$image->image_watermark="asd.jpg";
        //resim boyutlandırma
        $image->image_resize=true;
        $image->image_x=250;
        $image->image_y=250;
        $image->image_ratio_fill=true;

        $image->Process("../img/Kategori/Thumb/");
        $kategori_icon=$image->file_dst_name;
        if ($image->processed) {
          $query=$db->prepare("UPDATE kategoriler SET
            kategori_ustId = ?,
            kategori_adi = ?,
            kategori_yazarId = ?,
            kategori_yazarId = ?,
            kategori_link = ?,
            kategori_description = ?,
            kategori_keyword = ?,
            kategori_icerik = ?,
            kategori_icon = ?
            WHERE kategori_id=$id
            ");
            $insert=$query->execute(array(
              $kategori_ustId,
              $kategori_adi,
              $kategori_yazarId,
              $kategori_link,
              $kategori_description,
              $kategori_keyword,
              $kategori_icerik,
              $kategori_icon
            ));
            if ($insert) {
              echo
              '
              <section class="content-header">
              <h1>
              <i class="fa fa-archive"></i> Kategori Düzenle
              </h1>
              <div class="callout callout-success">
              <h4>Kategori Bilgileri Başarıyla Düzenlendi!</h4>
              <p>Teşekkürler.</p>
              </div>
              </section>
              ';
              header("Refresh:3; url=main.php?sayfa=kategoriduzenle&id=$id");
            }
          }else{
            $hata=$image->error;
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-archive"></i> Kategori Düzenle
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
          <i class="fa fa-archive"></i> Kategori Düzenle
          </h1>
          <div class="callout callout-danger">
          <h4>'.$hata.'</h4>
          </div>
          </section>
          ';
        }
      }
    }else{
      $query=$db->prepare("UPDATE kategoriler SET
        kategori_ustId = ?,
        kategori_adi = ?,
        kategori_yazarId = ?,
        kategori_link = ?,
        kategori_description = ?,
        kategori_keyword = ?,
        kategori_icerik = ?
        WHERE kategori_id=$id
        ");
        $insert=$query->execute(array(
          $kategori_ustId,
          $kategori_adi,
          $kategori_yazarId,
          $kategori_link,
          $kategori_description,
          $kategori_keyword,
          $kategori_icerik
        ));
        if ($insert) {
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-archive"></i> Kategori Düzenle
          </h1>
          <div class="callout callout-success">
          <h4>Kategori Bilgileri Başarıyla Düzenlendi!</h4>
          <p>Teşekkürler.</p>
          </div>
          </section>
          ';
          header("Refresh:3; url=main.php?sayfa=kategoriduzenle&id=$id");
        }else{
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-archive"></i> Kategori Düzenle
          </h1>
          <div class="callout callout-success">
          <h4>Kategori Bilgileri Düzenlenemedi!</h4>
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
      <i class="fa fa-archive"></i> Kategori Düzenle
      </h1>
      <h3 class="text-center">'.$kategori["kategori_adi"].'</h3>
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
                  <select aria-hidden="true" tabindex="-1" class="form-control select2 select2-hidden-accessible" name="kategori_ustId" style="width: 100%;">
                    <option selected="selected" value="0">Ana Kategori</option>
                      <?php echo kategorisecili($db,$id); ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Kategori Adı</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kategori Adı" type="text" name="kategori_adi" value="<?php echo $kategori["kategori_adi"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Kategori Description</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kategori Kısa Açıklaması" type="text" name="kategori_description" value="<?php echo $kategori["kategori_description"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Kategori Keyword</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kategori Keyword" type="text" name="kategori_keyword" value="<?php echo $kategori["kategori_keyword"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Kategori İçerik</label>
                <div class="col-sm-10">
                  <textarea class="ckeditor" cols="80" id="editor1" name="kategori_icerik" rows="10"><?php echo $kategori["kategori_"]; ?></textarea>
                  <script language="javascript" type="text/javascript">
                  CKEDITOR.replace('kategori_icerik',{
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
                <label  class="col-sm-2 control-label">Kategori İcon</label>
                <div class="col-sm-10">
                  <input id="exampleInputFile" type="file" name="kategori_icon" >
                </div>
                <div class="col-sm-10">
                  <img src="../img/Kategori/Thumb/<?php echo $kategori["kategori_icon"]; ?>" alt="<?php echo $kategori["kategori_adi"]; ?>" />
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
