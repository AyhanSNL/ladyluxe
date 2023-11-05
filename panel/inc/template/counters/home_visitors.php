<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
/* Bugün verilerini çek */
$bugun = date("Y-m-d");
$bugunTekiLCek = $db->prepare("select * from ziyaretciler where tarih='$bugun' group by ipadres");
$bugunTekiLCek->execute();
/*  <========SON=========>>> Bugün verilerini çek SON */

/* Bu Hafta verilerini çek */
$cevir = strtotime('-7 day',strtotime($bugun));
$buhafta = date("Y-m-d",$cevir);
$buhaftaTekilCek = $db->prepare("select * from ziyaretciler where tarih>='$buhafta' group by ipadres");
$buhaftaTekilCek->execute();
/*  <========SON=========>>> Bu Hafta verilerini çek SON */

/* Bu Ay verilerini çek */
$cevir = strtotime('-30 day',strtotime($bugun));
$buay = date("Y-m-d",$cevir);
$buayTekilCek = $db->prepare("select * from ziyaretciler where tarih>='$buay' group by ipadres");
$buayTekilCek->execute();
/*  <========SON=========>>> Bu Ay verilerini çek SON */


/* Bu Hafta Pasta İstatistikleri */
$buHaftaDesktopPie = $db->prepare("select * from ziyaretciler where tarih>='$buhafta' and cihaz='desktop' group by ipadres");
$buHaftaDesktopPie->execute();
$desktopPie = $buHaftaDesktopPie->rowCount();
$buHaftaMobilePie = $db->prepare("select * from ziyaretciler where tarih>='$buhafta' and cihaz='mobile' group by ipadres");
$buHaftaMobilePie->execute();
$mobilePie = $buHaftaMobilePie->rowCount();
/*  <========SON=========>>> Bu Hafta Pasta İstatistikleri SON */

?>
<ul class="list-inline widget-chart m-t-20 m-b-15 text-center">
    <li class="list-inline-item bg-light" style="border: 1px solid #fff;">
        <h5><?=$bugunTekiLCek->rowCount()?></h5>
        <p class="text-muted"><?=$diller['adminpanel-text-63']?></p>
    </li>
    <li class="list-inline-item bg-light" style="border: 1px solid #fff;">
        <h5><?=$buhaftaTekilCek->rowCount()?></h5>
        <p class="text-muted"><?=$diller['adminpanel-text-64']?></p>
    </li>
    <li class="list-inline-item bg-light" style="border: 1px solid #fff;">
        <h5><?=$buayTekilCek->rowCount()?></h5>
        <p class="text-muted"><?=$diller['adminpanel-text-65']?></p>
    </li>
</ul>
<div class="d-none d-md-inline-block w-100 text-center">
    <canvas id="pie"  height="250"></canvas>
</div>
<script src="plugins/chartjs/chart.min.js"></script>
<script>
    !function($) {
        "use strict";
        var ChartJs = function() {};
        ChartJs.prototype.respChart = function(selector,type,data, options) {
            var ctx = selector.get(0).getContext("2d");
            var container = $(selector).parent();
            $(window).resize( generateChart );
            function generateChart(){
                var ww = selector.attr('width', $(container).width() );
                switch(type){
                    case 'Pie':
                        new Chart(ctx, {type: 'pie', data: data, options: options});
                        break;
                }
            };
            generateChart();
        },
            ChartJs.prototype.init = function() {
                var pieChart = {
                    labels: [
                        "<?=$diller['adminpanel-text-66']?>",
                        "<?=$diller['adminpanel-text-67']?>"
                    ],
                    datasets: [
                        {
                            data: [<?=$desktopPie?>, <?=$mobilePie?>],
                            backgroundColor: [
                                "#46cd93",
                                "#ebeff2"
                            ],
                            hoverBackgroundColor: [
                                "#46cd93",
                                "#ebeff2"
                            ],
                            hoverBorderColor: "#fff"
                        }]
                };
                this.respChart($("#pie"),'Pie',pieChart);

            },
            $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

    }(window.jQuery),
        function($) {
            "use strict";
            $.ChartJs.init()
        }(window.jQuery);
</script>