<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'main_update' ){
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
                    $guncelle = $db->prepare("UPDATE video_ayar SET
                                     arkaplan=:arkaplan,      
                                     font_secim=:font_secim,
                                     izlenme=:izlenme,
                                     tags=:tags,      
                                     spot_akordion=:spot_akordion,
                                     meta_desc=:meta_desc,   
                                     nav=:nav
                                     WHERE id='1'      
                                    ");
                    $sonuc = $guncelle->execute(array(
                        'arkaplan' => colorFormat($_POST['arkaplan']),
                        'font_secim' => $_POST['font_secim'],
                        'izlenme' => $_POST['izlenme'],
                        'tags' => $_POST['tags'],
                        'spot_akordion' => $_POST['spot_akordion'],
                        'meta_desc' => $_POST['meta_desc'],
                        'nav' => $_POST['nav']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_videos');
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