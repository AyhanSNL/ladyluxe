<?php
if($_POST){
        $eposta = trim(strip_tags($_POST['emailadress']));
    if($demo != '1'  ){
        if($eposta  ) {

            if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){
                    $randomid = rand(0,(int) 99999999);
                $epostaSorgusu = $db->prepare("select * from uyeler where eposta=:eposta ");
                $epostaSorgusu->execute(array(
                    'eposta' => $eposta
                ));
                if($epostaSorgusu->rowCount()>'0'  ) {
                    /* üyeyi çek */
                    $uyeSorgu = $db->prepare("select * from uyeler where eposta=:eposta ");
                    $uyeSorgu->execute(array(
                        'eposta' => $eposta
                    ));
                    if($uyeSorgu->rowCount()>'0'  ) {
                        $uyeRow = $uyeSorgu->fetch(PDO::FETCH_ASSOC);
                        $isim = $uyeRow['isim'];
                        $soyisim = $uyeRow['soyisim'];
                    }
                    /*  <========SON=========>>> üyeyi çek SON */
                    $rand = md5($randomid);
                    $kaydet = $db->prepare("INSERT INTO uyeler_reset_sifre SET
                        eposta=:eposta,    
                        kod=:kod,
                        uye_id=:uye_id,
                        durum=:durum
                    ");
                    $sonuc = $kaydet->execute(array(
                        'eposta' => $eposta,
                        'kod' => $rand,
                        'uye_id' => $uyeRow['id'],
                        'durum' => '0'
                    ));
                    if($sonuc){
                        /* E-Posta Bildirimleri */
                        if($ayar['smtp_durum'] == '1' ) {
                           include 'includes/post/mailtemp/users/resetpassword_mail_temp.php';
                        }
                        /* E-Posta Bildirimleri SON */
                        $_SESSION['epostasifirla_durum'] = 'success';
                        header('Location:'.$ayar['site_url'].'sifremi-unuttum/');
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                }else{
                    $_SESSION['epostasifirla_durum'] = 'nouser';
                    header('Location:'.$ayar['site_url'].'sifremi-unuttum/');
                }
            }else{
                $_SESSION['epostasifirla_durum'] = 'emailerror';
                header('Location:'.$ayar['site_url'].'sifremi-unuttum/');
            }
        }else{
            $_SESSION['epostasifirla_durum'] = 'empty';
            header('Location:'.$ayar['site_url'].'sifremi-unuttum/');
        }
    }else{
        $_SESSION['demo_alert'] = 'demo';
        header('Location:'.$ayar['site_url'].'sifremi-unuttum/');
    }
} else {
    header('Location:'.$ayar['site_url'].'404');
}
?>