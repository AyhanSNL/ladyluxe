<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'productdetail';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from urun_detay where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-text-290']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_product_detail"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-text-290']?></a>
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
                                    <h4> <?=$diller['adminpanel-text-290']?></h4>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_catalog_post&status=product_detail" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label  for="detay_font" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="detay_font" class="form-control" id="detay_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['detay_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="detay_bg"><?=$diller['adminpanel-form-text-295']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['detay_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="detay_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="detay_sepet_button"><?=$diller['adminpanel-form-text-296']?></label>
                                                    <select name="detay_sepet_button" class="form-control selet2" style="width: 100%;"  id="detay_sepet_button" required>
                                                        <option value="button-black-white" <?php if($detay['detay_sepet_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['detay_sepet_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['detay_sepet_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['detay_sepet_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['detay_sepet_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['detay_sepet_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['detay_sepet_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['detay_sepet_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['detay_sepet_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['detay_sepet_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['detay_sepet_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['detay_sepet_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['detay_sepet_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['detay_sepet_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['detay_sepet_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['detay_sepet_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['detay_sepet_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['detay_sepet_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['detay_sepet_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['detay_sepet_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['detay_sepet_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['detay_sepet_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['detay_sepet_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="urundetay_aktif_tab"><?=$diller['adminpanel-form-text-297']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['urundetay_aktif_tab']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="urundetay_aktif_tab"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="urundetay_aktif_tab_yazi"><?=$diller['adminpanel-form-text-298']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['urundetay_aktif_tab_yazi']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="urundetay_aktif_tab_yazi"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="detay_infobox_border"><?=$diller['adminpanel-form-text-304']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['detay_infobox_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="detay_infobox_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="galeri_tema"><?=$diller['adminpanel-form-text-1977']?></label>
                                                    <select name="galeri_tema" class="form-control" id="galeri_tema" required>
                                                        <option value="1" <?php if($detay['galeri_tema'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1978']?> 1</option>
                                                        <option value="2" <?php if($detay['galeri_tema'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1978']?> 2</option>
                                                        <option value="3" <?php if($detay['galeri_tema'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1978']?> 3</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="galeri_thumb" class="d-flex align-items-center justify-content-start">
                                                        <?=$diller['adminpanel-form-text-1986']?>
                                                    </label>
                                                    <select name="galeri_thumb" class="form-control" id="galeri_thumb" required>
                                                        <option value="3" <?php if($detay['galeri_thumb'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1979']?></option>
                                                        <option value="4" <?php if($detay['galeri_thumb'] == '4' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1980']?></option>
                                                        <option value="5" <?php if($detay['galeri_thumb'] == '5' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1981']?></option>
                                                        <option value="6" <?php if($detay['galeri_thumb'] == '6' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1982']?></option>
                                                        <option value="7" <?php if($detay['galeri_thumb'] == '7' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1983']?></option>
                                                        <option value="8" <?php if($detay['galeri_thumb'] == '8' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1984']?></option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                   <?=$diller['adminpanel-form-text-299']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="detay_stok_goster" class="w-100"><?=$diller['adminpanel-form-text-300']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="detay_stok_goster" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="detay_stok_goster" name="detay_stok_goster" value="1" <?php if($detay['detay_stok_goster'] != '0'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="detay_stok_goster"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="detay_urunkod_goster" class="w-100"><?=$diller['adminpanel-form-text-301']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="detay_urunkod_goster" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="detay_urunkod_goster" name="detay_urunkod_goster" value="1" <?php if($detay['detay_urunkod_goster'] != '0'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="detay_urunkod_goster"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="detay_fiyatkazanc" class="w-100"><?=$diller['adminpanel-form-text-302']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="detay_fiyatkazanc" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="detay_fiyatkazanc" name="detay_fiyatkazanc" value="1" <?php if($detay['detay_fiyatkazanc'] != '0'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="detay_fiyatkazanc"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="detay_havale_info" class="w-100"><?=$diller['adminpanel-form-text-303']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="detay_havale_info" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="detay_havale_info" name="detay_havale_info" value="1" <?php if($detay['detay_havale_info'] != '0'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="detay_havale_info"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="sosyal_ikon" class="w-100"><?=$diller['adminpanel-form-text-309']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sosyal_ikon" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sosyal_ikon" name="sosyal_ikon" value="1" <?php if($detay['sosyal_ikon'] != '0'  ) { ?>checked<?php }?>>
                                                        <label class="custom-control-label" for="sosyal_ikon"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="star_rate" class="w-100" ><?=$diller['adminpanel-form-text-314']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="star_rate" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="star_rate" name="star_rate" value="1"  <?php if($detay['star_rate'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="star_rate"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row border-top mb-2 pt-3 border-bottom">
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="detay_marka_goster" class="w-100" ><?=$diller['adminpanel-form-text-305']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="detay_marka_goster" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="detay_marka_goster" name="detay_marka_goster" value="1"  <?php if($detay['detay_marka_goster'] == '1'  ) { ?>checked<?php }?> onclick="kargoCek(this.checked);">
                                                        <label class="custom-control-label" for="detay_marka_goster"></label>
                                                    </div>
                                                </div>
                                                <div id="kargoCek" class="w-100 col-md-6 " <?php if($detay['detay_marka_goster'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row   pr-3">
                                                        <div class="form-group col-md-12 mb-4">
                                                            <label for="detay_marka_tip"><?=$diller['adminpanel-form-text-308']?></label>
                                                            <select name="detay_marka_tip" class="form-control" id="detay_marka_tip" required>
                                                                <option value="0" <?php if($detay['detay_marka_tip'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-307']?></option>
                                                                <option value="1" <?php if($detay['detay_marka_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-306']?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-menu-text-8']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="detay_yorum_oval_bg"><?=$diller['adminpanel-form-text-310']?></label>
                                                    <select name="detay_yorum_oval_bg" class="form-control selet2" style="width: 100%;  " id="detay_yorum_oval_bg" required>
                                                        <option value="button-black-white" <?php if($detay['detay_yorum_oval_bg'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['detay_yorum_oval_bg'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['detay_yorum_oval_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['detay_yorum_oval_bg'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['detay_yorum_oval_bg'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['detay_yorum_oval_bg'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['detay_yorum_oval_bg'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['detay_yorum_oval_bg'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['detay_yorum_oval_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['detay_yorum_oval_bg'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['detay_yorum_oval_bg'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['detay_yorum_oval_bg'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['detay_yorum_oval_bg'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['detay_yorum_oval_bg'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="detay_yorumyap_button"><?=$diller['adminpanel-form-text-311']?></label>
                                                    <select name="detay_yorumyap_button" class="form-control selet2" style="width: 100%;  " id="detay_yorumyap_button" required>
                                                        <option value="button-black-white" <?php if($detay['detay_yorumyap_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['detay_yorumyap_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['detay_yorumyap_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['detay_yorumyap_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['detay_yorumyap_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['detay_yorumyap_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['detay_yorumyap_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['detay_yorumyap_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['detay_yorumyap_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['detay_yorumyap_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['detay_yorumyap_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['detay_yorumyap_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['detay_yorumyap_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['detay_yorumyap_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['detay_yorumyap_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['detay_yorumyap_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['detay_yorumyap_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['detay_yorumyap_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['detay_yorumyap_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['detay_yorumyap_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['detay_yorumyap_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['detay_yorumyap_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['detay_yorumyap_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="detay_more_comment_button"><?=$diller['adminpanel-form-text-312']?></label>
                                                    <select name="detay_more_comment_button"class="form-control selet2" style="width: 100%; " id="detay_more_comment_button" required>
                                                        <option value="button-black-white" <?php if($detay['detay_more_comment_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['detay_more_comment_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['detay_more_comment_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['detay_more_comment_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['detay_more_comment_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['detay_more_comment_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['detay_more_comment_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['detay_more_comment_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['detay_more_comment_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['detay_more_comment_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['detay_more_comment_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['detay_more_comment_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['detay_more_comment_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['detay_more_comment_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['detay_more_comment_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['detay_more_comment_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['detay_more_comment_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['detay_more_comment_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['detay_more_comment_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['detay_more_comment_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['detay_more_comment_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['detay_more_comment_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['detay_more_comment_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-5 mb-4">
                                                    <label  for="urun_yorum_onay" class="w-100" ><?=$diller['adminpanel-form-text-313']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="urun_yorum_onay" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="urun_yorum_onay" name="urun_yorum_onay" value="1"  <?php if($detay['urun_yorum_onay'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="urun_yorum_onay"></label>
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
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>