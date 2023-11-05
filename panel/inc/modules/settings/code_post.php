<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'update' && $_POST && isset($_POST['update']) ) {
                $guncelle = $db->prepare("UPDATE ayarlar SET
                        js_kodlar=:js_kodlar
                 WHERE id='1'      
                ");
                $sonuc = $guncelle->execute(array(
                    'js_kodlar' => $_POST['js_kodlar']
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=code');
                    $_SESSION['main_alert'] = 'success';
                }else{
                echo 'Veritabanı Hatası';
                }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=code');
    $_SESSION['main_alert'] = 'demo';
}