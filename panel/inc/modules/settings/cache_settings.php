<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'cache';

$cachesorgu = $db->prepare("select * from cache where id=:id ");
$cachesorgu->execute(array(
        'id' => '1'
));
$caches = $cachesorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-172']?> - <?=$panelayar['baslik']?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">


        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-151']?></a>
                                <a href="pages.php?page=cache_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-172']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_diger'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-6<?php }else{?>col-md-9<?php } ?>">
                    <div class="card p-4">
                        <form method="post" action="post.php?process=cache_post&status=update">

                            <div class="w-100">
                                <div class="w-100 text-left border-bottom mb-3 pb-3">
                                    <h4><?=$diller['adminpanel-menu-text-172']?></h4>
                                    <span class="font-12 "><?=$diller['adminpanel-text-266']?></span>
                                </div>
                            </div>

                            <!-- Butonlar !-->
                            <div class="w-100 mt-4">
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="headermenu" class="w-100" ><?=$diller['adminpanel-form-text-112']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="headermenu" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="headermenu" name="headermenu" value="1"  <?php if($caches['headermenu'] == '1'  ) { ?>checked<?php }?> onclick="headerCache(this.checked);">
                                            <label class="custom-control-label" for="headermenu"></label>
                                        </div>
                                    </div>
                                    <div id="headerCache" class="w-100 col-md-6 mb-4" <?php if($caches['headermenu'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                       <div class="row   pr-3">
                                           <div class="form-group col-md-12 mb-4">
                                               <label for="headermenu_zaman"><?=$diller['adminpanel-form-text-113']?></label>
                                               <input type="number" name="headermenu_zaman" value="<?=$caches['headermenu_zaman']?>" id="headermenu_zaman" class="form-control">
                                           </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="footer" class="w-100" ><?=$diller['adminpanel-form-text-114']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="footer" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="footer" name="footer" value="1"  <?php if($caches['footer'] == '1'  ) { ?>checked<?php }?> onclick="footerCache(this.checked);">
                                            <label class="custom-control-label" for="footer"></label>
                                        </div>
                                    </div>
                                    <div id="footerCache" class="w-100 col-md-6 mb-4" <?php if($caches['footer'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="footer_zaman"><?=$diller['adminpanel-form-text-115']?></label>
                                                <input type="number" name="footer_zaman" value="<?=$caches['footer_zaman']?>" id="footer_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="secenek_vitrin" class="w-100" ><?=$diller['adminpanel-form-text-116']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="secenek_vitrin" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="secenek_vitrin" name="secenek_vitrin" value="1"  <?php if($caches['secenek_vitrin'] == '1'  ) { ?>checked<?php }?> onclick="secenekVitrin(this.checked);">
                                            <label class="custom-control-label" for="secenek_vitrin"></label>
                                        </div>
                                    </div>
                                    <div id="secenekVitrin" class="w-100 col-md-6 mb-4" <?php if($caches['secenek_vitrin'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row   pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="secenek_vitrin_zaman"><?=$diller['adminpanel-form-text-117']?></label>
                                                <input type="number" name="secenek_vitrin_zaman" value="<?=$caches['secenek_vitrin_zaman']?>" id="secenek_vitrin_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="vitrin1" class="w-100" ><?=$diller['adminpanel-form-text-118']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="vitrin1" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="vitrin1" name="vitrin1" value="1"  <?php if($caches['vitrin1'] == '1'  ) { ?>checked<?php }?> onclick="ilkVitrin(this.checked);">
                                            <label class="custom-control-label" for="vitrin1"></label>
                                        </div>
                                    </div>
                                    <div id="ilkVitrin" class="w-100 col-md-6 mb-4" <?php if($caches['vitrin1'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row   pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="vitrin1_zaman"><?=$diller['adminpanel-form-text-119']?></label>
                                                <input type="number" name="vitrin1_zaman" value="<?=$caches['vitrin1_zaman']?>" id="vitrin1_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="resimli_vitrin" class="w-100" ><?=$diller['adminpanel-form-text-120']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="resimli_vitrin" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="resimli_vitrin" name="resimli_vitrin" value="1"  <?php if($caches['resimli_vitrin'] == '1'  ) { ?>checked<?php }?> onclick="rsmVitrin(this.checked);">
                                            <label class="custom-control-label" for="resimli_vitrin"></label>
                                        </div>
                                    </div>
                                    <div id="rsmVitrin" class="w-100 col-md-6 mb-4" <?php if($caches['resimli_vitrin'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row   pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="resimli_vitrin_zaman"><?=$diller['adminpanel-form-text-121']?></label>
                                                <input type="number" name="resimli_vitrin_zaman" value="<?=$caches['resimli_vitrin_zaman']?>" id="resimli_vitrin_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="resimli_vitrin_2" class="w-100" ><?=$diller['adminpanel-form-text-122']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="resimli_vitrin_2" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="resimli_vitrin_2" name="resimli_vitrin_2" value="1"  <?php if($caches['resimli_vitrin_2'] == '1'  ) { ?>checked<?php }?> onclick="rsmVitrin2(this.checked);">
                                            <label class="custom-control-label" for="resimli_vitrin_2"></label>
                                        </div>
                                    </div>
                                    <div id="rsmVitrin2" class="w-100 col-md-6 mb-4" <?php if($caches['resimli_vitrin_2'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row   pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="resimli_vitrin_2_zaman"><?=$diller['adminpanel-form-text-123']?></label>
                                                <input type="number" name="resimli_vitrin_2_zaman" value="<?=$caches['resimli_vitrin_2_zaman']?>" id="resimli_vitrin_2_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="marka" class="w-100" ><?=$diller['adminpanel-form-text-126']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="marka" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="marka" name="marka" value="1"  <?php if($caches['marka'] == '1'  ) { ?>checked<?php }?> onclick="markaVitrin(this.checked);">
                                            <label class="custom-control-label" for="marka"></label>
                                        </div>
                                    </div>
                                    <div id="markaVitrin" class="w-100 col-md-6 mb-4" <?php if($caches['marka'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row   pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="marka_zaman"><?=$diller['adminpanel-form-text-127']?></label>
                                                <input type="number" name="marka_zaman" value="<?=$caches['marka_zaman']?>" id="marka_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="tkutu" class="w-100" ><?=$diller['adminpanel-form-text-124']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="tkutu" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="tkutu" name="tkutu" value="1"  <?php if($caches['tkutu'] == '1'  ) { ?>checked<?php }?> onclick="tKutuVitrin(this.checked);">
                                            <label class="custom-control-label" for="tkutu"></label>
                                        </div>
                                    </div>
                                    <div id="tKutuVitrin" class="w-100 col-md-6 mb-4" <?php if($caches['tkutu'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row   pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="tkutu_zaman"><?=$diller['adminpanel-form-text-125']?></label>
                                                <input type="number" name="tkutu_zaman" value="<?=$caches['tkutu_zaman']?>" id="tkutu_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="slider" class="w-100" ><?=$diller['adminpanel-form-text-1985']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="slider" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="slider" name="slider" value="1"  <?php if($caches['slider'] == '1'  ) { ?>checked<?php }?> onclick="sliderXX(this.checked);">
                                            <label class="custom-control-label" for="slider"></label>
                                        </div>
                                    </div>
                                    <div id="sliderCac" class="w-100 col-md-6 mb-4" <?php if($caches['slider'] != '1'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row   pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="slider_zaman"><?=$diller['adminpanel-form-text-2150']?></label>
                                                <input type="number" name="slider_zaman" value="<?=$caches['slider_zaman']?>" id="slider_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-4">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="slider_orta" class="w-100" ><?=$diller['adminpanel-form-text-2151']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="slider_orta" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="slider_orta" name="slider_orta" value="1"  <?php if($caches['slider_orta'] == '1'  ) { ?>checked<?php }?> onclick="sliderXXX(this.checked);">
                                            <label class="custom-control-label" for="slider_orta"></label>
                                        </div>
                                    </div>
                                    <div id="sliderCac2" class="w-100 col-md-6 mb-4" <?php if($caches['slider'] != '1'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row   pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="slider_orta_zaman"><?=$diller['adminpanel-form-text-2152']?></label>
                                                <input type="number" name="slider_orta_zaman" value="<?=$caches['slider_orta_zaman']?>" id="slider_orta_zaman" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Butonlar SON !-->
                            <div class="w-100  pt-1">
                                <button class="btn btn-success btn-block" name="update">
                                    <?=$diller['adminpanel-form-text-53']?>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
                <!--  <========SON=========>>> Contents SON !-->


                <!-- Logo !-->
                <div class="col-md-3">
                    <div class="card p-4">
                        <div class="in-header-page-main">
                            <div class="in-header-page-text">
                               <?=$diller['adminpanel-text-4']?>
                            </div>
                        </div>
                        <div class="w-100 bg-light  p-2  mb-4 mt-2">
                            <?=$diller['adminpanel-text-267']?>
                        </div>
                        <div class="w-100">
                                <a class="btn btn-danger btn-block" href="post.php?process=cache_clear&cache=trash"><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-268']?></a>
                                <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                </div>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Logo SON !-->



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

<script>
    function sliderXX(selected)
    {
        if (selected)
        {
            document.getElementById("sliderCac").style.display = "";
        } else

        {
            document.getElementById("sliderCac").style.display = "none";
        }

    }
    function sliderXXX(selected)
    {
        if (selected)
        {
            document.getElementById("sliderCac2").style.display = "";
        } else

        {
            document.getElementById("sliderCac2").style.display = "none";
        }

    }
    function headerCache(selected)
    {
        if (selected)
        {
            document.getElementById("headerCache").style.display = "";
        } else

        {
            document.getElementById("headerCache").style.display = "none";
        }

    }
    function footerCache(selected)
    {
        if (selected)
        {
            document.getElementById("footerCache").style.display = "";
        } else

        {
            document.getElementById("footerCache").style.display = "none";
        }

    }
    function secenekVitrin(selected)
    {
        if (selected)
        {
            document.getElementById("secenekVitrin").style.display = "";
        } else

        {
            document.getElementById("secenekVitrin").style.display = "none";
        }

    }
    function ilkVitrin(selected)
    {
        if (selected)
        {
            document.getElementById("ilkVitrin").style.display = "";
        } else

        {
            document.getElementById("ilkVitrin").style.display = "none";
        }

    }
    function rsmVitrin(selected)
    {
        if (selected)
        {
            document.getElementById("rsmVitrin").style.display = "";
        } else

        {
            document.getElementById("rsmVitrin").style.display = "none";
        }

    }
    function rsmVitrin2(selected)
    {
        if (selected)
        {
            document.getElementById("rsmVitrin2").style.display = "";
        } else

        {
            document.getElementById("rsmVitrin2").style.display = "none";
        }

    }
    function markaVitrin(selected)
    {
        if (selected)
        {
            document.getElementById("markaVitrin").style.display = "";
        } else

        {
            document.getElementById("markaVitrin").style.display = "none";
        }

    }
    function tKutuVitrin(selected)
    {
        if (selected)
        {
            document.getElementById("tKutuVitrin").style.display = "";
        } else

        {
            document.getElementById("tKutuVitrin").style.display = "none";
        }

    }
</script>
