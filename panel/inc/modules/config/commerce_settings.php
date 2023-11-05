<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'commerce';
$siparisDurumKkart = $db->prepare("select * from siparis_durumlar where durum='1' order by sira asc ");
$siparisDurumKkart->execute();
$siparisDurumKkart2 = $db->prepare("select * from siparis_durumlar where durum='1' order by sira asc ");
$siparisDurumKkart2->execute();
?>
<title><?=$diller['adminpanel-menu-text-79']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-75']?></a>
                                <a href="pages.php?page=commerce_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-79']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['yapilandirma'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/config_leftbar.php'; ?>

                <!-- Contents !-->
                <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=commerce_settings_post">
                       <div class="row">
                           <div class="col-md-12">
                               <div class="card">
                                   <div class="card-body">
                                       <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 mb-2">
                                           <h4><?=$diller['adminpanel-menu-text-79']?></h4>
                                       </div>
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4 border-top pt-4">
                                                <label  for="sepet_sistemi" class="w-100 d-flex align-items-center justify-content-start flex-wrap" ><?=$diller['adminpanel-form-text-678']?> <?php if($odemeRow['sepet_sistemi'] == '0' ) { ?><i class="fa fa-exclamation-triangle ml-2 text-danger" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-679']?>"></i><?php }?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="sepet_sistemi" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="sepet_sistemi" name="sepet_sistemi" value="1"  <?php if($odemeRow['sepet_sistemi'] == '1'  ) { ?>checked<?php }?> ">
                                                    <label class="custom-control-label" for="sepet_sistemi"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4 ">
                                                <label  for="sepet_kupon" class="w-100 d-flex align-items-center justify-content-start flex-wrap" ><?=$diller['adminpanel-form-text-758']?> </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="sepet_kupon" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="sepet_kupon" name="sepet_kupon" value="1"  <?php if($odemeRow['sepet_kupon'] == '1'  ) { ?>checked<?php }?> ">
                                                    <label class="custom-control-label" for="sepet_kupon"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4">
                                                <label  for="uyesiz_alisveris" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-698']?>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="uyesiz_alisveris" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="uyesiz_alisveris" name="uyesiz_alisveris" value="1"  <?php if($odemeRow['uyesiz_alisveris'] == '1'  ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="uyesiz_alisveris"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4">
                                                <label for="sepet_href"><?=$diller['adminpanel-form-text-680']?></label>
                                                <select name="sepet_href" class="form-control" id="sepet_href" required>
                                                    <option value="0" <?php if($odemeRow['sepet_href'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-681']?></option>
                                                    <option value="1" <?php if($odemeRow['sepet_href'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-682']?></option>
                                                    <option value="2" <?php if($odemeRow['sepet_href'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-683']?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 mb-4 border-bottom pb-4">
                                                <label  for="wp_siparis" class="w-100" >
                                                    <?=$diller['adminpanel-form-text-684']?>
                                                    <br>
                                                    <small style="color:#999"><?=$diller['adminpanel-form-text-685']?></small></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="wp_siparis" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="wp_siparis" name="wp_siparis" value="1"  <?php if($odemeRow['wp_siparis'] == '1'  ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="wp_siparis"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mb-4 border-bottom pb-4">
                                                <label  for="wp_no" class="w-100" >WhatsApp No</label>
                                                <input type="number" name="wp_no" value="<?=$odemeRow['wp_no']?>" id="wp_no"  placeholder="905xxxxxxxxx"  class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 mb-4 border-bottom pb-4">
                                                <label  for="siparis_iptal" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-689']?>
                                                    <i class="ti-help-alt text-primary ml-2 text-danger" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-690']?>"></i>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="siparis_iptal" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="siparis_iptal" name="siparis_iptal" value="1"  <?php if($odemeRow['siparis_iptal'] == '1'  ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="siparis_iptal"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mb-4 border-bottom pb-4">
                                                <label  for="siparis_urun_iade" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-691']?>
                                                    <i class="ti-help-alt text-primary ml-2 text-danger" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-692']?>"></i>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="siparis_urun_iade" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="siparis_urun_iade" name="siparis_urun_iade" value="1"  <?php if($odemeRow['siparis_urun_iade'] == '1'  ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="siparis_urun_iade"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4">
                                                <label  for="urun_stok_dus" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-695']?>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="urun_stok_dus" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="urun_stok_dus" name="urun_stok_dus" value="1"  <?php if($odemeRow['urun_stok_dus'] == '1'  ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="urun_stok_dus"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4">
                                                <label  for="urun_stok_sinir" class="w-100" >
                                                   <?=$diller['adminpanel-form-text-693']?>
                                                    <br>
                                                    <small style="color:#999"><?=$diller['adminpanel-form-text-694']?></small>
                                                </label>
                                                <input type="number" min="0" name="urun_stok_sinir" value="<?=$odemeRow['urun_stok_sinir']?>" id="urun_stok_sinir"  class="form-control">
                                            </div>

                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4 ">
                                                <label  for="normalsiparis_durum" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                    <?=$diller['adminpanel-form-text-686']?>
                                                    <div><a href="pages.php?page=order_status" data-toggle="tooltip" target="_blank" data-placement="top" title="Sipariş Durumlarını Yönet" class="mr-2"><i class="fa fa-external-link-alt"></i></a> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-687']?>"></i></div>
                                                    <div class="w-100">
                                                        <small style="color: #999"><?=$diller['adminpanel-form-text-688']?></small>
                                                    </div>
                                                </label>
                                                <select name="normalsiparis_durum" class="form-control" id="normalsiparis_durum" required>
                                                    <?php foreach ($siparisDurumKkart as $durumKkart ) {?>
                                                        <option <?php if($durumKkart['id'] == $odemeRow['normalsiparis_durum']) { ?>selected<?php }?> value="<?=$durumKkart['id']?>"><?=$durumKkart['baslik']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 mb-4 border-bottom pb-4">
                                                <label  for="ucretsiz_alisveris" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-696']?>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="ucretsiz_alisveris" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="ucretsiz_alisveris" name="ucretsiz_alisveris" value="1"  <?php if($odemeRow['ucretsiz_alisveris'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);" >
                                                    <label class="custom-control-label" for="ucretsiz_alisveris"></label>
                                                </div>
                                            </div>
                                            <div id="actionBox" class="w-100 col-md-6 mb-4  border-bottom" <?php if($odemeRow['ucretsiz_alisveris'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                <div class="row">
                                                    <div class="form-group col-md-12 mb-4 pb-4 ">
                                                        <label  for="ucretsiz_alisveris_durum" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                            <?=$diller['adminpanel-form-text-697']?>
                                                            <div><a href="pages.php?page=order_status" data-toggle="tooltip" target="_blank" data-placement="top" title="Sipariş Durumlarını Yönet"><i class="fa fa-external-link-alt"></i></a> </div>
                                                        </label>
                                                        <select name="ucretsiz_alisveris_durum" class="form-control" id="ucretsiz_alisveris_durum" required>
                                                            <?php foreach ($siparisDurumKkart2 as $durumKkart2 ) {?>
                                                                <option <?php if($durumKkart2['id'] == $odemeRow['ucretsiz_alisveris_durum']) { ?>selected<?php }?> value="<?=$durumKkart2['id']?>"><?=$durumKkart2['baslik']?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4">
                                                <label  for="fiyat_gosterim_uyari" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-781']?>
                                                    <div class="mt-2" style="font-size: 12px ; font-weight: 300 ; color:#999">
                                                        <?=$diller['adminpanel-form-text-782']?>
                                                    </div>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="fiyat_gosterim_uyari" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="fiyat_gosterim_uyari" name="fiyat_gosterim_uyari" value="1"  <?php if($odemeRow['fiyat_gosterim_uyari'] == '1'  ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="fiyat_gosterim_uyari"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4">
                                                <label  for="urun_karsilastirma" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-699']?>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="urun_karsilastirma" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="urun_karsilastirma" name="urun_karsilastirma" value="1"  <?php if($odemeRow['urun_karsilastirma'] == '1'  ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="urun_karsilastirma"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mb-4 border-bottom pb-4">
                                                <label  for="faturasiz_teslimat" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-700']?>
                                                </label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="faturasiz_teslimat" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="faturasiz_teslimat" name="faturasiz_teslimat" value="1"  <?php if($odemeRow['faturasiz_teslimat'] == '1'  ) { ?>checked<?php }?> onclick="actionBox2(this.checked);" >
                                                    <label class="custom-control-label" for="faturasiz_teslimat"></label>
                                                </div>
                                            </div>
                                            <div id="actionBox2" class="w-100 col-md-6 mb-4  border-bottom" <?php if($odemeRow['faturasiz_teslimat'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-4">
                                                        <label  for="faturasiz_tc_zorunlu" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                            <?=$diller['adminpanel-form-text-701']?>
                                                        </label>
                                                        <div class="custom-control custom-switch custom-switch-lg">
                                                            <input type="hidden" name="faturasiz_tc_zorunlu" value="0"">
                                                            <input type="checkbox" class="custom-control-input" id="faturasiz_tc_zorunlu" name="faturasiz_tc_zorunlu" value="1"  <?php if($odemeRow['faturasiz_tc_zorunlu'] == '1'  ) { ?>checked<?php }?>  >
                                                            <label class="custom-control-label" for="faturasiz_tc_zorunlu"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4 border-bottom pb-4">
                                                <label  for="teslimat_sehir" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                    <?=$diller['adminpanel-form-text-702']?>
                                                    <small class="w-100 " style="color:#999">
                                                        <?=$diller['adminpanel-form-text-704']?>
                                                    </small>
                                                </label>
                                                <input type="text" name="teslimat_sehir" value="<?=$odemeRow['teslimat_sehir']?>" id="teslimat_sehir" class="form-control" placeholder="<?=$diller['adminpanel-form-text-703']?>">
                                            </div>
                                        </div>
                                       <div class="row mt-3">
                                           <div class="col-md-12">
                                               <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                </form>
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