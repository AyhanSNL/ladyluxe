<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'numbers_add' || $_GET['status'] == 'numbers_multidelete' || $_GET['status'] == 'numbers_delete' || $_GET['status'] == 'numbers_edit' || $_GET['status'] == 'sms_post') {

            $timestamp = date('Y-m-d G:i:s');


            /* SMS Post */
            if($_GET['status'] == 'sms_post'  ) {
                if ($_POST && isset($_POST['smsPost'])) {
                    if($sms['durum'] == '1' ) {
                        if($_POST['icerik']) {
                            if($_POST['gsm_select'] == '0' || $_POST['gsm_select'] == '1'  ) {

                                if($_POST['gsm_select'] == '0'  ) {
                                    /* Tüm numaralara Gönder */
                                    if ($sms['sms_firma'] == 'iletimerkezi') {
                                        /* İleti Merkezi */
                                        $iletibaslik = $sms['iletimerkezi_baslik'];
                                        $iletiuser = $sms['iletimerkezi_user'];
                                        $iletipass = $sms['iletimerkezi_pass'];
                                        $mesaj_icerik = $_POST['icerik'];
                                        $allNumbers = $db->prepare("select * from sms_numaralar ");
                                        $allNumbers->execute();
                                        foreach ($allNumbers as $num) {
                                            $topluno.='<number>'.$num['gsm'].'</number>';
                                        }
                                        function sendRequest($site_name, $send_xml, $header_type)
                                        {

                                            //die('SITENAME:'.$site_name.'SEND XML:'.$send_xml.'HEADER TYPE '.var_export($header_type,true));
                                            $ch = curl_init();
                                            curl_setopt($ch, CURLOPT_URL, $site_name);
                                            curl_setopt($ch, CURLOPT_POST, 1);
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $send_xml);
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_type);
                                            curl_setopt($ch, CURLOPT_HEADER, 0);
                                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                                            curl_setopt($ch, CURLOPT_TIMEOUT, 120);

                                            $result = curl_exec($ch);

                                            return $result;
                                        }

                                        $username = $iletiuser;
                                        $password = $iletipass;
                                        $orgin_name = $iletibaslik;

                                        $xml = <<<EOS
                                             <request>
                                                 <authentication>
                                                     <username>{$username}</username>
                                                     <password>{$password}</password>
                                                 </authentication>
                                    
                                                 <order>
                                                     <sender>{$orgin_name}</sender>
                                                     <sendDateTime>01/05/2013 18:00</sendDateTime>
                                                     <message>
                                                         <text>{$mesaj_icerik}</text>
                                                         <receipents>
                                                             $topluno
                                                         </receipents>
                                                     </message>
                                                 </order>
                                            
                                             </request>

EOS;
                                        $result = sendRequest('http://api.iletimerkezi.com/v1/send-sms', $xml, array('Content-Type: text/xml'));
                                            $_SESSION['main_alert'] = 'success';
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=multi_sms');
                                    }

                                    if ($sms['sms_firma'] == 'netgsm') {
                                        /* NEtgsm */
                                        $allNumbers = $db->prepare("select * from sms_numaralar ");
                                        $allNumbers->execute();
                                        foreach ($allNumbers as $num) {
                                            $topluno.=''.$num['gsm'].',';
                                        }
                                        $mesaj_icerik = $_POST['icerik'];
                                        function sendsms($msg, $telno, $header, $username, $pass)
                                        {


                                            $startdate = date('d.m.Y H:i');
                                            $startdate = str_replace('.', '', $startdate);
                                            $startdate = str_replace(':', '', $startdate);
                                            $startdate = str_replace(' ', '', $startdate);

                                            $stopdate = date('d.m.Y H:i', strtotime('+1 day'));
                                            $stopdate = str_replace('.', '', $stopdate);
                                            $stopdate = str_replace(':', '', $stopdate);
                                            $stopdate = str_replace(' ', '', $stopdate);


                                            $url = "http://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=$telno&message=$msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
                                            //echo $url;

                                            $ch = curl_init();
                                            curl_setopt($ch, CURLOPT_URL, $url);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
                                            $output = curl_exec($ch);
                                            curl_close($ch);
                                            return $output;

                                        }


                                        $usa = $sms['netgsm_user'];
                                        $paso = $sms['netgsm_pass'];

                                        $mesaj = $mesaj_icerik;
                                        $tel = $topluno;
                                        $baslik = $sms['netgsm_baslik'];


                                        $mesaj = html_entity_decode($mesaj, ENT_COMPAT, "UTF-8");
                                        $mesaj = rawurlencode($mesaj);


                                        $baslik = html_entity_decode($baslik, ENT_COMPAT, "UTF-8");
                                        $baslik = rawurlencode($baslik);


                                        sendsms($mesaj, $tel, $baslik, $usa, $paso);

                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=multi_sms');
                                    }
                                }else{
                                    /* Sadece Seçililere Gönder */
                                    if ($sms['sms_firma'] == 'iletimerkezi') {
                                        /* İleti Merkezi */
                                        $iletibaslik = $sms['iletimerkezi_baslik'];
                                        $iletiuser = $sms['iletimerkezi_user'];
                                        $iletipass = $sms['iletimerkezi_pass'];
                                        $mesaj_icerik = $_POST['icerik'];
                                        $allNumbers = $_POST['gsm'];
                                        foreach ($allNumbers as $num) {
                                            $topluno.='<number>'.$num.'</number>';
                                        }
                                        function sendRequest($site_name, $send_xml, $header_type)
                                        {

                                            //die('SITENAME:'.$site_name.'SEND XML:'.$send_xml.'HEADER TYPE '.var_export($header_type,true));
                                            $ch = curl_init();
                                            curl_setopt($ch, CURLOPT_URL, $site_name);
                                            curl_setopt($ch, CURLOPT_POST, 1);
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $send_xml);
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header_type);
                                            curl_setopt($ch, CURLOPT_HEADER, 0);
                                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                                            curl_setopt($ch, CURLOPT_TIMEOUT, 120);

                                            $result = curl_exec($ch);

                                            return $result;
                                        }

                                        $username = $iletiuser;
                                        $password = $iletipass;
                                        $orgin_name = $iletibaslik;

                                        $xml = <<<EOS
                                             <request>
                                                 <authentication>
                                                     <username>{$username}</username>
                                                     <password>{$password}</password>
                                                 </authentication>
                                    
                                                 <order>
                                                     <sender>{$orgin_name}</sender>
                                                     <sendDateTime>01/05/2013 18:00</sendDateTime>
                                                     <message>
                                                         <text>{$mesaj_icerik}</text>
                                                         <receipents>
                                                             $topluno
                                                         </receipents>
                                                     </message>
                                                 </order>
                                            
                                             </request>

EOS;
                                        $result = sendRequest('http://api.iletimerkezi.com/v1/send-sms', $xml, array('Content-Type: text/xml'));
                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=multi_sms');
                                    }

                                    if ($sms['sms_firma'] == 'netgsm') {
                                        /* NEtgsm */
                                       $allNumbers = $_POST['gsm'];
                                        foreach ($allNumbers as $num) {
                                            $topluno.=''.$num.',';
                                        }
                                        $mesaj_icerik = $_POST['icerik'];
                                        function sendsms($msg, $telno, $header, $username, $pass)
                                        {


                                            $startdate = date('d.m.Y H:i');
                                            $startdate = str_replace('.', '', $startdate);
                                            $startdate = str_replace(':', '', $startdate);
                                            $startdate = str_replace(' ', '', $startdate);

                                            $stopdate = date('d.m.Y H:i', strtotime('+1 day'));
                                            $stopdate = str_replace('.', '', $stopdate);
                                            $stopdate = str_replace(':', '', $stopdate);
                                            $stopdate = str_replace(' ', '', $stopdate);


                                            $url = "http://api.netgsm.com.tr/bulkhttppost.asp?usercode=$username&password=$pass&gsmno=$telno&message=$msg&msgheader=$header&startdate=$startdate&stopdate=$stopdate";
                                            //echo $url;

                                            $ch = curl_init();
                                            curl_setopt($ch, CURLOPT_URL, $url);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  curl_setopt($ch,CURLOPT_HEADER, false);
                                            $output = curl_exec($ch);
                                            curl_close($ch);
                                            return $output;

                                        }


                                        $usa = $sms['netgsm_user'];
                                        $paso = $sms['netgsm_pass'];

                                        $mesaj = $mesaj_icerik;
                                        $tel = $topluno;
                                        $baslik = $sms['netgsm_baslik'];


                                        $mesaj = html_entity_decode($mesaj, ENT_COMPAT, "UTF-8");
                                        $mesaj = rawurlencode($mesaj);


                                        $baslik = html_entity_decode($baslik, ENT_COMPAT, "UTF-8");
                                        $baslik = rawurlencode($baslik);


                                        sendsms($mesaj, $tel, $baslik, $usa, $paso);

                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=multi_sms');
                                    }
                                }

                            } else{
                                $_SESSION['main_alert'] = 'zorunlu';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=multi_sms');
                            }
                        }else{
                            $_SESSION['main_alert'] = 'zorunlu';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=multi_sms');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'smsoff';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=multi_sms');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> SMS Post SON */


            /*  Add */
            if($_GET['status'] == 'numbers_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['isim'] && $_POST['gsm'] )  {
                        if(strlen($_POST['gsm']) >= 10  ) {

                             $SMSSorgu = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                             $SMSSorgu->execute(array(
                                 'gsm' => $_POST['gsm'],
                             ));

                             if($SMSSorgu->rowCount()<=''  ) {
                                 $kaydet = $db->prepare("INSERT INTO sms_numaralar SET
                                     isim=:isim,   
                                     gsm=:gsm
                                            ");
                                 $sonuc = $kaydet->execute(array(
                                     'isim' => $_POST['isim'],
                                     'gsm' => $_POST['gsm']
                                 ));
                                 if($sonuc){
                                     $_SESSION['main_alert'] = 'success';
                                     header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                                 }else{
                                     echo 'Veritabanı Hatası';
                                 }
                             }else{
                                 $_SESSION['main_alert'] = 'gsmvar';
                                 header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                             }

                        }else{
                            $_SESSION['main_alert'] = 'gsmuzunluk';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  Edit */
            if($_GET['status'] == 'numbers_edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if($_POST['isim'] && $_POST['gsm']) {
                        if(strlen($_POST['gsm']) >= 10 ){

                            $asilCek = $db->prepare("select * from sms_numaralar where id=:id and gsm=:gsm ");
                            $asilCek->execute(array(
                                'id' => $_POST['gsm_id'],
                                'gsm' => trim(strip_tags($_POST['gsm']))
                            ));
                            $row = $asilCek->fetch(PDO::FETCH_ASSOC);
                            if($asilCek->rowCount()>'0'  ) {
                                $guncelle = $db->prepare("UPDATE sms_numaralar SET
                                     isim=:isim,
                                     gsm=:gsm   
                                 WHERE id={$_POST['gsm_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'isim' => $_POST['isim'],
                                    'gsm' => $_POST['gsm']
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                $listCehck = $db->prepare("select * from sms_numaralar where gsm=:gsm ");
                                $listCehck->execute(array(
                                    'gsm' => trim(strip_tags($_POST['gsm'])),
                                ));

                                if($row['gsm'] != $_POST['gsm']  ) {
                                    if($listCehck->rowCount()<='0'  ) {
                                        $guncelle = $db->prepare("UPDATE sms_numaralar SET
                                     gsm=:gsm   
                                 WHERE id={$_POST['gsm_id']}      
                                ");
                                        $sonuc = $guncelle->execute(array(
                                            'gsm' => trim(strip_tags($_POST['gsm']))
                                        ));
                                        if($sonuc){
                                            $_SESSION['main_alert'] = 'success';
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                    }else{
                                        $_SESSION['main_alert'] = 'gsmvar';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                                    }
                                }


                            }
                        }else{
                            $_SESSION['main_alert'] = 'gsmuzunluk';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /*  delete */
            if($_GET['status'] == 'numbers_delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from sms_numaralar where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from sms_numaralar WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */

            /* Multi Delete */
            if($_GET['status'] == 'numbers_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from sms_numaralar where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from sms_numaralar WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
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