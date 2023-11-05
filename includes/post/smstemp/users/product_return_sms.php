<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($sms['sms_uruniade_site'] == '1' ) {
    $siteMesaj = ''.$urun['siparis_id'].' '.$diller['oto-eposta-content-text101'].'';
    $telSite = $sms['bildirim_numara'];
}
if($sms['sms_uruniade_user'] == '1' ) {
    $kaynak  = $diller['oto-eposta-content-text100'];
    $eski   = '<br>';
    $yeni   = '';
    $kaynak = str_replace($eski, $yeni, $kaynak);
    $userMesaj = ''.$urun['siparis_id'].' '.$kaynak.'';
    $telUser = $userCek['telefon'];
}
?>
