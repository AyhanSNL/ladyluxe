<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'order_reports';

?>
<title><?=$diller['adminpanel-menu-text-95']?> - <?=$panelayar['baslik']?></title>
<style>
    .nav-link{
        color: #000;
        transition-duration: 0.1s; transition-timing-function: linear;
        font-weight: 500;
        font-size: 14px;
        padding: 15px 25px;

    }
    .saas:hover{
        background-color: #fff;
        color: #000;
    }
    @media (max-width: 768px) {
        .nav-link{
            color: #000;
            transition-duration: 0.1s; transition-timing-function: linear;
            font-weight: 500;
            font-size: 14px;
            padding: 10px;
        }
        .nav-tabs{
            padding: 15px;
        }
        .nav-tabs li:first-child{
            margin-left: 0;
        }
        .nav-link.active{
            border-color: #dee2e6 #dee2e6 #dee2e6 !important;
            border-radius: 6px !important;
        }
    }
</style>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-16']?></a>
                                <a href="pages.php?page=order_reports"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-95']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['siparis'] == '1' && $yetki['siparis_diger'] == '1') {?>

            <div class="row">

                <?php include 'inc/modules/_helper/orders_leftbar.php'; ?>

                <!-- Contents !-->

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="new-buttonu-main-top mb-0  pb-2 ">
                                        <div class="new-buttonu-main-left">
                                            <h4><?=$diller['adminpanel-menu-text-95']?></h4>
                                        </div>
                                    </div>
                                    <!-- Tab Alanı !-->
                                    <ul class="nav nav-tabs  pt-2" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link saas " href="pages.php?page=order_reports">
                                                <i class="ion ion-md-stats"></i> <?=$diller['adminpanel-form-text-1704']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas active" href="pages.php?page=order_reports_data">
                                                <i class="ion ion-md-stats"></i> <?=$diller['adminpanel-form-text-1706']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" href="pages.php?page=order_reports_date">
                                               <i class="fa fa-calendar-check"></i> <?=$diller['adminpanel-form-text-1705']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" href="pages.php?page=order_reports_type">
                                                <i class="fa fa-credit-card"></i> <?=$diller['adminpanel-text-101']?>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content bg-white rounded-bottom border border-top-0">
                                        <div class="tab-pane active p-4" id="one" role="tabpanel" >
                                            <div class="row">
                                                <!-- Bugun Verileri !-->
                                                <div id="daily_order_detail" class="col-md-12 mb-3"></div>
                                                <!--  <========SON=========>>> Bugun Verileri SON !-->

                                                <!-- Bu hafta verileri !-->
                                                <div id="week_order_detail" class="col-md-12 mb-3"></div>
                                                <!--  <========SON=========>>> Bu hafta verileri SON !-->

                                                <!-- Bu ay verileri !-->
                                                <div id="month_order_detail" class="col-md-12 mb-3"></div>
                                                <!--  <========SON=========>>> Bu ay verileri SON !-->

                                                <!-- Bu yıl !-->
                                                <div id="year_order_detail" class="col-md-12 mb-3"></div>
                                                <!--  <========SON=========>>> Bu yıl SON !-->
                                            </div>

                                        </div>
                                    </div>
                                    <!--  <========SON=========>>> Tab Alanı SON !-->


                                </div>
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
