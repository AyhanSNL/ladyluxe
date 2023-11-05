<?php
$pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
$pazarYeri->execute();
$pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'hb';

$urunBilgisi = $db->prepare("select * from urun where id=:id and dil=:dil ");
$urunBilgisi->execute(array(
        'id' => $_GET['productID'],
        'dil' => $_SESSION['dil'],
));
if($urunBilgisi->rowCount()>'0' ) {
    $row = $urunBilgisi->fetch(PDO::FETCH_ASSOC);
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=products');
    exit();
}


$BilgiSorgu = $db->prepare("select * from hb_urun_bilgi where urun_id=:urun_id ");
$BilgiSorgu->execute(array(
        'urun_id' => $_GET['productID']
));

$EnvSorgu = $db->prepare("select * from hb_envanter where urun_id=:urun_id ");
$EnvSorgu->execute(array(
        'urun_id' => $_GET['productID'],
));

$pazarDevSql = $db->prepare("select hb_user,hb_pass,hb_merchant from pazaryeri where id=:id ");
$pazarDevSql->execute(array(
    'id' => '1'
));
$pazarDevRow = $pazarDevSql->fetch(PDO::FETCH_ASSOC);


$hbuser = $pazarDevRow['hb_user'];
$hbpass = $pazarDevRow['hb_pass'];
$hbmerchant = $pazarDevRow['hb_merchant'];

if($_POST  ) {
if($yetki['demo'] != '1') {

    if($_POST['process'] == 'inv_item_add'  ) {


        $urunc = $db->prepare("select fiyat, stok, barkod, urun_kod from urun where id=:id ");
        $urunc->execute(array(
            'id' => $_POST['product_id']
        ));
        $urun = $urunc->fetch(PDO::FETCH_ASSOC);

        if($urun['barkod'] == !null ) {
            $barkod = $urun['barkod'];
        }else{
            $barkod = $urun['urun_kod'];
        }

        if($_POST['sku_durum'] == '1'  ) {
            $sku = $_POST['hb_sku'];
            $msku = $_POST['hb_stokkodu'];
        }else{
            $sku = null;
            $msku = null;
        }


        if($_POST['sku_durum'] == '1'  ) {
            if($_POST['hb_sku'] == null  ) {
                $_SESSION['main_alert'] = 'hb_sku_bos';
                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_hb&productID='.$_POST['product_id'].'');
                exit();
            }
            if($_POST['hb_stokkodu'] == null  ) {
                $_SESSION['main_alert'] = 'hb_stokkod_bos';
                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_hb&productID='.$_POST['product_id'].'');
                exit();
            }
        }

        $timestamp = date('Y-m-d G:i:s');
        $kaydet = $db->prepare("INSERT INTO hb_envanter SET
                        urun_id=:urun_id,
                        hb_sku=:hb_sku,
                        hb_stokkodu=:hb_stokkodu,
                        barkod=:barkod,
                        hb_fiyat=:hb_fiyat,
                        hb_stok=:hb_stok,
                        hb_yayin=:hb_yayin,
                        tarih=:tarih
                ");
        $sonuc = $kaydet->execute(array(
            'urun_id' => $_POST['product_id'],
            'hb_sku' => $sku,
            'hb_stokkodu' => $msku,
            'barkod' => $barkod,
            'hb_fiyat' => $urun['fiyat'],
            'hb_stok' => $urun['stok'],
            'hb_yayin' => '0',
            'tarih' => $timestamp
        ));
        if($sonuc){
            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_hb&productID='.$_POST['product_id'].'');
            exit();
        }else{
            echo 'Veritabanı Hatası';
            exit();
        }


    }


}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_hb&productID='.$_GET['productID'].'');
    exit();
}

}


