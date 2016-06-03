<?php
if ($_POST["kayitet"]) {
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
  //echo '<script type="text/javascript">alert("'.$sayfa_adi.'");</script>';
  $ss=sayfasorgula($db,$sayfa_adi,$sayfa_link);
  if ($ss==0) {
    if ($sayfa_iconResmi!="") {
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
            $query=$db->prepare("INSERT INTO sayfalar SET
              sayfa_ustId = ?,
              sayfa_adi = ?,
              sayfa_yazarId = ?,
              sayfa_link = ?,
              sayfa_kisaAciklama = ?,
              sayfa_description = ?,
              sayfa_keyword = ?,
              sayfa_icerik = ?,
              sayfa_kayitTarihi = ?,
              sayfa_durum = ?,
              sayfa_icon = ?,
              sayfa_guncellemeTarihi = ?
              ");
              $insert=$query->execute(array(
                $sayfa_ustId,
                $sayfa_adi,
                $sayfa_yazarId,
                $sayfa_link,
                $sayfa_description,
                $sayfa_description,
                $sayfa_keyword,
                $sayfa_icerik,
                $sayfa_kayitTarihi,
                $sayfa_durum,
                $sayfa_icon,
                $sayfa_kayitTarihi
              ));
              if ($insert) {
                echo
                '
                <section class="content-header">
                <h1>
                <i class="fa fa-archive"></i> Sayfa Ekle
                </h1>
                <div class="callout callout-success">
                <h4>Sayfa Başarıyla Eklendi!</h4>
                <p>Teşekkürler.</p>
                </div>
                </section>
                ';
                header("Refresh:2; url=main.php?sayfa=sayfalistele");
              }
            }else{
              $hata=$image->error;
              echo
              '
              <section class="content-header">
              <h1>
              <i class="fa fa-archive"></i> Sayfa Ekle
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
            <i class="fa fa-archive"></i> Sayfa Ekle
            </h1>
            <div class="callout callout-danger">
            <h4>'.$hata.'</h4>
            </div>
            </section>
            ';
          }
        }
    }else if($sayfa_iconResmi==""){
        $query=$db->prepare("INSERT INTO sayfalar SET
          sayfa_ustId = ?,
          sayfa_adi = ?,
          sayfa_yazarId = ?,
          sayfa_link = ?,
          sayfa_kisaAciklama = ?,
          sayfa_keyword = ?,
          sayfa_description = ?,
          sayfa_icerik = ?,
          sayfa_kayitTarihi = ?,
          sayfa_durum = ?,
          sayfa_guncellemeTarihi = ?
          ");
          $insert=$query->execute(array(
            $sayfa_ustId,
            $sayfa_adi,
            $sayfa_yazarId,
            $sayfa_link,
            $sayfa_description,
            $sayfa_keyword,
            $sayfa_description,
            $sayfa_icerik,
            $sayfa_kayitTarihi,
            $sayfa_durum,
            $sayfa_kayitTarihi
          ));
          if ($insert) {
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-archive"></i> Sayfa Ekle
            </h1>
            <div class="callout callout-success">
            <h4>Sayfa Başarıyla Eklendi!</h4>
            <p>Teşekkürler.</p>
            </div>
            </section>
            ';
            header("Refresh:2; url=main.php?sayfa=sayfalistele");
          }else{
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-archive"></i> Sayfa Ekle
            </h1>
            <div class="callout callout-danger">
            <h4>Sayfa Eklenemedi.</h4>
            </div>
            </section>
            ';
          }
        }
      }else if($ss==1){
        echo
        '
        <section class="content-header">
        <h1>
        <i class="fa fa-archive"></i> Sayfa Ekle
        </h1>
        <div class="callout callout-danger">
        <h4>Aynı İsimde Sayfa Mevcut.</h4>
        </div>
        </section>
        ';
      }
    }else{
      echo
      '
      <section class="content-header">
      <h1>
      <i class="fa fa-archive"></i> Sayfa Ekle
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
                <label  class="col-sm-2 control-label">Ust Sayfa</label>
                <div class="col-sm-10">
                  <select aria-hidden="true" tabindex="-1" class="form-control select2 select2-hidden-accessible" name="sayfa_ustId" style="width: 100%;">
                    <option selected="selected" value="0">Ana Sayfa</option>
                    <?php echo kategori($db); ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa Adı</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Sayfa Adı" type="text" name="sayfa_adi" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa Description</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="SayfaKısa Açıklaması" type="text" name="sayfa_description" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa Keyword</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="SayfaKeyword" type="text" name="sayfa_keyword" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Sayfa İçerik</label>
                <div class="col-sm-10">
                  <textarea class="ckeditor" cols="80" id="editor1" name="sayfa_icerik" rows="10"></textarea>
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
