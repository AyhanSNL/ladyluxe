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
            /* Ürün Kutulaı */
            if($_GET['status'] == 'main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE uyeler_ayar SET
                            detay_bg=:detay_bg,
                            altsayfa_bg=:altsayfa_bg,
                            font_select=:font_select
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'detay_bg' => colorFormat($_POST['detay_bg']),
                        'altsayfa_bg' => colorFormat($_POST['altsayfa_bg']),
                        'font_select' => $_POST['font_select']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_users_settings');
                    }else{
                    echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Ürün Kutulaı SON */

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