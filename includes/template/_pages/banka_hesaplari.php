<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='banka' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
$Sayfa = @intval($_GET['page']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from bankalar   where durum='1' ");
$ToplamVeri = $Say->rowCount();
$Limit = 15;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from bankalar   where durum='1' order by sira ASC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);
?>
<title><?php echo $diller['altsayfa-banka-hesap-title'] ?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$ayar[banka_sayfa_desc]" ?>">
<meta name="keywords" content="<?php echo"$ayar[banka_sayfa_tags]" ?>">
<meta name="news_keywords" content="<?php echo"$ayar[banka_sayfa_tags]" ?>">
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


<div id="MainDiv" style="background-color: #<?=$ayar['banka_sayfa_bg']?>; width: 100%; font-family : '<?=$ayar['banka_sayfa_font']?>',Sans-serif ; overflow: hidden  ">
    <?php if($pagehead['durum'] == '1' ) {?>
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?=$diller['banka-hesap-baslik']?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span style="font-weight: bold;">/</span>
                    <a>
                        <?php echo $diller['banka-hesap-baslik']; ?>
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
    <?php }?>
<div class="iletisim-container-main">


    <?php if($ayar['banka_sayfa_nav'] == '1' ) {?>
      <?php include 'includes/template/helper/pages_nav/navigation.php'; ?>
    <?php }?>

    <?php if($ToplamVeri<='0'  ) {?>
    <div class="iletisim-container-in">
        <div class="user_subpage_favorites_noitems" >
            <i class="las la-university" style="color: #999;"></i>
            <div class="user_subpage_favorites_noitems_head m-top-10" >
                <?=$diller['banka-hesap-text1']?>
            </div>
            <div class="user_subpage_favorites_noitems_s">
                <?=$diller['banka-hesap-text2']?>
            </div>
            <a href="iletisim" class="button-blue button-2x m-top-20">
                <?=$diller['banka-hesap-text3']?>
            </a>
        </div>
    </div>
    <?php }else { ?>
        <div class="alt_sayfa_flex_1">
            <?php foreach ($islemCek as $islem) {?>
                <div class="banka-hesap-main-box">
                    <div class="banka-hesap-main-box-img">
                        <img src="i/banks/<?=$islem['gorsel']?>" alt="<?=$islem['banka_adi']?>">
                    </div>
                    <div class="banka-hesap-main-box-flex">
                        <div class="banka-hesap-main-box-flex-name">
                            <div class="banka-hesap-main-box-flex-ust">
                                <?=$diller['banka-hesap-text4']?>
                            </div>
                            <div class="banka-hesap-main-box-flex-alt">
                                <?=$islem['banka_adi']?>
                            </div>
                        </div>
                        <div class="banka-hesap-main-box-flex-doviz">
                            <div class="banka-hesap-main-box-flex-ust">
                                <?=$diller['banka-hesap-text5']?>
                            </div>
                            <div class="banka-hesap-main-box-flex-alt">
                                <?=$islem['doviz']?>
                            </div>
                        </div>
                        <div class="banka-hesap-main-box-flex-isim">
                            <div class="banka-hesap-main-box-flex-ust">
                                <?=$diller['banka-hesap-text6']?>
                            </div>
                            <div class="banka-hesap-main-box-flex-alt">
                                <?=$islem['hesap_sahibi']?>
                            </div>
                        </div>
                        <div class="banka-hesap-main-box-flex-hesap">
                            <div class="banka-hesap-main-box-flex-ust">
                                <?=$diller['banka-hesap-text8']?>
                            </div>
                            <div class="banka-hesap-main-box-flex-alt">
                                <?=$islem['hesap_sube']?> / <?=$islem['hesap_no']?>
                            </div>
                        </div>
                        <div class="banka-hesap-main-box-flex-iban">
                            <div class="banka-hesap-main-box-flex-ust">
                                <?=$diller['banka-hesap-text7']?>
                            </div>
                            <div class="banka-hesap-main-box-flex-alt">
                                <?=$islem['hesap_iban']?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
            <!---- Sayfalama Elementleri ================== !-->
            <?php if($ToplamVeri > $Limit  ) {?>
                <div id="SayfalamaElementi" style="width: 100%;  ">
                    <?php if($Sayfa >= 1){?>
                    <nav aria-label="Page navigation example" style="margin-top: 20px;">
                        <ul class="pagination pagination-sm">
                            <?php } ?>

                            <?php if($Sayfa > 1){?>

                                <li class="page-item"><a class="page-link" href="hesap-numaralarimiz/1/"><?=$diller['sayfalama-ilk']?></a></li>
                                <li class="page-item"><a class="page-link" href="hesap-numaralarimiz/<?=$Sayfa - 1?>/"><?=$diller['sayfalama-onceki']?></a></li>

                            <?php } ?>
                            <?php
                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                if($i == $Sayfa){
                                    echo '    
    
                            <li class="page-item active" aria-current="page">
                              <a class="page-link" href="hesap-numaralarimiz/'.$i.'/">'.$i.'<span class="sr-only">(current)</span></a>
                            </li>
                            
                            ';
                                }else{
                                    echo '
                    <li class="page-item"><a class="page-link" href="hesap-numaralarimiz/'.$i.'/">'.$i.'</a></li>
                    ';
                                }
                            }
                            }
                            ?>

                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                <?php if($Sayfa != $Sayfa_Sayisi){?>

                                    <li class="page-item"><a class="page-link" href="hesap-numaralarimiz/<?=$Sayfa + 1?>/"><?=$diller['sayfalama-sonraki']?></a></li>
                                    <li class="page-item"><a class="page-link" href="hesap-numaralarimiz/<?=$Sayfa_Sayisi?>/"><?=$diller['sayfalama-son']?></a></li>


                                <?php }} ?>

                            <?php if($Sayfa >= 1){?>
                        </ul>
                    </nav>
                <?php } ?>
                </div>
            <?php }?>
            <!---- Sayfalama Elementleri ================== !-->
        </div>

    <?php }?>





</div>
</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

