<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='markalar' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);

$markaTotal = $db->prepare("select * from urun_marka where durum='1' ");
$markaTotal->execute();


if(isset($_GET['q'])  ) {

    if($_GET['q']==null  ) {
     header('Location:'.$siteurl.'marka-listesi/');
    }
    if(strip_tags(htmlspecialchars($_GET['q'])) != $_GET['q']  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }

    $markaAra = "(baslik like '%$_GET[q]%' or spot like '%$_GET[q]%' or tags like '%$_GET[q]%' or meta_desc like '%$_GET[q]%') and ";
}

$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from urun_marka where $markaAra durum='1'   ");
$ToplamVeri = $Say->rowCount();
$Limit = 20  ;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from urun_marka where $markaAra durum='1'  order by sira ASC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

$markaAyar = $db->prepare("select * from urun_marka_ayar where id='1'");
$markaAyar->execute();
$markaAyarRow = $markaAyar->fetch(PDO::FETCH_ASSOC);
?>
<title><?php echo $diller['altsayfa-tummarkalar-title'] ?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$markaAyarRow[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$markaAyarRow[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$markaAyarRow[tags]" ?>">
<meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">
<meta property="og:type" content="website" />

<?php include "includes/config/header_libs.php";?>
</head>
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>
<?php include 'includes/template/helper/page-headers-stil.php';  ?>


<!-- CONTENT AREA ============== !-->


<div id="MainDiv" style="background-color: #<?=$markaAyarRow['detay_bg']?>; width: 100%; font-family : '<?=$markaAyarRow['detay_font']?>',Sans-serif ; overflow: hidden  ">
    <?php if($pagehead['durum'] == '1' ) {?>
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?=$diller['tummarkalar-text1']?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a ><?=$diller['tummarkalar-text1']?></a>
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
<div class="iletisim-container-main">



    <?php if($markaTotal->rowCount()<='0'  ) {?>
    <div class="iletisim-container-in">
        <div class="user_subpage_favorites_noitems" >
            <div class="user_subpage_favorites_noitems_head m-top-10" >
                <?=$diller['tummarkalar-text2']?>
            </div>
            <div class="user_subpage_favorites_noitems_s">
                <?=$diller['tummarkalar-text3']?>
            </div>
            <a href="<?=$ayar['site_url']?>" class="button-blue button-2x m-top-20">
                <?=$diller['sepet-alisverise-basla']?>
            </a>
        </div>
    </div>
    <?php }else { ?>
        <div class="alt_sayfa_flex_1">

            <div class="markadetay-main-div">
                <?php if($ToplamVeri>'0'  ) {?>
                    <div class="markadetay-search teslimat-form-area">
                        <form action="" method="get">
                            <input type="text" name="q" placeholder="<?=$diller['tummarkalar-text4']?>" required class="form-control" autocomplete="off">
                            <button class="button-1x button-black">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                <?php } ?>
                <?php if($ToplamVeri<='0'  ) {?>
                    <div class="user_subpage_favorites_noitems" style="margin-bottom: 0;" >
                        <div class="user_subpage_favorites_noitems_head m-top-10" >
                            <?=$diller['tummarkalar-text2']?>
                        </div>
                        <div class="user_subpage_favorites_noitems_s">
                            <?=$diller['tummarkalar-text6']?>
                        </div>
                        <?php if( isset($_GET['q'])  ) {?>
                            <a href="marka-listesi/" class="button-yellow-out button-2x m-top-20">
                                <?=$diller['tummarkalar-text5']?>
                            </a>
                        <?php }?>
                    </div>
                <?php }?>
                <?php if($ToplamVeri>'0' && isset($_GET['q'])   ) {?>
                <div style="width: 100%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; font-size: 16px ; font-weight: 600;  ">
                    "<?=$_GET['q']?>" <?=$diller['tummarkalar-text7']?>
                </div>
                    <?php if(isset($_GET['q'])  ) {?>
                        <div style="width: 100%; display: flex; align-items: center; justify-content: center;  ">
                            <a href="marka-listesi/" class="button-yellow-out button-2x">
                                <i class="las la-undo"></i> <?=$diller['tummarkalar-text5']?>
                            </a>
                        </div>
                    <?php }?>
                <?php }?>

                <div class="markadetay-content-boxes">
                    <?php foreach ($islemCek as $row) {?>
                    <div class="markadetay-content-box">
                        <a  href="marka/<?=$row['seo_url']?>/">
                        <div class="markadetay-content-box-img">
                            <?php if($row['gorsel'] == !null  ) {?>
                                <img src="images/uploads/<?=$row['gorsel']?>" alt="<?=$row['baslik']?>">
                            <?php }else { ?>
                                <img src="images/product/no-img.jpg" alt="<?=$row['baslik']?>">
                            <?php }?>
                        </div>
                        </a>
                        <a class="markadetay-content-box-text" href="marka/<?=$row['seo_url']?>/">
                            <?=$row['baslik']?>
                        </a>
                    </div>
                    <?php }?>
                </div>

                <!---- Sayfalama Elementleri ================== !-->
                <?php if($ToplamVeri > $Limit  ) {?>
                    <div id="SayfalamaElementi" style="width: 100%;  ">
                        <?php if($Sayfa >= 1){?>
                        <nav aria-label="Page navigation example" style="margin-top: 20px;">
                            <ul class="pagination pagination-sm justify-content-center">
                                <?php } ?>

                                <?php if($Sayfa > 1){?>

                                    <li class="page-item"><a class="page-link" href="marka-listesi/<?php if(isset($_GET['q'])  ) { ?>?q=<?=$_GET['q']?>&page=1<?php }else{?>?page=1<?php }?>"><?=$diller['sayfalama-ilk']?></a></li>
                                    <li class="page-item"><a class="page-link" href="marka-listesi/<?php if(isset($_GET['q'])  ) { ?>?q=<?=$_GET['q']?>&page=<?=$Sayfa - 1?><?php }else{?>?page=<?=$Sayfa - 1?><?php }?>"><?=$diller['sayfalama-onceki']?></a></li>

                                <?php } ?>
                                <?php
                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                    if($i == $Sayfa){
                                        ?>

                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="marka-listesi/<?php if(isset($_GET['q'])  ) { ?>?q=<?=$_GET['q']?>&page=<?=$i?><?php }else{?>?page=<?=$i?><?php }?>"><?=$i?><span class="sr-only">(current)</span></a>
                                        </li>

                                        <?php
                                    }else{
                                        ?>
                                        <li class="page-item"><a class="page-link" href="marka-listesi/<?php if(isset($_GET['q'])  ) { ?>?q=<?=$_GET['q']?>&page=<?=$i?><?php }else{?>?page=<?=$i?><?php }?>"><?=$i?></a></li>
                                        <?php
                                    }
                                }
                                }
                                ?>

                                <?php if($islemListele->rowCount() <=0) { } else { ?>
                                    <?php if($Sayfa != $Sayfa_Sayisi){?>

                                        <li class="page-item"><a class="page-link" href="marka-listesi/<?php if(isset($_GET['q'])  ) { ?>?q=<?=$_GET['q']?>&page=<?=$Sayfa + 1?><?php }else{?>?page=<?=$Sayfa + 1?><?php }?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                        <li class="page-item"><a class="page-link" href="marka-listesi/<?php if(isset($_GET['q'])  ) { ?>?q=<?=$_GET['q']?>&page=<?=$Sayfa_Sayisi?><?php }else{?>?page=<?=$Sayfa_Sayisi?><?php }?>"><?=$diller['sayfalama-son']?></a></li>


                                    <?php }} ?>

                                <?php if($Sayfa >= 1){?>
                            </ul>
                        </nav>
                    <?php } ?>
                    </div>
                <?php }?>
                <!---- Sayfalama Elementleri ================== !-->
            </div>





        </div>

    <?php }?>





</div>
</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

