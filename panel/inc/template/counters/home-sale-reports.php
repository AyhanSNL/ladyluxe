<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
/* Tüm zamanlar */
$saleReports = $db->prepare("select SUM(toplam_tutar) AS toplam from siparisler where onay=:onay and parabirimi=:parabirimi ");
$saleReports->execute(array(
    'onay' => '1',
    'parabirimi' => $Current_Money['kod']
));
$saleReportRow = $saleReports->fetch(PDO::FETCH_ASSOC);
$saleReportshavale = $db->prepare("select SUM(havale_toplamtutar) AS toplam from siparisler where onay=:onay and parabirimi=:parabirimi ");
$saleReportshavale->execute(array(
    'onay' => '1',
    'parabirimi' => $Current_Money['kod']
));
$saleReportHavaleRow = $saleReportshavale->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Tüm zamanlar SON */


/* Bugün */
$today = date("Y-m-d");
$todaySaleReports = $db->prepare("select SUM(toplam_tutar) AS toplam from siparisler where sade_tarih='$today' and onay='1' and parabirimi= '$Current_Money[kod]' ");
$todaySaleReports->execute();
$TodaysaleReportRow = $todaySaleReports->fetch(PDO::FETCH_ASSOC);

$todaySaleReportsHavale = $db->prepare("select SUM(havale_toplamtutar) AS toplam from siparisler where sade_tarih='$today' and onay='1' and parabirimi= '$Current_Money[kod]' ");
$todaySaleReportsHavale->execute();
$TodaysaleReportHavaleRow = $todaySaleReportsHavale->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Bugün SON */


/* Bu Ay */
$cevir = strtotime('-30 day',strtotime($today));
$lastmonth = date("Y-m-d",$cevir);
$monthSaleReports = $db->prepare("select SUM(toplam_tutar) AS toplam from siparisler where sade_tarih >='$lastmonth' and onay='1' and parabirimi= '$Current_Money[kod]' ");
$monthSaleReports->execute();
$monthsaleReportRow = $monthSaleReports->fetch(PDO::FETCH_ASSOC);

$monthSaleReportsHavale = $db->prepare("select SUM(havale_toplamtutar) AS toplam from siparisler where sade_tarih >='$lastmonth' and onay='1' and parabirimi= '$Current_Money[kod]' ");
$monthSaleReportsHavale->execute();
$monthsaleReportHavaleRow = $monthSaleReportsHavale->fetch(PDO::FETCH_ASSOC);

/*  <========SON=========>>> Bu Ay SON */

?>
<div class="col-md-4">
    <div class="card bg-light" style="margin-bottom: 15px;">
        <div class="card-body d-flex align-items-start justify-content-start ">
            <div class="flex-grow-1 font-20 ">
                <div class="bg-success rounded-circle align-items-center text-white justify-content-center d-flex " style="padding: 10px; width: 40px">
                    <i class="fa fa-coins"></i>
                </div>
            </div>
            <div class="flex-grow-1 text-left ">
                <div class="font-14"><?=$diller['adminpanel-text-80']?></div>
                <div style="width: 30px; height: 2px; background-color: #333; margin:10px 0"></div>
                <div style="font-size: 16px ; font-weight: 600;">
                   <?php echo number_format($saleReportRow['toplam']+$saleReportHavaleRow['toplam'], 2); ?> <?=$Current_Money['kod']?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card bg-light" style="margin-bottom: 15px;">
        <div class="card-body d-flex align-items-start justify-content-start ">
            <div class="flex-grow-1 font-20 ">
                <div class="bg-success rounded-circle align-items-center text-white justify-content-center d-flex " style="padding: 10px; width: 40px">
                    <i class="fa fa-coins"></i>
                </div>
            </div>
            <div class="flex-grow-1 text-left ">
                <div class="font-14"><?=$diller['adminpanel-text-81']?></div>
                <div style="width: 30px; height: 2px; background-color: #333; margin:10px 0"></div>
                <div style="font-size: 16px ; font-weight: 600;">
                    <?php echo number_format($TodaysaleReportRow['toplam']+$TodaysaleReportHavaleRow['toplam'], 2); ?> <?=$Current_Money['kod']?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card bg-light" style="margin-bottom: 15px;">
        <div class="card-body d-flex align-items-start justify-content-start ">
            <div class="flex-grow-1 font-20 ">
                <div class="bg-success rounded-circle align-items-center text-white justify-content-center d-flex " style="padding: 10px; width: 40px">
                    <i class="fa fa-coins"></i>
                </div>
            </div>
            <div class="flex-grow-1 text-left ">
                <div class="font-14"><?=$diller['adminpanel-text-82']?></div>
                <div style="width: 30px; height: 2px; background-color: #333; margin:10px 0"></div>
                <div style="font-size: 16px ; font-weight: 600;">
                    <?php echo number_format($monthsaleReportRow['toplam']+$monthsaleReportHavaleRow['toplam'], 2); ?> <?=$Current_Money['kod']?>
                </div>
            </div>
        </div>
    </div>
</div>