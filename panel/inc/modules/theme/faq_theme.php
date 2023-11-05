<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'faq';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from sss_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-147']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_faq"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-147']?></a>
                            </div>
                        </div>
                        <div class="col-md-auto mr-3" >
                            <?php if($yetki['icerik_yonetim'] == '1' && $yetki['icerik_diger'] == '1' ) {?>
                                <div class="mt-2 d-md-none d-sm-block"></div>
                                <a href="pages.php?page=faq"  class="btn btn-primary" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-form-text-615']?></a>
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
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap mb-2 ">
                                    <h4> <?=$diller['adminpanel-menu-text-147']?></h4>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_faq_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-6">
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
                                                <div class="form-group col-md-6">
                                                    <label  for="baslik_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="baslik_font" class="form-control" id="baslik_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['baslik_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="first_open" class="w-100" ><?=$diller['adminpanel-form-text-616']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="first_open" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="first_open" name="first_open" value="1"  <?php if($detay['first_open'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="first_open"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="nav_durum" class="w-100 d-flex justify-content-start align-items-center flex-wrap">
                                                        <?=$diller['adminpanel-form-text-516']?>
                                                        <a href="pages.php?page=sub_navigations" class="text-pink ml-2" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                                                    </label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="nav_durum" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="nav_durum" name="nav_durum" value="1" <?php if($detay['nav_durum'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="nav_durum"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-text-311']?> <i class="ti-help-alt text-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-617']?>"></i>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="form-group col-md-12">
                                                    <label  for="tags" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                                    <input type="text" name="tags" value="<?=$detay['tags']?>" id="tags" data-role="tagsinput" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="meta_desc" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                                    <textarea name="meta_desc" id="meta_desc" class="form-control" rows="2" ><?=$detay['meta_desc']?></textarea>
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

    }
</script>