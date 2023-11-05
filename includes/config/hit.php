<?php
//todo ioncube
$ipadres = $_SERVER["REMOTE_ADDR"];
$bugun = date("Y-m-d");
$day = date("d");
$month = date("m");
$year = date("Y");
$ziyaretciKayitKontrol = $db->prepare("select * from ziyaretciler where tarih=:tarih and ipadres=:ipadres ");
$ziyaretciKayitKontrol->execute(array(
    'tarih' => $bugun,
    'ipadres' => $ipadres
));
if($ziyaretciKayitKontrol->rowCount()<='0'  ){

    if (isMobileDevice()) {
       $device = 'mobile';
    } else {
        $device = 'desktop';
    }

    $kaydet = $db->prepare("INSERT INTO ziyaretciler SET
         tarih=:tarih,
         ipadres=:ipadres,
         cihaz=:cihaz,
         day=:day,
         month=:month,
         year=:year
 ");
 $sonuc = $kaydet->execute(array(
     'tarih' => $bugun,
     'ipadres' => $ipadres,
     'cihaz' => $device,
     'day' => $day,
     'month' => $month,
     'year' => $year,
 ));
}
/*  <========SON=========>>> Ziyaretçileri Kaydet SON */

function deviceCheck()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
        , $_SERVER["HTTP_USER_AGENT"]);
}

if (deviceCheck()) {
    $device = 'mobile';
} else {
    $device = 'desktop';
}

function total_online()
{

    global $db;
    global $device;
    $ip = $_SERVER["REMOTE_ADDR"];
    $current_time = time();
    $session_exist = $db->prepare("SELECT * FROM ziyaretci_online WHERE session='".$_SESSION['session']."'");
    $session_exist->execute();
    $session_check = $session_exist->rowCount();

    if($session_check == '0' && $_SESSION['session']!="")
    {
        $kaydet = $db->prepare("INSERT INTO ziyaretci_online SET
            session=:session,
            time=:time
        ");
        $kaydet->execute(array(
            'session' => $_SESSION['session'],
            'time' => $current_time
        ));

        $kaydet = $db->prepare("INSERT INTO ziyaretciler_adres SET
            ip=:ip,    
            url_adres=:url_adres,
            device=:device,
            session=:session
        ");
        $sonuc = $kaydet->execute(array(
            'ip' => $ip,
            'url_adres' => $_SERVER['REQUEST_URI'],
            'device' => $device,
            'session' => $_SESSION['session']
        ));
    }
    else
    {
        $kaydet = $db->prepare("UPDATE ziyaretci_online SET
            time=:time
            WHERE session='$_SESSION[session]'
        ");
        $kaydet->execute(array(
            'time' => time()
        ));

        $sorgulaAdres = $db->prepare("select * from ziyaretciler_adres where session=:session ");
        $sorgulaAdres->execute(array(
            'session' => $_SESSION['session'],
        ));

        if($sorgulaAdres->rowCount()>'0'  ) {
            $guncelle = $db->prepare("UPDATE ziyaretciler_adres SET
                 ip=:ip,    
            url_adres=:url_adres,
            session=:session 
         WHERE session='$_SESSION[session]'      
        ");
            $sonuc = $guncelle->execute(array(
                'ip' => $ip,
                'url_adres' => $_SERVER['REQUEST_URI'],
                'session' => $_SESSION['session']
            ));
        }else{
            $kaydet = $db->prepare("INSERT INTO ziyaretciler_adres SET
            ip=:ip,    
            url_adres=:url_adres,
            device=:device,
            session=:session
        ");
            $sonuc = $kaydet->execute(array(
                'ip' => $ip,
                'url_adres' => $_SERVER['REQUEST_URI'],
                'device' => $device,
                'session' => $_SESSION['session']
            ));
        }



    }
}
total_online();
?>