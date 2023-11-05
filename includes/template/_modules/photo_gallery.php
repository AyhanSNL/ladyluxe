<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$photogallerysettings = $db->prepare("select * from galeri_ayar where id='1'");
$photogallerysettings->execute();
$photoset = $photogallerysettings->fetch(PDO::FETCH_ASSOC);
$photolimit = $photoset["galeri_limit"];
?>
<?php
$num = 1;
$fotogaleri_liste = $db->prepare("select * from galeri_kat where durum='1' and dil='$_SESSION[dil]' and anasayfa='1' order by sira asc limit $photolimit");
$fotogaleri_liste->execute();

    $fotoListele = $db->prepare("select * from galeri_resim where kat_id=:kat_id order by sira asc limit $photolimit");
        $fotoListele->execute(array(
            'kat_id' => $photoset['galeri_id']
        ));


$galeriCount = $db->prepare("select * from galeri_kat where durum='1' and dil='$_SESSION[dil]'");
$galeriCount->execute();

?>
<?php if($fotogaleri_liste->rowCount() >'0'  ) {?>
<div class="pgallery-module-main-div">
    <div class="pgallery-module-inside-area">
        <div class="pgallery-module-inside-box-area">
            <?php if($photoset['galeri_tip'] == '0' ) {?>
                <?php foreach ($fotogaleri_liste as $ga) {?>
                    <div class="pgallery-module-inside-box">
                        <a href="galeri/<?=$ga['seo_url']?>/">
                            <div class="pgallery-module-box-overlay lspac">
                                <div class="pgallery-module-box-overlay-in" style="font-family : '<?=$photoset['baslik_font']?>',sans-serif ;">
                                    <?php if($photoset['icon'] == !null  ) {?>
                                        <i class="fa <?=$photoset['icon']?>"></i>
                                    <?php }?>
                                    <?=$ga['baslik']?>
                                </div>
                            </div>
                        </a>
                        <?php if($ayar['lazy'] == '1' ) {?>
                            <img class="lazy" src="images/load.gif" data-original="images/gallery/<?=$ga['gorsel']?>" alt="<?=$ga['gorsel']?>">
                        <?php }else { ?>
                            <img src="images/gallery/<?=$ga['gorsel']?>" alt="<?=$ga['baslik']?>">
                        <?php }?>
                    </div>
                <?php }?>
            <?php }?>
            <?php if($photoset['galeri_tip'] == '1' ) {?>
                <div id="portfolio" style="width: 100%; display: flex; justify-content: center; align-items: center; flex-wrap: wrap  ">
            <?php foreach ($fotoListele as $fot) {?>
                    <div class="pgallery-module-inside-box" >
                        <a href="images/gallery/<?=$fot['gorsel']?>">
                            <div class="pgallery-module-box-overlay lspac">
                                <div class="pgallery-module-box-overlay-in" style="font-family : '<?=$photoset['baslik_font']?>',sans-serif ;">
                                    <?php if($photoset['icon'] == !null  ) {?>
                                        <i class="fa <?=$photoset['icon']?>"></i>
                                    <?php }?>
                                    <?=$diller['anasayfa-foto-galeri-buyut']?>
                                </div>
                            </div>
                        </a>
                        <?php if($ayar['lazy'] == '1' ) {?>
                            <img class="lazy" src="images/load.gif" data-original="images/gallery/<?=$fot['gorsel']?>" alt="<?=$fot['gorsel']?>">
                        <?php }else { ?>
                            <img src="images/gallery/<?=$fot['gorsel']?>" alt="<?=$fot['gorsel']?>">
                        <?php }?>
                    </div>
            <?php }?>
                    <?php if($fotoListele->rowCount() <= '0'  ) {?>
                    <div class="alert alert-secondary"> No Item</div>
                    <?php }?>
                </div>
                <link rel="stylesheet" href="assets/css/magnific-popup.css">
                <link rel="stylesheet" href="assets/css/lightbox/lightbox.css" >
                <script src='assets/js/jquery.magnific-popup.min.js'></script>
                <script src="assets/js/lightbox/lightbox.js"></script>
            <?php }?>



        </div>

    </div>
    <?php if($photoset['bg_tip'] == '0'  ) {?>
        <?php if($photoset['bg_dark'] == '1'  ) {?>
            <!-- Slider Karartma Var ise !-->
            <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
            <!-- Slider Karartma Var ise !-->
        <?php }?>
    <?php }?>
</div>
<?php }?>
