<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
?>
<title><?=$diller['adminpanel-text-11']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=password_change"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-text-11']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">


            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div style="font-size: 20px ; font-weight: 600;" class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                            <?=$diller['adminpanel-text-11']?> <i class="las la-key" style="font-size: 28px ;"></i>
                        </div>
                        <form method="post" action="post.php?process=other_post&status=password">
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-md-6 form-group">
                                    <label for="old">* <?=$diller['adminpanel-form-text-1735']?></label>
                                    <input type="password" name="old_password" value="" id="old"  class="form-control">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-md-6 form-group">
                                    <label for="new">* <?=$diller['adminpanel-form-text-1736']?></label>
                                    <input type="password" name="new_password" value="" id="new"  class="form-control">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-md-6 form-group">
                                    <label for="new2">* <?=$diller['adminpanel-form-text-1737']?></label>
                                    <input type="password" name="new_password_again" value="" id="new2"  class="form-control">
                                </div>
                            </div>
                            <div class="row d-flex align-items-center justify-content-center">
                                <div class="col-md-6 mb-4">
                                    <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card mb-2 border-primary border bg-primary text-white">
                    <div class="card-body">
                        <div class=" d-flex align-items-start justify-content-start" >
                            <div style="width: 30px">
                                <i class="fa fa-info" style="font-size: 11px ;"></i>
                            </div>
                            <div>
                                <?=$diller['adminpanel-form-text-1733']?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($adminRow['sifre_tarih'] == !null  ) {
                    $kaynak =$diller['adminpanel-form-text-1734'];
                    $kaynak  = $kaynak;
                    $eski   = '{date}';
                    $yeni   = '<strong>'.date_tr('j F Y, H:i ', ''.$adminRow['sifre_tarih'].'').'</strong>';
                    $kaynak = str_replace($eski, $yeni, $kaynak);
                    ?>
                    <div class="mt-3  alert-warning border border-warning text-dark p-4 mb-3 rounded d-flex align-items-start justify-content-start" >
                        <div style="width: 30px">
                            <i class="fa fa-info" style="font-size: 11px ;"></i>
                        </div>
                        <div>
                            <?=$kaynak?>
                        </div>
                    </div>
                <?php }?>
            </div>




        </div>

    </div>
</div>
