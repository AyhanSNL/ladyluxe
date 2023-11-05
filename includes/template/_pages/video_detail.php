<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php

$id = htmlspecialchars(trim($_GET['vid_id']));
if(strip_tags(htmlspecialchars($_GET['vid_id'])) != $_GET['vid_id']  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}
$icerikCek = $db->prepare("select * from video where seo_url=:seo_url and dil=:dil and durum=:durum ");
$icerikCek->execute(array(
    'seo_url' => $id,
    'dil' => $_SESSION['dil'],
    'durum' => '1'
));
$icerik = $icerikCek->fetch(PDO::FETCH_ASSOC);
$islemAyarcek = $db->prepare("select * from video_ayar where id='1' ");
$islemAyarcek->execute();
$islemayar = $islemAyarcek->fetch(PDO::FETCH_ASSOC);

$videoHits = $db->prepare("UPDATE video SET hit = hit+1 WHERE seo_url='$id'  ");
$videoHits->execute();

/* Seo Başlık */
if($icerik['seo_baslik'] == !null ) {
    $baslik = $icerik['seo_baslik'];
}else{
    $baslik = $icerik['baslik'];
}
/*  <========SON=========>>> Seo Başlık SON */
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='video' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<?php if($icerikCek->rowCount() <= '0'  ) {?>
    <?php header('Location:'.$siteurl.'');
    exit();

    ?>
<?php }else { ?>
    <title><?=$baslik?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="description" content="<?php echo"$icerik[meta_desc]" ?>">
    <meta name="keywords" content="<?php echo"$icerik[tags]" ?>">
    <meta name="news_keywords" content="<?php echo"$icerik[tags]" ?>">
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
    <!-- CONTENT AREA ============== !-->

    <div id="MainDiv" style="width: 100%;  overflow: hidden; background-color: #<?=$islemayar['arkaplan']?>; font-family : '<?=$islemayar['font_secim']?>',Sans-serif ; ">
        <?php if($pagehead['durum'] == '1' ) {?>
            <div class="page-banner-main" >
                <div class="page-banner-in-text">
                    <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                        <?=$icerik['baslik']?>
                    </div>
                    <div class="page-banner-links ">
                        <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                        <span>/</span>
                        <a href="video-galeri/"><?php echo ucwords_tr($diller['video-galeri-baslik']); ?></a>
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
        <?php } ?>
        <div class="videolar-container-flex">
            <?php if($islemayar['nav'] == '1' ) {?>
                <?php include 'includes/template/helper/pages_nav/navigation.php'; ?>
            <?php }?>
            <div class="video-detail-container-main">
                <div class="video-detail-container-main-h">
                    <?=$icerik['baslik']?>
                    <?php if($islemayar['izlenme'] == '1' ) {?>
                        <div style="font-size: 12px ; font-weight: 500; margin-bottom: 5px;">
                           <i class="ion-eye"></i> <?=$icerik['hit']?> <?=$diller['video-galeri-izlenme']?>
                        </div>
                    <?php }?>
                </div>
                <div class="video-detail-container-main-iframe">
                    <iframe src="https://www.youtube.com/embed/<?=$icerik['embed']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="video-detail-container-main-accordion">
                    <label for="tm" class="accordionitem"><?=$diller['video-aciklamasi']?> <i class="fa fa-angle-down"></i></label>
                    <input type="checkbox" id="tm" <?php if($islemayar['spot_akordion'] == '0' ) { ?>checked<?php }?> />
                    <div class="hiddentext" >
                        <?php
                        $kaynak  = $icerik['spot'];
                        $eski   = '../';
                        $yeni   = '';
                        $kaynak = str_replace($eski, $yeni, $kaynak);
                        ?>
                        <?=$kaynak?>
                        <?php
                        if($icerik['tags'] == !null){
                            $etiketler = $icerik['tags'];
                            $etiketler = explode(',', $etiketler);
                            ?>
                            <br>
                                <?php foreach( $etiketler as $anahtar => $deger ){ ?>
                                   <a class="video-detail-container-main-tag" style="color: #000;" href="<?=$siteurl?>video-galeri/?etiket=<?=urlencode($deger)?>"><?=$deger?></a>
                                <?php } ?>
                        <?php } ?>
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
<?php }?>


