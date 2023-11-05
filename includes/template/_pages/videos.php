<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if(isset($_GET['etiket'])  ) {
    if(htmlspecialchars(trim(strip_tags($_GET['etiket']))) == !null ) {
        if(strip_tags(htmlspecialchars($_GET['etiket'])) != $_GET['etiket']  ) {
            header('Location:'.$ayar['site_url'].'404');
            exit();
        }
        $filtreGet = $_GET['etiket'];
        $Filtre ="and (tags LIKE '%$filtreGet%' or meta_desc LIKE '%$filtreGet%' or spot LIKE '%$filtreGet%' or baslik LIKE '%$filtreGet%') ";
    }else{
    header('Location:'.$ayar['site_url'].'video-galeri/');
    }
}
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from video where durum='1' and dil='$_SESSION[dil]' $Filtre ");
$ToplamVeri = $Say->rowCount();
$Limit = 30;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from video where durum='1' and dil='$_SESSION[dil]' $Filtre order by sira ASC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);
$islemAyarcek = $db->prepare("select * from video_ayar where id='1' ");
$islemAyarcek->execute();
$islemayar = $islemAyarcek->fetch(PDO::FETCH_ASSOC);
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='video' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['altsayfa-video-galeri-title']?> - <?php echo $ayar['site_baslik']?></title>
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
<?php include 'includes/template/helper/page-headers-stil.php';  ?>

<!-- CONTENT AREA ============== !-->


<div id="MainDiv" style="width: 100%;  overflow: hidden; background-color: #<?=$islemayar['arkaplan']?>; font-family : '<?=$islemayar['font_secim']?>',Sans-serif ; ">
    <?php if($pagehead['durum'] == '1' ) {?>
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?php echo $diller['video-galeri-baslik']; ?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a>
                        <?php echo ucwords_tr($diller['video-galeri-baslik']); ?>
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
    <div class="videolar-container-flex">
        <?php if($islemayar['nav'] == '1' ) {?>
            <?php include 'includes/template/helper/pages_nav/navigation.php'; ?>
        <?php }?>
        <div class="videolar-container-main">
            <?php if($ToplamVeri>'0'  ) {?>
                <div class="w-100 d-flex align-items-center flex-wrap justify-content-end teslimat-form-area p-3 bg-light border-bottom ">
                    <?php if(isset($_GET['etiket'])) {?>
                        <div class="col-md-6 text-right d-flex align-items-center justify-content-start pl-0 videos-tags-find ">
                            <a href="<?=$ayar['site_url']?>video-galeri/" data-toggle="tooltip" data-placement="top" title="<?=$diller['tag-buttons-remove']?>" class="btn btn-info btn-sm"><?=$filtreGet?> <i class="fa fa-times"></i></a>
                        </div>
                    <?php }?>
                    <form method="get" action="" class="col-md-6 text-right d-flex align-items-center justify-content-end mr-0 pr-0 ">
                        <input type="text" name="etiket" autocomplete="off" placeholder="<?=$diller['video-ara']?>"  required class="form-control ">
                        <button class="border-0 bg-dark text-white" style="height: 35px; width: 35px"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            <?php }?>

            <?php foreach ($islemCek as $video) {?>
                <div class="videolar-sub-box">
                    <div class="videolar-sub-box-img">
                        <div class="videolar-sub-box-img-overlay">
                            <a href="video/<?=$video['seo_url']?>/" style="display: flex; align-items: flex-start; justify-content: center;">
                                <div class="videolar-sub-box-img-overlay-i">
                                    <i class="fa fa-video-camera"></i>
                                </div>
                                <div class="videolar-sub-box-img-overlay-i-2">
                                    <i class="fa fa-play"></i>
                                </div>
                            </a>
                        </div>
                        <img src="images/videos/<?=$video['gorsel']?>" alt="<?=$video['baslik']?>">
                    </div>
                    <div class="videolar-sub-box-h">
                        <a href="video/<?=$video['seo_url']?>/">
                            <?=$video['baslik']?>
                        </a>
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

                                <li class="page-item"><a class="page-link" href="video-galeri/<?php if(isset($_GET['etiket'])  ) { ?>?etiket=<?=$_GET['etiket']?>&page=1<?php }else{?>1/<?php } ?>"><?=$diller['sayfalama-ilk']?></a></li>
                                <li class="page-item"><a class="page-link" href="video-galeri/<?php if(isset($_GET['etiket'])  ) { ?>?etiket=<?=$_GET['etiket']?>&page=<?=$Sayfa - 1?><?php }else{?><?=$Sayfa - 1?>/<?php } ?>"><?=$diller['sayfalama-onceki']?></a></li>

                            <?php } ?>
                            <?php
                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                if($i == $Sayfa){
                                   ?>
                                <li class="page-item active" aria-current="page">
                                  <a class="page-link" href="video-galeri/<?php if(isset($_GET['etiket'])  ) { ?>?etiket=<?=$_GET['etiket']?>&page=<?=$i?><?php }else{?><?=$i?>/<?php } ?>"><?=$i?><span class="sr-only">(current)</span></a>
                                </li>
                                    <?php
                                }else{
                                    ?>
                                <li class="page-item"><a class="page-link" href="video-galeri/<?php if(isset($_GET['etiket'])  ) { ?>?etiket=<?=$_GET['etiket']?>&page=<?=$i?><?php }else{?><?=$i?>/<?php } ?>"><?=$i?></a></li>
                                <?php       }    }     } ?>
                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                <?php if($Sayfa != $Sayfa_Sayisi){?>

                                    <li class="page-item"><a class="page-link" href="video-galeri/<?php if(isset($_GET['etiket'])  ) { ?>?etiket=<?=$_GET['etiket']?>&page=<?=$Sayfa + 1?><?php }else{?><?=$Sayfa + 1?>/<?php } ?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                    <li class="page-item"><a class="page-link" href="video-galeri/<?php if(isset($_GET['etiket'])  ) { ?>?etiket=<?=$_GET['etiket']?>&page=<?=$Sayfa_Sayisi?><?php }else{?><?=$Sayfa_Sayisi?>/<?php } ?>"><?=$diller['sayfalama-son']?></a></li>


                                <?php }} ?>

                            <?php if($Sayfa >= 1){?>
                        </ul>
                    </nav>
                <?php } ?>
                </div>
            <?php }?>
            <!---- Sayfalama Elementleri ================== !-->


            <?php if($ToplamVeri<='0'  ) {?>
                <div class="alert alert-secondary w-100 rounded-0 m-3 font-14" >
                    <i class="fa fa-ban"></i> <?=$diller['no-data']?>
                    <?php if(isset($_GET['etiket'])  ) {?>
                        <a href="<?=$ayar['site_url']?>video-galeri/" class="text-danger"><?=$diller['users-panel-text34']?></a>
                    <?php }?>
                </div>
            <?php }?>
        </div>
    </div>

</div>

<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

