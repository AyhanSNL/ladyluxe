<?php
if($_POST) {
    $returnValue = trim(strip_tags($_POST['returnValue']));
    $adresHash = trim(strip_tags($_POST['addressHash']));
    $adresNo = trim(strip_tags($_POST['addressNo']));

    $adresCek = $db->prepare("select * from uyeler_adres where adres_id=:adres_id ");
    $adresCek->execute(array(
        'adres_id' => $adresNo,
    ));
    $adresRow = $adresCek->fetch(PDO::FETCH_ASSOC);
    if($demo != '1'  ){
    if($adresCek->rowCount()>'0' && md5($adresRow['adres_id']) == $adresHash) {

        if($returnValue) {
            if($returnValue == 'cart' ||$returnValue =='account' ) {

                $baslik = trim(strip_tags($_POST['baslik']));
                $isim = trim(strip_tags($_POST['isim']));
                $soyisim = trim(strip_tags($_POST['soyisim']));
                $alankodu  = trim(strip_tags($_POST['alankodu']));
                $telefon  = trim(strip_tags($_POST['tel']));
                $eposta = trim(strip_tags($_POST['eposta']));
                $ulke = trim(strip_tags($_POST['ulke']));
                $sehir = trim(strip_tags($_POST['il']));
                $ilce = trim(strip_tags($_POST['ilce']));
                $postakodu = trim(strip_tags($_POST['postakodu']));
                $adres = trim(strip_tags($_POST['adresbilgisi']));
                $varsayilan = trim(strip_tags($_POST['secili']));

                if($baslik && $isim && $soyisim && $telefon  && $eposta && $ulke && $sehir && $ilce  && $adres  ) {
                    if($varsayilan == '1' || $varsayilan == '0'  ) {
                        if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){
                            if($odemeayar['faturasiz_teslimat'] == '0' ) {
                                $fatura_isim = trim(strip_tags($_POST['fatura_isim']));
                                $fatura_soyisim = trim(strip_tags($_POST['fatura_soyisim']));
                                $fatura_tc = trim(strip_tags($_POST['fatura_tc']));
                                $fatura_firma_unvan = trim(strip_tags($_POST['fatura_firma_unvan']));
                                $fatura_vergi_dairesi = trim(strip_tags($_POST['fatura_vergi_dairesi']));
                                $fatura_vergi_no = trim(strip_tags($_POST['fatura_vergi_no']));
                                $fatura_ulke = trim(strip_tags($_POST['fatura_ulke']));
                                $fatura_il=trim(strip_tags($_POST['fatura_il']));
                                $fatura_ilce = trim(strip_tags($_POST['fatura_ilce']));
                                $fatura_postakodu = trim(strip_tags($_POST['fatura_postakodu']));
                                $fatura_adresbilgisi = trim(strip_tags($_POST['fatura_adresbilgisi']));
                                $faturaturu =  trim(strip_tags($_POST['fatura_turu']));
                                if(trim(strip_tags($_POST['fatura_turu'])) == 'fatura_turu1' || trim(strip_tags($_POST['fatura_turu'])) == 'fatura_turu2' ) {
                                    if(trim(strip_tags($_POST['fatura_turu'])) == 'fatura_turu1'  ) {
                                        if($fatura_isim && $fatura_soyisim && $fatura_ulke && $fatura_il && $fatura_ilce && $fatura_adresbilgisi && $faturaturu) {
                                            if($varsayilan == '1'  ) {
                                                $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                 secili=:secili
                                          WHERE uye_id={$userCek['id']}      
                                         ");
                                                $sonuc = $guncelle->execute(array(
                                                    'secili' => '0'
                                                ));
                                                if($sonuc){

                                                    $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                   baslik=:baslik, 
                                                   isim=:isim,      
                                                   soyisim=:soyisim,
                                                   alan_kodu=:alan_kodu,
                                                   eposta=:eposta,
                                                   telefon=:telefon,
                                                   ulke=:ulke,
                                                   sehir=:sehir,
                                                   ilce=:ilce,
                                                   postakodu=:postakodu,
                                                   adresbilgisi=:adresbilgisi,
                                                   fatura_turu=:fatura_turu,
                                                   fatura_isim=:fatura_isim,
                                                   fatura_soyisim=:fatura_soyisim,
                                                   fatura_tc=:fatura_tc,
                                                   fatura_ulke=:fatura_ulke,
                                                   fatura_sehir=:fatura_sehir,
                                                   fatura_ilce=:fatura_ilce,
                                                   fatura_postakodu=:fatura_postakodu,
                                                   fatura_adresi=:fatura_adresi,
                                                   secili=:secili   
                                                 WHERE adres_id={$adresNo}      
                                                ");
                                                    $sonuc = $guncelle->execute(array(
                                                        'baslik' => $baslik,
                                                        'isim' => $isim,
                                                        'soyisim' => $soyisim,
                                                        'alan_kodu' => $alankodu,
                                                        'eposta' => $eposta,
                                                        'telefon' => $telefon,
                                                        'ulke' => $ulke,
                                                        'sehir' => $sehir,
                                                        'ilce' => $ilce,
                                                        'postakodu' => $postakodu,
                                                        'adresbilgisi' => $adres,
                                                        'fatura_turu' => '1',
                                                        'fatura_isim' => $fatura_isim,
                                                        'fatura_soyisim' => $fatura_soyisim,
                                                        'fatura_tc' => $fatura_tc,
                                                        'fatura_ulke' => $fatura_ulke,
                                                        'fatura_sehir' => $fatura_il,
                                                        'fatura_ilce' => $fatura_ilce,
                                                        'fatura_postakodu' => $fatura_postakodu,
                                                        'fatura_adresi' => $fatura_adresbilgisi,
                                                        'secili' => $varsayilan
                                                    ));
                                                    if($sonuc){
                                                        if($returnValue == 'cart'  ) {
                                                            $_SESSION['adres_alert'] = 'success_edit';
                                                            header('Location:'.$ayar['site_url'].'teslimat/');
                                                        }
                                                        if($returnValue == 'account' ) {
                                                            $_SESSION['adres_alert'] = 'success_edit';
                                                            header('Location:'.$ayar['site_url'].'hesabim/adresler/');
                                                        }
                                                    }else{
                                                        echo 'Veritabanı Hatası';
                                                    }



                                                }else{
                                                    echo 'Veritabanı Hatası';
                                                }
                                            }
                                            if($varsayilan == '0'  ) {
                                                $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                   baslik=:baslik, 
                                                   isim=:isim,      
                                                   soyisim=:soyisim,
                                                   alan_kodu=:alan_kodu,
                                                   eposta=:eposta,
                                                   telefon=:telefon,
                                                   ulke=:ulke,
                                                   sehir=:sehir,
                                                   ilce=:ilce,
                                                   postakodu=:postakodu,
                                                   adresbilgisi=:adresbilgisi,
                                                   fatura_turu=:fatura_turu,
                                                   fatura_isim=:fatura_isim,
                                                   fatura_soyisim=:fatura_soyisim,
                                                   fatura_tc=:fatura_tc,
                                                   fatura_ulke=:fatura_ulke,
                                                   fatura_sehir=:fatura_sehir,
                                                   fatura_ilce=:fatura_ilce,
                                                   fatura_postakodu=:fatura_postakodu,
                                                   fatura_adresi=:fatura_adresi,
                                                   secili=:secili   
                                                 WHERE adres_id={$adresNo}      
                                                ");
                                                $sonuc = $guncelle->execute(array(
                                                    'baslik' => $baslik,
                                                    'isim' => $isim,
                                                    'soyisim' => $soyisim,
                                                    'alan_kodu' => $alankodu,
                                                    'eposta' => $eposta,
                                                    'telefon' => $telefon,
                                                    'ulke' => $ulke,
                                                    'sehir' => $sehir,
                                                    'ilce' => $ilce,
                                                    'postakodu' => $postakodu,
                                                    'adresbilgisi' => $adres,
                                                    'fatura_turu' => '1',
                                                    'fatura_isim' => $fatura_isim,
                                                    'fatura_soyisim' => $fatura_soyisim,
                                                    'fatura_tc' => $fatura_tc,
                                                    'fatura_ulke' => $fatura_ulke,
                                                    'fatura_sehir' => $fatura_il,
                                                    'fatura_ilce' => $fatura_ilce,
                                                    'fatura_postakodu' => $fatura_postakodu,
                                                    'fatura_adresi' => $fatura_adresbilgisi,
                                                    'secili' => $varsayilan
                                                ));
                                                if($sonuc){
                                                    if($returnValue == 'cart'  ) {
                                                        $_SESSION['adres_alert'] = 'success_edit';
                                                        header('Location:'.$ayar['site_url'].'teslimat/');
                                                    }
                                                    if($returnValue == 'account' ) {
                                                        $_SESSION['adres_alert'] = 'success_edit';
                                                        header('Location:'.$ayar['site_url'].'hesabim/adresler/');
                                                    }
                                                }else{
                                                    echo 'Veritabanı Hatası';
                                                }
                                            }
                                        }else{
                                            $_SESSION['adres_alert'] = 'empty';
                                            header('Location:'.$ayar['site_url'].'hesabim/adres-duzenle/'.$adresNo.'/');
                                        }
                                    }
                                    if(trim(strip_tags($_POST['fatura_turu'])) == 'fatura_turu2'  ) {
                                        if($fatura_vergi_no && $fatura_ulke && $fatura_il && $fatura_ilce  && $fatura_adresbilgisi ) {
                                            if($varsayilan == '1'  ) {
                                                $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                 secili=:secili
                                          WHERE uye_id={$userCek['id']}      
                                         ");
                                                $sonuc = $guncelle->execute(array(
                                                    'secili' => '0'
                                                ));
                                                if($sonuc){

                                                    $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                       baslik=:baslik, 
                                                       isim=:isim,      
                                                       soyisim=:soyisim,
                                                       alan_kodu=:alan_kodu,
                                                       eposta=:eposta,
                                                       telefon=:telefon,
                                                       ulke=:ulke,
                                                       sehir=:sehir,
                                                       ilce=:ilce,
                                                       postakodu=:postakodu,
                                                       adresbilgisi=:adresbilgisi,
                                                       fatura_turu=:fatura_turu,
                                                       fatura_isim=:fatura_isim,
                                                       fatura_soyisim=:fatura_soyisim,
                                                       fatura_firma_unvan=:fatura_firma_unvan,
                                                       fatura_vergi_dairesi=:fatura_vergi_dairesi,
                                                       fatura_vergi_no=:fatura_vergi_no,
                                                       fatura_ulke=:fatura_ulke,
                                                       fatura_sehir=:fatura_sehir,
                                                       fatura_ilce=:fatura_ilce,
                                                       fatura_postakodu=:fatura_postakodu,
                                                       fatura_adresi=:fatura_adresi,
                                                       secili=:secili
                                                 WHERE adres_id={$adresNo}      
                                                ");
                                                    $sonuc = $guncelle->execute(array(
                                                        'baslik' => $baslik,
                                                        'isim' => $isim,
                                                        'soyisim' => $soyisim,
                                                        'alan_kodu' => $alankodu,
                                                        'eposta' => $eposta,
                                                        'telefon' => $telefon,
                                                        'ulke' => $ulke,
                                                        'sehir' => $sehir,
                                                        'ilce' => $ilce,
                                                        'postakodu' => $postakodu,
                                                        'adresbilgisi' => $adres,
                                                        'fatura_turu' => '2',
                                                        'fatura_isim' => $fatura_isim,
                                                        'fatura_soyisim' => $fatura_soyisim,
                                                        'fatura_firma_unvan' => $fatura_firma_unvan,
                                                        'fatura_vergi_dairesi' => $fatura_vergi_dairesi,
                                                        'fatura_vergi_no' => $fatura_vergi_no,
                                                        'fatura_ulke' => $fatura_ulke,
                                                        'fatura_sehir' => $fatura_il,
                                                        'fatura_ilce' => $fatura_ilce,
                                                        'fatura_postakodu' => $fatura_postakodu,
                                                        'fatura_adresi' => $fatura_adresbilgisi,
                                                        'secili' => $varsayilan
                                                    ));
                                                    if($sonuc){
                                                        if($returnValue == 'cart'  ) {
                                                            $_SESSION['adres_alert'] = 'success_edit';
                                                            header('Location:'.$ayar['site_url'].'teslimat/');
                                                        }
                                                        if($returnValue == 'account' ) {
                                                            $_SESSION['adres_alert'] = 'success_edit';
                                                            header('Location:'.$ayar['site_url'].'hesabim/adresler/');
                                                        }
                                                    }else{
                                                        echo 'Veritabanı Hatası';
                                                    }



                                                }else{
                                                    echo 'Veritabanı Hatası';
                                                }
                                            }
                                            if($varsayilan == '0'  ) {
                                                $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                   baslik=:baslik, 
                                   isim=:isim,      
                                   soyisim=:soyisim,
                                   alan_kodu=:alan_kodu,
                                   eposta=:eposta,
                                   telefon=:telefon,
                                   ulke=:ulke,
                                   sehir=:sehir,
                                   ilce=:ilce,
                                   postakodu=:postakodu,
                                   adresbilgisi=:adresbilgisi,
                                   fatura_turu=:fatura_turu,
                                   fatura_isim=:fatura_isim,
                                   fatura_soyisim=:fatura_soyisim,
                                   fatura_firma_unvan=:fatura_firma_unvan,
                                   fatura_vergi_dairesi=:fatura_vergi_dairesi,
                                   fatura_vergi_no=:fatura_vergi_no,
                                   fatura_ulke=:fatura_ulke,
                                   fatura_sehir=:fatura_sehir,
                                   fatura_ilce=:fatura_ilce,
                                   fatura_postakodu=:fatura_postakodu,
                                   fatura_adresi=:fatura_adresi,
                                   secili=:secili
                                                 WHERE adres_id={$adresNo}      
                                                ");
                                                $sonuc = $guncelle->execute(array(
                                                    'baslik' => $baslik,
                                                    'isim' => $isim,
                                                    'soyisim' => $soyisim,
                                                    'alan_kodu' => $alankodu,
                                                    'eposta' => $eposta,
                                                    'telefon' => $telefon,
                                                    'ulke' => $ulke,
                                                    'sehir' => $sehir,
                                                    'ilce' => $ilce,
                                                    'postakodu' => $postakodu,
                                                    'adresbilgisi' => $adres,
                                                    'fatura_turu' => '2',
                                                    'fatura_isim' => $fatura_isim,
                                                    'fatura_soyisim' => $fatura_soyisim,
                                                    'fatura_firma_unvan' => $fatura_firma_unvan,
                                                    'fatura_vergi_dairesi' => $fatura_vergi_dairesi,
                                                    'fatura_vergi_no' => $fatura_vergi_no,
                                                    'fatura_ulke' => $fatura_ulke,
                                                    'fatura_sehir' => $fatura_il,
                                                    'fatura_ilce' => $fatura_ilce,
                                                    'fatura_postakodu' => $fatura_postakodu,
                                                    'fatura_adresi' => $fatura_adresbilgisi,
                                                    'secili' => $varsayilan
                                                ));
                                                if($sonuc){
                                                    if($returnValue == 'cart'  ) {
                                                        $_SESSION['adres_alert'] = 'success_edit';
                                                        header('Location:'.$ayar['site_url'].'teslimat/');
                                                    }
                                                    if($returnValue == 'account' ) {
                                                        $_SESSION['adres_alert'] = 'success_edit';
                                                        header('Location:'.$ayar['site_url'].'hesabim/adresler/');
                                                    }
                                                }else{
                                                    echo 'Veritabanı Hatası';
                                                }
                                            }
                                        }else{
                                            $_SESSION['adres_alert'] = 'empty';
                                            header('Location:'.$ayar['site_url'].'hesabim/adres-duzenle/'.$adresNo.'/');
                                        }
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }else{
                                if($odemeayar['faturasiz_tc_zorunlu'] == '0'  ) {
                                    if($varsayilan == '1'  ) {
                                        $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                 secili=:secili
                                          WHERE uye_id={$userCek['id']}      
                                         ");
                                        $sonuc = $guncelle->execute(array(
                                            'secili' => '0'
                                        ));
                                        if($sonuc){

                                            $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                                 baslik=:baslik, 
                                   isim=:isim,      
                                   soyisim=:soyisim,
                                   alan_kodu=:alan_kodu,
                                   eposta=:eposta,
                                   telefon=:telefon,
                                   ulke=:ulke,
                                   sehir=:sehir,
                                   ilce=:ilce,
                                   postakodu=:postakodu,
                                   adresbilgisi=:adresbilgisi,
                                   secili=:secili
                                                 WHERE adres_id={$adresNo}      
                                                ");
                                            $sonuc = $guncelle->execute(array(
                                                'baslik' => $baslik,
                                                'isim' => $isim,
                                                'soyisim' => $soyisim,
                                                'alan_kodu' => $alankodu,
                                                'eposta' => $eposta,
                                                'telefon' => $telefon,
                                                'ulke' => $ulke,
                                                'sehir' => $sehir,
                                                'ilce' => $ilce,
                                                'postakodu' => $postakodu,
                                                'adresbilgisi' => $adres,
                                                'secili' => $varsayilan
                                            ));
                                            if($sonuc){
                                                if($returnValue == 'cart'  ) {
                                                    $_SESSION['adres_alert'] = 'success_edit';
                                                    header('Location:'.$ayar['site_url'].'teslimat/');
                                                }
                                                if($returnValue == 'account' ) {
                                                    $_SESSION['adres_alert'] = 'success_edit';
                                                    header('Location:'.$ayar['site_url'].'hesabim/adresler/');
                                                }
                                            }else{
                                                echo 'Veritabanı Hatası';
                                            }



                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                    }
                                    if($varsayilan == '0'  ) {
                                        $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                   baslik=:baslik, 
                                   tc_no=:tc_no,
                                   isim=:isim,      
                                   soyisim=:soyisim,
                                   alan_kodu=:alan_kodu,
                                   eposta=:eposta,
                                   telefon=:telefon,
                                   ulke=:ulke,
                                   sehir=:sehir,
                                   ilce=:ilce,
                                   postakodu=:postakodu,
                                   adresbilgisi=:adresbilgisi,
                                   secili=:secili
                                                 WHERE adres_id={$adresNo}      
                                                ");
                                        $sonuc = $guncelle->execute(array(
                                            'baslik' => $baslik,
                                            'tc_no' => trim(strip_tags($_POST['tcno'])),
                                            'isim' => $isim,
                                            'soyisim' => $soyisim,
                                            'alan_kodu' => $alankodu,
                                            'eposta' => $eposta,
                                            'telefon' => $telefon,
                                            'ulke' => $ulke,
                                            'sehir' => $sehir,
                                            'ilce' => $ilce,
                                            'postakodu' => $postakodu,
                                            'adresbilgisi' => $adres,
                                            'secili' => $varsayilan
                                        ));
                                        if($sonuc){
                                            if($returnValue == 'cart'  ) {
                                                $_SESSION['adres_alert'] = 'success_edit';
                                                header('Location:'.$ayar['site_url'].'teslimat/');
                                            }
                                            if($returnValue == 'account' ) {
                                                $_SESSION['adres_alert'] = 'success_edit';
                                                header('Location:'.$ayar['site_url'].'hesabim/adresler/');
                                            }
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                    }
                                }
                                if($odemeayar['faturasiz_tc_zorunlu'] == '1'  ) {
                                    if(trim(strip_tags($_POST['tcno']))) {
                                        if($varsayilan == '1'  ) {
                                            $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                 secili=:secili
                                          WHERE uye_id={$userCek['id']}      
                                         ");
                                            $sonuc = $guncelle->execute(array(
                                                'secili' => '0'
                                            ));
                                            if($sonuc){

                                                $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                                                 baslik=:baslik, 
                                   isim=:isim,      
                                   soyisim=:soyisim,
                                   alan_kodu=:alan_kodu,
                                   eposta=:eposta,
                                   telefon=:telefon,
                                   ulke=:ulke,
                                   sehir=:sehir,
                                   ilce=:ilce,
                                   postakodu=:postakodu,
                                   adresbilgisi=:adresbilgisi,
                                   secili=:secili
                                                 WHERE adres_id={$adresNo}      
                                                ");
                                                $sonuc = $guncelle->execute(array(
                                                    'baslik' => $baslik,
                                                    'isim' => $isim,
                                                    'soyisim' => $soyisim,
                                                    'alan_kodu' => $alankodu,
                                                    'eposta' => $eposta,
                                                    'telefon' => $telefon,
                                                    'ulke' => $ulke,
                                                    'sehir' => $sehir,
                                                    'ilce' => $ilce,
                                                    'postakodu' => $postakodu,
                                                    'adresbilgisi' => $adres,
                                                    'secili' => $varsayilan
                                                ));
                                                if($sonuc){
                                                    if($returnValue == 'cart'  ) {
                                                        $_SESSION['adres_alert'] = 'success_edit';
                                                        header('Location:'.$ayar['site_url'].'teslimat/');
                                                    }
                                                    if($returnValue == 'account' ) {
                                                        $_SESSION['adres_alert'] = 'success_edit';
                                                        header('Location:'.$ayar['site_url'].'hesabim/adresler/');
                                                    }
                                                }else{
                                                    echo 'Veritabanı Hatası';
                                                }



                                            }else{
                                                echo 'Veritabanı Hatası';
                                            }
                                        }
                                        if($varsayilan == '0'  ) {
                                            $guncelle = $db->prepare("UPDATE uyeler_adres SET
                                   baslik=:baslik, 
                                   tc_no=:tc_no,
                                   isim=:isim,      
                                   soyisim=:soyisim,
                                   alan_kodu=:alan_kodu,
                                   eposta=:eposta,
                                   telefon=:telefon,
                                   ulke=:ulke,
                                   sehir=:sehir,
                                   ilce=:ilce,
                                   postakodu=:postakodu,
                                   adresbilgisi=:adresbilgisi,
                                   secili=:secili
                                                 WHERE adres_id={$adresNo}      
                                                ");
                                            $sonuc = $guncelle->execute(array(
                                                'baslik' => $baslik,
                                                'tc_no' => trim(strip_tags($_POST['tcno'])),
                                                'isim' => $isim,
                                                'soyisim' => $soyisim,
                                                'alan_kodu' => $alankodu,
                                                'eposta' => $eposta,
                                                'telefon' => $telefon,
                                                'ulke' => $ulke,
                                                'sehir' => $sehir,
                                                'ilce' => $ilce,
                                                'postakodu' => $postakodu,
                                                'adresbilgisi' => $adres,
                                                'secili' => $varsayilan
                                            ));
                                            if($sonuc){
                                                if($returnValue == 'cart'  ) {
                                                    $_SESSION['adres_alert'] = 'success_edit';
                                                    header('Location:'.$ayar['site_url'].'teslimat/');
                                                }
                                                if($returnValue == 'account' ) {
                                                    $_SESSION['adres_alert'] = 'success_edit';
                                                    header('Location:'.$ayar['site_url'].'hesabim/adresler/');
                                                }
                                            }else{
                                                echo 'Veritabanı Hatası';
                                            }
                                        }
                                    }else{
                                        $_SESSION['adres_alert'] = 'tczorunlu';
                                        header('Location:'.$ayar['site_url'].'hesabim/adres-duzenle/'.$adresNo.'/');
                                    }
                                }
                            }
                        }else{
                            $_SESSION['adres_alert'] = 'eposta';
                            header('Location:'.$ayar['site_url'].'hesabim/adres-duzenle/'.$adresNo.'/');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    $_SESSION['adres_alert'] = 'empty';
                    header('Location:'.$ayar['site_url'].'hesabim/adres-duzenle/'.$adresNo.'/');
                }

            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }

    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
    }else{
        $_SESSION['demo_alert'] = 'demo';
        if($returnValue == 'cart'  ) {
            header('Location:'.$ayar['site_url'].'teslimat/');
        }
        if($returnValue == 'account' ) {
            header('Location:'.$ayar['site_url'].'hesabim/adresler/');
        }
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>