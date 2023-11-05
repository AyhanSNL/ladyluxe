<?php
//todo ioncube
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
if($_POST && isset($_POST['login']) ) {
    $user = trim(strip_tags($_POST['username']));
    $pass = $_POST['password'];
    if($user && $pass  ) {
        $md5pass = md5($pass);
        $adminCheck = $db->prepare("select * from yonetici where user_adi=:user_adi and pass_sifre=:pass_sifre  ");
        $adminCheck->execute(array(
            'user_adi' => $user,
            'pass_sifre' => $md5pass
        ));
        if($adminCheck->rowCount()>'0'  ) {
            $adminrow = $adminCheck->fetch(PDO::FETCH_ASSOC);
            if($ayar['login_log'] == '1' ) { 
             $timestamp = date('Y-m-d G:i:s');
             $ip = $_SERVER["REMOTE_ADDR"];
             $kaydet = $db->prepare("INSERT INTO login_log SET
                     ip=:ip,
                     durum=:durum,
                     tarih=:tarih,
                     admin_id=:admin_id
             ");
             $sonuc = $kaydet->execute(array(
                 'ip' => $ip,
                 'durum' => '1',
                 'tarih' => $timestamp,
                 'admin_id' => $adminrow['id']
             ));
            }
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
                    'islem' => '1',
                    'tarih' => $timestamp,
                    'admin_id' => $adminrow['id']
                ));
            }
            $_SESSION['admin_user_session'] = $adminrow['user_adi'];
            header('Location:'.$ayar['panel_url'].'');
        }else{
            if($ayar['login_log'] == '1' ) {
                $timestamp = date('Y-m-d G:i:s');
                $ip = $_SERVER["REMOTE_ADDR"];
                $kaydet = $db->prepare("INSERT INTO login_log SET
                     ip=:ip,
                     durum=:durum,
                     tarih=:tarih
             ");
                $sonuc = $kaydet->execute(array(
                    'ip' => $ip,
                    'durum' => '0',
                    'tarih' => $timestamp
                ));
            }
            $_SESSION['login_alert'] ='nouser';
            header('Location:'.$ayar['panel_url'].'login/');
        }
    }else{
        $_SESSION['login_alert'] ='empty';
        header('Location:'.$ayar['panel_url'].'login/');
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>