<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$id = htmlspecialchars(trim($_GET['p_id']));
$icerikCek = $db->prepare("select * from urun where dil=:dil and id=:id and durum=:durum and seo_url=:seo_url ");
$icerikCek->execute(array(
    'dil' => $_SESSION['dil'] ,
    'id' => $id,
    'durum' => '1',
    'seo_url' => $_GET['seo_url'],
));
$icerik = $icerikCek->fetch(PDO::FETCH_ASSOC);

/* Ürünün Fiyatı */
if($userSorgusu->rowCount()>'0'  ) {
    if($uyegruplariCek->rowCount()>'0') {
        if($uyegrup['fiyat_tip'] == '0' ) {
            $urunFiyat = $icerik['fiyat'];
            $urunOzelFiyat= '0';
        }else{
            if($icerik['fiyat_tip2'] == !null && $icerik['fiyat_tip2'] > '0' ) {
                $urunFiyat = $icerik['fiyat_tip2'];
                $urunOzelFiyat= '1';
            }else{
                $urunFiyat = $icerik['fiyat'];
                $urunOzelFiyat= '0';
            }
        }
    }else{
        $urunFiyat = $icerik['fiyat'];
        $urunOzelFiyat= '0';
    }
}else{
   $urunFiyat = $icerik['fiyat'];
   $urunOzelFiyat= '0';
}
/*  <========SON=========>>> Ürünün Fiyatı SON */

$urun_galeri = $db->prepare("select * from urun_galeri where urun_id=:urun_id order by sira asc limit 1");
$urun_galeri->execute(array(
    'urun_id' => $icerik['id']
));

$markaCek = $db->prepare("select * from urun_marka where id=:id and durum=:durum ");
$markaCek->execute(array(
    'id' => $icerik['marka'],
    'durum' => '1'
));
$marka = $markaCek->fetch(PDO::FETCH_ASSOC);

$urun_galeri2 = $db->prepare("select * from urun_galeri where urun_id=:urun_id order by sira asc limit 1,999");
$urun_galeri2->execute(array(
    'urun_id' => $icerik['id']
));

$urungaleri_sayisi = $db->prepare("select * from urun_galeri where urun_id=:urun_id ");
$urungaleri_sayisi->execute(array(
    'urun_id' => $icerik['id']
));

$urunHits = $db->prepare("UPDATE urun SET hit = hit+1 WHERE id='$id'  ");
$urunHits->execute();



