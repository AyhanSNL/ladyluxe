<?php
ob_start();
session_start();
error_reporting(0);
ini_set('error_reporting', E_ALL^E_NOTICE);
define("GUVENLIK",true);
date_default_timezone_set( 'Europe/Istanbul' );
include "includes/config/config.php";
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$odemesettings=$db->prepare("SELECT * from odeme_ayar where id='1'");
$odemesettings->execute(array(0));
$odemeayar=$odemesettings->fetch(PDO::FETCH_ASSOC);
$ipAdres = $_SERVER["REMOTE_ADDR"];
?>