<?php
if($_POST && $userSorgusu->rowCount()>'0' ){

    $tcno = trim(strip_tags($_POST['tc_no']));
    $isim = trim(strip_tags($_POST['name']));
    $soyisim = trim(strip_tags($_POST['surname']));
    $eposta = $userCek['eposta'];
    $telefon = trim(strip_tags($userCek['telefon']));
    $sifre = trim(strip_tags($_POST['password']));
    $uyetip = trim(strip_tags($_POST['uye_tip']));
    $firma = trim(strip_tags($_POST['firma_unvan']));
    $vergidairesi = trim(strip_tags($_POST['vergi_dairesi']));
    $vergino = trim(strip_tags($_POST['vergi_no']));
    $ip = $_SERVER["REMOTE_ADDR"];
    $timestamp = date('Y-m-d G:i:s');



    if($demo != '1'  ){
        if(trim(strip_tags($_POST['smsonay'])) == '1'  ) {
            $smsekle = '1';
        }else{
            $smsekle = '0';
        }

        if(trim(strip_tags($_POST['epostaonay'])) == '1'  ) {
            $epostaekle = '1';
        }else{
            $epostaekle = '0';
        }

        if($uyeayar['basit_form'] == '0' ) {

            if($uyetip == '1' || $uyetip == '2'  ) {

                if($uyetip == '1'  ) {
                    if($isim && $soyisim ) {
                        if($tcno == !null  ) {
                            if(strlen($tcno) != '11'  ) {
                                $_SESSION['ayardegis_durum'] = 'tcuzunluk';
                                header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
                                exit();
                            }
                        }
                        $guncelle = $db->prepare("UPDATE uyeler SET
                                    isim=:isim,
                                    soyisim=:soyisim,
                                    uye_tip=:uye_tip,
                                    ip=:ip,
                                    tc_no=:tc_no,
                                    sms_ekle=:sms_ekle,
                                    eposta_ekle=:eposta_ekle
                         WHERE id={$userCek['id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'isim' => $isim,
                            'soyisim' => $soyisim,
                            'uye_tip' => $uyetip,
                            'ip' => $ip,
                            'tc_no' => $tcno,
                            'sms_ekle' => $smsekle,
                            'eposta_ekle' => $epostaekle
                        ));
                        if($sonuc){
                            $_SESSION['ayardegis_durum'] = 'success';
                            header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
                            /* Bültenlere Ekleme Onayı */
                            if($smsekle == '1') {
                                if($uyeayar['sms_ekle'] == '1'  ) {
                                    $smsSorgusu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                                    $smsSorgusu->execute(array(
                                        'gsm' => $telefon
                                    ));
                                    if($smsSorgusu->rowCount()<='0'  ) {
                                        $kaydet = $db->prepare("INSERT INTO sms_numaralar SET
                                                     isim=:isim,      
                                                     gsm=:gsm
                                                    ");
                                        $sonuc = $kaydet->execute(array(
                                            'isim' => $isim.' '.$soyisim,
                                            'gsm' => $telefon
                                        ));
                                    }
                                }
                            }
                            if($smsekle == '0') {
                                if($uyeayar['sms_ekle'] == '1'  ) {
                                    $smsSorgusu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                                    $smsSorgusu->execute(array(
                                        'gsm' => $telefon
                                    ));
                                    if($smsSorgusu->rowCount() >'0'  ) {
                                        $silmeislem = $db->prepare("DELETE from sms_numaralar WHERE gsm=:gsm");
                                        $silmeislem->execute(array(
                                            'gsm' => $telefon
                                        ));
                                    }
                                }
                            }
                            if($epostaekle == '1') {
                                if($uyeayar['eposta_ekle'] == '1'  ) {
                                    $postaSorgusu = $db->prepare("select * from ebulten where eposta=:eposta ");
                                    $postaSorgusu->execute(array(
                                        'eposta' => $eposta
                                    ));
                                    if($postaSorgusu->rowCount()<='0'  ) {
                                        $kaydet = $db->prepare("INSERT INTO ebulten SET
                                                     eposta=:eposta,      
                                                     tarih=:tarih
                                                    ");
                                        $sonuc = $kaydet->execute(array(
                                            'eposta' => $eposta,
                                            'tarih' => $timestamp
                                        ));
                                    }
                                }
                            }
                            if($epostaekle == '0') {
                                if($uyeayar['eposta_ekle'] == '1'  ) {
                                    $postaSorgusu = $db->prepare("select * from ebulten where eposta=:eposta ");
                                    $postaSorgusu->execute(array(
                                        'eposta' => $eposta
                                    ));
                                    if($postaSorgusu->rowCount()>'0'  ) {
                                        $silmeislem = $db->prepare("DELETE from ebulten WHERE eposta=:eposta");
                                        $silmeislem->execute(array(
                                            'eposta' => $eposta
                                        ));
                                    }
                                }
                            }
                            /*  <========SON=========>>> Bültenlere Ekleme Onayı SON */
                        }else{
                            echo 'Veritabanı Hatası';
                        }

                    }else{
                        $_SESSION['ayardegis_durum'] = 'empty';
                        header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
                    }
                }
                if($uyetip == '2'  ) {

                    if($isim && $soyisim && $vergino  ) {
                        $guncelle = $db->prepare("UPDATE uyeler SET
                                    isim=:isim,
                                    soyisim=:soyisim,
                                    uye_tip=:uye_tip,
                                    ip=:ip,
                                    vergi_dairesi=:vergi_dairesi,
                                    vergi_no=:vergi_no,
                                    firma_unvan=:firma_unvan,
                                    sms_ekle=:sms_ekle,
                                    eposta_ekle=:eposta_ekle
                         WHERE id={$userCek['id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'isim' => $isim,
                            'soyisim' => $soyisim,
                            'uye_tip' => $uyetip,
                            'ip' => $ip,
                            'vergi_dairesi' => $vergidairesi,
                            'vergi_no' => $vergino,
                            'firma_unvan' => $firma,
                            'sms_ekle' => $smsekle,
                            'eposta_ekle' => $epostaekle
                        ));
                        if($sonuc){
                            $_SESSION['ayardegis_durum'] = 'success';
                            header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
                            /* Bültenlere Ekleme Onayı */
                            if($smsekle == '1') {
                                if($uyeayar['sms_ekle'] == '1'  ) {
                                    $smsSorgusu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                                    $smsSorgusu->execute(array(
                                        'gsm' => $telefon
                                    ));
                                    if($smsSorgusu->rowCount()<='0'  ) {
                                        $kaydet = $db->prepare("INSERT INTO sms_numaralar SET
                                                     isim=:isim,      
                                                     gsm=:gsm
                                                    ");
                                        $sonuc = $kaydet->execute(array(
                                            'isim' => $isim.' '.$soyisim,
                                            'gsm' => $telefon
                                        ));
                                    }
                                }
                            }
                            if($smsekle == '0') {
                                if($uyeayar['sms_ekle'] == '1'  ) {
                                    $smsSorgusu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                                    $smsSorgusu->execute(array(
                                        'gsm' => $telefon
                                    ));
                                    if($smsSorgusu->rowCount() >'0'  ) {
                                        $silmeislem = $db->prepare("DELETE from sms_numaralar WHERE gsm=:gsm");
                                        $silmeislem->execute(array(
                                            'gsm' => $telefon
                                        ));
                                    }
                                }
                            }
                            if($epostaekle == '1') {
                                if($uyeayar['eposta_ekle'] == '1'  ) {
                                    $postaSorgusu = $db->prepare("select * from ebulten where eposta=:eposta ");
                                    $postaSorgusu->execute(array(
                                        'eposta' => $eposta
                                    ));
                                    if($postaSorgusu->rowCount()<='0'  ) {
                                        $kaydet = $db->prepare("INSERT INTO ebulten SET
                                                     eposta=:eposta,      
                                                     tarih=:tarih
                                                    ");
                                        $sonuc = $kaydet->execute(array(
                                            'eposta' => $eposta,
                                            'tarih' => $timestamp
                                        ));
                                    }
                                }
                            }
                            if($epostaekle == '0') {
                                if($uyeayar['eposta_ekle'] == '1'  ) {
                                    $postaSorgusu = $db->prepare("select * from ebulten where eposta=:eposta ");
                                    $postaSorgusu->execute(array(
                                        'eposta' => $eposta
                                    ));
                                    if($postaSorgusu->rowCount()>'0'  ) {
                                        $silmeislem = $db->prepare("DELETE from ebulten WHERE eposta=:eposta");
                                        $silmeislem->execute(array(
                                            'eposta' => $eposta
                                        ));
                                    }
                                }
                            }
                            /*  <========SON=========>>> Bültenlere Ekleme Onayı SON */
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['ayardegis_durum'] = 'empty';
                        header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
                    }
                }






        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }

    if($uyeayar['basit_form'] == '1' ) {
        if($isim && $soyisim ) {
            $guncelle = $db->prepare("UPDATE uyeler SET
                                    isim=:isim,
                                    soyisim=:soyisim,
                                    uye_tip=:uye_tip,
                                    ip=:ip,
                                    sms_ekle=:sms_ekle,
                                    eposta_ekle=:eposta_ekle
                         WHERE id={$userCek['id']}      
                        ");
            $sonuc = $guncelle->execute(array(
                'isim' => $isim,
                'soyisim' => $soyisim,
                'uye_tip' => '1',
                'ip' => $ip,
                'sms_ekle' => $smsekle,
                'eposta_ekle' => $epostaekle
            ));
            if($sonuc){
                $_SESSION['ayardegis_durum'] = 'success';
                header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
                /* Bültenlere Ekleme Onayı */
                if($smsekle == '1') {
                    if($uyeayar['sms_ekle'] == '1'  ) {
                        $smsSorgusu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                        $smsSorgusu->execute(array(
                            'gsm' => $telefon
                        ));
                        if($smsSorgusu->rowCount()<='0'  ) {
                            $kaydet = $db->prepare("INSERT INTO sms_numaralar SET
                                                     isim=:isim,      
                                                     gsm=:gsm
                                                    ");
                            $sonuc = $kaydet->execute(array(
                                'isim' => $isim.' '.$soyisim,
                                'gsm' => $telefon
                            ));
                        }
                    }
                }
                if($smsekle == '0') {
                    if($uyeayar['sms_ekle'] == '1'  ) {
                        $smsSorgusu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                        $smsSorgusu->execute(array(
                            'gsm' => $telefon
                        ));
                        if($smsSorgusu->rowCount() >'0'  ) {
                            $silmeislem = $db->prepare("DELETE from sms_numaralar WHERE gsm=:gsm");
                            $silmeislem->execute(array(
                                'gsm' => $telefon
                            ));
                        }
                    }
                }
                if($epostaekle == '1') {
                    if($uyeayar['eposta_ekle'] == '1'  ) {
                        $postaSorgusu = $db->prepare("select * from ebulten where eposta=:eposta ");
                        $postaSorgusu->execute(array(
                            'eposta' => $eposta
                        ));
                        if($postaSorgusu->rowCount()<='0'  ) {
                            $kaydet = $db->prepare("INSERT INTO ebulten SET
                                                     eposta=:eposta,      
                                                     tarih=:tarih
                                                    ");
                            $sonuc = $kaydet->execute(array(
                                'eposta' => $eposta,
                                'tarih' => $timestamp
                            ));
                        }
                    }
                }
                if($epostaekle == '0') {
                    if($uyeayar['eposta_ekle'] == '1'  ) {
                        $postaSorgusu = $db->prepare("select * from ebulten where eposta=:eposta ");
                        $postaSorgusu->execute(array(
                            'eposta' => $eposta
                        ));
                        if($postaSorgusu->rowCount()>'0'  ) {
                            $silmeislem = $db->prepare("DELETE from ebulten WHERE eposta=:eposta");
                            $silmeislem->execute(array(
                                'eposta' => $eposta
                            ));
                        }
                    }
                }
                /*  <========SON=========>>> Bültenlere Ekleme Onayı SON */
            }else{
                echo 'Veritabanı Hatası';
            }
        }else{
            $_SESSION['ayardegis_durum'] = 'empty';
            header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
        }
    }

}else{
    $_SESSION['demo_alert'] = 'demo';
    header('Location:'.$ayar['site_url'].'hesabim/ayarlar/');
}

} else {
    header('Location:'.$ayar['site_url'].'404');
}
?>