<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'probanner';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from vitrin_tip1_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-text-300']?> - <?=$panelayar['baslik']?></title>
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
                            <?php if($yetki['modul'] == '1' && $yetki['modul_vitrin'] == '1' ) {?>
                                <a href="pages.php?page=showcase_bannerproduct"  class="btn btn-primary" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-text-329']?></a>
                            <?php } ?>
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
                                    <div class="font-20 w-100 pt-3 pb-3 font-weight-bold">
                                        <?=$diller['adminpanel-text-300']?>
                                    </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=probanner_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label  for="font" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="font" class="form-control" id="font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="arkaplan"><?=$diller['adminpanel-form-text-386']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="border_color"><?=$diller['adminpanel-form-text-384']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['border_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="border_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="baslik_renk"><?=$diller['adminpanel-form-text-322']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['baslik_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="baslik_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="spot_renk"><?=$diller['adminpanel-form-text-324']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['spot_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="spot_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="urun_limit"><?=$diller['adminpanel-form-text-395']?></label>
                                                    <input type="number" name="urun_limit" value="<?=$detay['urun_limit']?>" id="urun_limit" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label  for="vitrin_grid" class="w-100">* <?=$diller['adminpanel-form-text-390']?></label>
                                                    <select name="vitrin_grid" class="form-control" id="vitrin_grid" required>
                                                        <option value="3" <?php if($detay['vitrin_grid'] == '3'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-394']?></option>
                                                        <option value="4" <?php if($detay['vitrin_grid'] == '4'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-391']?></option>
                                                        <option value="5" <?php if($detay['vitrin_grid'] == '5'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-392']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="gorsel_radius"><?=$diller['adminpanel-form-text-421']?></label>
                                                    <input type="text" name="gorsel_radius" value="<?=$detay['gorsel_radius']?>" id="gorsel_radius" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="gorsel_zoom" class="w-100"><?=$diller['adminpanel-form-text-422']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="gorsel_zoom" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="gorsel_zoom" name="gorsel_zoom" value="1" <?php if($detay['gorsel_zoom'] != '0'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="gorsel_zoom"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="gorsel_blur" class="w-100"><?=$diller['adminpanel-form-text-423']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="gorsel_blur" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="gorsel_blur" name="gorsel_blur" value="1" <?php if($detay['gorsel_blur'] != '0'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="gorsel_blur"></label>
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