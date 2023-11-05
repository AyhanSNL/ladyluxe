<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'cart';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from odeme_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-115']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_cart"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-115']?></a>
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
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2  ">
                                    <h4> <?=$diller['adminpanel-menu-text-115']?></h4>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_cart_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label  for="sepet_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="sepet_font" class="form-control" id="sepet_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['sepet_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="alisveris_arkaplan"><?=$diller['adminpanel-form-text-483']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['alisveris_arkaplan']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="alisveris_arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="sepet_page_button_bg"><?=$diller['adminpanel-form-text-484']?></label>
                                                    <select name="sepet_page_button_bg" class="form-control selet2" style="width: 100%;" id="sepet_page_button_bg" required>
                                                        <option value="button-black-white" <?php if($detay['sepet_page_button_bg'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['sepet_page_button_bg'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['sepet_page_button_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['sepet_page_button_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['sepet_page_button_bg'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['sepet_page_button_bg'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['sepet_page_button_bg'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['sepet_page_button_bg'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['sepet_page_button_bg'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['sepet_page_button_bg'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['sepet_page_button_bg'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['sepet_page_button_bg'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['sepet_page_button_bg'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['sepet_page_button_bg'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['sepet_page_button_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['sepet_page_button_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['sepet_page_button_bg'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['sepet_page_button_bg'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['sepet_page_button_bg'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['sepet_page_button_bg'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['sepet_page_button_bg'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['sepet_page_button_bg'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['sepet_page_button_bg'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sepet_kdv_goster" class="w-100" ><?=$diller['adminpanel-form-text-486']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sepet_kdv_goster" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sepet_kdv_goster" name="sepet_kdv_goster" value="1"  <?php if($detay['sepet_kdv_goster'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sepet_kdv_goster"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-4">
                                                    <label  for="sepet_havale_goster" class="w-100" ><?=$diller['adminpanel-form-text-487']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sepet_havale_goster" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sepet_havale_goster" name="sepet_havale_goster" value="1"  <?php if($detay['sepet_havale_goster'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sepet_havale_goster"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="sepet_urunfiyat_uyari" class="w-100"><?=$diller['adminpanel-form-text-485']?></label>
                                                    <select name="sepet_urunfiyat_uyari" class="form-control" id="sayfalama_hiza" required>
                                                        <option value="0" <?php if($detay['sepet_urunfiyat_uyari'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-490']?></option>
                                                        <option value="1" <?php if($detay['sepet_urunfiyat_uyari'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-491']?></option>
                                                        <option value="2" <?php if($detay['sepet_urunfiyat_uyari'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-492']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="sepet_kupon_button" class="w-100 d-flex align-items-center justify-content-between flex-wrap"><?=$diller['adminpanel-form-text-489']?> <?php if($detay['sepet_kupon'] == '1' ) { ?><span class="text-success">(<?=$diller['adminpanel-form-text-498']?>)</span><?php }else{?><a href="pages.php?page=commerce_settings" target="_blank" class="text-danger">(<?=$diller['adminpanel-form-text-499']?> <i class="fa fa-external-link-alt"></i>)</a><?php } ?></label>
                                                    <select name="sepet_kupon_button" class="form-control selet2" style="width: 100%;" id="sepet_kupon_button" required>
                                                        <option value="button-black-white" <?php if($detay['sepet_kupon_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['sepet_kupon_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['sepet_kupon_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['sepet_kupon_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['sepet_kupon_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['sepet_kupon_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['sepet_kupon_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['sepet_kupon_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['sepet_kupon_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['sepet_kupon_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['sepet_kupon_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['sepet_kupon_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['sepet_kupon_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['sepet_kupon_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['sepet_kupon_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['sepet_kupon_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['sepet_kupon_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['sepet_kupon_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['sepet_kupon_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['sepet_kupon_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['sepet_kupon_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['sepet_kupon_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['sepet_kupon_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-3" style="margin-bottom: 20px;">
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-form-text-500']?>
                                                </div>
                                            </div>
                                            <div class="w-100 bg-light p-2 mb-3">
                                                <?=$diller['adminpanel-form-text-501']?>
                                                <a href="pages.php?page=delivery_settings" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="kargo_limit_sepet" class="w-100"><?=$diller['adminpanel-form-text-493']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kargo_limit_sepet" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kargo_limit_sepet" name="kargo_limit_sepet" value="1" <?php if($detay['kargo_limit_sepet'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                        <label class="custom-control-label" for="kargo_limit_sepet"></label>
                                                    </div>
                                                </div>
                                                <div id="actionBox" class="w-100 col-md-12 mb-4 " <?php if($detay['kargo_limit_sepet'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class=" bg-light p-4  border up-arrow-2">
                                                        <div class="row">
                                                            <div class="form-group col-md-6 ">
                                                                <label for="kargo_limit_sepet_button"><?=$diller['adminpanel-form-text-494']?></label>
                                                                <select name="kargo_limit_sepet_button" class="form-control selet2" style="width: 100%;" id="kargo_limit_sepet_button" required>
                                                                    <option value="button-black-white" <?php if($detay['kargo_limit_sepet_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                                    <option value="button-white-black" <?php if($detay['kargo_limit_sepet_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                                    <option value="button-yellow" <?php if($detay['kargo_limit_sepet_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                                    <option value="button-yellow-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                                    <option value="button-black" <?php if($detay['kargo_limit_sepet_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                                    <option value="button-black-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                                    <option value="button-white" <?php if($detay['kargo_limit_sepet_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                                    <option value="button-white-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                                    <option value="button-gold" <?php if($detay['kargo_limit_sepet_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                                    <option value="button-gold-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                                    <option value="button-red" <?php if($detay['kargo_limit_sepet_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                                    <option value="button-red-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                                    <option value="button-blue" <?php if($detay['kargo_limit_sepet_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                                    <option value="button-blue-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                                    <option value="button-yellow" <?php if($detay['kargo_limit_sepet_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                                    <option value="button-yellow-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                                    <option value="button-green" <?php if($detay['kargo_limit_sepet_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                                    <option value="button-green-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                                    <option value="button-grey" <?php if($detay['kargo_limit_sepet_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                                    <option value="button-grey-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                                    <option value="button-orange" <?php if($detay['kargo_limit_sepet_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                                    <option value="button-orange-out" <?php if($detay['kargo_limit_sepet_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                                    <option value="button-pink" <?php if($detay['kargo_limit_sepet_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="kargo_limit_sepet_button_size"><?=$diller['adminpanel-form-text-495']?></label>
                                                                <select name="kargo_limit_sepet_button_size" class="form-control" id="kargo_limit_sepet_button_size" required>
                                                                    <option value="button-1x" <?php if($detay['kargo_limit_sepet_button_size'] == 'button-1x' ) { ?>selected<?php }?>>1x</option>
                                                                    <option value="button-2x" <?php if($detay['kargo_limit_sepet_button_size'] == 'button-2x' ) { ?>selected<?php }?>>2x</option>
                                                                    <option value="button-3x" <?php if($detay['kargo_limit_sepet_button_size'] == 'button-3x' ) { ?>selected<?php }?>>3x</option>
                                                                    <option value="button-4x" <?php if($detay['kargo_limit_sepet_button_size'] == 'button-4x' ) { ?>selected<?php }?>>4x</option>
                                                                    <option value="button-5x" <?php if($detay['kargo_limit_sepet_button_size'] == 'button-5x' ) { ?>selected<?php }?>>5x</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="kargo_limit_sepet_sayac" class="w-100"><?=$diller['adminpanel-form-text-496']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kargo_limit_sepet_sayac" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kargo_limit_sepet_sayac" name="kargo_limit_sepet_sayac" value="1" <?php if($detay['kargo_limit_sepet_sayac'] != '0'  ) { ?>checked<?php }?> onclick="actionBox2(this.checked);">
                                                        <label class="custom-control-label" for="kargo_limit_sepet_sayac"></label>
                                                    </div>
                                                </div>
                                                <div id="actionBox2" class="w-100 col-md-12 mb-4 " <?php if($detay['kargo_limit_sepet_sayac'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class=" bg-light p-4  border up-arrow-2">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="kargo_limit_sepet_sayac_button"><?=$diller['adminpanel-form-text-494']?></label>
                                                                <select name="kargo_limit_sepet_sayac_button" class="form-control selet2" style="width: 100%;" id="kargo_limit_sepet_sayac_button" required>
                                                                    <option value="button-black-white" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                                    <option value="button-white-black" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                                    <option value="button-yellow" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                                    <option value="button-yellow-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                                    <option value="button-black" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                                    <option value="button-black-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                                    <option value="button-white" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                                    <option value="button-white-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                                    <option value="button-gold" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                                    <option value="button-gold-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                                    <option value="button-red" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                                    <option value="button-red-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                                    <option value="button-blue" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                                    <option value="button-blue-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                                    <option value="button-yellow" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                                    <option value="button-yellow-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                                    <option value="button-green" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                                    <option value="button-green-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                                    <option value="button-grey" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                                    <option value="button-grey-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                                    <option value="button-orange" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                                    <option value="button-orange-out" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                                    <option value="button-pink" <?php if($detay['kargo_limit_sepet_sayac_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                                </select>
                                                            </div>
                                                        </div>
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

<script>
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
    function actionBox2(selected)
    {
        if (selected)
        {
            document.getElementById("actionBox2").style.display = "";
        } else

        {
            document.getElementById("actionBox2").style.display = "none";
        }

    }    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>