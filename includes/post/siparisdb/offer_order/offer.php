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
        $adet = trim(strip_tags($_POST['adet'])) ;
        $not = trim(strip_tags($_POST['teklif_not']));


        if($userSorgusu->rowCount()>'0'  ) {
            $uyeNO = $userCek['id'];
        }else{
            $uyeNO = null;
        }



        if($isim && $soyisim && $eposta && $telefon && $not ) {

            if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){


                /* captha */
                if($ayar['site_captcha'] == '1') {
                    if ($_POST['secure_code'] == $_SESSION['secure_code']) {

                     $kaydet = $db->prepare("INSERT INTO siparis_teklif SET
                         isim=:isim,   
                         yeni=:yeni,
                         soyisim=:soyisim, 
                         eposta=:eposta,
                         telefon=:telefon,
                         urun_adet=:urun_adet,
                         teklif_no=:teklif_no,
                         tarih=:tarih,
                         urun_id=:urun_id,
                         uye_id=:uye_id,
                         teklif_not=:teklif_not,
                         durum=:durum
                     ");
                     $sonuc = $kaydet->execute(array(
                         'isim' => $isim,
                         'yeni' => '1',
                         'soyisim' => $soyisim,
                         'eposta' => $eposta,
                         'telefon' => $telefon,
                         'urun_adet' => $adet,
                         'teklif_no' => $orderIDno,
                         'tarih' => $timestamp,
                         'urun_id' => $urunRow['id'],
                         'uye_id' => $uyeNO,
                         'teklif_not' => $not,
                         'durum' => '0'
                     ));
                     if($sonuc){
                         $_SESSION['teklif_siparis_alert'] = 'success';
                         header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                         /* E-Posta Bildirimleri */
                         if($ayar['smtp_durum'] == '1' ) {
                             include 'includes/post/mailtemp/siparisler/offer_order/offer_mail_temp.php';
                         }
                         /* E-Posta Bildirimleri SON */
                         /* SMS */
                         if($sms['durum'] == '1' ) {
                             if($sms['sms_teklif_site'] == '1' || $sms['sms_teklif_user'] == '1') {
                                 include 'includes/post/smstemp/siparis/teklif_sms.php';
                                 include 'includes/post/smstemp/sms_api.php';
                             }
                         }
                         /*  <========SON=========>>> SMS SON */
                     }else{
                         header('Location:'.$siteurl.'404');
                     }
                    }else{
                        $_SESSION['teklif_siparis_alert'] = 'secure';
                        header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                        unset($_SESSION['secure_code']);
                    }
                }
                /*  <========SON=========>>> captha SON */



                /* No captcha */
                if($ayar['site_captcha'] == '0' || $ayar['site_captcha'] == null ) {
                    $kaydet = $db->prepare("INSERT INTO siparis_teklif SET
                         isim=:isim,   
                         yeni=:yeni,
                         soyisim=:soyisim, 
                         eposta=:eposta,
                         telefon=:telefon,
                         urun_adet=:urun_adet,
                         teklif_no=:teklif_no,
                         tarih=:tarih,
                         urun_id=:urun_id,
                         uye_id=:uye_id,
                         teklif_not=:teklif_not,
                         durum=:durum
                     ");
                    $sonuc = $kaydet->execute(array(
                        'isim' => $isim,
                        'yeni' => '1',
                        'soyisim' => $soyisim,
                        'eposta' => $eposta,
                        'telefon' => $telefon,
                        'urun_adet' => $adet,
                        'teklif_no' => $orderIDno,
                        'tarih' => $timestamp,
                        'urun_id' => $urunRow['id'],
                        'uye_id' => $uyeNO,
                        'teklif_not' => $not,
                        'durum' => '0'
                    ));
                    if($sonuc){
                        $_SESSION['teklif_siparis_alert'] = 'success';
                        header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                        /* E-Posta Bildirimleri */
                        if($ayar['smtp_durum'] == '1' ) {
                            include 'includes/post/mailtemp/siparisler/offer_order/offer_mail_temp.php';
                        }
                        /* E-Posta Bildirimleri SON */
                        /* SMS */
                        if($sms['durum'] == '1' ) {
                            if($sms['sms_teklif_site'] == '1' || $sms['sms_teklif_user'] == '1') {
                                include 'includes/post/smstemp/siparis/teklif_sms.php';
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
                $_SESSION['teklif_siparis_alert'] = 'eposta';
                header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
            }
        }else{
            $_SESSION['teklif_siparis_alert'] = 'empty';
            header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
        }
    }else{
        header('Location:'.$siteurl.'404');
    }
}else{
header('Location:'.$siteurl.'404');
}
?>