<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'header';
?>
<title><?=$diller['adminpanel-menu-text-99']?> - <?=$panelayar['baslik']?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="page-title-box" >
                    <div class="row align-items-center" >
                        <div class="col-md-8" >
                            <h4 class="page-title m-0" ><?=$diller['adminpanel-menu-text-99']?></h4>
                            <div class="page-title-nav">
                                <a href="javascript:Void(0)"><?=$diller['adminpanel-menu-text-151']?></a>
                                <i class="fa fa-angle-right"></i>
                                <a href="javascript:Void(0)"><?=$diller['adminpanel-menu-text-98']?></a>
                                <i class="fa fa-angle-right"></i>
                                <a href="pages.php?page=theme_header_settings"><?=$diller['adminpanel-menu-text-99']?></a>
                            </div>
                            <div style="width: 5px; height: 20px" class=" d-sm-inline-block block d-md-none"></div>
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
                    <div class="card p-4 mb-2 ">
                        <div class="w-100 d-flex align-items-center justify-content-start flex-wrap ">
                            <div class="d-flex align-items-center rounded-circle justify-content-center mr-4 bg-light" style="width: 56px; height: 56px; font-size: 22px ; ">
                            <i class="fas fa-feather-alt"></i>
                            </div>
                            <div >
                            <h5> <?=$diller['adminpanel-menu-text-99']?></h5>
                            <span style="color: #BBBBBB !important;"><?=$diller['adminpanel-text-270']?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 mt-4 ">
                        <a class="col-md-4 text-dark" href="pages.php?page=theme_header_settings_main">
                            <div class="card rounded-0 shadow-none  btn-light  mb-1"  style="border:1px solid #EBEBEB">
                                <div class="card-body">
                                    <div class=" shadow text-white bg-warning border border-white d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:28px">
                                        <i class="fas fa-brush"></i>
                                    </div>
                                    <h6><?=$diller['adminpanel-text-271']?></h6>
                                    <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-276']?></span>
                                </div>
                            </div>
                        </a>
                        <a class="col-md-4 text-dark" href="pages.php?page=theme_header_settings_dropdown">
                            <div class="card rounded-0  shadow-none btn-light mb-1" style="border:1px solid #EBEBEB">
                                <div class="card-body">
                                    <div class="shadow text-white bg-pink border border-white d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                        <i class="fas fa-sort-amount-down"></i>
                                    </div>
                                    <h6><?=$diller['adminpanel-text-272']?></h6>
                                    <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-273']?></span>
                                </div>
                            </div>
                        </a>
                        <a class="col-md-4 text-dark" href="pages.php?page=theme_header_settings_top">
                            <div class="card rounded-0  shadow-none btn-light mb-1"  style="border:1px solid #EBEBEB">
                                <div class="card-body">
                                    <div class="shadow text-white bg-info border border-white  d-flex align-items-center justify-content-center mb-4 " style="width: 65px; height: 65px; font-size:32px">
                                        <i class="fas fa-sliders-h"></i>
                                    </div>
                                    <h6><?=$diller['adminpanel-text-274']?></h6>
                                    <span style="font-size: 13px ; color: #666 !important;"><?=$diller['adminpanel-text-275']?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php if($yetki['modul'] =='1' && $yetki['modul_header_footer'] == '1' ) {?>
                        <div class="card p-4">

                            <div class="in-header-page-main">
                                <div class="in-header-page-text">
                                    <i class="fa fa-arrow-down"></i> <?=$diller['adminpanel-text-277']?>
                                </div>
                            </div>
                            <div class="row mt-2 mb-4">
                                <a class="col-md-4 text-dark" href="pages.php?page=tophtml_area">
                                    <div class="card mb-0 rounded-0 bg-light " style="border:1px solid #EBEBEB">
                                        <div class="card-body">
                                            <h6><?=$diller['adminpanel-menu-text-44']?></h6>
                                            <span style="font-size: 12px ; color: #666 !important;"><?=$diller['adminpanel-text-278']?></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="col-md-4 text-dark" href="pages.php?page=header_links">
                                    <div class="card mb-0 rounded-0 bg-light " style="border:1px solid #EBEBEB">
                                        <div class="card-body">
                                            <h6><?=$diller['adminpanel-menu-text-46']?></h6>
                                            <span style="font-size: 12px ; color: #666 !important;"><?=$diller['adminpanel-text-279']?></span>
                                        </div>
                                    </div>
                                </a>
                                <a class="col-md-4 text-dark" href="pages.php?page=topheader_links">
                                    <div class="card mb-0 rounded-0 bg-light " style="border:1px solid #EBEBEB">
                                        <div class="card-body">
                                            <h6><?=$diller['adminpanel-menu-text-45']?></h6>
                                            <span style="font-size: 12px ; color: #666 !important;"><?=$diller['adminpanel-text-280']?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <!--  <========SON=========>>> Contents SON !-->

                <div class="col-md-3  ">
                    <a class="btn btn-pink mo-mb-2 btn-block  mb-3 pt-3 pb-3  d-flex align-items-center justify-content-between " data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        <?=$diller['adminpanel-text-284']?> <i class="fa fa-plus"></i>
                    </a>
                    <div class="collapse mb-4 " id="collapseExample" style="max-height: 485px; overflow-y: scroll">
                        <?php if($yetki['tema_ayarlar'] == '1') {?>
                            <a href="pages.php?page=theme_header_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'header'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-99']?></a>
                            <a href="pages.php?page=theme_footer_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'footer'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-101']?></a>
                            <a href="pages.php?page=theme_catalog_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'catalog'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-103']?></a>
                            <a href="pages.php?page=theme_category_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'category'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-105']?></a>
                            <a href="pages.php?page=theme_users_settings" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'users'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-107']?></a>
                            <a href="pages.php?page=fonts" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'fonts'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-109']?></a>
                            <a href="pages.php?page=theme_banners" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'banners'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-111']?></a>
                            <a href="pages.php?page=theme_mail" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'mail'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-113']?></a>
                            <a href="pages.php?page=theme_cart" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'cart'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-115']?></a>
                            <a href="pages.php?page=theme_brand" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'brand'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-117']?></a>
                            <a href="pages.php?page=theme_compare" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'compare'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-119']?></a>
                            <a href="pages.php?page=theme_contact" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'contact'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-121']?></a>
                            <a href="pages.php?page=preloader" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'loader'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-123']?></a>
                            <a href="pages.php?page=theme_slider" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'slider'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-125']?></a>
                            <a href="pages.php?page=theme_story" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'story'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-127']?></a>
                            <a href="pages.php?page=theme_modal" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'modal'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-129']?></a>
                            <a href="pages.php?page=theme_404" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == '404'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-131']?></a>
                            <a href="pages.php?page=theme_banks" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'bank'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-133']?></a>
                            <a href="pages.php?page=theme_pricing" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'pricing'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-135']?></a>
                            <a href="pages.php?page=theme_services" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'services'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-137']?></a>
                            <a href="pages.php?page=theme_blogs" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'blogs'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-139']?></a>
                            <a href="pages.php?page=theme_enews" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'enews'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-141']?></a>
                            <a href="pages.php?page=theme_client_comments" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'clients'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-143']?></a>
                            <a href="pages.php?page=theme_client_counter" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'counter'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-145']?></a>
                            <a href="pages.php?page=theme_faq" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'faq'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-147']?></a>
                            <a href="pages.php?page=theme_faq" class="btn  w-100 mb-2 text-left p-3   <?php if($currentMenu == 'faq'  ) { ?>font-weight-bold btn-primary<?php }else{?>btn-light card<?php }?>"><?=$diller['adminpanel-menu-text-147']?></a>
                        <?php }?>
                    </div>

                    <div class="card p-4 bg-white font-16 mb-2 ">
                        <div class="w-100 text-center">
                            <img src="assets/images/icon/design-ill.png" >
                        </div>
                        <h5><?=$diller['adminpanel-text-281']?></h5>
                        <?=$diller['adminpanel-text-282']?>
                        <div style="font-size: 11px ; color: #999; margin-top: 10px;"><?=$diller['adminpanel-text-283']?></div>
                    </div>
                </div>
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
