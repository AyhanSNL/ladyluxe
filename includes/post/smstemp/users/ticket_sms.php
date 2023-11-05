<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($sms['sms_ticket_site'] == '1' ) {
    $siteMesaj = ''.$diller['oto-eposta-content-text91'].'';
    $telSite = $sms['bildirim_numara'];
}
if($sms['sms_ticket_user'] == '1' ) {
    $kaynak  = $diller['oto-eposta-content-text84'];
    $eski   = '<br>';
    $yeni   = '';
    $kaynak = str_replace($eski, $yeni, $kaynak);
    $userMesaj = ''.$diller['oto-eposta-content-text1'].' '.$isim.' '.$soyisim.', '.$kaynak.'';
    $telUser = $userCek['telefon'];
}
?>
