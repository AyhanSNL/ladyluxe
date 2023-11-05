<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$benzerUrunlerCek = $db->prepare("select * from urundetay_benzer_urun where detay_id=:detay_id order by sira asc");
$benzerUrunlerCek->execute(array(
        'detay_id' => $icerik['id']
));
?>
<?php if($benzerUrunlerCek->rowCount()>'0'  ) {
    $urunKutuAyar = $db->prepare("select * from urun_kutu where id='1'");
    $urunKutuAyar->execute();
    $urunKutuRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
    ?>
<div class="urun-detay-benzer-urunler-main-div">

    <div class="urun-detay-benzer-urunler-main-div-head">
        <div class="urun-detay-benzer-urunler-main-div-head-l">
            <?=$diller['urun-detay-benzer-urunler-baslik']?>
        </div>
        <div class="arrorhead"><span class="Arrows"></span></div>
    </div>
    <div class="urun-detay-benzer-urunler-main-div-container SlickCarousel">
        <!-- Ürünler !-->
        <?php foreach( $benzerUrunlerCek as $benzerRow ){
            $benzerUrunCek = $db->prepare("select * from urun where id=:id and durum=:durum and dil=:dil ");
            $benzerUrunCek->execute(array(
                'id' => $benzerRow['urun_id'],
                'durum' => '1',
                'dil' => $_SESSION['dil']
            ));
            $benzurun = $benzerUrunCek->fetch(PDO::FETCH_ASSOC);
            $starDec = $db->prepare("SELECT SUM(yildiz) AS orta FROM urun_yorum where onay=:onay and urun_id=:urun_id; ");
            $starDec->execute(array(
                'onay' => '1',
                'urun_id' => $benzurun['id']
            ));
            $yildiz = $starDec->fetch(PDO::FETCH_ASSOC);

            $yorumsayisi = $db->prepare("select * from urun_yorum where onay=:onay and urun_id=:urun_id ");
            $yorumsayisi->execute(array(
                'onay' => '1',
                'urun_id' => $benzurun['id']
            ));
            $yorumcount = $yorumsayisi->rowCount();

            if($yorumcount == null  ) {
                $yildizhesap = '0';
            } else {
                $yildizhesap = $yildiz['orta'] / $yorumcount;
            }
            $finalstarrate_hit = (int)$yildizhesap;

            /* Fiyatı Çıkar */
            if($userSorgusu->rowCount()>'0'  ) {
                if($uyegruplariCek->rowCount()>'0'  ) {
                    if($uyegrup['fiyat_tip'] == '0'  ) {
                        $box_fiyat = $benzurun['fiyat'];
                        $box_fiyat_uyari = '0';
                    }
                    if($uyegrup['fiyat_tip'] == '1'  ) {
                        if($benzurun['fiyat_tip2'] >'0' ) {
                            $box_fiyat = $benzurun['fiyat_tip2'];
                            $box_fiyat_uyari = '1';
                        }else{
                            $box_fiyat = $benzurun['fiyat'];
                            $box_fiyat_uyari = '0';
                        }
                    }
                }else{
                    $box_fiyat = $benzurun['fiyat'];
                    $box_fiyat_uyari = '0';
                }
            }else{
                $box_fiyat = $benzurun['fiyat'];
                $box_fiyat_uyari = '0';
            }
            /*  <========SON=========>>> Fiyatı Çıkar SON */
            /* İndirim Oranı */
            if($benzurun['indirim'] == '1' && $benzurun['eski_fiyat'] >'0' ) {
                $indirimorani = 100 - (($box_fiyat / $benzurun['eski_fiyat']) * 100);
            }
            /*  <========SON=========>>> İndirim Oranı SON */
            ?>
            <?php if($benzerUrunCek->rowCount()>'0'  ) {?>
            <div class="urun-detay-benzer-urun-box">
                <div class="urun-detay-benzer-urun-box-img <?php if($benzurun['stok'] <= '0' ) { ?>product-grey-img<?php }?>">
                    <a href="<?=$benzurun['seo_url']?>-P<?=$benzurun['id']?>">
                        <img src="images/product/<?=$benzurun['gorsel']?>" alt="<?=$benzurun['baslik']?>">
                    </a>
                </div>
                <div class="urun-detay-benzer-urun-box-text">
                    <div class="urun-detay-benzer-urun-box-text-h">
                        <a href="<?=$benzurun['seo_url']?>-P<?=$benzurun['id']?>">
                            <?=$benzurun['baslik']?>
                        </a>
                    </div>
                </div>
                <?=benzer_urunbox_starrate()?>
                <?=benzer_urunbox_fiyatlar();?>
                <div class="urun-detay-benzer-urun-box-overlay">
                    <a href="<?=$benzurun['seo_url']?>-P<?=$benzurun['id']?>" class="btn btn-sm btn-dark" style="width: 100%; border-radius: 0; font-size: 13px; "><?=$diller['urun-detay-benzer-urunler-urune-git']?></a>
                </div>
            </div>
            <?php }?>
        <?php }?>
        <!-- Ürünler SON !-->
    </div>

</div>
    <script>
        $(document).ready(function () {
            $(".SlickCarousel").slick({
                rtl: false, // If RTL Make it true & .slick-slide{float:right;}
                autoplay: true,
                autoplaySpeed: 4300, //  Slide Delay
                speed: 400, // Transition Speed
                slidesToShow: 4, // Number Of Carousel
                slidesToScroll: 1, // Slide To Move
                pauseOnHover: false,
                appendArrows: $(".urun-detay-benzer-urunler-main-div .arrorhead .Arrows"), // Class For Arrows Buttons
                prevArrow: '<span class="Slick-Prev"></span>',
                nextArrow: '<span class="Slick-Next"></span>',
                easing: "linear",
                responsive: [
                    { breakpoint: 801, settings: {
                            slidesToShow: 3 } },

                    { breakpoint: 641, settings: {
                            slidesToShow: 3 } },

                    { breakpoint: 481, settings: {
                            slidesToShow: 2 } }] });

        });
    </script>
<?php }?>