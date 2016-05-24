<?php
session_start();
ob_start();
require_once("../sistem/ayar.php");
require_once("../sistem/head.php");
if($_POST){
    if(!empty($_POST["kullanici_adi"]) && !empty($_POST["kullanici_sifre"])){
        $kadi=$_POST["kullanici_adi"];
		$parola=md5($_POST["kullanici_sifre"]);
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
                echo "Yönlendiriliyorsunuz.";
                header("Refresh:1; url=main.php");
            }

        }else{
            echo "What are you doing ?";
        }
    }else{
        echo "UPS..";
    }
}else if(@$_SESSION["login"]==true){
  if ($_SESSION["login"]==true) {
    $kullanici=$_SESSION["kullanici_adi"];
    $kullanici=$db->query("SELECT * FROM kullanicilar WHERE kullanici_adi='$kullanici'")->fetch(PDO::FETCH_ASSOC);
    if ($kullanici) {
      echo 'Yönlendiriliyorsunuz..';
      header("Refresh:1; url=main.php");
    }
  }
}else{
    echo '
    <form action="" method="POST">
        <table>
            <tr>
                <td>Kullanıcı Adı</td>
                <td><input type="text" name="kullanici_adi"></td>
            </tr>
            <tr>
                <td>Şifre</td>
                <td><input type="password" name="kullanici_sifre"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="giris" value="Giriş Yap"></td>
            </tr>
        </table>
    </form>
';
}
ob_end_flush();
?>
