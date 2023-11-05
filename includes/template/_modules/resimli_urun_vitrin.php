<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($cacheRow['vitrin1'] == '1' ) {?>
    <?php
    $CacheIPKontrol = $db->prepare("select * from ziyaretciler where ipadres=:ipadres ");
    $CacheIPKontrol->execute(array(
        'ipadres' => $ipAdres
    ));
    if($CacheIPKontrol->rowCount()>'0'  ) {
        error_reporting(0);
        $vitrin1 = md5("vitrin1").md5($ipAdres).".html";
        $cache = "i/cache/d/".$vitrin1;
        $sure = $cacheRow['vitrin1_zaman'];
        if( time() - $sure < filemtime($cache) && isset($cache)){
            readfile($cache);

        } else {
            ob_start();
            ?>
            <?php
            $vitrin_tip1_Ayar = $db->prepare("select * from vitrin_tip1_ayar where id='1'");
            $vitrin_tip1_Ayar->execute();
            $tip1Ayar = $vitrin_tip1_Ayar->fetch(PDO::FETCH_ASSOC);
            $gruplimit = $tip1Ayar['urun_limit'];
            $vitrin_tip1_Grup = $db->prepare("select * from vitrin_tip1_grup where dil=:dil and durum=:durum order by sira asc ");
            $vitrin_tip1_Grup->execute(array(
                'dil' => $_SESSION['dil'],
                'durum' => '1'
            ));
            $urunKutuAyar = $db->prepare("select * from urun_kutu where id='1'");
            $urunKutuAyar->execute();
            $urunKutuRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="group-urun-module-main-div">
                <div class="group-urun-module-inside-area">

                    <div class="urun-kutulari-main">
                        <!-- Boxes !-->
                        <?php foreach ($vitrin_tip1_Grup as $vitrintip1) {
                            $Vitrin_tip1_Urunler = $db->prepare("select * from vitrin_tip1_urunler where grup_id=:grup_id order by sira asc limit $gruplimit ");
                            $Vitrin_tip1_Urunler->execute(array(
                                'grup_id' => $vitrintip1['id'],
                            ));
                            ?>
                            <div class="group-product-main-box">
                                <?php if($vitrintip1['gorsel'] == !null  ) {?>
                                    <a <?php if($vitrintip1['adres_url'] == !null  ) { ?>href="<?=$vitrintip1['adres_url']?>"<?php }else{?> href="javascript:Void(0)" <?php } ?> style="color: #<?=$vitrintip1['gorsel_baslik_renk']?>;">
                                        <div class="group-product-main-box-img " >
                                            <?php if($vitrintip1['gorsel_baslik'] == !null ) {?>
                                                <div class="group-product-main-box-img-line">
                                                    <div class="group-product-main-box-img-line-in">
                                                        <div class="group-product-main-box-img-line-in-txt">
                                                            <?=$vitrintip1['gorsel_baslik']?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <img src="images/uploads/<?=$vitrintip1['gorsel']?>" alt="<?=$vitrintip1['baslik']?>">
                                        </div>
                                    </a>
                                <?php }?>
                                <div class="group-product-main-box-container">
                                    <?php if($vitrintip1['baslik_durum'] == '1'  ) {?>
                                        <div class="group-product-main-box-container-header">
                                            <div class="group-product-main-box-container-header-left">
                                                <div>
                                                    <div class="group-product-main-box-container-header-left-h" style="color: #<?=$tip1Ayar['baslik_renk']?>;">
                                                        <?=$vitrintip1['baslik']?>
                                                    </div>
                                                    <div class="group-product-main-box-container-header-left-s" style="color: #<?=$tip1Ayar['spot_renk']?>;">
                                                        <?=$vitrintip1['spot']?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <div class="group-product-main-box-container-boxex">

                                        <!-- Ürün Kutu standart !-->
                                        <?php if($vitrintip1['tur'] == '0'  ) {?>
                                            <?=urunBoxKategoriliVitrin($Vitrin_tip1_Urunler)?>
                                        <?php }?>
                                        <!--  <========SON=========>>> Ürün Kutu standart SON !-->


                                        <!-- Ürün Kutu Slider !-->
                                        <?php if($vitrintip1['tur'] == '1'  ) {?>
                                            <div class="swiper-product-list" style="height: auto !important; padding-top: 20px; padding-bottom: 20px;">
                                                <div class="swiper-wrapper" >
                                                    <?=urunBoxKategoriliVitrin_slider($Vitrin_tip1_Urunler)?>
                                                </div>
                                                <div class="swiper-button-next"></div>
                                                <div class="swiper-button-prev"></div>
                                            </div>

                                        <?php }?>
                                        <!--  <========SON=========>>> Ürün Kutu Slider SON !-->
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <!--  <========SON=========>>> Boxes SON !-->


                    </div>

                </div>
            </div>
            <?php

            $ac = fopen($cache, "w+");
            fwrite($ac, ob_get_contents());
            fclose($ac);

            ob_end_flush();
        }
    }
    ?>
<?php }else {
    ?>
    <?php
    $vitrin_tip1_Ayar = $db->prepare("select * from vitrin_tip1_ayar where id='1'");
    $vitrin_tip1_Ayar->execute();
    $tip1Ayar = $vitrin_tip1_Ayar->fetch(PDO::FETCH_ASSOC);
    $gruplimit = $tip1Ayar['urun_limit'];
    $vitrin_tip1_Grup = $db->prepare("select * from vitrin_tip1_grup where dil=:dil and durum=:durum order by sira asc ");
    $vitrin_tip1_Grup->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1'
    ));
    $urunKutuAyar = $db->prepare("select * from urun_kutu where id='1'");
    $urunKutuAyar->execute();
    $urunKutuRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="group-urun-module-main-div">
        <div class="group-urun-module-inside-area">

            <div class="urun-kutulari-main">
                <!-- Boxes !-->
                <?php foreach ($vitrin_tip1_Grup as $vitrintip1) {
                    $Vitrin_tip1_Urunler = $db->prepare("select * from vitrin_tip1_urunler where grup_id=:grup_id order by sira asc limit $gruplimit ");
                    $Vitrin_tip1_Urunler->execute(array(
                        'grup_id' => $vitrintip1['id'],
                    ));
                    ?>
                    <div class="group-product-main-box">
                        <?php if($vitrintip1['gorsel'] == !null  ) {?>
                            <a <?php if($vitrintip1['adres_url'] == !null  ) { ?>href="<?=$vitrintip1['adres_url']?>"<?php }else{?> href="javascript:Void(0)" <?php } ?> style="color: #<?=$vitrintip1['gorsel_baslik_renk']?>;">
                                <div class="group-product-main-box-img " >
                                    <?php if($vitrintip1['gorsel_baslik'] == !null ) {?>
                                        <div class="group-product-main-box-img-line">
                                            <div class="group-product-main-box-img-line-in">
                                                <div class="group-product-main-box-img-line-in-txt">
                                                    <?=$vitrintip1['gorsel_baslik']?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <img src="images/uploads/<?=$vitrintip1['gorsel']?>" alt="<?=$vitrintip1['baslik']?>">
                                </div>
                            </a>
                        <?php }?>
                        <div class="group-product-main-box-container">
                            <?php if($vitrintip1['baslik_durum'] == '1'  ) {?>
                                <div class="group-product-main-box-container-header">
                                    <div class="group-product-main-box-container-header-left">
                                        <div class="group-product-main-box-container-header-left-h" style="color: #<?=$tip1Ayar['baslik_renk']?>;">
                                            <?=$vitrintip1['baslik']?>
                                        </div>
                                        <div class="group-product-main-box-container-header-left-s" style="color: #<?=$tip1Ayar['spot_renk']?>;">
                                            <?=$vitrintip1['spot']?>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="group-product-main-box-container-boxex">

                                <!-- Ürün Kutu standart !-->
                                <?php if($vitrintip1['tur'] == '0'  ) {?>
                                    <?=urunBoxKategoriliVitrin($Vitrin_tip1_Urunler)?>
                                <?php }?>
                                <!--  <========SON=========>>> Ürün Kutu standart SON !-->


                                <!-- Ürün Kutu Slider !-->
                                <?php if($vitrintip1['tur'] == '1'  ) {?>
                                    <div class="swiper-product-list" style="height: auto !important; padding-top: 20px; padding-bottom: 20px;">
                                        <div class="swiper-wrapper" >
                                            <?=urunBoxKategoriliVitrin_slider($Vitrin_tip1_Urunler)?>
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                <?php }?>
                                <!--  <========SON=========>>> Ürün Kutu Slider SON !-->
                            </div>
                        </div>
                    </div>
                <?php }?>
                <!--  <========SON=========>>> Boxes SON !-->


            </div>

        </div>
    </div>
<?php }?>


