<?php
//todo ioncube
if($_GET['language']) {
    $_SESSION['dil'] = $_GET['language'];
    array_map('unlink', glob('../../i/cache/d/*.html'));
    array_map('unlink', glob('../../i/cache/s/*.html'));
    die(json_encode(array()));
}
$sqldil = $db->prepare("select * from dil order by sira asc limit 1");
$sqldil->execute();
while($dils = $sqldil->fetch(PDO::FETCH_ASSOC)){
    if ($_SESSION['dil'] == "$dils[kisa_ad]") {
        $dil = "$dils[kisa_ad]";
    }
     }
$sqldil2 = $db->prepare("select * from dil order by sira asc limit 1,999");
$sqldil2->execute();
while($dils2 = $sqldil2->fetch(PDO::FETCH_ASSOC)){
    if ($_SESSION['dil'] == "$dils2[kisa_ad]") {
        $dil = "$dils2[kisa_ad]";
    }
  }
if(!$_SESSION["dil"])
{
    $sqldil = $db->prepare("select * from dil where varsayilan='1' order by id asc limit 1");
    $sqldil->execute();
    $dils = $sqldil->fetch(PDO::FETCH_ASSOC);
    $_SESSION['dil'] = "$dils[kisa_ad]";
    $dil =  "$dils[kisa_ad]";
}
include 'includes/lang/'.$dil.'.php';
?>