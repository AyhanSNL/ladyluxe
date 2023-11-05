<?php
//todo ioncube
ob_start();
session_start();
error_reporting(0);
header('Content-Type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL^E_NOTICE);
define("GUVENLIK",true);
include "../includes/config/config.php";
include "../includes/config/functions.php";
include "../includes/config/admin_language.php";
include "inc/functions.php";
date_default_timezone_set( 'Europe/Istanbul' );
//** Ayar SQL */
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$licenceProcessRequestAddress = $ayar['merchant_request'];

/* AdmIN Kontrol */
$adminSorgu = $db->prepare("select * from yonetici where user_adi=:user_adi ");
$adminSorgu->execute(array(
    'user_adi' => $_SESSION['admin_user_session']
));
$adminRow = $adminSorgu->fetch(PDO::FETCH_ASSOC);

/*  <========SON=========>>> AdmIN Kontrol SON */
/* Panel Ayar */
$panelAyarRow = $db->prepare("select * from panel_ayar where id=:id ");
$panelAyarRow->execute(array(
    'id' => '1',
));
$panelayar = $panelAyarRow->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Panel Ayar SON */

/* mevcut Dil */
$CurrentLang = $db->prepare("select * from dil where kisa_ad=:kisa_ad ");
$CurrentLang->execute(array(
    'kisa_ad' => $_SESSION['dil'],
));
$mevcutdil = $CurrentLang->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> mevcut Dil SON */

/* Ticaret Ayarları */
$odemeAyar = $db->prepare("select * from odeme_ayar where id='1' ");
$odemeAyar->execute();
$odemeRow = $odemeAyar->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Ticaret Ayarları SON */

/* Yetki çek */
$yetkiSorgu = $db->prepare("select * from yetki_grup where id=:id ");
$yetkiSorgu->execute(array(
    'id' => $adminRow['yetki']
));
$yetki = $yetkiSorgu->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Yetki çek SON */

/* Bakım */
$bakimCheck = $db->prepare("select * from bakim where id=:id ");
$bakimCheck->execute(array(
    'id' => '1',
));
$bakim = $bakimCheck->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Bakım SON */


/* Popup */
$popupCheck = $db->prepare("select * from popup where id=:id ");
$popupCheck->execute(array(
    'id' => '1',
));
$popup = $popupCheck->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Popup SON */

/* varsayılan Para birimi */
$Varsayilan_Para_Birimi = $db->prepare("select * from para_birimleri where varsayilan=:varsayilan and durum=:durum ");
$Varsayilan_Para_Birimi->execute(array(
    'varsayilan' => '1',
    'durum' => '1'
));
$Current_Money = $Varsayilan_Para_Birimi->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> varsayılan Para birimi SON */

/* SMS */
$sms_setting = $db->prepare("select * from sms where id='1'");
$sms_setting->execute();
$sms = $sms_setting->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> SMS SON */

/* E-Posta Template */
$ePostaTema = $db->prepare("select * from eposta_tema where id=:id");
$ePostaTema->execute(array(
    'id' => '1'
));
$epostatema = $ePostaTema->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> E-Posta Template SON */

/* Bildirim Ayarları */
$bildirimAyar = $db->prepare("select * from bildirimler_ayar where id=:id ");
$bildirimAyar->execute(array(
    'id' => '1'
));
$notiSet = $bildirimAyar->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Bildirim Ayarları SON */

$uyelikAyar = $db->prepare("select * from uyeler_ayar where id=:id ");
$uyelikAyar->execute(array(
        'id' => '1'
    )
);
$uyeayar = $uyelikAyar->fetch(PDO::FETCH_ASSOC);




?>