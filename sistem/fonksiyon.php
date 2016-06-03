<?php

function p($sutun, $st = false){
  if($st){
    return htmlspecialchars(trim($_POST[$sutun]));
  }else{
    return trim($_POST[$sutun]);
  }
}
function g($sutun, $st = false){
  if($st){
    return htmlspecialchars(trim($_GET[$sutun]));
  }else{
    return trim($_GET[$sutun]);
  }
}
function seflink($string){
  $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
  $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
  $string = strtolower(str_replace($find, $replace, $string));
  $string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
  $string = trim(preg_replace('/\s+/', ' ', $string));
  $string = str_replace(' ', '-', $string);
  return $string;
}
function git($par, $time = 0){
	if($time == 0){
		header("Location: {$par}");
	}else{
		header("Refresh: {$time}; url={$par}");
	}
}
function curlKullan($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
    $curlData = curl_exec($curl);
    curl_close($curl);
    return $curlData;
}
function GetIP(){
	if(getenv("HTTP_CLIENT_IP")) {
 		$ip = getenv("HTTP_CLIENT_IP");
 	} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 		$ip = getenv("HTTP_X_FORWARDED_FOR");
 		if (strstr($ip, ',')) {
 			$tmp = explode (',', $ip);
 			$ip = trim($tmp[0]);
 		}
 	} else {
 	$ip = getenv("REMOTE_ADDR");
 	}
	return $ip;
}
function GetBrowser(){
     $u_agent = $_SERVER['HTTP_USER_AGENT'];
     $bname = 'Bilinmiyor';
     $platform = 'Bilinmiyor';
     $version= "";
     //Hangi platformdan gelmiş, Linux, Windows, MacOSX?
     if (preg_match('/linux/i', $u_agent)) {
         $platform = 'linux';
     }
     elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
         $platform = 'mac';
     }
     elseif (preg_match('/windows|win32/i', $u_agent)) {
         $platform = 'windows';
     }
     //Sonra hangi tarayıcı olduğuna  göz atalım
     if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
     {
         $bname = 'Internet Explorer';
         $ub = "MSIE";
     }
     elseif(preg_match('/Firefox/i',$u_agent))
     {
         $bname = 'Mozilla Firefox';
         $ub = "Firefox";
     }
     elseif(preg_match('/Chrome/i',$u_agent))
     {
         $bname = 'Google Chrome';
         $ub = "Chrome";
     }
     elseif(preg_match('/Safari/i',$u_agent))
     {
         $bname = 'Apple Safari';
         $ub = "Safari";
     }
     elseif(preg_match('/Opera/i',$u_agent))
     {
         $bname = 'Opera';
         $ub = "Opera";
     }
     elseif(preg_match('/Netscape/i',$u_agent))
     {
         $bname = 'Netscape';
         $ub = "Netscape";
     }
     // Tarayıcının versiyon numarasını tespit edelim.
     // burada düzenli ifadeler kullanarak bakıyoruz.
     $known = array('Version', $ub, 'other');
     $pattern = '#(?<browser>' . join('|', $known) .
     ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
     if (!preg_match_all($pattern, $u_agent, $matches)) {
         // buraya kadar bulamadık, aramaya devam
     }
     $i = count($matches['browser']);
     if ($i != 1) {
         if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
             $version= $matches['version'][0];
         }
         else {
             $version= $matches['version'][1];
         }
     }
     else {
         $version= $matches['version'][0];
     }
     if ($version==null || $version=="") {$version="?";}
     return array(
         'userAgent' => $u_agent,
         'name'      => $bname,
         'version'   => $version,
         'platform'  => $platform,
         'pattern'    => $pattern
     );
 }
