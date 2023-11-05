<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'popup';
?>
<title><?=$diller['adminpanel-menu-text-168']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=popup"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-168']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_diger'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-4">
                        <form method="post" action="post.php?process=popup_post&status=update" enctype="multipart/form-data">

                            <div class="w-100">
                                <div class="w-100 text-left border-bottom mb-3 pb-2">
                                    <h4><?=$diller['adminpanel-menu-text-168']?></h4>
                                </div>
                               <div class="row">
                                   <div class="form-group col-md-12 mb-4">
                                       <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-96']?></label>
                                       <div class="custom-control custom-switch custom-switch-lg">
                                           <input type="hidden" name="durum" value="0"">
                                           <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" <?php if($popup['durum'] == '1'  ) { ?>checked<?php }?>>
                                           <label class="custom-control-label" for="durum"></label>
                                       </div>
                                   </div>
                                   <div class="form-group col-md-12 mb-4">
                                       <label  for="ip_durum" class="w-100"><?=$diller['adminpanel-form-text-103']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-104']?>"></i></label>
                                       <div class="custom-control custom-switch custom-switch-lg">
                                           <input type="hidden" name="ip_durum" value="no"">
                                           <input type="checkbox" class="custom-control-input" id="ip_durum" name="ip_durum" value="yes" <?php if($popup['ip_durum'] == 'yes'  ) { ?>checked<?php }?>>
                                           <label class="custom-control-label" for="ip_durum"></label>
                                       </div>
                                   </div>
                                   <div class="form-group col-md-6 mb-4">
                                       <label  for="delay" class="w-100"><?=$diller['adminpanel-form-text-100']?></label>
                                       <input type="number" name="delay" value="<?=$popup['delay']?>" id="delay" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-6 mb-4">
                                       <label  for="padding" class="w-100"><?=$diller['adminpanel-form-text-102']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-105']?>"></i></label>
                                       <input type="number" name="padding" value="<?=$popup['padding']?>" id="padding" required class="form-control">
                                   </div>

                                   <div class="form-group col-md-12 mb-4">
                                       <label for="tur"><?=$diller['adminpanel-form-text-97']?></label>
                                       <select name="tur" class="form-control" id="select_box" required>
                                           <option value="0" <?php if($popup['tur'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-98']?></option>
                                           <option value="1" <?php if($popup['tur'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-99']?></option>
                                       </select>
                                   </div>

                                   <div  id="0" class="select_option form-group pl-3 pr-3 w-100">
                                       <div class="in-header-page-main">
                                           <div class="in-header-page-text">
                                               <?=$diller['adminpanel-form-text-108']?>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="col-md-6">
                                               <div class="w-100 bg-light   p-3 text-center mb-3 ">
                                                   <?php if($popup['gorsel'] == !null  ) {?>
                                                       <small class="text-dark">
                                                           <?=$diller['adminpanel-form-text-107']?>
                                                       </small>
                                                       <br><br>
                                                       <img src="<?=$ayar['site_url']?>images/uploads/<?=$popup['gorsel']?>" class="img-fluid" >
                                                       <small>
                                                           <br><br>
                                                           <?=$diller['adminpanel-form-text-89']?> : 700x450
                                                       </small>
                                                       <br><br>
                                                       <a href="" data-href="post.php?process=popup_post&status=img_delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                   <?php }else{ ?>
                                                       <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                       <small>
                                                           <br><br>
                                                           <?=$diller['adminpanel-form-text-89']?> : 700x450
                                                       </small>
                                                   <?php }?>
                                               </div>
                                               <div class="w-100">
                                                   <input type="hidden" name="old_gorsel" value="<?=$popup['gorsel']?>" >
                                                   <div class="input-group mb-3">
                                                       <div class="custom-file">
                                                           <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel" >
                                                           <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                                       </div>
                                                   </div>
                                                   <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                                       <small>png,  jpg, jpeg, gif</small>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class=" form-group">
                                                   <label for="url"><?=$diller['adminpanel-form-text-101']?></label>
                                                   <input type="text" name="url" value="<?=$popup['url']?>" id="url" placeholder="https://" class="form-control">
                                               </div>
                                               <div class="form-group d-flex">
                                                   <input type="hidden" name="url_target" value="0" >
                                                   <input type="checkbox" name="url_target" value="1" id="url_target" style="height: 16px; width: 16px" <?php if($popup['url_target'] == '1' ) { ?>checked<?php }?> >
                                                   <label for="url_target" class="ml-2"><?=$diller['adminpanel-form-text-111']?></label>
                                               </div>
                                           </div>
                                       </div>

                                   </div>


                                   <div id="1" class="select_option form-group pl-3 pr-3 w-100">
                                       <div class="in-header-page-main">
                                           <div class="in-header-page-text">
                                               <?=$diller['adminpanel-form-text-109']?>
                                           </div>
                                       </div>
                                       <div>
                                           <label for=""><?=$diller['adminpanel-form-text-110']?></label>
                                           <input type="text" name="embed" value="<?=$popup['embed']?>" id="embed"  class="form-control">
                                       </div>
                                   </div>



                               </div>

                            </div>

                            <div class="w-100 border-top pt-3">
                                <button class="btn btn-success btn-block" name="update">
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
    $('#select_box').change(function () {
        var select = $(this).find(':selected').val();
        $(".select_option").hide();
        $('#' + select).show();
    }).change();
</script>