<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'sms';

$smsAyarlar = $db->prepare("select * from sms where id='1' ");
$smsAyarlar->execute();
$sms = $smsAyarlar->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-39']?> - <?=$panelayar['baslik']?></title>
<style>
    .nav-link{
        color: #000;
        transition-duration: 0.1s; transition-timing-function: linear;
        font-weight: 500;
    }
    .saas:hover{
        background-color: #fff;
        color: #000;
    }
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-75']?></a>
                                <a href="pages.php?page=sms_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-39']?></a>
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

                <!-- Smtp Ayarları !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">



                    <!-- Tab headers !-->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link saas  active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="home" aria-selected="true">
                                <div class="d-none d-md-inline-block p-2  font-14"><?=$diller['adminpanel-menu-text-39']?></div>
                                <div class="d-md-none d-sm-inline-block" style="font-size: 12px ;"><?=$diller['adminpanel-form-text-787']?></div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  saas" id="oto-sms-tab" data-toggle="tab" href="#oto-sms" role="tab" aria-controls="home" aria-selected="true">
                                <div class="d-none  p-2 font-14 d-md-inline-block"><?=$diller['adminpanel-form-text-812']?></div>
                                <div class="d-md-none d-sm-inline-block"  style="font-size: 12px ;"><?=$diller['adminpanel-form-text-813']?></div>
                            </a>
                        </li>
                    </ul>
                    <!--  <========SON=========>>> Tab headers SON !-->

                    <!-- Tab Contents !-->
                    <div class="tab-content bg-white border border-top-0 rounded-bottom">
                        <!-- Settings Tab !-->
                        <div class="tab-pane active p-3 " id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form method="post" action="post.php?process=sms_settings_post&status=main_update">
                            <div class="row mt-3 pl-2 pr-2" >
                                <div class="form-group col-md-12 mb-4">
                                    <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-811']?></label>
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="hidden" name="durum" value="0"">
                                        <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" <?php if($sms['durum'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                        <label class="custom-control-label" for="durum"></label>
                                    </div>
                                </div>
                                <div id="actionBox" class="w-100 col-md-12 " <?php if($sms['durum'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                    <div class="row">

                                        <div class="form-group col-md-12 ">
                                            <div class="bg-light w-100 border p-3 rounded">
                                                <label for="bildirim_numara"><?=$diller['adminpanel-form-text-815']?></label>
                                                <input type="number" id="bildirim_numara"  class="form-control" autocomplete="off" name="bildirim_numara"   value="<?=$sms['bildirim_numara']?>"  placeholder="5xxxxxxxxx">
                                            </div>
                                        </div>



                                        <div class="form-group col-md-12">
                                            <label  for="sms_firma" class="w-100"><?=$diller['adminpanel-form-text-816']?></label>
                                            <select name="sms_firma" class="form-control" id="sms_firma" style="height:50px" >
                                                <option value="netgsm" <?php if($sms['sms_firma'] == 'netgsm'  ) { ?>selected<?php }?>>NetGSM</option>
                                                <option value="iletimerkezi" <?php if($sms['sms_firma'] == 'iletimerkezi'  ) { ?>selected<?php }?>>İleti Merkezi</option>
                                            </select>
                                        </div>
                                        <div id="netgsm-choise" class="col-md-12 mb-3 " <?php if($sms['sms_firma'] != 'netgsm'  ) { ?>style="display: none" <?php }?> >
                                            <div class="w-100 p-3 border rounded-top  ">
                                                <div class="col-md-12">
                                                    <img  src="assets/images/uploads/netgsm.png" style="max-width: 100px">
                                                </div>
                                            </div>
                                            <div class="row bg-light border  m-0 border-top-0 p-3">
                                                <div class="form-group col-md-12 mb-4 mt-3">
                                                    <label for="netgsm_user"><?=$diller['adminpanel-form-text-818']?></label>
                                                    <input type="text" autocomplete="off" name="netgsm_user" value="<?=$sms['netgsm_user']?>" id="netgsm_user"   class="form-control">
                                                </div>
                                                <div class="form-group col-md-12 mb-4">
                                                    <label for="netgsm_pass"><?=$diller['adminpanel-form-text-819']?></label>
                                                    <input type="text" autocomplete="off" name="netgsm_pass" value="<?=$sms['netgsm_pass']?>" id="netgsm_pass"   class="form-control">
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                    <label for="netgsm_baslik"><?=$diller['adminpanel-form-text-817']?></label>
                                                    <input type="text" autocomplete="off" name="netgsm_baslik" value="<?=$sms['netgsm_baslik']?>" id="netgsm_baslik"   class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="iletimerkezi-choise" class="col-md-12 mb-3 " <?php if($sms['sms_firma'] != 'iletimerkezi'  ) { ?>style="display: none" <?php }?> >
                                            <div class="w-100 p-3 border border-danger rounded-top bg-danger " style="background-color: #bc183d!important;">
                                                <div class="col-md-12">
                                                    <img  src="assets/images/uploads/iletimerkezi.png" style="max-width: 100px">
                                                </div>
                                            </div>
                                            <div class="row bg-light border  m-0 border-top-0 p-3">
                                                <div class="form-group col-md-12 mb-4 mt-3">
                                                    <label for="iletimerkezi_user"><?=$diller['adminpanel-form-text-824']?></label>
                                                    <input type="text" autocomplete="off" name="iletimerkezi_user" value="<?=$sms['iletimerkezi_user']?>" id="iletimerkezi_user"   class="form-control">
                                                </div>
                                                <div class="form-group col-md-12 mb-4">
                                                    <label for="iletimerkezi_pass"><?=$diller['adminpanel-form-text-825']?></label>
                                                    <input type="text" autocomplete="off" name="iletimerkezi_pass" value="<?=$sms['iletimerkezi_pass']?>" id="iletimerkezi_pass"   class="form-control">
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                    <label for="iletimerkezi_baslik"><?=$diller['adminpanel-form-text-823']?></label>
                                                    <input type="text" autocomplete="off" name="iletimerkezi_baslik" value="<?=$sms['iletimerkezi_baslik']?>" id="iletimerkezi_baslik"   class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12  ">
                                            <div class=" w-100 border p-3 mb-2 rounded alert alert-dismissible alert-warning border-warning text-dark">
                                                <div style="font-size: 18px ; font-weight: 600; margin-bottom: 10px;"><?=$diller['adminpanel-form-text-821']?></div>
                                                <div style="font-size: 14px ;">
                                                    <?=$diller['adminpanel-form-text-820']?>
                                                </div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                    <div class="col-md-12 mb-0">
                                        <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                    </div>
                            </div>

                            </form>
                        </div>
                        <!--  <========SON=========>>> Settings Tab SON !-->

                        <!-- Auto E-Mail Tab !-->
                        <div class="tab-pane  p-3 " id="oto-sms" role="tabpanel" aria-labelledby="oto-sms-tab">

                            <?php if($sms['durum'] == '1' ) {?>
                                <form method="post" action="post.php?process=sms_settings_post&status=auto_messages">
                                <div class="p-3 mt-1 border border-warning alert-warning text-dark mb-3" style="font-size: 14px ;">
                                   <i class="fa fa-info-circle"></i> <?=$diller['adminpanel-form-text-832']?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-828']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_siparis_site" class="w-100" ><?=$diller['adminpanel-form-text-826']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_siparis_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_siparis_site" name="sms_siparis_site" value="1"  <?php if($sms['sms_siparis_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_siparis_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="sms_siparis_user" class="w-100" ><?=$diller['adminpanel-form-text-827']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_siparis_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_siparis_user" name="sms_siparis_user" value="1"  <?php if($sms['sms_siparis_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_siparis_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-829']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_ticket_site" class="w-100" ><?=$diller['adminpanel-form-text-826']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_ticket_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_ticket_site" name="sms_ticket_site" value="1"  <?php if($sms['sms_ticket_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_ticket_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_ticket_user" class="w-100" ><?=$diller['adminpanel-form-text-827']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_ticket_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_ticket_user" name="sms_ticket_user" value="1"  <?php if($sms['sms_ticket_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_ticket_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-830']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_odeme_site" class="w-100" ><?=$diller['adminpanel-form-text-826']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_odeme_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_odeme_site" name="sms_odeme_site" value="1"  <?php if($sms['sms_odeme_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_odeme_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_odeme_user" class="w-100" ><?=$diller['adminpanel-form-text-827']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_odeme_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_odeme_user" name="sms_odeme_user" value="1"  <?php if($sms['sms_odeme_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_odeme_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-831']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_siparisiptal_site" class="w-100" ><?=$diller['adminpanel-form-text-826']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_siparisiptal_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_siparisiptal_site" name="sms_siparisiptal_site" value="1"  <?php if($sms['sms_siparisiptal_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_siparisiptal_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_siparisiptal_user" class="w-100" ><?=$diller['adminpanel-form-text-827']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_siparisiptal_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_siparisiptal_user" name="sms_siparisiptal_user" value="1"  <?php if($sms['sms_siparisiptal_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_siparisiptal_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-833']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_uruniade_site" class="w-100" ><?=$diller['adminpanel-form-text-826']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_uruniade_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_uruniade_site" name="sms_uruniade_site" value="1"  <?php if($sms['sms_uruniade_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_uruniade_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_uruniade_user" class="w-100" ><?=$diller['adminpanel-form-text-827']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_uruniade_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_uruniade_user" name="sms_uruniade_user" value="1"  <?php if($sms['sms_uruniade_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_uruniade_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-834']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_normalsiparis_site" class="w-100" ><?=$diller['adminpanel-form-text-826']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_normalsiparis_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_normalsiparis_site" name="sms_normalsiparis_site" value="1"  <?php if($sms['sms_normalsiparis_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_normalsiparis_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_normalsiparis_user" class="w-100" ><?=$diller['adminpanel-form-text-827']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_normalsiparis_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_normalsiparis_user" name="sms_normalsiparis_user" value="1"  <?php if($sms['sms_normalsiparis_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_normalsiparis_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-835']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_teklif_site" class="w-100" ><?=$diller['adminpanel-form-text-826']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_teklif_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_teklif_site" name="sms_teklif_site" value="1"  <?php if($sms['sms_teklif_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_teklif_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="sms_teklif_user" class="w-100" ><?=$diller['adminpanel-form-text-827']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="sms_teklif_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="sms_teklif_user" name="sms_teklif_user" value="1"  <?php if($sms['sms_teklif_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="sms_teklif_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-0">
                                        <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                    </div>
                                </div>
                                </form>
                            <?php }else { ?>
                            <div class="bg-light border  p-3">
                               <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-814']?>
                            </div>
                            <?php }?>


                        </div>
                        <!--  <========SON=========>>> Auto E-Mail Tab SON !-->
                    </div>
                    <!--  <========SON=========>>> Tab Contents SON !-->


                </div>
                <!--  <========SON=========>>> Smtp Ayarları SON !-->


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
    $('#sms_firma').on('change', function() {
        $('#netgsm-choise').css('display', 'none');
        if ( $(this).val() === 'netgsm' ) {
            $('#netgsm-choise').css('display', 'block');
        }
        $('#iletimerkezi-choise').css('display', 'none');
        if ( $(this).val() === 'iletimerkezi' ) {
            $('#iletimerkezi-choise').css('display', 'block');
        }

    });
<?php if($_SESSION['tab_select'] == 'oto'  ) {?>
    $('#oto-sms-tab').addClass('active');
    $('#oto-sms').addClass('active');

    $('#settings').removeClass('active');
    $('#settings-tab').removeClass('active');
    <?php
    unset($_SESSION['tab_select']);
    ?>
<?php }?>
</script>