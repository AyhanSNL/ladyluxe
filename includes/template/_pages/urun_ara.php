<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if(!isset($_GET['q'])) {?>
    <?php
    header('Location:'.$siteurl.'');
    ?>
<?php }else { ?>
    <?php
    include 'includes/template/helper/urun_ara/fonksiyonlar.php';
    ?>
    <title><?=$diller['altsayfa-urunara-title']?> - <?php echo $ayar['site_baslik'] ?></title>
    <meta name="description" content="<?php echo"$ayar[site_desc]" ?>">
    <meta name="keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="news_keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta property="og:type" content="website"/>

    <?php include "includes/config/header_libs.php"; ?>
    <link rel="stylesheet" href="assets/css/category_style.css"/>

    </head>
    <body>
    <?php include 'includes/template/pre-loader.php' ?>
    <?php include 'includes/template/header.php' ?>
    <?php include 'includes/template/helper/page-headers-stil.php'; ?>
    <!-- CONTENT AREA ============== !-->

    <div class="cat-detail-main-div"style="padding: 0 !important; ">
        <!-- Page Header !-->
        <?php if ($pagehead['durum'] == '1') { ?>
            <div class="page-banner-main">
                <div class="page-banner-in-text">
                    <div class="page-banner-h <?= $pagehead['baslik_space'] ?>">
                        <i class="las la-search-location"></i> <?=$diller['altsayfa-urunara-title']?>
                    </div>
                    <div class="page-banner-links ">
                        <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?= $diller['sayfa-banner-anasayfa'] ?></a>
                        <span>/</span>
                        <a><?=$diller['altsayfa-urunara-title']?></a>
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
        <!--  <========SON=========>>> Page Header SON !-->
    </div>

    <?php if(isset($_GET['q']) && $_GET['q'] == null  ) {?>
        <?php
        header('Location:'.$siteurl.'');
        ?>
    <?php }else { ?>
        <?php  if(strlen(htmlspecialchars(trim($_GET['q']))) < 4 ) {?>
            <div id="MainDiv" class="cat-detail-main-div" style="width: 100%; padding: 0; overflow: hidden; ">
                <div class="user_login_register_div">
                    <div class="iletisim-container-in">
                        <div class="user_subpage_favorites_noitems" >
                            <i class="las la-frown" style="color: #999;"></i>
                            <div class="user_subpage_favorites_noitems_head m-top-10" >
                                <?=$diller['urun-ara-sayfa-text5']?>
                            </div>
                            <a href="javascript:Void(0)" style="width: auto; display: inline-block; margin-top: 20px; font-size: 13px; border-bottom: 1px solid #666; color: #000; text-decoration: none;" >
                                <?=$diller['urun-ara-sayfa-text3']?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }else { ?>
            <?php if($mainTotalCount->rowCount() <='0') {?>
                <div id="MainDiv" class="cat-detail-main-div" style="width: 100%; padding: 0; overflow: hidden; ">
                    <div class="user_login_register_div">
                        <div class="iletisim-container-in">
                            <div class="user_subpage_favorites_noitems" >
                                <i class="las la-frown" style="color: #999;"></i>
                                <div class="user_subpage_favorites_noitems_head m-top-10" >
                                    <?=$diller['urun-ara-sayfa-text1']?>
                                </div>
                                <div class="user_subpage_favorites_noitems_s">
                                    <strong>"<?=trim(strip_tags($_GET['q']))?>"</strong>  <?=$diller['urun-ara-sayfa-text2']?>
                                </div>
                                <a href="javascript:Void(0)" style="width: auto; display: inline-block; margin-top: 20px; font-size: 13px; border-bottom: 1px solid #666; color: #000; text-decoration: none;" >
                                    <?=$diller['urun-ara-sayfa-text3']?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }else { ?>
                <div class="cat-detail-main-div" ><div class="cat-detail-main-div-in">

                        <!-- left Nav !-->
                        <?php include 'includes/template/helper/urun_ara/left-bar.php'; ?>

                        <!-- Products Area !-->
                        <div class="cat-right-main">

                            <div class="cat-right-header-out">
                                <div class="cat-right-header2">
                                    <div class="cat-right-header2-left">
                                        <div class="cat-right-head-text" style="color: #000; <?php if ($markaMain['spot']==null) { ?>margin-bottom:0;<?php } ?>">
                                            <?=$search?> <?=$diller['urun-ara-sayfa-text4']?> (<?=$TotalData?>)
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="cat-right-elements-out">
                                <div class="cat-right-elements">
                                    <div class="cat-right-elements-left">
                                        <?php if($islemayar['filtre_stok'] == '1' ) {?>
                                            <div class="cat-left-box-t" style="border-bottom: 0; padding: 5px 0 0 0;">
                                                <div class="custom-control custom-checkbox">
                                                    <?php if($_GET['stok'] == '1'  ) {?>
                                                        <input type="checkbox" class="custom-control-input" id="stok" onclick="javascript:window.location='<?=$browser_link?>?<?=$StokParselMain?>'" checked >
                                                    <?php }?>
                                                    <?php if($_GET['stok'] == '0' || !isset($_GET['stok'])    ) {?>
                                                        <input type="checkbox" class="custom-control-input" id="stok" onclick="javascript:window.location='<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$StokParselMain?>&stok=1'" >
                                                    <?php }?>
                                                    <label class="custom-control-label" for="stok" style="color: #<?=$islemayar['sol_nav_text_color']?>;"><?=$diller['kategori-detay-text9']?></label>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <div class="cat-right-elements-right" >
                                        <div class="cat-right-elements-right-siralama" >
                                            <select name="s" id="dynamic_select" class="select nice-select-cat-detail" required>
                                                <option value="<?=$browser_link?>?s=1<?=$siralamaURL?>"<?php if($_GET['s'] == '1'  ) { ?>selected<?php }?>><?=$diller['kategori-detay-text13']?></option>
                                                <option value="<?=$browser_link?>?s=2<?=$siralamaURL?>"<?php if($_GET['s'] == '2'  ) { ?>selected<?php }?>><?=$diller['kategori-detay-text14']?></option>
                                                <option value="<?=$browser_link?>?s=3<?=$siralamaURL?>"<?php if($_GET['s'] == '3'  ) { ?>selected<?php }?>><?=$diller['kategori-detay-text15']?></option>
                                                <option value="<?=$browser_link?>?s=4<?=$siralamaURL?>"<?php if($_GET['s'] == '4'  ) { ?>selected<?php }?>><?=$diller['kategori-detay-text16']?></option>
                                                <option value="<?=$browser_link?>?s=5<?=$siralamaURL?>"<?php if($_GET['s'] == '5'  ) { ?>selected<?php }?>><?=$diller['kategori-detay-text17']?></option>
                                            </select>
                                        </div>
                                        <div class="cat-right-elements-right-liste">
                                            <a href="#" class="grid tooltip-bottom cat-grid none-grid-system" data-tooltip="<?=$diller['kategori-detay-text10']?>"
                                               <?php if ($_SESSION['cat_box_show_select'] == '1') { ?>style="border: 1px solid #000; padding: 5px;"<?php } ?>>
                                                <img src="images/grid_b.png" alt="grid show">
                                            </a>
                                            <a href="#" class="grid tooltip-bottom cat-grid-b" data-tooltip="<?=$diller['kategori-detay-text11']?>"
                                               <?php if ($_SESSION['cat_box_show_select'] == '3') { ?>style="border: 1px solid #000; padding: 5px;"<?php } ?>>
                                                <img src="images/grid.png" alt="grid show">
                                            </a>
                                            <a href="#" class="list tooltip-bottom cat-list" data-tooltip="<?=$diller['kategori-detay-text12']?>"
                                               <?php if ($_SESSION['cat_box_show_select'] == '2') { ?>style="border: 1px solid #000; padding: 5px;"<?php } ?>>
                                                <img src="images/list.png" alt="list show">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($_GET['editor']== '1' || $_GET['uk']== '1' || $_GET['new']=='1' || $_GET['firsat']=='1' || $_GET['indirim']=='1' || $_GET['taksit']=='1' || $_GET['hizlikargo']== '1' || $_GET['stok'] == '1' || isset($_GET['min']) || isset($_GET['max'] ) || isset($_GET['marka']) || isset($_GET['oz'])) {?>
                                <!-- Filtreleri kaldır !-->
                                <div class="cat-left-box-out-filterbox-out" >
                                    <?php if($_GET['uk'] == '1'  ) {?>
                                        <a href="<?=$browser_link?>?<?=$ukParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text2']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <?php if($_GET['new'] == '1'  ) {?>
                                        <a href="<?=$browser_link?>?<?=$npParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text3']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <?php if($_GET['firsat'] == '1'  ) {?>
                                        <a href="<?=$browser_link?>?<?=$opParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text4']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <?php if($_GET['indirim'] == '1'  ) {?>
                                        <a href="<?=$browser_link?>?<?=$indirimParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text5']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <?php if($_GET['taksit'] == '1'  ) {?>
                                        <a href="<?=$browser_link?>?<?=$taksitParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text6']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <?php if($_GET['hizlikargo'] == '1'  ) {?>
                                        <a href="<?=$browser_link?>?<?=$hkParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text7']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <?php if($_GET['stok'] == '1'  ) {?>
                                        <a href="<?=$browser_link?>?<?=$StokParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text35']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <?php if($_GET['editor'] == '1'  ) {?>
                                        <a href="<?=$browser_link?>?<?=$editorParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text38']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <?php if(isset($_GET['min']) && isset($_GET['max'])) {?>
                                        <a href="<?=$browser_link?>?<?=$PriceFilterParselMain?>" class="<?=$islemayar['secili_filtre_button']?> tooltip-bottom"  data-tooltip="<?=$diller['kategori-detay-text34']?>"><?=$diller['kategori-detay-text27']?> <i class="ion-backspace"></i></a>
                                    <?php }?>
                                    <a href="<?=$browser_link?>?s=1&q=<?=$search?>" class="<?=$islemayar['tumfiltre_kaldir_button']?> "><?=$diller['kategori-detay-text20']?></a>
                                </div>
                                <!--  <========SON=========>>> Filtreleri kaldır SON !-->
                            <?php }?>


                            <!-- Ürünler !-->
                            <div class="cat-detail-products">

                                <?php if($listeleSorgu->rowCount() > '0'  ) {?>
                                    <!-- Görünüm İşlemleri !-->
                                    <?php if (!isset($_SESSION['cat_box_show_select'])) {
                                        $_SESSION['cat_box_show_select'] = $islemayar['urun_box_gorunum_tur'];
                                        $box_gorunum_turu = $_SESSION['cat_box_show_select'];
                                    } else {
                                        $box_gorunum_turu = $_SESSION['cat_box_show_select'];
                                    } ?>
                                    <?php
                                    if ($box_gorunum_turu == '1') {
                                        $box_gorunum_main_div = 'cat-detail-products-box';
                                        $box_gorunum_img_div = 'cat-detail-products-box-img';
                                        $box_gorunum_info_div = 'cat-detail-products-box-info';
                                        $box_gorunum_price_div = 'cat-detail-products-box-fiyat';
                                        $box_gorunum_hiddenprice_div = 'urun-box-special-area';

                                    }
                                    if ($box_gorunum_turu == '2') {
                                        $box_gorunum_main_div = 'cat-detail-products-box-list';
                                        $box_gorunum_img_div = 'cat-detail-products-box-img-list';
                                        $box_gorunum_info_div = 'cat-detail-products-box-info-list';
                                        $box_gorunum_price_div = 'cat-detail-products-box-fiyat-list';
                                        $box_gorunum_hiddenprice_div = 'urun-box-special-area-list';
                                    }
                                    if ($box_gorunum_turu == '3') {
                                        $box_gorunum_main_div = 'cat-detail-products-box-big';
                                        $box_gorunum_img_div = 'cat-detail-products-box-img-big';
                                        $box_gorunum_info_div = 'cat-detail-products-box-info';
                                        $box_gorunum_price_div = 'cat-detail-products-box-fiyat';
                                        $box_gorunum_hiddenprice_div = 'urun-box-special-area';

                                    }
                                    ?>
                                    <!--  <========SON=========>>> Görünüm İşlemleri SON !-->




                                    <?php foreach ($listeleSorgu as $urun) {
                                        $kutuMarka = $db->prepare("select * from urun_marka where id=:id and durum=:durum ");
                                        $kutuMarka->execute(array(
                                            'id' => $urun['marka'],
                                            'durum' => '1'
                                        ));
                                        $urunmarka = $kutuMarka->fetch(PDO::FETCH_ASSOC);
                                        /* Fiyatı Çıkar */
                                        if($userSorgusu->rowCount()>'0'  ) {
                                            if($uyegruplariCek->rowCount()>'0'  ) {
                                                if($uyegrup['fiyat_tip'] == '0'  ) {
                                                    $box_fiyat = $urun['fiyat'];
                                                    $box_fiyat_uyari = '0';
                                                }
                                                if($uyegrup['fiyat_tip'] == '1'  ) {
                                                    if($urun['fiyat_tip2'] >'0' ) {
                                                        $box_fiyat = $urun['fiyat_tip2'];
                                                        $box_fiyat_uyari = '1';
                                                    }else{
                                                        $box_fiyat = $urun['fiyat'];
                                                        $box_fiyat_uyari = '0';
                                                    }
                                                }
                                            }else{
                                                $box_fiyat = $urun['fiyat'];
                                                $box_fiyat_uyari = '0';
                                            }
                                        }else{
                                            $box_fiyat = $urun['fiyat'];
                                            $box_fiyat_uyari = '0';
                                        }
                                        /*  <========SON=========>>> Fiyatı Çıkar SON */
                                        if($urun['indirim'] == '1' && $urun['eski_fiyat'] >'0' ) {
                                            $indirimorani = 100 - (($box_fiyat / $urun['eski_fiyat']) * 100);
                                        }
                                        /* Ürünün Yorum ve Değerlendirme Ortalaması */
                                        $urunYildizlari = $db->prepare("SELECT SUM(yildiz) AS orta FROM urun_yorum where onay=:onay and urun_id=:urun_id; ");
                                        $urunYildizlari->execute(array(
                                            'onay' => '1',
                                            'urun_id' => $urun['id']
                                        ));
                                        $yildizToplami = $urunYildizlari->fetch(PDO::FETCH_ASSOC);

                                        $urunYorumToplamSayi = $db->prepare("select * from urun_yorum where onay=:onay and urun_id=:urun_id ");
                                        $urunYorumToplamSayi->execute(array(
                                            'onay' => '1',
                                            'urun_id' => $urun['id']
                                        ));
                                        $yorumcount = $urunYorumToplamSayi->rowCount();

                                        if($yorumcount == null && $yorumcount <= '0') {
                                            $yildizOrtalamasi = '0';
                                        } else {
                                            $yildizOrtalamasi = $yildizToplami['orta'] / $yorumcount;
                                        }
                                        $urun_comment_star = (int)$yildizOrtalamasi;
                                        /*  <========SON=========>>> Ürünün Yorum ve Değerlendirme Ortalaması SON */

                                        /* Varyant Sorgu */
                                        $varyantVarmi = $db->prepare("select * from detay_varyant where urun_id=:urun_id ");
                                        $varyantVarmi->execute(array(
                                            'urun_id' => $urun['id']
                                        ));
                                        /*  <========SON=========>>> Varyant Sorgu SON */
                                        ?>
                                        <div class="<?=$box_gorunum_main_div ?>">
                                            <?php if ($urunKutuRow['kutu_yeni_ribbon'] == '1') { ?>
                                                <?php if($urun['yeni'] == '1' ) {?>
                                                    <div class="ribbon"><span><?=$diller['urun-box-text4']?></span></div>
                                                <?php }?>
                                            <?php } ?>
                                            <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '1') { ?>
                                                <?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?>
                                                    <div class="cat-detail-products-box-cart-1">
                                                        <?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $urun['stok'] > '0') { ?>
                                                            <?php if($urun['fiyat_goster'] == '1' ) {?>
                                                                <?php if($urun['siparis_islem'] == '0'  ) {?>
                                                                    <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                                        <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                                            <i class="fa fa-shopping-basket"></i>
                                                                        </button>
                                                                    <?php }else { ?>
                                                                        <form action="addtocart" method="post" >
                                                                            <input name="product_code" type="hidden" value="<?php echo $urun["id"]; ?>">
                                                                            <input name="token" type="hidden" value="<?=md5('searchCallBack')?>">
                                                                            <input name="actualCheck" type="hidden" value="<?=$parseParts['query']?>">
                                                                            <input name="quantity" type="hidden" value="1">
                                                                            <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                                                <i class="fa fa-shopping-basket"></i>
                                                                            </button>
                                                                        </form>
                                                                    <?php }?>
                                                                <?php }?>
                                                            <?php }?>
                                                            <?php if($urun['fiyat_goster'] == '2' ) {?>
                                                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                                                    <?php if($urun['siparis_islem'] == '0'  ) {?>
                                                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                                            <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                                                <i class="fa fa-shopping-basket"></i>
                                                                            </button>
                                                                        <?php }else { ?>
                                                                            <form action="addtocart" method="post" >
                                                                                <input name="product_code" type="hidden" value="<?php echo $urun["id"]; ?>">
                                                                                <input name="token" type="hidden" value="<?=md5('searchCallBack')?>">
                                                                                <input name="actualCheck" type="hidden" value="<?=$parseParts['query']?>">
                                                                                <input name="quantity" type="hidden" value="1">
                                                                                <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                                                    <i class="fa fa-shopping-basket"></i>
                                                                                </button>
                                                                            </form>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                <?php }?>
                                                            <?php }?>
                                                            <?php if($urun['fiyat_goster'] == '3' ) {?>
                                                                <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                                                                    <?php if($urun['siparis_islem'] == '0'  ) {?>
                                                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                                            <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                                                <i class="fa fa-shopping-basket"></i>
                                                                            </button>
                                                                        <?php }else { ?>
                                                                            <form action="addtocart" method="post" >
                                                                                <input name="product_code" type="hidden" value="<?php echo $urun["id"]; ?>">
                                                                                <input name="token" type="hidden" value="<?=md5('searchCallBack')?>">
                                                                                <input name="actualCheck" type="hidden" value="<?=$parseParts['query']?>">
                                                                                <input name="quantity" type="hidden" value="1">
                                                                                <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                                                    <i class="fa fa-shopping-basket"></i>
                                                                                </button>
                                                                            </form>
                                                                        <?php }?>
                                                                    <?php }?>
                                                                <?php }?>
                                                            <?php }?>
                                                        <?php } ?>

                                                        <?php if ($urunKutuRow['kutu_fav_button'] == '1') { ?>
                                                            <?php if($uyeayar['durum'] == '1' && $uyeayar['favori_alani'] == '1' ) {?>
                                                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                                                    <?php
                                                                    $favCek = $db->prepare("select * from urun_favori where urun_id=:urun_id ");
                                                                    $favCek->execute(array(
                                                                        'urun_id' => $urun['id']
                                                                    ));
                                                                    $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                                                    ?>
                                                                    <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                                                        <a href="#" class="tooltip-right product-fav-del" data-code="<?php echo $urun['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" style="background-color: #f08183; color: #FFF;">
                                                                            <i class="fa fa-heart-o"></i>
                                                                        </a>
                                                                    <?php }else { ?>
                                                                        <a href="#" class="tooltip-right product-fav-go" data-code="<?php echo $urun['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>">
                                                                            <i class="fa fa-heart-o"></i>
                                                                        </a>
                                                                    <?php } ?>
                                                                <?php }else { ?>
                                                                    <a href="" data-toggle="modal" data-target="#loginModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text2']?>">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                <?php }?>
                                                            <?php }?>
                                                        <?php }?>

                                                        <?php if ($urunKutuRow['kutu_compare_button'] == '1' && $odemeayar['urun_karsilastirma'] == '1') { ?>
                                                            <?php if(isset($_SESSION['compare_product'][$urun['id']] )) {?>
                                                                <a href="#" style="background-color: #f08183; color: #FFF;" data-code="<?php echo $urun['id']; ?>" class="tooltip-right product-compare-exit" data-tooltip="<?=$diller['urun-box-text8']?>">
                                                                    <i class="fa fa-random"></i>
                                                                </a>
                                                            <?php }else { ?>
                                                                <a href="#" class="tooltip-right product-compare" data-code="<?php echo $urun['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>">
                                                                    <i class="fa fa-random"></i>
                                                                </a>
                                                            <?php }?>
                                                        <?php } ?>


                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            <div class="<?= $box_gorunum_img_div ?> <?php if($urun['stok'] <= '0' ) { ?>product-grey-img<?php }?>">
                                                <?php if ($urunKutuRow['kutu_kargo_goster'] == '1') { ?>
                                                    <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                                                        <?php if($urun['kargo'] == '0' ) {?>
                                                            <div class="cat-detail-products-box-kargo">
                                                                <i class="fa fa-truck"></i> <?=$diller['urun-box-text5']?>
                                                            </div>
                                                        <?php }?>
                                                    <?php }?>
                                                <?php } ?>
                                                <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" >
                                                    <?php if($ayar['lazy'] == '1' ) {?>
                                                        <img class="lazy" src="images/load.gif" data-original="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                                                    <?php }else { ?>
                                                        <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                                                    <?php }?>
                                                </a>
                                            </div>

                                            <div class="<?= $box_gorunum_info_div ?>">

                                                <?php if ($urunKutuRow['kutu_star_rate'] == '1') { ?>
                                                    <?php if($uyeayar['durum'] == '0' ) {
                                                        /* Üyelik Sistemi Devre Dışı ise Yöneticinin belirlediği yıldızları getir */
                                                        ?>
                                                        <div class="cat-detail-products-box-stars">
                                                            <?php if($urun['star_rate'] == '0' ) {?>
                                                                <span class="pasif-span">★★★★★</span>
                                                            <?php }?>
                                                            <?php if($urun['star_rate'] == '1' ) {?>
                                                                <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                                                            <?php }?>
                                                            <?php if($urun['star_rate'] == '2' ) {?>
                                                                <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                                                            <?php }?>
                                                            <?php if($urun['star_rate'] == '3' ) {?>
                                                                <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                                                            <?php }?>
                                                            <?php if($urun['star_rate'] == '4' ) {?>
                                                                <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                                                            <?php }?>
                                                            <?php if($urun['star_rate'] == '5' ) {?>
                                                                <span class="aktif-span">★★★★★</span>
                                                            <?php }?>
                                                        </div>
                                                    <?php }else {
                                                        /* Üyelik var. Ürünün yorum durumunu kontrol et yorumlanabilir ise bilgileri çek yorumlanamaz ise yöneticinin belirlediğini ekrana yazdır */
                                                        ?>
                                                        <?php if($urun['yorum_durum'] == '0' ) {
                                                            /* YORUM VE DEĞERLENDİRME YAPILAMAZ! */
                                                            ?>
                                                            <div class="cat-detail-products-box-stars">
                                                                <?php if($urun['star_rate'] == '0' ) {?>
                                                                    <span class="pasif-span">★★★★★</span>
                                                                <?php }?>
                                                                <?php if($urun['star_rate'] == '1' ) {?>
                                                                    <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                                                                <?php }?>
                                                                <?php if($urun['star_rate'] == '2' ) {?>
                                                                    <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                                                                <?php }?>
                                                                <?php if($urun['star_rate'] == '3' ) {?>
                                                                    <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                                                                <?php }?>
                                                                <?php if($urun['star_rate'] == '4' ) {?>
                                                                    <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                                                                <?php }?>
                                                                <?php if($urun['star_rate'] == '5' ) {?>
                                                                    <span class="aktif-span">★★★★★</span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }else {
                                                            /* Yorumlanabilir */
                                                            ?>
                                                            <div class="cat-detail-products-box-stars">
                                                                <?php if($urun_comment_star == '0' ) {?>
                                                                    <span class="pasif-span">★★★★★</span>
                                                                <?php }?>
                                                                <?php if($urun_comment_star == '1' ) {?>
                                                                    <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                                                                <?php }?>
                                                                <?php if($urun_comment_star == '2' ) {?>
                                                                    <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                                                                <?php }?>
                                                                <?php if($urun_comment_star == '3' ) {?>
                                                                    <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                                                                <?php }?>
                                                                <?php if($urun_comment_star == '4' ) {?>
                                                                    <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                                                                <?php }?>
                                                                <?php if($urun_comment_star == '5' ) {?>
                                                                    <span class="aktif-span">★★★★★</span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }?>
                                                    <?php }?>
                                                <?php } ?>



                                                <?php if ($urunKutuRow['kutu_marka_goster'] == '1') { ?>
                                                    <?php if($urun['marka'] >'0' && $urun['marka'] == !null && $kutuMarka->rowCount()>'0') {?>
                                                        <div class="cat-detail-products-box-marka">
                                                            <a href="marka/<?=$urunmarka['seo_url']?>/" style="color: #<?= $urunKutuRow['kutu_marka_renk'] ?>;">
                                                                <?=$urunmarka['baslik']?>
                                                            </a>
                                                        </div>
                                                    <?php }?>
                                                <?php } ?>
                                                <div class="cat-detail-products-box-h">
                                                    <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" style="color: #<?= $urunKutuRow['kutu_yazi_renk'] ?>;">
                                                        <?=$urun['baslik']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php if($urun['fiyat_goster'] == '1' && $urun['stok'] > '0' ) {?>
                                                <div class="<?= $box_gorunum_price_div ?>" >
                                                    <div class="cat-detail-products-box-fiyat-out">
                                                        <?php if($urun['indirim'] == '1' && $urun['eski_fiyat'] > '0') {?>
                                                            <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                                                <?php kur_cekimi($urun['eski_fiyat']) ?>
                                                            </div>
                                                        <?php }?>
                                                        <div class="cat-detail-products-box-fiyat-mevcut" style="color: #<?= $urunKutuRow['kutu_fiyat_renk'] ?>; ">
                                                            <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                                                                <?php if($box_fiyat == '0'  ) {?>
                                                                    <?=$diller['kategori-detay-text24']?>
                                                                <?php }else { ?>

                                                                    <?php if($box_fiyat_uyari == '1'  ) {?>
                                                                        <div class="cat-detail-products-box-special-out">
                                                                            <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                           <?php kur_cekimi_nospan($urun['fiyat']) ?>
                                                        ">
                                                                                <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }?>
                                                                    <?php kur_cekimi($box_fiyat) ?>
                                                                <?php }?>
                                                            <?php }else { ?>
                                                                <?php if($box_fiyat_uyari == '1'  ) {?>
                                                                    <div class="cat-detail-products-box-special-out">
                                                                        <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                    <?php kur_cekimi_nospan($urun['fiyat']) ?>
                                                        ">
                                                                            <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                                <?php kur_cekimi($box_fiyat) ?>
                                                            <?php }?>

                                                        </div>
                                                    </div>
                                                    <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                                                        <?php
                                                        if($urun['indirim'] == '1' && $urun['eski_fiyat'] >'0' ) {
                                                            ?>
                                                            <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                                                % <?=(int)$indirimorani?>
                                                            </div>
                                                        <?php }} ?>
                                                </div>
                                            <?php }?>
                                            <?php if($urun['fiyat_goster'] == '2' && $urun['stok'] > '0') {?>
                                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                                    <div class="<?= $box_gorunum_price_div ?>" >
                                                        <div class="cat-detail-products-box-fiyat-out">
                                                            <?php if($urun['indirim'] == '1' && $urun['eski_fiyat'] > '0') {?>
                                                                <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                                                    <?php kur_cekimi($urun['eski_fiyat']) ?>
                                                                </div>
                                                            <?php }?>
                                                            <div class="cat-detail-products-box-fiyat-mevcut" style="color: #<?= $urunKutuRow['kutu_fiyat_renk'] ?>; ">
                                                                <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                                                                    <?php if($box_fiyat == '0'  ) {?>
                                                                        <?=$diller['kategori-detay-text24']?>
                                                                    <?php }else { ?>

                                                                        <?php if($box_fiyat_uyari == '1'  ) {?>
                                                                            <div class="cat-detail-products-box-special-out">
                                                                                <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                             <?php kur_cekimi_nospan($urun['fiyat']) ?>
                                                        ">
                                                                                    <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                                                </div>
                                                                            </div>
                                                                        <?php }?>
                                                                        <?php kur_cekimi($box_fiyat) ?>
                                                                    <?php }?>
                                                                <?php }else { ?>
                                                                    <?php if($box_fiyat_uyari == '1'  ) {?>
                                                                        <div class="cat-detail-products-box-special-out">
                                                                            <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                        <?php kur_cekimi_nospan($urun['fiyat']) ?>
                                                        ">
                                                                                <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }?>
                                                                    <?php kur_cekimi($box_fiyat) ?>
                                                                <?php }?>

                                                            </div>
                                                        </div>
                                                        <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                                                            <?php
                                                            if($urun['indirim'] == '1' && $urun['eski_fiyat'] >'0' ) {
                                                                ?>
                                                                <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                                                    % <?=(int)$indirimorani?>
                                                                </div>
                                                            <?php }} ?>
                                                    </div>
                                                <?php }else { ?>
                                                    <?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                                                        <div class="<?=$box_gorunum_hiddenprice_div?>"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text22']?></div>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>
                                            <?php if($urun['fiyat_goster'] == '3' && $urun['stok'] > '0' ) {?>
                                                <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                                                    <div class="<?= $box_gorunum_price_div ?>" >
                                                        <div class="cat-detail-products-box-fiyat-out">
                                                            <?php if($urun['indirim'] == '1' && $urun['eski_fiyat'] > '0') {?>
                                                                <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                                                    <?php kur_cekimi($urun['eski_fiyat']) ?>
                                                                </div>
                                                            <?php }?>
                                                            <div class="cat-detail-products-box-fiyat-mevcut" style="color: #<?= $urunKutuRow['kutu_fiyat_renk'] ?>; ">
                                                                <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                                                                    <?php if($box_fiyat == '0'  ) {?>
                                                                        <?=$diller['kategori-detay-text24']?>
                                                                    <?php }else { ?>


                                                                        <?php if($box_fiyat_uyari == '1'  ) {?>
                                                                            <div class="cat-detail-products-box-special-out">
                                                                                <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                        <?php kur_cekimi_nospan($urun['fiyat']) ?>
                                                        ">
                                                                                    <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                                                </div>
                                                                            </div>
                                                                        <?php }?>
                                                                        <?php kur_cekimi_nospan($box_fiyat) ?>
                                                                    <?php }?>
                                                                <?php }else { ?>
                                                                    <?php if($box_fiyat_uyari == '1'  ) {?>
                                                                        <div class="cat-detail-products-box-special-out">
                                                                            <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                        <?php kur_cekimi_nospan($urun['fiyat']) ?>
                                                        ">
                                                                                <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                                            </div>
                                                                        </div>
                                                                    <?php }?>
                                                                    <?php kur_cekimi($box_fiyat) ?>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                                                            <?php
                                                            if($urun['indirim'] == '1' && $urun['eski_fiyat'] >'0' ) {
                                                                ?>
                                                                <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                                                    % <?=(int)$indirimorani?>
                                                                </div>
                                                            <?php }} ?>
                                                    </div>
                                                <?php }else { ?>
                                                    <?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                                                        <div class="<?=$box_gorunum_hiddenprice_div?>"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text23']?></div>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>
                                            <?php if($urun['stok'] <= '0' ) {?>
                                                <div class="<?= $box_gorunum_price_div ?>" >
                                                    <div class="cat-detail-products-box-fiyat-out button-red button-1x" style="width: 100%; text-align: center;">
                                                        <?=$diller['urun-detay-stok-durum-yok']?>
                                                    </div>
                                                </div>
                                            <?php }?>

                                            <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '2') { ?>
                                                <?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?>
                                                    <div class="cat-detail-products-box-cart-2">

                                                        <?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $urun['stok'] > '0') { ?>


                                                            <?php if($urun['fiyat_goster'] == '1' ) {?>
                                                                <?php if($urun['siparis_islem'] == '0'  ) {?>
                                                                    <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                                        <button data-toggle="modal" data-target="#varyantModal"><?=$diller['urun-box-text1']?></button>
                                                                    <?php }else { ?>
                                                                        <form action="addtocart" method="post" >
                                                                            <input name="product_code" type="hidden" value="<?php echo $urun["id"]; ?>">
                                                                            <input name="token" type="hidden" value="<?=md5('searchCallBack')?>">
                                                                            <input name="actualCheck" type="hidden" value="<?=$parseParts['query']?>">
                                                                            <input name="quantity" type="hidden" value="1">
                                                                            <button name="addtocart" >
                                                                                <?=$diller['urun-box-text1']?>
                                                                            </button>
                                                                        </form>
                                                                    <?php }} ?>
                                                            <?php } ?>

                                                            <?php if($urun['fiyat_goster'] == '2' ) {?>
                                                                <?php if($userSorgusu->rowCount()>'0' ) {?>
                                                                    <?php if($urun['siparis_islem'] == '0'  ) {?>
                                                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                                            <button data-toggle="modal" data-target="#varyantModal"><?=$diller['urun-box-text1']?></button>
                                                                        <?php }else { ?>
                                                                            <form action="addtocart" method="post" >
                                                                                <input name="product_code" type="hidden" value="<?php echo $urun["id"]; ?>">
                                                                                <input name="token" type="hidden" value="<?=md5('searchCallBack')?>">
                                                                                <input name="actualCheck" type="hidden" value="<?=$parseParts['query']?>">
                                                                                <input name="quantity" type="hidden" value="1">
                                                                                <button name="addtocart" >
                                                                                    <?=$diller['urun-box-text1']?>
                                                                                </button>
                                                                            </form>
                                                                        <?php } ?>
                                                                    <?php }?>
                                                                <?php }?>
                                                            <?php } ?>

                                                            <?php if($urun['fiyat_goster'] == '3' ) {?>
                                                                <?php if($uyegruplariCek->rowCount()>'0' ) {?>
                                                                    <?php if($urun['siparis_islem'] == '0'  ) {?>
                                                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                                            <button data-toggle="modal" data-target="#varyantModal"><?=$diller['urun-box-text1']?></button>
                                                                        <?php }else { ?>
                                                                            <form action="addtocart" method="post" >
                                                                                <input name="product_code" type="hidden" value="<?php echo $urun["id"]; ?>">
                                                                                <input name="token" type="hidden" value="<?=md5('searchCallBack')?>">
                                                                                <input name="actualCheck" type="hidden" value="<?=$parseParts['query']?>">
                                                                                <input name="quantity" type="hidden" value="1">
                                                                                <button name="addtocart" >
                                                                                    <?=$diller['urun-box-text1']?>
                                                                                </button>
                                                                            </form>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>


                                                        <?php if ($urunKutuRow['kutu_fav_button'] == '1') { ?>
                                                            <?php if($uyeayar['durum'] == '1' && $uyeayar['favori_alani'] == '1' ) {?>
                                                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                                                    <?php
                                                                    $favCek = $db->prepare("select * from urun_favori where urun_id=:urun_id ");
                                                                    $favCek->execute(array(
                                                                        'urun_id' => $urun['id']
                                                                    ));
                                                                    $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                                                    ?>
                                                                    <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                                                        <a href="#" class="tooltip-bottom product-fav-del" data-code="<?php echo $urun['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" >
                                                                            <i class="fa fa-heart"></i>
                                                                        </a>
                                                                    <?php }else { ?>
                                                                        <a href="#" class="tooltip-bottom product-fav-go compare-href" data-code="<?php echo $urun['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>">
                                                                            <i class="fa fa-heart-o"></i>
                                                                        </a>
                                                                    <?php }?>
                                                                <?php } else { ?>
                                                                    <a href="" data-toggle="modal" data-target="#loginModal" class="compare-href tooltip-bottom" data-tooltip="<?=$diller['urun-box-text2']?>">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                <?php }?>
                                                            <?php } ?>
                                                        <?php } ?>


                                                        <?php if ($urunKutuRow['kutu_compare_button'] == '1' && $odemeayar['urun_karsilastirma'] == '1') { ?>
                                                            <?php if(isset($_SESSION['compare_product'][$urun['id']] )) {?>
                                                                <a href="#" class=" tooltip-bottom product-compare-exit" data-code="<?php echo $urun['id']; ?>" data-tooltip="<?=$diller['urun-box-text8']?>">
                                                                    <i class="fa fa-random"></i>
                                                                </a>
                                                            <?php }else { ?>
                                                                <a href="#" class="compare-href tooltip-bottom product-compare" data-code="<?php echo $urun['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>">
                                                                    <i class="fa fa-random"></i>
                                                                </a>
                                                            <?php }?>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>

                                    <?php }?>



                                <?php }else { ?>
                                    <div class="category-detail-no-product-alert">
                                        <i class="ion-alert-circled"></i> <?=$diller['kategori-detay-text21']?>
                                    </div>
                                <?php }?>


                            </div>
                            <!--  <========SON=========>>> Ürünler SON !-->

                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($TotalData > $Limit  ) {?>
                                <div class="category-pagination-out">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-sm <?php if($islemayar['sayfalama_hiza'] == '1' ) { ?>justify-content-center<?php }?><?php if($islemayar['sayfalama_hiza'] == '2' ) { ?>justify-content-end<?php }?>">
                                            <?php if($Sayfa > 1){?>
                                                <li class="page-item"><a class="page-link" href="<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$sayfalamaParsel?>&p=1"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item"><a class="page-link" href="<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$sayfalamaParsel?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active" aria-current="page">
                                                        <a class="page-link" href="<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$sayfalamaParsel?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                <?php }else{?>
                                                    <li class="page-item"><a class="page-link" href="<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$sayfalamaParsel?>&p=<?=$i?>"><?=$i?></a></li>
                                                <?php }}}?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$sayfalamaParsel?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="<?=$browser_link?><?php if(!isset($_GET['s'])) { ?>?s=1<?php }else{?>?<?php } ?><?=$sayfalamaParsel?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                </div>
                            <?php }?>
                            <!---- Sayfalama Elementleri ================== !-->


                        </div>
                        <!--  <========SON=========>>> Products Area SON !-->
                    </div> </div>
            <?php }?>
        <?php }?>
    <?php }?>

    <!-- CONTENT AREA ============== !-->


    <?php include 'includes/template/footer.php' ?>
    </body>
    </html>
    <script src="assets/js/niceselect/jquery.nice-select.min.js"></script>
    <?php include "includes/config/footer_libs.php"; ?>
    <script>
        $(document).ready(function () {
            $('.select').niceSelect();
        });
        $(function(){
            $('#dynamic_select').on('change', function () {
                var url = $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            });
        });
    </script>

    <!-- Ürün Eklendi Modal 1 !-->
    <?php if($_SESSION['addtocart'] == 'success' || $_SESSION['addtocart'] == 'modalsuccess'   ) {?>
        <div class="modal fade" id="successCart" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
                        <?=$diller['urun-sepete-eklendi']?>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  style=" " data-dismiss="modal"><?=$diller['sepet-alisverise-devam']?></button>
                        <a href="sepet/" class="button-2x button-black-out" style="width: 100%; text-align: center;text-transform: uppercase; "><i class="fa fa-shopping-bag"></i> <?=$diller['header-sepete-git-yazisi']?></a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(window).on("load", function() {
                $('#successCart').modal('show');
            });
            $(window).load(function () {
                $('#successCart').modal('show');
            });
            var $modalDialog = $("#successCart");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['addtocart'] ) ?>
    <?php }?>
    <!-- Ürün Eklendi Modal 1 SON !-->

    <!-- Boş alan uyarısı !-->
    <?php if($_SESSION['addtocart'] == 'empty'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-bos-alan']?>
                        </div>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(window).on("load", function() {
                $('#noArea').modal('show');
            });
            $(window).load(function () {
                $('#noArea').modal('show');
            });
            var $modalDialog = $("#noArea");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['addtocart'] ) ?>
    <?php }?>
    <!-- Boş alan uyarısı SON !-->

    <!-- Stok yok !-->
    <?php if($_SESSION['addtocart'] == 'nostok'  ) {?>
        <div class="modal fade" id="noStok" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-yetersiz-stok']?></div>
                        <div>
                            <?=$diller['urun-yetersiz-stok-aciklama']?>
                        </div>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(window).on("load", function() {
                $('#noStok').modal('show');
            });
            $(window).load(function () {
                $('#noStok').modal('show');
            });
            var $modalDialog = $("#noStok");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['addtocart'] ) ?>
    <?php }?>
    <!-- Stok yok SON !-->

    <!-- Stok aşılmış !-->
    <?php if($_SESSION['addtocart'] == 'nomorestok'  ) {?>
        <div class="modal fade" id="noStok" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-stok-asma-baslik']?></div>
                        <div>
                            <?=$diller['urun-stok-asma']?>
                        </div>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(window).on("load", function() {
                $('#noStok').modal('show');
            });
            $(window).load(function () {
                $('#noStok').modal('show');
            });
            var $modalDialog = $("#noStok");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['addtocart'] ) ?>
    <?php }?>
    <!-- Stok aşılmış SON !-->

    <!-- varyant Sepet Uyarısı !-->
    <div class="modal fade" id="varyantModal" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['kategori-detay-text28']?></div>
                    <div>
                        <?=$diller['kategori-detay-text29']?>
                    </div>
                    <div style="font-size: 12px; margin-top: 20px; line-height: 15px!important; color: #666;">
                        <?=$diller['kategori-detay-text32']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <!--  <========SON=========>>> varyant Sepet Uyarısı SON !-->

    <!-- Favoriler Login Uyarısı !-->
    <div class="modal fade" id="loginModal"  >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-locked" style="font-size: 45px ; color: #558cff;"></i><br>
                    <?=$diller['kategori-detay-text31']?>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <a href="uye-girisi/" class="button-2x button-blue" style="width: 100%; text-align: center; text-transform: uppercase;"><?=$diller['kategori-detay-text37']?></a>
                </div>
            </div>
        </div>
    </div>
    <!--  <========SON=========>>> Favoriler Login Uyarısı SON !-->

    <?php if($_SESSION['compare_status'] == 'success'  ) {?>
        <!-- Karşılaştırma !-->
        <div class="modal fade" id="compareModal" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                        <?=$diller['urun-detay-karsilastirma-listeye-eklendi-text']?>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <a href="karsilastirmalar/" class="button-2x button-blue" style="width: 100%; text-align: center;   text-transform: uppercase;"><?=$diller['urun-detay-karsilastirma-listeye-git']?></a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(window).on("load", function() {
                $('#compareModal').modal('show');
            });
            $(window).load(function () {
                $('#compareModal').modal('show');
            });
            var $modalDialog = $("#compareModal");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['compare_status']); ?>
        <!--  <========SON=========>>> Karşılaştırma SON !-->
    <?php } ?>
    <?php if($_SESSION['favorite_status'] == 'success'  ) {?>
        <!-- Favorilere eklendi !-->
        <div class="modal fade" id="favModal" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-heart" style="font-size: 60px ; color: #f7acaa;"></i><br>
                        <?=$diller['urun-detay-favori-listeye-eklendi-text']?>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <a href="hesabim/favoriler/" class="button-2x button-pink" style=" width: 100%; text-align: center;   text-transform: uppercase;"><?=$diller['urun-detay-favori-listeye-git']?></a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(window).on("load", function() {
                $('#favModal').modal('show');
            });
            $(window).load(function () {
                $('#favModal').modal('show');
            });
            var $modalDialog = $("#favModal");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['favorite_status']); ?>
        <!--  <========SON=========>>> Favorilere eklendi SON !-->
    <?php } ?>
<?php }?>
