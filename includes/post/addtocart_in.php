<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;
//todo ioncube
?>
<?php
/* Üye Kontrolü ///////////////////////////////////////////*/
if($userSorgusu->rowCount() > '0'  ) {
    $uye_id = $userCek['id'];

    /* Üyenin grubuna göre fiyat kontrolü */
    if($userCek['uye_grup'] == !null && $userCek['uye_grup'] > '0') {

        $uyeGurubu = $db->prepare("select * from uyeler_grup where id=:id ");
        $uyeGurubu->execute(array(
            'id' => $userCek['uye_grup']
        ));
        $uyegrup = $uyeGurubu->fetch(PDO::FETCH_ASSOC);
        if($uyeGurubu->rowCount()>'0') {

            if($uyegrup['fiyat_tip'] == '0' ) {

                $fiyat = $urun['fiyat'];
                $uyefiyat = 0;
                $uyeyeozelfiyat= '0';

            }
            if($uyegrup['fiyat_tip'] == '1' ) {

                $fiyat = $urun['fiyat'];

                if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] >'0') {
                    $uyefiyat = $urun['fiyat_tip2'];
                    $uyeyeozelfiyat= '1';
                }else{
                    $uyefiyat = 0;
                    $uyeyeozelfiyat= '0';
                }

            }

        }else{
            $fiyat = $urun['fiyat'];
            $uyefiyat = 0;
            $uyeyeozelfiyat= '0';
        }
    }else{
        $fiyat = $urun['fiyat'];
        $uyefiyat = 0;
        $uyeyeozelfiyat= '0';
    }
    /* Üyenin grubuna göre fiyat kontrolü SON */


}else{
    $uye_id = null;
    $fiyat = $urun['fiyat'];
    $uyefiyat = 0;
    $uyeyeozelfiyat= '0';
}
/* Üye Kontrolü SON ///////////////////////////////////////////*/



/////////////////////////* Varyant ek fiyatları hesapla ///////////////////////////////////////////*/
///
/* Seçili Varyant Seçenekleri */
/* varyant sorgu */
$varyantKontroluHead = $db->prepare("select * from detay_varyant where urun_id=:urun_id ");
$varyantKontroluHead->execute(array(
    'urun_id' => $urun_id
));
/* varyant sorgu SON */
foreach($varyantKontroluHead as $vhead){
    $varyantSecenekvarmiHead = $db->prepare("select * from detay_varyant_ozellik where id=:id ");
    $varyantSecenekvarmiHead->execute(array(
        'id' => trim(strip_tags($_POST['var'.$vhead['id'].'']))
    ));
    if($vhead!='' && $varyantSecenekvarmiHead->rowCount()>'0'){
        $varyantsecenekleriHead.= trim(strip_tags($_POST['var'.$vhead['id'].''])).',';
    }else{
        $varyantsecenekleriHead.= '0,';
    }
}
/* Seçili Varyant Seçenekleri SON */

$varyant_ozellik_ek_fiyat = 0;

$varyantayirCalc = $varyantsecenekleriHead;
$varyantayirCalc = explode(',', $varyantayirCalc);

foreach ($varyantayirCalc as $varcalckey) {
    if($varcalckey !='' ) {
        $varyantOzellikCekelimCalc = $db->prepare("select * from detay_varyant_ozellik where id=:id and urun_id=:urun_id ");
        $varyantOzellikCekelimCalc->execute(array(
            'id' => $varcalckey,
            'urun_id' => $urun_id
        ));
        if($varyantOzellikCekelimCalc->rowCount()>'0'  ) {
            foreach ($varyantOzellikCekelimCalc as $varyantozellikcalc) {

                $calc_var_ek_fiyat = $varyantozellikcalc['ek_fiyat'];

                $varyantGrubuCekCalc = $db->prepare("select * from detay_varyant where urun_id=:urun_id and varyant_id=:varyant_id ");
                $varyantGrubuCekCalc->execute(array(
                    'urun_id' => $urun_id,
                    'varyant_id' => $varyantozellikcalc['varyant_id']
                ));
                $vargrubuCalc = $varyantGrubuCekCalc->fetch(PDO::FETCH_ASSOC);

                if($vargrubuCalc['tur'] == '2' ) {

                    if($_POST['ek_var'.$vargrubuCalc['id'].''] == !null ) {

                    }else{
                        $calc_var_ek_fiyat = 0;
                    }

                }
                if($vargrubuCalc['tur'] == '4' ) {

                    if($_POST['ek_var'.$vargrubuCalc['id'].''] == !null ) {

                    }else{
                        $calc_var_ek_fiyat = 0;
                    }

                }
                /* Varyant Ek Fiyatlar Toplaması */
                $varyant_ozellik_ek_fiyat = $varyant_ozellik_ek_fiyat + ($calc_var_ek_fiyat);
                /* Varyant Ek Fiyatlar Toplaması SON */
            }
        }
    }
}


/////////////////////////* Varyant ek fiyatları hesapla SON ///////////////////////////////////////////*/
///
///
///
///
///
///



/* KDV Kontrolü ve kayıtları */
if($urun['kdv'] == '0' ) {
    if($userSorgusu->rowCount()>'0'  ) {
        if($uyegruplariCek->rowCount() >'0'  ) {
            if($uyegrup['fiyat_tip'] == '0'  ) {
                $urunun_kdvsiz_fiyati = $fiyat+$varyant_ozellik_ek_fiyat;
                $urunun_kdv_si = 0;
            }
            if($uyegrup['fiyat_tip'] == '1'  ) {
                if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {
                    $urunun_kdvsiz_fiyati = $uyefiyat+$varyant_ozellik_ek_fiyat;
                    $urunun_kdv_si = 0;
                }else{
                    $urunun_kdvsiz_fiyati = $fiyat+$varyant_ozellik_ek_fiyat;
                    $urunun_kdv_si = 0;
                }
            }
        }else{
            $urunun_kdvsiz_fiyati = $fiyat+$varyant_ozellik_ek_fiyat;
            $urunun_kdv_si = 0;
        }
    }else{
        $urunun_kdvsiz_fiyati = $fiyat+$varyant_ozellik_ek_fiyat;
        $urunun_kdv_si = 0;
    }
    $kdv_durumu = '0';
}

