<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'kargoayar';
?>
<title><?=$diller['adminpanel-menu-text-83']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=delivery_settings"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-83']?></a>
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
                <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=delivery_settings_post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 ">
                                        <h4><?=$diller['adminpanel-menu-text-83']?></h4>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4 mt-2 ">
                                            <label  for="kargo_sistemi" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                <?=$diller['adminpanel-form-text-745']?>
                                            </label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="kargo_sistemi" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="kargo_sistemi" name="kargo_sistemi" value="1"  <?php if($odemeRow['kargo_sistemi'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);" >
                                                <label class="custom-control-label" for="kargo_sistemi"></label>
                                            </div>
                                        </div>
                                        <div id="actionBox" class="w-100 col-md-12 " <?php if($odemeRow['kargo_sistemi'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label  for="kargo_sabit" class="w-100"><?=$diller['adminpanel-form-text-748']?></label>
                                                    <select name="kargo_sabit" class="form-control rounded-top rounded-0 " id="kargo_sabit" style="height:50px; font-size: 16px ;" >
                                                        <option value="0" <?php if($odemeRow['kargo_sabit'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-747']?></option>
                                                        <option value="1" <?php if($odemeRow['kargo_sabit'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-746']?></option>
                                                    </select>
                                                </div>
                                                <div id="sabit-choise" class="col-md-12 mb-4  " <?php if($odemeRow['kargo_sabit'] != '1'  ) { ?>style="display: none" <?php }?> >
                                                    <div class="row bg-white border m-0   p-3 up-arrow-2-white">
                                                        <div class="col-md-12" style="font-size: 15px ;">
                                                            <?=$diller['adminpanel-form-text-749']?>
                                                        </div>
                                                    </div>
                                                    <div class="row bg-light border  m-0 border-top-0  p-3">
                                                        <div class="form-group col-md-6 ">
                                                            <label for="kargo_sabit_ucret" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                                <?=$diller['adminpanel-form-text-750']?>
                                                            </label>
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control" id="kargo_sabit_ucret" value="<?=$odemeRow['kargo_sabit_ucret']?>" name="kargo_sabit_ucret">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12 ">
                                                    <div class="w-100 border bg-light ">
                                                        <div class="bg-white form-group col-md-12 border-bottom pl-4 pr-4  pt-2 pb-2 mb-0 ">
                                                            <div class="w-100 ">
                                                                <h5><?=$diller['adminpanel-form-text-751']?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="bg-white form-group col-md-12 border-bottom pl-4 pr-4  pt-3 pb-3" style="font-size: 15px ;">
                                                            <?=$diller['adminpanel-form-text-752']?>
                                                        </div>
                                                        <div class="form-group col-md-6 pl-4 pr-4 ">
                                                            <label for="kargo_limit" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                                <?=$diller['adminpanel-form-text-751']?>
                                                            </label>
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control" id="kargo_limit" value="<?=$odemeRow['kargo_limit']?>" name="kargo_limit">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6 mb-4  pl-4 pr-4 ">
                                                            <label  for="kargo_limit_urundetay" class="w-100" ><?=$diller['adminpanel-form-text-753']?></label>
                                                            <div class="custom-control custom-switch custom-switch-lg">
                                                                <input type="hidden" name="kargo_limit_urundetay" value="0"">
                                                                <input type="checkbox" class="custom-control-input" id="kargo_limit_urundetay" name="kargo_limit_urundetay" value="1"  <?php if($odemeRow['kargo_limit_urundetay'] == '1'  ) { ?>checked<?php }?> ">
                                                                <label class="custom-control-label" for="kargo_limit_urundetay"></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12 pl-4 pr-4  ">
                                                            <div class="bg-white border rounded p-3 shadow-sm">
                                                               <div class="mb-2" style="font-size: 20px ; font-weight: bold;">
                                                                   <?=$diller['adminpanel-form-text-757']?>
                                                               </div>
                                                               <div style="font-size: 14px ;">
                                                                   <?=$diller['adminpanel-form-text-754']?>
                                                                   <br>
                                                                   <?=$diller['adminpanel-form-text-755']?> <a href="pages.php?page=theme_cart" class="text-danger"><?=$diller['adminpanel-form-text-756']?></a>
                                                               </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
    $('#kargo_sabit').on('change', function() {
        $('#sabit-choise').css('display', 'none');
        if ( $(this).val() === '1' ) {
            $('#sabit-choise').css('display', 'block');
        }
    });
</script><script type='text/javascript'>
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>