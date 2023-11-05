<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'banner_edit' || $_GET['status'] == 'bg_image_update' || $_GET['status'] == 'bg_image_delete' ){
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            /* Banner Düzenle */
            if($_GET['status'] == 'banner_edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE page_header SET
                                        area=:area,      
                     font_size=:font_size,
                     spot_font_size=:spot_font_size,
                              font_weight=:font_weight,      
                     padding_top=:padding_top,
                     padding_bottom=:padding_bottom,
                              margin_top=:margin_top,      
                     margin_bottom=:margin_bottom,
                     baslik_space=:baslik_space,
                     baslik_font=:baslik_font,      
                     tip=:tip,
                     durum=:durum,
                     border_top=:border_top,      
                     border_bottom=:border_bottom,
                     baslik_color=:baslik_color,    
                    spot_color=:spot_color      
                     WHERE id={$_POST['banner_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'area' => $_POST['area'],
                        'font_size' => $_POST['font_size'],
                        'spot_font_size' => $_POST['spot_font_size'],
                        'font_weight' => $_POST['font_weight'],
                        'padding_top' => $_POST['padding_top'],
                        'padding_bottom' => $_POST['padding_bottom'],
                        'margin_top' => $_POST['margin_top'],
                        'margin_bottom' => $_POST['margin_bottom'],
                        'baslik_space' => $_POST['baslik_space'],
                        'baslik_font' => $_POST['baslik_font'],
                        'tip' => $_POST['tip'],
                        'durum' => $_POST['durum'],
                        'border_top' => colorFormat($_POST['border_top']),
                        'border_bottom' => colorFormat($_POST['border_bottom']),
                        'baslik_color' => colorFormat($_POST['baslik_color']),
                        'spot_color' => colorFormat($_POST['spot_color'])
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banner_edit&no='.$_POST['banner_id'].'');
                        $_SESSION['collepse_status'] ='genelAcc';
                        $_SESSION['main_alert'] = 'success';
                    }else{
                        echo 'Veritabanı Hatasıss';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner Düzenle SON */

            /* Arkaplan Ayarları */
            if($_GET['status'] == 'bg_image_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['bg_tip']=='0' || $_POST['bg_tip'] == '1'  ) {
                        if($_POST['bg_tip']== '0'  ) {
                            /* Arkaplan Görseli */
                            if ($_FILES['bg_image']["size"] > 0) {
                                $old_img = $_POST['old_bg'];
                                $file_format = $_FILES["bg_image"];
                                $kaynak = $_FILES["bg_image"]["tmp_name"];
                                $uzanti = explode(".", $_FILES['bg_image']['name']);
                                $random = rand(0, (int)99999);
                                $random2 = rand(0, (int)999);
                                $filename = trim(addslashes($_FILES['bg_image']['name']));
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
                                    $guncelle = $db->prepare("UPDATE page_header SET
                                         bg_image=:bg_image,
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='$_POST[banner_id]'      
                                        ");
                                    $sonuc = $guncelle->execute(array(
                                        'bg_image' => $file_name,
                                        'bg_tip' => '0',
                                        'bg_dark' => $_POST['bg_dark'],
                                        'bg_durum' => $_POST['bg_durum']
                                    ));
                                    if($sonuc){
                                        if($old_img == !null || isset($old_img) ) {
                                            unlink("../images/uploads/$old_img");
                                        }
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banner_edit&no='.$_POST['banner_id'].'');
                                                                $_SESSION['collepse_status'] ='bgAcc';
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banner_edit&no='.$_POST['banner_id'].'');
                                                $_SESSION['collepse_status'] ='bgAcc';
                                    $_SESSION['main_alert'] = 'filetype';
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE page_header SET
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='$_POST[banner_id]'      
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'bg_tip' => '0',
                                    'bg_dark' => $_POST['bg_dark'],
                                    'bg_durum' => $_POST['bg_durum']
                                ));
                                if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banner_edit&no='.$_POST['banner_id'].'');
                                    $_SESSION['collepse_status'] ='bgAcc';
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                                /*  <========SON=========>>> Görsel Eklemeden Diğer Ayar Kayıtları SON */
                            }
                            /*  <========SON=========>>> Arkaplan Görseli SON */
                        }
                        if($_POST['bg_tip']== '1'  ) {
                            /* Sadece Renk */
                            $guncelle = $db->prepare("UPDATE page_header SET
                                    bg_color=:bg_color,
                                    bg_tip=:bg_tip
                                         WHERE id='$_POST[banner_id]'      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'bg_color' => colorFormat($_POST['bg_color']),
                                'bg_tip' => '1'
                            ));
                            if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banner_edit&no='.$_POST['banner_id'].'');
                         $_SESSION['collepse_status'] ='bgAcc';
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Sadece Renk SON */
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }


            if($_GET['status'] == 'bg_image_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null  ) {
                    $sorgu = $db->prepare("select * from page_header where id='$_GET[no]' ");
                    $sorgu->execute();
                    $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                    unlink("../images/uploads/$row[bg_image]");
                    $guncelle = $db->prepare("UPDATE page_header SET
                            bg_image=:bg_image
                     WHERE id='$_GET[no]'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'bg_image' => null,
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banner_edit&no='.$_GET['no'].'');
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['collepse_status'] ='bgAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Arkaplan Ayarları SON */




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