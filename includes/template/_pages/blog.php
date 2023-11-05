<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php


if(isset($_GET['value'] ) && $_GET['value'] == 'etiketler' ) {
    $Filtre ="and tags LIKE '%$_GET[content]%'";
    if(strip_tags(htmlspecialchars($_GET['content'])) != $_GET['content']  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }
}
if(isset($_GET['value'] ) && $_GET['value'] == 'kategori' ) {
    if(strip_tags(htmlspecialchars($_GET['content'])) != $_GET['content']  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }
    $getS = htmlspecialchars($_GET['content']);
    $Filtre ="and kat='$getS'";
}
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from blog where durum='1' and dil='$_SESSION[dil]' $Filtre ");
$ToplamVeri = $Say->rowCount();
$Limit = 12;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from blog where durum='1' and dil='$_SESSION[dil]' $Filtre order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

$islemlerAyar = $db->prepare("select * from blog_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='blog' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<title><?php echo $diller['altsayfa-bloglar-title']; ?> - <?php echo $ayar['site_baslik']?></title>
<?php
if(isset($_GET['value'] ) && $_GET['value'] == 'kategori' ) {
    $blogKatSql = $db->prepare("select meta_desc,tags from blog_kat where seo_url=:seo_url  ");
    $blogKatSql->execute(array(
            'seo_url' => $getS,
    ));
    $katRowMeta = $blogKatSql->fetch(PDO::FETCH_ASSOC);
?>
<meta name="description" content="<?php echo"$katRowMeta[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$katRowMeta[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$katRowMeta[tags]" ?>">
<?php }else { ?>
<meta name="description" content="<?php echo"$islemayar[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$islemayar[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$islemayar[tags]" ?>">
<?php }?>
<meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta name="robots" content="index follow">
<meta name="googlebot" content="index follow">
<meta property="og:type" content="website" />

<?php include "includes/config/header_libs.php";?>
<link rel='stylesheet' href='assets/css/slider/swiper.min.css'>
<link rel='stylesheet' href='assets/css/slider/aos.css'>
</head>
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>


<!-- Page Header ====================== !-->
<?php include 'includes/template/helper/page-headers-stil.php'; ?>


<!-- CONTENT AREA ============== !-->
<div id="MainDiv" style="background-color: #<?=$islemayar['detay_bg_color']?>; width: 100%; font-family : '<?=$islemayar['baslik_font']?>',Sans-serif ;  ">
    <?php if ($pagehead['durum'] == '1') { ?>
        <div class="page-banner-main">
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?php echo $diller['altsayfa-bloglar-title']; ?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a>
                        <?php echo $diller['altsayfa-bloglar-title']; ?>
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
    <?php if($islemayar['list_kategoriler'] == '1' ) {?>
        <div class="blog-list-tags-div">
            <?php
            $blogKatSorgu = $db->prepare("select seo_url,baslik from blog_kat where dil=:dil and durum=:durum order by sira asc");
            $blogKatSorgu->execute(array(
                'dil' => $_SESSION['dil'],
                'durum' => '1',
            ));
            ?>
            <?php if($blogKatSorgu->rowCount()>'0') {?>
                <div class="swiper-blogtags">
                    <div class="swiper-wrapper">
                        <?php foreach ($blogKatSorgu as $blogKat) {?>
                            <div class="swiper-slide" style="width: auto">
                                <a class="bloglar-detay-left-content-div-tags-box-big" href="<?=$siteurl?>bloglar/kategori/<?=$blogKat['seo_url']?>/">
                                    <?=$blogKat['baslik']?>
                                </a>
                            </div>
                        <?php }?>
                    </div>
                </div>
            <?php } ?>
           <?php if(isset($_GET['value'])) {?>
               <?php if($_GET['value'] == 'etiketler' || $_GET['value'] == 'kategori' ) {?>
                   <div class="blog-list-value-div">
                       <a class="button-black button-2x" href="<?=$siteurl?>bloglar/"><?=$diller['bloglar-geri-don']?></a>
                       <?php if($_GET['value'] == 'etiketler'  ) {?>
                           <div class="blog-list-value-div-h">
                               <?=$diller['bloglar-aranan-etiket']?> : <?=$_GET['content']?>
                           </div>
                       <?php }?>
                       <?php if($_GET['value'] == 'kategori'  ) {?>
                           <div class="blog-list-value-div-h">
                               <?php
                               $kategoriCek = $db->prepare("select * from blog_kat where durum=:durum and seo_url=:seo_url ");
                               $kategoriCek->execute(array(
                                   'durum' => '1',
                                   'seo_url' => $_GET['content']
                               ));
                               $katrow = $kategoriCek->fetch(PDO::FETCH_ASSOC);
                               ?>
                               <?php if($kategoriCek->rowCount()>'0'  ) {?>
                                   <?=$diller['bloglar-kategoridetay']?> : <?=$katrow['baslik']?>
                               <?php }?>
                           </div>
                       <?php }?>
                   </div>
               <?php }?>
           <?php }?>
        </div>
    <?php }?>

<div class="bloglar-container-main" >

    <?php foreach ($islemCek as $blog) {?>
        <div class="blog-box">
            <?php if($blog['gorsel'] ==!null ) {?>
                <div class="blog-box-img">
                    <a href="blog/<?=$blog['seo_url']?>/" style="color: #<?=$islemayar['kutu_baslik_renk']?>;">
                        <div class="blog-box-overlay">
                            <i class="fa fa-unlink"></i>
                        </div>
                        <img src="images/blog/<?=$blog['gorsel']?>" alt="<?=$blog['baslik']?>">
                    </a>
                </div>
            <?php }?>
            <div class="blog-box-text-area" style="background-color: #<?=$islemayar['kutu_bg']?>;">
                <div class="blog-box-date lspacsmall" style="color: #<?=$islemayar['kutu_tarih_renk']?>;">
                    <?php echo date_tr('j F Y', ''.$blog['tarih'].''); ?>
                </div>
                <div class="blog-box-h">
                    <a href="blog/<?=$blog['seo_url']?>/" style="color: #<?=$islemayar['kutu_baslik_renk']?>;">
                        <?=$blog['baslik']?>
                    </a>
                </div>
                <?php if($blog['spot'] == !null ) {?>
                    <div class="blog-box-s" style="color: #<?=$islemayar['kutu_spot_renk']?>;">
                        <?=$blog['spot']?>
                    </div>
                <?php }else { ?>
                    <div style="width: 100%; height: 15px;    "></div>
                <?php }?>
                <div class="blog-box-button lspacsmall">
                    <a href="blog/<?=$blog['seo_url']?>/" class="right-underline" style="color: #<?=$islemayar['kutu_more_renk']?>;">
                        <i class="fa fa-arrow-right"></i> <?=$diller['anasayfa-bloglar-devam-yazisi']?>
                    </a>
                </div>
            </div>

        </div>
    <?php }?>
    <!---- Sayfalama Elementleri ================== !-->
    <?php if($ToplamVeri > $Limit  ) {?>
        <div id="SayfalamaElementi" style="width: 100%;  ">
            <?php if($Sayfa >= 1){?>
            <nav aria-label="Page navigation example" style="margin-top: 50px;">
                <ul class="pagination justify-content-center">
                    <?php } ?>

                    <?php if($Sayfa > 1){?>

                        <li class="page-item"><a class="page-link" href="bloglar/<?php if(isset($_GET['value']) && $_GET['value'] == 'etiketler') { ?>etiketler/<?=$_GET['content']?>/<?php }?><?php if(isset($_GET['value']) && $_GET['value'] == 'kategori') { ?>kategori/<?=$_GET['content']?>/<?php }?>"><?=$diller['sayfalama-ilk']?></a></li>
                        <li class="page-item"><a class="page-link" href="bloglar/<?php if(isset($_GET['value']) && $_GET['value'] == 'etiketler') { ?>etiketler/<?=$_GET['content']?>/<?php }?><?php if(isset($_GET['value']) && $_GET['value'] == 'kategori') { ?>kategori/<?=$_GET['content']?>/<?php }?><?=$Sayfa - 1?>/"><?=$diller['sayfalama-onceki']?></a></li>

                    <?php } ?>
                    <?php
                    for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                        if($i == $Sayfa){
                         ?>
    
                            <li class="page-item active" aria-current="page">
                              <a class="page-link" href="bloglar/<?php if(isset($_GET['value']) && $_GET['value'] == 'etiketler') { ?>etiketler/<?=$_GET['content']?>/<?php }?><?php if(isset($_GET['value']) && $_GET['value'] == 'kategori') { ?>kategori/<?=$_GET['content']?>/<?php }?><?=$i?>/"><?=$i?><span class="sr-only">(current)</span></a>
                            </li>

                           <?php
                        }else{
                            ?>
                    <li class="page-item"><a class="page-link" href="bloglar/<?php if(isset($_GET['value']) && $_GET['value'] == 'etiketler') { ?>etiketler/<?=$_GET['content']?>/<?php }?><?php if(isset($_GET['value']) && $_GET['value'] == 'kategori') { ?>kategori/<?=$_GET['content']?>/<?php }?><?=$i?>/"><?=$i?></a></li>
                        <?php
                        }
                    }
                    }
                    ?>

                    <?php if($islemListele->rowCount() <=0) { } else { ?>
                        <?php if($Sayfa != $Sayfa_Sayisi){?>

                            <li class="page-item"><a class="page-link" href="bloglar/<?php if(isset($_GET['value']) && $_GET['value'] == 'etiketler') { ?>etiketler/<?=$_GET['content']?>/<?php }?><?php if(isset($_GET['value']) && $_GET['value'] == 'kategori') { ?>kategori/<?=$_GET['content']?>/<?php }?><?=$Sayfa + 1?>/"><?=$diller['sayfalama-sonraki']?></a></li>
                            <li class="page-item"><a class="page-link" href="bloglar/<?php if(isset($_GET['value']) && $_GET['value'] == 'etiketler') { ?>etiketler/<?=$_GET['content']?>/<?php }?><?php if(isset($_GET['value']) && $_GET['value'] == 'kategori') { ?>kategori/<?=$_GET['content']?>/<?php }?><?=$Sayfa_Sayisi?>/"><?=$diller['sayfalama-son']?></a></li>


                        <?php }} ?>

                    <?php if($Sayfa >= 1){?>
                </ul>
            </nav>
        <?php } ?>
        </div>
    <?php }?>
    <!---- Sayfalama Elementleri ================== !-->
    <?php if($ToplamVeri<='0'  ) {?>
        <div class="alert alert-secondary " style="width: 100%;  ">
            <i class="fa fa-ban"></i> <?=$diller['bloglar-bulunamadi']?>
        </div>
    <?php }?>
</div>
</div>

<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.5/swiper-bundle.min.js'></script>
<script src='assets/js/slider/aos.js'></script>
<?php include "includes/config/footer_libs.php";?>
<script>
    var swiper = new Swiper('.swiper-blogtags', {
        slidesPerView: 'auto',
        centeredSlides: true,
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>