<?php
if($_POST){

    if($demo != '1'  ){
        $isim = trim(strip_tags($_POST['name']));
        $soyisim = trim(strip_tags($_POST['surname']));
        $eposta = trim(strip_tags($_POST['emailadress']));
        $telefon = trim(strip_tags($_POST['gsm']));
        $sifre = trim(strip_tags($_POST['password']));
        $uyetip = trim(strip_tags($_POST['uye_tip']));
        $firma = trim(strip_tags($_POST['firma_unvan']));
        $vergidairesi = trim(strip_tags($_POST['vergi_dairesi']));
        $vergino = trim(strip_tags($_POST['vergi_no']));
        $ip = $_SERVER["REMOTE_ADDR"];
        $timestamp = date('Y-m-d G:i:s');
        $timestamp2 = date('Y-m-d');
        if(trim(strip_tags($_POST['smsonay'])) == '1'  ) {
            $smsekle = '1';
        }else{
            $smsekle = '0';
        }

        if($uyeayar['oto_onay'] == '1' ) {
            $onay = '1';
        }else{
            $onay = '0';
        }

        if(trim(strip_tags($_POST['epostaonay'])) == '1'  ) {
            $epostaekle = '1';
        }else{
            $epostaekle = '0';
        }

        if($uyeayar['basit_form'] == '0' ) {
            if($uyetip == '1' || $uyetip == '2'  ) {

                if($uyetip == '1'  ) {
                    if($isim && $soyisim && $eposta && $telefon && $sifre  ) {
                        if(trim(strip_tags($_POST['sozlesme_onayi'])) == '1'   ) {
                            if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){
                                $epostaSorgula = $db->prepare("select * from uyeler where eposta=:eposta ");
                                $epostaSorgula->execute(array(
                                    'eposta' => $eposta
                                ));
                                if($epostaSorgula->rowCount()<= '0') {

                                    $kaydet = $db->prepare("INSERT INTO uyeler SET
                                    isim=:isim,
                                    onay=:onay,
                                    destek=:destek,
                                    soyisim=:soyisim,
                                    telefon=:telefon,
                                    eposta=:eposta,
                                    uye_tip=:uye_tip,
                                    uyesifre=:uyesifre,
                                    ip=:ip,
                                    tarih_ymd=:tarih_ymd,
                                    tarih=:tarih,
                                    sms_ekle=:sms_ekle,
                                    eposta_ekle=:eposta_ekle,
                                    son_giris=:son_giris
                            ");
                                    $sonuc = $kaydet->execute(array(
                                        'isim' => $isim,
                                        'onay' => $onay,
                                        'destek' => '1',
                                        'soyisim' => $soyisim,
                                        'telefon' => $telefon,
                                        'eposta' => $eposta,
                                        'uye_tip' => '1',
                                        'uyesifre' => md5($sifre),
                                        'ip' => $ip,
                                        'tarih_ymd' => $timestamp2,
                                        'tarih' => $timestamp,
                                        'sms_ekle' => $smsekle,
                                        'eposta_ekle' => $epostaekle,
                                        'son_giris' => $timestamp
                                    ));
                                    if($sonuc){

                                        /* E-Posta Bildirimleri */
                                        if($ayar['smtp_durum'] == '1' ) {
                                            include 'includes/post/mailtemp/users/register_mail_temp.php';
                                        }
                                        /* E-Posta Bildirimleri SON */



                                        /* Bültenlere Ekleme Onayı */
                                        if(trim(strip_tags($_POST['smsonay']))=='1') {
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
                                        if(trim(strip_tags($_POST['epostaonay']))=='1') {
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
                                        /*  <========SON=========>>> Bültenlere Ekleme Onayı SON */

                                        /* Üyelerin LOG KAydı */
                                        if($ayar['uye_log'] == '1' ) {
                                            $uyelerr = $db->prepare("select * from uyeler where eposta=:eposta ");
                                            $uyelerr->execute(array(
                                                'eposta' => $eposta
                                            ));
                                            if($uyelerr->rowCount()>'0'  ) {
                                                $uyem = $uyelerr->fetch(PDO::FETCH_ASSOC);
                                                $kaydet = $db->prepare("INSERT INTO uyeler_log SET
                                                   uye_id=:uye_id,     
                                                   ip=:ip,
                                                   islem=:islem,
                                                   tarih=:tarih
                                                ");
                                                $sonuc = $kaydet->execute(array(
                                                    'uye_id' => $uyem['id'],
                                                    'ip' => $ip,
                                                    'islem' => '1',
                                                    'tarih' => $timestamp,
                                                ));
                                            }

                                        }
                                        /*  <========SON=========>>> Üyelerin LOG KAydı SON */

                                        $_SESSION['user_email_address'] = $eposta;
                                        if($onay == '1'  ) {
                                            $_SESSION['uyelik_durum'] = 'success';
                                            header('Location:'.$ayar['site_url'].'');
                                        }else{
                                            $_SESSION['user_email_address_onaysiz'] = $eposta;
                                            $_SESSION['uyelik_durum'] = 'success_onay';
                                            header('Location:'.$ayar['site_url'].'');
                                        }
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    $_SESSION['uyelik_durum'] = 'epostavar';
                                    header('Location:'.$ayar['site_url'].'uyelik/');
                                }
                            }else{
                                $_SESSION['uyelik_durum'] = 'eposta';
                                header('Location:'.$ayar['site_url'].'uyelik/');
                            }
                        }else{
                            $_SESSION['uyelik_durum'] = 'sozlesme';
                            header('Location:'.$ayar['site_url'].'uyelik/');
                        }

                    }else{
                        $_SESSION['uyelik_durum'] = 'empty';
                        header('Location:'.$ayar['site_url'].'uyelik/');
                    }
                }

                if($uyetip == '2'  ) {
                    if($isim && $soyisim && $eposta && $telefon && $sifre && $vergino  ) {
                        if (trim(strip_tags($_POST['sozlesme_onayi'])) == '1') {
                            if (filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
                                $epostaSorgula = $db->prepare("select * from uyeler where eposta=:eposta ");
                                $epostaSorgula->execute(array(
                                    'eposta' => $eposta
                                ));
                                if($epostaSorgula->rowCount()<= '0') {
                                    $kaydet = $db->prepare("INSERT INTO uyeler SET
                                    isim=:isim,
                                    onay=:onay,
                                    destek=:destek,
                                    soyisim=:soyisim,
                                    firma_unvan=:firma_unvan,
                                    vergi_dairesi=:vergi_dairesi,
                                    vergi_no=:vergi_no,
                                    telefon=:telefon,
                                    eposta=:eposta,
                                    uye_tip=:uye_tip,
                                    uyesifre=:uyesifre,
                                    ip=:ip,
                                    tarih_ymd=:tarih_ymd,
                                    tarih=:tarih,
                                    sms_ekle=:sms_ekle,
                                    eposta_ekle=:eposta_ekle,
                                    son_giris=:son_giris
                            ");
                                    $sonuc = $kaydet->execute(array(
                                        'isim' => $isim,
                                        'onay' => $onay,
                                        'destek' => '1',
                                        'soyisim' => $soyisim,
                                        'firma_unvan' => $firma,
                                        'vergi_dairesi' => $vergidairesi,
                                        'vergi_no' => $vergino,
                                        'telefon' => $telefon,
                                        'eposta' => $eposta,
                                        'uye_tip' => '2',
                                        'uyesifre' => md5($sifre),
                                        'ip' => $ip,
                                        'tarih_ymd' => $timestamp2,
                                        'tarih' => $timestamp,
                                        'sms_ekle' => $smsekle,
                                        'eposta_ekle' => $epostaekle,
                                        'son_giris' => $timestamp
                                    ));
                                    if($sonuc){
                                        /* E-Posta Bildirimleri */
                                        if($ayar['smtp_durum'] == '1' ) {
                                            include 'includes/post/mailtemp/users/register_mail_temp.php';
                                        }
                                        /* E-Posta Bildirimleri SON */

                                        /* Bültenlere Ekleme Onayı */
                                        if(trim(strip_tags($_POST['smsonay']))=='1') {
                                            if($uyeayar['sms_ekle'] == '1'  ) {
                                                $smsSorgusu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                                                $smsSorgusu->execute(array(
                                                    'gsm' => $telefon
                                                ));
                                                if($smsSorgusu->rowCount()<='0'  ) {
                                                    $kaydet = $db->prepare("INSERT INTO sms_numaralar SET
                                                     isim=:isim,      
                                                     destek=:destek,
                                                     gsm=:gsm
                                                    ");
                                                    $sonuc = $kaydet->execute(array(
                                                        'isim' => $isim.' '.$soyisim,
                                                        'gsm' => $telefon
                                                    ));
                                                }
                                            }
                                        }
                                        if(trim(strip_tags($_POST['epostaonay']))=='1') {
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
                                        /*  <========SON=========>>> Bültenlere Ekleme Onayı SON */
                                        $_SESSION['user_email_address'] = $eposta;
                                        if($onay == '1'  ) {
                                            $_SESSION['uyelik_durum'] = 'success';
                                            header('Location:'.$ayar['site_url'].'');
                                        }else{
                                            $_SESSION['uyelik_durum'] = 'success_onay';
                                            header('Location:'.$ayar['site_url'].'');
                                        }
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    $_SESSION['uyelik_durum'] = 'epostavar';
                                    header('Location:'.$ayar['site_url'].'uyelik/');
                                }
                            }else{
                                $_SESSION['uyelik_durum'] = 'eposta';
                                header('Location:'.$ayar['site_url'].'uyelik/');
                            }
                        }else{
                            $_SESSION['uyelik_durum'] = 'sozlesme';
                            header('Location:'.$ayar['site_url'].'uyelik/');
                        }
                    }else{
                        $_SESSION['uyelik_durum'] = 'empty';
                        header('Location:'.$ayar['site_url'].'uyelik/');
                    }
                }

      


            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }
        if($uyeayar['basit_form'] == '1' ) {
            if($isim && $soyisim && $eposta && $telefon && $sifre  ) {
                if (trim(strip_tags($_POST['sozlesme_onayi'])) == '1') {
                    if (filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
                        $epostaSorgula = $db->prepare("select * from uyeler where eposta=:eposta ");
                        $epostaSorgula->execute(array(
                            'eposta' => $eposta
                        ));
                        if ($epostaSorgula->rowCount() <= '0') {

                            $kaydet = $db->prepare("INSERT INTO uyeler SET
                                    isim=:isim,
                                    onay=:onay,
                                    destek=:destek,
                                    soyisim=:soyisim,
                                    telefon=:telefon,
                                    eposta=:eposta,
                                    uye_tip=:uye_tip,
                                    uyesifre=:uyesifre,
                                    ip=:ip,
                                    tarih_ymd=:tarih_ymd,
                                    tarih=:tarih,
                                    sms_ekle=:sms_ekle,
                                    eposta_ekle=:eposta_ekle,
                                    son_giris=:son_giris
                            ");
                            $sonuc = $kaydet->execute(array(
                                'isim' => $isim,
                                'onay' => $onay,
                                'destek' => '1',
                                'soyisim' => $soyisim,
                                'telefon' => $telefon,
                                'eposta' => $eposta,
                                'uye_tip' => '1',
                                'uyesifre' => md5($sifre),
                                'ip' => $ip,
                                'tarih_ymd' => $timestamp2,
                                'tarih' => $timestamp,
                                'sms_ekle' => $smsekle,
                                'eposta_ekle' => $epostaekle,
                                'son_giris' => $timestamp
                            ));
                            if($sonuc){
                                /* E-Posta Bildirimleri */
                                if($ayar['smtp_durum'] == '1' ) {
                                    include 'includes/post/mailtemp/users/register_mail_temp.php';
                                }
                                /* E-Posta Bildirimleri SON */

                                /* Bültenlere Ekleme Onayı */
                                if(trim(strip_tags($_POST['smsonay']))=='1') {
                                    if($uyeayar['sms_ekle'] == '1'  ) {
                                        $smsSorgusu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                                        $smsSorgusu->execute(array(
                                            'gsm' => $telefon
                                        ));
                                        if($smsSorgusu->rowCount()<='0'  ) {
                                            $kaydet = $db->prepare("INSERT INTO sms_numaralar SET
                                                     isim=:isim,      
                                                     destek=:destek,
                                                     gsm=:gsm
                                                    ");
                                            $sonuc = $kaydet->execute(array(
                                                'isim' => $isim.' '.$soyisim,
                                                'gsm' => $telefon
                                            ));
                                        }
                                    }
                                }
                                if(trim(strip_tags($_POST['epostaonay']))=='1') {
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
                                /*  <========SON=========>>> Bültenlere Ekleme Onayı SON */
                                $_SESSION['user_email_address'] = $eposta;
                                if($onay == '1'  ) {
                                    $_SESSION['uyelik_durum'] = 'success';
                                    header('Location:'.$ayar['site_url'].'');
                                }else{
                                    $_SESSION['uyelik_durum'] = 'success_onay';
                                    header('Location:'.$ayar['site_url'].'');
                                }
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            $_SESSION['uyelik_durum'] = 'epostavar';
                            header('Location:'.$ayar['site_url'].'uyelik/');
                        }
                    }else{
                        $_SESSION['uyelik_durum'] = 'eposta';
                        header('Location:'.$ayar['site_url'].'uyelik/');
                    }
                }else{
                    $_SESSION['uyelik_durum'] = 'sozlesme';
                    header('Location:'.$ayar['site_url'].'uyelik/');
                }
            }else{
                $_SESSION['uyelik_durum'] = 'empty';
                header('Location:'.$ayar['site_url'].'uyelik/');
            }
        }

        $_SESSION['form_temp_register'] = array(
            'tip' => $uyetip,
            'isim' => $isim,
            'soyisim' => $soyisim,
            'eposta' => $eposta,
            'telefon' => $telefon,
            'firma' => $firma,
            'vergino' => $vergino,
            'vd' => $vergidairesi,
        );


    }else{
        $_SESSION['demo_alert'] = 'demo';
        header('Location:'.$ayar['site_url'].'uyelik/');
    }

} else {
    header('Location:'.$ayar['site_url'].'404');
}
?>