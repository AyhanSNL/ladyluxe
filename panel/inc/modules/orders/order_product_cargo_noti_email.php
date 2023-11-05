<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include '../includes/phpmailer/Exception.php';
include '../includes/phpmailer/PHPMailer.php';
include '../includes/phpmailer/SMTP.php';
$siteadres = $ayar['site_url'];
$smtpLogo = ''.$ayar['site_url'].'images/logo/'.$ayar['smtp_logo'].'';
$smtpIcon_user = ''.$ayar['site_url'].'i/iconmail/deli.png';
$site_adi = $ayar["site_baslik"];
$smtp_protokol = $ayar["smtp_protokol"];
$smtp_host = $ayar["smtp_host"];
$smtp_mail = $ayar["smtp_mail"];
$smtp_port = $ayar["smtp_port"];
$smtp_pass = $ayar["smtp_pass"];


$urunGoster = $db->prepare("select gorsel from urun where id=:id ");
$urunGoster->execute(array(
    'id' => $proRow['urun_id'],
));
$asilRow = $urunGoster->fetch(PDO::FETCH_ASSOC);

if($urunGoster->rowCount()>'0'  ) {

    $urunlerTablo =" <table width='100%' style=\"border-collapse: collapse ; border-spacing: 0 !important; border: 1px solid #".$epostatema['ana_div_in_border']."; color: #".$epostatema['ana_div_text'].";\" >
            <tr>
                <td width='5%' valign='top' >
                <img src='".$siteadres."images/product/".$asilRow['gorsel']."' style='width: 45px; padding: 8px;' >
                </td>
                <td width='32%' valign='top' style='border-right: 1px solid #".$epostatema['ana_div_in_border'].";  font-size: 12px;' >
                <div style='border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";  margin-bottom: 5px; padding: 8px;'>
                  $urunBaslik
                </div>
                <div style=' padding: 8px; margin-bottom: 5px;'>
                    ".$diller['adminpanel-form-text-1199']." : ".$proRow['adet']."
                </div>
                </td>
            </tr>
            </table>";

}


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
                    <td width='80%' >".$diller['adminpanel-bildirim-text-25']."</td>
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
                <strong>#$_POST[order_id]</strong> ".$diller['adminpanel-bildirim-text-26']." $urunBaslik ".$diller['adminpanel-bildirim-text-27']."
            </div>
            
            $urunlerTablo
            
            <div style='width: 100%;  background-color: #f8f8f8; border:1px solid #EBEBEB; padding:15px; box-sizing: border-box '>
                ".$diller['adminpanel-bildirim-text-24']."
                <br><br>
                <strong>".$diller['adminpanel-bildirim-text-21']."</strong> $kargofirma
                <br>
                <strong>".$diller['adminpanel-bildirim-text-22']."</strong> $kargotakip
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
$mail->AddBCC($eposta, "");
// Konu //
$mail->Subject = '🚚'  .$diller['adminpanel-bildirim-text-25'];
// Mesaj //
$mail->isHTML(true);
$mail->Body = $mail_content_user;

if($mail->send()) {
} else {
}
?>