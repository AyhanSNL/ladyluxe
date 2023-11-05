<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
error_reporting(0);
$currentMenu = 'email_import';
$id = htmlspecialchars($_GET['id']);
$Sorgula = $db->prepare("select * from eposta_import where id=:id ");
$Sorgula->execute(array(
    'id' => $id
));
$row = $Sorgula->fetch(PDO::FETCH_ASSOC);
$xml_file = simplexml_load_file("inc/input/email/$row[dosya]");
if($Sorgula->rowCount()<='0'  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}
?>
<title><?= $diller['adminpanel-form-text-2065'] ?> (XML) - <?= $panelayar['baslik'] ?></title>

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
                                <a href="pages.php?page=email_list_import_process&id=<?=$_GET['id']?>"><i
                                            class="fa fa-angle-right"></i> <?= $diller['adminpanel-form-text-2062'] ?></a>
                                <a href="javascript:Void(0)"><i
                                            class="fa fa-angle-right"></i> <?= $diller['adminpanel-form-text-2065'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_eposta'] == '1') { ?>
            <?php
            if(!$xml_file) { ?>
                <div class="card p-xl-5">
                    <h3><?= $diller['adminpanel-text-136'] ?></h3>
                    <h6><?= $diller['adminpanel-form-text-2076'] ?></h6>
                    <div class="mt-3">
                        <a href="pages.php?page=email_list_import_process&id=<?=$_GET['id']?>"
                           class="btn btn-primary"><?= $diller['adminpanel-text-138'] ?></a>
                    </div>
                </div>
            <?php }else{?>
                <?php if($_POST && isset($_POST['sync'])  ) {
                    if($_POST['ana_etiket'] && $_POST['adres_etiket']) {
                        $anaTag = $_POST['ana_etiket'];
                        $adresTag = $_POST['adres_etiket'];
                        if(isset($xml_file->$anaTag)) {
                            if(isset($xml_file->$anaTag->$adresTag)  )
                            {
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card p-3">
                                            <div>
                                                <a href="pages.php?page=email_list_import_process&id=<?=$_GET['id']?>" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                                    <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                                </a>
                                            </div>
                                            <div class="new-buttonu-main-top ">
                                                <div class="new-buttonu-main-left">
                                                    <h5><?=$diller['adminpanel-form-text-2072']?> </h5>
                                                </div>
                                            </div>
                                            <div class="w-100 bg-light border border-info rounded p-3 mb-3" style="font-size: 16px ;">
                                                <?=$diller['adminpanel-form-text-2073']?> : <?=count($xml_file)?>
                                            </div>
                                            <form action="post.php?process=email_laststep_post&status=import" method="post">
                                                <input type="hidden" name="xml_id" value="<?=$id?>">
                                                <input type="hidden" name="dosya" value="<?=$row['dosya']?>">
                                                <input type="hidden" name="anatag" value="<?=$anaTag?>">
                                                <input type="hidden" name="adrestag" value="<?=$adresTag?>">
                                                <div class="row d-flex align-items-center justify-content-center ">
                                                    <div class="form-group col-md-12">
                                                        <button class="btn btn-success btn-block" name="sync" style="height: 50px; font-size: 18px ;">
                                                            <i class="fa fa-cloud-upload-alt"></i> <?=$diller['adminpanel-form-text-2074']?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php }else{
                                echo '<div class="row">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <div>
                                            <a href="pages.php?page=email_list_import_process&id='.$_GET['id'].'" class="btn btn-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> '.$diller['adminpanel-text-138'].'
                                            </a>
                                        </div>
                                        <div class="w-100 bg-danger text-white border border-danger rounded p-3 " style="font-size: 16px ;">
                                            '.$diller['adminpanel-form-text-2075'].'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            }
                        }else{
                            echo '<div class="row">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <div>
                                            <a href="pages.php?page=email_list_import_process&id='.$_GET['id'].'" class="btn btn-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> '.$diller['adminpanel-text-138'].'
                                            </a>
                                        </div>
                                        <div class="w-100 bg-danger text-white border border-danger rounded p-3 " style="font-size: 16px ;">
                                            '.$diller['adminpanel-form-text-2075'].'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=email_list_import_process&id='.$_GET['id'].'');
                        exit();
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }?>
            <?php } ?>
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