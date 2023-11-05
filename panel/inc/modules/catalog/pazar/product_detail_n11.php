<?php
$pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
$pazarYeri->execute();
$pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'n11';

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
$ozellikcek = $row['n11_ozellik'];
$ozellikcek = explode('|', $ozellikcek);

if(isset($_GET['merchant'])  ) {
    if ($yetki['demo'] != '1') {
        if( $_GET['merchant'] == 'item_delete' ||  $_GET['merchant'] == 'stockupdate' ) {
            if($_GET['merchant'] == 'item_delete' ) {
                $urunKontrolet = $db->prepare("select n11_kod,id from urun where id=:id ");
                $urunKontrolet->execute(array(
                    'id' => $_GET['productID']
                ));
                if($urunKontrolet->rowCount()>'0') {
                    $kontrolRow = $urunKontrolet->fetch(PDO::FETCH_ASSOC);
                    if($kontrolRow['n11_kod'] == !null ) {
                        $n11kod = $kontrolRow['n11_kod'];
                        include "inc/modules/entegration/pazar/n11_api.php";
                        $deleteProductBySeller = $n11->DeleteProductBySellerCode(''.$n11kod.'');
                        $durum = $deleteProductBySeller->result->status;
                        if($durum == 'success'  ) {
                            $silmeislem = $db->prepare("DELETE from n11_urun WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $_GET['productID']
                            ));
                            $guncelle = $db->prepare("UPDATE urun SET
                          n11_aktarim=:n11_aktarim,
                          n11_log=:n11_log,
                          n11_kod=:n11_kod
                         WHERE id={$_GET['productID']}      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'n11_aktarim' => 0,
                                'n11_log' => '0',
                                'n11_kod' => '0'
                            ));
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                            exit();
                        }else{
                            echo '<div class="w-100 bg-danger text-white p-3 text-center card"><div class="card-body">
'.$diller['pazaryeri-text-38'].'
</div></div>';
                            header('Refresh:2; url='.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                    exit();
                }
            }

            if($_GET['merchant'] == 'stockupdate' ) {
                $urunKontrolet = $db->prepare("select n11_kod,id from urun where id=:id ");
                $urunKontrolet->execute(array(
                    'id' => $_GET['productID']
                ));
                if($urunKontrolet->rowCount()>'0') {
                    $kontrolRow = $urunKontrolet->fetch(PDO::FETCH_ASSOC);
                    if ($kontrolRow['n11_kod'] == !null) {
                        $n11kod = $kontrolRow['n11_kod'];
                        include "inc/modules/entegration/pazar/n11_api.php";
                        $urunStokCekSorgu = $n11->GetProductBySellerCode('' . $n11kod . '');
                        $stoksayisicek= $urunStokCekSorgu->product->stockItems->stockItem->quantity;
                        $guncelle = $db->prepare("UPDATE n11_urun SET
                            n11_stok=:n11_stok
                            WHERE urun_id={$_GET['productID']}
                            ");
                        $sonuc = $guncelle->execute(array(
                            'n11_stok' => $stoksayisicek
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                            exit();
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                    exit();
                }
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
            exit();
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
        exit();
    }
}


if(isset($_GET['send'])  ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['send'] == 'no' || $_GET['send'] == 'yes') {

            if($_GET['send']=='yes'  ) {
                $guncelle = $db->prepare("UPDATE urun SET
                    n11_izin=:n11_izin 
              WHERE id={$_GET['productID']}      
             ");
                $sonuc = $guncelle->execute(array(
                    'n11_izin' => '1'
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                    exit();
                }else{
                    echo 'Veritabanı Hatası';
                }
            }else{
                $guncelle = $db->prepare("UPDATE urun SET
                    n11_izin=:n11_izin 
              WHERE id={$_GET['productID']}      
             ");
                $sonuc = $guncelle->execute(array(
                    'n11_izin' => '0'
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
                    exit();
                }else{
                    echo 'Veritabanı Hatası';
                }
            }

        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
            exit();
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_GET['productID'].'');
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
                        <div class="col-md-8" >
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
                                                <?php if($pazar['n11_durum'] == '1' ) {?>
                                                    <?php if($row['n11_kat_id'] == '0' ) {?>
                                                        <div class="col-md-12">
                                                            <div class="w-100 p-3 bg-light mb-3 font-12 rounded border ">
                                                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['pazaryeri-text-6']?>
                                                            </div>
                                                            <div class="w-100 d-flex align-items-center justify-content-center pt-4 pb-4 border">
                                                                <a href="javascript:Void(0)" data-page="product" data-pro="<?=$row['id']?>" data-id="<?=$row['iliskili_kat']?>" class="btn btn-lg btn-success syncDo"><i class="fa fa-sync mr-2"></i> <?=$diller['pazaryeri-text-9']?></a>
                                                            </div>
                                                        </div>
                                                    <?php }else {
                                                        $fileCheck = file_get_contents(''.$ayar['panel_url'].'assets/n11/cat/'.$row['n11_kat_id'].'.php');
                                                        $attrb= json_decode($fileCheck);
                                                        $att_area= json_decode($fileCheck,true);
                                                        error_reporting(0);
                                                        ?>
                                                        <div class="col-md-12">
                                                            <?php if($row['n11_log'] >'0'  ) {?>
                                                                <div class="rounded  bg-light border p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                                                    <strong><?=$diller['pazaryeri-text-30']?> :</strong>
                                                                    <div class="w-100 border border-light">
                                                                        <?php
                                                                        $jsonCevir = json_decode($row['n11_log']);
                                                                        $logmesaj  = $jsonCevir->result->errorMessage;
                                                                        $eski   = array('shipmentTemplate','product altmış saniye boyunca guncellenemez');
                                                                        $yeni   = array('Teslimat Şablonu',''.$diller['pazaryeri-text-38'].'');
                                                                        $logmesaj = str_replace($eski, $yeni, $logmesaj);

                                                                        echo $logmesaj;
                                                                        ?>
                                                                    </div>
                                                                    <div class="w-100 pt-2 mt-2 border-top" style="font-size: 11px ;">
                                                                        <?=$diller['adminpanel-form-text-1356']?> : <?php echo date_tr('j F Y, H:i', ''.$row['n11_tarih'].''); ?>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                            <?php if( $row['n11_aktarim'] != '1') {?>
                                                                <div class="rounded  border border-grey p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                                                    <div class="kustom-checkbox">
                                                                        <?php if($row['n11_izin'] == '1' ) {?>
                                                                            <input type="checkbox" class="individual" id="izin"  onclick="javascript:window.location='pages.php?page=product_detail_entegration&productID=<?=$row['id']?>&send=no'" <?php if($row['n11_izin'] == '1' ) { ?>checked<?php }?> >
                                                                            <label for="izin"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                <?=$diller['pazaryeri-text-17']?>
                                                                            </label>
                                                                        <?php }else { ?>
                                                                            <input type="checkbox" class="individual" id="izin"  onclick="javascript:window.location='pages.php?page=product_detail_entegration&productID=<?=$row['id']?>&send=yes'" >
                                                                            <label for="izin"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                <?=$diller['pazaryeri-text-17']?>
                                                                            </label>
                                                                        <?php }?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if($row['n11_ozellik'] == !null && $row['n11_aktarim'] != '1' && $row['n11_izin'] == '1' && $row['n11_kod'] <= '0') {?>
                                                                <div class="rounded  pt-4 pb-4 pl-3 pr-3 w-100 d-flex align-items-center justify-content-between flex-wrap mb-3 border border-warning" style="background-color: #FFEABB;" >
                                                                    <div style="font-size: 16px ; font-weight: 500;">
                                                                        <?=$diller['pazaryeri-text-18']?>
                                                                    </div>
                                                                    <div class="d-sm-block mt-2 mb-2">
                                                                        <a href="javascript:Void(0)" data-id="<?=$row['id']?>"  class="btn btn-light btn-lg w-100 aktar d-flex align-items-center justify-content-center " href="" style="margin-left: auto;">
                                                                            <img src="assets/images/n11.png" class="mr-2"> <?=$diller['pazaryeri-text-19']?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                        </div>
                                                    <?php }?>


                                                    <?php
                                                    //echo '<pre>';
                                                    //print_r($attrb);
                                                    //echo '</pre>';
                                                    ?>



                                                    <div class="col-md-12">
                                                        <?php if($row['n11_kod'] <= '0' && $row['n11_izin'] == '1' ) {?>
                                                            <div class="rounded bg-light border border-grey p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                                                <div class="flex-grow-1">
                                                                    <strong> <?=$diller['pazaryeri-text-4']?> :</strong> <?=$row['n11_kat_isim']?> (#<?=$row['n11_kat_id']?>)
                                                                </div>
                                                                <div class="d-sm-block mt-2 mb-2">
                                                                    <a href="javascript:Void(0)" data-page="product" data-pro="<?=$row['id']?>" data-id="<?=$row['iliskili_kat']?>"  class="btn btn-secondary w-100 syncDo" href="" style="margin-left: auto;">
                                                                        <i class="fa fa-sync"></i> <?=$diller['pazaryeri-text-5']?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <?php if($row['n11_ozellik'] == '0' ) {?>
                                                                <div class="rounded bg-danger text-white p-3 mb-3 w-100 " style="font-size: 14px ;">
                                                                    <i class="fa fa-arrow-down"></i> <?=$diller['pazaryeri-text-14']?>
                                                                </div>
                                                            <?php }?>
                                                            <div class="rounded border border-grey p-3 w-100 " style="font-size: 14px ;">
                                                                <div class="in-header-page-main2">
                                                                    <div class="in-header-page-text2 text-primary">
                                                                        <i class="fa fa-arrow-down"></i>
                                                                        <?=$diller['pazaryeri-text-8']?>
                                                                    </div>
                                                                </div>
                                                                <form method="post" action="post.php?process=pazar_post&status=n11_ozellik">
                                                                    <input type="hidden" name="cat_id" value="<?=$row['iliskili_kat']?>" >
                                                                    <input type="hidden" name="product_id" value="<?=$row['id']?>" >
                                                                    <input type="hidden" name="return" value="product" >
                                                                    <div class="row">
                                                                        <?php if(isset($att_area['category']['attributeList']['attribute'][0])  ) {?>
                                                                            <?php
                                                                            // 1 den fazla attribute için
                                                                            foreach ($attrb->category->attributeList as $ats) {
                                                                                foreach ($ats as $at =>$key){
                                                                                    ?>
                                                                                    <div class="col-md-6 form-group">
                                                                                        <label for="<?=$key->name?>"><?php if($key->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$key->name?></label>
                                                                                        <select name="ozellik[]" class="form-control selet2" style="width: 100%" id="<?=$key->name?>" <?php if($key->mandatory == '1'  ) { ?>required<?php }?>>
                                                                                            <?php if($key->mandatory != '1'  ) { ?>
                                                                                                <option value="" selected><?=$diller['adminpanel-form-text-1222']?></option>
                                                                                            <?php } ?>
                                                                                            <?php foreach ($key->valueList as $val ) {?>
                                                                                                <?php foreach ($val as $va =>$vas) {?>
                                                                                                    <option value="<?=$key->name?>_<?=$vas->name?>"

                                                                                                        <?php foreach ($ozellikcek as $omc) {?>
                                                                                                            <?php if($omc != ''  ) {?>
                                                                                                            <?php if($omc == ''.$key->name.'_'.$vas->name.'' ) {?>
                                                                                                                selected
                                                                                                            <?php }?>
                                                                                                            <?php }?>
                                                                                                        <?php }?>

                                                                                                    ><?=$vas->name?></option>
                                                                                                <?php }?>
                                                                                            <?php }?>
                                                                                        </select>
                                                                                    </div>
                                                                                <?php }
                                                                            }
                                                                            ?>
                                                                        <?php }else {
                                                                            // tek attribute için
                                                                            ?>
                                                                            <div class="col-md-6 form-group">
                                                                                <label for="<?=$attrb->category->attributeList->attribute->name?>"><?php if($attrb->category->attributeList->attribute->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$attrb->category->attributeList->attribute->name?></label>
                                                                                <select name="ozellik[]" class="form-control selet2 " style="width: 100%" id="<?=$attrb->category->attributeList->attribute->name?>" <?php if($attrb->category->attributeList->attribute->mandatory == '1') { ?>required<?php }?>>
                                                                                    <?php if($attrb->category->attributeList->attribute->mandatory != '1'  ) {?>
                                                                                        <option value="" selected><?=$diller['adminpanel-form-text-1222']?></option>
                                                                                    <?php }?>
                                                                                    <?php
                                                                                    foreach ($attrb->category->attributeList->attribute->valueList as $val){
                                                                                        foreach ($val as $mam => $des) {
                                                                                            ?>
                                                                                            <option value="<?=$attrb->category->attributeList->attribute->name?>_<?=$des->name?>"

                                                                                                <?php foreach ($ozellikcek as $omc) {?>
                                                                                                    <?php if($omc == ''.$attrb->category->attributeList->attribute->name.'_'.$des->name.'' ) {?>
                                                                                                        selected
                                                                                                    <?php }?>
                                                                                                <?php }?>

                                                                                            ><?=$des->name?></option>
                                                                                            <?php
                                                                                        }}
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        <?php }?>
                                                                        <div class="col-md-12 form-group mb-0 mt-2">
                                                                            <button class="btn btn-block  btn-success " name="attAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        <?php }?>
                                                        <?php if($row['n11_kod'] > '0' && $row['n11_izin'] == '1') {
                                                            $n11Urunu = $db->prepare("select n11_stok from n11_urun where urun_id=:urun_id ");
                                                            $n11Urunu->execute(array(
                                                                'urun_id' => $row['id']
                                                            ));
                                                            $n11Row = $n11Urunu->fetch(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <div class="rounded bg-success text-white  pt-4 pb-4 pl-3 pr-3 w-100 d-flex align-items-center justify-content-between flex-wrap "  >
                                                                <div style="font-size: 18px ; font-weight: 500;">
                                                                    <?=$diller['pazaryeri-text-20']?>
                                                                    <i class="ti-help-alt text-white ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-33']?>"></i>
                                                                    <div class="w-100" style="font-size: 12px ;">
                                                                        <?=$diller['adminpanel-form-text-1356']?> : <?php echo date_tr('j F Y, H:i', ''.$row['n11_tarih'].''); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2 mb-2 d-flex align-items-center justify-content-end flex-wrap">
                                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>"  class="btn btn-pink btn-lg w-100 guncelle" href="" >
                                                                        <?=$diller['pazaryeri-text-22']?>
                                                                    </a>
                                                                    <a   href="" data-href="pages.php?page=product_detail_entegration&productID=<?=$row['id']?>&merchant=item_delete" data-toggle="modal" data-target="#confirm-delete" class="btn btn-light btn-lg w-100  mt-2">
                                                                        <i class="fa fa-trash"></i> <?=$diller['pazaryeri-text-21']?>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <div class="rounded bg-light   pt-4 pb-4 pl-3 pr-3 w-100 mt-3 d-flex align-items-center justify-content-between flex-wrap "  >
                                                                <div style="font-size: 14px ;">
                                                                    <?=$diller['pazaryeri-text-39']?> : <strong><?=$n11Row['n11_stok']?></strong>
                                                                    <i class="ti-help-alt text-dark ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-40']?>"></i>
                                                                </div>
                                                                <div class="mt-2 mb-2 d-flex align-items-center justify-content-end flex-wrap">
                                                                    <a id="waitButton"  href="pages.php?page=product_detail_entegration&productID=<?=$row['id']?>&merchant=stockupdate" class="btn btn-sm btn-dark btn-lg w-100 mt-2">
                                                                        <?=$diller['pazaryeri-text-41']?>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        <?php }?>
                                                    </div>
                                                <?php }else { ?>
                                                    <div class="col-md-12 p-3 text-center">
                                                        <h3><?=$diller['adminpanel-text-136']?></h3>
                                                        <h6><?=$diller['pazaryeri-text-15']?></h6>
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

        $('.aktar').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=n11_tek_aktar',
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
                url: 'masterpiece.php?page=n11_tek_guncelle',
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

        $('.syncDo').click(function(){

            var postID = $(this).data('id');
            var turnPage = $(this).data('page');
            var productID = $(this).data('pro');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=n11CatSelect',
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