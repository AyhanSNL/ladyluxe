<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'banners';

if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_banners');
    }
}


?>
<title><?=$diller['adminpanel-menu-text-111']?> - <?=$panelayar['baslik']?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box  bg-white card mb-0 pl-3" >
                    <div class="row align-items-center d-flex justify-content-between" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-98']?></a>
                                <a href="pages.php?page=theme_banners"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-111']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1') {


            $islemCek = $db->prepare("select page_baslik, bg_tip, id, durum from page_header where (page_baslik like '%$_GET[search]%' )");
            $islemCek->execute();

            $ToplamVeri = $islemCek->rowCount();


            ?>


            <div class="row">

                <!-- Contents !-->
                <div class="col-md-9">
                    <div class="card p-3">
                        <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 mb-2 border-bottom">
                            <h4> <?=$diller['adminpanel-menu-text-111']?></h4>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=theme_banners" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="theme_banners" id="" required class="form-control">
                                            <input type="text" name="search" class="form-control" placeholder="<?=$diller['adminpanel-text-154']?>"  aria-describedby="button-addon2" required autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-dark rounded-0" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Search Form SON !-->
                        <div class="w-100">
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th><?=$diller['adminpanel-text-317']?></th>
                                            <th class="text-center"><?=$diller['adminpanel-text-318']?></th>
                                            <th class="text-center"><?=$diller['adminpanel-form-text-62']?></th>
                                            <th  class="text-right" width="45"><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody >
                                        <?php foreach ($islemCek as $row) { ?>
                                            <tr>
                                                <td style="font-weight: 500; min-width: 140px"><?=$row['page_baslik']?></td>
                                                <td width="190" style="min-width: 190px">
                                                    <?php if($row['bg_tip'] == '0' ) {?>
                                                        <div class="btn btn-sm btn-pink btn-block  ">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="fa fa-image mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-251']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['bg_tip'] == '1' ) {?>
                                                        <div class="btn btn-sm btn-info btn-block ">
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <i class="fa fa-palette mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-250']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </td>
                                                <td width="80">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <div class="btn btn-sm btn-outline-danger ">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <div class="btn btn-sm btn-success ">
                                                            <div class="d-flex align-items-center">
                                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                <?=$diller['adminpanel-form-text-67']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </td>
                                                <td class="text-right">
                                                    <a href="pages.php?page=theme_banner_edit&no=<?=$row['id']?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            <!-- Kaydırılabilir Alert !-->
                            <div class="d-md-none d-sm-block p-2 bg-light  text-center">
                                <?=$diller['adminpanel-text-340']?> <i class="fas fa-hand-pointer"></i>
                            </div>
                            <!--  <========SON=========>>> Kaydırılabilir Alert SON !-->
                                <div class="border-top"> </div>
                            <?php if($ToplamVeri<='0' && !isset($_GET['search']) ) {?>
                                <div class="w-100  p-3 ">
                                    <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                </div>
                            <?php }?>

                            <?php if($ToplamVeri<='0' && isset($_GET['search']) ) {?>
                                <div class="w-100  p-3 ">
                                    <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-163']?>
                                </div>
                            <?php }?>

                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Contents SON !-->
                <?php include 'inc/modules/_helper/theme_all_links.php'; ?>

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