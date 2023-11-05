<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'tab_insert' || $_GET['status'] == 'firsat_add' || $_GET['status'] == 'firsat_delete' || $_GET['status'] == 'firsat_multidelete' || $_GET['status'] == 'firsat_time' || $_GET['status'] == 'html_modul_bg_delete' || $_GET['status'] == 'html_modul_bg' || $_GET['status'] == 'html_modul_other' || $_GET['status'] == 'banner2_add' || $_GET['status'] == 'banner2_edit' || $_GET['status'] == 'banner2_delete' || $_GET['status'] == 'banner1_delete' || $_GET['status'] == 'banner1_edit' || $_GET['status'] == 'banner1_add' || $_GET['status'] == 'banner1_edit' || $_GET['status'] == 'bannerproduct_multidelete' || $_GET['status'] == 'bannerproduct_delete' || $_GET['status'] == 'tab_update' || $_GET['status'] == 'bannerproduct_add' || $_GET['status'] == 'bannerproduct_edit' || $_GET['status'] == 'bannerproduct_list_add' || $_GET['status'] == 'bannerproduct_img_delete' || $_GET['status'] == 'bannerproduct_list_delete' || $_GET['status'] == 'bannerproduct_list_multidelete') {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            
            /* Fırsat Vitrin Add */
            if($_GET['status'] == 'firsat_add') {
                if ($_POST && isset($_POST['insert'])) {
                    if($_POST['son_tarih'] && $_POST['urun_id'] && $_POST['son_time']  ) {
                        $urunnn = $db->prepare("select baslik,id from urun where id=:id ");
                        $urunnn->execute(array(
                            'id' => $_POST['urun_id']
                        ));
                        $urunRow = $urunnn->fetch(PDO::FETCH_ASSOC);
                        if($urunnn->rowCount()>'0'  ) {
                            $vitrinSorgu = $db->prepare("select * from vitrin_firsat_urunler where urun_id=:urun_id ");
                            $vitrinSorgu->execute(array(
                                'urun_id' => $_POST['urun_id']
                            ));
                            if($vitrinSorgu->rowCount()<='0'  ) {
                                $kaydet = $db->prepare("INSERT INTO vitrin_firsat_urunler SET
                           son_tarih=:son_tarih,  
                           son_time=:son_time,
                           urun_id=:urun_id,
                           dil=:dil,
                           baslik=:baslik
                     ");
                                $sonuc = $kaydet->execute(array(
                                    'son_tarih' => $_POST['son_tarih'],
                                    'son_time' => $_POST['son_time'],
                                    'urun_id' => $_POST['urun_id'],
                                    'dil' => $_SESSION['dil'],
                                    'baslik' => $urunRow['baslik']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] ='success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
                                $_SESSION['main_alert'] = 'haveitem';
                            }
                        }else{
                            $_SESSION['main_alert'] ='zorunlu';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
                        }
                    }else{
                        $_SESSION['main_alert'] ='zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Fırsat Vitrin Add SON */


            /* Fırsat Vitrin Delete */
            if($_GET['status'] == 'firsat_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null  ) {
                    $vitrinControl = $db->prepare("select * from vitrin_firsat_urunler where id=:id ");
                    $vitrinControl->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($vitrinControl->rowCount()>'0' ) {
                     $silmeislem = $db->prepare("DELETE from vitrin_firsat_urunler WHERE id=:id");
                     $dell = $silmeislem->execute(array(
                        'id' => $_GET['no']
                     ));
                     if ($dell) {
                         $_SESSION['main_alert'] = 'success';
                         header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
                     }else {
                         echo 'veritabanı hatası';
                     }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Fırsat Vitrin Delete SON */

            /* Fırsat Vitrin MultiDelete */
            if($_GET['status'] == 'firsat_multidelete') {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from vitrin_firsat_urunler where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $silmeislem = $db->prepare("DELETE from vitrin_firsat_urunler WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
                }
            }
            /*  <========SON=========>>> Fırsat Vitrin MultiDelete SON */


            /* Fırsat Vitrin Tarih Uzat */
            if($_GET['status'] == 'firsat_time'  ) {
                if ($_POST && isset($_POST['update'])) {
                        if($_POST['firsat_id'] && $_POST['son_tarih'] && $_POST['son_time'] ) {
                            $guncelle = $db->prepare("UPDATE vitrin_firsat_urunler SET
                                   son_tarih=:son_tarih,
                                   son_time=:son_time 
                             WHERE id={$_POST['firsat_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'son_tarih' => $_POST['son_tarih'],
                                'son_time' => $_POST['son_time']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
                            }else{
                            echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Fırsat Vitrin Tarih Uzat SON */

            /* HTML Modül Other Settings */
            if($_GET['status'] == 'html_modul_other'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if($_POST['modul_id']) {
                        $guncelle = $db->prepare("UPDATE html_modul SET
                             padding=:padding,   
                             margin=:margin,
                             modul_border=:modul_border,
                             area=:area,
                             round=:round,
                             baslik_font=:baslik_font,
                             baslik_space=:baslik_space,
                             boxed=:boxed
                         WHERE id={$_POST['modul_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'padding' => $_POST['padding'],
                            'margin' => $_POST['margin'],
                            'modul_border' => colorFormat($_POST['modul_border']),
                            'area' => $_POST['area'],
                            'round' => $_POST['round'],
                            'baslik_font' => $_POST['baslik_font'],
                            'baslik_space' => $_POST['baslik_space'],
                            'boxed' => $_POST['boxed']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            $_SESSION['tab_select'] = 'other';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_html');
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> HTML Modül Other Settings SON */
            
            /* HTML Modül BG */
            if($_GET['status'] == 'html_modul_bg'  ) {
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

                                if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $guncelle = $db->prepare("UPDATE html_modul SET
                                         bg_image=:bg_image,
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='$_POST[modul_id]'      
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
                                        $_SESSION['main_alert'] = 'success';
                                        $_SESSION['tab_select'] = 'bg';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_html');
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    $_SESSION['main_alert'] = 'filetype';
                                    $_SESSION['tab_select'] = 'bg';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_html');
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE html_modul SET
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='$_POST[modul_id]'      
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'bg_tip' => '0',
                                    'bg_dark' => $_POST['bg_dark'],
                                    'bg_durum' => $_POST['bg_durum']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    $_SESSION['tab_select'] = 'bg';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_html');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                                /*  <========SON=========>>> Görsel Eklemeden Diğer Ayar Kayıtları SON */
                            }
                            /*  <========SON=========>>> Arkaplan Görseli SON */
                        }
                        if($_POST['bg_tip']== '1'  ) {
                            /* Sadece Renk */
                            $guncelle = $db->prepare("UPDATE html_modul SET
                                    bg_color=:bg_color,
                                    bg_tip=:bg_tip
                                         WHERE id='$_POST[modul_id]'      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'bg_color' => colorFormat($_POST['bg_color']),
                                'bg_tip' => '1'
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                $_SESSION['tab_select'] = 'bg';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_html');
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
            /*  <========SON=========>>> HTML Modül BG SON */

            /* HTML Modül BG Delete */
            if($_GET['status'] == 'html_modul_bg_delete'  ) {
                if(isset($_GET['modul_id']) && $_GET['modul_id'] == !null  ) {
                    $sorgu = $db->prepare("select * from html_modul where id='$_GET[modul_id]' ");
                    $sorgu->execute();
                    $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                    unlink("../images/uploads/$row[bg_image]");
                    $guncelle = $db->prepare("UPDATE html_modul SET
                            bg_image=:bg_image
                     WHERE id='$_GET[modul_id]'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'bg_image' => null,
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['tab_select'] = 'bg';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_html');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> HTML Modül BG Delete SON */




            /* Banner 2 Add */
            if($_GET['status'] == 'banner2_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_FILES['gorsel']["size"] > 0) {
                        $vitrinAyarCek = $db->prepare("select grid_sayi from vitrin_tip3_ayar where id=:id ");
                        $vitrinAyarCek->execute(array(
                            'id' => '1'
                        ));
                        $vitrinRow = $vitrinAyarCek->fetch(PDO::FETCH_ASSOC);
                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            if($_POST['baslik'] && $_POST['sira']) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'banner2_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 20;
                                    $upload->webp_quality = 85;
                                    $upload->jpeg_quality = 90;
                                    $upload->png_compression = 9;
                                    if($vitrinRow['grid_sayi'] == '3'  ) {
                                        $upload->image_x = 415;
                                        $upload->image_y = 265;
                                    }
                                    if($vitrinRow['grid_sayi'] == '4'  ) {
                                        $upload->image_x = 300;
                                        $upload->image_y = 190;
                                    }
                                    if($vitrinRow['grid_sayi'] == '5'  ) {
                                        $upload->image_x = 238;
                                        $upload->image_y = 145;
                                    }
                                    $upload->process("../images/uploads");
                                    $file_name = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $kaydet = $db->prepare("INSERT INTO vitrin_tip3 SET
                                            baslik=:baslik,
                                            gorsel=:gorsel,
                                            sira=:sira,
                                            adres_url=:adres_url,
                                            baslik_color=:baslik_color,
                                            dil=:dil,
                                            durum=:durum
                                            ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'sira' => $_POST['sira'],
                                    'adres_url' => $_POST['adres_url'],
                                    'baslik_color' => colorFormat($_POST['baslik_color']),
                                    'dil' => $_SESSION['dil'],
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                        $_SESSION['main_alert'] = 'filesize';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner 2 Add SON */

            /* Banner 2 Edit */
            if($_GET['status'] == 'banner2_edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if($_POST['vitrin_id'] && $_POST['baslik']  ) {
                        if ($_FILES['gorsel']["size"] > 0) {
                            $vitrinAyarCek = $db->prepare("select grid_sayi from vitrin_tip3_ayar where id=:id ");
                            $vitrinAyarCek->execute(array(
                                'id' => '1'
                            ));
                            $vitrinRow = $vitrinAyarCek->fetch(PDO::FETCH_ASSOC);
                            $old_img = $_POST['old_img'];
                            $file_format = $_FILES["gorsel"];
                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'banner2_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 20;
                                    $upload->webp_quality = 85;
                                    $upload->jpeg_quality = 95;
                                    $upload->png_compression = 9;
                                    if($vitrinRow['grid_sayi'] == '3'  ) {
                                        $upload->image_x = 415;
                                        $upload->image_y = 265;
                                    }
                                    if($vitrinRow['grid_sayi'] == '4'  ) {
                                        $upload->image_x = 300;
                                        $upload->image_y = 190;
                                    }
                                    if($vitrinRow['grid_sayi'] == '5'  ) {
                                        $upload->image_x = 238;
                                        $upload->image_y = 145;
                                    }
                                    $upload->process("../images/uploads");
                                    $file_name = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $guncelle = $db->prepare("UPDATE vitrin_tip3 SET
                                            baslik=:baslik,
                                            gorsel=:gorsel,
                                            sira=:sira,
                                            adres_url=:adres_url,
                                            baslik_color=:baslik_color,
                                            durum=:durum    
                             WHERE id={$_POST['vitrin_id']}      
                            ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'sira' => $_POST['sira'],
                                    'adres_url' => $_POST['adres_url'],
                                    'baslik_color' => colorFormat($_POST['baslik_color']),
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    if($old_img == !null  ) {
                                        unlink('../images/uploads/'.$old_img.'');
                                    }
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            } else {
                                /* FileType */
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                                $_SESSION['main_alert'] = 'filetype';
                                /*  <========SON=========>>> FileType SON */
                            }
                        }else{
                            /* Fotosuz update */
                            $guncelle = $db->prepare("UPDATE vitrin_tip3 SET
                                            baslik=:baslik,
                                            sira=:sira,
                                            adres_url=:adres_url,
                                            baslik_color=:baslik_color,
                                            durum=:durum    
                             WHERE id={$_POST['vitrin_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'sira' => $_POST['sira'],
                                'adres_url' => $_POST['adres_url'],
                                'baslik_color' => colorFormat($_POST['baslik_color']),
                                'durum' => $_POST['durum']
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Fotosuz update SON */
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner 2Edit SON */

            /* Banner 2 Delete */
            if($_GET['status'] == 'banner2_delete'  ) {
                if (isset($_GET['no']) && $_GET['no'] == !null ) {

                    $noSorgusu = $db->prepare("select * from vitrin_tip3 where id='$_GET[no]' ");
                    $noSorgusu->execute();
                    $noRow = $noSorgusu->fetch(PDO::FETCH_ASSOC);
                    /* Görsel Delete */
                    unlink('../images/uploads/'.$noRow['gorsel'].'');
                    /*  <========SON=========>>> Görsel Delete SON */
                    if($noSorgusu->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from vitrin_tip3 WHERE id=:id");
                        $del = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($del) {
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                            $_SESSION['main_alert'] = 'success';
                        }else {
                            echo 'veritabanı hatası';
                        }

                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                        $_SESSION['main_alert'] = 'nocheck';
                    }
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner2');
                }
            }
            /*  <========SON=========>>> Banner 2 Delete SON */




            /* Banner 1 Add */
            if($_GET['status'] == 'banner1_add'  ) {
                if ($_POST && isset($_POST['insert'])) {

                    if ($_FILES['gorsel']["size"] > 0) {
                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            if($_POST['baslik'] && $_POST['sira']) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'banner1_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->process("../images/uploads");
                                    $file_name = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $kaydet = $db->prepare("INSERT INTO vitrin_tip2 SET
                                            baslik=:baslik,
                                            gorsel=:gorsel,
                                            sira=:sira,
                                            spot=:spot,
                                            adres_url=:adres_url,
                                            yazi_durum=:yazi_durum,
                                            col_md=:col_md,
                                            yazi_color=:yazi_color,
                                            dark=:dark,
                                            dil=:dil,
                                            durum=:durum
                                            ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'sira' => $_POST['sira'],
                                    'spot' => $_POST['spot'],
                                    'adres_url' => $_POST['adres_url'],
                                    'yazi_durum' => $_POST['yazi_durum'],
                                    'col_md' => $_POST['col_md'],
                                    'yazi_color' => colorFormat($_POST['yazi_color']),
                                    'dark' => $_POST['dark'],
                                    'dil' => $_SESSION['dil'],
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                        $_SESSION['main_alert'] = 'filesize';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner 1 Add SON */

            /* Banner 1 Edit */
            if($_GET['status'] == 'banner1_edit'  ) {
                if ($_POST && isset($_POST['update'])) {

                    if($_POST['vitrin_id'] && $_POST['baslik']  ) {
                        if ($_FILES['gorsel']["size"] > 0) {
                            $old_img = $_POST['old_img'];
                            $file_format = $_FILES["gorsel"];
                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'banner1_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->process("../images/uploads");
                                    $file_name = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $guncelle = $db->prepare("UPDATE vitrin_tip2 SET
                                                          baslik=:baslik,
                                            gorsel=:gorsel,
                                            sira=:sira,
                                            spot=:spot,
                                            adres_url=:adres_url,
                                            yazi_durum=:yazi_durum,
                                            col_md=:col_md,
                                            yazi_color=:yazi_color,
                                            dark=:dark,
                                            durum=:durum    
                             WHERE id={$_POST['vitrin_id']}      
                            ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'sira' => $_POST['sira'],
                                    'spot' => $_POST['spot'],
                                    'adres_url' => $_POST['adres_url'],
                                    'yazi_durum' => $_POST['yazi_durum'],
                                    'col_md' => $_POST['col_md'],
                                    'yazi_color' => colorFormat($_POST['yazi_color']),
                                    'dark' => $_POST['dark'],
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    if($old_img == !null  ) {
                                        unlink('../images/uploads/'.$old_img.'');
                                    }
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            } else {
                                /* FileType */
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                                $_SESSION['main_alert'] = 'filetype';
                                /*  <========SON=========>>> FileType SON */
                            }
                        }else{
                            /* Fotosuz update */
                            $guncelle = $db->prepare("UPDATE vitrin_tip2 SET
                                            baslik=:baslik,
                                            sira=:sira,
                                            spot=:spot,
                                            adres_url=:adres_url,
                                            yazi_durum=:yazi_durum,
                                            col_md=:col_md,
                                            yazi_color=:yazi_color,
                                            dark=:dark,
                                            durum=:durum    
                             WHERE id={$_POST['vitrin_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'sira' => $_POST['sira'],
                                'spot' => $_POST['spot'],
                                'adres_url' => $_POST['adres_url'],
                                'yazi_durum' => $_POST['yazi_durum'],
                                'col_md' => $_POST['col_md'],
                                'yazi_color' => colorFormat($_POST['yazi_color']),
                                'dark' => $_POST['dark'],
                                'durum' => $_POST['durum']
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Fotosuz update SON */
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner 1 Edit SON */

            /* Banner 1 Delete */
            if($_GET['status'] == 'banner1_delete'  ) {
                if (isset($_GET['no']) && $_GET['no'] == !null ) {

                    $noSorgusu = $db->prepare("select * from vitrin_tip2 where id='$_GET[no]' ");
                    $noSorgusu->execute();
                    $noRow = $noSorgusu->fetch(PDO::FETCH_ASSOC);
                    /* Görsel Delete */
                    unlink('../images/uploads/'.$noRow['gorsel'].'');
                    /*  <========SON=========>>> Görsel Delete SON */
                    if($noSorgusu->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from vitrin_tip2 WHERE id=:id");
                        $del = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($del) {
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                            $_SESSION['main_alert'] = 'success';
                        }else {
                            echo 'veritabanı hatası';
                        }

                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                        $_SESSION['main_alert'] = 'nocheck';
                    }
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_banner1');
                }
            }
            /*  <========SON=========>>> Banner 1 Delete SON */



            /* Multi Delete banner Product */
            if($_GET['status'] == 'bannerproduct_multidelete') {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from vitrin_tip1_grup where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                            /* Görsel Delete */
                            unlink('../images/uploads/'.$row['gorsel'].'');
                            /*  <========SON=========>>> Görsel Delete SON */
                            $silmeislem = $db->prepare("DELETE from vitrin_tip1_grup WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                            /* Ürünleri Sil */
                            $sil2 = $db->prepare("DELETE from vitrin_tip1_urunler WHERE grup_id=:grup_id");
                            $sil2->execute(array(
                                'grup_id' => $idler
                            ));
                            /*  <========SON=========>>> Ürünleri Sil SON */
                        }
                    }
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                }
            }
            /*  <========SON=========>>> Multi Delete banner Product SON */

            /* Banner product Delete */
            if($_GET['status'] == 'bannerproduct_delete'  ) {
                if (isset($_GET['no']) && $_GET['no'] == !null ) {

                    $noSorgusu = $db->prepare("select * from vitrin_tip1_grup where id='$_GET[no]' ");
                    $noSorgusu->execute();
                    $noRow = $noSorgusu->fetch(PDO::FETCH_ASSOC);
                    /* Görsel Delete */
                    unlink('../images/uploads/'.$noRow['gorsel'].'');
                    /*  <========SON=========>>> Görsel Delete SON */
                    if($noSorgusu->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from vitrin_tip1_grup WHERE id=:id");
                        $del = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($del) {

                            /* Ürünleri Sil */
                            $silmeislem = $db->prepare("DELETE from vitrin_tip1_urunler WHERE grup_id=:grup_id");
                            $silmeislem->execute(array(
                               'grup_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> Ürünleri Sil SON */

                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                            $_SESSION['main_alert'] = 'success';
                        }else {
                            echo 'veritabanı hatası';
                        }

                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                        $_SESSION['main_alert'] = 'nocheck';
                    }
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                }
            }
            /*  <========SON=========>>> Banner product Delete SON */

            /* Banner Product List MULTI-delete */
            if($_GET['status'] == 'bannerproduct_list_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from vitrin_tip1_urunler where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from vitrin_tip1_urunler WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct_list&grup_id='.$_GET['grup_id'].'');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct_list&grup_id='.$_GET['grup_id'].'');
                }
            }
            /*  <========SON=========>>> Banner Product List MULTI-delete SON */

            /* Banner Product List delete */
            if($_GET['status'] == 'bannerproduct_list_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null && $_GET['grup_id'] == !null  ) {

                    $noSorgusu = $db->prepare("select * from vitrin_tip1_urunler where id='$_GET[no]' ");
                    $noSorgusu->execute();
                    $noRow = $noSorgusu->fetch(PDO::FETCH_ASSOC);
                    if($noSorgusu->rowCount()>'0'  ) {

                       $silmeislem = $db->prepare("DELETE from vitrin_tip1_urunler WHERE id=:id");
                       $del = $silmeislem->execute(array(
                          'id' => $_GET['no']
                       ));
                       if ($del) {
                           header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct_list&grup_id='.$_GET['grup_id'].'');
                           $_SESSION['main_alert'] = 'success';
                       }else {
                           echo 'veritabanı hatası';
                       }

                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner Product List delete SON */

            /* Banner Product BANNER Delete */
            if($_GET['status'] == 'bannerproduct_img_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null  ) {

                    $noSorgusu = $db->prepare("select * from vitrin_tip1_grup where id='$_GET[no]' ");
                    $noSorgusu->execute();
                    $noRow = $noSorgusu->fetch(PDO::FETCH_ASSOC);
                    if($noSorgusu->rowCount()>'0'  ) {

                        $guncelle = $db->prepare("UPDATE vitrin_tip1_grup SET
                            gorsel=:gorsel    
                         WHERE id={$_GET['no']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                           'gorsel' => null,
                        ));
                        if($sonuc){
                            unlink('../images/uploads/'.$noRow['gorsel'].'');
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                        echo 'Veritabanı Hatası';
                        }

                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner Product BANNER Delete SON */


            /* Banner Product Ürün Ekle */
            if($_GET['status'] == 'bannerproduct_list_add'  ) {
                if($_POST && isset($_POST['insert']) ) {
                    $pro_id = $_POST['urun_id'];
                    if($_POST['grup_id'] ) {

                        if($_POST['sira'] >0  ) {
                         $sira = $_POST['sira'];
                        }else{
                            $sira = '1';
                        }
                        /* Urun Kontrol */
                        $urunKontrol = $db->prepare("select baslik,id from urun where id='$pro_id' ");
                        $urunKontrol->execute();
                        $urun = $urunKontrol->fetch(PDO::FETCH_ASSOC);
                        /*  <========SON=========>>> Urun Kontrol SON */
                        if($urunKontrol->rowCount()>'0'  ) {
                            $vitrinControl = $db->prepare("select * from vitrin_tip1_urunler where urun_id=:urun_id and grup_id=:grup_id ");
                            $vitrinControl->execute(array(
                                'urun_id' => $pro_id,
                                'grup_id' => $_POST['grup_id']
                            ));
                            if( $vitrinControl->rowCount()<='0' ) {
                                $kaydet = $db->prepare("INSERT INTO vitrin_tip1_urunler SET
                                 urun_id=:urun_id,   
                                 sira=:sira,
                                 grup_id=:grup_id,
                                 baslik=:baslik
                            ");
                                $sonuc = $kaydet->execute(array(
                                    'urun_id' => $pro_id,
                                    'sira' => $sira,
                                    'grup_id' => $_POST['grup_id'],
                                    'baslik' => $urun['baslik']
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct_list&grup_id='.$_POST['grup_id'].'');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct_list&grup_id='.$_POST['grup_id'].'');
                                $_SESSION['main_alert'] = 'haveitem';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct_list&grup_id='.$_POST['grup_id'].'');
                            $_SESSION['main_alert'] = 'zorunlu';
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                    
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner Product Ürün Ekle SON */

            /* Banner+Product Edit */
            if($_GET['status'] == 'bannerproduct_edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['sira'] && $_POST['grup_id']  ) {
                        if ($_FILES['gorsel']["size"] > 0) {
                            $old_img = $_POST['old_img'];
                            $file_format = $_FILES["gorsel"];
                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'banner_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 85;
                                    $upload->png_compression = 9;
                                    $upload->image_ratio_y = true;
                                    $upload->image_x = 300;
                                    $upload->process("../images/uploads");
                                    $file_name = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $guncelle = $db->prepare("UPDATE vitrin_tip1_grup SET
                                                 baslik=:baslik,   
                                                 gorsel=:gorsel,
                                                 gorsel_baslik=:gorsel_baslik,
                                                 gorsel_baslik_renk=:gorsel_baslik_renk,
                                                 spot=:spot,
                                                 durum=:durum,
                                                 sira=:sira,
                                                 adres_url=:adres_url,
                                                 tur=:tur,
                                                 baslik_durum=:baslik_durum     
                                 WHERE id={$_POST['grup_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'gorsel_baslik' => $_POST['gorsel_baslik'],
                                    'gorsel_baslik_renk' => colorFormat($_POST['gorsel_baslik_renk']),
                                    'spot' => $_POST['spot'],
                                    'durum' => $_POST['durum'],
                                    'sira' => $_POST['sira'],
                                    'adres_url' => $_POST['adres_url'],
                                    'tur' => $_POST['tur'],
                                    'baslik_durum' => $_POST['baslik_durum']
                                ));
                                if($sonuc){
                                    if($old_img == !null  ) {
                                     unlink('../images/uploads/'.$old_img.'');
                                    }
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $guncelle = $db->prepare("UPDATE vitrin_tip1_grup SET
                                                 baslik=:baslik,   
                                                 gorsel_baslik=:gorsel_baslik,
                                                 gorsel_baslik_renk=:gorsel_baslik_renk,
                                                 spot=:spot,
                                                 durum=:durum,
                                                 sira=:sira,
                                                 adres_url=:adres_url,
                                                 tur=:tur,
                                                 baslik_durum=:baslik_durum     
                                 WHERE id={$_POST['grup_id']}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'gorsel_baslik' => $_POST['gorsel_baslik'],
                                'gorsel_baslik_renk' => colorFormat($_POST['gorsel_baslik_renk']),
                                'spot' => $_POST['spot'],
                                'durum' => $_POST['durum'],
                                'sira' => $_POST['sira'],
                                'adres_url' => $_POST['adres_url'],
                                'tur' => $_POST['tur'],
                                'baslik_durum' => $_POST['baslik_durum']
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner+Product Edit SON */
            
            /* Banner+Product Insert */
            if($_GET['status'] == 'bannerproduct_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['baslik'] && $_POST['sira']  ) {
                        if ($_FILES['gorsel']["size"] > 0) {
                            $file_format = $_FILES["gorsel"];
                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'banner_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 85;
                                    $upload->jpeg_quality = 90;
                                    $upload->png_compression = 9;
                                    $upload->image_ratio_y = true;
                                    $upload->image_x = 300;
                                    $upload->process("../images/uploads");
                                    $file_name = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $kaydet = $db->prepare("INSERT INTO vitrin_tip1_grup SET
                         baslik=:baslik,   
                         gorsel=:gorsel,
                         gorsel_baslik=:gorsel_baslik,
                         gorsel_baslik_renk=:gorsel_baslik_renk,
                         spot=:spot,
                         dil=:dil,
                         durum=:durum,
                         sira=:sira,
                         adres_url=:adres_url,
                         tur=:tur,
                         baslik_durum=:baslik_durum
                    ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'gorsel_baslik' => $_POST['gorsel_baslik'],
                                    'gorsel_baslik_renk' => colorFormat($_POST['gorsel_baslik_renk']),
                                    'spot' => $_POST['spot'],
                                    'dil' => $_SESSION['dil'],
                                    'durum' => $_POST['durum'],
                                    'sira' => $_POST['sira'],
                                    'adres_url' => $_POST['adres_url'],
                                    'tur' => $_POST['tur'],
                                    'baslik_durum' => $_POST['baslik_durum']
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }

                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $kaydet = $db->prepare("INSERT INTO vitrin_tip1_grup SET
                         baslik=:baslik,   
                         gorsel_baslik=:gorsel_baslik,
                         gorsel_baslik_renk=:gorsel_baslik_renk,
                         spot=:spot,
                         dil=:dil,
                         durum=:durum,
                         sira=:sira,
                         adres_url=:adres_url,
                         tur=:tur,
                         baslik_durum=:baslik_durum
                    ");
                            $sonuc = $kaydet->execute(array(
                                'baslik' => $_POST['baslik'],
                                'gorsel_baslik' => $_POST['gorsel_baslik'],
                                'gorsel_baslik_renk' => colorFormat($_POST['gorsel_baslik_renk']),
                                'spot' => $_POST['spot'],
                                'dil' => $_SESSION['dil'],
                                'durum' => $_POST['durum'],
                                'sira' => $_POST['sira'],
                                'adres_url' => $_POST['adres_url'],
                                'tur' => $_POST['tur'],
                                'baslik_durum' => $_POST['baslik_durum']
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }            
            /*  <========SON=========>>> Banner+Product Insert SON */
  
            /* Tab'a Ürün Ekle */
            if($_GET['status'] == 'tab_insert'  ) {
                if(isset($_GET['tab_insert']) && $_GET['tab_insert']==!null  ) {

                    /* Yeni Ürün */
                    if($_GET['tab_insert'] == 'newproduct'  ) {
                        if($_POST && isset($_POST['insert'])  ) {
                            $pro_id = $_POST['urun_id'];
                            if($pro_id == !null  ) {
                                $guncelle = $db->prepare("UPDATE urun SET
                                                      yeni=:yeni 
                                                WHERE id={$pro_id}      
                                               ");
                                $sonuc = $guncelle->execute(array(
                                    'yeni' => '1'
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }
                    /*  <========SON=========>>> Yeni Ürün SON */

                    /* İndirimli ürün */
                    if($_GET['tab_insert'] == 'discountproduct'  ) {
                        if($_POST && isset($_POST['insert'])  ) {
                            $pro_id = $_POST['urun_id'];
                            if($pro_id == !null  ) {
                                $guncelle = $db->prepare("UPDATE urun SET
                                                      indirim=:indirim 
                                                WHERE id={$pro_id}      
                                               ");
                                $sonuc = $guncelle->execute(array(
                                    'indirim' => '1'
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                    $_SESSION['main_alert'] = 'success';
                                    $_SESSION['tab_select'] = 'indirim';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                $_SESSION['main_alert'] = 'zorunlu';
                                $_SESSION['tab_select'] = 'indirim';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }
                    /*  <========SON=========>>> İndirimli ürün SON */

                    /* Firsat */
                    if($_GET['tab_insert'] == 'firsat'  ) {
                        if($_POST && isset($_POST['insert'])  ) {
                            $pro_id = $_POST['urun_id'];
                            if($pro_id == !null  ) {
                                $guncelle = $db->prepare("UPDATE urun SET
                                                      firsat=:firsat 
                                                WHERE id={$pro_id}      
                                               ");
                                $sonuc = $guncelle->execute(array(
                                    'firsat' => '1'
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                    $_SESSION['main_alert'] = 'success';
                                    $_SESSION['tab_select'] = 'firsat';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                $_SESSION['main_alert'] = 'zorunlu';
                                $_SESSION['tab_select'] = 'firsat';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }
                    /*  <========SON=========>>> Firsat SON */

                    /* editor */
                    if($_GET['tab_insert'] == 'editor'  ) {
                        if($_POST && isset($_POST['insert'])  ) {
                            $pro_id = $_POST['urun_id'];
                            if($pro_id == !null  ) {
                                $guncelle = $db->prepare("UPDATE urun SET
                                                      editor_secim=:editor_secim 
                                                WHERE id={$pro_id}      
                                               ");
                                $sonuc = $guncelle->execute(array(
                                    'editor_secim' => '1'
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                    $_SESSION['main_alert'] = 'success';
                                    $_SESSION['tab_select'] = 'editor';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                $_SESSION['main_alert'] = 'zorunlu';
                                $_SESSION['tab_select'] = 'editor';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }
                    /*  <========SON=========>>> editor SON */

                    /* Free Cargo */
                    if($_GET['tab_insert'] == 'fastcargo'  ) {
                        if($_POST && isset($_POST['insert'])  ) {
                            $pro_id = $_POST['urun_id'];
                            if($pro_id == !null  ) {
                                $guncelle = $db->prepare("UPDATE urun SET
                                                      hizli_kargo=:hizli_kargo 
                                                WHERE id={$pro_id}      
                                               ");
                                $sonuc = $guncelle->execute(array(
                                    'hizli_kargo' => '1'
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                    $_SESSION['main_alert'] = 'success';
                                    $_SESSION['tab_select'] = 'fastCargo';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                                $_SESSION['main_alert'] = 'zorunlu';
                                $_SESSION['tab_select'] = 'fastCargo';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }
                    /*  <========SON=========>>> Free Cargo SON */

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Tab'a Ürün Ekle SON */

            /* Çıkar */
            if($_GET['status'] == 'tab_update'  ) {
                /* Yeni Üründen Cıkar */
                if($_GET['tab_update'] == 'newproduct'  ) {
                    $pro_id = $_GET['product_id'];
                    if($pro_id == !null  ) {
                        $guncelle = $db->prepare("UPDATE urun SET
                                                      yeni=:yeni 
                                                WHERE id={$pro_id}      
                                               ");
                        $sonuc = $guncelle->execute(array(
                            'yeni' => '0'
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }

                }
                /*  <========SON=========>>> Yeni Üründen Cıkar SON */

                /* İnidirm */
                if($_GET['tab_update'] == 'discountproduct'  ) {
                    $pro_id = $_GET['product_id'];
                        $guncelle = $db->prepare("UPDATE urun SET
                                                      indirim=:indirim 
                                                WHERE id={$pro_id}      
                                               ");
                        $sonuc = $guncelle->execute(array(
                            'indirim' => '0'
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                            $_SESSION['main_alert'] = 'success';
                            $_SESSION['tab_select'] = 'indirim';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                }
                /*  <========SON=========>>> İnidirm SON */

                /* Fırsat */
                if($_GET['tab_update'] == 'firsat'  ) {
                    $pro_id = $_GET['product_id'];
                    $guncelle = $db->prepare("UPDATE urun SET
                                                      firsat=:firsat 
                                                WHERE id={$pro_id}      
                                               ");
                    $sonuc = $guncelle->execute(array(
                        'firsat' => '0'
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['tab_select'] = 'firsat';
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }
                /*  <========SON=========>>> Fırsat SON */

                /* Editor */
                if($_GET['tab_update'] == 'editor'  ) {
                    $pro_id = $_GET['product_id'];
                    $guncelle = $db->prepare("UPDATE urun SET
                                                      editor_secim=:editor_secim 
                                                WHERE id={$pro_id}      
                                               ");
                    $sonuc = $guncelle->execute(array(
                        'editor_secim' => '0'
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['tab_select'] = 'editor';
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }
                /*  <========SON=========>>> Editor SON */
                
                /* Hızlı kargo */
                if($_GET['tab_update'] == 'fastcargo'  ) {
                    $pro_id = $_GET['product_id'];
                    $guncelle = $db->prepare("UPDATE urun SET
                                                      hizli_kargo=:hizli_kargo 
                                                WHERE id={$pro_id}      
                                               ");
                    $sonuc = $guncelle->execute(array(
                        'hizli_kargo' => '0'
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_tabproduct');
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['tab_select'] = 'fastCargo';
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }
                /*  <========SON=========>>> Hızlı kargo SON */
            }
            /*  <========SON=========>>> Çıkar SON */

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