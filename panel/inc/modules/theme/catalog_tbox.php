<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'tbox';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from tkutu_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-text-296']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_tbox"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-text-296']?></a>
                            </div>
                        </div>
                        <div class="col-md-auto mr-3" >
                            <div class="mt-2 d-md-none d-sm-block"></div>
                            <a href="pages.php?page=commerce_boxes"  class="btn btn-primary" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-text-349']?></a>
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
                        <!-- Düzen Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 mb-2">
                                    <h4> <?=$diller['adminpanel-text-296']?></h4>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=tbox_main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label  for="tkutu_font" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="tkutu_font" class="form-control" id="tkutu_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['tkutu_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="tkutu_ana_arkaplan"><?=$diller['adminpanel-form-text-386']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['tkutu_ana_arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="tkutu_ana_arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="tkutu_main_border"><?=$diller['adminpanel-form-text-384']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['tkutu_main_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="tkutu_main_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="tkutu_arkaplan"><?=$diller['adminpanel-form-text-264']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['tkutu_arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="tkutu_arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="tkutu_border"><?=$diller['adminpanel-form-text-267']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['tkutu_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="tkutu_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="tkutu_baslik_renk"><?=$diller['adminpanel-form-text-322']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['tkutu_baslik_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="tkutu_baslik_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="tkutu_spot_renk"><?=$diller['adminpanel-form-text-324']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['tkutu_spot_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="tkutu_spot_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="tkutu_icon_renk"><?=$diller['adminpanel-form-text-387']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['tkutu_icon_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="tkutu_icon_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="tkutu_footer" class="w-100"><?=$diller['adminpanel-form-text-388']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="tkutu_footer" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="tkutu_footer" name="tkutu_footer" value="1" <?php if($detay['tkutu_footer'] != '0'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="tkutu_footer"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
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
    function markaCek(selected)
    {
        if (selected)
        {
            document.getElementById("markaCek").style.display = "";
        } else

        {
            document.getElementById("markaCek").style.display = "none";
        }

    }
    function kargoCek(selected)
    {
        if (selected)
        {
            document.getElementById("kargoCek").style.display = "";
        } else

        {
            document.getElementById("kargoCek").style.display = "none";
        }

    }
    function starCek(selected)
    {
        if (selected)
        {
            document.getElementById("starCek").style.display = "";
        } else

        {
            document.getElementById("starCek").style.display = "none";
        }

    }
</script>