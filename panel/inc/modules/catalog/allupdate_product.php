<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'allupdate_product';
?>
<title><?=$diller['adminpanel-menu-text-9']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=allupdate_product"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-9']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['katalog'] == '1' && $yetki['toplu'] == '1') { ?>
            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card pt-3 pl-3 pr-3 pb-0">
                        <div class="new-buttonu-main-top mb-0  pb-2 ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-9']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                            </div>
                        </div>
                        <!-- Fİlter !-->
                        <div class="w-100 mb-0  pt-2  d-flex align-items-center justify-content-start flex-wrap ">
                            <a class="btn btn-light  btn-block p-3 border" href="javascript:Void(0)" data-toggle="collapse" data-target="#filterAcc" aria-expanded="false" aria-controls="collapseForm" style="font-size: 15px; ">
                                <i class="fa fa-filter"></i>
                                <?=$diller['adminpanel-form-text-1292']?>
                            </a>
                        </div>
                        <div id="accordions" class="accordion">
                            <div class="collapse" id="filterAcc" data-parent="#accordions">
                                <form method="GET" action="pages.php">
                                    <input type="hidden" name="page" value="allupdate_product" >
                                    <div class="pt-5 pl-5 pr-5 pb-4  border border-top-0" >
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="search" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-154']?>
                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1780']?>"></i>
                                                </label>
                                                <input type="text" name="search" autocomplete="off" <?php if($_GET['search'] >'0'  ) { ?>value="<?=$_GET['search']?>" <?php }?> id="search"  class="form-control" >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="productStatus" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['users-panel-text48']?>
                                                </label>
                                                <select name="productStatus" class="form-control selet2" id="productStatus" style="width: 100%;  " >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <option value="0" <?php if( $_GET['productStatus'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                                    <option value="1" <?php if( $_GET['productStatus'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                                    <option value="2" <?php if( $_GET['productStatus'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1782']?></option>
                                                    <option value="3" <?php if( $_GET['productStatus'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1789']?></option>
                                                    <option value="4" <?php if( $_GET['productStatus'] == '4' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1790']?></option>
                                                    <option value="5" <?php if( $_GET['productStatus'] == '5' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1792']?></option>
                                                    <option value="6" <?php if( $_GET['productStatus'] == '6' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1793']?></option>
                                                    <option value="7" <?php if( $_GET['productStatus'] == '7' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1794']?></option>
                                                    <option value="8" <?php if( $_GET['productStatus'] == '8' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1795']?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="feature" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1788']?>
                                                </label>
                                                <select name="feature" class="form-control selet2" id="feature" style="width: 100%;  " >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <option value="1" <?php if( $_GET['feature'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-416']?></option>
                                                    <option value="2" <?php if( $_GET['feature'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-417']?></option>
                                                    <option value="3" <?php if( $_GET['feature'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-420']?></option>
                                                    <option value="4" <?php if( $_GET['feature'] == '4' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-418']?></option>
                                                    <option value="5" <?php if( $_GET['feature'] == '5' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-413']?></option>
                                                    <option value="6" <?php if( $_GET['feature'] == '6' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-347']?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="category" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1091']?>
                                                </label>
                                                <select name="category" class="form-control catalog_cat_select"  style="width: 100%;  " >
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="brand" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-menu-text-117']?>
                                                </label>
                                                <select name="brand" class="form-control catalog_brand_select"  style="width: 100%;  " >
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for=""><?=$diller['adminpanel-form-text-1088']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date" <?php if($_GET['date'] >'0'  ) { ?>value="<?=$_GET['date']?>" <?php }?> class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_first" autocomplete="off"  style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for=""><?=$diller['adminpanel-form-text-1089']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date_end" <?php if($_GET['date_end'] >'0'  ) { ?>value="<?=$_GET['date_end']?>" <?php }?> class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_ends" autocomplete="off"  style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="min" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                    <?=$diller['adminpanel-form-text-1441']?>
                                                </label>
                                                <div class="input-group mb-2">
                                                    <input type="number" class="form-control" <?php if($_GET['min'] >'0'  ) { ?>value="<?=$_GET['min']?>" <?php }?> id="min"  name="min">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text font-12 font-weight-bold"><i class="fas fa-tag"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label for="max" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                    <?=$diller['adminpanel-form-text-1442']?>
                                                </label>
                                                <div class="input-group mb-2">
                                                    <input type="number" class="form-control" id="max"  name="max" <?php if($_GET['max'] >'0'  ) { ?>value="<?=$_GET['max']?>" <?php }?>>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text font-12 font-weight-bold"><i class="fas fa-tag"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <button class="btn  m-1 btn-primary  " style="width: 150px; margin-left: 0px !important;"><?=$diller['adminpanel-form-text-1292']?></button>
                                                <?php if ( isset($_GET['search']) || isset($_GET['brand']) || isset($_GET['stokCode']) || isset($_GET['barcode']) || isset($_GET['feature']) ||isset($_GET['productStatus']) || isset($_GET['date']) || isset($_GET['date_end']) || isset($_GET['min']) || isset($_GET['max']) || isset($_GET['sort']) ) {?>
                                                <a class="btn  m-1 btn-danger text-white" href="pages.php?page=allupdate_product" style="width: 150px">
                                                    <i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1114']?>
                                                </a>
                                                <?php } ?>
                                                <a class="btn  m-1 btn-secondary text-white" style="width: 90px;" data-toggle="collapse" data-target="#filterAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Fİlter SON !-->
                        <div class="w-100 mt-3 mb-3">
                           <div class="">
                               <?php if(isset($_GET['search']) || isset($_GET['productStatus']) || isset($_GET['feature'])  ||isset($_GET['category']) || isset($_GET['brand']) || isset($_GET['date']) || isset($_GET['date_end']) ||isset($_GET['min']) || isset($_GET['max'])) {?>
                                   <?php

                                   $searchGet = htmlspecialchars($_GET['search']);
                                   if(isset($_GET['search']) && $_GET['search']== !null  ) {
                                       $search = "where (baslik like '%$searchGet%' or seo_baslik like '%$searchGet%' or spot like '%$searchGet%' or icerik like '%$searchGet%' or tags like '%$searchGet%' or meta_desc like '%$searchGet%' or urun_kod like '%$searchGet%' or seo_url like '%$searchGet%') ";
                                   }else{
                                       $search = "where (baslik like '%$searchGet%' or seo_baslik like '%$searchGet%' or spot like '%$searchGet%' or icerik like '%$searchGet%' or tags like '%$searchGet%' or meta_desc like '%$searchGet%' or urun_kod like '%$searchGet%' or seo_url like '%$searchGet%') ";
                                   }


                                   if(isset($_GET['productStatus'])  ) {
                                       if($_GET['productStatus'] == '0' || $_GET['productStatus'] == null  ||$_GET['productStatus'] == '1' || $_GET['productStatus'] == '2' ||$_GET['productStatus'] == '3' || $_GET['productStatus'] == '4' ||$_GET['productStatus'] == '5' || $_GET['productStatus'] == '6' || $_GET['productStatus'] == '7' || $_GET['productStatus'] == '8'  ) {
                                           if($_GET['productStatus'] == '0'  ) {
                                               $productStatusGet = "and durum='0'";
                                           }
                                           if($_GET['productStatus'] == '1'  ) {
                                               $productStatusGet = "and durum='1'";
                                           }
                                           if($_GET['productStatus'] == '2'  ) {
                                               $productStatusGet = "and gorunmez='1'";
                                           }
                                           if($_GET['productStatus'] == '3'  ) {
                                               $productStatusGet = "and siparis_islem='0'";
                                           }
                                           if($_GET['productStatus'] == '4'  ) {
                                               $productStatusGet = "and siparis_islem!='0'";
                                           }
                                           if($_GET['productStatus'] == '5'  ) {
                                               $productStatusGet = "and fiyat_goster='0'";
                                           }
                                           if($_GET['productStatus'] == '6'  ) {
                                               $productStatusGet = "and fiyat_goster='1'";
                                           }
                                           if($_GET['productStatus'] == '7'  ) {
                                               $productStatusGet = "and fiyat_goster='2'";
                                           }
                                           if($_GET['productStatus'] == '8'  ) {
                                               $productStatusGet = "and fiyat_goster='3'";
                                           }
                                       }else{
                                               $productStatusGet = null;
                                       }
                                   }else{
                                           $productStatusGet = null;
                                   }

                                   if(isset($_GET['feature'])  ) {
                                       if( $_GET['feature'] == null  ||$_GET['feature'] == '1' || $_GET['feature'] == '2' ||$_GET['feature'] == '3' || $_GET['feature'] == '4' ||$_GET['feature'] == '5' || $_GET['feature'] == '6'  ) {

                                           if ($_GET['feature'] == '1') {
                                               $featureGet = "and indirim='1'";
                                           }
                                           if ($_GET['feature'] == '2') {
                                               $featureGet = "and firsat='1'";
                                           }
                                           if ($_GET['feature'] == '3') {
                                               $featureGet = "and hizli_kargo='1'";
                                           }
                                           if ($_GET['feature'] == '4') {
                                               $featureGet = "and editor_secim ='1'";
                                           }
                                           if ($_GET['feature'] == '5') {
                                               $featureGet = "and yeni='1'";
                                           }
                                           if ($_GET['feature'] == '6') {
                                               $featureGet = "and taksit='1'";
                                           }
                                       }else{
                                               $featureGet = null;
                                       }
                                   }else{
                                       $featureGet = null;
                                   }

                                   if(isset($_GET['category']) && $_GET['category'] >'0'  ) {
                                       $categoryIDCome = htmlspecialchars($_GET['category']);
                                       $categoryGet = "and (kat_id like '%$categoryIDCome,%')";
                                   }

                                   if(isset($_GET['brand']) && $_GET['brand'] >'0'  ) {
                                       $brandSecureGet = htmlspecialchars($_GET['brand']);
                                       $brandGet = "and marka='$brandSecureGet'";
                                   }

                                   if(isset($_GET['date']) && $_GET['date'] >'0'  ) {
                                       $dateGet = "and sade_tarih >='$_GET[date]' ";
                                   }else{
                                       $dateGet = null;
                                   }

                                   if(isset($_GET['date_end']) && $_GET['date_end'] >'0'  ) {
                                       $dateEndGet = "and sade_tarih <='$_GET[date_end]'  ";
                                   }else{
                                       $dateEndGet = null;
                                   }

                                   if(isset($_GET['min']) && $_GET['min'] >'0'  ) {
                                       $minTutarSecure = htmlspecialchars($_GET['min']);
                                       $minTutarGet = "and (fiyat >='$minTutarSecure')  ";
                                   }else{
                                       $minTutarGet = null;
                                   }
                                   if(isset($_GET['max']) && $_GET['max'] >'0'  ) {
                                       $maxTutarSecure = htmlspecialchars($_GET['max']);
                                       $maxTutarGet = "and (fiyat <='$maxTutarSecure')  ";
                                   }else{
                                       $maxTutarGet = null;
                                   }


                                   $uruNSorgu = $db->prepare("select id from urun $search $productStatusGet $featureGet $categoryGet $brandGet $dateGet $dateEndGet $minTutarGet $maxTutarGet");
                                   $uruNSorgu->execute();

                                   ?>
                                   <div class="row">
                                       <div class="col-md-12">
                                           <div class="pb-2 mb-2  rounded border-info  border p-3 mb-3"  style="font-size: 13px ; background-color: #E2F3FF;">
                                               <?=$diller['adminpanel-form-text-1899']?> : <strong><?=$uruNSorgu->rowCount()?></strong>
                                           </div>
                                           <div class="border border-danger rounded  p-3 mb-3 " style="font-size: 13px ; background-color: #FFF2ED">
                                               <?=$diller['adminpanel-form-text-1898']?>
                                           </div>
                                            <div class="w-100 p-3 border rounded ">
                                                <div class="in-header-page-main" >
                                                    <div class="in-header-page-text">
                                                        <i class="fa fa-arrow-down"></i>
                                                        <?=$diller['adminpanel-form-text-1900']?>
                                                    </div>
                                                </div>
                                                <div class="pb-2 mb-2  rounded border  border p-4   shadow-sm"  >
                                                    <?php if($uruNSorgu->rowCount()>'0'  ) {?>
                                                        <form method="post" action="post.php?process=multi_update">
                                                            <input type="hidden" name="search_input" value="<?=htmlspecialchars($_GET['search'])?>" >
                                                            <input type="hidden" name="status_input" value="<?=htmlspecialchars($_GET['productStatus'])?>" >
                                                            <input type="hidden" name="feature_input" value="<?=htmlspecialchars($_GET['feature'])?>" >
                                                            <input type="hidden" name="date_1_input" value="<?=htmlspecialchars($_GET['date'])?>" >
                                                            <input type="hidden" name="date_2_input" value="<?=htmlspecialchars($_GET['date_end'])?>" >
                                                            <input type="hidden" name="min_input" value="<?=htmlspecialchars($_GET['min'])?>" >
                                                            <input type="hidden" name="max_input" value="<?=htmlspecialchars($_GET['max'])?>" >
                                                            <input type="hidden" name="category_input" value="<?=htmlspecialchars($_GET['category'])?>" >
                                                            <input type="hidden" name="brand_input" value="<?=htmlspecialchars($_GET['brand'])?>" >
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <select name="secenek" class="form-control selet2" id="secenek"  style="width: 100%;  ">
                                                                        <option value="">--- <?=$diller['adminpanel-form-text-1901']?></option>
                                                                        <option value="price_plus"><?=$diller['adminpanel-form-text-1904']?></option>
                                                                        <option value="price_minus"><?=$diller['adminpanel-form-text-1905']?></option>
                                                                        <option value="price_plus_percent"><?=$diller['adminpanel-form-text-1904']?> (<?=$diller['adminpanel-form-text-1911']?>)</option>
                                                                        <option value="price_minus_percent"><?=$diller['adminpanel-form-text-1905']?> (<?=$diller['adminpanel-form-text-1911']?>)</option>
                                                                        <option value="stock_plus"><?=$diller['adminpanel-form-text-1906']?></option>
                                                                        <option value="stock_minus"><?=$diller['adminpanel-form-text-1910']?></option>
                                                                        <option value="cargo"><?=$diller['adminpanel-form-text-1907']?></option>
                                                                        <option value="kdv"><?=$diller['adminpanel-form-text-1908']?></option>
                                                                        <option value="status_choose"><?=$diller['adminpanel-form-text-1909']?></option>
                                                                        <option value="stock_code"><?=$diller['adminpanel-form-text-2135']?></option>
                                                                    </select>
                                                                </div>
                                                                <div id="price_plus_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="border p-2 mb-3 bg-light rounded">
                                                                                <?=$diller['adminpanel-form-text-1914']?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="plus_price_value">
                                                                                <?=$diller['adminpanel-form-text-1912']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">+</div>
                                                                                </div>
                                                                                <input type="text" class="form-control" id="plus_price_value"  name="plus_price_value">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="ozel_plus_price_value">
                                                                                <?=$diller['adminpanel-form-text-1913']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">+</div>
                                                                                </div>
                                                                                <input type="text" class="form-control" id="ozel_plus_price_value"  name="ozel_plus_price_value">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="price_minus_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="border p-2 mb-3 bg-light rounded">
                                                                                <?=$diller['adminpanel-form-text-1914']?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="minus_price_value">
                                                                                <?=$diller['adminpanel-form-text-1915']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">-</div>
                                                                                </div>
                                                                                <input type="text" class="form-control" id="minus_price_value"  name="minus_price_value">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="ozel_minus_price_value">
                                                                                <?=$diller['adminpanel-form-text-1916']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">-</div>
                                                                                </div>
                                                                                <input type="text" class="form-control" id="ozel_minus_price_value"  name="ozel_minus_price_value">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-8 ">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="hidden" name="indirim" value="0" >
                                                                                <input type="checkbox" class="individual" id="indirim" name='indirim' value="1" >
                                                                                <label for="indirim"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1928']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="price_plus_percent_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-4 form-group">
                                                                            <label for="plus_price_percent">
                                                                                <?=$diller['adminpanel-form-text-1917']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">+</div>
                                                                                </div>
                                                                                <input type="number" class="form-control" id="plus_price_percent"  name="plus_price_percent">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold">%</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 form-group">
                                                                            <label for="ozel_plus_price_percent">
                                                                                <?=$diller['adminpanel-form-text-1918']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">+</div>
                                                                                </div>
                                                                                <input type="number" class="form-control" id="ozel_plus_price_percent"  name="ozel_plus_price_percent">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold">%</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="price_minus_percent_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-4 form-group">
                                                                            <label for="minus_price_percent">
                                                                                <?=$diller['adminpanel-form-text-1919']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">-</div>
                                                                                </div>
                                                                                <input type="number" class="form-control" id="minus_price_percent"  name="minus_price_percent">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold">%</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 form-group">
                                                                            <label for="ozel_minus_price_percent">
                                                                                <?=$diller['adminpanel-form-text-1920']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">-</div>
                                                                                </div>
                                                                                <input type="number" class="form-control" id="ozel_minus_price_percent"  name="ozel_minus_price_percent">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold">%</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-8 ">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="hidden" name="indirim_percent" value="0" >
                                                                                <input type="checkbox" class="individual" id="indirim_percent" name='indirim_percent' value="1" >
                                                                                <label for="indirim_percent"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1928']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="stock_plus_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="plus_stock_value">
                                                                                <?=$diller['adminpanel-form-text-1921']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">+</div>
                                                                                </div>
                                                                                <input type="number" class="form-control" id="plus_stock_value"  name="plus_stock_value">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="stock_minus_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="minus_stock_value">
                                                                                <?=$diller['adminpanel-form-text-1922']?>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <div class="input-group-prepend">
                                                                                    <div class="input-group-text font-12 font-weight-bold">-</div>
                                                                                </div>
                                                                                <input type="number" class="form-control" id="minus_stock_value"  name="minus_stock_value">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="cargo_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="cargo_value">
                                                                                <?=$diller['adminpanel-form-text-1669']?>
                                                                            </label>
                                                                            <select name="cargo_value" class="form-control" id="cargo_value" >
                                                                                <option value="0"><?=$diller['adminpanel-form-text-1670']?></option>
                                                                                <option value="1"><?=$diller['adminpanel-form-text-1671']?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div id="kargo_tutar" class="col-md-12" style="display: none;">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-6 mb-3  ">
                                                                                    <label for="kargo_tipi" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                        * <?=$diller['adminpanel-form-text-1669']?>
                                                                                    </label>
                                                                                    <select name="kargo_tipi" class="form-control " id="kargo_tipi"  required style="width: 100%;  ">
                                                                                        <option value="0"><?=$diller['adminpanel-form-text-1676']?></option>
                                                                                        <option value="1"><?=$diller['adminpanel-form-text-1677']?></option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-3 mb-0">
                                                                                    <label for="kargo_ucret" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                        * <?=$diller['adminpanel-form-text-1672']?>
                                                                                    </label>
                                                                                    <div class="input-group mb-2">
                                                                                        <input type="text" class="form-control" autocomplete="off" id="kargo_ucret" value="<?=$row['kargo_ucret']?>" name="kargo_ucret" >
                                                                                        <div class="input-group-append">
                                                                                            <div class="input-group-text font-12 font-weight-bold">
                                                                                                <?=$Current_Money['sag_simge']?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-12 mb-3  ">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="hidden" name="hizli_kargo" value="0" >
                                                                                <input type="checkbox" class="individual" id="hizli_kargo" name='hizli_kargo' value="1">
                                                                                <label for="hizli_kargo"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1678']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-12 ">
                                                                            <label for="kargo_sure" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                <?=$diller['adminpanel-form-text-1679']?>
                                                                            </label>
                                                                            <input type="text" name="kargo_sure" autocomplete="off" id="kargo_sure" placeholder="<?=$diller['adminpanel-form-text-1680']?>"  class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="kdv_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="kdv_value">
                                                                                <?=$diller['adminpanel-form-text-1922']?>
                                                                            </label>
                                                                            <select name="kdv_value" class="form-control" id="kdv_value" required>
                                                                                <option value="0"><?=$diller['adminpanel-form-text-1923']?></option>
                                                                                <option value="1"><?=$diller['adminpanel-form-text-1924']?></option>
                                                                                <option value="2"><?=$diller['adminpanel-form-text-1925']?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div id="kdv_oran" class="col-md-6" style="display: none;" >
                                                                            <div class="form-group col-md-6 mb-0">
                                                                                <label for="kdv_percent" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                    * <?=$diller['adminpanel-form-text-1667']?>
                                                                                </label>
                                                                                <div class="input-group mb-2">
                                                                                    <input type="text" class="form-control" autocomplete="off" id="kdv_percent"  name="kdv_percent" >
                                                                                    <div class="input-group-append">
                                                                                        <div class="input-group-text font-12 font-weight-bold">
                                                                                            <i class="fas fa-percent"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="status_div" class="col-md-12" style="display:none">
                                                                    <div class="row">
                                                                        <div class="col-md-7 form-group">
                                                                            <select name="durum_value" class="form-control" id="durum_value"  style="width: 100%;  ">
                                                                                <option value="1"><?=$diller['adminpanel-form-text-1926']?></option>
                                                                                <option value="7"><?=$diller['adminpanel-form-text-1934']?></option>
                                                                                <option value="2"><?=$diller['adminpanel-form-text-1927']?></option>
                                                                                <option value="8"><?=$diller['adminpanel-form-text-1935']?></option>
                                                                                <option value="3"><?=$diller['adminpanel-form-text-1929']?></option>
                                                                                <option value="4"><?=$diller['adminpanel-form-text-1930']?></option>
                                                                                <option value="5"><?=$diller['adminpanel-form-text-1931']?></option>
                                                                                <option value="6"><?=$diller['adminpanel-form-text-1932']?></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    $('#secenek').on('change', function() {
                                                                        $('#price_plus_div').css('display', 'none');
                                                                        if ( $(this).val() === 'price_plus' ) {
                                                                            $('#price_plus_div').css('display', 'block');
                                                                        }
                                                                        $('#price_minus_div').css('display', 'none');
                                                                        if ( $(this).val() === 'price_minus' ) {
                                                                            $('#price_minus_div').css('display', 'block');
                                                                        }
                                                                        $('#price_plus_percent_div').css('display', 'none');
                                                                        if ( $(this).val() === 'price_plus_percent' ) {
                                                                            $('#price_plus_percent_div').css('display', 'block');
                                                                        }
                                                                        $('#price_minus_percent_div').css('display', 'none');
                                                                        if ( $(this).val() === 'price_minus_percent' ) {
                                                                            $('#price_minus_percent_div').css('display', 'block');
                                                                        }
                                                                        $('#stock_plus_div').css('display', 'none');
                                                                        if ( $(this).val() === 'stock_plus' ) {
                                                                            $('#stock_plus_div').css('display', 'block');
                                                                        }
                                                                        $('#stock_minus_div').css('display', 'none');
                                                                        if ( $(this).val() === 'stock_minus' ) {
                                                                            $('#stock_minus_div').css('display', 'block');
                                                                        }
                                                                        $('#cargo_div').css('display', 'none');
                                                                        if ( $(this).val() === 'cargo' ) {
                                                                            $('#cargo_div').css('display', 'block');
                                                                        }
                                                                        $('#kdv_div').css('display', 'none');
                                                                        if ( $(this).val() === 'kdv' ) {
                                                                            $('#kdv_div').css('display', 'block');
                                                                        }
                                                                        $('#status_div').css('display', 'none');
                                                                        if ( $(this).val() === 'status_choose' ) {
                                                                            $('#status_div').css('display', 'block');
                                                                        }
                                                                    });
                                                                    $('#kdv_value').on('change', function() {
                                                                        $('#kdv_oran').css('display', 'none');
                                                                        if ( $(this).val() === '1' || $(this).val() === '2' ) {
                                                                            $('#kdv_oran').css('display', 'block');
                                                                        }
                                                                    });
                                                                    $('#cargo_value').on('change', function() {
                                                                        $('#kargo_tutar').css('display', 'none');
                                                                        if ( $(this).val() === '1' ) {
                                                                            $('#kargo_tutar').css('display', 'block');
                                                                        }
                                                                    });
                                                                </script>
                                                            </div>
                                                            <input type="hidden" name="updateStatusPersonality" value="true">
                                                            <input type="hidden" name="updateStatus" value="success">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <button class="btn btn-success" id="waitButton">
                                                                        <?=$diller['adminpanel-form-text-1902']?>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <?php }else { ?>
                                                        <?=$diller['adminpanel-form-text-1933']?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                               <?php }else { ?>
                                   <div class="row">
                                       <div class="col-md-12">
                                           <div class="border p-3 d-flex align-items-center rounded justify-content-center" style="font-size: 15px ; min-height: 185px">
                                               <div class="col-md-5 text-center">
                                                   <?=$diller['adminpanel-form-text-1903']?>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               <?php }?>
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

<script>
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#filterAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#filterAcc').offset().top - 80 },
                500);
        });
    });
</script>

<?php if($_SESSION['collepse_status'] == 'genelAcc'  ) {?>
    <script>
        $('#genelAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#genelAcc').offset().top - 80 },
            0);
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>

<script>
    $(document).ready(function() {
        $('.catalog_brand_select').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-1091']?>',
            ajax: {
                url: 'masterpiece.php?page=brand_select',
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
    $(document).ready(function() {
        $('.catalog_cat_select').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-1091']?>',
            ajax: {
                url: 'masterpiece.php?page=category_select',
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
    $(document).ready(function() {
        $('.selet2').select2({

        })})
</script>
