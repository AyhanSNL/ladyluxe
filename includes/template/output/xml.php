<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
header('Content-Type: text/xml');
header('Content-type: application/xml; charset="utf8"',true);
$key = htmlspecialchars($_GET['key']);
$exportSql = $db->prepare("select * from urun_export where output_key=:output_key");
$exportSql->execute(array(
    'output_key' => $key
));
$anarow = $exportSql->fetch(PDO::FETCH_ASSOC);
$dil = $anarow['dil'];
if($exportSql->rowCount()<='0'  ) {
 header('Location:'.$ayar['site_url'].'404');
 exit();
}
if(isset($_GET['limit_start']) && $_GET['limit_start'] >'0'  ) {
    $limit_start = htmlspecialchars($_GET['limit_start']);
}else{
    $limit_start = $anarow['limit_start'];
}
if(isset($_GET['limit_end']) && $_GET['limit_end'] >'0'  ) {
    $limit_end = htmlspecialchars($_GET['limit_end']);
}else{
    $limit_end = $anarow['limit_end'];
}
if($anarow['ipler'] == !null ) {
    $iplemeSorgusu = $db->prepare("select * from urun_export where id='$anarow[id]' and (ipler like '%$ipAdres%') ");
    $iplemeSorgusu->execute();
    if($iplemeSorgusu->rowCount()<='0'  ) {
     header('Location:'.$ayar['site_url'].'404');
     exit();
    }
}
if($anarow['kategoriler'] >'0' ) {
  $katsayisi = 0;
  $katAyir = $anarow['kategoriler'];
  $katAyir = explode(',', $katAyir);
  foreach ($katAyir as $katSayi){
      if($katSayi != ''  ) {
       $katsayisi = $katsayisi+1;
      }
  }
  if($katsayisi == '1'  ) {
      $katParsel = $anarow['kategoriler'];
      $katParsel = explode(',', $katParsel);
      foreach ($katParsel as $katRow){
          $kategoriFilter .= "and (iliskili_kat like '%$katRow%')";
      }
  }else{
      $katParsel = $anarow['kategoriler'];
      $katParsel = explode(',', $katParsel);
      $kategoriFilter .= "and (iliskili_kat like ''";
      foreach ($katParsel as $katRow){
          if($katRow !=''  ) {
              $kategoriFilter .= " or iliskili_kat like '%$katRow%' ";
          }
      }
      $kategoriFilter .= ")";
  }
}else{
    $kategoriFilter = null;
}
$moneyCek = $db->prepare("select * from para_birimleri where kod=:kod ");
$moneyCek->execute(array(
    'kod' => $anarow['parabirimi']
));
$moneyrow = $moneyCek->fetch(PDO::FETCH_ASSOC);
$paraFormat = $moneyrow['para_format'];
$urunler = $db->prepare("select * from urun where durum='1' and dil='$dil' $kategoriFilter order by id desc limit $limit_start,$limit_end ");
$urunler->execute();
function kdvhesapla($degers,$degeroran)
{
    $degers = $degers * $degeroran/100;
    return $degers;
}
function kdvcikar($degers,$degeroran)
{
    $degers = $degers / (1+($degeroran/100));
    return $degers;
}
echo '<?xml version="1.0" encoding="UTF-8" ?>';
if($anarow['tur'] == 'standart' ) {
    include 'includes/template/output/standart_format.php';
}
if($anarow['tur'] == 'facebook' ) {
    include 'includes/template/output/facebook.php';
}
if($anarow['tur'] == 'google' ) {
    include 'includes/template/output/google.php';
}
if($anarow['tur'] == 'n11' ) {
    include 'includes/template/output/n11.php';
}
if($anarow['tur'] == 'hepsiburada' ) {
    include 'includes/template/output/hepsiburada.php';
}
if($anarow['tur'] == 'cimri' ) {
    include 'includes/template/output/cimri.php';
}
if($anarow['tur'] == 'akakce' ) {
    include 'includes/template/output/akakce.php';
}
if($anarow['tur'] == 'pttavm' ) {
    include 'includes/template/output/pttavm.php';
}
?>