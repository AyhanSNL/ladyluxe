<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: text/html; charset=utf-8');
include "../../../../includes/config/config.php";
ini_set('error_reporting', E_ALL^E_NOTICE);
date_default_timezone_set( 'Europe/Istanbul' );
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
/* AdmIN Kontrol */
$adminSorgu = $db->prepare("select * from yonetici where user_adi=:user_adi ");
$adminSorgu->execute(array(
    'user_adi' => $_SESSION['admin_user_session']
));
$adminRow = $adminSorgu->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> AdmIN Kontrol SON */
if($adminSorgu->rowCount()>'0'  ) {
    if($ayar['yonetici_log'] == '1' ) {
        $timestamp = date('Y-m-d G:i:s');
        $ip = $_SERVER["REMOTE_ADDR"];
        $kaydet = $db->prepare("INSERT INTO yonetici_log SET
                     ip=:ip,
                     islem=:islem,
                     tarih=:tarih,
                     admin_id=:admin_id
             ");
        $sonuc = $kaydet->execute(array(
            'ip' => $ip,
            'islem' => '0',
            'tarih' => $timestamp,
            'admin_id' => $adminRow['id']
        ));
        if($sonuc ) {
            header('Location:'.$ayar['panel_url'].'');
            unset($_SESSION['admin_user_session']);
        }else{
            header('Location:'.$ayar['panel_url'].'');
            unset($_SESSION['admin_user_session']);
        }
    }else{
        header('Location:'.$ayar['panel_url'].'');
        unset($_SESSION['admin_user_session']);
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>



