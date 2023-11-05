<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'main_update'){
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            /* Genel Güncelleme */
            if($_GET['status'] == 'main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {



                    if ($_FILES['icon']["size"] > 0) {
                        $file_format = $_FILES["icon"];
                        $kaynak = $_FILES["icon"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['icon']['name']);
                        $random = rand(0,(int) 99999);
                        $random2 = rand(0,(int) 999);
                        $filename = trim(addslashes($_FILES['icon']['name']));
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
                        $file_name = $random . "-" . $random2 . "-" .$filename;
                        $target = "../images/loader/" . $file_name;

                        if($file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif'  ) {
                            $gitti = move_uploaded_file($kaynak, $target);

                            $guncelle = $db->prepare("UPDATE loader SET
                                icon=:icon,
                                back_color=:back_color,
                                durum=:durum,
                                delay=:delay
                         WHERE id='1'      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'icon' => $file_name,
                                'back_color' => colorFormat($_POST['back_color']),
                                'durum' => $_POST['durum'],
                                'delay' => $_POST['delay']
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=preloader');
                                $_SESSION['main_alert'] = 'success';
                                unlink("../images/loader/$_POST[old_icon]");
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=preloader');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        $guncelle = $db->prepare("UPDATE loader SET
                                back_color=:back_color,
                                durum=:durum,
                                delay=:delay
                         WHERE id='1'      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'back_color' => colorFormat($_POST['back_color']),
                            'durum' => $_POST['durum'],
                            'delay' => $_POST['delay']
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=preloader');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Genel Güncelleme SON */

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