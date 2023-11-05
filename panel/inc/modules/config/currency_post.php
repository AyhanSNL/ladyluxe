<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'edit' || $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete' || $_GET['status'] == 'currency_auto'  ) {
            $timestamp = date('Y-m-d G:i:s');


            /* Status Insert */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {

                    if($_POST['deger'] == !null  ) {
                     $deger = $_POST['deger'];
                    }else{
                        $deger = '1';
                    }

                    $kaydet = $db->prepare("INSERT INTO para_birimleri SET
                      son_guncel=:son_guncel,      
                      baslik=:baslik,
                      kod=:kod,
                      sol_simge=:sol_simge,
                      sag_simge=:sag_simge,
                      simge_gosterim=:simge_gosterim,
                      deger=:deger,
                      para_format=:para_format,
                      varsayilan=:varsayilan,
                      bozuk_para=:bozuk_para,
                      durum=:durum,
                      sira=:sira
                    ");
                    $sonuc = $kaydet->execute(array(
                        'son_guncel' => $timestamp,
                        'baslik' => $_POST['baslik'],
                        'kod' => $_POST['kod'],
                        'sol_simge' => $_POST['sol_simge'],
                        'sag_simge' => $_POST['sag_simge'],
                        'simge_gosterim' => $_POST['simge_gosterim'],
                        'deger' => $deger,
                        'para_format' => $_POST['para_format'],
                        'varsayilan' => '0',
                        'bozuk_para' => $_POST['bozuk_para'],
                        'durum' => '1',
                        'sira' => '0'
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=currency');
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
                    $var = $_POST['varsayilan'];
                    if($var == '1'  ) {
                        $guncelle = $db->prepare("UPDATE para_birimleri SET
                                           varsayilan=:varsayilan 
                                    ");
                        $sonuc = $guncelle->execute(array(
                            'varsayilan' => '0'
                        ));
                    }
                    if($_POST['deger'] == !null  ) {
                        $deger = $_POST['deger'];
                    }else{
                        $deger = '1';
                    }
                    $guncelle = $db->prepare("UPDATE para_birimleri SET
                      son_guncel=:son_guncel,      
                      baslik=:baslik,
                      kod=:kod,
                      sol_simge=:sol_simge,
                      sag_simge=:sag_simge,
                      simge_gosterim=:simge_gosterim,
                      deger=:deger,
                      para_format=:para_format,
                      varsayilan=:varsayilan,
                      bozuk_para=:bozuk_para,
                      durum=:durum,
                      sira=:sira
                     WHERE id={$_POST['para_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'son_guncel' => $timestamp,
                        'baslik' => $_POST['baslik'],
                        'kod' => $_POST['kod'],
                        'sol_simge' => $_POST['sol_simge'],
                        'sag_simge' => $_POST['sag_simge'],
                        'simge_gosterim' => $_POST['simge_gosterim'],
                        'deger' => $deger,
                        'para_format' => $_POST['para_format'],
                        'varsayilan' => $var,
                        'bozuk_para' => $_POST['bozuk_para'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=currency');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Status Update SON */


            /* Delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {
                    $silmeislem = $db->prepare("DELETE from para_birimleri WHERE id=:id");
                    $silmeislemSuccess = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($silmeislemSuccess) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=currency');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Delete SON */


            /* Auto Bot */
            if($_GET['status'] == 'currency_auto'  ) {

                $botName = 'assets/xml/currency.xml';
                $contents = file_get_contents('http://www.tcmb.gov.tr/kurlar/today.xml');
                $okay = file_put_contents($botName, $contents);

                if($okay) {

                    $paraBirimleri = $db->prepare("select * from para_birimleri where durum='1' ");
                    $paraBirimleri->execute();
                    $xmlDosya = simplexml_load_file("assets/xml/currency.xml");

                    foreach ($paraBirimleri as $para){
                        foreach($xmlDosya as  $xmlRow)
                        {
                            if($para['kod'] == $xmlRow['CurrencyCode'] ) {
                                $kod = $xmlRow['CurrencyCode'];

                                $guncelle = $db->prepare("UPDATE para_birimleri SET
                                        son_guncel=:son_guncel,
                                        deger=:deger
                                 WHERE id={$para['id']}   
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'son_guncel' => $timestamp,
                                    'deger' => $xmlRow->ForexSelling
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=currency');
                                }else{
                                echo 'Veritabanı Hatası';
                                }

                            }
                        }
                    }

                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=currency');
                }


            }
            /*  <========SON=========>>> Auto Bot SON */

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