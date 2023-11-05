<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$islemlerAyar = $db->prepare("select * from galeri_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);

$id = htmlspecialchars(trim($_GET['gal_id']));
if(strip_tags(htmlspecialchars($_GET['gal_id'])) != $_GET['gal_id']  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}
$icerikCek = $db->prepare("select * from galeri_kat where seo_url=:seo_url and dil=:dil and durum=:durum ");
$icerikCek->execute(array(
    'seo_url' => $id,
    'dil' => $_SESSION['dil'],
    'durum' => '1'
));
$icerik = $icerikCek->fetch(PDO::FETCH_ASSOC);

$galerifoto = $db->prepare("select * from galeri_resim where kat_id=:kat_id order by sira asc ");
$galerifoto->execute(array(
    'kat_id' => $icerik['id']
));

/* Seo Başlık */
if($icerik['seo_baslik'] == !null ) {
    $baslik = $icerik['seo_baslik'];
}else{
    $baslik = $icerik['baslik'];
}
/*  <========SON=========>>> Seo Başlık SON */
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='fotogaleri' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<?php if($icerikCek->rowCount() <= '0'  ) {?>
    <?php header('Location:'.$siteurl.''); ?>
<?php }else { ?>
    <title><?=$baslik?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="description" content="<?php echo"$islemayar[meta_desc]" ?>">
    <meta name="keywords" content="<?php echo"$islemayar[tags]" ?>">
    <meta name="news_keywords" content="<?php echo"$islemayar[tags]" ?>">
    <meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta property="og:type" content="website" />

    <?php include "includes/config/header_libs.php";?>
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/lightbox/lightbox.css" >

    </head>
    <body>
    <?php include 'includes/template/pre-loader.php'?>
    <?php include 'includes/template/header.php'?>
    <?php include 'includes/template/helper/page-headers-stil.php';  ?>
    <!-- CONTENT AREA ============== !-->
    <div class="fotogaleri_detay">
        <?php if($pagehead['durum'] == '1' ) {?>
            <div class="page-banner-main" >
                <div class="page-banner-in-text">
                    <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                        <?=$icerik['baslik']?>
                    </div>
                    <div class="page-banner-links ">
                        <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                        <span>/</span>
                        <a href="foto-galeri/"><?php echo $diller['altsayfa-foto-galeri-title']; ?></a>
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
        <div class="fotogaleri-container-main-in">
            <div class="masonry" id="portfolio">
                <?php foreach ($galerifoto as $foto) {?>
                    <div class="photo_gallery_mas_img">
                        <a href="images/gallery/<?=$foto['gorsel']?>">
                            <img src="images/gallery/<?=$foto['gorsel']?>" alt="<?=$icerik['baslik']?>">
                        </a>
                    </div>
                <?php }?>
            </div>
            <?php if($galerifoto->rowCount() <= '0'  ) {?>
                <div class="alert alert-secondary " style="width: 100%;  ">
                    <i class="fa fa-ban"></i> Bu Albüme fotoğraf eklenmemiş!
                </div>
            <?php }?>
        </div>

    </div>



    <!-- CONTENT AREA ============== !-->



    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
    <?php include "includes/config/footer_libs.php";?>
<?php }?>


<script src='assets/js/jquery.magnific-popup.min.js'></script>
<script src="assets/js/lightbox/lightbox.js"></script>