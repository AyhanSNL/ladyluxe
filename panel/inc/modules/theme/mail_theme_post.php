<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'main_update' || $_GET['status'] == 'logo_update'){
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

                    $guncelle = $db->prepare("UPDATE eposta_tema SET
                            arkaplan=:arkaplan,
                            ana_div=:ana_div,
                            ana_div_baslik_weight=:ana_div_baslik_weight,
                            ana_div_baslik_size=:ana_div_baslik_size,
                            ana_div_baslik_color=:ana_div_baslik_color,
                            ana_div_font_size=:ana_div_font_size,
                            ana_div_width=:ana_div_width,
                            ana_div_text=:ana_div_text,
                            ana_div_a_color=:ana_div_a_color,
                            ana_div_radius=:ana_div_radius,
                            ana_div_border_size=:ana_div_border_size,
                            ana_div_border=:ana_div_border,
                            ana_div_in_border=:ana_div_in_border,
                            ana_div_padding=:ana_div_padding,
                            imza_bg=:imza_bg,
                            imza_border_radius=:imza_border_radius,
                            imza_border_size=:imza_border_size,
                            imza_border=:imza_border,
                            imza_text=:imza_text,
                            imza_font_size=:imza_font_size,
                            imza_icerik=:imza_icerik
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'arkaplan' => colorFormat($_POST['arkaplan']),
                        'ana_div' => colorFormat($_POST['ana_div']),
                        'ana_div_baslik_weight' => $_POST['ana_div_baslik_weight'],
                        'ana_div_baslik_size' => $_POST['ana_div_baslik_size'],
                        'ana_div_baslik_color' => colorFormat($_POST['ana_div_baslik_color']),
                        'ana_div_font_size' => $_POST['ana_div_font_size'],
                        'ana_div_width' => $_POST['ana_div_width'],
                        'ana_div_text' => colorFormat($_POST['ana_div_text']),
                        'ana_div_a_color' => colorFormat($_POST['ana_div_a_color']),
                        'ana_div_radius' => $_POST['ana_div_radius'],
                        'ana_div_border_size' => $_POST['ana_div_border_size'],
                        'ana_div_border' => colorFormat($_POST['ana_div_border']),
                        'ana_div_in_border' => colorFormat($_POST['ana_div_in_border']),
                        'ana_div_padding' => $_POST['ana_div_padding'],
                        'imza_bg' => colorFormat($_POST['imza_bg']),
                        'imza_border_radius' => $_POST['imza_border_radius'],
                        'imza_border_size' => $_POST['imza_border_size'],
                        'imza_border' => colorFormat($_POST['imza_border']),
                        'imza_text' => colorFormat($_POST['imza_text']),
                        'imza_font_size' => $_POST['imza_font_size'],
                        'imza_icerik' => $_POST['imza_icerik'],
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mail');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Genel Güncelleme SON */

            /* Logo Update */
            if($_GET['status'] == 'logo_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if ($_FILES['smtp_logo']["size"] > 0) {
                        $file_format = $_FILES["smtp_logo"];
                        $kaynak = $_FILES["smtp_logo"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['smtp_logo']['name']);
                        $random = rand(0,(int) 99999);
                        $random2 = rand(0,(int) 999);
                        $filename = trim(addslashes($_FILES['smtp_logo']['name']));
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
                        $target = "../images/logo/" . $file_name;

                        if( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  ) {
                            $gitti = move_uploaded_file($kaynak, $target);

                            $guncelle = $db->prepare("UPDATE ayarlar SET
                                smtp_logo=:smtp_logo
                         WHERE id='1'      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'smtp_logo' => $file_name,
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mail');
                                $_SESSION['main_alert'] = 'success';
                                unlink("../images/logo/$_POST[old_logo]");
                            }else{
                                echo 'Veritabanı Hatası';
                            }

                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mail');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mail');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Logo Update SON */

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