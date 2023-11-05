<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'pos';
?>
<title><?=$diller['adminpanel-menu-text-77']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=pos_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-77']?></a>
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

                <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=pos_settings_post">
                       <div class="row">
               <!-- Sepet Uyarısı !-->
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
               <!--  <========SON=========>>> Sepet Uyarısı SON !-->
                           <div class="col-md-12">
                               <div class="card">
                                   <div class="card-body">
                                       <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 mb-2">
                                           <h4><?=$diller['adminpanel-menu-text-77']?></h4>
                                       </div>
                                       <div class="row">
                                           <div class="form-group col-md-12">
                                               <label  for="pos_tur" class="w-100"><?=$diller['adminpanel-form-text-660']?></label>
                                               <select name="pos_tur" class="form-control" id="pos_tur" style="height:50px" >
                                                   <option value="paytr" <?php if($odemeRow['pos_tur'] == 'paytr'  ) { ?>selected<?php }?>>Paytr</option>
                                                   <option value="iyzico" <?php if($odemeRow['pos_tur'] == 'iyzico'  ) { ?>selected<?php }?>>İyzico</option>
                                                   <option value="shopier" <?php if($odemeRow['pos_tur'] == 'shopier'  ) { ?>selected<?php }?>>Shopier</option>
                                               </select>
                                           </div>
                                           <div id="paytr-choise" class="col-md-12 " <?php if($odemeRow['pos_tur'] != 'paytr'  ) { ?>style="display: none" <?php }?> >
                                               <div class="w-100 p-3 border rounded-top  ">
                                                   <div class="col-md-12">
                                                       <img  src="assets/images/uploads/paytr.png" style="max-width: 100px">
                                                   </div>
                                               </div>
                                               <div class="row bg-light border  m-0 border-top-0 p-3">
                                                    <div class="form-group col-md-12 mb-4 mt-3">
                                                        <label for="paytr_id">PAYTR - Merchant ID</label>
                                                        <input type="text" autocomplete="off" name="paytr_id" value="<?=$odemeRow['paytr_id']?>" id="paytr_id"   class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="paytr_key">PAYTR - Merchant Key</label>
                                                        <input type="text" autocomplete="off" name="paytr_key" value="<?=$odemeRow['paytr_key']?>" id="paytr_key"   class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12 ">
                                                        <label for="paytr_salt">PAYTR - Merchant Salt</label>
                                                        <input type="text" autocomplete="off" name="paytr_salt" value="<?=$odemeRow['paytr_salt']?>" id="paytr_salt"   class="form-control">
                                                    </div>
                                               </div>
                                               <div class="row border  m-0 border-top-0 p-3">
                                                   <div class="form-group col-md-4 ">
                                                       <label for="taksit_max_paytr" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                           <?=$diller['adminpanel-form-text-663']?>
                                                           <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-670']?>"></i>
                                                       </label>
                                                       <input type="text" autocomplete="off" name="taksit_max_paytr" value="<?=$odemeRow['taksit_max_paytr']?>" id="taksit_max_paytr"   class="form-control">
                                                   </div>
                                                   <div class="form-group col-md-4 ">
                                                       <label for="paytr_tasarim"><?=$diller['adminpanel-form-text-665']?></label>
                                                       <select name="paytr_tasarim" class="form-control" id="paytr_tasarim" required>
                                                           <option value="1" <?php if($odemeRow['paytr_tasarim'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-666']?></option>
                                                           <option value="2" <?php if($odemeRow['paytr_tasarim'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-9']?></option>
                                                       </select>
                                                   </div>
                                                   <div class="form-group col-md-4 ">
                                                       <label  for="paytr_test" class="w-100" ><?=$diller['adminpanel-form-text-667']?></label>
                                                       <div class="custom-control custom-switch custom-switch-lg">
                                                           <input type="hidden" name="paytr_test" value="0"">
                                                           <input type="checkbox" class="custom-control-input" id="paytr_test" name="paytr_test" value="1"  <?php if($odemeRow['paytr_test'] == '1'  ) { ?>checked<?php }?> ">
                                                           <label class="custom-control-label" for="paytr_test"></label>
                                                       </div>
                                                   </div>
                                               </div>
                                               <div class="w-100 p-3 border rounded-bottom border-top-0  ">
                                                    <div class="col-md-12">
                                                        <strong><?=$diller['adminpanel-form-text-661']?></strong>
                                                        <br>
                                                        <small><?=$diller['adminpanel-form-text-662']?></small>
                                                        <div class="w-100 mt-3">
                                                            <input type="text" autocomplete="off" disabled value="<?=$ayar['site_url']?>masterpiece.php?sayfa=paytr_bildirim"   class="form-control">
                                                        </div>
                                                    </div>
                                               </div>


                                           </div>

                                           <div id="iyzico-choise" class="col-md-12" <?php if($odemeRow['pos_tur'] != 'iyzico'  ) { ?>style="display: none" <?php }?> >
                                               <div class="w-100 p-3 bg-info border border-info rounded-top  ">
                                                   <div class="col-md-12">
                                                       <img  src="assets/images/uploads/iyzico.png" style="max-width: 80px">
                                                   </div>
                                               </div>
                                               <div class="row bg-light border  m-0 border-top-0 p-3">
                                                   <div class="form-group col-md-12 mb-4 mt-3">
                                                       <label for="iyzico_key">Iyzico - API Key</label>
                                                       <input type="text" autocomplete="off" name="iyzico_key" value="<?=$odemeRow['iyzico_key']?>" id="iyzico_key"   class="form-control">
                                                   </div>
                                                   <div class="form-group col-md-12">
                                                       <label for="iyzico_secure">Iyzico - Secure Key</label>
                                                       <input type="text" autocomplete="off" name="iyzico_secure" value="<?=$odemeRow['iyzico_secure']?>" id="iyzico_secure"   class="form-control">
                                                   </div>
                                               </div>
                                               <div class="row border rounded-bottom m-0 border-top-0 p-3">
                                                   <div class="form-group col-md-12 ">
                                                       <label for="iyzico_taksit_sayi"><?=$diller['adminpanel-form-text-664']?></label>
                                                       <select name="iyzico_taksit_sayi" class="form-control" id="iyzico_taksit_sayi" required>
                                                           <option value="0" <?php if($odemeRow['iyzico_taksit_sayi'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-668']?></option>
                                                           <option value="1" <?php if($odemeRow['iyzico_taksit_sayi'] == '1'  ) { ?>selected<?php }?>>2 <?=$diller['adminpanel-form-text-669']?></option>
                                                           <option value="2" <?php if($odemeRow['iyzico_taksit_sayi'] == '2'  ) { ?>selected<?php }?>>2, 3 <?=$diller['adminpanel-form-text-669']?></option>
                                                           <option value="3" <?php if($odemeRow['iyzico_taksit_sayi'] == '3'  ) { ?>selected<?php }?>>2, 3, 6 <?=$diller['adminpanel-form-text-669']?></option>
                                                           <option value="4" <?php if($odemeRow['iyzico_taksit_sayi'] == '4'  ) { ?>selected<?php }?>>2, 3, 6, 9 <?=$diller['adminpanel-form-text-669']?></option>
                                                           <option value="5" <?php if($odemeRow['iyzico_taksit_sayi'] == '5'  ) { ?>selected<?php }?>>2, 3, 6, 9, 12 <?=$diller['adminpanel-form-text-669']?></option>
                                                       </select>
                                                   </div>
                                                   <div class="form-group col-md-4 ">
                                                       <label  for="iyzico_test" class="w-100" ><?=$diller['adminpanel-form-text-667']?></label>
                                                       <div class="custom-control custom-switch custom-switch-lg">
                                                           <input type="hidden" name="iyzico_test" value="0"">
                                                           <input type="checkbox" class="custom-control-input" id="iyzico_test" name="iyzico_test" value="1"  <?php if($odemeRow['iyzico_test'] == '1'  ) { ?>checked<?php }?> ">
                                                           <label class="custom-control-label" for="iyzico_test"></label>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>

                                           <div id="shopier-choise" class="col-md-12" <?php if($odemeRow['pos_tur'] != 'shopier'  ) { ?>style="display: none" <?php }?> >
                                               <div class="w-100 p-3 bg-success border border-success rounded-top  " style="background-color: #51cbb0 !important;">
                                                   <div class="col-md-12">
                                                       <img  src="assets/images/uploads/shopier.png" style="max-width: 80px">
                                                   </div>
                                               </div>
                                               <div class="row bg-light border  m-0 border-top-0 p-3">
                                                   <div class="form-group col-md-12 mb-4 mt-3">
                                                       <label for="shopier_user">Shopier - API User</label>
                                                       <input type="text" autocomplete="off" name="shopier_user" value="<?=$odemeRow['shopier_user']?>" id="shopier_user"   class="form-control">
                                                   </div>
                                                   <div class="form-group col-md-12">
                                                       <label for="shopier_pass">Shopier - API Password Key</label>
                                                       <input type="text" autocomplete="off" name="shopier_pass" value="<?=$odemeRow['shopier_pass']?>" id="shopier_pass"   class="form-control">
                                                   </div>
                                               </div>
                                               <div class="row border rounded-bottom m-0 border-top-0 p-3">
                                                   <div class="form-group col-md-12 ">
                                                       <label ><?=$diller['adminpanel-form-text-671']?></label>
                                                       <input type="text" autocomplete="off" disabled  value="<?=$ayar['site_url']?>pages.php?sayfa=shopierOrderSuccess" class="form-control rounded-0 rounded-top" >
                                                       <div class="border p-2 w-100 bg-light rounded-bottom border-top-0 " style="font-size: 11px ;"><?=$diller['adminpanel-form-text-672']?></div>
                                                   </div>
                                               </div>
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
    $('#pos_tur').on('change', function() {
        $('#paytr-choise').css('display', 'none');
        if ( $(this).val() === 'paytr' ) {
            $('#paytr-choise').css('display', 'block');
        }
        $('#iyzico-choise').css('display', 'none');
        if ( $(this).val() === 'iyzico' ) {
            $('#iyzico-choise').css('display', 'block');
        }
        $('#shopier-choise').css('display', 'none');
        if ( $(this).val() === 'shopier' ) {
            $('#shopier-choise').css('display', 'block');
        }
    });
</script>