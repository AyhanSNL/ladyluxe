<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($_GET['favicon'] == 'delete' || $_GET['favicon'] == 'update'  ) {
    if($yetki['demo'] != '1' ) {

        if($_GET['favicon'] == 'delete'  ) {
              unlink("../images/favicon.ico");
            $guncelle = $db->prepare("UPDATE ayarlar SET
                    site_favicon=:site_favicon
             WHERE id='1'      
            ");
            $sonuc = $guncelle->execute(array(
                'site_favicon' => '',
            ));
            if($sonuc){
                header('Location:'.$ayar['panel_url'].'pages.php?page=settings');
                $_SESSION['main_alert'] = 'success';
            }else{
            echo 'Veritabanı Hatası';
            }
        }

        if($_GET['favicon'] == 'update'  ) {
            if($_POST && isset($_POST['faviconUpdate'])  ) {
                if ($_FILES['favicon']["size"] > 0) {
                    $file_format = $_FILES["favicon"];
                    $kaynak = $_FILES["favicon"]["tmp_name"];
                    $file_name = 'favicon.ico';
                    $target = "../images/" . $file_name;
                    if($file_format['type'] == 'image/x-icon' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  ) {
                        $gitti = move_uploaded_file($kaynak, $target);
                        $guncelle = $db->prepare("UPDATE ayarlar SET
                                site_favicon=:site_favicon
                         WHERE id='1'      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'site_favicon' => $file_name,
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=settings');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=settings');
                        $_SESSION['main_alert'] = 'filetype';
                    }
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=settings');
                    $_SESSION['main_alert'] = 'filesize';
                }
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }

    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=settings');
        $_SESSION['main_alert'] = 'demo';
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>