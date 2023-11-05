<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($sms['sms_siparisiptal_site'] == '1' ) {
    $siteMesaj = ''.$sipID.' '.$diller['oto-eposta-content-text112'].'';
    $telSite = $sms['bildirim_numara'];
}
if($sms['sms_siparisiptal_user'] == '1' ) {
    $kaynak  = $diller['oto-eposta-content-text111'];
    $eski   = '<br>';
    $yeni   = '';
    $kaynak = str_replace($eski, $yeni, $kaynak);
    $userMesaj = ''.$sipID.' '.$kaynak.'';
    $telUser = $userCek['telefon'];
}
?>
