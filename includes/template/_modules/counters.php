<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$countersettings = $db->prepare("select * from sayac_ayar where id='1'");
$countersettings->execute();
$countsett = $countersettings->fetch(PDO::FETCH_ASSOC);
?>
<?php
$counter_counts = $db->prepare("select * from sayac where durum='1' and dil='$_SESSION[dil]' order by sira asc");
$counter_counts->execute();
$sayi = 2;
?>
<?php if($counter_counts->rowCount() > 0) { ?>
    <div class="counter-module-main-div">
        <div class="counter-module-inside-area counters">
        <?php foreach ($counter_counts as $count1){ ?>
            <div class="counter-module-box <?=$countsett['yazi_space']?>" data-appear-animation="fadeInUp" data-appear-animation-delay="<?=$sayi++;?>00">
                <?php if ($count1['icon'] == !null) {?>
                    <div class="counter-module-box-i" style="color: #<?=$countsett['yazi_renk']?>;">
                    <i class="fa <?php echo $count1['icon'] ?>"></i>
                    </div>
                <?php }?>
                <div class="counter-module-box-sayi" style="color: #<?=$countsett['yazi_renk']?>; <?php if($countsett['border'] == '1'  ) { ?>border: 1px solid #<?=$countsett['yazi_renk']?>;<?php }?>">
                    <span data-to="<?php echo $count1['count'] ?>" <?php if($count1['plus'] == '1') { ?>data-append="+"<?php }?> >0</span><br>
                </div>
                <div class="counter-module-box-txt" style="color: #<?=$countsett['yazi_renk']?>;">
                    <label><?php echo $count1['baslik'] ?></label>
                </div>
            </div>
        <?php } ?>
        </div>
        <?php if($countsett['bg_tip'] == '0'  ) {?>
            <?php if($countsett['bg_dark'] == '1'  ) {?>
                <!-- Slider Karartma Var ise !-->
                <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                <!-- Slider Karartma Var ise !-->
            <?php }?>
        <?php }?>
    </div>
<?php } ?>