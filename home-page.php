<?php include 'includes/config/session.php';
unset($_SESSION['form_temp_odemebildirimi']); unset($_SESSION['form_temp_register']);
unset($_SESSION['cat_box_show_select']);
unset($_SESSION['cat_box_show_select_img']);
unset($_SESSION['cat_box_show_select_info']);
unset($_SESSION['cat_box_show_select_price']);
if ($bakim['durum'] == '1' ) {
    header("Location:$ayar[site_url]maintenance/");
    exit();
}
?>
<!doctype html>
<html lang="<?=$current_lang['kisa_ad']?>" dir="<?=$current_lang['area']?>">
<head>
    <base href="<?php echo"$ayar[site_url]"?>">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="<?php echo $ayar['site_url'] ?>images/<?php echo $ayar['site_favicon']; ?>">
    <title><?php echo $ayar['site_baslik']?></title>
    <meta name="description" content="<?php echo"$ayar[site_desc]" ?>">
    <meta name="keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="news_keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta property="og:type" content="website" />
    <?php include "includes/config/header_libs.php";?>
    <?php
    $vitrin1ForCheck = $db->prepare("select id from vitrin_tip1_grup where durum='1' and tur='1'");
    $vitrin1ForCheck->execute();

    $markaVarmi = $db->prepare("select durum from moduller where id=:id ");
    $markaVarmi->execute(array(
        'id' => '16'
    ));
    $markaVarmiRow = $markaVarmi->fetch(PDO::FETCH_ASSOC);

    $tabVitrin = $db->prepare("select durum from moduller where id=:id ");
    $tabVitrin->execute(array(
        'id' => '22'
    ));
    $tabVitrinRow = $tabVitrin->fetch(PDO::FETCH_ASSOC);


    $yorumvarmi = $db->prepare("select durum from moduller where id=:id ");
    $yorumvarmi->execute(array(
        'id' => '12'
    ));
    $yorumvarmiRow = $yorumvarmi->fetch(PDO::FETCH_ASSOC);

    $vitrin1varmi = $db->prepare("select durum from moduller where id=:id ");
    $vitrin1varmi->execute(array(
        'id' => '24'
    ));
    $vitrin1varmiRow = $vitrin1varmi->fetch(PDO::FETCH_ASSOC);

    $SliderVarmi = $db->prepare("select durum from moduller where id=:id ");
    $SliderVarmi->execute(array(
        'id' => '27'
    ));
    $SliderVarmiRow = $SliderVarmi->fetch(PDO::FETCH_ASSOC);
    $OrtaSliderVarmi = $db->prepare("select durum from moduller where id=:id ");
    $OrtaSliderVarmi->execute(array(
        'id' => '29'
    ));
    $OrtaSliderVarmiRow = $OrtaSliderVarmi->fetch(PDO::FETCH_ASSOC);
    $firsatVitVarmi = $db->prepare("select durum from moduller where id=:id ");
    $firsatVitVarmi->execute(array(
        'id' => '31'
    ));
    $firsatVitVarmiRow = $firsatVitVarmi->fetch(PDO::FETCH_ASSOC);
    ?>
    <?php if($SliderVarmiRow['durum'] == '1'  ) {?><link rel='stylesheet' href='assets/css/slider/aos.css'><?php }?><link rel="stylesheet" href="assets/css/modules_style.css"  >
