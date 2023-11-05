<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($siparisnotu == !null  ) {
    $notuekle = $siparisnotu;
}else{
    $notuekle = null;
}
/* Döviz Durumu */
if($odemeayar['havale_doviz_durum'] == '1' ) {

    $toplamodenecek = kurhesapla($varsayilankur['deger'],$secilikur['deger'],((($havale_odenecek_tutar-$havale_indirimtutar)-$sepette_ek_indirim_havale)-$ilk_sip_indirim_havale)-$grubindirimi_havale);
    $siparis_aratoplam = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havale_aratoplam);
    $siparis_kargotoplam = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalekargo_toplami);
    $siparis_kdvtoplam = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havale_kdvtoplam);
    $siparis_indirimtutar = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havale_indirimtutar);
    $siparis_ek_indirimtutar = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$sepette_ek_indirim_havale);
    $siparis_ilk_indirimi = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$ilk_sip_indirim_havale);
    $siparis_grup_indirimi = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$grubindirimi_havale);

    $parabirimi = $secilikur['kod'];
    if($secilikur['kod'] == $varsayilankur['kod'] ) {
        $dovizdurum = '0';
        $odemekur = '1';
    }else{
        $dovizdurum = '1';
        $odemekur = $secilikur['deger'];
    }
}else{
    $toplamodenecek = ((($havale_odenecek_tutar-$havale_indirimtutar)-$sepette_ek_indirim_havale)-$ilk_sip_indirim_havale)-$grubindirimi_havale;
    $siparis_aratoplam = $havale_aratoplam;
    $siparis_kargotoplam = $havalekargo_toplami;
    $siparis_kdvtoplam = $havale_kdvtoplam;
    $siparis_indirimtutar = $havale_indirimtutar;
    $siparis_ek_indirimtutar = $sepette_ek_indirim_havale;
    $siparis_ilk_indirimi = $ilk_sip_indirim_havale;
    $siparis_grup_indirimi = $grubindirimi_havale;

    $parabirimi = $varsayilankur['kod'];
    $dovizdurum = '0';
    $odemekur = '1';
}
/* Döviz Durumu SON */

