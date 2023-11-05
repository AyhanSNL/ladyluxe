<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include '../includes/phpmailer/Exception.php';
include '../includes/phpmailer/PHPMailer.php';
include '../includes/phpmailer/SMTP.php';
$siteadres = $ayar['site_url'];
$smtpLogo = ''.$ayar['site_url'].'images/logo/'.$ayar['smtp_logo'].'';
$smtpIcon_user = ''.$ayar['site_url'].'i/iconmail/cart.png';
$site_adi = $ayar["site_baslik"];
$smtp_protokol = $ayar["smtp_protokol"];
$smtp_host = $ayar["smtp_host"];
$smtp_mail = $ayar["smtp_mail"];
$smtp_port = $ayar["smtp_port"];
$smtp_pass = $ayar["smtp_pass"];



$mail_content_user ="
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
                    <td width='80%' >".$diller['adminpanel-bildirim-text-15']."</td>
                    <td width='20%' style='text-align:right;'><img src='".$smtpIcon_user."' ></td>
                </tr>
            </table>
            <!--  <========SON=========>>> Başlık SON !-->
     
     
                <!-- gönderen isim soyisim !-->
            <div style='width: 95%;  margin-bottom: 25px; '>
                ".$diller['adminpanel-bildirim-text-2']." <strong>".$isim." ".$soyisim."</strong>,
            </div>
            <!--  <========SON=========>>> gönderen isim soyisim SON !-->
            
     
            <div style='width: 95%;  margin-bottom: 25px; '>
                <strong>#$sipRow[siparis_no]</strong> ".$diller['adminpanel-bildirim-text-16']." <strong>$d[baslik]</strong> ".$diller['adminpanel-bildirim-text-28']."
                <br>
                <br>
                $ayrica
            </div>
            
            <!-- Button Area !-->
            <div style='width: 100%; margin-bottom:0; '>
            <a href='".$siteadres."uye-girisi/' style='display:block; text-align:center; padding: 8px 15px; font-size: 14px ; background-color: dodgerblue; color: #FFF; text-decoration: none; '>
             ".$diller['adminpanel-bildirim-text-7']."
            </a>
            </div>
            <!--  <========SON=========>>> Button Area SON !-->
            
            
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
$mail->AddBCC($eposta, "");
// Konu //
$mail->Subject = '🛒'  .$diller['adminpanel-bildirim-text-15'];
// Mesaj //
$mail->isHTML(true);
$mail->Body = $mail_content_user;

if($mail->send()) {
} else {
}
?>