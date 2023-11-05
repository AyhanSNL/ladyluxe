<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'main_update' || $_GET['status'] == 'bg_update' || $_GET['status'] == 'bg_img_delete' || $_GET['status'] == 'copyright' || $_GET['status'] == 'footer_logo' || $_GET['status'] == 'footer_logo_delete' || $_GET['status'] == 'footer_img' || $_GET['status'] == 'footer_img_delete') {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            /* Genel Ayarlar */
            if( $_GET['status'] == 'main_update' ) {
                if($_POST && isset($_POST['update'])  ) {
                        $guncelle = $db->prepare("UPDATE footer_ayar SET
                                padding=:padding,
                                margin=:margin,
                                baslik_font=:baslik_font,
                                sosyal=:sosyal,
                                ana_renk=:ana_renk,
                                alt_renk=:alt_renk,
                                footer_html=:footer_html,
                                footer_border=:footer_border
                         WHERE id='1'      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'padding' => $_POST['padding'],
                            'margin' => $_POST['margin'],
                            'baslik_font' => $_POST['baslik_font'],
                            'sosyal' => $_POST['sosyal'],
                            'ana_renk' => colorFormat($_POST['ana_renk']),
                            'alt_renk' => colorFormat($_POST['alt_renk']),
                            'footer_html' => $_POST['footer_html'],
                            'footer_border' => colorFormat($_POST['footer_border'])
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                            $_SESSION['collepse_status'] = 'genelAcc';
                            $_SESSION['main_alert'] = 'success';
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Genel Ayarlar SON */
            
            
            /* Arkaplan Ayarları */
            if($_GET['status'] == 'bg_update'  ) {
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
                                    $guncelle = $db->prepare("UPDATE footer_ayar SET
                                         bg_image=:bg_image,
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
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
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                        $_SESSION['collepse_status'] = 'bgAcc';
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                    $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'filetype';
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE footer_ayar SET
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'bg_tip' => '0',
                                    'bg_dark' => $_POST['bg_dark'],
                                    'bg_durum' => $_POST['bg_durum']
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                    $_SESSION['collepse_status'] = 'bgAcc';
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
                            $guncelle = $db->prepare("UPDATE footer_ayar SET
                                    bg_color=:bg_color,
                                    bg_tip=:bg_tip
                             WHERE id='1'      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'bg_color' => colorFormat($_POST['bg_color']),
                                'bg_tip' => '1'
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                $_SESSION['collepse_status'] = 'bgAcc';
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


            if($_GET['status'] == 'bg_img_delete'  ) {
                      $sorgu = $db->prepare("select * from footer_ayar where id='1' ");
                      $sorgu->execute();
                      $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                      unlink("../images/uploads/$row[bg_image]");
                      $guncelle = $db->prepare("UPDATE footer_ayar SET
                            bg_image=:bg_image
                     WHERE id='1'      
                    ");
                      $sonuc = $guncelle->execute(array(
                          'bg_image' => null,
                      ));
                      if($sonuc){
                          header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                          $_SESSION['main_alert'] = 'success';
                      }else{
                          echo 'Veritabanı Hatası';
                      }
                  }
            /*  <========SON=========>>> Arkaplan Ayarları SON */

            /* Telif ayarları */
            if( $_GET['status'] == 'copyright' ) {
                if($_POST && isset($_POST['update'])   ) {
                    if($_POST['durum'] == '0' || $_POST['durum']== '1'  ) {
                        if($_POST['durum']== '0'  ) {
                            /* Eklenmemiş! Sıfırdan Ekle */
                            if($_POST['telif_text']== !null  ) {
                                $kaydet = $db->prepare("INSERT INTO footer_telif SET
                                         icerik=:icerik,
                                         dil=:dil
                                 ");
                                $sonuc = $kaydet->execute(array(
                                    'icerik' => $_POST['telif_text'],
                                    'dil' => $_SESSION['dil'],
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                    $_SESSION['collepse_status'] = 'copyrightAcc';
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                $_SESSION['collepse_status'] = 'copyrightAcc';
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                            /*  <========SON=========>>> Eklenmemiş! Sıfırdan Ekle SON */
                        }
                        if($_POST['durum']== '1' ) {
                            /* Update işlemi yap */
                            if($_POST['copyright_id'] == !null  ) {
                                $sorgu = $db->prepare("select * from footer_telif where id=:id ");
                                $sorgu->execute(array(
                                    'id' => $_POST['copyright_id']
                                ));
                                if($sorgu->rowCount()>'0'  ) {
                                   $guncelle = $db->prepare("UPDATE footer_telif SET
                                           icerik=:icerik
                                    WHERE id={$_POST['copyright_id']}      
                                   ");
                                   $sonuc = $guncelle->execute(array(
                                       'icerik' => $_POST['telif_text']
                                   ));
                                   if($sonuc){
                                       header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                       $_SESSION['collepse_status'] = 'copyrightAcc';
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
                            /*  <========SON=========>>> Update işlemi yap SON */
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Telif ayarları SON */


            /* Logo ayarları */
            if( $_GET['status'] == 'footer_logo' ) {
                if($_POST && isset($_POST['update'])  ) {
                    $old_img = $_POST['old_logo'];
                    if ($_FILES['footer_logo']["size"] > 0) {
                        $file_format = $_FILES["footer_logo"];
                        $kaynak = $_FILES["footer_logo"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['footer_logo']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['footer_logo']['name']));
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
                            $guncelle = $db->prepare("UPDATE footer_ayar SET
                                         footer_logo=:footer_logo
                                         WHERE id='1'      
                                        ");
                            $sonuc = $guncelle->execute(array(
                                'footer_logo' => $file_name,
                            ));
                            if($sonuc){
                                if($old_img == !null || isset($old_img) ) {
                                    unlink("../images/logo/$old_img");
                                }
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                $_SESSION['collepse_status'] = 'logoAcc';
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                            $_SESSION['collepse_status'] = 'logoAcc';
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                        $_SESSION['collepse_status'] = 'logoAcc';
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if( $_GET['status'] == 'footer_logo_delete' ) {
                $sorgu = $db->prepare("select * from footer_ayar where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink("../images/logo/$row[footer_logo]");
                $guncelle = $db->prepare("UPDATE footer_ayar SET
                            footer_logo=:footer_logo
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'footer_logo' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                    $_SESSION['collepse_status'] = 'logoAcc';
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> Logo ayarları SON */



            /* extra Image ayarları */
            if( $_GET['status'] == 'footer_img' ) {
                if($_POST && isset($_POST['update'])  ) {
                    $old_img = $_POST['old_img'];
                    if ($_FILES['gorsel']["size"] > 0) {
                        $file_format = $_FILES["gorsel"];
                        $kaynak = $_FILES["gorsel"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['gorsel']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['gorsel']['name']));
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
                            $guncelle = $db->prepare("UPDATE footer_ayar SET
                                         gorsel=:gorsel
                                         WHERE id='1'      
                                        ");
                            $sonuc = $guncelle->execute(array(
                                'gorsel' => $file_name,
                            ));
                            if($sonuc){
                                if($old_img == !null || isset($old_img) ) {
                                    unlink("../images/uploads/$old_img");
                                }
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                                $_SESSION['collepse_status'] = 'extraImgAcc';
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                            $_SESSION['collepse_status'] = 'extraImgAcc';
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                        $_SESSION['collepse_status'] = 'extraImgAcc';
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if( $_GET['status'] == 'footer_img_delete' ) {
                $sorgu = $db->prepare("select * from footer_ayar where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink("../images/uploads/$row[gorsel]");
                $guncelle = $db->prepare("UPDATE footer_ayar SET
                            gorsel=:gorsel
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'gorsel' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                    $_SESSION['collepse_status'] = 'extraImgAcc';
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> extra Image ayarları SON */

        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
    $_SESSION['main_alert'] = 'demo';
}