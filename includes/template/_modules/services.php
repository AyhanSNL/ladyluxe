<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$serviceayar = $db->prepare("select * from hizmet_ayar where id='1'");
$serviceayar->execute();
$serv = $serviceayar->fetch(PDO::FETCH_ASSOC);
$hizmetlimit = $serv['hizmet_limit'];
?>
<?php
$num = 1;
$serviceliste = $db->prepare("select * from hizmet where durum='1' and dil='$_SESSION[dil]' and anasayfa='1' order by sira asc limit $hizmetlimit");
$serviceliste->execute();
$totalServiceCount = $db->prepare("select * from hizmet where durum='1' and dil='$_SESSION[dil]' ");
$totalServiceCount->execute();
?>
<?php if($serviceliste->rowCount() > 0) {?>
    <div class="hizmetler-module-main-div">
        <div class="hizmetler-module-inside-area">



            <?php if($diller['anasayfa-hizmetler-baslik'] == !null || $diller['anasayfa-hizmetler-altbaslik'] == !null  ) {?>
                <!-- Modül başlıgı ve üst başlıgı !-->
                <div class="modules-head-text-main">
                    <?php if($diller['anasayfa-hizmetler-baslik'] == !null  ) {?>
                        <?php if($serv['hizmet_baslik_tip'] == '0' ) {?>
                            <div class="modules-head-text-h <?=$serv['baslik_space']?>" style="color: #<?=$serv['baslik_renk']?>; margin-bottom: 0; font-size: 25px ; font-weight: bold;">
                                <?=$diller['anasayfa-hizmetler-baslik']?>
                            </div>
                        <?php }?>
                        <?php if($serv['hizmet_baslik_tip'] == '1' ) {?>
                            <div class="modules-head-forbg-text-out" style="border-bottom: 1px solid #<?=$serv['hizmet_baslik_cizgi']?>; ">
                                <div class="modules-head-forbg-text <?=$serv['baslik_space']?>" style="color: #<?=$serv['baslik_renk']?>;     background-color: #<?=$serv['hizmet_baslik_bg']?>; ">
                                    <?=$diller['anasayfa-hizmetler-baslik']?>
                                </div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <div class="modules-head-text-s <?=$serv['baslik_space']?>" style="color: #<?=$serv['spot_renk']?>; margin-bottom: 0;">
                        <?=$diller['anasayfa-hizmetler-altbaslik']?>
                    </div>
                </div>
                <!-- Modül başlıgı ve üst başlıgı SON !-->
            <?php }?>


            <div class="hizmetler-box-main-div">
                <?php foreach ($serviceliste as $hizmet ) {?>
                    <div class="hizmetler-box <?=$serv['kutu_space']?>"  >
                        <div class="hizmetler-box-img">
                            <a href="hizmet/<?=$hizmet['seo_url']?>/">
                                <div class="hizmetler-box-line"></div>
                                <?php if($ayar['lazy'] == '1' ) {?>
                                    <img class="lazy" src="images/load.gif" data-original="images/services/<?=$hizmet['gorsel']?>" alt="<?=$hizmet['baslik']?>">
                                <?php }else { ?>
                                    <img src="images/services/<?=$hizmet['gorsel']?>" alt="<?=$hizmet['baslik']?>">
                                <?php }?>
                            </a>
                        </div>
                        <div class="hizmetler-box-h" style="font-size: <?=$serv['kutu_font_size']?>px ; ">
                            <a href="hizmet/<?=$hizmet['seo_url']?>/" style="color: #<?=$serv['kutu_yazi_renk']?>;">
                                <?=$hizmet['baslik']?>
                            </a>
                        </div>
                        <?php if($hizmet['spot'] == !null) {?>
                            <div class="hizmetler-box-s" style="color: #<?=$serv['kutu_yazi_renk']?>; ">
                                <?=$hizmet['spot']?>
                            </div>
                        <?php }?>
                    </div>
                <?php }?>
            </div>

            <?php if($totalServiceCount->rowCount() > $hizmetlimit  ) {?>
                <a href="hizmetler/" class="<?=$serv['button_renk']?> button-4x lspacsmall">
                    <?=$diller['anasayfa-hizmetler-tumu-yazisi']?>
                </a>
            <?php }?>


        </div>
        <?php if($serv['bg_tip'] == '0'  ) {?>
            <?php if($serv['bg_dark'] == '1'  ) {?>
                <!-- Slider Karartma Var ise !-->
                <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                <!-- Slider Karartma Var ise !-->
            <?php }?>
        <?php }?>
    </div>
<?php } ?>
