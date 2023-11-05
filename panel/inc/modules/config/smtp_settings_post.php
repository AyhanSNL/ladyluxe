<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'main_update' || $_GET['status'] == 'auto_messages'    ) {


         /* Main Update */
            if($_GET['status'] == 'main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE ayarlar SET
                           smtp_durum=:smtp_durum, 
                           smtp_host=:smtp_host,
                           smtp_mail=:smtp_mail,
                           smtp_pass=:smtp_pass,
                           smtp_port=:smtp_port,
                           smtp_protokol=:smtp_protokol,
                           smtp_bildirim_mail=:smtp_bildirim_mail
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'smtp_durum' => $_POST['smtp_durum'],
                        'smtp_host' => $_POST['smtp_host'],
                        'smtp_mail' => $_POST['smtp_mail'],
                        'smtp_pass' => $_POST['smtp_pass'],
                        'smtp_port' => $_POST['smtp_port'],
                        'smtp_protokol' => $_POST['smtp_protokol'],
                        'smtp_bildirim_mail' => $_POST['smtp_bildirim_mail']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=smtp_settings');
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
                    $guncelle = $db->prepare("UPDATE ayarlar SET
                           smtp_iletisim_site=:smtp_iletisim_site, 
                           smtp_iletisim_user=:smtp_iletisim_user,
                           smtp_bulten_site=:smtp_bulten_site,
                           smtp_bulten_user=:smtp_bulten_user,
                           smtp_urun_yorum_site=:smtp_urun_yorum_site,
                           smtp_urun_yorum_user=:smtp_urun_yorum_user, 
                           smtp_modul_yorum_site=:smtp_modul_yorum_site,
                           smtp_modul_yorum_user=:smtp_modul_yorum_user,
                           smtp_siparis_site=:smtp_siparis_site,
                           smtp_siparis_user=:smtp_siparis_user,
                           smtp_normalsiparis_site=:smtp_normalsiparis_site, 
                           smtp_normalsiparis_user=:smtp_normalsiparis_user,
                           smtp_teklif_site=:smtp_teklif_site,
                           smtp_teklif_user=:smtp_teklif_user,
                           smtp_uyelik_site=:smtp_uyelik_site,
                            smtp_uyelik_user=:smtp_uyelik_user, 
                           smtp_ticket_site=:smtp_ticket_site,
                           smtp_ticket_user=:smtp_ticket_user,
                           smtp_iptalsiparis_site=:smtp_iptalsiparis_site,
                           smtp_iptalsiparis_user=:smtp_iptalsiparis_user,                           
                           smtp_uruniade_site=:smtp_uruniade_site, 
                           smtp_uruniade_user=:smtp_uruniade_user,
                           smtp_odeme_site=:smtp_odeme_site,
                           smtp_odeme_user=:smtp_odeme_user
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'smtp_iletisim_site' => $_POST['smtp_iletisim_site'],
                        'smtp_iletisim_user' => $_POST['smtp_iletisim_user'],
                        'smtp_bulten_site' => $_POST['smtp_bulten_site'],
                        'smtp_bulten_user' => $_POST['smtp_bulten_user'],
                        'smtp_urun_yorum_site' => $_POST['smtp_urun_yorum_site'],
                        'smtp_urun_yorum_user' => $_POST['smtp_urun_yorum_user'],
                        'smtp_modul_yorum_site' => $_POST['smtp_modul_yorum_site'],
                        'smtp_modul_yorum_user' => $_POST['smtp_modul_yorum_user'],
                        'smtp_siparis_site' => $_POST['smtp_siparis_site'],
                        'smtp_siparis_user' => $_POST['smtp_siparis_user'],
                        'smtp_normalsiparis_site' => $_POST['smtp_normalsiparis_site'],
                        'smtp_normalsiparis_user' => $_POST['smtp_normalsiparis_user'],
                        'smtp_teklif_site' => $_POST['smtp_teklif_site'],
                        'smtp_teklif_user' => $_POST['smtp_teklif_user'],
                        'smtp_uyelik_site' => $_POST['smtp_uyelik_site'],
                        'smtp_uyelik_user' => $_POST['smtp_uyelik_user'],
                        'smtp_ticket_site' => $_POST['smtp_ticket_site'],
                        'smtp_ticket_user' => $_POST['smtp_ticket_user'],
                        'smtp_iptalsiparis_site' => $_POST['smtp_iptalsiparis_site'],
                        'smtp_iptalsiparis_user' => $_POST['smtp_iptalsiparis_user'],
                        'smtp_uruniade_site' => $_POST['smtp_uruniade_site'],
                        'smtp_uruniade_user' => $_POST['smtp_uruniade_user'],
                        'smtp_odeme_site' => $_POST['smtp_odeme_site'],
                        'smtp_odeme_user' => $_POST['smtp_odeme_user']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=smtp_settings');
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