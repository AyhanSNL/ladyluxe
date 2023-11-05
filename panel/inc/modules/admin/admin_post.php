<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {

    if(isset($_GET['status'])  ) {
        if($_GET['status']=='admin_edit' || $_GET['status']=='ppdelete' || $_GET['status'] == 'admin_add' || $_GET['status'] == 'admin_delete' || $_GET['status'] == 'admin_multi_delete'    ) {

            /* Admin Add */
            if($_GET['status'] == 'admin_add'  ) {
                if($_POST && isset($_POST['adminAdd'])  ) {
                    $isim = $_POST['isim'];
                    $soyisim = $_POST['soyisim'];
                    $user = $_POST['user_adi'];
                    $pass = $_POST['pass_sifre'];
                    $md5pass = md5($pass);
                    $timestamp = date('Y-m-d G:i:s');
                    $rand = rand(0,(int) 999999);

                    if($isim && $soyisim && $user && $pass) {
                        if ($_FILES['foto']["size"] > 0) {
                            $file_format = $_FILES["foto"];
                            $kaynak = $_FILES["foto"]["tmp_name"];
                            $uzanti = explode(".", $_FILES['foto']['name']);
                            $random = rand(0, (int)99999);
                            $random2 = rand(0, (int)999);
                            $filename = trim(addslashes($_FILES['foto']['name']));
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
                            $target = "assets/images/uploads/" . $file_name;

                            if ($file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif') {
                                $gitti = move_uploaded_file($kaynak, $target);
                                $kaydet = $db->prepare("INSERT INTO yonetici SET
                    isim=:isim,       
                    soyisim=:soyisim,
                    user_adi=:user_adi,
                    pass_sifre=:pass_sifre,
                    foto=:foto,
                    random_id=:random_id,
                    yetki=:yetki,
                    sound=:sound,
                    tarih=:tarih
                   ");
                                $sonuc = $kaydet->execute(array(
                                    'isim' => $isim,
                                    'soyisim' => $soyisim,
                                    'user_adi' => $user,
                                    'pass_sifre' => $md5pass,
                                    'foto' => $file_name,
                                    'random_id' => $rand,
                                    'yetki' => $_POST['yetki'],
                                    'sound' => '1',
                                    'tarih' => $timestamp
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            } else {
                                header('Location:'.$ayar['panel_url'].'pages.php?page=admin_add');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $kaydet = $db->prepare("INSERT INTO yonetici SET
                    isim=:isim,       
                    soyisim=:soyisim,
                    user_adi=:user_adi,
                    pass_sifre=:pass_sifre,
                    random_id=:random_id,
                    yetki=:yetki,
                    sound=:sound,
                    tarih=:tarih
                   ");
                            $sonuc = $kaydet->execute(array(
                                'isim' => $isim,
                                'soyisim' => $soyisim,
                                'user_adi' => $user,
                                'pass_sifre' => $md5pass,
                                'random_id' => $rand,
                                'yetki' => $_POST['yetki'],
                                'sound' => '1',
                                'tarih' => $timestamp
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=admin_add');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
                }
            }
            /*  <========SON=========>>> Admin Add SON */





            /* Admin Edit */
            if($_GET['status'] == 'admin_edit' ) {
                if($_POST && isset($_POST['adminEdit'])  ) {
                    $isim = $_POST['isim'];
                    $soyisim = $_POST['soyisim'];
                    $user = $_POST['user_adi'];
                    $pass = $_POST['pass_sifre'];

                    if($isim && $soyisim) {
                        if ($_FILES['foto']["size"] > 0) {
                            $file_format = $_FILES["foto"];
                            $kaynak = $_FILES["foto"]["tmp_name"];
                            $uzanti = explode(".", $_FILES['foto']['name']);
                            $random = rand(0, (int)99999);
                            $random2 = rand(0, (int)999);
                            $filename = trim(addslashes($_FILES['foto']['name']));
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
                            $target = "assets/images/uploads/" . $file_name;

                            if ($file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif') {
                                $gitti = move_uploaded_file($kaynak, $target);
                                unlink("assets/images/uploads/$_POST[old_img]");
                                /* Foto eklenmiş */
                                if($pass) {
                                    $md5pass = md5($pass);
                                    $guncelle = $db->prepare("UPDATE yonetici SET
                                            isim=:isim,
                                            soyisim=:soyisim,
                                            user_adi=:user_adi,
                                            foto=:foto,
                                            yetki=:yetki,
                                            pass_sifre=:pass_sifre
                                     WHERE random_id={$_POST['admin_no']}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'isim' => $isim,
                                        'soyisim' => $soyisim,
                                        'user_adi' => $user,
                                        'foto' => $file_name,
                                        'yetki' => $_POST['yetki'],
                                        'pass_sifre' => $md5pass
                                    ));
                                    if($sonuc){
                                        if($adminRow['random_id'] == $_POST['admin_no'] ) {
                                            $_SESSION['admin_user_session'] = $user;
                                        }
                                        $_SESSION['main_alert'] ='success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=admin_edit&no='.$_POST['admin_no'].'');
                                    }else{
                                    echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    $guncelle = $db->prepare("UPDATE yonetici SET
                                            isim=:isim,
                                            soyisim=:soyisim,
                                            user_adi=:user_adi,
                                            foto=:foto,
                                            yetki=:yetki
                                     WHERE random_id={$_POST['admin_no']}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'isim' => $isim,
                                        'soyisim' => $soyisim,
                                        'user_adi' => $user,
                                        'foto' => $file_name,
                                        'yetki' => $_POST['yetki']
                                    ));
                                    if($sonuc){
                                        if($adminRow['random_id'] == $_POST['admin_no'] ) {
                                            $_SESSION['admin_user_session'] = $user;
                                        }
                                        $_SESSION['main_alert'] ='success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=admin_edit&no='.$_POST['admin_no'].'');
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }
                                /*  <========SON=========>>> Foto eklenmiş SON */
                            }
                        }else{
                            if($pass) {
                                $md5pass = md5($pass);
                                $guncelle = $db->prepare("UPDATE yonetici SET
                                            isim=:isim,
                                            soyisim=:soyisim,
                                            user_adi=:user_adi,
                                            yetki=:yetki,
                                            pass_sifre=:pass_sifre
                                     WHERE random_id={$_POST['admin_no']}      
                                    ");
                                $sonuc = $guncelle->execute(array(
                                    'isim' => $isim,
                                    'soyisim' => $soyisim,
                                    'user_adi' => $user,
                                    'yetki' => $_POST['yetki'],
                                    'pass_sifre' => $md5pass
                                ));
                                if($sonuc){
                                    if($adminRow['random_id'] == $_POST['admin_no'] ) {
                                        $_SESSION['admin_user_session'] = $user;
                                    }
                                    $_SESSION['main_alert'] ='success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_edit&no='.$_POST['admin_no'].'');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                $guncelle = $db->prepare("UPDATE yonetici SET
                                            isim=:isim,
                                            soyisim=:soyisim,
                                            user_adi=:user_adi,
                                            yetki=:yetki
                                     WHERE random_id={$_POST['admin_no']}      
                                    ");
                                $sonuc = $guncelle->execute(array(
                                    'isim' => $isim,
                                    'soyisim' => $soyisim,
                                    'user_adi' => $user,
                                    'yetki' => $_POST['yetki']
                                ));
                                if($sonuc){
                                    if($adminRow['random_id'] == $_POST['admin_no'] ) {
                                        $_SESSION['admin_user_session'] = $user;
                                    }
                                    $_SESSION['main_alert'] ='success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_edit&no='.$_POST['admin_no'].'');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=admin_add');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
                }
            }
            /*  <========SON=========>>> Admin Edit SON */



            /* Admin PP Delete */
            if($_GET['status'] == 'ppdelete' ) {

                $sorgu = $db->prepare("select * from yonetici where random_id=:random_id ");
                $sorgu->execute(array(
                    'random_id' => $_GET['no'],
                ));

                if($sorgu->rowCount()>'0'  ) {
                 $cek = $sorgu->fetch(PDO::FETCH_ASSOC);
                    unlink("assets/images/uploads/$cek[foto]");
                    $guncelle = $db->prepare("UPDATE yonetici SET
                            foto=:foto
                     WHERE random_id={$_GET['no']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'foto' => null,
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] ='success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=admin_edit&no='.$_GET['no'].'');
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_edit&no='.$_GET['no'].'');
                }
            }
            /*  <========SON=========>>> Admin PP Delete SON */





            /* Admin Delete */
            if($_GET['status'] == 'admin_delete'  ) {
                $admin_no = $_GET['no'];

                $sorgu = $db->prepare("select * from yonetici where random_id='$admin_no' ");
                $sorgu->execute();

                if($sorgu->rowCount()>'0'  ) {

                    $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                    unlink("assets/images/uploads/$row[foto]");

                    $silmeislem = $db->prepare("DELETE from yonetici WHERE random_id=:random_id");
                    $sil = $silmeislem->execute(array(
                       'random_id' => $admin_no
                    ));
                    if ($sil) {
                        $_SESSION['main_alert'] ='success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Admin Delete SON */




            /* ADmin Multi Delete */
            if($_GET['status'] == 'admin_multi_delete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                   foreach ($liste as $adminno){
                       $sorgu = $db->prepare("select * from yonetici where random_id='$adminno' ");
                       $sorgu->execute();
                       if($sorgu->rowCount()>'0'  ) {
                               $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                               unlink("assets/images/uploads/$row[foto]");
                               $silmeislem = $db->prepare("DELETE from yonetici WHERE random_id=:random_id");
                               $silmeislem->execute(array(
                                   'random_id' => $adminno
                               ));
                       }
                   }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
                }
            }
            /*  <========SON=========>>> ADmin Multi Delete SON */





        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
    $_SESSION['main_alert'] = 'demo';
}
?>