<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'import' || $_GET['status'] == 'delete'  ) {

            $timestamp = date('Y-m-d G:i:s');

            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $itemControl = $db->prepare("select * from gsm_import where id=:id ");
                    $itemControl->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($itemControl->rowCount()>'0'  ) {
                        $itemRow = $itemControl->fetch(PDO::FETCH_ASSOC);
                        unlink('inc/input/gsm/'.$itemRow['dosya'].'');
                        $silmeislem = $db->prepare("DELETE from gsm_import WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            if($_GET['type'] == 'all' ) {
                                $dataValueDelete = $db->prepare("DELETE from 	sms_numaralar WHERE xml_id=:xml_id");
                                $dataValueDelete->execute(array(
                                    'xml_id' => $_GET['no']
                                ));
                            }
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=gsm_list_import');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=gsm_list_import');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }


            if($_GET['status'] == 'import'  ) {
                if ($_POST && isset($_POST['importDo'])) {
                    if ($_FILES['dosya']["size"] > 0) {
                        $file_format = $_FILES["dosya"];
                        $kaynak = $_FILES["dosya"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['dosya']['name']);
                        $random = rand(0, (int)999999999999123);
                        $file_name = ''.$random.'.xml';
                        $target = "inc/input/gsm/" . $file_name;

                        if ($file_format['type'] == 'text/xml' ) {
                            $gitti = move_uploaded_file($kaynak, $target);
                                    $kaydet = $db->prepare("INSERT INTO gsm_import SET
                                    baslik=:baslik,
                                    dosya=:dosya,
                                    durum=:durum,
                                    tarih=:tarih      
                            ");
                            $sonuc = $kaydet->execute(array(
                                'baslik' => $_POST['baslik'],
                                'dosya' => ''.$random.'.xml',
                                'durum' => '0',
                                'tarih' => $timestamp
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=gsm_list_import');
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=gsm_list_import');
                            $_SESSION['main_alert'] = 'filetype';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=gsm_list_import');
                        $_SESSION['main_alert'] = 'filesize';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
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