<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'tabproduct';

$temaayar = $db->prepare("select * from vitrin_secenekli_ayar where id='1' ");
$temaayar->execute();
$temayar = $temaayar->fetch(PDO::FETCH_ASSOC);
$urunlimit = $temayar['secenekvitrin_tab_urun_limit'];
?>
<title><?=$diller['adminpanel-menu-text-11']?> - <?=$panelayar['baslik']?></title>
<style>
    .nav-link{
        color: #000;
        transition-duration: 0.1s; transition-timing-function: linear;
        font-weight: 500;
        font-size: 14px;
        padding: 15px 12px;

    }
    .saas:hover{
        background-color: #fff;
        color: #000;
    }
    @media (max-width: 768px) {
        .nav-tabs{
            overflow-x: scroll;
            flex-wrap: nowrap;
        }
        .nav-link.active{
            border-color: #dee2e6 #dee2e6 #dee2e6 !important;
            border-radius: 10px !important;
        }
    }
</style>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">


        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center d-flex justify-content-between" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-67']?></a>
                                <a href="pages.php?page=showcase_tabproduct"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-11']?></a>
                            </div>
                        </div>
                        <div class="col-md-auto mr-3" >
                            <?php if($yetki['modul'] == '1' && $yetki['modul_vitrin'] == '1' ) {?>
                                <div class="mt-2 d-md-none d-sm-block"></div>
                                <a  class="btn btn-info text-white " href="pages.php?page=theme_showcase_tab"><?=$diller['adminpanel-form-text-838']?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <?php if($yetki['modul'] == '1' &&  $yetki['modul_vitrin'] == '1') {
            ?>

            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">




                    <!-- Tab headers !-->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <!-- Yeni Ürün Tab !-->
                        <li class="nav-item">
                            <a class="nav-link saas  active" id="yeni-tab" data-toggle="tab" href="#yeni" role="tab" aria-controls="yeni" aria-selected="true">
                                <div ><?=$diller['adminpanel-form-text-413']?></div>
                            </a>
                        </li>
                        <!--  <========SON=========>>> Yeni Ürün Tab SON !-->
                        <!-- Popüler Ürünler Tab !-->
                        <li class="nav-item">
                            <a class="nav-link saas" id="populer-tab" data-toggle="tab" href="#populer" role="tab" aria-controls="populer" aria-selected="true">
                                <div ><?=$diller['adminpanel-form-text-415']?></div>
                            </a>
                        </li>
                        <!--  <========SON=========>>> Popüler Ürünler Tab SON !-->
                        <!-- İndirimli Ürünler Tab !-->
                        <li class="nav-item">
                            <a class="nav-link saas" id="indirim-tab" data-toggle="tab" href="#indirim" role="tab" aria-controls="indirim" aria-selected="true">
                                <div ><?=$diller['adminpanel-form-text-416']?></div>
                            </a>
                        </li>
                        <!--  <========SON=========>>> İndirimli Ürünler Tab SON !-->
                        <!-- Fırsat Ürünler Tab !-->
                        <li class="nav-item">
                            <a class="nav-link saas" id="firsat-tab" data-toggle="tab" href="#firsat" role="tab" aria-controls="firsat" aria-selected="true">
                                <div ><?=$diller['adminpanel-form-text-417']?></div>
                            </a>
                        </li>
                        <!--  <========SON=========>>> Fırsat Ürünler Tab SON !-->
                        <!-- Editor Ürünler Tab !-->
                        <li class="nav-item">
                            <a class="nav-link saas" id="editor-tab" data-toggle="tab" href="#editor" role="tab" aria-controls="editor" aria-selected="true">
                                <div ><?=$diller['adminpanel-form-text-418']?></div>
                            </a>
                        </li>
                        <!--  <========SON=========>>> Editor Ürünler Tab SON !-->
                        <!-- bedavaKargo Ürünler Tab !-->
                        <li class="nav-item">
                            <a class="nav-link saas" id="freeCargo-tab" data-toggle="tab" href="#freeCargo" role="tab" aria-controls="freeCargo" aria-selected="true">
                                <div ><?=$diller['adminpanel-form-text-419']?></div>
                            </a>
                        </li>
                        <!--  <========SON=========>>> bedavaKargo Ürünler Tab SON !-->
                        <!-- hızlıKargo Ürünler Tab !-->
                        <li class="nav-item">
                            <a class="nav-link saas" id="fastCargo-tab" data-toggle="tab" href="#fastCargo" role="tab" aria-controls="fastCargo" aria-selected="true">
                                <div><?=$diller['adminpanel-form-text-420']?></div>
                            </a>
                        </li>
                        <!--  <========SON=========>>> hızlıKargo Ürünler Tab SON !-->
                    </ul>
                    <!--  <========SON=========>>> Tab headers SON !-->

                    <!-- Tab Contents !-->
                    <div class="tab-content bg-white border border-top-0 rounded-bottom">

                        <!-- Yeni Ürünler Tab !-->
                        <div class="tab-pane  active p-3 " id="yeni" role="tabpanel" >
                            <div class="row  pl-2 pr-2" >

                                <?php if($temayar['secenekvitrin_yeni_urunler'] == '1' ) {
                                    $yeniUrunler = $db->prepare("select * from urun where yeni='1' and anasayfa='1' and durum='1' order by id desc limit $urunlimit ");
                                    $yeniUrunler->execute();
                                    ?>

                                    <div class="col-md-12 ">
                                        <div class="bg-light border rounded p-3 mb-3" style="font-size: 15px ;">
                                            <div style="font-size: 18px ; font-weight: 600;">
                                                <?=$diller['adminpanel-form-text-943']?> : <?=$urunlimit?>
                                            </div>
                                            <?=$diller['adminpanel-form-text-944']?>
                                        </div>
                                    </div>
                                        <div class="col-md-12 ">
                                            <div class=" border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div class="in-header-page-main" >
                                                    <div class="in-header-page-text">
                                                        * <?=$diller['adminpanel-form-text-938']?>
                                                    </div>
                                                </div>
                                                <div class=" mb-2 pt-2 pb-2 pl-3 pr-3 alert-warning border border-warning text-dark rounded" style="font-size: 12px ;">
                                                   <?=$diller['adminpanel-form-text-1752']?>
                                                </div>
                                                <form method="post" action="post.php?process=showcase_post&status=tab_insert&tab_insert=newproduct">
                                                <div class="row">
                                                    <div class="col-md-8 form-group">
                                                        <select class="urunler_select form-control col-md-12" name="urun_id"   id="urun_id" style="width: 100%!important;" >
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php if($yeniUrunler->rowCount()>'0'  ) {?>
                                    <?php foreach ($yeniUrunler as $yeniRow) {?>
                                        <div class="col-md-3"  >
                                            <div class="card border">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                        <?php if($yeniRow['gorunmez'] == '1'  ) {?>
                                                            <div class="position-absolute w-100 " style="background: rgba(255,255,255,0.9); top:0; padding: 20px; font-size: 16px ; font-weight: 500 ; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,.1)">
                                                                <i class="fa fa-eye-slash"></i> <?=$diller['adminpanel-form-text-1769']?>
                                                            </div>
                                                        <?php }?>
                                                        <img src="../images/product/<?=$yeniRow['gorsel']?>" class="img-fluid border " style="width: 135px; height: 135px;" >
                                                    </div>
                                                    <div class="text-center mb-3">
                                                        <?=$yeniRow['baslik']?>
                                                    </div>
                                                    <div class="text-center p-2">
                                                            <a class="btn btn-sm btn-outline-danger btn-block " href="post.php?process=showcase_post&status=tab_update&tab_update=newproduct&product_id=<?=$yeniRow['id']?>">
                                                                <i class="fa fa-times"></i>  <?=$diller['adminpanel-form-text-941']?>
                                                            </a>
                                                        <a class="btn btn-sm btn-primary btn-block  " target="_blank" href="pages.php?page=product_detail&productID=<?=$yeniRow['id']?>">
                                                            <i class="fa fa-eye"></i>  <?=$diller['adminpanel-form-text-942']?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <?php } ?>
                                    <?php if($yeniUrunler->rowCount()<='0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class=" rounded bg-light border   p-3 w-100">
                                                <?=$diller['adminpanel-form-text-945']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="col-md-12 ">
                                        <div class="bg-light border  p-3 w-100">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-939']?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Yeni Ürünler Tab SON !-->

                        <!-- Popüler Ürünler Tab !-->
                        <div class="tab-pane   p-3 " id="populer" role="tabpanel" >
                            <div class="row  pl-2 pr-2" >
                                <div class="loader-page-spin w-100 d-flex justify-content-center align-items-center" style="display: none !important;">
                                   <div class="spinner-border text-success"  style="width:50px; height: 50px; margin:38px 0" role="status">
                                       <span class="sr-only">Loading...</span>
                                   </div>
                               </div>
                                <?php if($temayar['secenekvitrin_populer_urunler'] == '1' ) {
                                    $populerUrunler = $db->prepare("select * from urun where anasayfa='1' and durum='1' order by hit desc limit $urunlimit ");
                                    $populerUrunler->execute();
                                    ?>
                                    <?php if($populerUrunler->rowCount()>'0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class="bg-light border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div style="font-size: 18px ; font-weight: 600;">
                                                    <?=$diller['adminpanel-form-text-943']?> : <?=$urunlimit?>
                                                </div>
                                                <?=$diller['adminpanel-form-text-944']?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class=" w-100 border p-3 mb-3 rounded alert alert-dismissible alert-warning border-warning text-dark">
                                                <div style="font-size: 12px ;">
                                                    <?=$diller['adminpanel-form-text-946']?>
                                                </div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>
                                        <?php foreach ($populerUrunler as $popRow) {?>
                                            <div class="col-md-3"  >
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                            <?php if($popRow['gorunmez'] == '1'  ) {?>
                                                                <div class="position-absolute w-100 " style="background: rgba(255,255,255,0.9); top:0; padding: 20px; font-size: 16px ; font-weight: 500 ; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,.1)">
                                                                    <i class="fa fa-eye-slash"></i> <?=$diller['adminpanel-form-text-1769']?>
                                                                </div>
                                                            <?php }?>
                                                            <img src="../images/product/<?=$popRow['gorsel']?>" class="img-fluid border " style="width: 135px; height: 135px;" >
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <?=$popRow['baslik']?>
                                                        </div>
                                                        <div class="text-center p-2">
                                                            <a class="btn btn-sm btn-primary btn-block  " target="_blank" href="pages.php?page=product_detail&productID=<?=$popRow['id']?>">
                                                                <i class="fa fa-eye"></i>  <?=$diller['adminpanel-form-text-942']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    <?php } ?>
                                    <?php if($populerUrunler->rowCount()<='0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class=" rounded bg-light border   p-3 w-100">
                                          <?=$diller['adminpanel-form-text-1751']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="col-md-12 ">
                                        <div class="bg-light border  p-3 w-100">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-939']?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Popüler Ürünler Tab SON !-->

                        <!-- İndirimli Ürünler Tab !-->
                        <div class="tab-pane p-3 " id="indirim" role="tabpanel" >
                            <div class="row  pl-2 pr-2" >

                                <?php if($temayar['secenekvitrin_indirimli_urunler'] == '1' ) {
                                    $indirimUrunleri = $db->prepare("select * from urun where indirim='1' and anasayfa='1' and durum='1' order by id desc limit $urunlimit ");
                                    $indirimUrunleri->execute();
                                    ?>
                                        <div class="col-md-12 ">
                                            <div class="bg-light border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div style="font-size: 18px ; font-weight: 600;">
                                                    <?=$diller['adminpanel-form-text-943']?> : <?=$urunlimit?>
                                                </div>
                                                <?=$diller['adminpanel-form-text-944']?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">
                                            <div class=" border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div class="in-header-page-main" >
                                                    <div class="in-header-page-text">
                                                        * <?=$diller['adminpanel-form-text-938']?>
                                                    </div>
                                                </div>
                                                <div class=" mb-2 pt-2 pb-2 pl-3 pr-3 alert-warning border border-warning text-dark rounded" style="font-size: 12px ;">
                                                    <?=$diller['adminpanel-form-text-1752']?>
                                                </div>
                                                <form method="post" action="post.php?process=showcase_post&status=tab_insert&tab_insert=discountproduct">
                                                    <div class="row">
                                                        <div class="col-md-8 form-group">
                                                            <select class="urunler_select form-control col-md-12" name="urun_id"   id="urun_id" style="width: 100%!important;" >
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php if($indirimUrunleri->rowCount()>'0'  ) {?>
                                        <?php foreach ($indirimUrunleri as $indRow) {?>
                                            <div class="col-md-3"  >
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                            <?php if($indRow['gorunmez'] == '1'  ) {?>
                                                                <div class="position-absolute w-100 " style="background: rgba(255,255,255,0.9); top:0; padding: 20px; font-size: 16px ; font-weight: 500 ; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,.1)">
                                                                    <i class="fa fa-eye-slash"></i> <?=$diller['adminpanel-form-text-1769']?>
                                                                </div>
                                                            <?php }?>
                                                            <img src="../images/product/<?=$indRow['gorsel']?>" class="img-fluid border " style="width: 135px; height: 135px;" >
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <?=$indRow['baslik']?>
                                                        </div>
                                                        <div class="text-center p-2">
                                                                <a class="btn btn-sm btn-outline-danger btn-block " href="post.php?process=showcase_post&status=tab_update&tab_update=discountproduct&product_id=<?=$indRow['id']?>">
                                                                    <i class="fa fa-times"></i>  <?=$diller['adminpanel-form-text-941']?>
                                                                </a>
                                                            <a class="btn btn-sm btn-primary btn-block  " target="_blank" href="pages.php?page=product_detail&productID=<?=$indRow['id']?>">
                                                                <i class="fa fa-eye"></i>  <?=$diller['adminpanel-form-text-942']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    <?php } ?>
                                    <?php if($indirimUrunleri->rowCount()<='0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class=" rounded bg-light border   p-3 w-100">
                                                <?=$diller['adminpanel-form-text-945']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="col-md-12 ">
                                        <div class="bg-light border  p-3 w-100">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-939']?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <!--  <========SON=========>>> İndirimli Ürünler Tab SON !-->

                        <!-- Fırsat Ürünler Tab !-->
                        <div class="tab-pane  p-3 " id="firsat" role="tabpanel" >
                            <div class="row  pl-2 pr-2" >

                                <?php if($temayar['secenekvitrin_firsat_urunleri'] == '1' ) {
                                    $firsatUrunler = $db->prepare("select * from urun where firsat='1' and anasayfa='1' and durum='1' order by id desc limit $urunlimit ");
                                    $firsatUrunler->execute();
                                    ?>
                                        <div class="col-md-12 ">
                                            <div class="bg-light border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div style="font-size: 18px ; font-weight: 600;">
                                                    <?=$diller['adminpanel-form-text-943']?> : <?=$urunlimit?>
                                                </div>
                                                <?=$diller['adminpanel-form-text-944']?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">
                                            <div class=" border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div class="in-header-page-main" >
                                                    <div class="in-header-page-text">
                                                        * <?=$diller['adminpanel-form-text-938']?>
                                                    </div>
                                                </div>
                                                <div class=" mb-2 pt-2 pb-2 pl-3 pr-3 alert-warning border border-warning text-dark rounded" style="font-size: 12px ;">
                                                    <?=$diller['adminpanel-form-text-1752']?>
                                                </div>
                                                <form method="post" action="post.php?process=showcase_post&status=tab_insert&tab_insert=firsat">
                                                    <div class="row">
                                                        <div class="col-md-8 form-group">
                                                            <select class="urunler_select form-control col-md-12" name="urun_id"   id="urun_id" style="width: 100%!important;" >
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php if($firsatUrunler->rowCount()>'0'  ) {?>
                                        <?php foreach ($firsatUrunler as $firRow) {?>
                                            <div class="col-md-3"  >
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                            <?php if($firRow['gorunmez'] == '1'  ) {?>
                                                                <div class="position-absolute w-100 " style="background: rgba(255,255,255,0.9); top:0; padding: 20px; font-size: 16px ; font-weight: 500 ; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,.1)">
                                                                    <i class="fa fa-eye-slash"></i> <?=$diller['adminpanel-form-text-1769']?>
                                                                </div>
                                                            <?php }?>
                                                            <img src="../images/product/<?=$firRow['gorsel']?>" class="img-fluid border " style="width: 135px; height: 135px;" >
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <?=$firRow['baslik']?>
                                                        </div>
                                                        <div class="text-center p-2">
                                                                <a class="btn btn-sm btn-outline-danger btn-block " href="post.php?process=showcase_post&status=tab_update&tab_update=firsat&product_id=<?=$firRow['id']?>">
                                                                    <i class="fa fa-times"></i>  <?=$diller['adminpanel-form-text-941']?>
                                                                </a>
                                                            <a class="btn btn-sm btn-primary btn-block  " target="_blank" href="pages.php?page=product_detail&productID=<?=$firRow['id']?>">
                                                                <i class="fa fa-eye"></i>  <?=$diller['adminpanel-form-text-942']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    <?php } ?>
                                    <?php if($firsatUrunler->rowCount()<='0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class=" rounded bg-light border   p-3 w-100">
                                                <?=$diller['adminpanel-form-text-945']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="col-md-12 ">
                                        <div class="bg-light border  p-3 w-100">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-939']?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Fırsat Ürünler Tab SON !-->

                        <!-- Editor Ürünler Tab !-->
                        <div class="tab-pane p-3 " id="editor" role="tabpanel" >
                            <div class="row  pl-2 pr-2" >

                                <?php if($temayar['secenekvitrin_editor_urunleri'] == '1' ) {
                                    $editorUrun = $db->prepare("select * from urun where editor_secim='1' and anasayfa='1' and durum='1' order by id desc limit $urunlimit ");
                                    $editorUrun->execute();
                                    ?>
                                        <div class="col-md-12 ">
                                            <div class="bg-light border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div style="font-size: 18px ; font-weight: 600;">
                                                    <?=$diller['adminpanel-form-text-943']?> : <?=$urunlimit?>
                                                </div>
                                                <?=$diller['adminpanel-form-text-944']?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">
                                            <div class=" border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div class="in-header-page-main" >
                                                    <div class="in-header-page-text">
                                                        * <?=$diller['adminpanel-form-text-938']?>
                                                    </div>
                                                </div>
                                                <div class=" mb-2 pt-2 pb-2 pl-3 pr-3 alert-warning border border-warning text-dark rounded" style="font-size: 12px ;">
                                                    <?=$diller['adminpanel-form-text-1752']?>
                                                </div>
                                                <form method="post" action="post.php?process=showcase_post&status=tab_insert&tab_insert=editor">
                                                    <div class="row">
                                                        <div class="col-md-8 form-group">
                                                            <select class="urunler_select form-control col-md-12" name="urun_id"   id="urun_id" style="width: 100%!important;" >
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php if($editorUrun->rowCount()>'0'  ) {?>
                                        <?php foreach ($editorUrun as $edtRow) {?>
                                            <div class="col-md-3"  >
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                            <?php if($edtRow['gorunmez'] == '1'  ) {?>
                                                                <div class="position-absolute w-100 " style="background: rgba(255,255,255,0.9); top:0; padding: 20px; font-size: 16px ; font-weight: 500 ; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,.1)">
                                                                    <i class="fa fa-eye-slash"></i> <?=$diller['adminpanel-form-text-1769']?>
                                                                </div>
                                                            <?php }?>
                                                            <img src="../images/product/<?=$edtRow['gorsel']?>" class="img-fluid border " style="width: 135px; height: 135px;" >
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <?=$edtRow['baslik']?>
                                                        </div>
                                                        <div class="text-center p-2">
                                                                <a class="btn btn-sm btn-outline-danger btn-block " href="post.php?process=showcase_post&status=tab_update&tab_update=editor&product_id=<?=$edtRow['id']?>">
                                                                    <i class="fa fa-times"></i>  <?=$diller['adminpanel-form-text-941']?>
                                                                </a>
                                                            <a class="btn btn-sm btn-primary btn-block  " target="_blank" href="pages.php?page=product_detail&productID=<?=$edtRow['id']?>">
                                                                <i class="fa fa-eye"></i>  <?=$diller['adminpanel-form-text-942']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    <?php } ?>
                                    <?php if($editorUrun->rowCount()<='0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class=" rounded bg-light border   p-3 w-100">
                                                <?=$diller['adminpanel-form-text-945']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="col-md-12 ">
                                        <div class="bg-light border  p-3 w-100">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-939']?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Editor Ürünler Tab SON !-->

                        <!-- Bedava Kargo Ürünler Tab !-->
                        <div class="tab-pane p-3 " id="freeCargo" role="tabpanel" >
                            <div class="row  pl-2 pr-2" >

                                <?php if($temayar['secenekvitrin_bedavakargo_urunleri'] == '1' ) {
                                    $kargoUcretsizUrun = $db->prepare("select * from urun where kargo='0' and anasayfa='1' and durum='1' order by id desc limit $urunlimit ");
                                    $kargoUcretsizUrun->execute();
                                    ?>
                                    <?php if($kargoUcretsizUrun->rowCount()>'0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class="bg-light border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div style="font-size: 18px ; font-weight: 600;">
                                                    <?=$diller['adminpanel-form-text-943']?> : <?=$urunlimit?>
                                                </div>
                                                <?=$diller['adminpanel-form-text-944']?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class=" w-100 border p-3 mb-3 rounded alert alert-dismissible alert-warning border-warning text-dark">
                                                <div style="font-size: 12px ;">
                                                    <?=$diller['adminpanel-form-text-947']?>
                                                </div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>

                                        <?php foreach ($kargoUcretsizUrun as $kargosuzRow) {?>
                                            <div class="col-md-3"  >
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                            <?php if($kargosuzRow['gorunmez'] == '1'  ) {?>
                                                                <div class="position-absolute w-100 " style="background: rgba(255,255,255,0.9); top:0; padding: 20px; font-size: 16px ; font-weight: 500 ; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,.1)">
                                                                    <i class="fa fa-eye-slash"></i> <?=$diller['adminpanel-form-text-1769']?>
                                                                </div>
                                                            <?php }?>
                                                            <img src="../images/product/<?=$kargosuzRow['gorsel']?>" class="img-fluid border " style="width: 135px; height: 135px;" >
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <?=$kargosuzRow['baslik']?>
                                                        </div>
                                                        <div class="text-center p-2">
                                                            <a class="btn btn-sm btn-primary btn-block  " target="_blank" href="pages.php?page=product_detail&productID=<?=$kargosuzRow['id']?>">
                                                                <i class="fa fa-eye"></i>  <?=$diller['adminpanel-form-text-942']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    <?php } ?>
                                    <?php if($kargoUcretsizUrun->rowCount()<='0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class=" rounded bg-light border   p-3 w-100">
                                                <?=$diller['adminpanel-form-text-1753']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="col-md-12 ">
                                        <div class="bg-light border  p-3 w-100">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-939']?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Bedava Kargo Ürünler Tab SON !-->

                        <!-- Hızlı Kargo Ürünler Tab !-->
                        <div class="tab-pane  p-3 " id="fastCargo" role="tabpanel" >
                            <div class="row  pl-2 pr-2" >

                                <?php if($temayar['secenekvitrin_hizlikargo_urunleri'] == '1' ) {
                                    $fastKargo = $db->prepare("select * from urun where hizli_kargo='1' and anasayfa='1' and durum='1' order by id desc limit $urunlimit ");
                                    $fastKargo->execute();
                                    ?>
                                        <div class="col-md-12 ">
                                            <div class="bg-light border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div style="font-size: 18px ; font-weight: 600;">
                                                    <?=$diller['adminpanel-form-text-943']?> : <?=$urunlimit?>
                                                </div>
                                                <?=$diller['adminpanel-form-text-944']?>
                                            </div>
                                        </div>
                                        <div class="col-md-12 ">
                                            <div class=" border rounded p-3 mb-3" style="font-size: 15px ;">
                                                <div class="in-header-page-main" >
                                                    <div class="in-header-page-text">
                                                        * <?=$diller['adminpanel-form-text-938']?>
                                                    </div>
                                                </div>
                                                <div class=" mb-2 pt-2 pb-2 pl-3 pr-3 alert-warning border border-warning text-dark rounded" style="font-size: 12px ;">
                                                    <?=$diller['adminpanel-form-text-1752']?>
                                                </div>
                                                <form method="post" action="post.php?process=showcase_post&status=tab_insert&tab_insert=fastcargo">
                                                    <div class="row">
                                                        <div class="col-md-8 form-group">
                                                            <select class="urunler_select form-control col-md-12" name="urun_id"   id="urun_id" style="width: 100%!important;" >
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-group">
                                                            <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php if($fastKargo->rowCount()>'0'  ) {?>

                                        <?php foreach ($fastKargo as $fastCRow) {?>
                                            <div class="col-md-3"  >
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                            <?php if($fastCRow['gorunmez'] == '1'  ) {?>
                                                                <div class="position-absolute w-100 " style="background: rgba(255,255,255,0.9); top:0; padding: 20px; font-size: 16px ; font-weight: 500 ; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,.1)">
                                                                    <i class="fa fa-eye-slash"></i> <?=$diller['adminpanel-form-text-1769']?>
                                                                </div>
                                                            <?php }?>
                                                            <img src="../images/product/<?=$fastCRow['gorsel']?>" class="img-fluid border " style="width: 135px; height: 135px;" >
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <?=$fastCRow['baslik']?>
                                                        </div>
                                                        <div class="text-center p-2">
                                                                <a class="btn btn-sm btn-outline-danger btn-block " href="post.php?process=showcase_post&status=tab_update&tab_update=fastcargo&product_id=<?=$fastCRow['id']?>">
                                                                    <i class="fa fa-times"></i>  <?=$diller['adminpanel-form-text-941']?>
                                                                </a>
                                                            <a class="btn btn-sm btn-primary btn-block  " target="_blank" href="pages.php?page=product_detail&productID=<?=$fastCRow['id']?>">
                                                                <i class="fa fa-eye"></i>  <?=$diller['adminpanel-form-text-942']?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    <?php } ?>
                                    <?php if($fastKargo->rowCount()<='0'  ) {?>
                                        <div class="col-md-12 ">
                                            <div class=" rounded bg-light border   p-3 w-100">
                                                <?=$diller['adminpanel-form-text-945']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <div class="col-md-12 ">
                                        <div class="bg-light border  p-3 w-100">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-939']?>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Hızlı Kargo Ürünler Tab SON !-->

                    </div>
                    <!--  <========SON=========>>> Tab Contents SON !-->


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
    $('[data-toggle="tab"]').click(function(e) {

        var $this = $(this),

            loadurl = $this.attr('href'),
            targ = $this.attr('data-toggle');


        $.get(loadurl, function(data) {
            $(targ).html(data);
        });

        $this.tab('show');

        return false;

    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.urunler_select').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-880']?>',
            ajax: {
                url: 'masterpiece.php?page=tabproduct_select',
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
    <?php if($_SESSION['tab_select'] == 'indirim'  ) {?>
    $('#indirim-tab').addClass('active');
    $('#indirim').addClass('active');

    $('#yeni-tab').removeClass('active');
    $('#yeni').removeClass('active');
    <?php
    unset($_SESSION['tab_select']);
    ?>
    <?php }?>
    <?php if($_SESSION['tab_select'] == 'firsat'  ) {?>
    $('#firsat-tab').addClass('active');
    $('#firsat').addClass('active');

    $('#yeni-tab').removeClass('active');
    $('#yeni').removeClass('active');
    <?php
    unset($_SESSION['tab_select']);
    ?>
    <?php }?>
    <?php if($_SESSION['tab_select'] == 'editor'  ) {?>
    $('#editor-tab').addClass('active');
    $('#editor').addClass('active');

    $('#yeni-tab').removeClass('active');
    $('#yeni').removeClass('active');
    <?php
    unset($_SESSION['tab_select']);
    ?>
    <?php }?>
    <?php if($_SESSION['tab_select'] == 'fastCargo'  ) {?>
    $('#fastCargo-tab').addClass('active');
    $('#fastCargo').addClass('active');

    $('#yeni-tab').removeClass('active');
    $('#yeni').removeClass('active');
    <?php
    unset($_SESSION['tab_select']);
    ?>
    <?php }?>
</script>