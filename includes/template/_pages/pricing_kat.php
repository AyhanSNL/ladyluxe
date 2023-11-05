<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$seoURL = htmlspecialchars($_GET['seo_url']);
if(strip_tags(htmlspecialchars($_GET['seo_url'])) != $_GET['seo_url']  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}
$tabloKategoriSql = $db->prepare("select * from pricing_kat where durum=:durum and seo_url=:seo_url ");
$tabloKategoriSql->execute(array(
        'durum' => '1',
        'seo_url' => $seoURL
));

if($tabloKategoriSql->rowCount()>'0'  ) {


}else{
    header('Location:'.$ayar['site_url'].'404');
    exit();
}
$katRow = $tabloKategoriSql->fetch(PDO::FETCH_ASSOC);

$pricing_liste = $db->prepare("select * from pricing where durum=:durum and dil=:dil and kat_id=:kat_id order by sira asc");
$pricing_liste->execute(array(
    'durum' => '1',
    'dil' => $_SESSION['dil'],
    'kat_id' => $katRow['id']
));

$islemlerAyar = $db->prepare("select baslik_font,detay_bg from pricing_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='pricing' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$katRow['baslik']?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$katRow[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$katRow[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$katRow[tags]" ?>">
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
<div class="tablolar_ana_div" style="font-family : '<?=$islemayar['baslik_font']?>',sans-serif ; background-color: #<?=$islemayar['detay_bg']?>; overflow: hidden">
    <?php if($pagehead['durum'] == '1' ) {?>
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?=$katRow['baslik']?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a href="paketler/">
                        <?php echo ucwords_tr($diller['anasayfa-paketler-baslik']); ?>
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
    <div class="tablolar-container-main">
        <div class="ptable-box-main-div">
        <?php if($pricing_liste->rowCount()>'0'  ) {?>
            <?php foreach ($pricing_liste as $tablo){
                $tablo_ozellik = $db->prepare("select * from pricing_ozellik where pr_id=:pr_id and dil=:dil order by sira asc ");
                $tablo_ozellik->execute(array(
                    'pr_id' => $tablo['id'],
                    'dil' => $_SESSION['dil']
                ));
                if($tablo['url_tur'] == '1' ) {
                    /* Ürün varmı */
                    $urunKontrol = $db->prepare("select id,fiyat_goster from urun where id=:id and durum=:durum and siparis_islem=:siparis_islem");
                    $urunKontrol->execute(array(
                        'id' => $tablo['urun_id'],
                        'durum' => '1',
                        'siparis_islem' => '0'
                    ));
                    $tabloUrun = $urunKontrol->fetch(PDO::FETCH_ASSOC);

                    $varyantKontrolTablo = $db->prepare("select * from detay_varyant where urun_id=:urun_id ");
                    $varyantKontrolTablo->execute(array(
                        'urun_id' => $tablo['urun_id']
                    ));
                    /*  <========SON=========>>> Ürün varmı SON */
                }
                ?>
                <div class="ptable-box" style="background-color: #<?=$tablo['kutu_arkaplan']?>;<?php if($tablo['tavsiye'] == '1') { ?>border: 2px solid #<?=$tablo['tavsiye_renk']?>;<?php }else{?>border-bottom: 1px solid rgba(0,0,0,0.1);<?php }?>">
                    <div class="ptable-box-img" style=" <?php if($tablo['fiyat'] == null && $tablo['fiyat'] == '0' && $tablo['odeme_sure'] == null  ) { ?>justify-content: center;<?php }?> ">
                        <?php if($tablo['tavsiye'] == '1'  ) {?>
                            <div class="ptable-tavsiye-main" >
                                <div class="ptable-header-tavsiye lspacsmall" style="background-color: #<?=$tablo['tavsiye_renk']?>; color: #<?=$tablo['tavsiye_yazi_renk']?>;">
                                    <?=$diller['anasayfa-paketler-tavsiye']?>
                                </div>
                            </div>
                        <?php }?>
                        <div class="ptable-header" style="color: #<?=$tablo['kutu_baslik_renk']?>;">
                            <?=$tablo['baslik']?>
                        </div>
                        <?php if($tablo['baslik_kat'] == !null  ) {?>
                            <div class="ptable-header-spot" style="color: #<?=$tablo['kutu_baslik_renk']?>;">
                                <?=$tablo['baslik_kat']?>
                            </div>
                        <?php }?>
                        <?php if( $tablo['fiyat'] > '0'  ) {?>
                            <?php if( $tablo['fiyat'] == !null || $tablo['fiyat'] >'0' || $tablo['odeme_sure'] == !null ) {?>
                                <div class="ptable-box-price" style="color: #<?=$tablo['kutu_baslik_renk']?>;">
                                    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                        <?=$secilikur['sol_simge']?>
                                    <?php }?>
                                    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                        <?=$secilikur['sag_simge']?>
                                    <?php }?>
                                    <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$tablo['fiyat'] ), $secilikur['para_format']); ?>

                                    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                        <?=$secilikur['sol_simge']?>
                                    <?php }?>
                                    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                        <?=$secilikur['sag_simge']?>
                                    <?php }?>

                                    <br><span style="font-size: 13px; font-weight: 400;"><?=$tablo['odeme_sure']?></span>
                                </div>
                            <?php }?>
                        <?php }?>
                    </div>
                    <?php foreach ($tablo_ozellik as $ozellik) {?>
                        <div class="ptable-feature-div" style="color: #<?=$ozellik['yazi_renk']?>; background-color: #<?=$ozellik['bg_renk']?>">
                            <?php if($ozellik['spot'] == !null  ) {?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="left" title="<?=$ozellik['spot']?>" style="cursor: pointer"></i>
                            <?php }?> <?=$ozellik['baslik']?>
                        </div>
                    <?php }?>

                    <?php if($tablo['url_tur'] == '1' ) {?>
                        <?php if($urunKontrol->rowCount()>'0' && $varyantKontrolTablo->rowCount()<='0'  ) {?>
                            <?php if($tabloUrun['fiyat_goster'] == '1' ) {?>
                                <div class="ptable-button-div">
                                    <form action="addtocart" method="post" >
                                        <input name="product_code" type="hidden" value="<?php echo $tabloUrun["id"]; ?>">
                                        <input name="token" type="hidden" value="<?=md5('pricingCallBack')?>">
                                        <input name="request" type="hidden" value="<?=md5('tablesCatCallBack')?>">
                                        <input name="request_name" type="hidden" value="<?=$seoURL?>">
                                        <input name="quantity" type="hidden" value="1">
                                        <button name="addtocart" class="<?=$tablo['url_button']?> button-2x">
                                            <?=$diller['urun-box-text1']?>
                                        </button>
                                    </form>
                                </div>
                            <?php }?>
                            <?php if($tabloUrun['fiyat_goster'] == '2' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'   ) {?>
                                    <div class="ptable-button-div">
                                        <form action="addtocart" method="post" >
                                            <input name="product_code" type="hidden" value="<?php echo $tabloUrun["id"]; ?>">
                                            <input name="token" type="hidden" value="<?=md5('pricingCallBack')?>">
                                            <input name="request" type="hidden" value="<?=md5('tablesCatCallBack')?>">
                                            <input name="request_name" type="hidden" value="<?=$seoURL?>">
                                            <input name="quantity" type="hidden" value="1">
                                            <button name="addtocart" class="<?=$tablo['url_button']?> button-2x">
                                                <?=$diller['urun-box-text1']?>
                                            </button>
                                        </form>
                                    </div>
                                <?php }else { ?>
                                    <div class="ptable-button-div">
                                        <div class="<?=$tablo['url_button']?> button-2x">
                                            <?=$diller['anasayfa-paketler-uyelere-ozel']?>
                                        </div>
                                    </div>
                                <?php }?>
                            <?php }?>
                            <?php if($tabloUrun['fiyat_goster'] == '3'   ) {?>
                                <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                                    <div class="ptable-button-div">
                                        <form action="addtocart" method="post" >
                                            <input name="product_code" type="hidden" value="<?php echo $tabloUrun["id"]; ?>">
                                            <input name="token" type="hidden" value="<?=md5('pricingCallBack')?>">
                                            <input name="request" type="hidden" value="<?=md5('tablesCatCallBack')?>">
                                            <input name="request_name" type="hidden" value="<?=$seoURL?>">
                                            <input name="quantity" type="hidden" value="1">
                                            <button name="addtocart" class="<?=$tablo['url_button']?> button-2x">
                                                <?=$diller['urun-box-text1']?>
                                            </button>
                                        </form>
                                    </div>
                                <?php }else { ?>
                                    <div class="ptable-button-div">
                                        <div class="<?=$tablo['url_button']?> button-2x">
                                            <?=$diller['anasayfa-paketler-uyegrubuna-ozel']?>
                                        </div>
                                    </div>
                                <?php }?>
                            <?php }?>
                        <?php }?>
                    <?php }?>
                    <?php if($tablo['url_tur'] == '2' ) {?>
                        <div class="ptable-button-div">
                            <a href="<?=$tablo['url_adres']?>" target="_blank" class="<?=$tablo['url_button']?> button-2x">
                                <?=$tablo['url_yazi']?>
                            </a>
                        </div>
                    <?php }?>

                </div>
            <?php }?>
        <?php }else { ?>
          <div class="w-100 card shadow-sm">
              <div class="card-body text-center">
                  <?=$diller['anasayfa-paketler-no-item']?>
              </div>
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
                    <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  style=" font-family: '<?=$odemeayar['sepet_font']?>',sans-serif;" data-dismiss="modal"><?=$diller['sepet-alisverise-devam']?></button>
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
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; font-family: '<?=$odemeayar['sepet_font']?>',sans-serif;" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
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
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; font-family: '<?=$odemeayar['sepet_font']?>',sans-serif;" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
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
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; font-family: '<?=$odemeayar['sepet_font']?>',sans-serif;" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
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
