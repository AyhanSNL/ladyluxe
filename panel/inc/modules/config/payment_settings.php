<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'payment';
$siparisDurumKkart = $db->prepare("select * from siparis_durumlar where durum='1' order by sira asc ");
$siparisDurumKkart->execute();
$siparisDurumKkart2 = $db->prepare("select * from siparis_durumlar where durum='1' order by sira asc ");
$siparisDurumKkart2->execute();
$siparisDurumKkart3 = $db->prepare("select * from siparis_durumlar where durum='1' order by sira asc ");
$siparisDurumKkart3->execute();
?>
<title><?=$diller['adminpanel-menu-text-76']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=payment_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-76']?></a>
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

                <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=payment_settings_post">
                       <div class="row">
                           <?php if($odemeRow['sepet_sistemi'] == '0' ) {?>
                               <div class="col-md-12 ">
                                   <div class="card border border-danger bg-white">
                                       <div class="card-body text-danger">
                                           <h6 class="text-uppercase"><?=$diller['adminpanel-modal-text-4']?></h6>
                                           <?=$diller['adminpanel-form-text-659']?>
                                       </div>
                                   </div>
                               </div>
                           <?php }?>
                           <div class="col-md-12">
                               <div class="card">
                                   <div class="card-body">
                                       <div class="in-header-page-main">
                                           <div class="in-header-page-text">
                                               <?=$diller['adminpanel-text-97']?>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="form-group col-md-12 mb-4">
                                               <label  for="kredi_kart" class="w-100"><?=$diller['adminpanel-form-text-62']?> </label>
                                               <div class="custom-control custom-switch custom-switch-lg">
                                                   <input type="hidden" name="kredi_kart" value="0"">
                                                   <input type="checkbox" class="custom-control-input" id="kredi_kart" name="kredi_kart" value="1" <?php if($odemeRow['kredi_kart'] == '1'  ) { ?>checked<?php }?> onclick="kKart(this.checked);">
                                                   <label class="custom-control-label" for="kredi_kart"></label>
                                               </div>
                                           </div>
                                           <div id="kKart" class="w-100 col-md-12" <?php if($odemeRow['kredi_kart'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                               <div class="row bg-light border rounded  m-0  p-3">
                                                   <div class="form-group col-md-12 mb-4">
                                                       <label  for="kredi_kart_siparis_durum" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                           <?=$diller['adminpanel-form-text-641']?>
                                                           <div>
                                                               <a href="pages.php?page=order_status" data-toggle="tooltip" target="_blank" data-placement="top" title="Sipariş Durumlarını Yönet" class="mr-2"><i class="fa fa-external-link-alt"></i></a>
                                                               <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-642']?>"></i>
                                                           </div>
                                                       </label>
                                                       <select name="kredi_kart_siparis_durum" class="form-control" id="kredi_kart_siparis_durum" required>
                                                           <?php foreach ($siparisDurumKkart as $durumKkart ) {?>
                                                               <option <?php if($durumKkart['id'] == $odemeRow['kredi_kart_siparis_durum']) { ?>selected<?php }?> value="<?=$durumKkart['id']?>"><?=$durumKkart['baslik']?></option>
                                                           <?php }?>
                                                       </select>
                                                   </div>
                                                   <div class="form-group col-md-12 ">
                                                       <label  for="kredi_kart_doviz_durum" class="w-100 d-flex align-items-center justify-content-between flex-wrap"><?=$diller['adminpanel-form-text-639']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-640']?>"></i>
                                                       </label>
                                                       <div class="custom-control custom-switch custom-switch-lg">
                                                           <input type="hidden" name="kredi_kart_doviz_durum" value="0"">
                                                           <input type="checkbox" class="custom-control-input" id="kredi_kart_doviz_durum" name="kredi_kart_doviz_durum" value="1" <?php if($odemeRow['kredi_kart_doviz_durum'] == '1'  ) { ?>checked<?php }?> >
                                                           <label class="custom-control-label" for="kredi_kart_doviz_durum"></label>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-12">
                               <div class="card">
                                   <div class="card-body">
                                       <div class="in-header-page-main">
                                           <div class="in-header-page-text">
                                               <?=$diller['adminpanel-text-98']?>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="form-group col-md-12 mb-4">
                                               <label  for="havale_eft" class="w-100"><?=$diller['adminpanel-form-text-62']?> </label>
                                               <div class="custom-control custom-switch custom-switch-lg">
                                                   <input type="hidden" name="havale_eft" value="0"">
                                                   <input type="checkbox" class="custom-control-input" id="havale_eft" name="havale_eft" value="1" <?php if($odemeRow['havale_eft'] == '1'  ) { ?>checked<?php }?> onclick="havaLe(this.checked);">
                                                   <label class="custom-control-label" for="havale_eft"></label>
                                               </div>
                                           </div>
                                           <div id="havaLe" class="w-100 col-md-12 " <?php if($odemeRow['havale_eft'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                               <div class="row bg-light border rounded  m-0  p-3">
                                                   <div class="form-group col-md-12 mb-4">
                                                       <label  for="havale_eft_siparis_durum" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                           <?=$diller['adminpanel-form-text-645']?>
                                                           <div><a href="pages.php?page=order_status" data-toggle="tooltip" target="_blank" data-placement="top" title="Sipariş Durumlarını Yönet" class="mr-2"><i class="fa fa-external-link-alt"></i></a> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-643']?>"></i></div>
                                                       </label>
                                                       <select name="havale_eft_siparis_durum" class="form-control" id="havale_eft_siparis_durum" required>
                                                           <?php foreach ($siparisDurumKkart2 as $durumKkart2 ) {?>
                                                               <option <?php if($durumKkart2['id'] == $odemeRow['havale_eft_siparis_durum']) { ?>selected<?php }?> value="<?=$durumKkart2['id']?>"><?=$durumKkart2['baslik']?></option>
                                                           <?php }?>
                                                       </select>
                                                   </div>
                                                   <div class="form-group col-md-12 mb-4">
                                                       <label  for="havale_doviz_durum" class="w-100 d-flex align-items-center justify-content-between flex-wrap"><?=$diller['adminpanel-form-text-639']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-644']?>"></i>
                                                       </label>
                                                       <div class="custom-control custom-switch custom-switch-lg">
                                                           <input type="hidden" name="havale_doviz_durum" value="0"">
                                                           <input type="checkbox" class="custom-control-input" id="havale_doviz_durum" name="havale_doviz_durum" value="1" <?php if($odemeRow['havale_doviz_durum'] == '1'  ) { ?>checked<?php }?> >
                                                           <label class="custom-control-label" for="havale_doviz_durum"></label>
                                                       </div>
                                                   </div>

                                                   <div class="form-group col-md-12 mb-4">
                                                       <label  for="havale_odeme_bildirim" class="w-100 d-flex align-items-center justify-content-between flex-wrap"><?=$diller['adminpanel-form-text-646']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-647']?>"></i>
                                                       </label>
                                                       <div class="custom-control custom-switch custom-switch-lg">
                                                           <input type="hidden" name="havale_odeme_bildirim" value="0"">
                                                           <input type="checkbox" class="custom-control-input" id="havale_odeme_bildirim" name="havale_odeme_bildirim" value="1" <?php if($odemeRow['havale_odeme_bildirim'] == '1'  ) { ?>checked<?php }?> >
                                                           <label class="custom-control-label" for="havale_odeme_bildirim"></label>
                                                       </div>
                                                   </div>
                                                   <div class="form-group col-md-12 ">
                                                       <label  for="havale_siparis_banka_button" class="w-100 d-flex align-items-center justify-content-between flex-wrap"><?=$diller['adminpanel-form-text-648']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-649']?>"></i></label>
                                                       <div class="custom-control custom-switch custom-switch-lg">
                                                           <input type="hidden" name="havale_siparis_banka_button" value="0"">
                                                           <input type="checkbox" class="custom-control-input" id="havale_siparis_banka_button" name="havale_siparis_banka_button" value="1" <?php if($odemeRow['havale_siparis_banka_button'] == '1'  ) { ?>checked<?php }?> >
                                                           <label class="custom-control-label" for="havale_siparis_banka_button"></label>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-12">
                               <div class="card">
                                   <div class="card-body">
                                       <div class="in-header-page-main">
                                           <div class="in-header-page-text">
                                               <?=$diller['adminpanel-form-text-650']?>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="form-group col-md-6 ">
                                               <label for="kapida_odeme_limit" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                   <?=$diller['adminpanel-form-text-651']?>
                                                   <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-652']?>"></i>
                                               </label>
                                               <div class="input-group mb-2">
                                                   <input type="text" class="form-control" id="kapida_odeme_limit" value="<?=$odemeRow['kapida_odeme_limit']?>" name="kapida_odeme_limit">
                                                   <div class="input-group-append">
                                                       <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="form-group col-md-6 mb-4">
                                               <label  for="kapida_odeme_siparis_durum" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                   <?=$diller['adminpanel-form-text-653']?>
                                                   <div><a href="pages.php?page=order_status" data-toggle="tooltip" target="_blank" data-placement="top" title="Sipariş Durumlarını Yönet" class="mr-2"><i class="fa fa-external-link-alt"></i></a> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-654']?>"></i></div>
                                               </label>
                                               <select name="kapida_odeme_siparis_durum" class="form-control" id="kapida_odeme_siparis_durum" required>
                                                   <?php foreach ($siparisDurumKkart3 as $durumKkart3 ) {?>
                                                       <option <?php if($durumKkart3['id'] == $odemeRow['kapida_odeme_siparis_durum']) { ?>selected<?php }?> value="<?=$durumKkart3['id']?>"><?=$durumKkart3['baslik']?></option>
                                                   <?php }?>
                                               </select>
                                           </div>
                                           <div class="form-group col-md-12 mb-4">
                                               <label  for="kapida_odeme_doviz_durum" class="w-100 d-flex align-items-center justify-content-between flex-wrap"><?=$diller['adminpanel-form-text-639']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-644']?>"></i>
                                               </label>
                                               <div class="custom-control custom-switch custom-switch-lg">
                                                   <input type="hidden" name="kapida_odeme_doviz_durum" value="0"">
                                                   <input type="checkbox" class="custom-control-input" id="kapida_odeme_doviz_durum" name="kapida_odeme_doviz_durum" value="1" <?php if($odemeRow['kapida_odeme_doviz_durum'] == '1'  ) { ?>checked<?php }?> >
                                                   <label class="custom-control-label" for="kapida_odeme_doviz_durum"></label>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="form-group col-md-6 mb-4">
                                               <label  for="kapida_odeme_kart" class="w-100"><?=$diller['adminpanel-text-99']?> </label>
                                               <div class="custom-control custom-switch custom-switch-lg">
                                                   <input type="hidden" name="kapida_odeme_kart" value="0"">
                                                   <input type="checkbox" class="custom-control-input" id="kapida_odeme_kart" name="kapida_odeme_kart" value="1" <?php if($odemeRow['kapida_odeme_kart'] == '1'  ) { ?>checked<?php }?> onclick="kaPi(this.checked);">
                                                   <label class="custom-control-label" for="kapida_odeme_kart"></label>
                                               </div>
                                           </div>
                                           <div id="kaPi" class="w-100 col-md-6 mb-5 " <?php if($odemeRow['kapida_odeme_kart'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                               <div class="row bg-light border rounded  m-0  p-4">
                                                   <div class="form-group col-md-12 mb-0 ">
                                                       <label for="kapida_odeme_kart_tutar" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                           <?=$diller['adminpanel-form-text-655']?>
                                                           <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-656']?>"></i>
                                                       </label>
                                                       <div class="input-group mb-2">
                                                           <input type="text" min="0" class="form-control" id="kapida_odeme_kart_tutar" value="<?=$odemeRow['kapida_odeme_kart_tutar']?>" name="kapida_odeme_kart_tutar">
                                                           <div class="input-group-append">
                                                               <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>

                                       </div>
                                       <div class="row">
                                           <div class="form-group col-md-6 mb-4">
                                               <label  for="kapida_odeme_nakit" class="w-100"><?=$diller['adminpanel-text-100']?> </label>
                                               <div class="custom-control custom-switch custom-switch-lg">
                                                   <input type="hidden" name="kapida_odeme_nakit" value="0"">
                                                   <input type="checkbox" class="custom-control-input" id="kapida_odeme_nakit" name="kapida_odeme_nakit" value="1" <?php if($odemeRow['kapida_odeme_nakit'] == '1'  ) { ?>checked<?php }?> onclick="kaPi2(this.checked);">
                                                   <label class="custom-control-label" for="kapida_odeme_nakit"></label>
                                               </div>
                                           </div>
                                           <div id="kaPi2" class="w-100 col-md-6 " <?php if($odemeRow['kapida_odeme_nakit'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                               <div class="row bg-light border rounded  m-0  p-4">
                                                   <div class="form-group col-md-12 mb-0 ">
                                                       <label for="kapida_odeme_nakit_tutar" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                           <?=$diller['adminpanel-form-text-657']?>
                                                           <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-658']?>"></i>
                                                       </label>
                                                       <div class="input-group mb-2">
                                                           <input type="text" min="0" class="form-control" id="kapida_odeme_nakit_tutar" value="<?=$odemeRow['kapida_odeme_nakit_tutar']?>" name="kapida_odeme_nakit_tutar">
                                                           <div class="input-group-append">
                                                               <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-12">
                               <div class="card">
                                   <div class="card-body">
                                       <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
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
    function kKart(selected)
    {
        if (selected)
        {
            document.getElementById("kKart").style.display = "";
        } else

        {
            document.getElementById("kKart").style.display = "none";
        }

    }
    function havaLe(selected)
    {
        if (selected)
        {
            document.getElementById("havaLe").style.display = "";
        } else

        {
            document.getElementById("havaLe").style.display = "none";
        }

    }
    function kaPi(selected)
    {
        if (selected)
        {
            document.getElementById("kaPi").style.display = "";
        } else

        {
            document.getElementById("kaPi").style.display = "none";
        }

    }
    function kaPi2(selected)
    {
        if (selected)
        {
            document.getElementById("kaPi2").style.display = "";
        } else

        {
            document.getElementById("kaPi2").style.display = "none";
        }

    }
</script>