<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;
$sliderAyar = $db->prepare("select height,mobil_height from slider2_ayar where id=:id ");
$sliderAyar->execute(array(
    'id' => '1'
));
$slidRow = $sliderAyar->fetch(PDO::FETCH_ASSOC);
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' ||  $_GET['status'] == 'update' || $_GET['status'] == 'delete' ||  $_GET['status'] == 'theme_settings' ||  $_GET['status'] == 'mobil_gorsel' ) {

            if($_GET['status'] == 'theme_settings'  ) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_slider');
                $_SESSION['collepse_status'] = 'otherAcc';
            }

            /*  Insert */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if ($_FILES['gorsel']["size"] > 0) {
                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            if($_POST['sira'] ) {
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
                                    $upload->webp_quality = 85;
                                    $upload->jpeg_quality = 90;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 1300;
                                    $upload->image_y = $slidRow['height'];
                                    $upload->process("../i/uploads");
                                    $file_name = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $kaydet = $db->prepare("INSERT INTO slider2 SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  link_url=:link_url,
                                  sira=:sira,
                                  durum=:durum,
                                  dil=:dil,
                                  yeni_sekme=:yeni_sekme
                                ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'link_url' => $_POST['link_url'],
                                    'sira' => $_POST['sira'],
                                    'durum' => $_POST['durum'],
                                    'dil' => $_SESSION['dil'],
                                    'yeni_sekme' => $_POST['yeni_sekme']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
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
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            if($_POST['sira'] ) {
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
                                    $upload->webp_quality = 85;
                                    $upload->jpeg_quality = 90;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 1300;
                                    $upload->image_y = $slidRow['height'];
                                    $upload->process("../i/uploads");
                                    $file_name = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $guncelle = $db->prepare("UPDATE slider2 SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  link_url=:link_url,
                                  sira=:sira,
                                  durum=:durum,
                                  yeni_sekme=:yeni_sekme
                                 WHERE id={$_POST['slider_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'link_url' => $_POST['link_url'],
                                    'sira' => $_POST['sira'],
                                    'durum' => $_POST['durum'],
                                    'yeni_sekme' => $_POST['yeni_sekme']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../i/uploads/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        $guncelle = $db->prepare("UPDATE slider2 SET
                                  baslik=:baslik,      
                                  link_url=:link_url,
                                  sira=:sira,
                                  durum=:durum,
                                  yeni_sekme=:yeni_sekme
                                 WHERE id={$_POST['slider_id']}      
                                ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'link_url' => $_POST['link_url'],
                            'sira' => $_POST['sira'],
                            'durum' => $_POST['durum'],
                            'yeni_sekme' => $_POST['yeni_sekme']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Update SON */

            /* Mobil Gorsel */
            if($_GET['status'] == 'mobil_gorsel'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_FILES['gorsel_mobil']["size"] > 0) {
                        $old_mobil = $_POST['old_mobil'];
                        $file_format = $_FILES["gorsel_mobil"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            /* Görsel Upload */
                            include_once('inc/class.upload.php');
                            $upload = new Upload($_FILES['gorsel_mobil']);
                            if ($upload->uploaded) {
                                $random = rand(0, (int)99991234569);
                                $random2 = rand(0, (int)999);
                                $upload->file_name_body_pre = 'slider_';
                                $upload->file_name_body_add = ''.$random.''.$random2.'';
                                $upload->image_resize = true;
                                $upload->image_ratio_crop = true;
                                $upload->png_quality = 90;
                                $upload->webp_quality = 85;
                                $upload->jpeg_quality = 95;
                                $upload->png_compression = 9;
                                $upload->image_ratio_x         = true;
                                $upload->image_y = $slidRow['mobil_height'];
                                $upload->process("../i/uploads");
                                $file_name = $upload->file_dst_name;
                            }
                            /*  <========SON=========>>> Görsel Upload SON */
                            $guncelle = $db->prepare("UPDATE slider2 SET
                                  gorsel_mobil=:gorsel_mobil
                                 WHERE id={$_POST['slider_id']}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'gorsel_mobil' => $file_name
                            ));
                            if($sonuc){
                                if($old_mobil == !null || isset($old_mobil) ) {
                                    unlink("../i/uploads/$old_mobil");
                                }
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Mobil Gorsel SON */

            /* Delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from slider2 where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../i/uploads/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from slider2 WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=middle_slider');
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