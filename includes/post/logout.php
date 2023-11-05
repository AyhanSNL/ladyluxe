<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$timestamp = date('Y-m-d G:i:s');
$ip = $_SERVER["REMOTE_ADDR"];
/* Üyelerin LOG KAydı */
if($ayar['uye_log'] == '1' ) {
    $kaydet = $db->prepare("INSERT INTO uyeler_log SET
                       uye_id=:uye_id,     
                       ip=:ip,
                       islem=:islem,
                       tarih=:tarih
                    ");
    $sonuc = $kaydet->execute(array(
        'uye_id' => $userCek['id'],
        'ip' => $ip,
        'islem' => '0',
        'tarih' => $timestamp,
    ));
}
/*  <========SON=========>>> Üyelerin LOG KAydı SON */
unset($_SESSION['user_email_address'] );
unset($_SESSION['user_email_address_onaysiz'] );
array_map('unlink', glob('i/cache/d/*.html'));
array_map('unlink', glob('i/cache/s/*.html'));
header('Location:'.$siteurl.'');
?>