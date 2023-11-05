<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
        if($_POST && isset($_POST['logoUpdate'])  ) {
            if ($_FILES['panel_logo']["size"] > 0) {
                $file_format = $_FILES["panel_logo"];
                $kaynak = $_FILES["panel_logo"]["tmp_name"];
                $uzanti = explode(".", $_FILES['panel_logo']['name']);
                $random = rand(0,(int) 99999);
                $random2 = rand(0,(int) 999);
                $filename = trim(addslashes($_FILES['panel_logo']['name']));
                $filename = str_replace(' ', '_', $filename);
                $filename = str_replace('ş', 's', $filename);
                $filename = str_replace('&', '-', $filename);
                $filename = str_replace('%', '-', $filename);
                $filename = str_replace('?', '-', $filename);
                $filename = str_replace('+', '-', $filename);
                $filename = str_replace('ı', 'i', $filename);
                $filename = str_replace('Ş', 's', $filename);
                $filename = str_replace('ğ', 'g', $filename);
                $filename = str_replace('Ğ', 'g', $filename);
                $filename = str_replace('ü', 'u', $filename);
                $filename = str_replace('Ü', 'u', $filename);
                $filename = str_replace('ç', 'c', $filename);
                $filename = str_replace('Ç', 'c', $filename);
                $filename = str_replace('ö', 'o', $filename);
                $filename = str_replace('Ö', 'o', $filename);
                $filename = str_replace('İ', 'i', $filename);
                $filename = preg_replace('/\s+/', '_', $filename);
                $file_name = $random . "-" . $random2 . "-" .$filename;
                $target = "assets/images/" . $file_name;

                if($file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif'  ) {
                    $gitti = move_uploaded_file($kaynak, $target);

                    $guncelle = $db->prepare("UPDATE panel_ayar SET
                                panel_logo=:panel_logo
                         WHERE id='1'      
                        ");
                    $sonuc = $guncelle->execute(array(
                        'panel_logo' => $file_name,
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=panel_settings');
                        $_SESSION['main_alert'] = 'success';
                        unlink("assets/images/$_POST[old_logo]");
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=panel_settings');
                    $_SESSION['main_alert'] = 'filetype';
                }
            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=panel_settings');
                $_SESSION['main_alert'] = 'filesize';
            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }

}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=panel_settings');
    $_SESSION['main_alert'] = 'demo';
}
?>