<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'edit' ||  $_GET['status'] == 'comments_edit' || $_GET['status'] == 'comment_delete' ||$_GET['status'] == 'comment_multidelete' || $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete') {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            /*  Add */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['baslik'] && $_POST['icerik'] && $_POST['sira']  ) {

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
                                    $upload->file_name_body_pre = 'services_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 275;
                                    $upload->image_y = 185;
                                    $upload->process("../images/services");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $timestamp = date('Y-m-d G:i:s');
                                $kaydet = $db->prepare("INSERT INTO hizmet SET
                                            baslik=:baslik,
                                            sira=:sira,
                                            spot=:spot,
                                            gorsel=:gorsel,
                                            icerik=:icerik,
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
                                    'spot' => $_POST['spot'],
                                    'gorsel' => $file_name,
                                    'icerik' => $_POST['icerik'],
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
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }

                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                            $_SESSION['main_alert'] = 'filesize';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  edit */
            if($_GET['status'] == 'edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['icerik'] && $_POST['sira']  ) {

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
                                    $upload->file_name_body_pre = 'services_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 275;
                                    $upload->image_y = 185;
                                    $upload->process("../images/services");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $guncelle = $db->prepare("UPDATE hizmet SET
                                             baslik=:baslik,
                                            sira=:sira,
                                            spot=:spot,
                                            gorsel=:gorsel,
                                            icerik=:icerik,
                                            anasayfa=:anasayfa,
                                            meta_desc=:meta_desc,
                                            tags=:tags,
                                            seo_url=:seo_url,
                                            seo_baslik=:seo_baslik,
                                            durum=:durum 
                                 WHERE id={$_POST['ser_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'sira' => $_POST['sira'],
                                    'spot' => $_POST['spot'],
                                    'gorsel' => $file_name,
                                    'icerik' => $_POST['icerik'],
                                    'anasayfa' => $_POST['anasayfa'],
                                    'meta_desc' => $_POST['meta_desc'],
                                    'tags' => $_POST['tags'],
                                    'seo_url' => $seo_url,
                                    'seo_baslik' => $seo_title,
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../images/services/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }

                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $guncelle = $db->prepare("UPDATE hizmet SET
                                        baslik=:baslik,
                                            sira=:sira,
                                            spot=:spot,
                                            icerik=:icerik,
                                            anasayfa=:anasayfa,
                                            meta_desc=:meta_desc,
                                            tags=:tags,
                                            seo_url=:seo_url,
                                            seo_baslik=:seo_baslik,
                                            durum=:durum   
                                 WHERE id={$_POST['ser_id']}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'sira' => $_POST['sira'],
                                'spot' => $_POST['spot'],
                                'icerik' => $_POST['icerik'],
                                'anasayfa' => $_POST['anasayfa'],
                                'meta_desc' => $_POST['meta_desc'],
                                'tags' => $_POST['tags'],
                                'seo_url' => $seo_url,
                                'seo_baslik' => $seo_title,
                                'durum' => $_POST['durum']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  edit SON */

            /*  delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from hizmet where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../images/services/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from hizmet WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */

            /*  multi delete */
            if($_GET['status'] == 'multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from hizmet where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            unlink('../images/services/'.$row['gorsel'].'');


                            $silmeislem = $db->prepare("DELETE from hizmet WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=services');
                }
            }
            /*  <========SON=========>>>  multi delete SON */


            /*  comment edit */
            if($_GET['status'] == 'comments_edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                       if (filter_var($_POST['eposta'], FILTER_VALIDATE_EMAIL)){


                           $guncelle = $db->prepare("UPDATE modul_yorum SET
                                isim=:isim,
                                eposta=:eposta,
                                durum=:durum,
                                icerik=:icerik
                         WHERE id={$_POST['comment_id']}      
                        ");
                           $sonuc = $guncelle->execute(array(
                               'isim' => $_POST['isim'],
                               'eposta' => $_POST['eposta'],
                               'durum' => $_POST['durum'],
                               'icerik' => $_POST['icerik']
                           ));
                           if($sonuc){
                               $_SESSION['main_alert'] = 'success';
                               header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                           }else{
                               echo 'Veritabanı Hatası';
                           }
                       }else{
                           $_SESSION['main_alert'] = 'emailerror';
                           header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                       }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  comment edit SON */

            /*  comment delete */
            if($_GET['status'] == 'comment_delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {
                    $resimKontrol = $db->prepare("select * from modul_yorum where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    }
                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from modul_yorum WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  comment delete SON */

            /*  comment multi delete */
            if($_GET['status'] == 'comment_multidelete'  ) {
                if($_POST && isset($_POST['multidelete'])) {
                    if($_POST['sil'] == !null  ) {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler){
                            $sorgu = $db->prepare("select * from modul_yorum where id='$idler' ");
                            $sorgu->execute();
                            if($sorgu->rowCount()>'0'  ) {
                                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                                $silmeislem = $db->prepare("DELETE from modul_yorum WHERE id=:id");
                                $silmeislem->execute(array(
                                    'id' => $idler
                                ));
                            }
                        }
                        $_SESSION['main_alert'] ='success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                    }
                }
                if($_POST && isset($_POST['active'])) {
                    if($_POST['sil'] == !null  ) {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler){
                            $sorgu = $db->prepare("select * from modul_yorum where id='$idler' ");
                            $sorgu->execute();
                            if($sorgu->rowCount()>'0'  ) {
                                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                                $guncelle = $db->prepare("UPDATE modul_yorum SET
                                       durum=:durum 
                                 WHERE id={$idler}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'durum' => '1'
                                ));
                                if($sonuc){

                                }else{
                                echo 'Veritabanı Hatası';
                                }
                            }
                        }
                        $_SESSION['main_alert'] ='success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                    }else{
                        $_SESSION['main_alert'] ='nocheck2';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                    }
                }
                if($_POST && isset($_POST['deactive'])) {
                    if($_POST['sil'] == !null  ) {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler){
                            $sorgu = $db->prepare("select * from modul_yorum where id='$idler' ");
                            $sorgu->execute();
                            if($sorgu->rowCount()>'0'  ) {
                                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                                $guncelle = $db->prepare("UPDATE modul_yorum SET
                                       durum=:durum 
                                 WHERE id={$idler}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'durum' => '0'
                                ));
                                if($sonuc){

                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }
                        }
                        $_SESSION['main_alert'] ='success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                    }else{
                        $_SESSION['main_alert'] ='nocheck2';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=service_comments');
                    }
                }
            }
            /*  <========SON=========>>>  comment multi delete SON */


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