if($urun['kdv'] == '1' ) {
    if($userSorgusu->rowCount()>'0'  ) {
        if($uyegruplariCek->rowCount() >'0'  ) {
            if($uyegrup['fiyat_tip'] == '0'  ) {
                $urunun_kdvsiz_fiyati = $fiyat+$varyant_ozellik_ek_fiyat;
                $urunun_kdv_si = kdvhesapla($fiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
            }
            if($uyegrup['fiyat_tip'] == '1'  ) {
                if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {
                    $urunun_kdvsiz_fiyati = $uyefiyat+$varyant_ozellik_ek_fiyat;
                    $urunun_kdv_si = kdvhesapla($uyefiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
                }else{
                    $urunun_kdvsiz_fiyati = $fiyat+$varyant_ozellik_ek_fiyat;
                    $urunun_kdv_si = kdvhesapla($fiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
                }
            }
        }else{
            $urunun_kdvsiz_fiyati = $fiyat+$varyant_ozellik_ek_fiyat;
            $urunun_kdv_si = kdvhesapla($fiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
        }
    }else{
        $urunun_kdvsiz_fiyati = $fiyat+$varyant_ozellik_ek_fiyat;
        $urunun_kdv_si = kdvhesapla($fiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
    }
    $kdv_durumu = '1';
}

if($urun['kdv'] == '2' ) {
    if($userSorgusu->rowCount()>'0'  ) {
        if($uyegruplariCek->rowCount() >'0'  ) {
            if($uyegrup['fiyat_tip'] == '0'  ) {
                $urunun_kdvsiz_fiyati = kdvcikar($fiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
                $urunun_kdv_si = kdvhesapla($urunun_kdvsiz_fiyati,$urun['kdv_oran']);
            }
            if($uyegrup['fiyat_tip'] == '1'  ) {
                if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {
                    $urunun_kdvsiz_fiyati = kdvcikar($uyefiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
                    $urunun_kdv_si = kdvhesapla($urunun_kdvsiz_fiyati,$urun['kdv_oran']);
                }else{
                    $urunun_kdvsiz_fiyati = kdvcikar($fiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
                    $urunun_kdv_si = kdvhesapla($urunun_kdvsiz_fiyati,$urun['kdv_oran']);
                }
            }
        }else{
            $urunun_kdvsiz_fiyati = kdvcikar($fiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
            $urunun_kdv_si = kdvhesapla($urunun_kdvsiz_fiyati,$urun['kdv_oran']);
        }
    }else{
        $urunun_kdvsiz_fiyati = kdvcikar($fiyat+$varyant_ozellik_ek_fiyat,$urun['kdv_oran']);
        $urunun_kdv_si = kdvhesapla($urunun_kdvsiz_fiyati,$urun['kdv_oran']);
    }
    $kdv_durumu = '2';
}
/* KDV Kontrolü ve kayıtları SON */

/* Kargo Bilgileri */
if($odemeayar['kargo_sistemi'] == '1' ) {
    if($urun['kargo'] == '1' ) {
        if($odemeayar['kargo_sabit'] == '1' ) {
            $kargo_tut= $odemeayar['kargo_sabit_ucret'];
        }else{
            $kargo_tut= $urun['kargo_ucret'];
        }
    }else{
        $kargo_tut='0';
    }
}else{
    $kargo_tut='0';
}
/* Kargo Bilgileri SON */

/* Havale Fiyat Bilgileri */
if($urun['havale_indirim_tutar'] == !null && $urun['havale_indirim_tutar'] > '0' ) {
    if($userSorgusu->rowCount()>'0'  ) {
        if($uyegruplariCek->rowCount() >'0'  ) {
            if($uyegrup['fiyat_tip'] == '0'  ) {
                if($urun['havale_indirim_tur'] == '1' ) {
                    $havale_tut_cikar = ($fiyat*$urun['havale_indirim_tutar'])/100;
                    $havale_tut = $fiyat-$havale_tut_cikar;
                }
                if($urun['havale_indirim_tur'] == '2' ) {
                    $havale_tut = $fiyat-$urun['havale_indirim_tutar'];
                }
            }
            if($uyegrup['fiyat_tip'] == '1'  ) {
                if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {
                    if($urun['havale_indirim_tur'] == '1' ) {
                        $havale_tut_cikar = ($uyefiyat*$urun['havale_indirim_tutar'])/100;
                        $havale_tut = $fiyat-$havale_tut_cikar;
                    }
                    if($urun['havale_indirim_tur'] == '2' ) {
                        $havale_tut = $uyefiyat-$urun['havale_indirim_tutar'];
                    }
                }else{
                    if($urun['havale_indirim_tur'] == '1' ) {
                        $havale_tut_cikar = ($fiyat*$urun['havale_indirim_tutar'])/100;
                        $havale_tut = $fiyat-$havale_tut_cikar;
                    }
                    if($urun['havale_indirim_tur'] == '2' ) {
                        $havale_tut = $fiyat-$urun['havale_indirim_tutar'];
                    }
                }
            }
        }else{
            if($urun['havale_indirim_tur'] == '1' ) {
                $havale_tut_cikar = ($fiyat*$urun['havale_indirim_tutar'])/100;
                $havale_tut = $fiyat-$havale_tut_cikar;
            }
            if($urun['havale_indirim_tur'] == '2' ) {
                $havale_tut = $fiyat-$urun['havale_indirim_tutar'];
            }
        }
    }else{
        if($urun['havale_indirim_tur'] == '1' ) {
            $havale_tut_cikar = ($fiyat*$urun['havale_indirim_tutar'])/100;
            $havale_tut = $fiyat-$havale_tut_cikar;
        }
        if($urun['havale_indirim_tur'] == '2' ) {
            $havale_tut = $fiyat-$urun['havale_indirim_tutar'];
        }
    }
}else{
    $havale_tut = 0;
}

/* Havale Fiyat Bilgileri SON */





/* Sepet Kontrolü ///////////////////////////////////////////*/
$sepetKontrol = $db->prepare("select * from sepet where urun_id=:urun_id and ip=:ip ");
$sepetKontrol->execute(array(
    'urun_id' => $urun_id,
    'ip' => $ip
));
$sepet = $sepetKontrol->fetch(PDO::FETCH_ASSOC);
$sepet_ip = $sepet['ip'];
$sepet_urunid = $sepet['urun_id'];
$sepet_adet = $sepet['adet'];
/* Sepet Kontrolü SON ///////////////////////////////////////////*/


if($adet) {


    if($urun_id) {

        if($urunCek->rowCount()>'0'  ) {

            /////////////////////////* Varyantlı ürünü sepete ekleme ///////////////////////////////////////////*/

            /* varyant sorgu */
            $varyantKontrolu = $db->prepare("select * from detay_varyant where urun_id=:urun_id ");
            $varyantKontrolu->execute(array(
                'urun_id' => $urun_id
            ));
            /* varyant sorgu SON */

            if($varyantKontrolu->rowCount() > '0'  ) {


                /* Seçili Varyant Seçenekleri */
                foreach($varyantKontrolu as $v){
                    $varyantSecenekvarmi = $db->prepare("select * from detay_varyant_ozellik where id=:id ");
                    $varyantSecenekvarmi->execute(array(
                        'id' => trim(strip_tags($_POST['var'.$v['id'].'']))
                    ));
                    if($v!='' && $varyantSecenekvarmi->rowCount()>'0'){
                        $varyantsecenekleri.= trim(strip_tags($_POST['var'.$v['id'].''])).',';
                    }else{
                        $varyantsecenekleri.= '0,';
                    }
                }
                /* Seçili Varyant Seçenekleri SON */





                /* Bu ürünü müşteri sepete daha önce eklemiş mi? */

                $varyantSepetUrunKontrolu = $db->prepare("select * from sepet where urun_id=:urun_id and ip=:ip and varyant=:varyant");
                $varyantSepetUrunKontrolu->execute(array(
                    'urun_id' => $urun_id,
                    'ip' => $ip,
                    'varyant' => $varyantsecenekleri
                ));
                $varsepet = $varyantSepetUrunKontrolu->fetch(PDO::FETCH_ASSOC);


                /* Varyant Seçeneklerinin stok kontrolü Sorgusu */
                $varyantStokKontrol = $db->prepare("select * from detay_varyant_stok where urun_id=:urun_id and varyant=:varyant ");
                $varyantStokKontrol->execute(array(
                    'urun_id' => $urun_id,
                    'varyant' => $varyantsecenekleri
                ));
                $varyantStok = $varyantStokKontrol->fetch(PDO::FETCH_ASSOC);
                $varyantStokSayi = $varyantStok['stok'];
                /* Varyant Seçeneklerinin stok kontrolü Sorgusu SON */

                /* Varyantlı sepet adet ve yeni adet toplamı sorgusu */
                $varyantSecenekSepetToplami = $db->prepare("SELECT SUM(adet) AS geneladet FROM sepet where urun_id=:urun_id and ip=:ip and varyant=:varyant");
                $varyantSecenekSepetToplami->execute(array(
                    'urun_id' => $urun_id,
                    'ip' => $ip,
                    'varyant' => $varyantsecenekleri
                ));
                $varyanSecTop = $varyantSecenekSepetToplami->fetch(PDO::FETCH_ASSOC);
                $varyansecenekgeneladetsayisi = $varyanSecTop['geneladet'] + $adet ;
                /* Varyantlı sepet adet ve yeni adet toplamı sorgusu SON */


                /* ANA ÜRÜN STOK İÇİN varytantlı sepet adet ve yeni adet toplamı sorgusu */
                $anaurunstokicinSepetSayiCek = $db->prepare("SELECT SUM(adet) AS geneladet FROM sepet where urun_id=:urun_id and ip=:ip and varyant_stok_durum=:varyant_stok_durum");
                $anaurunstokicinSepetSayiCek->execute(array(
                    'urun_id' => $urun_id,
                    'ip' => $ip,
                    'varyant_stok_durum' => '0'
                ));
                $anauruNSepetToplam = $anaurunstokicinSepetSayiCek->fetch(PDO::FETCH_ASSOC);
                $anaurunToplamAdetSayisi = $anauruNSepetToplam['geneladet'] + $adet ;
                /* ANA ÜRÜN STOK İÇİN varytantlı sepet adet ve yeni adet toplamı sorgusu SON */



                if($varyantSepetUrunKontrolu->rowCount() > '0') {
                    /* Evet Eklemiş *//////////////////



                    if($varyantStokKontrol->rowCount()>'0'  ) {
                        if($varyantStokSayi >= $varyansecenekgeneladetsayisi  ) {
                            /* Sepetteki ürünün adet sayısı + yeni eklenen adetin sayısının toplamı stok değerine eşit veya kücükse işlem yap */

                            /* TÜR 2 İÇİN Ek Varyant İÇERİĞİNİ Güncelle ///////////////////////////////////////////*/
                            $ekvaryantFor = $db->prepare("select * from detay_varyant where urun_id=:urun_id and tur=:tur ");
                            $ekvaryantFor->execute(array(
                                'urun_id' => $urun_id,
                                'tur' => '2'
                            ));
                            if($ekvaryantFor->rowCount()> '0'  ) {
                                foreach ($ekvaryantFor as $ekvarfor) {
                                    $ekVaryant = $db->prepare("select * from urun_varyant_ekler where sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id");
                                    $ekVaryant->execute(array(
                                        'sepet_id' => $varsepet['sepetno'],
                                        'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].'']
                                    ));
                                    $ekvar = $ekVaryant->fetch(PDO::FETCH_ASSOC);
                                    if($ekVaryant->rowCount() >'0'  ) {
                                        if($_POST['ek_var'.$ekvarfor['id'].''] == null ) {
                                            $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE sepet_id=:sepet_id");
                                            $silmeislem->execute(array(
                                                'sepet_id' => $varsepet['sepetno']
                                            ));
                                        }else{
                                            $guncelle = $db->prepare("UPDATE urun_varyant_ekler SET
                                                         icerik=:icerik
                                                  WHERE sepet_id={$varsepet['sepetno']}
                                                 ");
                                            $sonuc = $guncelle->execute(array(
                                                'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].'']))
                                            ));
                                        }
                                    }else{
                                        $kaydet = $db->prepare("INSERT INTO urun_varyant_ekler SET
                                                 urun_id=:urun_id,
                                                 ip_adres=:ip_adres,
                                                 detay_ozellik_id=:detay_ozellik_id,
                                                 icerik=:icerik,
                                                 sepet_id=:sepet_id
                                            ");
                                        $sonuc = $kaydet->execute(array(
                                            'urun_id' => $urun_id,
                                            'ip_adres' => $ip,
                                            'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].''],
                                            'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].''])),
                                            'sepet_id' => $varsepet['sepetno']
                                        ));
                                    }
                                }
                            }
                            /* TÜR 2 İÇİN Ek Varyant İÇERİĞİNİ Güncelle SON ///////////////////////////////////////////*/

                            /* Tür 4 İÇİN Ek Varyant İçeriği */
                            $ekvaryantFor = $db->prepare("select * from detay_varyant where urun_id=:urun_id and tur=:tur ");
                            $ekvaryantFor->execute(array(
                                'urun_id' => $urun_id,
                                'tur' => '4'
                            ));
                            if($ekvaryantFor->rowCount()> '0'  ) {
                                foreach ($ekvaryantFor as $ekvarfor) {
                                    $ekVaryant = $db->prepare("select * from urun_varyant_ekler where sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id");
                                    $ekVaryant->execute(array(
                                        'sepet_id' => $varsepet['sepetno'],
                                        'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].'']
                                    ));
                                    $ekvar = $ekVaryant->fetch(PDO::FETCH_ASSOC);
                                    if($ekVaryant->rowCount() >'0'  ) {
                                        if($_POST['ek_var'.$ekvarfor['id'].''] == null ) {
                                            $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE sepet_id=:sepet_id");
                                            $silmeislem->execute(array(
                                                'sepet_id' => $varsepet['sepetno']
                                            ));
                                        }else{
                                            $guncelle = $db->prepare("UPDATE urun_varyant_ekler SET
                                                         icerik=:icerik
                                                  WHERE sepet_id={$varsepet['sepetno']}
                                                 ");
                                            $sonuc = $guncelle->execute(array(
                                                'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].'']))
                                            ));
                                        }
                                    }else{
                                        $kaydet = $db->prepare("INSERT INTO urun_varyant_ekler SET
                                                 urun_id=:urun_id,
                                                 ip_adres=:ip_adres,
                                                 detay_ozellik_id=:detay_ozellik_id,
                                                 icerik=:icerik,
                                                 sepet_id=:sepet_id
                                            ");
                                        $sonuc = $kaydet->execute(array(
                                            'urun_id' => $urun_id,
                                            'ip_adres' => $ip,
                                            'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].''],
                                            'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].''])),
                                            'sepet_id' => $varsepet['sepetno']
                                        ));
                                    }
                                }
                            }
                            /*  <========SON=========>>> Tür 4 İÇİN Ek Varyant İçeriği SON */

                            $guncelle = $db->prepare("UPDATE sepet SET
                                  adet=:adet,
                                  varyant_stok_durum=:varyant_stok_durum
                           WHERE sepetno={$varsepet['sepetno']}      
                          ");
                            $sonuc = $guncelle->execute(array(
                                'adet' => $varsepet['adet']+$adet,
                                'varyant_stok_durum' => '1'
                            ));
                            if($sonuc){
                                unset($_SESSION['siparis_islem_id']);
                                if($odemeayar['sepet_href'] == '0' ) {
                                    $_SESSION['addtocart'] = 'success';
                                    header('Location:'.$sesurun_adres.'');
                                }
                                if($odemeayar['sepet_href'] == '1' ) {
                                    $_SESSION['addtocart'] = 'modalsuccess';
                                    $_SESSION['adetdetay'] = $adet;
                                    header('Location:'.$sesurun_adres.'');
                                }
                                if($odemeayar['sepet_href'] == '2' ) {
                                    header('Location:'.$siteurl.'sepet/');
                                }
                            }else{
                                $_SESSION['dberror'] = 'dberror';
                                header('Location:'.$siteurl.'404');
                            }
                            /* Sepetteki ürünün adet sayısı + yeni eklenen adetin sayısının toplamı stok değerine eşit veya kücükse işlem yap SON */
                        }else{
                            $_SESSION['addtocart'] = 'nomorestok';
                            header('Location:'.$sesurun_adres.'');
                        }
                    }else{
                        if($urunstok >= $anaurunToplamAdetSayisi) {
                            /* ANAÜRÜN STOKUNA GÖRE!!!!-> Sepetteki ürünün adet sayısı + yeni eklenen adetin sayısının toplamı stok değerine eşit veya kücükse işlem yap */
                            /* TÜR 2 İÇİN Ek Varyant İÇERİĞİNİ Güncelle ///////////////////////////////////////////*/
                            $ekvaryantFor = $db->prepare("select * from detay_varyant where urun_id=:urun_id and tur=:tur ");
                            $ekvaryantFor->execute(array(
                                'urun_id' => $urun_id,
                                'tur' => '2'
                            ));
                            if($ekvaryantFor->rowCount()> '0'  ) {
                                foreach ($ekvaryantFor as $ekvarfor) {
                                    $ekVaryant = $db->prepare("select * from urun_varyant_ekler where sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id");
                                    $ekVaryant->execute(array(
                                        'sepet_id' => $varsepet['sepetno'],
                                        'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].'']
                                    ));
                                    $ekvar = $ekVaryant->fetch(PDO::FETCH_ASSOC);
                                    if($ekVaryant->rowCount() >'0'  ) {
                                        if($_POST['ek_var'.$ekvarfor['id'].''] == null ) {
                                            $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE sepet_id=:sepet_id");
                                            $silmeislem->execute(array(
                                                'sepet_id' => $varsepet['sepetno']
                                            ));
                                        }else{
                                            $guncelle = $db->prepare("UPDATE urun_varyant_ekler SET
                                                         icerik=:icerik
                                                  WHERE sepet_id={$varsepet['sepetno']}
                                                 ");
                                            $sonuc = $guncelle->execute(array(
                                                'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].'']))
                                            ));
                                        }
                                    }else{
                                        $kaydet = $db->prepare("INSERT INTO urun_varyant_ekler SET
                                                 urun_id=:urun_id,
                                                 ip_adres=:ip_adres,
                                                 detay_ozellik_id=:detay_ozellik_id,
                                                 icerik=:icerik,
                                                 sepet_id=:sepet_id
                                            ");
                                        $sonuc = $kaydet->execute(array(
                                            'urun_id' => $urun_id,
                                            'ip_adres' => $ip,
                                            'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].''],
                                            'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].''])),
                                            'sepet_id' => $varsepet['sepetno']
                                        ));
                                    }
                                }
                            }
                            /* TÜR 2 İÇİN Ek Varyant İÇERİĞİNİ Güncelle SON ///////////////////////////////////////////*/
                            /* TÜR 4 İÇİN Ek Varyant İÇERİĞİNİ Güncelle ///////////////////////////////////////////*/
                            $ekvaryantFor = $db->prepare("select * from detay_varyant where urun_id=:urun_id and tur=:tur ");
                            $ekvaryantFor->execute(array(
                                'urun_id' => $urun_id,
                                'tur' => '4'
                            ));
                            if($ekvaryantFor->rowCount()> '0'  ) {
                                foreach ($ekvaryantFor as $ekvarfor) {
                                    $ekVaryant = $db->prepare("select * from urun_varyant_ekler where sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id");
                                    $ekVaryant->execute(array(
                                        'sepet_id' => $varsepet['sepetno'],
                                        'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].'']
                                    ));
                                    $ekvar = $ekVaryant->fetch(PDO::FETCH_ASSOC);
                                    if($ekVaryant->rowCount() >'0'  ) {
                                        if($_POST['ek_var'.$ekvarfor['id'].''] == null ) {
                                            $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE sepet_id=:sepet_id");
                                            $silmeislem->execute(array(
                                                'sepet_id' => $varsepet['sepetno']
                                            ));
                                        }else{
                                            $guncelle = $db->prepare("UPDATE urun_varyant_ekler SET
                                                         icerik=:icerik
                                                  WHERE sepet_id={$varsepet['sepetno']}
                                                 ");
                                            $sonuc = $guncelle->execute(array(
                                                'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].'']))
                                            ));
                                        }
                                    }else{
                                        $kaydet = $db->prepare("INSERT INTO urun_varyant_ekler SET
                                                 urun_id=:urun_id,
                                                 ip_adres=:ip_adres,
                                                 detay_ozellik_id=:detay_ozellik_id,
                                                 icerik=:icerik,
                                                 sepet_id=:sepet_id
                                            ");
                                        $sonuc = $kaydet->execute(array(
                                            'urun_id' => $urun_id,
                                            'ip_adres' => $ip,
                                            'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].''],
                                            'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].''])),
                                            'sepet_id' => $varsepet['sepetno']
                                        ));
                                    }
                                }
                            }
                            /* TÜR 4 İÇİN Ek Varyant İÇERİĞİNİ Güncelle SON ///////////////////////////////////////////*/
                            $guncelle = $db->prepare("UPDATE sepet SET
                                  adet=:adet
                           WHERE sepetno={$varsepet['sepetno']}      
                          ");
                            $sonuc = $guncelle->execute(array(
                                'adet' => $varsepet['adet']+$adet
                            ));
                            if($sonuc){
                                unset($_SESSION['siparis_islem_id']);
                                if($odemeayar['sepet_href'] == '0' ) {
                                    $_SESSION['addtocart'] = 'success';
                                    header('Location:'.$sesurun_adres.'');
                                }
                                if($odemeayar['sepet_href'] == '1' ) {
                                    $_SESSION['addtocart'] = 'modalsuccess';
                                    $_SESSION['adetdetay'] = $adet;
                                    header('Location:'.$sesurun_adres.'');
                                }
                                if($odemeayar['sepet_href'] == '2' ) {
                                    header('Location:'.$siteurl.'sepet/');
                                }
                            }else{
                                $_SESSION['dberror'] = 'dberror';
                                header('Location:'.$siteurl.'404');
                            }
                            /* ANAÜRÜN STOKUNA GÖRE!!!!->Sepetteki ürünün adet sayısı + yeni eklenen adetin sayısının toplamı stok değerine eşit veya kücükse işlem yap SON */
                        }else{
                            $_SESSION['addtocart'] = 'nomorestok';
                            header('Location:'.$sesurun_adres.'');
                        }
                    }

                    /* Evet Eklemiş SON *//////////////////
                }else{
                    /* Hayır! Sepete bu seçenekli ürün eklememiş. Yeni SIFIRDAN Ekle *////////////////////

                    if($varyantStokKontrol->rowCount()>'0'  ) {
                        /* Varyant Kombinasyonlarının Stok Değerini baz al! */

                        if($varyantStokSayi>'0' ) {

                            if($varyantStokSayi >= $adet  ) {

                                /////////////////////* Tür 2 Varyant varsa içeriğini db'ye aktar ///////////////////////////////////////////*/
                                $ekvaryantFor = $db->prepare("select * from detay_varyant where urun_id=:urun_id and tur=:tur ");
                                $ekvaryantFor->execute(array(
                                    'urun_id' => $urun_id,
                                    'tur' => '2'
                                ));
                                if($ekvaryantFor->rowCount()> '0'  ) {
                                    foreach ($ekvaryantFor as $ekvarfor) {
                                        if($_POST['ek_var'.$ekvarfor['id'].''] == !null  ) {
                                            $kaydet = $db->prepare("INSERT INTO urun_varyant_ekler SET
                                                 urun_id=:urun_id,
                                                 ip_adres=:ip_adres,
                                                 detay_ozellik_id=:detay_ozellik_id,
                                                 icerik=:icerik,
                                                 sepet_id=:sepet_id
                                            ");
                                            $sonuc = $kaydet->execute(array(
                                                'urun_id' => $urun_id,
                                                'ip_adres' => $ip,
                                                'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].''],
                                                'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].''])),
                                                'sepet_id' => $rand
                                            ));
                                        }
                                    }
                                }
                                /////////////////////* Tür 2 Varyant varsa içeriğini db'ye aktar SON ///////////////////////////////////////////*/
                                ///
                                /////////////////////* Tür 4 Varyant varsa içeriğini db'ye aktar ///////////////////////////////////////////*/
                                $ekvaryantFor = $db->prepare("select * from detay_varyant where urun_id=:urun_id and tur=:tur ");
                                $ekvaryantFor->execute(array(
                                    'urun_id' => $urun_id,
                                    'tur' => '4'
                                ));
                                if($ekvaryantFor->rowCount()> '0'  ) {
                                    foreach ($ekvaryantFor as $ekvarfor) {
                                        if($_POST['ek_var'.$ekvarfor['id'].''] == !null  ) {
                                            $kaydet = $db->prepare("INSERT INTO urun_varyant_ekler SET
                                                 urun_id=:urun_id,
                                                 ip_adres=:ip_adres,
                                                 detay_ozellik_id=:detay_ozellik_id,
                                                 icerik=:icerik,
                                                 sepet_id=:sepet_id
                                            ");
                                            $sonuc = $kaydet->execute(array(
                                                'urun_id' => $urun_id,
                                                'ip_adres' => $ip,
                                                'detay_ozellik_id' => $_POST['var'.$ekvarfor['id'].''],
                                                'icerik' => trim(strip_tags($_POST['ek_var'.$ekvarfor['id'].''])),
                                                'sepet_id' => $rand
                                            ));
                                        }
                                    }
                                }
                                /////////////////////* Tür 4 Varyant varsa içeriğini db'ye aktar SON ///////////////////////////////////////////*/
                                if($uyefiyat > '0'  ) {
                                    $uyefiyat= $uyefiyat+$varyant_ozellik_ek_fiyat;
                                }else{
                                    $uyefiyat= $uyefiyat;
                                }
                                /* VARYANT STOK KONTROLLÜ -> Ürünü ve seçeneklerini db'ye aktarma işlemi */
                                $kaydet = $db->prepare("INSERT INTO sepet SET
                                                  urun_id=:urun_id,  
                                                  uye_id=:uye_id,
                                                  sepetno=:sepetno,
                                                  ip=:ip,
                                                  fiyat=:fiyat,
                                                  fiyat_2=:fiyat_2,
                                                  uye_ozel_fiyat=:uye_ozel_fiyat,
                                                  ek_fiyat_tekil=:ek_fiyat_tekil,
                                                  kdv_durum=:kdv_durum,
                                                  kdvsiz_fiyat=:kdvsiz_fiyat,
                                                  kdv_tutar=:kdv_tutar,
                                                  kargo_tutar=:kargo_tutar,
                                                  havale_fiyat=:havale_fiyat,
                                                  varyant=:varyant,
                                                  adet=:adet,
                                                  taksit=:taksit,
                                                  varyant_stok_durum=:varyant_stok_durum,
                                                  sepet_durum=:sepet_durum
                                            ");
                                $sonuc = $kaydet->execute(array(
                                    'urun_id' => $urun_id,
                                    'uye_id' => $uye_id,
                                    'sepetno' => $rand,
                                    'ip' => $ip,
                                    'fiyat' => $fiyat+$varyant_ozellik_ek_fiyat,
                                    'fiyat_2' => $uyefiyat,
                                    'uye_ozel_fiyat' => $uyeyeozelfiyat,
                                    'ek_fiyat_tekil' => $varyant_ozellik_ek_fiyat,
                                    'kdv_durum' => $kdv_durumu,
                                    'kdvsiz_fiyat' => $urunun_kdvsiz_fiyati,
                                    'kdv_tutar' => $urunun_kdv_si,
                                    'kargo_tutar' => $kargo_tut,
                                    'havale_fiyat' => $havale_tut,
                                    'varyant' => $varyantsecenekleri,
                                    'adet' => $adet,
                                    'taksit' => $urun['taksit'],
                                    'varyant_stok_durum' => '1',
                                    'sepet_durum' => '1'
                                ));
                                if($sonuc){
                                    unset($_SESSION['siparis_islem_id']);
                                    if($odemeayar['sepet_href'] == '0' ) {
                                        $_SESSION['addtocart'] = 'success';
                                        header('Location:'.$sesurun_adres.'');
                                    }
                                    if($odemeayar['sepet_href'] == '1' ) {
                                        $_SESSION['addtocart'] = 'modalsuccess';
                                        $_SESSION['adetdetay'] = $adet;
                                        header('Location:'.$sesurun_adres.'');
                                    }
                                    if($odemeayar['sepet_href'] == '2' ) {
                                        header('Location:'.$siteurl.'sepet/');
                                    }
                                }else{
                                    $_SESSION['dberror'] = 'dberror';
                                    header('Location:'.$siteurl.'404');
                                }
                                /* VARYANT STOK KONTROLLÜ -> Ürünü ve seçeneklerini db'ye aktarma işlemi SON */


                            }else{
                                $_SESSION['addtocart'] = 'nomorestok';
                                header('Location:'.$sesurun_adres.'');
                            }
                        }else{
                            $_SESSION['addtocart'] = 'nostok';
                            header('Location:'.$sesurun_adres.'');
                        }

                        /* Varyant Kombinasyonlarının Stok Değerini baz al! SON */
                    }else{
                        /* Ana ürünün stok sayısını baz al! */
                        if($urunstok > '0'  ) {

                            if($urunstok >= $anaurunToplamAdetSayisi) {

                                /////////////////////* Tür 2 Varyant varsa içeriğini db'ye aktar ///////////////////////////////////////////*/
                                $ekvaryantFor = $db->prepare("select * from detay_varyant where urun_id=:urun_id and tur=:tur ");
                                $ekvaryantFor->execute(array(
                                    'urun_id' => $urun_id,
                                    'tur' => '2'
                                ));
                                if($ekvaryantFor->rowCount()> '0'  ) {
                                    foreach ($ekvaryantFor as $ekvarfor) {
                                        if($_POST['ek_var'.$ekvarfor['id'].''] == !null  ) {
                                            $kaydet = $db->prepare("INSERT INTO urun_varyant_ekler SET
                                                 urun_id=:urun_id,
                                                 ip_adres=:ip_adres,
                                                 detay_ozellik_id=:detay_ozellik_id,
                                                 icerik=:icerik,
                                                 sepet_id=:sepet_id
                                            ");
                                            $sonuc = $kaydet->execute(array(
                                                'urun_id' => $urun_id,
                                                'ip_adres' => $ip,
                                                'detay_ozellik_id' => $_POST['var' . $ekvarfor['id'] . ''],
                                                'icerik' => trim(strip_tags($_POST['ek_var' . $ekvarfor['id'] . ''])),
                                                'sepet_id' => $rand
                                            ));
                                        }
                                    }
                                }
                                /////////////////////* Tür 2 Varyant varsa içeriğini db'ye aktar SON ///////////////////////////////////////////*/
                                /////////////////////* Tür 4 Varyant varsa içeriğini db'ye aktar ///////////////////////////////////////////*/
                                $ekvaryantFor = $db->prepare("select * from detay_varyant where urun_id=:urun_id and tur=:tur ");
                                $ekvaryantFor->execute(array(
                                    'urun_id' => $urun_id,
                                    'tur' => '4'
                                ));
                                if($ekvaryantFor->rowCount()> '0'  ) {
                                    foreach ($ekvaryantFor as $ekvarfor) {
                                        if($_POST['ek_var'.$ekvarfor['id'].''] == !null  ) {
                                            $kaydet = $db->prepare("INSERT INTO urun_varyant_ekler SET
                                                 urun_id=:urun_id,
                                                 ip_adres=:ip_adres,
                                                 detay_ozellik_id=:detay_ozellik_id,
                                                 icerik=:icerik,
                                                 sepet_id=:sepet_id
                                            ");
                                            $sonuc = $kaydet->execute(array(
                                                'urun_id' => $urun_id,
                                                'ip_adres' => $ip,
                                                'detay_ozellik_id' => $_POST['var' . $ekvarfor['id'] . ''],
                                                'icerik' => trim(strip_tags($_POST['ek_var' . $ekvarfor['id'] . ''])),
                                                'sepet_id' => $rand
                                            ));
                                        }
                                    }
                                }
                                /////////////////////* Tür 4 Varyant varsa içeriğini db'ye aktar SON ///////////////////////////////////////////*/


                                if($uyefiyat > '0'  ) {
                                    $uyefiyat= $uyefiyat+$varyant_ozellik_ek_fiyat;
                                }else{
                                    $uyefiyat= $uyefiyat;
                                }
                                /* ANAÜRÜN STOK KONTROLÜ  STOKUNA GÖRE -> Ürünü ve seçeneklerini db'ye aktarma işlemi */
                                $kaydet = $db->prepare("INSERT INTO sepet SET
                                                  urun_id=:urun_id,  
                                                  uye_id=:uye_id,
                                                  sepetno=:sepetno,
                                                  ip=:ip,
                                                  fiyat=:fiyat,
                                                  fiyat_2=:fiyat_2,
                                                  uye_ozel_fiyat=:uye_ozel_fiyat,
                                                  ek_fiyat_tekil=:ek_fiyat_tekil,
                                                  kdv_durum=:kdv_durum,
                                                  kdvsiz_fiyat=:kdvsiz_fiyat,
                                                  kdv_tutar=:kdv_tutar,
                                                  kargo_tutar=:kargo_tutar,
                                                  havale_fiyat=:havale_fiyat,
                                                  varyant=:varyant,
                                                  adet=:adet,
                                                  taksit=:taksit,
                                                  varyant_stok_durum=:varyant_stok_durum,
                                                  sepet_durum=:sepet_durum
                                            ");
                                $sonuc = $kaydet->execute(array(
                                    'urun_id' => $urun_id,
                                    'uye_id' => $uye_id,
                                    'sepetno' => $rand,
                                    'ip' => $ip,
                                    'fiyat' => $fiyat+$varyant_ozellik_ek_fiyat,
                                    'fiyat_2' => $uyefiyat,
                                    'uye_ozel_fiyat' => $uyeyeozelfiyat,
                                    'ek_fiyat_tekil' => $varyant_ozellik_ek_fiyat,
                                    'kdv_durum' => $kdv_durumu,
                                    'kdvsiz_fiyat' => $urunun_kdvsiz_fiyati,
                                    'kdv_tutar' => $urunun_kdv_si,
                                    'kargo_tutar' => $kargo_tut,
                                    'havale_fiyat' => $havale_tut+$varyant_ozellik_ek_fiyat,
                                    'varyant' => $varyantsecenekleri,
                                    'adet' => $adet,
                                    'taksit' => $urun['taksit'],
                                    'varyant_stok_durum' => '0',
                                    'sepet_durum' => '1'
                                ));
                                if($sonuc){
                                    unset($_SESSION['siparis_islem_id']);
                                    if($odemeayar['sepet_href'] == '0' ) {
                                        $_SESSION['addtocart'] = 'success';
                                        header('Location:'.$sesurun_adres.'');
                                    }
                                    if($odemeayar['sepet_href'] == '1' ) {
                                        $_SESSION['addtocart'] = 'modalsuccess';
                                        $_SESSION['adetdetay'] = $adet;
                                        header('Location:'.$sesurun_adres.'');
                                    }
                                    if($odemeayar['sepet_href'] == '2' ) {
                                        header('Location:'.$siteurl.'sepet/');
                                    }
                                }else{
                                    $_SESSION['dberror'] = 'dberror';
                                    header('Location:'.$siteurl.'404');
                                }
                                /* ANAÜRÜN STOK KONTROLÜ  STOKUNA GÖRE -> Ürünü ve seçeneklerini db'ye aktarma işlemi SON */

                            }else{
                                $_SESSION['addtocart'] = 'nomorestok';
                                header('Location:'.$sesurun_adres.'');
                            }
                        }else{
                            $_SESSION['addtocart'] = 'nostok';
                            header('Location:'.$sesurun_adres.'');
                        }
                        /* Ana ürünün stok sayısını baz al! SON */
                    }

                    /* Hayır! Sepete bu seçenekli ürün eklememiş. Yeni Ekle SON *////////////////////



                }
                /* Bu ürünü müşteri sepete daha önce eklemiş mi? SON */

            }
            /////////////////////////* Varyantlı ürünü sepete ekleme SON ///////////////////////////////////////////*/
            ///
            ///
            ///


            else{
                /////////////////////////* Varyantsız ürünü ekleme işlemleri ///////////////////////////////////////////*/
                ///
                ///
                $varyantSizUrunSepetKontrol = $db->prepare("select * from sepet where urun_id=:urun_id and ip=:ip");
                $varyantSizUrunSepetKontrol->execute(array(
                    'urun_id' => $urun_id,
                    'ip' => $ip
                ));
                $varsizsepet = $varyantSizUrunSepetKontrol->fetch(PDO::FETCH_ASSOC);

                if($varyantSizUrunSepetKontrol->rowCount() >'0'  ) {

                    /* Daha önce eklenmiş var */

                    /* Varyantsiz Sepetteki aynı ürünlerin adet sayısı */
                    $varsizUrunAdetSayisi = $db->prepare("SELECT SUM(adet) AS geneladet FROM sepet where urun_id=:urun_id and ip=:ip ");
                    $varsizUrunAdetSayisi->execute(array(
                        'urun_id' => $urun_id,
                        'ip' => $ip
                    ));
                    $varsizurunsay = $varsizUrunAdetSayisi->fetch(PDO::FETCH_ASSOC);
                    $varsizurunadetleritoplam = $varsizurunsay['geneladet'] + $adet ;
                    /* Varyantsiz Sepetteki aynı ürünlerin adet sayısı */


                    if($urunstok >= $varsizurunadetleritoplam  ) {

                        $guncelle = $db->prepare("UPDATE sepet SET
                                  adet=:adet
                                WHERE sepetno={$varsizsepet['sepetno']}      
                          ");
                        $sonuc = $guncelle->execute(array(
                            'adet' => $varsizsepet['adet']+$adet
                        ));
                        if($sonuc){
                            unset($_SESSION['siparis_islem_id']);
                            if($odemeayar['sepet_href'] == '0' ) {
                                $_SESSION['addtocart'] = 'success';
                                header('Location:'.$sesurun_adres.'');
                            }
                            if($odemeayar['sepet_href'] == '1' ) {
                                $_SESSION['addtocart'] = 'modalsuccess';
                                $_SESSION['adetdetay'] = $varsizsepet['adet']+$adet;
                                header('Location:'.$sesurun_adres.'');
                            }
                            if($odemeayar['sepet_href'] == '2' ) {
                                header('Location:'.$siteurl.'sepet/');
                            }
                        }else{
                            $_SESSION['dberror'] = 'dberror';
                            header('Location:'.$siteurl.'404');
                        }


                    }else{

                        $_SESSION['addtocart'] = 'nomorestok';
                        header('Location:'.$sesurun_adres.'');

                    }



                    /* Daha önce eklenmiş var SON */

                }else{


                    /* Hiç eklenmemiş! SIFIRDAN EKLE */
                    if($urunstok > '0'  ) {


                        if($urunstok >= $adet  ) {

                            $kaydet = $db->prepare("INSERT INTO sepet SET
                                                  urun_id=:urun_id,  
                                                  uye_id=:uye_id,
                                                  sepetno=:sepetno,
                                                  ek_fiyat=:ek_fiyat,
                                                  ek_fiyat_tekil=:ek_fiyat_tekil,
                                                  kdv_durum=:kdv_durum,
                                                  kdvsiz_fiyat=:kdvsiz_fiyat,
                                                  kdv_tutar=:kdv_tutar,
                                                  ip=:ip,
                                                  kargo_tutar=:kargo_tutar,
                                                  fiyat=:fiyat,
                                                  fiyat_2=:fiyat_2,
                                                  uye_ozel_fiyat=:uye_ozel_fiyat,
                                                  havale_fiyat=:havale_fiyat,
                                                  varyant=:varyant,
                                                  adet=:adet,
                                                  varyant_stok_durum=:varyant_stok_durum,
                                                  taksit=:taksit,
                                                  sepet_durum=:sepet_durum
                                            ");
                            $sonuc = $kaydet->execute(array(
                                'urun_id' => $urun_id,
                                'uye_id' => $uye_id,
                                'sepetno' => $rand,
                                'ek_fiyat' => '0',
                                'ek_fiyat_tekil' => '0',
                                'kdv_durum' => $kdv_durumu,
                                'kdvsiz_fiyat' => $urunun_kdvsiz_fiyati,
                                'kdv_tutar' => $urunun_kdv_si,
                                'ip' => $ip,
                                'kargo_tutar' => $kargo_tut,
                                'fiyat' => $fiyat,
                                'fiyat_2' => $uyefiyat,
                                'uye_ozel_fiyat' => $uyeyeozelfiyat,
                                'havale_fiyat' => $havale_tut,
                                'varyant' => 0,
                                'adet' => $adet,
                                'varyant_stok_durum' => '0',
                                'taksit' => $urun['taksit'],
                                'sepet_durum' => '1'
                            ));
                            if($sonuc){
                                unset($_SESSION['siparis_islem_id']);
                                if($odemeayar['sepet_href'] == '0' ) {
                                    $_SESSION['addtocart'] = 'success';
                                    header('Location:'.$sesurun_adres.'');
                                }
                                if($odemeayar['sepet_href'] == '1' ) {
                                    $_SESSION['addtocart'] = 'modalsuccess';
                                    $_SESSION['adetdetay'] = $adet;
                                    header('Location:'.$sesurun_adres.'');
                                }
                                if($odemeayar['sepet_href'] == '2' ) {
                                    header('Location:'.$siteurl.'sepet/');
                                }
                            }else{
                                $_SESSION['dberror'] = 'dberror';
                                header('Location:'.$siteurl.'404');
                            }
                        }else{
                            $_SESSION['addtocart'] = 'nomorestok';
                            header('Location:'.$sesurun_adres.'');
                        }
                    }else{
                        $_SESSION['addtocart'] = 'nostok';
                        header('Location:'.$sesurun_adres.'');
                    }
                    /* Hiç eklenmemiş! SIFIRDAN EKLE SON */

                }




            }
            /////////////////////////* Varyantsız ürünü ekleme işlemleri SON ///////////////////////////////////////////*/
            ///
            ///
            ///

        }else {
            header('Location:'.$siteurl.'404');
        }
    }else{
        $_SESSION['addtocart'] = 'empty';
        header('Location:'.$sesurun_adres.'');
    }
}else{
    $_SESSION['addtocart'] = 'empty';
    header('Location:'.$sesurun_adres.'');
}

?>