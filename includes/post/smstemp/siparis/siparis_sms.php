<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($sms['sms_siparis_site'] == '1' ) {
    $siteMesaj = ''.$diller['oto-eposta-havale-eft-4'].'';
    $telSite = $sms['bildirim_numara'];
}
if($sms['sms_siparis_user'] == '1' ) {
    $userMesaj .= ''.$diller['oto-eposta-content-text1'].' '.$isim.' '.$soyisim.', '.$diller['oto-eposta-havale-eft-2'].' '.$diller['oto-eposta-content-text2'].' : '.$siparis_id.'';
    if($odemeTur == '2' && $odemeayar['havale_odeme_bildirim'] == '1' ) {
        $kaynak  = $diller['oto-eposta-havale-eft-5'];
        $eski   = array('<strong>','</strong>');
        $yeni   = array('','');
        $kaynak = str_replace($eski, $yeni, $kaynak);
        $userMesaj .= ''.$kaynak.'';
    }
    $telUser = $yenitelefon;
}
?>
