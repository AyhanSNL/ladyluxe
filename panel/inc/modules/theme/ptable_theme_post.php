<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'main_update' || $_GET['status'] == 'bg_update' || $_GET['status'] == 'bg_delete' ){
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

                /* Genel Update */
                            if($_GET['status'] == 'main_update'  ) {
                                if($_POST && isset($_POST['update'])  ) {
                                    $guncelle = $db->prepare("UPDATE pricing_ayar SET
                                     baslik_renk=:baslik_renk,      
                                     padding=:padding,
                                     spot_renk=:spot_renk,
                                     tags=:tags,      
                                     meta_desc=:meta_desc,   
                                     margin=:margin,
                                     tablo_limit=:tablo_limit,
                                     baslik_font=:baslik_font,
                                     baslik_space=:baslik_space,
                                     pricingayar_border=:pricingayar_border,
                                     pricing_basliktip=:pricing_basliktip,
                                     pricing_baslik_cizgi=:pricing_baslik_cizgi,
                                     pricing_baslik_bg=:pricing_baslik_bg,
                                     tab_bg=:tab_bg,
                                     tab_radius=:tab_radius,
                                     tab_text=:tab_text,
                                     tab_act_bg=:tab_act_bg,
                                     tab_act_text=:tab_act_text,
                                     tab_font_size=:tab_font_size,
                                     tab_shadow=:tab_shadow,
                                     detay_bg=:detay_bg
                                     WHERE id='1'      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'baslik_renk' => colorFormat($_POST['baslik_renk']),
                                        'padding' => $_POST['padding'],
                                        'spot_renk' => colorFormat($_POST['spot_renk']),
                                        'tags' => $_POST['tags'],
                                        'meta_desc' => $_POST['meta_desc'],
                                        'margin' => $_POST['margin'],
                                        'tablo_limit' => $_POST['tablo_limit'],
                                        'baslik_font' => $_POST['baslik_font'],
                                        'baslik_space' => $_POST['baslik_space'],
                                        'pricingayar_border' => colorFormat($_POST['pricingayar_border']),
                                        'pricing_basliktip' => $_POST['pricing_basliktip'],
                                        'pricing_baslik_cizgi' => colorFormat($_POST['pricing_baslik_cizgi']),
                                        'pricing_baslik_bg' => colorFormat($_POST['pricing_baslik_bg']),
                                        'tab_bg' => colorFormat($_POST['tab_bg']),
                                        'tab_radius' => $_POST['tab_radius'],
                                        'tab_text' => colorFormat($_POST['tab_text']),
                                        'tab_act_bg' => colorFormat($_POST['tab_act_bg']),
                                        'tab_act_text' => colorFormat($_POST['tab_act_text']),
                                        'tab_font_size' => $_POST['tab_font_size'],
                                        'tab_shadow' => $_POST['tab_shadow'],
                                        'detay_bg' => colorFormat($_POST['detay_bg'])
                                    ));
                                    if($sonuc){
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_pricing');
                                        $_SESSION['main_alert'] = 'success';
                                        $_SESSION['collepse_status'] = 'genelAcc';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                /*  <========SON=========>>> Genel Update SON */



            /* bg_update */
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

                                if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $guncelle = $db->prepare("UPDATE pricing_ayar SET
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
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_pricing');
                                        $_SESSION['main_alert'] = 'success';
                                        $_SESSION['collepse_status'] = 'otherAcc';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_pricing');
                                    $_SESSION['main_alert'] = 'filetype';
                                    $_SESSION['collepse_status'] = 'otherAcc';
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE pricing_ayar SET
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
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_pricing');
                                    $_SESSION['main_alert'] = 'success';
                                    $_SESSION['collepse_status'] = 'otherAcc';

                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                                /*  <========SON=========>>> Görsel Eklemeden Diğer Ayar Kayıtları SON */
                            }
                            /*  <========SON=========>>> Arkaplan Görseli SON */
                        }
                        if($_POST['bg_tip']== '1'  ) {
                            /* Sadece Renk */
                            $guncelle = $db->prepare("UPDATE pricing_ayar SET
                                    bg_color=:bg_color,
                                    bg_tip=:bg_tip
                             WHERE id='1'      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'bg_color' => colorFormat($_POST['bg_color']),
                                'bg_tip' => '1'
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_pricing');
                                $_SESSION['main_alert'] = 'success';
                                $_SESSION['collepse_status'] = 'otherAcc';
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
            if($_GET['status'] == 'bg_delete'  ) {
                $sorgu = $db->prepare("select * from pricing_ayar where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink("../images/uploads/$row[bg_image]");
                $guncelle = $db->prepare("UPDATE pricing_ayar SET
                            bg_image=:bg_image
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'bg_image' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_pricing');
                    $_SESSION['collepse_status'] = 'otherAcc';
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> bg_update SON */



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