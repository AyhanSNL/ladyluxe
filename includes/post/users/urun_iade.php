<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($_POST) {

    $id = trim(strip_tags($_POST['productNo']));
    $hash = trim(strip_tags($_POST['product']));

    $urunCek = $db->prepare("select * from siparis_urunler where id=:id ");
    $urunCek->execute(array(
        'id' => $id,
    ));
    if($urunCek->rowCount()>'0'  ) {
        $urun = $urunCek->fetch(PDO::FETCH_ASSOC);
        if($demo != '1'  ){
        if(md5($urun['id']) == $hash  ) {
            if(trim(strip_tags($_POST['sebep'])) == !null  ) {
                if($odemeayar['siparis_urun_iade'] == '1' && $urun['iade_aksiyon'] == '1' ) {
                    if($urun['durum'] != '5' && $urun['durum'] != '6'  ) {
                        $timestamp = date('Y-m-d G:i:s');
                        $random = rand(0,(int) 99999999);
                        $rand = rand(0,(int) 9999999999);
                        $kaydet = $db->prepare("INSERT INTO siparis_urunler_iade SET
                        urun_id=:urun_id,    
                        siparis_no=:siparis_no,
                        tarih=:tarih,
                        durum=:durum,
                        talep_no=:talep_no,
                        sebep=:sebep,
                        yeni=:yeni,
                        uye_id=:uye_id
                    ");
                        $sonuc = $kaydet->execute(array(
                            'urun_id' => $id,
                            'siparis_no' => $urun['siparis_id'],
                            'tarih' => $timestamp,
                            'durum' => '0',
                            'talep_no' => $random,
                            'sebep' => trim(strip_tags($_POST['sebep'])),
                            'yeni' => '1',
                            'uye_id' => $userCek['id']
                        ));
                        if($sonuc){
                            $guncelle = $db->prepare("UPDATE siparis_urunler SET
                                iade_aksiyon=:iade_aksiyon
                         WHERE id={$id}      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'iade_aksiyon' => '0'
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
                                    'modul' => 'uruniade',
                                    'icerik_id' => $rand,
                                ));
                                /*  <========SON=========>>> Panel bildirim SON */


                                /* Site içi bildirim */
                                if($bildirimayar['durum'] == '1' ) {
                                    $user = $userCek['id'];
                                    $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                    $kullaniciCek->execute(array(
                                        'id' => $user
                                    ));
                                    if($kullaniciCek->rowCount()>'0'  ) {
                                        $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                        $rand = rand(0,(int) 9999999999);
                                        $baslik = $diller['bildirimler-text18'];
                                        $icerik = ''.$diller['oto-eposta-content-text1'].' '.$userCek['isim'].' '.$userCek['soyisim'].', <br><br> #'.$urun['siparis_id'].' '.$diller['bildirimler-text19'].' ';
                                        /* Site içi bildirim gönder */
                                        $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                                    bildirim_id=:bildirim_id,
                                                                    baslik=:baslik,
                                                                    icerik=:icerik,
                                                                    tarih=:tarih,
                                                                    tur=:tur,
                                                                    ikon=:ikon,
                                                                    uye_id=:uye_id,
                                                                    durum=:durum,
                                                                    dil=:dil
                                                                    ");
                                                                    $sonuc = $kaydet->execute(array(
                                                                        'bildirim_id' => $rand,
                                                                        'baslik' => $baslik,
                                                                        'icerik' => $icerik,
                                                                        'tarih' => $timestamp,
                                                                        'tur' => '2',
                                                                        'ikon' => '&#128472;',
                                                                        'uye_id' => $user,
                                                                        'durum' => '1',
                                                                        'dil' => $_SESSION['dil']
                                                                    ));
                                        /*  <========SON=========>>> Site içi bildirim gönder SON */

                                    }
                                }
                                /*  <========SON=========>>> Site içi bildirim SON */



                                $_SESSION['iade_status'] = 'success';
                                header('Location:'.$ayar['site_url'].'hesabim/iade-talebi/'.$random.'/');
                                /* E-Posta Bildirimleri */
                                if($ayar['smtp_durum'] == '1' ) {
                                    include 'includes/post/mailtemp/users/urun_iade_mail_temp.php';
                                }
                                /* E-Posta Bildirimleri SON */

                                /* SMS */
                                if($sms['durum'] == '1' ) {
                                    if($sms['sms_uruniade_site'] == '1' || $sms['sms_uruniade_user'] == '1') {
                                        include 'includes/post/smstemp/users/product_return_sms.php';
                                        include 'includes/post/smstemp/sms_api.php';
                                    }
                                }
                                /*  <========SON=========>>> SMS SON */
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }else{
                $_SESSION['iade_status'] = 'empty';
                header('Location:'.$ayar['site_url'].'hesabim/siparis-detay/'.$urun['siparis_id'].'/');
            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
        }else{
            $_SESSION['demo_alert'] = 'demo';
            header('Location:'.$ayar['site_url'].'hesabim/siparis-detay/'.$urun['siparis_id'].'/');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else {
    header('Location:'.$ayar['site_url'].'404');
}
?>