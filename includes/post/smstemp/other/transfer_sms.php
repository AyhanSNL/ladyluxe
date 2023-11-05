<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($sms['sms_odeme_site'] == '1' ) {
    $siteMesaj = ''.$siparisno.' '.$diller['oto-eposta-content-text125'].'';
    $telSite = $sms['bildirim_numara'];
}
if($sms['sms_odeme_user'] == '1' ) {
    $userMesaj = ''.$siparisno.' '.$diller['oto-eposta-content-text117'].'';
    $telUser = $sipariRow['telefon'];
}
?>
