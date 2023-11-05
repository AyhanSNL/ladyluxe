<?php
if($_POST && isset($_POST['newPassword'])){

    $sifre1 = trim(strip_tags($_POST['yenisifre']));
    $sifre2 = trim(strip_tags($_POST['yenisifre_tekrar']));
    $hash = trim(strip_tags($_POST['hash']));

    $hashSorgu = $db->prepare("select * from uyeler_reset_sifre where kod=:kod and durum=:durum ");
    $hashSorgu->execute(array(
        'kod' => $hash,
        'durum' => '0'
    ));
    $hashRow = $hashSorgu->fetch(PDO::FETCH_ASSOC);

    if($hashSorgu->rowCount()>'0'  ) {
        if($sifre1 && $sifre2  ) {
            if($sifre1 == $sifre2  ) {

                $sifre = md5($sifre1);
                
                $guncelle = $db->prepare("UPDATE uyeler SET
                        uyesifre=:uyesifre
                 WHERE id={$hashRow['uye_id']}      
                ");
                $sonuc = $guncelle->execute(array(
                    'uyesifre' => $sifre
                ));
                if($sonuc){
                    $_SESSION['sifredegis_durum'] = 'success';
                    header('Location:'.$ayar['site_url'].'uye-girisi/');
                    $silmeislem = $db->prepare("DELETE from uyeler_reset_sifre WHERE kod=:kod");
                    $silmeislem->execute(array(
                       'kod' => $hash
                    ));
                }else{
                echo 'Veritabanı Hatası';
                }
            }else{
                $_SESSION['sifredegis_durum'] = 'sifrefarkli';
                header('Location:'.$ayar['site_url'].'sifre-sifirla/?hash='.$hash.'');
            }
        }else{
            $_SESSION['sifredegis_durum'] = 'empty';
            header('Location:'.$ayar['site_url'].'sifre-sifirla/?hash='.$hash.'');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }

} else {
    header('Location:'.$ayar['site_url'].'404');
}
?>