<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($_POST && isset($_POST['odemeBildir'])) {

    $siparisno = trim(strip_tags($_POST['hidden_order']));
    $isim = trim(strip_tags($_POST['name']));
    $tutar = trim(strip_tags($_POST['amount']));
    $parabirimi = trim(strip_tags($_POST['parabirimi']));
    $aciklama = trim(strip_tags($_POST['aciklama']));
    $banka = trim(strip_tags($_POST['banka']));
    if($demo != '1'  ){
        if($siparisno) {
            $siparisSorgu = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
            $siparisSorgu->execute(array(
                'siparis_no' => $siparisno,
            ));
            if($siparisSorgu->rowCount()>'0'  ) {
                $sipariRow = $siparisSorgu->fetch(PDO::FETCH_ASSOC);
                if($banka) {
                    if($isim && $tutar && $parabirimi && $aciklama) {

                        $timestamp = date('Y-m-d G:i:s');
                        $sadetarih = date('Y-m-d');

                        $kaydet = $db->prepare("INSERT INTO odeme_bildirim SET
                           banka=:banka, 
                           durum=:durum,
                           sade_tarih=:sade_tarih,
                           gonderen=:gonderen,
                           siparis_no=:siparis_no,
                           odeme_tutar=:odeme_tutar,
                           parabirimi=:parabirimi,
                           gonderen_not=:gonderen_not,
                           tarih=:tarih
                    ");
                        $sonuc = $kaydet->execute(array(
                            'banka' => $banka,
                            'durum' => '0',
                            'sade_tarih' => $sadetarih,
                            'gonderen' => $isim,
                            'siparis_no' => $siparisno,
                            'odeme_tutar' => $tutar,
                            'parabirimi' => $parabirimi,
                            'gonderen_not' => $aciklama,
                            'tarih' => $timestamp
                        ));
                        if($sonuc){
                            /* E-Posta Bildirimleri */
                            if($ayar['smtp_durum'] == '1' ) {
                                $eposta = $sipariRow['eposta'];
                                include 'includes/post/mailtemp/odeme_bildirim_mail_temp.php';
                            }
                            /* E-Posta Bildirimleri SON */
                            /* SMS */
                            if($sms['durum'] == '1' ) {
                                if($sms['sms_odeme_site'] == '1' || $sms['sms_odeme_user'] == '1') {
                                    include 'includes/post/smstemp/other/transfer_sms.php';
                                    include 'includes/post/smstemp/sms_api.php';
                                }
                            }
                            /*  <========SON=========>>> SMS SON */
                            $_SESSION['bildirim_alert'] = 'success';
                            header('Location:'.$ayar['site_url'].'odeme-bildirimi/?sID='.$siparisno.'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['bildirim_alert'] = 'empty';
                        header('Location:'.$ayar['site_url'].'odeme-bildirimi/?sID='.$siparisno.'');
                    }
                }else{
                    $_SESSION['bildirim_alert'] = 'bankasec';
                    header('Location:'.$ayar['site_url'].'odeme-bildirimi/?sID='.$siparisno.'');
                }
                /* Kayıt Temp Form */
                $_SESSION['form_temp_odemebildirimi'] = array(
                    'aciklama' => $aciklama,
                    'tutar' => $tutar,
                    'isim' => $isim,
                );
                /*  <========SON=========>>> Kayıt Temp Form SON */
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        $_SESSION['demo_alert'] = 'demo';
        header('Location:'.$ayar['site_url'].'odeme-bildirimi/?sID='.$siparisno.'');
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
