<?php
$sil=$_GET["sil"];
if (!$sil) {
  header("Location:main.php?sayfa=default");
  die();
}
if($sil=="kategori_sil"){
  $id = g("id");
  if(!$id){
    go("main.php");
  }else{
    $query=$db->query("SELECT * FROM kategoriler WHERE kategori_id=$id")->fetch(PDO::FETCH_ASSOC);
    if ($query) {
      $big="../img/Kategori/Big/".$query["kategori_icon"];
      $thumb="../img/Kategori/Thumb/".$query["kategori_icon"];
      if (is_file($big) && is_file($thumb)) {
        unlink($big);
        unlink($thumb);
      }
      $delete=$db->prepare("DELETE FROM kategoriler WHERE kategori_id= :id");
      $delete2=$delete->execute(array(
        'id'=>$id
      ));
      if ($delete2) {
        echo 'Kategori ve Bileşenleri Başarıyla Silindi.';
        header("Refresh:3; url=main.php?sayfa=kategorilistele");
      }else{
        echo 'Kategori ve Bileşenleri Silinirken Bir Hata Oluştu.';
      }
    }else{
      header("Location:main.php?sayfa=default");
    }

  }
}
if($sil=="yazi_sil"){
  $id = g("id");
  if(!$id){
    go("main.php");
  }else{
    $query=$db->query("SELECT * FROM yazilar WHERE yazi_id=$id")->fetch(PDO::FETCH_ASSOC);
    if ($query) {
      $big="../img/Yazi/Big/".$query["yazi_icon"];
      $thumb="../img/Yazi/Thumb/".$query["yazi_icon"];
      if (is_file($big) && is_file($thumb)) {
        unlink($big);
        unlink($thumb);
      }
      $delete=$db->prepare("DELETE FROM yazilar WHERE yazi_id= :id");
      $delete2=$delete->execute(array(
        'id'=>$id
      ));
      if ($delete2) {
        echo 'Yazı ve Bileşenleri Başarıyla Silindi.';
        header("Refresh:3; url=main.php?sayfa=yazilistele");
      }else{
        echo 'Yazı ve Bileşenleri Silinirken Bir Hata Oluştu.';
      }
    }else{
      header("Location:main.php?sayfa=default");
    }

  }
}
if($sil=="sayfa_sil"){
  $id = g("id");
  if(!$id){
    go("main.php");
  }else{
    $query=$db->query("SELECT * FROM sayfalar WHERE sayfa_id=$id")->fetch(PDO::FETCH_ASSOC);
    if ($query) {
      $big="../img/Sayfa/Big/".$query["sayfa_icon"];
      $thumb="../img/Sayfa/Thumb/".$query["sayfa_icon"];
      if (is_file($big) && is_file($thumb)) {
        unlink($big);
        unlink($thumb);
      }
      $delete=$db->prepare("DELETE FROM sayfalar WHERE sayfa_id= :id");
      $delete2=$delete->execute(array(
        'id'=>$id
      ));
      if ($delete2) {
        echo 'Sayfa ve Bileşenleri Başarıyla Silindi.';
        header("Refresh:3; url=main.php?sayfa=sayfalistele");
      }else{
        echo 'Sayfa ve Bileşenleri Silinirken Bir Hata Oluştu.';
      }
    }else{
      header("Location:main.php?sayfa=default");
    }

  }
}
if($sil=="uye_sil"){
  $id = g("id");
  if(!$id){
    go("main.php");
  }else{
    $query=$db->query("SELECT * FROM kullanicilar WHERE kullanici_id=$id")->fetch(PDO::FETCH_ASSOC);
    if ($query) {
      $big="../img/Avatar/Big/".$query["kullanici_avatar"];
      $thumb="../img/Avatar/Thumb/".$query["kullanici_avatar"];
      if (is_file($big) && is_file($thumb)) {
        unlink($big);
        unlink($thumb);
      }
      $delete=$db->prepare("DELETE FROM kullanicilar WHERE kullanici_id= :id");
      $delete2=$delete->execute(array(
        'id'=>$id
      ));
      if ($delete2) {
        echo 'Kullanıcı ve Bileşenleri Başarıyla Silindi.';
        header("Refresh:3; url=main.php?sayfa=uyelistele");
      }else{
        echo 'Kullanıcı ve Bileşenleri Silinirken Bir Hata Oluştu.';
      }
    }else{
      header("Location:main.php?sayfa=default");
    }

  }
}


?>