$islemlerAyar = $db->prepare("select * from urun_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='urundetay' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);

$starDec = $db->prepare("SELECT SUM(yildiz) AS orta FROM urun_yorum where onay=:onay and urun_id=:urun_id; ");
$starDec->execute(array(
    'onay' => '1',
    'urun_id' => $icerik['id']
));
$yildiz = $starDec->fetch(PDO::FETCH_ASSOC);

$yorumsayisi = $db->prepare("select * from urun_yorum where onay=:onay and urun_id=:urun_id ");
$yorumsayisi->execute(array(
    'onay' => '1',
    'urun_id' => $icerik['id']
));
$yorumcount = $yorumsayisi->rowCount();

if($yorumcount == null  ) {
    $yildizhesap = '0';
} else {
    $yildizhesap = $yildiz['orta'] / $yorumcount;
}
$finalstarrate = (int)$yildizhesap;

/* Varyant Sorgusu ///////////////////////////////////////////*/
$varyantSorgu = $db->prepare("select * from detay_varyant where urun_id=:urun_id order by sira asc ");
$varyantSorgu->execute(array(
    'urun_id' => $icerik['id']
));
/* Varyant Sorgusu SON ///////////////////////////////////////////*/

/* Özellik Grubu  */
$ozellikGrubuCek = $db->prepare("select * from filtre_ozellik_grup where urun_id=:urun_id and dil=:dil and durum=:durum group by baslik order by sira asc ");
$ozellikGrubuCek->execute(array(
        'urun_id' => $icerik['id'],
        'dil' => $_SESSION['dil'],
        'durum' => '1'
));
/*  <========SON=========>>> Özellik Grubu  SON */

/* Seo Başlık */
if($icerik['seo_baslik'] == !null ) {
    $baslik = $icerik['seo_baslik'];
}else{
    $baslik = $icerik['baslik'];
}
/*  <========SON=========>>> Seo Başlık SON */

?>
<?php if($icerikCek->rowCount() <= '0'  ) {?>
    <?php header('Location:'.$siteurl.'404'); ?>
<?php }else { ?>
    <?php
    $_SESSION['urun_id_kaydet'] = $icerik['id'];
    $urunseobaslik = seo($icerik["baslik"]);
    $_SESSION['geridonus_url_kaydet'] = "".$siteurl."".$icerik['seo_url']."-P".$icerik['id']."";
    $_SESSION['geridonus_url_kaydet_comment'] = "".$siteurl."".$icerik['seo_url']."-P".$icerik['id']."";
    $_SESSION['geridonus_url_kaydet_urun'] = "".$siteurl."".$icerik['seo_url']."-P".$icerik['id']."";
    ?>
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



    <div class="urun-detay-main" style="overflow: hidden" >
        <?php if($pagehead['durum'] == '1'  ) {?>
            <div class="page-banner-main" >
                <div class="page-banner-in-text">
                    <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                        <?=$diller['altsayfa-urundetay-title']?>
                    </div>
                    <div class="page-banner-links ">
                        <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                        <span>/</span>
                        <a href="javascript:Void(0)"><?=$diller['altsayfa-urundetay-title']?></a>
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
        <div class="urun-detay-main-in">

            <div class="urun-detay-sol-alan">

                <!-- Ürün Görselleri ve Galeri !-->
                <?php include 'includes/template/helper/product_detail/gallery.php'; ?>
                <!--  <========SON=========>>> Ürün Görselleri ve Galeri SON !-->

            </div>
            <div class="urun-detay-sag-alan" style="background-color: #fff; border: 1px solid #<?=$islemayar['detay_infobox_border']?>;">



                <div class="urun-detay-sag-alan-baslik">
                    <?=$icerik['baslik']?>
                </div>



                <?php if($icerik['iliskili_kat'] == !null  && $icerik['iliskili_kat'] > '0' ) {?>
                    <div class="urun-detay-sag-alan-iliskili-kat">
                        <?=urundetay_Kategori_Agaci($icerik);?>
                    </div>
                <?php }?>


                <div class="urun-detay-baslik-alti">
            
                    <?=urundetay_Star();?>


                    <!-- Sosyal Paylaşım Linkleri !-->
                    <div class="urun-detay-social">
                        <a href="https://www.facebook.com/sharer.php?u=<?=$_SESSION['geridonus_url_kaydet']?>" onClick="return popup(this, 'notes')"  ><i aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>" class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?=$_SESSION['geridonus_url_kaydet']?>" onClick="return popup(this, 'notes')" ><i class="fa fa-twitter" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>"></i></a>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?=$_SESSION['geridonus_url_kaydet']?>" onClick="return popup(this, 'notes')"><i class="fa fa-linkedin" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>"></i></a>
                        <a href="https://www.pinterest.com/pin/create/button/?url=<?=$_SESSION['geridonus_url_kaydet']?>&media=<?=$ayar['site_url']?>images/product/<?=$icerik['gorsel']?>&description=<?=$icerik['baslik']?>"  onClick="return popup(this, 'notes')"><i class="fa fa-pinterest-p" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>"></i></a>
                        <a href="https://api.whatsapp.com/send?text=<?=$icerik['baslik']?> <?=$_SESSION['geridonus_url_kaydet']?>" target="_blank"><i class="fa fa-whatsapp" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>"></i></a>
                    </div>
                    <!-- Sosyal Paylaşım Linkleri SON !-->


                </div>
                <?php if($islemayar['detay_marka_goster'] == '1'  ) {?>
                <?php if($icerik['marka'] == !null  && $icerik['marka'] >'0' ) {?>
                <div class="urun-detay-sag-alan-d-bilgiler-box" >
                    <?php if($islemayar['detay_marka_tip'] == '1' ) {?>
                        <a target="_blank" href="marka/<?=$marka['seo_url']?>/" data-toggle="tooltip" data-placement="right" title="<?=$diller['urun-detay-urun-markaya-git']?>" >
                            <img src="images/uploads/<?=$marka['gorsel']?>" alt="">
                        </a>
                    <?php }?>
                </div>
                <?php }?>
                <?php }?>
                <?php if($icerik['spot'] == !null  ) {?>
                <div class="urun-detay-sag-alan-spot">
                    <?=$icerik['spot']?>
                </div>
                <?php }?>
                <?php if($icerik['stok'] > '0' ) {?>
                <?php if($icerik['ek_aciklama1'] == !null  ) {?>
                <div class="urun-detay-sag-alan-no-stok" <?php if($icerik['marka'] == !null && $icerik['spot'] == null ) { ?>style="margin-top:10px ;"<?php }?>>
                    <i class="fa fa-info-circle"></i> <?=$icerik['ek_aciklama1']?>
                </div>
                <?php } ?>
                <?php } ?>
                <!-- Diğer Bilgiler !-->
                <?php if($islemayar['detay_stok_goster'] == '1' || $islemayar['detay_marka_goster'] == '1' || $islemayar['detay_urunkod_goster'] == '1') {?>
                <div class="urun-detay-sag-alan-d-bilgiler">

                    <?php if($islemayar['detay_urunkod_goster'] == '1'  ) {?>
                        <div class="urun-detay-sag-alan-d-bilgiler-box">
                            <?=$diller['urun-detay-urun-kodu']?> : <strong><?=$icerik['urun_kod']?></strong>
                        </div>
                    <?php }?>
                    <?php if($islemayar['detay_stok_goster'] == '1'  ) {?>
                        <div class="urun-detay-sag-alan-d-bilgiler-box">
                            <?=$diller['urun-detay-stok-durum']?> :

                            <?php if($icerik['stok'] > '0' ) {?>
                                <span style="color:var(--green); font-weight: 600;"><?=$diller['urun-detay-stok-durum-var']?></span>
                            <?php }else { ?>
                                <span style="color:var(--red); font-weight: 600;" ><?=$diller['urun-detay-stok-durum-yok']?></span>
                            <?php }?>
                        </div>
                    <?php }?>
                    <?php if($islemayar['detay_marka_goster'] == '1'  ) {?>
                        <?php if($icerik['marka'] == !null ) {?>
                            <div class="urun-detay-sag-alan-d-bilgiler-box">
                                <?php if($islemayar['detay_marka_tip'] == '0' ) {?>
                                    <?=$diller['urun-detay-urun-marka']?> :
                                    <a target="_blank" href="marka/<?=$marka['seo_url']?>/" style="color: #000;">
                                        <strong><?=$marka['baslik']?></strong>
                                    </a>
                                <?php }?>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
                <?php }?>
                <!-- Diğer Bilgiler SON !-->
                <?php if($icerik['stok'] <= '0' ) {?>
                <!-- No Stock !-->
                <div class="urun-detay-sag-alan-no-stok">
                    <i class="fa fa-info-circle"></i> <?=$diller['urun-detay-stok-yok-aciklama']?>
                </div>
                <!-- No Stock SON !-->
                <?php } ?>
                <!-- Stok varsa !-->
                <?php if($icerik['stok'] > '0' ) {?>
                <?php include 'includes/template/helper/product_detail/product-detail-fiyat-goster.php'; ?>
                <!-- Ürün Ek Detay Kutuları !-->
                <?php if($icerik['kargo'] == '0' || $icerik['kargo_sure'] == !null || $icerik['ek_aciklama2'] == !null ) {?>
                <div class="urun-detay-sag-alan-ek-bilgiler">
                    <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                        <?php if($icerik['kargo'] == '0' ) {?>
                            <div class="urun-detay-sag-alan-ek-bilgiler-box">
                                <i class="fa fa-gift"></i> <?=$diller['urun-detay-kargo-ucretsiz-yazisi']?>
                            </div>
                        <?php }?>
                    <?php }?>
                    <?php if($icerik['kargo_sure'] == !null  ) {?>
                        <div class="urun-detay-sag-alan-ek-bilgiler-box">
                            <i class="ion-calendar"></i> <?=$icerik['kargo_sure']?>
                        </div>
                    <?php }?>
                    <?php if($icerik['ek_aciklama2'] == !null  ) {?>
                        <div class="urun-detay-sag-alan-ek-bilgiler-box" style="flex:1; margin-right: 0;">
                            <i class="fa fa-info-circle"></i>  <?=$icerik['ek_aciklama2']?>
                        </div>
                    <?php }?>
                </div>
                <?php }?>
                <!-- Ürün Ek Detay Kutuları SON !-->
                <!-- Son ürünler Uyarısı !-->
                <?php if($icerik['fiyat_goster'] == '1' ) {?>
                <?php if($varyantSorgu->rowCount() <= '0'  ) {?>
                <?php if($icerik['stok'] > '0') {?>
                <?php if($icerik['stok'] <= $odemeayar['urun_stok_sinir']) {?>
                <div style="width: 100%; display: flex ; margin-top: 20px; ">
                    <div class="alert alert-danger" style="font-size: 13px; border:1px solid #DFB0B5; padding: 4px 15px; width: auto; margin: 0;  ">
                        <strong><?=$icerik['stok']?></strong> <?=$diller['urun-detay-stok-sinir-yazisi']?>
                    </div>
                </div>
                <?php } ?>
                <?php }?>
                <?php }?>
                <?php } ?>
                <?php if($icerik['fiyat_goster'] == '2' ) {?>
                <?php if($userSorgusu->rowCount()> '0'  ) {?>
                <?php if($varyantSorgu->rowCount() <= '0'  ) {?>
                <?php if($icerik['stok'] > '0') {?>
                <?php if($icerik['stok'] <= $odemeayar['urun_stok_sinir']) {?>
                <div style="width: 100%; display: flex; margin-top: 20px;  ">
                    <div class="alert alert-danger" style="font-size: 13px; border:1px solid #DFB0B5; padding: 4px 15px; width: auto; margin: 0;  ">
                        <strong><?=$icerik['stok']?></strong> <?=$diller['urun-detay-stok-sinir-yazisi']?>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php if($icerik['fiyat_goster'] == '3' ) {?>
                 <?php if($userSorgusu->rowCount()> '0' && $uyegruplariCek->rowCount()>'0'  ) {?>
                <?php if($varyantSorgu->rowCount() <= '0'  ) {?>
                <?php if($icerik['stok'] > '0') {?>
                <?php if($icerik['stok'] <= $odemeayar['urun_stok_sinir']) {?>
                <div style="width: 100%; display: flex; margin-top: 20px;  ">
                    <div class="alert alert-danger" style="font-size: 13px; border:1px solid #DFB0B5; padding: 4px 15px; width: auto; margin: 0;  ">
                        <strong><?=$icerik['stok']?></strong> <?=$diller['urun-detay-stok-sinir-yazisi']?>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
                <?php }?>
                <?php }?>
                <?php } ?>
                <!-- Son ürünler Uyarısı SON !-->
                <?php include 'includes/template/helper/product_detail/product-detail-sepete-ekle.php'; ?>
            <?php }?>
                <!-- Stok varsa SON !-->
                
                <!-- Favorites and compare !-->
                <?php if($uyeayar['favori_alani'] == '1' ||  $odemeayar['urun_karsilastirma'] == '1') {?>
                    <div class="urun-detay-sag-alan-urun-islemler-main" <?php if($icerik['stok'] <= '0'  ) { ?>style="margin-top: 12px;" <?php }?>>
                        <?php if($uyeayar['favori_alani'] == '1'  ) {?>
                            <?php if($userSorgusu->rowCount() > '0'  ) {?>
                                <?php
                                $favCek = $db->prepare("select * from urun_favori where urun_id=:urun_id ");
                                $favCek->execute(array(
                                    'urun_id' => $icerik['id']
                                ));
                                $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                    <a href="#" class="product-fav-del fav-b" data-code="<?php echo $icerik['id']; ?>" >
                                        <i class="fa fa-heart" ></i> <span ><?=$diller['urun-detay-favori-buton-cikar']?></span>
                                    </a>
                                <?php }else { ?>
                                    <a href="#" class="product-fav-go fav-a" data-code="<?php echo $icerik['id']; ?>" >
                                        <i class="fa fa-heart-o" ></i> <span ><?=$diller['urun-detay-favori-buton']?></span>
                                    </a>
                                <?php }?>
                            <?php } else { ?>
                                <a href="" class="fav-a" data-toggle="modal" data-target="#favModal">
                                    <i class="fa fa-heart-o" ></i> <span ><?=$diller['urun-detay-favori-buton']?></span>
                                </a>
                            <?php }?>
                        <?php }?>

                        <?php if($odemeayar['urun_karsilastirma'] == '1'  ) {?>
                            <?php if(isset($_SESSION['compare_product'][$icerik['id']] )) {?>
                                <a href="#" class="karsilastir-product-exit product-compare-exit" data-code="<?php echo $icerik['id']; ?>" >
                                    <i class="fa fa-random" ></i> <span ><?=$diller['urun-detay-karsilastirma-cikar']?></span>
                                </a>
                                <a href="karsilastirmalar" class="karsilastir-product"  >
                                    <i class="fa fa-list" ></i> <span ><?=$diller['urun-detay-karsilastirma-listeye-git']?></span>
                                </a>
                            <?php }else { ?>
                                <a href="#" class="karsilastir-product product-compare" data-code="<?php echo $icerik['id']; ?>" >
                                    <i class="fa fa-random" ></i> <span ><?=$diller['urun-detay-karsilastirma']?></span>
                                </a>
                            <?php }?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!--  <========SON=========>>> Favorites and compare SON !-->
        </div>
    </div>
    <!-- Yorumlar ile alakalı modal ve alert kodları SON !-->
    <?php include 'includes/template/helper/product_detail/product-detail-modals.php'; ?>
    <!-- Yorumlar ile alakalı modal ve alert kodları SON !-->
    <div class="urun-detay-desc-main" style="margin-top: 0;" >

        <div id="tabs-comments"></div>
        <div id="tabs-taksitler"></div>

        <?php if( $icerik['icerik'] == !null || $icerik['ek_tabs'] == !null ||  $icerik['yorum_durum'] > '0' || $icerik['ozellik_tab_durum'] == '1' || $icerik['taksit'] == '1' || $icerik['embed'] == !null || $icerik['katalog'] > '0') {?>
        <div id="urundetaytabs">
            <ul>
                <?php if($icerik['icerik'] == !null ) {?>
                <li><a href="<?=$mevcut_adresi_cek?>#tabs-aciklama" ><?=$diller['urun-detay-aciklama-tab']?></a></li>
                <?php } ?>

                <!-- Ürün Özellikleri TAB !-->
                <?php if( $ozellikGrubuCek->rowCount()>'0' ) {?>
                    <?php if($icerik['ozellik_tab_durum'] == '1' ) {?>
                        <li><a href="<?=$mevcut_adresi_cek?>#tabs-features" ><?=$diller['urun-detay-ozellikler-tab']?></a></li>
                    <?php }?>
                <?php }?>
                <!--  <========SON=========>>> Ürün Özellikleri TAB SON !-->


                <?php if($icerik['ek_tabs'] == !null ) {?>
                    <li><a href="<?=$mevcut_adresi_cek?>#tabs-ekstra" ><?=$icerik['ek_tabs_baslik']?></a></li>
                <?php }?>

                <?php if($icerik['yorum_durum'] == '1' ) {?>
                    <?php if($uyeayar['durum'] == '1' ) {?>
                        <li ><a href="<?=$mevcut_adresi_cek?>#tabs-comments"  ><?=$diller['urun-detay-yorumlar-tab']?> (<?=$yorumcount?>)</a></li>
                    <?php }}?>

                <!-- Taksit TAB Başlık Herkese Açık !-->
                <?php if($icerik['fiyat_goster'] == '1' && $icerik['stok']>'0'  ) {?>
                    <?php if($icerik['taksit'] == '1' ) {?>
                        <li><a href="<?=$mevcut_adresi_cek?>#tabs-taksitler" ><?=$diller['urun-detay-taksitler-tab']?></a></li>
                    <?php }?>
                <?php }?>
                <!-- Taksit TAB Başlık Herkese Açık !-->

                <!-- Taksit TAB Başlık Üyelere Açık !-->
                <?php if($icerik['fiyat_goster'] == '2' && $icerik['stok']>'0'  ) {
                    if($userSorgusu->rowCount()>'0'  ) {
                    ?>
                    <?php if($icerik['taksit'] == '1' ) {?>
                        <li><a href="<?=$mevcut_adresi_cek?>#tabs-taksitler" ><?=$diller['urun-detay-taksitler-tab']?></a></li>
                    <?php }?>
                <?php }}?>
                <!-- Taksit TAB Başlık Üyelere Açık !-->

                <!-- Taksit TAB Başlık Üyelere Açık !-->
                <?php if($icerik['fiyat_goster'] == '3' && $icerik['stok']>'0'  ) {
                    if($uyegruplariCek->rowCount()>'0'  ) {
                        ?>
                        <?php if($icerik['taksit'] == '1' ) {?>
                            <li><a href="<?=$mevcut_adresi_cek?>#tabs-taksitler" ><?=$diller['urun-detay-taksitler-tab']?></a></li>
                        <?php }?>
                    <?php }}?>
                <!-- Taksit TAB Başlık Üyelere Açık !-->


                <?php if($icerik['embed'] == !null ) {?>
                    <li><a href="<?=$mevcut_adresi_cek?>#tabs-video"><i class="fa fa-video-camera" style="margin-right: 5px"></i> <?=$diller['urun-detay-video-tab']?></a></li>
                <?php }?>

                <?php if($icerik['katalog'] == !null ) {?>
                    <li><a href="<?=$mevcut_adresi_cek?>#tabs-katalog"><i class="fa fa-file-pdf-o" style="margin-right: 5px"></i> <?=$diller['urun-detay-katalog-tab']?></a></li>
                <?php }?>

            </ul>
            <div id="tabs-aciklama" >
                <?php
                $urunaciklama  = $icerik['icerik'];
                $eski   = "../images";
                $yeni   = "images";
                $urunaciklama = str_replace($eski, $yeni, $urunaciklama);
                ?>
                <?=$urunaciklama?>
            </div>
            <?php if( $ozellikGrubuCek->rowCount()>'0' ) {?>
            <?php if($icerik['ozellik_tab_durum'] == '1' ) { ?>
                <div id="tabs-features">
                <?php foreach ($ozellikGrubuCek as $ozellikgrubu)  {
                    $ozellikCek = $db->prepare("select * from filtre_ozellik where grup_id=:grup_id and urun_id=:urun_id  order by sira asc");
                    $ozellikCek->execute(array(
                            'grup_id' => $ozellikgrubu['real_grup_id'],
                            'urun_id' => $icerik['id']
                    ));
                    ?>
                    <div class="product-detail-features-table">
                        <div class="product-detail-features-table-left">
                            <?=$ozellikgrubu['baslik']?>
                        </div>
                        <div class="product-detail-features-table-dots">
                            :
                        </div>
                        <div class="product-detail-features-table-right">
                            <?php foreach ($ozellikCek as $ozellik) {?>
                                <?php if($ozellikCek->rowCount()== '1'  ) {?>
                                    <?=$ozellik['baslik']?>
                                <?php }?>
                                <?php if($ozellikCek->rowCount()> '1'  ) {?>
                                   <i class="fa fa-caret-right"></i> <?=$ozellik['baslik']?> <span style="display: block; margin-right: 20px;"></span>
                                <?php }?>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>
                </div>
            <?php }} ?>

            <?php if($icerik['ek_tabs'] == !null ) {?>
                <div id="tabs-ekstra" >
                    <?=$icerik['ek_tabs']?>
                </div>
            <?php }?>

            <?php if($icerik['yorum_durum'] == '1' ) {?>
                <?php if($uyeayar['durum'] == '1' ) {?>
                    <div id="tabs-comments"  >
                        <div class="product-comment-head">
                            <div class="product-comment-head-1">

                                <div class="product-comment-head-1-h">
                                    <?=$diller['urun-detay-yorum-yapin-yazisi']?>
                                </div>
                                <?php if($userSorgusu->rowCount() > 0  ) {?>
                                    <div class="product-comment-head-1-s">
                                        <?=$diller['urun-detay-yorum-bilgi-yazisi']?>
                                    </div>
                                    <div class="product-comment-head-1-btn">
                                        <a class="<?=$islemayar['detay_yorumyap_button']?>" href="" data-toggle="modal" data-target="#AddCommentUser"><i class="fa fa-comment"></i> <?=$diller['urun-detay-yorum-yap-button-yazisi']?></a>
                                    </div>
                                <?php } else { ?>
                                    <div class="product-comment-head-1-s">
                                        <?=$diller['urun-detay-yorum-uyelik-uyarisi']?>
                                    </div>
                                    <div class="product-comment-head-1-btn">
                                        <a class="<?=$islemayar['detay_yorumyap_button']?>" href=""  data-toggle="modal" data-target="#LoginModal"><?=$diller['urun-detay-yorum-uyelik-button-yazisi']?></a>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="product-comment-head-2">
                                <div class="product-comment-head-2-img">
                                    <img src="images/product/<?=$icerik['gorsel']?>" >
                                </div>
                                <div class="product-comment-head-2-ot">
                                    <div class="product-comment-head-2-ot-1">
                                        <?=$yorumcount ?> <?=$diller['urun-detay-toplam-yorum-degerlendirme-yazisi']?>
                                    </div>
                                    <?php if($yorumcount > '0'  ) {?>
                                        <div class="product-comment-head-2-ot-2">
                                            <?=$diller['urun-detay-yorum-ortalama-yazisi']?>
                                        </div>
                                        <div class="product-comment-head-2-ot-3">
                                            <?php echo $yildizhesapfinal = substr($yildizhesap,0,3); ?>
                                        </div>
                                    <?php }else { ?>
                                        <div class="product-comment-head-2-ot-2">
                                            <?=$diller['urun-detay-degerlendirme-yok']?>
                                        </div>
                                    <?php }?>
                                    <div class="product-comment-head-2-ot-4">
                                        <?php if($finalstarrate == '0'){ ?>
                                            <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                        <?php }?>
                                        <?php if($finalstarrate == '1'){ ?>
                                            <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                        <?php }?>
                                        <?php if($finalstarrate == '2'){ ?>
                                            <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                        <?php }?>
                                        <?php if($finalstarrate == '3'){ ?>
                                            <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                        <?php }?>
                                        <?php if($finalstarrate == '4'){ ?>
                                            <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                                        <?php }?>
                                        <?php if($finalstarrate == '5'){ ?>
                                            <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <!-- Yorumlar Burada !-->
                        <div class="product-comment-head-content-main">
                            <?php

                            $yorumSayisi = $db->prepare("select * from urun_yorum where urun_id=:urun_id and onay=:onay ");
                            $yorumSayisi->execute(array(
                                'urun_id' => $icerik['id'],
                                'onay' => '1'
                            ));


                            $UrunyorumListele = $db->prepare("select * from urun_yorum where urun_id=:urun_id and onay=:onay order by id desc limit 5");
                            $UrunyorumListele->execute(array(
                                'urun_id' => $icerik['id'],
                                'onay' => '1'
                            ));

                            ?>
                            <?php foreach ($UrunyorumListele as $yor) {
                                $postID = 	$yor['id'];
                                $shortname = mb_substr($yor['isim'], 0, 1,'UTF-8');
                                ?>
                                <div class="product-comment-head-content-box-out">
                                    <div class="product-comment-head-content-box">
                                        <div class="product-comment-head-content-box-name-rad <?=$islemayar['detay_yorum_oval_bg']?>">
                                            <?=$shortname?>
                                        </div>
                                        <div class="product-comment-head-content-box-in">
                                            <div class="product-comment-head-content-box-in-1">
                                                <div class="product-comment-head-content-box-in-1-name">
                                                    <?php if($yor['gizli']  == 1 ) {?>
                                                        <?php
                                                        $gizliisim = mb_substr($yor['isim'],0,2,'UTF-8');
                                                        $gizlisoyisim = mb_substr($yor['soyisim'],0,2,'UTF-8');
                                                        ?>
                                                        <?=$gizliisim ?>**** <?=$gizlisoyisim ?>****
                                                    <?php }else { ?>
                                                        <?=$yor['isim']?> <?=$yor['soyisim']?>
                                                    <?php }?>
                                                </div>
                                                <div class="product-comment-head-content-box-in-1-date">
                                                    <?php echo date_tr('j F Y, l ', ''.$yor['tarih'].''); ?>
                                                </div>
                                            </div>
                                            <div class="product-comment-head-content-box-in-2">
                                                <?php echo trim(strip_tags($yor['baslik']))?>
                                            </div>
                                            <div class="product-comment-head-content-box-in-3">
                                                <?php if($yor['yildiz'] == 0){ ?>
                                                    <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($yor['yildiz'] == 1){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($yor['yildiz'] == 2){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($yor['yildiz'] == 3){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($yor['yildiz'] == 4){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                                                <?php }?>
                                                <?php if($yor['yildiz'] == 5){ ?>
                                                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                                                <?php }?>
                                            </div>
                                            <div class="product-comment-head-content-box-in-4">
                                                <?php echo trim(strip_tags($yor['yorum']))?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($yorumSayisi->rowCount()>'5'  ) {?>
                                <div class="urundetay-show-more-button " id="urundetay-show-more-button<?php echo $postID; ?>">
                                    <span id="<?php echo $postID; ?>" data-id="<?=$icerik['id']?>" class="urundetay-showmorespan <?=$islemayar['detay_more_comment_button']?>" >+ <?=$diller['urun-detay-daha-fazla-yorum-goster']?></span>
                                    <span class="urundetay_loding" style="display: none;"><span class="urundetay_loding_txt">Loading...</span></span>
                                </div>
                            <?php }?>
                        </div>
                      <!--  <========SON=========>>> Yorumlar Burada SON !-->

                    </div>
                <?php }}?>
            <?php include 'includes/template/helper/product_detail/product-detail-taksit-tab.php'; ?>
            <?php if($icerik['embed'] == !null ) {?>
                <div id="tabs-video" >
                    <iframe src="https://www.youtube.com/embed/<?=$icerik['embed']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            <?php }?>
            <?php if($icerik['katalog'] == !null && $icerik['katalog'] >'0') {
                $katalogcek = $db->prepare("select * from katalog where id=:id ");
                $katalogcek->execute(array(
                    'id' => $icerik['katalog']
                ));
                $katalogs = $katalogcek->fetch(PDO::FETCH_ASSOC);

                ?>
                <div id="tabs-katalog" >
                    <object data="assets/uploads/<?=$katalogs['url']?>" type="application/pdf" width="100%" height="650"></object>
                </div>
            <?php }?>
        </div>
        <?php }?>
        <!-- Benzer Ürünler !-->
            <?php include 'includes/template/helper/product_detail/product-detail-benzerler.php';  ?>
        <!-- Benzer Ürünler SON !-->
    </div>
    </div>
    <!-- CONTENT AREA ============== !-->
    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
    <?php include "includes/config/footer_libs.php";?>
<?php } ?>

<?php
//todo bu sayfada ilginçlik var
?>
