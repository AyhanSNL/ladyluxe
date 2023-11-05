<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'sale_reports';
if (isset($_GET['date']) && $_GET['date'] == !null && isset($_GET['date_end']) && $_GET['date_end'] == !null) {
    $datePage = "&date=".$_GET['date']."&date_end=".$_GET['date_end']."";
}
if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if(isset($_GET['show']) && $_GET['show'] == !null  ) {
    if($_GET['show']!= 'mobile' && $_GET['show'] != 'desktop'  ) {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=sale_reports_date');
        exit();
    }
}
if (isset($_GET['show']) && $_GET['show'] == !null) {
    $showPage = "&show=$_GET[show]";
}
?>
<title><?=$diller['adminpanel-menu-text-96']?> - <?=$panelayar['baslik']?></title>
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
                                    <a href="pages.php?page=sale_reports"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-96']?></a>
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
                                            <h4><?=$diller['adminpanel-menu-text-96']?></h4>
                                        </div>
                                    </div>
                                    <!-- Tab Alanı !-->
                                    <ul class="nav nav-tabs  pt-2" id="myTab" role="tablist">
                                        <li class="nav-item">
                                                <a class="nav-link saas " href="pages.php?page=sale_reports">
                                                <i class="ion ion-md-stats"></i> <?=$diller['adminpanel-form-text-1717']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                                <a class="nav-link saas active" href="pages.php?page=sale_reports_date">
                                               <i class="fa fa-calendar-check"></i> <?=$diller['adminpanel-form-text-1718']?>
                                            </a>
                                        </li>

                                    </ul>

                                    <div class="tab-content bg-white rounded-bottom border border-top-0">
                                        <div class="tab-pane active p-4" id="one" role="tabpanel" >
                                            <div class="w-100 alert-warning border border-warning p-2 mb-3 text-dark d-flex align-items-center">
                                                <i class="ti-help-alt text-primary mr-2 text-dark" ></i>
                                                <?=$diller['adminpanel-text-83']?>
                                                <div class="ml-2"><strong>[<?=$Current_Money['sag_simge']?>]</strong></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <div class="border bg-light">
                                                        <div class="card-body">
                                                            <form action="pages.php" method="get">
                                                                <input type="hidden" name="page" value="sale_reports_date" >
                                                                <div class="row">
                                                                    <div class="form-group col-md-4">
                                                                        <label for=""><?=$diller['adminpanel-form-text-1088']?></label>
                                                                        <div>
                                                                            <div class="input-group">
                                                                                <input type="text" <?php if($_GET['date'] >0  ) { ?>value="<?=$_GET['date']?>" <?php }?> name="date" class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_selected_first" autocomplete="off" required style="height: 40px">
                                                                                <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                                            </div><!-- input-group -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4">
                                                                        <label for=""><?=$diller['adminpanel-form-text-1089']?></label>
                                                                        <div>
                                                                            <div class="input-group">
                                                                                <input type="text" <?php if($_GET['date_end'] >0  ) { ?>value="<?=$_GET['date_end']?>" <?php }?> name="date_end" class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_selected_end" autocomplete="off" required style="height: 40px">
                                                                                <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                                            </div><!-- input-group -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 text-left">
                                                                        <button class="btn  btn-primary "><i class="fa fa-filter"></i> <?=$diller['adminpanel-form-text-1090']?></button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                <?php if(isset($_GET['date']) && isset($_GET['date_end'])) {?>
                                                    <?php if($_GET['date'] > 0  && $_GET['date_end'] >0  ) {?>
                                                        <div class="col-md-12 mb-3">
                                                            <div class=" bg-light " >
                                                                <div class="card-body text-center" style="font-size: 14px ; ">
                                                                    <strong><?php echo date_tr('j F Y', ''.$_GET['date'].''); ?></strong>
                                                                    -
                                                                    <strong><?php echo date_tr('j F Y', ''.$_GET['date_end'].''); ?></strong>
                                                                    <?=$diller['adminpanel-form-text-1721']?>
                                                                </div>
                                                            </div>
                                                            <a href="pages.php?page=sale_reports_date" class="btn btn-pink btn-block" style="border-radius: 0 0 4px 4px">
                                                                <i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1114']?>
                                                            </a>
                                                        </div>
                                                    <?php }else { ?>
                                                        <?php
                                                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=sale_reports_date');
                                                        exit();
                                                        ?>
                                                    <?php }?>
                                                <?php }?>



                                                <?php if(isset($_GET['date']) && isset($_GET['date_end'])) {

                                                    if (isset($_GET['date']) && $_GET['date'] == !null && isset($_GET['date_end']) && $_GET['date_end'] == !null) {
                                                        $date1 = $_GET['date'];
                                                        $date2= $_GET['date_end'];
                                                        $minDate = "sade_tarih >= '$date1'";
                                                        $maxDate = "and sade_tarih <= '$date2'";
                                                    }else{
                                                        $minDate = null;
                                                        $maxDate = null;
                                                    }

                                                    $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
                                                    $Say = $db->query("select * from siparisler where onay='1' and $minDate $maxDate and parabirimi= '$Current_Money[kod]' ");
                                                    $ToplamVeri = $Say->rowCount();
                                                    $Limit = 50;
                                                    $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
                                                    $Goster = $Sayfa * $Limit - $Limit;
                                                    $GorunenSayfa = 5;
                                                    $islemListele = $db->query("select * from siparisler where onay='1' and $minDate $maxDate and parabirimi= '$Current_Money[kod]' order by id desc limit $Goster,$Limit");
                                                    $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

                                                    $ziy = $db->prepare("select SUM(toplam_tutar) AS toplam from siparisler where onay='1' and $minDate $maxDate and parabirimi= '$Current_Money[kod]' ");
                                                    $ziy->execute();
                                                    $saleReportRow = $ziy->fetch(PDO::FETCH_ASSOC);
                                                    $ziyHavale = $db->prepare("select SUM(havale_toplamtutar) AS toplam from siparisler where onay='1' and $minDate $maxDate and parabirimi= '$Current_Money[kod]' ");
                                                    $ziyHavale->execute();
                                                    $saleReportHavaleRow = $ziyHavale->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="w-100 bg-light mb-3 p-3" style="font-size: 16px ;">
                                                            <?=$diller['adminpanel-form-text-1124']?> <strong><?=$ToplamVeri?></strong>
                                                            <br>
                                                            <?=$diller['adminpanel-form-text-1722']?> : <strong><?=$saleReportRow['toplam']+$saleReportHavaleRow['toplam']?> <?=$Current_Money['sag_simge']?></strong>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-hover text-left mb-0 table-bordered">
                                                                <thead class="thead-default">
                                                                <tr>
                                                                    <th><?=$diller['adminpanel-form-text-1460']?></th>
                                                                    <th><?=$diller['adminpanel-form-text-1722']?></th>
                                                                    <th><?=$diller['users-panel-text141']?></th>
                                                                    <th><?=$diller['adminpanel-form-text-1217']?></th>
                                                                    <th><?=$diller['adminpanel-form-text-1520']?></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php foreach ($islemCek as $row) {?>
                                                                    <tr >
                                                                        <td>
                                                                            <?php echo date_tr('j F Y', ''.$row['siparis_tarih'].''); ?>
                                                                        </td>
                                                                        <td style="font-weight: 600;">
                                                                           <?php if($row['odeme_tur'] == '2' ) {?>
                                                                           <?php echo number_format($row['havale_toplamtutar'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                                           <?php }else { ?>
                                                                               <?php echo number_format($row['toplam_tutar'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                                           <?php }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($row['odeme_tur'] == '2' ) {?>
                                                                                <?php echo number_format($row['havale_kdvtutar'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                                            <?php }else { ?>
                                                                                <?php echo number_format($row['kdv_tutar'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                                            <?php }?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo number_format($row['indirim_tutar'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if($row['odeme_tur'] == '2' ) {?>
                                                                                <?php echo number_format($row['havale_kargotutar'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                                            <?php }else { ?>
                                                                                <?php echo number_format($row['kargo_tutar'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                                            <?php }?>
                                                                        </td>
                                                                    </tr>
                                                                <?php }?>
                                                                </tbody>
                                                            </table>
                                                            <?php if($ToplamVeri<='0' ) {?>
                                                                <div class="w-100  p-3 ">
                                                                    <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                                                </div>
                                                            <?php }?>
                                                        </div>


                                                        <!---- Sayfalama Elementleri ================== !-->
                                                        <?php if($ToplamVeri > $Limit  ) {?>
                                                            <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                                                <?php if($Sayfa >= 1){?>
                                                                <nav aria-label="Page navigation example " >
                                                                    <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                                                        <?php } ?>
                                                                        <?php if($Sayfa > 1){  ?>
                                                                            <li class="page-item "><a class="page-link " href="pages.php?page=sale_reports_date<?=$datePage?><?=$showPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                                            <li class="page-item "><a class="page-link " href="pages.php?page=sale_reports_date<?=$datePage?><?=$showPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                                        <?php } ?>
                                                                        <?php
                                                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                                            if($i == $Sayfa){
                                                                                ?>
                                                                                <li class="page-item active " aria-current="page">
                                                                                    <a class="page-link" href="pages.php?page=sale_reports_date<?=$datePage?><?=$showPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                                                </li>
                                                                                <?php
                                                                            }else{
                                                                                ?>
                                                                                <li class="page-item "><a class="page-link" href="pages.php?page=sale_reports_date<?=$datePage?><?=$showPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        }
                                                                        ?>

                                                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                                                <li class="page-item"><a class="page-link" href="pages.php?page=sale_reports_date<?=$datePage?><?=$showPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                                                <li class="page-item"><a class="page-link" href="pages.php?page=sale_reports_date<?=$datePage?><?=$showPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                                                            <?php }} ?>
                                                                        <?php if($Sayfa >= 1){?>
                                                                    </ul>
                                                                </nav>
                                                            <?php } ?>
                                                            </div>
                                                        <?php }?>
                                                        <!---- Sayfalama Elementleri ================== !-->
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="col-md-12 ">
                                                        <div class=" bg-light ">
                                                            <div class="card-body">
                                                                <i class="fa fa-info-circle"></i> <?=$diller['adminpanel-form-text-1720']?>
                                                            </div>
                                                        </div>
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

            <script>
                var dateToday = new Date();
                var selectedDate;
                $("#date_selected_first").datepicker(    {
                        monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                        dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                        firstDay:1,
                        maxDate:dateToday,
                        dateFormat: "yy-mm-dd",
                        changeYear: true,
                        showButtonPanel: true,
                    },
                );
                $("#date_selected_end").datepicker(    {
                        monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                        dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                        firstDay:1,
                        maxDate:dateToday,
                        dateFormat: "yy-mm-dd",
                        changeYear: true,
                        showButtonPanel: true,
                    },
                );
            </script>
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
