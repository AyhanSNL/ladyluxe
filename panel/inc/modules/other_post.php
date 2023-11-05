<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'password' || $_GET['status'] == 'account' || $_GET['status'] == 'ppdelete' || $_GET['status'] == 'inbox_delete'  ) {

            if($_GET['status'] == 'password'  ) {
                if ($_POST && isset($_POST['update'])) {

                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $new_password_again = $_POST['new_password_again'];

                    if( $old_password && $new_password && $new_password_again ) {
                        $old_password_md5 = md5($old_password);
                        if($adminRow['pass_sifre'] == $old_password_md5 ) {
                            if($new_password == $new_password_again  ) {
                                if($old_password != $new_password  ) {
                                    $timestamp = date('Y-m-d G:i:s');
                                    $newSifre = md5($new_password);
                                    $guncelle = $db->prepare("UPDATE yonetici SET
                                      sifre_tarih=:sifre_tarih,  
                                      pass_sifre=:pass_sifre
                                 WHERE id={$adminRow['id']}      
                                ");
                                    $sonuc = $guncelle->execute(array(
                                        'sifre_tarih' => $timestamp,
                                        'pass_sifre' => $newSifre
                                    ));
                                    if($sonuc){
                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=password_change');
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    $_SESSION['main_alert'] = 'old_new_pass_error';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=password_change');
                                }
                            }else{
                                $_SESSION['main_alert'] = 'new_password_error';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=password_change');
                            }
                        }else{
                            $_SESSION['main_alert'] = 'old_password_error';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=password_change');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=password_change');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'account'  ) {
                if($_POST && isset($_POST['update'])  ) {
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
                            $guncelle = $db->prepare("UPDATE yonetici SET
                                    foto=:foto,
                                    isim=:isim,
                                    soyisim=:soyisim,
                                    sound=:sound
                             WHERE id={$adminRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'foto' => $file_name,
                                'isim' => $_POST['isim'],
                                'soyisim' => $_POST['soyisim'],
                                'sound' => $_POST['sound']
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=my_account');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=my_account');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                  /* fotosuz */
                        $guncelle = $db->prepare("UPDATE yonetici SET
                                    isim=:isim,
                                    soyisim=:soyisim,
                                    sound=:sound
                             WHERE id={$adminRow['id']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'isim' => $_POST['isim'],
                            'soyisim' => $_POST['soyisim'],
                            'sound' => $_POST['sound']
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=my_account');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                  /*  <========SON=========>>> fotosuz SON */
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

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
                        header('Location:'.$ayar['panel_url'].'pages.php?page=my_account');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=my_account');
                }
            }



            /* Multi Delete */
            if($_GET['status'] == 'inbox_delete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];

                    if($liste == !null  ) {
                        foreach ($liste as $idler){
                            $sorgu = $db->prepare("select * from mesaj where id='$idler' ");
                            $sorgu->execute();
                            if($sorgu->rowCount()>'0'  ) {
                                $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                                $silmeislem = $db->prepare("DELETE from mesaj WHERE id=:id");
                                $silmeislem->execute(array(
                                    'id' => $idler
                                ));
                            }
                        }
                        header('Location:'.$ayar['panel_url'].'pages.php?page=inbox');
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=inbox');
                    }

                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=inbox');
                }
            }
            /*  <========SON=========>>> Multi Delete SON */


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