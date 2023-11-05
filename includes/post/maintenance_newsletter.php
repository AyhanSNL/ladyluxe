<?php
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
ini_set('error_reporting', E_ALL^E_NOTICE);
date_default_timezone_set( 'Europe/Istanbul' );
include "../config/config.php";
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$demo = $ayar['demo_mod'];
?>
<?php if($_POST && isset($_POST['goAddress'])  ) {?>
    <?php
    $eposta_adres = trim(strip_tags($_POST['eposta']));
    if($eposta_adres) {
        if($demo != '1'  ){
            if (filter_var($eposta_adres, FILTER_VALIDATE_EMAIL)){
                $timestamp = date('Y-m-d G:i:s');
                $kaydet = $db->prepare("INSERT INTO ebulten SET
     eposta=:eposta,       
     tarih=:tarih
    ");
                $sonuc = $kaydet->execute(array(
                    'eposta' => $eposta_adres,
                    'tarih' => $timestamp
                ));
                if($sonuc){
                    $_SESSION['alert'] = 'success';
                    header('Location:'.$ayar['site_url'].'');
                }else{
                    echo 'Veritabanı Hatası';
                }
            }else{
                $_SESSION['alert'] = 'epostasorun';
                header('Location:'.$ayar['site_url'].'');
            }
        }else{
            $_SESSION['alert'] = 'bos';
            header('Location:'.$ayar['site_url'].'');
        }
    }else{
        $_SESSION['ebulten_sonuc'] = 'empty';
        header('Location:'.$ayar['site_url'].'');
    }
    ?>
<?php }else { ?>
    <?php
    header('Location:'.$ayar['site_url'].'');
    ?>
<?php }?>