<?php
if ($_SESSION["login"]==true) {
  $degis=$_GET["degis"];
  $id=$_GET["id"];
  if (!$degis) {
    header("Location:main.php");
  }else{
    /*Kullanıcı Durum Değiş*/
    if ($degis=="kullanici_degis") {
      $kullanicisorgula=$db->query("SELECT * FROM kullanicilar WHERE kullanici_id=$id")->fetch(PDO::FETCH_ASSOC);
      if ($kullanicisorgula) {
        if ($kullanicisorgula["kullanici_durum"]==0) {
          $query=$db->prepare("UPDATE kullanicilar SET
            kullanici_durum = :kullanici_durum
            WHERE kullanici_id=$id");
            $update = $query->execute(array(
              "kullanici_durum" => "1"
            ));
          }else if($kullanicisorgula["kullanici_durum"]==1){
            $query=$db->prepare("UPDATE kullanicilar SET
              kullanici_durum = :kullanici_durum
              WHERE kullanici_id=$id");
              $update = $query->execute(array(
                "kullanici_durum" => "0"
              ));
            }
            if ($update) {
              echo "Başarıyla Güncellendi.";
              header("Refresh:2; url=main.php?sayfa=uyelistele");
            }else{
              echo $db->errorCode();
            }
          }else{
            header("Location:main.php");
          }
        }
        /*Kullanıcı Durum Değiş*/


        /*Kategori Durum Değiş*/
        if ($degis=="kategori_degis") {
          $kategorisorgula=$db->query("SELECT * FROM kategoriler WHERE kategori_id=$id")->fetch(PDO::FETCH_ASSOC);
          if ($kategorisorgula) {
            if ($kategorisorgula["kategori_durum"]==0) {
              $query=$db->prepare("UPDATE kategoriler SET
                kategori_durum = :kategori_durum
                WHERE kategori_id=$id");
                $update = $query->execute(array(
                  "kategori_durum" => "1"
                ));
              }else if($kategorisorgula["kategori_durum"]==1){
                $query=$db->prepare("UPDATE kategoriler SET
                  kategori_durum = :kategori_durum
                  WHERE kategori_id=$id");
                  $update = $query->execute(array(
                    "kategori_durum" => "0"
                  ));
                }
                if ($update) {
                  echo "Başarıyla Güncellendi.";
                  header("Refresh:2; url=main.php?sayfa=kategorilistele");
                }else{
                  echo $db->errorCode();
                }
              }else{
                header("Location:main.php");
              }
            }
            /*Kategori Durum Değiş*/

            /*Yazı Durum Değiş*/
            if ($degis=="yazi_degis") {
              $yazisorgula=$db->query("SELECT * FROM yazilar WHERE yazi_id=$id")->fetch(PDO::FETCH_ASSOC);
              if ($yazisorgula) {
                if ($yazisorgula["yazi_durum"]==0) {
                  $query=$db->prepare("UPDATE yazilar SET
                    yazi_durum = :yazi_durum
                    WHERE yazi_id=$id");
                    $update = $query->execute(array(
                      "yazi_durum" => "1"
                    ));
                  }else if($yazisorgula["yazi_durum"]==1){
                    $query=$db->prepare("UPDATE yazilar SET
                      yazi_durum = :yazi_durum
                      WHERE yazi_id=$id");
                      $update = $query->execute(array(
                        "yazi_durum" => "0"
                      ));
                    }
                    if ($update) {
                      echo "Başarıyla Güncellendi.";
                      header("Refresh:2; url=main.php?sayfa=yazilistele");
                    }else{
                      echo $db->errorCode();
                    }
                  }else{
                    header("Location:main.php");
                  }
                }
                /*Yazı Durum Değiş*/


                /*Sayfa Durum Değiş*/
                if ($degis=="sayfa_degis") {
                  $yazisorgula=$db->query("SELECT * FROM sayfalar WHERE sayfa_id=$id")->fetch(PDO::FETCH_ASSOC);
                  if ($yazisorgula) {
                    if ($yazisorgula["sayfa_durum"]==0) {
                      $query=$db->prepare("UPDATE sayfalar SET
                        sayfa_durum = :sayfa_durum
                        WHERE sayfa_id=$id");
                        $update = $query->execute(array(
                          "sayfa_durum" => "1"
                        ));
                      }else if($yazisorgula["sayfa_durum"]==1){
                        $query=$db->prepare("UPDATE sayfalar SET
                          sayfa_durum = :sayfa_durum
                          WHERE sayfa_id=$id");
                          $update = $query->execute(array(
                            "sayfa_durum" => "0"
                          ));
                        }
                        if ($update) {
                          echo "Başarıyla Güncellendi.";
                          header("Refresh:2; url=main.php?sayfa=sayfalistele");
                        }else{
                          echo $db->errorCode();
                        }
                      }else{
                        header("Location:main.php");
                      }
                    }
                    /*Sayfa Durum Değiş*/

                  }


                }
                ?>
