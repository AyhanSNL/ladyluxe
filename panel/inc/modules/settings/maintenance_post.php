<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'bg_update' || $_GET['status'] == 'logo_update' || $_GET['status'] == 'bg_delete' || $_GET['status'] == 'logo_delete' || $_GET['status'] == 'update' ) {


            /* Main Update */
            if($_GET['status']=='update'   ) {
                if($_POST && isset($_POST['update'])  ) {
                    $baslik = $_POST['baslik'];
                    $spot = $_POST['spot'];
                    $durum = $_POST['durum'];
                    $font = $_POST['font_select'];
                    $ebulten = $_POST['ebulten'];
                    $sosyal = $_POST['sosyal'];
                    $iletisim = $_POST['iletisim'];
                    $tarih_durum = $_POST['tarih_durum'];
                    $tarih = $_POST['tarih'];
                    if($baslik) {
                        $guncelle = $db->prepare("UPDATE bakim SET
                                baslik=:baslik,
                                spot=:spot,
                                durum=:durum,
                                font_select=:font_select,
                                ebulten=:ebulten,
                                sosyal=:sosyal,
                                iletisim=:iletisim,
                                tarih_durum=:tarih_durum,
                                tarih=:tarih,
                                tel=:tel,
                                whatsapp=:whatsapp,
                                adres=:adres,
                                eposta=:eposta
                         WHERE id='1'      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $baslik,
                            'spot' => $spot,
                            'durum' => $durum,
                            'font_select' => $font,
                            'ebulten' => $ebulten,
                            'sosyal' => $sosyal,
                            'iletisim' => $iletisim,
                            'tarih_durum' => $tarih_durum,
                            'tarih' => $tarih,
                            'tel' => $_POST['tel'],
                            'whatsapp' => $_POST['whatsapp'],
                            'adres' => $_POST['adres'],
                            'eposta' => $_POST['eposta']
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                        $_SESSION['main_alert'] = 'empty';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Main Update SON */

            /* BG Delete */
            if($_GET['status']=='bg_delete'  ) {
                $baksorgu = $db->prepare("select * from bakim where id='1' ");
                $baksorgu->execute();
                $bak = $baksorgu->fetch(PDO::FETCH_ASSOC);

                $sil = unlink("../i/uploads/$bak[bg]");
                $guncelle = $db->prepare("UPDATE bakim SET
                         bg=:bg
                  WHERE id='1'      
                 ");
                $sonuc = $guncelle->execute(array(
                    'bg' => null
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                    $_SESSION['main_alert'] = 'success';
                    exit();
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> BG Delete SON */

            /* Logo Delete */
            if($_GET['status']=='logo_delete'  ) {
                $baksorgu = $db->prepare("select * from bakim where id='1' ");
                $baksorgu->execute();
                $bak = $baksorgu->fetch(PDO::FETCH_ASSOC);

                $sil = unlink("../i/uploads/$bak[logo]");
                $guncelle = $db->prepare("UPDATE bakim SET
                         logo=:logo
                  WHERE id='1'      
                 ");
                $sonuc = $guncelle->execute(array(
                    'logo' => null
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> Logo Delete SON */


            /* Bg Upload */
            if($_GET['status']=='bg_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $old_img = $_POST['old_bg'];
                    if ($_FILES['bg']["size"] > 0) {
                        $file_format = $_FILES["bg"];
                        $kaynak = $_FILES["bg"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['bg']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['bg']['name']));
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
                        $target = "../i/uploads/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png') {
                            $gitti = move_uploaded_file($kaynak, $target);

                            $guncelle = $db->prepare("UPDATE bakim SET
                               bg=:bg 
                         WHERE id='1'      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'bg' => $file_name
                            ));
                            if($sonuc){
                                if($old_img == !null || isset($old_img) ) {
                                    unlink("../i/uploads/$old_img");
                                }
                                header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Bg Upload SON */


            /* Logo Upload */
            if($_GET['status']=='logo_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $old_img = $_POST['old_logo'];
                    if ($_FILES['logo']["size"] > 0) {
                        $file_format = $_FILES["logo"];
                        $kaynak = $_FILES["logo"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['logo']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['logo']['name']));
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
                        $target = "../i/uploads/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml') {
                            $gitti = move_uploaded_file($kaynak, $target);

                            $guncelle = $db->prepare("UPDATE bakim SET
                               logo=:logo 
                         WHERE id='1'      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'logo' => $file_name
                            ));
                            if($sonuc){
                                if($old_img == !null || isset($old_img) ) {
                                    unlink("../i/uploads/$old_img");
                                }
                                header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Logo Upload SON */




        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=maintenance');
    $_SESSION['main_alert'] = 'demo';
}