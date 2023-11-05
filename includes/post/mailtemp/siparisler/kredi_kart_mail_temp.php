<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'includes/phpmailer/Exception.php';
include 'includes/phpmailer/PHPMailer.php';
include 'includes/phpmailer/SMTP.php';
$siteadres = $ayar['site_url'];
$smtpLogo = ''.$ayar['site_url'].'images/logo/'.$ayar['smtp_logo'].'';
$smtpIcon_site = ''.$ayar['site_url'].'i/iconmail/cart.png';
$smtpIcon_user = ''.$ayar['site_url'].'i/iconmail/cartcheck.png';
$site_adi = $ayar["site_baslik"];
$smtp_protokol = $ayar["smtp_protokol"];
$smtp_host = $ayar["smtp_host"];
$smtp_mail = $ayar["smtp_mail"];
$smtp_port = $ayar["smtp_port"];
$smtp_pass = $ayar["smtp_pass"];
$smtp_bildirim_mail = $ayar["smtp_bildirim_mail"];

$parabirimi = $sip['parabirimi'];
$siparis_id = $sip['siparis_no'];
$isim = $sip['isim'];
$soyisim = $sip['soyisim'];
$eposta = $sip['eposta'];
$alankodu = $sip['alan_kodu'];
$yenitelefon = $sip['telefon'];
$telefon = $sip['telefon_gosterim'];
$adres=$sip['adresbilgisi'];
$postakodu = $sip['postakodu'];
$ilce = $sip['ilce'];
$sehir = $sip['sehir'];
$siparis_aratoplam = $sip['ara_tutar'];
$toplamodenecek = $sip['toplam_tutar'];
$kargo_tutar = $sip['kargo_tutar'];
$kdv_tutar = $sip['kdv_tutar'];
$indirim_tutar = $sip['indirim_tutar'];
$kargo_tutar = $sip['kargo_tutar'];
$siparis_ek_indirimtutar = $sip['sepette_ek_indirim'];
$siparis_ilk_indirimi = $sip['ilk_siparis_indirim'];
$siparis_grup_indirimi = $sip['grup_indirim'];


$DovizBul = $db->prepare("select * from para_birimleri where kod=:kod ");
$DovizBul->execute(array(
    'kod' => $parabirimi,
));
$paraDurumu = $DovizBul->fetch(PDO::FETCH_ASSOC);


