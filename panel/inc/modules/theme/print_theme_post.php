<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'invoice_add' || $_GET['status'] == 'delete' || $_GET['status'] == 'invoice_edit' || $_GET['status'] == 'bg_delete'){

           /* Sablon ADd */
            if($_GET['status'] == 'invoice_add'  ) {
                if($_POST && isset($_POST['invoiceAdd'])  ) {

                    if ($_FILES['arkaplan']["size"] > 0) {
                        $file_format = $_FILES["arkaplan"];
                        $kaynak = $_FILES["arkaplan"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['arkaplan']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['arkaplan']['name']));
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
                        $target = "../i/uploads/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  ) {
                            if($_POST['baslik'] && $_POST['width'] && $_POST['height']  ) {
                                $gitti = move_uploaded_file($kaynak, $target);

                                if($_POST['varsayilan'] == '1'  ) {
                                    $guncelle = $db->prepare("UPDATE print_tema SET
                                             varsayilan=:varsayilan
                                      WHERE modul='invoice'      
                                     ");
                                    $sonuc = $guncelle->execute(array(
                                        'varsayilan' => '0',
                                    ));
                                }
                                $kaydet = $db->prepare("INSERT INTO print_tema SET
                                            baslik=:baslik,
                                            arkaplan=:arkaplan,
                                            width=:width,
                                            height=:height,
                                            modul=:modul,
                                            varsayilan=:varsayilan
                                            ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'arkaplan' => $file_name,
                                    'width' => $_POST['width'],
                                    'height' => $_POST['height'],
                                    'modul' => 'invoice',
                                    'varsayilan' => $_POST['varsayilan']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                      /* Görsel yoksa */
                        if($_POST['varsayilan'] == '1'  ) {
                            $guncelle = $db->prepare("UPDATE print_tema SET
                                             varsayilan=:varsayilan
                                      WHERE modul='invoice'      
                                     ");
                            $sonuc = $guncelle->execute(array(
                                'varsayilan' => '0',
                            ));
                        }
                        $kaydet = $db->prepare("INSERT INTO print_tema SET
                                            baslik=:baslik,
                                            width=:width,
                                            height=:height,
                                            modul=:modul,
                                            varsayilan=:varsayilan
                                            ");
                        $sonuc = $kaydet->execute(array(
                            'baslik' => $_POST['baslik'],
                            'width' => $_POST['width'],
                            'height' => $_POST['height'],
                            'modul' => 'invoice',
                            'varsayilan' => $_POST['varsayilan']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                      /*  <========SON=========>>> Görsel yoksa SON */
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Sablon ADd SON */

            /* Invoice Edit */
            if($_GET['status'] == 'invoice_edit'  ) {
                if($_POST && isset($_POST['invoiceEdit'])  ) {

                    if ($_FILES['arkaplan']["size"] > 0) {
                        $file_format = $_FILES["arkaplan"];
                        $kaynak = $_FILES["arkaplan"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['arkaplan']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['arkaplan']['name']));
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
                        $target = "../i/uploads/" . $file_name;

                        if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png'  ) {
                            if($_POST['baslik'] && $_POST['width'] && $_POST['height']  ) {
                                $gitti = move_uploaded_file($kaynak, $target);

                                if($_POST['varsayilan'] == '1'  ) {
                                    $guncelle = $db->prepare("UPDATE print_tema SET
                                             varsayilan=:varsayilan
                                      WHERE modul='invoice'      
                                     ");
                                    $sonuc = $guncelle->execute(array(
                                        'varsayilan' => '0',
                                    ));
                                }
                                $guncelle = $db->prepare("UPDATE print_tema SET
                                              baslik=:baslik,
                                            arkaplan=:arkaplan,
                                            width=:width,
                                            kod=:kod,
                                            height=:height,
                                            varsayilan=:varsayilan  
                                 WHERE id={$_POST['themeId']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'arkaplan' => $file_name,
                                    'width' => $_POST['width'],
                                    'kod' => htmlspecialchars($_POST['kod']),
                                    'height' => $_POST['height'],
                                    'varsayilan' => $_POST['varsayilan']
                                ));
                                if($sonuc){
                                    if($_POST['old_img'] == !null  ) {
                                        unlink('../i/uploads/'.$_POST['old_img'].'');
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice&theme='.$_POST['themeId'].'');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice&theme='.$_POST['themeId'].'');
                                $_SESSION['main_alert'] = 'zorunlu';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice&theme='.$_POST['themeId'].'');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        /* Görsel yoksa */
                        if($_POST['varsayilan'] == '1'  ) {
                            $guncelle = $db->prepare("UPDATE print_tema SET
                                             varsayilan=:varsayilan
                                      WHERE modul='invoice'      
                                     ");
                            $sonuc = $guncelle->execute(array(
                                'varsayilan' => '0',
                            ));
                        }
                        $guncelle = $db->prepare("UPDATE print_tema SET
                                              baslik=:baslik,
                                              kod=:kod,
                                              kod_duz=:kod_duz,
                                            width=:width,
                                            height=:height,
                                            varsayilan=:varsayilan  
                                 WHERE id={$_POST['themeId']}      
                                ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'kod' => htmlspecialchars ($_POST['kod']),
                            'kod_duz' => $_POST['kod'],
                            'width' => $_POST['width'],
                            'height' => $_POST['height'],
                            'varsayilan' => $_POST['varsayilan']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice&theme='.$_POST['themeId'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                        /*  <========SON=========>>> Görsel yoksa SON */
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Invoice Edit SON */



            /* for Delete */
            if($_GET['status'] == 'delete' && isset($_GET['no']) && $_GET['no']>'0' ) {
                $sorgu = $db->prepare("select * from print_tema where id='$_GET[no]' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink('../i/uploads/'.$row['arkaplan'].'');
                $guncelle = $db->prepare("UPDATE print_tema SET
                            arkaplan=:arkaplan
                     WHERE id='$_GET[no]'     
                    ");
                $sonuc = $guncelle->execute(array(
                    'arkaplan' => null,
                ));
                if($sonuc){
                    $silmeislem = $db->prepare("DELETE from print_tema WHERE id=:id");
                    $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            if($_GET['status'] == 'bg_delete' && isset($_GET['no']) && $_GET['no']>'0' ) {
                $sorgu = $db->prepare("select * from print_tema where id='$_GET[no]' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink('../i/uploads/'.$row['arkaplan'].'');
                $guncelle = $db->prepare("UPDATE print_tema SET
                            arkaplan=:arkaplan
                     WHERE id='$_GET[no]'     
                    ");
                $sonuc = $guncelle->execute(array(
                    'arkaplan' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_print_invoice&theme='.$_GET['no'].'');
                    $_SESSION['collepse_status'] ='setAcc';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> for Delete SON */

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