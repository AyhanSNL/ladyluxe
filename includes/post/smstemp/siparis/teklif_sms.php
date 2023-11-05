<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($sms['sms_teklif_site'] == '1' ) {
    $kaynak  = $diller['oto-eposta-urun-teklif-4'];
    $eski   = '<br>';
    $yeni   = '';
    $kaynak = str_replace($eski, $yeni, $kaynak);
    $siteMesaj = ''.$kaynak.'';
    $telSite = $sms['bildirim_numara'];
}
if($sms['sms_teklif_user'] == '1' ) {
    $userMesaj = ''.$diller['oto-eposta-urun-teklif-2'].'';
    $telUser = $telefon;
}
?>