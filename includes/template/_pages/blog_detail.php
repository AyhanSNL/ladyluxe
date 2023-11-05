<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php

$id = htmlspecialchars(trim($_GET['blog_id']));
if(strip_tags(htmlspecialchars($_GET['blog_id'])) != $_GET['blog_id']  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}

$icerikCek = $db->prepare("select * from blog where seo_url=:seo_url and dil=:dil and durum=:durum ");
$icerikCek->execute(array(
    'seo_url' => $id,
    'dil' => $_SESSION['dil'],
    'durum' => '1'
));
$icerik = $icerikCek->fetch(PDO::FETCH_ASSOC);


$blog_hits = $db->prepare("UPDATE blog SET hit = hit+1 WHERE seo_url='$id'  ");
$blog_hits->execute();

$islemlerAyar = $db->prepare("select * from blog_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);

$bloglar = $db->prepare("select * from blog where dil=:dil and durum=:durum order by hit desc limit 10 ");
$bloglar->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1'
));

$noo = '1';
/* Seo Başlık */
if($icerik['seo_baslik'] == !null ) {
    $baslik = $icerik['seo_baslik'];
}else{
    $baslik = $icerik['baslik'];
}
/*  <========SON=========>>> Seo Başlık SON */
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='blog' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
<?php if($icerikCek->rowCount() <= '0'  ) {?>
<?php header('Location:'.$siteurl.''); ?>
<?php }else { ?>
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
    <div id="MainDiv" style="background-color: #<?=$islemayar['detay_bg_color']?>; width: 100%; font-family : '<?=$islemayar['baslik_font']?>',Sans-serif ;  ">
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?=$icerik['baslik']?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span>/</span>
                    <a href="bloglar/"><?php echo $diller['altsayfa-bloglar-title']; ?></a>
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
        <div class="bloglar-detay">
            <div class="bloglar-detay-left">
                <div class="bloglar-detay-left-img">
                    <img src="images/blog/big_photo/<?=$icerik['gorsel']?>" alt="">
                </div>
                <div class="bloglar-detay-left-content-div">
                    <?php
                    $kategoriler = $db->prepare("select * from blog_kat where seo_url=:seo_url ");
                    $kategoriler->execute(array(
                        'seo_url' => $icerik['kat'],
                    ));
                    $katrow = $kategoriler->fetch(PDO::FETCH_ASSOC);
                    ?>
                   <?php if($kategoriler->rowCount()>'0'  ) {?>
                       <div class="bloglar-detay-left-content-div-date " style="font-weight: bold; ">
                           <i class="las la-pencil-alt"></i> <a href="bloglar/kategori/<?=$katrow['seo_url']?>/" style="color: #000;">
                               <?=$katrow['baslik']?>
                           </a>
                       </div>
                   <?php }?>
                    <div class="bloglar-detay-left-content-div-date lspacsmall">
                        <i class="fa fa-calendar"></i> <?php echo date_tr('j F Y', ''.$icerik['tarih'].''); ?>
                    </div>
                    <div class="bloglar-detay-left-content-div-h">
                        <?=$icerik['baslik']?>
                    </div>
                    <?php if($islemayar['okunma'] == '1' ) {?>
                        <div class="bloglar-detay-left-content-div-view lspacsmall">
                            <i class="fa fa-eye"></i> <?=$diller['bloglar-okunma-yazisi']?> : <?=$icerik['hit']?>
                        </div>
                    <?php }?>
                    <div class="bloglar-detay-left-content-div-icerik">
                        <?php
                        $icerikgoster  = $icerik['icerik'];
                        $eski   = "../";
                        $yeni   = "";
                        $icerikgoster = str_replace($eski, $yeni, $icerikgoster);
                        ?>
                        <?=$icerikgoster?>
                    </div>
                    <?php
                    if($icerik['tags'] == !null){
                        $etiketler = $icerik['tags'];
                        $etiketler = explode(',', $etiketler);
                        ?>
                        <div style="font-size: 13px ; font-weight: bold; color: #000;  "><?=$diller['bloglar-etiketler-baslik']?></div>
                        <div class="bloglar-detay-left-content-div-tags">
                            <?php foreach( $etiketler as $anahtar => $deger ){ ?>
                                <?php if($deger != '' ) {?>
                                    <a class="bloglar-detay-left-content-div-tags-box" href="<?=$siteurl?>bloglar/etiketler/<?=urlencode($deger)?>/">
                                        <?=$deger?>
                                    </a>
                                <?php }?>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <div class="bloglar-detay-left-content-div-social">
                        <a href="https://www.facebook.com/sharer.php?u=<?=$ayar['site_url']?>blog/<?=$icerik['seo_url']?>/" onClick="return popup(this, 'notes')"  ><i aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>" class="fa fa-facebook"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?=$ayar['site_url']?>blog/<?=$icerik['seo_url']?>/" onClick="return popup(this, 'notes')" ><i class="fa fa-twitter" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>"></i></a>
                        <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?=$ayar['site_url']?>blog/<?=$icerik['seo_url']?>/" onClick="return popup(this, 'notes')"><i class="fa fa-linkedin" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>"></i></a>
                        <a href="https://www.pinterest.com/pin/create/button/?url=<?=$ayar['site_url']?>blog/<?=$icerik['seo_url']?>&media=<?=$ayar['site_url']?>images/blog/<?=$icerik['gorsel']?>&description=<?=$icerik['baslik']?>"  onClick="return popup(this, 'notes')"><i class="fa fa-pinterest-p" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>"></i></a>
                        <a href="https://api.whatsapp.com/send?text=<?=$icerik['baslik']?> <?=$ayar['site_url']?>blog/<?=$icerik['seo_url']?>/" target="_blank"><i class="fa fa-whatsapp" data-toggle="tooltip" data-placement="bottom" title="<?=$diller['paylas']?>"></i></a>
                    </div>

                    <!-- Blog için yorumlar !-->
                    <?php
                    $commentSettings = $db->prepare("select * from modul_yorum_ayar where id=:id ");
                    $commentSettings->execute(array(
                        'id' => '1'
                    ));
                    $comset = $commentSettings->fetch(PDO::FETCH_ASSOC);
                    $yorumlimit = $comset['yorumlimit'];

                    $yorumCount = $db->prepare("select * from modul_yorum where durum=:durum and icerik_id=:icerik_id and modul=:modul ");
                    $yorumCount->execute(array(
                        'durum' => '1',
                        'icerik_id' => $icerik['id'],
                        'modul' => 'blog',
                    ));

                    $yorumCek = $db->prepare("select * from modul_yorum where durum=:durum and icerik_id=:icerik_id and modul=:modul order by id desc limit $yorumlimit");
                    $yorumCek->execute(array(
                        'durum' => '1',
                        'icerik_id' => $icerik['id'],
                        'modul' => 'blog',
                    ));

                    ?>
                    <?php if($comset['blog_durum'] == '1' ) {?>
                    <div class="commentfull-div-main">
                        <div class="module_comment_add_main">
                            <div class="module_comment_head">
                                <div class="module_comment_head_left">
                                    <?=$diller['modul-yorum-ekle-yazisi']?>
                                </div>
                                    <div class="module_comment_head_right">
                                        <?=$diller['modul-tum-yorumlar-yazisi']?> <b><?=$yorumCount->rowCount()?></b>
                                    </div>
                            </div>
                            <div class="module_comment_form_area">
                                <form method="post" action="blogcommentpost" >
                                    <input type="hidden" name="bID" value="<?=$icerik['id']?>" >
                                    <input type="hidden" name="hash" value="<?=md5($icerik['seo_url'])?>" >
                                    <div class="form-row">
                                        <div class="form-group col-md-6 ">
                                            <label for="inputnName"><?=$diller['modul-yorum-isim']?> <span style="color: red;">*</span></label>
                                            <input type="text" name="isim" autocomplete="off" class="form-control" id="inputnName" style="border-radius: 0"  >
                                        </div>
                                        <div class="form-group col-md-6 ">
                                            <label for="eposta"><?=$diller['modul-yorum-eposta']?> <span style="color: red;">*</span></label>
                                            <input type="text" name="eposta" autocomplete="off" class="form-control" id="eposta" style="border-radius: 0" >
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label for="yorumLabel"><?=$diller['modul-yorum-icerik']?> <span style="color: red;">*</span></label>
                                            <textarea name="yorum" id="yorumLabel" class="form-control" rows="2"  style="border-radius: 0"></textarea>
                                        </div>
                                        <?php
                                        if($ayar['site_captcha'] == '1')
                                        {
                                            ?>
                                            <!-- GÜVENLİK CAPTCHA ========== !-->
                                            <?php $kod=$_SESSION['secure_code'];?>
                                            <div class="form-group col-md-4 ">
                                                <label for="inputCaptcha"><?=$diller['guvenlik-kodu']?></label>
                                                <div class="input-group mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text"><img src='includes/template/captcha.php'/></div>
                                                    </div>
                                                    <input type="text" class="form-control form-captcha-height" id="inputCaptcha"   name="secure_code" maxlength="5"  >
                                                </div>
                                            </div>
                                            <!-- GÜVENLİK CAPTCHA ========== !-->
                                        <?php }?>
                                    </div>
                                    <button type="submit" id="shopButton" name="add" class="<?=$comset['gonder_button_bg']?> button-2x" style=" font-size: 13px !important ; font-weight: bold; border-radius: 0!important;"><?=$diller['modul-yorum-button']?></button>
                                </form>
                            </div>

                        </div>




                        <?php if($yorumCount->rowCount()> '0'  ) {?>
                            <div style="border-top: 1px solid #EBEBEB; width: 100%;  ">
                        <?php }?>
                        <?php foreach ($yorumCek as $yorum) {
                            $postID = 	$yorum['id'];
                            $ipcek = $_SERVER["REMOTE_ADDR"];
                            $likeCek = $db->prepare("select * from modul_yorum_begeni where yorum_id=:yorum_id and durum=:durum ");
                            $likeCek->execute(array(
                                'yorum_id' => $yorum['id'],
                                'durum' => '0'
                            ));

                            $dislikeCek = $db->prepare("select * from modul_yorum_begeni where yorum_id=:yorum_id and durum=:durum ");
                            $dislikeCek->execute(array(
                                'yorum_id' => $yorum['id'],
                                'durum' => '1'
                            ));

                            $begenilerS = $db->prepare("select * from modul_yorum_begeni where yorum_id=:yorum_id and ip_adres=:ip_adres order by id desc limit 1");
                            $begenilerS->execute(array(
                                'yorum_id' => $yorum['id'],
                                'ip_adres' => $ipcek
                            ));
                            $begen = $begenilerS->fetch(PDO::FETCH_ASSOC);


                            ?>
                            <div class="module_comment_box_main">
                                <div class="module_comment_in_box_div">
                                    <?php if($comset['gorsel'] == !null && $comset['gorsel']>'0'  ) {?>
                                        <div class="module_comment_box_img">
                                            <img src="images/uploads/<?=$comset['gorsel']?>" alt="<?=$yorum['isim']?>">
                                        </div>
                                    <?php }?>
                                    <div class="module_comment_box_right">
                                        <div class="module_comment_box_head_area">
                                            <div class="module_comment_box_name"><?=$yorum['isim']?></div>
                                            <div class="module_comment_box_date"><?php echo date_tr('j F Y, H:i', ''.$yorum['tarih'].''); ?></div>
                                        </div>
                                        <div class="module_comment_box_content">
                                            <?=$yorum['icerik']?>
                                        </div>
                                        <div class="module_comment_box_content" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #EBEBEB; font-size: 12px ;">

                                            <?php if($begen['durum'] == '0' ) {?>
                                                <a href="#" class="like-post" data-code="<?php echo $yorum['id']; ?>" style="color: green; font-weight: 700; text-decoration: none;">
                                                    <i class="fa fa-thumbs-o-up"></i> <?=$diller['modul-yorum-begen']?> (<?=$likeCek->rowCount()?>)
                                                </a>
                                                <span style="width:20px; display: inline-block"></span>
                                                <a href="#" class="like-dislike-post" data-code="<?php echo $yorum['id']; ?>" style="color: #666; font-weight: 600; text-decoration: none;">
                                                    <i class="fa fa-thumbs-o-down"></i> <?=$diller['modul-yorum-begenme']?> (<?=$dislikeCek->rowCount()?>)
                                                </a>
                                            <?php }?>


                                            <?php if($begen['durum'] == '1' ) {?>
                                                <a href="#" class="dislike-like-post" data-code="<?php echo $yorum['id']; ?>" style="color: #666; font-weight: 600; text-decoration: none;">
                                                    <i class="fa fa-thumbs-o-up"></i> <?=$diller['modul-yorum-begen']?> (<?=$likeCek->rowCount()?>)
                                                </a>
                                                <span style="width:20px; display: inline-block"></span>
                                                <a href="#" class="dislike-post" data-code="<?php echo $yorum['id']; ?>" style="color: red; font-weight: 700; text-decoration: none;">
                                                    <i class="fa fa-thumbs-o-down"></i> <?=$diller['modul-yorum-begenme']?> (<?=$dislikeCek->rowCount()?>)
                                                </a>
                                            <?php }?>


                                            <?php if($begen['durum'] == null ) {?>
                                                <a href="#" class="like-post" data-code="<?php echo $yorum['id']; ?>" style="color: #666; font-weight: 600; text-decoration: none;">
                                                    <i class="fa fa-thumbs-o-up"></i> <?=$diller['modul-yorum-begen']?> (<?=$likeCek->rowCount()?>)
                                                </a>
                                                <span style="width:20px; display: inline-block"></span>
                                                <a href="#" class="dislike-post" data-code="<?php echo $yorum['id']; ?>" style="color: #666; font-weight: 600; text-decoration: none;">
                                                    <i class="fa fa-thumbs-o-down"></i> <?=$diller['modul-yorum-begenme']?> (<?=$dislikeCek->rowCount()?>)
                                                </a>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <?php if($yorumCount->rowCount()> '0'  ) {?>
                            </div>
                        <?php }?>

                        <?php if($yorumCount->rowCount() > $yorumlimit  ) {?>
                            <div class="blogcomment-show-more-button " id="blogcomment-show-more-button<?php echo $postID; ?>">
                                <span id="<?php echo $postID; ?>" data-id="<?=$icerik['id']?>" class="blogcomment-showmorespan <?=$comset['tumu_button_bg']?>" >+ <?=$diller['modul-tum-yorumlar-yazisi-alt']?></span>
                                <span class="blogcomment_loding" style="display: none;"><span class="blogcomment_loding_txt"><?=$diller['modul-tum-yorumlar-wait']?></span></span>
                            </div>
                        <?php }?>

                        <?php if($yorumCount->rowCount() <= '0'  ) {?>
                            <div class="alert alert-dark" style=" font-size: 14px ;">
                                <?=$diller['modul-yorum-yok']?>
                            </div>
                        <?php }?>

                    </div>
                    <?php }?>

                </div>
            </div>
            <?php if($islemayar['detay_hits'] == '1' || $islemayar['detay_kategoriler'] == '1'  ) {?>
            <div class="bloglar-detay-right" style="background-color: #fff">
                <?php
                $blogKatSorgu = $db->prepare("select * from blog_kat where dil=:dil and durum=:durum order by sira asc");
                $blogKatSorgu->execute(array(
                    'dil' => $_SESSION['dil'],
                    'durum' => '1',
                ));
                ?>
                <?php if($blogKatSorgu->rowCount()>'0' && $islemayar['detay_kategoriler'] == '1'  ) {?>
                    <div class="bloglar-detay-right-h2">
                        <i class="fa fa-level-down"></i>  <?=$diller['bloglar-tum-kategoriler']?>
                    </div>
                    <div class="bloglar-detay-right-tags">
                        <?php foreach ($blogKatSorgu as $blogkat) {?>
                            <a class="bloglar-detay-left-content-div-tags-box" href="<?=$siteurl?>bloglar/kategori/<?=$blogkat['seo_url']?>/">
                                <?=$blogkat['baslik']?>
                            </a>
                        <?php }?>
                    </div>
                <?php }?>
                <?php if($islemayar['detay_hits'] == '1' ) {?>
                    <div class="bloglar-detay-right-h">
                        <i class="fa fa-level-down"></i>  <?=$diller['bloglar-cok-okunanlar']?>
                    </div>
                    <?php foreach ($bloglar as $blog) {?>
                        <div class="bloglar-detay-right-box">
                            <div class="bloglar-detay-right-box-no">
                                <?=$noo++?>
                            </div>
                            <div class="bloglar-detay-right-box-img">
                                <a href="blog/<?=$blog['seo_url']?>/">
                                    <img src="images/blog/<?=$blog['gorsel']?>" alt="<?=$blog['baslik']?>">
                                </a>
                            </div>
                            <div class="bloglar-detay-right-box-h">
                                <a href="blog/<?=$blog['seo_url']?>/">
                                    <?=$blog['baslik']?>
                                </a>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>



            </div>
            <?php }?>
        </div>
    </div>



    <!-- CONTENT AREA ============== !-->

    <style>
        .shopButtonT{
            font-family : '<?=$islemayar['baslik_font']?>',Sans-serif ;
        }
    </style>

    <div id="shopButtonOverlay">
        <div class="shopButtonT">
            <div><img src="images/load.svg" alt=""></div>
            <div><?=$diller['teslimat-uye-text-4']?></div>
        </div>
    </div>

    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
    <?php include "includes/config/footer_libs.php";?>
<?php }?>

<?php if($_SESSION['yorum_alert'] == 'secure'   ) {?>
    <div class="modal fade" id="errorModal" data-backdrop="static"  style="z-index: 99999">
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['alert-warning-captcha']?>
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
            $('#errorModal').modal('show');
        });
        $(window).load(function () {
            $('#errorModal').modal('show');
        });
        var $modalDialog = $("#errorModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['yorum_alert'] ); ?>
<?php }?>
<?php if($_SESSION['yorum_alert'] == 'bos'   ) {?>
    <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
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
            $('#errorModal').modal('show');
        });
        $(window).load(function () {
            $('#errorModal').modal('show');
        });
        var $modalDialog = $("#errorModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['yorum_alert'] ); ?>
<?php }?>
<?php if($_SESSION['yorum_alert'] == 'eposta'   ) {?>
    <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['alert-warning-eposta-hata']?>
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
            $('#errorModal').modal('show');
        });
        $(window).load(function () {
            $('#errorModal').modal('show');
        });
        var $modalDialog = $("#errorModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['yorum_alert'] ); ?>
<?php }?>
<?php if($_SESSION['yorum_alert'] == 'success'   ) {?>
    <div class="modal fade" id="successModals" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['modul-yorum-basarili']?></div>
                    <div>
                        <?=$diller['modul-yorum-basarili-yazi']?>
                    </div>
                    <div style="font-size: 12px; margin-top: 20px; line-height: 15px!important; color: #666;">
                        <?=$diller['modul-yorum-basarili-aciklama']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successModals').modal('show');
        });
        $(window).load(function () {
            $('#successModals').modal('show');
        });
        var $modalDialog = $("#successModals");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['yorum_alert'] ); ?>
<?php }?>


<script>
    $(document).ready(function(){
        $(document).on('click','.blogcomment-showmorespan',function(){
            var ID = $(this).attr('id');
            var PRO_ID = $(this).attr('data-id');
            $('.blogcomment-showmorespan').hide();
            $('.blogcomment_loding').show();
            $.ajax({
                type:'POST',
                url:'blog-comment-more',
                data:{id: ID, pro_id: PRO_ID},
                success:function(html){
                    $('#blogcomment-show-more-button'+ID).remove();
                    $('.commentfull-div-main').append(html);
                }
            });
        });
    });
</script>