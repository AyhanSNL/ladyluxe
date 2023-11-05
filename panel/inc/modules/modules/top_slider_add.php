<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'topslider';
$sliderSetting = $db->prepare("select slider_width,height from slider_ayar where id=:id ");
$sliderSetting->execute(array(
    'id' => '1'
));
$sliderset = $sliderSetting->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-form-text-897']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-form-text-897']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['modul'] == '1' &&  $yetki['modul_diger'] == '1') { ?>


            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100 d-flex flex-column pb-2 mb-1">
                            <div>
                                <a href="pages.php?page=top_slider" class="btn btn-outline-dark btn-sm mb-2 d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                            </div>
                        </div>
                        <div class="w-100 border shadow-sm pl-3 pr-3 pt-3 mb-3 rounded">
                            <form action="post.php?process=top_slider_post&status=add" method="post" enctype="multipart/form-data">
                                <div class="row ">
                                    <div class="form-group col-md-12 text-center bg-light text-dark mt-n3 mb-3 p-3  border-bottom d-flex flex-wrap align-items-center justify-content-start">
                                        <div style="font-size: 16px ;"> <?=$diller['adminpanel-menu-text-69']?> <i class="fa fa-caret-right ml-2 mr-2"></i></div>
                                        <div>
                                            <h6> <?=$diller['adminpanel-form-text-897']?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-3   ">
                                    <div class="form-group col-md-3 ">
                                        <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 ">
                                        <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="durum" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  checked >
                                            <label class="custom-control-label" for="durum"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                        <input type="number" min="1" autocomplete="off"  name="sira" id="sira" required class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-3">
                                        <label  for="inputGroupFile01" class="w-100"><?=$diller['adminpanel-form-text-906']?>  <small>( png,  jpg, jpeg, webp ) - <?php if($sliderset['slider_width'] == '0' ) { ?>1920px<?php }else{?>1300px<?php }?> - <?=$sliderset['height']?>px</small></label>
                                        <div class="input-group ">
                                            <div class="custom-file ">
                                                <input type="file" class="custom-file-input " id="inputGroupFile01" name="gorsel" >
                                                <label class="custom-file-label" for="inputGroupFile01"  ><?=$diller['adminpanel-form-text-106']?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-3">
                                        <div class="border p-3 rounded ">
                                            <label  class="w-100"><i class="fa fa-mobile-alt"></i> <?=$diller['adminpanel-form-text-917']?> </label>
                                            <div style="font-size: 12px ; color: #999;">
                                                <?=$diller['adminpanel-form-text-918']?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="text_status" class="w-100"><?=$diller['adminpanel-form-text-898']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="text_status" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="text_status" name="text_status" value="1"  onclick="actionBox(this.checked);">
                                            <label class="custom-control-label" for="text_status"></label>
                                        </div>
                                    </div>
                                    <div id="actionBox" class="w-100 col-md-12 mb-4 " style="display:none !important;" >
                                        <div class="row bg-light border ml-1 mr-1 pt-3 pb-2  rounded up-arrow-2">
                                            <div class="form-group col-md-6">
                                                <label for="baslik"><?=$diller['adminpanel-form-text-899']?></label>
                                                <input type="text" min="1" autocomplete="off"  name="baslik" id="baslik"  class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="baslik_animation"><?=$diller['adminpanel-form-text-900']?></label>
                                                <select name="baslik_animation" id="baslik_animation" class="form-control">
                                                    <option value="fade-up">Fade-Up</option>
                                                    <option value="fade-down">Fade-Down</option>
                                                    <option value="fade-right">Fade-Right</option>
                                                    <option value="fade-left">Fade-Left</option>

                                                    <option value="flip-left">Flip Left</option>
                                                    <option value="flip-right">Flip Right</option>
                                                    <option value="flip-up">Flip Up</option>
                                                    <option value="flip-down">Flip Down</option>

                                                    <option value="zoom-in">Zoom-In</option>
                                                    <option value="zoom-out">Zoom-Out</option>
                                                    <option value="zoom-in-down">Zoom-In-Down</option>
                                                    <option value="zoom-in-left">Zoom-In-Left</option>
                                                    <option value="zoom-in-right">Zoom-In-Right</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="spot"><?=$diller['adminpanel-form-text-901']?></label>
                                                <textarea name="spot" id="spot" class="form-control" rows="2"></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="spot_animation"><?=$diller['adminpanel-form-text-902']?></label>
                                                <select name="spot_animation" id="spot_animation" class="form-control">
                                                    <option value="fade-up">Fade-Up</option>
                                                    <option value="fade-down">Fade-Down</option>
                                                    <option value="fade-right">Fade-Right</option>
                                                    <option value="fade-left">Fade-Left</option>

                                                    <option value="flip-left">Flip Left</option>
                                                    <option value="flip-right">Flip Right</option>
                                                    <option value="flip-up">Flip Up</option>
                                                    <option value="flip-down">Flip Down</option>

                                                    <option value="zoom-in">Zoom-In</option>
                                                    <option value="zoom-out">Zoom-Out</option>
                                                    <option value="zoom-in-down">Zoom-In-Down</option>
                                                    <option value="zoom-in-left">Zoom-In-Left</option>
                                                    <option value="zoom-in-right">Zoom-In-Right</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="area"><?=$diller['adminpanel-form-text-903']?></label>
                                                <select name="area" id="area" class="form-control">
                                                    <option value="flex-start"><?=$diller['adminpanel-form-text-208']?></option>
                                                    <option value="center"><?=$diller['adminpanel-form-text-209']?></option>
                                                    <option value="flex-end"><?=$diller['adminpanel-form-text-210']?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="text_bg"><?=$diller['adminpanel-form-text-904']?></label>
                                                <div data-color-format="default" data-color=""  class="colorpicker-default input-group">
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
                                                    <input type="checkbox" class="custom-control-input" id="dark_bg" name="dark_bg" value="1"   ">
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
                                            <option value="1"><?=$diller['adminpanel-form-text-908']?></option>
                                            <option value="0"><?=$diller['adminpanel-form-text-909']?></option>
                                        </select>
                                    </div>
                                    <div id="full-a-choice" class="col-md-12 "    >
                                        <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                            <input type="text" name="full_a_url" autocomplete="off" placeholder="https://"  class="form-control">
                                            <select name="yeni_sekme_full" class="form-control mt-2" id="yeni_sekme_full" style="width: 200px">
                                                <option value="0"><?=$diller['adminpanel-form-text-858']?></option>
                                                <option value="1"><?=$diller['adminpanel-form-text-111']?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="button-a-choice" class="col-md-12 " style="display: none;"   >
                                        <div class="border bg-light p-3 up-arrow-2 ">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="url"><?=$diller['adminpanel-form-text-910']?></label>
                                                    <input type="text" name="url" autocomplete="off" placeholder="https://"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="url"><?=$diller['adminpanel-form-text-859']?></label>
                                                    <select name="yeni_sekme_button" class="form-control " id="yeni_sekme_button" >
                                                        <option value="0"><?=$diller['adminpanel-form-text-858']?></option>
                                                        <option value="1"><?=$diller['adminpanel-form-text-111']?></option>
                                                    </select>
                                                </div>
                                            </div>
                                           <div class="row">
                                               <div class="form-group col-md-6">
                                                   <label for="button_text"><?=$diller['adminpanel-form-text-911']?></label>
                                                   <input type="text" name="button_text" autocomplete="off" id="button_text"   class="form-control">
                                               </div>
                                               <div class="form-group col-md-6">
                                                   <label for="button_bg"><?=$diller['adminpanel-form-text-912']?></label>
                                                   <select name="button_bg" class="form-control select_ajax2" id="button_bg" required style="width: 100%">
                                                       <option value="button-black-white" ><?=$diller['adminpanel-form-text-156']?> </option>
                                                       <option value="button-white-black" ><?=$diller['adminpanel-form-text-172']?> </option>
                                                       <option value="button-yellow" ><?=$diller['adminpanel-form-text-150']?></option>
                                                       <option value="button-yellow-out" ><?=$diller['adminpanel-form-text-151']?></option>
                                                       <option value="button-black" ><?=$diller['adminpanel-form-text-152']?></option>
                                                       <option value="button-black-out" ><?=$diller['adminpanel-form-text-153']?></option>
                                                       <option value="button-white" ><?=$diller['adminpanel-form-text-154']?></option>
                                                       <option value="button-white-out" ><?=$diller['adminpanel-form-text-155']?> </option>
                                                       <option value="button-gold" ><?=$diller['adminpanel-form-text-157']?></option>
                                                       <option value="button-gold-out" ><?=$diller['adminpanel-form-text-158']?> </option>
                                                       <option value="button-red" ><?=$diller['adminpanel-form-text-159']?></option>
                                                       <option value="button-red-out" ><?=$diller['adminpanel-form-text-160']?> </option>
                                                       <option value="button-blue" ><?=$diller['adminpanel-form-text-161']?></option>
                                                       <option value="button-blue-out" ><?=$diller['adminpanel-form-text-162']?> </option>
                                                       <option value="button-yellow" ><?=$diller['adminpanel-form-text-163']?></option>
                                                       <option value="button-yellow-out" ><?=$diller['adminpanel-form-text-164']?> </option>
                                                       <option value="button-green" ><?=$diller['adminpanel-form-text-165']?></option>
                                                       <option value="button-green-out" ><?=$diller['adminpanel-form-text-166']?> </option>
                                                       <option value="button-grey" ><?=$diller['adminpanel-form-text-167']?></option>
                                                       <option value="button-grey-out" ><?=$diller['adminpanel-form-text-168']?> </option>
                                                       <option value="button-orange" ><?=$diller['adminpanel-form-text-169']?></option>
                                                       <option value="button-orange-out"><?=$diller['adminpanel-form-text-170']?> </option>
                                                       <option value="button-pink"><?=$diller['adminpanel-form-text-171']?></option>
                                                   </select>
                                               </div>
                                               <div class="form-group col-md-4">
                                                   <label for="button_animation"><?=$diller['adminpanel-form-text-913']?></label>
                                                   <select name="button_animation" id="button_animation" class="form-control">
                                                       <option value="fade-up">Fade-Up</option>
                                                       <option value="fade-down">Fade-Down</option>
                                                       <option value="fade-right">Fade-Right</option>
                                                       <option value="fade-left">Fade-Left</option>

                                                       <option value="flip-left">Flip Left</option>
                                                       <option value="flip-right">Flip Right</option>
                                                       <option value="flip-up">Flip Up</option>
                                                       <option value="flip-down">Flip Down</option>

                                                       <option value="zoom-in">Zoom-In</option>
                                                       <option value="zoom-out">Zoom-Out</option>
                                                       <option value="zoom-in-down">Zoom-In-Down</option>
                                                       <option value="zoom-in-left">Zoom-In-Left</option>
                                                       <option value="zoom-in-right">Zoom-In-Right</option>
                                                   </select>
                                               </div>
                                               <div class="form-group col-md-4">
                                                   <label for="button_size"><?=$diller['adminpanel-form-text-914']?></label>
                                                   <select name="button_size" class="form-control" id="button_size" required>
                                                       <option value="button-1x" >1x</option>
                                                       <option value="button-2x" >2x</option>
                                                       <option value="button-3x" >3x</option>
                                                       <option value="button-4x" >4x</option>
                                                       <option value="button-5x" >5x</option>
                                                   </select>
                                               </div>
                                               <div class="form-group col-md-4">
                                                   <label for="button_radius"><?=$diller['adminpanel-form-text-915']?></label>
                                                   <input type="text" name="button_radius" autocomplete="off" id="button_radius" value="0"  class="form-control">
                                               </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                    <div class="col-md-12 text-right">
                                        <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                    </div>
                                </div>
                            </form>
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