<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'main_update' || $_GET['status'] == 'auto_messages'    ) {


            /* Main Update */
            if($_GET['status'] == 'main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE sms SET
                           durum=:durum, 
                           bildirim_numara=:bildirim_numara,
                           sms_firma=:sms_firma,
                           netgsm_user=:netgsm_user,
                           netgsm_pass=:netgsm_pass,
                           netgsm_baslik=:netgsm_baslik,
                           iletimerkezi_user=:iletimerkezi_user,
                           iletimerkezi_pass=:iletimerkezi_pass,
                           iletimerkezi_baslik=:iletimerkezi_baslik
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $_POST['durum'],
                        'bildirim_numara' => $_POST['bildirim_numara'],
                        'sms_firma' => $_POST['sms_firma'],
                        'netgsm_user' => $_POST['netgsm_user'],
                        'netgsm_pass' => $_POST['netgsm_pass'],
                        'netgsm_baslik' => $_POST['netgsm_baslik'],
                        'iletimerkezi_user' => $_POST['iletimerkezi_user'],
                        'iletimerkezi_pass' => $_POST['iletimerkezi_pass'],
                        'iletimerkezi_baslik' => $_POST['iletimerkezi_baslik']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sms_settings');
                        $_SESSION['main_alert'] = 'success';
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Main Update SON */

            /* Auto Email */
            if($_GET['status'] == 'auto_messages'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE sms SET
                           sms_odeme_site=:sms_odeme_site, 
                           sms_odeme_user=:sms_odeme_user,
                           sms_siparisiptal_site=:sms_siparisiptal_site,
                           sms_siparisiptal_user=:sms_siparisiptal_user,
                           sms_uruniade_site=:sms_uruniade_site,
                           sms_uruniade_user=:sms_uruniade_user, 
                           sms_ticket_site=:sms_ticket_site,
                           sms_ticket_user=:sms_ticket_user,
                           sms_siparis_site=:sms_siparis_site,
                           sms_siparis_user=:sms_siparis_user,
                           sms_normalsiparis_site=:sms_normalsiparis_site, 
                           sms_normalsiparis_user=:sms_normalsiparis_user,
                           sms_teklif_site=:sms_teklif_site,
                           sms_teklif_user=:sms_teklif_user
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'sms_odeme_site' => $_POST['sms_odeme_site'],
                        'sms_odeme_user' => $_POST['sms_odeme_user'],
                        'sms_siparisiptal_site' => $_POST['sms_siparisiptal_site'],
                        'sms_siparisiptal_user' => $_POST['sms_siparisiptal_user'],
                        'sms_uruniade_site' => $_POST['sms_uruniade_site'],
                        'sms_uruniade_user' => $_POST['sms_uruniade_user'],
                        'sms_ticket_site' => $_POST['sms_ticket_site'],
                        'sms_ticket_user' => $_POST['sms_ticket_user'],
                        'sms_siparis_site' => $_POST['sms_siparis_site'],
                        'sms_siparis_user' => $_POST['sms_siparis_user'],
                        'sms_normalsiparis_site' => $_POST['sms_normalsiparis_site'],
                        'sms_normalsiparis_user' => $_POST['sms_normalsiparis_user'],
                        'sms_teklif_site' => $_POST['sms_teklif_site'],
                        'sms_teklif_user' => $_POST['sms_teklif_user']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sms_settings');
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['tab_select'] = 'oto';
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Auto Email SON */


        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }






}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}