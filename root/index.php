<?php
session_start();
ob_start();
require_once("../sistem/ayar.php");
require_once("../sistem/head.php");
?>
<style media="screen">
body{
  background-image: url("images/login-panel-bg.jpg");
  background-repeat: no-repeat;
  background-size: 100% 100%;
  background-attachment: fixed;
}
.login {
  background-image: url("images/login-panel.png");
  background-repeat: no-repeat;
  height: 450px !important;
  background-size: auto 450px !important;
  width: 450px !important;
  margin-top: 5%;
  float: left;
  margin-left: 30%;
}
.login .satir{
  width: 100%;
  height: auto;
  float: left;
  margin-top: 5px;
}
.login .satir .baslik{
  width: 100px;
  color: #fff;
  float: left;
  font-size: 13px;
  padding-top: 10px;
}
.login .satir .icerik{
  width: 115px;
  float: left;
}
.login .satir .icerik input {
  width: 100%;
  color: #000;
  border: 1px solid rgb(211, 17, 67);
  float: left;
  border-radius: 5px;
  padding: 5px;
}
.satir-genel {
  width: 100%;
  height: auto;
  margin-top: 170px;
  margin-left: 230px;
}
.giris {
  width: 127px !important;
  background-color: rgba(29, 219, 212, 0.7);
  color: #fff !important;
}
</style>
<?php
if($_POST){
  if(!empty($_POST["kullanici_adi"]) && !empty($_POST["kullanici_sifre"])){
    $kadi=addslashes($_POST["kullanici_adi"]);
    $parola=addslashes(md5($_POST["kullanici_sifre"]));
    $usearch=$db->query("Select * from kullanicilar where kullanici_adi='$kadi' and kullanici_sifre='$parola' and kullanici_durum=1", PDO::FETCH_ASSOC);

    if ($usearch->rowCount()) {
      foreach ($usearch as $row) {

        $_SESSION["login"]=true;
        $_SESSION["kullanici_id"]=$row["kullanici_id"];
        $_SESSION["kullanici_adi"]=$row["kullanici_adi"];
        $_SESSION["kullanici_email"]=$row["kullanici_email"];
        $_SESSION["kullanici_telefon"]=$row["kullanici_telefon"];
        $_SESSION["kullanici_yetki"]=$row["kullanici_yetki"];
        //echo $row['kullanici_adi']." ".$row['email']." ";
        echo "<div style='color:#fff;'>Yönlendiriliyorsunuz.</div>";
        header("Refresh:1; url=main.php");
      }

    }else{
      echo "<div style='color:#fff;'>What are you doing ?</div>";
    }
  }else{
    echo "<div style='color:#fff;'>UPS..</div>";
  }
}else if(@$_SESSION["login"]==true){
  if ($_SESSION["login"]==true) {
    $kullanici=$_SESSION["kullanici_adi"];
    $kullanici=$db->query("SELECT * FROM kullanicilar WHERE kullanici_adi='$kullanici'")->fetch(PDO::FETCH_ASSOC);
    if ($kullanici) {
      echo "<div style='color:#fff;'>Yönlendiriliyorsunuz..</div>";
      header("Refresh:1; url=main.php");
    }
  }
}else{
  ?>
  <div class="login">
    <div class="satir-genel">
      <form action="" method="POST">
        <div class="satir">
          <div class="baslik">
            Kullanici Adı
          </div>
          <div class="icerik">
            <input name="kullanici_adi" type="text">
          </div>
        </div>
        <div class="satir">
          <div class="baslik">
            Kullanici Şifresi
          </div>
          <div class="icerik">
            <input name="kullanici_sifre" type="password">
          </div>
        </div>
        <div class="satir">
          <div class="baslik">
            &nbsp;

          </div>
          <div class="icerik">
            <input class="giris" name="giris" value="Giriş Yap" type="submit">
          </div>
        </div>

      </form>
    </div>

    <?php
  }
  ob_end_flush();
  ?>
