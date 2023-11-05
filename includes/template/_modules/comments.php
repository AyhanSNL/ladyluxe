<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$yorumsettings = $db->prepare("select * from yorum_ayar where id='1'");
$yorumsettings->execute();
$yorumset = $yorumsettings->fetch(PDO::FETCH_ASSOC);
$yorumlimit = $yorumset["yorum_limit"];

?>
<?php
$num = 1;
$yorum_listele = $db->prepare("select * from yorum where durum='1' and dil='$_SESSION[dil]' order by sira asc limit $yorumlimit");
$yorum_listele->execute();

$yorumSay = $db->prepare("select * from yorum where durum='1' and dil='$_SESSION[dil]'");
$yorumSay->execute();
?>
<div class="yorumlar-module-main-div">
    <div class="yorumlar-module-inside-area">


        <?php if($diller['anasayfa-yorumlar-baslik'] == !null || $diller['anasayfa-yorumlar-altbaslik'] == !null  ) {?>
            <!-- Modül başlıgı ve üst başlıgı !-->
            <div class="modules-head-text-main">
                <?php if($diller['anasayfa-yorumlar-baslik'] == !null  ) {?>
                    <?php if($yorumset['yorum_baslik_tip'] == '0' ) {?>
                        <div class="modules-head-text-h <?=$yorumset['baslik_space']?>" style="color: #<?=$yorumset['baslik_renk']?>; margin-bottom: 0; font-size: 25px ; font-weight: bold;">
                            <?=$diller['anasayfa-yorumlar-baslik']?>
                        </div>
                    <?php }?>
                    <?php if($yorumset['yorum_baslik_tip'] == '1' ) {?>
                        <div class="modules-head-forbg-text-out" style="border-bottom: 1px solid #<?=$yorumset['yorum_baslik_cizgi']?>; ">
                            <div class="modules-head-forbg-text <?=$yorumset['baslik_space']?>" style="color: #<?=$yorumset['baslik_renk']?>;  background-color: #<?=$yorumset['yorum_baslik_bg']?>; ">
                                <?=$diller['anasayfa-yorumlar-baslik']?>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>
                <div class="modules-head-text-s <?=$yorumset['baslik_space']?>" style="color: #<?=$yorumset['spot_renk']?>; margin-bottom: 0;">
                    <?=$diller['anasayfa-yorumlar-altbaslik']?>
                </div>
                <?php if($yorumSay->rowCount() > $yorumlimit  ) {?>
                    <br>
                    <a href="musteri-yorumlari/" class="<?=$yorumset['tumu_buton']?> button-1x"><?=$diller['anasayfa-yorumlar-button']?></a>
                <?php }?>
            </div>
            <!-- Modül başlıgı ve üst başlıgı SON !-->
        <?php }?>

        <div class="yorumlar-content-area">
            <!-- Carousel Alanı !-->
            <div class="swiper-comments">
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <div class="swiper-wrapper">
                    <?php foreach ($yorum_listele as $yor) {?>
                        <div class="swiper-slide">
                            <div class="yorumlar-box-img" style="border: 4px solid #<?=$yorumset['yorum_border_renk']?>;">
                                <?php if($yor['gorsel'] == 'no-image'  ) {?>
                                    <img src="images/comments/def_com.jpg" alt="<?=$yor['isim']?>">
                                <?php }else { ?>
                                    <?php if($ayar['lazy'] == '1' ) {?>
                                        <img class="lazy" src="images/load.gif" data-original="images/comments/<?=$yor['gorsel']?>" alt="<?=$yor['isim']?>">
                                    <?php }else { ?>
                                        <img src="images/comments/<?=$yor['gorsel']?>" alt="<?=$yor['isim']?>">
                                    <?php }?>
                                <?php }?>
                            </div>
                            <div class="yorumlar-text-area">
                                <div class="yorumlar-text-p" style="color: #<?=$yorumset['yorum_poz_renk']?>;">
                                    <?=$yor['pozisyon']?>
                                </div>
                                <div class="yorumlar-text-h" style="color: #<?=$yorumset['yorum_isim_renk']?>;">
                                    <?=$yor['isim']?>
                                </div>
                                <div class="yorumlar-text-s" style="color: #<?=$yorumset['yorum_yazisi_renk']?>;">
                                    <?=$yor['icerik']?>
                                    <br>
                                    <i class="fa fa-quote-right" style="font-size: 30px ;"></i>
                                </div>
                                <div class="yorumlar-text-star">
                                    <?php if($yor['star_rate'] == 0){ ?>
                                        <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                    <?php }?>
                                    <?php if($yor['star_rate'] == 1){ ?>
                                        <span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                    <?php }?>
                                    <?php if($yor['star_rate'] == 2){ ?>
                                        <span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                    <?php }?>
                                    <?php if($yor['star_rate'] == 3){ ?>
                                        <span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                    <?php }?>
                                    <?php if($yor['star_rate'] == 4){ ?>
                                        <span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#CCC">★</span>
                                    <?php }?>
                                    <?php if($yor['star_rate'] == 5){ ?>
                                        <span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span><span style="color:#<?php echo $yorumset['yorum_star_renk']?>">★</span>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>

            </div>
            <!-- Carousel Alanı SON !-->
        </div>

    </div>
    <?php if($yorumset['bg_tip'] == '0'  ) {?>
        <?php if($yorumset['bg_dark'] == '1'  ) {?>
            <!-- Slider Karartma Var ise !-->
            <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
            <!-- Slider Karartma Var ise !-->
        <?php }?>
    <?php }?>
</div>

