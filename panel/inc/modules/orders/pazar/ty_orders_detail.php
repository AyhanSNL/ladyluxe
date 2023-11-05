<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'ty_orders';
$orderDetail = $db->prepare("select * from trendyol_siparis where siparis_no=:siparis_no ");
$orderDetail->execute(array(
    'siparis_no' => $_GET['orderID']
));
$row = $orderDetail->fetch(PDO::FETCH_ASSOC);
if($orderDetail->rowCount()<='0'  ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=ty_orders');
    exit();
}
$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);
$urunListesi = $db->prepare("select * from trendyol_siparis_urun where siparis_no=:siparis_no ");
$urunListesi->execute(array(
    'siparis_no' => $row['siparis_no'],
));
?>
<title>Trendyol - #<?=$row['siparis_no']?> <?=$diller['adminpanel-form-text-1451']?> - <?=$panelayar['baslik']?></title>
<style>
    .ssa:before{
        display: none;
    }
    .kustom-checkbox label:before{
        margin-right: 10px;
    }
    .kustom-checkbox label {
        font-size: 13px ;
        font-weight: 200 !important;
    }
    .show > .dropdown-menu{
        z-index: 99999 !important;
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-16']?></a>
                                <a href="pages.php?page=ty_orders"><i class="fa fa-angle-right"></i>Trendyol <?=$diller['pazaryeri-text-129']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> #<?=$row['siparis_no']?> <?=$diller['adminpanel-form-text-1451']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1' && $pazar['ty_durum'] == '1') {?>
            <div class="row">

                <?php include 'inc/modules/_helper/orders_leftbar.php'; ?>



                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">


                            <!-- Header !-->
                            <a href="pages.php?page=ty_orders" class="btn btn-outline-dark   btn-sm  " >
                                <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                            </a>
                            <div class="d-flex align-items-center flex-wrap justify-content-between  pb-2  mt-2" >
                                <h5>TRENDYOL - #<?=$row['siparis_no']?> <?=$diller['adminpanel-form-text-1451']?></h5>
                            </div>
                            <!--  <========SON=========>>> Header SON !-->




                            <div class="row">




                                <div class="col-md-12 mb-3">
                                    <div class="border border-grey pt-3 pl-3 pr-3 pb-0">
                                        <div class="row">
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-text-91']?></label>
                                                <div class="text">
                                                    #<?=$row['siparis_no']?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1460']?></label>
                                                <div class="text">
                                                    <?php echo date_tr('j F Y, H:i', ''.$row['siparis_tarih'].''); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1433']?></label>
                                                <div class="text">
                                                   <?=$row['musteri_isim']?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1316']?></label>
                                                <div class="text">
                                                    <?=$row['musteri_tc']?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1438']?></label>
                                                <div class="text">
                                                    <?php if($row['siparis_durum'] == 'Awaiting' ) {?>
                                                        <div class="btn btn-sm btn-light  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-132']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'Created' ) {?>
                                                        <div class="btn btn-sm btn-light  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-133']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'Picking' ) {?>
                                                        <div class="btn btn-sm btn-light  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-134']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'Invoiced' ) {?>
                                                        <div class="btn btn-sm btn-light  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-135']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'Shipped' ) {?>
                                                        <div class="btn btn-sm btn-light  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-136']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'AtCollectionPoint' ) {?>
                                                        <div class="btn btn-sm btn-light  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-137']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'Cancelled' ) {?>
                                                        <div class="btn btn-sm btn-danger  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-138']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'UnPacked' ) {?>
                                                        <div class="btn btn-sm btn-light  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-139']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'Delivered' ) {?>
                                                        <div class="btn btn-sm btn-success  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-140']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'UnDelivered' ) {?>
                                                        <div class="btn btn-sm btn-outline-danger  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-141']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['siparis_durum'] == 'UnDeliveredAndReturned' ) {?>
                                                        <div class="btn btn-sm btn-outline-danger  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$diller['pazaryeri-text-142']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <?php if($row['kargo_adi'] == !null ) {?>
                                                <div class="col-md-3 order-top-form form-group">
                                                    <label class="text-uppercase"><?=$diller['adminpanel-form-text-1501']?></label>
                                                    <div class="text">
                                                        <?=$row['kargo_adi']?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?php if($row['kargo_takip_url'] == !null ) {?>
                                                <div class="col-md-3 order-top-form form-group">
                                                    <label class="text-uppercase"><i class="fa fa-external-link-alt"></i></label>
                                                    <div class="text">
                                                        <a href="<?=$row['kargo_takip_url']?>" target="_blank" class="btn btn-sm btn-primary"><?=$diller['pazaryeri-text-144']?></a>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 form-group">
                                    <div class="row">


                                        <div class="col-md-6 form-group bg-white">
                                            <div class="border border-grey">
                                                <div class="border-bottom border-grey bg-white pt-2 pb-2 pl-3 pr-3 mb-2 d-flex align-items-center justify-content-between flex-wrap" >
                                                    <h6><i class="fas fa-map-marker-alt"></i> <?=$diller['adminpanel-form-text-1324']?></h6>
                                                </div>
                                                <ul class="list-group list-group-flush p-3 list-unstyled " style="font-size: 14px ;">
                                                    <li class="border-bottom border-grey pb-2" ><?=$row['teslimat_isim']?></li>
                                                    <li class="border-bottom border-grey pb-2 pt-2" ><?=$row['teslimat_adres']?></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group bg-white">
                                            <div class="border border-grey">
                                                <div class="border-bottom border-grey bg-white pt-2 pb-2 pl-3 pr-3 mb-2 d-flex align-items-center justify-content-between flex-wrap" >
                                                    <h6><i class="fas fa-receipt"></i> <?=$diller['adminpanel-form-text-1327']?></h6>
                                                </div>
                                                <div class="pl-3 pr-3" style="font-weight: 600;">

                                                </div>
                                                <?php if($row['adres_fatura_farkli'] == '0'  ) {?>
                                                    <ul class="list-group list-group-flush p-3 list-unstyled " style="font-size: 14px ;">
                                                        <li class="border-bottom border-grey pb-2 pt-2" >
                                                            <?=$row['isim']?> <?=$row['soyisim']?>
                                                        </li>
                                                        <?php if($row['tc_no'] == !null  ) {?>
                                                            <li class="border-bottom border-grey pb-2 pt-2" >
                                                                <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1316']?> :</strong> <?=$row['tc_no']?>
                                                            </li>
                                                        <?php }?>
                                                        <li class="border-bottom border-grey pb-2 pt-2" >
                                                            <strong class="text-uppercase"><?=$diller['adminpanel-form-text-81']?> :</strong> <?=$row['telefon_gosterim']?>
                                                        </li>
                                                        <li class="border-bottom border-grey pb-2 pt-2" >
                                                            <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1107']?> :</strong> <?=$row['eposta']?>
                                                        </li>
                                                        <li class="border-bottom border-grey pb-2 pt-2" >
                                                            <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1474']?> :</strong> <?=$row['postakodu']?>
                                                        </li>
                                                    </ul>
                                                    <div class="pt-1 pl-3 pr-3 pb-3" style="font-size: 14px ;">
                                                        <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1326']?> :</strong>
                                                        <br>
                                                        <?=$row['adresbilgisi']?>
                                                        <br>
                                                        <?=$row['ilce']?> / <?=$row['sehir']?> / <?=$ulk['baslik']?>
                                                    </div>
                                                <?php }else { ?>
                                                    <ul class="list-group list-group-flush p-3 list-unstyled " style="font-size: 14px ;">
                                                        <li class="border-bottom border-grey pb-2" ><?=$row['fatura_isim']?></li>
                                                        <li class="border-bottom border-grey pb-2 pt-2" ><?=$row['fatura_adres']?></li>
                                                    </ul>
                                                <?php }?>
                                            </div>
                                        </div>


                                    </div>
                                </div>


                                <!-- Order Product List !-->
                                <div class="col-md-12 mb-3 product-list-area">
                                    <div class="border border-grey " >
                                        <div class="p-3 border-bottom border-grey  d-flex align-items-center text-dark justify-content-between flex-wrap">
                                            <div class="d-flex align-items-center justify-content-start flex-wrap flex-grow-1 ">
                                                <i class="fas fa-shopping-basket mr-2" style="font-size: 20px;"></i>
                                                <div>
                                                    <div style="font-size: 18px; font-weight: 600;">
                                                        <?=$diller['adminpanel-form-text-1508']?> (<?=$urunListesi->rowCount()?>)
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- Ürün Listesi  !-->
                                        <div class="w-100 pt-1 pb-1 pl-3 pr-3">
                                            <?php foreach ($urunListesi as $prow) {
                                                ?>
                                                <div class="w-100 border p-3 mt-3 mb-3">
                                                    <div class="w-100 d-flex align-items-center justify-content-between flex-wrap ">
                                                        <div class="row" style="width: 120%;  ">
                                                            <div class="col-md-6 d-flex  justify-content-start flex-wrap">
                                                                <div class="">
                                                                    <div class="mt-2 mb-2">
                                                                        <div class="w-100" style="font-size: 16px ; font-weight: 500;">
                                                                            <?=$prow['baslik']?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="border-top border-grey pt-3 mt-3">
                                                            <div class="row">
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['pazaryeri-text-145']?></label>
                                                                        <span style="font-size: 14px ;"><?=$prow['sku']?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['pazaryeri-text-146']?></label>
                                                                        <span style="font-size: 14px ;"><?php echo number_format($prow['fiyat'], 2); ?> TRY</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1217']?></label>
                                                                        <span style="font-size: 14px ;"><?php echo number_format($prow['indirim'], 2); ?> TRY</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1199']?></label>
                                                                        <span style="font-size: 14px ;"><?=$prow['adet']?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1521']?> </label>
                                                                        <span style="font-size: 15px ; font-weight: 500;"><?php echo number_format($prow['toplam'], 2); ?> TRY</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <!--  <========SON=========>>> Ürün Listesi  SON !-->

                                        <style>
                                            .account_subpage_summary_order_main{
                                                width: 100%;
                                                box-sizing: border-box;
                                                display: flex;
                                                justify-content: flex-end;
                                            }
                                            .account_subpage_summary_order_in{
                                                width: 300px;
                                            }
                                            .account_subpage_summary_order_freedelivery,
                                            .account_subpage_summary_order_discount_coupon{
                                                width: 100%;
                                                box-sizing: border-box;
                                                border: 1px solid #ebebeb;
                                                display: flex;
                                                align-items: flex-start;
                                                justify-content: flex-start;
                                                padding: 20px 18px;
                                                margin-bottom: 10px;
                                            }
                                            .account_subpage_summary_order_coupon_icon{
                                                width: 45px;
                                                font-size: 24px ;
                                                line-height: 28px;
                                                color: #6e8ebe;
                                            }
                                            .account_subpage_summary_order_coupon_text{
                                                flex:1;
                                                font-size: 13px ;
                                                color: #333;
                                                font-weight: 500;
                                                line-height: 15px;
                                            }
                                            .account_subpage_summary_order_coupon_text_h{
                                                width: 100%;
                                                color: #999;
                                                font-weight: 500;
                                            }
                                            .account_subpage_summary_order_coupon_text_s{
                                                width: 100%;
                                                margin-top: 5px;
                                            }
                                            .account_subpage_summary_order_box{
                                                width: 100%;
                                                box-sizing: border-box;
                                                border: 1px solid #ebebeb;
                                                background-color: #f8f8f8;
                                                color: #000;
                                                padding: 20px;
                                            }
                                            .account_subpage_summary_order_box_h{
                                                font-size: 16px ;
                                                font-weight: 600;
                                                margin-bottom: 20px;
                                            }
                                            .account_subpage_summary_order_box_s{
                                                display: flex;
                                                align-items: flex-start;
                                                justify-content: space-between;
                                                flex-wrap: wrap;
                                                width: 100% ;
                                                border-bottom: 1px solid #EBEBEB;
                                                font-size: 14px ;
                                                padding-bottom: 8px;
                                                margin-bottom: 8px;
                                            }
                                            .account_subpage_summary_order_box_s:last-child{
                                                border-bottom: 0;
                                                margin-bottom: 0;
                                                padding-bottom: 0;
                                            }
                                            .account_subpage_summary_order_box_s_left{
                                                width: 50%;
                                            }
                                            .account_subpage_summary_order_box_s_right{
                                                width: 50%;
                                                text-align: right;
                                                font-weight: 600;
                                            }
                                            .orderdetail_coupon_total{
                                                box-sizing: border-box;
                                                text-align: center;
                                                border: 1px solid #EBEBEB;
                                                padding: 5px;
                                                margin-top: 5px;
                                                border-radius: 10px;
                                                background-color: #f8f8f8;
                                            }
                                        </style>

                                        <div class="w-100 pt-0 pb-3 pl-3 pr-3">
                                            <div class="account_subpage_summary_order_main">
                                                <div class="account_subpage_summary_order_in">
                                                    <!-- Summary !-->
                                                    <div class="account_subpage_summary_order_box">
                                                        <div class="account_subpage_summary_order_box_h">
                                                            <?=$diller['users-panel-text139']?>
                                                        </div>
                                                        <div class="account_subpage_summary_order_box_s">
                                                            <div class="account_subpage_summary_order_box_s_left">
                                                                <?=$diller['users-panel-text140']?>
                                                            </div>
                                                            <div class="account_subpage_summary_order_box_s_right">
                                                                <?php echo number_format($row['ara_toplam'], 2); ?> TRY
                                                            </div>
                                                        </div>
                                                            <div class="account_subpage_summary_order_box_s">
                                                                <div class="account_subpage_summary_order_box_s_left">
                                                                    <?=$diller['adminpanel-form-text-1217']?>
                                                                </div>
                                                                <div class="account_subpage_summary_order_box_s_right">
                                                                    <?php echo number_format($row['indirim'], 2); ?> TRY
                                                                </div>
                                                            </div>

                                                        <div class="account_subpage_summary_order_box_s">
                                                            <div class="account_subpage_summary_order_box_s_left" style="font-size: 15px ;">
                                                                <?=$diller['users-panel-text144']?>
                                                            </div>
                                                            <div class="account_subpage_summary_order_box_s_right" style="font-size: 18px ;">
                                                                <?php echo number_format($row['toplam'], 2); ?> TRY
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--  <========SON=========>>> Summary SON !-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--  <========SON=========>>> Order Product List SON !-->


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
