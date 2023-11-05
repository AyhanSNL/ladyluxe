<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'update' || $_GET['status']=='delete' ) {


            /*  Edit */
            if($_GET['status'] == 'update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['yorumlimit'] ) {

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
                            $target = "../images/uploads/" . $file_name;

                            if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                                $gitti = move_uploaded_file($kaynak, $target);
                                $guncelle = $db->prepare("UPDATE modul_yorum_ayar SET
                                             blog_durum=:blog_durum,
                                            gorsel=:gorsel,
                                            hizmet_durum=:hizmet_durum,
                                            yorumlimit=:yorumlimit,
                                            oto_onay=:oto_onay,
                                            tumu_button_bg=:tumu_button_bg,
                                            gonder_button_bg=:gonder_button_bg   
                                 WHERE id='1'      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'blog_durum' => $_POST['blog_durum'],
                                    'gorsel' => $file_name,
                                    'hizmet_durum' => $_POST['hizmet_durum'],
                                    'yorumlimit' => $_POST['yorumlimit'],
                                    'oto_onay' => $_POST['oto_onay'],
                                    'tumu_button_bg' => $_POST['tumu_button_bg'],
                                    'gonder_button_bg' => $_POST['gonder_button_bg']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../images/uploads/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page='.$_SESSION['modul_comment_url'].'');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page='.$_SESSION['modul_comment_url'].'');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $guncelle = $db->prepare("UPDATE modul_yorum_ayar SET
                                             blog_durum=:blog_durum,
                                            hizmet_durum=:hizmet_durum,
                                            yorumlimit=:yorumlimit,
                                            oto_onay=:oto_onay,
                                            tumu_button_bg=:tumu_button_bg,
                                            gonder_button_bg=:gonder_button_bg   
                                 WHERE id='1'      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'blog_durum' => $_POST['blog_durum'],
                                'hizmet_durum' => $_POST['hizmet_durum'],
                                'yorumlimit' => $_POST['yorumlimit'],
                                'oto_onay' => $_POST['oto_onay'],
                                'tumu_button_bg' => $_POST['tumu_button_bg'],
                                'gonder_button_bg' => $_POST['gonder_button_bg']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page='.$_SESSION['modul_comment_url'].'');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page='.$_SESSION['modul_comment_url'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /* Comment ico Delete */
            if($_GET['status'] == 'delete'  ) {
                    $noSorgusu = $db->prepare("select * from modul_yorum_ayar where id='1' ");
                    $noSorgusu->execute();
                    $noRow = $noSorgusu->fetch(PDO::FETCH_ASSOC);
                    if($noSorgusu->rowCount()>'0'  ) {

                        $guncelle = $db->prepare("UPDATE modul_yorum_ayar SET
                            gorsel=:gorsel    
                         WHERE id='1'      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'gorsel' => null,
                        ));
                        if($sonuc){
                            unlink('../images/uploads/'.$noRow['gorsel'].'');
                            header('Location:'.$ayar['panel_url'].'pages.php?page='.$_SESSION['modul_comment_url'].'');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }

                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page='.$_SESSION['modul_comment_url'].'');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }
            }
            /*  <========SON=========>>> Comment ico Delete SON */


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