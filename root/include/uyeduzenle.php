<?php
$id=$_GET["id"];
if (!$id) {
  header("Location:main.php");
}else{
  $uye=$db->query("SELECT * FROM kullanicilar WHERE kullanici_id=$id")->fetch(PDO::FETCH_ASSOC);
  if (!$uye) {
    header("Location:main.php");
  }
}
if ($_POST["kayitguncelle"]) {
  echo "<script type='text/javascript'>alert('asdas');</script>";
  require('class.upload.php');
  $kullanici_isim                   = p("kullanici_isim");
  $kullanici_soyisim                = p("kullanici_soyisim");
  $kullanici_email                  = p("kullanici_email");
  $kullanici_telefon                = p("kullanici_telefon");
  $kullanici_facebook               = p("kullanici_facebook");
  $kullanici_twitter                = p("kullanici_twitter");
  $kullanici_instagram              = p("kullanici_instagram");
  $kullanici_youtube                = p("kullanici_youtube");
  $kullanici_google                 = p("kullanici_google");
  $kullanici_meslek                 = p("kullanici_meslek");
  $kullanici_yetki                  = p("kullanici_yetki");
  $kullanici_adi                    = p("kullanici_adi");
  $kullanici_sifreBase              = p("kullanici_sifre");
  $kullanici_sifre                  = md5(p("kullanici_sifre"));
  $kullanici_sifreYeniden           = md5(p("kullanici_sifreYeniden"));
  $tarih                            = date("Ymd-His");
  $kullanici_avatar           			= $_FILES["kullanici_avatar"]["tmp_name"];
  if (strlen($kullanici_avatar)>4) {
    $image=new Upload($_FILES["kullanici_avatar"]);
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

      $image->Process("../img/Avatar/Big/");
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

        $image->Process("../img/Avatar/Thumb/");
        $avatar=$image->file_dst_name;
        if ($image->processed) {
          $query=$db->prepare("UPDATE kullanicilar SET
            kullanici_isim = ?,
            kullanici_soyisim = ?,
            kullanici_email = ?,
            kullanici_telefon = ?,
            kullanici_facebook = ?,
            kullanici_twitter = ?,
            kullanici_instagram = ?,
            kullanici_youtube = ?,
            kullanici_google = ?,
            kullanici_meslek = ?,
            kullanici_yetki = ?,
            kullanici_avatar = ?,
            kullanici_adi = ?
            WHERE kullanici_id=$id");
            $insert=$query->execute(array(
              $kullanici_isim,
              $kullanici_soyisim,
              $kullanici_email,
              $kullanici_telefon,
              $kullanici_facebook,
              $kullanici_twitter,
              $kullanici_instagram,
              $kullanici_youtube,
              $kullanici_google,
              $kullanici_meslek,
              $kullanici_yetki,
              $avatar,
              $kullanici_adi
            ));
            if ($insert) {
              echo
              '
              <section class="content-header">
              <h1>
              <i class="fa fa-user"></i> Kullanıcı Düzenle
              </h1>
              <div class="callout callout-success">
              <h4>Kullanıcı Bilgileri Başarıyla Düzenlendi!</h4>
              <p>Teşekkürler.</p>
              </div>
              </section>
              ';
              header("Refresh:3; url=main.php?sayfa=uyeduzenle&id=$id");
            }
          }else{
            $hata=$image->error;
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-user"></i> Kullanıcı Düzenle
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
          <i class="fa fa-user"></i> Kullanıcı Düzenle
          </h1>
          <div class="callout callout-danger">
          <h4>'.$hata.'</h4>
          </div>
          </section>
          ';
        }
      }
    }else{
      $query=$db->prepare("UPDATE kullanicilar SET
        kullanici_isim = ?,
        kullanici_soyisim = ?,
        kullanici_email = ?,
        kullanici_telefon = ?,
        kullanici_facebook = ?,
        kullanici_twitter = ?,
        kullanici_instagram = ?,
        kullanici_youtube = ?,
        kullanici_google = ?,
        kullanici_meslek = ?,
        kullanici_yetki = ?,
        kullanici_avatar = ?,
        kullanici_adi = ?
        WHERE kullanici_id=$id");
        $insert=$query->execute(array(
          $kullanici_isim,
          $kullanici_soyisim,
          $kullanici_email,
          $kullanici_telefon,
          $kullanici_facebook,
          $kullanici_twitter,
          $kullanici_instagram,
          $kullanici_youtube,
          $kullanici_google,
          $kullanici_meslek,
          $kullanici_yetki,
          $avatar,
          $kullanici_adi
        ));
        if ($insert) {
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-user"></i> Kullanıcı Düzenle
          </h1>
          <div class="callout callout-success">
          <h4>Kullanıcı Bilgileri Başarıyla Düzenlendi!</h4>
          <p>Teşekkürler.</p>
          </div>
          </section>
          ';
          header("Refresh:3; url=main.php?sayfa=uyeduzenle&id=$id");
        }else{
          echo
          '
          <section class="content-header">
          <h1>
          <i class="fa fa-user"></i> Kullanıcı Düzenle
          </h1>
          <div class="callout callout-success">
          <h4>Kullanıcı Bilgileri Düzenlenemedi!</h4>
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
      <i class="fa fa-user"></i> Kullanıcı Düzenle
      </h1>
      <h3 class="text-center">'.$uye["kullanici_adi"].'</h3>
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
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici İsim</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı İsim" type="text" name="kullanici_isim" value="<?php echo $uye["kullanici_isim"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Soyisim</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Soyisim" type="text" name="kullanici_soyisim" value="<?php echo $uye["kullanici_soyisim"]; ?>"  required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Email</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Email" type="email" name="kullanici_email" value="<?php echo $uye["kullanici_email"]; ?>"  required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Telefon</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Telefon" type="text" name="kullanici_telefon" value="<?php echo $uye["kullanici_telefon"]; ?>"  required>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Facebook </label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Facebook " type="text" name="kullanici_facebook" value="<?php echo $uye["kullanici_facebook"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Twitter</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Twitter" type="text" name="kullanici_twitter" value="<?php echo $uye["kullanici_twitter"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici İnstagram</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı İnstagram" type="text" name="kullanici_instagram" value="<?php echo $uye["kullanici_instagram"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Youtube</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Youtube" type="text" name="kullanici_youtube" value="<?php echo $uye["kullanici_youtube"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Google</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Google" type="text" name="kullanici_google" value="<?php echo $uye["kullanici_google"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Meslek</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Meslek" type="text" name="kullanici_meslek" value="<?php echo $uye["kullanici_meslek"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Yetkisi</label>
                <div class="col-sm-10">
                  <select aria-hidden="true" tabindex="-1" class="form-control select2 select2-hidden-accessible" name="kullanici_yetki" style="width: 100%;">
                    <option selected="selected" value="1">Admin</option>
                    <option value="2">User</option>
                    <option value="3">Quest</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Adı</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Kullanıcı Adı" type="text" name="kullanici_adi" required value="<?php echo $uye["kullanici_adi"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Kullanici Avatar</label>
                <div class="col-sm-10">
                  <input id="exampleInputFile" type="file" name="kullanici_avatar">
                </div>
                <div class="col-sm-10">
                  <img src="../img/Avatar/Thumb/<?php echo $uye["kullanici_avatar"]; ?>" alt="<?php echo $uye["kullanici_adi"]; ?>" />
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
