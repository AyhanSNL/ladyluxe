<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($odemeayar['sepet_sistemi'] == '1' ) {?>
    <?php if($demo == '1'  ) {?>
        <?php
        $page_header_setting = $db->prepare("select * from page_header where page_id='ordersuccess' order by id");
        $page_header_setting->execute();
        $pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);

        $random = rand(0,(int) 9999999999999);
        $randomTutar = rand(0,(int) 12345);

        $orderMoneyType = $db->prepare("select * from para_birimleri where kod=:kod  ");
        $orderMoneyType->execute(array(
            'kod' => $current_kur
        ));
        $ordermoney = $orderMoneyType->fetch(PDO::FETCH_ASSOC);
        ?>
        <title><?=$diller['siparis-basarili-anabaslik']?> - <?php echo $ayar['site_baslik']?></title>
        <meta name="description" content="<?php echo"$ayar[site_desc]" ?>">
        <meta name="keywords" content="<?php echo"$ayar[site_tags]" ?>">
        <meta name="news_keywords" content="<?php echo"$ayar[site_tags]" ?>">
        <meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
        <meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
        <meta name="robots" content="index follow">
        <meta name="googlebot" content="index follow">
        <meta property="og:type" content="website" />
        <?php include "includes/config/header_libs.php";?>
        </head>
        <body>
        <?php include 'includes/template/pre-loader.php'?>
        <?php include 'includes/template/header.php'?>
        <?php include 'includes/template/helper/page-headers-stil.php';  ?>
        <style>
            .tooltip{
                font-size: 12px !important ;
            }
            .success-order-main-div{
                font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
            }
            .success-order-buttons-area a{
                font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
            }
        </style>
        <!-- CONTENT AREA ============== !-->
        <div class="success-order-main-div" style="background-color: #<?=$odemeayar['alisveris_arkaplan']?>;">
            <?php if($pagehead['durum'] == '1' ) {?>
                <div class="page-banner-main" >
                    <div class="page-banner-in-text">
                        <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                            <i class="fa fa-check"></i> <?=$diller['siparis-basarili-anabaslik']?>
                        </div>
                        <div class="page-banner-links ">
                            <a href="index.html"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                            <span>/</span>
                            <a><?=$diller['siparis-basarili-anabaslik']?></a>
                        </div>
                    </div>
                    <?php if($pagehead['bg_tip'] == '0'  ) {?>
                        <?php if($pagehead['bg_dark'] == '1'  ) { ?>
                            <!-- Karartma Var ise !-->
                            <div style="background: rgba(0,0,0,0.3); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                            <!-- Karartma Var ise !-->
                            <?php
                        }}
                    ?>
                </div>
            <?php }?>
            <div class="sucess-order-in-div">

                <div class="success-order-check-mark"></div>
                <div class="success-order-h">
                    <?=$diller['siparis-basarili-aciklama1']?>
                </div>
                <div class="success-order-h-2">
                    <?=$diller['siparis-basarili-aciklama2']?> <span id="orderNumber"><?=$random?></span>
                    <button onclick="copyToClipboard('orderNumber')" data-toggle="tooltip" data-placement="top" title="<?=$diller['siparis-basarili-aciklama3']?>">
                        <i class="fa fa-copy"></i>
                    </button>
                </div>
                <div class="success-order-h-3">
                    <?=$diller['siparis-basarili-aciklama-ornek']?>
                </div>
                <div class="success-order-h-4">
                <?=$diller['users-panel-text144']?> :
                    <?php if($ordermoney['simge_gosterim'] == '0' ) {?>
                        <?=$ordermoney['sol_simge']?>
                    <?php }?>
                    <?php if($ordermoney['simge_gosterim'] == '1' ) {?>
                        <?=$ordermoney['sag_simge']?>
                    <?php }?>
                    <?php echo number_format($randomTutar, $ordermoney['para_format']); ?>
                    <?php if($ordermoney['simge_gosterim'] == '2' ) {?>
                        <?=$ordermoney['sol_simge']?>
                    <?php }?>
                    <?php if($ordermoney['simge_gosterim'] == '3' ) {?>
                        <?=$ordermoney['sag_simge']?>
                    <?php }?>
                </div>
                <div class="success-order-buttons-area mb-4 mt-5">
                    <!-- Alışverişe Devam !-->
                    <a href="<?=$siteurl?>" class="button-blue button-2x" target="_blank" style="text-transform: uppercase;"><?=$diller['sepet-alisverise-devam']?></a>
                    <!--  Alışverişe Devam !-->

                    <!-- Sipariş Detayı !-->
                    <a href="javascript:Void(0)" class="button-grey button-2x"><?=$diller['siparis-basarili-button3']?></a>
                    <!-- Sipariş Detayı SON !-->
                </div>
            </div>
        </div>

        <!-- CONTENT AREA ============== !-->



        <?php include 'includes/template/footer.php'?>
        </body>
        </html>
        <?php include "includes/config/footer_libs.php";?>

        <?php
        unset($_SESSION['siparis_islem_id']);
        unset($_SESSION['kapida_odeme']);
        $ip = $_SERVER["REMOTE_ADDR"];
        $silmeislem = $db->prepare("DELETE from sepet WHERE ip=:ip");
        $silmeislem->execute(array(
            'ip' => $ip
        ));
        ?>
    <?php }else {
        header('Location:'.$siteurl.'sepet/');
    }
}else {
    header('Location:'.$ayar['site_url'].'404');
}
?>