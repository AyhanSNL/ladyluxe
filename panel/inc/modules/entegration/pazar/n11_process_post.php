<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);

$GETID = htmlspecialchars(strip_tags($_GET['process_id']));

$islemKontrolu = $db->prepare("select * from n11_islem where id=:id ");
$islemKontrolu->execute(array(
        'id' => $GETID,
));
$islemRows = $islemKontrolu->fetch(PDO::FETCH_ASSOC);
$katid = $islemRows['kat_id'];
$oran = $islemRows['oran'];
$yerli = $islemRows['yerli'];
$durumu = $islemRows['urun_durum'];
$gun = $islemRows['gun'];
$sablon = $islemRows['sablon'];

if($islemKontrolu->rowCount()<='0'  ) {
 header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
 exit();
}

$varmiSorgu = $db->prepare("select id from urun where iliskili_kat ='$islemRows[kat_id]'and n11_kuyruk='1' and n11_izin='1' and n11_aktarim='0' and (NOT n11_ozellik = '0' and NOT n11_kat_id = '0' and NOT n11_kod >'0')");
$varmiSorgu->execute(array());
if($varmiSorgu->rowCount()<='0'  ) {
   header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
   exit();
}

$aktarilacak = $db->prepare("select * from urun where iliskili_kat ='$islemRows[kat_id]'and n11_kuyruk='1' and n11_izin='1' and n11_aktarim='0' and (NOT n11_ozellik = '0' and NOT n11_kat_id = '0' and NOT n11_kod >'0')");
$aktarilacak->execute();
$row = $aktarilacak->fetch(PDO::FETCH_ASSOC);
include "inc/modules/entegration/pazar/n11_api.php";
$timestamp = date('Y-m-d G:i:s');


if($yerli == '1'  ) {
    $yerliDurum = true;
}else{
    $yerliDurum = false;
}

$satisfiyat = $row['fiyat'];

if($oran>'0'  ) {
    $oranfiyat = kdvhesapla($satisfiyat,$oran);
    $fiyat = $satisfiyat+$oranfiyat;
}else{
    $fiyat = $satisfiyat;
}



$veri = $row['n11_ozellik'];

$verim = $veri;
$verim = explode('|', $verim);

foreach ($verim as $v){
    $v2 = $v;
    $v2 = explode('_', $v2);
    foreach ($v2 as $a =>$key){
        if($key !='' && $a == '0') {
            $siparisler[]=
                ['name' => ''.$v2[0].'','value' => ''.$v2[1].''];
        }
    }
}

$icerik_cevir  = $row['icerik'];
$eski   = '../i/';
$yeni   = ''.$ayar['site_url'].'i/';
$icerik_cevir = str_replace($eski, $yeni, $icerik_cevir);


if($row['icerik'] == null  ) {
    $icerik = trim(strip_tags($pazar['n11_aciklama']));
}else{
    $icerik = trim(strip_tags($icerik_cevir));
}

$saveProduct = $n11->SaveProduct(
    [
        'productSellerCode' => ''.$row['urun_kod'].'',
        'title' => ''.$row['baslik'].'',
        'subtitle' => ''.$row['baslik'].'',
        'description' => ''.$icerik.'',
        'attributes' =>
            [
                'attribute' =>
                    $siparisler


            ],
        'category' =>
            [
                'id' => $row['n11_kat_id']
            ],
        'price' => $fiyat,
        'currencyType' => 'TL',
        'images' =>
            [
                'image' =>
                    [
                        'url' => ''.$ayar['site_url'].'images/product/'.$row['gorsel'].'',
                        'order' => 1
                    ]
            ],
        'discount' => '0',
        'saleStartDate' => '',
        'saleEndDate' => '',
        'productionDate' => '',
        'expirationDate' => '',
        'productCondition' => ''.$durumu.'',
        'domestic' => $yerliDurum,
        'preparingDay' => ''.$gun.'',
        'shipmentTemplate' => ''.$sablon.'',
        'groupAttribute' => null,
        'groupItemCode' => null,
        'unitInfo' => '',
        'maxPurchaseQuantity' => $row['stok'],
        'itemName' => null,
        'stockItems' =>
            [
                'stockItem' =>
                    [
                        'n11CatalogId' => 0,
                        'quantity' => $row['stok'],
                        'sellerStockCode' => ''.$row['urun_kod'].'',
                        'attributes' =>
                            [
                                'attribute' => []
                            ],
                        'optionPrice' => $fiyat
                    ]
            ]
    ]
);
$durum = $saveProduct->result->status;

