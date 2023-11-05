<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'main_update' || $_GET['status'] == 'bg_update' || $_GET['status'] == 'bg_delete' || $_GET['status'] == 'detail_update'){
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            /* Genel Update */
            if($_GET['status'] == 'main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE sss_ayar SET
                                     detay_bg=:detay_bg,      
                                     baslik_font=:baslik_font,
                                     first_open=:first_open,
                                     tags=:tags,      
                                     meta_desc=:meta_desc,   
                                     nav_durum=:nav_durum
                                     WHERE id='1'      
                                    ");
                    $sonuc = $guncelle->execute(array(
                        'detay_bg' => colorFormat($_POST['detay_bg']),
                        'baslik_font' => $_POST['baslik_font'],
                        'first_open' => $_POST['first_open'],
                        'tags' => $_POST['tags'],
                        'meta_desc' => $_POST['meta_desc'],
                        'nav_durum' => $_POST['nav_durum']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_faq');
                        $_SESSION['main_alert'] = 'success';
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Genel Update SON */

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