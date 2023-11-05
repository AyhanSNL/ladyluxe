<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($siparisnotu == !null  ) {
    $notuekle = $siparisnotu;
}else{
    $notuekle = null;
}

/* Döviz Durumu */
if($odemeayar['kredi_kart_doviz_durum'] == '1' ) {

    if($odemeayar['pos_tur'] == 'iyzico') {
        $toplamodenecek = kurhesapla($varsayilankur['deger'],$secilikur['deger'],(((($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar)-$sepette_ek_indirim)-$ilk_sip_indirim)-$grubindirimi);
        $siparis_aratoplam = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$aratoplam);
        $siparis_kargotoplam = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$kargotoplami);
        $siparis_kdvtoplam = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$kdvtoplami);
        $siparis_indirimtutar = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$indirimtutar);
        $siparis_ek_indirimtutar = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$sepette_ek_indirim);
        $siparis_ilk_indirimi = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$ilk_sip_indirim);
        $siparis_grup_indirimi = kurhesapla($varsayilankur['deger'],$secilikur['deger'],$grubindirimi);

        $parabirimi = $secilikur['kod'];

        if($secilikur['kod'] == $varsayilankur['kod'] ) {
            $dovizdurum = '0';
            $odemekur = '1';
        }else{
            $dovizdurum = '1';
            $odemekur = $secilikur['deger'];
        }

    }else{
        $toplamodenecek = (((($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar)-$sepette_ek_indirim)-$ilk_sip_indirim)-$grubindirimi;
        $siparis_aratoplam = $aratoplam;
        $siparis_kargotoplam = $kargotoplami;
        $siparis_kdvtoplam = $kdvtoplami;
        $siparis_indirimtutar = $indirimtutar;
        $siparis_ek_indirimtutar = $sepette_ek_indirim;
        $siparis_ilk_indirimi = $ilk_sip_indirim;
        $siparis_grup_indirimi = $grubindirimi;
        $parabirimi = $varsayilankur['kod'];
        $dovizdurum = '0';
        $odemekur = '1';
    }
}else{
    $toplamodenecek = (((($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar)-$sepette_ek_indirim)-$ilk_sip_indirim)-$grubindirimi;
    $siparis_aratoplam = $aratoplam;
    $siparis_kargotoplam = $kargotoplami;
    $siparis_kdvtoplam = $kdvtoplami;
    $siparis_indirimtutar = $indirimtutar;
    $siparis_ek_indirimtutar = $sepette_ek_indirim;
    $siparis_ilk_indirimi = $ilk_sip_indirim;
    $siparis_grup_indirimi = $grubindirimi;
    $parabirimi = $varsayilankur['kod'];
    $dovizdurum = '0';
    $odemekur = '1';
}
/* Döviz Durumu SON */

if (isMobileDevice()) {
    $device = 'mobile';
} else {
    $device = 'desktop';
}

/* Sanal pos */
if($odemeayar['pos_tur'] == 'iyzico' ) {
    $posName = 'iyzico';
}
if($odemeayar['pos_tur'] == 'paytr' ) {
    $posName = 'PayTR';
}
if($odemeayar['pos_tur'] == 'shopier' ) {
    $posName = 'Shopier';
}
if($odemeayar['pos_tur'] == 'shoplemo' ) {
    $posName = 'Shoplemo';
}
if($odemeayar['pos_tur'] == 'payu' ) {
    $posName = 'Payu';
}
if($odemeayar['pos_tur'] == 'ipara' ) {
    $posName = 'iPara';
}
if($odemeayar['pos_tur'] == 'moka' ) {
    $posName = 'Moka';
}
/*  <========SON=========>>> Sanal pos SON */

$timestamp = date('Y-m-d G:i:s');
$sadetarih = date('Y-m-d');
$kaydet = $db->prepare("INSERT INTO siparisler SET
        siparis_no=:siparis_no,
        grup_indirim=:grup_indirim,
        ilk_siparis_indirim=:ilk_siparis_indirim,
        sade_tarih=:sade_tarih,
        iptal_aksiyon=:iptal_aksiyon,
        iptal=:iptal,
        taksit_durum=:taksit_durum,
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
        sepette_ek_indirim=:sepette_ek_indirim,
        kargo_limit_durum=:kargo_limit_durum,
        sabit_kargo=:sabit_kargo,
        odeme_kuru=:odeme_kuru,
        doviz_durum=:doviz_durum,
        alan_kodu=:alan_kodu,
             device=:device,
             sanal_pos=:sanal_pos
");
$sonuc = $kaydet->execute(array(
    'siparis_no' => $siparis_id,
    'grup_indirim' => $siparis_grup_indirimi,
    'ilk_siparis_indirim' => $siparis_ilk_indirimi,
    'sade_tarih' => $sadetarih,
    'iptal_aksiyon' => '1',
    'iptal' => '0',
    'taksit_durum' => $taksitdurum,
    'uye_id' => $sepetuyesi,
    'ara_tutar' => $siparis_aratoplam,
    'kdv_tutar' => $siparis_kdvtoplam,
    'kargo_tutar' => $siparis_kargotoplam,
    'indirim_tutar' => $siparis_indirimtutar,
    'toplam_tutar' => $toplamodenecek,
    'odeme_tur' => '1',
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
    'fatura_turu' =>$faturaturu,
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
    'siparis_durum' => $odemeayar['kredi_kart_siparis_durum'],
    'onay' => '0',
    'sepette_ek_indirim' => $siparis_ek_indirimtutar,
    'kargo_limit_durum' => $kargo_limit_durumu,
    'sabit_kargo' => $odemeayar['kargo_sabit'],
    'odeme_kuru' => $odemekur,
    'doviz_durum' => $dovizdurum,
    'alan_kodu' => $alankodu,
    'device' => $device,
    'sanal_pos' => $posName
));
/* üyenin ilk siparişinin indirim kaydı */
if($ilk_sip_indirim> '0'  ) {
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
        'onay' => '0'
    ));
}
/*  <========SON=========>>> üyenin ilk siparişinin indirim kaydı SON */
/* Ürünleri aktarma include alanı */
include 'kredi_kart_urun_aktar.php';
?>
