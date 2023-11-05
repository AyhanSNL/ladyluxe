<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'email_import';
$ID = htmlspecialchars($_GET['id']);
$dosyaSql = $db->prepare("select * from eposta_import where id=:id ");
$dosyaSql->execute(array(
    'id' => $ID,
));
$row = $dosyaSql->fetch(PDO::FETCH_ASSOC);




?>
<title><?= $diller['adminpanel-form-text-2062'] ?> (XML) - <?= $panelayar['baslik'] ?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="page-title-nav">
                                <a href="<?= $ayar['panel_url'] ?>"><i
                                        class="ion ion-md-home"></i> <?= $diller['adminpanel-text-341'] ?></a>
                                <a href="javascript:Void(0)"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-86'] ?></a>
                                <a href="pages.php?page=email_list_import"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-91'] ?> (XML)</a>
                                <a href="javascript:Void(0)"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-form-text-2062'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_eposta'] == '1') { ?>
            <?php if($row['durum'] == '0' ) {?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3 mb-3">
                            <div>
                                <a href="pages.php?page=email_list_import" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                    <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                </a>
                            </div>
                            <div class="new-buttonu-main-top">
                                <div class="new-buttonu-main-left">
                                    <h4> <?=$diller['adminpanel-form-text-2062']?> (XML)</h4>
                                </div>
                            </div>
                            <div class="sitemap-div-main p-0">
                                <div class="sitemap-link-main">
                                    <div class="sitemap-link-icon">
                                        <img src="assets/images/icon/href_icon.png">
                                    </div>
                                    <div class="sitemap-link-address">
                                        <a href="<?=$ayar['panel_url'] ?>inc/input/email/<?=$row['dosya']?>" target="_blank">
                                            <?=$ayar['panel_url'] ?>inc/input/email/<?=$row['dosya']?>
                                        </a>
                                    </div>
                                    <a class="sitemap-link-refresh" href="<?=$ayar['panel_url'] ?>inc/input/email/<?=$row['dosya']?>" target="_blank">
                                        <i class="fas fa-eye"></i> <?= $diller['adminpanel-form-text-2063'] ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-md-12 mb-3">
                        <div class="rounded border border-warning alert-warning text-dark text-center ">
                            <div class="card-body">
                                <?=$diller['adminpanel-form-text-2064']?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="new-buttonu-main-top border-bottom border-grey pb-2 mb-3">
                                <div class="new-buttonu-main-left">
                                    <h5><i class="fa fa-code"></i> <?=$diller['adminpanel-form-text-2065']?> </h5>
                                </div>
                            </div>
                            <form action="pages.php?page=email_list_import_process_step&id=<?=$row['id']?>" method="post">
                                <input type="hidden" name="xml_id" value="<?=$row['id']?>">
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="ana_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2067']?>
                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2068']?>"></i>
                                        </label>
                                        <input type="text" name="ana_etiket" autocomplete="off"  id="ana_etiket" required class="form-control">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="adres_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2069']?>
                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2070']?>"></i>
                                        </label>
                                        <input type="text" name="adres_etiket" autocomplete="off"  id="adres_etiket" required class="form-control">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <button class="btn btn-success btn-block" name="sync">
                                            <i class="fa fa-sync"></i> <?=$diller['adminpanel-form-text-2071']?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php }else { ?>
                <div class="card p-xl-5">
                    <h6><?= $diller['adminpanel-form-text-2066'] ?></h6>
                    <div class="mt-3">
                        <a href="<?= $ayar['panel_url'] ?>pages.php?page=email_list_import"
                           class="btn btn-primary"><?= $diller['adminpanel-text-138'] ?></a>
                    </div>
                </div>
            <?php }?>
        <?php } else { ?>
            <div class="card p-xl-5">
                <h3><?= $diller['adminpanel-text-136'] ?></h3>
                <h6><?= $diller['adminpanel-text-137'] ?></h6>
                <div class="mt-3">
                    <a href="<?= $ayar['panel_url'] ?>"
                       class="btn btn-primary"><?= $diller['adminpanel-text-138'] ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>