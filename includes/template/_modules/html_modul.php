<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
    $aboutCek = $db->prepare("select * from html_modul where dil=:dil order by id desc limit 1 ");
        $aboutCek->execute(array(
                'dil' => $_SESSION['dil']
        ));
        $about = $aboutCek->fetch(PDO::FETCH_ASSOC);
?>
<div <?php if($about['boxed'] == '1' ) { ?>class="about-module-main-div-boxed <?php if($about['round'] == '1' ) { ?>rounded<?php }?>"<?php }else{?>class="about-module-main-div "<?php } ?> >
    <div <?php if($about['boxed'] == '1' ) { ?>class="about-module-inside-area-boxed"<?php }else{?>class="about-module-inside-area"<?php } ?> >
        <?php if($about['area'] == '1'  ) {?>
            <?php if( $about['ustbaslik'] == !null || $about['baslik'] == !null || $about['spot'] == !null) {?>
                <div class="about-module-leftside-txt">
                    <?php if($about['ustbaslik'] == !null ) {?>
                        <div class="about-module-leftside-txt-h <?=$about['baslik_space']?>" style="color: #<?=$about['ustbaslik_renk']?>;">
                            <?=$about['ustbaslik']?>
                        </div>
                    <?php }?>
                    <?php if($about['baslik'] == !null ) {?>
                        <div class="about-module-leftside-txt-h2 <?=$about['baslik_space']?>" style="color: #<?=$about['baslik_renk']?>;">
                            <?=$about['baslik']?>
                        </div>
                    <?php }?>
                    <?php if($about['spot'] == !null ) {?>
                        <div class="about-module-leftside-txt-s "style="color: #<?=$about['spot_renk']?>;">
                            <?php
                            $content  = $about['spot'];
                            $eski   = "../i/";
                            $yeni   = "i/";
                            $content = str_replace($eski, $yeni, $content);
                            ?>
                            <?=$content?>
                        </div>
                    <?php }?>
                    <?php if($about['url'] == !null ) {?>
                        <div class="about-module-leftside-txt-button-area">
                            <a <?php if($about['yeni_sekme'] == '1' ) { ?>target="_blank"<?php }?> href="<?=$about['url']?>" class="<?=$about['button_renk']?> <?=$about['baslik_space']?> <?=$about['button_size']?>"><?=$about['button_yazi']?></a>
                        </div>
                    <?php }?>
                </div>
            <?php }?>
            <?php if($about['gorsel'] == !null  ) {?>
                <div class="about-module-leftside-img">
                    <?php if($ayar['lazy'] == '1' ) {?>
                        <img class="lazy" src="images/load.gif" data-original="images/uploads/<?=$about['gorsel']?>" alt="<?=$about['baslik']?>">
                    <?php }else { ?>
                        <img src="images/uploads/<?=$about['gorsel']?>" alt="<?=$about['baslik']?>">
                    <?php }?>
                </div>
            <?php }?>
        <?php }?>
        <?php if($about['area'] == '0'  ) {?>
            <?php if( $about['ustbaslik'] == !null || $about['baslik'] == !null || $about['spot'] == !null) {?>
                <div class="about-module-center-txt">
                    <?php if($about['ustbaslik'] == !null ) {?>
                        <div class="about-module-center-txt-h <?=$about['baslik_space']?>" style="color: #<?=$about['ustbaslik_renk']?>;">
                            <?=$about['ustbaslik']?>
                        </div>
                    <?php }?>
                    <?php if($about['baslik'] == !null ) {?>
                        <div class="about-module-center-txt-h2 <?=$about['baslik_space']?>" style="color: #<?=$about['baslik_renk']?>;">
                            <?=$about['baslik']?>
                        </div>
                    <?php }?>
                    <?php if($about['spot'] == !null ) {?>
                        <div class="about-module-center-txt-s "style="color: #<?=$about['spot_renk']?>;">
                            <?php
                            $content  = $about['spot'];
                            $eski   = "../i/";
                            $yeni   = "i/";
                            $content = str_replace($eski, $yeni, $content);
                            ?>
                            <?=$content?>
                        </div>
                    <?php }?>
                    <?php if($about['url'] == !null ) {?>
                        <div class="about-module-center-txt-button-area">
                            <a <?php if($about['yeni_sekme'] == '1' ) { ?>target="_blank"<?php }?> href="<?=$about['url']?>" class="<?=$about['button_renk']?> <?=$about['baslik_space']?> <?=$about['button_size']?>"><?=$about['button_yazi']?></a>
                        </div>
                    <?php }?>
                </div>
            <?php } ?>
            <?php if($about['gorsel'] == !null  ) {?>
                <div class="about-module-center-img">
                    <?php if($ayar['lazy'] == '1' ) {?>
                        <img class="lazy" src="images/load.gif" data-original="images/uploads/<?=$about['gorsel']?>" alt="<?=$about['baslik']?>">
                    <?php }else { ?>
                        <img src="images/uploads/<?=$about['gorsel']?>" alt="<?=$about['baslik']?>">
                    <?php }?>
                </div>
            <?php }?>
        <?php }?>
        <?php if($about['area'] == '2'  ) {?>
            <?php if($about['gorsel'] == !null  ) {?>
                <div class="about-module-rightside-img">
                    <?php if($ayar['lazy'] == '1' ) {?>
                        <img class="lazy" src="images/load.gif" data-original="images/uploads/<?=$about['gorsel']?>" alt="<?=$about['baslik']?>">
                    <?php }else { ?>
                        <img src="images/uploads/<?=$about['gorsel']?>" alt="<?=$about['baslik']?>">
                    <?php }?>
                </div>
            <?php }?>
            <?php if( $about['ustbaslik'] == !null || $about['baslik'] == !null || $about['spot'] == !null) {?>
                <div class="about-module-rightside-txt">
                    <?php if($about['ustbaslik'] == !null ) {?>
                        <div class="about-module-rightside-txt-h <?=$about['baslik_space']?>" style="color: #<?=$about['ustbaslik_renk']?>;">
                            <?=$about['ustbaslik']?>
                        </div>
                    <?php }?>
                    <?php if($about['baslik'] == !null ) {?>
                        <div class="about-module-rightside-txt-h2 <?=$about['baslik_space']?>" style="color: #<?=$about['baslik_renk']?>;">
                            <?=$about['baslik']?>
                        </div>
                    <?php }?>
                    <?php if($about['spot'] == !null ) {?>
                        <div class="about-module-rightside-txt-s "style="color: #<?=$about['spot_renk']?>;">
                            <?php
                            $content  = $about['spot'];
                            $eski   = "../i/";
                            $yeni   = "i/";
                            $content = str_replace($eski, $yeni, $content);
                            ?>
                            <?=$content?>
                        </div>
                    <?php }?>
                    <?php if($about['url'] == !null ) {?>
                        <div class="about-module-rightside-txt-button-area">
                            <a <?php if($about['yeni_sekme'] == '1' ) { ?>target="_blank"<?php }?> href="<?=$about['url']?>" class="<?=$about['button_renk']?> <?=$about['baslik_space']?> <?=$about['button_size']?>"><?=$about['button_yazi']?></a>
                        </div>
                    <?php }?>
                </div>
            <?php } ?>
        <?php }?>
    </div>
    <?php if($about['bg_tip'] == '0'  ) {?>
    <?php if($about['bg_dark'] == '1'  ) {?>
    <!-- Slider Karartma Var ise !-->
    <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
    <!-- Slider Karartma Var ise !-->
    <?php }?>
    <?php }?>
</div>

