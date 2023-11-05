<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$userSorgusu = $db->prepare("select * from uyeler where eposta=:eposta order by id");
$userSorgusu->execute(array(
    'eposta' => $_SESSION['user_email_address']
));
$userCek = $userSorgusu->fetch(PDO::FETCH_ASSOC);

if($userSorgusu->rowCount() > '0'  ) {
    if(isset($_GET["urun_id"]))
    {
        if($demo != '1'  ){
        $getID = htmlspecialchars($_GET['urun_id']);
        $kaydet = $db->prepare("INSERT INTO urun_favori SET
                 uye_id=:uye_id,
                 urun_id=:urun_id
         ");
        $sonuc = $kaydet->execute(array(
            'uye_id' => $userCek['id'],
            'urun_id' => $getID
        ));
        $_SESSION['favorite_status'] = 'success';
        array_map('unlink', glob('../../i/cache/d/*.html'));
        die(json_encode(array()));
        }else{
            $_SESSION['demo_alert'] = 'demo';
            die(json_encode(array()));
        }
    }

    if(isset($_GET["urun_del_id"]))
    {
        if($demo != '1'  ){
        $getID = htmlspecialchars($_GET['urun_del_id']);
        $sil = $db->prepare("DELETE from urun_favori WHERE urun_id=:urun_id and uye_id=:uye_id");
        $sil->execute(array(
          'urun_id' => $getID,
           'uye_id' => $userCek['id']
       ));
        array_map('unlink', glob('../../i/cache/d/*.html'));
        die(json_encode(array()));
        }else{
            $_SESSION['demo_alert'] = 'demo';
            die(json_encode(array()));
        }
    }
}else{
   header('Location:'.$ayar['site_url'].'404');
}
?>