</head>
<body>
<?php if($ayar['site_width'] == '0' ) {?>
<div class="main-body">
<?php }else { ?>
<div class="main-body-2">
<?php }?>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/popup.php'?>
<?php include 'includes/template/header.php'?>
<?php include 'includes/template/modules.php'?>
<?php include 'includes/template/footer.php'?>
</div>
</body>
</html>
<?php if($SliderVarmiRow['durum'] == '1' || $OrtaSliderVarmiRow['durum'] == '1' || $firsatVitVarmiRow['durum'] == '1' || $markaVarmiRow['durum'] == '1' ||  $yorumvarmiRow['durum'] == '1' || $vitrin1varmiRow['durum'] == '1' || $tabVitrinRow['durum'] == '1'  ) {?><?php if($SliderVarmiRow['durum'] == '1'  ) {$aosEkle = '1';}?><?php if($topheaderAktif !='1'  ) {?><script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.4.5/swiper-bundle.min.js'></script><?php if($aosEkle == '1'  ) {?><script src='assets/js/slider/aos.js'></script><?php }?><?php }?><?php }?>
<?php include "includes/config/footer_libs.php";?>
<?php if($SliderVarmiRow['durum'] == '1'  ) {?>
<script> /* Slider Main Carousel */var swiper = new Swiper('.swiper-container', {effect: 'slide', navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }, pagination: {el: '.swiper-pagination', clickable: true, }, autoplay: {delay: 5000,}, speed:1300, on: {slideChangeTransitionStart: function () {$('.slider-section').hide(0);$('.slider-section').removeClass('aos-init').removeClass('aos-animate');}, slideChangeTransitionEnd: function () {$('.slider-section').show(0);AOS.init();} } });AOS.init();/*  <========SON=========>>> Slider Main Carousel SON */</script>
<?php }?>
<?php if($vitrin1ForCheck->rowCount()>'0' && $vitrin1varmiRow['durum'] == '1'  ) {?>
    <?php
    $vitrin_tip1_Ayar = $db->prepare("select vitrin_grid from vitrin_tip1_ayar where id='1'");
    $vitrin_tip1_Ayar->execute();
    $tip1Ayar = $vitrin_tip1_Ayar->fetch(PDO::FETCH_ASSOC);
    ?>
<script> var swiper = new Swiper('.swiper-product-list', {autoplay: {delay: 5000,}, speed:300,  navigation: {nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }, slidesPerView: 1, spaceBetween: 0, breakpoints: {0: {slidesPerView: 2, spaceBetween: 10,}, 400: {slidesPerView: 2, spaceBetween: 10,}, 415: {slidesPerView: 2, spaceBetween: 10,},  600: {slidesPerView: 3, spaceBetween: 10,},768: {slidesPerView: 4, spaceBetween: 10,}, 800: {slidesPerView:4, spaceBetween: 12,}, 1000: {slidesPerView: 3, spaceBetween: 30,}, 1024: {slidesPerView: 4, spaceBetween: 15,}, 1152: {slidesPerView: <?=$tip1Ayar['vitrin_grid']?>, spaceBetween:15,}, 1280: {slidesPerView: <?=$tip1Ayar['vitrin_grid']?>, spaceBetween: 13,}, 1600: {slidesPerView: <?=$tip1Ayar['vitrin_grid']?>, spaceBetween: 13,}, 1920: {slidesPerView: <?=$tip1Ayar['vitrin_grid']?>, spaceBetween: 13,}, 2560: {slidesPerView: <?=$tip1Ayar['vitrin_grid']?>, spaceBetween: 13,},}, /*enable auto height*/});</script>
<?php }?>
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
<div class="modal fade" id="varyantModal" data-backdrop="static" ><div class="modal-dialog modal-dialog-centered modal-sm "><div class="modal-content"><button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button><div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;"><i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br><div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['kategori-detay-text28']?></div><div><?=$diller['kategori-detay-text29']?></div><div style="font-size: 12px; margin-top: 20px; line-height: 15px!important; color: #666;"><?=$diller['kategori-detay-text32']?></div></div><div class="category-cart-add-success-modal-footer"><button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button></div></div></div></div><div class="modal fade" id="loginModal"  ><div class="modal-dialog modal-dialog-centered modal-sm"><div class="modal-content"><button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button><div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;"><i class="ion-ios-locked" style="font-size: 45px ; color: #558cff;"></i><br><?=$diller['kategori-detay-text31']?></div><div class="category-cart-add-success-modal-footer"><a href="uye-girisi/" class="button-2x button-blue" style="width: 100%; text-align: center; text-transform: uppercase;"><?=$diller['kategori-detay-text37']?></a></div></div></div></div>
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
<?php if($_SESSION['uyelik_durum'] =='success'  ) {?>
    <div class="modal fade" id="okArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['users-text13']?></div>
                    <div>
                        <?=$diller['users-text14']?>
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
            $('#okArea').modal('show');
        });
        $(window).load(function () {
            $('#okArea').modal('show');
        });
        var $modalDialog = $("#okArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['uyelik_durum']); ?>
<?php }?>
<?php if($_SESSION['uyelik_durum'] =='success_onay'  ) {?>
    <div class="modal fade" id="okArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['users-text13']?></div>
                    <div>
                        <?=$diller['users-text14-onaysiz']?>
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
            $('#okArea').modal('show');
        });
        $(window).load(function () {
            $('#okArea').modal('show');
        });
        var $modalDialog = $("#okArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['uyelik_durum']); ?>
<?php }?>
<?php if($_SESSION['uyelik_durum'] =='success_onay2'  ) {?>
    <div class="modal fade" id="okArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #4b7ece;"><?=$diller['alert-warning-2']?></div>
                    <div>
                        <?=$diller['users-text14-onaysiz']?>
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
            $('#okArea').modal('show');
        });
        $(window).load(function () {
            $('#okArea').modal('show');
        });
        var $modalDialog = $("#okArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['uyelik_durum']); ?>
<?php }?>
<?php
unset($_SESSION['adetdetay']);
?>
