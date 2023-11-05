<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';

if($_GET['status'] == 'newproductgo'  ) { 
    if($_SESSION['main_alert'] == 'success_product'  ) {
        $LastProductCheck = $db->prepare("select id from urun order by id desc limit 1 ");
        $LastProductCheck->execute();
        $lastRow = $LastProductCheck->fetch(PDO::FETCH_ASSOC);
        $_SESSION['go_product'] = 'okay';
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail&productID='.$lastRow['id'].'');
        unset($_SESSION['main_alert']);
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=products');
    }
}

if($_GET['search'] == !null ) {
    if(strip_tags(htmlspecialchars($_GET['search'])) <= '0'  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=products');
        exit();
    }

}

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if ( isset($_GET['limit']) || isset($_GET['catID']) || isset($_GET['search']) || isset($_GET['stokCode']) || isset($_GET['barcode']) || isset($_GET['productStatus']) || isset($_GET['brand']) || isset($_GET['feature']) || isset($_GET['sort']) || isset($_GET['date']) || isset($_GET['date_end']) || isset($_GET['min']) || isset($_GET['max'])) {
    $filterPage = "&limit=$_GET[limit]&catID=$_GET[catID]&search=$_GET[search]&stokCode=$_GET[stokCode]&barcode=$_GET[barcode]&productStatus=$_GET[productStatus]&brand=$_GET[brand]&feature=$_GET[feature]&sort=$_GET[sort]&date=$_GET[date]&date_end=$_GET[date_end]&min=$_GET[min]&max=$_GET[max]";
}

if(isset($_GET['status_update'])  ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['status_update'] == !null) {

            $statusCek = $db->prepare("select * from urun where id=:id ");
            $statusCek->execute(array(
                'id' => $_GET['status_update']
            ));

            if ($statusCek->rowCount() > '0') {
                $st = $statusCek->fetch(PDO::FETCH_ASSOC);


                if ($st['durum'] == '1') {
                    $statusum = '0';
                }
                if ($st['durum'] == '0') {
                    $statusum = '1';
                }

                $guncelle = $db->prepare("UPDATE urun SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
                $sonuc = $guncelle->execute(array(
                    'durum' => $statusum
                ));
                if ($sonuc) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=products'.$filterPage.''.$sayfa.'');
                } else {
                    echo 'Veritabanı Hatası';
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=products');
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=products');
        }
    }else{
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=products');
    }
}





