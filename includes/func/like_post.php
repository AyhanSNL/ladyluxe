<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
//todo ioncube
if($_GET['begen_id'] == !null || $_GET['disbegen_id'] == !null || $_GET['likedislike_id'] == !null || $_GET['dislikelike_id'] == !null  ) {
    if(isset($_GET["begen_id"]))
    {
        $begenID = htmlspecialchars($_GET["begen_id"]);
        $ipcek = $_SERVER["REMOTE_ADDR"];
        $yorumBegeni = $db->prepare("select * from modul_yorum_begeni where yorum_id=:yorum_id and ip_adres=:ip_adres ");
        $yorumBegeni->execute(array(
            'yorum_id' => $begenID,
            'ip_adres' => $ipcek
        ));
        $begen = $yorumBegeni->fetch(PDO::FETCH_ASSOC);

        if($yorumBegeni->rowCount() > '0') {

            $sil = $db->prepare("DELETE from modul_yorum_begeni WHERE yorum_id=:yorum_id and ip_adres=:ip_adres");
            $sil->execute(array(
                'yorum_id' => $begenID,
                'ip_adres' => $ipcek
            ));

        }else{
            $kaydet = $db->prepare("INSERT INTO modul_yorum_begeni SET
                 ip_adres=:ip_adres,
                 yorum_id=:yorum_id,
                 durum=:durum       
                ");
            $sonuc = $kaydet->execute(array(
                'ip_adres' => $ipcek,
                'yorum_id' => $begenID,
                'durum' => '0'
            ));
        }
        die(json_encode(array()));
    }

    if(isset($_GET["disbegen_id"]))
    {
        $begenID = htmlspecialchars($_GET["disbegen_id"]);
        $ipcek = $_SERVER["REMOTE_ADDR"];
        $yorumBegeni = $db->prepare("select * from modul_yorum_begeni where yorum_id=:yorum_id and ip_adres=:ip_adres ");
        $yorumBegeni->execute(array(
            'yorum_id' => $begenID,
            'ip_adres' => $ipcek
        ));
        $begen = $yorumBegeni->fetch(PDO::FETCH_ASSOC);

        if($yorumBegeni->rowCount() > '0') {

            $sil = $db->prepare("DELETE from modul_yorum_begeni WHERE yorum_id=:yorum_id and ip_adres=:ip_adres");
            $sil->execute(array(
                'yorum_id' => $begenID,
                'ip_adres' => $ipcek
            ));

        }else{
            $kaydet = $db->prepare("INSERT INTO modul_yorum_begeni SET
                 ip_adres=:ip_adres,
                 yorum_id=:yorum_id,
                 durum=:durum       
                ");
            $sonuc = $kaydet->execute(array(
                'ip_adres' => $ipcek,
                'yorum_id' => $begenID,
                'durum' => '1'
            ));
        }
        die(json_encode(array()));
    }

    if(isset($_GET["likedislike_id"]))
    {
        $begenID = htmlspecialchars($_GET["likedislike_id"]);
        $guncelle = $db->prepare("UPDATE modul_yorum_begeni SET
            durum=:durum
     WHERE yorum_id={$begenID}      
    ");
        $guncelle->execute(array(
            'durum' => '1'
        ));
        die(json_encode(array()));
    }

    if(isset($_GET["dislikelike_id"]))
    {
        $begenID = htmlspecialchars($_GET["dislikelike_id"]);
        $guncelle = $db->prepare("UPDATE modul_yorum_begeni SET
            durum=:durum
     WHERE yorum_id={$begenID}      
    ");
        $guncelle->execute(array(
            'durum' => '0'
        ));
        die(json_encode(array()));
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>