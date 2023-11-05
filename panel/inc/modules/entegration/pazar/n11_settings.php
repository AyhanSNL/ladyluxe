<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'n11settings';

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
        'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['pazaryeri-text-1']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-86']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-1']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/entegration_leftbar.php'; ?>

                <!-- Contents !-->

                <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=pazar_post&status=n11_settings">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="in-header-page-main">
                                        <div class="in-header-page-text">
                                            <?=$diller['pazaryeri-text-1']?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label  for="n11_durum" class="w-100"><?=$diller['adminpanel-form-text-62']?> </label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="n11_durum" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="n11_durum" name="n11_durum" value="1" <?php if($pazar['n11_durum'] == '1' ) { ?>checked<?php }?> >
                                                <label class="custom-control-label" for="n11_durum"></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="n11_api" class="w-100">N11 - API KEY</label>
                                            <input type="text" name="n11_api" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['n11_api']?>"<?php } ?>  id="n11_api" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="n11_secret" class="w-100">N11 - API SECRET</label>
                                            <input type="text" name="n11_secret" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['n11_secret']?>"<?php } ?>  id="n11_secret" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="n11_sablon" class="w-100"><?=$diller['adminpanel-form-text-2055']?></label>
                                            <input type="text" name="n11_sablon" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['n11_sablon']?>"<?php } ?>  id="n11_sablon" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="n11_aciklama" class="w-100" >
                                                <?=$diller['pazaryeri-text-57']?>
                                            </label>
                                            <textarea name="n11_aciklama" id="tiny" class="form-control" rows="3"  ><?=$pazar['n11_aciklama']?></textarea>
                                        </div>
                                        <div class="form-group col-md-12 mb-0">
                                            <button class="btn btn-success btn-block" name="settingSave">
                                                <?=$diller['adminpanel-form-text-53']?>
                                            </button>
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