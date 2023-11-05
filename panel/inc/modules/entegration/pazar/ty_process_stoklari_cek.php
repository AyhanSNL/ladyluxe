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
function replace_tr($text) {
    $text = trim($text);
    $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
    $replace = array('C','c','G','G','i','I','O','o','S','s','U','u');
    $new_text = str_replace($search,$replace,$text);
    return $new_text;
}
$aktarilacak = $db->prepare("select * from trendyol_urun_bilgi where ty_aktarim=:ty_aktarim and ty_kod != '0' and ty_kuyruk=:ty_kuyruk ");
$aktarilacak->execute(array(
    'ty_aktarim' => '1',
    'ty_kuyruk' => '1',
));
$bilgi = $aktarilacak->fetch(PDO::FETCH_ASSOC);

if($aktarilacak->rowCount() <='0'  ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=ty_aktarilan_urunler');
    exit();
}

$kodcek = $bilgi['ty_kod'];
$tyKod = replace_tr($kodcek);
$supplierId = ''.$bayino.'';
$username = ''.$api.'';
$password = ''.$secret.'';
$authorization = base64_encode($username . ':' . $password);
$timestamp = date('Y-m-d G:i:s');
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$supplierId.'/products?barcode='.$tyKod.'',
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

$ProductResult = curl_exec($curl);
curl_close($curl);
$json = json_decode($ProductResult,true);

if($json['totalElements'] == '0' ) {
    $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_kuyruk=:ty_kuyruk
                             WHERE urun_id={$bilgi['urun_id']}      
                            ");
    $sonuc = $guncelle->execute(array(
        'ty_kuyruk' => '0'
    ));
    if($sonuc){
        header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }else{
        header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }
}
if($json['totalElements'] == '1' ) {

    $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_tarih=:ty_tarih,
                                    ty_kuyruk=:ty_kuyruk,           
                                    ty_fiyat=:ty_fiyat,
                                    ty_stok=:ty_stok
                             WHERE urun_id={$bilgi['urun_id']}      
                            ");
    $sonuc = $guncelle->execute(array(
            'ty_tarih' => $timestamp,
            'ty_kuyruk' => '0',
        'ty_fiyat' => $json['content'][0]['salePrice'],
        'ty_stok' => $json['content'][0]['quantity']
    ));
    if($sonuc){
        header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }else{
        header("Refresh:0; url=$_SERVER[REQUEST_URI]");
    }

}





?>
<title><?=$diller['pazaryeri-text-115']?> - <?=$panelayar['baslik']?></title>

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
                                            <h2><?=$diller['pazaryeri-text-117']?></h2>
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
