<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'panel_settings';
?>
<title><?=$diller['adminpanel-menu-text-154']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-151']?></a>
                                <a href="pages.php?page=panel_settings"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-154']?></a>
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
                        <form method="post" action="post.php?process=panel_settings_update">

                        <div class="w-100">
                            <div class="w-100 text-right">
                                <h3><?=$diller['adminpanel-menu-text-154']?></h3>
                            </div>
                            <div class="form-group">
                                <label  for="baslik" class="w-100">* <?=$diller['adminpanel-form-text-24']?> </label>
                                <input type="text" name="baslik" value="<?=$panelayar['baslik']?>" id="baslik" required class="form-control ">
                            </div>
                            <div class="form-group">
                                <label  for="editor_dil" class="w-100">* <?=$diller['adminpanel-form-text-262']?> </label>
                                <select name="editor_dil" class="form-control" id="editor_dil" required>
                                    <option value="tr" <?php if($panelayar['editor_dil'] == 'tr' ) { ?>selected<?php }?>>Türkçe</option>
                                    <option value="en" <?php if($panelayar['editor_dil'] == 'en' ) { ?>selected<?php }?>>İngilizce</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="panel_nav"><?=$diller['adminpanel-text-345']?></label>
                                <select name="panel_nav" class="form-control" id="panel_nav" required>
                                    <option value="1" <?php if($panelayar['panel_nav'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-text-344']?></option>
                                    <option value="0" <?php if($panelayar['panel_nav'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-text-346']?></option>
                                </select>
                            </div>
                        </div>

                            <!-- Header !-->
                            <div class="w-100 mt-5">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-147']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="fixed_header" class="w-100"><?=$diller['adminpanel-form-text-25']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="fixed_header" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="fixed_header" name="fixed_header" value="1" <?php if($panelayar['fixed_header'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="fixed_header"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="shortlink" class="w-100"><?=$diller['adminpanel-form-text-26']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="shortlink" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="shortlink" name="shortlink" value="1" <?php if($panelayar['shortlink'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="shortlink"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="header_cache" class="w-100"><?=$diller['adminpanel-form-text-27']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="header_cache" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="header_cache" name="header_cache" value="1" <?php if($panelayar['header_cache'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="header_cache"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="panel_bildirim" class="w-100"><?=$diller['adminpanel-form-text-28']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="panel_bildirim" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="panel_bildirim" name="panel_bildirim" value="1" <?php if($panelayar['panel_bildirim'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="panel_bildirim"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="header_order" class="w-100"><?=$diller['adminpanel-form-text-29']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="header_order" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="header_order" name="header_order" value="1" <?php if($panelayar['header_order'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="header_order"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="header_iptal" class="w-100"><?=$diller['adminpanel-form-text-30']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="header_iptal" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="header_iptal" name="header_iptal" value="1" <?php if($panelayar['header_iptal'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="header_iptal"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="header_iade" class="w-100"><?=$diller['adminpanel-form-text-31']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="header_iade" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="header_iade" name="header_iade" value="1" <?php if($panelayar['header_iade'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="header_iade"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="header_ticket" class="w-100"><?=$diller['adminpanel-form-text-32']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="header_ticket" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="header_ticket" name="header_ticket" value="1" <?php if($panelayar['header_ticket'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="header_ticket"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="header_comment" class="w-100"><?=$diller['adminpanel-form-text-33']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="header_comment" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="header_comment" name="header_comment" value="1" <?php if($panelayar['header_comment'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="header_comment"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="header_inbox" class="w-100"><?=$diller['adminpanel-form-text-34']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="header_inbox" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="header_inbox" name="header_inbox" value="1" <?php if($panelayar['header_inbox'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="header_inbox"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-8 mb-4">
                                        <label for="headermenu_overlay_op"><?=$diller['adminpanel-form-text-35']?> </label>
                                        <input type="text" name="headermenu_overlay_op" value="<?=$panelayar['headermenu_overlay_op']?>" id="headermenu_overlay_op" required class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Header SON !-->

                            <!-- Dashboard Ayar !-->
                            <div class="w-100 mt-5">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-150']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="dash_alert" class="w-100"><?=$diller['adminpanel-form-text-36']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="dash_alert" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="dash_alert" name="dash_alert" value="1" <?php if($panelayar['dash_alert'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="dash_alert"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="dash_ust" class="w-100"><?=$diller['adminpanel-form-text-37']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="dash_ust" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="dash_ust" name="dash_ust" value="1" <?php if($panelayar['dash_ust'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="dash_ust"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="dash_istatistik" class="w-100"><?=$diller['adminpanel-form-text-38']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="dash_istatistik" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="dash_istatistik" name="dash_istatistik" value="1" <?php if($panelayar['dash_istatistik'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="dash_istatistik"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="dash_siparis" class="w-100"><?=$diller['adminpanel-form-text-39']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="dash_siparis" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="dash_siparis" name="dash_siparis" value="1" <?php if($panelayar['dash_siparis'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="dash_siparis"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="dash_alt" class="w-100"><?=$diller['adminpanel-form-text-40']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="dash_alt" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="dash_alt" name="dash_alt" value="1" <?php if($panelayar['dash_alt'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="dash_alt"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-4">
                                        <label  for="bekleyen_isler_modal" class="w-100"><?=$diller['adminpanel-form-text-41']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="bekleyen_isler_modal" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="bekleyen_isler_modal" name="bekleyen_isler_modal" value="1" <?php if($panelayar['bekleyen_isler_modal'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="bekleyen_isler_modal"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Dashboard Ayar SON !-->

                            <!-- Footer !-->
                            <div class="w-100 mt-5">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-148']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="footer_text"><?=$diller['adminpanel-form-text-42']?></label>
                                        <input type="text" name="footer_text" value="<?=$panelayar['footer_text']?>" id="footer_text"  class="form-control">
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label><?=$diller['adminpanel-form-text-43']?></label>
                                        <div data-color-format="default" data-color="#<?=$panelayar['footer_bg']?>"  class="colorpicker-default input-group">
                                            <input type="text" name="footer_bg"  value="" class="form-control">
                                            <div class="input-group-append add-on">
                                                <button class="btn btn-light border" type="button">
                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label><?=$diller['adminpanel-form-text-44']?></label>
                                        <div data-color-format="default" data-color="#<?=$panelayar['footer_text_color']?>"  class="colorpicker-default input-group">
                                            <input type="text" name="footer_text_color"  value="" class="form-control">
                                            <div class="input-group-append add-on">
                                                <button class="btn btn-light border" type="button">
                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Footer SON !-->
                            <div class="w-100 border-top pt-3">
                                <button class="btn btn-success btn-block" name="panelUpdate">
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
                                <?=$diller['adminpanel-text-149']?>
                            </div>
                        </div>
                        
                        <div class="w-100 bg-primary p-3 text-center mb-3 ">
                            <?php if($panelayar['panel_logo'] == !null  ) {?>
                                <small class="text-white"><?=$diller['adminpanel-text-151']?></small>
                                <br><br>
                                <img src="<?=$ayar['panel_url']?>assets/images/<?=$panelayar['panel_logo']?>" style="max-width: 30px">
                            <?php }?>
                        </div>

                        <div class="w-100">
                        <form action="post.php?process=panel_logo" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="old_logo" value="<?=$panelayar['panel_logo']?>" >
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="panel_logo" >
                                    <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-text-152']?></label>
                                </div>
                            </div>
                            <button class="btn btn-success btn-block" name="logoUpdate"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                            <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                <small>png,  jpg, jpeg, svg, gif</small>
                            </div>
                        </form>
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

