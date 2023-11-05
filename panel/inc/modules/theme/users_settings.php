<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'users';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from uyeler_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-107']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_users_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-107']?></a>
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
                        <a href="pages.php?page=theme_users_settings" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'users'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-107']?></a>
                        <?php if($yetki['uyelik'] == '1' ) {?>
                            <?php if($yetki['uye_yonet'] == '1'  ) {?>
                                <a href="pages.php?page=users" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'productdetail'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-26']?></a>
                                <a href="pages.php?page=users_group" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'catdetail'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-27']?></a>
                            <?php }?>
                            <?php if($yetki['uyelik_ayar'] == '1' ) {?>
                                <a href="pages.php?page=users_settings" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'brand'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-29']?></a>
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
                        <a href="pages.php?page=theme_users_settings" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'user_teheme'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-107']?></a>
                        <?php if($yetki['uyelik'] == '1' ) {?>
                            <?php if($yetki['uye_yonet'] == '1'  ) {?>
                                <a href="pages.php?page=users" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'productdetail'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-26']?></a>
                                <a href="pages.php?page=users_group" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'catdetail'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-27']?></a>
                            <?php }?>
                            <?php if($yetki['uyelik_ayar'] == '1' ) {?>
                                <a href="pages.php?page=users_settings" class="p-3 list-group-item p-3 list-group-item-action  <?php if($currentMenu == 'brand'  ) { ?>active<?php }?>"><?=$diller['adminpanel-menu-text-29']?></a>
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
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 mb-2">
                                    <h4> <?=$diller['adminpanel-menu-text-107']?></h4>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_users_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label  for="font_select" class="w-100">* <?=$diller['adminpanel-form-text-77']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-438']?>"></i></label>
                                                    <select name="font_select" class="form-control" id="font_select" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['font_select'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="detay_bg"><?=$diller['adminpanel-form-text-436']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['detay_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="detay_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="altsayfa_bg"><?=$diller['adminpanel-form-text-437']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['altsayfa_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="altsayfa_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
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