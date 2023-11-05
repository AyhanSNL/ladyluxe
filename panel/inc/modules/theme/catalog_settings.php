<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'catalog';
?>
<title><?=$diller['adminpanel-menu-text-103']?> - <?=$panelayar['baslik']?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box  bg-white card mb-0 pl-3" >
                    <div class="row align-items-center d-flex justify-content-between" >
                        <div class="col-md-12" >
                            <h4 class="page-title mb-3" style="font-size: 20px ;"><?=$diller['adminpanel-menu-text-103']?></h4>
                        </div>
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-98']?></a>
                                <a href="pages.php?page=theme_catalog_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-103']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['tema_ayarlar'] == '1' ) {?>
            <div class="row">
                <!-- Contents !-->
                <div class="col-md-9">


                     <div class="row">
                         <a class="col-md-3 text-dark mb-4" href="pages.php?page=theme_product_box">
                             <div class="card rounded-0 shadow-none  btn-light  mb-1"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class=" shadow text-white bg-warning border border-white d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:28px">
                                         1
                                     </div>
                                     <h6><?=$diller['adminpanel-text-288']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-289']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark mb-4" href="pages.php?page=theme_product_detail">
                             <div class="card rounded-0  shadow-none btn-light mb-1" style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-white bg-pink border border-white d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                         2
                                     </div>
                                     <h6><?=$diller['adminpanel-text-290']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-291']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark mb-4" href="pages.php?page=theme_cat_detail">
                             <div class="card rounded-0  shadow-none btn-light mb-1"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-white bg-info border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                         3
                                     </div>
                                     <h6><?=$diller['adminpanel-text-292']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-293']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark" href="pages.php?page=theme_brand">
                             <div class="card rounded-0  shadow-none btn-light mb-1"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-white bg-success border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                         4
                                     </div>
                                     <h6><?=$diller['adminpanel-text-294']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-295']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark" href="pages.php?page=theme_tbox">
                             <div class="card rounded-0  shadow-none btn-light mb-1"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-white bg-primary border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                         5
                                     </div>
                                     <h6><?=$diller['adminpanel-text-296']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-297']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark" href="pages.php?page=theme_showcase_tab">
                             <div class="card rounded-0  shadow-none btn-light  mb-4"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-white bg-dark border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                         6
                                     </div>
                                     <h6><?=$diller['adminpanel-text-298']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-299']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark" href="pages.php?page=theme_showcase_bannerproduct">
                             <div class="card rounded-0  shadow-none btn-light mb-4"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-white bg-secondary border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                         7
                                     </div>
                                     <h6><?=$diller['adminpanel-text-300']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-301']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark" href="pages.php?page=theme_showcase_banner1">
                             <div class="card rounded-0  shadow-none btn-light  mb-4"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-white  border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px; background-color: #DA7A72">
                                         8
                                     </div>
                                     <h6><?=$diller['adminpanel-text-302']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-303']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark" href="pages.php?page=theme_showcase_banner2">
                             <div class="card rounded-0  shadow-none btn-light  mb-4"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-dark bg-white border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                         9
                                     </div>
                                     <h6><?=$diller['adminpanel-text-304']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-305']?></span>
                                 </div>
                             </div>
                         </a>
                         <a class="col-md-3 text-dark" href="pages.php?page=theme_showcase_countdown">
                             <div class="card rounded-0  shadow-none btn-light  mb-4"  style="border:1px solid #EBEBEB">
                                 <div class="card-body">
                                     <div class="shadow text-white  border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px; background-color: #A770AA">
                                         10
                                     </div>
                                     <h6><?=$diller['adminpanel-text-306']?></h6>
                                     <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-307']?></span>
                                 </div>
                             </div>
                         </a>
                     </div>


                </div>
                <!--  <========SON=========>>> Contents SON !-->
                <?php include 'inc/modules/_helper/theme_all_links.php'; ?>

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