/* Banka bildirim durum */
if($odemeayar['havale_odeme_bildirim'] == '1' ) {
 $bankabildirim = '0';
}else{
 $bankabildirim = '1';
}
/*  <========SON=========>>> Banka bildirim durum SON */
$timestamp = date('Y-m-d G:i:s');
$sadetarih = date('Y-m-d');
if (isMobileDevice()) {
    $device = 'mobile';
} else {
    $device = 'desktop';
}
$kaydet = $db->prepare("INSERT INTO siparisler SET
        siparis_no=:siparis_no,
        grup_indirim=:grup_indirim,
        sepette_ek_indirim=:sepette_ek_indirim,
        ilk_siparis_indirim=:ilk_siparis_indirim,
        iptal_aksiyon=:iptal_aksiyon,
        iptal=:iptal,
        uye_id=:uye_id,
        havale_aratutar=:havale_aratutar,
        havale_kdvtutar=:havale_kdvtutar,
        havale_kargotutar=:havale_kargotutar,
        indirim_tutar=:indirim_tutar,
        havale_toplamtutar=:havale_toplamtutar,
        banka_bildirim_durum=:banka_bildirim_durum,
        odeme_tur=:odeme_tur,
        siparis_notu=:siparis_notu,
        siparis_tarih=:siparis_tarih,
        sade_tarih=:sade_tarih,
        parabirimi=:parabirimi,
        ipadres=:ipadres,
        isim=:isim,
        soyisim=:soyisim,
        tc_no=:tc_no,
        telefon=:telefon,
        telefon_gosterim=:telefon_gosterim,
        eposta=:eposta,
        ulke=:ulke,
        sehir=:sehir,
        ilce=:ilce,
        postakodu=:postakodu,
        adresbilgisi=:adresbilgisi,
        adres_fatura_farkli=:adres_fatura_farkli,
        fatura_turu=:fatura_turu,
        fatura_isim=:fatura_isim,
        fatura_soyisim=:fatura_soyisim,
        fatura_tc=:fatura_tc,
        fatura_firma_unvan=:fatura_firma_unvan,
        fatura_vergi_dairesi=:fatura_vergi_dairesi,
        fatura_vergi_no=:fatura_vergi_no,
        fatura_ulke=:fatura_ulke,
        fatura_sehir=:fatura_sehir,
        fatura_ilce=:fatura_ilce,
        fatura_postakodu=:fatura_postakodu,
        fatura_adresi=:fatura_adresi,
        siparis_durum=:siparis_durum,
        onay=:onay,
        havale_kargo_limit_durum=:havale_kargo_limit_durum,
        sabit_kargo=:sabit_kargo,
        odeme_kuru=:odeme_kuru,
        doviz_durum=:doviz_durum,
        alan_kodu=:alan_kodu,
        device=:device,
        yeni=:yeni
");
$sonuc = $kaydet->execute(array(
    'siparis_no' => $siparis_id,
    'grup_indirim' => $siparis_grup_indirimi,
    'sepette_ek_indirim' => $siparis_ek_indirimtutar,
    'ilk_siparis_indirim' => $siparis_ilk_indirimi,
    'iptal_aksiyon' => '1',
    'iptal' => '0',
    'uye_id' => $sepetuyesi,
    'havale_aratutar' => $siparis_aratoplam,
    'havale_kdvtutar' => $siparis_kdvtoplam,
    'havale_kargotutar' => $siparis_kargotoplam,
    'indirim_tutar' => $siparis_indirimtutar,
    'havale_toplamtutar' => $toplamodenecek,
    'banka_bildirim_durum' => $bankabildirim,
    'odeme_tur' => '2',
    'siparis_notu' => $notuekle,
    'siparis_tarih' => $timestamp,
    'sade_tarih' => $sadetarih,
    'parabirimi' => $parabirimi,
    'ipadres' => $ipnedir,
    'isim' => $isim,
    'soyisim' => $soyisim,
    'tc_no' => $tc,
    'telefon' => $yenitelefon,
    'telefon_gosterim' => $telefon,
    'eposta' => $eposta,
    'ulke' => $ulke,
    'sehir' => $sehir,
    'ilce' => $ilce,
    'postakodu' => $postakodu,
    'adresbilgisi' => $adres,
    'adres_fatura_farkli' => $faturaadresdurum,
    'fatura_turu' => $faturaturu,
    'fatura_isim' => $fatura_isim,
    'fatura_soyisim' => $fatura_soyisim,
    'fatura_tc' => $fatura_tc,
    'fatura_firma_unvan' => $fatura_firma_unvan,
    'fatura_vergi_dairesi' => $fatura_vergi_dairesi,
    'fatura_vergi_no' => $fatura_vergi_no,
    'fatura_ulke' => $fatura_ulke,
    'fatura_sehir' => $fatura_il,
    'fatura_ilce' => $fatura_ilce,
    'fatura_postakodu' => $fatura_postakodu,
    'fatura_adresi' => $fatura_adresbilgisi,
    'siparis_durum' => $odemeayar['havale_eft_siparis_durum'],
    'onay' => '1',
    'havale_kargo_limit_durum' => $havale_kargo_limit_durumu,
    'sabit_kargo' => $odemeayar['kargo_sabit'],
    'odeme_kuru' => $odemekur,
    'doviz_durum' => $dovizdurum,
    'alan_kodu' => $alankodu,
    'device' => $device,
    'yeni' => '1'
));
include 'includes/post/siparisdb/havale_eft_urun_aktar.php';

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
                $baslik = $diller['bildirimler-text15'];
                $icerik = ''.$diller['oto-eposta-content-text1'].' '.$userCek['isim'].' '.$userCek['soyisim'].', <br><br> #'.$siparis_id.' '.$diller['bildirimler-text16'].' ';
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
    'icerik_id' => $siparis_id
));
/*  <========SON=========>>> Panel bildirim SON */

/* E-Posta Bildirimleri */
if($ayar['smtp_durum'] == '1' ) {
    include 'includes/post/mailtemp/siparisler/havale_eft_mail_temp.php';
}
/* E-Posta Bildirimleri SON */

/* SMS */
if($sms['durum'] == '1' ) {
    if($sms['sms_siparis_site'] == '1' || $sms['sms_siparis_user'] == '1') {
        $odemeTur = '2';
        include 'includes/post/smstemp/siparis/siparis_sms.php';
        include 'includes/post/smstemp/sms_api.php';
    }
}
/*  <========SON=========>>> SMS SON */


/* Sepet Kupon Kullanıldı Durumu Güncellemesi */
if($siparis_indirimtutar> '0'  ) {
    $guncelle_kupon = $db->prepare("UPDATE sepet_kupon SET
            kullanim=:kullanim,
            siparis_id=:siparis_id
            WHERE durum='1' and uye_id={$sepetuyesi} and kullanim='0'  
    ");
    $sonuc = $guncelle_kupon->execute(array(
        'kullanim' => '1',
        'siparis_id' => $siparis_id
    ));
}
/*  <========SON=========>>> Sepet Kupon Kullanıldı Durumu Güncellemesi SON */


/* üyenin ilk siparişinin indirim kaydı */
if($ilk_sip_indirim_havale> '0'  ) {
    $kaydet = $db->prepare("INSERT INTO indirim_ilk_siparis_kayit SET
       uye_id=:uye_id,     
       ip_adres=:ip_adres,
       siparis_id=:siparis_id,
       onay=:onay
    ");
    $sonuc = $kaydet->execute(array(
        'uye_id' => $userCek['id'],
        'ip_adres' => $ipnedir,
        'siparis_id' => $siparis_id,
        'onay' => '1'
    ));
}
/*  <========SON=========>>> üyenin ilk siparişinin indirim kaydı SON */

?>
