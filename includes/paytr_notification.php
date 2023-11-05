<?php
$paytr_key = $odemeayar["paytr_key"];
$paytr_salt = $odemeayar["paytr_salt"];

$post = $_POST;

$merchant_key 	= $paytr_key;
$merchant_salt	= $paytr_salt;
$hash = base64_encode( hash_hmac('sha256', $post['merchant_oid'].$merchant_salt.$post['status'].$post['total_amount'], $merchant_key, true) );
if( $hash != $post['hash'] )
    die('PAYTR notification failed: bad hash');
if( $post['status'] == 'success' ) { ## Ödeme Onaylandı
    $sorgula = $db->prepare("select * from siparisler where siparis_no=:siparis_no and onay=:onay ");
    $sorgula->execute(array(
        'siparis_no' => $post['merchant_oid'],
        'onay' => '0'
    ));
    if($sorgula->rowCount()>'0'  ) {
        $timestamp = date('Y-m-d G:i:s');
        $guncelle = $db->prepare("UPDATE siparisler SET
                onay=:onay
         WHERE siparis_no={$post['merchant_oid']}      
        ");
        $sonuc = $guncelle->execute(array(
            'onay' => '1'
        ));

        $siparisiCek = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
        $siparisiCek->execute(array(
            'siparis_no' => $post['merchant_oid']
        ));
        $sip = $siparisiCek->fetch(PDO::FETCH_ASSOC);

        /* Kupon indirimi var ise kullanımı güncelle */
        $guncelle_kupon = $db->prepare("UPDATE sepet_kupon SET
            kullanim=:kullanim,
            siparis_id=:siparis_id
            WHERE durum='1' and uye_id={$sip['uye_id']} and kullanim='0'  
            ");
        $sonuc = $guncelle_kupon->execute(array(
            'kullanim' => '1',
            'siparis_id' => $sip['siparis_no']
        ));
        /* Sipariş ürün satış sayıları */
        $siparisUrunListesi = $db->prepare("select adet,urun_id,varyant_stok_durum,varyantlar from siparis_urunler where siparis_id=:siparis_id ");
        $siparisUrunListesi->execute(array(
            'siparis_id' => $sip['siparis_no'],
        ));
        foreach ($siparisUrunListesi as $sis){
            $urun = $db->prepare("select satis_adet from urun where id=:id ");
            $urun->execute(array(
                'id' => $sis['urun_id'],
            ));
            $u = $urun->fetch(PDO::FETCH_ASSOC);
            $satisCount = $u['satis_adet'];

            $guncelle = $db->prepare("UPDATE urun SET
                                        satis_adet=:satis_adet
                                 WHERE id={$sis['urun_id']}      
                                ");
            $sonuc = $guncelle->execute(array(
                'satis_adet' => $satisCount+$sis['adet'],
            ));
            /* varyant ve ana ürün stok işlemleri */
            if($sis['varyant_stok_durum'] == '0'  ) {
                $mainProductStock_Query = $db->prepare("select * from urun where id=:id ");
                $mainProductStock_Query->execute(array(
                    'id' => $sis['urun_id']
                ));
                $stokMainRow = $mainProductStock_Query->fetch(PDO::FETCH_ASSOC);
                if($odemeayar['urun_stok_dus'] == '1' ) {
                    $guncelle = $db->prepare("UPDATE urun SET
                         stok=:stok
                  WHERE id={$sis['urun_id']}      
                 ");
                    $sonuc = $guncelle->execute(array(
                        'stok' => $stokMainRow['stok']-$sis['adet']
                    ));
                }
            }
            if($sis['varyant_stok_durum'] == '1'  ) {
                /* varyant Stok İşlemleri */
                $detailVariant_Stok_Query = $db->prepare("select * from detay_varyant_stok where varyant=:varyant and urun_id=:urun_id ");
                $detailVariant_Stok_Query->execute(array(
                    'varyant' => $sis['varyantlar'],
                    'urun_id' => $sis['urun_id']
                ));
                $stokRow = $detailVariant_Stok_Query->fetch(PDO::FETCH_ASSOC);
                if($detailVariant_Stok_Query->rowCount()>'0' ) {
                    if($odemeayar['urun_stok_dus'] == '1' ) {
                        /* Stoktan Düşme için mevcut stok - adet yap */
                        $guncelle = $db->prepare("UPDATE detay_varyant_stok SET
                         stok=:stok
                          WHERE id={$stokRow['id']}      
                         ");
                        $sonuc = $guncelle->execute(array(
                            'stok' => $stokRow['stok']-$sis['adet']
                        ));
                        /* Stoktan Düşme için mevcut stok - adet yap SON */
                    }
                }
                /* varyant Stok İşlemleri SON */
            }
            /* varyant ve ana ürün stok işlemleri SON */
        }
        /*  <========SON=========>>>  Sipariş ürün satış sayıları SON */

        /* Site içi bildirim */
        if($bildirimayar['durum'] == '1' ) {
            $user = $sip['uye_id'];
            $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
            $kullaniciCek->execute(array(
                'id' => $user
            ));
            if($kullaniciCek->rowCount()>'0'  ) {
                $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                $rand = rand(0,(int) 9999999999);
                $baslik = $diller['bildirimler-text15'];
                $icerik = ''.$diller['oto-eposta-content-text1'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$sip['siparis_no'].' '.$diller['bildirimler-text17'].' ';
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
                    'ikon' => '&#128722',
                    'uye_id' => $user,
                    'durum' => '1',
                    'dil' => $_SESSION['dil']
                ));
                /*  <========SON=========>>> Site içi bildirim gönder SON */

            }
        }
        /*  <========SON=========>>> Site içi bildirim SON */

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
            'modul' => 'siparis',
            'icerik_id' => $sip['siparis_no'],
        ));
        /*  <========SON=========>>> Panel bildirim SON */


        /* E-Posta Bildirimleri */
        if($ayar['smtp_durum'] == '1' ) {
            include "includes/post/mailtemp/siparisler/kredi_kart_mail_temp.php";
        }
        /* E-Posta Bildirimleri SON */

        /* SMS */
        if($sms['durum'] == '1' ) {
            if($sms['sms_siparis_site'] == '1' || $sms['sms_siparis_user'] == '1') {
                $yenitelefon = $sip['telefon'];
                $isim = $sip['isim'];
                $soyisim = $sip['soyisim'];
                $siparis_id = $sip['siparis_no'];
                include 'includes/post/smstemp/siparis/siparis_sms.php';
                include 'includes/post/smstemp/sms_api.php';
            }
        }
        /*  <========SON=========>>> SMS SON */



        /* İlk siparişe özel indirim kontrolü */
        $ilkSiparisSorgu = $db->prepare("select * from indirim_ilk_siparis_kayit where siparis_id=:siparis_id and onay=:onay ");
        $ilkSiparisSorgu->execute(array(
            'siparis_id' => $sip['siparis_no'],
            'onay' => '0'
        ));
        if($ilkSiparisSorgu->rowCount()>'0'  ) {
            $guncelle = $db->prepare("UPDATE indirim_ilk_siparis_kayit SET
              onay=:onay   
          WHERE siparis_id={$sip['siparis_no']}      
         ");
            $sonuc = $guncelle->execute(array(
                'onay' => '1'
            ));
        }
        /*  <========SON=========>>> İlk siparişe özel indirim kontrolü SON */

        /* Üye satın aldı ise onu tekrar session'a ekle */
        if($sip['uye_id'] >'0' ) {
            $uyeSorgusuYap = $db->prepare("select * from uyeler where id=:id and onay=:onay ");
            $uyeSorgusuYap->execute(array(
                'id' => $sip['uye_id'],
                'onay' => '1'
            ));
            if($uyeSorgusuYap->rowCount()>'0'  ) {
                $uyeRows = $uyeSorgusuYap->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_email_address'] = $uyeRows['eposta'];
            }
        }
        /*  <========SON=========>>> Üye satın aldı ise onu tekrar session'a ekle SON */

        /* Sepet ürünü sil */
        $silmeislem = $db->prepare("DELETE from sepet WHERE ip=:ip");
        $silmeislem->execute(array(
            'ip' => $sip['ipadres']
        ));
        /*  <========SON=========>>> Sepet ürünü sil SON */
    }

} else {

}
echo "OK";
exit;
?>