<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = '404';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select 404_header_border,404_head_bg,404_main_bg,404_text_color,404_button,404_gorsel,404_logo from ayarlar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-131']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_404"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-131']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['tema_ayarlar'] == '1' ) {?>
            <div class="row">


                <!-- Middle Image Block !-->
                <div class="col-md-3">
                    <div class="card p-4">
                        <div class="in-header-page-main">
                            <div class="in-header-page-text">
                                <?=$diller['adminpanel-form-text-549']?>
                            </div>
                        </div>

                        <div class="w-100 p-3 text-center mb-3 " style="background-color: #<?=$detay['404_head_bg']?>;">
                            <?php if($detay['404_logo'] == !null  ) {?>
                                <small class="text-dark bg-white"><?=$diller['adminpanel-text-151']?></small>
                                <br><br>
                                <img src="<?=$ayar['site_url']?>images/logo/<?=$detay['404_logo']?>" class="img-fluid" >
                            <?php }?>
                        </div>

                        <div class="w-100">
                            <form action="post.php?process=theme_404_post&status=logo_update" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="old_logo" value="<?=$detay['404_logo']?>" >
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="404_logo" >
                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-text-152']?></label>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-block" name="update"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                                <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                    <small>png,  jpg, jpeg, svg, gif</small>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card p-4">
                        <div class="in-header-page-main">
                            <div class="in-header-page-text">
                                <?=$diller['adminpanel-form-text-548']?>
                            </div>
                        </div>

                        <div class="w-100 p-3 text-center mb-3 " style="background-color: #<?=$detay['404_main_bg']?>;">
                            <?php if($detay['404_gorsel'] == !null  ) {?>
                                <small class="text-dark bg-white"><?=$diller['adminpanel-form-text-107']?></small>
                                <br><br>
                                <img src="<?=$ayar['site_url']?>images/uploads/<?=$detay['404_gorsel']?>" class="img-fluid" >
                                <br><br>
                                <a href="" data-href="post.php?process=theme_404_post&status=img_delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                            <?php }else { ?>
                                <img class="border rounded" src="<?=$ayar['panel_url']?>assets/images/no-img.jpg" style="max-width: 90px">
                            <?php }?>
                        </div>

                        <div class="w-100">
                            <form action="post.php?process=theme_404_post&status=img_update" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="old_img" value="<?=$detay['404_gorsel']?>" >
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="404_gorsel" >
                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
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
                <!--  <========SON=========>>> Middle Image Block SON !-->


                <!-- Contents !-->
                <div class="col-md-6">
                        <!-- Düzen Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2  ">
                                    <h4><?=$diller['adminpanel-menu-text-131']?></h4>
                                </div>
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_404_post&status=main_update" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="404_main_bg"><?=$diller['adminpanel-form-text-543']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['404_main_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="404_main_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="404_head_bg"><?=$diller['adminpanel-form-text-544']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['404_head_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="404_head_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="404_header_border"><?=$diller['adminpanel-form-text-545']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['404_header_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="404_header_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="404_text_color"><?=$diller['adminpanel-form-text-546']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['404_text_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="404_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="404_button"><?=$diller['adminpanel-form-text-547']?></label>
                                                    <select name="404_button" class="form-control selet2" id="404_button" required style="width: 100%;  ">
                                                        <option value="button-black-white" <?php if($detay['404_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($detay['404_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($detay['404_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['404_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($detay['404_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($detay['404_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($detay['404_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($detay['404_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($detay['404_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($detay['404_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($detay['404_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($detay['404_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($detay['404_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($detay['404_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($detay['404_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($detay['404_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($detay['404_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($detay['404_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($detay['404_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($detay['404_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($detay['404_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($detay['404_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($detay['404_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
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
        $('.selet2').select2();
    });
</script>