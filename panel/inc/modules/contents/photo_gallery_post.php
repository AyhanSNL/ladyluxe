<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'album_add' || $_GET['status'] == 'album_edit' ||  $_GET['status'] == 'album_delete' || $_GET['status'] == 'album_multidelete' || $_GET['status'] == 'photo_add' || $_GET['status'] == 'photo_edit' || $_GET['status'] == 'photo_multidelete' ) {

            /*  Add */
            if($_GET['status'] == 'album_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['baslik'] && $_POST['sira']  ) {

                        if($_POST['seo_url'] == !null  ) {
                            $seo_url = seo($_POST['seo_url']);
                        }else{
                            $seo_url = seo($_POST['baslik']);
                        }

                        if($_POST['seo_baslik']==!null  ) {
                            $seo_title = $_POST['seo_baslik'];
                        }else{
                            $seo_title = $_POST['baslik'];
                        }

                        if ($_FILES['gorsel']["size"] > 0) {
                            $file_format = $_FILES["gorsel"];
                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);

                                    $upload->file_name_body_pre = 'cover_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 480;
                                    $upload->image_y = 450;
                                    $upload->process("../images/gallery");

                                    $upload->file_name_body_pre = 'cover_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 255;
                                    $upload->image_y = 180;
                                    $upload->process("../images/gallery/small");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $timestamp = date('Y-m-d G:i:s');
                                $kaydet = $db->prepare("INSERT INTO galeri_kat SET
                                            baslik=:baslik,
                                            sira=:sira,
                                            gorsel=:gorsel,
                                            anasayfa=:anasayfa,
                                            meta_desc=:meta_desc,
                                            tags=:tags,
                                            tarih=:tarih,
                                            dil=:dil,
                                            seo_url=:seo_url,
                                            seo_baslik=:seo_baslik,
                                            durum=:durum
                                            ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'sira' => $_POST['sira'],
                                    'gorsel' => $file_name,
                                    'anasayfa' => $_POST['anasayfa'],
                                    'meta_desc' => $_POST['meta_desc'],
                                    'tags' => $_POST['tags'],
                                    'tarih' => $timestamp,
                                    'dil' => $_SESSION['dil'],
                                    'seo_url' => $seo_url,
                                    'seo_baslik' => $seo_title,
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }

                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                            $_SESSION['main_alert'] = 'filesize';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  edit */
            if($_GET['status'] == 'album_edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['sira']  ) {

                        if($_POST['seo_url'] == !null  ) {
                            $seo_url = seo($_POST['seo_url']);
                        }else{
                            $seo_url = seo($_POST['baslik']);
                        }

                        if($_POST['seo_baslik']==!null  ) {
                            $seo_title = $_POST['seo_baslik'];
                        }else{
                            $seo_title = $_POST['baslik'];
                        }

                        if ($_FILES['gorsel']["size"] > 0) {
                            $old_img = $_POST['old_img'];
                            $file_format = $_FILES["gorsel"];
                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);

                                    $upload->file_name_body_pre = 'cover_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 480;
                                    $upload->image_y = 450;
                                    $upload->process("../images/gallery");

                                    $upload->file_name_body_pre = 'cover_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 255;
                                    $upload->image_y = 180;
                                    $upload->process("../images/gallery/small");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $guncelle = $db->prepare("UPDATE galeri_kat SET
                                            baslik=:baslik,
                                            sira=:sira,
                                            gorsel=:gorsel,
                                            anasayfa=:anasayfa,
                                            meta_desc=:meta_desc,
                                            tags=:tags,
                                            seo_url=:seo_url,
                                            seo_baslik=:seo_baslik,
                                            durum=:durum
                                 WHERE id={$_POST['album_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'sira' => $_POST['sira'],
                                    'gorsel' => $file_name,
                                    'anasayfa' => $_POST['anasayfa'],
                                    'meta_desc' => $_POST['meta_desc'],
                                    'tags' => $_POST['tags'],
                                    'seo_url' => $seo_url,
                                    'seo_baslik' => $seo_title,
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../images/gallery/$old_img");
                                        unlink("../images/gallery/small/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }

                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            if($_POST['seo_url'] == !null  ) {
                                $seo_url = seo($_POST['seo_url']);
                            }else{
                                $seo_url = seo($_POST['baslik']);
                            }

                            if($_POST['seo_baslik']==!null  ) {
                                $seo_title = $_POST['seo_baslik'];
                            }else{
                                $seo_title = $_POST['baslik'];
                            }
                            $guncelle = $db->prepare("UPDATE galeri_kat SET
                                            baslik=:baslik,
                                            sira=:sira,
                                            anasayfa=:anasayfa,
                                            meta_desc=:meta_desc,
                                            tags=:tags,
                                            seo_url=:seo_url,
                                            seo_baslik=:seo_baslik,
                                            durum=:durum
                                 WHERE id={$_POST['album_id']}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'sira' => $_POST['sira'],
                                'anasayfa' => $_POST['anasayfa'],
                                'meta_desc' => $_POST['meta_desc'],
                                'tags' => $_POST['tags'],
                                'seo_url' => $seo_url,
                                'seo_baslik' => $seo_title,
                                'durum' => $_POST['durum']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  edit SON */



            /*  multi delete */
            if($_GET['status'] == 'album_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from galeri_kat where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            unlink('../images/gallery/'.$row['gorsel'].'');
                            unlink('../images/gallery/small/'.$row['gorsel'].'');
                            $silmeislem = $db->prepare("DELETE from galeri_kat WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));

                            $galeriKontrol = $db->prepare("select * from galeri_resim where kat_id=:kat_id ");
                            $galeriKontrol->execute(array(
                                'kat_id' => $idler
                            ));
                            if($galeriKontrol->rowCount() > '0'  ) {
                                foreach ($galeriKontrol as $resim){
                                    unlink('../images/gallery/'.$resim['gorsel'].'');
                                    $silmeislem2 = $db->prepare("DELETE from galeri_resim WHERE id=:id");
                                    $silmeislem2->execute(array(
                                        'id' => $resim
                                    ));
                                }
                            }
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery');
                }
            }
            /*  <========SON=========>>>  multi delete SON */


            /* Photo Insert */

                if(!empty($_FILES)  && $_GET['status'] == 'photo_add')
                {
                    $folder_name = '../images/gallery/';
                    $random = rand(0, (int)99999);
                    $random2 = rand(0, (int)999);
                    $filename =  trim(addslashes($_FILES['file']['name']));
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
                    $temp_file = $_FILES['file']['tmp_name'];

                    move_uploaded_file($temp_file, $folder_name.$file_name);

                    $kaydet = $db->prepare("INSERT INTO galeri_resim SET
                      gorsel=:gorsel,
                      kat_id=:kat_id
                      ");
                    $ekle = $kaydet->execute(array(
                        'gorsel' => $file_name,
                        'kat_id' => $_GET['parent']
                    ));
                    $_SESSION['main_alert'] ='success';
                }
            /*  <========SON=========>>> Photo Insert SON */


            /* Photo Multi-Delete OK */
            if($_GET['status'] == 'photo_multidelete'  ) {
                if($_POST) {
                    if(isset($_GET['parent']) && $_GET['parent']== !null  ) {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler){
                            $sorgu = $db->prepare("select * from galeri_resim where id='$idler' ");
                            $sorgu->execute();
                            if($sorgu->rowCount()>'0'  ) {
                                $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                                unlink('../images/gallery/'.$row['gorsel'].'');


                                $silmeislem = $db->prepare("DELETE from galeri_resim WHERE id=:id");
                                $silmeislem->execute(array(
                                    'id' => $idler
                                ));
                            }
                        }
                        $_SESSION['main_alert'] ='success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery_list&parent='.$_GET['parent'].'');
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery_list&parent='.$_GET['parent'].'');
                    }
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=photo_gallery_list&parent='.$_GET['parent'].'');
                }
            }

            /*  <========SON=========>>> Photo Multi-Delete SON */



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