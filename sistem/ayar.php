<?php
session_start();
error_reporting(1);
try {
$db=new PDO("mysql:host=localhost;dbname=emrekara_root;charset=utf8","emrekara_root","Battal^3453");
} catch (PDOException $e) {
print $e->getMessage();
}
$mainpage="http://www.emrekara.com.tr/";
require_once("fonksiyon.php");
girisKayit($db);
?>
