<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'productbox';

$urunKutu = $db->prepare("select * from urun_kutu where id='1' ");
$urunKutu->execute();
$box = $urunKutu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-text-288']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_product_box"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-text-288']?></a>
                            </div>
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
                                    <h4> <?=$diller['adminpanel-text-288']?></h4>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=product_box" method="post">
                                            <div class="row">

                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="resim_w">* <?=$diller['adminpanel-form-text-2156']?></label>
                                                    <input type="number" name="resim_w" value="<?=$box['resim_w']?>" id="resim_w" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="resim_h">* <?=$diller['adminpanel-form-text-2157']?></label>
                                                    <input type="number" name="resim_h" value="<?=$box['resim_h']?>" id="resim_h" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="resim_big_w">* <?=$diller['adminpanel-form-text-2158']?></label>
                                                    <input type="number" name="resim_big_w" value="<?=$box['resim_big_w']?>" id="resim_big_w" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label for="resim_big_h">* <?=$diller['adminpanel-form-text-2159']?></label>
                                                    <input type="number" name="resim_big_h" value="<?=$box['resim_big_h']?>" id="resim_big_h" required class="form-control">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="kutu_arkaplan"><?=$diller['adminpanel-form-text-264']?></label>
                                                    <div data-color-format="default" data-color="#<?=$box['kutu_arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="kutu_border_renk"><?=$diller['adminpanel-form-text-267']?></label>
                                                    <div data-color-format="default" data-color="#<?=$box['kutu_border_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_border_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="kutu_yazi_renk"><?=$diller['adminpanel-form-text-269']?></label>
                                                    <div data-color-format="default" data-color="#<?=$box['kutu_yazi_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_yazi_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label for="kutu_radius">* <?=$diller['adminpanel-form-text-266']?></label>
                                                    <input type="text" name="kutu_radius" value="<?=$box['kutu_radius']?>" id="kutu_radius" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label for="border_width">* <?=$diller['adminpanel-form-text-290']?></label>
                                                    <input type="text" name="border_width" value="<?=$box['border_width']?>" id="border_width" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="kutu_shadow" class="w-100" ><?=$diller['adminpanel-form-text-265']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kutu_shadow" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kutu_shadow" name="kutu_shadow" value="1"  <?php if($box['kutu_shadow'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="kutu_shadow"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                   <?=$diller['adminpanel-form-text-291']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="kutu_fiyat_renk"><?=$diller['adminpanel-form-text-270']?></label>
                                                    <div data-color-format="default" data-color="#<?=$box['kutu_fiyat_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_fiyat_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="kutu_eskifiyat_renk"><?=$diller['adminpanel-form-text-271']?></label>
                                                    <div data-color-format="default" data-color="#<?=$box['kutu_eskifiyat_renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_eskifiyat_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="kutu_grupfiyat_button"><?=$diller['adminpanel-form-text-284']?></label>
                                                    <select name="kutu_grupfiyat_button" class="form-control selet2" style="width: 100%;" id="kutu_grupfiyat_button" required >
                                                        <option value="button-black-white" <?php if($box['kutu_grupfiyat_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($box['kutu_grupfiyat_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($box['kutu_grupfiyat_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($box['kutu_grupfiyat_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($box['kutu_grupfiyat_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($box['kutu_grupfiyat_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($box['kutu_grupfiyat_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($box['kutu_grupfiyat_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($box['kutu_grupfiyat_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($box['kutu_grupfiyat_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($box['kutu_grupfiyat_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($box['kutu_grupfiyat_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($box['kutu_grupfiyat_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($box['kutu_grupfiyat_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($box['kutu_grupfiyat_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($box['kutu_grupfiyat_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($box['kutu_grupfiyat_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($box['kutu_grupfiyat_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($box['kutu_grupfiyat_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($box['kutu_grupfiyat_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($box['kutu_grupfiyat_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($box['kutu_grupfiyat_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($box['kutu_grupfiyat_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="kutu_ozelfiyat_bg" class="w-100"><?=$diller['adminpanel-form-text-285']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-292']?>"></i></label>
                                                    <div data-color-format="default" data-color="#<?=$box['kutu_ozelfiyat_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_ozelfiyat_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="kutu_ozelfiyat_text" class="w-100"><?=$diller['adminpanel-form-text-286']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-292']?>"></i></label>
                                                    <div data-color-format="default" data-color="#<?=$box['kutu_ozelfiyat_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_ozelfiyat_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" style="margin-bottom: 20px;" >
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-form-text-293']?>
                                                </div>
                                            </div>
                                            <div class="w-100 bg-light p-3 mb-3">
                                                <?=$diller['adminpanel-form-text-294']?>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="box_action" class="w-100"><?=$diller['adminpanel-form-text-275']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="box_action" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="box_action" name="box_action" value="1" <?php if($box['kutu_aksiyon_tip'] != '0'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                        <label class="custom-control-label" for="box_action"></label>
                                                    </div>
                                                </div>
                                                <div id="actionBox" class="w-100 col-md-12 mb-4 " <?php if($box['kutu_aksiyon_tip'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row">
                                                        <div class="form-group col-md-12 ">
                                                            <label for="kutu_aksiyon_tip"><?=$diller['adminpanel-form-text-275']?></label>
                                                            <select name="kutu_aksiyon_tip" class="form-control"  id="kutu_aksiyon_tip" required>
                                                                <option value="1" <?php if($box['kutu_aksiyon_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-278']?></option>
                                                                <option value="2" <?php if($box['kutu_aksiyon_tip'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-277']?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-4 mb-4">
                                                            <label  for="kutu_sepet_button" class="w-100"><?=$diller['adminpanel-form-text-279']?></label>
                                                            <div class="custom-control custom-switch custom-switch-lg">
                                                                <input type="hidden" name="kutu_sepet_button" value="0"">
                                                                <input type="checkbox" class="custom-control-input" id="kutu_sepet_button" name="kutu_sepet_button" value="1" <?php if($box['kutu_sepet_button'] == '1'  ) { ?>checked<?php }?> >
                                                                <label class="custom-control-label" for="kutu_sepet_button"></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 mb-4">
                                                            <label  for="kutu_fav_button" class="w-100"><?=$diller['adminpanel-form-text-280']?></label>
                                                            <div class="custom-control custom-switch custom-switch-lg">
                                                                <input type="hidden" name="kutu_fav_button" value="0"">
                                                                <input type="checkbox" class="custom-control-input" id="kutu_fav_button" name="kutu_fav_button" value="1" <?php if($box['kutu_fav_button'] == '1'  ) { ?>checked<?php }?> >
                                                                <label class="custom-control-label" for="kutu_fav_button"></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 mb-4">
                                                            <label  for="kutu_compare_button" class="w-100"><?=$diller['adminpanel-form-text-281']?></label>
                                                            <div class="custom-control custom-switch custom-switch-lg">
                                                                <input type="hidden" name="kutu_compare_button" value="0"">
                                                                <input type="checkbox" class="custom-control-input" id="kutu_compare_button" name="kutu_compare_button" value="1" <?php if($box['kutu_compare_button'] == '1'  ) { ?>checked<?php }?> >
                                                                <label class="custom-control-label" for="kutu_compare_button"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4"  >
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-form-text-276']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="kutu_indirim_goster" class="w-100"><?=$diller['adminpanel-form-text-282']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kutu_indirim_goster" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kutu_indirim_goster" name="kutu_indirim_goster" value="1" <?php if($box['kutu_indirim_goster'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="kutu_indirim_goster"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="kutu_yeni_ribbon" class="w-100"><?=$diller['adminpanel-form-text-283']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kutu_yeni_ribbon" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kutu_yeni_ribbon" name="kutu_yeni_ribbon" value="1" <?php if($box['kutu_yeni_ribbon'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="kutu_yeni_ribbon"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row border-top  pt-3 mb-2">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="kutu_marka_goster" class="w-100" ><?=$diller['adminpanel-form-text-273']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kutu_marka_goster" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kutu_marka_goster" name="kutu_marka_goster" value="1"  <?php if($box['kutu_marka_goster'] == '1'  ) { ?>checked<?php }?> onclick="markaCek(this.checked);">
                                                        <label class="custom-control-label" for="kutu_marka_goster"></label>
                                                    </div>
                                                </div>
                                                <div id="markaCek" class="w-100 col-md-6 " <?php if($box['kutu_marka_goster'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row   pr-3">
                                                        <div class="form-group col-md-12 mb-4">
                                                            <label for="kutu_marka_renk"><?=$diller['adminpanel-form-text-272']?></label>
                                                            <div data-color-format="default" data-color="#<?=$box['kutu_marka_renk']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="kutu_marka_renk"  value="" class="form-control">
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
                                            <div class="row border-top mb-2 pt-3">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="kutu_kargo_goster" class="w-100" ><?=$diller['adminpanel-form-text-274']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kutu_kargo_goster" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kutu_kargo_goster" name="kutu_kargo_goster" value="1"  <?php if($box['kutu_kargo_goster'] == '1'  ) { ?>checked<?php }?> onclick="kargoCek(this.checked);">
                                                        <label class="custom-control-label" for="kutu_kargo_goster"></label>
                                                    </div>
                                                </div>
                                                <div id="kargoCek" class="w-100 col-md-6 " <?php if($box['kutu_kargo_goster'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row   pr-3">
                                                        <div class="form-group col-md-12 mb-4">
                                                            <label for="kutu_kargo_renk"><?=$diller['adminpanel-form-text-268']?></label>
                                                            <div data-color-format="default" data-color="#<?=$box['kutu_kargo_renk']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="kutu_kargo_renk"  value="" class="form-control">
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
                                            <div class="row border-top mb-2 pt-3">
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="kutu_star_rate" class="w-100" ><?=$diller['adminpanel-form-text-287']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kutu_star_rate" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kutu_star_rate" name="kutu_star_rate" value="1"  <?php if($box['kutu_star_rate'] == '1'  ) { ?>checked<?php }?> onclick="starCek(this.checked);">
                                                        <label class="custom-control-label" for="kutu_star_rate"></label>
                                                    </div>
                                                </div>
                                                <div id="starCek" class="w-100 col-md-12 " <?php if($box['kutu_star_rate'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row  pr-3">
                                                        <div class="form-group col-md-6 mb-4">
                                                            <label for="star_color"><?=$diller['adminpanel-form-text-288']?></label>
                                                            <div data-color-format="default" data-color="#<?=$box['star_color']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="star_color"  value="" class="form-control">
                                                                <div class="input-group-append add-on">
                                                                    <button class="btn btn-light border" type="button">
                                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 mb-4">
                                                            <label for="star_pasif_color"><?=$diller['adminpanel-form-text-289']?></label>
                                                            <div data-color-format="default" data-color="#<?=$box['star_pasif_color']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="star_pasif_color"  value="" class="form-control">
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
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>