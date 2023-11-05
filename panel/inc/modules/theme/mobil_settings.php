<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'mobileheader';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();

$mobilTema = $db->prepare("select * from mobiltema where id=:id ");
$mobilTema->execute(array(
        'id' => '1'
));
$headayar = $mobilTema->fetch(PDO::FETCH_ASSOC);


$headerAyarCek = $db->prepare("select header_mobil_logo,header_bg from header_ayar where id=:id ");
$headerAyarCek->execute(array(
    'id' => '1'
));
$logorow = $headerAyarCek->fetch(PDO::FETCH_ASSOC);
?>

<title><?=$diller['adminpanel-menu-text-184']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_mobil_settings"> <i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-184']?></a>
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
                                <?=$diller['adminpanel-form-text-1377']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'menuAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#menuAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-1987']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'logoAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-134']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'fixedAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#fixedAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-1989']?>
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
                                <?=$diller['adminpanel-form-text-1377']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'menuAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#menuAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-1987']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'logoAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-134']?>
                            </button>
                            <button class="btn btn-lg card btn-block text-left pt-3 pb-3  mb-0 mt-0 <?php if($_SESSION['collepse_status'] == 'fixedAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#fixedAcc" aria-expanded="false" aria-controls="collapseForm">
                                <?=$diller['adminpanel-form-text-1989']?>
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
                                        <?=$diller['adminpanel-form-text-1377']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100  border-top pt-3">
                                        <form action="post.php?process=theme_mobil_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="col-md-12 form-group">
                                                    <div class="alert-warning text-dark w-100 border border-warning p-3">
                                                        <?=$diller['adminpanel-form-text-1990']?>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="bar_area"><i class="fa fa-bars"></i> <?=$diller['adminpanel-form-text-1991']?></label>
                                                    <select name="bar_area" class="form-control" id="bar_area" required>
                                                        <option value="1" <?php if($headayar['bar_area'] == '1') { ?>selected<?php }?>><?=$diller['adminpanel-form-text-208']?></option>
                                                        <option value="2" <?php if($headayar['bar_area'] == '2') { ?>selected<?php }?>><?=$diller['adminpanel-form-text-210']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="bar_bg"><?=$diller['adminpanel-form-text-1993']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['bar_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="bar_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="bar_color"><?=$diller['adminpanel-form-text-1994']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['bar_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="bar_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="bar_border"><?=$diller['adminpanel-form-text-1995']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['bar_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="bar_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="round" class="w-100"><?=$diller['adminpanel-form-text-1992']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="round" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="round" name="round" value="1" <?php if($headayar['round'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="round"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="ara_home" class="w-100"><?=$diller['adminpanel-form-text-1996']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="ara_home" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="ara_home" name="ara_home" value="1" <?php if($headayar['ara_home'] == '1'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="ara_home"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="alt_border"><?=$diller['adminpanel-form-text-1997']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['alt_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="alt_border"  value="" class="form-control">
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

                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#menuAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-1987']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse " id="menuAcc" data-parent="#accordion">
                                    <div class="w-100  border-top pt-3">
                                        <form action="post.php?process=theme_mobil_post&status=menu_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="op_menu_bg"><?=$diller['adminpanel-form-text-1998']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['op_menu_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="op_menu_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="op_menu_text"><?=$diller['adminpanel-form-text-1999']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['op_menu_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="op_menu_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="op_menu_hover"><?=$diller['adminpanel-form-text-2000']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['op_menu_hover']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="op_menu_hover"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="op_menu_hover_text"><?=$diller['adminpanel-form-text-2001']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['op_menu_hover_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="op_menu_hover_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="op_menu_border"><?=$diller['adminpanel-form-text-2002']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['op_menu_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="op_menu_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="kapat_bg"><?=$diller['adminpanel-form-text-2006']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['kapat_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kapat_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="kapat_renk"><?=$diller['adminpanel-form-text-2007']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['kapat_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kapat_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cagri_bg"><?=$diller['adminpanel-form-text-2008']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['cagri_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="cagri_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cagri_text"><?=$diller['adminpanel-form-text-2009']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['cagri_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="cagri_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="cagri_border"><?=$diller['adminpanel-form-text-2010']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['cagri_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="cagri_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="ara" class="w-100"><?=$diller['adminpanel-form-text-1996']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="ara" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="ara" name="ara" value="1" <?php if($headayar['ara'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                        <label class="custom-control-label" for="ara"></label>
                                                    </div>
                                                </div>
                                                <div id="actionBox" class="col-md-12 mb-4" <?php if($headayar['ara'] != '1'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="border bg-light rounded p-3 up-arrow-2">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="ara_bg"><?=$diller['adminpanel-form-text-2003']?></label>
                                                                <div data-color-format="default" data-color="#<?=$headayar['ara_bg']?>"  class="colorpicker-default input-group">
                                                                    <input type="text" name="ara_bg"  value="" class="form-control">
                                                                    <div class="input-group-append add-on">
                                                                        <button class="btn btn-light border" type="button">
                                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="ara_text"><?=$diller['adminpanel-form-text-2004']?></label>
                                                                <div data-color-format="default" data-color="#<?=$headayar['ara_text']?>"  class="colorpicker-default input-group">
                                                                    <input type="text" name="ara_text"  value="" class="form-control">
                                                                    <div class="input-group-append add-on">
                                                                        <button class="btn btn-light border" type="button">
                                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="ara_border"><?=$diller['adminpanel-form-text-2005']?></label>
                                                                <div data-color-format="default" data-color="#<?=$headayar['ara_border']?>"  class="colorpicker-default input-group">
                                                                    <input type="text" name="ara_border"  value="" class="form-control">
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
                                                <script id="rendered-js" >
                                                    function actionBox(selected)
                                                    {
                                                        if (selected)
                                                        {
                                                            document.getElementById("actionBox").style.display = "";
                                                        } else

                                                        {
                                                            document.getElementById("actionBox").style.display = "none";
                                                        }

                                                    }
                                                </script>

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

                        <!-- Logo Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#logoAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-134']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse " id="logoAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card border">
                                                        <div class="card-body">
                                                            <div class="w-100 p-3 text-center mb-2" style="background-color: #<?=$logorow['header_bg']?>;">
                                                                <?php if($logorow['header_mobil_logo'] == !null  ) {?>
                                                                    <small class="text-dark bg-white p-1">
                                                                        <?=$diller['adminpanel-text-151']?>
                                                                    </small>
                                                                    <br><br>
                                                                    <img src="<?=$ayar['site_url']?>images/logo/<?=$logorow['header_mobil_logo']?>" class="img-fluid" >
                                                                    <br><br>
                                                                    <small class="bg-white p-1">
                                                                        <?=$diller['adminpanel-form-text-89']?> : 110x30
                                                                    </small>
                                                                <?php }else{ ?>
                                                                    <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                                    <br><br>
                                                                    <small class="bg-white p-1">
                                                                        <?=$diller['adminpanel-form-text-89']?> : 110x30
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                            <div class="w-100 border-top pt-2 ">
                                                                <form action="post.php?process=theme_mobil_post&status=header_mobillogo_update" method="post" enctype="multipart/form-data">
                                                                    <input type="hidden" name="old_logo" value="<?=$logorow['header_mobil_logo']?>" >
                                                                    <div class="input-group mb-3">
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="header_mobil_logo" >
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

                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#fixedAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-1989']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="fixedAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_mobil_post&status=fixed_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="sabit" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sabit" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sabit" name="sabit" value="1"  <?php if($headayar['sabit'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sabit"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="uye_giris" class="w-100" ><?=$diller['adminpanel-form-text-2011']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="uye_giris" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="uye_giris" name="uye_giris" value="1"  <?php if($headayar['uye_giris'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="uye_giris"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sepet" class="w-100" ><?=$diller['adminpanel-form-text-2013']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sepet" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sepet" name="sepet" value="1"  <?php if($headayar['sepet'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sepet"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="favori" class="w-100" ><?=$diller['adminpanel-form-text-2012']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="favori" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="favori" name="favori" value="1"  <?php if($headayar['favori'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="favori"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sabit_bg"><?=$diller['adminpanel-form-text-1993']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['sabit_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sabit_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sabit_text"><?=$diller['adminpanel-form-text-2014']?></label>
                                                    <div data-color-format="default" data-color="#<?=$headayar['sabit_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sabit_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sabit_golge" class="w-100" ><?=$diller['adminpanel-form-text-2015']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sabit_golge" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sabit_golge" name="sabit_golge" value="1"  <?php if($headayar['sabit_golge'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sabit_golge"></label>
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
        $('#fixedAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#fixedAcc').offset().top - 80 },
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
<?php if($_SESSION['collepse_status'] == 'fixedAcc'  ) {?>
    <script>
        $('#fixedAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#fixedAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>