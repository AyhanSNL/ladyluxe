<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'compare';

$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from compare_ayar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-119']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_compare"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-119']?></a>
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
                                    <h4> <?=$diller['adminpanel-menu-text-119']?></h4>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_compare_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label  for="sayfa_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="sayfa_font" class="form-control" id="sayfa_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['sayfa_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="sayfa_bg"><?=$diller['adminpanel-form-text-295']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['sayfa_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="sayfa_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-3" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-502']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="fiyat" class="w-100"><?=$diller['adminpanel-form-text-503']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="fiyat" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="fiyat" name="fiyat" value="1" <?php if($detay['fiyat'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="fiyat"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="marka" class="w-100"><?=$diller['adminpanel-form-text-504']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="marka" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="marka" name="marka" value="1" <?php if($detay['marka'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="marka"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="indirim" class="w-100"><?=$diller['adminpanel-form-text-505']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="indirim" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="indirim" name="indirim" value="1" <?php if($detay['indirim'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="indirim"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="kargo" class="w-100"><?=$diller['adminpanel-form-text-506']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="kargo" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="kargo" name="kargo" value="1" <?php if($detay['kargo'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="kargo"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="hizli" class="w-100"><?=$diller['adminpanel-form-text-507']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="hizli" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="hizli" name="hizli" value="1" <?php if($detay['hizli'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="hizli"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="stok" class="w-100"><?=$diller['adminpanel-form-text-508']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="stok" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="stok" name="stok" value="1" <?php if($detay['stok'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="stok"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="taksit" class="w-100"><?=$diller['adminpanel-form-text-509']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="taksit" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="taksit" name="taksit" value="1" <?php if($detay['taksit'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="taksit"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="puan" class="w-100"><?=$diller['adminpanel-form-text-510']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="puan" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="puan" name="puan" value="1" <?php if($detay['puan'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="puan"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="yeni" class="w-100"><?=$diller['adminpanel-form-text-511']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="yeni" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="yeni" name="yeni" value="1" <?php if($detay['yeni'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="yeni"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="firsat" class="w-100"><?=$diller['adminpanel-form-text-512']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="firsat" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="firsat" name="firsat" value="1" <?php if($detay['firsat'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="firsat"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mb-4">
                                                    <label  for="editor" class="w-100"><?=$diller['adminpanel-form-text-513']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="editor" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="editor" name="editor" value="1" <?php if($detay['editor'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="editor"></label>
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
