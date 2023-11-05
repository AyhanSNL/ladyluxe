<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'parasut_ayar';

$pazarSql = $db->prepare("select * from parasut where id=:id ");
$pazarSql->execute(array(
        'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);

if($_POST) {
    if($yetki['demo'] != '1' ) {
        $guncelle = $db->prepare("UPDATE parasut SET
                client_id=:client_id,
                client_secret=:client_secret,
                username=:username,
                password=:password,
                redirect_uri=:redirect_uri,
                kasa=:kasa,
                company_id=:company_id,
                durum=:durum
         WHERE id='1'      
        ");
        $sonuc = $guncelle->execute(array(
            'client_id' => $_POST['client_id'],
            'client_secret' => $_POST['client_secret'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'redirect_uri' => $_POST['redirect_uri'],
            'kasa' => $_POST['kasa'],
            'company_id' => $_POST['company_id'],
            'durum' => $_POST['durum']
        ));
        if($sonuc){
            $_SESSION['main_alert'] = 'success';
            header('Location:pages2.php?page=parasut_ayar');
            exit();
        }else{
            echo 'Veritabanı Hatası';
        }
    }
}
?>
<title><?=$diller['parasut-text-1']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['parasut-text-1']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['parasut'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/entegration_leftbar.php'; ?>

                <!-- Contents !-->

                <form class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" method="post" action="">
                    <input type="hidden" name="ayar" value="1">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="in-header-page-main">
                                        <div class="in-header-page-text">
                                            <?=$diller['parasut-text-1']?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-62']?> </label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="durum" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" <?php if($pazar['durum'] == '1' ) { ?>checked<?php }?> >
                                                <label class="custom-control-label" for="durum"></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="company_id" class="w-100"><?=$diller['parasut-text-4']?></label>
                                            <input type="text" name="company_id" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['company_id']?>"<?php } ?>  id="company_id" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="client_id" class="w-100">Client (Application) ID</label>
                                            <input type="text" name="client_id" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['client_id']?>"<?php } ?>  id="client_id" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="client_secret" class="w-100">Client (Application) Secret</label>
                                            <input type="text" name="client_secret" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['client_secret']?>"<?php } ?>  id="client_secret" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="username" class="w-100"><?=$diller['parasut-text-2']?></label>
                                            <input type="text" name="username" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['username']?>"<?php } ?>  id="username" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="password" class="w-100"><?=$diller['parasut-text-3']?></label>
                                            <input type="text" name="password" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['password']?>"<?php } ?>  id="password" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="redirect_uri" class="w-100"><?=$diller['parasut-text-5']?></label>
                                            <input type="text" name="redirect_uri" autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['redirect_uri']?>"<?php } ?>  id="redirect_uri" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label for="kasa"><?=$diller['parasut-text-9']?>
                                                <div style="font-size: 11px ; font-weight: 400;">
                                                    <?=$diller['parasut-text-10']?>
                                                </div>
                                            </label>
                                            <input type="text" name="kasa" required autocomplete="off" <?php if($yetki['demo'] == '1' ) { ?>value=""<?php }else{?>value="<?=$pazar['kasa']?>"<?php } ?>  id="kasa" class="form-control">
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