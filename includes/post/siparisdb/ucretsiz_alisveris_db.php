<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($siparisnotu == !null  ) {
    $notuekle = $siparisnotu;
}else{
    $notuekle = null;
}
$toplamodenecek = '0';
$siparis_aratoplam = '0';
$siparis_kargotoplam = '0';
$siparis_kdvtoplam = '0';
$siparis_indirimtutar = '0';
$siparis_ek_indirimtutar = '0';
$parabirimi = $varsayilankur['kod'];

if (isMobileDevice()) {
    $device = 'mobile';
} else {
    $device = 'desktop';
}
$timestamp = date('Y-m-d G:i:s');
$sadetarih = date('Y-m-d');
$kaydet = $db->prepare("INSERT INTO siparisler SET
    siparis_no=:siparis_no,
    sade_tarih=:sade_tarih,
        iptal_aksiyon=:iptal_aksiyon,
        iptal=:iptal,   
        uye_id=:uye_id,
        ara_tutar=:ara_tutar,
        kdv_tutar=:kdv_tutar,
        kargo_tutar=:kargo_tutar,
        indirim_tutar=:indirim_tutar,
        toplam_tutar=:toplam_tutar,
        odeme_tur=:odeme_tur,
        siparis_notu=:siparis_notu,
        siparis_tarih=:siparis_tarih,
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
        alan_kodu=:alan_kodu,
               device=:device,
        yeni=:yeni
");
$sonuc = $kaydet->execute(array(
    'siparis_no' => $siparis_id,
    'sade_tarih' => $sadetarih,
    'iptal_aksiyon' => '1',
    'iptal' => '0',
    'uye_id' => $sepetuyesi,
    'ara_tutar' => $siparis_aratoplam,
    'kdv_tutar' => $siparis_kdvtoplam,
    'kargo_tutar' => $siparis_kargotoplam,
    'indirim_tutar' => $siparis_indirimtutar,
    'toplam_tutar' => $toplamodenecek,
    'odeme_tur' => 'free',
    'siparis_notu' => $notuekle,
    'siparis_tarih' => $timestamp,
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
    'siparis_durum' => $odemeayar['ucretsiz_alisveris_durum'],
    'onay' => '1',
    'alan_kodu' => $alankodu,
    'device' => $device,
    'yeni' => '1'
));
include 'includes/post/siparisdb/ucretsiz_alisveris_urun_aktar.php';
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
        $icerik = ''.$diller['oto-eposta-content-text1'].' '.$userCek['isim'].' '.$userCek['soyisim'].', <br><br> #'.$siparis_id.' '.$diller['bildirimler-text17'].' ';
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
    'icerik_id' => $siparis_id,
));
/*  <========SON=========>>> Panel bildirim SON */

/* SMS */
if($sms['durum'] == '1' ) {
    if($sms['sms_siparis_site'] == '1' || $sms['sms_siparis_user'] == '1') {
        include 'includes/post/smstemp/siparis/siparis_sms.php';
        include 'includes/post/smstemp/sms_api.php';
    }
}
/*  <========SON=========>>> SMS SON */

/* E-Posta Bildirimleri */
if($ayar['smtp_durum'] == '1' ) {
    include 'includes/post/mailtemp/siparisler/ucretsiz_alisveris_mail_temp.php';
}
/* E-Posta Bildirimleri SON */

?>