if($durum == 'success'  ) {
    $kaydet = $db->prepare("INSERT INTO n11_urun SET
                            urun_id=:urun_id,
                            n11_stok=:n11_stok,
                            n11_foto=:n11_foto,
                            n11_desc=:n11_desc,
                            n11_fiyat=:n11_fiyat
                            ");
    $sonuc = $kaydet->execute(array(
        'urun_id' => $row['id'],
        'n11_stok' => $row['stok'],
        'n11_foto' => ''.$ayar['site_url'].'images/product/'.$row['gorsel'].'',
        'n11_desc' => $icerik,
        'n11_fiyat' => $fiyat
    ));

    $guncelle = $db->prepare("UPDATE n11_islem SET
            durum=:durum,
            tarih=:tarih
     WHERE id={$GETID}      
    ");
    $sonuc = $guncelle->execute(array(
        'durum' => '1',
        'tarih' => $timestamp
    ));

    $guncelle = $db->prepare("UPDATE urun SET
      n11_tarih=:n11_tarih,
      n11_aktarim=:n11_aktarim,
      n11_kuyruk=:n11_kuyruk,
      n11_kod=:n11_kod,
      n11_log=:n11_log               
     WHERE id={$row['id']}      
    ");
    $sonuc = $guncelle->execute(array(
        'n11_tarih' => $timestamp,
        'n11_aktarim' => '1',
        'n11_kuyruk' => '0',
        'n11_kod' => $row['urun_kod'],
        'n11_log' => '0'
    ));

    if($sonuc){
    header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }else{
      header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }

}else{
    $guncelle = $db->prepare("UPDATE n11_islem SET
            durum=:durum,
            tarih=:tarih
     WHERE id={$GETID}      
    ");
    $sonuc = $guncelle->execute(array(
        'durum' => '1',
        'tarih' => $timestamp
    ));
    $guncelle = $db->prepare("UPDATE urun SET
                                    n11_tarih=:n11_tarih,
                                    n11_kuyruk=:n11_kuyruk,
                                    n11_log=:n11_log                                    
                             WHERE id={$row['id']}      
                            ");
    $sonuc = $guncelle->execute(array(
        'n11_tarih' => $timestamp,
        'n11_kuyruk' => '0',
        'n11_log' => json_encode($saveProduct)
    ));
    if($sonuc){
        header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }else{
        header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }
}

?>
<title><?=$diller['pazaryeri-text-42']?> - <?=$panelayar['baslik']?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <style>
            .alt_text{
               width: 600px;
                text-align: center;
            }
            @media screen and (max-width: 374px) and (min-width: 0) {
                .alt_text{
                    width: 100%;
                    text-align: center;
                }
                h2{
                    font-size: 18px ;
                }
            }
            @media screen and (max-width: 767px) and (min-width: 375px) {
                .alt_text{
                    width: 100%;
                    text-align: center;
                }
                h2{
                    font-size: 23px ;
                }
            }
        </style>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') {?>
            <?php if($pazar['n11_durum'] == '1' ) {?>
                <div class="row">



                    <!-- Contents !-->
                    <div class="col-md-12 mt-4" >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <div class="w-100 text-center mt-5 mb-3">
                                        <img src="assets/images/n11_logo.png" >
                                    </div>
                                    <div class="w-100 justify-content-center align-items-center d-flex mb-3 ">
                                        <div class="spinner-grow text-dark" role="status" style="width: 15px; height: 15px;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="ml-2 mr-2">
                                            <h2><?=$diller['pazaryeri-text-55']?></h2>
                                        </div>
                                        <div class="spinner-grow text-dark" role="status" style="width: 15px; height: 15px;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div class="w-100 d-flex align-items-center justify-content-center mb-3">
                                        <div class="spinner-border text-success" role="status" style="width: 65px; height: 65px; margin-left: -12px;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div  class="w-100 d-flex align-items-center justify-content-center mb-5" style="font-size: 20px ;">
                                        <div class="alt_text" >
                                            <?=$diller['pazaryeri-text-56']?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  <========SON=========>>> Contents SON !-->


                </div>
            <?php }else { ?>
                <div class="card p-xl-5">
                    <div class="col-md-12 p-3 text-center">
                        <h3><?=$diller['adminpanel-text-136']?></h3>
                        <h6><?=$diller['pazaryeri-text-15']?></h6>
                    </div>
                </div>
            <?php }?>
        <?php }else { ?>
            <div class="card p-xl-5">
                <h3><?=$diller['adminpanel-text-136']?></h3>
                <h6><?=$diller['adminpanel-text-137']?></h6>
                <div  class="mt-3">
                    <a href="<?=$ayar['panel_url']?>" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                </div>
            </div>
        <?php }?>
    </div>
</div>
