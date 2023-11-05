<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status']) && $_POST && isset($_POST['update'])) {
        if ($_GET['status'] == 'main_update' || $_GET['status'] == 'dropdown_update' || $_GET['status'] == 'header_logo_update' || $_GET['status'] == 'header_mobillogo_update' || $_GET['status'] == 'topheader_update') {


            /* Genel Ayarlar */
            if( $_GET['status'] == 'main_update' ) {
                /* Renk Format */


                function colorFormat($degisken){
                    $isim  = $degisken;
                    $eski   = '#';
                    $yeni   = '';
                    $isim = str_replace($eski, $yeni, $isim);
                    return $isim;
                }

                /*  <========SON=========>>> Renk Format SON */
                $guncelle = $db->prepare("UPDATE header_ayar SET
                     cagri_merkezi=:cagri_merkezi,    
                     cagri_no=:cagri_no,
                     padding=:padding,
                     header_text_status=:header_text_status,
                     header_search=:header_search,
                     search_tip=:search_tip,
                     font_select=:font_select,
                     header_bell=:header_bell,
                     header_login=:header_login,
                     header_fav=:header_fav,
                     header_cart=:header_cart,
                     search_border_radius=:search_border_radius,
                     search_shadow=:search_shadow,
                     count_bg=:count_bg,
                     count_bg_2=:count_bg_2,
                     dropdown_shadow=:dropdown_shadow,
                     dropdown_radius=:dropdown_radius,
                     dropdown_compare=:dropdown_compare,
                     dropdown_fav=:dropdown_fav,
                     dropdown_bell=:dropdown_bell,
                     login_dropdown_compare=:login_dropdown_compare,
                     login_dropdown_fav=:login_dropdown_fav,
                     login_dropdown_bell=:login_dropdown_bell,
                     login_dropdown_account=:login_dropdown_account,
                     login_dropdown_address=:login_dropdown_address,
                     login_dropdown_order=:login_dropdown_order,
                     login_dropdown_support=:login_dropdown_support,
                     login_dropdown_comments=:login_dropdown_comments,
                     login_dropdown_coupon=:login_dropdown_coupon,
                     search_bg=:search_bg,
                     search_border_color=:search_border_color,
                     search_text_color=:search_text_color,
                     search_place_color=:search_place_color,
                     search_focus_border=:search_focus_border,
                     search_button_color=:search_button_color,
                     call_i_color=:call_i_color,
                     call_text_color=:call_text_color,
                     navbutton_color=:navbutton_color,
                     navbutton_hover_color=:navbutton_hover_color,
                     dropdown_border=:dropdown_border,
                     header_bg=:header_bg
                  WHERE id='1'      
                 ");
                $sonuc = $guncelle->execute(array(
                    'cagri_merkezi' => $_POST['cagri_merkezi'],
                    'cagri_no' => $_POST['cagri_no'],
                    'padding' => $_POST['padding'],
                    'header_text_status' => $_POST['header_text_status'],
                    'header_search' => $_POST['header_search'],
                    'search_tip' => $_POST['search_tip'],
                    'font_select' => $_POST['font_select'],
                    'header_bell' => $_POST['header_bell'],
                    'header_login' => $_POST['header_login'],
                    'header_fav' => $_POST['header_fav'],
                    'header_cart' => $_POST['header_cart'],
                    'search_border_radius' => $_POST['search_border_radius'],
                    'search_shadow' => $_POST['search_shadow'],
                    'count_bg' => $_POST['count_bg'],
                    'count_bg_2' => $_POST['count_bg_2'],
                    'dropdown_shadow' => $_POST['dropdown_shadow'],
                    'dropdown_radius' => $_POST['dropdown_radius'],
                    'dropdown_compare' => $_POST['dropdown_compare'],
                    'dropdown_fav' => $_POST['dropdown_fav'],
                    'dropdown_bell' => $_POST['dropdown_bell'],
                    'login_dropdown_compare' => $_POST['login_dropdown_compare'],
                    'login_dropdown_fav' => $_POST['login_dropdown_fav'],
                    'login_dropdown_bell' => $_POST['login_dropdown_bell'],
                    'login_dropdown_account' => $_POST['login_dropdown_account'],
                    'login_dropdown_address' => $_POST['login_dropdown_address'],
                    'login_dropdown_order' => $_POST['login_dropdown_order'],
                    'login_dropdown_support' => $_POST['login_dropdown_support'],
                    'login_dropdown_comments' => $_POST['login_dropdown_comments'],
                    'login_dropdown_coupon' => $_POST['login_dropdown_coupon'],
                    'search_bg' => colorFormat($_POST['search_bg']),
                    'search_border_color' => colorFormat($_POST['search_border_color']),
                    'search_text_color' => colorFormat($_POST['search_text_color']),
                    'search_place_color' => colorFormat($_POST['search_place_color']),
                    'search_focus_border' => colorFormat($_POST['search_focus_border']),
                    'search_button_color' => colorFormat($_POST['search_button_color']),
                    'call_i_color' => colorFormat($_POST['call_i_color']),
                    'call_text_color' => colorFormat($_POST['call_text_color']),
                    'navbutton_color' => colorFormat($_POST['navbutton_color']),
                    'navbutton_hover_color' => colorFormat($_POST['navbutton_hover_color']),
                    'dropdown_border' => colorFormat($_POST['dropdown_border']),
                    'header_bg' => colorFormat($_POST['header_bg']),
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                    $_SESSION['main_alert'] = 'success';
                    $_SESSION['collepse_status'] = 'genelAcc';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> Genel Ayarlar SON */


            /* Main Logo */
            if( $_GET['status'] == 'header_logo_update' ) {
                $old_img = $_POST['old_logo'];
                if ($_FILES['header_logo']["size"] > 0) {
                    $file_format = $_FILES["header_logo"];
                    $kaynak = $_FILES["header_logo"]["tmp_name"];
                    $uzanti = explode(".", $_FILES['header_logo']['name']);
                    $random = rand(0, (int)99999);
                    $random2 = rand(0, (int)999);
                    $filename = trim(addslashes($_FILES['header_logo']['name']));
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
                                         header_logo=:header_logo
                                         WHERE id='1'      
                                        ");
                        $sonuc = $guncelle->execute(array(
                            'header_logo' => $file_name,
                        ));
                        if($sonuc){
                            if($old_img == !null || isset($old_img) ) {
                                unlink("../images/logo/$old_img");
                            }
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                            $_SESSION['collepse_status'] = 'logoAcc';
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                        $_SESSION['collepse_status'] = 'logoAcc';
                        $_SESSION['main_alert'] = 'filetype';
                    }


                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                    $_SESSION['collepse_status'] = 'logoAcc';
                    $_SESSION['main_alert'] = 'filesize';
                }
            }
            /*  <========SON=========>>> Main Logo SON */


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
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                            $_SESSION['collepse_status'] = 'logoAcc';
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                        $_SESSION['collepse_status'] = 'logoAcc';
                        $_SESSION['main_alert'] = 'filetype';
                    }


                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                    $_SESSION['collepse_status'] = 'logoAcc';
                    $_SESSION['main_alert'] = 'filesize';
                }
            }
            /*  <========SON=========>>> MobilMain Logo SON */


            /* Top Header Ayarlar */
                if( $_GET['status'] == 'topheader_update' ) {
                    /* Renk Format */
                    $kaynak  = $_POST['topheader_bg'];
                    $eski   = '#';
                    $yeni   = '';
                    $kaynak = str_replace($eski, $yeni, $kaynak);

                    $kaynak2  = $_POST['topheader_border'];
                    $eski   = '#';
                    $yeni   = '';
                    $kaynak2 = str_replace($eski, $yeni, $kaynak2);

                    $kaynak3  = $_POST['topheader_a_color'];
                    $eski   = '#';
                    $yeni   = '';
                    $kaynak3 = str_replace($eski, $yeni, $kaynak3);

                    $kaynak4  = $_POST['topheader_a_color_hover'];
                    $eski   = '#';
                    $yeni   = '';
                    $kaynak4 = str_replace($eski, $yeni, $kaynak4);
                    /*  <========SON=========>>> Renk Format SON */
                 $guncelle = $db->prepare("UPDATE header_ayar SET
                     topheader=:topheader,    
                     topheader_bg=:topheader_bg,
                     topheader_border=:topheader_border,
                     topheader_dil=:topheader_dil,
                     topheader_kur=:topheader_kur,
                     topheader_a_color=:topheader_a_color,
                     topheader_a_color_hover=:topheader_a_color_hover,
                     topheader_a_size=:topheader_a_size,
                     topheader_a_padding=:topheader_a_padding,
                     topheader_a_weight=:topheader_a_weight
                  WHERE id='1'      
                 ");
                 $sonuc = $guncelle->execute(array(
                     'topheader' => $_POST['topheader'],
                     'topheader_bg' => $kaynak,
                     'topheader_border' => $kaynak2,
                     'topheader_dil' => $_POST['topheader_dil'],
                     'topheader_kur' => $_POST['topheader_kur'],
                     'topheader_a_color' => $kaynak3,
                     'topheader_a_color_hover' => $kaynak4,
                     'topheader_a_size' => $_POST['topheader_a_size'],
                     'topheader_a_padding' => $_POST['topheader_a_padding'],
                     'topheader_a_weight' => $_POST['topheader_a_weight']
                 ));
                 if($sonuc){
                     header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                     $_SESSION['collepse_status'] = 'topHAcc';
                     $_SESSION['main_alert'] = 'success';
                 }else{
                 echo 'Veritabanı Hatası';
                 }
                }
            /*  <========SON=========>>> Top Header Ayarlar SON */


            /* Dropdown Ayarları */
            if( $_GET['status'] == 'dropdown_update' ) {
                /* Renk Format */
                $kaynak  = $_POST['arkaplan'];
                $eski   = '#';
                $yeni   = '';
                $kaynak = str_replace($eski, $yeni, $kaynak);

                $kaynak2  = $_POST['border_color'];
                $eski   = '#';
                $yeni   = '';
                $kaynak2 = str_replace($eski, $yeni, $kaynak2);

                $kaynak3  = $_POST['box_text_color'];
                $eski   = '#';
                $yeni   = '';
                $kaynak3 = str_replace($eski, $yeni, $kaynak3);

                $kaynak4  = $_POST['box_hover_bg'];
                $eski   = '#';
                $yeni   = '';
                $kaynak4 = str_replace($eski, $yeni, $kaynak4);

                $kaynak5  = $_POST['box_hover_text_color'];
                $eski   = '#';
                $yeni   = '';
                $kaynak5 = str_replace($eski, $yeni, $kaynak5);

                $kaynak6  = $_POST['second_bg'];
                $eski   = '#';
                $yeni   = '';
                $kaynak6 = str_replace($eski, $yeni, $kaynak6);

                $kaynak7  = $_POST['second_bg_hover'];
                $eski   = '#';
                $yeni   = '';
                $kaynak7 = str_replace($eski, $yeni, $kaynak7);

                $kaynak8  = $_POST['second_text_color'];
                $eski   = '#';
                $yeni   = '';
                $kaynak8 = str_replace($eski, $yeni, $kaynak8);

                $kaynak9  = $_POST['second_hover_text_color'];
                $eski   = '#';
                $yeni   = '';
                $kaynak9 = str_replace($eski, $yeni, $kaynak9);

                $kaynak10  = $_POST['second_border'];
                $eski   = '#';
                $yeni   = '';
                $kaynak10 = str_replace($eski, $yeni, $kaynak10);

                $kaynak11  = $_POST['third_bg'];
                $eski   = '#';
                $yeni   = '';
                $kaynak11 = str_replace($eski, $yeni, $kaynak11);

                $kaynak12  = $_POST['third_bg_hover'];
                $eski   = '#';
                $yeni   = '';
                $kaynak12 = str_replace($eski, $yeni, $kaynak12);

                $kaynak13  = $_POST['third_text_color'];
                $eski   = '#';
                $yeni   = '';
                $kaynak13 = str_replace($eski, $yeni, $kaynak13);

                $kaynak14  = $_POST['third_hover_text_color'];
                $eski   = '#';
                $yeni   = '';
                $kaynak14 = str_replace($eski, $yeni, $kaynak14);

                $kaynak15  = $_POST['mega_bg'];
                $eski   = '#';
                $yeni   = '';
                $kaynak15 = str_replace($eski, $yeni, $kaynak15);

                $kaynak16  = $_POST['mega_baslik_text'];
                $eski   = '#';
                $yeni   = '';
                $kaynak16 = str_replace($eski, $yeni, $kaynak16);

                $kaynak17  = $_POST['mega_alt_text'];
                $eski   = '#';
                $yeni   = '';
                $kaynak17 = str_replace($eski, $yeni, $kaynak17);

                $kaynak18  = $_POST['mega_border'];
                $eski   = '#';
                $yeni   = '';
                $kaynak18 = str_replace($eski, $yeni, $kaynak18);

                $kaynak19  = $_POST['dropdown_topborder'];
                $eski   = '#';
                $yeni   = '';
                $kaynak19 = str_replace($eski, $yeni, $kaynak19);
                /*  <========SON=========>>> Renk Format SON */
                $guncelle = $db->prepare("UPDATE haeder_dropdown SET
                     arkaplan=:arkaplan,   
                     border_size=:border_size, 
                     border_size_top=:border_size_top,
                     border_color=:border_color,
                     area=:area,
                     box_text_color=:box_text_color,
                     box_hover_bg=:box_hover_bg,
                     box_hover_text_color=:box_hover_text_color,
                     box_padding_left=:box_padding_left,
                     box_padding_top=:box_padding_top,
                     box_font_size=:box_font_size,
                     box_font_weight=:box_font_weight,
                     second_bg=:second_bg,
                     second_bg_hover=:second_bg_hover,
                     second_text_color=:second_text_color,
                     second_hover_text_color=:second_hover_text_color,
                     second_border=:second_border,
                     second_font_size=:second_font_size,
                     third_bg=:third_bg,
                     third_bg_hover=:third_bg_hover,
                     third_text_color=:third_text_color,
                     third_hover_text_color=:third_hover_text_color,
                     third_font_size=:third_font_size,
                     third_border=:third_border,
                     mega_bg=:mega_bg,
                     mega_baslik_text=:mega_baslik_text,
                     mega_alt_text=:mega_alt_text,
                     mega_border=:mega_border,
                     dropdown_topborder=:dropdown_topborder,
                     dropdown_overlay=:dropdown_overlay
                  WHERE id='1'      
                 ");
                $sonuc = $guncelle->execute(array(
                    'arkaplan' => $kaynak,
                    'border_size' => $_POST['border_size'],
                    'border_size_top' => $_POST['border_size_top'],
                    'border_color' => $kaynak2,
                    'area' => $_POST['area'],
                    'box_text_color' => $kaynak3,
                    'box_hover_bg' => $kaynak4,
                    'box_hover_text_color' => $kaynak5,
                    'box_padding_left' => $_POST['box_padding_left'],
                    'box_padding_top' => $_POST['box_padding_top'],
                    'box_font_size' => $_POST['box_font_size'],
                    'box_font_weight' => $_POST['box_font_weight'],
                    'second_bg' => $kaynak6,
                    'second_bg_hover' => $kaynak7,
                    'second_text_color' => $kaynak8,
                    'second_hover_text_color' => $kaynak9,
                    'second_border' => $kaynak10,
                    'second_font_size' => $_POST['second_font_size'],
                    'third_bg' => $kaynak11,
                    'third_bg_hover' => $kaynak12,
                    'third_text_color' => $kaynak13,
                    'third_hover_text_color' => $kaynak14,
                    'third_font_size' => $_POST['third_font_size'],
                    'third_border' => $_POST['third_border'],
                    'mega_bg' => $kaynak15,
                    'mega_baslik_text' => $kaynak16,
                    'mega_alt_text' => $kaynak17,
                    'mega_border' => $kaynak18,
                    'dropdown_topborder' => $kaynak19,
                    'dropdown_overlay' => $_POST['dropdown_overlay']
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                    $_SESSION['collepse_status'] = 'menuAcc';
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> Dropdown Ayarları SON */





        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
    $_SESSION['main_alert'] = 'demo';
}