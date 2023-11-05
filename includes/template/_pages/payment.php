<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;
unset($_SESSION['form_temp']);
?>
<?php if($odemeayar['sepet_sistemi'] == '1' ) {?>
<?php if(isset($_SESSION['siparis_islem_id'])) {

    if($odemeayar['pos_tur'] == 'shopier' ) {
        $SiparisiAl = $db->prepare("select * from siparisler where siparis_no=:siparis_no and onay=:onay");
        $SiparisiAl->execute(array(
            'siparis_no' => $_SESSION['siparis_islem_id'],
            'onay' => '0'
        ));
        $siparisim = $SiparisiAl->fetch(PDO::FETCH_ASSOC);
        include_once 'includes/template/vpos/shopier/shopier_1.php';
        exit();
    }
    ?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='payment' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);

include 'includes/func/cartcalc.php';

?>
    <title><?=$diller['kart-odeme-text-1']?> - <?php echo $ayar['site_baslik']?></title>
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
        .ccard-payment-page-main{
            font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
        }
    </style>
    <!-- CONTENT AREA ============== !-->
    <div id="MainDiv" style="background-color: #<?=$odemeayar['alisveris_arkaplan']?>; width: 100%;  overflow: hidden  ">
    <?php if($pagehead['durum'] == '1' ) {?>
            <div class="page-banner-main" >
                <div class="page-banner-in-text">
                    <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                        <?=$diller['kart-odeme-text-1']?>
                    </div>
                    <div class="page-banner-links ">
                        <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                        <span>/</span>
                        <a><?=$diller['kart-odeme-text-1']?></a>
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
    <div class="ccard-payment-page-main">
      <?php if($odemeayar['pos_tur'] == 'paytr' ) {?>
          <?php if($odemeayar['paytr_tasarim'] == '1' ) {?>
              <?php include 'includes/template/_pages/payment_paytr_1.php'; ?>
          <?php }?>
          <?php if($odemeayar['paytr_tasarim'] == '2' ) {?>
              <?php include 'includes/template/_pages/payment_paytr_2.php'; ?>
          <?php }?>
      <?php }?>
      <?php if($odemeayar['pos_tur'] == 'iyzico' ) {?>
            <?php include 'includes/template/_pages/payment_iyzico.php'; ?>
      <?php }?>
      <?php if($odemeayar['pos_tur'] == 'shoplemo' ) {?>
          <?php include 'includes/template/_pages/payment_shoplemo.php'; ?>
      <?php }?>
    </div>
    </div>
    <!-- CONTENT AREA ============== !-->
    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
    <?php include "includes/config/footer_libs.php";?>

    <?php }else { ?>
        <?php
       header('Location:'.$siteurl.'sepet/');
        ?>
    <?php }?>
<?php }else { ?>
<?php
header('Location:'.$siteurl.'404');
?>
<?php }?>