<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'import' || $_GET['status'] == 'delete'  || $_GET['status'] == 'file_edit' || $_GET['status'] == 'data_multidelete') {
            $timestamp = date('Y-m-d G:i:s');

            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {
                    $itemControl = $db->prepare("select * from urun_import where id=:id ");
                    $itemControl->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($itemControl->rowCount()>'0'  ) {
                        $itemRow = $itemControl->fetch(PDO::FETCH_ASSOC);
                        unlink('inc/input/product/'.$itemRow['dosya'].'');
                        $silmeislem = $db->prepare("DELETE from urun_import WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            if($_GET['type'] == 'all' ) {
                                $xmlurunukontrol = $db->prepare("select * from urun where xml_id=:xml_id ");
                                $xmlurunukontrol->execute(array(
                                    'xml_id' => $_GET['no']
                                ));
                                foreach ($xmlurunukontrol as $row){
                                    /* varyantlar silinsin */
                                    $silmeislem = $db->prepare("DELETE from detay_varyant WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    $silmeislem = $db->prepare("DELETE from detay_varyant_ozellik WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> varyantlar silinsin SON */

                                    /* Detay Benzer Ürünler Sil */
                                    $silmeislem = $db->prepare("DELETE from urundetay_benzer_urun WHERE detay_id=:detay_id");
                                    $sil = $silmeislem->execute(array(
                                        'detay_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Detay Benzer Ürünler Sil SON */

                                    /* Favorilerden Sil */
                                    $silmeislem = $db->prepare("DELETE from urun_favori WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Favorilerden Sil SON */
                                    /* galeri sil */
                                    $galeriListesi = $db->prepare("select * from urun_galeri where urun_id=:urun_id ");
                                    $galeriListesi->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    if($galeriListesi->rowCount()>'0'  ) {
                                        foreach ($galeriListesi as $galerisil){
                                            unlink('../images/product/'.$galerisil['gorsel'].'');
                                            $silmeislem = $db->prepare("DELETE from urun_galeri WHERE urun_id=:urun_id");
                                            $sil = $silmeislem->execute(array(
                                                'urun_id' => $row['id']
                                            ));
                                        }
                                    }
                                    /*  <========SON=========>>> galeri sil SON */

                                    /* Yorum Sil */
                                    $silmeislem = $db->prepare("DELETE from urun_yorum WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Yorum Sil SON */

                                    /* Teknik Özellik Sil */
                                    $silmeislem = $db->prepare("DELETE from filtre_ozellik WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    $silmeislem = $db->prepare("DELETE from filtre_ozellik_grup WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Teknik Özellik Sil SON */

                                    /* Vitrinlerden Sil */
                                    $silmeislem = $db->prepare("DELETE from vitrin_firsat_urunler WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    $silmeislem = $db->prepare("DELETE from vitrin_tip1_urunler WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Vitrinlerden Sil SON */

                                    $silmeislem = $db->prepare("DELETE from urun WHERE id=:id");
                                    $sil = $silmeislem->execute(array(
                                        'id' => $row['id']
                                    ));
                                    if($row['gorsel'] == !null && $row['gorsel'] != 'no-img.jpg' ) {
                                        unlink('../images/product/'.$row['gorsel'].'');
                                        unlink('../images/product/big_photo/'.$row['gorsel'].'');
                                    }
                                }
                            }
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'file_edit' ) {
                if ($_POST && isset($_POST['editDo']) && $_POST['upload_type'] && $_POST['file_id'] ) {
                    if($_POST['upload_type'] == '1' || $_POST['upload_type'] == '2'  ) {
                        $xmlControl = $db->prepare("select * from urun_import where id=:id ");
                        $xmlControl->execute(array(
                            'id' => $_POST['file_id']
                        ));
                        if($xmlControl->rowCount()>'0'  ) {
                            $xmlRow = $xmlControl->fetch(PDO::FETCH_ASSOC);
                            $dosyaAdi = $xmlRow['dosya'];
                            if($_POST['upload_type'] == '1'  ) {
                                if($_FILES['dosya']["size"]  ) {
                                    $file_format = $_FILES["dosya"];
                                    $kaynak = $_FILES["dosya"]["tmp_name"];
                                    $target = 'inc/input/product/'.$dosyaAdi.'';
                                    if ($file_format['type'] == 'text/xml' ) {
                                        unlink('inc/input/product/'.$xmlRow['dosya'].'');
                                        $gitti = move_uploaded_file($kaynak, $target);
                                        $guncelle = $db->prepare("UPDATE urun_import SET
                                                upload_tip=:upload_tip,
                                                dosya_url=:dosya_url,
                                                tarih=:tarih
                                         WHERE id={$xmlRow['id']}      
                                        ");
                                        $sonuc = $guncelle->execute(array(
                                            'upload_tip' => '1',
                                            'dosya_url' => null,
                                            'tarih' => $timestamp
                                        ));
                                        if($sonuc){
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_process&id='.$_POST['file_id'].'');
                                            $_SESSION['main_alert'] = 'success';
                                            exit();
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                    }else{
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_process&id='.$_POST['file_id'].'');
                                        $_SESSION['main_alert'] = 'filetype';
                                        exit();
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_process&id='.$_POST['file_id'].'');
                                    $_SESSION['main_alert'] = 'filesize';
                                    exit();
                                }
                            }
                            if($_POST['upload_type'] == '2'  ) {
                                if($_POST['dosya_url']  ) {
                                    $dosyaURL = $_POST['dosya_url'];
                                    $botName = 'inc/input/product/'.$xmlRow['dosya'].'';
                                    $contents = file_get_contents(''.$dosyaURL.'');
                                    $okay = file_put_contents($botName, $contents);
                                    $guncelle = $db->prepare("UPDATE urun_import SET
                                                upload_tip=:upload_tip,
                                                dosya_url=:dosya_url,
                                                tarih=:tarih
                                         WHERE id={$xmlRow['id']}      
                                        ");
                                    $sonuc = $guncelle->execute(array(
                                        'upload_tip' => '2',
                                        'dosya_url' => $_POST['dosya_url'],
                                        'tarih' => $timestamp
                                    ));
                                    if($sonuc){
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_process&id='.$_POST['file_id'].'');
                                        $_SESSION['main_alert'] = 'success';
                                        exit();
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_process&id='.$_POST['file_id'].'');
                                    $_SESSION['main_alert'] = 'zorunlu';
                                    exit();
                                }
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                            exit();
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'import' ) {
                if ($_POST && isset($_POST['importDo']) && $_POST['upload_type'] ) {
                    if($_POST['upload_type'] == '1' || $_POST['upload_type'] == '2'  ) {
                        $random = rand(0, (int)999999999999123);
                        if($_POST['upload_type'] == '1'  ) {
                            if($_FILES['dosya']["size"]  ) {
                                $file_format = $_FILES["dosya"];
                                $kaynak = $_FILES["dosya"]["tmp_name"];
                                $uzanti = explode(".", $_FILES['dosya']['name']);
                                $file_name = ''.$random.'.xml';
                                $target = "inc/input/product/" . $file_name;
                                if ($file_format['type'] == 'text/xml' ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $kaydet = $db->prepare("INSERT INTO urun_import SET
                                    baslik=:baslik,
                                    dosya=:dosya,
                                    durum=:durum,
                                    tarih=:tarih,
                                    upload_tip=:upload_tip     
                                    ");
                                    $sonuc = $kaydet->execute(array(
                                        'baslik' => $_POST['baslik'],
                                        'dosya' => ''.$random.'.xml',
                                        'durum' => '0',
                                        'tarih' => $timestamp,
                                        'upload_tip' => '1'
                                    ));
                                    if($sonuc){
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                                        $_SESSION['main_alert'] = 'success';
                                        exit();
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                                    $_SESSION['main_alert'] = 'filetype';
                                    exit();
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                                $_SESSION['main_alert'] = 'filesize';
                                exit();
                            }
                        }
                        if($_POST['upload_type'] == '2'  ) {
                            if($_POST['dosya_url']  ) {
                                $dosyaURL = $_POST['dosya_url'];
                                $botName = 'inc/input/product/'.$random.'.xml';
                                $contents = file_get_contents(''.$dosyaURL.'');
                                $okay = file_put_contents($botName, $contents);
                                $kaydet = $db->prepare("INSERT INTO urun_import SET
                                    baslik=:baslik,
                                    dosya=:dosya,
                                    durum=:durum,
                                    tarih=:tarih,
                                    upload_tip=:upload_tip,
                                    dosya_url=:dosya_url     
                                    ");
                                $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                    'dosya' => ''.$random.'.xml',
                                    'durum' => '0',
                                    'tarih' => $timestamp,
                                    'upload_tip' => '2',
                                    'dosya_url' => $dosyaURL
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                                    $_SESSION['main_alert'] = 'success';
                                    exit();
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                                $_SESSION['main_alert'] = 'zorunlu';
                                exit();
                            }
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }


            if($_GET['status'] == 'data_multidelete'  ) {
                if($_POST) {
                    $ID = $_GET['id'];
                    if($ID  ) {
                        if($_POST['sil'] <='0'  ) {
                            $_SESSION['main_alert'] ='nocheck';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_data&id='.$ID.'');
                        }else{
                            $liste = $_POST['sil'];
                            foreach ($liste as $idler){
                                $sorgu = $db->prepare("select * from urun where id='$idler' ");
                                $sorgu->execute();
                                if($sorgu->rowCount()>'0'  ) {
                                    $row = $sorgu->fetch(PDO::FETCH_ASSOC);


                                    /* varyantlar silinsin */
                                    $silmeislem = $db->prepare("DELETE from detay_varyant WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    $silmeislem = $db->prepare("DELETE from detay_varyant_ozellik WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> varyantlar silinsin SON */

                                    /* Detay Benzer Ürünler Sil */
                                    $silmeislem = $db->prepare("DELETE from urundetay_benzer_urun WHERE detay_id=:detay_id");
                                    $sil = $silmeislem->execute(array(
                                        'detay_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Detay Benzer Ürünler Sil SON */

                                    /* Favorilerden Sil */
                                    $silmeislem = $db->prepare("DELETE from urun_favori WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Favorilerden Sil SON */
                                    /* galeri sil */
                                    $galeriListesi = $db->prepare("select * from urun_galeri where urun_id=:urun_id ");
                                    $galeriListesi->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    if($galeriListesi->rowCount()>'0'  ) {
                                        foreach ($galeriListesi as $galerisil){
                                            unlink('../images/product/'.$galerisil['gorsel'].'');
                                            $silmeislem = $db->prepare("DELETE from urun_galeri WHERE urun_id=:urun_id");
                                            $sil = $silmeislem->execute(array(
                                                'urun_id' => $row['id']
                                            ));
                                        }
                                    }
                                    /*  <========SON=========>>> galeri sil SON */

                                    /* Yorum Sil */
                                    $silmeislem = $db->prepare("DELETE from urun_yorum WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Yorum Sil SON */

                                    /* Teknik Özellik Sil */
                                    $silmeislem = $db->prepare("DELETE from filtre_ozellik WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    $silmeislem = $db->prepare("DELETE from filtre_ozellik_grup WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Teknik Özellik Sil SON */

                                    /* Vitrinlerden Sil */
                                    $silmeislem = $db->prepare("DELETE from vitrin_firsat_urunler WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    $silmeislem = $db->prepare("DELETE from vitrin_tip1_urunler WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $row['id']
                                    ));
                                    /*  <========SON=========>>> Vitrinlerden Sil SON */

                                    $silmeislem = $db->prepare("DELETE from urun WHERE id=:id");
                                    $sil = $silmeislem->execute(array(
                                        'id' => $row['id']
                                    ));
                                    if($row['gorsel'] == !null && $row['gorsel'] != 'no-img.jpg' ) {
                                        unlink('../images/product/'.$row['gorsel'].'');
                                        unlink('../images/product/big_photo/'.$row['gorsel'].'');
                                    }

                                }
                            }
                            $_SESSION['main_alert'] ='success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_data&id='.$ID.'');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_data&id='.$ID.'');
                }
            }



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