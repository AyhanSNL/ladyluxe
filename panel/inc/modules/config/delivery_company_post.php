<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'edit' || $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete'  ) {


            /* Status Insert */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
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
                        $target = "../i/cargo/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                          if($_POST['baslik'] ) {
                              $gitti = move_uploaded_file($kaynak, $target);
                              $kaydet = $db->prepare("INSERT INTO kargo_firma SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  takip_url=:takip_url,
                                  sira=:sira,
                                  durum=:durum
                                ");
                              $sonuc = $kaydet->execute(array(
                                  'baslik' => $_POST['baslik'],
                                  'gorsel' => $file_name,
                                  'takip_url' => $_POST['takip_url'],
                                  'sira' => '0',
                                  'durum' => '1'
                              ));
                              if($sonuc){
                                  $_SESSION['main_alert'] = 'success';
                                  header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                              }else{
                                  echo 'Veritabanı Hatası';
                              }
                          }else{
                              header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                              $_SESSION['main_alert'] = 'zorunlu';
                          }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Status Insert SON */



            /* Status Update */
            if($_GET['status'] == 'edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
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
                        $target = "../i/cargo/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                            $gitti = move_uploaded_file($kaynak, $target);
                            $guncelle = $db->prepare("UPDATE kargo_firma SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  takip_url=:takip_url,
                                  sira=:sira,
                                  durum=:durum  
                             WHERE id={$_POST['firma_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'gorsel' => $file_name,
                                'takip_url' => $_POST['takip_url'],
                                'sira' => $_POST['sira'],
                                'durum' => $_POST['durum']
                            ));
                            if($sonuc){
                                if($old_img == !null || isset($old_img) ) {
                                    unlink("../i/cargo/$old_img");
                                }
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                            }else{
                            echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                       /* Görselsiz Update */
                        $guncelle = $db->prepare("UPDATE kargo_firma SET
                                baslik=:baslik,      
                                  takip_url=:takip_url,
                                  sira=:sira,
                                  durum=:durum 
                             WHERE id={$_POST['firma_id']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'takip_url' => $_POST['takip_url'],
                            'sira' => $_POST['sira'],
                            'durum' => $_POST['durum']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                       /*  <========SON=========>>> Görselsiz Update SON */
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Status Update SON */


            /* Delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from kargo_firma where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                     $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                     unlink('../i/cargo/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from kargo_firma WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Delete SON */

            /* Multi Delete */
            if($_GET['status'] == 'multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from kargo_firma where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            unlink('../i/cargo/'.$row['gorsel'].'');


                            $silmeislem = $db->prepare("DELETE from kargo_firma WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
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