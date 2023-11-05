<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'cartdiscount';
$cartDiscount = $db->prepare("select * from indirim_ek_sepet where id=:id ");
$cartDiscount->execute(array(
        'id' => '1'
));
$row = $cartDiscount->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-180']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-30']?></a>
                                <a href="pages.php?page=cart_discount"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-180']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['kampanya'] == '1' && $yetki['indirimkod'] == '1' ) {?>


            <div class="row">

                <?php include 'inc/modules/_helper/campaign_leftbar.php'; ?>
                <!-- Contents !-->
                <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=coupon_post&status=cart_discount">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 border-bottom ">
                                        <h4><?=$diller['adminpanel-menu-text-180']?></h4>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="form-group col-md-12 mb-4 mt-2 ">
                                            <label  for="durum" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                <?=$diller['adminpanel-form-text-62']?>
                                            </label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="durum" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  <?php if($row['durum'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);" >
                                                <label class="custom-control-label" for="durum"></label>
                                            </div>
                                        </div>
                                        <div id="actionBox" class="w-100 col-md-12 " <?php if($row['durum'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label  for="tur" class="w-100">* <?=$diller['adminpanel-form-text-1214']?></label>
                                                    <select name="tur" class="form-control" id="tur" >
                                                        <option value="1" <?php if($row['tur'] == '1'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1216']?></option>
                                                        <option value="2" <?php if($row['tur'] == '2'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1215']?></option>
                                                    </select>
                                                </div>
                                                <div id="oran-choose" class="col-md-4" <?php if($row['tur'] != '1' ) { ?>style="display: none" <?php }?>  >
                                                    <div class="row">
                                                        <div class="form-group col-md-12 ">
                                                            <label for="oran_oran" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                                *  <?=$diller['adminpanel-form-text-1218']?>
                                                            </label>
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text font-12 font-weight-bold">%</div>
                                                                </div>
                                                                <input type="text" class="form-control" id="oran_oran"  name="oran_oran" value="<?=$row['tutar']?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tutar-choose" class="col-md-4" <?php if($row['tur'] != '2' ) { ?>style="display: none" <?php }?> >
                                                    <div class="row">
                                                        <div class="form-group col-md-12 ">
                                                            <label for="tutar_tutar" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                                *  <?=$diller['adminpanel-form-text-1217']?>
                                                            </label>
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control" id="tutar_tutar"  name="tutar_tutar" value="<?=$row['tutar']?>">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    $('#tur').on('change', function() {
                                                        $('#tutar-choose').css('display', 'none');
                                                        if ( $(this).val() === '2' ) {
                                                            $('#tutar-choose').css('display', 'block');
                                                        }
                                                        $('#oran-choose').css('display', 'none');
                                                        if ( $(this).val() === '1' ) {
                                                            $('#oran-choose').css('display', 'block');
                                                        }
                                                    });
                                                </script>
                                                <div class="form-group col-md-4 ">
                                                    <label for="sepet_alt_limit" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                        <div>
                                                            * <?=$diller['adminpanel-form-text-1201']?>
                                                        </div>
                                                        <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1219']?>"></i>
                                                    </label>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" id="sepet_alt_limit"  name="sepet_alt_limit" value="<?=$row['sepet_alt_limit']?>" >
                                                        <div class="input-group-append">
                                                            <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="indirim_tip" class="w-100">* <?=$diller['adminpanel-form-text-1231']?></label>
                                                    <select name="indirim_tip" class="form-control" id="indirim_tip" >
                                                        <option value="0" <?php if($row['indirim_tip'] == '0'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1232']?></option>
                                                        <option value="1" <?php if($row['indirim_tip'] == '1'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1233']?></option>
                                                        <option value="2" <?php if($row['indirim_tip'] == '2'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1234']?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
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
</script>