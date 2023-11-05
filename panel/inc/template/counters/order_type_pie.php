<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
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
<div  id="pie-chart">
    <div id="pie-chart-container" class="flot-chart" style="height: 320px">
    </div>
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
