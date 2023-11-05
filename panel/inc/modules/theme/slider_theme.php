<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'slider';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$fontlar2 = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar2->execute();
$sayfaSorgu = $db->prepare("select * from slider_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
$detayCek2 = $db->prepare("select * from slider2_ayar where id=:id ");
$detayCek2->execute(array(
    'id' => '1'
));
$detay2 = $detayCek2->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-125']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_slider"> <i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-125']?></a>
                            </div>
                        </div>
                        <div class="col-md-auto mr-3" >
                            <?php if($yetki['modul'] == '1' && $yetki['modul_diger'] == '1' ) {?>
                                <div class="mt-2 d-md-none d-sm-block"></div>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" style="font-size: 13px ; font-weight: 400;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?=$diller['adminpanel-text-329']?>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                        <a class="dropdown-item" href="pages.php?page=top_slider"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-text-330']?></a>
                                        <a class="dropdown-item" href="pages.php?page=middle_slider"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-text-331']?></a>
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

                <!-- Nav Menu !-->
                    <div class="col-md-3 d-none d-md-inline-block" id="sidebarWrap" style="overflow: hidden; position: relative">
                        <div id="sidebar" class="mr-3">
                            <div class="btn-group w-100 d-flex flex-wrap" role="group">
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?>" type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-text-332']?>
                                </button>
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'otherAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#otherAcc" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-text-333']?>
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
                                    <?=$diller['adminpanel-text-332']?>
                                </button>
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'otherAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#otherAcc" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-text-333']?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--  <========SON=========>>> Mobile SON !-->
                <!--  <========SON=========>>> Nav Menu SON !-->

                <!-- Contents !-->
                <div class="col-md-6">

                    <div id="accordion" class="accordion">
                        <!-- Top Slider  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-332']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3 mt-3">
                                        <form action="post.php?process=theme_slider_post&status=top_slider" method="post" >
                                            <div class="row">
											   <div class="form-group col-md-6">
                                                    <label for="arkaplan"><?=$diller['adminpanel-form-text-254']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="margin"><?=$diller['adminpanel-form-text-243']?></label>
                                                    <input type="number" name="margin" value="<?=$detay['margin']?>" id="margin" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="slider_width"><?=$diller['adminpanel-form-text-524']?></label>
                                                    <select name="slider_width" class="form-control" id="slider_width" required>
                                                        <option value="0" <?php if($detay['slider_width'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-10']?> (1920px)</option>
                                                        <option value="1" <?php if($detay['slider_width'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-9']?> (1300px)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="dots_renk" class="w-100 d-flex align-items-center justify-content-between flex-wrap"><?=$diller['adminpanel-form-text-522']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-523']?>"></i></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['dots_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="dots_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="round" class="w-100" ><?=$diller['adminpanel-form-text-538']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="round" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="round" name="round" value="1"  <?php if($detay['round'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="round"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                   <?=$diller['adminpanel-form-text-525']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="height"><?=$diller['adminpanel-form-text-526']?></label>
                                                    <input type="number" name="height" value="<?=$detay['height']?>" id="height" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="mobil_height"><?=$diller['adminpanel-form-text-528']?></label>
                                                    <input type="number" name="mobil_height" value="<?=$detay['mobil_height']?>" id="mobil_height" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-531']?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="form-group col-md-6">
                                                    <label  for="baslik_font" class="w-100"><?=$diller['adminpanel-form-text-529']?></label>
                                                    <select name="baslik_font" class="form-control" id="baslik_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['baslik_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="spot_font" class="w-100"><?=$diller['adminpanel-form-text-530']?></label>
                                                    <select name="spot_font" class="form-control" id="spot_font" >
                                                        <?php foreach ($fontlar2 as $font2) {?>
                                                            <option value="<?=$font2['font_adi']?>" <?php if($font2['font_adi'] == $detay['spot_font'] ) { ?>selected<?php }?>><?=$font2['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="baslik_size"><?=$diller['adminpanel-form-text-532']?></label>
                                                    <select name="baslik_size" class="form-control" id="baslik_size" required>
                                                        <option value="24" <?php if($detay['baslik_size'] == '24' ) { ?>selected<?php }?>>24px</option>
                                                        <option value="30" <?php if($detay['baslik_size'] == '30' ) { ?>selected<?php }?>>30px</option>
                                                        <option value="36" <?php if($detay['baslik_size'] == '36' ) { ?>selected<?php }?>>36px</option>
                                                        <option value="42" <?php if($detay['baslik_size'] == '42' ) { ?>selected<?php }?>>42px</option>
                                                        <option value="50" <?php if($detay['baslik_size'] == '50' ) { ?>selected<?php }?>>50px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="baslik_weight"><?=$diller['adminpanel-form-text-534']?></label>
                                                    <select name="baslik_weight" class="form-control" id="baslik_weight" required>
                                                        <option value="300" <?php if($detay['baslik_weight'] == '300' ) { ?>selected<?php }?>>300</option>
                                                        <option value="400" <?php if($detay['baslik_weight'] == '400' ) { ?>selected<?php }?>>400</option>
                                                        <option value="500" <?php if($detay['baslik_weight'] == '500' ) { ?>selected<?php }?>>500</option>
                                                        <option value="600" <?php if($detay['baslik_weight'] == '600' ) { ?>selected<?php }?>>600</option>
                                                        <option value="700" <?php if($detay['baslik_weight'] == '700' ) { ?>selected<?php }?>>700</option>
                                                        <option value="800" <?php if($detay['baslik_weight'] == '800' ) { ?>selected<?php }?>>800</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="spot_size"><?=$diller['adminpanel-form-text-535']?></label>
                                                    <select name="spot_size" class="form-control" id="spot_size" required>
                                                        <option value="16" <?php if($detay['spot_size'] == '16' ) { ?>selected<?php }?>>16px</option>
                                                        <option value="19" <?php if($detay['spot_size'] == '19' ) { ?>selected<?php }?>>19px</option>
                                                        <option value="24" <?php if($detay['spot_size'] == '24' ) { ?>selected<?php }?>>24px</option>
                                                        <option value="28" <?php if($detay['spot_size'] == '28' ) { ?>selected<?php }?>>28px</option>
                                                        <option value="30" <?php if($detay['spot_size'] == '30' ) { ?>selected<?php }?>>30px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="spot_weight"><?=$diller['adminpanel-form-text-537']?></label>
                                                    <select name="spot_weight" class="form-control" id="spot_weight" required>
                                                        <option value="200" <?php if($detay['spot_weight'] == '200' ) { ?>selected<?php }?>>200</option>
                                                        <option value="300" <?php if($detay['spot_weight'] == '300' ) { ?>selected<?php }?>>300</option>
                                                        <option value="400" <?php if($detay['spot_weight'] == '400' ) { ?>selected<?php }?>>400</option>
                                                        <option value="500" <?php if($detay['spot_weight'] == '500' ) { ?>selected<?php }?>>500</option>
                                                        <option value="600" <?php if($detay['spot_weight'] == '600' ) { ?>selected<?php }?>>600</option>
                                                        <option value="700" <?php if($detay['spot_weight'] == '700' ) { ?>selected<?php }?>>700</option>
                                                        <option value="800" <?php if($detay['spot_weight'] == '800' ) { ?>selected<?php }?>>800</option>
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
                        <!--  <========SON=========>>> Top Slider  SON !-->


                        <!-- Middle Slider  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#otherAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-333']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="otherAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3 mt-3">
                                        <form action="post.php?process=theme_slider_post&status=middle_slider" method="post" >
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="margin2"><?=$diller['adminpanel-form-text-243']?></label>
                                                    <input type="number" name="margin" value="<?=$detay2['margin']?>" id="margin2" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="padding"><?=$diller['adminpanel-form-text-130']?></label>
                                                    <input type="number" name="padding" value="<?=$detay2['padding']?>" id="padding" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="arkaplan"><?=$diller['adminpanel-form-text-386']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay2['arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="border_color"><?=$diller['adminpanel-form-text-384']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay2['border_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="border_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="radius"><?=$diller['adminpanel-form-text-538']?></label>
                                                    <input type="number" name="radius" value="<?=$detay2['radius']?>" id="radius" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-525']?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="height2"><?=$diller['adminpanel-form-text-526']?></label>
                                                    <input type="number" name="height" value="<?=$detay2['height']?>" id="height2" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="mobil_height2"><?=$diller['adminpanel-form-text-528']?></label>
                                                    <input type="number" name="mobil_height" value="<?=$detay2['mobil_height']?>" id="mobil_height2" required class="form-control">
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
                        <!--  <========SON=========>>> Middle Slider  SON !-->

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
        $('#otherAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#otherAcc').offset().top - 80 },
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
<?php if($_SESSION['collepse_status'] == 'otherAcc'  ) {?>
    <script>
        $('#otherAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#otherAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>