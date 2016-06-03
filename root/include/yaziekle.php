<?php
if ($_POST["kayitet"]) {
  require('class.upload.php');
  $yazi_yazarId                 = $_SESSION["kullanici_id"];
  $yazi_kategori                = p("yazi_kategori");
  $yazi_kategori_link           = yazikategoriadi($db,$yazi_kategori);
  $yazi_adi                     = p("yazi_adi");
  $yazi_link                    = seflink($yazi_adi);
  $yazi_description             = p("yazi_description");
  $yazi_keyword                 = p("yazi_keyword");
  $yazi_icerik                  = p("yazi_icerik");
  $tarih                        = date("Ymd-His");
  $yazi_kayitTarihi             = date("Y-m-d H:i:s");
  $yazi_iconResmi               = $_FILES["yazi_icon"]["tmp_name"];
  $yazi_durum=1;
  //echo '<script type="text/javascript">alert("'.$yazi_adi.'");</script>';
  $ys=yazisorgula($db,$yazi_adi,$yazi_link);
  if ($ys==0) {
    if ($yazi_iconResmi!="") {
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
          if ($image->processed) {
            $query=$db->prepare("INSERT INTO yazilar SET
              yazi_kategori = ?,
              yazi_kategori_link = ?,
              yazi_adi = ?,
              yazi_yazarId = ?,
              yazi_link = ?,
              yazi_kisaAciklama = ?,
              yazi_keyword = ?,
              yazi_description = ?,
              yazi_icerik = ?,
              yazi_kayitTarihi = ?,
              yazi_durum = ?,
              yazi_icon = ?,
              yazi_guncellemeTarihi = ?
              ");
              $insert=$query->execute(array(
                $yazi_kategori,
                $yazi_kategori_link,
                $yazi_adi,
                $yazi_yazarId,
                $yazi_link,
                $yazi_description,
                $yazi_keyword,
                $yazi_description,
                $yazi_icerik,
                $yazi_kayitTarihi,
                $yazi_durum,
                $yazi_icon,
                $yazi_kayitTarihi
              ));
              if ($insert) {

                echo
                '
                <section class="content-header">
                <h1>
                <i class="fa fa-archive"></i> Yazı Ekle
                </h1>
                <div class="callout callout-success">
                <h4>Yazı Başarıyla Eklendi!</h4>
                <p>Teşekkürler.</p>
                </div>
                </section>
                ';
                header("Refresh:2; url=main.php?sayfa=yazilistele");
              }
            }else{
              $hata=$image->error;
              echo
              '
              <section class="content-header">
              <h1>
              <i class="fa fa-archive"></i> Yazı Ekle
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
            <i class="fa fa-archive"></i> Yazı Ekle
            </h1>
            <div class="callout callout-danger">
            <h4>'.$hata.'</h4>
            </div>
            </section>
            ';
          }
        }
    }else if($yazi_iconResmi==""){
        $query=$db->prepare("INSERT INTO yazilar SET
          yazi_kategori = ?,
          yazi_kategori_link = ?,
          yazi_adi = ?,
          yazi_yazarId = ?,
          yazi_link = ?,
          yazi_kisaAciklama = ?,
          yazi_keyword = ?,
          yazi_description = ?,
          yazi_icerik = ?,
          yazi_kayitTarihi = ?,
          yazi_durum = ?,
          yazi_guncellemeTarihi = ?
          ");
          $insert=$query->execute(array(
            $yazi_kategori,
            $yazi_kategori_link,
            $yazi_adi,
            $yazi_yazarId,
            $yazi_link,
            $yazi_description,
            $yazi_keyword,
            $yazi_description,
            $yazi_icerik,
            $yazi_kayitTarihi,
            $yazi_durum,
            $yazi_kayitTarihi
          ));
          if ($insert) {
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-archive"></i> Yazı Ekle
            </h1>
            <div class="callout callout-success">
            <h4>Yazı Başarıyla Eklendi!</h4>
            <p>Teşekkürler.</p>
            </div>
            </section>
            ';
            header("Refresh:2; url=main.php?sayfa=yazilistele");
          }else{
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-archive"></i> Yazı Ekle
            </h1>
            <div class="callout callout-danger">
            <h4>Yazı Eklenemedi.</h4>
            </div>
            </section>
            ';
          }
        }
      }else if($ys==1){
        echo
        '
        <section class="content-header">
        <h1>
        <i class="fa fa-archive"></i> Yazı Ekle
        </h1>
        <div class="callout callout-danger">
        <h4>Aynı İsimde Yazı Mevcut.</h4>
        </div>
        </section>
        ';
      }
    }else{
      echo
      '
      <section class="content-header">
      <h1>
      <i class="fa fa-archive"></i> Yazı Ekle
      </h1>
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
                <label  class="col-sm-2 control-label">Yazı</label>
                <div class="col-sm-10">
                  <select aria-hidden="true" tabindex="-1" class="form-control select2 select2-hidden-accessible" name="yazi_kategori" style="width: 100%;">
                    <option selected="selected" value="0">Ana Kategori</option>
                    <?php echo kategori($db); ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazı Adı</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Yazi Adı" type="text" name="yazi_adi" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazı Description</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Yazi Kısa Açıklaması" type="text" name="yazi_description" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazı Keyword</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Yazi Keyword" type="text" name="yazi_keyword" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazı İçerik</label>
                <div class="col-sm-10">
                  <textarea class="ckeditor" cols="80" id="yazi_icerik" name="yazi_icerik" rows="10"></textarea>
                  <script type="text/javascript" language="javascript">
            CKEDITOR.replace('yazi_icerik',{
              filebrowserBrowseUrl : '/browser/browse.php',
              filebrowserImageBrowseUrl : '/browser/browse.php?type=Images',
              filebrowserUploadUrl : '/uploader/upload.php',
              filebrowserImageUploadUrl : '/uploader/upload.php?type=Images',
              filebrowserWindowWidth : '900',
              filebrowserWindowHeight : '500',
              filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
              filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?type=Images',
              filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?type=Flash',
              filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
              filebrowserImageUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
              filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
            });
            </script>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Yazı İcon</label>
                <div class="col-sm-10">
                  <input id="exampleInputFile" type="file" name="yazi_icon">
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="submit" name="kayitet" value="Kayıt Et" class="btn btn-info pull-left col-md-3" >
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->




    <?php require_once("include/footerinc.php");?>
