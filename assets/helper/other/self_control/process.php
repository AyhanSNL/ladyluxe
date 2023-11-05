<?php
$kontrol = 'localhost';

if($kontrol !='localhost'  ) {

$settings=$db->prepare("SELECT merchant from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$kodgetir = $ayar['merchant'];
$lisanscek = file_get_contents('https://phptema.com/lisans.php?kod='.$kodgetir.'');
$lisanscek = json_decode($lisanscek);

if($lisanscek->kod == 'success'  ) {
    $domainadi = $lisanscek->domain;

    if (!stristr(htmlentities($_SERVER['SERVER_NAME']), "$domainadi")) {
        echo "
<div style='width: 100%; height: 300px; display: flex; align-items: center; justify-content: center; background-color: #f5f5f5; border:1px solid #EBEBEB; font-size:24px; font-weight: 600'>
    Erişim Hatası!
</div>
";
        exit();
    }

}else{
    echo "
<div style='width: 100%; height: 300px; display: flex; align-items: center; justify-content: center; background-color: #f5f5f5; border:1px solid #EBEBEB; font-size:24px; font-weight: 600'>
    Erişim Hatası!
</div>
";
    exit();
}
}

?>