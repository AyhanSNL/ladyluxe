<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status']) && $_POST && isset($_POST['update'])) {
        if ($_GET['status'] == 'main_update' || $_GET['status'] == 'menu_update' || $_GET['status'] == 'header_mobillogo_update' || $_GET['status'] == 'fixed_update') {

            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            if( $_GET['status'] == 'fixed_update' ) {
                $guncelle = $db->prepare("UPDATE mobiltema SET
                     sabit=:sabit,    
                     uye_giris=:uye_giris,
                     sepet=:sepet,
                     favori=:favori,
                     sabit_bg=:sabit_bg,
                     sabit_text=:sabit_text,
                     sabit_golge=:sabit_golge
                  WHERE id='1'      
                 ");
                $sonuc = $guncelle->execute(array(
                    'sabit' => colorFormat($_POST['sabit']),
                    'uye_giris' => $_POST['uye_giris'],
                    'sepet' => colorFormat($_POST['sepet']),
                    'favori' => colorFormat($_POST['favori']),
                    'sabit_bg' => colorFormat($_POST['sabit_bg']),
                    'sabit_text' => colorFormat($_POST['sabit_text']),
                    'sabit_golge' => colorFormat($_POST['sabit_golge'])
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mobil_settings');
                    $_SESSION['main_alert'] = 'success';
                    $_SESSION['collepse_status'] = 'fixedAcc';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }

            /* Genel Ayarlar */
            if( $_GET['status'] == 'main_update' ) {
                $guncelle = $db->prepare("UPDATE mobiltema SET
                     alt_border=:alt_border,    
                     round=:round,
                     bar_border=:bar_border,
                     bar_color=:bar_color,
                     bar_bg=:bar_bg,
                     bar_area=:bar_area,
                     ara_home=:ara_home
                  WHERE id='1'      
                 ");
                $sonuc = $guncelle->execute(array(
                    'alt_border' => colorFormat($_POST['alt_border']),
                    'round' => $_POST['round'],
                    'bar_border' => colorFormat($_POST['bar_border']),
                    'bar_color' => colorFormat($_POST['bar_color']),
                    'bar_bg' => colorFormat($_POST['bar_bg']),
                    'bar_area' => $_POST['bar_area'],
                    'ara_home' => $_POST['ara_home']
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mobil_settings');
                    $_SESSION['main_alert'] = 'success';
                    $_SESSION['collepse_status'] = 'genelAcc';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> Genel Ayarlar SON */

            /* Açılır Bar */
            if( $_GET['status'] == 'menu_update' ) {
                $guncelle = $db->prepare("UPDATE mobiltema SET
                     op_menu_bg=:op_menu_bg,    
                     ara=:ara,
                     op_menu_text=:op_menu_text,
                     op_menu_hover=:op_menu_hover,
                     op_menu_hover_text=:op_menu_hover_text,
                     op_menu_border=:op_menu_border,
                     ara_bg=:ara_bg,
                     ara_border=:ara_border,
                     ara_text=:ara_text,
                     cagri_bg=:cagri_bg,
                     cagri_text=:cagri_text,
                     cagri_border=:cagri_border,
                     kapat_bg=:kapat_bg,
                     kapat_renk=:kapat_renk
                  WHERE id='1'      
                 ");
                $sonuc = $guncelle->execute(array(
                    'op_menu_bg' => colorFormat($_POST['op_menu_bg']),
                    'ara' => $_POST['ara'],
                    'op_menu_text' => colorFormat($_POST['op_menu_text']),
                    'op_menu_hover' => colorFormat($_POST['op_menu_hover']),
                    'op_menu_hover_text' => colorFormat($_POST['op_menu_hover_text']),
                    'op_menu_border' => colorFormat($_POST['op_menu_border']),
                    'ara_bg' => colorFormat($_POST['ara_bg']),
                    'ara_border' => colorFormat($_POST['ara_border']),
                    'ara_text' => colorFormat($_POST['ara_text']),
                    'cagri_bg' => colorFormat($_POST['cagri_bg']),
                    'cagri_text' => colorFormat($_POST['cagri_text']),
                    'cagri_border' => colorFormat($_POST['cagri_border']),
                    'kapat_bg' => colorFormat($_POST['kapat_bg']),
                    'kapat_renk' => colorFormat($_POST['kapat_renk'])
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mobil_settings');
                    $_SESSION['main_alert'] = 'success';
                    $_SESSION['collepse_status'] = 'menuAcc';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> Açılır Bar SON */


            /* MobilMain Logo */
            if( $_GET['status'] == 'header_mobillogo_update' ) {
                $old_img = $_POST['old_logo'];
                if ($_FILES['header_mobil_logo']["size"] > 0) {
                    $file_format = $_FILES["header_mobil_logo"];
                    $kaynak = $_FILES["header_mobil_logo"]["tmp_name"];
                    $uzanti = explode(".", $_FILES['header_mobil_logo']['name']);
                    $random = rand(0, (int)99999);
                    $random2 = rand(0, (int)999);
                    $filename = trim(addslashes($_FILES['header_mobil_logo']['name']));
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

                    if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                        $gitti = move_uploaded_file($kaynak, $target);
                        $guncelle = $db->prepare("UPDATE header_ayar SET
                                         header_mobil_logo=:header_mobil_logo
                                         WHERE id='1'      
                                        ");
                        $sonuc = $guncelle->execute(array(
                            'header_mobil_logo' => $file_name,
                        ));
                        if($sonuc){
                            if($old_img == !null || isset($old_img) ) {
                                unlink("../images/logo/$old_img");
                            }
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mobil_settings');
                            $_SESSION['collepse_status'] = 'logoAcc';
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mobil_settings');
                        $_SESSION['collepse_status'] = 'logoAcc';
                        $_SESSION['main_alert'] = 'filetype';
                    }


                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mobil_settings');
                    $_SESSION['collepse_status'] = 'logoAcc';
                    $_SESSION['main_alert'] = 'filesize';
                }
            }
            /*  <========SON=========>>> MobilMain Logo SON */







        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_mobil_settings');
    $_SESSION['main_alert'] = 'demo';
}