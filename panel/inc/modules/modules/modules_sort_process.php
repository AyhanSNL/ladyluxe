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


if(isset($_GET['islem_id'])  ) {

    if($yetki['demo'] != '1' ) {
        $islem_id = $_GET['islem_id'];

        $statusCek = $db->prepare("select * from moduller where id=:id ");
        $statusCek->execute(array(
            'id' => $islem_id
        ));

        if($statusCek->rowCount()>'0'  ) {
            $st = $statusCek->fetch(PDO::FETCH_ASSOC);


            if($st['durum'] == '1' ) {
                $statusum = '0';
            }
            if($st['durum'] == '0' ) {
                $statusum = '1';
            }

            $guncelle = $db->prepare("UPDATE moduller SET
                 durum=:durum
          WHERE id={$islem_id}      
         ");
            $sonuc = $guncelle->execute(array(
                'durum' => $statusum
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