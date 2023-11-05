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

    .ct-chart .ct-label.ct-horizontal.ct-end {
        justify-content: flex-end;
        text-align: left;
        transform-origin: 100% 0;
        transform: translate(-100%) rotate(-45deg);
        white-space:nowrap;
        height: 100px !important;
        position: relative;
    }

    .table-container {
        display: inline-block;
        vertical-align: top;
        width: 50%;
        border: 1px solid #ccc;
        padding-right: 25px;
        margin: 2px;
        border-radius: 25px;
    }
    svg.ct-chart-bar, svg.ct-chart-line{
        overflow: visible;
    }
</style>
<link rel="stylesheet" href="plugins/chartist/css/chartist.min.css">
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
                                            <a class="nav-link saas" href="pages.php?page=order_reports_data">
                                                <i class="ion ion-md-stats"></i> <?=$diller['adminpanel-form-text-1706']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" href="pages.php?page=order_reports_date">
                                               <i class="fa fa-calendar-check"></i> <?=$diller['adminpanel-form-text-1705']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas active" href="pages.php?page=order_reports_type">
                                                <i class="fa fa-credit-card"></i> <?=$diller['adminpanel-text-101']?>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content bg-white rounded-bottom border border-top-0">
                                        <div class="tab-pane active p-4" id="one" role="tabpanel" >

                                            <div class="w-100  ">
                                                <?php
                                                $odemeKart = $db->prepare("select * from siparisler where onay=:onay and odeme_tur=:odeme_tur ");
                                                $odemeKart->execute(array(
                                                    'onay' => '1',
                                                    'odeme_tur' => '1'
                                                ));
                                                $odemeHavale = $db->prepare("select * from siparisler where onay=:onay and odeme_tur=:odeme_tur ");
                                                $odemeHavale->execute(array(
                                                    'onay' => '1',
                                                    'odeme_tur' => '2'
                                                ));
                                                $odemeKK = $db->prepare("select * from siparisler where onay=:onay and odeme_tur=:odeme_tur ");
                                                $odemeKK->execute(array(
                                                    'onay' => '1',
                                                    'odeme_tur' => '3'
                                                ));
                                                $odemeKN = $db->prepare("select * from siparisler where onay=:onay and odeme_tur=:odeme_tur ");
                                                $odemeKN->execute(array(
                                                    'onay' => '1',
                                                    'odeme_tur' => '4'
                                                ));
                                                ?>
                                                <?php if($odemeKart->rowCount()>'0'  || $odemeHavale->rowCount()>'0'  || $odemeKK->rowCount()>'0' || $odemeKN->rowCount()> '0' ) {?>
                                                 <div class="border p-3 rounded shadow-sm">
                                                     <div  id="pie-chart">
                                                         <div id="pie-chart-container" class="flot-chart" style="height: 320px">
                                                         </div>
                                                     </div>
                                                 </div>
                                                    <div class="row mt-3">
                                                        <!-- Havale !-->
                                                        <div class="col-md-6 form-group">
                                                            <div class="p-3  shadow-sm text-center border rounded" style="font-size: 16px ;" >
                                                                <?php
                                                                $havaleDil = $diller['adminpanel-form-text-1713'];
                                                                $havaleDil  = $havaleDil;
                                                                $eski   = '{sayi}';
                                                                $yeni   = '<strong>'.$odemeHavale->rowCount().'</strong>';
                                                                $havaleDil = str_replace($eski, $yeni, $havaleDil);
                                                                ?>
                                                                <?=$havaleDil?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <div class="p-3  shadow-sm text-center border rounded" style="font-size: 16px ;" >
                                                                <?php
                                                                $krediKartiDil = $diller['adminpanel-form-text-1714'];
                                                                $krediKartiDil  = $krediKartiDil;
                                                                $eski   = '{sayi}';
                                                                $yeni   = '<strong>'.$odemeKart->rowCount().'</strong>';
                                                                $krediKartiDil = str_replace($eski, $yeni, $krediKartiDil);
                                                                ?>
                                                                <?=$krediKartiDil?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <div class="p-3  shadow-sm text-center border rounded" style="font-size: 16px ;" >
                                                                <?php
                                                                $KO_Kart = $diller['adminpanel-form-text-1715'];
                                                                $KO_Kart  = $KO_Kart;
                                                                $eski   = '{sayi}';
                                                                $yeni   = '<strong>'.$odemeKK->rowCount().'</strong>';
                                                                $KO_Kart = str_replace($eski, $yeni, $KO_Kart);
                                                                ?>
                                                                <?=$KO_Kart?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <div class="p-3  shadow-sm text-center border rounded" style="font-size: 16px ;" >
                                                                <?php
                                                                $KO_Nakit = $diller['adminpanel-form-text-1716'];
                                                                $KO_Nakit  = $KO_Nakit;
                                                                $eski   = '{sayi}';
                                                                $yeni   = '<strong>'.$odemeKN->rowCount().'</strong>';
                                                                $KO_Nakit = str_replace($eski, $yeni, $KO_Nakit);
                                                                ?>
                                                                <?=$KO_Nakit?>
                                                            </div>
                                                        </div>
                                                        </div>

                                                        <!--  <========SON=========>>> Havale SON !-->
                                                    </div>
                                                    <script src="plugins/flot-chart/jquery.flot.min.js"></script>
                                                    <script src="plugins/flot-chart/jquery.flot.tooltip.min.js"></script>
                                                    <script src="plugins/flot-chart/jquery.flot.resize.js"></script>
                                                    <script src="plugins/flot-chart/jquery.flot.pie.js"></script>
                                                    <script>
                                                        !function($) {
                                                            "use strict";

                                                            var FlotChart = function() {
                                                                this.$body = $("body")
                                                                this.$realData = []
                                                            };

                                                            FlotChart.prototype.createPieGraph = function(selector, labels, datas, colors) {
                                                                var data = [
                                                                    <?php if($odemeKart->rowCount()>'0'  ) {?>
                                                                    {
                                                                        label: labels[0],
                                                                        data: datas[0]
                                                                    },
                                                                    <?php }?>
                                                                    <?php if($odemeHavale->rowCount()>'0'  ) {?>
                                                                    {
                                                                        label: labels[1],
                                                                        data: datas[1]
                                                                    },
                                                                    <?php }?>
                                                                    <?php if($odemeKK->rowCount()>'0'  ) {?>
                                                                    {
                                                                        label: labels[2],
                                                                        data: datas[2]
                                                                    },
                                                                    <?php }?>
                                                                    <?php if($odemeKN->rowCount()>'0'  ) {?>
                                                                    {
                                                                        label: labels[3],
                                                                        data: datas[3]
                                                                    }
                                                                    <?php }?>
                                                                ];
                                                                var options = {
                                                                    series: {
                                                                        pie: {
                                                                            show: true
                                                                        }
                                                                    },
                                                                    legend : {
                                                                        show : true
                                                                    },
                                                                    grid : {
                                                                        hoverable : true,
                                                                        clickable : true
                                                                    },
                                                                    colors : colors,
                                                                    tooltip : true,
                                                                    tooltipOpts : {
                                                                        content : "%s, %p.0%"
                                                                    }
                                                                };

                                                                $.plot($(selector), data, options);
                                                            },
                                                                FlotChart.prototype.init = function() {
                                                                    var pielabels = ["<?=$diller['adminpanel-text-97']?>","<?=$diller['adminpanel-text-98']?>","<?=$diller['adminpanel-text-99']?>","<?=$diller['adminpanel-text-100']?>"];
                                                                    var datas = [<?=$odemeKart->rowCount()?>,<?=$odemeHavale->rowCount()?>, <?=$odemeKK->rowCount()?>, <?=$odemeKN->rowCount()?>];
                                                                    var colors = ['#46cd93', '#5985ee', "#f0f1f4", "#F42F12"];
                                                                    this.createPieGraph("#pie-chart #pie-chart-container", pielabels , datas, colors);
                                                                },
                                                                $.FlotChart = new FlotChart, $.FlotChart.Constructor = FlotChart

                                                        }(window.jQuery),

//initializing flotchart
                                                            function($) {
                                                                "use strict";
                                                                $.FlotChart.init()
                                                            }(window.jQuery);
                                                    </script><?php }else { ?>
                                                    <div class="alert alert-light border text-center">
                                                        <i class="fa fa-exclamation-triangle" style="font-size: 35px ; margin-bottom: 20px;"></i><br>
                                                        <?=$diller['adminpanel-text-103']?>
                                                    </div>
                                                <?php }?>
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
