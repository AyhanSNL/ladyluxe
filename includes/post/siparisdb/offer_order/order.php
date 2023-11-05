<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($_POST) {
    $id = $_POST['pid'];
    $seo = $_POST['hash'];

    $urunKontrol = $db->prepare("select * from urun where id=:id");
    $urunKontrol->execute(array(
        'id' => $id
    ));
    $urunRow = $urunKontrol->fetch(PDO::FETCH_ASSOC);

    if(md5($urunRow['seo_url']) == $seo ) {

        $timestamp = date('Y-m-d G:i:s');

        $orderIDno = rand(0,(int) 99999999);

        $isim = trim(strip_tags($_POST['isim']));
        $soyisim = trim(strip_tags($_POST['soyisim']));
        $eposta = trim(strip_tags($_POST['eposta']));
        $telefon = trim(strip_tags($_POST['telefon'])) ;
        $ulke = trim(strip_tags($_POST['ulke'])) ;
        $sehir_ilce = trim(strip_tags($_POST['sehir_ilce'])) ;
        $postakodu = trim(strip_tags($_POST['postakodu'])) ;
        $adres = trim(strip_tags($_POST['adres'])) ;
        $not = trim(strip_tags($_POST['siparis_not']));

        if($not == !null  ) {
            $not = $not;
        }else{
            $not = null;
        }

        if($userSorgusu->rowCount()>'0'  ) {
            $uyeNO = $userCek['id'];
        }else{
            $uyeNO = null;
        }


        $sadeTarih = date('Y-m-d');

        if($isim && $soyisim && $eposta && $telefon && $ulke && $sehir_ilce && $postakodu && $adres ) {

            if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){


                /* captha */
                if($ayar['site_captcha'] == '1') {
                    if ($_POST['secure_code'] == $_SESSION['secure_code']) {

                     $kaydet = $db->prepare("INSERT INTO siparis_normal SET
                         isim=:isim,   
                         sade_tarih=:sade_tarih,
                         soyisim=:soyisim, 
                         yeni=:yeni,
                         eposta=:eposta,
                         telefon=:telefon,
                         sehir=:sehir,
                         ulke=:ulke,
                         postakodu=:postakodu,
                         adres=:adres,
                         siparis_no=:siparis_no,
                         tarih=:tarih,
                         urun_id=:urun_id,
                         uye_id=:uye_id,
                         siparis_not=:siparis_not,
                         durum=:durum
                     ");
                     $sonuc = $kaydet->execute(array(
                         'isim' => $isim,
                         'sade_tarih' => $sadeTarih,
                         'soyisim' => $soyisim,
                         'yeni' => '1',
                         'eposta' => $eposta,
                         'telefon' => $telefon,
                         'sehir' => $sehir_ilce,
                         'ulke' => $ulke,
                         'postakodu' => $postakodu,
                         'adres' => $adres,
                         'siparis_no' => $orderIDno,
                         'tarih' => $timestamp,
                         'urun_id' => $urunRow['id'],
                         'uye_id' => $uyeNO,
                         'siparis_not' => $not,
                         'durum' => $odemeayar['normalsiparis_durum']
                     ));
                     if($sonuc){
                         $_SESSION['normal_siparis_alert'] = 'success';
                         header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                         /* E-Posta Bildirimleri */
                         if($ayar['smtp_durum'] == '1' ) {
                             include 'includes/post/mailtemp/siparisler/offer_order/order_mail_temp.php';
                         }
                         /* E-Posta Bildirimleri SON */

                         /* SMS */
                         if($sms['durum'] == '1' ) {
                             if($sms['sms_normalsiparis_site'] == '1' || $sms['sms_normalsiparis_user'] == '1') {
                                 include 'includes/post/smstemp/siparis/tek_urun_sms.php';
                                 include 'includes/post/smstemp/sms_api.php';
                             }
                         }
                         /*  <========SON=========>>> SMS SON */
                     }else{
                         header('Location:'.$siteurl.'404');
                     }
                    }else{
                        $_SESSION['normal_siparis_alert'] = 'secure';
                        header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                        unset($_SESSION['secure_code']);
                    }
                }
                /*  <========SON=========>>> captha SON */



                /* No captcha */
                if($ayar['site_captcha'] == '0' || $ayar['site_captcha'] == null ) {
                    $kaydet = $db->prepare("INSERT INTO siparis_normal SET
                         isim=:isim,   
                         soyisim=:soyisim, 
                         sade_tarih=:sade_tarih,
                         yeni=:yeni,
                         eposta=:eposta,
                         telefon=:telefon,
                         sehir=:sehir,
                         ulke=:ulke,
                         postakodu=:postakodu,
                         adres=:adres,
                         siparis_no=:siparis_no,
                         tarih=:tarih,
                         urun_id=:urun_id,
                         uye_id=:uye_id,
                         siparis_not=:siparis_not,
                         durum=:durum
                     ");
                    $sonuc = $kaydet->execute(array(
                        'isim' => $isim,
                        'soyisim' => $soyisim,
                        'sade_tarih' => $sadeTarih,
                        'yeni' => '1',
                        'eposta' => $eposta,
                        'telefon' => $telefon,
                        'sehir' => $sehir_ilce,
                        'ulke' => $ulke,
                        'postakodu' => $postakodu,
                        'adres' => $adres,
                        'siparis_no' => $orderIDno,
                        'tarih' => $timestamp,
                        'urun_id' => $urunRow['id'],
                        'uye_id' => $uyeNO,
                        'siparis_not' => $not,
                        'durum' => $odemeayar['normalsiparis_durum']
                    ));
                    if($sonuc){
                        $_SESSION['normal_siparis_alert'] = 'success';
                        header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                        /* E-Posta Bildirimleri */
                        if($ayar['smtp_durum'] == '1' ) {
                            include 'includes/post/mailtemp/siparisler/offer_order/order_mail_temp.php';
                        }
                        /* E-Posta Bildirimleri SON */
                        /* SMS */
                        if($sms['durum'] == '1' ) {
                            if($sms['sms_normalsiparis_site'] == '1' || $sms['sms_normalsiparis_user'] == '1') {
                                include 'includes/post/smstemp/siparis/tek_urun_sms.php';
                                include 'includes/post/smstemp/sms_api.php';
                            }
                        }
                        /*  <========SON=========>>> SMS SON */
                    }else{
                        header('Location:'.$siteurl.'404');
                    }
                }
                /*  <========SON=========>>> No captcha SON */


            }else{
                $_SESSION['normal_siparis_alert'] = 'eposta';
                header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
            }
        }else{
            $_SESSION['normal_siparis_alert'] = 'empty';
            header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
        }
    }else{
        header('Location:'.$siteurl.'404');
    }
}else{
header('Location:'.$siteurl.'404');
}
?>