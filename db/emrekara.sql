-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 Mar 2016, 21:25:03
-- Sunucu sürümü: 5.6.17
-- PHP Sürümü: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `emrekara`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE IF NOT EXISTS `ayarlar` (
  `ayar_id` int(11) NOT NULL AUTO_INCREMENT,
  `ayar_title` varchar(255) NOT NULL,
  `ayar_description` text NOT NULL,
  `ayar_keyword` text NOT NULL,
  `ayar_copyright` varchar(255) NOT NULL,
  `ayar_logo` varchar(255) NOT NULL,
  `ayar_email` varchar(255) NOT NULL,
  `ayar_telefon` varchar(255) NOT NULL,
  `ayar_facebook` varchar(255) NOT NULL,
  `ayar_twitter` varchar(255) NOT NULL,
  `ayar_instagram` varchar(255) NOT NULL,
  `ayar_google` varchar(255) NOT NULL,
  `ayar_linkedin` varchar(255) NOT NULL,
  `ayar_url` varchar(255) NOT NULL,
  PRIMARY KEY (`ayar_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`ayar_id`, `ayar_title`, `ayar_description`, `ayar_keyword`, `ayar_copyright`, `ayar_logo`, `ayar_email`, `ayar_telefon`, `ayar_facebook`, `ayar_twitter`, `ayar_instagram`, `ayar_google`, `ayar_linkedin`, `ayar_url`) VALUES
(1, 'Emre Kara | Kişisel Web Sitesi | Blog', 'Emre Kara Kişisel Web Site ve Bloğudur. Hakkında ve Yaptıkları Projeler Hakkında Bilgi Edinebilirsiniz.', 'emre kara, emre kara kişisel web sitesi,web tasarim, emre, kara, php, yazılımcı, bloger, css, html, script, web site tasarımı, kurumsal site', 'Şükür', 'emre-kara-kisisel-web-sitesi-blog_2.png', 'iletisim@emrekara.com.tr', '0531 968 09 37', 'https://www.facebook.com/emrekara93', 'https://twitter.com/emrekara9353', 'https://www.instagram.com/karaemre53/', 'https://plus.google.com/u/0/105358139157875829971', 'https://www.linkedin.com/in/karaemre', 'http://localhost/emrekara.com.tr/');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE IF NOT EXISTS `kategoriler` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_ustId` int(5) NOT NULL,
  `kategori_adi` varchar(255) NOT NULL,
  `kategori_yazarId` int(11) NOT NULL,
  `kategori_link` varchar(255) NOT NULL,
  `kategori_kisaAciklama` text NOT NULL,
  `kategori_description` text NOT NULL,
  `kategori_keyword` text NOT NULL,
  `kategori_icerik` text NOT NULL,
  `kategori_icon` varchar(255) NOT NULL,
  `kategori_durum` int(5) NOT NULL,
  `kategori_kayitTarihi` text NOT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`kategori_id`, `kategori_ustId`, `kategori_adi`, `kategori_yazarId`, `kategori_link`, `kategori_kisaAciklama`, `kategori_description`, `kategori_keyword`, `kategori_icerik`, `kategori_icon`, `kategori_durum`, `kategori_kayitTarihi`) VALUES
(1, 0, 'PHP', 0, 'php', '', 'Emre Kara PHP Deneyimleri', 'emre kara php, php, php dili, php deneyim', '', '20160320-171503.png', 1, '2016-03-20 17:13:42');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `kullanici_id` int(11) NOT NULL AUTO_INCREMENT,
  `kullanici_adi` varchar(255) NOT NULL,
  `kullanici_sifreBase` varchar(255) NOT NULL,
  `kullanici_sifre` varchar(255) NOT NULL,
  `kullanici_email` varchar(255) NOT NULL,
  `kullanici_isim` varchar(255) NOT NULL,
  `kullanici_soyisim` varchar(255) NOT NULL,
  `kullanici_telefon` varchar(255) NOT NULL,
  `kullanici_facebook` varchar(255) NOT NULL,
  `kullanici_twitter` varchar(255) NOT NULL,
  `kullanici_instagram` varchar(255) NOT NULL,
  `kullanici_youtube` varchar(255) NOT NULL,
  `kullanici_google` varchar(255) NOT NULL,
  `kullanici_avatar` varchar(255) NOT NULL,
  `kullanici_meslek` varchar(255) NOT NULL,
  `kullanici_ustId` int(5) NOT NULL,
  `kullanici_yetki` varchar(255) NOT NULL,
  `kullanici_durum` int(5) NOT NULL,
  `kullanici_kayitTarihi` timestamp NOT NULL,
  PRIMARY KEY (`kullanici_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `kullanici_adi`, `kullanici_sifreBase`, `kullanici_sifre`, `kullanici_email`, `kullanici_isim`, `kullanici_soyisim`, `kullanici_telefon`, `kullanici_facebook`, `kullanici_twitter`, `kullanici_instagram`, `kullanici_youtube`, `kullanici_google`, `kullanici_avatar`, `kullanici_meslek`, `kullanici_ustId`, `kullanici_yetki`, `kullanici_durum`, `kullanici_kayitTarihi`) VALUES
(1, 'emrekara', '123456', 'e10adc3949ba59abbe56e057f20f883e', 'iletisim@emrekara.com.tr', 'Emre', 'Kara', '0531 968 09 37', 'https://www.facebook.com/emrekara93', 'https://twitter.com/emrekara9353', 'https://www.instagram.com/karaemre53/', 'https://www.youtube.com/channel/UCez6vdWx_m3kl--vMtcXXaA', 'https://plus.google.com/105358139157875829971', '20160306-151359emrekara.jpg', 'Bilgisayar Programcılığı', 0, '1', 1, '2016-02-26 19:47:06');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sayfalar`
--

CREATE TABLE IF NOT EXISTS `sayfalar` (
  `sayfa_id` int(11) NOT NULL AUTO_INCREMENT,
  `sayfa_ustId` int(5) NOT NULL,
  `sayfa_yazarId` int(11) NOT NULL,
  `sayfa_adi` varchar(255) NOT NULL,
  `sayfa_link` varchar(255) NOT NULL,
  `sayfa_kisaAciklama` varchar(255) NOT NULL,
  `sayfa_description` text NOT NULL,
  `sayfa_keyword` text NOT NULL,
  `sayfa_icerik` text NOT NULL,
  `sayfa_kayitTarihi` varchar(255) NOT NULL,
  `sayfa_durum` int(11) NOT NULL,
  `sayfa_icon` varchar(255) NOT NULL,
  `sayfa_guncellemeTarihi` varchar(255) NOT NULL,
  PRIMARY KEY (`sayfa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `sayfalar`
--

INSERT INTO `sayfalar` (`sayfa_id`, `sayfa_ustId`, `sayfa_yazarId`, `sayfa_adi`, `sayfa_link`, `sayfa_kisaAciklama`, `sayfa_description`, `sayfa_keyword`, `sayfa_icerik`, `sayfa_kayitTarihi`, `sayfa_durum`, `sayfa_icon`, `sayfa_guncellemeTarihi`) VALUES
(2, 0, 1, 'Hakkımda', 'hakkimda', 'Emre Kara Kişisel Blog Projesidir.', 'Emre Kara Kişisel Blog Projesidir.', 'emre kara, emrekara, hakkında, emrekara hakkında, emre kara hakkında, emre kara php', '<p>Eyl&uuml;l 1993 İstanbul doğumluyum. &Ccedil;ok sakin olmasa da &ccedil;ocukluğumun &ccedil;oğu d&ouml;nemi hastanelerde ge&ccedil;miştir. &Ccedil;ocukluğumdan gelen bilgisayar, bilgisayar oyunlarına merakımdan dolayı o zamanlar her ne kadar bilgisayar m&uuml;hendisi olmak istesem de lise d&ouml;nemlerim de bu hayallerim yerini yazılım ve tasarım olarak Bilgisayar Programcılığı b&ouml;l&uuml;m&uuml;ne s&uuml;r&uuml;kledi.</p>\r\n\r\n<p>Lise d&ouml;nemlerimde gerek okuldaki meslek deslerinde ve gerekse o zamanlar internette dolaşan eğitim videolarını izleyerek kendimi geliştirme fırsatı buldum. Lise d&ouml;nemimde meslek dersleri dışında &ccedil;ok b&uuml;y&uuml;k bir başarı sağlayamasam da g&uuml;zel bir ortalamayla (4.08*) lise d&ouml;nemimi tamamladım. Lise stajımı notebook tamiri gibi bir alanda yaptığım i&ccedil;in donanım alanında da kendi bilgilerimin &uuml;st&uuml;ne katarak kendimi daha da geliştirdim.</p>\r\n\r\n<p>&Uuml;niversite d&ouml;nemimde bir yıllık hazırlığın ardından lisedeki b&ouml;l&uuml;m&uuml;m&uuml; devam ettirerek Bilgisayar Programcılığı b&ouml;l&uuml;m&uuml;ne devam ettim. &Uuml;niversite stajımı d&uuml;nya &ccedil;apında bir otelin bilgi işlem departmanında yaparak deneyimime deneyim kattım. &Uuml;niversite de bol eğlenceli, gezerek ve arkadaş ortamında 2 yıllık b&ouml;l&uuml;m&uuml;m&uuml; bitirerek mezun oldum (3.13**).</p>\r\n\r\n<p>&nbsp;</p>', '2016-03-20 13:21:53', 1, '20160327-224245HakkYmda.png', '2016-03-27 22:42:45');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yazilar`
--

CREATE TABLE IF NOT EXISTS `yazilar` (
  `yazi_id` int(11) NOT NULL AUTO_INCREMENT,
  `yazi_kategori` int(5) NOT NULL,
  `yazi_yazarId` int(5) NOT NULL,
  `yazi_adi` varchar(255) NOT NULL,
  `yazi_link` varchar(255) NOT NULL,
  `yazi_kisaAciklama` text NOT NULL,
  `yazi_keyword` text NOT NULL,
  `yazi_description` text NOT NULL,
  `yazi_icerik` text NOT NULL,
  `yazi_kayitTarihi` varchar(255) NOT NULL,
  `yazi_durum` int(5) NOT NULL,
  `yazi_icon` varchar(255) NOT NULL,
  `yazi_guncellemeTarihi` varchar(255) NOT NULL,
  PRIMARY KEY (`yazi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Tablo döküm verisi `yazilar`
--

INSERT INTO `yazilar` (`yazi_id`, `yazi_kategori`, `yazi_yazarId`, `yazi_adi`, `yazi_link`, `yazi_kisaAciklama`, `yazi_keyword`, `yazi_description`, `yazi_icerik`, `yazi_kayitTarihi`, `yazi_durum`, `yazi_icon`, `yazi_guncellemeTarihi`) VALUES
(9, 1, 1, 'İlk Yazı', 'ilk-yazi', 'İlk Yazı Bu Ulan', 'ilk yazi,', 'İlk Yazı Bu Ulan', '<p><br />\r\nMerhaba Bu ilk Yazı</p>', '2016-03-20 19:51:35', 1, '', '2016-03-20 19:51:35'),
(10, 0, 1, 'qwe', 'qwe', 'qwe', 'qwe', 'qwe', '<p>qwe</p>', '2016-03-27 11:39:29', 0, '', '2016-03-27 16:39:08'),
(11, 0, 1, 'Yaşanmışlıklarla Yaşıyorum', 'yasanmisliklarla-yasiyorum', 'Emre Kara Yaşanmışlıklarla Yaşıyorum', 'Yaşanmışlıklarla Yaşıyorum, emre kara, blog,', 'Emre Kara Yaşanmışlıklarla Yaşıyorum', '<p><img alt=\\\\\\"\\\\\\" src=\\\\\\"/emrekara.com.tr/Upload/images/1.jpg\\\\\\" style=\\\\\\"height:635px; width:1600px\\\\\\" />Yaşanmışlıklarla yaşıyorum kimseye ses etmeden,</p>\r\n\r\n<p>Yaşanmışlıklarla yaşıyorum seni g&ouml;rmeden,</p>\r\n\r\n<p>Yaşanmışlıklarla yaşıyorum seni hissederek,</p>\r\n\r\n<p>Yaşanmışlıklarla yaşıyorum sensiz olarak.</p>', '2016-03-29 21:12:04', 1, '', '2016-03-29 21:14:13');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
