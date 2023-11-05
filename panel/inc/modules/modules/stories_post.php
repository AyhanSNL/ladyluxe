<?php use Verot\Upload\Upload;
echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add_group' ||  $_GET['status'] == 'story_add' ||   $_GET['status'] == 'story_update' || $_GET['status'] == 'story_delete' ||  $_GET['status'] == 'update_group' || $_GET['status'] == 'delete' ||  $_GET['status'] == 'theme_settings' ||  $_GET['status'] == 'multidelete' ) {

            if($_GET['status'] == 'theme_settings'  ) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_story');
            }

            $storyAyar = $db->prepare("select tur from story_ayar where id='1' ");
            $storyAyar->execute();
            $stAyar = $storyAyar->fetch(PDO::FETCH_ASSOC);
            $grup_id = rand(0,(int) 999999);

            /* Story Grup Multi Delete */
            if($_GET['status'] == 'multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from story_grup where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from story_grup WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                            unlink('../i/stories/'.$row['gorsel'].'');

                          /* Storyleri sil */
                            $altStoriler = $db->prepare("select * from story where grup_id=:grup_id ");
                            $altStoriler->execute(array(
                                'grup_id' => $row['grup_id']
                            ));
                            if($altStoriler->rowCount()>'0'  ) {
                                foreach ($altStoriler as $altRow){
                                    $storiSil = $db->prepare("DELETE from story WHERE id=:id");
                                    $storiSil->execute(array(
                                        'id' => $altRow['id']
                                    ));
                                    unlink('../i/stories/'.$altRow['gorsel'].'');
                                }
                            }
                          /*  <========SON=========>>> Storyleri sil SON */

                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                }
            }
            /*  <========SON=========>>> Story Grup Multi Delete SON */


            /*  Story Insert */
            if($_GET['status'] == 'story_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if ($_FILES['gorsel']["size"] > 0) {
                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            if($_POST['saniye'] && $_POST['baslik'] && $_POST['grup_id']  ) {
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'story_item_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 90;
                                    $upload->jpeg_quality = 90;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 500;
                                    $upload->image_y = 750;
                                    $upload->process("../i/stories");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                $kaydet = $db->prepare("INSERT INTO story SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  sira=:sira,
                                 grup_id=:grup_id,
                                 url_adres=:url_adres,
                                 saniye=:saniye,
                                 url_baslik=:url_baslik,
                                 durum=:durum
                                ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'sira' => $_POST['sira'],
                                    'grup_id' => $_POST['grup_id'],
                                    'url_adres' => $_POST['url_adres'],
                                    'saniye' => $_POST['saniye'],
                                    'url_baslik' => $_POST['url_baslik'],
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Story Insert SON */
            /*  STORY Update */
            if($_GET['status'] == 'story_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if ($_FILES['gorsel']["size"] > 0) {
                        $old_img = $_POST['old_img'];
                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            if($_POST['sira'] && $_POST['baslik']) {
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'story_item_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_compression = 9;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 90;
                                    $upload->jpeg_quality = 90;
                                    $upload->image_x = 500;
                                    $upload->image_y = 750;
                                    $upload->process("../i/stories");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /* URL Ayar */
                                if($stAyar['tur'] == '1' ) {
                                    $go_url = null;
                                }else{
                                    $go_url = $_POST['url_adres'];
                                }
                                /*  <========SON=========>>> URL Ayar SON */
                                $guncelle = $db->prepare("UPDATE story SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  sira=:sira,
                                 url_adres=:url_adres,
                                 saniye=:saniye,
                                 url_baslik=:url_baslik,
                                 durum=:durum
                                 WHERE id={$_POST['story_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'sira' => $_POST['sira'],
                                    'url_adres' => $_POST['url_adres'],
                                    'saniye' => $_POST['saniye'],
                                    'url_baslik' => $_POST['url_baslik'],
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../i/stories/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        /* URL Ayar */
                        if($stAyar['tur'] == '1' ) {
                            $go_url = null;
                        }else{
                            $go_url = $_POST['url_adres'];
                        }
                        /*  <========SON=========>>> URL Ayar SON */
                        $guncelle = $db->prepare("UPDATE story SET
                                  baslik=:baslik,      
                                  sira=:sira,
                                 url_adres=:url_adres,
                                 saniye=:saniye,
                                 url_baslik=:url_baslik,
                                 durum=:durum
                                 WHERE id={$_POST['story_id']}      
                                ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'sira' => $_POST['sira'],
                            'url_adres' => $_POST['url_adres'],
                            'saniye' => $_POST['saniye'],
                            'url_baslik' => $_POST['url_baslik'],
                            'durum' => $_POST['durum']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_POST['grup_id'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  STORY Update SON */

            /* STORY Delete */
            if($_GET['status'] == 'story_delete' && isset($_GET['no'])  && isset($_GET['grup_id']) ) {
                if($_GET['no'] == !null && $_GET['grup_id'] == !null   ) {

                    $resimKontrol = $db->prepare("select * from story where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../i/stories/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from story WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_GET['grup_id'].'');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=story_item_list&grup_id='.$_GET['grup_id'].'');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> STORY Delete SON */


            /*  Insert */
            if($_GET['status'] == 'add_group'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if ($_FILES['gorsel']["size"] > 0) {

                        /* URL Ayar */
                        if($stAyar['tur'] == '1' ) {
                            $go_url = null;
                        }else{
                            $go_url = $_POST['url_adres'];
                        }
                        /*  <========SON=========>>> URL Ayar SON */

                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                            if($_POST['sira']   ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'story_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 85;
                                    $upload->jpeg_quality = 85;
                                    $upload->image_x = 90;
                                    $upload->image_y = 90;
                                    $upload->process("../i/stories");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $kaydet = $db->prepare("INSERT INTO story_grup SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  url_adres=:url_adres,
                                  sira=:sira,
                                  durum=:durum,
                                  dil=:dil,
                                  grup_id=:grup_id
                                ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'url_adres' => $go_url,
                                    'sira' => $_POST['sira'],
                                    'durum' => $_POST['durum'],
                                    'dil' => $_SESSION['dil'],
                                    'grup_id' => $grup_id
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Insert SON */

            /*  Update */
            if($_GET['status'] == 'update_group'  ) {
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
                                    $upload->file_name_body_pre = 'story_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 85;
                                    $upload->jpeg_quality = 85;
                                    $upload->image_x = 90;
                                    $upload->image_y = 90;
                                    $upload->process("../i/stories");
                                    $file_name = $upload->file_dst_name;
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                /* URL Ayar */
                                if($stAyar['tur'] == '1' ) {
                                    $go_url = null;
                                }else{
                                    $go_url = $_POST['url_adres'];
                                }
                                /*  <========SON=========>>> URL Ayar SON */
                                $guncelle = $db->prepare("UPDATE story_grup SET
                                   baslik=:baslik,      
                                  gorsel=:gorsel,
                                  url_adres=:url_adres,
                                  sira=:sira,
                                  durum=:durum
                                 WHERE id={$_POST['story_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'url_adres' => $go_url,
                                    'sira' => $_POST['sira'],
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../i/stories/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        /* URL Ayar */
                        if($stAyar['tur'] == '1' ) {
                            $go_url = null;
                        }else{
                            $go_url = $_POST['url_adres'];
                        }
                        /*  <========SON=========>>> URL Ayar SON */
                        $guncelle = $db->prepare("UPDATE story_grup SET
                                   baslik=:baslik,      
                                  url_adres=:url_adres,
                                  sira=:sira,
                                  durum=:durum
                                 WHERE id={$_POST['story_id']}      
                                ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'url_adres' => $go_url,
                            'sira' => $_POST['sira'],
                            'durum' => $_POST['durum']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
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

                    $resimKontrol = $db->prepare("select * from story_grup where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    $resimRow = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    if($resimKontrol->rowCount()>'0'  ) {
                        unlink('../i/stories/'.$resimRow['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        /* Storiler varsa onları sil önce */
                         $altStoriler = $db->prepare("select * from story where grup_id=:grup_id ");
                         $altStoriler->execute(array(
                             'grup_id' => $resimRow['grup_id']
                         ));
                         if($altStoriler->rowCount()>'0'  ) {
                          foreach ($altStoriler as $altRow){
                              $storiSil = $db->prepare("DELETE from story WHERE id=:id");
                              $storiSil->execute(array(
                                  'id' => $altRow['id']
                              ));
                              unlink('../i/stories/'.$altRow['gorsel'].'');
                          }
                         }

                        /*  <========SON=========>>> Storiler varsa onları sil önce SON */
                        $silmeislem = $db->prepare("DELETE from story_grup WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=stories');
                        }else {
                            echo 'veritabanı hatası';
                        }
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