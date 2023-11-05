<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
include "includes/func/cartcalc.php";
if($_POST) {
 if(isset($_POST['paymentValueGo'])  ) {
    if ($userSorgusu->rowCount() > '0') {
        /////////////////////////* ÜYE GİRİŞİ YAPILMIŞ ///////////////////////////////////////////*/

        $adres_no = trim(strip_tags($_POST['adres_no']));
        $siparisnotu = trim(strip_tags($_POST['siparis_notu']));
        $odemetur = trim(strip_tags($_POST['odeme_tipi']));
        $sozlesmeonay = trim(strip_tags($_POST['sozlesme_onayi']));
        $siparis_id = mt_rand(0,(int) 999999999999);
        $_SESSION['siparis_islem_id'] = $siparis_id;

        /* Adres Bilgisi Çek */
        $adresBilgisiCek = $db->prepare("select * from uyeler_adres where uye_id=:uye_id and adres_id=:adres_id ");
        $adresBilgisiCek->execute(array(
            'uye_id' => $userCek['id'],
            'adres_id' => $adres_no
        ));
        $adresrow = $adresBilgisiCek->fetch(PDO::FETCH_ASSOC);

        $isim = $adresrow['isim'];
        $soyisim = $adresrow['soyisim'];
        $tc_no = $adresrow['tc_no'];
        $alankodu  = $adresrow['alan_kodu'];
        $telefon  = $adresrow['telefon'];
        $eposta = $adresrow['eposta'];
        $ulke = $adresrow['ulke'];
        $sehir = $adresrow['sehir'];
        $ilce = $adresrow['ilce'];
        $postakodu = $adresrow['postakodu'];
        $adres = $adresrow['adresbilgisi'];
        $siparisnotu = trim(strip_tags($_POST['siparis_notu']));
        $faturaadresdurum = '1';
        $faturaturu =  $adresrow['fatura_turu'];
        $fatura_isim = $adresrow['fatura_isim'];
        $fatura_soyisim = $adresrow['fatura_soyisim'];
        $fatura_tc = $adresrow['fatura_tc'];
        $fatura_firma_unvan = $adresrow['fatura_firma_unvan'];
        $fatura_vergi_dairesi = $adresrow['fatura_vergi_dairesi'];
        $fatura_vergi_no = $adresrow['fatura_vergi_no'];
        $fatura_ulke = $adresrow['fatura_ulke'];
        $fatura_il= $adresrow['fatura_sehir'];
        $fatura_ilce = $adresrow['fatura_ilce'];
        $fatura_postakodu = $adresrow['fatura_postakodu'];
        $fatura_adresbilgisi = $adresrow['fatura_adresi'];
        /* Telefon formatını düzleştir */
        function telefonduzformat($duztelefon) {
            $tr = array('(',')','-',' ');
            $eng = array('','','','');
            $duztelefon = str_replace($tr,$eng,$duztelefon);
            $duztelefon = strtolower($duztelefon);
            $duztelefon = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $duztelefon);
            $duztelefon = preg_replace('/\s+/', '-', $duztelefon);
            $duztelefon = preg_replace('|-+|', '-', $duztelefon);
            $duztelefon = preg_replace('/#/', '', $duztelefon);
            $duztelefon = str_replace('\'', '-', $duztelefon);
            $duztelefon = str_replace('.', '', $duztelefon);
            $duztelefon = trim($duztelefon, '-');
            return $duztelefon;
        }
        /* Telefon formatını düzleştir SON */
        $yenitelefon = telefonduzformat($telefon);

        /*  <========SON=========>>> Adres Bilgisi Çek SON */

        if($adres_no) {
            if($adresBilgisiCek->rowCount()> '0'  ) {
                if($sozlesmeonay == '1'  ) {
                    if($odemetur == '1' || $odemetur == '2' || $odemetur == '3' || $odemetur == '4'  || $odemetur == 'freeShip' ) {//todo burayı üye girişsiz için de ekle
                        if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {
                            if($odemetur == 'freeShip') {
                                if($odemeayar['ucretsiz_alisveris'] == '1' ) {
                                    if($demo != '1'  ) {
                                        include 'includes/post/siparisdb/ucretsiz_alisveris_db.php';
                                        header('Location:'.$siteurl.'siparis/ucretsiz-siparis/?sID='.$siparis_id.'');
                                    }else{
                                        header('Location:'.$siteurl.'samplesuccess/');
                                    }
                                }else{
                                    header('Location:'.$siteurl.'404');
                                }
                            }else{
                                header('Location:'.$siteurl.'404');
                            }
                        }else{
                            if($odemetur == '1') {
                                if($odemeayar['kredi_kart'] == '1' ) {
                                    include 'includes/post/siparisdb/kredi_kart_order_to_db.php';
                                    header('Location:'.$siteurl.'odeme/');
                                }else{
                                    header('Location:'.$siteurl.'404');
                                }
                            }
                            if($odemetur == '2'  ) {
                                if($odemeayar['havale_eft'] == '1' ) {
                                    if($demo != '1'  ) {
                                        include 'includes/post/siparisdb/havale_eft_order_to_db.php';
                                        header('Location:'.$siteurl.'siparis/havale-eft/?sID='.$siparis_id.'');
                                    }else{
                                        header('Location:'.$siteurl.'samplesuccess/');
                                    }
                                }else{
                                    header('Location:'.$siteurl.'404');
                                }
                            }
                            if($odemetur == '3'  ) {
                                if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                    if($odemeayar['kapida_odeme_kart'] == '1' ) {
                                        if($demo != '1'  ) {
                                            $_SESSION['kapida_odeme'] = '3';
                                            include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                            header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                        }else{
                                            header('Location:'.$siteurl.'samplesuccess/');
                                        }
                                    }else{
                                        header('Location:'.$siteurl.'404');
                                    }
                                }else{
                                    header('Location:'.$siteurl.'404');
                                }
                            }
                            if($odemetur == '4') {
                                if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                    if($odemeayar['kapida_odeme_nakit'] == '1' ) {
                                        if($demo != '1'  ) {
                                            $_SESSION['kapida_odeme'] = '4';
                                            include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                            header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                        }else{
                                            header('Location:'.$siteurl.'samplesuccess/');
                                        }
                                    }else{
                                        header('Location:'.$siteurl.'404');
                                    }
                                }else{
                                    header('Location:'.$siteurl.'404');
                                }
                            }
                        }
                    }else{
                        header('Location:'.$siteurl.'404');
                    }
                }else{
                    $_SESSION['teslimat_alert'] = 'sozlesmeHata';
                    header('Location:'.$siteurl.'teslimat/');
                }
            }else{
                $_SESSION['teslimat_alert'] = 'adresorunu';
                header('Location:'.$siteurl.'teslimat/');
            }
        }else{
            header('Location:'.$siteurl.'404');
        }
        /////////////////////////* ÜYE GİRİŞİ YAPILMIŞ SON ///////////////////////////////////////////*/
        ///
        ///
        ///
    } else {




        /////////////////////////* ÜYE GİRİŞSİZ ALIŞVERİŞ İÇİN ///////////////////////////////////////////*/
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
        $siparisnotu = trim(strip_tags($_POST['siparis_notu']));
        $faturaadresdurum = trim(strip_tags($_POST['fatura_farkli']));
        $odemetur = trim(strip_tags($_POST['odeme_tipi']));
        $siparis_id = mt_rand(0,(int) 999999999999);
        $_SESSION['siparis_islem_id'] = $siparis_id;
        $tc = trim(strip_tags($_POST['tcno']));
        $sozlesmeonay = trim(strip_tags($_POST['sozlesme_onayi']));


        /* Telefon formatını düzleştir */
        function telefonduzformat($duztelefon) {
            $tr = array('(',')','-',' ');
            $eng = array('','','','');
            $duztelefon = str_replace($tr,$eng,$duztelefon);
            $duztelefon = strtolower($duztelefon);
            $duztelefon = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $duztelefon);
            $duztelefon = preg_replace('/\s+/', '-', $duztelefon);
            $duztelefon = preg_replace('|-+|', '-', $duztelefon);
            $duztelefon = preg_replace('/#/', '', $duztelefon);
            $duztelefon = str_replace('\'', '-', $duztelefon);
            $duztelefon = str_replace('.', '', $duztelefon);
            $duztelefon = trim($duztelefon, '-');
            return $duztelefon;
        }
        /* Telefon formatını düzleştir SON */
        $yenitelefon = telefonduzformat($telefon);

        if($isim && $soyisim && $telefon && $eposta && $ulke && $sehir && $ilce  && $adres ) {
            if($odemetur == '1' || $odemetur == '2' || $odemetur == '3' || $odemetur == '4' || $odemetur == 'freeShip' ) {
                if($sozlesmeonay == '1'  ) {
                    if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){

                        if($odemeayar['faturasiz_teslimat'] == '0' ) {
                            /* FATURA BİLGİSİ ZORUNLU */
                            if($faturaadresdurum == '0'  ) {
                                /* Fatura adresi ve bilgileri teslimat bilgiler ile eşit seçilmiş */
                                    if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {
                                        if($odemetur == 'freeShip') {
                                            if($odemeayar['ucretsiz_alisveris'] == '1' ) {
                                                if($demo != '1'  ) {
                                                    include 'includes/post/siparisdb/ucretsiz_alisveris_db.php';
                                                    header('Location:'.$siteurl.'siparis/ucretsiz-siparis/?sID='.$siparis_id.'');
                                                }else{
                                                    header('Location:'.$siteurl.'samplesuccess/');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                    }else{
                                        if($odemetur == '1') {
                                            if($odemeayar['kredi_kart'] == '1' ) {
                                                    include 'includes/post/siparisdb/kredi_kart_order_to_db.php';
                                                    header('Location:'.$siteurl.'odeme/');
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                        if($odemetur == '2'  ) {
                                            if($odemeayar['havale_eft'] == '1' ) {
                                                if($demo != '1'  ) {
                                                    include 'includes/post/siparisdb/havale_eft_order_to_db.php';
                                                    header('Location:'.$siteurl.'siparis/havale-eft/?sID='.$siparis_id.'');
                                                }else{
                                                    header('Location:'.$siteurl.'samplesuccess/');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                        if($odemetur == '3'  ) {
                                            if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                                if($odemeayar['kapida_odeme_kart'] == '1' ) {
                                                    if($demo != '1'  ) {
                                                        $_SESSION['kapida_odeme'] = '3';
                                                        include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                        header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                    }else{
                                                        header('Location:'.$siteurl.'samplesuccess/');
                                                    }
                                                }else{
                                                    header('Location:'.$siteurl.'404');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                        if($odemetur == '4') {
                                            if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                                if($odemeayar['kapida_odeme_nakit'] == '1' ) {
                                                    if($demo != '1'  ) {
                                                        $_SESSION['kapida_odeme'] = '4';
                                                        include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                        header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                    }else{
                                                        header('Location:'.$siteurl.'samplesuccess/');
                                                    }
                                                }else{
                                                    header('Location:'.$siteurl.'404');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                    }
                                /* Fatura adresi ve bilgileri teslimat bilgiler ile eşit SON */
                            }else{
                                /* Fatura adresi ayrı girilecek */

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
                                if($_POST['fatura_turu'] == 'fatura_turu1'  ) {
                                    $faturaturu = '1';
                                }
                                if($_POST['fatura_turu'] == 'fatura_turu2'  ) {
                                    $faturaturu = '2';
                                }

                                if(trim(strip_tags($_POST['fatura_turu'])) == 'fatura_turu1' || trim(strip_tags($_POST['fatura_turu'])) == 'fatura_turu2' ) {
                                    if(trim(strip_tags($_POST['fatura_turu'])) == 'fatura_turu1'  ) {
                                        /* Bireysel Fatura */
                                        if($fatura_isim && $fatura_soyisim && $fatura_tc  && $fatura_adresbilgisi && $faturaturu) {

                                            if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {
                                                if($odemetur == 'freeShip') {
                                                    if($odemeayar['ucretsiz_alisveris'] == '1' ) {
                                                        if($demo != '1'  ) {
                                                            include 'includes/post/siparisdb/ucretsiz_alisveris_db.php';
                                                            header('Location:'.$siteurl.'siparis/ucretsiz-siparis/?sID='.$siparis_id.'');
                                                        }else{
                                                            header('Location:'.$siteurl.'samplesuccess/');
                                                        }
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                            }else{
                                                if($odemetur == '1') {
                                                    if($odemeayar['kredi_kart'] == '1' ) {
                                                        include 'includes/post/siparisdb/kredi_kart_order_to_db.php';
                                                        header('Location:'.$siteurl.'odeme/');
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                                if($odemetur == '2'  ) {
                                                    if($odemeayar['havale_eft'] == '1' ) {
                                                        if($demo != '1'  ) {
                                                            include 'includes/post/siparisdb/havale_eft_order_to_db.php';
                                                            header('Location:'.$siteurl.'siparis/havale-eft/?sID='.$siparis_id.'');
                                                        }else{
                                                            header('Location:'.$siteurl.'samplesuccess/');
                                                        }
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                                if($odemetur == '3'  ) {
                                                    if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                                        if($odemeayar['kapida_odeme_kart'] == '1' ) {
                                                            if($demo != '1'  ) {
                                                                $_SESSION['kapida_odeme'] = '3';
                                                                include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                                header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                            }else{
                                                                header('Location:'.$siteurl.'samplesuccess/');
                                                            }
                                                        }else{
                                                            header('Location:'.$siteurl.'404');
                                                        }
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                                if($odemetur == '4') {
                                                    if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                                        if($odemeayar['kapida_odeme_nakit'] == '1' ) {
                                                            if($demo != '1'  ) {
                                                                $_SESSION['kapida_odeme'] = '4';
                                                                include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                                header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                            }else{
                                                                header('Location:'.$siteurl.'samplesuccess/');
                                                            }
                                                        }else{
                                                            header('Location:'.$siteurl.'404');
                                                        }
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                            }

                                        }else{
                                            $_SESSION['teslimat_alert'] = 'faturazorunlu';
                                            header('Location:'.$siteurl.'teslimat/');
                                        }
                                        /* Bireysel Fatura SON */
                                    }
                                    if(trim(strip_tags($_POST['fatura_turu'])) == 'fatura_turu2'  ) {
                                        /* Kurumsal Fatura */
                                        if($fatura_firma_unvan && $fatura_vergi_dairesi && $fatura_vergi_no  && $fatura_adresbilgisi ) {

                                            if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {
                                                if($odemetur == 'freeShip') {
                                                    if($odemeayar['ucretsiz_alisveris'] == '1' ) {
                                                        if($demo != '1'  ) {
                                                            include 'includes/post/siparisdb/ucretsiz_alisveris_db.php';
                                                            header('Location:'.$siteurl.'siparis/ucretsiz-siparis/?sID='.$siparis_id.'');
                                                        }else{
                                                            header('Location:'.$siteurl.'samplesuccess/');
                                                        }
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                            }else{
                                                if($odemetur == '1') {
                                                    if($odemeayar['kredi_kart'] == '1' ) {
                                                        include 'includes/post/siparisdb/kredi_kart_order_to_db.php';
                                                        header('Location:'.$siteurl.'odeme/');
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                                if($odemetur == '2'  ) {
                                                    if($odemeayar['havale_eft'] == '1' ) {
                                                        if($demo != '1'  ) {
                                                            include 'includes/post/siparisdb/havale_eft_order_to_db.php';
                                                            header('Location:'.$siteurl.'siparis/havale-eft/?sID='.$siparis_id.'');
                                                        }else{
                                                            header('Location:'.$siteurl.'samplesuccess/');
                                                        }
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                                if($odemetur == '3'  ) {
                                                    if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                                        if($odemeayar['kapida_odeme_kart'] == '1' ) {
                                                            if($demo != '1'  ) {
                                                                $_SESSION['kapida_odeme'] = '3';
                                                                include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                                header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                            }else{
                                                                header('Location:'.$siteurl.'samplesuccess/');
                                                            }
                                                        }else{
                                                            header('Location:'.$siteurl.'404');
                                                        }
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                                if($odemetur == '4') {
                                                    if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                                        if($odemeayar['kapida_odeme_nakit'] == '1' ) {
                                                            if($demo != '1'  ) {
                                                                $_SESSION['kapida_odeme'] = '4';
                                                                include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                                header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                            }else{
                                                                header('Location:'.$siteurl.'samplesuccess/');
                                                            }
                                                        }else{
                                                            header('Location:'.$siteurl.'404');
                                                        }
                                                    }else{
                                                        header('Location:'.$siteurl.'404');
                                                    }
                                                }
                                            }

                                        }else{
                                            $_SESSION['teslimat_alert'] = 'faturazorunlu';
                                            header('Location:'.$siteurl.'teslimat/');
                                        }
                                        /* Kurumsal Fatura SON */
                                    }
                                }else{
                                    header('Location:'.$siteurl.'404');
                                }

                                /* Fatura adresi ayrı girilecek SON */
                            }
                            /* FATURA BİLGİSİ ZORUNLU SON */
                        }else{

                            /* Faturasız alışveriş aktif */
                            if($odemeayar['faturasiz_tc_zorunlu'] == '0'  ) {
                                if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {
                                    if($odemetur == 'freeShip') {
                                        if($odemeayar['ucretsiz_alisveris'] == '1' ) {
                                            if($demo != '1'  ) {
                                                include 'includes/post/siparisdb/ucretsiz_alisveris_db.php';
                                                header('Location:'.$siteurl.'siparis/ucretsiz-siparis/?sID='.$siparis_id.'');
                                            }else{
                                                header('Location:'.$siteurl.'samplesuccess/');
                                            }
                                        }else{
                                            header('Location:'.$siteurl.'404');
                                        }
                                    }
                                }else{
                                    if($odemetur == '1') {
                                        if($odemeayar['kredi_kart'] == '1' ) {
                                            include 'includes/post/siparisdb/kredi_kart_order_to_db.php';
                                            header('Location:'.$siteurl.'odeme/');
                                        }else{
                                            header('Location:'.$siteurl.'404');
                                        }
                                    }
                                    if($odemetur == '2'  ) {
                                        if($odemeayar['havale_eft'] == '1' ) {
                                            if($demo != '1'  ) {
                                                include 'includes/post/siparisdb/havale_eft_order_to_db.php';
                                                header('Location:'.$siteurl.'siparis/havale-eft/?sID='.$siparis_id.'');
                                            }else{
                                                header('Location:'.$siteurl.'samplesuccess/');
                                            }
                                        }else{
                                            header('Location:'.$siteurl.'404');
                                        }
                                    }
                                    if($odemetur == '3'  ) {
                                        if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                            if($odemeayar['kapida_odeme_kart'] == '1' ) {
                                                if($demo != '1'  ) {
                                                    $_SESSION['kapida_odeme'] = '3';
                                                    include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                    header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                }else{
                                                    header('Location:'.$siteurl.'samplesuccess/');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }else{
                                            header('Location:'.$siteurl.'404');
                                        }
                                    }
                                    if($odemetur == '4') {
                                        if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                            if($odemeayar['kapida_odeme_nakit'] == '1' ) {
                                                if($demo != '1'  ) {
                                                    $_SESSION['kapida_odeme'] = '4';
                                                    include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                    header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                }else{
                                                    header('Location:'.$siteurl.'samplesuccess/');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }else{
                                            header('Location:'.$siteurl.'404');
                                        }
                                    }
                                }
                            }else{
                                if(trim(strip_tags($_POST['tcno']))) {
                                    if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {
                                        if($odemetur == 'freeShip') {
                                            if($odemeayar['ucretsiz_alisveris'] == '1' ) {
                                                if($demo != '1'  ) {
                                                    include 'includes/post/siparisdb/ucretsiz_alisveris_db.php';
                                                    header('Location:'.$siteurl.'siparis/ucretsiz-siparis/?sID='.$siparis_id.'');
                                                }else{
                                                    header('Location:'.$siteurl.'samplesuccess/');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                    }else{
                                        if($odemetur == '1') {
                                            if($odemeayar['kredi_kart'] == '1' ) {
                                                include 'includes/post/siparisdb/kredi_kart_order_to_db.php';
                                                header('Location:'.$siteurl.'odeme/');
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                        if($odemetur == '2'  ) {
                                            if($odemeayar['havale_eft'] == '1' ) {
                                                if($demo != '1'  ) {
                                                    include 'includes/post/siparisdb/havale_eft_order_to_db.php';
                                                    header('Location:'.$siteurl.'siparis/havale-eft/?sID='.$siparis_id.'');
                                                }else{
                                                    header('Location:'.$siteurl.'samplesuccess/');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                        if($odemetur == '3'  ) {
                                            if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                                if($odemeayar['kapida_odeme_kart'] == '1' ) {
                                                    if($demo != '1'  ) {
                                                        $_SESSION['kapida_odeme'] = '3';
                                                        include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                        header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                    }else{
                                                        header('Location:'.$siteurl.'samplesuccess/');
                                                    }
                                                }else{
                                                    header('Location:'.$siteurl.'404');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                        if($odemetur == '4') {
                                            if($odemeayar['kapida_odeme_limit'] <= ($aratoplam+$kdvtoplami) ) {
                                                if($odemeayar['kapida_odeme_nakit'] == '1' ) {
                                                    if($demo != '1'  ) {
                                                        $_SESSION['kapida_odeme'] = '4';
                                                        include 'includes/post/siparisdb/kapida_odeme_order_to_db.php';
                                                        header('Location:'.$siteurl.'siparis/kapida-odeme/?sID='.$siparis_id.'');
                                                    }else{
                                                        header('Location:'.$siteurl.'samplesuccess/');
                                                    }
                                                }else{
                                                    header('Location:'.$siteurl.'404');
                                                }
                                            }else{
                                                header('Location:'.$siteurl.'404');
                                            }
                                        }
                                    }
                                }else{
                                    $_SESSION['teslimat_alert'] = 'faturasiztczorunlu';
                                    header('Location:'.$siteurl.'teslimat/');
                                }
                            }
                            /* Faturasız alışveriş aktif SON */

                        }
                    }else{
                        $_SESSION['teslimat_alert'] = 'emailhata';
                        header('Location:'.$siteurl.'teslimat/');
                    }
                }else{
                    $_SESSION['teslimat_alert'] = 'sozlesmeHata';
                    header('Location:'.$siteurl.'teslimat/');
                }
            }else{
                header('Location:'.$siteurl.'404');
            }
        }else{
            $_SESSION['teslimat_alert'] = 'empty';
            header('Location:'.$siteurl.'teslimat/');
        }

        /* Kayıt Temp Form */
        $_SESSION['form_temp'] = array(
            'isim' => $isim,
            'soyisim' => $soyisim,
            'telefon' => $telefon,
            'eposta' => $eposta,
            'adres' => $adres,
            'tc' => $tc,
            'postakodu' => $postakodu,
            'fatura_tip' => $_POST['fatura_turu'],
            'fatura_isim' => $_POST['fatura_isim'],
            'fatura_soyisim' => $_POST['fatura_soyisim'],
            'fatura_tc' => $_POST['fatura_tc'],
            'fatura_adresi' => $_POST['fatura_adresbilgisi'],
            'fatura_posta' => $_POST['fatura_postakodu'],
            'fatura_unvan' => $_POST['fatura_firma_unvan'],
            'fatura_vd' => $_POST['fatura_vergi_dairesi'],
            'fatura_vn' => $_POST['fatura_vergi_no'],
            'siparis_notu' => $_POST['siparis_notu'],
        );
        /*  <========SON=========>>> Kayıt Temp Form SON */

        
        /////////////////////////* ÜYE GİRİŞSİZ ALIŞVERİŞ İÇİN SON ///////////////////////////////////////////*/
        ///
        ///
        ///
    }
 }else{
     header('Location:'.$siteurl.'404');
 }
}else{
    header('Location:'.$siteurl.'404');
}
?>