?>
<title><?=$diller['adminpanel-menu-text-3']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-2']?></a>
                                <a href="pages.php?page=products"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-3']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['katalog'] == '1' && $yetki['urun'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (baslik like '%$_GET[search]%' or seo_baslik like '%$_GET[search]%' or spot like '%$_GET[search]%' or icerik like '%$_GET[search]%' or tags like '%$_GET[search]%' or meta_desc like '%$_GET[search]%' or urun_kod like '%$_GET[search]%' or seo_url like '%$_GET[search]%') ";
            }else{
                $search = "where (baslik like '%$_GET[search]%' or seo_baslik like '%$_GET[search]%' or spot like '%$_GET[search]%' or icerik like '%$_GET[search]%' or tags like '%$_GET[search]%' or meta_desc like '%$_GET[search]%' or urun_kod like '%$_GET[search]%' or seo_url like '%$_GET[search]%') ";
            }

            if(isset($_GET['limit']) && $_GET['limit'] >'0'  ) {
                $limitGet = $_GET['limit'];
            }else{
                $limitGet = '30';
            }

            if(isset($_GET['stokCode']) && $_GET['stokCode'] >'0'  ) {
                $stockGet = "and urun_kod='$_GET[stokCode]'";
            }else{
                $stockGet = null;
            }

            if(isset($_GET['barcode']) && $_GET['barcode'] >'0'  ) {
                $barcodeGet = "and barkod='$_GET[barcode]'";
            }else{
                $barcodeGet = null;
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
                 header('Location:'.$ayar['panel_url'].'pages.php?page=products');
             }
            }

            if(isset($_GET['brand'])  ) {
                $markaSorgu = $db->prepare("select id,baslik from urun_marka where id=:id ");
                $markaSorgu->execute(array(
                    'id' => $_GET['brand'],
                ));
                $markaVer = $markaSorgu->fetch(PDO::FETCH_ASSOC);
                if($markaSorgu->rowCount()>'0'  ) {
                    $brandHave = '1';
                    $markaAdi = $markaVer['baslik'];
                    $brandGet = "and marka='$_GET[brand]'";
                }
            }

            if(isset($_GET['catID'])  ) {
                $catSorgu = $db->prepare("select id,baslik from urun_cat where id=:id ");
                $catSorgu->execute(array(
                    'id' => $_GET['catID'],
                ));
                $catRow = $catSorgu->fetch(PDO::FETCH_ASSOC);
                if($catSorgu->rowCount()>'0'  ) {
                    $brandHave = '1';
                    $katAdi = $catRow['baslik'];
                    $katGet = "and iliskili_kat='$_GET[catID]'";
                }
            }

            if(isset($_GET['feature'])  ) {
                if( $_GET['feature'] == null  ||$_GET['feature'] == '1' || $_GET['feature'] == '2' ||$_GET['feature'] == '3' || $_GET['feature'] == '4' ||$_GET['feature'] == '5' || $_GET['feature'] == '6'  ) {

                    if($_GET['feature'] == '1'  ) {
                        $featureGet = "and indirim='1'";
                    }
                    if($_GET['feature'] == '2'  ) {
                        $featureGet = "and firsat='1'";
                    }
                    if($_GET['feature'] == '3'  ) {
                        $featureGet = "and hizli_kargo='1'";
                    }
                    if($_GET['feature'] == '4'  ) {
                        $featureGet = "and editor_secim ='1'";
                    }
                    if($_GET['feature'] == '5'  ) {
                        $featureGet = "and yeni='1'";
                    }
                    if($_GET['feature'] == '6'  ) {
                        $featureGet = "and taksit='1'";
                    }

                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=products');
                }
            }

            if(isset($_GET['sort']) && $_GET['sort'] >'0'  ) {
                if($_GET['sort'] == '1' || $_GET['sort'] == '2'  || $_GET['sort'] == '3' || $_GET['sort'] == '4' || $_GET['sort'] == '5' || $_GET['sort'] == '6' || $_GET['sort'] == '7') {
                    if($_GET['sort'] == '1'  ) {
                        $sortOrder = "id desc";
                    }
                    if($_GET['sort'] == '2'  ) {
                        $sortOrder = "id asc";
                    }
                    if($_GET['sort'] == '3'  ) {
                        $sortOrder = "hit desc";
                    }
                    if($_GET['sort'] == '4'  ) {
                        $sortOrder = "satis_adet desc";
                    }
                    if($_GET['sort'] == '5'  ) {
                        $sortOrder = "fiyat desc";
                    }
                    if($_GET['sort'] == '6'  ) {
                        $sortOrder = "fiyat asc";
                    }
                    if($_GET['sort'] == '7'  ) {
                        $sortOrder = "stok asc";
                    }
                }else{
                    $sortOrder = "id desc";
                }
            }
            if(!isset($_GET['sort'])  ) {
                $sortOrder = "id desc";
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
                $minTutarGet = "and (fiyat >='$_GET[min]')  ";
            }else{
                $minTutarGet = null;
            }
            if(isset($_GET['max']) && $_GET['max'] >'0'  ) {
                $maxTutarGet = "and (fiyat <='$_GET[max]')  ";
            }else{
                $maxTutarGet = null;
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from urun $search and dil='$_SESSION[dil]' $stockGet $katGet $barcodeGet $productStatusGet $brandGet $featureGet $dateGet $dateEndGet $minTutarGet $maxTutarGet");
            $ToplamVeri = $Say->rowCount();
            $Limit = $limitGet;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from urun $search and dil='$_SESSION[dil]' $stockGet $katGet $barcodeGet $productStatusGet $brandGet $featureGet $dateGet $dateEndGet $minTutarGet $maxTutarGet order by $sortOrder limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);



            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top mb-0  pb-2 ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-3']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1746']?></a>
                                <div class="dropdown">
                                    <a href="" class="btn btn-light border " type="button" style="font-size: 13px ; font-weight: 400;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right ssa border  " style="margin-top: 4px !important;">
                                        <a class="dropdown-item" href="pages.php?page=theme_catalog_settings"  target="_blank" class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-menu-text-103']?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 pt-3 mb-3">
                                    <form action="post.php?process=catalog_post&status=product_add" method="post" enctype="multipart/form-data">

                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-white text-dark mt-n3 mb-0 border-bottom">
                                                <h5> <?=$diller['adminpanel-form-text-1746']?></h5>
                                            </div>
                                        </div>


                                        <div class="row mb-3 d-flex align-items-center justify-content-center bg-light border-bottom ">
                                            <div class="form-group col-md-6 mb-3 pt-3 ">
                                                <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                        <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                        <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>


                                        <div class="row d-flex align-items-center justify-content-center ">
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="durum" class="w-100" >
                                                    <?=$diller['adminpanel-form-text-1749']?>
                                                    <div  style="font-size: 11px ; color: #999; font-weight: 200;"><?=$diller['adminpanel-form-text-1750']?></div>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"   ">
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center ">
                                            <div class="form-group col-md-6 mb-4 mt-2">
                                                <label  for="gorunmez" class="w-100" >
                                                    <?=$diller['adminpanel-form-text-1754']?>
                                                    <div  style="font-size: 11px ; color: #999; font-weight: 200;"><?=$diller['adminpanel-form-text-1755']?></div>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="gorunmez" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="gorunmez" name="gorunmez" value="1"   ">
                                                    <label class="custom-control-label" for="gorunmez"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center ">
                                            <div class="form-group col-md-6">
                                                <label for="baslik">* <?=$diller['adminpanel-form-text-1748']?></label>
                                                <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center ">
                                            <div class="form-group col-md-6">
                                                <label for="seo_url">
                                                    <?=$diller['adminpanel-form-text-1756']?>
                                                    <div  style="font-size: 11px ; color: #999; font-weight: 200;"><?=$diller['adminpanel-form-text-1757']?></div>
                                                </label>
                                                <input type="text" autocomplete="off"  name="seo_url" id="seo_url"  placeholder="<?=$diller['adminpanel-form-text-1763']?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center ">
                                            <div class="form-group col-md-3">
                                                <label for="urun_kod" class="d-flex align-items-center justify-content-start ">
                                                    <?=$diller['adminpanel-form-text-1758']?>
                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1760']?>"></i>
                                                </label>
                                                <input type="text" autocomplete="off"  name="urun_kod" id="urun_kod"  class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="stok" class="d-flex align-items-center justify-content-start ">
                                                   * <?=$diller['adminpanel-form-text-1759']?>
                                                </label>
                                                <input type="number" autocomplete="off"  name="stok" required id="stok"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center ">
                                            <div class="form-group col-md-6">
                                                <label for="inputGroupFile01">
                                                   <i class="fa fa-camera"></i> <?=$diller['adminpanel-form-text-1761']?>
                                                    <div  style="font-size: 11px ; color: #999; font-weight: 200;"><?=$diller['adminpanel-form-text-1762']?></div>
                                                </label>
                                                <div class="input-group mb-1">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel" >
                                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                                    </div>
                                                </div>
                                                <div class="w-100 text-center bg-light rounded text-dark  ">
                                                    <small>[550x600] - png,  jpg, gif, webp, bmp</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center mb-3 border-top pt-3">
                                            <div class="col-md-6 d-flex align-items-center">
                                                <button class="btn  btn-success flex-grow-1 mr-2 " name="insert"><?=$diller['adminpanel-form-text-1747']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
                            <div class="collapse <?php if (isset($_GET['search']) || isset($_GET['stokCode']) || isset($_GET['barcode']) || isset($_GET['feature']) ||isset($_GET['productStatus']) || isset($_GET['date']) || isset($_GET['date_end']) || isset($_GET['min']) || isset($_GET['max']) || isset($_GET['sort']) ) {?>show<?php } ?>" id="filterAcc" data-parent="#accordions">
                                <form method="GET" action="pages.php">
                                    <input type="hidden" name="page" value="products" >
                                    <?php if(isset($_GET['catID'])  ) {?>
                                        <input type="hidden" name="catID" value="<?=$_GET['catID']?>" >
                                    <?php }?>
                                    <div class="p-3  border border-top-0" style="padding-bottom: 0!important;">
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label for="limit" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1529']?>
                                                </label>
                                                <input type="text" name="limit" autocomplete="off" <?php if($_GET['limit'] >'0'  ) { ?>value="<?=$_GET['limit']?>" <?php }else{?>value="30"<?php } ?> id="limit"  class="form-control" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label for="search" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-154']?>
                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1780']?>"></i>
                                                </label>
                                                <input type="text" name="search" autocomplete="off" <?php if($_GET['search'] >'0'  ) { ?>value="<?=$_GET['search']?>" <?php }?> id="search"  class="form-control" >
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="stokCode" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1758']?>
                                                </label>
                                                <input type="text" name="stokCode" autocomplete="off" <?php if($_GET['stokCode'] >'0'  ) { ?>value="<?=$_GET['stokCode']?>" <?php }?> id="stokCode"  class="form-control" >
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="barcode" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1781']?>
                                                </label>
                                                <input type="text" name="barcode" autocomplete="off" <?php if($_GET['barcode'] >'0'  ) { ?>value="<?=$_GET['barcode']?>" <?php }?> id="barcode"  class="form-control" >
                                            </div>
                                            <div class="col-md-3 form-group">
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
                                            <div class="col-md-3 form-group">
                                                <label for="brand" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-menu-text-117']?>
                                                </label>
                                                <select name="brand" class="form-control catalog_brand_select" id="productStatus" style="width: 100%;  " >
                                                </select>
                                            </div>
                                            <div class="col-md-3 form-group">
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
                                            <div class="col-md-6 form-group">
                                                <label for="sort" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1784']?>
                                                </label>
                                                <select name="sort" class="form-control selet2" id="sort" style="width: 100%;  " >
                                                    <option value="1" <?php if( $_GET['sort'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1443']?></option>
                                                    <option value="2" <?php if( $_GET['sort'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1449']?></option>
                                                    <option value="3" <?php if( $_GET['sort'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1785']?></option>
                                                    <option value="4" <?php if( $_GET['sort'] == '4' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1786']?></option>
                                                    <option value="5" <?php if( $_GET['sort'] == '5' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-332']?></option>
                                                    <option value="6" <?php if( $_GET['sort'] == '6' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-331']?></option>
                                                    <option value="7" <?php if( $_GET['sort'] == '7' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1797']?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label for=""><?=$diller['adminpanel-form-text-1088']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date" <?php if($_GET['date'] >'0'  ) { ?>value="<?=$_GET['date']?>" <?php }?> class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_first" autocomplete="off"  style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for=""><?=$diller['adminpanel-form-text-1089']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date_end" <?php if($_GET['date_end'] >'0'  ) { ?>value="<?=$_GET['date_end']?>" <?php }?> class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_ends" autocomplete="off"  style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>

                                            <div class="form-group col-md-3 ">
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
                                            <div class="form-group col-md-3 ">
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
                                                <a class="btn  m-1 btn-danger text-white" href="pages.php?page=products" style="width: 150px">
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



                        <div class="w-100 mt-3">

                        <form action="post.php?process=catalog_post&status=multidelete" method="post">
                            <?php if($ToplamVeri>'0'  ) {?>
                                <div class="d-flex align-items-center justify-content-end mb-1">
                                    <a href="pages.php?page=product_export" target="_blank" class="btn  m-1 btn-light border" >
                                        <i class="fa fa-upload"></i> <?=$diller['adminpanel-form-text-1745']?> (XML)
                                    </a>
                                    <a href="pages.php?page=product_import" target="_blank" class="btn  m-1 btn-light border" >
                                        <i class="fa fa-download"></i> <?=$diller['adminpanel-form-text-1764']?> (XML)
                                    </a>
                                </div>
                            <?php }?>

                            <!-- Brand Name !-->
                            <?php if(isset($_GET['brand']) && $brandHave == '1' && $_GET['brand']> '0'  ) {?>
                                <div class="w-100 mb-3 bg-light border p-4 rounded" style="font-size: 20px ;">
                                    <?=$markaAdi?> <?=$diller['adminpanel-form-text-1796']?>
                                </div>
                            <?php }?>
                            <!--  <========SON=========>>> Brand Name SON !-->

                            <!-- Category Filter !-->
                            <?php if(isset($_GET['catID']) && $_GET['catID']> '0'  ) {?>
                                <div class="w-100 mb-3 bg-light border p-4 rounded" style="font-size: 20px ;">
                                    <?=$katAdi?> <?=$diller['adminpanel-form-text-2155']?>
                                </div>
                            <?php }?>
                            <!--  <========SON=========>>> Category Filter SON !-->


                            <div class="table-responsive ">
                                <table class="table table-bordered table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th width="30" class="text-center" style="max-width: 40px; text-align: center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                            </div>
                                        </th>
                                        <th>
                                            
                                        </th>
                                        <th><?=$diller['adminpanel-form-text-1748']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-1758']?></th>
                                        <th><?=$diller['adminpanel-form-text-1765']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-1767']?></th>
                                        <th></th>
                                        <th class="text-center" style="font-size: 11px ;"><?=$diller['adminpanel-form-text-843']?></th>
                                        <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {
                                        ?>
                                        <tr>
                                            <td class="text-center" width="30" style="max-width: 40px; text-align: center">
                                                <div class="custom-control custom-checkbox" >
                                                    <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                    <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                </div>
                                            </td>
                                            <td style="width: 40px;">
                                                <img src="../images/product/<?=$row['gorsel']?>" style="width: 35px; " class="shadow-sm">
                                            </td>
                                            <td width="300" style="min-width: 300px">
                                                <?php if($row['pazaryeri_adi'] == 'trendyol' ||$row['pazaryeri_adi'] == 'n11' ||$row['pazaryeri_adi'] == 'hepsiburada'  ) {?>
                                                <div class="mb-2">
                                                    <?php if($row['pazaryeri_adi'] == 'trendyol' ) {?>
                                                        <div class="badge" style="background-color: tomato; cursor:pointer;" data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-125']?>">TRENDYOL</div>
                                                    <?php }?>
                                                </div>
                                                <?php }?>
                                                <a  target="_blank" href="<?=$ayar['site_url']?><?=$row['seo_url']?>-P<?=$row['id']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1690']?>"><i class="fa fa-external-link-alt"></i></a>
                                                <?=$row['baslik']?>
                                            </td>
                                            <td width="110" style="min-width: 110px; font-weight: 500; text-align: center;" >
                                                <?=$row['urun_kod']?>
                                            </td>
                                            <td width="120" style="min-width: 120px; font-weight: 500;">
                                                <?php if($row['kdv'] == '0' ) {?>
                                                    <?php echo number_format($row['fiyat'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                <?php }?>
                                                <?php if($row['kdv'] == '1' ) {?>
                                                    <!-- +KDV !-->
                                                    <?php
                                                    $kdvtutar= kdvhesapla($row['fiyat'],$row['kdv_oran']);
                                                    ?>
                                                    <?php echo number_format($row['fiyat']+$kdvtutar, 2); ?> <?=$Current_Money['sag_simge']?>
                                                    <div style="font-size: 11px ;font-weight: 200;">
                                                        (<?=$diller['adminpanel-form-text-1766']?>)
                                                    </div>
                                                    <!--  <========SON=========>>> +KDV SON !-->
                                                <?php }?>
                                                <?php if($row['kdv'] == '2' ) {?>
                                                    <!-- KDV DAHİL !-->
                                                    <?php echo number_format($row['fiyat'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                    <div style="font-size: 11px ;font-weight: 200;">
                                                        (<?=$diller['adminpanel-form-text-1766']?>)
                                                    </div>
                                                    <!--  <========SON=========>>> KDV DAHİL !-->
                                                <?php }?>
                                            </td>
                                            <td width="80" style="min-width: 80px; text-align: center; font-weight: 600;" >
                                                <?=$row['stok']?>
                                            </td>
                                            <td class="text-center" style="min-width: 100px" width="100">
                                                <?php if($row['gorunmez'] == '1' ) {?>
                                                    <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-light border mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1769']?>">
                                                        <?=$diller['adminpanel-form-text-1768']?>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['anasayfa'] == '1' ) {?>
                                                    <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-dark  text-white mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1777']?>">
                                                        <?=$diller['adminpanel-form-text-1776']?>
                                                    </div>
                                                <?php } ?>
                                                <?php if($row['yeni'] == '1' ) {?>
                                                    <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-light border text-dark mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1681']?>">
                                                        <?=$diller['adminpanel-form-text-1682']?>
                                                    </div>
                                                <?php } ?>
                                                <?php if($row['indirim'] == '1' ) {?>
                                                    <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-light border mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1771']?>">
                                                        <?=$diller['adminpanel-form-text-1770']?>
                                                    </div>
                                                <?php } ?>
                                                <?php if($row['firsat'] == '1' ) {?>
                                                    <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-light border mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1773']?>">
                                                        <?=$diller['adminpanel-form-text-1772']?>
                                                    </div>
                                                <?php } ?>
                                                <?php if($row['hizli_kargo'] == '1' ) {?>
                                                    <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-light border mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1775']?>">
                                                        <?=$diller['adminpanel-form-text-1774']?>
                                                    </div>
                                                <?php } ?>
                                                <?php if($row['editor_secim'] == '1' ) {?>
                                                    <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-light border mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1779']?>">
                                                        <?=$diller['adminpanel-form-text-1778']?>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <td width="100" style="min-width: 100px; text-align: center;">
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <a class="btn btn-sm btn-outline-danger " href="pages.php?page=products&status_update=<?=$row['id']?><?=$sayfa?><?=$filterPage?>">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-times mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-68']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <a class="btn btn-sm btn-success " href="pages.php?page=products&status_update=<?=$row['id']?><?=$sayfa?><?=$filterPage?>">
                                                        <div class="d-flex align-items-center">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <?=$diller['adminpanel-form-text-67']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                            </td>
                                            <td class="text-center" width="230" style="min-width: 230px">
                                                <a href="pages.php?page=product_detail_entegration&productID=<?=$row['id']?>" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-13']?>"><i class="fas fa-store-alt"></i></a>
                                                <a href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>" class="btn btn-sm btn-dark " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-menu-text-7']?>"><i class=" fa fa-sitemap " ></i></a>
                                                <a href="pages.php?page=product_detail_features&productID=<?=$row['id']?>" class="btn btn-sm btn-dark  " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1611']?>"><i class="fa fa-bars fa-fw" ></i></a>
                                                <a href="pages.php?page=product_detail_gallery&productID=<?=$row['id']?>" class="btn btn-sm btn-dark  " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1600']?>"><i class="fas fa-images"></i></a>
                                                <a href="pages.php?page=product_detail&productID=<?=$row['id']?>" class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-115']?>"><i class="fa fa-eye" ></i></a>
                                                <a href="" data-href="post.php?process=catalog_post&status=product_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
                                            </td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>

                                <!-- Kaydırılabilir Alert !-->
                                <div class="d-md-none d-sm-block p-2 bg-light  text-center">
                                    <?=$diller['adminpanel-text-340']?> <i class="fas fa-hand-pointer"></i>
                                </div>
                                <!--  <========SON=========>>> Kaydırılabilir Alert SON !-->
                                <?php if($ToplamVeri<='0' ) {?>
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                <?php }?>
                            <?php if($ToplamVeri > '0') {?>
                            <div class="w-100 pt-3 pb-3 border-bottom   " >
                                <button class="btn btn-danger btn-sm pl-4 pr-4 " disabled="disabled" name="deleteMulti" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                            </div>
                        </form>
                            <script>
                                var checkboxes = $("input[type='checkbox']"),
                                    submitButt = $("button[name='deleteMulti']");

                                checkboxes.click(function() {
                                    submitButt.attr("disabled", !checkboxes.is(":checked"));
                                });
                            </script>
                        <?php }?>
                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=products<?=$filterPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=products<?=$filterPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=products<?=$filterPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=products<?=$filterPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=products<?=$filterPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=products<?=$filterPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                                <?php }} ?>
                                            <?php if($Sayfa >= 1){?>
                                        </ul>
                                    </nav>
                                <?php } ?>
                                </div>
                            <?php }?>
                            <!---- Sayfalama Elementleri ================== !-->

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
            placeholder: ' <?=$diller['adminpanel-form-text-1783']?>',
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
        $('.selet2').select2({

        })})
</script>
