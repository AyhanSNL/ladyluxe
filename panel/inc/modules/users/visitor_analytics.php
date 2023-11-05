<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'visitor';

?>
<title><?=$diller['adminpanel-text-60']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-25']?></a>
                                <a href="pages.php?page=visitor_analytics"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-text-60']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['uyelik'] == '1' && $yetki['ziyaretci_istatistik'] == '1') {?>

            <div class="row">

                <?php include 'inc/modules/_helper/users_leftbar.php'; ?>

                <!-- Contents !-->

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="new-buttonu-main-top mb-0  pb-2 ">
                                        <div class="new-buttonu-main-left">
                                            <h4><?=$diller['adminpanel-text-60']?></h4>
                                        </div>
                                    </div>
                                    <!-- Tab Alanı !-->
                                    <ul class="nav nav-tabs  pt-2" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link saas active" id="one-tab" data-toggle="tab" href="#one" role="tab"  aria-selected="true">
                                               <?=$diller['adminpanel-form-text-1416']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" href="pages.php?page=visitor_analytics_chart">
                                                <i class="far fa-chart-bar"></i> <?=$diller['adminpanel-form-text-1417']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" href="pages.php?page=visitor_analytics_date">
                                               <i class="fa fa-calendar-check"></i> <?=$diller['adminpanel-form-text-1418']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" href="pages.php?page=visitor_analytics_users">
                                                <i class="fa fa-users"></i> <?=$diller['adminpanel-form-text-1419']?>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content bg-white rounded-bottom border border-top-0">
                                        <div class="tab-pane active p-4" id="one" role="tabpanel" >
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <div class="border">
                                                        <div class="card-body text-center">
                                                            <h6 class="text-dark"> <?=$diller['adminpanel-text-68']?></h6>
                                                            <div class="col-md-12 text-center text-dark" id="onlinever" style="padding: 0px; margin: 0px"></div>
                                                            <script>
                                                                $('#onlinever').html('<div class="spinner-border text-success"  style="width:50px; height: 50px; margin:38px 0" role="status">\n' +
                                                                    '                                        <span class="sr-only">Loading...</span>\n' +
                                                                    '                                      </div>');
                                                                function veriler2(){  $.get("inc/online.php",function(data){ jQuery('#onlinever').html(data); }); }
                                                                window.setInterval("veriler2()",3000);
                                                            </script>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8  form-group">
                                                    <div class="border ">
                                                        <div class="card-body text-center">
                                                            <div class="new-buttonu-main-top mb-0 pb-2 ">
                                                                <div class="new-buttonu-main-left">
                                                                    <h6><?=$diller['adminpanel-form-text-1410']?></h6>
                                                                </div>
                                                                <div class="new-buttonu-main">
                                                                    <a  class="btn btn-outline-danger btn-sm  " href="" data-href="post.php?process=users_post&status=page_reset&ok=ok"  data-toggle="modal" data-target="#confirm-delete" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-form-text-1408']?></a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 text-center text-dark" id="pagever" style="padding: 0px; margin: 0px"></div>
                                                            <script>
                                                                $('#pagever').html('<div class="spinner-border text-success"  style="width:50px; height: 50px; margin:38px 0" role="status">\n' +
                                                                    '                                        <span class="sr-only">Loading...</span>\n' +
                                                                    '                                      </div>');
                                                                function veriler3(){  $.get("masterpiece.php?page=online_track",function(data){ jQuery('#pagever').html(data); }); }
                                                                window.setInterval("veriler3()",3000);
                                                            </script>
                                                            <div style="height: 4px"></div>
                                                        </div>
                                                    </div>
                                                </div>
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
