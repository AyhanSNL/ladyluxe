<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($odemeayar['sepet_sistemi'] == '1' ) {?>
<?php if($_GET['sID'] == $_SESSION['siparis_islem_id'] && isset($_GET['sID']) && isset($_SESSION['siparis_islem_id'])) {?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='ordersuccess' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
include 'includes/func/cartcalc.php';


$orderToMe = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
$orderToMe->execute(array(
    'siparis_no' => $_GET['sID']
));
$sip = $orderToMe->fetch(PDO::FETCH_ASSOC);

$orderMoneyType = $db->prepare("select * from para_birimleri where kod=:kod  ");
$orderMoneyType->execute(array(
    'kod' => $sip['parabirimi']
));
$ordermoney = $orderMoneyType->fetch(PDO::FETCH_ASSOC);
        if($orderToMe->rowCount()<= '0'  ) {
            header('Location:'.$siteurl.'404');
        }
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
             <?=$diller['siparis-basarili-aciklama2']?> <span id="orderNumber"><?=$sip['siparis_no']?></span>
              <button onclick="copyToClipboard('orderNumber')" data-toggle="tooltip" data-placement="top" title="<?=$diller['siparis-basarili-aciklama3']?>">
                  <i class="fa fa-copy"></i>
              </button>
          </div>
          <div class="success-order-h-3">
              <?=$diller['siparis-basarili-aciklama4']?>
          </div>
          <div class="success-order-h-4">
              <?=$diller['siparis-basarili-aciklama5']?>
              <?php if($ordermoney['simge_gosterim'] == '0' ) {?>
                  <?=$ordermoney['sol_simge']?>
              <?php }?>
              <?php if($ordermoney['simge_gosterim'] == '1' ) {?>
                  <?=$ordermoney['sag_simge']?>
              <?php }?>
              <?php echo number_format($sip['havale_toplamtutar'], $ordermoney['para_format']); ?>
              <?php if($ordermoney['simge_gosterim'] == '2' ) {?>
                  <?=$ordermoney['sol_simge']?>
              <?php }?>
              <?php if($ordermoney['simge_gosterim'] == '3' ) {?>
                  <?=$ordermoney['sag_simge']?>
              <?php }?>
          </div>
          <div class="success-order-buttons-area">


              <?php if($odemeayar['havale_siparis_banka_button'] == '1' ) {?>
                  <!-- Hesap Numaraları !-->
                  <a href="hesap-numaralarimiz/" class="button-blue button-2x" target="_blank"><?=$diller['siparis-basarili-button1']?></a>
                  <!-- Hesap Numaraları SON !-->
              <?php }?>

              <?php if($sip['banka_bildirim_durum'] == '0'  ) {?>
                  <!-- Ödeme Bildirimi !-->
                  <a href="odeme-bildirimi/?sID=<?=$sip['siparis_no']?>" class="button-green button-2x" target="_blank"><?=$diller['siparis-basarili-button2']?></a>
                  <!-- Ödeme Bildirimi SON !-->
              <?php }?>
              
              <!-- Sipariş Detayı !-->
              <a href="siparis-takip/?sID=<?=$sip['siparis_no']?>&email=<?=$sip['eposta']?>" class="button-grey button-2x" target="_blank"><?=$diller['siparis-basarili-button3']?></a>
              <!-- Sipariş Detayı SON !-->
          </div>

          <div class="sucess-order-bottom-div">
              <i class="fa fa-exclamation-triangle"></i>  <?=$diller['siparis-basarili-aciklama6']?>
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
        $ip = $_SERVER["REMOTE_ADDR"];
    $silmeislem = $db->prepare("DELETE from sepet WHERE ip=:ip");
    $silmeislem->execute(array(
       'ip' => $ip
    ));
    ?>
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