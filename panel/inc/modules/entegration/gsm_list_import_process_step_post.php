<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'import') {
            if($_GET['status'] == 'import'  ) {
                if ($_POST && isset($_POST['sync']) && $_POST['xml_id'] && $_POST['anatag'] && $_POST['gsmtag'] && $_POST['dosya']) {
                   $dosya = $_POST['dosya'];
                   $anatag = $_POST['anatag'];
                   $gsmtag = $_POST['gsmtag'];
                   $isim = $_POST['isimtag'];
                   $xml_file = simplexml_load_file('inc/input/gsm/'.$dosya.'');
                    if($xml_file) {
                        $guncelle = $db->prepare("UPDATE gsm_import SET
                                   durum=:durum
                               WHERE id={$_POST['xml_id']}      
                              ");
                        $sonuc = $guncelle->execute(array(
                            'durum' => '1'
                        ));
                        $timestamp = date('Y-m-d G:i:s');
                        foreach ($xml_file->$anatag as $i){
                            $kaydet = $db->prepare("INSERT INTO sms_numaralar SET
                                      gsm=:gsm,
                                      isim=:isim,
                                      xml_id=:xml_id
                              ");
                            $sonuc = $kaydet->execute(array(
                                'gsm' => $i->$gsmtag,
                                'isim' => $i->$isim,
                                'xml_id' => $_POST['xml_id']
                            ));
                        }
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=gsm_list_import');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
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