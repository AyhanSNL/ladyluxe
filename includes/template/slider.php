<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$sliderayar = $db->prepare("select * from slider_ayar where id='1'");
$sliderayar ->execute();
$slidayar = $sliderayar->fetch(PDO::FETCH_ASSOC);
?>
<?php
$slider = $db->prepare("select * from slider where dil='$_SESSION[dil]' and durum='1' order by sira asc");
$slider->execute();

?>
<?php
if($slider->rowCount() > 0) { ?>
    <div class="swiper-container">
        <div class="swiper-wrapper">


            <?php foreach ($slider as $row) { ?>

                <div class="swiper-slide" style="background-image:url(images/slider/<?php echo $row['gorsel']; ?>);  background-size: cover !important; background-position:top center; ">


                    <?php if($row['text_status'] == '1') {?>
                        <div class="slider_text_inside_main" style="justify-content: <?=$row['area']?>">
                            <div class="slider_text_inside_box" style="<?php if($row['area'] == 'center'  ) { ?>text-align: center;<?php } else{?>text-align: left;<?php }?>" >
                                <?php if($row['baslik'] == !null  ) {?>
                                    <div class="slider-section slider_text_inside_box_h" style="
                                            font-size: <?=$slidayar['baslik_size']?>px ;
                                            color: #<?=$row['text_bg']?>;
                                            font-family : '<?=$slidayar['baslik_font']?>', sans-serif ;
                                            line-height: <?=$slidayar['baslik_size']?>px;
                                            font-weight: <?=$slidayar['baslik_weight']?>;
                                            " data-aos="<?php echo $row['baslik_animation'] ?>" data-aos-offset="200" data-aos-delay="50"   data-aos-duration="1000">
                                        <?=$row['baslik']?>
                                    </div>
                                <?php }?>
                                <?php if($row['spot'] == !null  ) {?>
                                <div class="slider-section slider_text_inside_box_s" style="
                                    font-size: <?=$slidayar['spot_size']?>px ;
                                    color: #<?=$row['text_bg']?>;
                                    font-family : '<?=$slidayar['spot_font']?>', sans-serif ;
                                    line-height: <?=$slidayar['spot_size']+5?>px;
                                    font-weight: <?=$slidayar['spot_weight']?>;
                                    " data-aos="<?php echo $row['spot_animation'] ?>" data-aos-offset="200" data-aos-delay="50"   data-aos-duration="1500">
                                   <?=$row['spot']?>
                                </div>
                                <?php }?>
                                <?php if($row['url'] == !null ) {?>
                                    <div class="slider_text_inside_box_button" >
                                        <a href="<?=$row['url']?>"
                                           style="
                                                font-size: <?=$row['button_size']?>px ;
                                                  border-radius: <?=$row['button_radius']?>;
                                                "
                                           target="_blank" class="slider-section <?=$row['button_bg']?> <?=$row['button_size']?>" data-aos="<?php echo $row['button_animation'] ?>" data-aos-offset="200" data-aos-delay="50"   data-aos-duration="1500">
                                            <?=$row['button_text']?>
                                        </a>
                                    </div>
                                <?php }?>
                    

                            </div>
                        </div>
                    <?php }?>

                    <?php if($row['text_status'] == '0') {?>
                        <?php if($row['url'] == !null ) {?>
                            <div style="width: 100%; height: 100%; display: flex; justify-content: center;align-items: flex-end; padding-bottom: 60px;  ">
                                <div class="slider_text_inside_box_button"  style="text-align: center;">
                                    <a href="<?=$row['url']?>"
                                       style="
                                               font-size: <?=$row['button_size']?>px ;
                                               border-radius: <?=$row['button_radius']?>;
                                               "
                                       target="_blank" class="<?=$row['button_bg']?> button-2x" >
                                        <?=$row['button_text']?>
                                    </a>
                                </div>
                            </div>

                        <?php }?>
                    <?php } ?>


                    <?php
                    if($row['dark_bg']==1)
                    {
                        ?>
                        <!-- Slider Karartma Var ise !-->
                        <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute"></div>
                        <!-- Slider Karartma Var ise !-->
                    <?php } ?>


                </div>
            <?php } ?>



        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <div class="swiper-pagination"></div>
    </div>
<?php } else { ?>


<?php } ?>

