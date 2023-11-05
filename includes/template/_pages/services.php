<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from hizmet where durum='1' and dil='$_SESSION[dil]' ");
$ToplamVeri = $Say->rowCount();
$Limit = 12;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from hizmet where durum='1' and dil='$_SESSION[dil]' order by sira ASC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

$islemlerAyar = $db->prepare("select * from hizmet_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='hizmet' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<title><?php echo $diller['altsayfa-hizmetler-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
<?php include 'includes/template/helper/page-headers-stil.php'; ?>


<!-- CONTENT AREA ============== !-->

<div class="hizmetler_sayfasi" style="background-color: #<?=$islemayar['detay_bg']?>;  font-family : '<?=$islemayar['baslik_font']?>',sans-serif ; ">
    <?php if ($pagehead['durum'] == '1') { ?>
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?php echo$diller['altsayfa-hizmetler-title']; ?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a>
                        <?php echo $diller['altsayfa-hizmetler-title']; ?>
                    </a>
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
<div class="hizmetler-container-main">
        <?php foreach ($islemCek as $hizmet) {?>
            <div class="hizmetler-box <?=$islemayar['kutu_space']?>"  >
                <div class="hizmetler-box-img">
                    <a href="hizmet/<?=$hizmet['seo_url']?>/">
                        <div class="hizmetler-box-line">

                        </div>
                        <img src="images/services/<?=$hizmet['gorsel']?>" alt="<?=$hizmet['baslik']?>">
                    </a>
                </div>
                <div class="hizmetler-box-h" style="font-size: <?=$islemayar['kutu_font_size']?>px ; ">
                    <a href="hizmet/<?=$hizmet['seo_url']?>/" style="color: #<?=$islemayar['kutu_yazi_renk']?>;">
                        <?=$hizmet['baslik']?>
                    </a>
                </div>
                <div class="hizmetler-box-s" style="color: #<?=$islemayar['kutu_yazi_renk']?>; ">
                    <?=$hizmet['spot']?>
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

                        <li class="page-item"><a class="page-link" href="hizmetler/1/"><?=$diller['sayfalama-ilk']?></a></li>
                        <li class="page-item"><a class="page-link" href="hizmetler/<?=$Sayfa - 1?>/"><?=$diller['sayfalama-onceki']?></a></li>

                    <?php } ?>
                    <?php
                    for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                        if($i == $Sayfa){
                            echo '    
    
                            <li class="page-item active" aria-current="page">
                              <a class="page-link" href="hizmetler/'.$i.'/">'.$i.'<span class="sr-only">(current)</span></a>
                            </li>
                            
                            ';
                        }else{
                            echo '
                    <li class="page-item"><a class="page-link" href="hizmetler/'.$i.'/">'.$i.'</a></li>
                    ';
                        }
                    }
                    }
                    ?>

                    <?php if($islemListele->rowCount() <=0) { } else { ?>
                        <?php if($Sayfa != $Sayfa_Sayisi){?>

                            <li class="page-item"><a class="page-link" href="hizmetler/<?=$Sayfa + 1?>/"><?=$diller['sayfalama-sonraki']?></a></li>
                            <li class="page-item"><a class="page-link" href="hizmetler/<?=$Sayfa_Sayisi?>/"><?=$diller['sayfalama-son']?></a></li>


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
            <i class="fa fa-ban"></i> Hiç veri eklenmemiş!
        </div>
    <?php }?>
</div>
</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

