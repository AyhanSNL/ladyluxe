<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$seo_url = trim(strip_tags(htmlspecialchars($_GET['id'])));
if(strip_tags(htmlspecialchars($_GET['id'])) != $_GET['id']  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}
$htmlsayfa = $db->prepare("select * from htmlsayfa where seo_url=:seo_url and dil=:dil and durum=:durum order by id ");
$htmlsayfa->execute(array(
        'seo_url' => $seo_url,
    'dil' => $_SESSION['dil'],
    'durum' => '1'
));
$sayfa = $htmlsayfa->fetch(PDO::FETCH_ASSOC);

/* Seo Başlık */
if($sayfa['seo_baslik'] == !null ) {
    $baslik = $sayfa['seo_baslik'];
}else{
    $baslik = $sayfa['baslik'];
}
/*  <========SON=========>>> Seo Başlık SON */
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='htmlsayfa' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<?php if ($sayfa['seo_url'] == $_GET['id'] ) { ?>
<title><?php echo $baslik?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$sayfa[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$sayfa[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$sayfa[tags]" ?>">
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


<div id="MainDiv" style="background-color: #<?=$sayfa['arkaplan']?>; width: 100%;  overflow: hidden  ">

    <?php if($pagehead['durum'] == '1' ) {?>
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?=$sayfa['baslik']?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a><?=$sayfa['baslik']?></a>
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


<div class="htmlpage-container-main">

        <?php if($sayfa['nav_durum'] == '1' ) {?>
            <?php include 'includes/template/helper/pages_nav/navigation.php'; ?>
        <?php }?>

        <div class="htmlpage-content-div"  style="font-family : '<?=$sayfa['sayfa_font']?>',Sans-serif ; <?php if($sayfa['nav_durum'] == '0'  ) { ?>padding:0; border:0;<?php }?>">
            <?php
            $content  = $sayfa['icerik'];
            $eski   = "../i/";
            $yeni   = "i/";
            $content = str_replace($eski, $yeni, $content);
            ?>
            <?=$content?>
        </div>


</div>
</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
    </html>
<?php include "includes/config/footer_libs.php";?>
<?php  } else { ?>
<script type='text/javascript'> document.location = '<?=$ayar['site_url']?>'; </script>
<?php }  ?>
