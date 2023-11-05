<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);
$bayino = $pazar['ty_bayi'];
$api = $pazar['ty_api'];
$secret = $pazar['ty_secret'];

$aktarilacak = $db->prepare("select * from trendyol_urun_bilgi where ty_aktarim=:ty_aktarim and ty_kod != '0' and ty_kuyruk=:ty_kuyruk ");
$aktarilacak->execute(array(
    'ty_aktarim' => '1',
    'ty_kuyruk' => '1'
));
$bilgi = $aktarilacak->fetch(PDO::FETCH_ASSOC);
$uruncek = $db->prepare("select stok,fiyat from urun where id=:id and durum=:durum ");
$uruncek->execute(array(
        'id' => $bilgi['urun_id'],
    'durum' => '1',
));
$urun = $uruncek->fetch(PDO::FETCH_ASSOC);

$adet = $urun['stok'];
$fiyat = $urun['fiyat'];
$barkod = $bilgi['ty_kod'];

if($aktarilacak->rowCount() <='0'  ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=ty_aktarilan_urunler');
    exit();
}

if($uruncek->rowCount()>'0'  ) {
    $url = 'https://api.trendyol.com/sapigw/suppliers/'.$bayino.'/products/price-and-inventory';
    $ch = curl_init($url);
    $json='{
                          "items": [
                            {
                              "barcode": "'.$barkod.'",
                              "quantity": '.$adet.',
                              "salePrice": '.$fiyat.',
                              "listPrice": '.$fiyat.'
                            }
                          ]
                        }';
    curl_setopt($ch, CURLOPT_POST, 1);
    $header = array(
        'Authorization: Basic '. base64_encode(''.$api.':'.$secret.''),
        'Content-Type: application/json'
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $json = json_decode($result,true);
    if(isset($json['errors'][0])  ) {
        $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_kuyruk=:ty_kuyruk
                             WHERE id={$bilgi['id']}      
                            ");
        $sonuc = $guncelle->execute(array(
            'ty_kuyruk' => '0'
        ));
        if($sonuc  ) {
            header("Refresh:0; url=$_SERVER[REQUEST_URI]");
        }else{
            header("Refresh:0; url=$_SERVER[REQUEST_URI]");
        }
    }else{
        $supplierId = ''.$bayino.''; // Buraya trendyol tarafından size verilen tedarikçi ID yazılır.
        $username = ''.$api.''; // api kullanıcı adı
        $password = ''.$secret.''; // api şifre
        $authorization = base64_encode($username . ':' . $password);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$supplierId.'/products/batch-requests/'.$json['batchRequestId'].'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT =>0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: ' . $supplierId . ' - SelfIntegration',
                'Authorization: Basic ' . $authorization,
            )
        ));
        $kontrolSonuc = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($kontrolSonuc);
        $jsons = json_decode($kontrolSonuc,true);
        if($jsons['items'][0]['status'] == 'SUCCESS'  ) {
            $timestamp = date('Y-m-d G:i:s');
            $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_tarih=:ty_tarih,
                                    ty_stok=:ty_stok,
                                    ty_kuyruk=:ty_kuyruk,
                                    ty_fiyat=:ty_fiyat
                             WHERE id={$bilgi['id']}      
                            ");
            $sonuc = $guncelle->execute(array(
                'ty_tarih' => $timestamp,
                'ty_stok' => $adet,
                'ty_kuyruk' => '0',
                'ty_fiyat' => $fiyat
            ));
            if($sonuc  ) {
                header("Refresh:0; url=$_SERVER[REQUEST_URI]");
            }else{
                header("Refresh:0; url=$_SERVER[REQUEST_URI]");
            }
        }else{
            $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_kuyruk=:ty_kuyruk
                             WHERE id={$bilgi['id']}      
                            ");
            $sonuc = $guncelle->execute(array(
                'ty_kuyruk' => '0'
            ));
            if($sonuc  ) {
                header("Refresh:0; url=$_SERVER[REQUEST_URI]");
            }else{
                header("Refresh:0; url=$_SERVER[REQUEST_URI]");
            }
        }
    }
}else{
    $silmeislem = $db->prepare("DELETE from trendyol_urun_bilgi WHERE id=:id");
    $sil = $silmeislem->execute(array(
    'id' => $bilgi['id']
    ));
    if ($sil) {
        header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }else {
        header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }
}



// buradan devam.. Ürünleri güncelle..

// sonra da ürünleri çek işlemine gir. O da bitince trendyol siparişleri menusunu ekle ve siparişleri çek.




?>
<title><?=$diller['pazaryeri-text-120']?> - <?=$panelayar['baslik']?></title>

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
            <?php if($pazar['ty_durum'] == '1' ) {?>
                <div class="row">



                    <!-- Contents !-->
                    <div class="col-md-12 mt-4" >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <div class="w-100 text-center mt-5 mb-3">
                                        <img src="assets/images/ty_logo.png" >
                                    </div>
                                    <div class="w-100 justify-content-center align-items-center d-flex mb-3 ">
                                        <div class="spinner-grow text-dark" role="status" style="width: 15px; height: 15px;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="ml-2 mr-2">
                                            <h2><?=$diller['pazaryeri-text-120']?></h2>
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
                                            <?=$diller['pazaryeri-text-118']?>
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
