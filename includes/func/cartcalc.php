<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
//todo ioncube
$ipnedir= $_SERVER["REMOTE_ADDR"];
/* Onaysız Ürünler İçin Güncellemeler */
$OnaySepetSorgusuPasif = $db->prepare("select * from sepet where ip=:ip");
$OnaySepetSorgusuPasif->execute(array(
    'ip' => $ipnedir
));
foreach ($OnaySepetSorgusuPasif as $onaysizsepet) {

    $OnaysizSepetUrunuCekelimc = $db->prepare("select * from urun where id=:id ");
    $OnaysizSepetUrunuCekelimc->execute(array(
        'id' => $onaysizsepet['urun_id']
    ));
    $onaysizSepUrun = $OnaysizSepetUrunuCekelimc->fetch(PDO::FETCH_ASSOC);

    /* Ufak bir durum güncellemesi ///////////////////////////////////////////*/
        if($OnaySepetSorgusuPasif->rowCount()>'0' && $onaysizSepUrun['durum'] == '1'  ) {
            if($onaysizSepUrun['stok'] > '0' ) {

                if($onaysizsepet['varyant_stok_durum'] == '0' ) {
                    if($onaysizsepet['adet'] <= $onaysizSepUrun['stok']  ) {
                        $zeasdsa = $db->prepare("UPDATE sepet SET
                         sepet_durum=:sepet_durum
                          WHERE sepetno={$onaysizsepet['sepetno']}      
                         ");
                        $asassaasddas = $zeasdsa->execute(array(
                            'sepet_durum' => '1'
                        ));
                    }else{
                        $zeasdsa = $db->prepare("UPDATE sepet SET
                         sepet_durum=:sepet_durum
                  WHERE sepetno={$onaysizsepet['sepetno']}      
                 ");
                        $asassaasddas = $zeasdsa->execute(array(
                            'sepet_durum' => '0'
                        ));
                    }
                }

                if($onaysizsepet['varyant_stok_durum'] == '1' ) {

                    $varyantStokBilgisi = $db->prepare("select * from detay_varyant_stok where urun_id=:urun_id and varyant=:varyant ");
                    $varyantStokBilgisi->execute(array(
                        'urun_id' => $onaysizsepet['urun_id'],
                        'varyant' => $onaysizsepet['varyant']
                    ));
                    $varStokCek = $varyantStokBilgisi->fetch(PDO::FETCH_ASSOC);

                    if($onaysizsepet['adet'] <= $varStokCek['stok']  ) {
                        $zeasdsa = $db->prepare("UPDATE sepet SET
                         sepet_durum=:sepet_durum
                          WHERE sepetno={$onaysizsepet['sepetno']}      
                         ");
                        $asassaasddas = $zeasdsa->execute(array(
                            'sepet_durum' => '1'
                        ));
                    }else{
                        $zeasdsa = $db->prepare("UPDATE sepet SET
                         sepet_durum=:sepet_durum
                  WHERE sepetno={$onaysizsepet['sepetno']}      
                 ");
                        $asassaasddas = $zeasdsa->execute(array(
                            'sepet_durum' => '0'
                        ));
                    }

                }

            }else{
                $zeasdsa = $db->prepare("UPDATE sepet SET
                         sepet_durum=:sepet_durum
                  WHERE sepetno={$onaysizsepet['sepetno']}      
                 ");
                $asassaasddas = $zeasdsa->execute(array(
                    'sepet_durum' => '0'
                ));
            }
        }else{
            $zeasdsa = $db->prepare("UPDATE sepet SET
                         sepet_durum=:sepet_durum
                  WHERE sepetno={$onaysizsepet['sepetno']}      
                 ");
            $asassaasddas = $zeasdsa->execute(array(
                'sepet_durum' => '0'
            ));
        }
    /* Ufak bir durum güncellemesi SON ///////////////////////////////////////////*/


    /* varyant Stok Durumu Güncellemesi */
    $varyntStokDurumSorgusu = $db->prepare("select * from detay_varyant_stok where urun_id=:urun_id and varyant=:varyant ");
    $varyntStokDurumSorgusu->execute(array(
        'urun_id' => $onaysizsepet['urun_id'],
        'varyant' => $onaysizsepet['varyant']
    ));
    if($varyntStokDurumSorgusu->rowCount()>'0'  ) {
        $guncelle2 = $db->prepare("UPDATE sepet SET
                   varyant_stok_durum=:varyant_stok_durum
            WHERE sepetno={$onaysizsepet['sepetno']}      
           ");
        $sonuc = $guncelle2->execute(array(
            'varyant_stok_durum' => '1'
        ));
    }else{
        $guncelle2 = $db->prepare("UPDATE sepet SET
                   varyant_stok_durum=:varyant_stok_durum
            WHERE sepetno={$onaysizsepet['sepetno']}      
           ");
        $sonuc = $guncelle2->execute(array(
            'varyant_stok_durum' => '0'
        ));
    }
    /* varyant Stok Durumu Güncellemesi SON */

    /* Sepet itemi Üye Kontrolü */
    if($userSorgusu->rowCount()>'0' ) {
        $guncelle4 = $db->prepare("UPDATE sepet SET
                uye_id=:uye_id
                WHERE sepetno={$onaysizsepet['sepetno']}      
                ");
        $sonuc = $guncelle4->execute(array(
            'uye_id' => $userCek['id']
        ));
        $sepetuyesi = $userCek['id'];
    }else{
        $guncelle4 = $db->prepare("UPDATE sepet SET
                uye_id=:uye_id
                WHERE sepetno={$onaysizsepet['sepetno']}      
                ");
        $sonuc = $guncelle4->execute(array(
            'uye_id' => null
        ));
        $sepetuyesi = null;
    }
    /* Sepet itemi Üye Kontrolü SON */

    /* Taksit Durumu Güncelle */
    $guncelleTaksit = $db->prepare("UPDATE sepet SET
                taksit=:taksit
         WHERE sepetno={$onaysizsepet['sepetno']}      
        ");
    $sonuc = $guncelleTaksit->execute(array(
        'taksit' => $onaysizSepUrun['taksit']
    ));
    /* Taksit Durumu Güncelle SON */



}
/* Onaysız Ürünler İçin Güncellemeler SON --------------------------------------------------------------------*/



/////////////////////////* ONAYLI ÜRÜNLER HESAPLARI ///////////////////////////////////////////*/
$OnaySepetSorgusu = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum");
$OnaySepetSorgusu->execute(array(
    'ip' => $ipnedir,
    'sepet_durum' => '1',
)); 
$aratoplam=0;
$kdvtoplami=0;
$kargohesabi=0;
$kargotoplami=0;
$varyantfiyat=0;
$varyantekfiyattoplami=0;
$toplamodenecektutar=0;
$havale_aratoplam = 0;
$havale_kdvtoplam = 0;
$havale_odenecek_tutar = 0;
 if($OnaySepetSorgusu->rowCount()>'0'  ) {

    foreach ($OnaySepetSorgusu as $onaysepet){


        $OnayIcinUrunCek = $db->prepare("select * from urun where id=:id and durum=:durum ");
        $OnayIcinUrunCek->execute(array(
            'id' => $onaysepet['urun_id'],
            'durum' => '1'
        ));
        $onayurun = $OnayIcinUrunCek->fetch(PDO::FETCH_ASSOC);

        $onayadet = $onaysepet['adet'];
        $onaykdvoran = $onayurun['kdv_oran'];


        /////////////////////////* Varyant ek fiyatları hesapla ///////////////////////////////////////////*/
        $varyantekfiyattoplami_tekilCalc = 0;
        if($onaysepet['varyant'] == !null || $onaysepet['varyant'] > '0') {
            $varyantayirCalc = $onaysepet['varyant'];
            $varyantayirCalc = explode(',', $varyantayirCalc);
            foreach ($varyantayirCalc as $varcalckey) {
                if($varcalckey !='' ) {
                    $varyantOzellikCekelimCalc = $db->prepare("select * from detay_varyant_ozellik where id=:id and urun_id=:urun_id ");
                    $varyantOzellikCekelimCalc->execute(array(
                        'id' => $varcalckey,
                        'urun_id' => $onaysepet['urun_id']
                    ));
                    if($varyantOzellikCekelimCalc->rowCount()>'0'  ) {
                        foreach ($varyantOzellikCekelimCalc as $varyantozellikcalc) {
                            $calc_var_ek_fiyat = $varyantozellikcalc['ek_fiyat'];
                            $varyantGrubuCekCalc = $db->prepare("select * from detay_varyant where urun_id=:urun_id and varyant_id=:varyant_id ");
                            $varyantGrubuCekCalc->execute(array(
                                'urun_id' => $onaysepet['urun_id'],
                                'varyant_id' => $varyantozellikcalc['varyant_id']
                            ));
                            $vargrubuCalc = $varyantGrubuCekCalc->fetch(PDO::FETCH_ASSOC);
                            if($vargrubuCalc['tur'] == '2' ) {
                                $varyantEkCekCalc = $db->prepare("select * from urun_varyant_ekler where urun_id=:urun_id and sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id order by id desc limit 1 ");
                                $varyantEkCekCalc->execute(array(
                                    'urun_id' => $onaysepet['urun_id'],
                                    'sepet_id' => $onaysepet['sepetno'],
                                    'detay_ozellik_id' => $varyantozellikcalc['id']
                                ));
                                $varyanteki = $varyantEkCekCalc->fetch(PDO::FETCH_ASSOC);
                                if($varyantEkCekCalc->rowCount()>'0') {

                                }else{
                                    $calc_var_ek_fiyat = 0;
                                }
                            }
                            if($vargrubuCalc['tur'] == '4' ) {
                                $varyantEkCekCalc = $db->prepare("select * from urun_varyant_ekler where urun_id=:urun_id and sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id order by id desc limit 1 ");
                                $varyantEkCekCalc->execute(array(
                                    'urun_id' => $onaysepet['urun_id'],
                                    'sepet_id' => $onaysepet['sepetno'],
                                    'detay_ozellik_id' => $varyantozellikcalc['id']
                                ));
                                $varyanteki = $varyantEkCekCalc->fetch(PDO::FETCH_ASSOC);
                                if($varyantEkCekCalc->rowCount()>'0') {

                                }else{
                                    $calc_var_ek_fiyat = 0;
                                }
                            }
                            /* Varyant Ek Fiyatlar Toplaması */
                            $varyantekfiyattoplami_tekilCalc = $varyantekfiyattoplami_tekilCalc + ($calc_var_ek_fiyat);
                            /* Varyant Ek Fiyatlar Toplaması SON */
                        }
                    }
                }
            }

        }

        /* varyant ek fiyatları sepette güncelle */
        if($varyantekfiyattoplami_tekilCalc >'0'  ) {
            $ekfiyatekleguncelle = $db->prepare("UPDATE sepet SET
                     ek_fiyat=:ek_fiyat,
                     ek_fiyat_tekil=:ek_fiyat_tekil     
                 WHERE sepetno={$onaysepet['sepetno']}      
              ");
            $ekfiyatekleguncelle->execute(array(
                'ek_fiyat' => ($varyantekfiyattoplami_tekilCalc )* $onaysepet['adet'],
                'ek_fiyat_tekil' => $varyantekfiyattoplami_tekilCalc
            ));
        }else{
            $ekfiyatekleguncelle = $db->prepare("UPDATE sepet SET
                 ek_fiyat=:ek_fiyat,
                 ek_fiyat_tekil=:ek_fiyat_tekil       
                WHERE sepetno={$onaysepet['sepetno']}      
             ");
            $ekfiyatekleguncelle->execute(array(
                'ek_fiyat' => '0',
                'ek_fiyat_tekil' => '0'
            ));
        }
        /* varyant ek fiyatları sepette güncelle SON */

        /////////////////////////* Varyant ek fiyatları hesapla SON ///////////////////////////////////////////*/
        ///
        ///
        ///


        /////////////////////////* KDVSİZ Fiyatı Ortaya Çıkar ///////////////////////////////////////////*/
        /* Bu üründe kdv olayı kapalıysa */
        if($onayurun['kdv'] == '0' ) {

            if($userSorgusu->rowCount()>'0'  ) {
                if($uyegruplariCek->rowCount() >'0'  ) {
                    if($uyegrup['fiyat_tip'] == '0'  ) {
                        $onayfiyat = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                    }
                    if($uyegrup['fiyat_tip'] == '1'  ) {
                        if($onayurun['fiyat_tip2'] == !null && $onayurun['fiyat_tip2'] > '0'  ) {
                            $onayfiyat = $onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc;
                        }else{
                            $onayfiyat = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                        }
                    }
                }else{
                    $onayfiyat = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                }
            }else{
                $onayfiyat = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
            }


        }
        /* Bu üründe kdv olayı kapalıysa SON */

        /* Bu üründe + kdv varsa */
        if($onayurun['kdv'] == '1' ) {

            if($userSorgusu->rowCount()>'0'  ) {
                if($uyegruplariCek->rowCount() >'0'  ) {
                    if($uyegrup['fiyat_tip'] == '0'  ) {
                        $onayfiyat = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                    }
                    if($uyegrup['fiyat_tip'] == '1'  ) {
                        if($onayurun['fiyat_tip2'] == !null && $onayurun['fiyat_tip2'] > '0'  ) {
                            $onayfiyat = $onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc;
                        }else{
                            $onayfiyat = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                        }
                    }
                }else{
                    $onayfiyat = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                }
            }else{
                $onayfiyat = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
            }

        }
        /* Bu üründe + kdv varsa SON */

        /* Bu ürün kdv dahil ise kdvsiz fiyat olarak ayarla */
        if($onayurun['kdv'] == '2' ) {
            if($userSorgusu->rowCount()>'0'  ) {
                if($uyegruplariCek->rowCount() >'0'  ) {
                    if($uyegrup['fiyat_tip'] == '0'  ) {
                        $onayfiyat = kdvcikar($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,$onayurun['kdv_oran']);
                    }
                    if($uyegrup['fiyat_tip'] == '1'  ) {
                        if($onayurun['fiyat_tip2'] == !null && $onayurun['fiyat_tip2'] > '0'  ) {
                            $onayfiyat = kdvcikar($onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc,$onayurun['kdv_oran']);
                        }else{
                            $onayfiyat = kdvcikar($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,$onayurun['kdv_oran']);
                        }
                    }
                }else{
                    $onayfiyat = kdvcikar($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,$onayurun['kdv_oran']);
                }
            }else{
                $onayfiyat = kdvcikar($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,$onayurun['kdv_oran']);
            }
        }
        /* Bu ürün kdv dahil ise kdvsiz fiyat olarak ayarla SON */
        /////////////////////////* KDVSİZ Fiyatı Ortaya Çıkar SON ///////////////////////////////////////////*/
        ///
        ///
        ///


        /* KDVleri Hesaplayalım */
        if($onayurun['kdv'] == '0' ) {
            $kdvtutar = 0;
            $kdvsepetguncelle = $db->prepare("UPDATE sepet SET
                 kdvsiz_fiyat=:kdvsiz_fiyat,
                 kdv_tutar=:kdv_tutar,
                 kdv_durum=:kdv_durum     
              WHERE sepetno={$onaysepet['sepetno']}      
             ");
            $kdvsepetguncelle->execute(array(
                'kdvsiz_fiyat' => $onayfiyat,
                'kdv_tutar' => '0',
                'kdv_durum' => '0'
            ));
        }
        if($onayurun['kdv'] == '1' ) {
            $kdvtutar = kdvhesapla($onayfiyat,$onayurun['kdv_oran']);
            $kdvsepetguncelle = $db->prepare("UPDATE sepet SET
                 kdvsiz_fiyat=:kdvsiz_fiyat,
                 kdv_tutar=:kdv_tutar,
                 kdv_durum=:kdv_durum
              WHERE sepetno={$onaysepet['sepetno']}
             ");
            $kdvsepetguncelle->execute(array(
                'kdvsiz_fiyat' => $onayfiyat,
                'kdv_tutar' => $kdvtutar,
                'kdv_durum' => '1'
            ));
        }
        if($onayurun['kdv'] == '2' ) {
            $kdvtutar = kdvhesapla($onayfiyat,$onayurun['kdv_oran']);
            $kdvsepetguncelle = $db->prepare("UPDATE sepet SET
                  kdvsiz_fiyat=:kdvsiz_fiyat,
                  kdv_tutar=:kdv_tutar,
                  kdv_durum=:kdv_durum
               WHERE sepetno={$onaysepet['sepetno']}
              ");
            $kdvsepetguncelle->execute(array(
                'kdvsiz_fiyat' => $onayfiyat,
                'kdv_tutar' => $kdvtutar,
                'kdv_durum' => '2'
            ));
        }
        /* KDVleri Hesaplayalım SON */




        /* Kargo Hesapla */
                if($odemeayar['kargo_sistemi'] == '1' ) {
                    if($onayurun['kargo'] == '1' ) {
                        if($odemeayar['kargo_sabit'] == '1' ) {
                            $kargohesabi= $odemeayar['kargo_sabit_ucret'];
                        }else{
                            if($onayurun['kargo_tipi'] == '0'  ) {
                                $kargohesabi = $kargohesabi+($onayurun['kargo_ucret']);
                            }
                            if($onayurun['kargo_tipi'] == '1' ) {
                                $kargohesabi = $kargohesabi+($onayurun['kargo_ucret']*$onaysepet['adet']);
                            }
                        }
                    }
                }else{
                    $kargohesabi='0';
                }
        /* Kargo Hesapla SON */

        /* kargo bilgisini db'ye aktar */
                     if($odemeayar['kargo_sistemi'] == '1' ) {
                         if($odemeayar['kargo_sabit'] == '1' ) {
                             if($onayurun['kargo'] == '1' ) {
                                 $guncelle = $db->prepare("UPDATE sepet SET
                                             kargo_tutar=:kargo_tutar,
                                             kargo_tipi=:kargo_tipi
                                         WHERE sepetno={$onaysepet['sepetno']}      
                                        ");
                                 $sonuc = $guncelle->execute(array(
                                     'kargo_tutar' => $odemeayar['kargo_sabit_ucret'],
                                     'kargo_tipi' => '0'
                                 ));
                             }else{
                                 $guncelle = $db->prepare("UPDATE sepet SET
                                             kargo_tutar=:kargo_tutar,
                                             kargo_tipi=:kargo_tipi
                                         WHERE sepetno={$onaysepet['sepetno']}      
                                        ");
                                 $sonuc = $guncelle->execute(array(
                                     'kargo_tutar' => '0',
                                     'kargo_tipi' => '0'
                                 ));
                             }
                         }else{
                             if($onayurun['kargo'] == '1' ) {
                                 if($onayurun['kargo_tipi'] == '1' ) {
                                     $guncelle = $db->prepare("UPDATE sepet SET
                                             kargo_tutar=:kargo_tutar,
                                             kargo_tipi=:kargo_tipi
                                         WHERE sepetno={$onaysepet['sepetno']}      
                                        ");
                                     $sonuc = $guncelle->execute(array(
                                         'kargo_tutar' => $onayurun['kargo_ucret']*$onaysepet['adet'],
                                         'kargo_tipi' => '1'
                                     ));
                                 }else{
                                     $guncelle = $db->prepare("UPDATE sepet SET
                                             kargo_tutar=:kargo_tutar,
                                             kargo_tipi=:kargo_tipi
                                         WHERE sepetno={$onaysepet['sepetno']}      
                                        ");
                                     $sonuc = $guncelle->execute(array(
                                         'kargo_tutar' => $onayurun['kargo_ucret'],
                                         'kargo_tipi' => '0'
                                     ));
                                 }
                             }else{
                                 $guncelle = $db->prepare("UPDATE sepet SET
                                             kargo_tutar=:kargo_tutar,
                                             kargo_tipi=:kargo_tipi
                                         WHERE sepetno={$onaysepet['sepetno']}      
                                        ");
                                 $sonuc = $guncelle->execute(array(
                                     'kargo_tutar' => '0',
                                     'kargo_tipi' => '0'
                                 ));
                             }
                         }
                     }else{
                         $guncelle = $db->prepare("UPDATE sepet SET
                                             kargo_tutar=:kargo_tutar,
                                             kargo_tipi=:kargo_tipi
                                         WHERE sepetno={$onaysepet['sepetno']}      
                                        ");
                         $sonuc = $guncelle->execute(array(
                             'kargo_tutar' => '0',
                             'kargo_tipi' => '0'
                         ));
                     }
        /* kargo bilgisini db'ye aktar SON */



        /* Havale Fiyatı güncelle */
             if($userSorgusu->rowCount()>'0') {
                if($uyegruplariCek->rowCount() >'0'  ) {
                    if($uyegrup['fiyat_tip'] == '0'  ) {
                        if($onayurun['havale_indirim_tutar'] == !null && $onayurun['havale_indirim_tutar'] > '0' ) {
                            if($onayurun['havale_indirim_tur'] == '1' ) {

                                $havale_tut_cikar = (($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)*$onayurun['havale_indirim_tutar'])/100;
                                $havale_tut = ($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)-$havale_tut_cikar;

                                $guncelle = $db->prepare("UPDATE sepet SET
                                    havale_fiyat=:havale_fiyat
                                     WHERE sepetno={$onaysepet['sepetno']}      
                                    ");
                                $sonuc = $guncelle->execute(array(
                                    'havale_fiyat' => $havale_tut,
                                ));
                            }
                            if($onayurun['havale_indirim_tur'] == '2' ) {
                                $havale_tut = ($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)-$onayurun['havale_indirim_tutar'];
                                $guncelle = $db->prepare("UPDATE sepet SET
                                    havale_fiyat=:havale_fiyat
                                     WHERE sepetno={$onaysepet['sepetno']}      
                                    ");
                                $sonuc = $guncelle->execute(array(
                                    'havale_fiyat' => $havale_tut,
                                ));
                            }
                        }else{
                            $havale_tut = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                            $guncelle = $db->prepare("UPDATE sepet SET
                                havale_fiyat=:havale_fiyat
                                 WHERE sepetno={$onaysepet['sepetno']}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'havale_fiyat' => $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,
                            ));
                        }
                    }
                    if($uyegrup['fiyat_tip'] == '1'  ) {
                        if($onayurun['fiyat_tip2'] == !null && $onayurun['fiyat_tip2'] > '0'  ) {

                            if($onayurun['havale_indirim_tutar'] == !null && $onayurun['havale_indirim_tutar'] > '0' ) {
                                if($onayurun['havale_indirim_tur'] == '1' ) {

                                    $havale_tut_cikar = (($onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc)*$onayurun['havale_indirim_tutar'])/100;
                                    $havale_tut = ($onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc)-$havale_tut_cikar;

                                    $guncelle = $db->prepare("UPDATE sepet SET
                                    havale_fiyat=:havale_fiyat
                                     WHERE sepetno={$onaysepet['sepetno']}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'havale_fiyat' => $havale_tut,
                                    ));
                                }
                                if($onayurun['havale_indirim_tur'] == '2' ) {
                                    $havale_tut = ($onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc)-$onayurun['havale_indirim_tutar'];
                                    $guncelle = $db->prepare("UPDATE sepet SET
                                    havale_fiyat=:havale_fiyat
                                     WHERE sepetno={$onaysepet['sepetno']}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'havale_fiyat' => $havale_tut,
                                    ));
                                }
                            }else{
                                $havale_tut = $onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc;
                                $guncelle = $db->prepare("UPDATE sepet SET
                                havale_fiyat=:havale_fiyat
                                 WHERE sepetno={$onaysepet['sepetno']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'havale_fiyat' => $onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc,
                                ));
                            }

                        }else{
                            if($onayurun['havale_indirim_tutar'] == !null && $onayurun['havale_indirim_tutar'] > '0' ) {
                                if($onayurun['havale_indirim_tur'] == '1' ) {

                                    $havale_tut_cikar = (($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)*$onayurun['havale_indirim_tutar'])/100;
                                    $havale_tut = ($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)-$havale_tut_cikar;

                                    $guncelle = $db->prepare("UPDATE sepet SET
                    havale_fiyat=:havale_fiyat
                     WHERE sepetno={$onaysepet['sepetno']}      
                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'havale_fiyat' => $havale_tut,
                                    ));
                                }
                                if($onayurun['havale_indirim_tur'] == '2' ) {
                                    $havale_tut = ($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)-$onayurun['havale_indirim_tutar'];
                                    $guncelle = $db->prepare("UPDATE sepet SET
                    havale_fiyat=:havale_fiyat
                     WHERE sepetno={$onaysepet['sepetno']}      
                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'havale_fiyat' => $havale_tut,
                                    ));
                                }
                            }else{
                                $havale_tut = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                                $guncelle = $db->prepare("UPDATE sepet SET
                    havale_fiyat=:havale_fiyat
                     WHERE sepetno={$onaysepet['sepetno']}      
                    ");
                                $sonuc = $guncelle->execute(array(
                                    'havale_fiyat' => $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,
                                ));
                            }
                        }
                    }
                }else{
                    if($onayurun['havale_indirim_tutar'] == !null && $onayurun['havale_indirim_tutar'] > '0' ) {
                        if($onayurun['havale_indirim_tur'] == '1' ) {

                            $havale_tut_cikar = (($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)*$onayurun['havale_indirim_tutar'])/100;
                            $havale_tut = ($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)-$havale_tut_cikar;

                            $guncelle = $db->prepare("UPDATE sepet SET
                    havale_fiyat=:havale_fiyat
                     WHERE sepetno={$onaysepet['sepetno']}      
                    ");
                            $sonuc = $guncelle->execute(array(
                                'havale_fiyat' => $havale_tut,
                            ));
                        }
                        if($onayurun['havale_indirim_tur'] == '2' ) {
                            $havale_tut = ($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)-$onayurun['havale_indirim_tutar'];
                            $guncelle = $db->prepare("UPDATE sepet SET
                    havale_fiyat=:havale_fiyat
                     WHERE sepetno={$onaysepet['sepetno']}      
                    ");
                            $sonuc = $guncelle->execute(array(
                                'havale_fiyat' => $havale_tut,
                            ));
                        }
                    }else{
                        $havale_tut = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                        $guncelle = $db->prepare("UPDATE sepet SET
                    havale_fiyat=:havale_fiyat
                     WHERE sepetno={$onaysepet['sepetno']}      
                    ");
                        $sonuc = $guncelle->execute(array(
                            'havale_fiyat' => $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,
                        ));
                    }
                }
            }else{
                 if($onayurun['havale_indirim_tutar'] == !null && $onayurun['havale_indirim_tutar'] > '0' ) {
                     if($onayurun['havale_indirim_tur'] == '1' ) {

                         $havale_tut_cikar = (($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)*$onayurun['havale_indirim_tutar'])/100;
                         $havale_tut = ($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)-$havale_tut_cikar;

                         $guncelle = $db->prepare("UPDATE sepet SET
                            havale_fiyat=:havale_fiyat
                             WHERE sepetno={$onaysepet['sepetno']}      
                            ");
                         $sonuc = $guncelle->execute(array(
                             'havale_fiyat' => $havale_tut,
                         ));
                     }
                     if($onayurun['havale_indirim_tur'] == '2' ) {
                         $havale_tut = ($onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc)-$onayurun['havale_indirim_tutar'];
                         $guncelle = $db->prepare("UPDATE sepet SET
                            havale_fiyat=:havale_fiyat
                             WHERE sepetno={$onaysepet['sepetno']}      
                            ");
                         $sonuc = $guncelle->execute(array(
                             'havale_fiyat' => $havale_tut,
                         ));
                     }
                 }else{
                     $havale_tut = $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc;
                     $guncelle = $db->prepare("UPDATE sepet SET
                            havale_fiyat=:havale_fiyat
                             WHERE sepetno={$onaysepet['sepetno']}      
                            ");
                     $sonuc = $guncelle->execute(array(
                         'havale_fiyat' => $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,
                     ));
                 }

            }
        /* Havale Fiyatı güncelle SON */




        /////////////////////////* Değerler ///////////////////////////////////////////*/
        $aratoplam = $aratoplam + ($onayfiyat * $onayadet);
        $kdvtoplami = $kdvtoplami + ($kdvtutar * $onayadet);

        /////////////////////////* Değerler SON ///////////////////////////////////////////*/
        ///
        ///
        ///




    /////////////////////////* Havale Fiyatına Göre Sepet Hesaplama ///////////////////////////////////////////*/

       $havale_islem_fiyati = $havale_tut;

        /* KDVSiz HJavale Fiyatı Hesapla */
        if($onayurun['kdv'] == '0' ) {
            $havale_tekil_kdv_fiyati = $havale_islem_fiyati;
            $havale_tekil_kdv = 0;
            $guncelle = $db->prepare("UPDATE sepet SET
                            havale_kdvsiz_fiyat=:havale_kdvsiz_fiyat,
                            havale_kdv_tutar=:havale_kdv_tutar
                             WHERE sepetno={$onaysepet['sepetno']}      
                            ");
            $sonuc = $guncelle->execute(array(
                'havale_kdvsiz_fiyat' => $havale_tekil_kdv_fiyati,
                'havale_kdv_tutar' => $havale_tekil_kdv
            ));
        }
        if($onayurun['kdv'] == '1' ) {
            $havale_tekil_kdv_fiyati = $havale_islem_fiyati;
            $havale_tekil_kdv = kdvhesapla($havale_tekil_kdv_fiyati,$onayurun['kdv_oran']);
            $guncelle = $db->prepare("UPDATE sepet SET
                            havale_kdvsiz_fiyat=:havale_kdvsiz_fiyat,
                            havale_kdv_tutar=:havale_kdv_tutar
                             WHERE sepetno={$onaysepet['sepetno']}      
                            ");
            $sonuc = $guncelle->execute(array(
                'havale_kdvsiz_fiyat' => $havale_tekil_kdv_fiyati,
                'havale_kdv_tutar' => $havale_tekil_kdv
            ));
        }
        if($onayurun['kdv'] == '2' ) {
            $havale_tekil_kdv_fiyati = kdvcikar($havale_islem_fiyati,$onayurun['kdv_oran']);
            $havale_tekil_kdv = kdvhesapla($havale_tekil_kdv_fiyati,$onayurun['kdv_oran']);
            $guncelle = $db->prepare("UPDATE sepet SET
                            havale_kdvsiz_fiyat=:havale_kdvsiz_fiyat,
                            havale_kdv_tutar=:havale_kdv_tutar
                             WHERE sepetno={$onaysepet['sepetno']}      
                            ");
            $sonuc = $guncelle->execute(array(
                'havale_kdvsiz_fiyat' => $havale_tekil_kdv_fiyati,
                'havale_kdv_tutar' => $havale_tekil_kdv
            ));
        }
        /* KDVSiz HJavale Fiyatı Hesapla SON */




        $havale_aratoplam = $havale_aratoplam + ($havale_tekil_kdv_fiyati * $onayadet);
        $havale_kdvtoplam = $havale_kdvtoplam + ($havale_tekil_kdv * $onayadet);


    /////////////////////////* Havale Fiyatına Göre Sepet Hesaplama SON ///////////////////////////////////////////*/
    /// 
    /// 
    ///


        


        

        

        /* Havale Fiyatı Kargo Durumu */
        if($odemeayar['kargo_sistemi'] == '1' ) {
            if($odemeayar['kargo_limit'] == '0' || $odemeayar['kargo_limit'] == null ) {
                $havalekargo_toplami = $kargohesabi;
                $havale_kargo_limit_durumu = '0';
            }else{
                if($odemeayar['kargo_limit'] <= ($havale_aratoplam+$havale_kdvtoplam)-$indirimtutar ) {
                    $havalekargo_toplami = '0';
                    $havale_kargo_limit_durumu = '1';
                }else{
                    $havalekargo_toplami = $kargohesabi;
                    $havale_kargo_limit_durumu = '0';
                }
            }
        }else{
            $havalekargo_toplami = '0';
            $havale_kargo_limit_durumu = '0';
        }
        /*  <========SON=========>>> Havale Fiyatı Kargo Durumu SON */


        /* Normal Fiyat Kargo Fiyalandırması */
        if($odemeayar['kargo_sistemi'] == '1' ) {
            if($odemeayar['kargo_limit'] == '0' || $odemeayar['kargo_limit'] == null ) {
                $kargotoplami = $kargohesabi;
                $kargo_limit_durumu = '0';
            }else{
                if($odemeayar['kargo_limit'] <= ($aratoplam+$kdvtoplami)-$indirimtutar ) {
                    $kargotoplami = '0';
                    $kargo_limit_durumu = '1';
                }else{
                    $kargotoplami = $kargohesabi;
                    $kargo_limit_durumu = '0';
                }
            }
        }else{
            $kargotoplami = '0';
            $kargo_limit_durumu = '0';
        }
        /*  <========SON=========>>> Normal Fiyat Kargo Fiyalandırması SON */





        /* Fiyat eşit mi değil mi sorgusu ve güncellemesi */
        if($onaysepet['fiyat'] == $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc ) {
            $guncelle3 = $db->prepare("UPDATE sepet SET
                    fiyat=:fiyat,
                    fiyat_eski=:fiyat_eski,
                  fiyat_durum=:fiyat_durum
          WHERE sepetno={$onaysepet['sepetno']}      
          ");
            $sonuc = $guncelle3->execute(array(
                'fiyat' => $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,
                'fiyat_eski' => $onaysepet['fiyat'],
                'fiyat_durum' => '0'
            ));
        }else{
            $guncelle3 = $db->prepare("UPDATE sepet SET
                    fiyat=:fiyat,
                    fiyat_eski=:fiyat_eski,
                  fiyat_durum=:fiyat_durum
          WHERE sepetno={$onaysepet['sepetno']}      
          ");
            $sonuc = $guncelle3->execute(array(
                'fiyat' => $onayurun['fiyat']+$varyantekfiyattoplami_tekilCalc,
                'fiyat_eski' => $onaysepet['fiyat'],
                'fiyat_durum' => '1'
            ));
        }
        /* Fiyat eşit mi değil mi sorgusu SON */

        /* Üyelere Özel Fiyat Hesaplaması Güncellemesi */
        if($userSorgusu->rowCount()>'0'  ) {
            if($uyegruplariCek->rowCount() >'0'  ) {
                if($uyegrup['fiyat_tip'] == '0'  ) {
                    $fiyat2update = $db->prepare("UPDATE sepet SET
                          fiyat_2=:fiyat_2,
                          uye_ozel_fiyat=:uye_ozel_fiyat
                      WHERE sepetno={$onaysepet['sepetno']}      
                      ");
                    $sonuc = $fiyat2update->execute(array(
                        'fiyat_2' => '0',
                        'uye_ozel_fiyat' => '0'
                    ));
                }
                if($uyegrup['fiyat_tip'] == '1'  ) {
                    if($onayurun['fiyat_tip2'] == !null && $onayurun['fiyat_tip2'] > '0'  ) {
                        $fiyat2update = $db->prepare("UPDATE sepet SET
                                      fiyat_2=:fiyat_2,
                                      uye_ozel_fiyat=:uye_ozel_fiyat
                              WHERE sepetno={$onaysepet['sepetno']}      
                              ");
                        $sonuc = $fiyat2update->execute(array(
                            'fiyat_2' => $onayurun['fiyat_tip2']+$varyantekfiyattoplami_tekilCalc,
                            'uye_ozel_fiyat' => '1'
                        ));
                    }else{
                        $fiyat2update = $db->prepare("UPDATE sepet SET
                                  fiyat_2=:fiyat_2,
                                  uye_ozel_fiyat=:uye_ozel_fiyat
                          WHERE sepetno={$onaysepet['sepetno']}      
                          ");
                        $sonuc = $fiyat2update->execute(array(
                            'fiyat_2' => '0',
                            'uye_ozel_fiyat' => '0'
                        ));
                    }
                }
            }else{
                $fiyat2update = $db->prepare("UPDATE sepet SET
                  fiyat_2=:fiyat_2,
                  uye_ozel_fiyat=:uye_ozel_fiyat
                      WHERE sepetno={$onaysepet['sepetno']}      
                      ");
                $sonuc = $fiyat2update->execute(array(
                    'fiyat_2' => '0',
                    'uye_ozel_fiyat' => '0'
                ));
            }
        }else{
            $fiyat2update = $db->prepare("UPDATE sepet SET
                  fiyat_2=:fiyat_2,
                  uye_ozel_fiyat=:uye_ozel_fiyat
          WHERE sepetno={$onaysepet['sepetno']}      
          ");
            $sonuc = $fiyat2update->execute(array(
                'fiyat_2' => '0',
                'uye_ozel_fiyat' => '0'
            ));
        }
        /*   <========SON=========>>> Üyelere Özel Fiyat Hesaplaması Güncellemesi */


    }
 }
/* Taksit Yapılabilir mi bu sepetteki siparişe? */
$taksitlerFor = $db->prepare("select * from sepet where sepet_durum=:sepet_durum and ip=:ip and taksit=:taksit ");
$taksitlerFor->execute(array(
    'sepet_durum' => '1',
    'ip' => $ipnedir,
    'taksit' => '0'
));
if($taksitlerFor->rowCount()>'0'  ) {
    $taksitdurum = '0';
}else{
    $taksitdurum = '1';
}
/*  <========SON=========>>> Taksit Yapılabilir mi bu sepetteki siparişe? SON */







$kupon_limit_tutar = $aratoplam+$kdvtoplami;
$kupon_oranti_toplam = $aratoplam;


//Kupon indirimi...
if($odemeayar['sepet_kupon'] == '1'  ) {
    $final_cart_items = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
    $final_cart_items->execute(array(
        'ip' => $ipnedir,
        'sepet_durum' => '1',
    ));
    $sepetKuponlari = $db->prepare("select * from sepet_kupon where uye_id=:uye_id and kullanim=:kullanim group by kupon_id");
    $sepetKuponlari->execute(array(
        'uye_id' => $userCek['id'],
        'kullanim' => '0'
    ));
    $todayCek = date('Y-m-d');
    if ($sepetKuponlari->rowCount() > '0') {
        $kdvtoplami = 0;
        $havale_kdvtoplam = 0;
        foreach ($sepetKuponlari as $sepkup) {
            $kuponBilgisi = $db->prepare("select * from kupon where id=:id and durum=:durum ");
            $kuponBilgisi->execute(array(
                'id' => $sepkup['kupon_id'],
                'durum' => '1',
            ));
            $kuponBilgi = $kuponBilgisi->fetch(PDO::FETCH_ASSOC);

            //Kupon Doğrulugu Sorgusu...
            if($sepkup['durum'] != '1' ) {
                $silmeislem = $db->prepare("DELETE from sepet_kupon WHERE kupon_id=:kupon_id");
                $silmeislem->execute(array(
                    'kupon_id' => $sepkup['kupon_id']
                ));
            }
            if ($kuponBilgi['durum'] != '1') {
                $silmeislem = $db->prepare("DELETE from sepet_kupon WHERE kupon_id=:kupon_id");
                $silmeislem->execute(array(
                    'kupon_id' => $sepkup['kupon_id']
                ));
            }
            if ($kuponBilgi['uye_id'] > '0' && $kuponBilgi['uye_id'] == !null) {
                if ($userCek['id'] != $kuponBilgi['uye_id']) {
                    $silmeislem = $db->prepare("DELETE from sepet_kupon WHERE kupon_id=:kupon_id");
                    $silmeislem->execute(array(
                        'kupon_id' => $sepkup['kupon_id']
                    ));
                }
            }
            if ($kuponBilgi['baslangic'] > $todayCek) {
                $silmeislem = $db->prepare("DELETE from sepet_kupon WHERE kupon_id=:kupon_id");
                $silmeislem->execute(array(
                    'kupon_id' => $sepkup['kupon_id']
                ));
            }
            if ($kuponBilgi['bitis'] < $todayCek) {
                $silmeislem = $db->prepare("DELETE from sepet_kupon WHERE kupon_id=:kupon_id");
                $silmeislem->execute(array(
                    'kupon_id' => $sepkup['kupon_id']
                ));
            }
            if ($kupon_limit_tutar  < $kuponBilgi['sepe_alt_limit']) {
                $silmeislem = $db->prepare("DELETE from sepet_kupon WHERE kupon_id=:kupon_id");
                $silmeislem->execute(array(
                    'kupon_id' => $sepkup['kupon_id']
                ));
            }
            //HAVALE için limit tutar kontrolü de yap ona göre kuponu aktif - pasif et....

            if ($kuponBilgi['tur'] == '1') {
               //ORAN// Oranlar toplanır ve aşağıdaki foreacha aktarrılır...
                $indirimorani = $indirimorani + $kuponBilgi['indirim_tutar'];
            } else {
                /* Tutar türünden *///Tutarlar toplanır aşağıdaki foreach'a aktarılır...
                $indirim_tutar_islem = $indirim_tutar_islem + $kuponBilgi['indirim_tutar'];
                /* Tutar türünden SON */
            }
        }
        foreach ($final_cart_items as $finalrow) {
          //ilk foreach...
          //Burası oranlı olan indirim kuponlarının tutar'a çevrilmesi içindir...

            //Normal fiyat ve havale beraber....
            if($indirimorani >'0'  ) {
                $oranli_toplam_tutar = $oranli_toplam_tutar + ((($finalrow['kdvsiz_fiyat'] * $finalrow['adet']) * $indirimorani) / 100);
                $oranli_toplam_tutar_havale = $oranli_toplam_tutar_havale + ((($finalrow['havale_kdvsiz_fiyat'] * $finalrow['adet']) * $indirimorani) / 100);
            }else{
                $oranli_toplam_tutar = 0;
            }


        }
        //Toplam kupon indirim tutarı...
        $oranli_toplam_tutar = $oranli_toplam_tutar + $indirim_tutar_islem;
        $oranli_toplam_tutar_havale = $oranli_toplam_tutar_havale + $indirim_tutar_islem;


        //İkinci foreach için tekrar ürünleri listeleriz...
        $final_cart_items = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
        $final_cart_items->execute(array(
            'ip' => $ipnedir,
            'sepet_durum' => '1',
        ));
        foreach ($final_cart_items as $finalrow) {
            //İkinci foreach..
            //Burada yukarıdaki indirim tutarı ile ürünlerin indirim miktarını paylaştırırız.
            $urunCek = $db->prepare("select kdv_oran,kdv from urun where id=:id ");
            $urunCek->execute(array(
                'id' => $finalrow['urun_id'],
            ));
            $urunrow = $urunCek->fetch(PDO::FETCH_ASSOC);
            //Ürünün fiyatı.
            $urunfiyat = $finalrow['kdvsiz_fiyat'] * $finalrow['adet'];
            $urunfiyat_havale = $finalrow['havale_kdvsiz_fiyat'] * $finalrow['adet'];
            //kdv aktif ise işlem..
            if($urunrow['kdv'] != '0'  ) {
                //Toplam indirim tutarının ürünlere dağıtılması...
                //Toplam indirim tutarının her bir üründe ne kadarı dağıtılacak hesap 2 de görüyoruz... Hesap 2 ürünün indirilmiş halidir.
                //Hesap 3 ise indirimli ürünün kdv tutarıdır...
                $hesap1 = ($urunfiyat / $aratoplam) * $oranli_toplam_tutar;
                $hesap2 = $urunfiyat - $hesap1;
                $hesap3 = ($hesap2 * $urunrow['kdv_oran']) / 100;

                $hesap1_havale = ($urunfiyat_havale / $havale_aratoplam) * $oranli_toplam_tutar_havale;
                $hesap2_havale = $urunfiyat_havale - $hesap1_havale;
                $hesap3_havale = ($hesap2_havale * $urunrow['kdv_oran']) / 100;
            }else{
                $hesap3 = 0;
                $hesap3_havale = 0;
            }
            $indirimtutar = $oranli_toplam_tutar;
            $kdvtoplami = $kdvtoplami + $hesap3;

            $havale_indirimtutar = $oranli_toplam_tutar_havale;
            $havale_kdvtoplam = $havale_kdvtoplam +$hesap3_havale;



        }
    }

}


//Grup İndirimi
if($uyegruplariCek->rowCount()>'0'  ) {
    if($uyegrup['ozel_indirim'] == '1' ) {
        if($uyegrup['indirim_oran'] >'0'  ) {
            $kdvtoplami = 0;
            $havale_kdvtoplam = 0;
            //Grup indirim oranının tutarını bulman gerek...
            $final_cart_items = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
            $final_cart_items->execute(array(
                'ip' => $ipnedir,
                'sepet_durum' => '1',
            ));
            foreach ($final_cart_items as $finalrow) {
                $grupIndirimOran = $uyegrup['indirim_oran'];
                if($grupIndirimOran >'0'  ) {
                    $grup_indirim_tutari = $grup_indirim_tutari + ((($finalrow['kdvsiz_fiyat'] * $finalrow['adet']) * $grupIndirimOran) / 100);
                    $grup_indirim_tutari_havale = $grup_indirim_tutari_havale + ((($finalrow['havale_kdvsiz_fiyat'] * $finalrow['adet']) * $grupIndirimOran) / 100);
                }else{
                    $grup_indirim_tutari = 0;
                    $grup_indirim_tutari_havale = 0;
                }
            }

            //Toplam İnd Tutar...
            $oranli_toplam_tutar = $oranli_toplam_tutar + $grup_indirim_tutari;
            $oranli_toplam_tutar_havale = $oranli_toplam_tutar_havale + $grup_indirim_tutari_havale;
            //İkinci foreach için tekrar ürünleri listeleriz...

            $final_cart_items = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
            $final_cart_items->execute(array(
                'ip' => $ipnedir,
                'sepet_durum' => '1',
            ));
            foreach ($final_cart_items as $finalrow) {
                //3. foreach..
                $urunCek = $db->prepare("select kdv_oran,kdv from urun where id=:id ");
                $urunCek->execute(array(
                    'id' => $finalrow['urun_id'],
                ));
                $urunrow = $urunCek->fetch(PDO::FETCH_ASSOC);
                $urunfiyat = $finalrow['kdvsiz_fiyat'] * $finalrow['adet'];
                $urunfiyat_havale = $finalrow['havale_kdvsiz_fiyat'] * $finalrow['adet'];
                if($urunrow['kdv'] != '0'  ) {
                    $hesap1 = ($urunfiyat / $aratoplam) * $oranli_toplam_tutar;
                    $hesap2 = $urunfiyat - $hesap1;
                    $hesap3 = ($hesap2 * $urunrow['kdv_oran']) / 100;

                    $hesap1_havale = ($urunfiyat_havale / $havale_aratoplam) * $oranli_toplam_tutar_havale;
                    $hesap2_havale = $urunfiyat_havale - $hesap1_havale;
                    $hesap3_havale = ($hesap2_havale * $urunrow['kdv_oran']) / 100;
                }else{
                    $hesap3 = 0;
                    $hesap3_havale = 0;
                }
                $kdvtoplami = $kdvtoplami + $hesap3;
                $grubindirimi = $grup_indirim_tutari;

                $havale_kdvtoplam = $havale_kdvtoplam +$hesap3_havale;
                $grubindirimi_havale = $grup_indirim_tutari_havale;
            }
        }
    }
}


/* İlk Siparişe İndirim */
$ilkSiparis = $db->prepare("select * from indirim_ilk_siparis where id=:id ");
$ilkSiparis->execute(array(
    'id' => '1'
));
if($ilkSiparis->rowCount()>'0'  ) {
    $ilkSipRow = $ilkSiparis->fetch(PDO::FETCH_ASSOC);
    if($ilkSipRow['durum'] == '1' ) {
        if($userSorgusu->rowCount()>'0'  ) {
            $kdvtoplami = 0;
            $havale_kdvtoplam = 0;
            $ilkSiparisKayitSorgu = $db->prepare("select * from indirim_ilk_siparis_kayit where uye_id=:uye_id and onay=:onay ");
            $ilkSiparisKayitSorgu->execute(array(
                'uye_id' => $userCek['id'],
                'onay' => '1'
            ));
            if($ilkSiparisKayitSorgu->rowCount()<='0'  ) {
                if($ilkSipRow['tutar'] >'0' ) {
                    if($kupon_limit_tutar >= $ilkSipRow['sepet_alt_limit']  ) {
                        if($ilkSipRow['tur'] == '1' ) {
                            //ORANLI
                           $ilksiparisIndirim_orani = $ilkSipRow['tutar'];
                            $final_cart_items = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
                            $final_cart_items->execute(array(
                                'ip' => $ipnedir,
                                'sepet_durum' => '1',
                            ));
                            foreach ($final_cart_items as $finalrow) {
                                //Burası oranlı olan indirimin tutar'a çevrilmesi içindir...
                                if($ilksiparisIndirim_orani >'0'  ) {
                                    $first_oran_tutarcevir = $first_oran_tutarcevir + ((($finalrow['kdvsiz_fiyat'] * $finalrow['adet']) * $ilksiparisIndirim_orani) / 100);
                                    $first_oran_tutarcevir_havale = $first_oran_tutarcevir_havale + ((($finalrow['havale_kdvsiz_fiyat'] * $finalrow['adet']) * $ilksiparisIndirim_orani) / 100);
                                }else{
                                    $first_oran_tutarcevir = 0;
                                    $first_oran_tutarcevir_havale = 0;
                                }
                            }
                            $first_order_disc_tutar = $first_oran_tutarcevir;
                            $first_order_disc_tutar_havale = $first_oran_tutarcevir_havale;
                        }
                        if($ilkSipRow['tur'] == '2' ) {
                            $first_order_disc_tutar = $ilkSipRow['tutar'];
                            $first_order_disc_tutar_havale = $ilkSipRow['tutar'];
                        }
                    }
                }

                //Toplam İnd Tutar...
                $oranli_toplam_tutar = $oranli_toplam_tutar + $first_order_disc_tutar;
                $oranli_toplam_tutar_havale = $oranli_toplam_tutar_havale + $first_order_disc_tutar_havale;
                //İkinci foreach için tekrar ürünleri listeleriz...
                $final_cart_items = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
                $final_cart_items->execute(array(
                    'ip' => $ipnedir,
                    'sepet_durum' => '1',
                ));
                foreach ($final_cart_items as $finalrow) {
                    //3. foreach..
                    $urunCek = $db->prepare("select kdv_oran,kdv from urun where id=:id ");
                    $urunCek->execute(array(
                        'id' => $finalrow['urun_id'],
                    ));
                    $urunrow = $urunCek->fetch(PDO::FETCH_ASSOC);
                    $urunfiyat = $finalrow['kdvsiz_fiyat'] * $finalrow['adet'];
                    $urunfiyat_havale = $finalrow['havale_kdvsiz_fiyat'] * $finalrow['adet'];
                    if($urunrow['kdv'] != '0'  ) {
                        $hesap1 = ($urunfiyat / $aratoplam) * $oranli_toplam_tutar;
                        $hesap2 = $urunfiyat - $hesap1;
                        $hesap3 = ($hesap2 * $urunrow['kdv_oran']) / 100;

                        $hesap1_havale = ($urunfiyat_havale / $havale_aratoplam) * $oranli_toplam_tutar_havale;
                        $hesap2_havale = $urunfiyat_havale - $hesap1_havale;
                        $hesap3_havale = ($hesap2_havale * $urunrow['kdv_oran']) / 100;
                    }else{
                        $hesap3 = 0;
                        $hesap3_havale = 0;
                    }
                    $kdvtoplami = $kdvtoplami + $hesap3;
                    $ilk_sip_indirim = $first_order_disc_tutar;

                    $havale_kdvtoplam = $havale_kdvtoplam + $hesap3_havale;
                    $ilk_sip_indirim_havale = $first_order_disc_tutar_havale;
                }


            }
        }
    }
}



//Sepette Ek İndirim...
$ekIndirimSql = $db->prepare("select * from indirim_ek_sepet where id=:id ");
$ekIndirimSql->execute(array(
    'id' => '1'
));
$ekindirimRow = $ekIndirimSql->fetch(PDO::FETCH_ASSOC);
if($ekindirimRow['durum'] == '1') {
    if($ekindirimRow['tutar'] >'0' ) {
        if($kupon_limit_tutar >= $ekindirimRow['sepet_alt_limit']  ) {
            if($ekindirimRow['indirim_tip'] == '0' ) {
                $ek_indirim_ok = '1';
            }
            if($ekindirimRow['indirim_tip'] == '1' ) {
                if($userSorgusu->rowCount()>'0'  ) {
                    $ek_indirim_ok = '1';
                }
            }
            if($ekindirimRow['indirim_tip'] == '2' ) {
                if($uyegruplariCek->rowCount()>'0'  ) {
                    $ek_indirim_ok = '1';
                }
            }
            //İŞLEM YAPILABİLİR...
            if($ek_indirim_ok == '1'  ) {
                $kdvtoplami = 0;
                $havale_kdvtoplam = 0;
                if($ekindirimRow['tur'] == '1' ) {
                    //ORANLI..
                    $ek_indirim_orani = $ekindirimRow['tutar'];
                    $final_cart_items = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
                    $final_cart_items->execute(array(
                        'ip' => $ipnedir,
                        'sepet_durum' => '1',
                    ));
                    foreach ($final_cart_items as $finalrow) {
                        //Burası oranlı olan indirimin tutar'a çevrilmesi içindir...
                        if($ek_indirim_orani >'0'  ) {
                            $ek_indirim_tutar_hesap = $ek_indirim_tutar_hesap + ((($finalrow['kdvsiz_fiyat'] * $finalrow['adet']) * $ek_indirim_orani) / 100);
                            $ek_indirim_tutar_hesap_havale = $ek_indirim_tutar_hesap_havale + ((($finalrow['havale_kdvsiz_fiyat'] * $finalrow['adet']) * $ek_indirim_orani) / 100);
                        }else{
                            $ek_indirim_tutar_hesap = 0;
                            $ek_indirim_tutar_hesap_havale = 0;
                        }
                    }
                    $ek_indirim_tutar_toplami = $ek_indirim_tutar_hesap;
                    $ek_indirim_tutar_toplami_havale = $ek_indirim_tutar_hesap_havale;
                }
                if($ekindirimRow['tur'] == '2' ) {
                    //TUTAR...
                    $ek_indirim_tutar_toplami =  $ekindirimRow['tutar'];
                    $ek_indirim_tutar_toplami_havale =  $ekindirimRow['tutar'];
                }

                //toplam..
                $oranli_toplam_tutar = $oranli_toplam_tutar + $ek_indirim_tutar_toplami;
                $oranli_toplam_tutar_havale = $oranli_toplam_tutar_havale + $ek_indirim_tutar_toplami_havale;
                //İkinci foreach için tekrar ürünleri listeleriz...
                $final_cart_items = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum ");
                $final_cart_items->execute(array(
                    'ip' => $ipnedir,
                    'sepet_durum' => '1',
                ));
                foreach ($final_cart_items as $finalrow) {
                    //3. foreach..
                    $urunCek = $db->prepare("select kdv_oran,kdv from urun where id=:id ");
                    $urunCek->execute(array(
                        'id' => $finalrow['urun_id'],
                    ));
                    $urunrow = $urunCek->fetch(PDO::FETCH_ASSOC);
                    $urunfiyat = $finalrow['kdvsiz_fiyat'] * $finalrow['adet'];
                    $urunfiyat_havale = $finalrow['havale_kdvsiz_fiyat'] * $finalrow['adet'];
                    if($urunrow['kdv'] != '0'  ) {
                        $hesap1 = ($urunfiyat / $aratoplam) * $oranli_toplam_tutar;
                        $hesap2 = $urunfiyat - $hesap1;
                        $hesap3 = ($hesap2 * $urunrow['kdv_oran']) / 100;

                        $hesap1_havale = ($urunfiyat_havale / $havale_aratoplam) * $oranli_toplam_tutar_havale;
                        $hesap2_havale = $urunfiyat_havale - $hesap1_havale;
                        $hesap3_havale = ($hesap2_havale * $urunrow['kdv_oran']) / 100;
                    }else{
                        $hesap3 = 0;
                        $hesap3_havale = 0;
                    }
                    $kdvtoplami = $kdvtoplami + $hesap3;
                    $sepette_ek_indirim = $ek_indirim_tutar_toplami;

                    $havale_kdvtoplam = $havale_kdvtoplam + $hesap3_havale;
                    $sepette_ek_indirim_havale = $ek_indirim_tutar_toplami_havale;
                }
            }
        }
    }
}


$havale_odenecek_tutar = ($havale_aratoplam+$havale_kdvtoplam+$havalekargo_toplami);

//TODO havale versiyonlarını da bitir sonra parasutun kalan kısımlarını tamamla.. 



























?>
