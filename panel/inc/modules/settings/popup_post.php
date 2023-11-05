<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'img_delete' || $_GET['status'] == 'update'  ) {


            /* Main Update */
            if($_GET['status']=='update'   ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['tur'] == '0' || $_POST['tur'] == '1'  ) {

                        if($_POST['tur']=='0') {
                            /* Görselli Güncelleme */
                            $old_img = $_POST['old_gorsel'];
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
                                $target = "../images/uploads/" . $file_name;

                                if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' ) {
                                    $gitti = move_uploaded_file($kaynak, $target);

                                    $guncelle = $db->prepare("UPDATE popup SET
                                         gorsel=:gorsel, 
                                         durum=:durum,
                                         ip_durum=:ip_durum,
                                         url_target=:url_target,
                                         url=:url,
                                         delay=:delay,
                                         padding=:padding,
                                         tur=:tur
                                         WHERE id='1'      
                                        ");
                                    $sonuc = $guncelle->execute(array(
                                        'gorsel' => $file_name,
                                        'durum' => $_POST['durum'],
                                        'ip_durum' => $_POST['ip_durum'],
                                        'url_target' => $_POST['url_target'],
                                        'url' => $_POST['url'],
                                        'delay' => $_POST['delay'],
                                        'padding' => $_POST['padding'],
                                        'tur' => '0'
                                    ));
                                    if($sonuc){
                                        if($old_img == !null || isset($old_img) ) {
                                            unlink("../images/uploads/$old_img");
                                        }
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=popup');
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=popup');
                                    $_SESSION['main_alert'] = 'filetype';
                                }
                            }else{
                                $guncelle = $db->prepare("UPDATE popup SET
                                         durum=:durum,
                                         ip_durum=:ip_durum,
                                         url_target=:url_target,
                                         url=:url,
                                         delay=:delay,
                                         padding=:padding,
                                         tur=:tur
                                         WHERE id='1'      
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'durum' => $_POST['durum'],
                                    'ip_durum' => $_POST['ip_durum'],
                                    'url_target' => $_POST['url_target'],
                                    'url' => $_POST['url'],
                                    'delay' => $_POST['delay'],
                                    'padding' => $_POST['padding'],
                                    'tur' => '0'
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=popup');
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }
                            /*  <========SON=========>>> Görselli Güncelleme SON */
                        }


                        if($_POST['tur']=='1') {
                            /* Görselli Güncelleme */
                            $guncelle = $db->prepare("UPDATE popup SET
                                         durum=:durum,
                                         ip_durum=:ip_durum,
                                         embed=:embed,
                                         delay=:delay,
                                         padding=:padding,
                                         tur=:tur
                                         WHERE id='1'      
                                        ");
                            $sonuc = $guncelle->execute(array(
                                'durum' => $_POST['durum'],
                                'ip_durum' => $_POST['ip_durum'],
                                'embed' => $_POST['embed'],
                                'delay' => $_POST['delay'],
                                'padding' => $_POST['padding'],
                                'tur' => '1'
                            ));
                            if ($sonuc) {
                                header('Location:' . $ayar['panel_url'] . 'pages.php?page=popup');
                                $_SESSION['main_alert'] = 'success';
                            } else {
                                echo 'Veritabanı Hatası';
                                /*  <========SON=========>>> Görselli Güncelleme SON */
                            }
                        }


                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Main Update SON */

            /* BG Delete */
            if($_GET['status']=='img_delete'  ) {
                $baksorgu = $db->prepare("select * from popup where id='1' ");
                $baksorgu->execute();
                $bak = $baksorgu->fetch(PDO::FETCH_ASSOC);

                $sil = unlink("../images/uploads/$bak[gorsel]");
                $guncelle = $db->prepare("UPDATE popup SET
                         gorsel=:gorsel
                  WHERE id='1'      
                 ");
                $sonuc = $guncelle->execute(array(
                    'gorsel' => null
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=popup');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> BG Delete SON */


        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=popup');
    $_SESSION['main_alert'] = 'demo';
}