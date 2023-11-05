<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'account_add' || $_GET['status'] == 'account_multidelete' || $_GET['status'] == 'account_delete' || $_GET['status'] == 'account_edit' || $_GET['status'] == 'mail_post') {

            $timestamp = date('Y-m-d G:i:s');


            /* Mail Post */
            if($_GET['status'] == 'mail_post'  ) {
                if ($_POST && isset($_POST['mailPost'])) {
                    if($ayar['smtp_durum'] == '1' ) {
                        if($_POST['baslik'] && $_POST['icerik']  ) {
                            $baslik = $_POST['baslik'];

                            include '../includes/phpmailer/Exception.php';
                            include '../includes/phpmailer/PHPMailer.php';
                            include '../includes/phpmailer/SMTP.php';
                            $siteadres = $ayar['site_url'];
                            $smtpLogo = ''.$ayar['site_url'].'images/logo/'.$ayar['smtp_logo'].'';
                            $smtpIcon_site =  ''.$ayar['site_url'].'i/iconmail/newsletter.png';
                            $site_adi = $ayar["site_baslik"];
                            $smtp_protokol = $ayar["smtp_protokol"];
                            $smtp_host = $ayar["smtp_host"];
                            $smtp_mail = $ayar["smtp_mail"];
                            $smtp_port = $ayar["smtp_port"];
                            $smtp_pass = $ayar["smtp_pass"];

                            /* Şablon */
                            if($_POST['sablon'] == '0'  ) {
                                /* düz */
                                $content = $_POST['icerik'];
                            }else{
                                /* özelleştirilmiş */
                                $content ="
<div id='MüşteriyeBildirim' style='font-family : Open Sans,sans-serif ; width: 100%; height: auto; padding-top: 30px; padding-bottom: 30px; background-color: #".$epostatema['arkaplan'].";  box-sizing: border-box;   '>
<div style='width: auto; margin: 0 auto;      '>
    <!-- Logo Alanı !-->
        <div id='Logo' style='margin-bottom: 20px; width: 100%; text-align: center; box-sizing: border-box;   '>
            <a href='".$ayar['site_url']."' target='_blank'>
                <img src='".$smtpLogo."' style='max-height: 60px; '>
            </a>
        </div>
    <!--  <========SON=========>>> Logo Alanı SON !-->
    
    <div id='Main_Div' style=' box-sizing: border-box;  margin: 0 auto; width: ".$epostatema['ana_div_width']."px; background-color: #".$epostatema['ana_div']."; color: #".$epostatema['ana_div_text']."; border-radius: ".$epostatema['ana_div_radius']."; padding: ".$epostatema['ana_div_padding']."; border: ".$epostatema['ana_div_border_size']."px solid #".$epostatema['ana_div_border']."; font-size: ".$epostatema['ana_div_font_size']."px ; '>
            <!-- Başlık !-->
            <table width='100%' style='color: #".$epostatema['ana_div_baslik_color']."; font-size:".$epostatema['ana_div_baslik_size']."px; font-weight: ".$epostatema['ana_div_baslik_weight']."; margin-bottom: 40px;'>
                <tr>
                    <td width='80%' >$baslik</td>
                    <td width='20%' style='text-align:right;'><img src='".$smtpIcon_site."' ></td>
                </tr>
            </table>
            <!--  <========SON=========>>> Başlık SON !-->
     
            <div style='width: 95%;  margin-bottom: 25px; '>
                ".$_POST['icerik']."
            </div>
            
    </div>
    
        <!-- Signature Area !-->
        <div id='Signature' style='margin: 0 auto; background-color: #".$epostatema['imza_bg']."; width: ".$epostatema['ana_div_width']."px; padding: ".$epostatema['ana_div_padding']."; box-sizing: border-box; color: #".$epostatema['imza_text']."; font-size: ".$epostatema['imza_font_size']."px ; border-radius: ".$epostatema['imza_border_radius']."; border: ".$epostatema['imza_border_size']."px solid #".$epostatema['imza_border'].";'>
            ".$epostatema['imza_icerik']."
        </div>
        <!--  <========SON=========>>> Signature Area SON !-->
    
    
</div>
</div>
";
                            }
                            /*  <========SON=========>>> Şablon SON */

                            if($_POST['adress_select'] == '0' || $_POST['adress_select'] == '1'  ) {

                                $mail = new PHPMailer;
                                $mail->isSMTP(true);
                                $mail->SMTPAuth = true;
                                $mail->SMTPSecure = false;
                                $mail->SMTPAutoTLS = false;
                                $mail->Host = "$smtp_host";
                                $mail->Username = "$smtp_mail";
                                $mail->Password = "$smtp_pass";
                                $mail->Port = "$smtp_port";
                                $mail->CharSet  = "utf-8";
                                if($ayar['smtp_protokol'] == 'tls' || $ayar['smtp_protokol'] == 'ssl') {
                                    $mail->SMTPSecure =$smtp_protokol;
                                }
                                $mail->setFrom($smtp_mail, $site_adi);


                                if($_POST['adress_select'] == '0'  ) {
                                    /* Herkese gönder */
                                    $allPostAddress = $db->prepare("select * from ebulten ");
                                    $allPostAddress->execute();
                                    foreach ($allPostAddress as $lis){
                                        $mail->AddBCC($lis['eposta']);
                                    }
                                    // Konu //
                                    $mail->Subject = $baslik;
                                    // Mesaj //
                                    $mail->isHTML(true);
                                    $mail->Body = $content;
                                    if($mail->send()) {
                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
                                    } else {
                                        $_SESSION['main_alert'] = 'smtperror';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
                                    }
                                    /*  <========SON=========>>> Herkese gönder SON */
                                }else{
                                    /* Seçili Postaya Gönder */
                                    if($_POST['eposta'] == !null  ) {
                                        $list = $_POST['eposta'];
                                        foreach ($list as $lis){
                                            $mail->AddBCC($lis);
                                        }
                                        // Konu //
                                        $mail->Subject = $baslik;
                                        // Mesaj //
                                        $mail->isHTML();
                                        $mail->Body = $content;
                                        if($mail->send()) {
                                            $_SESSION['main_alert'] = 'success';
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
                                        } else {
                                            $_SESSION['main_alert'] = 'smtperror';
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
                                        }
                                    }else{
                                        $_SESSION['main_alert'] = 'zorunlu';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
                                    }
                                    /*  <========SON=========>>> Seçili Postaya Gönder SON */
                                }
                            }else{
                                $_SESSION['main_alert'] = 'zorunlu';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
                            }
                        }else{
                            $_SESSION['main_alert'] = 'zorunlu';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'smtpoff';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=newsletter');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Mail Post SON */


            /*  Add */
            if($_GET['status'] == 'account_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['eposta'] )  {
                        $liste = $_POST['eposta'];
                        foreach ($liste  as $list)
                        {
                            if($liste != '') {
                                if(filter_var(trim(strip_tags($list)), FILTER_VALIDATE_EMAIL)){

                                    $listCehck = $db->prepare("select * from ebulten where eposta=:eposta ");
                                    $listCehck->execute(array(
                                        'eposta' => $list,
                                    ));

                                    if($listCehck->rowCount()<='0'  ) {
                                        $kaydet = $db->prepare("INSERT INTO ebulten SET
                                     eposta=:eposta,   
                                     tarih=:tarih
                                            ");
                                        $sonuc = $kaydet->execute(array(
                                            'eposta' => $list,
                                            'tarih' => $timestamp
                                        ));
                                        if($sonuc){
                                            $_SESSION['main_alert'] = 'success';
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                    }else{
                                        $_SESSION['main_alert'] = 'emailhave';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                                    }
                                }else{
                                    $_SESSION['main_alert'] = 'emailerror';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                                }
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  Edit */
            if($_GET['status'] == 'account_edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if($_POST['eposta']) {
                        if(filter_var(trim(strip_tags($_POST['eposta'])), FILTER_VALIDATE_EMAIL)){

                            $asilCek = $db->prepare("select * from ebulten where id=:id and eposta=:eposta ");
                            $asilCek->execute(array(
                                'id' => $_POST['mail_id'],
                                'eposta' => trim(strip_tags($_POST['eposta']))
                            ));
                            $row = $asilCek->fetch(PDO::FETCH_ASSOC);
                            if($asilCek->rowCount()>'0'  ) {
                                $guncelle = $db->prepare("UPDATE ebulten SET
                                     eposta=:eposta   
                                 WHERE id={$_POST['mail_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'eposta' => trim(strip_tags($_POST['eposta']))
                                ));
                                if($sonuc){
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                $listCehck = $db->prepare("select * from ebulten where eposta=:eposta ");
                                $listCehck->execute(array(
                                    'eposta' => trim(strip_tags($_POST['eposta'])),
                                ));

                                if($row['eposta'] != $_POST['eposta']  ) {
                                    if($listCehck->rowCount()<='0'  ) {
                                        $guncelle = $db->prepare("UPDATE ebulten SET
                                     eposta=:eposta   
                                 WHERE id={$_POST['mail_id']}      
                                ");
                                        $sonuc = $guncelle->execute(array(
                                            'eposta' => trim(strip_tags($_POST['eposta']))
                                        ));
                                        if($sonuc){
                                            $_SESSION['main_alert'] = 'success';
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                    }else{
                                        $_SESSION['main_alert'] = 'emailhave';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                                    }
                                }


                            }
                        }else{
                            $_SESSION['main_alert'] = 'emailerror';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /*  delete */
            if($_GET['status'] == 'account_delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from ebulten where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from ebulten WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */

            /* Multi Delete */
            if($_GET['status'] == 'account_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from ebulten where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from ebulten WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=email_list');
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