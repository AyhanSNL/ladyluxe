<?php
ob_start();
session_start();
include "../../../../includes/config/config.php";
/* AdmIN Kontrol */
$adminSorgu = $db->prepare("select * from yonetici where user_adi=:user_adi ");
$adminSorgu->execute(array(
    'user_adi' => $_SESSION['admin_user_session']
));
$adminRow = $adminSorgu->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> AdmIN Kontrol SON */
/* Yetki çek */
$yetkiSorgu = $db->prepare("select * from yetki_grup where id=:id ");
$yetkiSorgu->execute(array(
    'id' => $adminRow['yetki']
));
$yetki = $yetkiSorgu->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Yetki çek SON */


if(isset($_GET['gorev_id'])  ) {

    if($yetki['demo'] != '1' ) {
        $gorev_id = $_GET['gorev_id'];

        $gorevCek = $db->prepare("select * from panel_todo where random_id=:random_id ");
        $gorevCek->execute(array(
            'random_id' => $gorev_id
        ));

        if($gorevCek->rowCount()>'0'  ) {
            $timestamp = date('Y-m-d G:i:s');
            $guncelle = $db->prepare("UPDATE panel_todo SET
             durum=:durum,
             do_tarih=:do_tarih
      WHERE random_id={$gorev_id}      
     ");
            $sonuc = $guncelle->execute(array(
                'durum' => '1',
                'do_tarih' => $timestamp,
            ));
            if($sonuc){
                die(json_encode(array()));
            }else{
                echo 'Veritabanı Hatası';
            }
        }
    }else{

        $_SESSION['main_alert'] ='demo';
        die(json_encode(array()));

    }


}
?>