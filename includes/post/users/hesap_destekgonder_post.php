<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
if($_POST && $userSorgusu->rowCount()>'0'){
    if($demo != '1'  ){
    if($uyeayar['destek_siparis_mecbur'] == '0' ) {
        $baslik = trim(strip_tags($_POST['baslik']));
        $mesaj = trim(strip_tags($_POST['mesaj']));

        if($baslik && $mesaj  ) {

            $eposta = $userCek['eposta'];
            $isim = $userCek['isim'];
            $soyisim = $userCek['soyisim'];


            $timestamp = date('Y-m-d G:i:s');
            $rand = rand(0,(int) 9999999999);
            $uye = $userCek['id'];

            $kaydet = $db->prepare("INSERT INTO destek_talebi SET
                uye_id=:uye_id,
                ilk_islem=:ilk_islem,
                son_islem=:son_islem,
                durum=:durum,
                yeni=:yeni,
                baslik=:baslik,
                destek_no=:destek_no
        ");
            $sonuc = $kaydet->execute(array(
                'uye_id' => $uye,
                'ilk_islem' => $timestamp,
                'son_islem' => $timestamp,
                'durum' => '0',
                'yeni' => '1',
                'baslik' => $baslik,
                'destek_no' => $rand
            ));
            if($sonuc){
                $kaydet = $db->prepare("INSERT INTO destek_talep_mesaj SET
             destek_no=:destek_no,       
             gonderen=:gonderen,
             tarih=:tarih,
             mesaj=:mesaj
            ");
                $sonuc = $kaydet->execute(array(
                    'destek_no' => $rand,
                    'gonderen' => '1',
                    'tarih' => $timestamp,
                    'mesaj' => $mesaj
                ));
                if($sonuc){
                    
                    /* Panel bildirim */
                    $kaydet = $db->prepare("INSERT INTO panel_bildirim SET
                    durum=:durum,
                    tarih=:tarih,
                    modul=:modul,
                    icerik_id=:icerik_id
                    ");
                    $sonuc = $kaydet->execute(array(
                        'durum' => '1',
                        'tarih' => $timestamp,
                        'modul' => 'destek',
                        'icerik_id' => $rand,
                    ));
                    /*  <========SON=========>>> Panel bildirim SON */
                    
                    /* E-Posta Bildirimleri */
                    if($ayar['smtp_durum'] == '1' ) {
                        include 'includes/post/mailtemp/users/ticket_mail_temp.php';
                    }
                    /* E-Posta Bildirimleri SON */

                    /* SMS */
                    include 'inc/modules/orders/order_noti_sms.php';
                    /*  <========SON=========>>> SMS SON */

                    $_SESSION['destek_alert'] = 'success';
                    header('Location:'.$ayar['site_url'].'hesabim/destek/');
                }else{
                    echo 'Veritabanı Hatası';
                }
            }else{
                echo 'Veritabanı Hatası';
            }
        }else{
            $_SESSION['destek_alert'] = 'empty';
            header('Location:'.$ayar['site_url'].'hesabim/yeni-destek-talebi/');
        }
    }

    if($uyeayar['destek_siparis_mecbur'] == '1' ) {
        $baslik = trim(strip_tags($_POST['baslik']));
        $mesaj = trim(strip_tags($_POST['mesaj']));
        $siparis_no = trim(strip_tags($_POST['siparis_no']));

        if($baslik && $mesaj && $siparis_no ) {

            $eposta = $userCek['eposta'];
            $isim = $userCek['isim'];
            $soyisim = $userCek['soyisim'];


            $timestamp = date('Y-m-d G:i:s');
            $rand = rand(0,(int) 9999999999);
            $uye = $userCek['id'];

            $kaydet = $db->prepare("INSERT INTO destek_talebi SET
                uye_id=:uye_id,
                ilk_islem=:ilk_islem,
                son_islem=:son_islem,
                durum=:durum,
                yeni=:yeni,
                baslik=:baslik,
                siparis_no=:siparis_no,
                destek_no=:destek_no
        ");
            $sonuc = $kaydet->execute(array(
                'uye_id' => $uye,
                'ilk_islem' => $timestamp,
                'son_islem' => $timestamp,
                'durum' => '0',
                'yeni' => '1',
                'baslik' => $baslik,
                'siparis_no' => $siparis_no,
                'destek_no' => $rand
            ));
            if($sonuc){
                $kaydet = $db->prepare("INSERT INTO destek_talep_mesaj SET
                     destek_no=:destek_no,       
                     gonderen=:gonderen,
                     tarih=:tarih,
                     mesaj=:mesaj
                    ");
                $sonuc = $kaydet->execute(array(
                    'destek_no' => $rand,
                    'gonderen' => '1',
                    'tarih' => $timestamp,
                    'mesaj' => $mesaj
                ));
                if($sonuc){
                    /* Panel bildirim */
                    $kaydet = $db->prepare("INSERT INTO panel_bildirim SET
                    durum=:durum,
                    tarih=:tarih,
                    modul=:modul,
                    icerik_id=:icerik_id
                    ");
                    $sonuc = $kaydet->execute(array(
                        'durum' => '1',
                        'tarih' => $timestamp,
                        'modul' => 'destek',
                        'icerik_id' => $rand,
                    ));
                    /*  <========SON=========>>> Panel bildirim SON */

                    /* E-Posta Bildirimleri */
                    if($ayar['smtp_durum'] == '1' ) {
                        include 'includes/post/mailtemp/users/ticket_mail_temp.php';
                    }
                    /* E-Posta Bildirimleri SON */

                    /* SMS */
                    if($sms['durum'] == '1' ) {
                        if($sms['sms_ticket_site'] == '1' || $sms['sms_ticket_user'] == '1') {
                            include 'includes/post/smstemp/users/ticket_sms.php';
                            include 'includes/post/smstemp/sms_api.php';
                        }
                    }
                    /*  <========SON=========>>> SMS SON */

                    $_SESSION['destek_alert'] = 'success';
                    header('Location:'.$ayar['site_url'].'hesabim/destek/');
                }else{
                    echo 'Veritabanı Hatası';
                }
            }else{
                echo 'Veritabanı Hatası';
            }
        }else{
            $_SESSION['destek_alert'] = 'empty';
            header('Location:'.$ayar['site_url'].'hesabim/yeni-destek-talebi/');
        }
    }

    }else{
        $_SESSION['demo_alert'] = 'demo';
        header('Location:'.$ayar['site_url'].'hesabim/destek/');
    }

} else {
    header('Location:'.$ayar['site_url'].'404');
}
?>