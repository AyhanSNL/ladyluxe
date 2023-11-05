<?php
//todo ioncube
ob_start();
session_start();
$_SESSION['session']=session_id();
error_reporting(0);
header('Content-Type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL^E_NOTICE);
error_reporting(0);
define("GUVENLIK",true);
date_default_timezone_set( 'Europe/Istanbul' );
include "includes/config/config.php";
include "includes/config/language.php";
include "includes/config/parabirimi.php";
include "includes/config/functions.php";
include 'includes/config/Mobile_Detect.php';
$detect = new Mobile_Detect;
function isMobileDevice()
{
    global $detect;
    return $detect->isMobile();
}
include "includes/config/hit.php";
//** Ayar SQL */
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$siteurl = $ayar['site_url'];
$site_adi = $ayar['site_baslik'];
$demo = $ayar['demo_mod'];
$licenceProcessRequestAddress = $ayar['merchant_request'];
$sms_setting = $db->prepare("select * from sms where id='1'");
$sms_setting->execute();
$sms = $sms_setting->fetch(PDO::FETCH_ASSOC);
$odemesettings=$db->prepare("SELECT * from odeme_ayar where id='1'");
$odemesettings->execute(array(0));
$odemeayar=$odemesettings->fetch(PDO::FETCH_ASSOC);
$BakimDurum = $db->prepare("select * from bakim where id='1' and durum='1' order by id");
$BakimDurum->execute();
$bakim = $BakimDurum->fetch(PDO::FETCH_ASSOC);
$cacheCek = $db->prepare("select * from cache where id='1'");
$cacheCek->execute();
$cacheRow = $cacheCek->fetch(PDO::FETCH_ASSOC);
$dilMevcut = $db->prepare("select * from dil where kisa_ad=:kisa_ad order by id");
$dilMevcut->execute(array(
    'kisa_ad' => $_SESSION['dil'] ,
));
$current_lang = $dilMevcut->fetch(PDO::FETCH_ASSOC);
?>
<?php
$mevcut_adresi_cek = ''.$ayar['protokol'].''.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'].'';
$_SESSION['mevcut_adres_cek'] = $mevcut_adresi_cek;
?>
<?php
$uyelikAyar = $db->prepare("select * from uyeler_ayar where id=:id ");
$uyelikAyar->execute(array(
        'id' => '1'
    )
);
$uyeayar = $uyelikAyar->fetch(PDO::FETCH_ASSOC);
?>
<?php if($uyeayar['durum'] == '0' ) {?>
    <?php unset($_SESSION['user_email_address']); ?>
<?php }?>
<?php
$userSorgusu = $db->prepare("select * from uyeler where eposta=:eposta and onay=:onay order by id");
$userSorgusu->execute(array(
    'eposta' => $_SESSION['user_email_address'],
    'onay' => '1',
));
$userCek = $userSorgusu->fetch(PDO::FETCH_ASSOC);
if ($userSorgusu->rowCount()<=0){
    unset($_SESSION['user_email_address']);
}
/* Grup süresi kontrolü */
if($userSorgusu->rowCount()>'0'  ) {
    if($userCek['uye_grup'] >'0' ) {
        if($userCek['uye_grup_sure_durum'] == '1' ) {
            $today =  date('Y-m-d');
            if($userCek['uye_grup_sure_2'] < $today  ) {
                $guncelle = $db->prepare("UPDATE uyeler SET
                        uye_grup=:uye_grup     
                      WHERE id={$userCek['id']}      
                     ");
                $sonuc = $guncelle->execute(array(
                    'uye_grup' => null,
                ));
            }
        }
    }
}
/*  <========SON=========>>> Grup süresi kontrolü SON */
/* Onaysız Üyelik */
$userSorgusuOnaysiz = $db->prepare("select * from uyeler where eposta=:eposta and onay=:onay order by id");
$userSorgusuOnaysiz->execute(array(
    'eposta' => $_SESSION['user_email_address_onaysiz'],
    'onay' => '0'
));
$userOcek = $userSorgusuOnaysiz->fetch(PDO::FETCH_ASSOC);
if ($userSorgusuOnaysiz->rowCount()<=0){
    unset($_SESSION['user_email_address_onaysiz']);
}
/*  <========SON=========>>> Onaysız Üyelik SON */
$uyegruplariCek = $db->prepare("select * from uyeler_grup where id=:id ");
$uyegruplariCek->execute(array(
    'id' => $userCek['uye_grup']
));
$uyegrup = $uyegruplariCek->fetch(PDO::FETCH_ASSOC);
/* E-Posta Template */
$ePostaTema = $db->prepare("select * from eposta_tema where id=:id");
$ePostaTema->execute(array(
    'id' => '1'
));
$epostatema = $ePostaTema->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> E-Posta Template SON */
/* Sepet Count */
$ipAdres = $_SERVER["REMOTE_ADDR"];
$shopCount = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
$shopCount->execute(array(
    'ip' => $ipAdres,
    'sepet_durum' => '1'
));
$shoppingCartCount = $shopCount->rowCount();
/*  <========SON=========>>> Sepet Count SON */

/* Bildirimler */
$bildirimAyar = $db->prepare("select * from bildirimler_ayar where id=:id ");
$bildirimAyar->execute(array(
    'id' => '1'
));
$bildirimayar = $bildirimAyar->fetch(PDO::FETCH_ASSOC);
if($bildirimayar['durum'] == '1') {
    $bellCountQuery = $db->prepare("select * from bildirimler where dil=:dil and durum=:durum");
    $bellCountQuery->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1'
    ));
    $bellCountTotal = 0;
    $bellCountTotalUser = 0;
    $bellCountTotalUserID = 0;
    foreach ($bellCountQuery as $bellquery){
        if($bellquery['tur'] == '0'  ) {
            $ip = $_SERVER["REMOTE_ADDR"];
            $bellIPKontrolHead = $db->prepare("select * from bildirimler_ip where ip_adres=:ip_adres and bildirim_id=:bildirim_id ");
            $bellIPKontrolHead->execute(array(
                'ip_adres' => $ip,
                'bildirim_id' => $bellquery['bildirim_id']
            ));
        }
        if($bellquery['tur'] == '1'  ) {
            $bellIPKontrolHead = $db->prepare("select * from bildirimler_ip where uye_id=:uye_id and bildirim_id=:bildirim_id ");
            $bellIPKontrolHead->execute(array(
                'uye_id' => $userCek['id'],
                'bildirim_id' => $bellquery['bildirim_id']
            ));
        }
        if($bellquery['tur'] == '2'  ) {
            $bellIPKontrolHead = $db->prepare("select * from bildirimler_ip where uye_id=:uye_id and bildirim_id=:bildirim_id ");
            $bellIPKontrolHead->execute(array(
                'uye_id' => $userCek['id'],
                'bildirim_id' => $bellquery['bildirim_id']
            ));
        }
        if($bellquery['tur'] == '0' && $bellquery['uye_id'] <= '0' && $bellIPKontrolHead->rowCount()<='0'  ) {
            $bellCountTotal = $bellCountTotal+($bellquery['durum']);
        }
        if($bellquery['tur'] == '1' && $userSorgusu->rowCount()>'0' && $bellIPKontrolHead->rowCount()<='0'  ) {
            $bellCountTotalUser = $bellCountTotalUser+($bellquery['durum']);
        }
        if($bellquery['tur'] == '2' && $bellquery['uye_id'] == $userCek['id'] && $bellIPKontrolHead->rowCount()<='0'  ) {
            $bellCountTotalUserID = $bellCountTotalUserID+($bellquery['durum']);
        }
    }
}
/*  <========SON=========>>> Bildirimler SON */










?>