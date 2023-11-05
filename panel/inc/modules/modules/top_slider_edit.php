<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'topslider';
$sliderCek = $db->prepare("select * from slider where id=:id ");
$sliderCek->execute(array(
        'id' => $_GET['slider_id']
));
$row = $sliderCek->fetch(PDO::FETCH_ASSOC);

if($sliderCek->rowCount()<='0'  ) {
 header('Location:'.$ayar['panel_url'].'pages.php?page=top_slider');
 die();
}


?>
<title><?=$diller['adminpanel-form-text-916']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-67']?></a>
                                <a href="pages.php?page=top_slider"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-69']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-form-text-916']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['modul'] == '1' &&  $yetki['modul_diger'] == '1') { ?>


            <div class="row">


                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="w-100 d-flex flex-column pb-2 mb-1">
                            <div>
                                <a href="pages.php?page=top_slider" class="btn btn-outline-dark btn-sm mb-2 d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="w-100 border shadow-sm pl-3 pr-3 pt-3 mb-3 rounded">
                                    <form action="post.php?process=top_slider_post&status=update" method="post" enctype="multipart/form-data">

                                        <input type="hidden" name="slider_id" value="<?=$row['id']?>">
                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-light text-dark mt-n3 mb-3 p-3  border-bottom d-flex flex-wrap align-items-center justify-content-start">
                                                <div style="font-size: 16px ;"> <?=$diller['adminpanel-menu-text-69']?> <i class="fa fa-caret-right ml-2 mr-2"></i></div>
                                                <div>
                                                    <h6> <?=$diller['adminpanel-form-text-916']?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12 ">
                                                <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  <?php if($row['durum'] == '1' ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                                <input type="number" min="1" autocomplete="off" value="<?=$row['sira']?>"  name="sira" id="sira" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="inputGroupFile01"><?=$diller['adminpanel-form-text-906']?>  <small>( png,  jpg, jpeg )</small></label>
                                                <div class="w-100 bg-light border p-3 rounded-top border-bottom-0">
                                                    <div class="mx-auto" style="width: 90%">
                                                        <img class="img-fluid p-3 bg-white border" src="<?=$ayar['site_url']?>images/slider/<?=$row['gorsel']?>" alt="">
                                                    </div>
                                                </div>
                                                <div class="input-group ">
                                                    <div class="custom-file">
                                                        <input type="hidden" name="old_img" value="<?=$row['gorsel']?>">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel" >
                                                        <label class="custom-file-label" for="inputGroupFile01" style="border-radius: 0 0 4px 4px"><?=$diller['adminpanel-form-text-106']?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4">
                                                <label  for="text_status" class="w-100"><?=$diller['adminpanel-form-text-898']?> (<?=$diller['adminpanel-form-text-1988']?>)</label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="text_status" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="text_status" name="text_status" value="1"  <?php if($row['text_status'] == '1' ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                    <label class="custom-control-label" for="text_status"></label>
                                                </div>
                                            </div>
                                            <div id="actionBox" class="w-100 col-md-12 mb-4 " <?php if($row['text_status'] == '0' ) { ?>style="display:none !important;"<?php }?> >
                                                <div class="row bg-light border ml-1 mr-1 pt-3 pb-2 mt-n2 rounded">
                                                    <div class="form-group col-md-6">
                                                        <label for="baslik"><?=$diller['adminpanel-form-text-899']?></label>
                                                        <input type="text" min="1" autocomplete="off"  value="<?=$row['baslik']?>" name="baslik" id="baslik"  class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="baslik_animation"><?=$diller['adminpanel-form-text-900']?></label>
                                                        <select name="baslik_animation" id="baslik_animation" class="form-control">
                                                            <option <?php if ($row['baslik_animation'] == 'fade-up') {?> selected <?php }?>  value="fade-up">Fade-Up</option>
                                                            <option <?php if ($row['baslik_animation'] == 'fade-down') {?> selected <?php }?>  value="fade-down">Fade-Down</option>
                                                            <option <?php if ($row['baslik_animation'] == 'fade-right') {?> selected <?php }?>  value="fade-right">Fade-Right</option>
                                                            <option <?php if ($row['baslik_animation'] == 'fade-left') {?> selected <?php }?>  value="fade-left">Fade-Left</option>

                                                            <option <?php if ($row['baslik_animation'] == 'flip-left') {?> selected <?php }?>  value="flip-left">Flip Left</option>
                                                            <option <?php if ($row['baslik_animation'] == 'flip-right') {?> selected <?php }?> value="flip-right">Flip Right</option>
                                                            <option <?php if ($row['baslik_animation'] == 'flip-up') {?> selected <?php }?>  value="flip-up">Flip Up</option>
                                                            <option <?php if ($row['baslik_animation'] == 'flip-down') {?> selected <?php }?>  value="flip-down">Flip Down</option>

                                                            <option <?php if ($row['baslik_animation'] == 'zoom-in') {?> selected <?php }?>  value="zoom-in">Zoom-In</option>
                                                            <option <?php if ($row['baslik_animation'] == 'zoom-out') {?> selected <?php }?>  value="zoom-out">Zoom-Out</option>
                                                            <option <?php if ($row['baslik_animation'] == 'zoom-in-down') {?> selected <?php }?>  value="zoom-in-down">Zoom-In-Down</option>
                                                            <option <?php if ($row['baslik_animation'] == 'zoom-in-left') {?> selected <?php }?>  value="zoom-in-left">Zoom-In-Left</option>
                                                            <option <?php if ($row['baslik_animation'] == 'zoom-in-right') {?> selected <?php }?>  value="zoom-in-right">Zoom-In-Right</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="spot"><?=$diller['adminpanel-form-text-901']?></label>
                                                        <textarea name="spot" id="spot" class="form-control" rows="2"><?=$row['spot']?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="spot_animation"><?=$diller['adminpanel-form-text-902']?></label>
                                                        <select name="spot_animation" id="spot_animation" class="form-control">
                                                            <option <?php if ($row['spot_animation'] == 'fade-up') {?> selected <?php }?>  value="fade-up">Fade-Up</option>
                                                            <option <?php if ($row['spot_animation'] == 'fade-down') {?> selected <?php }?>  value="fade-down">Fade-Down</option>
                                                            <option <?php if ($row['spot_animation'] == 'fade-right') {?> selected <?php }?>  value="fade-right">Fade-Right</option>
                                                            <option <?php if ($row['spot_animation'] == 'fade-left') {?> selected <?php }?>  value="fade-left">Fade-Left</option>

                                                            <option <?php if ($row['spot_animation'] == 'flip-left') {?> selected <?php }?>  value="flip-left">Flip Left</option>
                                                            <option <?php if ($row['spot_animation'] == 'flip-right') {?> selected <?php }?> value="flip-right">Flip Right</option>
                                                            <option <?php if ($row['spot_animation'] == 'flip-up') {?> selected <?php }?>  value="flip-up">Flip Up</option>
                                                            <option <?php if ($row['spot_animation'] == 'flip-down') {?> selected <?php }?>  value="flip-down">Flip Down</option>

                                                            <option <?php if ($row['spot_animation'] == 'zoom-in') {?> selected <?php }?>  value="zoom-in">Zoom-In</option>
                                                            <option <?php if ($row['spot_animation'] == 'zoom-out') {?> selected <?php }?>  value="zoom-out">Zoom-Out</option>
                                                            <option <?php if ($row['spot_animation'] == 'zoom-in-down') {?> selected <?php }?>  value="zoom-in-down">Zoom-In-Down</option>
                                                            <option <?php if ($row['spot_animation'] == 'zoom-in-left') {?> selected <?php }?>  value="zoom-in-left">Zoom-In-Left</option>
                                                            <option <?php if ($row['spot_animation'] == 'zoom-in-right') {?> selected <?php }?>  value="zoom-in-right">Zoom-In-Right</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="area"><?=$diller['adminpanel-form-text-903']?></label>
                                                        <select name="area" id="area" class="form-control">
                                                            <option value="flex-start" <?php if($row['area'] == 'flex-start'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-208']?></option>
                                                            <option value="center" <?php if($row['area'] == 'center'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-209']?></option>
                                                            <option value="flex-end" <?php if($row['area'] == 'flex-end'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-210']?></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="text_bg"><?=$diller['adminpanel-form-text-904']?></label>
                                                        <div data-color-format="default" data-color="#<?=$row['text_bg']?>"  class="colorpicker-default input-group">
                                                            <input type="text" name="text_bg"  value="" class="form-control">
                                                            <div class="input-group-append add-on">
                                                                <button class="btn btn-light border" type="button">
                                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6 ">
                                                        <label  for="dark_bg" class="w-100" ><?=$diller['adminpanel-form-text-905']?></label>
                                                        <div class="custom-control custom-switch custom-switch-lg">
                                                            <input type="hidden" name="dark_bg" value="0"">
                                                            <input type="checkbox" class="custom-control-input" id="dark_bg" name="dark_bg" value="1" <?php if($row['dark_bg'] == '1' ) { ?>checked<?php }?>  ">
                                                            <label class="custom-control-label" for="dark_bg"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12 ">
                                                <label for="full_a"><?=$diller['adminpanel-form-text-907']?></label>
                                                <select name="full_a" class="form-control rounded-0" id="full_a" required style="height: 55px; font-size: 15px ;">
                                                    <option value="1" <?php if($row['full_a'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-908']?></option>
                                                    <option value="0" <?php if($row['full_a'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-909']?></option>
                                                </select>
                                            </div>
                                            <div id="full-a-choice" class="col-md-12 "  <?php if($row['full_a'] != '1'  ) { ?> style="display: none;"<?php }?>   >
                                                <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                                    <input type="text" name="full_a_url" value="<?=$row['full_a_url']?>" autocomplete="off" placeholder="https://"  class="form-control">
                                                    <select name="yeni_sekme_full" class="form-control mt-2" id="yeni_sekme_full" style="width: 200px">
                                                        <option value="0" <?php if($row['yeni_sekme'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-858']?></option>
                                                        <option value="1" <?php if($row['yeni_sekme'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-111']?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="button-a-choice" class="col-md-12 " <?php if($row['full_a'] == '1'  ) { ?> style="display: none;"<?php }?>  >
                                                <div class="border bg-light p-3 up-arrow-2">
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="url"><?=$diller['adminpanel-form-text-910']?></label>
                                                            <input type="text" name="url" value="<?=$row['url']?>" autocomplete="off" placeholder="https://"  class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-3">
                                                            <label for="url"><?=$diller['adminpanel-form-text-859']?></label>
                                                            <select name="yeni_sekme_button" class="form-control " id="yeni_sekme_button" >
                                                                <option value="0" <?php if($row['yeni_sekme'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-858']?></option>
                                                                <option value="1" <?php if($row['yeni_sekme'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-111']?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="button_text"><?=$diller['adminpanel-form-text-911']?></label>
                                                            <input type="text" name="button_text" value="<?=$row['button_text']?>" autocomplete="off" id="button_text"   class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="button_bg"><?=$diller['adminpanel-form-text-912']?></label>
                                                            <select name="button_bg" class="form-control select_ajax2" id="button_bg" required style="width: 100%">
                                                                <option value="button-black-white" <?php if($row['button_bg'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                                <option value="button-white-black" <?php if($row['button_bg'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                                <option value="button-yellow" <?php if($row['button_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                                <option value="button-yellow-out" <?php if($row['button_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                                <option value="button-black" <?php if($row['button_bg'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                                <option value="button-black-out" <?php if($row['button_bg'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                                <option value="button-white" <?php if($row['button_bg'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                                <option value="button-white-out" <?php if($row['button_bg'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                                <option value="button-gold" <?php if($row['button_bg'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                                <option value="button-gold-out" <?php if($row['button_bg'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                                <option value="button-red" <?php if($row['button_bg'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                                <option value="button-red-out" <?php if($row['button_bg'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                                <option value="button-blue" <?php if($row['button_bg'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                                <option value="button-blue-out" <?php if($row['button_bg'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                                <option value="button-yellow" <?php if($row['button_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                                <option value="button-yellow-out" <?php if($row['button_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                                <option value="button-green" <?php if($row['button_bg'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                                <option value="button-green-out" <?php if($row['button_bg'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                                <option value="button-grey" <?php if($row['button_bg'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                                <option value="button-grey-out" <?php if($row['button_bg'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                                <option value="button-orange" <?php if($row['button_bg'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                                <option value="button-orange-out" <?php if($row['button_bg'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                                <option value="button-pink" <?php if($row['button_bg'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="button_animation"><?=$diller['adminpanel-form-text-913']?></label>
                                                            <select name="button_animation" id="button_animation" class="form-control">
                                                                <option <?php if ($row['button_animation'] == 'fade-up') {?> selected <?php }?>  value="fade-up">Fade-Up</option>
                                                                <option <?php if ($row['button_animation'] == 'fade-down') {?> selected <?php }?>  value="fade-down">Fade-Down</option>
                                                                <option <?php if ($row['button_animation'] == 'fade-right') {?> selected <?php }?>  value="fade-right">Fade-Right</option>
                                                                <option <?php if ($row['button_animation'] == 'fade-left') {?> selected <?php }?>  value="fade-left">Fade-Left</option>

                                                                <option <?php if ($row['button_animation'] == 'flip-left') {?> selected <?php }?>  value="flip-left">Flip Left</option>
                                                                <option <?php if ($row['button_animation'] == 'flip-right') {?> selected <?php }?> value="flip-right">Flip Right</option>
                                                                <option <?php if ($row['button_animation'] == 'flip-up') {?> selected <?php }?>  value="flip-up">Flip Up</option>
                                                                <option <?php if ($row['button_animation'] == 'flip-down') {?> selected <?php }?>  value="flip-down">Flip Down</option>

                                                                <option <?php if ($row['button_animation'] == 'zoom-in') {?> selected <?php }?>  value="zoom-in">Zoom-In</option>
                                                                <option <?php if ($row['button_animation'] == 'zoom-out') {?> selected <?php }?>  value="zoom-out">Zoom-Out</option>
                                                                <option <?php if ($row['button_animation'] == 'zoom-in-down') {?> selected <?php }?>  value="zoom-in-down">Zoom-In-Down</option>
                                                                <option <?php if ($row['button_animation'] == 'zoom-in-left') {?> selected <?php }?>  value="zoom-in-left">Zoom-In-Left</option>
                                                                <option <?php if ($row['button_animation'] == 'zoom-in-right') {?> selected <?php }?>  value="zoom-in-right">Zoom-In-Right</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="button_size"><?=$diller['adminpanel-form-text-914']?></label>
                                                            <select name="button_size" class="form-control" id="button_size" required>
                                                                <option value="button-1x" <?php if($row['button_size'] == 'button-1x' ) { ?>selected<?php }?>>1x</option>
                                                                <option value="button-2x" <?php if($row['button_size'] == 'button-2x' ) { ?>selected<?php }?>>2x</option>
                                                                <option value="button-3x" <?php if($row['button_size'] == 'button-3x' ) { ?>selected<?php }?>>3x</option>
                                                                <option value="button-4x" <?php if($row['button_size'] == 'button-4x' ) { ?>selected<?php }?>>4x</option>
                                                                <option value="button-5x" <?php if($row['button_size'] == 'button-5x' ) { ?>selected<?php }?>>5x</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="button_radius"><?=$diller['adminpanel-form-text-915']?></label>
                                                            <input type="text" name="button_radius" autocomplete="off" id="button_radius" value="<?=$row['button_radius']?>"  class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="w-100 border shadow-sm pl-3 pr-3 pt-3 mb-3 pb-3 rounded">
                                    <div class="border-bottom pb-2 mb-3" style="font-size: 16px ; font-weight: 500;">
                                        <?=$diller['adminpanel-form-text-917']?>
                                    </div>

                                    <div class="w-100 mb-3  ">
                                        <?php if($row['gorsel_mobil'] == !null  ) {?>
                                            <img src="<?=$ayar['site_url']?>/images/slider/<?=$row['gorsel_mobil']?>" class="img-fluid" >
                                            <br>
                                            <a href="" data-href="post.php?process=top_slider_post&status=mobil_gorsel_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger mt-2"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                        <?php }else { ?>
                                            <div class="card border mb-0">
                                                <div class="card-body text-center">
                                                    <i class="fa fa-ban"></i>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>

                                    <div class="w-100">
                                        <form action="post.php?process=top_slider_post&status=mobil_gorsel" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="slider_id" value="<?=$row['id']?>" >
                                            <input type="hidden" name="old_mobil" value="<?=$row['gorsel_mobil']?>" >
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputGroupFile02" name="gorsel_mobil" >
                                                    <label class="custom-file-label" for="inputGroupFile02"><?=$diller['adminpanel-form-text-106']?></label>
                                                </div>
                                            </div>
                                            <button class="btn btn-success btn-block" name="update"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                                            <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                                <small>png,  jpg, jpeg, svg, gif</small>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Contents SON !-->

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
    $('#full_a').on('change', function() {
        $('#full-a-choice').css('display', 'none');
        if ( $(this).val() === '1' ) {
            $('#full-a-choice').css('display', 'block');
        }
        $('#button-a-choice').css('display', 'none');
        if ( $(this).val() === '0' ) {
            $('#button-a-choice').css('display', 'block');
        }
    });
</script>
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
    $(document).ready(function() {
        $('.select_ajax2').select2();
    });
</script>