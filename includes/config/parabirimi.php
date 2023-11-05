<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
$current_kur = $_SESSION['current_kur'];
$kurCek = $db->prepare("select * from para_birimleri where varsayilan=:varsayilan and durum=:durum order by id desc limit 1");
$kurCek->execute(array(
    'varsayilan' => '1',
    'durum' => '1'
));
$varsayilankur = $kurCek->fetch(PDO::FETCH_ASSOC);
if($_SESSION['current_kur'] == null || $_SESSION['current_kur'] == '' || $_SESSION['current_kur'] == '0' ) {
    $_SESSION['current_kur'] = $varsayilankur['kod'];
}else{
    $_SESSION['current_kur'] = $current_kur;
}
$kurSirala = $db->prepare("select * from para_birimleri where durum=:durum order by sira asc");
$kurSirala->execute(array(
    'durum' => '1'
));
$kurSiralaMobil = $db->prepare("select * from para_birimleri where durum=:durum order by sira asc");
$kurSiralaMobil->execute(array(
    'durum' => '1'
));
$MevcutKurcek = $db->prepare("select * from para_birimleri where kod=:kod and durum=:durum");
$MevcutKurcek->execute(array(
    'kod' => $_SESSION['current_kur'],
    'durum' => '1'
));
$secilikur = $MevcutKurcek->fetch(PDO::FETCH_ASSOC);
?>
<?php
if(isset($_GET['kur_code'])) {
    $_SESSION['current_kur'] = $_GET['kur_code'];
    array_map('unlink', glob('../../i/cache/d/*.html')); // Cache klasörü içerisindeki sadece .html uzantılı dosyaları sil
    die(json_encode(array()));
}
?>