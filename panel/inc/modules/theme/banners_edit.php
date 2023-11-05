<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'countdown';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from page_header where id=:id ");
$sayfaSorgu->execute(array(
        'id' => $_GET['no'],
));
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
if($sayfaSorgu->rowCount()>'0'  ) {

}else{
    header('Location:pages.php?page=theme_banners');
    die;
}

?>
<title><?=$diller['adminpanel-text-319']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_banners"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-111']?></a>
                                <a href="pages.php?page=theme_banner_edit&no=<?=$_GET['no']?>"><i class="fa fa-angle-right"></i> <?=$detay['page_baslik']?> <?=$diller['adminpanel-text-320']?></a>
                            </div>
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
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?> " type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-140']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'bgAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#bgAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-519']?>
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
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?> " type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-140']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'bgAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#bgAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-519']?>
                            </button>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Mobile SON !-->

                <!-- Contents !-->
                <div class="col-md-9">
                    <div class="w-100 bg-light shadow-sm text-dark rounded p-4 d-flex align-items-center justify-content-between flex-wrap mb-3">
                        <h5><?=$detay['page_baslik']?> <?=$diller['adminpanel-text-320']?></h5>
                        <a href="pages.php?page=theme_banners" class="btn btn-outline-dark"><?=$diller['adminpanel-text-138']?></a>
                    </div>
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
                                        <form action="post.php?process=theme_banner_post&status=banner_edit" method="post">
                                            <input type="hidden" name="banner_id" value="<?=$detay['id']?>">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-62']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="durum" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  <?php if($detay['durum'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="durum"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="baslik_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="baslik_font" class="form-control" id="baslik_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['baslik_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                    <label  for="tip" class="w-100"><?=$diller['adminpanel-text-321']?></label>
                                                    <select name="tip" class="form-control" id="tip" >
                                                        <option value="0" <?php if($detay['tip'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-text-323']?></option>
                                                        <option value="1" <?php if($detay['tip'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-text-322']?></option>
                                                    </select>
                                                </div>

                                                <div id="myself-choise" class="form-group mt-n3 pl-3 pr-3 w-100" <?php if($detay['tip'] == '1'  ) { ?>style="display:none"<?php }?>>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <div class="bg-light border rounded p-3">
                                                                <select name="area" class="form-control" >
                                                                    <option value="left" <?php if($detay['area'] == 'left'  ) { ?>selected<?php }?>><?=$diller['adminpanel-text-324']?></option>
                                                                    <option value="center" <?php if($detay['area'] == 'center'  ) { ?>selected<?php }?>><?=$diller['adminpanel-text-325']?></option>
                                                                    <option value="right" <?php if($detay['area'] == 'right'  ) { ?>selected<?php }?>><?=$diller['adminpanel-text-326']?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-3" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-444']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="baslik_color"><?=$diller['adminpanel-form-text-322']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['baslik_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="baslik_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="font_size" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-445']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-449']?>"></i></label>
                                                    <select name="font_size" class="form-control" id="font_size" required>
                                                        <option value="20" <?php if($detay['font_size'] == '20' ) { ?>selected<?php }?>>20px</option>
                                                        <option value="24" <?php if($detay['font_size'] == '24' ) { ?>selected<?php }?>>24px</option>
                                                        <option value="28" <?php if($detay['font_size'] == '28' ) { ?>selected<?php }?>>28px</option>
                                                        <option value="36" <?php if($detay['font_size'] == '36' ) { ?>selected<?php }?>>36px</option>
                                                        <option value="40" <?php if($detay['font_size'] == '40' ) { ?>selected<?php }?>>40px</option>
                                                        <option value="48" <?php if($detay['font_size'] == '48' ) { ?>selected<?php }?>>48px</option>
                                                        <option value="55" <?php if($detay['font_size'] == '55' ) { ?>selected<?php }?>>55px</option>
                                                        <option value="62" <?php if($detay['font_size'] == '62' ) { ?>selected<?php }?>>62px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="baslik_space" class="w-100"><?=$diller['adminpanel-form-text-435']?></label>
                                                    <select name="baslik_space" class="form-control" id="baslik_space" >
                                                        <option value="" <?php if($detay['baslik_space'] == ''  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-401']?></option>
                                                        <option value="lspac" <?php if($detay['baslik_space'] == 'lspac'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-398']?></option>
                                                        <option value="lspacsmall" <?php if($detay['baslik_space'] == 'lspacsmall'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-399']?></option>
                                                        <option value="lspacsmall_2" <?php if($detay['baslik_space'] == 'lspacsmall_2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-400']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="font_weight"><?=$diller['adminpanel-form-text-446']?></label>
                                                    <select name="font_weight" class="form-control" id="font_weight" required>
                                                        <option value="300" <?php if($detay['font_weight'] == '300' ) { ?>selected<?php }?>>300</option>
                                                        <option value="400" <?php if($detay['font_weight'] == '400' ) { ?>selected<?php }?>>400</option>
                                                        <option value="500" <?php if($detay['font_weight'] == '500' ) { ?>selected<?php }?>>500</option>
                                                        <option value="600" <?php if($detay['font_weight'] == '600' ) { ?>selected<?php }?>>600</option>
                                                        <option value="700" <?php if($detay['font_weight'] == '700' ) { ?>selected<?php }?>>700</option>
                                                        <option value="800" <?php if($detay['font_weight'] == '800' ) { ?>selected<?php }?>>800</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="spot_color"><?=$diller['adminpanel-form-text-447']?></label>
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
                                                    <label for="spot_font_size"><?=$diller['adminpanel-form-text-448']?></label>
                                                    <select name="spot_font_size" class="form-control" id="spot_font_size" required>
                                                        <option value="12" <?php if($detay['spot_font_size'] == '12' ) { ?>selected<?php }?>>12px</option>
                                                        <option value="13" <?php if($detay['spot_font_size'] == '13' ) { ?>selected<?php }?>>13px</option>
                                                        <option value="14" <?php if($detay['spot_font_size'] == '14' ) { ?>selected<?php }?>>14px</option>
                                                        <option value="15" <?php if($detay['spot_font_size'] == '15' ) { ?>selected<?php }?>>15px</option>
                                                        <option value="16" <?php if($detay['spot_font_size'] == '16' ) { ?>selected<?php }?>>16px</option>
                                                        <option value="18" <?php if($detay['spot_font_size'] == '18' ) { ?>selected<?php }?>>18px</option>
                                                        <option value="20" <?php if($detay['spot_font_size'] == '20' ) { ?>selected<?php }?>>20px</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-450']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="margin_top"><?=$diller['adminpanel-form-text-453']?></label>
                                                    <input type="number" name="margin_top" value="<?=$detay['margin_top']?>" id="margin_top" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="margin_bottom"><?=$diller['adminpanel-form-text-454']?></label>
                                                    <input type="number" name="margin_bottom" value="<?=$detay['margin_bottom']?>" id="margin_bottom" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="padding_top"><?=$diller['adminpanel-form-text-451']?></label>
                                                    <input type="number" name="padding_top" value="<?=$detay['padding_top']?>" id="padding_top" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="padding_bottom"><?=$diller['adminpanel-form-text-452']?></label>
                                                    <input type="number" name="padding_bottom" value="<?=$detay['padding_bottom']?>" id="padding_bottom" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="border_top"><?=$diller['adminpanel-form-text-455']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['border_top']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="border_top"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="border_bottom"><?=$diller['adminpanel-form-text-456']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['border_bottom']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="border_bottom"  value="" class="form-control">
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

                        <!-- Arkaplan Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#bgAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-519']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="bgAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_banner_post&status=bg_image_update" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="banner_id" value="<?=$detay['id']?>">
                                            <div class="row">
                                                <div class="form-group col-md-12 ">
                                                    <select name="bg_tip" class="form-control"  id="select_box" required>
                                                        <option value="0" <?php if($detay['bg_tip'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-251']?></option>
                                                        <option value="1" <?php if($detay['bg_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-250']?></option>
                                                    </select>
                                                </div>
                                                <div  id="0" class="select_option form-group pl-3 pr-3 w-100">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="inputGroupFile01"><?=$diller['adminpanel-form-text-255']?></label>
                                                            <div class="w-100 bg-light   p-3 text-center mb-3 ">
                                                                <?php if($detay['bg_image'] == !null  ) {?>
                                                                    <small class="text-dark">
                                                                        <?=$diller['adminpanel-form-text-107']?>
                                                                    </small>
                                                                    <br><br>
                                                                    <img src="<?=$ayar['site_url']?>images/uploads/<?=$detay['bg_image']?>" class="img-fluid" >
                                                                    <small>
                                                                        <br><br>
                                                                        <?=$diller['adminpanel-form-text-89']?> : 1920x1080
                                                                    </small>
                                                                    <br><br>
                                                                    <a href="" data-href="post.php?process=theme_banner_post&status=bg_image_delete&no=<?=$detay['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                                <?php }else{ ?>
                                                                    <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                                    <small>
                                                                        <br><br>
                                                                        <?=$diller['adminpanel-form-text-89']?> : 1920x1080
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                            <div class="w-100">
                                                                <input type="hidden" name="old_bg" value="<?=$detay['bg_image']?>" >
                                                                <div class="input-group mb-3">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="bg_image" >
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
                                                                    <?=$diller['adminpanel-form-text-263']?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group bg-light col-md-12 mb-4 border pb-3 pt-2">
                                                                <label  for="bg_durum" class="w-100" ><?=$diller['adminpanel-form-text-253']?></label>
                                                                <div class="custom-control custom-switch custom-switch-lg">
                                                                    <input type="hidden" name="bg_durum" value="0"">
                                                                    <input type="checkbox" class="custom-control-input" id="bg_durum" name="bg_durum" value="1"  <?php if($detay['bg_durum'] == '1'  ) { ?>checked<?php }?> ">
                                                                    <label class="custom-control-label" for="bg_durum"></label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group bg-light col-md-12 mb-4 border pb-3 pt-2">
                                                                <label  for="bg_dark" class="w-100" ><?=$diller['adminpanel-form-text-252']?></label>
                                                                <div class="custom-control custom-switch custom-switch-lg">
                                                                    <input type="hidden" name="bg_dark" value="0"">
                                                                    <input type="checkbox" class="custom-control-input" id="bg_dark" name="bg_dark" value="1"  <?php if($detay['bg_dark'] == '1'  ) { ?>checked<?php }?> ">
                                                                    <label class="custom-control-label" for="bg_dark"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div id="1" class="select_option w-100 ">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="form-group col-md-12">
                                                            <label for="bg_color"><?=$diller['adminpanel-form-text-254']?></label>
                                                            <div data-color-format="default" data-color="#<?=$detay['bg_color']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="bg_color"  value="" class="form-control">
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
<script id="rendered-js" >
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
        $('#bgAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#bgAcc').offset().top - 80 },
                500);
        });
    });
    $('#tip').on('change', function() {
        $('#myself-choise').css('display', 'none');
        if ( $(this).val() === '0' ) {
            $('#myself-choise').css('display', 'block');
        }
    });

    $('#select_box').change(function () {
        var select = $(this).find(':selected').val();
        $(".select_option").hide();
        $('#' + select).show();
    }).change();


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