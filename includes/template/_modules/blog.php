<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$blogAyar = $db->prepare("select * from blog_ayar where id='1'");
$blogAyar->execute();
$blogset = $blogAyar->fetch(PDO::FETCH_ASSOC);
$bloglimit = $blogset['blog_limit'];
?>
<?php
$num = 1;
$blogList = $db->prepare("select * from blog where durum='1' and dil='$_SESSION[dil]' and anasayfa='1' order by id desc limit $bloglimit");
$blogList->execute();

    $blogsay = $db->prepare("select * from blog where durum='1' and dil='$_SESSION[dil]' ");
        $blogsay->execute();

?>
<?php if($blogList->rowCount() > 0) {?>
    <div class="bloglar-module-main-div">
        <div class="bloglar-module-inside-area">

            <?php if($diller['anasayfa-bloglar-baslik'] == !null || $diller['anasayfa-bloglar-altbaslik'] == !null  ) {?>
                <!-- Modül başlıgı ve üst başlıgı !-->
                <div class="modules-head-text-main">
                    <?php if($diller['anasayfa-bloglar-baslik'] == !null  ) {?>
                        <?php if($blogset['blog_baslik_tip'] == '0' ) {?>
                            <div class="modules-head-text-h <?=$blogset['baslik_space']?>" style="color: #<?=$blogset['baslik_renk']?>; margin-bottom: 0; font-size: 25px ; font-weight: bold;">
                                <?=$diller['anasayfa-bloglar-baslik']?>
                            </div>
                        <?php }?>
                        <?php if($blogset['blog_baslik_tip'] == '1' ) {?>
                            <div class="modules-head-forbg-text-out" style="border-bottom: 1px solid #<?=$blogset['blog_baslik_cizgi']?>; ">
                                <div class="modules-head-forbg-text <?=$blogset['baslik_space']?>" style="color: #<?=$blogset['baslik_renk']?>;     background-color: #<?=$blogset['blog_baslik_bg']?>; ">
                                    <?=$diller['anasayfa-bloglar-baslik']?>
                                </div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <div class="modules-head-text-s <?=$blogset['baslik_space']?>" style="color: #<?=$blogset['spot_renk']?>; margin-bottom: 0;">
                        <?=$diller['anasayfa-bloglar-altbaslik']?>
                    </div>
                </div>
                <!-- Modül başlıgı ve üst başlıgı SON !-->
            <?php }?>

          <div class="bloglar-box-main-div">
              <?php foreach ($blogList as $blog) {?>
                <div class="blog-box">
                    <?php if($blog['gorsel'] ==!null ) {?>
                        <div class="blog-box-img">
                            <a href="blog/<?=$blog['seo_url']?>/" style="color: #<?=$blogset['kutu_baslik_renk']?>;">
                            <div class="blog-box-overlay">
                                <i class="fa fa-unlink"></i>
                            </div>
                                <?php if($ayar['lazy'] == '1' ) {?>
                                    <img class="lazy" src="images/load.gif" data-original="images/blog/<?=$blog['gorsel']?>" alt="<?=$blog['baslik']?>">
                                <?php }else { ?>
                                    <img src="images/blog/<?=$blog['gorsel']?>" alt="<?=$blog['baslik']?>">
                                <?php }?>
                            </a>
                        </div>
                    <?php }?>
                    <div class="blog-box-text-area" style="background-color: #<?=$blogset['kutu_bg']?>;">
                        <div class="blog-box-date lspacsmall" style="color: #<?=$blogset['kutu_tarih_renk']?>;">
                            <?php echo date_tr('j F Y', ''.$blog['tarih'].''); ?>
                        </div>
                        <div class="blog-box-h">
                            <a href="blog/<?=$blog['seo_url']?>/" style="color: #<?=$blogset['kutu_baslik_renk']?>;">
                                <?=$blog['baslik']?>
                            </a>
                        </div>
                        <?php if($blog['spot'] == !null ) {?>
                            <div class="blog-box-s" style="color: #<?=$blogset['kutu_spot_renk']?>;">
                                <?=$blog['spot']?>
                            </div>
                        <?php }else { ?>
                        <div style="width: 100%; height: 15px;    "></div>
                        <?php }?>
                        <div class="blog-box-button lspacsmall">
                            <a href="blog/<?=$blog['seo_url']?>/" class="right-underline" style="color: #<?=$blogset['kutu_more_renk']?>;">
                                <i class="fa fa-arrow-right"></i> <?=$diller['anasayfa-bloglar-devam-yazisi']?>
                            </a>
                        </div>
                    </div>

                </div>
              <?php }?>
          </div>

            <?php if($blogsay->rowCount() > $bloglimit  ) {?>
                <div class="pgallery-all-button-main">
                    <a href="bloglar/" class="<?=$blogset['tumu_buton']?> button-4x">
                        <?=$diller['anasayfa-bloglar-tumu']?>
                    </a>
                </div>
            <?php }?>


        </div>
        <?php if($blogset['bg_tip'] == '0'  ) {?>
            <?php if($blogset['bg_dark'] == '1'  ) {?>
                <!-- Slider Karartma Var ise !-->
                <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                <!-- Slider Karartma Var ise !-->
            <?php }?>
        <?php }?>
    </div>
<?php } ?>
