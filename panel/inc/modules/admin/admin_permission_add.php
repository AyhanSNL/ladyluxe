<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'admin_per';
?>
<title><?=$diller['adminpanel-text-168']?> - <?=$panelayar['baslik']?></title>
<style>


</style>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-151']?></a>
                                <a href="pages.php?page=admin_permission"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-158']?></a>
                                <a href="pages.php?page=permission_add"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-text-168']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-4">
                        <form method="post" action="post.php?process=permission_post&status=per_add">

                        <div class="w-100">
                            <div class="w-100  pb-2 mb-4 border-bottom d-flex align-items-center justify-content-between flex-wrap">
                                <h4><?=$diller['adminpanel-text-238']?></h4>
                                <a href="pages.php?page=admin_permission" class="btn btn-outline-dark btn-sm mb-2"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                            </div>
                           <div class="row">
                               <div class="form-group col-md-9">
                                   <label  for="baslik" class="w-100">* <?=$diller['adminpanel-text-169']?> </label>
                                   <input type="text" name="baslik" id="baslik" required class="form-control " autocomplete="off">
                               </div>
                               <div class="form-group col-md-3">
                                   <label  for="sira" class="w-100">* <?=$diller['adminpanel-form-text-55']?> </label>
                                   <input type="number" name="sira" id="sira" required class="form-control " autocomplete="off">
                               </div>
                           </div>
                        </div>

                            <div class="w-100 mt-3">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-172']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="demo" class="w-100" style="font-size: 11px !important; font-weight: 400!important; "><?=$diller['adminpanel-text-173']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="demo" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="demo" name="demo" value="1" <?php if($panelayar['demo'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="demo"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Site ayar yetki !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-menu-text-151']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="site_ayarlar" class="w-100" ><?=$diller['adminpanel-text-174']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="site_ayarlar" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="site_ayarlar" name="site_ayarlar" value="1"  onclick="ayarlar(this.checked);">
                                            <label class="custom-control-label" for="site_ayarlar"></label>
                                        </div>
                                    </div>
                                    <div id="ayarlar" class="w-100" style="display:none !important;">
                                        <div class="row pl-3">
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="ayar_yonet" class="w-100" ><?=$diller['adminpanel-text-175']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="ayar_yonet" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="ayar_yonet" name="ayar_yonet" value="1" checked>
                                                    <label class="custom-control-label" for="ayar_yonet"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="yonetici" class="w-100" ><?=$diller['adminpanel-text-176']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-177']?>"></i></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="yonetici" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="yonetici" name="yonetici" value="1" checked>
                                                    <label class="custom-control-label" for="yonetici"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="dil_yonet" class="w-100" ><?=$diller['adminpanel-text-178']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="dil_yonet" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="dil_yonet" name="dil_yonet" value="1" checked>
                                                    <label class="custom-control-label" for="dil_yonet"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="ayar_diger" class="w-100" ><?=$diller['adminpanel-text-179']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-180']?>"></i></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="ayar_diger" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="ayar_diger" name="ayar_diger" value="1" checked>
                                                    <label class="custom-control-label" for="ayar_diger"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Site ayar yetki SON !-->

                            <!-- Katalog/Ürün yetki !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-198']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="katalog" class="w-100" ><?=$diller['adminpanel-text-191']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="katalog" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="katalog" name="katalog" value="1"  onclick="katalogs(this.checked);">
                                            <label class="custom-control-label" for="katalog"></label>
                                        </div>
                                    </div>
                                    <div id="katalogs" class="w-100" style="display:none !important;">
                                        <div class="row pl-3">
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="urun" class="w-100" ><?=$diller['adminpanel-text-192']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="urun" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="urun" name="urun" value="1"checked>
                                                    <label class="custom-control-label" for="urun"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="kat" class="w-100" ><?=$diller['adminpanel-text-193']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="kat" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="kat" name="kat" value="1" checked>
                                                    <label class="custom-control-label" for="kat"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="marka" class="w-100" ><?=$diller['adminpanel-text-194']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="marka" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="marka" name="marka" value="1" checked>
                                                    <label class="custom-control-label" for="marka"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="varyant" class="w-100" ><?=$diller['adminpanel-text-195']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="varyant" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="varyant" name="varyant" value="1" checked>
                                                    <label class="custom-control-label" for="varyant"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="urun_yorum" class="w-100" ><?=$diller['adminpanel-text-196']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="urun_yorum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="urun_yorum" name="urun_yorum" value="1" checked>
                                                    <label class="custom-control-label" for="urun_yorum"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="toplu" class="w-100" ><?=$diller['adminpanel-text-197']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="toplu" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="toplu" name="toplu" value="1" checked>
                                                    <label class="custom-control-label" for="toplu"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Katalog/Ürün yetki SON !-->

                            <!-- Siparişler yetki !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-199']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="siparis" class="w-100" ><?=$diller['adminpanel-text-200']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="siparis" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="siparis" name="siparis" value="1"  onclick="orders(this.checked);">
                                            <label class="custom-control-label" for="siparis"></label>
                                        </div>
                                    </div>
                                    <div id="orders" class="w-100" style="display:none !important;">
                                        <div class="row pl-3">
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="siparis_yonet" class="w-100" ><?=$diller['adminpanel-text-201']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="siparis_yonet" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="siparis_yonet" name="siparis_yonet" value="1"checked>
                                                    <label class="custom-control-label" for="siparis_yonet"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="odeme_bildirim" class="w-100" ><?=$diller['adminpanel-text-202']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="odeme_bildirim" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="odeme_bildirim" name="odeme_bildirim" value="1" checked>
                                                    <label class="custom-control-label" for="odeme_bildirim"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="siparis_diger" class="w-100" ><?=$diller['adminpanel-text-203']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-204']?>"></i></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="siparis_diger" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="siparis_diger" name="siparis_diger" value="1" checked>
                                                    <label class="custom-control-label" for="siparis_diger"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Siparişler yetki SON !-->

                            <!-- Üyeler & Ticket yetki !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-205']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="uyelik" class="w-100" ><?=$diller['adminpanel-text-206']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="uyelik" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="uyelik" name="uyelik" value="1"  onclick="uyelers(this.checked);">
                                            <label class="custom-control-label" for="uyelik"></label>
                                        </div>
                                    </div>
                                    <div id="uyelers" class="w-100" style="display:none !important;">
                                        <div class="row pl-3">
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="uye_yonet" class="w-100" ><?=$diller['adminpanel-text-207']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="uye_yonet" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="uye_yonet" name="uye_yonet" value="1"checked>
                                                    <label class="custom-control-label" for="uye_yonet"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="ticket" class="w-100" ><?=$diller['adminpanel-text-208']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="ticket" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="ticket" name="ticket" value="1" checked>
                                                    <label class="custom-control-label" for="ticket"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="uyelik_ayar" class="w-100" ><?=$diller['adminpanel-text-209']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="uyelik_ayar" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="uyelik_ayar" name="uyelik_ayar" value="1" checked>
                                                    <label class="custom-control-label" for="uyelik_ayar"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="ziyaretci_istatistik" class="w-100" ><?=$diller['adminpanel-text-188']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="ziyaretci_istatistik" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="ziyaretci_istatistik" name="ziyaretci_istatistik" value="1" checked ">
                                                    <label class="custom-control-label" for="ziyaretci_istatistik"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Üyeler & Ticket yetki SON !-->


                            <!-- Kampanya yetki !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-217']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="kampanya" class="w-100" ><?=$diller['adminpanel-text-212']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="kampanya" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="kampanya" name="kampanya" value="1"  onclick="campaigne(this.checked);">
                                            <label class="custom-control-label" for="kampanya"></label>
                                        </div>
                                    </div>
                                    <div id="campaigne" class="w-100" style="display:none !important;">
                                        <div class="row pl-3">
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="indirimkod" class="w-100" ><?=$diller['adminpanel-text-213']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="indirimkod" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="indirimkod" name="indirimkod" value="1"checked>
                                                    <label class="custom-control-label" for="indirimkod"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="eposta_yonet" class="w-100" ><?=$diller['adminpanel-text-214']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="eposta_yonet" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="eposta_yonet" name="eposta_yonet" value="1" checked>
                                                    <label class="custom-control-label" for="eposta_yonet"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="sms_yonet" class="w-100" ><?=$diller['adminpanel-text-215']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="sms_yonet" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="sms_yonet" name="sms_yonet" value="1" checked>
                                                    <label class="custom-control-label" for="sms_yonet"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="bildirim_gonder" class="w-100" ><?=$diller['adminpanel-text-216']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="bildirim_gonder" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="bildirim_gonder" name="bildirim_gonder" value="1" checked>
                                                    <label class="custom-control-label" for="bildirim_gonder"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Kampanya yetki SON !-->


                            <!-- İçerik Yönetimi yetki !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-218']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="icerik_yonetim" class="w-100" ><?=$diller['adminpanel-text-219']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="icerik_yonetim" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="icerik_yonetim" name="icerik_yonetim" value="1"  onclick="modulyonet(this.checked);">
                                            <label class="custom-control-label" for="icerik_yonetim"></label>
                                        </div>
                                    </div>
                                    <div id="modulyonet" class="w-100" style="display:none !important;">
                                        <div class="row pl-3">
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="sayfa_yonet" class="w-100" ><?=$diller['adminpanel-text-220']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="sayfa_yonet" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="sayfa_yonet" name="sayfa_yonet" value="1"checked>
                                                    <label class="custom-control-label" for="sayfa_yonet"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="blog_hizmet" class="w-100" ><?=$diller['adminpanel-text-221']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="blog_hizmet" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="blog_hizmet" name="blog_hizmet" value="1" checked>
                                                    <label class="custom-control-label" for="blog_hizmet"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="galeri" class="w-100" ><?=$diller['adminpanel-text-222']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="galeri" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="galeri" name="galeri" value="1" checked>
                                                    <label class="custom-control-label" for="galeri"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="ptable" class="w-100" ><?=$diller['adminpanel-text-223']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="ptable" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="ptable" name="ptable" value="1" checked>
                                                    <label class="custom-control-label" for="ptable"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="icerik_diger" class="w-100" ><?=$diller['adminpanel-text-224']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="icerik_diger" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="icerik_diger" name="icerik_diger" value="1" checked>
                                                    <label class="custom-control-label" for="icerik_diger"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> İçerik Yönetimi yetki SON !-->

                            <!-- Modül !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-226']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="modul" class="w-100" ><?=$diller['adminpanel-text-227']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="modul" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="modul" name="modul" value="1"  onclick="icerikyonetim(this.checked);">
                                            <label class="custom-control-label" for="modul"></label>
                                        </div>
                                    </div>
                                    <div id="icerikyonetim" class="w-100" style="display:none !important;">
                                        <div class="row pl-3">
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="modul_header_footer" class="w-100" ><?=$diller['adminpanel-text-228']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="modul_header_footer" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="modul_header_footer" name="modul_header_footer" value="1"checked>
                                                    <label class="custom-control-label" for="modul_header_footer"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="sirala" class="w-100" ><?=$diller['adminpanel-text-229']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="sirala" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="sirala" name="sirala" value="1" checked>
                                                    <label class="custom-control-label" for="sirala"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="modul_vitrin" class="w-100" ><?=$diller['adminpanel-text-230']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="modul_vitrin" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="modul_vitrin" name="modul_vitrin" value="1" checked>
                                                    <label class="custom-control-label" for="modul_vitrin"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="modul_diger" class="w-100" ><?=$diller['adminpanel-text-231']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="modul_diger" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="modul_diger" name="modul_diger" value="1" checked>
                                                    <label class="custom-control-label" for="modul_diger"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Modül SON !-->

                            <!-- entegrasyon !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-232']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="entegrasyon" class="w-100" ><?=$diller['adminpanel-text-233']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="entegrasyon" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="entegrasyon" name="entegrasyon" value="1"  onclick="entegra(this.checked);">
                                            <label class="custom-control-label" for="entegrasyon"></label>
                                        </div>
                                    </div>
                                    <div id="entegra" class="w-100" style="display:none !important;">
                                        <div class="row pl-3">
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="entegrasyon_pazar" class="w-100" ><?=$diller['adminpanel-form-text-2153']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="entegrasyon_pazar" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="entegrasyon_pazar" name="entegrasyon_pazar" value="1"checked>
                                                    <label class="custom-control-label" for="entegrasyon_pazar"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="entegrasyon_urun" class="w-100" ><?=$diller['adminpanel-text-234']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="entegrasyon_urun" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="entegrasyon_urun" name="entegrasyon_urun" value="1"checked>
                                                    <label class="custom-control-label" for="entegrasyon_urun"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="entegrasyon_sms" class="w-100" ><?=$diller['adminpanel-text-235']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="entegrasyon_sms" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="entegrasyon_sms" name="entegrasyon_sms" value="1" checked>
                                                    <label class="custom-control-label" for="entegrasyon_sms"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="entegrasyon_eposta" class="w-100" ><?=$diller['adminpanel-text-236']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="entegrasyon_eposta" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="entegrasyon_eposta" name="entegrasyon_eposta" value="1" checked>
                                                    <label class="custom-control-label" for="entegrasyon_eposta"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="entegrasyon_map" class="w-100" ><?=$diller['adminpanel-text-237']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="entegrasyon_map" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="entegrasyon_map" name="entegrasyon_map" value="1" checked>
                                                    <label class="custom-control-label" for="entegrasyon_map"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-4">
                                                <label  for="parasut" class="w-100" >Paraşüt </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="parasut" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="parasut" name="parasut" value="1" checked>
                                                    <label class="custom-control-label" for="parasut"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> entegrasyon SON !-->

                            <!-- Diğer Yetki !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                        <?=$diller['adminpanel-text-181']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3 mb-4">
                                        <label  for="yapilandirma" class="w-100" ><?=$diller['adminpanel-text-225']?> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="yapilandirma" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="yapilandirma" name="yapilandirma" value="1" <?php if($panelayar['yapilandirma'] == '1'  ) { ?>checked<?php }?> ">
                                            <label class="custom-control-label" for="yapilandirma"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-4">
                                        <label  for="tema_ayarlar" class="w-100" ><?=$diller['adminpanel-text-182']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-183']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="tema_ayarlar" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="tema_ayarlar" name="tema_ayarlar" value="1" <?php if($panelayar['tema_ayarlar'] == '1'  ) { ?>checked<?php }?> ">
                                            <label class="custom-control-label" for="tema_ayarlar"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-4">
                                        <label  for="bell" class="w-100" ><?=$diller['adminpanel-text-184']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-185']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="bell" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="bell" name="bell" value="1" <?php if($panelayar['bell'] == '1'  ) { ?>checked<?php }?> ">
                                            <label class="custom-control-label" for="bell"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-4">
                                        <label  for="kisayol_ekle" class="w-100" ><?=$diller['adminpanel-text-186']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-187']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="kisayol_ekle" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="kisayol_ekle" name="kisayol_ekle" value="1" <?php if($panelayar['kisayol_ekle'] == '1'  ) { ?>checked<?php }?> ">
                                            <label class="custom-control-label" for="kisayol_ekle"></label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3 mb-4">
                                        <label  for="veriler" class="w-100" ><?=$diller['adminpanel-text-189']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-190']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="veriler" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="veriler" name="veriler" value="1" <?php if($panelayar['veriler'] == '1'  ) { ?>checked<?php }?> ">
                                            <label class="custom-control-label" for="veriler"></label>
                                        </div>
                                    </div>
                                           <div class="form-group col-md-3 mb-4">
                                        <label  for="gelenkutusu" class="w-100" ><?=$diller['adminpanel-text-210']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-211']?>"></i></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="gelenkutusu" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="gelenkutusu" name="gelenkutusu" value="1" <?php if($panelayar['gelenkutusu'] == '1'  ) { ?>checked<?php }?> ">
                                            <label class="custom-control-label" for="gelenkutusu"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Diğer Yetki SON !-->

                            <div class="w-100 border-top pt-3">
                                <button class="btn btn-success btn-block" name="perAdd">
                                    <?=$diller['adminpanel-form-text-53']?>
                                </button>
                            </div>

                        </form>
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
    function ayarlar(selected)
    {
        if (selected)
        {
            document.getElementById("ayarlar").style.display = "";
        } else

        {
            document.getElementById("ayarlar").style.display = "none";
        }

    }


    function katalogs(selected)
    {
        if (selected)
        {
            document.getElementById("katalogs").style.display = "";
        } else

        {
            document.getElementById("katalogs").style.display = "none";
        }

    }
        function orders(selected)
    {
        if (selected)
        {
            document.getElementById("orders").style.display = "";
        } else

        {
            document.getElementById("orders").style.display = "none";
        }

    }

 function uyelers(selected)
    {
        if (selected)
        {
            document.getElementById("uyelers").style.display = "";
        } else

        {
            document.getElementById("uyelers").style.display = "none";
        }

    }
 function campaigne(selected)
    {
        if (selected)
        {
            document.getElementById("campaigne").style.display = "";
        } else

        {
            document.getElementById("campaigne").style.display = "none";
        }

    }
    function icerikyonetim(selected)
    {
        if (selected)
        {
            document.getElementById("icerikyonetim").style.display = "";
        } else

        {
            document.getElementById("icerikyonetim").style.display = "none";
        }

    }
    function modulyonet(selected)
    {
        if (selected)
        {
            document.getElementById("modulyonet").style.display = "";
        } else

        {
            document.getElementById("modulyonet").style.display = "none";
        }

    }

    function entegra(selected)
    {
        if (selected)
        {
            document.getElementById("entegra").style.display = "";
        } else

        {
            document.getElementById("entegra").style.display = "none";
        }

    }
</script>