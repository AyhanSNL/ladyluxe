<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'catdetail';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from urun_cat_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);



?>
<title><?=$diller['adminpanel-menu-text-105']?> - <?=$panelayar['baslik']?></title>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">


        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box  bg-white card mb-0 pl-3" >
                    <div class="row align-items-center d-flex justify-content-between" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-98']?></a>
                                <a href="pages.php?page=theme_catalog_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-103']?></a>
                                <a href="pages.php?page=theme_cat_detail"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-105']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['tema_ayarlar'] == '1' ) {?>
            <div class="row">


                <!-- Nav Menu !-->
                <div class="col-md-3 d-none d-md-inline-block" id="sidebarWrap" style="overflow: hidden; position: relative">
                    <div id="sidebar" class="mr-3">
                        <div class="btn-group w-100 d-flex flex-wrap" role="group">
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?> " type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-140']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'navAcc'  ) { ?>active<?php }?> " type="button" data-toggle="collapse" data-target="#navAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-341']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'sortAcc'  ) { ?>active<?php }?> " type="button" data-toggle="collapse" data-target="#sortAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-328']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'filtreAcc'  ) { ?>active<?php }?> " type="button" data-toggle="collapse" data-target="#filtreAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-340']?>
                            </button>
                        </div>

                    </div>
                </div>
                <!--  <========SON=========>>> Nav Menu SON !-->

                <!-- Mobile !-->
                <div class="col-md-3 d-md-none d-sm-inline-block ">
                    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#navigasyon" aria-expanded="false" aria-controls="collapseExample">
                        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
                    </a>
                    <div class="collapse mb-3" id="navigasyon">
                        <div class="btn-group w-100 d-flex flex-wrap" role="group">
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?> " type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-140']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'navAcc'  ) { ?>active<?php }?> " type="button" data-toggle="collapse" data-target="#navAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-341']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'sortAcc'  ) { ?>active<?php }?> " type="button" data-toggle="collapse" data-target="#sortAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-328']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'filtreAcc'  ) { ?>active<?php }?> " type="button" data-toggle="collapse" data-target="#filtreAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-340']?>
                            </button>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Mobile SON !-->

                <!-- Contents !-->
                <div class="col-md-6">

                    <div id="accordion" class="accordion">
                        <!-- Düzen Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-140']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=category_main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="detay_arkaplan"><?=$diller['adminpanel-form-text-295']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['detay_arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="detay_arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="detay_font" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="detay_font" class="form-control" id="detay_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['detay_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="urun_liste_limit" class="w-100">* <?=$diller['adminpanel-form-text-315']?></label>
                                                    <input type="number" name="urun_liste_limit" value="<?=$detay['urun_liste_limit']?>" id="urun_liste_limit" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="sayfalama_hiza" class="w-100">* <?=$diller['adminpanel-form-text-316']?></label>
                                                    <select name="sayfalama_hiza" class="form-control" id="sayfalama_hiza" required>
                                                        <option value="0" <?php if($detay['sayfalama_hiza'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-208']?></option>
                                                        <option value="1" <?php if($detay['sayfalama_hiza'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-209']?></option>
                                                        <option value="2" <?php if($detay['sayfalama_hiza'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-210']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="urun_box_gorunum_tur" class="w-100">* <?=$diller['adminpanel-form-text-335']?></label>
                                                    <select name="urun_box_gorunum_tur" class="form-control" id="urun_box_gorunum_tur" required>
                                                        <option value="1" <?php if($detay['urun_box_gorunum_tur'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-337']?></option>
                                                        <option value="2" <?php if($detay['urun_box_gorunum_tur'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-338']?></option>
                                                        <option value="3" <?php if($detay['urun_box_gorunum_tur'] == '3'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-336']?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-319']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="checkbox_border">* <?=$diller['adminpanel-form-text-317']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['checkbox_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="checkbox_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="checkbox_bg">* <?=$diller['adminpanel-form-text-318']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['checkbox_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="checkbox_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-320']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label  for="baslik_yer" class="w-100">* <?=$diller['adminpanel-form-text-321']?></label>
                                                    <select name="baslik_yer" class="form-control" id="baslik_yer" required>
                                                        <option value="1" <?php if($detay['baslik_yer'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-326']?></option>
                                                        <option value="2" <?php if($detay['baslik_yer'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-327']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="baslik_color">* <?=$diller['adminpanel-form-text-322']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['baslik_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="baslik_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="aciklama_durum" class="w-100" >* <?=$diller['adminpanel-form-text-323']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="aciklama_durum" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="aciklama_durum" name="aciklama_durum" value="1"  <?php if($detay['aciklama_durum'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="aciklama_durum"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="spot_color">* <?=$diller['adminpanel-form-text-324']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['spot_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="spot_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cat_href_color">* <?=$diller['adminpanel-form-text-325']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['cat_href_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="cat_href_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group mb-0">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Düzen Ayarları  SON !-->

                        <!-- Sol Nav Ayar !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#navAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-341']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="navAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=category_nav" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="sol_nav_tip"><?=$diller['adminpanel-form-text-360']?></label>
                                                    <select name="sol_nav_tip" class="form-control" id="sol_nav_tip" required>
                                                        <option value="1" <?php if($detay['sol_nav_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-361']?></option>
                                                        <option value="2" <?php if($detay['sol_nav_tip'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-362']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sol_nav_bg"><?=$diller['adminpanel-form-text-363']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['sol_nav_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sol_nav_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sol_nav_border"><?=$diller['adminpanel-form-text-364']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['sol_nav_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sol_nav_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sol_nav_head_color"><?=$diller['adminpanel-form-text-365']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['sol_nav_head_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sol_nav_head_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sol_nav_text_color"><?=$diller['adminpanel-form-text-366']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['sol_nav_text_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sol_nav_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sol_nav_scroll"><?=$diller['adminpanel-form-text-368']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['sol_nav_scroll']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sol_nav_scroll"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sol_nav_scroll_alt"><?=$diller['adminpanel-form-text-369']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['sol_nav_scroll_alt']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sol_nav_scroll_alt"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sol_nav_ayirac"><?=$diller['adminpanel-form-text-367']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['sol_nav_ayirac']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sol_nav_ayirac"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-342']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="altkat_padding"><?=$diller['adminpanel-form-text-370']?></label>
                                                    <input type="text" name="altkat_padding"  value="<?=$detay['altkat_padding']?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="altkat_box_bg"><?=$diller['adminpanel-form-text-372']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['altkat_box_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="altkat_box_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="altkat_box_bg_hover"><?=$diller['adminpanel-form-text-373']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['altkat_box_bg_hover']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="altkat_box_bg_hover"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="altkat_box_text"><?=$diller['adminpanel-form-text-374']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['altkat_box_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="altkat_box_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="altkat_box_text_hover"><?=$diller['adminpanel-form-text-375']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['altkat_box_text_hover']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="altkat_box_text_hover"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="altkat_box_border"><?=$diller['adminpanel-form-text-376']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['altkat_box_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="altkat_box_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="altkat_openbox_border"><?=$diller['adminpanel-form-text-377']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['altkat_openbox_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="altkat_openbox_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="altkat_openbox_shadow" class="w-100" ><?=$diller['adminpanel-form-text-371']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="altkat_openbox_shadow" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="altkat_openbox_shadow" name="altkat_openbox_shadow" value="1"  <?php if($detay['altkat_openbox_shadow'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="altkat_openbox_shadow"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 form-group mb-0">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Sol Nav Ayar SON !-->

                        <!-- Sıralama Ayar !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#sortAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-328']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="sortAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=category_sort_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label  for="siralama_secim" class="w-100">* <?=$diller['adminpanel-form-text-329']?></label>
                                                    <select name="siralama_secim" class="form-control" id="siralama_secim" required>
                                                        <option <?php if($detay['sirala_harf'] == '0' ) { ?>disabled<?php }?> value="1" <?php if($detay['siralama_secim'] == '1'  ) { ?>selected<?php }?>><?php if($detay['sirala_harf'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-330']?></option>
                                                        <option <?php if($detay['sirala_artan'] == '0' ) { ?>disabled<?php }?> value="2" <?php if($detay['siralama_secim'] == '2'  ) { ?>selected<?php }?>><?php if($detay['sirala_artan'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-331']?></option>
                                                        <option <?php if($detay['sirala_azalan'] == '0' ) { ?>disabled<?php }?> value="3" <?php if($detay['siralama_secim'] == '3'  ) { ?>selected<?php }?>><?php if($detay['sirala_azalan'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-332']?></option>
                                                        <option <?php if($detay['sirala_yeni'] == '0' ) { ?>disabled<?php }?> value="4" <?php if($detay['siralama_secim'] == '4'  ) { ?>selected<?php }?>><?php if($detay['sirala_yeni'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-333']?></option>
                                                        <option <?php if($detay['sirala_populer'] == '0' ) { ?>disabled<?php }?> value="5" <?php if($detay['siralama_secim'] == '5'  ) { ?>selected<?php }?>><?php if($detay['sirala_populer'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-334']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sirala_harf" class="w-100" ><?=$diller['adminpanel-form-text-330']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sirala_harf" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sirala_harf" name="sirala_harf" value="1"  <?php if($detay['sirala_harf'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sirala_harf"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sirala_artan" class="w-100" ><?=$diller['adminpanel-form-text-331']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sirala_artan" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sirala_artan" name="sirala_artan" value="1"  <?php if($detay['sirala_artan'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sirala_artan"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sirala_azalan" class="w-100" ><?=$diller['adminpanel-form-text-332']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sirala_azalan" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sirala_azalan" name="sirala_azalan" value="1"  <?php if($detay['sirala_azalan'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sirala_azalan"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sirala_yeni" class="w-100" ><?=$diller['adminpanel-form-text-333']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sirala_yeni" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sirala_yeni" name="sirala_yeni" value="1"  <?php if($detay['sirala_yeni'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sirala_yeni"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sirala_populer" class="w-100" ><?=$diller['adminpanel-form-text-334']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sirala_populer" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sirala_populer" name="sirala_populer" value="1"  <?php if($detay['sirala_populer'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sirala_populer"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group mb-0">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Sıralama Ayar SON !-->

                        <!-- Filtre Ayar !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#filtreAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-340']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="filtreAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=category_filtre" method="post">
                                            <div class="row">

                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="filtre_bedavakargo" class="w-100" ><?=$diller['adminpanel-form-text-343']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="filtre_bedavakargo" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="filtre_bedavakargo" name="filtre_bedavakargo" value="1"  <?php if($detay['filtre_bedavakargo'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="filtre_bedavakargo"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="filtre_yeniler" class="w-100" ><?=$diller['adminpanel-form-text-344']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="filtre_yeniler" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="filtre_yeniler" name="filtre_yeniler" value="1"  <?php if($detay['filtre_yeniler'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="filtre_yeniler"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="filtre_firsatlar" class="w-100" ><?=$diller['adminpanel-form-text-345']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="filtre_firsatlar" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="filtre_firsatlar" name="filtre_firsatlar" value="1"  <?php if($detay['filtre_firsatlar'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="filtre_firsatlar"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="filtre_indirimler" class="w-100" ><?=$diller['adminpanel-form-text-346']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="filtre_indirimler" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="filtre_indirimler" name="filtre_indirimler" value="1"  <?php if($detay['filtre_indirimler'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="filtre_indirimler"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="filtre_taksitler" class="w-100" ><?=$diller['adminpanel-form-text-347']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="filtre_taksitler" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="filtre_taksitler" name="filtre_taksitler" value="1"  <?php if($detay['filtre_taksitler'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="filtre_taksitler"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="filtre_hizlikargo" class="w-100" ><?=$diller['adminpanel-form-text-348']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="filtre_hizlikargo" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="filtre_hizlikargo" name="filtre_hizlikargo" value="1"  <?php if($detay['filtre_hizlikargo'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="filtre_hizlikargo"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="filtre_stok" class="w-100" ><?=$diller['adminpanel-form-text-349']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="filtre_stok" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="filtre_stok" name="filtre_stok" value="1"  <?php if($detay['filtre_stok'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="filtre_stok"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="filtre_editor" class="w-100" ><?=$diller['adminpanel-form-text-350']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="filtre_editor" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="filtre_editor" name="filtre_editor" value="1"  <?php if($detay['filtre_editor'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="filtre_editor"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="secili_filtre_button"><?=$diller['adminpanel-form-text-352']?></label>
                                                    <select name="secili_filtre_button" class="form-control selet2" style="width: 100%; " id="secili_filtre_button" required>
                                                        <option value="button-black-white" <?php if($detay['secili_filtre_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['secili_filtre_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['secili_filtre_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['secili_filtre_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['secili_filtre_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['secili_filtre_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['secili_filtre_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['secili_filtre_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['secili_filtre_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['secili_filtre_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['secili_filtre_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['secili_filtre_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['secili_filtre_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['secili_filtre_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['secili_filtre_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['secili_filtre_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['secili_filtre_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['secili_filtre_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['secili_filtre_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['secili_filtre_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['secili_filtre_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['secili_filtre_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['secili_filtre_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="tumfiltre_kaldir_button"><?=$diller['adminpanel-form-text-351']?></label>
                                                    <select name="tumfiltre_kaldir_button" class="form-control selet2" style="width: 100%; " id="tumfiltre_kaldir_button" required>
                                                        <option value="button-black-white" <?php if($detay['tumfiltre_kaldir_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['tumfiltre_kaldir_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['tumfiltre_kaldir_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['tumfiltre_kaldir_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['tumfiltre_kaldir_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['tumfiltre_kaldir_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['tumfiltre_kaldir_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['tumfiltre_kaldir_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['tumfiltre_kaldir_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['tumfiltre_kaldir_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['tumfiltre_kaldir_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['tumfiltre_kaldir_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['tumfiltre_kaldir_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['tumfiltre_kaldir_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-353']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="fiyat_range_bg"><?=$diller['adminpanel-form-text-354']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['fiyat_range_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="fiyat_range_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fiyat_range_ball"><?=$diller['adminpanel-form-text-355']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['fiyat_range_ball']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="fiyat_range_ball"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fiyat_range_price_bg"><?=$diller['adminpanel-form-text-356']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['fiyat_range_price_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="fiyat_range_price_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fiyat_range_price_text"><?=$diller['adminpanel-form-text-357']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['fiyat_range_price_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="fiyat_range_price_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fiyat_range_price_border"><?=$diller['adminpanel-form-text-358']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['fiyat_range_price_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="fiyat_range_price_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fiyat_range_button"><?=$diller['adminpanel-form-text-359']?></label>
                                                    <select name="fiyat_range_button" class="form-control" id="fiyat_range_button" required>
                                                        <option value="button-black-white" <?php if($detay['fiyat_range_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['fiyat_range_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['fiyat_range_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['fiyat_range_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['fiyat_range_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['fiyat_range_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['fiyat_range_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['fiyat_range_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['fiyat_range_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['fiyat_range_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['fiyat_range_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['fiyat_range_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['fiyat_range_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['fiyat_range_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['fiyat_range_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['fiyat_range_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['fiyat_range_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['fiyat_range_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['fiyat_range_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['fiyat_range_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['fiyat_range_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['fiyat_range_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['fiyat_range_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group mb-0">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Filtre Ayar SON !-->


                    </div>

                </div>
                <!--  <========SON=========>>> Contents SON !-->

                
                <?php include 'inc/modules/_helper/theme_catalog_rightbar.php'; ?>


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
<script id="rendered-js" >
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
        $('#sortAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#sortAcc').offset().top - 80 },
                1500);
        });
        $('#filtreAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#filtreAcc').offset().top - 80 },
                500);
        });
        $('#navAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#navAcc').offset().top - 80 },
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
<?php if($_SESSION['collepse_status'] == 'sortAcc'  ) {?>
    <script>
        $('#sortAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#sortAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'filtreAcc'  ) {?>
    <script>
        $('#filtreAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#filtreAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'navAcc'  ) {?>
    <script>
        $('#navAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#navAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<script>
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>