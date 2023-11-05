<?php
if($_POST  && $userSorgusu->rowCount()>'0'){

    $mevcutsifre = trim(strip_tags($_POST['old_password']));
    $sifre1 = trim(strip_tags($_POST['new_password']));
    $sifre2 = trim(strip_tags($_POST['new_password_again']));

    if($demo != '1'  ){
    if(md5($mevcutsifre) == $userCek['uyesifre'] ) {

        if($sifre1 && $sifre2  ) {
            if($sifre1 == $sifre2  ) {
                if($mevcutsifre != $sifre1  ) {
                    $sifre = md5($sifre1);

                    $guncelle = $db->prepare("UPDATE uyeler SET
                        uyesifre=:uyesifre
                 WHERE id={$userCek['id']}      
                ");
                    $sonuc = $guncelle->execute(array(
                        'uyesifre' => $sifre
                    ));
                    if($sonuc){
                        $_SESSION['sifredegis_durum'] = 'success';
                        header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    $_SESSION['sifredegis_durum'] = 'sifreayni';
                    header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
                }
            }else{
                $_SESSION['sifredegis_durum'] = 'sifrefarkli';
                header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
            }
        }else{
            $_SESSION['sifredegis_durum'] = 'empty';
            header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
        }
    }else{
        $_SESSION['sifredegis_durum'] = 'eskisifrefarkli';
        header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
    }
    }else{
        $_SESSION['demo_alert'] = 'demo';
        header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
    }






} else {
    header('Location:'.$ayar['site_url'].'404');
}
?>