function analitik_hit($db,$analitik_ip){
    $query=$db->query("SELECT * FROM analitik WHERE analitik_ip='$analitik_ip' order by analitik_id desc limit 0,1")->fetch(PDO::FETCH_ASSOC);
    if ($query) {
        return $query["analitik_hit"]+1;
    }else{
        return 0;
    }
}
function analitikhitdondur($db,$id){
  $hit=$db->query("SELECT * FROM analitik WHERE analitik_id=$id order by analitik_hit desc limit 0,1")->fetch(PDO::FETCH_ASSOC);
  if ($hit) {
    return $hit["analitik_hit"];
  }
}
function analitikdegerdondur($db,$id,$column){
  $deger=$db->query("SELECT * FROM analitik WHERE analitik_id=$id")->fetch(PDO::FETCH_ASSOC);
  if ($deger) {
    return $deger[$column];
  }
}
function girisKayit($db){
    $analitik_ip=  GetIP();
    $analitik_getbrowser= GetBrowser();
    $analitik_tarayici=$analitik_getbrowser["name"]." ".$analitik_getbrowser["version"];
    $analitik_sistem=$analitik_getbrowser["platform"];
    $analitik_url="http://".$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI']."";
    $analitik_hit=analitik_hit($db, $analitik_ip);
    $query=$db->prepare("INSERT INTO analitik SET
              analitik_ip = ?,
              analitik_tarayici = ?,
              analitik_sistem = ?,
              analitik_url = ?,
              analitik_hit = ?
              ");
              $insert=$query->execute(array(
                $analitik_ip,
        $analitik_tarayici,
        $analitik_sistem,
        $analitik_url,
        $analitik_hit
              ));

}
function ayarlar($db,$colum){
  $query=$db->query("SELECT * FROM ayarlar WHERE ayar_id=1")->fetch(PDO::FETCH_ASSOC);
  if ($query) {
    return $query[$colum];
  }
}
function kullanici($db,$kullanici_id,$colum){
  $query=$db->query("SELECT * FROM kullanicilar WHERE kullanici_id=$kullanici_id")->fetch(PDO::FETCH_ASSOC);
  if ($query) {
    return $query[$colum];
  }
}
function uyelistele($db){
  $query=$db->query("SELECT * FROM kullanicilar order by kullanici_kayitTarihi asc",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      if($row["kullanici_durum"]==0){
        $kullanici_durum='<a href="main.php?sayfa=durumdegis&degis=kullanici_degis&id='.$row["kullanici_id"].'"><img src="images/pasif.png"></a>';
      }else if($row["kullanici_durum"]==1){
        $kullanici_durum='<a href="main.php?sayfa=durumdegis&degis=kullanici_degis&id='.$row["kullanici_id"].'"><img src="images/aktif.png"></a>';
      }
      echo '<tr>';
      echo
      '
      <td style="text-align:center;">'.$kullanici_durum.'</td>
      <td>'.$row["kullanici_adi"].'</td>
      <td>'.$row["kullanici_isim"].' '.$row["kullanici_soyisim"].'</td>
      <td>'.$row["kullanici_email"].'</td>
      <td>'.$row["kullanici_telefon"].'</td>
      <td>'.$row["kullanici_kayitTarihi"].'</td>
      <td>
      <a href="main.php?sayfa=uyeduzenle&id='.$row["kullanici_id"].'"><i class="fa fa-pencil"></i></a>
      <a href="main.php?sayfa=sil&sil=uye_sil&id='.$row["kullanici_id"].'" onclick="return confirmDel();"><i class="fa fa-trash"></i></a>
      </td>
      ';
      echo '</tr>';
    }
  }
}
function ustkategori($db,$id){
  $query=$db->query("SELECT * FROM kategoriler WHERE kategori_id=$id")->fetch(PDO::FETCH_ASSOC);
  if ($query) {
    return $query["kategori_adi"];
  }else{
    return "Ana Kategori";
  }
}
function kategorilistele($db){
  $query=$db->query("SELECT * FROM kategoriler order by kategori_adi asc ",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      if($row["kategori_durum"]==0){
        $kategori_durum='<a href="main.php?sayfa=durumdegis&degis=kategori_degis&id='.$row["kategori_id"].'"><img src="images/pasif.png"></a>';
      }else if($row["kategori_durum"]==1){
        $kategori_durum='<a href="main.php?sayfa=durumdegis&degis=kategori_degis&id='.$row["kategori_id"].'"><img src="images/aktif.png"></a>';
      }
      echo '<tr>';
      echo
      '
      <td style="text-align:center;">'.$kategori_durum.'</td>
      <td><img src="../img/Kategori/Thumb/'.$row["kategori_icon"].'" style="max-width:25px;"></td>
      <td>'.ustkategori($db,$row["kategori_ustId"]).'</td>
      <td>'.$row["kategori_adi"].'</td>
      <td>'.$row["kategori_kayitTarihi"].'</td>
      <td>
      <a href="main.php?sayfa=kategoriduzenle&id='.$row["kategori_id"].'"><i class="fa fa-pencil"></i></a>
      <a href="main.php?sayfa=sil&sil=kategori_sil&id='.$row["kategori_id"].'" onclick="return confirmDel();"><i class="fa fa-trash"></i></a>
      </td>
      ';
      echo '</tr>';
    }
  }
}
function kategori($db){
  $query=$db->query("SELECT * FROM kategoriler WHERE kategori_durum=1 order by kategori_adi asc",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      echo '<option value="'.$row["kategori_id"].'">'.$row["kategori_adi"].'</option>';
    }
  }
}
function kategorisecili($db,$id){
    echo'<option value="0">Ana Kategori</option>';
  $query=$db->query("SELECT * FROM kategoriler WHERE kategori_durum=1",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      echo '<option value="'.$row["kategori_id"].'"';
        if($id==$row["kategori_id"]){
            echo ' selected ' ;
        }
        echo '>'.$row["kategori_adi"].'</option>';
    }
  }
}
function yazikategoriadi($db,$id){
  $query=$db->query("SELECT * FROM kategoriler WHERE kategori_id=$id")->fetch(PDO::FETCH_ASSOC);
  if ($query) {
    return seflink($query["kategori_adi"]);
  }
}
function kategorisorgula($db,$isim){
  $sef=seflink($isim);
  $query=$db->query("SELECT * FROM kategoriler WHERE kategori_adi='$isim' or kategori_link='$sef'")->fetch(PDO::FETCH_ASSOC);
  if ($query) {
    return 1;
  }else{
    return 0;
  }
}
function yazisorgula($db,$yazi_adi,$yazi_link){
  $query=$db->query("SELECT * FROM yazilar WHERE yazi_adi='$yazi_adi' or yazi_link='$yazi_link'")->fetch(PDO::FETCH_ASSOC);
  if ($query) {
    return 1;
  }else{
    return 0;
  }
}
function yazilistele($db){
  $query=$db->query("SELECT * FROM yazilar order by yazi_id desc ",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      if($row["yazi_durum"]==0){
        $yazi_durum='<a href="main.php?sayfa=durumdegis&degis=yazi_degis&id='.$row["yazi_id"].'"><img src="images/pasif.png"></a>';
      }else if($row["yazi_durum"]==1){
        $yazi_durum='<a href="main.php?sayfa=durumdegis&degis=yazi_degis&id='.$row["yazi_id"].'"><img src="images/aktif.png"></a>';
      }
      echo '<tr>';
      echo
      '
      <td style="text-align:center;">'.$yazi_durum.'</td>
      <td>'.$row["yazi_adi"].'</td>
      <td>'.kullanici($db,$row["yazi_yazarId"],"kullanici_isim").' '.kullanici($db,$row["yazi_yazarId"],"kullanici_soyisim").'</td>
      <td>'.$row["yazi_guncellemeTarihi"].'</td>
      <td>
      <a href="main.php?sayfa=yaziduzenle&id='.$row["yazi_id"].'"><i class="fa fa-pencil"></i></a>
      <a href="main.php?sayfa=sil&sil=yazi_sil&id='.$row["yazi_id"].'" onclick="return confirmDel();"><i class="fa fa-trash"></i></a>
      </td>
      ';
      echo '</tr>';
    }
  }

}

