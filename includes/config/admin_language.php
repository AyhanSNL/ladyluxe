<?php
ob_start();
session_start();
include "config.php";
date_default_timezone_set( 'Europe/Istanbul' );

# Dil seçimi yapılmışsa
if($_GET['language']) {
# Dil seçimini session'a ata.
    $_SESSION['dil'] = $_GET['language'];
# Anasayfa'ya yönlendir.

    die(json_encode(array()));
}
?>
<?php
$sqldil = $db->prepare("select * from dil order by sira asc limit 1");
$sqldil->execute();
while($dils = $sqldil->fetch(PDO::FETCH_ASSOC)){
    ?>
    <?php
    if ($_SESSION['dil'] == "$dils[kisa_ad]") {
        $dil = "$dils[kisa_ad]";
    }
    ?>
<?php }?>
<?php
$sqldil2 = $db->prepare("select * from dil order by sira asc limit 1,999");
$sqldil2->execute();
while($dils2 = $sqldil2->fetch(PDO::FETCH_ASSOC)){
    ?>
    <?php
    if ($_SESSION['dil'] == "$dils2[kisa_ad]") {
        $dil = "$dils2[kisa_ad]";
    }
    ?>
<?php }?>
<?php
if(!$_SESSION["dil"])
{
    ?>
    <?php
    $sqldil = $db->prepare("select * from dil where varsayilan='1' order by id asc limit 1");
    $sqldil->execute();
    $dils = $sqldil->fetch(PDO::FETCH_ASSOC);
    ?>
    <?php
    $_SESSION['dil'] = "$dils[kisa_ad]";
    $dil =  "$dils[kisa_ad]";
    ?>
    <?php
}
# Dil dosyamızı include ediyoruz
include '../includes/lang/'.$dil.'-panel.php';
?>