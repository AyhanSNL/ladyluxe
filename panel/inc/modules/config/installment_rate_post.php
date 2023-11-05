<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'month_add' ||  $_GET['status'] == 'month_edit' || $_GET['status'] == 'month_delete' || $_GET['status'] == 'edit' || $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete'  ) {


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
                        $target = "../images/ccards/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                            if($_POST['baslik']  ) {
                                $gitti = move_uploaded_file($kaynak, $target);
                                $kaydet = $db->prepare("INSERT INTO taksit_kart SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  durum=:durum,
                                  sira=:sira
                                ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'durum' => '1',
                                    'sira' => '0'
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'month_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    $kaydet = $db->prepare("INSERT INTO taksit_kart_ay SET
                      ay=:ay,      
                      vade_oran=:vade_oran,
                      durum=:durum,
                      sira=:sira,
                      kart_id=:kart_id
                    ");
                    $sonuc = $kaydet->execute(array(
                        'ay' => $_POST['ay'],
                        'vade_oran' => $_POST['vade_oran'],
                        'durum' => '1',
                        'sira' => '0',
                        'kart_id' => $_POST['kart_id']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=installment_month&no='.$_POST['kart_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
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
                        $target = "../images/ccards/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                            if($_POST['baslik']  ) {
                                $gitti = move_uploaded_file($kaynak, $target);
                                $guncelle = $db->prepare("UPDATE taksit_kart SET
                                  baslik=:baslik,      
                                  gorsel=:gorsel,
                                  durum=:durum,
                                  sira=:sira
                                 WHERE id={$_POST['kart_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'gorsel' => $file_name,
                                    'durum' => $_POST['durum'],
                                    'sira' => $_POST['sira']
                                ));
                                if($sonuc){
                                    if($old_img == !null || isset($old_img) ) {
                                        unlink("../images/ccards/$old_img");
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        $guncelle = $db->prepare("UPDATE taksit_kart SET
                                  baslik=:baslik,      
                                  durum=:durum,
                                  sira=:sira
                                 WHERE id={$_POST['kart_id']}      
                                ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'durum' => $_POST['durum'],
                            'sira' => $_POST['sira']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'month_edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE taksit_kart_ay SET
                      ay=:ay,      
                      vade_oran=:vade_oran,
                      durum=:durum,
                      sira=:sira
                     WHERE id={$_POST['vade_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'ay' => $_POST['ay'],
                        'vade_oran' => $_POST['vade_oran'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=installment_month&no='.$_POST['kart_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Status Update SON */


            /* Delete */
            if($_GET['status'] == 'month_delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {
                    $cek = $db->prepare("select * from taksit_kart_ay where id='$_GET[no]' ");
                    $cek->execute();
                    $r = $cek->fetch(PDO::FETCH_ASSOC);
                 $silmeislem = $db->prepare("DELETE from taksit_kart_ay WHERE id=:id");
                 $silmeislemSuccess = $silmeislem->execute(array(
                    'id' => $_GET['no']
                 ));
                 if ($silmeislemSuccess) {
                     $_SESSION['main_alert'] = 'success';
                     header('Location:'.$ayar['panel_url'].'pages.php?page=installment_month&no='.$r['kart_id'].'');
                 }else {
                     echo 'veritabanı hatası';
                 }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from taksit_kart where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../images/ccards/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from taksit_kart WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {

                            /* taksitleri sil */
                            $silmeislem = $db->prepare("DELETE from taksit_kart_ay WHERE kart_id=:kart_id");
                            $silOk = $silmeislem->execute(array(
                                'kart_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> taksitleri sil SON */

                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                        }else {
                            echo 'veritabanı hatası';
                        }
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
                        $sorgu = $db->prepare("select * from taksit_kart where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                            unlink('../images/ccards/'.$row['gorsel'].'');
                            $silmeislem = $db->prepare("DELETE from taksit_kart WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                            /* taksitleri sil */
                            $silmeislem = $db->prepare("DELETE from taksit_kart_ay WHERE kart_id=:kart_id");
                            $silOk = $silmeislem->execute(array(
                                'kart_id' => $idler
                            ));
                            /*  <========SON=========>>> taksitleri sil SON */
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=installment_rate');
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