if($odemeayar['kargo_sistemi']== '1'  ) {
    $kargoTablo = "    <table width='100%' style='padding: 8px; border-bottom: 1px solid #EBEBEB;'>
                        <tr>
                            <td width='46%' style='font-size: 12px ;'>".$diller['oto-eposta-content-text11']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 14px ; text-align: right;'>".number_format($kargo_tutar, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>  ";
}else{
    $kargoTablo = '';
}
if($kdv_tutar > '0'  ) {
    $kdvTablo = "    <table width='100%' style='padding: 8px; border-bottom: 1px solid #EBEBEB;'>
                        <tr>
                            <td width='46%' style='font-size: 12px ;'>".$diller['oto-eposta-content-text10']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 14px ; text-align: right;'>".number_format($kdv_tutar, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table> ";
}else{
    $kdvTablo = '';
}
if($indirim_tutar > '0'  ) {
    $indirimTablo = "<table width='100%' style='padding: 8px; border-bottom: 1px solid #EBEBEB;'>
                        <tr>
                            <td width='46%' style='font-size: 12px ;'>".$diller['oto-eposta-content-text12']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 14px ; text-align: right;'>- ".number_format($indirim_tutar, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>";
}else{
    $indirimTablo = '';
}

if($siparis_ek_indirimtutar > '0'  ) {
    $ekIndirimTutar = "<table width='100%' style='padding: 8px; border-bottom: 1px solid #EBEBEB;'>
                        <tr>
                            <td width='46%' style='font-size: 12px ;'>".$diller['oto-eposta-content-text12-2']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 14px ; text-align: right;'>- ".number_format($siparis_ek_indirimtutar, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>";
}else{
    $ekIndirimTutar = '';
}
if($siparis_ilk_indirimi > '0'  ) {
    $ilkIndirimTutar = "<table width='100%' style='padding: 8px; border-bottom: 1px solid #EBEBEB;'>
                        <tr>
                            <td width='46%' style='font-size: 12px ;'>".$diller['oto-eposta-content-text12-3']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 14px ; text-align: right;'>- ".number_format($siparis_ilk_indirimi, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>";
}else{
    $ilkIndirimTutar = '';
}

if($siparis_grup_indirimi > '0'  ) {
    $grupIndirimi = "<table width='100%' style='padding: 8px; border-bottom: 1px solid #EBEBEB;'>
                        <tr>
                            <td width='46%' style='font-size: 12px ;'>".$diller['oto-eposta-content-text12-4']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 14px ; text-align: right;'>- ".number_format($siparis_grup_indirimi, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>";
}else{
    $grupIndirimi = '';
}

/* Ürünleri Çek */
$urunAktar_Eposta = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
$urunAktar_Eposta->execute(array(
    'siparis_id' => $sip['siparis_no']
));


foreach ($urunAktar_Eposta as $urunPosta) {

        $urun_kdvsiztutar = $urunPosta['kdvsiz_tutar'];
        $urun_kargotutar =  $urunPosta['kargo_tutar'];
        $urun_kdvtutar = $urunPosta['kdv_tutar'];
        $urun_ekfiyat = $urunPosta['ek_fiyat'];


    /* Ürünü Al */
    $dbForRealProduct = $db->prepare("select * from urun where id=:id ");
    $dbForRealProduct->execute(array(
        'id' => $urunPosta['urun_id'],
    ));
    $postaRealurun = $dbForRealProduct->fetch(PDO::FETCH_ASSOC);
    /* Ürünü Al SON */
    if($urunPosta['ek_fiyat'] > '0'  ) {
        $ekfiyatDiv="
        <div style='border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";  padding: 8px; margin-bottom: 5px;'>
        <strong>".$diller['oto-eposta-content-text22']." : ".number_format($urun_ekfiyat, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</strong>
        <br>
        ".$diller['oto-eposta-content-text23']."
        </div>";
    }else{
        $ekfiyatDiv = '';
    }
    if($urunPosta['kdv_tutar'] > '0'  ) {
     $urunKdvTablo = " <td width='15%' valign='top' style='border-right: 1px solid #".$epostatema['ana_div_in_border'].";  font-size: 13px;'>
                    <div style='padding: 8px; border-bottom: 1px solid #".$epostatema['ana_div_in_border']."; font-weight: bold;'>
                    ".$diller['oto-eposta-content-text26']."
                    </div>
                     <div style='padding: 8px; '>
                    ".number_format($urun_kdvtutar, $paraDurumu['para_format'])." ".$paraDurumu['kod']."
                    </div>
                </td>";
    }else{
     $urunKdvTablo = '';
    }

    if($odemeayar['kargo_sistemi'] == '1' ) {
     $urunKargoTablo = "<td width='15%' valign='top' style='border-right: 1px solid #".$epostatema['ana_div_in_border'].";  font-size: 13px;'>
                    <div style='padding: 8px; border-bottom: 1px solid #".$epostatema['ana_div_in_border']."; font-weight: bold;'>
                    ".$diller['oto-eposta-content-text27']."
                    </div>
                     <div style='padding: 8px; '>
                    ".number_format($urun_kargotutar, $paraDurumu['para_format'])." ".$paraDurumu['kod']."
                    </div>
                </td>";
    }



    $urunlerTablo.=" <table width='500' style=\"border-collapse: collapse ; border-spacing: 0 !important; border: 1px solid #".$epostatema['ana_div_in_border']."; color: #".$epostatema['ana_div_text'].";\" >
            <tr>
                <td width='5%' valign='top' >
                <img src='".$siteadres."images/product/".$postaRealurun['gorsel']."' style='width: 45px; padding: 8px;' >
                </td>
                <td width='32%' valign='top' style='border-right: 1px solid #".$epostatema['ana_div_in_border'].";  font-size: 12px;' >
                <div style='border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";  margin-bottom: 5px; padding: 8px;'>
                    ".$postaRealurun['baslik']."
                </div>
                $ekfiyatDiv
                <div style=' padding: 8px; margin-bottom: 5px;'>
                    ".$diller['oto-eposta-content-text24']." : ".$urunPosta['adet']."
                </div>
                </td>
                <td width='15%' valign='top' style='border-right: 1px solid #".$epostatema['ana_div_in_border'].";  font-size: 13px;'>
                    <div style='padding: 8px; border-bottom: 1px solid #".$epostatema['ana_div_in_border']."; font-weight: bold;'>
                    ".$diller['oto-eposta-content-text25']."
                    </div>
                     <div style='padding: 8px; '>
                    ".number_format($urun_kdvsiztutar, $paraDurumu['para_format'])." ".$paraDurumu['kod']."
                    </div>
                </td>
                 $urunKdvTablo      
                 $urunKargoTablo                         
            </tr>
            </table>";
}
/*  <========SON=========>>> Ürünleri Çek SON */


// Müşteriye Bildirim //
if($ayar['smtp_siparis_user'] == '1' ) {

    /* Mail İçeriği Müşteriye */
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
                    <td width='80%' >".$diller['oto-eposta-kart-odeme-1']."</td>
                    <td width='20%' style='text-align:right;'><img src='".$smtpIcon_user."' ></td>
                </tr>
            </table>
            <!--  <========SON=========>>> Başlık SON !-->
            
           <!-- Sipariş Sahibi !-->
            <div style='width: 95%;  margin-bottom: 25px; '>
                ".$diller['oto-eposta-content-text1']." <strong>".$isim." ".$soyisim."</strong>,
            </div>
            <!--  <========SON=========>>> Sipariş Sahibi SON !-->
            <!-- İçerik !-->
            <div style='width: 95%;  margin-bottom: 40px; '>
                ".$diller['oto-eposta-kart-odeme-2']."
            </div>
            <!--  <========SON=========>>> İçerik SON !-->
            
            
            <!-- Sipariş Sahibi Bilgileri !-->
            <div style='width: 100%; border-top: 1px solid #".$epostatema['ana_div_in_border']."; box-sizing: border-box; margin-bottom: 20px;  font-size: 13px ;  '>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text2']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".$siparis_id."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text2-2']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".date_tr('j F Y, H:i, l ', ''.$timestamp.'')."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text3']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".$diller['oto-eposta-content-text17']."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text4']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'><a href='tel:+".$alankodu."".$yenitelefon."' style='color:#".$epostatema['ana_div_a_color']."'>+".$alankodu." ".$telefon."</a></td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text5']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500; '><a href='mailto:$eposta' style='color:#".$epostatema['ana_div_a_color']."'>$eposta</a></td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr >
                        <td width='31%' valign='top'>".$diller['oto-eposta-content-text6']."</td>
                        <td width='4%' valign='top'>:</td>
                        <td width='65%' valign='top' style='font-weight: 500; font-size: 12px;'>".$adres." <br> $postakodu / $ilce / $sehir</td>
                    </tr>
                </table>
            </div>
            <!--  <========SON=========>>> Sipariş Sahibi Bilgileri SON !-->
            
            
            <div id='bilgiBox' style='width: 100%; background-color: #f1f6f7; border:1px solid #e1eef1; font-size: 13px ; padding: 10px; color: #000; box-sizing: border-box; margin-bottom: 40px;   '>
                ".$diller['oto-eposta-content-text7']."
            </div>
            
            <!-- Siparişteki Ürünler !-->
            <div id='Siparişİçeriği_Başlık' style='width: 100%; font-size: 14px ; font-weight: bold; border-bottom: 1px solid #".$epostatema['ana_div_in_border']."; margin-bottom: 8px; padding-bottom:8px;    '>
            ".$diller['oto-eposta-content-text21']."
            </div>
            
             $urunlerTablo
            <!--  <========SON=========>>> Siparişteki Ürünler SON !-->
            
            <!-- Sipariş Özeti !-->
            <table width='100%' style='color: #000; margin-top: 25px; border-collapse: collapse ; border-spacing: 0 !important;'>
            <tr>
                <td width='35%'  >
                
                </td>      
                <td width='65%' style='background-color: #f8f8f8; border: 1px solid #EBEBEB;'>
                    <div style='width: 100%; padding: 8px; border-bottom: 1px solid #EBEBEB; font-size: 14px; font-weight: bold; color: #000; text-align: right; box-sizing: border-box;  '>
                    ".$diller['oto-eposta-content-text8']."
                    </div>
                    <table width='100%' style='padding: 8px; border-bottom: 1px solid #EBEBEB;'>
                        <tr>
                            <td width='46%' style='font-size: 12px ;'>".$diller['oto-eposta-content-text9']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 14px ; text-align: right;'>".number_format($siparis_aratoplam, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>
                    ".$kdvTablo."
                    ".$kargoTablo." 
                    ".$indirimTablo."
                    ".$ekIndirimTutar."
                    $ilkIndirimTutar
                    $grupIndirimi
                    $kapidaBedelTablo
                    <table width='100%' style='padding: 8px;'>
                        <tr>
                            <td width='46%' style='font-size: 14px ;'>".$diller['oto-eposta-content-text14']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 18px ; text-align: right;'>".number_format($toplamodenecek, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>
                </td>  
            </tr>
            </table>
            <!--  <========SON=========>>> Sipariş Özeti SON !-->
            
            
             
            
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
    $mail->Subject = '✅'  .$diller['oto-eposta-kart-odeme-1'];
// Mesaj //
    $mail->isHTML(true);
    $mail->Body = $mail_content_user;

    if($mail->send()) { } else { }
}
// Müşteriye Bildirim Ending ////////////////////////////////////////////////////////////////////////////////////////



// Siteye Bildirim ////////////////

if($ayar['smtp_siparis_site']  == '1' ) {

    $mail_content_site ="
<div id='SiteyeBildirim' style='font-family : Open Sans,sans-serif ; width: 100%; height: auto; padding-top: 30px; padding-bottom: 30px; background-color: #".$epostatema['arkaplan'].";  box-sizing: border-box;   '>
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
                    <td width='80%' >".$diller['oto-eposta-kart-odeme-3']."</td>
                    <td width='20%' style='text-align:right;'><img src='".$smtpIcon_site."' ></td>
                </tr>
            </table>
            <!--  <========SON=========>>> Başlık SON !-->
            
            <!-- İçerik !-->
            <div style='width: 95%;  margin-bottom: 40px; '>
                ".$diller['oto-eposta-kart-odeme-4']."
            </div>
            <!--  <========SON=========>>> İçerik SON !-->
            
            <!-- Sipariş Sahibi Bilgileri !-->
            <div style='width: 100%; border-top: 1px solid #".$epostatema['ana_div_in_border']."; box-sizing: border-box; margin-bottom: 20px;  font-size: 13px ;  '>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text2']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".$siparis_id."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text2-2-2']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".$isim." ".$soyisim."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text2-2']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".date_tr('j F Y, H:i, l ', ''.$timestamp.'')."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text3']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'>".$diller['oto-eposta-content-text17']."</td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text4']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500;'><a href='tel:+".$alankodu."".$yenitelefon."' style='color:#".$epostatema['ana_div_a_color']."'>+".$alankodu." ".$telefon."</a></td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr>
                        <td width='31%'valign='top' >".$diller['oto-eposta-content-text5']."</td>
                        <td width='4%' valign='top' >:</td>
                        <td width='65%' valign='top' style='font-weight: 500; '><a href='mailto:$eposta' style='color:#".$epostatema['ana_div_a_color']."'>$eposta</a></td>
                    </tr>
                </table>
                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #".$epostatema['ana_div_in_border'].";'>
                    <tr >
                        <td width='31%' valign='top'>".$diller['oto-eposta-content-text6']."</td>
                        <td width='4%' valign='top'>:</td>
                        <td width='65%' valign='top' style='font-weight: 500; font-size: 12px;'>".$adres." <br> $postakodu / $ilce / $sehir</td>
                    </tr>
                </table>
            </div>
            <!--  <========SON=========>>> Sipariş Sahibi Bilgileri SON !-->
            
            
            <div id='bilgiBox' style='width: 100%; background-color: #f1f6f7; border:1px solid #e1eef1; font-size: 13px ; padding: 10px; color: #000; box-sizing: border-box; margin-bottom: 40px;   '>
                ".$diller['oto-eposta-content-text15']."
            </div>
            
            <!-- Siparişteki Ürünler !-->
            <div id='Siparişİçeriği_Başlık' style='width: 100%; font-size: 14px ; font-weight: bold; border-bottom: 1px solid #".$epostatema['ana_div_in_border']."; margin-bottom: 8px; padding-bottom:8px;    '>
            ".$diller['oto-eposta-content-text21']."
            </div>
            
             $urunlerTablo
            <!--  <========SON=========>>> Siparişteki Ürünler SON !-->
            
            <!-- Sipariş Özeti !-->
            <table width='100%' style='color: #000; border-collapse: collapse ; border-spacing: 0 !important; margin-top: 20px;'>
            <tr>
                <td width='35%'  >
                
                </td>      
                <td width='65%' style='background-color: #f8f8f8; border: 1px solid #EBEBEB;'>
                    <div style='width: 100%; padding: 8px; border-bottom: 1px solid #EBEBEB; font-size: 14px; font-weight: bold; color: #000; text-align: right; box-sizing: border-box;  '>
                    ".$diller['oto-eposta-content-text8']."
                    </div>
                    <table width='100%' style='padding: 8px; border-bottom: 1px solid #EBEBEB;'>
                        <tr>
                            <td width='46%' style='font-size: 12px ;'>".$diller['oto-eposta-content-text9']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 14px ; text-align: right;'>".number_format($siparis_aratoplam, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>
                    ".$kdvTablo."
                    ".$kargoTablo." 
                    ".$indirimTablo."
                    ".$ekIndirimTutar."
                    $ilkIndirimTutar
                    $grupIndirimi
                    $kapidaBedelTablo
                    <table width='100%' style='padding: 8px;'>
                        <tr>
                            <td width='46%' style='font-size: 14px ;'>".$diller['oto-eposta-content-text14']."</td>
                            <td width='2%'>:</td>
                            <td width='52%' style='font-weight: 500; font-size: 18px ; text-align: right;'>".number_format($toplamodenecek, $paraDurumu['para_format'])." ".$paraDurumu['kod']."</td>
                        </tr>
                    </table>
                </td>  
            </tr>
            </table>
            <!--  <========SON=========>>> Sipariş Özeti SON !-->
            
            
             
            
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
    $mail->Subject = '🎉' .$diller['oto-eposta-kart-odeme-3'];
// Mesaj //
    $mail->isHTML(true);
    $mail->Body = $mail_content_site;

    if($mail->send()) {
    } else {
    }
}
// Siteye Bildirim Son ////////////////
?>