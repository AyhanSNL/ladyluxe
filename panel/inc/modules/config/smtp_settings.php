<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'smtp';
?>
<title><?=$diller['adminpanel-menu-text-35']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=smtp_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-35']?></a>
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
                                <div class="d-none d-md-inline-block p-2  font-14"><?=$diller['adminpanel-form-text-783']?></div>
                                <div class="d-md-none d-sm-inline-block" style="font-size: 12px ;"><?=$diller['adminpanel-form-text-787']?></div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link saas " id="oto-mail-tab" data-toggle="tab" href="#oto-mail" role="tab" aria-controls="home" aria-selected="true">
                                <div class="d-none  p-2 font-14 d-md-inline-block"><?=$diller['adminpanel-form-text-785']?></div>
                                <div class="d-md-none d-sm-inline-block"  style="font-size: 12px ;"><?=$diller['adminpanel-form-text-786']?></div>
                            </a>
                        </li>
                    </ul>
                    <!--  <========SON=========>>> Tab headers SON !-->

                    <!-- Tab Contents !-->
                    <div class="tab-content bg-white border border-top-0 rounded-bottom">
                        <!-- Settings Tab !-->
                        <div class="tab-pane active p-3 " id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form method="post" action="post.php?process=smtp_settings_post&status=main_update">
                            <div class="row mt-3 pl-2 pr-2" >
                                <div class="form-group col-md-12 mb-4">
                                    <label  for="smtp_durum" class="w-100"><?=$diller['adminpanel-form-text-790']?></label>
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="hidden" name="smtp_durum" value="0"">
                                        <input type="checkbox" class="custom-control-input" id="smtp_durum" name="smtp_durum" value="1" <?php if($ayar['smtp_durum'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                        <label class="custom-control-label" for="smtp_durum"></label>
                                    </div>
                                </div>
                                <div id="actionBox" class="w-100 col-md-12 " <?php if($ayar['smtp_durum'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="smtp_host"><?=$diller['adminpanel-form-text-791']?></label>
                                            <input type="text" id="smtp_host"  class="form-control" autocomplete="off" name="smtp_host" value="<?=$ayar['smtp_host']?>" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="smtp_mail"><?=$diller['adminpanel-form-text-792']?></label>
                                            <input type="text" id="smtp_mail"  class="form-control" autocomplete="off" name="smtp_mail" value="<?=$ayar['smtp_mail']?>" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="smtp_pass"><?=$diller['adminpanel-form-text-793']?></label>
                                            <input type="text" id="smtp_pass"  class="form-control" autocomplete="off" name="smtp_pass" value="<?=$ayar['smtp_pass']?>" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="smtp_port"><?=$diller['adminpanel-form-text-794']?></label>
                                            <input type="text" id="smtp_port"  class="form-control" autocomplete="off" name="smtp_port" value="<?=$ayar['smtp_port']?>" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="smtp_protokol"><?=$diller['adminpanel-form-text-795']?></label>
                                            <select name="smtp_protokol" id="smtp_protokol" class="form-control" >
                                                <option value="0" <?php if($ayar['smtp_protokol'] === '0') {?>selected <?php }?>   ><?=$diller['adminpanel-form-text-796']?></option>
                                                <option value="tls" <?php if($ayar['smtp_protokol'] === 'tls') {?>selected <?php }?> >TLS</option>
                                                <option value="ssl" <?php if($ayar['smtp_protokol'] === 'ssl') {?>selected <?php }?> >SSL</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <div class="bg-light w-100 border p-3 rounded">
                                                <label for="smtp_bildirim_mail"><?=$diller['adminpanel-form-text-784']?></label>
                                                <input type="text" id="smtp_bildirim_mail"  class="form-control" autocomplete="off" name="smtp_bildirim_mail" value="<?=$ayar['smtp_bildirim_mail']?>" >
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12  ">
                                            <div class=" w-100 border p-3 mb-2 rounded alert alert-dismissible alert-warning border-warning text-dark">
                                                <div style="font-size: 18px ; font-weight: 600; margin-bottom: 10px;"><?=$diller['adminpanel-form-text-821']?></div>
                                                <div style="font-size: 14px ;">
                                                    <?=$diller['adminpanel-form-text-822']?>
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
                        <div class="tab-pane  p-3 " id="oto-mail" role="tabpanel" aria-labelledby="oto-mail-tab">

                            <?php if($ayar['smtp_durum'] == '1' ) {?>
                                <form method="post" action="post.php?process=smtp_settings_post&status=auto_messages">
                                <div class="p-3 mt-1 border border-warning alert-warning text-dark mb-3" style="font-size: 14px ;">
                                   <i class="fa fa-info-circle"></i> <?=$diller['adminpanel-form-text-789']?>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-788']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_iletisim_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_iletisim_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_iletisim_site" name="smtp_iletisim_site" value="1"  <?php if($ayar['smtp_iletisim_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_iletisim_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="smtp_iletisim_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_iletisim_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_iletisim_user" name="smtp_iletisim_user" value="1"  <?php if($ayar['smtp_iletisim_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_iletisim_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-799']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_bulten_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_bulten_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_bulten_site" name="smtp_bulten_site" value="1"  <?php if($ayar['smtp_bulten_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_bulten_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_bulten_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_bulten_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_bulten_user" name="smtp_bulten_user" value="1"  <?php if($ayar['smtp_bulten_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_bulten_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-801']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_urun_yorum_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_urun_yorum_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_urun_yorum_site" name="smtp_urun_yorum_site" value="1"  <?php if($ayar['smtp_urun_yorum_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_urun_yorum_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_urun_yorum_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_urun_yorum_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_urun_yorum_user" name="smtp_urun_yorum_user" value="1"  <?php if($ayar['smtp_urun_yorum_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_urun_yorum_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-802']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_modul_yorum_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_modul_yorum_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_modul_yorum_site" name="smtp_modul_yorum_site" value="1"  <?php if($ayar['smtp_modul_yorum_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_modul_yorum_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_modul_yorum_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_modul_yorum_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_modul_yorum_user" name="smtp_modul_yorum_user" value="1"  <?php if($ayar['smtp_modul_yorum_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_modul_yorum_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-803']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_siparis_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_siparis_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_siparis_site" name="smtp_siparis_site" value="1"  <?php if($ayar['smtp_siparis_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_siparis_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_siparis_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_siparis_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_siparis_user" name="smtp_siparis_user" value="1"  <?php if($ayar['smtp_siparis_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_siparis_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-804']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_normalsiparis_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_normalsiparis_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_normalsiparis_site" name="smtp_normalsiparis_site" value="1"  <?php if($ayar['smtp_normalsiparis_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_normalsiparis_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_normalsiparis_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_normalsiparis_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_normalsiparis_user" name="smtp_normalsiparis_user" value="1"  <?php if($ayar['smtp_normalsiparis_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_normalsiparis_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-805']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_teklif_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_teklif_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_teklif_site" name="smtp_teklif_site" value="1"  <?php if($ayar['smtp_teklif_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_teklif_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_teklif_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_teklif_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_teklif_user" name="smtp_teklif_user" value="1"  <?php if($ayar['smtp_teklif_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_teklif_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-806']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_uyelik_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_uyelik_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_uyelik_site" name="smtp_uyelik_site" value="1"  <?php if($ayar['smtp_uyelik_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_uyelik_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_uyelik_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_uyelik_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_uyelik_user" name="smtp_uyelik_user" value="1"  <?php if($ayar['smtp_uyelik_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_uyelik_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-807']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_ticket_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_ticket_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_ticket_site" name="smtp_ticket_site" value="1"  <?php if($ayar['smtp_ticket_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_ticket_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_ticket_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_ticket_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_ticket_user" name="smtp_ticket_user" value="1"  <?php if($ayar['smtp_ticket_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_ticket_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-808']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_iptalsiparis_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_iptalsiparis_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_iptalsiparis_site" name="smtp_iptalsiparis_site" value="1"  <?php if($ayar['smtp_iptalsiparis_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_iptalsiparis_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_iptalsiparis_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_iptalsiparis_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_iptalsiparis_user" name="smtp_iptalsiparis_user" value="1"  <?php if($ayar['smtp_iptalsiparis_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_iptalsiparis_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-809']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_uruniade_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_uruniade_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_uruniade_site" name="smtp_uruniade_site" value="1"  <?php if($ayar['smtp_uruniade_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_uruniade_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_uruniade_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_uruniade_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_uruniade_user" name="smtp_uruniade_user" value="1"  <?php if($ayar['smtp_uruniade_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_uruniade_user"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="border shadow-sm  mb-3">
                                            <div class="bg-light border-bottom pl-3 pr-3 pt-2 pb-2" style="font-size: 16px ; font-weight: 500;">
                                                <?=$diller['adminpanel-form-text-810']?>
                                            </div>
                                            <div class="row p-3 ">
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_odeme_site" class="w-100" ><?=$diller['adminpanel-form-text-797']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_odeme_site" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_odeme_site" name="smtp_odeme_site" value="1"  <?php if($ayar['smtp_odeme_site'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_odeme_site"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 ">
                                                    <label  for="smtp_odeme_user" class="w-100" ><?=$diller['adminpanel-form-text-798']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="smtp_odeme_user" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="smtp_odeme_user" name="smtp_odeme_user" value="1"  <?php if($ayar['smtp_odeme_user'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="smtp_odeme_user"></label>
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
                               <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-800']?>
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
<?php if($_SESSION['tab_select'] == 'oto'  ) {?>
    $('#oto-mail-tab').addClass('active');
    $('#oto-mail').addClass('active');

    $('#settings').removeClass('active');
    $('#settings-tab').removeClass('active');
    <?php
    unset($_SESSION['tab_select']);
    ?>
<?php }?>
</script>