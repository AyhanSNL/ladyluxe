<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
if(isset($_POST['userlogin'])){

    $returnID = trim(strip_tags($_POST['return_id']));
    $returnSEO = trim(strip_tags($_POST['return_product']));
    $ip = $_SERVER["REMOTE_ADDR"];

    $urun = $db->prepare("select id,seo_url from urun where durum=:durum and dil=:dil and seo_url=:seo_url and id=:id");
    $urun->execute(array(
        'durum' => '1',
        'dil' => $_SESSION['dil'],
        'seo_url' => $returnSEO,
        'id' => $returnID
    ));
    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
    if($urun->rowCount()>'0') {

        $epostaname = trim(strip_tags($_POST['emailadress']));
        $sifrebak = $_POST['password'];
        $pass_sifre = md5($_POST['password']);
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
                    $_SESSION['user_email_address'] = $epostaname;
                    if($uyeRow['onay'] == '0' ) {
                        $_SESSION['user_email_address_onaysiz'] = $epostaname;
                        $_SESSION['uyelik_durum'] = 'success_onay';
                    }else{
                        $_SESSION['login_success'] = 'success';
                    }
                    header('Location:'.$ayar['site_url'].''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                    /* son giriş log kaydı */
                    $guncelle = $db->prepare("UPDATE uyeler SET
                            son_giris=:son_giris
                     WHERE id={$uyeRow['id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'son_giris' => $timestamp
                    ));
                    /*  <========SON=========>>> son giriş log kaydı SON */
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
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
    } else {
    header('Location:'.$ayar['site_url'].'404');
}
?>