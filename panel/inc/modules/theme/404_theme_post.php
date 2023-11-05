<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'main_update' || $_GET['status'] == 'logo_update' ||$_GET['status'] == 'img_update' || $_GET['status'] == 'img_delete'){
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            /* Genel Güncelleme */
            if($_GET['status'] == 'main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE ayarlar SET
                            404_button=:404_button,
                            404_text_color=:404_text_color,
                            404_main_bg=:404_main_bg,
                            404_header_border=:404_header_border,
                            404_head_bg=:404_head_bg
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        '404_button' => $_POST['404_button'],
                        '404_text_color' => colorFormat($_POST['404_text_color']),
                        '404_main_bg' => colorFormat($_POST['404_main_bg']),
                        '404_header_border' => colorFormat($_POST['404_header_border']),
                        '404_head_bg' => colorFormat($_POST['404_head_bg'])
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_404');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Genel Güncelleme SON */


            /* IMG */
            if($_GET['status'] == 'logo_update'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_FILES['404_logo']["size"] > 0) {
                        $old_img = $_POST['old_logo'];
                        $file_format = $_FILES["404_logo"];
                        $kaynak = $_FILES["404_logo"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['404_logo']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['404_logo']['name']));
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
                        $file_name = $random . "-" . $random2 . "-" . $filename;
                        $target = "../images/logo/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                            $gitti = move_uploaded_file($kaynak, $target);
                            $guncelle = $db->prepare("UPDATE ayarlar SET
                                404_logo=:404_logo
                                WHERE id='1'
                                ");
                            $sonuc = $guncelle->execute(array(
                                '404_logo' => $file_name
                            ));
                            if($sonuc){
                                if($old_img == !null || isset($old_img) ) {
                                    unlink("../images/logo/$old_img");
                                }
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_404');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatasıss';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_404');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_404');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }
            }
            if($_GET['status'] == 'img_update'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_FILES['404_gorsel']["size"] > 0) {
                        $old_img = $_POST['old_img'];
                        $file_format = $_FILES["404_gorsel"];
                        $kaynak = $_FILES["404_gorsel"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['404_gorsel']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['404_gorsel']['name']));
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
                        $file_name = $random . "-" . $random2 . "-" . $filename;
                        $target = "../images/uploads/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                            $gitti = move_uploaded_file($kaynak, $target);
                            $guncelle = $db->prepare("UPDATE ayarlar SET
                                         404_gorsel=:404_gorsel
                                         WHERE id='1'      
                                        ");
                            $sonuc = $guncelle->execute(array(
                                '404_gorsel' => $file_name
                            ));
                            if($sonuc){
                                if($old_img == !null || isset($old_img) ) {
                                    unlink("../images/uploads/$old_img");
                                }
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_404');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatasıss';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_404');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_404');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }
            }
            if($_GET['status'] == 'img_delete'  ) {
                $sorgu = $db->prepare("select * from ayarlar where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink('../images/uploads/'.$row['404_gorsel'].'');
                $guncelle = $db->prepare("UPDATE ayarlar SET
                            404_gorsel=:404_gorsel
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    '404_gorsel' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_404');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> IMG SON */

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