<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'footer';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();

$footerAyarCek = $db->prepare("select * from footer_ayar where id=:id ");
$footerAyarCek->execute(array(
        'id' => '1'
));
$footerayar = $footerAyarCek->fetch(PDO::FETCH_ASSOC);


$telifCek = $db->prepare("select * from footer_telif where dil=:dil order by id desc limit 1 ");
$telifCek->execute(array(
        'dil' => $_SESSION['dil'],
));
$telif = $telifCek->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-101']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_footer_settings"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-101']?></a>
                            </div>
                        </div>
                        <div class="col-md-auto mr-3" >
                            <?php if($yetki['modul'] == '1' && $yetki['modul_header_footer'] == '1' ) {?>
                                <div class="mt-2 d-md-none d-sm-block"></div>
                                <a href="pages.php?page=footer_links"  class="btn btn-primary" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-text-276']?></a>
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
                                <?=$diller['adminpanel-text-277']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'bgAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#bgAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-287']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'copyrightAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#copyrightAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-278']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'logoAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-279']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'extraImgAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#extraImgAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-280']?>
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
                                <?=$diller['adminpanel-text-277']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'bgAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#bgAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-287']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'copyrightAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#copyrightAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-278']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'logoAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-279']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'extraImgAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#extraImgAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-text-280']?>
                            </button>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Mobile SON !-->
                <!--  <========SON=========>>> Nav Menu SON !-->

                <!-- Contents !-->
                <div class="col-md-6">

                    <div id="accordion" class="accordion">
                        <!-- Düzen Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-277']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_footer_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-4">
                                                    <label for="margin">* <?=$diller['adminpanel-form-text-243']?></label>
                                                    <input type="number" name="margin" value="<?=$footerayar['margin']?>" id="margin" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label for="padding">* <?=$diller['adminpanel-form-text-130']?></label>
                                                    <input type="number" name="padding" value="<?=$footerayar['padding']?>" id="padding" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="baslik_font" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="baslik_font" class="form-control" id="baslik_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $footerayar['baslik_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="sosyal" class="w-100" ><?=$diller['adminpanel-form-text-79']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sosyal" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sosyal" name="sosyal" value="1"  <?php if($footerayar['sosyal'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sosyal"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="ana_renk"><?=$diller['adminpanel-form-text-245']?></label>
                                                    <div data-color-format="default" data-color="#<?=$footerayar['ana_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="ana_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="alt_renk"><?=$diller['adminpanel-form-text-246']?></label>
                                                    <div data-color-format="default" data-color="#<?=$footerayar['alt_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="alt_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="footer_border"><?=$diller['adminpanel-form-text-248']?></label>
                                                    <div data-color-format="default" data-color="#<?=$footerayar['footer_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="footer_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" style="margin-bottom: 20px;">
                                                <div class="in-header-page-text">
                                                   <?=$diller['adminpanel-form-text-257']?>
                                                </div>
                                            </div>
                                            <div class="w-100 bg-light p-2 mb-2">
                                                <?=$diller['adminpanel-form-text-261']?>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <textarea name="footer_html" id="tiny"  ><?=$footerayar['footer_html']?></textarea>
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
                                        <?=$diller['adminpanel-text-287']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="bgAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_footer_post&status=bg_update" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="form-group col-md-12 ">
                                                    <select name="bg_tip" class="form-control"  id="select_box" required>
                                                        <option value="0" <?php if($footerayar['bg_tip'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-251']?></option>
                                                        <option value="1" <?php if($footerayar['bg_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-250']?></option>
                                                    </select>
                                                </div>
                                                <div  id="0" class="select_option form-group pl-3 pr-3 w-100">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="inputGroupFile01"><?=$diller['adminpanel-form-text-255']?></label>
                                                            <div class="w-100 bg-light   p-3 text-center mb-3 ">
                                                                <?php if($footerayar['bg_image'] == !null  ) {?>
                                                                    <small class="text-dark">
                                                                        <?=$diller['adminpanel-form-text-107']?>
                                                                    </small>
                                                                    <br><br>
                                                                    <img src="<?=$ayar['site_url']?>images/uploads/<?=$footerayar['bg_image']?>" class="img-fluid" >
                                                                    <small>
                                                                        <br><br>
                                                                        <?=$diller['adminpanel-form-text-89']?> : 1920x1080
                                                                    </small>
                                                                    <br><br>
                                                                    <a href="" data-href="post.php?process=theme_footer_post&status=bg_img_delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                                <?php }else{ ?>
                                                                    <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                                    <small>
                                                                        <br><br>
                                                                        <?=$diller['adminpanel-form-text-89']?> : 1920x1080
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                            <div class="w-100">
                                                                <input type="hidden" name="old_bg" value="<?=$footerayar['bg_image']?>" >
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
                                                                    <input type="checkbox" class="custom-control-input" id="bg_durum" name="bg_durum" value="1"  <?php if($footerayar['bg_durum'] == '1'  ) { ?>checked<?php }?> ">
                                                                    <label class="custom-control-label" for="bg_durum"></label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group bg-light col-md-12 mb-4 border pb-3 pt-2">
                                                                <label  for="bg_dark" class="w-100" ><?=$diller['adminpanel-form-text-252']?></label>
                                                                <div class="custom-control custom-switch custom-switch-lg">
                                                                    <input type="hidden" name="bg_dark" value="0"">
                                                                    <input type="checkbox" class="custom-control-input" id="bg_dark" name="bg_dark" value="1"  <?php if($footerayar['bg_dark'] == '1'  ) { ?>checked<?php }?> ">
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
                                                            <div data-color-format="default" data-color="#<?=$footerayar['bg_color']?>"  class="colorpicker-default input-group">
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


                        <!-- Telif İçeriği Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#copyrightAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-278']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="copyrightAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <?php if($telifCek->rowCount()<='0'  ) {?>
                                            <form action="post.php?process=theme_footer_post&status=copyright" method="post">
                                                <input type="hidden" name="durum" value="0">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="telif_text" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                            <div>
                                                               * <?=$diller['adminpanel-form-text-258']?>
                                                            </div>
                                                            <div class="ml-4 bg-light p-1 border">
                                                                <div class="flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div> <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                            </div>
                                                        </label>
                                                        <div class="w-100 p-1 pl-2 pr-2 bg-danger text-white mb-2 rounded border border-danger">
                                                           <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-244']?>
                                                        </div>
                                                        <textarea name="telif_text" id="telif_text" class="form-control" rows="4" ><?=$telif['icerik']?></textarea>
                                                        <div class="bg-light p-2 w-100 text-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['adminpanel-form-text-260']?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group mb-0">
                                                        <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php }else { ?>
                                            <form action="post.php?process=theme_footer_post&status=copyright" method="post">
                                                <input type="hidden" name="durum" value="1">
                                                <input type="hidden" name="copyright_id" value="<?=$telif['id']?>">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="telif_text" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                            <div>
                                                               * <?=$diller['adminpanel-form-text-258']?>
                                                            </div>
                                                            <div class="ml-4 bg-light p-1 border">
                                                                <div class="flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div> <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                            </div>
                                                        </label>
                                                        <textarea name="telif_text" id="telif_text" class="form-control" rows="4" ><?=$telif['icerik']?></textarea>
                                                        <div class="bg-light p-2 w-100 text-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['adminpanel-form-text-260']?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group mb-0">
                                                        <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Telif İçeriği Ayarları  SON !-->


                        <!-- Logo Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-279']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse " id="logoAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card border">
                                                        <div class="card-body">
                                                            <div class="w-100 p-3 text-center mb-2 " style="background-color: #<?=$footerayar['bg_color']?>;">
                                                                <?php if($footerayar['footer_logo'] == !null  ) {?>
                                                                    <small class="text-dark bg-white p-1">
                                                                        <?=$diller['adminpanel-text-151']?>
                                                                    </small>
                                                                    <br><br>
                                                                    <img src="<?=$ayar['site_url']?>images/logo/<?=$footerayar['footer_logo']?>" class="img-fluid" >
                                                                    <br><br>
                                                                    <small class="bg-white p-1">
                                                                        <?=$diller['adminpanel-form-text-89']?> : 190x50
                                                                    </small>
                                                                    <br><br>
                                                                    <a href="" data-href="post.php?process=theme_footer_post&status=footer_logo_delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-286']?></a>
                                                                <?php }else{ ?>
                                                                    <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                                    <br><br>
                                                                    <small class="bg-white p-1">
                                                                        <?=$diller['adminpanel-form-text-89']?> : 190x50
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                            <div class="w-100 border-top pt-2 ">
                                                                <form action="post.php?process=theme_footer_post&status=footer_logo" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="old_logo" value="<?=$footerayar['footer_logo']?>">
                                                                    <div class="input-group mb-3">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="footer_logo" >
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

                        <!-- Ek Görsel Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#extraImgAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-text-280']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse " id="extraImgAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <div class="w-100 bg-light p-2 mb-2">
                                            <?=$diller['adminpanel-form-text-256']?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card border">
                                                    <div class="card-body">
                                                        <div class="w-100 p-3 text-center mb-2 " style="background-color: #<?=$footerayar['bg_color']?>;">
                                                            <?php if($footerayar['gorsel'] == !null  ) {?>
                                                                <small class="text-dark bg-white p-1">
                                                                    <?=$diller['adminpanel-text-151']?>
                                                                </small>
                                                                <br><br>
                                                                <img src="<?=$ayar['site_url']?>images/uploads/<?=$footerayar['gorsel']?>" class="img-fluid" >
                                                                <br><br>
                                                                <a href="" data-href="post.php?process=theme_footer_post&status=footer_img_delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                            <?php }else{ ?>
                                                                <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                            <?php }?>
                                                        </div>
                                                        <div class="w-100 border-top pt-2 ">
                                                            <form action="post.php?process=theme_footer_post&status=footer_img" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="old_img" value="<?=$footerayar['gorsel']?>">
                                                                <div class="input-group mb-3">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel" >
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
                        <!--  <========SON=========>>> Ek Görsel Ayarları  SON !-->

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
        $('#extraImgAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#extraImgAcc').offset().top - 80 },
                500);
        });
        $('#copyrightAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#copyrightAcc').offset().top - 80 },
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
<?php if($_SESSION['collepse_status'] == 'extraImgAcc'  ) {?>
    <script>
        $('#extraImgAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#extraImgAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'copyrightAcc'  ) {?>
    <script>
        $('#copyrightAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#copyrightAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
