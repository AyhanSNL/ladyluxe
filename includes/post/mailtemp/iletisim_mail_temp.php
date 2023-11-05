<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'includes/phpmailer/Exception.php';
include 'includes/phpmailer/PHPMailer.php';
include 'includes/phpmailer/SMTP.php';
$siteadres = $ayar['site_url'];
$smtpLogo = ''.$ayar['site_url'].'images/logo/'.$ayar['smtp_logo'].'';
$smtpIcon_site = ''.$ayar['site_url'].'i/iconmail/env.png';
$smtpIcon_user = ''.$ayar['site_url'].'i/iconmail/env.png';
$site_adi = $ayar["site_baslik"];
$smtp_protokol = $ayar["smtp_protokol"];
$smtp_host = $ayar["smtp_host"];
$smtp_mail = $ayar["smtp_mail"];
$smtp_port = $ayar["smtp_port"];
$smtp_pass = $ayar["smtp_pass"];
$smtp_bildirim_mail = $ayar["smtp_bildirim_mail"];


// Ziyaretçiye Bildirim //
if($ayar['smtp_iletisim_user'] == '1' ) {

    /* Mail İçeriği Müşteriye */
    $mail_content_user ="
<div id='ziyaretciyeBildirim' style='font-family : Open Sans,sans-serif ; width: 100%; height: auto; padding-top: 30px; padding-bottom: 30px; background-color: #".$epostatema['arkaplan'].";  box-sizing: border-box;   '>
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
                    <td width='80%' >".$diller['oto-eposta-iletisim-form-text10']."</td>
                    <td width='20%' style='text-align:right;'><img src='".$smtpIcon_user."' ></td>
                </tr>
            </table>
            <!--  <========SON=========>>> Başlık SON !-->

            <!-- İçerik !-->
            <div style='width: 95%;  margin-bottom: 40px; '>
                ".$diller['oto-eposta-iletisim-form-text11']."
            </div>
            <!--  <========SON=========>>> İçerik SON !-->
            
            <!-- ziyaretçi form bilgileri !-->
            <div style='width: 100%; border-top: 1px solid #".$epostatema['ana_div_in_border']."; box-sizing: border-box; margin-bottom: 20px;  font-size: 13px ;  '>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-iletisim-form-text3']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".date_tr('j F Y, H:i, l ', ''.$timestamp.'')."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-iletisim-form-text4']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".$isim."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-iletisim-form-text5']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'><a href='tel:".$tel."' style='color:#".$epostatema['ana_div_a_color']."'>".$tel."</a></td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-iletisim-form-text6']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500; '><a href='mailto:$eposta' style='color:#".$epostatema['ana_div_a_color']."'>$eposta</a></td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr >
                        <td width='31%' valign='top'>".$diller['oto-eposta-iletisim-form-text7']."</td>
                        <td width='4%' valign='top'>:</td>
                        <td width='65%' valign='top' style='font-weight: 500; '>".$konu." </td>
                    </tr>
                </table>
            </div>
            <!--  <========SON=========>>> ziyaretçi form bilgileri SON !-->
            
            <div id='bilgiBox' style='width: 100%; background-color: #f8f8f8; border:1px solid #ebebeb; font-size: 13px ; padding: 10px; color: #000; box-sizing: border-box; margin-bottom: 20px;   '>
                <strong>".$diller['oto-eposta-iletisim-form-text8']."</strong>
                <br><br>
                ".$mesaj."
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

    /*  <========SON=========>>> Mail İçeriği Müşteriye SON */



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

// Gönderici //
    $mail->setFrom($smtp_mail, $site_adi);
// Alıcı //
    $mail->AddBCC($eposta, "");
// Konu //
    $mail->Subject = '📧'  .$diller['oto-eposta-iletisim-form-text10'];
// Mesaj //
    $mail->isHTML(true);
    $mail->Body = $mail_content_user;

    if($mail->send()) { } else { }
}
// Müşteriye Bildirim Ending ////////////////////////////////////////////////////////////////////////////////////////



// Siteye Bildirim ////////////////

if($ayar['smtp_iletisim_site']  == '1' ) {

    $mail_content_site ="
<div id='siteyeBildirim' style='font-family : Open Sans,sans-serif ; width: 100%; height: auto; padding-top: 30px; padding-bottom: 30px; background-color: #".$epostatema['arkaplan'].";  box-sizing: border-box;   '>
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
                    <td width='80%' >".$diller['oto-eposta-iletisim-form-text1']."</td>
                    <td width='20%' style='text-align:right;'><img src='".$smtpIcon_site."' ></td>
                </tr>
            </table>
            <!--  <========SON=========>>> Başlık SON !-->

            <!-- İçerik !-->
            <div style='width: 95%;  margin-bottom: 40px; '>
                ".$diller['oto-eposta-iletisim-form-text2']."
            </div>
            <!--  <========SON=========>>> İçerik SON !-->
            
            <!-- ziyaretçi form bilgileri !-->
            <div style='width: 100%; border-top: 1px solid #".$epostatema['ana_div_in_border']."; box-sizing: border-box; margin-bottom: 20px;  font-size: 13px ;  '>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-iletisim-form-text3']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".date_tr('j F Y, H:i, l ', ''.$timestamp.'')."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-iletisim-form-text4']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".$isim."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-iletisim-form-text5']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'><a href='tel:".$tel."' style='color:#".$epostatema['ana_div_a_color']."'>".$tel."</a></td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-iletisim-form-text6']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500; '><a href='mailto:$eposta' style='color:#".$epostatema['ana_div_a_color']."'>$eposta</a></td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr >
                        <td width='31%' valign='top'>".$diller['oto-eposta-iletisim-form-text7']."</td>
                        <td width='4%' valign='top'>:</td>
                        <td width='65%' valign='top' style='font-weight: 500; '>".$konu." </td>
                    </tr>
                </table>
            </div>
            <!--  <========SON=========>>> ziyaretçi form bilgileri SON !-->
            
            <div id='bilgiBox' style='width: 100%; background-color: #f8f8f8; border:1px solid #ebebeb; font-size: 13px ; padding: 10px; color: #000; box-sizing: border-box; margin-bottom: 20px;   '>
                <strong>".$diller['oto-eposta-iletisim-form-text8']."</strong>
                <br><br>
                ".$mesaj."
            </div>
            
            <div id='bilgiBox' style='width: 100%; background-color: #f1f6f7; border:1px solid #e1eef1; font-size: 13px ; padding: 10px; color: #000; box-sizing: border-box;    '>
                ".$diller['oto-eposta-iletisim-form-text9']."
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

// Gönderici //
    $mail->setFrom($smtp_mail, $site_adi);
// Alıcı //
    $mail->AddBCC($smtp_bildirim_mail, "");
// Konu //
    $mail->Subject = '📧' .$diller['oto-eposta-iletisim-form-text1'];
// Mesaj //
    $mail->isHTML(true);
    $mail->Body = $mail_content_site;

    if($mail->send()) {
    } else {
    }
}
// Siteye Bildirim Son ////////////////
?>