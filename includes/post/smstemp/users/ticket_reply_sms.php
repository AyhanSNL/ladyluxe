<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($sms['sms_ticket_site'] == '1' ) {
    $siteMesaj = ''.$destekno.' '.$diller['oto-eposta-content-text98'].'';
    $telSite = $sms['bildirim_numara'];
}
?>
