<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' ||  $_GET['status'] == 'update' ||  $_GET['status'] == 'mobil_gorsel_delete'|| $_GET['status'] == 'delete' || $_GET['status'] == 'mobil_gorsel' ||  $_GET['status'] == 'theme_settings' ) {

            /* Slider Setting */
            $sliderSetting = $db->prepare("select * from slider_ayar where id=:id ");
            $sliderSetting->execute(array(
                'id' => '1'
            ));
            $sliderset = $sliderSetting->fetch(PDO::FETCH_ASSOC);
            /*  <========SON=========>>> Slider Setting SON */

            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            if($_GET['status'] == 'theme_settings'  ) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_slider');
                $_SESSION['collepse_status'] = 'genelAcc';
            }

            if($_GET['status'] == 'mobil_gorsel_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null  ) {
                    $noSorgusu = $db->prepare("select * from slider where id='$_GET[no]' ");
                    $noSorgusu->execute();
                    $noRow = $noSorgusu->fetch(PDO::FETCH_ASSOC);
                    if($noSorgusu->rowCount()>'0'  ) {
                        $guncelle = $db->prepare("UPDATE slider SET
                            gorsel_mobil=:gorsel_mobil    
                         WHERE id={$_GET['no']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'gorsel_mobil' => null
                        ));
                        if($sonuc){
                            unlink('../images/slider/'.$noRow['gorsel_mobil'].'');
                            header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_edit&slider_id='.$_GET['no'].'');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }

                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_edit&slider_id='.$_GET['no'].'');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            /* Mobil Gorsel */
            if($_GET['status'] == 'mobil_gorsel'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_FILES['gorsel_mobil']["size"] > 0) {
                        $old_mobil = $_POST['old_mobil'];
                        $file_format = $_FILES["gorsel_mobil"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            $heightValue = $sliderset['mobil_height'];
                            /* Görsel Upload */
                            include_once('inc/class.upload.php');
                            $upload = new Upload($_FILES['gorsel_mobil']);
                            if ($upload->uploaded) {
                                $random = rand(0, (int)99991234569);
                                $random2 = rand(0, (int)999);
                                $upload->file_name_body_pre = 'slider_';
                                $upload->file_name_body_add = ''.$random.''.$random2.'';
                                $upload->image_resize = true;
                                $upload->png_quality = 90;
                                $upload->webp_quality = 85;
                                $upload->jpeg_quality = 95;
                                $upload->png_compression = 9;
                                $upload->image_ratio_x         = true;
                                $upload->image_y = $heightValue;
                                $upload->process("../images/slider");
                                $file_name = $upload->file_dst_name;
                            }
                            /*  <========SON=========>>> Görsel Upload SON */
                            $guncelle = $db->prepare("UPDATE slider SET
                                  gorsel_mobil=:gorsel_mobil
                                 WHERE id={$_POST['slider_id']}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'gorsel_mobil' => $file_name
                            ));
                            if($sonuc){
                                if($old_mobil == !null || isset($old_mobil) ) {
                                    unlink("../images/slider/$old_mobil");
                                }
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_edit&slider_id='.$_POST['slider_id'].'');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_edit&slider_id='.$_POST['slider_id'].'');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_edit&slider_id='.$_POST['slider_id'].'');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Mobil Gorsel SON */

            /*  Insert */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if ($_FILES['gorsel']["size"] > 0) {
                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                            if($_POST['sira'] ) {

                                $heightValue = $sliderset['height'];
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'slider_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    if($sliderset['slider_width'] == '0' ) {
                                        $upload->image_ratio_x         = true;
                                        $upload->image_y = $heightValue;
                                    }else{
                                        $upload->image_x = 1300;
                                        $upload->image_y = $heightValue;
                                    }
                                    $upload->process("../images/slider");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_add');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                /* Url çekimi */
                                if($_POST['full_a'] == '1'  ) { 
                                    $fulla= '1';
                                    $fulllink = $_POST['full_a_url'];
                                    $yeni_sekme = $_POST['yeni_sekme_full'];
                                }  else{
                                    $fulla= '0';
                                    $link = $_POST['url'];  
                                    $yeni_sekme = $_POST['yeni_sekme_button'];
                                }        
                                /*  <========SON=========>>> Url çekimi SON */

                                /* Mobile Özgü Görsel İçin Burayı Kullan */

                                /*  <========SON=========>>> Mobile Özgü Görsel İçin Burayı Kullan SON */
                                
                                $kaydet = $db->prepare("INSERT INTO slider SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  spot=:spot,
                                  text_status=:text_status,
                                  baslik_animation=:baslik_animation,
                                  spot_animation=:spot_animation,
                                  durum=:durum,
                                  sira=:sira,
                                  dark_bg=:dark_bg,
                                  dil=:dil,
                                  text_bg=:text_bg,
                                  area=:area,
                                  yeni_sekme=:yeni_sekme,
                                  full_a=:full_a,
                                  full_a_url=:full_a_url,
                                  url=:url,
                                  button_animation=:button_animation,
                                  button_text=:button_text,
                                  button_bg=:button_bg,
                                  button_radius=:button_radius,
                                  button_size=:button_size
                                ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'spot' => $_POST['spot'],
                                    'text_status' => $_POST['text_status'],
                                    'baslik_animation' => $_POST['baslik_animation'],
                                    'spot_animation' => $_POST['spot_animation'],
                                    'durum' => $_POST['durum'],
                                    'sira' => $_POST['sira'],
                                    'dark_bg' => $_POST['dark_bg'],
                                    'dil' => $_SESSION['dil'],
                                    'text_bg' => colorFormat($_POST['text_bg']),
                                    'area' => $_POST['area'],
                                    'yeni_sekme' => $yeni_sekme,
                                    'full_a' => $fulla,
                                    'full_a_url' => $fulllink,
                                    'url' => $link,
                                    'button_animation' => $_POST['button_animation'],
                                    'button_text' => $_POST['button_text'],
                                    'button_bg' => $_POST['button_bg'],
                                    'button_radius' => $_POST['button_radius'],
                                    'button_size' => $_POST['button_size']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_add');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_add');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_add');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Insert SON */

            /*  Update */
            if($_GET['status'] == 'update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if ($_FILES['gorsel']["size"] > 0) {
                        $old_img = $_POST['old_img'];
                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                            if($_POST['sira']) {
                                $heightValue = $sliderset['height'];
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'slider_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 80;
                                    $upload->webp_quality = 80;
                                    $upload->jpeg_quality = 80;
                                    $upload->png_compression = 9;
                                    if($sliderset['slider_width'] == '0' ) {
                                        $upload->image_ratio_x         = true;
                                        $upload->image_y = $heightValue;
                                    }else{
                                        $upload->image_x = 1300;
                                        $upload->image_y = $heightValue;
                                    }
                                    $upload->process("../images/slider");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_edit&slider_id='.$_POST['slider_id'].'');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                /* Url çekimi */
                                if($_POST['full_a'] == '1'  ) {
                                    $fulla= '1';
                                    $fulllink = $_POST['full_a_url'];
                                    $yeni_sekme = $_POST['yeni_sekme_full'];
                                }  else{
                                    $fulla= '0';
                                    $link = $_POST['url'];
                                    $yeni_sekme = $_POST['yeni_sekme_button'];
                                }
                                /*  <========SON=========>>> Url çekimi SON */

                                $guncelle = $db->prepare("UPDATE slider SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  spot=:spot,
                                  text_status=:text_status,
                                  baslik_animation=:baslik_animation,
                                  spot_animation=:spot_animation,
                                  durum=:durum,
                                  sira=:sira,
                                  dark_bg=:dark_bg,
                                  text_bg=:text_bg,
                                  area=:area,
                                  yeni_sekme=:yeni_sekme,
                                  full_a=:full_a,
                                  full_a_url=:full_a_url,
                                  url=:url,
                                  button_animation=:button_animation,
                                  button_text=:button_text,
                                  button_bg=:button_bg,
                                  button_radius=:button_radius,
                                  button_size=:button_size   
                                 WHERE id={$_POST['slider_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'spot' => $_POST['spot'],
                                    'text_status' => $_POST['text_status'],
                                    'baslik_animation' => $_POST['baslik_animation'],
                                    'spot_animation' => $_POST['spot_animation'],
                                    'durum' => $_POST['durum'],
                                    'sira' => $_POST['sira'],
                                    'dark_bg' => $_POST['dark_bg'],
                                    'text_bg' => colorFormat($_POST['text_bg']),
                                    'area' => $_POST['area'],
                                    'yeni_sekme' => $yeni_sekme,
                                    'full_a' => $fulla,
                                    'full_a_url' => $fulllink,
                                    'url' => $link,
                                    'button_animation' => $_POST['button_animation'],
                                    'button_text' => $_POST['button_text'],
                                    'button_bg' => $_POST['button_bg'],
                                    'button_radius' => $_POST['button_radius'],
                                    'button_size' => $_POST['button_size']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../images/slider/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_edit&slider_id='.$_POST['slider_id'].'');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        /* Url çekimi */
                        if($_POST['full_a'] == '1'  ) {
                            $fulla= '1';
                            $fulllink = $_POST['full_a_url'];
                            $yeni_sekme = $_POST['yeni_sekme_full'];
                        }  else{
                            $fulla= '0';
                            $link = $_POST['url'];
                            $yeni_sekme = $_POST['yeni_sekme_button'];
                        }
                        /*  <========SON=========>>> Url çekimi SON */
                        $guncelle = $db->prepare("UPDATE slider SET
                                  baslik=:baslik,      
                                  spot=:spot,
                                  text_status=:text_status,
                                  baslik_animation=:baslik_animation,
                                  spot_animation=:spot_animation,
                                  durum=:durum,
                                  sira=:sira,
                                  dark_bg=:dark_bg,
                                  text_bg=:text_bg,
                                  area=:area,
                                  yeni_sekme=:yeni_sekme,
                                  full_a=:full_a,
                                  full_a_url=:full_a_url,
                                  url=:url,
                                  button_animation=:button_animation,
                                  button_text=:button_text,
                                  button_bg=:button_bg,
                                  button_radius=:button_radius,
                                  button_size=:button_size   
                                 WHERE id={$_POST['slider_id']}      
                                ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'spot' => $_POST['spot'],
                            'text_status' => $_POST['text_status'],
                            'baslik_animation' => $_POST['baslik_animation'],
                            'spot_animation' => $_POST['spot_animation'],
                            'durum' => $_POST['durum'],
                            'sira' => $_POST['sira'],
                            'dark_bg' => $_POST['dark_bg'],
                            'text_bg' => colorFormat($_POST['text_bg']),
                            'area' => $_POST['area'],
                            'yeni_sekme' => $yeni_sekme,
                            'full_a' => $fulla,
                            'full_a_url' => $fulllink,
                            'url' => $link,
                            'button_animation' => $_POST['button_animation'],
                            'button_text' => $_POST['button_text'],
                            'button_bg' => $_POST['button_bg'],
                            'button_radius' => $_POST['button_radius'],
                            'button_size' => $_POST['button_size']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider_edit&slider_id='.$_POST['slider_id'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Update SON */

            /* Delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from slider where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../images/slider/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from slider WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Delete SON */


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