?>
<title><?=$row['baslik']?> <?=$diller['adminpanel-form-text-1799']?> - <?=$panelayar['baslik']?></title>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">


        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center" >
                        <div class="col-md-12" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-2']?></a>
                                <a href="pages.php?page=products"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-3']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$row['baslik']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['pazaryeri-text-13']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['katalog'] == '1' && $yetki['urun'] == '1' && $yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') { ?>

            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="new-buttonu-main-top mb-0  pb-2 ">
                                        <div class="new-buttonu-main-left w-100">
                                            <a href="pages.php?page=products" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                            </a>
                                            <div style="font-size: 20px; font-weight: 600; width: 100%;  " class="d-flex align-items-center justify-content-between flex-wrap pt-2 pb-2">
                                                <div>
                                                    <div>
                                                        <?=$row['baslik']?>
                                                        <a href="<?=$ayar['site_url']?><?=$row['seo_url']?>-P<?=$row['id']?>" target="_blank">
                                                            <i class="fa fa-external-link-alt"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <?php include 'inc/modules/catalog/pazar/product_pazaryeri_tabs.php'; ?>
                                    <div class="tab-content bg-white rounded-bottom border border-top-0">
                                        <div class="tab-pane active p-3" id="one" role="tabpanel" >
                                            <div class="row">
                                                <style>
                                                    .gonder-h{
                                                        width: 100%;
                                                        text-align: center;
                                                        font-size: 28px ;
                                                        font-weight: 600;
                                                    }
                                                    .gonder-s{
                                                        width: 100%;
                                                        text-align: center;
                                                        font-size: 16px ;
                                                        margin-top: 20px;
                                                        margin-bottom: 20px;
                                                        font-weight: 500;
                                                    }
                                                    .gonder-s2{
                                                        width: 100%;
                                                        text-align: center;
                                                        font-size: 13px ;
                                                        color: #999;
                                                    }
                                                    .gonder-line-con{
                                                        width: 100%;
                                                        border-bottom: 1px solid #EBEBEB;
                                                        display: flex;
                                                        align-items: center;
                                                        justify-content: center;
                                                        height: 6px;
                                                        margin-bottom: 30px;
                                                    }
                                                    .gonder-line{
                                                        background-color: #FFF;
                                                        padding: 20px;
                                                        font-size: 25px ;
                                                    }
                                                </style>
                                                <?php if($pazar['hb_durum'] == '1' ) {?>
                                                        <div class="col-md-12">
                                                            <?php if($BilgiSorgu->rowCount()<='0' && $EnvSorgu->rowCount() <='0'  ) {?>

                                                                <?php if($EnvSorgu->rowCount()<='0'  ) {?>
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-4">
                                                                            <div class="w-100 p-5 border rounded">
                                                                                <div class="gonder-h">
                                                                                    <?=$diller['pazaryeri-text-217']?>
                                                                                </div>
                                                                                <div class="gonder-s">
                                                                                    <?=$diller['pazaryeri-text-218']?>
                                                                                </div>
                                                                                <div class="w-100 text-center mt-5">
                                                                                    <a href="javascript:Void(0)" data-id="<?=$_GET['productID']?>" class="btn p-3 pl-5 pr-5 text-white btn-lg envantere_yolla" style="font-size: 16px ; background-color: #ff7c35; font-weight: 500;"><i class="fa fa-shopping-bag mr-2"></i> <?=$diller['pazaryeri-text-222']?></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>

                                                                
                                                                <div class="gonder-line-con">
                                                                    <div class="gonder-line">
                                                                        <?=$diller['pazaryeri-text-223']?>
                                                                    </div>
                                                                </div>
                                                                
                                                                <?php if($BilgiSorgu->rowCount()<='0'  ) {?>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="w-100 p-5 border rounded">
                                                                                <div class="gonder-h">
                                                                                    <?=$diller['pazaryeri-text-219']?>
                                                                                </div>
                                                                                <div class="gonder-s">
                                                                                    <?=$diller['pazaryeri-text-220']?>
                                                                                </div>
                                                                                <div class="gonder-s2">
                                                                                    <?=$diller['pazaryeri-text-221']?>
                                                                                </div>
                                                                                <div class="w-100 text-center mt-5">
                                                                                    <a href="javascript:Void(0)" data-page="product" data-pro="<?=$row['id']?>" data-id="<?=$row['iliskili_kat']?>" class="btn p-3 pl-5 pr-5 btn-success btn-lg syncDO" style="font-size: 16px ; font-weight: 500;"><i class="fa fa-sync mr-2"></i> <?=$diller['pazaryeri-text-9']?></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>

                                                            <?php }?>

                                                            <?php if($BilgiSorgu->rowCount()>'0'  ) {
                                                                $bilgiRow = $BilgiSorgu->fetch(PDO::FETCH_ASSOC); ?>

                                                                <?php if($bilgiRow['hb_aktarim'] == '1' ) {?>
                                                                    <div class="rounded  p-4  w-100 d-flex align-items-center justify-content-between flex-wrap    text-white" style="<?php if($bilgiRow['hb_durumu'] == 'Satışa Hazır' ) { ?>background-color: mediumseagreen;<?php }?><?php if($bilgiRow['hb_durumu'] == 'Incelenecek' ) { ?>background-color: dodgerblue;<?php }?>" >
                                                                        <?php if($bilgiRow['hb_durumu'] == 'Satışa Hazır'  ) {?>
                                                                            <div style="font-size: 16px ; font-weight: 500;">
                                                                                <?=$diller['pazaryeri-text-229']?>
                                                                            </div>
                                                                            <div style="width: 100%; font-size: 12px ;  ">
                                                                                <?=$diller['pazaryeri-text-230']?>
                                                                            </div>
                                                                        <?php }?>
                                                                        <?php if($bilgiRow['hb_durumu'] == 'Incelenecek'  ) {?>
                                                                            <div style="font-size: 16px ; font-weight: 500;">
                                                                                <?=$diller['pazaryeri-text-227']?>
                                                                            </div>
                                                                            <div style="width: 100%; font-size: 12px ;  ">
                                                                                <?=$diller['pazaryeri-text-228']?>
                                                                            </div>
                                                                        <?php }?>
                                                                    </div>
                                                                <?php }else { ?>
                                                                    <!-- Ürün Durumu ve Bilgi alanı !-->
                                                                    <?php if($bilgiRow['hb_ozellik'] != '0' ) {?>
                                                                        <div class="rounded  pt-4 pb-4 pl-3 pr-3 w-100 d-flex align-items-center justify-content-between flex-wrap mb-3 border border-warning" style="background-color: #FFEABB;" >
                                                                            <div style="font-size: 16px ; font-weight: 500;">
                                                                                <?=$diller['pazaryeri-text-225']?>
                                                                            </div>
                                                                            <div style="width: 100%; font-size: 12px ;  ">
                                                                                <?=$diller['pazaryeri-text-226']?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }else { ?>
                                                                        <div class="rounded bg-danger text-white p-3 mb-3 w-100 " style="font-size: 14px ;">
                                                                            <i class="fa fa-arrow-down"></i> <?=$diller['pazaryeri-text-165']?>
                                                                        </div>
                                                                    <?php }?>
                                                                    <div class="rounded bg-light border border-grey p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                                                        <div class="flex-grow-1">
                                                                            <strong> <?=$diller['pazaryeri-text-4']?> :</strong> <?=$bilgiRow['hb_kat_isim']?> (#<?=$bilgiRow['hb_kat_id']?>)
                                                                        </div>
                                                                        <div class="d-sm-block mt-2 mb-2">
                                                                            <a href="javascript:Void(0)" data-page="product" data-pro="<?=$row['id']?>" data-id="<?=$row['iliskili_kat']?>" class="btn btn-secondary w-100 syncDO" href="" style="margin-left: auto;">
                                                                                <i class="fa fa-sync"></i> <?=$diller['pazaryeri-text-5']?>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="rounded border border-grey p-3 w-100 " style="font-size: 14px ;">
                                                                        <div class="in-header-page-main2">
                                                                            <div class="in-header-page-text2 text-primary">
                                                                                <i class="fa fa-arrow-down"></i>
                                                                                <?=$diller['pazaryeri-text-8']?>
                                                                            </div>
                                                                        </div>
                                                                        <form method="post" action="post.php?process=hb_post&status=hb_ozellik">
                                                                            <input type="hidden" name="cat_id" value="<?=$ID?>" >
                                                                            <input type="hidden" name="urun_id" value="<?=$_GET['productID']?>" >
                                                                            <input type="hidden" name="hb_kat_id" value="<?=$bilgiRow['hb_kat_id']?>" >
                                                                            <div class="row">
                                                                                <?php
                                                                                $AttGetir = file_get_contents(''.$ayar['panel_url'].'assets/hb_features/'.$bilgiRow['hb_kat_id'].'.json');
                                                                                $attJson = json_decode($AttGetir);
                                                                                $ozellikcekValue = $bilgiRow['hb_ozellik'];
                                                                                $ozellikcekValue = explode('|', $ozellikcekValue);
                                                                                ?>
                                                                                <?php foreach ($attJson->data->baseAttributes as $f){
                                                                                    $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$row['hb_kat_id'].'/attribute/'.$f->id.'/values?page=0&size=100';
                                                                                    $service_url = $istek;
                                                                                    $curl = curl_init($service_url);
                                                                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                                                    $header = array(
                                                                                        'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                                                                                    );
                                                                                    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                                                                    $curl_response = curl_exec($curl);
                                                                                    $final = json_decode($curl_response);
                                                                                    if($f->mandatory == '1'  ) {
                                                                                        if($f->id != 'Image1' && $f->id != 'tax_vat_rate' && $f->id != 'Barcode'  && $f->id != 'UrunAciklamasi'  && $f->id !='UrunAdi' && $f->id != 'merchantSku'  ) {
                                                                                            ?>
                                                                                            <?php if($f->type == 'enum'  ) {?>
                                                                                                <div class="col-md-6 form-group">
                                                                                                    <label for="<?=$f->id?>"><?=$f->name?></label>
                                                                                                    <select name="ozellik[<?=$f->id?>]" class="form-control" id="<?=$f->id?>" <?php if($f->mandatory == '1'  ) { ?>required<?php }?>>
                                                                                                        <?php foreach ($final as $ks) {?>
                                                                                                            <option value="<?=$ks->value?>"

                                                                                                                <?php foreach ($ozellikcekValue as $omcV) {
                                                                                                                    $omcV2 = $omcV;
                                                                                                                    $omcV2 = explode('___', $omcV2);
                                                                                                                    foreach ($omcV2 as $a =>$key){
                                                                                                                        if($key !='' && $a == '0') {
                                                                                                                            if($omcV2[1] == $ks->value  ) { ?>
                                                                                                                                selected
                                                                                                                            <?php }
                                                                                                                        }
                                                                                                                    }}
                                                                                                                ?>

                                                                                                            ><?=$ks->value?></option>
                                                                                                        <?php } ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            <?php }else{ ?>
                                                                                                <div class="col-md-6 form-group">
                                                                                                    <label for="<?=$f->id?>"><?php if($f->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$f->name?></label>
                                                                                                    <input
                                                                                                        <?php if($f->type == 'integer'  ) { ?>type="number"<?php } ?>
                                                                                                        <?php if($f->type == 'string'  ) { ?>type="text"<?php } ?>
                                                                                                        name="ozellik[<?=$f->id?>]" <?php if($f->mandatory == '1'  ) { ?>required<?php } ?> autocomplete="off" id="<?=$f->id?>"  class="form-control"
                                                                                                        <?php foreach ($ozellikcekValue as $omcV) {
                                                                                                            $omcV2 = $omcV;
                                                                                                            $omcV2 = explode('___', $omcV2);
                                                                                                            foreach ($omcV2 as $a =>$key){
                                                                                                                if($key !='' && $a == '0') {
                                                                                                                    if($omcV2[0] == $f->id  ) { ?>
                                                                                                                        value="<?=$omcV2[1]?>"
                                                                                                                    <?php }
                                                                                                                }
                                                                                                            }}
                                                                                                        ?>
                                                                                                    >
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                }?>
                                                                                <?php foreach ($attJson->data->attributes as $d){
                                                                                    $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$bilgiRow['hb_kat_id'].'/attribute/'.$d->id.'/values?page=0&size=100';
                                                                                    $service_url = $istek;
                                                                                    $curl = curl_init($service_url);
                                                                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                                                    $header = array(
                                                                                        'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                                                                                    );
                                                                                    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                                                                    $curl_response = curl_exec($curl);
                                                                                    $final = json_decode($curl_response);
                                                                                    ?>

                                                                                <?php if($d->type == 'enum'  ) {?>
                                                                                <div class="col-md-6 form-group">
                                                                                    <label for="<?=$d->id?>"><?=$d->name?></label>
                                                                                    <select name="ozellik[<?=$d->id?>]" class="form-control" id="<?=$d->id?>" <?php if($d->mandatory == '1'  ) { ?>required<?php }?>>
                                                                                        <?php foreach ($final as $ks) {?>
                                                                                            <option value="<?=$ks->value?>"

                                                                                                <?php foreach ($ozellikcekValue as $omcV) {
                                                                                                    $omcV2 = $omcV;
                                                                                                    $omcV2 = explode('___', $omcV2);
                                                                                                    foreach ($omcV2 as $a =>$key){
                                                                                                        if($key !='' && $a == '0') {
                                                                                                            if($omcV2[1] == $ks->value  ) { ?>
                                                                                                                selected
                                                                                                            <?php }
                                                                                                        }
                                                                                                    }}
                                                                                                ?>

                                                                                            ><?=$ks->value?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                <?php }else{ ?>
                                                                                <div class="col-md-6 form-group">
                                                                                    <label for="<?=$d->id?>"><?php if($d->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$d->name?></label>
                                                                                    <input
                                                                                        <?php if($d->type == 'integer'  ) { ?>type="number"<?php } ?>
                                                                                        <?php if($d->type == 'string'  ) { ?>type="text"<?php } ?>
                                                                                        name="ozellik[<?=$d->id?>]" <?php if($d->mandatory == '1'  ) { ?>required<?php } ?> autocomplete="off" id="<?=$d->id?>"  class="form-control"
                                                                                        <?php foreach ($ozellikcekValue as $omcV) {
                                                                                            $omcV2 = $omcV;
                                                                                            $omcV2 = explode('___', $omcV2);
                                                                                            foreach ($omcV2 as $a =>$key){
                                                                                                if($key !='' && $a == '0') {
                                                                                                    if($omcV2[0] == $d->id  ) { ?>
                                                                                                        value="<?=$omcV2[1]?>"
                                                                                                    <?php }
                                                                                                }
                                                                                            }}
                                                                                        ?>
                                                                                    >
                                                                                </div>
                                                                                <?php } ?>
                                                                                <?php
                                                                                } ?>
                                                                                <?php foreach ($attJson->data->variantAttributes as $d){
                                                                                $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$bilgiRow['hb_kat_id'].'/attribute/'.$d->id.'/values?page=0&size=100';
                                                                                $service_url = $istek;
                                                                                $curl = curl_init($service_url);
                                                                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                                                $header = array(
                                                                                    'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                                                                                );
                                                                                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                                                                $curl_response = curl_exec($curl);
                                                                                $final = json_decode($curl_response);
                                                                                ?>
                                                                                <?php if($d->type == 'enum'  ) {?>
                                                                                <div class="col-md-6 form-group">
                                                                                    <label for="<?=$d->id?>"><?=$d->name?></label>
                                                                                    <select name="ozellik[<?=$d->id?>]" class="form-control" id="<?=$d->id?>" <?php if($d->mandatory == '1'  ) { ?>required<?php }?>>
                                                                                        <?php foreach ($final as $ks2) {?>
                                                                                            <option value="<?=$ks2->value?>"

                                                                                                <?php foreach ($ozellikcekValue as $omcV) {
                                                                                                    $omcV2 = $omcV;
                                                                                                    $omcV2 = explode('___', $omcV2);
                                                                                                    foreach ($omcV2 as $a =>$key){
                                                                                                        if($key !='' && $a == '0') {
                                                                                                            if($omcV2[1] == $ks2->value  ) { ?>
                                                                                                                selected
                                                                                                            <?php }
                                                                                                        }
                                                                                                    }}
                                                                                                ?>

                                                                                            ><?=$ks2->value?></option>
                                                                                        <?php }?>
                                                                                    </select>
                                                                                </div>
                                                                                <?php }else{ ?>
                                                                                <div class="col-md-6 form-group">
                                                                                    <label for="<?=$d->id?>"><?php if($d->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$d->name?></label>
                                                                                    <input
                                                                                        <?php if($d->type == 'integer'  ) { ?>type="number"<?php } ?>
                                                                                        <?php if($d->type == 'string'  ) { ?>type="text"<?php } ?>
                                                                                        name="ozellik[<?=$d->id?>]" <?php if($d->mandatory == '1'  ) { ?>required<?php } ?> autocomplete="off" id="<?=$d->id?>"  class="form-control"
                                                                                        <?php foreach ($ozellikcekValue as $omcV) {
                                                                                            $omcV2 = $omcV;
                                                                                            $omcV2 = explode('___', $omcV2);
                                                                                            foreach ($omcV2 as $a =>$key){
                                                                                                if($key !='' && $a == '0') {
                                                                                                    if($omcV2[0] == $d->id  ) { ?>
                                                                                                        value="<?=$omcV2[1]?>"
                                                                                                    <?php }
                                                                                                }
                                                                                            }}
                                                                                        ?>
                                                                                    >
                                                                                </div>
                                                                                <?php } ?>
                                                                                <?php
                                                                                }?>
                                                                                <div class="col-md-12 form-group mb-0 mt-2">
                                                                                    <button class="btn btn-block  btn-success " name="attAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!--  <========SON=========>>> Ürün Durumu ve Bilgi alanı SON !-->
                                                                <?php }?>

                                                                
                                                                
                                                            <?php }?>

                                                            <?php if($EnvSorgu->rowCount()>'0'  ) {?>
                                                            <div class="rounded  p-4  w-100 d-flex align-items-center text-center border justify-content-between flex-wrap    text-dark" >
                                                                <div style="font-size: 26px ; font-weight: 600; width: 100%; margin-top: 30px; margin-bottom: 30px;  ">
                                                                    <?=$diller['pazaryeri-text-231']?>
                                                                </div>
                                                                <div style="font-size: 14px ;  width: 600px; margin: 0 auto; color: #999;  ">
                                                                    <?=$diller['pazaryeri-text-232']?>
                                                                </div>
                                                                <div class="w-100 mt-4 mb-4">
                                                                    <a href="pages.php?page=hb_envanter" class="btn rounded" style="background-color: #ff7c35; padding: 15px 30px; font-size: 18px ; color: #fff; font-weight: 600;">
                                                                        <?=$diller['pazaryeri-text-233']?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <?php }?>
                                                        </div>
                                                <?php }else { ?>
                                                    <div class="col-md-12 p-3 text-center">
                                                        <h3><?=$diller['adminpanel-text-136']?></h3>
                                                        <h6><?=$diller['pazaryeri-text-151']?></h6>
                                                    </div>
                                                <?php }?>
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
                <h3><?=$diller['adminpanel-text-136']?></h3>
                <h6><?=$diller['adminpanel-text-137']?></h6>
                <div  class="mt-3">
                    <a href="<?=$ayar['panel_url']?>" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                </div>
            </div>
        <?php }?>
    </div>
</div>
<script type='text/javascript'>

    $(document).ready(function(){

        $('.envantere_yolla').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_env_urundetay_yolla',
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
<script type='text/javascript'>
    $(document).ready(function(){

        $('.syncDO').click(function(){

            var postID = $(this).data('id');
            var turnPage = $(this).data('page');
            var productID = $(this).data('pro');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hbCatSelect',
                type: 'post',
                data: {postID: postID,turnPage: turnPage,productID: productID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
    $(document).ready(function() {
        $('.selet2').select2({

        })})
</script>