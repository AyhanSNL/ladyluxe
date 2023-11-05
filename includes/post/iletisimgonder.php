<?php
date_default_timezone_set( 'Europe/Istanbul' );
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$siteurl = $ayar['site_url'];
$site_adi = $ayar['site_baslik'];
$smssettings=$db->prepare("SELECT * from sms where id='1'");
$smssettings->execute(array(0));
$smsayar=$smssettings->fetch(PDO::FETCH_ASSOC);
?>
<?php
if($demo != '1'  ) {
    if (isset($_POST['iletisimpost']) && $_POST) {



        $isim = trim(strip_tags($_POST['isim']));
        $tel = trim(strip_tags($_POST['telno']));
        $eposta = trim(strip_tags($_POST['eposta']));
        $konu = trim(strip_tags($_POST['konu']));
        $mesaj = trim(strip_tags($_POST['mesaj']));
        $timestamp = date('Y-m-d G:i:s');

        if( $isim && $tel && $konu && $eposta && $mesaj ) {

            if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){
                if($ayar['site_captcha'] == '1') {
                    if($_POST['secure_code']==$_SESSION['secure_code']){

                        if($ayar['smtp_durum'] == '1'){
                            include 'includes/post/mailtemp/iletisim_mail_temp.php';
                        }

                        $kaydet=$db->prepare("INSERT INTO mesaj SET
                    isim=:isim,
                    eposta=:eposta,
                    telno=:telno,
                    konu=:konu,
                    mesaj=:mesaj,
                    durum=:durum,
                    tarih=:tarih
                    ");
                        $ekle=$kaydet->execute(array(
                            'isim'   => trim(strip_tags($_POST['isim'])),
                            'eposta'  => trim(strip_tags($_POST['eposta'])),
                            'telno'   => trim(strip_tags($_POST['telno'])),
                            'konu'  => trim(strip_tags($_POST['konu'])),
                            'mesaj' => $mesaj,
                            'durum' => '1',
                            'tarih' => $timestamp
                        ));
                        if ($ekle) {
                            $_SESSION['mesaj_sonuc'] = 'success';
                            header('Location:'.$siteurl.'iletisim/');
                        } else {
                            $_SESSION['mesaj_sonuc'] = 'wrong';
                            header('Location:'.$siteurl.'iletisim/');
                        }
                    } else {
                        $_SESSION['mesaj_sonuc'] = 'secure';
                        header('Location:'.$siteurl.'iletisim/');
                        unset($_SESSION['secure_code']);
                    }
                }

                if($ayar['site_captcha'] == '0' || $ayar['site_captcha'] == null ) {

                    if($ayar['smtp_durum'] == '1'){
                        include 'includes/post/mailtemp/iletisim_mail_temp.php';
                    }

                    $kaydet=$db->prepare("INSERT INTO mesaj SET
        isim=:isim,
        eposta=:eposta,
        telno=:telno,
        konu=:konu,
        mesaj=:mesaj,
        durum=:durum,
        tarih=:tarih
        ");
                    $ekle=$kaydet->execute(array(
                        'isim'   => trim(strip_tags($_POST['isim'])),
                        'eposta'  => trim(strip_tags($_POST['eposta'])),
                        'telno'   => trim(strip_tags($_POST['telno'])),
                        'konu'  => trim(strip_tags($_POST['konu'])),
                        'mesaj' => $mesaj,
                        'durum' => '1',
                        'tarih' => $timestamp
                    ));
                    if ($ekle) {
                        $_SESSION['mesaj_sonuc'] = 'success';
                        header('Location:'.$siteurl.'iletisim/');
                    } else {
                        $_SESSION['mesaj_sonuc'] = 'wrong';
                        header('Location:'.$siteurl.'iletisim/');
                    }
                }
            }else{
                $_SESSION['mesaj_sonuc'] = 'epostasorun';
                header("location: ".$siteurl."iletisim/");
                unset($_SESSION['secure_code']);
            }

        }else {
            $_SESSION['mesaj_sonuc'] = 'bos';
            header("location: ".$siteurl."iletisim/");
            unset($_SESSION['secure_code']);
        }
    }else{
        header('Location:'.$siteurl.'404');
    }
}else{
    $_SESSION['demo_alert'] = 'demo';
    header('Location:'.$siteurl.'iletisim/');
}
?>