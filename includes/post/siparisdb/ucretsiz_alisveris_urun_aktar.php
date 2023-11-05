<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
/* Sepetteki ürünleri foreach'a al Sepet durumu 1 olanlar için */
$SepetAktif_Urun_Db_Aktar = $db->prepare("select * from sepet where sepet_durum=:sepet_durum and ip=:ip ");
$SepetAktif_Urun_Db_Aktar->execute(array(
    'sepet_durum' => '1',
    'ip' => $ipnedir
));

foreach ($SepetAktif_Urun_Db_Aktar as $sepetdb) {
    $sepetid = $sepetdb['sepetno'];
    /* Varyantları DB'ye aktar */
    if($sepetdb['varyant'] > '0' && $sepetdb['varyant'] == !null) {
        $varyantAyir = $sepetdb['varyant'];
        $varyantAyir = explode(',', $varyantAyir);

        foreach($varyantAyir as $varkey) {
            $varyantBilgi = $db->prepare("select * from detay_varyant_ozellik where id=:id ");
            $varyantBilgi->execute(array(
                'id' => $varkey
            ));
            $varRow = $varyantBilgi->fetch(PDO::FETCH_ASSOC);
            if($varyantBilgi->rowCount()>'0'  ) {
                $varyantGrup = $db->prepare("select * from detay_varyant where varyant_id=:varyant_id ");
                $varyantGrup->execute(array(
                    'varyant_id' => $varRow['varyant_id']
                ));
                $varGRow = $varyantGrup->fetch(PDO::FETCH_ASSOC);
                if($varyantGrup->rowCount() > '0'  ) {
                    if($varGRow['tur'] == '1' ) {
                        $kaydet = $db->prepare("INSERT INTO siparis_varyant SET
                         urun_id=:urun_id,       
                            sepet_id=:sepet_id,
                         siparis_id=:siparis_id,
                         varyant_adi=:varyant_adi,
                         grup_adi=:grup_adi,
                         tur=:tur,
                         ek_fiyat=:ek_fiyat
                        ");
                        $sonuc = $kaydet->execute(array(
                            'urun_id' => $sepetdb['urun_id'],
                            'sepet_id' => $sepetid,
                            'siparis_id' => $siparis_id,
                            'varyant_adi' => $varRow['baslik'],
                            'grup_adi' => $varGRow['baslik'],
                            'tur' => $varGRow['tur'],
                            'ek_fiyat' =>  $varRow['ek_fiyat']
                        ));
                    }
                    if($varGRow['tur'] == '3' ) {
                        $kaydet = $db->prepare("INSERT INTO siparis_varyant SET
                         urun_id=:urun_id,       
                            sepet_id=:sepet_id,
                         siparis_id=:siparis_id,
                         varyant_adi=:varyant_adi,
                         grup_adi=:grup_adi,
                         tur=:tur,
                         ek_fiyat=:ek_fiyat
                        ");
                        $sonuc = $kaydet->execute(array(
                            'urun_id' => $sepetdb['urun_id'],
                            'sepet_id' => $sepetid,
                            'siparis_id' => $siparis_id,
                            'varyant_adi' => $varRow['baslik'],
                            'grup_adi' => $varGRow['baslik'],
                            'tur' => $varGRow['tur'],
                            'ek_fiyat' => $varRow['ek_fiyat']
                        ));
                    }
                    if($varGRow['tur'] == '2' ) {
                        $varyantEkSorgu = $db->prepare("select * from urun_varyant_ekler where detay_ozellik_id=:detay_ozellik_id and sepet_id=:sepet_id order by id desc");
                        $varyantEkSorgu->execute(array(
                            'detay_ozellik_id' => $varRow['id'],
                            'sepet_id' => $sepetdb['sepetno']
                        ));
                        $ekRow = $varyantEkSorgu->fetch(PDO::FETCH_ASSOC);

                        if($varyantEkSorgu->rowCount()>'0'  ) {
                            $ekID = $ekRow['id'];
                            $ekFiyatCount = $varRow['ek_fiyat'];
                        }else{
                            $ekID = null;
                            $ekFiyatCount = '0';
                        }
                        $kaydet = $db->prepare("INSERT INTO siparis_varyant SET
                         urun_id=:urun_id,       
                            sepet_id=:sepet_id,
                         siparis_id=:siparis_id,
                         varyant_adi=:varyant_adi,
                         grup_adi=:grup_adi,
                         tur=:tur,
                         ekbilgi_id=:ekbilgi_id,
                         ek_fiyat=:ek_fiyat
                        ");
                        $sonuc = $kaydet->execute(array(
                            'urun_id' => $sepetdb['urun_id'],
                            'sepet_id' => $sepetid,
                            'siparis_id' => $siparis_id,
                            'varyant_adi' => $varRow['baslik'],
                            'grup_adi' => $varGRow['baslik'],
                            'tur' => $varGRow['tur'],
                            'ekbilgi_id' => $ekID,
                            'ek_fiyat' => $ekFiyatCount
                        ));
                    }
                    if($varGRow['tur'] == '4' ) {
                        $varyantEkSorgu = $db->prepare("select * from urun_varyant_ekler where detay_ozellik_id=:detay_ozellik_id and sepet_id=:sepet_id order by id desc");
                        $varyantEkSorgu->execute(array(
                            'detay_ozellik_id' => $varRow['id'],
                            'sepet_id' => $sepetdb['sepetno']
                        ));
                        $ekRow = $varyantEkSorgu->fetch(PDO::FETCH_ASSOC);

                        if($varyantEkSorgu->rowCount()>'0'  ) {
                            $ekID = $ekRow['id'];
                            $ekFiyatCount = $varRow['ek_fiyat'];
                        }else{
                            $ekID = null;
                            $ekFiyatCount = '0';
                        }
                        $kaydet = $db->prepare("INSERT INTO siparis_varyant SET
                         urun_id=:urun_id,       
                            sepet_id=:sepet_id,
                         siparis_id=:siparis_id,
                         varyant_adi=:varyant_adi,
                         grup_adi=:grup_adi,
                         tur=:tur,
                         ekbilgi_id=:ekbilgi_id,
                         ek_fiyat=:ek_fiyat
                        ");
                        $sonuc = $kaydet->execute(array(
                            'urun_id' => $sepetdb['urun_id'],
                            'sepet_id' => $sepetid,
                            'siparis_id' => $siparis_id,
                            'varyant_adi' => $varRow['baslik'],
                            'grup_adi' => $varGRow['baslik'],
                            'tur' => $varGRow['tur'],
                            'ekbilgi_id' => $ekID,
                            'ek_fiyat' => $ekFiyatCount
                        ));
                    }
                }
            }
        }
    }
    /*  <========SON=========>>> Varyantları DB'ye aktar SON */

    /* Ürünü Al */
        $dbForRealProduct = $db->prepare("select * from urun where id=:id ");
        $dbForRealProduct->execute(array(
            'id' => $sepetdb['urun_id'],
        ));
        $dbforurun = $dbForRealProduct->fetch(PDO::FETCH_ASSOC);
    /* Ürünü Al SON */

    /* varyant ve ana ürün stok işlemleri */
    if($sepetdb['varyant_stok_durum'] == '0'  ) {
        /* Ana ürün stok işlemleri */
        $mainProductStock_Query = $db->prepare("select * from urun where id=:id ");
        $mainProductStock_Query->execute(array(
            'id' => $sepetdb['urun_id'],
        ));
        $stokMainRow = $mainProductStock_Query->fetch(PDO::FETCH_ASSOC);
        $stokCode = $stokMainRow['urun_kod'];
        if($odemeayar['urun_stok_dus'] == '1' ) {
            $guncelle = $db->prepare("UPDATE urun SET
                         stok=:stok
                  WHERE id={$stokMainRow['id']}      
                 ");
            $sonuc = $guncelle->execute(array(
                'stok' => $stokMainRow['stok']-$sepetdb['adet']
            ));
        }
            /* Ana ürün stok işlemleri SON */
    }
    if($sepetdb['varyant_stok_durum'] == '1'  ) {
        /* varyant Stok İşlemleri */
            $detailVariant_Stok_Query = $db->prepare("select * from detay_varyant_stok where varyant=:varyant and urun_id=:urun_id ");
            $detailVariant_Stok_Query->execute(array(
                'varyant' => $sepetdb['varyant'],
                'urun_id' => $sepetdb['urun_id']
            ));
            $stokRow = $detailVariant_Stok_Query->fetch(PDO::FETCH_ASSOC);
            if($detailVariant_Stok_Query->rowCount()>'0' ) {
                $stokCode = $stokRow['stok_kodu'];
                if($odemeayar['urun_stok_dus'] == '1' ) { 
                 /* Stoktan Düşme için mevcut stok - adet yap */
                 $guncelle = $db->prepare("UPDATE detay_varyant_stok SET
                         stok=:stok
                  WHERE id={$stokRow['id']}      
                 ");
                 $sonuc = $guncelle->execute(array(
                        'stok' => $stokRow['stok']-$sepetdb['adet']
                 ));
                 /* Stoktan Düşme için mevcut stok - adet yap SON */
                }
            }else{
                $stokCode = '0000';
            }
        /* varyant Stok İşlemleri SON */
    }
    /* varyant ve ana ürün stok işlemleri SON */


    $kaydet = $db->prepare("INSERT INTO siparis_urunler SET 
        urun_id=:urun_id,
        iade_aksiyon=:iade_aksiyon,
             sepet_id=:sepet_id,
        durum=:durum,
        kargo_tutar=:kargo_tutar,
        ek_fiyat=:ek_fiyat,
        varyantlar=:varyantlar,
        kdvsiz_tutar=:kdvsiz_tutar,
        kdv_tutar=:kdv_tutar,
        urun_baslik=:urun_baslik,
        adet=:adet,
        varyant_stok_durum=:varyant_stok_durum,
        siparis_id=:siparis_id,
        ozel_fiyat_uye=:ozel_fiyat_uye,
        stok_kodu=:stok_kodu
");
    $sonuc = $kaydet->execute(array(
        'urun_id' => $sepetdb['urun_id'],
        'iade_aksiyon' => '1',
        'sepet_id' => $sepetid,
        'durum' => '0',
        'kargo_tutar' => 0,
        'ek_fiyat' => 0,
        'varyantlar' => null,
        'kdvsiz_tutar' => 0,
        'kdv_tutar' =>0,
        'urun_baslik' => $dbforurun['baslik'],
        'adet' => $sepetdb['adet'],
        'varyant_stok_durum' => $sepetdb['varyant_stok_durum'],
        'siparis_id' => $siparis_id,
        'ozel_fiyat_uye' => 0,
        'stok_kodu' => $stokCode
));

    /* Ürün satış sayıları için gerçek ürünü güncelle */
    $urun = $db->prepare("select satis_adet from urun where id=:id ");
    $urun->execute(array(
        'id' => $sepetdb['urun_id'],
    ));
    $u = $urun->fetch(PDO::FETCH_ASSOC);
    $satisCount = $u['satis_adet'];
    $guncelle = $db->prepare("UPDATE urun SET
           satis_adet=:satis_adet 
     WHERE id={$sepetdb['urun_id']}      
    ");
    $sonuc = $guncelle->execute(array(
        'satis_adet' => $satisCount+$sepetdb['adet']
    ));
    /*  <========SON=========>>> Ürün satış sayıları için gerçek ürünü güncelle SON */


}
?>
