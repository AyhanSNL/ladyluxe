<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'intro_add' || $_GET['status'] == 'intro_edit' || $_GET['status'] == 'edit' ||  $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete' ) {

            /* Intro Add */
            if($_GET['status'] == 'intro_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['baslik'] && $_POST['video_kod']) {
                        $kaydet = $db->prepare("INSERT INTO tanitim_video_icerik SET
                            baslik=:baslik,    
                            ustbaslik=:ustbaslik,
                            video_kod=:video_kod,
                            dil=:dil
                        ");
                        $sonuc = $kaydet->execute(array(
                            'baslik' => $_POST['baslik'],
                            'ustbaslik' => $_POST['ustbaslik'],
                            'video_kod' => $_POST['video_kod'],
                            'dil' => $_SESSION['dil']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=intro');
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=intro');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Intro Add SON */

            /* Intro Edit */
            if($_GET['status'] == 'intro_edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_POST['baslik'] && $_POST['video_kod'] && $_POST['intro_id']) {
                        $guncelle = $db->prepare("UPDATE tanitim_video_icerik SET
                                  baslik=:baslik,    
                            ustbaslik=:ustbaslik,
                            video_kod=:video_kod   
                         WHERE id={$_POST['intro_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'ustbaslik' => $_POST['ustbaslik'],
                            'video_kod' => $_POST['video_kod'],
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=intro');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=intro');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Intro Edit SON */

            /*  Add */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['baslik'] && $_POST['sira'] && $_POST['embed']  ) {

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
                            $target = "../images/videos/" . $file_name;

                            if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml'  ) {
                                $gitti = move_uploaded_file($kaynak, $target);
                                $timestamp = date('Y-m-d G:i:s');
                                $kaydet = $db->prepare("INSERT INTO video SET
                                            baslik=:baslik,
                                            spot=:spot,
                                            sira=:sira,
                                            hit=:hit,
                                            embed=:embed,
                                            gorsel=:gorsel,
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
                                    'spot' => $_POST['spot'],
                                    'sira' => $_POST['sira'],
                                    'hit' => '0',
                                    'embed' => $_POST['embed'],
                                    'gorsel' => $file_name,
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
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }

                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                            $_SESSION['main_alert'] = 'filesize';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  edit */
            if($_GET['status'] == 'edit'  ) {
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
                            $target = "../images/videos/" . $file_name;

                            if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml'  ) {
                                $gitti = move_uploaded_file($kaynak, $target);
                                $guncelle = $db->prepare("UPDATE video SET
                                            baslik=:baslik,
                                            spot=:spot,
                                            sira=:sira,
                                            embed=:embed,
                                            gorsel=:gorsel,
                                            meta_desc=:meta_desc,
                                            tags=:tags,
                                            seo_url=:seo_url,
                                            seo_baslik=:seo_baslik,
                                            durum=:durum
                                 WHERE id={$_POST['video_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'spot' => $_POST['spot'],
                                    'sira' => $_POST['sira'],
                                    'embed' => $_POST['embed'],
                                    'gorsel' => $file_name,
                                    'meta_desc' => $_POST['meta_desc'],
                                    'tags' => $_POST['tags'],
                                    'seo_url' => $seo_url,
                                    'seo_baslik' => $seo_title,
                                    'durum' => $_POST['durum']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../images/gallery/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }

                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
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
                            $guncelle = $db->prepare("UPDATE video SET
                                              baslik=:baslik,
                                            spot=:spot,
                                            sira=:sira,
                                            embed=:embed,
                                            meta_desc=:meta_desc,
                                            tags=:tags,
                                            seo_url=:seo_url,
                                            seo_baslik=:seo_baslik,
                                            durum=:durum
                                 WHERE id={$_POST['video_id']}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'spot' => $_POST['spot'],
                                'sira' => $_POST['sira'],
                                'embed' => $_POST['embed'],
                                'meta_desc' => $_POST['meta_desc'],
                                'tags' => $_POST['tags'],
                                'seo_url' => $seo_url,
                                'seo_baslik' => $seo_title,
                                'durum' => $_POST['durum']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  edit SON */

            /*  delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from video where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../images/videos/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from video WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
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
                        $sorgu = $db->prepare("select * from video where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            unlink('../images/videos/'.$row['gorsel'].'');
                            $silmeislem = $db->prepare("DELETE from video WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));

                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=video_gallery');
                }
            }
            /*  <========SON=========>>>  multi delete SON */




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