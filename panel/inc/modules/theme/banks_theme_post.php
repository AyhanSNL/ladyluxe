<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'banks_update' || $_GET['status'] == 'payment_report' || $_GET['status'] == 'order_track' ){
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

                /* Banka Update */
                            if($_GET['status'] == 'banks_update'  ) {
                                if($_POST && isset($_POST['update'])  ) {
                                    $guncelle = $db->prepare("UPDATE ayarlar SET
                                     banka_sayfa_bg=:banka_sayfa_bg,      
                                     banka_sayfa_font=:banka_sayfa_font,
                                     banka_sayfa_nav=:banka_sayfa_nav,
                                     banka_sayfa_tags=:banka_sayfa_tags,      
                                     banka_sayfa_desc=:banka_sayfa_desc   
                                     WHERE id='1'      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'banka_sayfa_bg' => colorFormat($_POST['banka_sayfa_bg']),
                                        'banka_sayfa_font' => $_POST['banka_sayfa_font'],
                                        'banka_sayfa_nav' => $_POST['banka_sayfa_nav'],
                                        'banka_sayfa_tags' => $_POST['banka_sayfa_tags'],
                                        'banka_sayfa_desc' => $_POST['banka_sayfa_desc']
                                    ));
                                    if($sonuc){
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banks');
                                        $_SESSION['main_alert'] = 'success';
                                        $_SESSION['collepse_status'] = 'genelAcc';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                /*  <========SON=========>>> Banka Update SON */

                /* Ödeme Bildirim */
                            if($_GET['status'] == 'payment_report'  ) {
                                if($_POST && isset($_POST['update'])  ) {
                                    $guncelle = $db->prepare("UPDATE ayarlar SET
                                                     odeme_bildirim_bg=:odeme_bildirim_bg,      
                                                     odeme_bildirim_font=:odeme_bildirim_font
                                                     WHERE id='1'      
                                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'odeme_bildirim_bg' => colorFormat($_POST['odeme_bildirim_bg']),
                                        'odeme_bildirim_font' => $_POST['odeme_bildirim_font']
                                    ));
                                    if($sonuc){
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banks');
                                        $_SESSION['main_alert'] = 'success';
                                        $_SESSION['collepse_status'] = 'otherAcc';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                /*  <========SON=========>>> Ödeme Bildirim SON */


                /* Sipariş takip */
            if($_GET['status'] == 'order_track'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE ayarlar SET
                                     siparis_takip_bg=:siparis_takip_bg,      
                                     siparis_takip_font=:siparis_takip_font,
                                     siparis_takip_tags=:siparis_takip_tags,      
                                     siparis_takip_desc=:siparis_takip_desc   
                                     WHERE id='1'      
                                    ");
                    $sonuc = $guncelle->execute(array(
                        'siparis_takip_bg' => colorFormat($_POST['siparis_takip_bg']),
                        'siparis_takip_font' => $_POST['siparis_takip_font'],
                        'siparis_takip_tags' => $_POST['siparis_takip_tags'],
                        'siparis_takip_desc' => $_POST['siparis_takip_desc']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banks');
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['collepse_status'] = 'otherAcc2';
                    }else{
                        echo 'Veritabanı Hatasıss';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
                /*  <========SON=========>>> Sipariş takip SON */



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