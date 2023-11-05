<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'contact';

$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select iletisim_sayfa_font,iletisim_sayfa_maps,iletisim_sayfa_nav,iletisim_sayfa_form,iletisim_sayfa_bg,iletisim_sayfa_tags,iletisim_sayfa_desc from ayarlar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-text-328']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_contact"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-text-328']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['tema_ayarlar'] == '1' ) {?>
            <div class="row">

                <!-- Left Bar !-->
                <div class="col-md-3 d-none d-md-inline-block ">
                    <div class="list-group ">
                        <a href="pages.php?page=theme_contact" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'contact'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-328']?></a>
                        <?php if($yetki['icerik_yonetim'] == '1' ) {?>
                            <?php if($yetki['icerik_diger'] == '1' ) {?>
                                <a href="pages.php?page=contact_page" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'contact_links'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-62']?></a>
                            <?php }?>
                            <?php if($yetki['sayfa_yonet'] == '1'  ) {?>
                                <a href="pages.php?page=sub_navigations" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'sub_nav'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-42']?></a>
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
                <!--  <========SON=========>>> Left Bar SON !-->

                <!-- Mobile !-->
                <div class="col-md-3 d-md-none d-sm-inline-block  ">
                    <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#assadasdasd" aria-expanded="false" aria-controls="collapseExample">
                        <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
                    </a>
                    <div class="collapse mb-3" id="assadasdasd">
                        <a href="pages.php?page=theme_contact" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'contact'  ) { ?>active<?php }?>"><?=$diller['adminpanel-text-328']?></a>
                        <?php if($yetki['icerik_yonetim'] == '1' ) {?>
                            <?php if($yetki['icerik_diger'] == '1' ) {?>
                                <a href="pages.php?page=contact_page" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'contact_links'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-62']?></a>
                            <?php }?>
                            <?php if($yetki['sayfa_yonet'] == '1'  ) {?>
                                <a href="pages.php?page=sub_navigations" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'sub_nav'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-42']?></a>
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
                <!--  <========SON=========>>> Mobile SON !-->

                <!-- Contents !-->
                <div class="col-md-6">
                        <!-- Düzen Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2  ">
                                    <h4> <?=$diller['adminpanel-text-328']?></h4>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_contact_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label  for="iletisim_sayfa_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="iletisim_sayfa_font" class="form-control" id="iletisim_sayfa_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['iletisim_sayfa_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="iletisim_sayfa_bg"><?=$diller['adminpanel-form-text-295']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['iletisim_sayfa_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="iletisim_sayfa_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="iletisim_sayfa_nav" class="w-100 d-flex justify-content-start align-items-center flex-wrap">
                                                        <?=$diller['adminpanel-form-text-516']?>
                                                        <a href="pages.php?page=sub_navigations" class="text-pink ml-2" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                                                    </label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="iletisim_sayfa_nav" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="iletisim_sayfa_nav" name="iletisim_sayfa_nav" value="1" <?php if($detay['iletisim_sayfa_nav'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="iletisim_sayfa_nav"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mb-4">
                                                    <label  for="iletisim_sayfa_form" class="w-100 d-flex justify-content-start align-items-center flex-wrap">
                                                        <?=$diller['adminpanel-form-text-1568']?>
                                                    </label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="iletisim_sayfa_form" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="iletisim_sayfa_form" name="iletisim_sayfa_form" value="1" <?php if($detay['iletisim_sayfa_form'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="iletisim_sayfa_form"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="iletisim_sayfa_maps"><i class="fa fa-map-marker-alt"></i> <?=$diller['adminpanel-form-text-514']?></label>
                                                    <textarea name="iletisim_sayfa_maps" id="iletisim_sayfa_maps" class="form-control" rows="4"><?=$detay['iletisim_sayfa_maps']?></textarea>
                                                    <div class="w-100 bg-light p-2 font-12 border rounded"><?=$diller['adminpanel-form-text-515']?></div>
                                                </div>

                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-text-311']?> <i class="ti-help-alt text-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-327']?>"></i>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="form-group col-md-12">
                                                    <label  for="iletisim_sayfa_tags" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                                    <input type="text" name="iletisim_sayfa_tags" value="<?=$detay['iletisim_sayfa_tags']?>" id="iletisim_sayfa_tags" data-role="tagsinput" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="iletisim_sayfa_desc" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                                    <textarea name="iletisim_sayfa_desc" id="iletisim_sayfa_desc" class="form-control" rows="2" ><?=$detay['iletisim_sayfa_desc']?></textarea>
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