function sayfa($db){
  $query=$db->query("SELECT * FROM sayfalar WHERE sayfa_durum=1 order by sayfa_adi asc",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      echo '<option value="'.$row["sayfa_id"].'">'.$row["sayfa_adi"].'</option>';
    }
  }
}
function sayfasorgula($db,$sayfa_adi,$sayfa_link){
  $query=$db->query("SELECT * FROM sayfalar WHERE sayfa_adi='$sayfa_adi' or sayfa_link='$sayfa_link'")->fetch(PDO::FETCH_ASSOC);
  if ($query) {
    return 1;
  }else{
    return 0;
  }
}
function sayfalistele($db){
  $query=$db->query("SELECT * FROM sayfalar order by sayfa_id desc ",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      if($row["sayfa_durum"]==0){
        $sayfa_durum='<a href="main.php?sayfa=durumdegis&degis=sayfa_degis&id='.$row["sayfa_id"].'"><img src="images/pasif.png"></a>';
      }else if($row["sayfa_durum"]==1){
        $sayfa_durum='<a href="main.php?sayfa=durumdegis&degis=sayfa_degis&id='.$row["sayfa_id"].'"><img src="images/aktif.png"></a>';
      }
      echo '<tr>';
      echo
      '
      <td style="text-align:center;">'.$sayfa_durum.'</td>
      <td>'.$row["sayfa_adi"].'</td>
      <td>'.kullanici($db,$row["sayfa_yazarId"],"kullanici_isim").' '.kullanici($db,$row["sayfa_yazarId"],"kullanici_soyisim").'</td>
      <td>'.$row["sayfa_guncellemeTarihi"].'</td>
      <td>
      <a href="main.php?sayfa=sayfaduzenle&id='.$row["sayfa_id"].'"><i class="fa fa-pencil"></i></a>
      <a href="main.php?sayfa=sil&sil=sayfa_sil&id='.$row["sayfa_id"].'" onclick="return confirmDel();"><i class="fa fa-trash"></i></a>
      </td>
      ';
      echo '</tr>';
    }
  }

}
function iletisimsosyalicon($db){
    $ayar_facebook=ayarlar($db,"ayar_facebook");
    $ayar_twitter=ayarlar($db,"ayar_twitter");
    $ayar_instagram=ayarlar($db,"ayar_instagram");
    $ayar_google=ayarlar($db,"ayar_google");
    $ayar_linkedin=ayarlar($db,"ayar_linkedin");
    if (!$ayar_facebook=="") {
        echo '<li><a href="'.$ayar_facebook.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-facebook"></i></a></li>';
    }
    if (!$ayar_twitter=="") {
        echo '<li><a href="'.$ayar_twitter.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-twitter "></i></a></li>';
    }
    if (!$ayar_instagram=="") {
        echo '<li><a href="'.$ayar_instagram.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-instagram "></i></a></li>';
    }
    if (!$ayar_google=="") {
        echo '<li><a href="'.$ayar_google.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-google "></i></a></li>';
    }
    if (!$ayar_linkedin=="") {
        echo '<li><a href="'.$ayar_linkedin.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-linkedin "></i></a></li>';
    }
}
function menusosyalicon($db){
  $ayar_facebook=ayarlar($db,"ayar_facebook");
  $ayar_twitter=ayarlar($db,"ayar_twitter");
  $ayar_instagram=ayarlar($db,"ayar_instagram");
  $ayar_google=ayarlar($db,"ayar_google");
  $ayar_linkedin=ayarlar($db,"ayar_linkedin");
  if (!$ayar_facebook=="") {
    echo '<li><a href="'.$ayar_facebook.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-facebook "></i></a></li>';
  }
  if (!$ayar_twitter=="") {
    echo '<li><a href="'.$ayar_twitter.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-twitter "></i></a></li>';
  }
  if (!$ayar_instagram=="") {
    echo '<li><a href="'.$ayar_instagram.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-instagram "></i></a></li>';
  }
  if (!$ayar_google=="") {
    echo '<li><a href="'.$ayar_google.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-google "></i></a></li>';
  }
  if (!$ayar_linkedin=="") {
    echo '<li><a href="'.$ayar_linkedin.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-linkedin "></i></a></li>';
  }
}
function altsosyalicon($db){
  $ayar_facebook=ayarlar($db,"ayar_facebook");
  $ayar_twitter=ayarlar($db,"ayar_twitter");
  $ayar_instagram=ayarlar($db,"ayar_instagram");
  $ayar_google=ayarlar($db,"ayar_google");
  $ayar_linkedin=ayarlar($db,"ayar_linkedin");
  if (!$ayar_facebook=="") {
    echo '<li><a href="'.$ayar_facebook.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-facebook "></i></a></li>';
  }
  if (!$ayar_twitter=="") {
    echo '<li><a href="'.$ayar_twitter.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-twitter "></i></a></li>';
  }
  if (!$ayar_instagram=="") {
    echo '<li><a href="'.$ayar_instagram.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-instagram "></i></a></li>';
  }
  if (!$ayar_google=="") {
    echo '<li><a href="'.$ayar_google.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-google "></i></a></li>';
  }
  if (!$ayar_linkedin=="") {
    echo '<li><a href="'.$ayar_linkedin.'" title="emre kara kişisel web sitesi & blog"><i class="fa fa-linkedin "></i></a></li>';
  }
}
function menulistele($db){
  $query=$db->query("SELECT * FROM sayfalar WHERE sayfa_durum=1 order by sayfa_adi asc",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      echo '<li><a href="sayfa/'.$row["sayfa_link"].'" title="'.$row["sayfa_adi"].' '.ayarlar($db,"ayar_title").'">'.$row["sayfa_adi"].'</a></li>';
    }
  }
}
function kategoriiceriksayisi($db,$kategori_id){
  $yazi=$db->query("SELECT COUNT(*) as toplam FROM yazilar WHERE yazi_kategori=$kategori_id and yazi_durum=1")->fetch(PDO::FETCH_ASSOC);
  return $yazi["toplam"];
}
function anasayfakategorilistele($db){
  $kategoriler=$db->query("SELECT * FROM kategoriler WHERE kategori_durum=1 ORDER BY kategori_adi asc",PDO::FETCH_ASSOC);
  if ($kategoriler->rowCount()) {
    foreach ($kategoriler as $kategori) {
      echo '<li>
<a href="kategori/'.$kategori["kategori_link"].'" title="'.$kategori["kategori_adi"].' '.ayarlar($db,"ayar_title").'">
      <img src="img/Kategori/Thumb/'.$kategori["kategori_icon"].'" alt="'.$kategori["kategori_adi"].'" style="width:24px; margin-top:-5px;">
      '.$kategori["kategori_adi"].' ('.kategoriiceriksayisi($db,$kategori["kategori_id"]).')
      </a>
      </li>';
    }
  }
}
function anasayfayazilistele($db,$kategori_link){
  //echo '<script type="text/javascript">alert("1");</script>';
  $sorgu="SELECT * FROM yazilar WHERE yazi_durum=1 ";
  if ($kategori_link) {
    $sorgu.="and yazi_kategori_link='$kategori_link' ";
  }
  $sorgu.="ORDER BY yazi_kayitTarihi desc";

  $yazilar=$db->query("$sorgu",PDO::FETCH_ASSOC);
  if ($yazilar->rowCount()) {
    foreach ($yazilar as $row) {
      $kullanici_avatar=kullanici($db,$row["yazi_yazarId"],"kullanici_avatar");
      $kullanici_isimSoyisim=kullanici($db,$row["yazi_yazarId"],"kullanici_isim")." ".kullanici($db,$row["yazi_yazarId"],"kullanici_soyisim");
      $yaziLink=ayarlar($db,"ayar_url").'yazi/'.$row["yazi_link"];
      echo
      '
      <div class="blog row">
      <div class="hiddex-xs col-md-2">
      <img src="img/Avatar/Thumb/'.$kullanici_avatar.'" alt="'.ayarlar($db,"ayar_title").'" class="w100 img-responsive img-square blog-profil"/>
      </div>
      <div class="col-md-10 blog-yazi ">
      <div class="row ">
      <div class="col-md-12 blog-baslik">
      <a href="'.$yaziLink.'" author="'.$kullanici_isimSoyisim.'" target="_top"><h2>'.$row["yazi_adi"].'</h2></a>
      </div>
      </div>
      <div class="row blog-bilgi">
      <div class="col-md-12 blog-yazar">
      <i class="fa fa-user"></i> Yazar: <span class="blog-yazar-icerik">'.$kullanici_isimSoyisim.'</span> &nbsp;
      <i class="fa fa-clock-o"></i> Tarih: <span class="blog-yazar-icerik">'.$row["yazi_guncellemeTarihi"].'</span>
      </div>
      </div>
      <div class="row blog-icerik">
      <div class="col-md-12">
      <img class="img-responsive" src="img/Yazi/Big/'.$row["yazi_icon"].'" alt="'.$row["yazi_adi"].'">
      </div>
      <div class="col-md-12">
      '.$row["yazi_icerik"].'
      </div>
      </div>
      <div class="row blog-paylas">
      <div class="col-md-8">
      <div class="ssb">
      <a href="https://www.facebook.com/sharer/sharer.php?u='.$yaziLink.'" title="Facebook ta Paylaş" target="_blank" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
      <a href="https://twitter.com/home?status='.$yaziLink.'" title="Twitter da Paylaş" target="_blank" class="btn btn-twitter"><i class="fa fa-twitter"></i> Twitter</a>
      <a href="https://plus.google.com/share?url='.$yaziLink.'" title="Google+ da Paylaş" target="_blank" class="btn btn-googleplus"><i class="fa fa-google-plus"></i> Google+</a>
      <a href="https://www.linkedin.com/shareArticle?mini=true&url='.$yaziLink.'" title="LinkedIn de Paylaş" target="_blank" class="btn btn-linkedin"><i class="fa fa-linkedin"></i> LinkedIn</a>
      </div>
      </div>
      <div class="col-md-4 devam-buton">
      <div class="text-rigth">
      <a href="'.$yaziLink.'" author="'.$kullanici_isimSoyisim.'">Devamı İçin..</a>
      </div>
      </div>
      </div>
      </div>
      </div>
      ';
    }
  }else{
    require_once("404.php");
  }
}
function sayfaiceriklistele($db,$sayfa_link){
  $sayfa=$db->query("SELECT * FROM sayfalar WHERE sayfa_link='$sayfa_link' and sayfa_durum=1")->fetch(PDO::FETCH_ASSOC);
  if ($sayfa) {
    $kullanici_isimSoyisim=kullanici($db,$sayfa["sayfa_yazarId"],"kullanici_isim")." ".kullanici($db,$sayfa["sayfa_yazarId"],"kullanici_soyisim");
    $sayfaLink=ayarlar($db,"ayar_url").'Sayfa/'.$sayfa["sayfa_link"];
    echo
    '
    <div class="blog row">
    <div class="col-md-12 blog-yazi ">
    <div class="row ">
    <div class="col-md-12 blog-baslik">
    <h3>'.$sayfa["sayfa_adi"].'</h3>
    </div>
    </div>
    <div class="row blog-bilgi">
    <div class="col-md-12 blog-yazar">
    <i class="fa fa-user"></i> Yazar: <span class="blog-yazar-icerik">'.$kullanici_isimSoyisim.'</span> &nbsp;
    <i class="fa fa-clock-o"></i> Tarih: <span class="blog-yazar-icerik">'.$sayfa["sayfa_guncellemeTarihi"].'</span>
    </div>
    </div>
    <div class="row blog-icerik">
    <div class="col-md-12">
    '.$sayfa["sayfa_icerik"].'
    </div>
    </div>
    <div class="row blog-paylas">
    <div class="col-md-12">
    <div class="ssb">
    <a href="https://www.facebook.com/sharer/sharer.php?u='.$sayfaLink.'" title="Facebook ta Paylaş" target="_blank" class="btn btn-facebook"><i class="fa fa-facebook"></i> Facebook</a>
    <a href="https://twitter.com/home?status='.$sayfaLink.'" title="Twitter da Paylaş" target="_blank" class="btn btn-twitter"><i class="fa fa-twitter"></i> Twitter</a>
    <a href="https://plus.google.com/share?url='.$sayfaLink.'" title="Google+ da Paylaş" target="_blank" class="btn btn-googleplus"><i class="fa fa-google-plus"></i> Google+</a>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url='.$sayfaLink.'" title="LinkedIn de Paylaş" target="_blank" class="btn btn-linkedin"><i class="fa fa-linkedin"></i> LinkedIn</a>
    </div>
    </div>
    </div>
    </div>
    </div>
    ';
  }else{
    header("Location:".ayarlar($db,"ayar_url")."");
  }
}
function analitiklistele($db){
    $query=$db->query("SELECT * FROM analitik order by analitik_id desc ",PDO::FETCH_ASSOC);
  if ($query->rowCount()) {
    foreach ($query as $row) {
      echo '<tr>';
      echo
      '
      <td><span class="analitik_ip pointer" title="'.$row["analitik_ip"].'">'.$row["analitik_ip"].'</span></td>
      <td>'.$row["analitik_tarayici"].'</td>
      <td>'.$row["analitik_hit"].'</td>
      <td>'.$row["analitik_kayitTarihi"].'</td>
      <td>
      <span class="Forward pointer" title="'.$row["analitik_id"].'"><i class="fa fa-pencil"></i></span>
      <a href="main.php?sayfa=sil&sil=analitik_sil&id='.$row["analitik_id"].'" onclick="return confirmDel();"><i class="fa fa-trash"></i></a>
      </td>
      ';
      echo '</tr>';
    }
  }
}
?>
