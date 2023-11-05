<?php
if(isset($_POST['userlogin'])){

        $epostaname = trim(strip_tags($_POST['emailadress']));
        $sifrebak = $_POST['password'];
        $pass_sifre = md5($_POST['password']);
    $ip = $_SERVER["REMOTE_ADDR"];
        if (filter_var($epostaname, FILTER_VALIDATE_EMAIL)){
            if ($epostaname && $sifrebak) {
                $kullanicisor = $db->prepare("SELECT * from uyeler where eposta=:eposta and uyesifre=:uyesifre");
                $kullanicisor->execute(
                    array(
                        'eposta' => $epostaname,
                        'uyesifre' => $pass_sifre
                    )
                );
                $say = $kullanicisor->rowCount();
                $uyeRow = $kullanicisor->fetch(PDO::FETCH_ASSOC);
                if ($say > '0') {
                    $timestamp = date('Y-m-d G:i:s');
                    if($uyeRow['onay'] == '0' ) {
                        $_SESSION['user_email_address_onaysiz'] = $epostaname;
                        $_SESSION['uyelik_durum'] = 'success_onay2';
                    }else{
                        $_SESSION['user_email_address'] = $epostaname;
                    }
                    header('Location:'.$ayar['site_url'].'');
                    array_map('unlink', glob('i/cache/d/*.html'));
                    array_map('unlink', glob('i/cache/s/*.html'));
                    /* son giriş log kaydı */
                    $guncelle = $db->prepare("UPDATE uyeler SET
                            son_giris=:son_giris
                     WHERE id={$uyeRow['id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'son_giris' => $timestamp
                    ));

                   /* Üyelerin LOG KAydı */
                    if($ayar['uye_log'] == '1' ) {
                        $kaydet = $db->prepare("INSERT INTO uyeler_log SET
                       uye_id=:uye_id,     
                       ip=:ip,
                       islem=:islem,
                       tarih=:tarih
                    ");
                        $sonuc = $kaydet->execute(array(
                            'uye_id' => $uyeRow['id'],
                            'ip' => $ip,
                            'islem' => '1',
                            'tarih' => $timestamp,
                        ));
                    }
                   /*  <========SON=========>>> Üyelerin LOG KAydı SON */

                }else {
                    $_SESSION['login_error'] = 'nouser'; // böyle bir kullanıcı yok.
                    header('Location:uye-girisi/');
                }
            } else {
                $_SESSION['login_error'] = 'empty';
                header('Location:uye-girisi/');
            }
        }else {
            $_SESSION['login_error'] = 'emailerror';
            header('Location:uye-girisi/');
        }
    } else {
    header('Location:'.$ayar['site_url'].'404');
}
?>