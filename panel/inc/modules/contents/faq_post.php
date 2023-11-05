<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'multidelete' || $_GET['status'] == 'edit' ||  $_GET['status'] == 'delete' ||  $_GET['status'] == 'img_delete' ) {

            $timestamp = date('Y-m-d G:i:s');

            /*  Add */
            if($_GET['status'] == 'add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['soru'] && $_POST['sira'] && $_POST['cevap']) {

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

                            if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml'  ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $kaydet = $db->prepare("INSERT INTO sss SET
                                            soru=:soru,    
                                            cevap=:cevap,
                                            gorsel=:gorsel,
                                            dil=:dil,
                                            durum=:durum,
                                            sira=:sira
                                        ");
                                    $sonuc = $kaydet->execute(array(
                                        'soru' => $_POST['soru'],
                                        'cevap' => $_POST['cevap'],
                                        'gorsel' => $file_name,
                                        'dil' => $_SESSION['dil'],
                                        'durum' => $_POST['durum'],
                                        'sira' => $_POST['sira']
                                    ));
                                    if($sonuc){
                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $kaydet = $db->prepare("INSERT INTO sss SET
                                            soru=:soru,    
                                            cevap=:cevap,
                                            dil=:dil,
                                            durum=:durum,
                                            sira=:sira
                                        ");
                            $sonuc = $kaydet->execute(array(
                                'soru' => $_POST['soru'],
                                'cevap' => $_POST['cevap'],
                                'dil' => $_SESSION['dil'],
                                'durum' => $_POST['durum'],
                                'sira' => $_POST['sira']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  Edit */
            if($_GET['status'] == 'edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_POST['soru'] && $_POST['sira'] && $_POST['faq_id'] && $_POST['cevap'] ) {

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

                            if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml'  ) {
                                $gitti = move_uploaded_file($kaynak, $target);
                                $guncelle = $db->prepare("UPDATE sss SET
                                           soru=:soru,    
                                           gorsel=:gorsel,
                                            cevap=:cevap,
                                            durum=:durum,
                                            sira=:sira
                         WHERE id={$_POST['faq_id']}      
                        ");
                                $sonuc = $guncelle->execute(array(
                                    'soru' => $_POST['soru'],
                                    'gorsel' => $file_name,
                                    'cevap' => $_POST['cevap'],
                                    'durum' => $_POST['durum'],
                                    'sira' => $_POST['sira']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            $guncelle = $db->prepare("UPDATE sss SET
                                                soru=:soru,    
                                            cevap=:cevap,
                                            durum=:durum,
                                            sira=:sira
                         WHERE id={$_POST['faq_id']}      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'soru' => $_POST['soru'],
                                'cevap' => $_POST['cevap'],
                                'durum' => $_POST['durum'],
                                'sira' => $_POST['sira']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /*  delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from sss where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../images/uploads/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from sss WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */
            
            /* IMG Delete */
            if($_GET['status'] == 'img_delete'  ) {
                $sorgu = $db->prepare("select * from sss where id='$_GET[no]' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink('../images/uploads/'.$row['gorsel'].'');
                $guncelle = $db->prepare("UPDATE sss SET
                            gorsel=:gorsel
                     WHERE id='$_GET[no]'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'gorsel' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> IMG Delete SON */

            /* Multi Delete */
            if($_GET['status'] == 'multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from sss where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            unlink('../images/uploads/'.$row['gorsel'].'');

                            $silmeislem = $db->prepare("DELETE from sss WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=faq');
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