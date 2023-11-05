<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'story';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from story_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-127']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_story"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-127']?></a>
                            </div>
                        </div>
                        <div class="col-md-auto mr-3" >
                            <div class="mt-2 d-md-none d-sm-block"></div>
                            <?php if($yetki['modul'] == '1' && $yetki['modul_vitrin'] == '1' ) {?>
                                <a href="pages.php?page=stories"  class="btn btn-primary" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-form-text-550']?></a>
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
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2  ">
                                    <h4><?=$diller['adminpanel-menu-text-127']?></h4>
                                </div>
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_story_post&status=main_update" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="form-group col-md-6">
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
                                                <div class="form-group col-md-6">
                                                    <label for="padding"><?=$diller['adminpanel-form-text-130']?></label>
                                                    <input type="number" name="padding" id="padding" value="<?=$detay['padding']?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="margin"><?=$diller['adminpanel-form-text-243']?></label>
                                                    <input type="number" name="margin" id="margin" value="<?=$detay['margin']?>" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
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
                                                <div class="form-group col-md-6">
                                                    <label  for="font_select" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="font_select" class="form-control" id="font_select" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['font_select'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="renk"><?=$diller['adminpanel-form-text-433']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['renk']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="scroll_bg"><?=$diller['adminpanel-form-text-539']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['scroll_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="scroll_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="scroll_pasif"><?=$diller['adminpanel-form-text-540']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['scroll_pasif']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="scroll_pasif"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="tur"><?=$diller['adminpanel-form-text-927']?></label>
                                                    <select name="tur" class="form-control" id="tur" required>
                                                        <option value="1" <?php if($detay['tur']== '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-928']?></option>
                                                        <option value="2" <?php if($detay['tur']== '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-929']?></option>
                                                    </select>
                                                </div>
                                                <div id="myself-choise" <?php if($detay['tur'] !='2' ) { ?>style="display:none"<?php }?>class="col-md-12 mb-2">
                                                    <div class="border bg-light rounded p-3 up-arrow-2">
                                                        <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="story_border"><?=$diller['adminpanel-form-text-267']?></label>
                                                                    <div data-color-format="default" data-color="#<?=$detay['story_border']?>"  class="colorpicker-default input-group">
                                                                        <input type="text" name="story_border"  value="" class="form-control">
                                                                        <div class="input-group-append add-on">
                                                                            <button class="btn btn-light border" type="button">
                                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="story_target"><?=$diller['adminpanel-form-text-859']?></label>
                                                                <select name="story_target" class="form-control" id="story_target" required>
                                                                    <option value="0" <?php if($detay['story_target'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-858']?></option>
                                                                    <option value="1" <?php if($detay['story_target'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-111']?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    $('#tur').on('change', function() {
                                                        $('#myself-choise').css('display', 'none');
                                                        if ( $(this).val() === '2' ) {
                                                            $('#myself-choise').css('display', 'block');
                                                        }
                                                    });
                                                </script>
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
</script>