<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'tysettings';
$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
        'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.trendyol.com/sapigw/shipment-providers',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT =>0,
    CURLOPT_FOLLOWLOCATION => true

));
$printShow = curl_exec($curl);
curl_close($curl);
$json = json_decode($printShow);

?>
<title><?=$diller['pazaryeri-text-72']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-72']?></a>
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

                <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="post.php?process=ty_post&status=ty_settings">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="in-header-page-main">
                                        <div class="in-header-page-text">
                                            <?=$diller['pazaryeri-text-72']?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4 mb-4">
                                            <label  for="ty_durum" class="w-100"><?=$diller['adminpanel-form-text-62']?> </label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="ty_durum" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="ty_durum" name="ty_durum" value="1" <?php if($pazar['ty_durum'] == '1' ) { ?>checked<?php }?> >
                                                <label class="custom-control-label" for="ty_durum"></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 mb-4">
                                            <label  for="ty_cat_update" class="w-100"><?=$diller['pazaryeri-text-78']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-79']?>"></i></label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="ty_cat_update" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="ty_cat_update" name="ty_cat_update" value="1"  >
                                                <label class="custom-control-label" for="ty_cat_update"></label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 ">
                                            <label  for="ty_bayi" class="w-100">Trendyol - Satıcı Id </label>
                                            <input type="text" name="ty_bayi" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['ty_bayi']?>"<?php } ?>  id="ty_bayi" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="ty_api" class="w-100">Trendyol - API Key (Api Username)</label>
                                            <input type="text" name="ty_api" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['ty_api']?>"<?php } ?>  id="ty_api" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="ty_secret" class="w-100">Trendyol - API Secret (Api Password)</label>
                                            <input type="text" name="ty_secret" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['ty_secret']?>"<?php } ?>  id="ty_secret" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="ty_kargo" class="w-100">Trendyol - <?=$diller['pazaryeri-text-74']?></label>
                                            <select name="ty_kargo" class="form-control" id="ty_kargo" >
                                                <?php foreach ($json as $gel) {?>
                                                    <option value="<?=$gel->id?>" <?php if($pazar['ty_kargo'] == $gel->id ) { ?>selected<?php }?>><?=$gel->name?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="ty_taksit" class="w-100">Trendyol - <?=$diller['pazaryeri-text-126']?></label>
                                            <select name="ty_taksit" class="form-control" id="ty_taksit" >
                                                <option value="0" <?php if($pazar['ty_taksit'] == '0' ) { ?>selected<?php }?>><?=$diller['pazaryeri-text-128']?></option>
                                                <option value="1" <?php if($pazar['ty_taksit'] == '1' ) { ?>selected<?php }?>><?=$diller['pazaryeri-text-127']?></option>
                                            </select>
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