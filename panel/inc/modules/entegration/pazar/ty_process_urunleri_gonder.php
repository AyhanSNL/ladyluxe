<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);




$aktarilacak = $db->prepare("select * from trendyol_urun_bilgi where ty_aktarim=:ty_aktarim and ty_marka != '0' and ty_kat != '0' and ty_kuyruk=:ty_kuyruk and ty_izin=:ty_izin");
$aktarilacak->execute(array(
    'ty_aktarim' => '0',
    'ty_kuyruk' => '1',
    'ty_izin' => '1',
));
$bilgi = $aktarilacak->fetch(PDO::FETCH_ASSOC);

if($aktarilacak->rowCount() <='0'  ) {
 header('Location:'.$ayar['panel_url'].'pages.php?page=ty_process');
 exit();
}

    $urun = $db->prepare("select * from urun where id=:id ");
    $urun->execute(array(
        'id' => $bilgi['urun_id']
    ));
    if($urun->rowCount()>'0'  ) {
        $row = $urun->fetch(PDO::FETCH_ASSOC);
        $bayino = $pazar['ty_bayi'];
        $api = $pazar['ty_api'];
        $secret = $pazar['ty_secret'];
        $baslik = $row['baslik'];
        $stokkodu = $row['urun_kod'];
        $markaID = $bilgi['ty_marka'];
        $categoryID = $bilgi['ty_kat'];
        $adet = $row['stok'];
        $IDproduct = $row['id'];
        $kdvorancek = $row['kdv_oran'];

        if($kdvorancek <='0'  ) {
            $kdvoran = '18';
        }else{
            $kdvoran = $kdvorancek;
        }

        /* Barkod */
        if($row['barkod'] == !null ) {
            $barkodGetir = $row['barkod'];
        }else{
            $barkodGetir = $row['urun_kod'];
        }
        /*  <========SON=========>>> Barkod SON */

        $oran = $_POST['ek_oran'];
        $satisfiyat = $row['fiyat'];

        if($oran>'0'  ) {
            $oranfiyat = kdvhesapla($satisfiyat,$oran);
            $fiyat = $satisfiyat+$oranfiyat;
        }else{
            $fiyat = $satisfiyat;
        }

        $veri = $bilgi['ty_ozellik'];
        $verim = $veri;
        $verim = explode('|', $verim);

        foreach ($verim as $v){
            $v2 = $v;
            $v2 = explode('_', $v2);
            foreach ($v2 as $a =>$key){
                if($key !='' && $a == '0') {
                    if(is_numeric($v2[1])  ) {
                        $siparisler[]=
                            ['attributeId' => "$v2[0]",'attributeValueId' => "$v2[1]"];
                    }else{
                        $siparisler[]=
                            ['attributeId' => "$v2[0]",'customAttributeValue' => "$v2[1]"];
                    }
                }
            }
        }
        $sip = json_encode($siparisler);

        if($row['icerik'] == !null  ) {
            $icerik_cek  = $row['icerik'];
            $eski   = '../i/';
            $yeni   = ''.$ayar['site_url'].'i/';
            $icerik_cek = str_replace($eski, $yeni, $icerik_cek);
            $icerik = trim(strip_tags($icerik_cek));
        }else{
            $icerik = $baslik;
        }

        $resim = ''.$ayar['site_url'].'images/product/'.$row['gorsel'].'';


        $url = 'https://api.trendyol.com/sapigw/suppliers/'.$bayino.'/v2/products';
        $ch = curl_init($url);
        $json='{
                                  "items": [
                                    {
                                      "barcode": "'.$barkodGetir.'",
                                      "title": "'.$baslik.'",
                                      "productMainId": "'.$IDproduct.'",
                                      "brandId": '.$markaID.',
                                      "categoryId": '.$categoryID.',
                                      "quantity": '.$adet.',
                                      "stockCode": "'.$stokkodu.'",
                                      "dimensionalWeight": 1,
                                      "description": "'.$icerik.'",
                                      "currencyType": "TRY",
                                      "listPrice": '.$fiyat.',
                                      "salePrice": '.$fiyat.',
                                      "vatRate": '.$kdvoran.',
                                      "cargoCompanyId": '.$pazar['ty_kargo'].',
                                          "attributes": 
                                            '.$sip.'
                                          ,
                                      "images": [
                                        {
                                          "url": "'.$resim.'"
                                        }
                                      ]
                                    }
                                  ]
                               } ';

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
            /* Ürün başarısız. Mesajı log kaydına ekle. */
            if(isset($json['errors'][0]['message'])  ) {
                $errormesaj = json_encode($json['errors'][0]['message']);
            }else{
                $errormesaj = 'Hatalar var! <br>Kategori veya marka seçiminizi kontrol edin.<br>Ayrıca kategori özelliklerinizi seçmeyi unutmayın.<br>Ayrıca ürün açıklamanızı, barkodunuzu ve stok kodunuzu da girdiğinizden emin olun.';
            }
            $timestamp = date('Y-m-d G:i:s');
            $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_log=:ty_log,
                                    ty_kuyruk=:ty_kuyruk,
                                    ty_tarih=:ty_tarih
                             WHERE urun_id={$row['id']}      
                            ");
            $sonuc = $guncelle->execute(array(
                'ty_log' => $errormesaj,
                'ty_kuyruk' => '0',
                'ty_tarih' => $timestamp,
            ));
            if($sonuc  ) {
                header("Refresh:0; url=$_SERVER[REQUEST_URI]");
            }else{
                header("Refresh:0; url=$_SERVER[REQUEST_URI]");
            }
        }else{
            /* Başarılı */
            $authorization = base64_encode($api . ':' . $secret);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$bayino.'/products/batch-requests/'.$json['batchRequestId'].'',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT =>0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'User-Agent: ' . $bayino . ' - SelfIntegration',
                    'Authorization: Basic ' . $authorization,
                )
            ));
            $kontrolSonuc = curl_exec($curl);
            curl_close($curl);
            $json = json_decode($kontrolSonuc);
            $jsons = json_decode($kontrolSonuc,true);
            if($jsons['status'] == 'SUCCESS' || $jsons['status'] == 'IN_PROGRESS' || $jsons['status'] == 'COMPLETED'  ) {
                $timestamp = date('Y-m-d G:i:s');
                $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_aktarim=:ty_aktarim,
                                    ty_kod=:ty_kod,
                                    ty_log=:ty_log,
                                    ty_kuyruk=:ty_kuyruk,
                                    ty_tarih=:ty_tarih,
                                    ty_stok=:ty_stok,
                                    ty_fiyat=:ty_fiyat
                             WHERE urun_id={$row['id']}      
                            ");
                $sonuc = $guncelle->execute(array(
                    'ty_aktarim' => '1',
                    'ty_kod' => $barkodGetir,
                    'ty_log' => '0',
                    'ty_kuyruk' => '0',
                    'ty_tarih' => $timestamp,
                    'ty_stok' => $adet,
                    'ty_fiyat' => $fiyat
                ));
                if($sonuc  ) {
                    header("Refresh:0; url=$_SERVER[REQUEST_URI]");
                }else{
                    header("Refresh:0; url=$_SERVER[REQUEST_URI]");
                }
            }else{
                $timestamp = date('Y-m-d G:i:s');
                $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_log=:ty_log,
                                    ty_kuyruk=:ty_kuyruk,
                                    ty_tarih=:ty_tarih
                             WHERE urun_id={$row['id']}      
                            ");
                $sonuc = $guncelle->execute(array(
                    'ty_log' => json_encode($jsons['items'][0]['failureReasons']),
                    'ty_kuyruk' => '0',
                    'ty_tarih' => $timestamp,
                ));
                if($sonuc  ) {
                    header("Refresh:0; url=$_SERVER[REQUEST_URI]");
                }else{
                    header("Refresh:0; url=$_SERVER[REQUEST_URI]");
                }
            }



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
