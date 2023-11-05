<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php

$islemlerAyar = $db->prepare("select * from bildirimler_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);

$idCek = trim(strip_tags(htmlspecialchars($_GET['bid'])));
if(strip_tags(htmlspecialchars($_GET['bid'])) != $_GET['bid']  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}
$bildirimDetay = $db->prepare("select * from bildirimler where bildirim_id=:bildirim_id and durum=:durum and dil=:dil ");
$bildirimDetay->execute(array(
    'bildirim_id' => $idCek,
    'durum' => '1',
    'dil' => $_SESSION['dil'],
));
if($bildirimDetay->rowCount()>'0'  ) {
 $bilRow = $bildirimDetay->fetch(PDO::FETCH_ASSOC);
}else{
    header('Location:'.$ayar['site_url'].'404');
}

if($bilRow['tur'] == '1' || $bilRow['tur'] == '2' ) {
 if($userSorgusu->rowCount()<='0'  ) {
     header('Location:'.$ayar['site_url'].'404');
 }
}
if($bilRow['tur'] == '2'  ) {
 if($bilRow['uye_id'] != $userCek['id'] ) {
     header('Location:'.$ayar['site_url'].'404');
 }
}

if($islemayar['durum'] == '0'  ) {
    header('Location:'.$ayar['site_url'].'404');
}

if($islemayar['tur'] == '1' && $userSorgusu->rowCount()<='0' ) {
 header('Location:'.$ayar['site_url'].'404');
}


/* Okundu Olayı */
if($bilRow['tur'] == '0' ) {
    $ip = $_SERVER["REMOTE_ADDR"];
    $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and ip_adres=:ip_adres ");
    $bildirim_ipSorgu->execute(array(
        'bildirim_id' => $bilRow['bildirim_id'],
        'ip_adres' => $ip
    ));
    if($bildirim_ipSorgu->rowCount()<='0'  ) {
        $kaydet = $db->prepare("INSERT INTO bildirimler_ip SET
      bildirim_id=:bildirim_id,   
      ip_adres=:ip_adres
 ");
        $sonuc = $kaydet->execute(array(
            'bildirim_id' => $bilRow['bildirim_id'],
            'ip_adres' => $ip
        ));
    }
}
if($bilRow['tur'] == '1' ) {
    $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and uye_id=:uye_id ");
    $bildirim_ipSorgu->execute(array(
        'bildirim_id' => $bilRow['bildirim_id'],
        'uye_id' => $userCek['id']
    ));
    if($bildirim_ipSorgu->rowCount()<='0'  ) {
        $kaydet = $db->prepare("INSERT INTO bildirimler_ip SET
      bildirim_id=:bildirim_id,   
      uye_id=:uye_id
 ");
        $sonuc = $kaydet->execute(array(
            'bildirim_id' => $bilRow['bildirim_id'],
            'uye_id' => $userCek['id']
        ));
    }
}
if($bilRow['tur'] == '2' ) {
    $bildirim_ipSorgu = $db->prepare("select * from bildirimler_ip where bildirim_id=:bildirim_id and uye_id=:uye_id ");
    $bildirim_ipSorgu->execute(array(
        'bildirim_id' => $bilRow['bildirim_id'],
        'uye_id' => $userCek['id']
    ));
    if($bildirim_ipSorgu->rowCount()<='0'  ) {
        $kaydet = $db->prepare("INSERT INTO bildirimler_ip SET
      bildirim_id=:bildirim_id,   
      uye_id=:uye_id
 ");
        $sonuc = $kaydet->execute(array(
            'bildirim_id' => $bilRow['bildirim_id'],
            'uye_id' => $userCek['id']
        ));
    }
}
/*  <========SON=========>>> Okundu Olayı SON */

?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='bildirim' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<title><?php echo $diller['bildirimler-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$islemayar[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$islemayar[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$islemayar[tags]" ?>">
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


<!-- Page Header ====================== !-->
<?php include 'includes/template/helper/page-headers-stil.php'; ?>


<!-- CONTENT AREA ============== !-->
<div id="MainDiv" style="background-color: #<?=$islemayar['detay_bg']?>; width: 100%; font-family : '<?=$islemayar['font_select']?>',Sans-serif ;    overflow: hidden;
    ">
    <?php if ($pagehead['durum'] == '1') { ?>
        <div class="page-banner-main">
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?php echo $diller['bildirimler-text1']; ?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a href="bildirimler/">
                        <?php echo $diller['bildirimler-text1']; ?>
                    </a>
                </div>
            </div>
            <?php if ($pagehead['bg_tip'] == '0') { ?>
                <?php if ($pagehead['bg_dark'] == '1') { ?>
                    <!-- Karartma Var ise !-->
                    <div style="background: rgba(0,0,0,0.3); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                    <!-- Karartma Var ise !-->
                    <?php
                }
            }
            ?>
        </div>
    <?php } ?>

<div class="bildirimler-container-main" >
        <div class="bildirim-detay-main">
            <a href="bildirimler/" class="button-white-black button-2x" style="border: 1px solid #EBEBEB;">
                <i class="las la-bell"></i> <?=$diller['bildirimler-text14']?>
            </a>
            <div class="bildirim-detay-content">
                <div class="bildirim-detay-content-h">
                   <?php if($bilRow['ikon'] == !null ) { ?><?=$bilRow['ikon']?><?php }?> <?=$bilRow['baslik']?>
                </div>
                <div class="bildirim-detay-content-tarih" >
                  <i class="fa fa-clock-o"></i>  <?php echo date_tr('j F Y, H:i', ''.$bilRow['tarih'].''); ?>
                </div>
                <div class="bildirim-detay-content-s">
                    <?php
                    $icerikgoster  = $bilRow['icerik'];
                    $eski   = "../";
                    $yeni   = "";
                    $icerikgoster = str_replace($eski, $yeni, $icerikgoster);
                    ?>
                    <?=$icerikgoster?>
                </div>
            </div>
        </div>
</div>
</div>

<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

<s


