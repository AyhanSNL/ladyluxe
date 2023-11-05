<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'order_export' || $_GET['status'] == 'email_list_export' || $_GET['status'] == 'gsm_list_export' ) {

            if($_GET['status'] == 'gsm_list_export'  ) {
                if($_POST) {
                    if($_POST['sms_limit'] >'0' ) {

                        $limit = trim(strip_tags($_POST['sms_limit']));

                        $gsmList = $db->prepare("select * from sms_numaralar order by id desc limit $limit ");
                        $gsmList->execute();

                        $rand = rand(0,(int) 99999999);
                        include 'inc/modules/export/gsm/xml-temp.php';
                        $uploads_dir = '/../../output/gsm/';
                        $dosyaName = ''.$rand.'-gsmNumbersOutput';
                        $uzanti = ".xml";

                        $dosya = fopen(__DIR__ . "$uploads_dir$dosyaName$uzanti", "a");
                        $yaz = fwrite($dosya, $xml_Content);

                        if($yaz) {
                            $file = 'inc/output/gsm/'.$dosyaName.'.xml';
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename='.basename($file));
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            header('Content-Length: ' . filesize($file));
                            ob_clean();
                            flush();
                            readfile($file);
                            exit;
                        }


                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }

            }

            if($_GET['status'] == 'email_list_export'  ) {
                if($_POST) {
                    if($_POST['email_limit'] >'0' ) {

                        $limit = trim(strip_tags($_POST['email_limit']));

                        $maiLList = $db->prepare("select * from ebulten order by id desc limit $limit ");
                        $maiLList->execute();

                        $rand = rand(0,(int) 99999999);
                        include 'inc/modules/export/email/xml-temp.php';
                        $uploads_dir = '/../../output/email/';
                        $dosyaName = ''.$rand.'-MailListOutput';
                        $uzanti = ".xml";

                        $dosya = fopen(__DIR__ . "$uploads_dir$dosyaName$uzanti", "a");
                        $yaz = fwrite($dosya, $xml_Content);

                        if($yaz) {
                            $file = 'inc/output/email/'.$dosyaName.'.xml';
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/octet-stream');
                            header('Content-Disposition: attachment; filename='.basename($file));
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
                            header('Content-Length: ' . filesize($file));
                            ob_clean();
                            flush();
                            readfile($file);
                            exit;
                        }


                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }

            }

            if($_GET['status'] == 'order_export'  ) {

                if($_POST) {

                    if($_POST['export_id']) {

                        $orderId = $_POST['export_id'];

                        /* XML Order Export */
                        if(isset($_POST['exportXML'])  ) {

                            $timestamp = date('Y-m-d');
                            $rand = rand(0,(int) 99999999);
                            $date = date_tr('j F Y', ''.$timestamp.'');
                            $datewrite = seo($date);

                            include 'inc/modules/export/order/xml-temp.php';
                            $uploads_dir = '/../../output/order/';
                            $dosyaName = ''.$rand.'-'.$datewrite.'-orderOutput';
                            $uzanti = ".xml";

                            $dosya = fopen(__DIR__ . "$uploads_dir$dosyaName$uzanti", "a");
                            $yaz = fwrite($dosya, $xml_Content);

                            if($yaz) {
                                $file = 'inc/output/order/'.$dosyaName.'.xml';
                                header('Content-Description: File Transfer');
                                header('Content-Type: application/octet-stream');
                                header('Content-Disposition: attachment; filename='.basename($file));
                                header('Content-Transfer-Encoding: binary');
                                header('Expires: 0');
                                header('Cache-Control: must-revalidate');
                                header('Pragma: public');
                                header('Content-Length: ' . filesize($file));
                                ob_clean();
                                flush();
                                readfile($file);
                                exit;
                            }




                        }
                        /*  <========SON=========>>> XML Order Export SON */

                        /* order Multi Delete */
                        if(isset($_POST['multidelete'])  ) {
                            if($_POST['item_id'] == !null  ) {
                               foreach ($_POST['item_id'] as $a){

                                   $siparisCek = $db->prepare("select * from siparisler where id=:id ");
                                   $siparisCek->execute(array(
                                       'id' => $a,
                                   ));
                                   $sipRows = $siparisCek->fetch(PDO::FETCH_ASSOC);

                                   $silmeislem = $db->prepare("DELETE from siparisler WHERE siparis_no=:siparis_no");
                                   $sil = $silmeislem->execute(array(
                                       'siparis_no' => $sipRows['siparis_no']
                                   ));
                                   if($sil) {
                                       $_SESSION['main_alert'] = 'success';
                                       header('Location:'.$ayar['panel_url'].'pages.php?page=orders');

                                       /* Ürünleri sil */
                                       $a = $db->prepare("DELETE from siparis_urunler WHERE siparis_id=:siparis_id");
                                       $a->execute(array(
                                           'siparis_id' => $sipRows['siparis_no']
                                       ));
                                       /*  <========SON=========>>> Ürünleri sil SON */

                                       /* E-Fatura varsa sil */
                                       $fatura = $db->prepare("select * from siparis_fatura where siparis_no=:siparis_no ");
                                       $fatura->execute(array(
                                           'siparis_no' => $sipRows['siparis_no'],
                                       ));
                                       if($fatura->rowCount()>'0'  ) {
                                           $fat = $fatura->fetch(PDO::FETCH_ASSOC);
                                           unlink('../i/invoice/'.$fat['fatura_url'].'');
                                           $fff = $db->prepare("DELETE from siparis_fatura WHERE siparis_no=:siparis_no");
                                           $fff->execute(array(
                                               'siparis_no' => $sipRows['siparis_no']
                                           ));
                                       }
                                       /*  <========SON=========>>> E-Fatura varsa sil SON */

                                       /* sipariş iptal sil */
                                       $b = $db->prepare("DELETE from siparis_iptal WHERE siparis_no=:siparis_no");
                                       $b->execute(array(
                                           'siparis_no' => $sipRows['siparis_no']
                                       ));
                                       /*  <========SON=========>>> sipariş iptal sil SON */

                                       /* İade Talep sil */
                                       $c = $db->prepare("DELETE from siparis_urunler_iade WHERE siparis_no=:siparis_no");
                                       $c->execute(array(
                                           'siparis_no' => $sipRows['siparis_no']
                                       ));
                                       /*  <========SON=========>>> İade Talep sil SON */

                                       /* Parça kargoları sil */
                                       $d = $db->prepare("DELETE from siparis_kargo WHERE siparis_id=:siparis_id");
                                       $d->execute(array(
                                           'siparis_id' => $sipRows['siparis_no']
                                       ));
                                       /*  <========SON=========>>> Parça kargoları sil SON */

                                       /* siparişte varyant varsa sil */
                                       $e = $db->prepare("DELETE from siparis_varyant WHERE siparis_id=:siparis_id");
                                       $e->execute(array(
                                           'siparis_id' => $sipRows['siparis_no']
                                       ));
                                       /*  <========SON=========>>> siparişte varyant varsa sil SON */

                                       /* Notları sil */
                                       $f = $db->prepare("DELETE from operator_not WHERE siparis_no=:siparis_no");
                                       $f->execute(array(
                                           'siparis_no' => $sipRows['siparis_no']
                                       ));
                                       /*  <========SON=========>>> Notları sil SON */
                                   }else {
                                       echo 'veritabanı hatası';
                                   }


                               }
                                header('Location:'.$ayar['panel_url'].'pages.php?page=orders');
                                exit();
                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=orders');
                                exit();
                            }
                        }
                        /*  <========SON=========>>> order Multi Delete SON */



                    }else{
                        header('Location:'.$ayar['site_url'].'404');
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
    header('Location:'.$ayar['panel_url'].'');
    $_SESSION['main_alert'] = 'demo';
}