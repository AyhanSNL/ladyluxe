<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'site_settings';
?>
<title><?=$diller['adminpanel-menu-text-152']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-152']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_yonet'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-6<?php }else{?>col-md-9<?php } ?>">
                    <div class="card p-4">
                        <form method="post" action="post.php?process=settings_update">
                            <!-- Genel Ayarlar !-->
                            <div class="w-100">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-139']?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label  for="site_url" class="w-100">* <?=$diller['adminpanel-form-text-1']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2']?>"></i></label>
                                    <input type="text" name="site_url" value="<?=$ayar['site_url']?>" id="site_url" required class="form-control ">
                                </div>
                                <div class="form-group">
                                    <label  for="panel_url" class="w-100">* <?=$diller['adminpanel-form-text-3']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2']?>"></i></label>
                                    <input type="text" name="panel_url" value="<?=$ayar['panel_url']?>" id="panel_url" required class="form-control ">
                                </div>
                                <div class="form-group">
                                    <label  for="protokol" class="w-100">* <?=$diller['adminpanel-form-text-1961']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1962']?>"></i></label>
                                    <select name="protokol" class="form-control" id="protokol" required>
                                        <option value="http://" <?php if($ayar['protokol'] == 'http://'  ) { ?>selected<?php }?>>HTTP</option>
                                        <option value="https://" <?php if($ayar['protokol'] == 'https://'  ) { ?>selected<?php }?>>HTTPS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label  for="site_baslik" class="w-100">* <?=$diller['adminpanel-form-text-4']?> </label>
                                    <input type="text" name="site_baslik" value="<?=$ayar['site_baslik']?>" id="site_baslik" required class="form-control ">
                                </div>
                                <div class="form-group">
                                    <label  for="site_tags" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                    <input type="text" name="site_tags" value="<?=$ayar['site_tags']?>" id="site_tags" data-role="tagsinput" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label  for="site_desc" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                    <textarea name="site_desc" id="site_desc" class="form-control" rows="2" ><?=$ayar['site_desc']?></textarea>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Genel Ayarlar SON !-->

                            <!-- Görünüm Ayarları !-->
                            <div class="w-100  mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-140']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="demo_mod" class="w-100 d-flex align-items-center justify-content-start" >
                                            <?=$diller['adminpanel-form-text-2146']?>
                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2147']?>"></i>
                                        </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="demo_mod" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="demo_mod" name="demo_mod" value="1"  <?php if($ayar['demo_mod'] == '1'  ) { ?>checked<?php }?> ">
                                            <label class="custom-control-label" for="demo_mod"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="site_width" class="w-100"><?=$diller['adminpanel-form-text-8']?> </label>
                                        <select name="site_width" class="form-control" id="site_width" >
                                            <option value="0" <?php if($ayar['site_width'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-10']?></option>
                                            <option value="1" <?php if($ayar['site_width'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-9']?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label><?=$diller['adminpanel-form-text-17']?></label>
                                        <div data-color-format="default" data-color="#<?=$ayar['site_bg_color']?>" class="colorpicker-default input-group">
                                            <input type="text" name="site_bg_color"  value="" class="form-control">
                                            <div class="input-group-append add-on">
                                                <button class="btn btn-light border" type="button">
                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="sekme_degistir_yazi" class="w-100"><?=$diller['adminpanel-form-text-11']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-12']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="sekme_degistir_yazi" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="sekme_degistir_yazi" name="sekme_degistir_yazi" value="1" <?php if($ayar['sekme_degistir_yazi'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="sekme_degistir_yazi"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="lazy" class="w-100"><?=$diller['adminpanel-form-text-13']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-14']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="lazy" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="lazy" name="lazy" value="1" <?php if($ayar['lazy'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="lazy"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="site_captcha" class="w-100"><?=$diller['adminpanel-form-text-15']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-16']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="site_captcha" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="site_captcha" name="site_captcha" value="1" <?php if($ayar['site_captcha'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="site_captcha"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="totop" class="w-100"><?=$diller['adminpanel-form-text-18']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-19']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="totop" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="totop"  name="totop" value="1" <?php if($ayar['totop'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="totop"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label><?=$diller['adminpanel-form-text-20']?></label>
                                        <div data-color-format="default" data-color="#<?=$ayar['totop_bg']?>"  class="colorpicker-default input-group">
                                            <input type="text" name="totop_bg"  value="" class="form-control">
                                            <div class="input-group-append add-on">
                                                <button class="btn btn-light border" type="button">
                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label><?=$diller['adminpanel-form-text-21']?></label>
                                        <div data-color-format="default" data-color="#<?=$ayar['totop_icon']?>" class="colorpicker-default input-group">
                                            <input type="text" name="totop_icon"  value="" class="form-control">
                                            <div class="input-group-append add-on">
                                                <button class="btn btn-light border" type="button">
                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="totop_bottom" class="w-100">* <?=$diller['adminpanel-form-text-22']?> </label>
                                        <input type="number" name="totop_bottom" value="<?=$ayar['totop_bottom']?>" id="totop_bottom" required class="form-control ">
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="totop_radius" class="w-100">* <?=$diller['adminpanel-form-text-23']?> </label>
                                        <input type="text" name="totop_radius" value="<?=$ayar['totop_radius']?>" id="totop_radius" required class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Görünüm Ayarları SON !-->

                            <!-- Log İşlemleri !-->
                            <div class="w-100  mt-3">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-252']?>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="login_log" class="w-100"><?=$diller['adminpanel-form-text-56']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-59']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="login_log" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="login_log" name="login_log" value="1" <?php if($ayar['login_log'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="login_log"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="yonetici_log" class="w-100"><?=$diller['adminpanel-form-text-57']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-60']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="yonetici_log" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="yonetici_log" name="yonetici_log" value="1" <?php if($ayar['yonetici_log'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="yonetici_log"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="uye_log" class="w-100"><?=$diller['adminpanel-form-text-58']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-61']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="uye_log" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="uye_log" name="uye_log" value="1" <?php if($ayar['uye_log'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="uye_log"></label>
                                        </div>
                                    </div>


                                </div>
                                <div class="w-100 border-top pt-3">
                                    <button class="btn btn-success btn-block" name="settingsUpdate">
                                        <?=$diller['adminpanel-form-text-53']?>
                                    </button>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Log İşlemleri SON !-->
                        </form>
                    </div>
                </div>
                <!--  <========SON=========>>> Contents SON !-->


                <!-- Favicon !-->

                <div class="col-md-3">
                    <div class="card p-4">
                        
                        <div class="in-header-page-main">
                            <div class="in-header-page-text">
                                <?=$diller['adminpanel-text-141']?>
                            </div>
                        </div>
                        
                        <div class="w-100 bg-light p-3 text-center mb-3 ">

                            <?php if($ayar['site_favicon'] == !null  ) {?>
                                <small><?=$diller['adminpanel-text-142']?></small>
                                <br><br>
                                <img src="<?=$ayar['site_url']?>images/<?=$ayar['site_favicon']?>" style="max-width: 30px">
                                <br><br>
                                <a href="" data-href="post.php?process=favicon_update&favicon=delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-135']?></a>
                            <?php }else { ?>
                                <img class="border rounded" src="<?=$ayar['panel_url']?>assets/images/no-img.jpg" style="max-width: 50px">
                                <br><br>
                                <small class="text-danger"><?=$diller['adminpanel-text-146']?></small>
                            <?php }?>
                        </div>

                        <div class="w-100">
                        <form action="post.php?process=favicon_update&favicon=update" method="post" enctype="multipart/form-data">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="favicon" >
                                    <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-text-143']?></label>
                                </div>
                            </div>
                            <button class="btn btn-success btn-block" name="faviconUpdate"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                            <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                <small>ico,  png,  jpg</small>
                            </div>
                        </form>
                        </div>


                        
                        
                    </div>
                </div>
                <!--  <========SON=========>>> Favicon SON !-->



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

