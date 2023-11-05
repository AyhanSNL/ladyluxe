<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'tab';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from vitrin_secenekli_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);


?>
<title><?=$diller['adminpanel-text-298']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_showcase_tab"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-text-298']?></a>
                            </div>
                        </div>
                        <div class="col-md-auto mr-3" >
                            <div class="mt-2 d-md-none d-sm-block"></div>
                            <a href="pages.php?page=showcase_tabproduct"  class="btn btn-primary" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-text-329']?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['tema_ayarlar'] == '1' ) {?>
            <div class="row">


                <div class="col-md-3 d-none d-md-inline-block" id="sidebarWrap" style="overflow: hidden; position: relative">
                    <div id="sidebar" class="mr-3">
                        <div class="btn-group w-100 d-flex flex-wrap" role="group">
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?>" type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-140']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'bgAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#bgAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-379']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'detailAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#detailAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-389']?>
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
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?>" type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-140']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'bgAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#bgAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-379']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'detailAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#detailAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-389']?>
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
                                        <form action="post.php?process=theme_catalog_post&status=tab_showcase_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label  for="secenekvitrin_baslik_font" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="secenekvitrin_baslik_font" class="form-control" id="secenekvitrin_baslik_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['secenekvitrin_baslik_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label for="secenekvitrin_margin">* <?=$diller['adminpanel-form-text-243']?></label>
                                                    <input type="number" name="secenekvitrin_margin" value="<?=$detay['secenekvitrin_margin']?>" id="secenekvitrin_margin" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label for="secenekvitrin_padding">* <?=$diller['adminpanel-form-text-130']?></label>
                                                    <input type="number" name="secenekvitrin_padding" value="<?=$detay['secenekvitrin_padding']?>" id="secenekvitrin_padding" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_border"><?=$diller['adminpanel-form-text-384']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['secenekvitrin_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="secenekvitrin_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="secenekvitrin_grid_sayi" class="w-100">* <?=$diller['adminpanel-form-text-390']?></label>
                                                    <select name="secenekvitrin_grid_sayi" class="form-control" id="secenekvitrin_grid_sayi" required>
                                                        <option value="4" <?php if($detay['secenekvitrin_grid_sayi'] == '4'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-391']?></option>
                                                        <option value="5" <?php if($detay['secenekvitrin_grid_sayi'] == '5'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-392']?></option>
                                                        <option value="6" <?php if($detay['secenekvitrin_grid_sayi'] == '6'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-393']?></option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4 mb-4">
                                                    <label for="secenekvitrin_tab_urun_limit">* <?=$diller['adminpanel-form-text-395']?></label>
                                                    <input type="number" name="secenekvitrin_tab_urun_limit" value="<?=$detay['secenekvitrin_tab_urun_limit']?>" id="secenekvitrin_tab_urun_limit" required class="form-control">
                                                </div>

                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-396']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label  for="secenekvitrin_tab_baslikspace" class="w-100"><?=$diller['adminpanel-form-text-397']?></label>
                                                    <select name="secenekvitrin_tab_baslikspace" class="form-control" id="secenekvitrin_tab_baslikspace" >
                                                        <option value="" <?php if($detay['secenekvitrin_tab_baslikspace'] == ''  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-401']?></option>
                                                        <option value="lspac" <?php if($detay['secenekvitrin_tab_baslikspace'] == 'lspac'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-398']?></option>
                                                        <option value="lspacsmall" <?php if($detay['secenekvitrin_tab_baslikspace'] == 'lspacsmall'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-399']?></option>
                                                        <option value="lspacsmall_2" <?php if($detay['secenekvitrin_tab_baslikspace'] == 'lspacsmall_2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-400']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_tab_baslik_size"><?=$diller['adminpanel-form-text-402']?></label>
                                                    <select name="secenekvitrin_tab_baslik_size" class="form-control" id="secenekvitrin_tab_baslik_size" required>
                                                        <option value="12" <?php if($detay['secenekvitrin_tab_baslik_size'] == '12' ) { ?>selected<?php }?>>12px</option>
                                                        <option value="13" <?php if($detay['secenekvitrin_tab_baslik_size'] == '13' ) { ?>selected<?php }?>>13px</option>
                                                        <option value="14" <?php if($detay['secenekvitrin_tab_baslik_size'] == '14' ) { ?>selected<?php }?>>14px</option>
                                                        <option value="15" <?php if($detay['secenekvitrin_tab_baslik_size'] == '15' ) { ?>selected<?php }?>>15px</option>
                                                        <option value="16" <?php if($detay['secenekvitrin_tab_baslik_size'] == '16' ) { ?>selected<?php }?>>16px</option>
                                                        <option value="18" <?php if($detay['secenekvitrin_tab_baslik_size'] == '18' ) { ?>selected<?php }?>>18px</option>
                                                        <option value="20" <?php if($detay['secenekvitrin_tab_baslik_size'] == '20' ) { ?>selected<?php }?>>20px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_tab_baslik_weight"><?=$diller['adminpanel-form-text-403']?></label>
                                                    <select name="secenekvitrin_tab_baslik_weight" class="form-control" id="secenekvitrin_tab_baslik_weight" required>
                                                        <option value="300" <?php if($detay['secenekvitrin_tab_baslik_weight'] == '300' ) { ?>selected<?php }?>>300</option>
                                                        <option value="400" <?php if($detay['secenekvitrin_tab_baslik_weight'] == '400' ) { ?>selected<?php }?>>400</option>
                                                        <option value="500" <?php if($detay['secenekvitrin_tab_baslik_weight'] == '500' ) { ?>selected<?php }?>>500</option>
                                                        <option value="600" <?php if($detay['secenekvitrin_tab_baslik_weight'] == '600' ) { ?>selected<?php }?>>600</option>
                                                        <option value="700" <?php if($detay['secenekvitrin_tab_baslik_weight'] == '700' ) { ?>selected<?php }?>>700</option>
                                                        <option value="800" <?php if($detay['secenekvitrin_tab_baslik_weight'] == '800' ) { ?>selected<?php }?>>800</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_aktif_tab_renk"><?=$diller['adminpanel-form-text-410']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['secenekvitrin_aktif_tab_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="secenekvitrin_aktif_tab_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_aktif_tab_yazi"><?=$diller['adminpanel-form-text-411']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['secenekvitrin_aktif_tab_yazi']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="secenekvitrin_aktif_tab_yazi"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_aktif_tab_border"><?=$diller['adminpanel-form-text-412']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['secenekvitrin_aktif_tab_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="secenekvitrin_aktif_tab_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_tab_renk"><?=$diller['adminpanel-form-text-405']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['secenekvitrin_tab_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="secenekvitrin_tab_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_tab_yazi"><?=$diller['adminpanel-form-text-406']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['secenekvitrin_tab_yazi']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="secenekvitrin_tab_yazi"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_tab_border"><?=$diller['adminpanel-form-text-407']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['secenekvitrin_tab_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="secenekvitrin_tab_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_tab_radius"><?=$diller['adminpanel-form-text-408']?></label>
                                                    <input type="number" name="secenekvitrin_tab_radius" value="<?=$detay['secenekvitrin_tab_radius']?>" id="secenekvitrin_tab_radius" required  class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="secenekvitrin_tab_margin"><?=$diller['adminpanel-form-text-409']?></label>
                                                    <input type="number" name="secenekvitrin_tab_margin" value="<?=$detay['secenekvitrin_tab_margin']?>" id="secenekvitrin_tab_radius" required  class="form-control">
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

                        <!-- Arkaplan Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#bgAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-379']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="bgAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=tab_showcase_bg" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="form-group col-md-12 ">
                                                    <select name="secenekvitrin_bg_tip" class="form-control"  id="select_box" required>
                                                        <option value="0" <?php if($detay['secenekvitrin_bg_tip'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-251']?></option>
                                                        <option value="1" <?php if($detay['secenekvitrin_bg_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-250']?></option>
                                                    </select>
                                                </div>
                                                <div  id="0" class="select_option form-group pl-3 pr-3 w-100">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="inputGroupFile01"><?=$diller['adminpanel-form-text-255']?></label>
                                                            <div class="w-100 bg-light   p-3 text-center mb-3 ">
                                                                <?php if($detay['secenekvitrin_bg_image'] == !null  ) {?>
                                                                    <small class="text-dark">
                                                                        <?=$diller['adminpanel-form-text-107']?>
                                                                    </small>
                                                                    <br><br>
                                                                    <img src="<?=$ayar['site_url']?>images/uploads/<?=$detay['secenekvitrin_bg_image']?>" class="img-fluid" >
                                                                    <small>
                                                                        <br><br>
                                                                        <?=$diller['adminpanel-form-text-89']?> : 1920x1080
                                                                    </small>
                                                                    <br><br>
                                                                    <a href="" data-href="post.php?process=theme_catalog_post&status=tab_showcase_bg_delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                                <?php }else{ ?>
                                                                    <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                                    <small>
                                                                        <br><br>
                                                                        <?=$diller['adminpanel-form-text-89']?> : 1920x1080
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                            <div class="w-100">
                                                                <input type="hidden" name="old_bg" value="<?=$detay['secenekvitrin_bg_image']?>" >
                                                                <div class="input-group mb-3">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="secenekvitrin_bg_image" >
                                                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                                                    <small>png,  jpg, jpeg</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="in-header-page-main">
                                                                <div class="in-header-page-text">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    <?=$diller['adminpanel-form-text-263']?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group bg-light col-md-12 mb-4 border pb-3 pt-2">
                                                                <label  for="secenekvitrin_bg_durum" class="w-100" ><?=$diller['adminpanel-form-text-253']?></label>
                                                                <div class="custom-control custom-switch custom-switch-lg">
                                                                    <input type="hidden" name="secenekvitrin_bg_durum" value="0"">
                                                                    <input type="checkbox" class="custom-control-input" id="secenekvitrin_bg_durum" name="secenekvitrin_bg_durum" value="1"  <?php if($detay['secenekvitrin_bg_durum'] == '1'  ) { ?>checked<?php }?> ">
                                                                    <label class="custom-control-label" for="secenekvitrin_bg_durum"></label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group bg-light col-md-12 mb-4 border pb-3 pt-2">
                                                                <label  for="secenekvitrin_bg_dark" class="w-100" ><?=$diller['adminpanel-form-text-252']?></label>
                                                                <div class="custom-control custom-switch custom-switch-lg">
                                                                    <input type="hidden" name="secenekvitrin_bg_dark" value="0"">
                                                                    <input type="checkbox" class="custom-control-input" id="secenekvitrin_bg_dark" name="secenekvitrin_bg_dark" value="1"  <?php if($detay['secenekvitrin_bg_dark'] == '1'  ) { ?>checked<?php }?> ">
                                                                    <label class="custom-control-label" for="secenekvitrin_bg_dark"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div id="1" class="select_option w-100 ">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="form-group col-md-12">
                                                            <label for="secenekvitrin_bg_color"><?=$diller['adminpanel-form-text-254']?></label>
                                                            <div data-color-format="default" data-color="#<?=$detay['secenekvitrin_bg_color']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="secenekvitrin_bg_color"  value="" class="form-control">
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
                        <!--  <========SON=========>>> Arkaplan Ayarları  SON !-->

                        <!-- sortable Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#detailAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-389']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="detailAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=tab_showcase_sort" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label  for="secenekvitrin_aktif_tab" class="w-100">* <?=$diller['adminpanel-form-text-414']?></label>
                                                    <select name="secenekvitrin_aktif_tab" class="form-control" id="secenekvitrin_aktif_tab" required>
                                                        <option <?php if($detay['secenekvitrin_yeni_urunler'] == '0' ) { ?>disabled<?php }?> value="1" <?php if($detay['secenekvitrin_aktif_tab'] == '1'  ) { ?>selected<?php }?>><?php if($detay['secenekvitrin_yeni_urunler'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-413']?></option>
                                                        <option <?php if($detay['secenekvitrin_populer_urunler'] == '0' ) { ?>disabled<?php }?> value="2" <?php if($detay['secenekvitrin_aktif_tab'] == '2'  ) { ?>selected<?php }?>><?php if($detay['secenekvitrin_populer_urunler'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-415']?></option>
                                                        <option <?php if($detay['secenekvitrin_indirimli_urunler'] == '0' ) { ?>disabled<?php }?> value="3" <?php if($detay['secenekvitrin_aktif_tab'] == '3'  ) { ?>selected<?php }?>><?php if($detay['secenekvitrin_indirimli_urunler'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-416']?></option>
                                                        <option <?php if($detay['secenekvitrin_firsat_urunleri'] == '0' ) { ?>disabled<?php }?> value="4" <?php if($detay['secenekvitrin_aktif_tab'] == '4'  ) { ?>selected<?php }?>><?php if($detay['secenekvitrin_firsat_urunleri'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-417']?></option>
                                                        <option <?php if($detay['secenekvitrin_editor_urunleri'] == '0' ) { ?>disabled<?php }?> value="5" <?php if($detay['secenekvitrin_aktif_tab'] == '5'  ) { ?>selected<?php }?>><?php if($detay['secenekvitrin_editor_urunleri'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-418']?></option>
                                                        <option <?php if($detay['secenekvitrin_bedavakargo_urunleri'] == '0' ) { ?>disabled<?php }?> value="5" <?php if($detay['secenekvitrin_aktif_tab'] == '6'  ) { ?>selected<?php }?>><?php if($detay['secenekvitrin_bedavakargo_urunleri'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-419']?></option>
                                                        <option <?php if($detay['secenekvitrin_hizlikargo_urunleri'] == '0' ) { ?>disabled<?php }?> value="5" <?php if($detay['secenekvitrin_aktif_tab'] == '7'  ) { ?>selected<?php }?>><?php if($detay['secenekvitrin_hizlikargo_urunleri'] == '0' ) { ?>----- <?=$diller['adminpanel-form-text-339']?> - <?php }?><?=$diller['adminpanel-form-text-420']?></option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="secenekvitrin_yeni_urunler" class="w-100" ><?=$diller['adminpanel-form-text-413']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="secenekvitrin_yeni_urunler" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="secenekvitrin_yeni_urunler" name="secenekvitrin_yeni_urunler" value="1"  <?php if($detay['secenekvitrin_yeni_urunler'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="secenekvitrin_yeni_urunler"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="secenekvitrin_populer_urunler" class="w-100" ><?=$diller['adminpanel-form-text-415']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="secenekvitrin_populer_urunler" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="secenekvitrin_populer_urunler" name="secenekvitrin_populer_urunler" value="1"  <?php if($detay['secenekvitrin_populer_urunler'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="secenekvitrin_populer_urunler"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="secenekvitrin_indirimli_urunler" class="w-100" ><?=$diller['adminpanel-form-text-416']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="secenekvitrin_indirimli_urunler" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="secenekvitrin_indirimli_urunler" name="secenekvitrin_indirimli_urunler" value="1"  <?php if($detay['secenekvitrin_indirimli_urunler'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="secenekvitrin_indirimli_urunler"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="secenekvitrin_firsat_urunleri" class="w-100" ><?=$diller['adminpanel-form-text-417']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="secenekvitrin_firsat_urunleri" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="secenekvitrin_firsat_urunleri" name="secenekvitrin_firsat_urunleri" value="1"  <?php if($detay['secenekvitrin_firsat_urunleri'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="secenekvitrin_firsat_urunleri"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="secenekvitrin_editor_urunleri" class="w-100" ><?=$diller['adminpanel-form-text-418']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="secenekvitrin_editor_urunleri" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="secenekvitrin_editor_urunleri" name="secenekvitrin_editor_urunleri" value="1"  <?php if($detay['secenekvitrin_editor_urunleri'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="secenekvitrin_editor_urunleri"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="secenekvitrin_bedavakargo_urunleri" class="w-100" ><?=$diller['adminpanel-form-text-419']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="secenekvitrin_bedavakargo_urunleri" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="secenekvitrin_bedavakargo_urunleri" name="secenekvitrin_bedavakargo_urunleri" value="1"  <?php if($detay['secenekvitrin_bedavakargo_urunleri'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="secenekvitrin_bedavakargo_urunleri"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="secenekvitrin_hizlikargo_urunleri" class="w-100" ><?=$diller['adminpanel-form-text-420']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="secenekvitrin_hizlikargo_urunleri" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="secenekvitrin_hizlikargo_urunleri" name="secenekvitrin_hizlikargo_urunleri" value="1"  <?php if($detay['secenekvitrin_hizlikargo_urunleri'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="secenekvitrin_hizlikargo_urunleri"></label>
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
                        <!--  <========SON=========>>> sortable  Ayarları  SON !-->



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
        $('#detailAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#detailAcc').offset().top - 80 },
                500);
        });
        $('#bgAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#bgAcc').offset().top - 80 },
                500);
        });
    });

    $('#select_box').change(function () {
        var select = $(this).find(':selected').val();
        $(".select_option").hide();
        $('#' + select).show();
    }).change();

</script><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) {?>
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
<?php if($_SESSION['collepse_status'] == 'detailAcc'  ) {?>
    <script>
        $('#detailAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#detailAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'bgAcc'  ) {?>
    <script>
        $('#bgAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#bgAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>