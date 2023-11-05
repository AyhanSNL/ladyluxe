<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
/* Tüm zamanlar */
$orderReports = $db->prepare("select * from siparisler where onay=:onay and parabirimi=:parabirimi ");
$orderReports->execute(array(
    'onay' => '1',
    'parabirimi' => $Current_Money['kod']
));
$AllTimesTotalOrder= $orderReports->rowCount();
/*  <========SON=========>>> Tüm zamanlar SON */


/* Bugün */
$today = date("Y-m-d");
$todayOrderReports = $db->prepare("select * from siparisler where sade_tarih='$today' and onay='1' and parabirimi= '$Current_Money[kod]' ");
$todayOrderReports->execute();
/*  <========SON=========>>> Bugün SON */


/* Bu Ay */
$cevir = strtotime('-30 day',strtotime($today));
$lastmonth = date("Y-m-d",$cevir);
$lastMonthOrderReports = $db->prepare("select * from siparisler where sade_tarih >='$lastmonth' and onay='1' and parabirimi= '$Current_Money[kod]' ");
$lastMonthOrderReports->execute();
/*  <========SON=========>>> Bu Ay SON */

?>
<div class="col-md-4 ">
    <div class="card bg-light">
        <div class="card-body d-flex align-items-start justify-content-start ">
            <div class="flex-grow-1 font-20 ">
                <div class="bg-primary rounded-circle align-items-center text-white justify-content-center d-flex " style="padding: 10px; width: 40px">
                    <i class="ion ion-md-stats"></i>
                </div>
            </div>
            <div class="flex-grow-1 text-left flex-column">
                <div class="font-14"><?=$diller['adminpanel-text-76']?> <span class="float-right text-primary " style="font-size: 11px ; font-weight: 600;" ><?=$Current_Money['kod']?></span></div>
                <div style="width: 30px; height: 2px; background-color: #333; margin:10px 0"></div>
                <div style="font-size: 16px ; font-weight: 600;"><?=$AllTimesTotalOrder?></div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card bg-light">
        <div class="card-body d-flex align-items-start justify-content-start ">
            <div class="flex-grow-1 font-20 ">
                <div class="bg-primary rounded-circle align-items-center text-white justify-content-center d-flex " style="padding: 10px; width: 40px">
                    <i class="ion ion-md-stats"></i>
                </div>
            </div>
            <div class="flex-grow-1 text-left flex-column">
                <div class="font-14"><?=$diller['adminpanel-text-77']?> <span class="float-right text-primary " style="font-size: 11px ; font-weight: 600;" ><?=$Current_Money['kod']?></span></div>
                <div style="width: 30px; height: 2px; background-color: #333; margin:10px 0"></div>
                <div style="font-size: 16px ; font-weight: 600;"><?=$todayOrderReports->rowCount()?></div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card bg-light" >
        <div class="card-body d-flex align-items-start justify-content-start">
            <div class="flex-grow-1 font-20 ">
                <div class="bg-primary rounded-circle align-items-center text-white justify-content-center d-flex " style="padding: 10px; width: 40px">
                    <i class="ion ion-md-stats"></i>
                </div>
            </div>
            <div class="flex-grow-1 text-left flex-column">
                <div class="font-14"><?=$diller['adminpanel-text-78']?> <span class="float-right text-primary " style="font-size: 11px ; font-weight: 600;" ><?=$Current_Money['kod']?></span></div>
                <div style="width: 30px; height: 2px; background-color: #333; margin:10px 0"></div>
                <div style="font-size: 16px ; font-weight: 600;"><?=$lastMonthOrderReports->rowCount()?></div>
            </div>
        </div>
    </div>
</div>
