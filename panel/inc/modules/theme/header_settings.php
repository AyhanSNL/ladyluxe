<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'header';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();

$headerAyarCek = $db->prepare("select * from header_ayar where id=:id ");
$headerAyarCek->execute(array(
        'id' => '1'
));
$headayar = $headerAyarCek->fetch(PDO::FETCH_ASSOC);

$dropDown = $db->prepare("select * from haeder_dropdown where id=:id ");
$dropDown->execute(array(
    'id' => '1'
));
$drop = $dropDown->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-99']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_header_settings"> <i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-99']?></a>
                            </div>
                        </div>
                        <div class="col-md-auto mr-3" >
                            <?php if($yetki['modul'] == '1' && $yetki['modul_header_footer'] == '1' ) {?>
                                <div class="mt-2 d-md-none d-sm-block"></div>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" style="font-size: 13px ; font-weight: 400;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?=$diller['adminpanel-text-275']?>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                        <a class="dropdown-item" href="pages.php?page=tophtml_area" target="_blank"><?=$diller['adminpanel-menu-text-44']?></a>
                                        <a class="dropdown-item" href="pages.php?page=topheader_links" target="_blank"><?=$diller['adminpanel-menu-text-45']?></a>
                                        <a class="dropdown-item" href="pages.php?page=header_links" target="_blank"><?=$diller['adminpanel-menu-text-46']?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->




        <?php if($yetki['tema_ayarlar'] == '1' ) {?>
            <div class="row">



                <div class="col-md-3 d-none d-md-inline-block" id="sidebarWrap">
                    <div id="sidebar" class="mr-3 ">
                        <div class="btn-group w-100 d-flex flex-wrap " role="group">
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0 <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?>" type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-271']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'menuAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#menuAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-272']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'logoAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-270']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'topHAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#topHAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-273']?>
                            </button>
                        </div>


                    </div>
                </div>


                <!-- Mobile !-->
                <div class="col-md-3 d-md-none d-sm-inline-block ">
                    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#navigasyon" aria-expanded="false" aria-controls="collapseExample">
                        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
                    </a>
                    <div class="collapse mb-3" id="navigasyon">
                        <div class="btn-group w-100 d-flex flex-wrap" role="group">
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0 <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?>" type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-271']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'menuAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#menuAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-272']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'logoAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-270']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'topHAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#topHAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-273']?>
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
                                        <?=$diller['adminpanel-form-text-128']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100  border-top pt-3">
                                        <form action="post.php?process=theme_header_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-4">
                                                    <label>  <?=$diller['adminpanel-form-text-129']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['header_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="header_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label for="padding">* <?=$diller['adminpanel-form-text-130']?></label>
                                                    <input type="number" name="padding" value="<?=$headayar['padding']?>" id="padding" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="font_select" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="font_select" class="form-control" id="font_select" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $headayar['font_select'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4">
                                                <div class="in-header-page-text">
                                                   <?=$diller['adminpanel-form-text-144']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="header_text_status" class="w-100"><?=$diller['adminpanel-form-text-135']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="header_text_status" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="header_text_status" name="header_text_status" value="1" <?php if($headayar['header_text_status'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="header_text_status"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="header_bell" class="w-100"><?=$diller['adminpanel-form-text-136']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="header_bell" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="header_bell" name="header_bell" value="1" <?php if($headayar['header_bell'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="header_bell"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="header_fav" class="w-100"><?=$diller['adminpanel-form-text-137']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="header_fav" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="header_fav" name="header_fav" value="1" <?php if($headayar['header_fav'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="header_fav"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="header_login" class="w-100"><?=$diller['adminpanel-form-text-138']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="header_login" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="header_login" name="header_login" value="1" <?php if($headayar['header_login'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="header_login"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="header_cart" class="w-100"><?=$diller['adminpanel-form-text-139']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="header_cart" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="header_cart" name="header_cart" value="1" <?php if($headayar['header_cart'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="header_cart"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="cagri_merkezi" class="w-100" ><?=$diller['adminpanel-form-text-140']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="cagri_merkezi" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="cagri_merkezi" name="cagri_merkezi" value="1"  <?php if($headayar['cagri_merkezi'] == '1'  ) { ?>checked<?php }?> onclick="callBtn(this.checked);">
                                                        <label class="custom-control-label" for="cagri_merkezi"></label>
                                                    </div>
                                                </div>
                                                <div id="callBtn" class="w-100 col-md-12 mb-4 " <?php if($headayar['cagri_merkezi'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row">
                                                        <div class="form-group col-md-4 ">
                                                            <label for="cagri_no"><?=$diller['adminpanel-form-text-141']?></label>
                                                            <input type="cagri_no" name="cagri_no" value="<?=$headayar['cagri_no']?>" id="cagri_no"   class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="call_i_color"><?=$diller['adminpanel-form-text-142']?></label>
                                                            <div data-color-format="default" data-color="#<?=$headayar['call_i_color']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="call_i_color"  value="" class="form-control">
                                                                <div class="input-group-append add-on">
                                                                    <button class="btn btn-light border" type="button">
                                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="call_text_color"><?=$diller['adminpanel-form-text-143']?></label>
                                                            <div data-color-format="default" data-color="#<?=$headayar['call_text_color']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="call_text_color"  value="" class="form-control">
                                                                <div class="input-group-append add-on">
                                                                    <button class="btn btn-light border" type="button">
                                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4">
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-form-text-145']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="navbutton_color"><?=$diller['adminpanel-form-text-146']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['navbutton_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="navbutton_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="navbutton_hover_color"><?=$diller['adminpanel-form-text-147']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['navbutton_hover_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="navbutton_hover_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="count_bg"><?=$diller['adminpanel-form-text-148']?></label>
                                                    <select name="count_bg" class="form-control selet2" id="count_bg" required style="width: 100%;  ">
                                                        <option value="button-black-white" <?php if($headayar['count_bg'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($headayar['count_bg'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($headayar['count_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($headayar['count_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($headayar['count_bg'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($headayar['count_bg'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($headayar['count_bg'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($headayar['count_bg'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($headayar['count_bg'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($headayar['count_bg'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($headayar['count_bg'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($headayar['count_bg'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($headayar['count_bg'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($headayar['count_bg'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($headayar['count_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($headayar['count_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($headayar['count_bg'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($headayar['count_bg'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($headayar['count_bg'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($headayar['count_bg'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($headayar['count_bg'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($headayar['count_bg'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($headayar['count_bg'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="count_bg_2"><?=$diller['adminpanel-form-text-173']?></label>
                                                    <select name="count_bg_2" class="form-control selet2" id="count_bg_2" required style="width: 100%;  ">
                                                        <option value="button-black-white" <?php if($headayar['count_bg_2'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($headayar['count_bg_2'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($headayar['count_bg_2'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($headayar['count_bg_2'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($headayar['count_bg_2'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($headayar['count_bg_2'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($headayar['count_bg_2'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($headayar['count_bg_2'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($headayar['count_bg_2'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($headayar['count_bg_2'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($headayar['count_bg_2'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($headayar['count_bg_2'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($headayar['count_bg_2'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($headayar['count_bg_2'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($headayar['count_bg_2'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($headayar['count_bg_2'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($headayar['count_bg_2'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($headayar['count_bg_2'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($headayar['count_bg_2'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($headayar['count_bg_2'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($headayar['count_bg_2'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($headayar['count_bg_2'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($headayar['count_bg_2'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4">
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-form-text-174']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="header_search" class="w-100" ><?=$diller['adminpanel-form-text-175']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="header_search" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="header_search" name="header_search" value="1"  <?php if($headayar['header_search'] == '1'  ) { ?>checked<?php }?> onclick="searchBtn(this.checked);">
                                                        <label class="custom-control-label" for="header_search"></label>
                                                    </div>
                                                </div>
                                                <div id="searchBtn" class="w-100 col-md-12 mb-4 border-bottom" <?php if($headayar['header_search'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row">
                                                        <div class="form-group col-md-6 ">
                                                            <label for="select_box"><?=$diller['adminpanel-form-text-176']?></label>
                                                            <select name="search_tip" class="form-control"  id="select_box" required>
                                                                <option value="1" <?php if($headayar['search_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-177']?></option>
                                                                <option value="2" <?php if($headayar['search_tip'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-178']?></option>
                                                            </select>
                                                        </div>
                                                        <div id="1" class="select_option w-100 ">
                                                            <div class="d-flex flex-wrap">
                                                                <div class="form-group col-md-6">
                                                                    <label for="search_bg"><?=$diller['adminpanel-form-text-179']?></label>
                                                                    <div data-color-format="default" data-color="#<?=$headayar['search_bg']?>"  class="colorpicker-default input-group">
                                                                        <input type="text" name="search_bg"  value="" class="form-control">
                                                                        <div class="input-group-append add-on">
                                                                            <button class="btn btn-light border" type="button">
                                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="search_border_color"><?=$diller['adminpanel-form-text-180']?></label>
                                                                    <div data-color-format="default" data-color="#<?=$headayar['search_border_color']?>"  class="colorpicker-default input-group">
                                                                        <input type="text" name="search_border_color"  value="" class="form-control">
                                                                        <div class="input-group-append add-on">
                                                                            <button class="btn btn-light border" type="button">
                                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="search_focus_border"><?=$diller['adminpanel-form-text-181']?></label>
                                                                    <div data-color-format="default" data-color="#<?=$headayar['search_focus_border']?>"  class="colorpicker-default input-group">
                                                                        <input type="text" name="search_focus_border"  value="" class="form-control">
                                                                        <div class="input-group-append add-on">
                                                                            <button class="btn btn-light border" type="button">
                                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="search_border_radius"><?=$diller['adminpanel-form-text-182']?></label>
                                                                    <input type="text" name="search_border_radius" value="<?=$headayar['search_border_radius']?>" id="search_border_radius" placeholder="Örn : 50px" required class="form-control">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="search_text_color"><?=$diller['adminpanel-form-text-184']?></label>
                                                                    <div data-color-format="default" data-color="#<?=$headayar['search_text_color']?>"  class="colorpicker-default input-group">
                                                                        <input type="text" name="search_text_color"  value="" class="form-control">
                                                                        <div class="input-group-append add-on">
                                                                            <button class="btn btn-light border" type="button">
                                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="search_place_color"><?=$diller['adminpanel-form-text-183']?></label>
                                                                    <div data-color-format="default" data-color="#<?=$headayar['search_place_color']?>"  class="colorpicker-default input-group">
                                                                        <input type="text" name="search_place_color"  value="" class="form-control">
                                                                        <div class="input-group-append add-on">
                                                                            <button class="btn btn-light border" type="button">
                                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="search_button_color"><?=$diller['adminpanel-form-text-185']?></label>
                                                                    <div data-color-format="default" data-color="#<?=$headayar['search_button_color']?>"  class="colorpicker-default input-group">
                                                                        <input type="text" name="search_button_color"  value="" class="form-control">
                                                                        <div class="input-group-append add-on">
                                                                            <button class="btn btn-light border" type="button">
                                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="search_shadow"><?=$diller['adminpanel-form-text-186']?></label>
                                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                                        <input type="hidden" name="search_shadow" value="0"">
                                                                        <input type="checkbox" class="custom-control-input" id="search_shadow" name="search_shadow" value="1" <?php if($headayar['search_shadow'] == '1'  ) { ?>checked<?php }?>>
                                                                        <label class="custom-control-label" for="search_shadow"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" style="margin-bottom: 20px;">
                                                <div class="in-header-page-text">
                                                   <?=$diller['adminpanel-form-text-187']?>
                                                </div>
                                            </div>
                                            <div class="w-100 bg-light p-2 mb-3">
                                                <?=$diller['adminpanel-form-text-188']?>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label  for="dropdown_shadow" class="w-100"><?=$diller['adminpanel-form-text-189']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="dropdown_shadow" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="dropdown_shadow" name="dropdown_shadow" value="1" <?php if($headayar['dropdown_shadow'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="dropdown_shadow"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="dropdown_radius" class="w-100"><?=$diller['adminpanel-form-text-190']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="dropdown_radius" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="dropdown_radius" name="dropdown_radius" value="1" <?php if($headayar['dropdown_radius'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="dropdown_radius"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="dropdown_border" class="w-100"><?=$diller['adminpanel-form-text-191']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['dropdown_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="dropdown_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-5" style="margin-bottom: 20px;">
                                                <div class="in-header-page-text ">
                                                    <?=$diller['adminpanel-form-text-192']?>
                                                </div>
                                            </div>
                                            <small >
                                                <?=$diller['adminpanel-form-text-193']?>
                                            </small>
                                            <div class="row mb-4 mt-4">
                                                <div class="form-group col-md-4">
                                                    <label  for="dropdown_compare" class="w-100"><?=$diller['adminpanel-form-text-194']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="dropdown_compare" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="dropdown_compare" name="dropdown_compare" value="1" <?php if($headayar['dropdown_compare'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="dropdown_compare"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="dropdown_fav" class="w-100"><?=$diller['adminpanel-form-text-195']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="dropdown_fav" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="dropdown_fav" name="dropdown_fav" value="1" <?php if($headayar['dropdown_fav'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="dropdown_fav"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="dropdown_bell" class="w-100"><?=$diller['adminpanel-form-text-196']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="dropdown_bell" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="dropdown_bell" name="dropdown_bell" value="1" <?php if($headayar['dropdown_bell'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="dropdown_bell"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-5" style="margin-bottom: 20px;">
                                                <div class="in-header-page-text ">
                                                    <?=$diller['adminpanel-form-text-197']?>
                                                </div>
                                            </div>
                                            <small>
                                               <?=$diller['adminpanel-form-text-198']?> 
                                            </small>
                                            <div class="row mb-4 mt-4">
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_compare" class="w-100"><?=$diller['adminpanel-form-text-194']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_compare" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_compare" name="login_dropdown_compare" value="1" <?php if($headayar['login_dropdown_compare'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_compare"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_fav" class="w-100"><?=$diller['adminpanel-form-text-195']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_fav" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_fav" name="login_dropdown_fav" value="1" <?php if($headayar['login_dropdown_fav'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_fav"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_bell" class="w-100"><?=$diller['adminpanel-form-text-196']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_bell" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_bell" name="login_dropdown_bell" value="1" <?php if($headayar['login_dropdown_bell'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_bell"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_account" class="w-100"><?=$diller['adminpanel-form-text-199']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_account" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_account" name="login_dropdown_account" value="1" <?php if($headayar['login_dropdown_account'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_account"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_address" class="w-100"><?=$diller['adminpanel-form-text-200']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_address" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_address" name="login_dropdown_address" value="1" <?php if($headayar['login_dropdown_address'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_address"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_order" class="w-100"><?=$diller['adminpanel-form-text-201']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_order" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_order" name="login_dropdown_order" value="1" <?php if($headayar['login_dropdown_order'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_order"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_support" class="w-100"><?=$diller['adminpanel-form-text-202']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_support" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_support" name="login_dropdown_support" value="1" <?php if($headayar['login_dropdown_support'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_support"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_comments" class="w-100"><?=$diller['adminpanel-form-text-203']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_comments" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_comments" name="login_dropdown_comments" value="1" <?php if($headayar['login_dropdown_comments'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_comments"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="login_dropdown_coupon" class="w-100"><?=$diller['adminpanel-form-text-204']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="login_dropdown_coupon" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="login_dropdown_coupon" name="login_dropdown_coupon" value="1" <?php if($headayar['login_dropdown_coupon'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="login_dropdown_coupon"></label>
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

                        <!-- Dropdown Tema Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#menuAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-272']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse " id="menuAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_header_post&status=dropdown_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-205']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="area"><?=$diller['adminpanel-form-text-207']?></label>
                                                    <select name="area" class="form-control" id="area" required>
                                                        <option value="flex-start" <?php if($drop['area'] == 'flex-start' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-208']?></option>
                                                        <option value="center" <?php if($drop['area'] == 'center' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-209']?></option>
                                                        <option value="flex-end" <?php if($drop['area'] == 'flex-end' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-210']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="dropdown_overlay" class="w-100"><?=$diller['adminpanel-form-text-149']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="dropdown_overlay" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="dropdown_overlay" name="dropdown_overlay" value="1" <?php if($drop['dropdown_overlay'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="dropdown_overlay"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-206']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['border_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="border_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label for="border_size_top"><?=$diller['adminpanel-form-text-840']?></label>
                                                    <select name="border_size_top" class="form-control" id="border_size_top" required>
                                                        <option value="0" <?php if($drop['border_size_top'] == '0' ) { ?>selected<?php }?>>0</option>
                                                        <option value="1" <?php if($drop['border_size_top'] == '1' ) { ?>selected<?php }?>>1px</option>
                                                        <option value="2" <?php if($drop['border_size_top'] == '2' ) { ?>selected<?php }?>>2px</option>
                                                        <option value="3" <?php if($drop['border_size_top'] == '3' ) { ?>selected<?php }?>>3px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label for="border_size"><?=$diller['adminpanel-form-text-841']?></label>
                                                    <select name="border_size" class="form-control" id="border_size" required>
                                                        <option value="0" <?php if($drop['border_size'] == '0' ) { ?>selected<?php }?>>0</option>
                                                        <option value="1" <?php if($drop['border_size'] == '1' ) { ?>selected<?php }?>>1px</option>
                                                        <option value="2" <?php if($drop['border_size'] == '2' ) { ?>selected<?php }?>>2px</option>
                                                        <option value="3" <?php if($drop['border_size'] == '3' ) { ?>selected<?php }?>>3px</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4">
                                                <div class="in-header-page-text">
                                                   <?=$diller['adminpanel-form-text-211']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-212']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['box_text_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="box_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-213']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['box_hover_text_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="box_hover_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-214']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['box_hover_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="box_hover_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="box_padding_left"><?=$diller['adminpanel-form-text-216']?></label>
                                                    <input type="number" name="box_padding_left" value="<?=$drop['box_padding_left']?>" id="box_padding_left" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="box_padding_top"><?=$diller['adminpanel-form-text-215']?></label>
                                                    <input type="number" name="box_padding_top" value="<?=$drop['box_padding_top']?>" id="box_padding_top" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="box_font_size"><?=$diller['adminpanel-form-text-217']?></label>
                                                    <select name="box_font_size" class="form-control" id="box_font_size" required>
                                                        <option value="12" <?php if($drop['box_font_size'] == '12' ) { ?>selected<?php }?>>12px</option>
                                                        <option value="13" <?php if($drop['box_font_size'] == '13' ) { ?>selected<?php }?>>13px</option>
                                                        <option value="14" <?php if($drop['box_font_size'] == '14' ) { ?>selected<?php }?>>14px</option>
                                                        <option value="15" <?php if($drop['box_font_size'] == '15' ) { ?>selected<?php }?>>15px</option>
                                                        <option value="16" <?php if($drop['box_font_size'] == '16' ) { ?>selected<?php }?>>16px</option>
                                                        <option value="17" <?php if($drop['box_font_size'] == '17' ) { ?>selected<?php }?>>17px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="box_font_weight"><?=$diller['adminpanel-form-text-218']?></label>
                                                    <select name="box_font_weight" class="form-control" id="box_font_weight" required>
                                                        <option value="300" <?php if($drop['box_font_weight'] == '300' ) { ?>selected<?php }?>>300</option>
                                                        <option value="400" <?php if($drop['box_font_weight'] == '400' ) { ?>selected<?php }?>>400</option>
                                                        <option value="500" <?php if($drop['box_font_weight'] == '500' ) { ?>selected<?php }?>>500</option>
                                                        <option value="600" <?php if($drop['box_font_weight'] == '600' ) { ?>selected<?php }?>>600</option>
                                                        <option value="700" <?php if($drop['box_font_weight'] == '700' ) { ?>selected<?php }?>>700</option>
                                                        <option value="800" <?php if($drop['box_font_weight'] == '800' ) { ?>selected<?php }?>>800</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4">
                                                <div class="in-header-page-text">
                                                  <?=$diller['adminpanel-form-text-219']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-220']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['second_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="second_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-221']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['second_bg_hover']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="second_bg_hover"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-222']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['second_text_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="second_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-223']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['second_hover_text_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="second_hover_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-224']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['second_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="second_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-225']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['dropdown_topborder']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="dropdown_topborder"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="second_font_size"><?=$diller['adminpanel-form-text-226']?></label>
                                                    <select name="second_font_size" class="form-control" id="box_font_size" required>
                                                        <option value="12" <?php if($drop['second_font_size'] == '12' ) { ?>selected<?php }?>>12px</option>
                                                        <option value="13" <?php if($drop['second_font_size'] == '13' ) { ?>selected<?php }?>>13px</option>
                                                        <option value="14" <?php if($drop['second_font_size'] == '14' ) { ?>selected<?php }?>>14px</option>
                                                        <option value="15" <?php if($drop['second_font_size'] == '15' ) { ?>selected<?php }?>>15px</option>
                                                        <option value="16" <?php if($drop['second_font_size'] == '16' ) { ?>selected<?php }?>>16px</option>
                                                        <option value="17" <?php if($drop['second_font_size'] == '17' ) { ?>selected<?php }?>>17px</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4">
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-form-text-227']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label>2.Alt Menü Arkaplan Rengi</label>
                                                    <div data-color-format="default" data-color="#<?=$drop['third_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="third_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label>2.Alt Menü Kutu Hover Rengi</label>
                                                    <div data-color-format="default" data-color="#<?=$drop['third_bg_hover']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="third_bg_hover"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label>2.Alt Menü Kutu Yazı Rengi</label>
                                                    <div data-color-format="default" data-color="#<?=$drop['third_text_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="third_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label>2.Alt Menü Kutu Yazı Hover Rengi</label>
                                                    <div data-color-format="default" data-color="#<?=$drop['third_hover_text_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="third_hover_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label>2.Alt Menü Kutu Border Rengi</label>
                                                    <div data-color-format="default" data-color="#<?=$drop['third_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="third_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="third_font_size">2.Alt Menü Font Size</label>
                                                    <select name="third_font_size" class="form-control" id="box_font_size" required>
                                                        <option value="12" <?php if($drop['third_font_size'] == '12' ) { ?>selected<?php }?>>12px</option>
                                                        <option value="13" <?php if($drop['third_font_size'] == '13' ) { ?>selected<?php }?>>13px</option>
                                                        <option value="14" <?php if($drop['third_font_size'] == '14' ) { ?>selected<?php }?>>14px</option>
                                                        <option value="15" <?php if($drop['third_font_size'] == '15' ) { ?>selected<?php }?>>15px</option>
                                                        <option value="16" <?php if($drop['third_font_size'] == '16' ) { ?>selected<?php }?>>16px</option>
                                                        <option value="17" <?php if($drop['third_font_size'] == '17' ) { ?>selected<?php }?>>17px</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4">
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-form-text-228']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-229']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['mega_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="mega_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-230']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['mega_baslik_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="mega_baslik_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-231']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['mega_alt_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="mega_alt_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label><?=$diller['adminpanel-form-text-232']?></label>
                                                    <div data-color-format="default" data-color="#<?=$drop['mega_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="mega_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Dropdown Tema Ayarları  SON !-->

                        <!-- Logo Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-132']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse " id="logoAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card border">
                                                        <div class="card-body">
                                                            <div class="font-14 p-2 bg-pink text-white text-center">
                                                                <?=$diller['adminpanel-form-text-133']?>
                                                            </div>
                                                            <div class="w-100 p-3 text-center mb-2" style="background-color: #<?=$headayar['header_bg']?>;">
                                                                <?php if($headayar['header_logo'] == !null  ) {?>
                                                                    <small class="text-dark bg-white p-1">
                                                                        <?=$diller['adminpanel-text-151']?>
                                                                    </small>
                                                                    <br><br>
                                                                    <img src="<?=$ayar['site_url']?>images/logo/<?=$headayar['header_logo']?>" class="img-fluid" >
                                                                    <br><br>
                                                                    <small class="bg-white p-1">
                                                                        <?=$diller['adminpanel-form-text-89']?> : 190x50
                                                                    </small>
                                                                <?php }else{ ?>
                                                                    <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                                    <br><br>
                                                                    <small class="bg-white p-1">
                                                                        <?=$diller['adminpanel-form-text-89']?> : 190x50
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                            <div class="w-100 border-top pt-2 ">
                                                                <form action="post.php?process=theme_header_post&status=header_logo_update" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="old_logo" value="<?=$headayar['header_logo']?>" >
                                                                    <div class="input-group mb-3">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="header_logo" >
                                                                            <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-text-152']?></label>
                                                                        </div>
                                                                    </div>
                                                                    <button class="btn btn-success btn-block" name="update"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                                                                    <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                                                        <small>png,  jpg, jpeg, gif, svg</small>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Logo Ayarları  SON !-->

                        <!-- Top Header Tema Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#topHAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-273']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="topHAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_header_post&status=topheader_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="topheader" class="w-100"><?=$diller['adminpanel-form-text-233']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="topheader" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="topheader" name="topheader" value="1" <?php if($headayar['topheader'] == '1'  ) { ?>checked<?php }?> onclick="topHeaderBtn(this.checked);">
                                                        <label class="custom-control-label" for="topheader"></label>
                                                    </div>
                                                </div>
                                                <div id="topHeaderBtn" class="w-100 col-md-12 mb-4 " <?php if($headayar['topheader'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row">
                                                        <div class="form-group col-md-6 mb-4">
                                                            <label  for="topheader_dil" class="w-100"><?=$diller['adminpanel-form-text-234']?></label>
                                                            <div class="custom-control custom-switch custom-switch-lg">
                                                                <input type="hidden" name="topheader_dil" value="0"">
                                                                <input type="checkbox" class="custom-control-input" id="topheader_dil" name="topheader_dil" value="1" <?php if($headayar['topheader_dil'] == '1'  ) { ?>checked<?php }?> >
                                                                <label class="custom-control-label" for="topheader_dil"></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 mb-4">
                                                            <label  for="topheader_kur" class="w-100"><?=$diller['adminpanel-form-text-235']?></label>
                                                            <div class="custom-control custom-switch custom-switch-lg">
                                                                <input type="hidden" name="topheader_kur" value="0"">
                                                                <input type="checkbox" class="custom-control-input" id="topheader_kur" name="topheader_kur" value="1" <?php if($headayar['topheader_kur'] == '1'  ) { ?>checked<?php }?> >
                                                                <label class="custom-control-label" for="topheader_kur"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6 mb-4">
                                                            <label><?=$diller['adminpanel-form-text-236']?></label>
                                                            <div data-color-format="default" data-color="#<?=$headayar['topheader_bg']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="topheader_bg"  value="" class="form-control">
                                                                <div class="input-group-append add-on">
                                                                    <button class="btn btn-light border" type="button">
                                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="topheader_border"><?=$diller['adminpanel-form-text-237']?></label>
                                                            <div data-color-format="default" data-color="#<?=$headayar['topheader_border']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="topheader_border"  value="" class="form-control">
                                                                <div class="input-group-append add-on">
                                                                    <button class="btn btn-light border" type="button">
                                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6 mb-4">
                                                            <label><?=$diller['adminpanel-form-text-238']?></label>
                                                            <div data-color-format="default" data-color="#<?=$headayar['topheader_a_color']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="topheader_a_color"  value="" class="form-control">
                                                                <div class="input-group-append add-on">
                                                                    <button class="btn btn-light border" type="button">
                                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 mb-4">
                                                            <label><?=$diller['adminpanel-form-text-239']?></label>
                                                            <div data-color-format="default" data-color="#<?=$headayar['topheader_a_color_hover']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="topheader_a_color_hover"  value="" class="form-control">
                                                                <div class="input-group-append add-on">
                                                                    <button class="btn btn-light border" type="button">
                                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="topheader_a_size"><?=$diller['adminpanel-form-text-240']?></label>
                                                            <select name="topheader_a_size" class="form-control" id="topheader_a_size" required>
                                                                <option value="11" <?php if($headayar['topheader_a_size'] == '11' ) { ?>selected<?php }?>>11px</option>
                                                                <option value="12" <?php if($headayar['topheader_a_size'] == '12' ) { ?>selected<?php }?>>12px</option>
                                                                <option value="13" <?php if($headayar['topheader_a_size'] == '13' ) { ?>selected<?php }?>>13px</option>
                                                                <option value="14" <?php if($headayar['topheader_a_size'] == '14' ) { ?>selected<?php }?>>14px</option>
                                                                <option value="15" <?php if($headayar['topheader_a_size'] == '15' ) { ?>selected<?php }?>>15px</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="topheader_a_weight"><?=$diller['adminpanel-form-text-241']?></label>
                                                            <select name="topheader_a_weight" class="form-control" id="topheader_a_size" required>
                                                                <option value="300" <?php if($headayar['topheader_a_weight'] == '300' ) { ?>selected<?php }?>>300</option>
                                                                <option value="400" <?php if($headayar['topheader_a_weight'] == '400' ) { ?>selected<?php }?>>400</option>
                                                                <option value="500" <?php if($headayar['topheader_a_weight'] == '500' ) { ?>selected<?php }?>>500</option>
                                                                <option value="600" <?php if($headayar['topheader_a_weight'] == '600' ) { ?>selected<?php }?>>600</option>
                                                                <option value="700" <?php if($headayar['topheader_a_weight'] == '700' ) { ?>selected<?php }?>>700</option>
                                                                <option value="800" <?php if($headayar['topheader_a_weight'] == '800' ) { ?>selected<?php }?>>800</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="topheader_a_padding"><?=$diller['adminpanel-form-text-242']?></label>
                                                            <input type="number" name="topheader_a_padding" value="<?=$headayar['topheader_a_padding']?>" id="topheader_a_padding" required class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Top Header Tema Ayarları  SON !-->
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
<script id="rendered-js" >
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
        $('#logoAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#logoAcc').offset().top - 80 },
                500);
        });
        $('#menuAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#menuAcc').offset().top - 80 },
                500);
        });
        $('#topHAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#topHAcc').offset().top - 80 },
                500);
        });
    });
    function searchBtn(selected)
    {
        if (selected)
        {
            document.getElementById("searchBtn").style.display = "";
        } else

        {
            document.getElementById("searchBtn").style.display = "none";
        }

    }
    $('#select_box').change(function () {
        var select = $(this).find(':selected').val();
        $(".select_option").hide();
        $('#' + select).show();
    }).change();
    function callBtn(selected)
    {
        if (selected)
        {
            document.getElementById("callBtn").style.display = "";
        } else

        {
            document.getElementById("callBtn").style.display = "none";
        }

    }
    function topHeaderBtn(selected)
    {
        if (selected)
        {
            document.getElementById("topHeaderBtn").style.display = "";
        } else

        {
            document.getElementById("topHeaderBtn").style.display = "none";
        }

    }
    $(document).ready(function() {
        $('.selet2').select2();
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
<?php if($_SESSION['collepse_status'] == 'logoAcc'  ) {?>
    <script>
        $('#logoAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#logoAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'menuAcc'  ) {?>
    <script>
        $('#menuAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#menuAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'topHAcc'  ) {?>
    <script>
        $('#topHAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#topHAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>