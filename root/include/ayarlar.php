<?php
$ayarlar=$db->query("SELECT * FROM ayarlar WHERE ayar_id=1")->fetch(PDO::FETCH_ASSOC);
if (!$ayarlar) {
  header("Location:main.php");
}
if($_POST["kayitguncelle"]){
  require('class.upload.php');
  $ayar_url         =p("ayar_url");
  $ayar_title       =p("ayar_title");
  $ayar_description =p("ayar_description");
  $ayar_keyword     =p("ayar_keyword");
  $ayar_copyright   =p("ayar_copyright");
  $ayar_email       =p("ayar_email");
  $ayar_telefon     =p("ayar_telefon");
  $ayar_facebook    =p("ayar_facebook");
  $ayar_twitter     =p("ayar_twitter");
  $ayar_instagram   =p("ayar_instagram");
  $ayar_google      =p("ayar_google");
  $ayar_linkedin    =p("ayar_linkedin");
  $ayar_logo        =$_FILES["ayar_logo"];
  $logoisim         =seflink($ayar_title);
  if (!$ayar_url || !$ayar_title || !$ayar_description || !$ayar_keyword || !$ayar_copyright || !$ayar_email || !$ayar_telefon ) {
    echo
    '
    <section class="content-header">
    <h1>
    <i class="fa fa-cogs"></i> Site Ayarları Düzenle
    </h1>
    <div class="callout callout-danger">
    <h4>Site Bilgilerini Boş Bırakmayınız!</h4>
    <p>Teşekkürler.</p>
    </div>
    </section>
    ';
  }else{
    if ($ayar_logo) {
      $image=new Upload($ayar_logo);
      if ($image->uploaded) {

        //BİG//

        //resim boyutu kontrolü
        //$image->file_max_size='4096';
        //resim formatları belirleme
        $image->allowed=array('image/*');
        //yeniden resim adı oluşturma
        $image->file_new_name_body=$logoisim;
        //resim boyutlandırma
        $image->image_resize=true;
        $image->image_x=1500;
        $image->image_y=500;
        $image->image_ratio_fill=true;

        $image->Process("../img/Ayar/Big/");
        if ($image->processed) {
          //THUMB//

          //resim boyutu kontrolü
          //$image->file_max_size='4096';
          //resim formatları belirleme
          $image->allowed=array('image/*');
          //yeniden resim adı oluşturma
          $image->file_new_name_body=$logoisim;
          //resmin önüne resim eklemek için
          //$image->image_watermark="asd.jpg";
          //resim boyutlandırma
          $image->image_resize=true;
          $image->image_x=750;
          $image->image_y=250;
          $image->image_ratio_fill=true;

          $image->Process("../img/Ayar/Thumb/");
          $ayar_logoIcon=$image->file_dst_name;
          if ($image->processed) {
            $query=$db->prepare("UPDATE ayarlar SET
              ayar_url          = ?,
              ayar_title        = ?,
              ayar_description  = ?,
              ayar_keyword      = ?,
              ayar_copyright    = ?,
              ayar_email        = ?,
              ayar_telefon      = ?,
              ayar_facebook     = ?,
              ayar_twitter      = ?,
              ayar_instagram    = ?,
              ayar_google       = ?,
              ayar_linkedin     = ?,
              ayar_logo         = ?
              WHERE ayar_id=1
              ");
              $update=$query->execute(array(
                $ayar_url,
                $ayar_title,
                $ayar_description,
                $ayar_keyword,
                $ayar_copyright,
                $ayar_email,
                $ayar_telefon,
                $ayar_facebook,
                $ayar_twitter,
                $ayar_instagram,
                $ayar_google,
                $ayar_linkedin,
                $ayar_logoIcon
              ));
              if ($update) {
                echo
                '
                <section class="content-header">
                <h1>
                <i class="fa fa-archive"></i> Site Ayarları Düzenle
                </h1>
                <div class="callout callout-success">
                <h4>Site Ayarları Düzenlenmiştir!</h4>
                <p>Teşekkürler.</p>
                </div>
                </section>
                ';
                header("Refresh:2; url=main.php?sayfa=ayarlar");
              }
            }else{
              $hata=$image->error;
              echo
              '
              <section class="content-header">
              <h1>
              <i class="fa fa-archive"></i> Site Ayarları Düzenle
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
            <i class="fa fa-cogs"></i> Site Ayarları Düzenle
            </h1>
            <div class="callout callout-danger">
            <h4>'.$hata.'</h4>
            </div>
            </section>
            ';
          }
        }
      }
      if ($ayar_title || $ayar_description || $ayar_keyword || $ayar_copyright || $ayar_email || $ayar_telefon) {
        $query=$db->prepare("UPDATE ayarlar SET
          ayar_url          = ?,
          ayar_title        = ?,
          ayar_description  = ?,
          ayar_keyword      = ?,
          ayar_copyright    = ?,
          ayar_email        = ?,
          ayar_facebook     = ?,
          ayar_twitter      = ?,
          ayar_instagram    = ?,
          ayar_google       = ?,
          ayar_linkedin     = ?,
          ayar_telefon      = ?
          WHERE ayar_id=1
          ");
          $update=$query->execute(array(
            $ayar_url,
            $ayar_title,
            $ayar_description,
            $ayar_keyword,
            $ayar_copyright,
            $ayar_email,
            $ayar_facebook,
            $ayar_twitter,
            $ayar_instagram,
            $ayar_google,
            $ayar_linkedin,
            $ayar_telefon
          ));
          if ($update) {
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-cogs"></i> Site Ayarları Düzenle
            </h1>
            <div class="callout callout-success">
            <h4>Site Ayarları Düzenlenmiştir!</h4>
            <p>Teşekkürler.</p>
            </div>
            </section>
            ';
            header("Refresh:2; url=main.php?sayfa=ayarlar");
          }else{
            echo
            '
            <section class="content-header">
            <h1>
            <i class="fa fa-cogs"></i> Site Ayarları Düzenle
            </h1>
            <div class="callout callout-danger">
            <h4>Site Ayarları Düzenlenemedi!</h4>
            <p>Teşekkürler.</p>
            </div>
            </section>
            ';
          }
        }
      }
    }else{
      echo
      '
      <section class="content-header">
      <h1>
      <i class="fa fa-cogs"></i> Site Ayarları Düzenle
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
                <label  class="col-sm-2 control-label">Site Url</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Url" type="text" name="ayar_url" value="<?php echo $ayarlar["ayar_url"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Title</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Title" type="text" name="ayar_title" value="<?php echo $ayarlar["ayar_title"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Description</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Description" type="text" name="ayar_description" value="<?php echo $ayarlar["ayar_description"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Keyword</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Keyword" type="text" name="ayar_keyword" value="<?php echo $ayarlar["ayar_keyword"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Copyright</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Copyright" type="text" name="ayar_copyright" value="<?php echo $ayarlar["ayar_copyright"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Email Adresi</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Email Adresi" type="text" name="ayar_email" value="<?php echo $ayarlar["ayar_email"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Telefon</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Telefon" type="text" name="ayar_telefon" value="<?php echo $ayarlar["ayar_telefon"]; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Facebook</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Facebook" type="text" name="ayar_facebook" value="<?php echo $ayarlar["ayar_facebook"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Twitter</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Twitter" type="text" name="ayar_twitter" value="<?php echo $ayarlar["ayar_twitter"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site İnstagram</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site İnstagram" type="text" name="ayar_instagram" value="<?php echo $ayarlar["ayar_instagram"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Google</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Google" type="text" name="ayar_google" value="<?php echo $ayarlar["ayar_google"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Linkedin</label>
                <div class="col-sm-10">
                  <input class="form-control" id="inputEmail3" placeholder="Site Linkedin" type="text" name="ayar_linkedin" value="<?php echo $ayarlar["ayar_linkedin"]; ?>" >
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-2 control-label">Site Logosunu Seçiniz</label>
                <div class="col-sm-10">
                  <input id="exampleInputFile" type="file" name="ayar_logo">
                </div>
                <div class="col-sm-10">
                  <img src="../img/Ayar/Thumb/<?php echo $ayarlar["ayar_logo"]; ?>" alt="<?php echo $ayarlar["ayar_title"]; ?>" />
                </div>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="submit" name="kayitguncelle" value="Site Ayarlarını Güncelle" class="btn btn-info pull-left col-md-3" >
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->




    <?php require_once("include/footerinc.php");?>
