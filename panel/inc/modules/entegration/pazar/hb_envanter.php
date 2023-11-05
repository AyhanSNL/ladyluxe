<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);

$hbuser = $pazar['hb_user'];
$hbpass = $pazar['hb_pass'];
$hbmerchant = $pazar['hb_merchant'];

$aktarilanlar = $db->prepare("select id from hb_urun_bilgi where hb_aktarim=:hb_aktarim ");
$aktarilanlar->execute(array(
    'hb_aktarim' => '1'
));
$aktarilanSayisi = $aktarilanlar->rowCount();

if(isset($_GET['q'])  ) {
    if(strip_tags(htmlspecialchars($_GET['q'])) != $_GET['q']  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }
    $qGet = '&q='.$_GET['q'].'';
    $qSql = "where (hb_stokkodu like '%$_GET[q]%' or barkod like '%$_GET[q]%' or hb_sku like '%$_GET[q]%')";
}



$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from hb_envanter $qSql   ");
$ToplamVeri = $Say->rowCount();
$Limit = 40;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from hb_envanter $qSql  order by id desc limit $Goster,$Limit");
$islemListeleFetch = $islemListele->fetchAll(PDO::FETCH_ASSOC);


if($_POST) {
    if($yetki['demo'] != '1') {
        if($_POST['merchant'] == 'process'  ) {


            if(isset($_POST['guncelle_btn'])  ) {
                $inv_id = $_POST['inv_id'];
                $sku = $_POST['hb_sku'];
                $msku = $_POST['hb_stokkodu'];
                $barkod = $_POST['barkod'];
                $stok = $_POST['hb_stok'];
                $fiyat = $_POST['hb_fiyat'];
                $kargosure = $_POST['hb_kargo_sure'];
                $stokmax = $_POST['hb_stok_max'];


                $fiyat2= number_format((float)$fiyat, 2, '.', '');

                $price  = $fiyat2;
                $eski   = '.';
                $yeni   = ',';
                $price = str_replace($eski, $yeni, $price);

                $timestamp = date('Y-m-d G:i:s');
                $guncelle = $db->prepare("UPDATE hb_envanter SET
                        hb_yayin=:hb_yayin,
                        tarih=:tarih,
                        hb_fiyat=:hb_fiyat,
                        hb_stok=:hb_stok,
                        hb_stokkodu=:hb_stokkodu,
                        barkod=:barkod,
                        hb_kargo_sure=:hb_kargo_sure,
                        hb_stok_max=:hb_stok_max,
                        hb_sku=:hb_sku
                 WHERE id={$inv_id}      
                ");
                $sonuc = $guncelle->execute(array(
                    'hb_yayin' => '1',
                    'tarih' => $timestamp,
                    'hb_fiyat' => $price,
                    'hb_stok' => $stok,
                    'hb_stokkodu' => $msku,
                    'barkod' => $barkod,
                    'hb_kargo_sure' => $kargosure,
                    'hb_stok_max' => $stokmax,
                    'hb_sku' => $sku
                ));


                $xml = '<?xml version="1.0" encoding="utf-8"?>
<listings xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
        <listing>
            <HepsiburadaSku>'.$sku.'</HepsiburadaSku>
            <MerchantSku>'.$msku.'</MerchantSku>
            <Price>'.$price.'</Price>
            <AvailableStock>'.$stok.'</AvailableStock>
            <DispatchTime>'.$kargosure.'</DispatchTime>
            <MaximumPurchasableQuantity>'.$stokmax.'</MaximumPurchasableQuantity>
            </listing>
</listings>';
                $service_url = 'https://listing-external.hepsiburada.com/listings/merchantid/'.$hbmerchant.'/inventory-uploads';
                //todo canlı mod değiştir yukarı URL
                $curl = curl_init($service_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
                $header = array(
                    'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.''),
                    'Content-Type: application/xml'
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                echo $curl_response = curl_exec($curl);


                $_SESSION['main_alert']='success';
                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                exit();
            }

            if(isset($_POST['satisa_cikar_btn'])  ) {
                $inv_id = $_POST['inv_id'];
                $sku = $_POST['hb_sku'];
                $msku = $_POST['hb_stokkodu'];
                $barkod = $_POST['barkod'];
                $stok = $_POST['hb_stok'];
                $fiyat = $_POST['hb_fiyat'];
                $kargo = $_POST['hb_kargo'];
                $kargosure = $_POST['hb_kargo_sure'];
                $stokmax = $_POST['hb_stok_max'];


                if($kargo == !null  ) {
                    $kargoson = $kargo;
                }else{
                    $kargoson = 'Aras Kargo';
                }
                $fiyat2= number_format((float)$fiyat, 2, '.', '');

                $price  = $fiyat2;
                $eski   = '.';
                $yeni   = ',';
                $price = str_replace($eski, $yeni, $price);

                $timestamp = date('Y-m-d G:i:s');
                $guncelle = $db->prepare("UPDATE hb_envanter SET
                        hb_yayin=:hb_yayin,
                        tarih=:tarih,
                        hb_fiyat=:hb_fiyat,
                        hb_stok=:hb_stok,
                        hb_stokkodu=:hb_stokkodu,
                        barkod=:barkod,
                        hb_kargo=:hb_kargo,
                        hb_kargo_sure=:hb_kargo_sure,
                        hb_stok_max=:hb_stok_max,
                        hb_sku=:hb_sku
                 WHERE id={$inv_id}      
                ");
                $sonuc = $guncelle->execute(array(
                    'hb_yayin' => '1',
                    'tarih' => $timestamp,
                    'hb_fiyat' => $price,
                    'hb_stok' => $stok,
                    'hb_stokkodu' => $msku,
                    'barkod' => $barkod,
                    'hb_kargo' => $kargoson,
                    'hb_kargo_sure' => $kargosure,
                    'hb_stok_max' => $stokmax,
                    'hb_sku' => $sku
                ));


                $xml = '<?xml version="1.0" encoding="utf-8"?>
<listings xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
        <listing>
            <HepsiburadaSku>'.$sku.'</HepsiburadaSku>
            <MerchantSku>'.$msku.'</MerchantSku>
            <Price>'.$price.'</Price>
            <AvailableStock>'.$stok.'</AvailableStock>
            <DispatchTime>'.$kargosure.'</DispatchTime>
            <MaximumPurchasableQuantity>'.$stokmax.'</MaximumPurchasableQuantity>
            <CargoCompany1>'.$kargoson.'</CargoCompany1>
            </listing>
</listings>';
                $service_url = 'https://listing-external.hepsiburada.com/listings/merchantid/'.$hbmerchant.'/inventory-uploads';
                //todo canlı mod değiştir yukarı URL
                $curl = curl_init($service_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
                $header = array(
                    'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.''),
                    'Content-Type: application/xml'
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                echo $curl_response = curl_exec($curl);



                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                exit();
            }
         
            if(isset($_POST['satisa_ac_btn'])  ) {
                $inv_id = $_POST['inv_id'];
                $sku = $_POST['hb_sku'];
                $timestamp = date('Y-m-d G:i:s');
                $guncelle = $db->prepare("UPDATE hb_envanter SET
                        hb_yayin=:hb_yayin,
                        tarih=:tarih,
                        hb_sku=:hb_sku
                 WHERE id={$inv_id}      
                ");
                $sonuc = $guncelle->execute(array(
                    'hb_yayin' => '1',
                    'tarih' => $timestamp,
                    'hb_sku' => $sku
                ));

                $url = 'https://listing-external.hepsiburada.com/listings/merchantid/'.$hbmerchant.'/sku/'.$sku.'/activate';
                //todo canlı mod değiştir yukarı URL


                $header = array(
                    'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

                $as = curl_exec($ch);
                $ass = simplexml_load_string($as);

                echo "<pre>";
                print_r($ass);
                echo "</pre>";


                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                exit();
            }

            if(isset($_POST['inv_trash'])  ) {
                $inv_id = $_POST['inv_id'];
                $sku = $_POST['hb_sku'];
                $msku = $_POST['hb_msku'];

               $silmeislem = $db->prepare("DELETE from hb_envanter WHERE id=:id ");
               $sil = $silmeislem->execute(array(
               'id' => $inv_id
               ));


                $url = 'https://listing-external.hepsiburada.com/listings/merchantid/'.$hbmerchant.'/sku/'.$sku.'/merchantsku/'.$msku.'';
                //todo canlı mod değiştir yukarı URL
                $service_url = $url;
                $curl = curl_init($service_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                $header = array(
                    'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                $curl_response = curl_exec($curl);


                $ss = json_decode($curl_response);


                echo "<pre>";
                var_dump($ss);
                echo "</pre>";


                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                exit();
            }

            if(isset($_POST['satisa_kapat_btn'])  ) {
                $inv_id = $_POST['inv_id'];
                $sku = $_POST['hb_sku'];
                $timestamp = date('Y-m-d G:i:s');
                $guncelle = $db->prepare("UPDATE hb_envanter SET
                        hb_yayin=:hb_yayin,
                        tarih=:tarih,
                        hb_sku=:hb_sku
                 WHERE id={$inv_id}      
                ");
                $sonuc = $guncelle->execute(array(
                    'hb_yayin' => '0',
                    'tarih' => $timestamp,
                    'hb_sku' => $sku
                ));

                $url = 'https://listing-external.hepsiburada.com/listings/merchantid/'.$hbmerchant.'/sku/'.$sku.'/deactivate';
                //todo canlı mod değiştir yukarı URL

                $header = array(
                    'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

                $as = curl_exec($ch);
                $ass = simplexml_load_string($as);

                echo "<pre>";
                print_r($ass);
                echo "</pre>";

                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                exit();
            }

            if(isset($_POST['trash'])  ) {

                $IDler = $_POST['item_id'];
                foreach ($_POST['item_id'] as $a){
                    $silmeislem = $db->prepare("DELETE from hb_urun_bilgi WHERE id=:id");
                    $sil = $silmeislem->execute(array(
                    'id' => $a
                    ));
                }
                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                exit();
            }

            if(isset($_POST['inventory'])  ) {
                $IDler = $_POST['item_id'];
                foreach ($_POST['item_id'] as $a){
                    $sor = $db->prepare("select * from hb_urun_bilgi where id=:id and hb_durumu=:hb_durumu");
                    $sor->execute(array(
                            'id' => $a,
                            'hb_durumu' => 'Satışa Hazır'
                    ));
                    
                    if($sor->rowCount()>'0' ) {
                     $row = $sor->fetch(PDO::FETCH_ASSOC);
                     $kaydet = $db->prepare("INSERT INTO hb_envanter SET
                            urun_id=:urun_id, 
                            hb_sku=:hb_sku,
                            hb_fiyat=:hb_fiyat,
                            hb_stok=:hb_stok,
                            hb_yayin=:hb_yayin
                     ");
                     $sonuc = $kaydet->execute(array(
                         'urun_id' => $row['urun_id'],
                         'hb_sku' => $row['hb_kod'],
                         'hb_fiyat' => $row['hb_fiyat'],
                         'hb_stok' => $row['hb_stok'],
                         'hb_yayin' => '0'
                     ));
                     if($sonuc){
                        $silmeislem = $db->prepare("DELETE from hb_urun_bilgi WHERE id=:id");
                        $sil = $silmeislem->execute(array(
                        'id' => $a
                        ));
                     }
                    }else{
                    $_SESSION['main_alert'] = 'hb_envanter_go_sorun';
                    }
                }
                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                exit();
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
            exit();
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
        exit();
    }
}



?>
<title><?=$diller['pazaryeri-text-167']?> - <?=$panelayar['baslik']?></title>
<style>
    .ust-pazar-header{
        width: 100%;
        display: flex;
        justify-content: flex-start;
        flex-wrap:wrap ;
        margin-bottom: 20px;
    }
    .ust-pazar-header-logo{
        width: 185px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border-right: 2px solid #EBEBEB;
        margin-right: 30px;
    }
    .ust-pazar-header-text{
        width: auto;
        font-size: 20px ;
        font-weight: 600;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ust-pazar-header-link{
        margin-left: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pazar-alert-ul{
        margin-bottom: 0;
        margin-top: 10px;
        font-size: 14px ;
    }
    .pazar-alert-ul li{
        margin-bottom: 10px;
    }

    @media screen and (max-width: 768px) and (min-width: 0)  {
        .ust-pazar-header-logo{
            width: 100%;
            border-right:0;
            margin-right: 0;
            justify-content: center;
            margin-bottom: 10px;
        }
        .ust-pazar-header-text{
            text-align: center;
            width: 100%;
            margin-bottom: 10px;
        }
        .ust-pazar-header-link{
            margin-left: 0;
            width: 100%;
            text-align: center;
            display: block;
        }
        .ust-pazar-header-link a{
            display: block !important;
        }
        .pazar-alert-ul{
            margin-bottom: 0;
            margin-top: 10px;
            font-size: 14px ;
            padding:15px;
            width: 100%;
        }
        .pazar-alert-ul li{
            margin-bottom: 10px;
        }
    }
    .urun_serch{
        width: 500px;
        margin:30px 0;
        position: relative;
    }
    .urun_serch input{
        border-radius: 0 !important;
    }
    .urun_serch button{
        border: 0;
        background-color: transparent;
        position: absolute;
        top:6px;
        right: 6px;
        font-size: 18px ;
        color: tomato;
    }
    .ust-secr{
             display: flex;
             align-items: center;
             justify-content: space-between;
             flex-wrap: wrap;
         }
    .hb-envanter-in{
        width: 100%;
        text-align: center;
        padding: 50px;
    }
    .hb-envanter-h{
        font-size: 30px ;
        font-weight: 600;
    }
    .hb-envanter-s{
        font-size: 14px ;
    }
    .hb-envanter-form{
        width: 80%;
        margin: 0 auto;
        margin-top: 40px;
        text-align: left;
    }
    .select2-container--default .select2-selection--single{
        border-radius: 0 !important;
        height: 70px;
    }
    .select2, .select2-results__option {
        font-size: 18px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: tomato !important;
        line-height: 70px;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: tomato !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered{
        padding-left: 30px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 50%;
        bottom:50%;
        margin-top: auto;
        margin-bottom: auto;
        right: 10px;
        width: 20px;
    }
    .inv-btb{
        background-color: #ff7c35;
        color: #FFF;
        font-size: 20px ;
        cursor: pointer;
        border: 0;
        padding: 15px !important;
        border-radius: 4px;
    }
</style>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-86']?></a>
                                <a href="pages.php?page=hb_process"><i class="fa fa-angle-right"></i> Hepsiburada <?=$diller['pazaryeri-text-100']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-167']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') {?>
            <?php if($pazar['hb_durum'] == '1' ) {?>
                <div class="row">
                    <!-- Contents !-->
                    <div class="col-md-12" >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <div class="border-bottom pb-1 mb-3">
                                        <a href="pages.php?page=hb_process" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                            <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                        </a>
                                    </div>
                                    <div class="ust-pazar-header">
                                        <div class="ust-pazar-header-logo">
                                            <img src="assets/images/hb_logo.png">
                                        </div>
                                        <div class="ust-pazar-header-text">
                                            <?=$diller['pazaryeri-text-167']?>
                                        </div>
                                    </div>
                                        <div class="w-100 border p-3 mb-2 up-arrow-2 rounded-0 alert alert-dismissible bg-light border text-dark">
                                            <div>
                                                <ul class="pazar-alert-ul">
                                                    <?=$diller['pazaryeri-text-185']?>
                                                </ul>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                    <div class="w-100 border mb-1 mt-3 rounded-0  border text-dark">
                                      <div class="hb-envanter-in">
                                          <div class="hb-envanter-h">
                                              <?=$diller['pazaryeri-text-167']?>
                                          </div> 
                                          <div class="hb-envanter-s">
                                              <?=$diller['pazaryeri-text-195']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-196']?>"></i>
                                          </div>
                                          <form action="post.php?process=hb_post&status=hb_inventory_item_add" method="post">
                                              <div class="hb-envanter-form">
                                                  <div class="row">
                                                      <div class="col-md-12 form-group">
                                                          <select class="urunler_select form-control col-md-12" name="inv_product_id"  required id="inv_product_id" style="width: 100%!important; height: 60px !important;"  >
                                                          </select>
                                                      </div>
                                                      <div class="col-md-12 form-group ">
                                                          <div class="kustom-checkbox">
                                                              <input type="hidden" name="sku_durum" value="0" >
                                                              <input type="checkbox" class="individual" id="sku_durum" name='sku_durum' value="1" onclick="actionBox(this.checked);">
                                                              <label for="sku_durum"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                  <?=$diller['pazaryeri-text-197']?>
                                                              </label>
                                                          </div>
                                                      </div>
                                                      <div id="actionBox" class="col-md-12 mb-4" style="display:none !important;" >
                                                          <div class="border bg-light  p-3 up-arrow-2">
                                                              <div class="row">
                                                                  <div class="form-group col-md-6 mb-2">
                                                                      <input type="text" name="hb_sku" id="" autocomplete="off" placeholder="<?=$diller['pazaryeri-text-198']?>" class="form-control rounded-0">
                                                                  </div>
                                                                  <div class="form-group col-md-6 mb-0">
                                                                      <input type="text" name="hb_stokkodu" id="" autocomplete="off" placeholder="<?=$diller['pazaryeri-text-214']?>" class="form-control rounded-0">
                                                                  </div>
                                                                  <div class="col-md-12">
                                                                      <div class=" rounded-0 mt-2 text-primary">
                                                                          <?=$diller['pazaryeri-text-199']?>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-12 form-group ">
                                                         <button class="w-100 p-2 inv-btb">
                                                             <?=$diller['pazaryeri-text-200']?>
                                                         </button>
                                                      </div>
                                                     <script id="rendered-js" >
                                                                        function actionBox(selected)
                                                                        {
                                                                            if (selected)
                                                                            {
                                                                                document.getElementById("actionBox").style.display = "";
                                                                            } else

                                                                            {
                                                                                document.getElementById("actionBox").style.display = "none";
                                                                            }

                                                                        }
                                                     </script>
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('.urunler_select').select2({
                                                maximumSelectionLength: 6,
                                                placeholder: ' <?=$diller['adminpanel-form-text-880']?>',
                                                ajax: {
                                                    url: 'masterpiece.php?page=headermenu_product_select',
                                                    dataType: 'json',
                                                    delay: 250,
                                                    data: function (data) {
                                                        return {
                                                            q: data.term
                                                        };
                                                    },
                                                    processResults: function (data) {
                                                        return {
                                                            results: data
                                                        };
                                                    },
                                                    cache: true
                                                }

                                            });
                                        });
                                    </script>

                                    <?php if($ToplamVeri>'0'  ) {?>
                                        <div class="w-100">
                                            <div class="ust-secr">
                                                <div class="urun_serch">
                                                    <form action="pages.php" method="get">
                                                        <input type="hidden" name="page" value="hb_envanter">
                                                        <?php if(isset($_GET['show']) && $_GET['show'] == 'open'  ) {?>
                                                            <input type="hidden" name="show" value="open">
                                                        <?php }?>
                                                        <?php if(isset($_GET['show']) && $_GET['show'] == 'close'  ) {?>
                                                            <input type="hidden" name="show" value="close">
                                                        <?php }?>
                                                        <input type="text" name="q"  autocomplete="off" placeholder="<?=$diller['pazaryeri-text-192']?>" id="" required   class="form-control">
                                                        <button type="submit">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </form>
                                                    <?php if(isset($_GET['q'])  ) {?>
                                                        <div class="w-100">
                                                            <a href="pages.php?page=hb_envanter<?=$opGet?>" class="btn btn-sm btn-danger mt-3">
                                                                <?=$_GET['q']?> <i class="fa fa-times"></i>
                                                            </a>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>

                                    <?php if($ToplamVeri<='0'  ) {?>
                                        <div class="rounded border p-xl-5 text-center" >
                                            <h5 style="font-weight: 100 !important;"><?=$diller['pazaryeri-text-60']?></h5>
                                            <?php if(isset($_GET['q']) || isset($_GET['show']) ) {?>
                                                <a href="pages.php?page=hb_envanter" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                                            <?php }?>
                                        </div>
                                    <?php }else { ?>
                                        <form method="post" action="pages.php?page=hb_envanter">
                                            <input type="hidden" name="merchant" value="process">
                                            <div class="table-responsive ">
                                                <table class="table table-bordered table-hover mb-0  ">
                                                    <thead class="thead-default">
                                                    <tr>
                                                        <th class="text-center"><?=$diller['pazaryeri-text-186']?></th>
                                                        <th><?=$diller['adminpanel-form-text-940']?></th>
                                                        <th  class="text-center"><?=$diller['adminpanel-form-text-1767']?></th>
                                                        <th  class="text-center"><?=$diller['adminpanel-form-text-1765']?></th>
                                                        <th class="text-center"><?=$diller['pazaryeri-text-187']?></th>
                                                        <th class="text-center"><?=$diller['pazaryeri-text-191']?></th>
                                                        <th class="text-center"><?=$diller['adminpanel-form-text-1781']?></th>
                                                        <th><?=$diller['adminpanel-form-text-1356']?></th>
                                                        <th  class="text-center" ></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody  >
                                                    <?php foreach ($islemListeleFetch as $row) {
                                                        $uruncek = $db->prepare("select baslik,id,stok,fiyat from urun where id=:id ");
                                                        $uruncek->execute(array(
                                                            'id' => $row['urun_id']
                                                        ));
                                                        $urun = $uruncek->fetch(PDO::FETCH_ASSOC);

                                                        ?>
                                                        <?php if($uruncek->rowCount()>'0'  ) {?>
                                                            <tr>
                                                                <td style="min-width: 150px; text-align: center;" width="150"   >

                                                                    <?php if($row['hb_yayin'] == '0') {?>
                                                                        <?php if($row['hb_sku'] == !null ) {?>
                                                                            <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn-block mb-1 satisa_ac btn btn-sm btn-success ">
                                                                                <?=$diller['pazaryeri-text-193']?>
                                                                            </a>
                                                                        <?php }else { ?>
                                                                            <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn-block mb-1 satisa_cikar btn btn-sm btn-success ">
                                                                                <?=$diller['pazaryeri-text-188']?>
                                                                            </a>
                                                                        <?php }?>
                                                                        <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn-block mb-1 envanter_trash  btn btn-outline-danger btn-sm ">
                                                                            <?=$diller['pazaryeri-text-190']?>
                                                                        </a>
                                                                    <?php }?>

                                                                    <?php if($row['hb_yayin'] == '1' ) {?>
                                                                        <a  href="javascript:Void(0)" data-id="<?=$row['id']?>" class="satisi_durdur btn-block mb-1 btn btn-sm btn-danger ">
                                                                            <?=$diller['pazaryeri-text-189']?>
                                                                        </a>
                                                                        <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="guncelle btn btn-primary btn-block btn-sm mb-1 ">
                                                                            <?=$diller['pazaryeri-text-22']?>
                                                                        </a>
                                                                    <?php }?>
                                                                </td>
                                                                <td style="min-width: 200px" width="200"  >
                                                                    <?=$urun['baslik']?>
                                                                </td>
                                                                <td style="min-width: 90px; text-align: center; font-weight: 500;" width="90"   >
                                                                    <?=$row['hb_stok']?>
                                                                </td>
                                                                <td style="min-width: 150px; text-align: center; font-weight: 500;" width="150"   >
                                                                    <?=$row['hb_fiyat']?>
                                                                </td>
                                                                <td style="min-width: 150px; text-align: center;" width="150"   >
                                                                    <?php if($row['hb_sku'] == !null  ) {?>
                                                                        <?=$row['hb_sku']?>
                                                                    <?php }else { ?>
                                                                        <i class="fa fa-ban"></i>
                                                                    <?php }?>
                                                                </td>
                                                                <td style="min-width: 150px; text-align: center; font-weight: 500;" width="150"   >
                                                                    <?=$row['hb_stokkodu']?>
                                                                </td>
                                                                <td style="min-width: 150px; text-align: center; font-weight: 500;" width="150"   >
                                                                    <?=$row['barkod']?>
                                                                </td>
                                                                <td style="min-width: 165px" width="165" >
                                                                    <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                                                </td>
                                                                <td style="min-width: 100px" width="100"  >
                                                                    <div class="w-100 d-flex align-items-center justify-content-center ">
                                                                        <?php if($row['hb_yayin'] == '1' ) {?>
                                                                            <a href="https://www.hepsiburada.com/phptema-p-<?=$row['hb_sku']?>" class="btn btn-sm btn-dark mr-1" target="_blank" data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-194']?>"><i class="fa fa-external-link-alt" ></i></a>
                                                                        <?php }?>
                                                                        <a href="pages.php?page=product_detail&productID=<?=$row['urun_id']?>" class="btn btn-sm btn-primary mr-1" target="_blank" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-115']?>"><i class="fa fa-eye" ></i></a>
                                                                        <a href="pages.php?page=product_detail_entegration_hb&productID=<?=$row['urun_id']?>" target="_blank" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-13']?>"><i class="fas fa-store-alt"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php }?>
                                                    <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Kaydırılabilir Alert !-->
                                            <div class="d-md-none d-sm-block p-2 bg-light  text-center">
                                                <?=$diller['adminpanel-text-340']?> <i class="fas fa-hand-pointer"></i>
                                            </div>
                                            <!--  <========SON=========>>> Kaydırılabilir Alert SON !-->
                                        </form>
                                        <?php if($ToplamVeri > $Limit  ) {?>
                                            <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light border-top  ">
                                                <?php if($Sayfa >= 1){?>
                                                <nav aria-label="Page navigation example " >
                                                    <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                                        <?php } ?>
                                                        <?php if($Sayfa > 1){  ?>
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=hb_envanter<?=$qGet?><?=$opGet?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=hb_envanter&p=<?=$Sayfa - 1?><?=$qGet?><?=$opGet?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                        <?php } ?>
                                                        <?php
                                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                            if($i == $Sayfa){
                                                                ?>
                                                                <li class="page-item active " aria-current="page">
                                                                    <a class="page-link" href="pages.php?page=hb_envanter&p=<?=$i?><?=$qGet?><?=$opGet?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                                </li>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <li class="page-item "><a class="page-link" href="pages.php?page=hb_envanter&p=<?=$i?><?=$qGet?><?=$opGet?>"><?=$i?></a></li>
                                                                <?php
                                                            }
                                                        }
                                                        }
                                                        ?>

                                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=hb_envanter&p=<?=$Sayfa + 1?><?=$qGet?><?=$opGet?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=hb_envanter&p=<?=$Sayfa_Sayisi?><?=$qGet?><?=$opGet?>"><?=$diller['sayfalama-son']?></a></li>
                                                            <?php }} ?>
                                                        <?php if($Sayfa >= 1){?>
                                                    </ul>
                                                </nav>
                                            <?php } ?>
                                            </div>
                                        <?php }?>
                                    <?php } ?>

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
                        <h6><?=$diller['pazaryeri-text-151']?></h6>
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


<script>
        $(document).ready(function(){

        $('.satisa_ac').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_satisa_ac',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
        $(document).ready(function(){

        $('.satisa_cikar').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_satisa_cikar',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
            $(document).ready(function(){

        $('.satisi_durdur').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_satisi_durdur',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
            $(document).ready(function(){

        $('.envanter_trash').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_env_sil',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
            $(document).ready(function(){

        $('.guncelle').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_guncelle_envanter',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
</script>