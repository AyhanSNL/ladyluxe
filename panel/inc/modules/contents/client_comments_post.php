<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'edit' ||  $_GET['status'] == 'delete'  ||  $_GET['status'] == 'img_delete' ) {

            $timestamp = date('Y-m-d G:i:s');

            /*  Add */
            if($_GET['status'] == 'add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['isim'] && $_POST['sira'] && $_POST['icerik']) {

                        if ($_FILES['gorsel']["size"] > 0) {
                            $file_format = $_FILES["gorsel"];
                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'client_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 134;
                                    $upload->image_y = 134;
                                    $upload->process("../images/comments");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                    $kaydet = $db->prepare("INSERT INTO yorum SET
                                            isim=:isim,    
                                            tarih=:tarih,
                                            gorsel=:gorsel,
                                            star_rate=:star_rate,
                                            pozisyon=:pozisyon,
                                            icerik=:icerik,
                                            dil=:dil,
                                            durum=:durum,
                                            sira=:sira
                                        ");
                                    $sonuc = $kaydet->execute(array(
                                        'isim' => $_POST['isim'],
                                        'tarih' => $timestamp,
                                        'gorsel' => $file_name,
                                        'star_rate' => $_POST['star_rate'],
                                        'pozisyon' => $_POST['pozisyon'],
                                        'icerik' => $_POST['icerik'],
                                        'dil' => $_SESSION['dil'],
                                        'durum' => $_POST['durum'],
                                        'sira' => $_POST['sira']
                                    ));
                                    if($sonuc){
                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $kaydet = $db->prepare("INSERT INTO yorum SET
                                            isim=:isim,    
                                            tarih=:tarih,
                                            gorsel=:gorsel,
                                            star_rate=:star_rate,
                                            pozisyon=:pozisyon,
                                            icerik=:icerik,
                                            dil=:dil,
                                            durum=:durum,
                                            sira=:sira
                                        ");
                            $sonuc = $kaydet->execute(array(
                                'isim' => $_POST['isim'],
                                'tarih' => $timestamp,
                                'gorsel' => 'no-image',
                                'star_rate' => $_POST['star_rate'],
                                'pozisyon' => $_POST['pozisyon'],
                                'icerik' => $_POST['icerik'],
                                'dil' => $_SESSION['dil'],
                                'durum' => $_POST['durum'],
                                'sira' => $_POST['sira']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  Edit */
            if($_GET['status'] == 'edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_POST['isim'] && $_POST['sira'] && $_POST['comment_id'] && $_POST['icerik'] ) {
                        if ($_FILES['gorsel']["size"] > 0) {
                            $file_format = $_FILES["gorsel"];
                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'client_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->image_ratio_crop = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 92;
                                    $upload->jpeg_quality = 92;
                                    $upload->png_compression = 9;
                                    $upload->image_x = 134;
                                    $upload->image_y = 134;
                                    $upload->process("../images/comments");
                                }
                                if ($upload->processed){
                                    $file_name = $upload->file_dst_name;
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                                /*  <========SON=========>>> Görsel Upload SON */
                                $guncelle = $db->prepare("UPDATE yorum SET
                                            isim=:isim,    
                                            gorsel=:gorsel,
                                            tarih=:tarih,
                                            star_rate=:star_rate,
                                            pozisyon=:pozisyon,
                                            icerik=:icerik,
                                            durum=:durum,
                                            sira=:sira
                         WHERE id={$_POST['comment_id']}      
                        ");
                                $sonuc = $guncelle->execute(array(
                                    'isim' => $_POST['isim'],
                                    'gorsel' => $file_name,
                                    'tarih' => $timestamp,
                                    'star_rate' => $_POST['star_rate'],
                                    'pozisyon' => $_POST['pozisyon'],
                                    'icerik' => $_POST['icerik'],
                                    'durum' => $_POST['durum'],
                                    'sira' => $_POST['sira']
                                ));
                                if($sonuc){
                                    if($_POST['old_img'] >'0'  ) { 
                                     unlink('../images/comments/'.$_POST['old_img'].'');
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $guncelle = $db->prepare("UPDATE yorum SET
                                            isim=:isim,    
                                            star_rate=:star_rate,
                                            pozisyon=:pozisyon,
                                            icerik=:icerik,
                                            durum=:durum,
                                            sira=:sira
                         WHERE id={$_POST['comment_id']}      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'isim' => $_POST['isim'],
                                'star_rate' => $_POST['star_rate'],
                                'pozisyon' => $_POST['pozisyon'],
                                'icerik' => $_POST['icerik'],
                                'durum' => $_POST['durum'],
                                'sira' => $_POST['sira']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /*  delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from yorum where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../images/comments/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from yorum WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */
            
            /* IMG Delete */
            if($_GET['status'] == 'img_delete'  ) {
                $sorgu = $db->prepare("select * from yorum where id='$_GET[no]' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink('../images/comments/'.$row['gorsel'].'');
                $guncelle = $db->prepare("UPDATE yorum SET
                            gorsel=:gorsel
                     WHERE id='$_GET[no]'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'gorsel' => 'no-image',
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=client_comments');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> IMG Delete SON */

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