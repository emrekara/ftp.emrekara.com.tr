<?php
require_once("sistem/ayar.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo ayarlar($db,"ayar_title"); ?></title>
    <?php require_once("include/seo.php");?>

    <meta name="description" content="<?php echo ayarlar($db,"ayar_description"); ?>" >
    <meta name="keyword" content="<?php echo ayarlar($db,"ayar_keyword"); ?>">


    <!--Twitter-->
    <meta name="twitter:card" value="summary"/>
    <meta name="twitter:url" value="http://www.emrekara.com.tr/"/>
    <meta name="twitter:site" content="@emrekara9353">
    <meta name="twitter:title" content="<?php echo ayarlar($db,'ayar_title');?>"/>
    <meta name="twitter:creator" content="@emrekara9353"/>
    <meta name="twitter:description" content="<?php echo ayarlar($db,'ayar_description');?>"/>

    <!--Google Sheme-->
    <meta itemprop="name" content="Emre Kara | Web Master | Kişisel Blog">
    <meta itemprop="description" content="<?php echo ayarlar($db,'ayar,description');?>">
    <meta itemprop="image" content="http://www.emrekara.com.tr/img/Yazi/Big/20160428-001441YaYanmYYlYklarla_YaYYyorum.jpg">

    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="article:author" content="https://www.facebook.com/emrekara93">
    <meta property="article:publisher" content="https://www.facebook.com/emrekara93">
    <meta property="og:title" content="Emre Kara | Web Master | Kişisel Blog">
    <meta property="og:description" content="<?php echo ayarlar($db,'ayar_description');?>">
    <meta property="og:image" content="http://www.emrekara.com.tr/img/Yazi/Big/20160428-001441YaYanmYYlYklarla_YaYYyorum.jpg">
    <style type="text/css">
        #success_message{ display: none;}
    </style>
</head>
<body>
<?php require_once("include/header.php"); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <?php
                $durum = '';
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $recaptcha = $_POST['g-recaptcha-response'];
                    if (!empty($recaptcha)) {
                        $google_url = "https://www.google.com/recaptcha/api/siteverify";
                        $secret = '6LdMkB8TAAAAALb_P9PU5tnpPvPsBDpJjWjeWsFu';
                        //kullanıcının ip adresi
                        $ip = $_SERVER['REMOTE_ADDR'];
                        //istek adresini oluşturuyoruz
                        $url = $google_url . "?secret=" . $secret . "&response=" . $recaptcha . "&remoteip=" . $ip;
                        $res = curlKullan($url);
                        $res = json_decode($res, true);
                        //işlem başarılıysa çalışacak kısım
                        if ($res['success']) {
                            //örnek olduğu için güvenlik kontrolü yapmıyorum. Normalde zararlı kodları süzmelisiniz.

                            $isim = p('isim');
                            $mail = p('mail');
                            $gsm = p('gsm');
                            $sehir = p('sehir');
                            $website = p('website');
                            $mesaj = p('mesaj');
                            if (!empty($isim) && !empty($mail) && !empty($gsm) && !empty($sehir) && !empty($mesaj)) {
                                $ilet=
                                    '
              					<!DOCTYPE html>
              					<html>
              					<head>
              					<meta CharSet="utf8">
              					</head>
              					<body>
              					<div style="padding-left:15px;">
              					<span style="120px;">İsim Soyisim </span>='.$isim .'<br>
              					<span style="120px;">Email</span>='.$mail.'<br>
              					<span style="120px;">Telefon</span>='.$gsm.'<br>
              					<span style="120px;">Yaşadığı Şehir </span>='.$sehir.'<br>
              					<span style="120px;">Web Site Adresi</span>='.$website.'<br>
              					<span style="120px;">Mesajı</span>='.$mesaj.'<br>
              					</div>
              					</body>
              					</html>
              					';
                                include("include/lib/mailer/class.phpmailer.php");

                                $mail = new PHPMailer();
                                $mail->IsSMTP();
                                $mail->SMTPAuth = true;
                                $mail->Host = 'mail.emrekara.com.tr';
                                $mail->Port = 587;
                                $mail->SMTPSecure = 'tls';
                                $mail->Username = 'iletisim@emrekara.com.tr';
                                $mail->Password = 'Battal^3453';
                                $mail->SetFrom($mail->Username, 'Emre Kara İletişim Formu');
                                $mail->AddAddress('info@emrekara.com.tr', 'Emre Kara İletişim Formu');
                                $mail->CharSet = 'UTF-8';
                                $mail->Subject = 'Emre Kara İletişim Formu';
                                $mail->MsgHTML($ilet);

                                if($mail->Send()) {
                                    echo 'Mail gönderildi!';
                                } else {
                                    echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
                                }
                            } else {
                                echo '<script type="text/javascript">alert("Lütfen Boş Alan Bırakmayınız.");</script>';
                            }
                        } else {
                            echo '<script type="text/javascript">alert("Lütfen Bot Olmadığınızı Doğrulayın.");</script>';
                        }
                    } else {
                        echo '<script type="text/javascript">alert("Lütfen Bot Olmadığınızı Doğrulayın.");</script>';
                    }
                }
                ?>
                <div id="feedback">
                    <div class="container">
                        <div class="col-md-5">
                            <div class="form-area">
                                <form action="" method="post" role="form">
                                    <br style="clear:both">
                                    <h3 style="margin-bottom: 25px; text-align: center;">İletişim Formu</h3>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="isim" placeholder="İsim Soyisim" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="email" name="mail" placeholder="Email Adresi" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="address" name="gsm" placeholder="Telefon Numaranız" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="subject" name="sehir" placeholder="Şehir" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="subject" name="website" placeholder="Web Siteniz" >
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" type="textarea" name="mesaj" id="mesaj" placeholder="Mesajınız" maxlength="140" rows="7"></textarea>
                                    </div>

                                    <div class="g-recaptcha" data-sitekey="6LdMkB8TAAAAADcXpTe-E66YdgnYXxQ0vF2c6xqF"></div>
                                    <button type="button" id="submit" name="submit" class="btn btn-primary pull-right" style="margin-bottom: 15px; margin-top: -35px;">Formu Gönder</button>

                                </form>
                            </div>
                        </div>
                    </div> <!--feedback-->
                </div>
            </div>
            <div class="col-md-6">
                <br style="clear:both">
                <h3 style="margin-bottom: 25px; text-align: center;">İletişim Adresleri</h3>
                <div class="form-group">
                    <div class="col-md-4">
                        <b>Email Adresi</b>
                    </div>
                    <div class="col-md-8">
                        : <?php echo ayarlar($db,"ayar_email");?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4">
                        <b>Telefon Numarası</b>
                    </div>
                    <div class="col-md-8">
                        : <?php echo ayarlar($db,"ayar_telefon");?>
                    </div>
                </div>
                <br style="clear:both">
                <h4 style="margin-bottom: 25px; text-align: center;">Sosyal Medya Adresleri</h4>
                <div class="form-group">
                    <div class="col-md-12 ">
                        <ul class="iletisimsocial">
                            <?php echo menusosyalicon($db);?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once("include/footer.php"); ?>
</body>
</html>
