<?php
function seo($s) {
    $tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',' ',',','?','!','&','+');
    $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','','','','');
    $s = str_replace($tr,$eng,$s);
    $s = strtolower($s);
    $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
    $s = preg_replace('/\s+/', '-', $s);
    $s = preg_replace('|-+|', '-', $s);
    $s = preg_replace('/#/', '', $s);
    $s = str_replace('\'', '-', $s);
    $s = str_replace('.', '', $s);
    $s = trim($s, '-');
    return $s;
}
function etiketDuzelt($s) {
    $tr = array(' ');
    $eng = array('+');
    $s = str_replace($tr,$eng,$s);
    $s = strtolower($s);
    $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);

    return $s;
}
?>
<?php
function ucwords_tr($deger)
{
    $lower_arr = array("I" => "ı", "i" => "İ");
    $deger = strtr($deger, $lower_arr);
    $deger = mb_convert_case($deger, MB_CASE_TITLE, "UTF-8");
    return $deger;
}
function kdvhesapla($degers,$degeroran)
{
    $degers = $degers * $degeroran/100;
    return $degers;
}
function kdvcikar($degers,$degeroran)
{
    $degers = $degers / (1+($degeroran/100));
    return $degers;
}
function taksithesapla($fiyat,$vade)
{
    $sonuc =  ($fiyat * $vade / 100)+$fiyat;
    return $sonuc;
}
function  kurhesapla($current,$to,$price){

    $capraz = ($current/$to);
    $sonuc = ($price * $capraz);

    return $sonuc;

}
?>
<?php

function date_tr($f, $zt = 'now'){
    global $diller;
    $z = date("$f", strtotime($zt));
    $donustur = array(
        'Monday'	=> $diller['tarih-text'],
        'Tuesday'	=> $diller['tarih-text2'],
        'Wednesday'	=> $diller['tarih-text3'],
        'Thursday'	=> $diller['tarih-text4'],
        'Friday'	=> $diller['tarih-text5'],
        'Saturday'	=> $diller['tarih-text6'],
        'Sunday'	=> $diller['tarih-text7'],
        'January'	=> $diller['tarih-text8'],
        'February'	=> $diller['tarih-text9'],
        'March'		=> $diller['tarih-text10'],
        'April'		=> $diller['tarih-text11'],
        'May'		=> $diller['tarih-text12'],
        'June'		=> $diller['tarih-text13'],
        'July'		=> $diller['tarih-text14'],
        'August'	=> $diller['tarih-text15'],
        'September'	=>  $diller['tarih-text16'],
        'October'	=> $diller['tarih-text17'],
        'November'	=> $diller['tarih-text18'],
        'December'	=> $diller['tarih-text19'],
        'Mon'		=> 'Pts',
        'Tue'		=> 'Sal',
        'Wed'		=> 'Çar',
        'Thu'		=> 'Per',
        'Fri'		=> 'Cum',
        'Sat'		=> 'Cts',
        'Sun'		=> 'Paz',
        'Jan'		=> 'Oca',
        'Feb'		=> 'Şub',
        'Mar'		=> 'Mar',
        'Apr'		=> 'Nis',
        'Jun'		=> 'Haz',
        'Jul'		=> 'Tem',
        'Aug'		=> 'Ağu',
        'Sep'		=> 'Eyl',
        'Oct'		=> 'Eki',
        'Nov'		=> 'Kas',
        'Dec'		=> 'Ara',
    );
    foreach($donustur as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($f, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
}
?>
<?php
function boslukSil($string)
{
    $string = preg_replace("/\s+/", "", $string);
    $string = trim($string);
    return $string;
}
?>
<?php
function temiz($text){
    $text = strip_tags($text);
    $text = preg_replace('/<a\s+.*?href="([^")]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text);
    $text = preg_replace('/<!--.+?-->/', '', $text);
    $text = preg_replace('/{.+?}/', '', $text);
    $text = preg_replace('/&nbsp;/', ' ', $text);
    $text = preg_replace('/&amp;/', ' ', $text);
    $text = preg_replace('/&quot;/', ' ', $text);
    $text = htmlspecialchars($text);
    $text = addslashes($text);
    return $text;
}
function gets($par) {
    $par = temiz(@$_GET[$par]);
    return $par;
}

function posts($par) {
    $par = htmlspecialchars(trim($_POST[$par]));
    return $par;
}
?>
<?php function urunBoxVitrinSecenekli($sorguAdi){
    global $db;
    global $userSorgusu;
    global $urunset;
    global $urunKutuRow;
    global $userCek;
    global $uyegruplariCek;
    global $uyegrup;
    global $varsayilankur;
    global $secilikur;
    global $dil;
    global $uyeayar;
    global $ayar;
    global $odemeayar;
    global $box_gorunum_turu;
    global $box_gorunum_main_div;
    global $box_gorunum_img_div;
    global $box_gorunum_info_div;
    global $box_gorunum_price_div;
    global $box_gorunum_hiddenprice_div;
    include 'includes/lang/'.$dil.'.php';
    ?>
    <?php foreach ($sorguAdi as $row) {
        $kutuMarka = $db->prepare("select * from urun_marka where id=:id and durum=:durum ");
        $kutuMarka->execute(array(
            'id' => $row['marka'],
            'durum' => '1'
        ));
        $urunmarka = $kutuMarka->fetch(PDO::FETCH_ASSOC);
        /* Fiyatı Çıkar */
        if($userSorgusu->rowCount()>'0'  ) {
            if($uyegruplariCek->rowCount()>'0'  ) {
                if($uyegrup['fiyat_tip'] == '0'  ) {
                    $box_fiyat = $row['fiyat'];
                    $box_fiyat_uyari = '0';
                }
                if($uyegrup['fiyat_tip'] == '1'  ) {
                    if($row['fiyat_tip2'] >'0' ) {
                        $box_fiyat = $row['fiyat_tip2'];
                        $box_fiyat_uyari = '1';
                    }else{
                        $box_fiyat = $row['fiyat'];
                        $box_fiyat_uyari = '0';
                    }
                }
            }else{
                $box_fiyat = $row['fiyat'];
                $box_fiyat_uyari = '0';
            }
        }else{
            $box_fiyat = $row['fiyat'];
            $box_fiyat_uyari = '0';
        }
        /*  <========SON=========>>> Fiyatı Çıkar SON */
        /* İndirim Oranı */
        if($row['indirim'] == '1' && $row['eski_fiyat'] >'0' ) {
            $indirimorani = 100 - (($box_fiyat / $row['eski_fiyat']) * 100);
        }
        /*  <========SON=========>>> İndirim Oranı SON */
        /* Ürünün Yorum ve Değerlendirme Ortalaması */
        $urunYildizlari = $db->prepare("SELECT SUM(yildiz) AS orta FROM urun_yorum where onay=:onay and urun_id=:urun_id; ");
        $urunYildizlari->execute(array(
            'onay' => '1',
            'urun_id' => $row['id']
        ));
        $yildizToplami = $urunYildizlari->fetch(PDO::FETCH_ASSOC);

        $urunYorumToplamSayi = $db->prepare("select * from urun_yorum where onay=:onay and urun_id=:urun_id ");
        $urunYorumToplamSayi->execute(array(
            'onay' => '1',
            'urun_id' => $row['id']
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
            'urun_id' => $row['id']
        ));
        /*  <========SON=========>>> Varyant Sorgu SON */

        ?>
        <div class="<?=$box_gorunum_main_div ?>">
            <?php if ($urunKutuRow['kutu_yeni_ribbon'] == '1') { ?>
                <?php if($row['yeni'] == '1' ) {?>
                    <div class="ribbon"><span><?=$diller['urun-box-text4']?></span></div>
                <?php }?>
            <?php } ?>
            <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '1') { ?>
                <?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?>
                    <div class="cat-detail-products-box-cart-1">
                        <?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $row['stok'] > '0') { ?>
                            <?php if($row['fiyat_goster'] == '1' ) {?>
                                <?php if($row['siparis_islem'] == '0'  ) {?>
                                    <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                        <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                            <i class="fa fa-shopping-basket"></i>
                                        </button>
                                    <?php }else { ?>
                                        <form action="addtocart" method="post" >
                                            <input name="product_code" type="hidden" value="<?php echo $row["id"]; ?>">
                                            <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                            <input name="quantity" type="hidden" value="1">
                                            <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                <i class="fa fa-shopping-basket"></i>
                                            </button>
                                        </form>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                            <?php if($row['fiyat_goster'] == '2' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <?php if($row['siparis_islem'] == '0'  ) {?>
                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                            <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                <i class="fa fa-shopping-basket"></i>
                                            </button>
                                        <?php }else { ?>
                                            <form action="addtocart" method="post" >
                                                <input name="product_code" type="hidden" value="<?php echo $row["id"]; ?>">
                                                <input name="token" type="hidden" value="<?=md5(sha1('homepageCallBack'))?>">
                                                <input name="quantity" type="hidden" value="1">
                                                <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                    <i class="fa fa-shopping-basket"></i>
                                                </button>
                                            </form>
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                            <?php if($row['fiyat_goster'] == '3' ) {?>
                                <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                                    <?php if($row['siparis_islem'] == '0'  ) {?>
                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                            <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                <i class="fa fa-shopping-basket"></i>
                                            </button>
                                        <?php }else { ?>
                                            <form action="addtocart" method="post" >
                                                <input name="product_code" type="hidden" value="<?php echo $row["id"]; ?>">
                                                <input name="token" type="hidden" value="<?=md5(sha1('homepageCallBack'))?>">
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
                                        'urun_id' => $row['id']
                                    ));
                                    $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                        <a href="#" class="tooltip-right product-fav-del" data-code="<?php echo $row['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" style="background-color: #f08183; color: #FFF;">
                                            <i class="fa fa-heart-o"></i>
                                        </a>
                                    <?php }else { ?>
                                        <a href="#" class="tooltip-right product-fav-go" data-code="<?php echo $row['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>">
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
                            <?php if(isset($_SESSION['compare_product'][$row['id']] )) {?>
                                <a href="#" style="background-color: #f08183; color: #FFF;" data-code="<?php echo $row['id']; ?>" class="tooltip-right product-compare-exit" data-tooltip="<?=$diller['urun-box-text8']?>">
                                    <i class="fa fa-random"></i>
                                </a>
                            <?php }else { ?>
                                <a href="#" class="tooltip-right product-compare" data-code="<?php echo $row['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>">
                                    <i class="fa fa-random"></i>
                                </a>
                            <?php }?>
                        <?php } ?>


                    </div>
                <?php } ?>
            <?php } ?>
            <div class="<?= $box_gorunum_img_div ?> <?php if($row['stok'] <= '0' ) { ?>product-grey-img<?php }?>">
                <?php if ($urunKutuRow['kutu_kargo_goster'] == '1') { ?>
                    <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                        <?php if($row['kargo'] == '0' ) {?>
                            <div class="cat-detail-products-box-kargo">
                                <i class="fa fa-truck"></i> <?=$diller['urun-box-text5']?>
                            </div>
                        <?php }?>
                    <?php }?>
                <?php } ?>
                <a href="<?=$row['seo_url']?>-P<?=$row['id']?>" >
                    <?php if($ayar['lazy'] == '1' ) {?>
                        <img class="lazy" src="images/load.gif" data-original="images/product/<?=$row['gorsel']?>" alt="<?php echo $row['baslik'] ?>">
                    <?php }else { ?>
                        <img src="images/product/<?=$row['gorsel']?>" alt="<?=$row['baslik']?>">
                    <?php }?>
                </a>
            </div>

            <div class="<?= $box_gorunum_info_div ?>">



                <?php if ($urunKutuRow['kutu_star_rate'] == '1') { ?>
                    <?php if($uyeayar['durum'] == '0' ) {
                        /* Üyelik Sistemi Devre Dışı ise Yöneticinin belirlediği yıldızları getir */
                        ?>
                        <div class="cat-detail-products-box-stars">
                            <?php if($row['star_rate'] == '0' ) {?>
                                <span class="pasif-span">★★★★★</span>
                            <?php }?>
                            <?php if($row['star_rate'] == '1' ) {?>
                                <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                            <?php }?>
                            <?php if($row['star_rate'] == '2' ) {?>
                                <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                            <?php }?>
                            <?php if($row['star_rate'] == '3' ) {?>
                                <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                            <?php }?>
                            <?php if($row['star_rate'] == '4' ) {?>
                                <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                            <?php }?>
                            <?php if($row['star_rate'] == '5' ) {?>
                                <span class="aktif-span">★★★★★</span>
                            <?php }?>
                        </div>
                    <?php }else {
                        /* Üyelik var. Ürünün yorum durumunu kontrol et yorumlanabilir ise bilgileri çek yorumlanamaz ise yöneticinin belirlediğini ekrana yazdır */
                        ?>
                        <?php if($row['yorum_durum'] == '0' ) {
                            /* YORUM VE DEĞERLENDİRME YAPILAMAZ! */
                            ?>
                            <div class="cat-detail-products-box-stars">
                                <?php if($row['star_rate'] == '0' ) {?>
                                    <span class="pasif-span">★★★★★</span>
                                <?php }?>
                                <?php if($row['star_rate'] == '1' ) {?>
                                    <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                                <?php }?>
                                <?php if($row['star_rate'] == '2' ) {?>
                                    <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                                <?php }?>
                                <?php if($row['star_rate'] == '3' ) {?>
                                    <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                                <?php }?>
                                <?php if($row['star_rate'] == '4' ) {?>
                                    <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                                <?php }?>
                                <?php if($row['star_rate'] == '5' ) {?>
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
                    <?php if($row['marka'] >'0' && $row['marka'] == !null && $kutuMarka->rowCount()>'0') {?>
                        <div class="cat-detail-products-box-marka">
                            <a href="marka/<?=$urunmarka['seo_url']?>/" style="color: #<?= $urunKutuRow['kutu_marka_renk'] ?>;">
                                <?=$urunmarka['baslik']?>
                            </a>
                        </div>
                    <?php }?>
                <?php } ?>
                <div class="cat-detail-products-box-h">
                    <a href="<?=$row['seo_url']?>-P<?=$row['id']?>" style="color: #<?= $urunKutuRow['kutu_yazi_renk'] ?>;">
                        <?=$row['baslik']?>
                    </a>
                </div>
            </div>
            <?php if($row['fiyat_goster'] == '1' && $row['stok'] > '0' ) {?>
                <div class="<?= $box_gorunum_price_div ?>" >
                    <div class="cat-detail-products-box-fiyat-out">
                        <?php if($row['indirim'] == '1' && $row['eski_fiyat'] > '0') {?>
                            <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                <?=kur_cekimi($row['eski_fiyat'])?>
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
                                                        <?=kur_cekimi_nospan($row['fiyat'])?>
                                                        ">
                                                <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <?=kur_cekimi($box_fiyat)?>
                                <?php }?>
                            <?php }else { ?>
                                <?php if($box_fiyat_uyari == '1'  ) {?>
                                    <div class="cat-detail-products-box-special-out">
                                        <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                         <?=kur_cekimi_nospan($row['fiyat'])?>
                                                        ">
                                            <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                        </div>
                                    </div>
                                <?php }?>
                                <?=kur_cekimi($box_fiyat)?>
                            <?php }?>

                        </div>
                    </div>
                    <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                        <?php
                        if($row['indirim'] == '1' && $row['eski_fiyat'] >'0' ) {
                            ?>
                            <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                % <?=(int)$indirimorani?>
                            </div>
                        <?php }} ?>
                </div>
            <?php }?>
            <?php if($row['fiyat_goster'] == '2' && $row['stok'] > '0') {?>
                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                    <div class="<?= $box_gorunum_price_div ?>" >
                        <div class="cat-detail-products-box-fiyat-out">
                            <?php if($row['indirim'] == '1' && $row['eski_fiyat'] > '0') {?>
                                <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                    <?=kur_cekimi($row['eski_fiyat'])?>
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
                                                        <?=kur_cekimi_nospan($row['fiyat'])?>
                                                        ">
                                                    <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?=kur_cekimi($box_fiyat)?>
                                    <?php }?>
                                <?php }else { ?>
                                    <?php if($box_fiyat_uyari == '1'  ) {?>
                                        <div class="cat-detail-products-box-special-out">
                                            <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                          <?=kur_cekimi_nospan($row['fiyat'])?>
                                                        ">
                                                <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <?=kur_cekimi($box_fiyat)?>
                                <?php }?>

                            </div>
                        </div>
                        <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                            <?php
                            if($row['indirim'] == '1' && $row['eski_fiyat'] >'0' ) {
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
            <?php if($row['fiyat_goster'] == '3' && $row['stok'] > '0' ) {?>
                <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                    <div class="<?= $box_gorunum_price_div ?>" >
                        <div class="cat-detail-products-box-fiyat-out">
                            <?php if($row['indirim'] == '1' && $row['eski_fiyat'] > '0') {?>
                                <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                    <?=kur_cekimi($row['eski_fiyat'])?>
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
                                                        <?=kur_cekimi_nospan($row['fiyat'])?>
                                                        ">
                                                    <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?=kur_cekimi($box_fiyat)?>
                                    <?php }?>
                                <?php }else { ?>
                                    <?php if($box_fiyat_uyari == '1'  ) {?>
                                        <div class="cat-detail-products-box-special-out">
                                            <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                         <?=kur_cekimi_nospan($row['fiyat'])?>
                                                        ">
                                                <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <?=kur_cekimi($box_fiyat)?>
                                <?php }?>
                            </div>
                        </div>
                        <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                            <?php
                            if($row['indirim'] == '1' && $row['eski_fiyat'] >'0' ) {
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
            <?php if($row['stok'] <= '0' ) {?>
                <div class="<?= $box_gorunum_price_div ?>" >
                    <div class="cat-detail-products-box-fiyat-out button-red button-1x" style="width: 100%; text-align: center;">
                        <?=$diller['urun-detay-stok-durum-yok']?>
                    </div>
                </div>
            <?php }?>

            <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '2') { ?>
                <?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?>
                    <div class="cat-detail-products-box-cart-2">
                        <?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $row['stok'] > '0') { ?>
                            <?php if($row['fiyat_goster'] == '1' ) {?>
                                <?php if($row['siparis_islem'] == '0'  ) {?>
                                    <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                        <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                    <?php }else { ?>
                                        <form action="addtocart" method="post" >
                                            <input name="product_code" type="hidden" value="<?php echo $row["id"]; ?>">
                                            <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                            <input name="quantity" type="hidden" value="1">
                                            <button name="addtocart" >
                                                <i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?>
                                            </button>
                                        </form>
                                    <?php }} ?>
                            <?php } ?>

                            <?php if($row['fiyat_goster'] == '2' ) {?>
                                <?php if($userSorgusu->rowCount()>'0' ) {?>
                                    <?php if($row['siparis_islem'] == '0'  ) {?>
                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                            <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                        <?php }else { ?>
                                            <form action="addtocart" method="post" >
                                                <input name="product_code" type="hidden" value="<?php echo $row["id"]; ?>">
                                                <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                <input name="quantity" type="hidden" value="1">
                                                <button name="addtocart" >
                                                    <i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?>
                                                </button>
                                            </form>
                                        <?php } ?>
                                    <?php }?>
                                <?php }?>
                            <?php } ?>
                            <?php if($row['fiyat_goster'] == '3' ) {?>
                                <?php if($uyegruplariCek->rowCount()>'0' ) {?>
                                    <?php if($row['siparis_islem'] == '0'  ) {?>
                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                            <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                        <?php }else { ?>
                                            <form action="addtocart" method="post" >
                                                <input name="product_code" type="hidden" value="<?php echo $row["id"]; ?>">
                                                <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                <input name="quantity" type="hidden" value="1">
                                                <button name="addtocart" >
                                                    <i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?>
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
                                        'urun_id' => $row['id']
                                    ));
                                    $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                        <a href="#" class="tooltip-bottom product-fav-del" data-code="<?php echo $row['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" >
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    <?php }else { ?>
                                        <a href="#" class="tooltip-bottom product-fav-go compare-href" data-code="<?php echo $row['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>">
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
                            <?php if(isset($_SESSION['compare_product'][$row['id']] )) {?>
                                <a href="#" class=" tooltip-bottom product-compare-exit" data-code="<?php echo $row['id']; ?>" data-tooltip="<?=$diller['urun-box-text8']?>">
                                    <i class="fa fa-random"></i>
                                </a>
                            <?php }else { ?>
                                <a href="#" class="compare-href tooltip-bottom product-compare" data-code="<?php echo $row['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>">
                                    <i class="fa fa-random"></i>
                                </a>
                            <?php }?>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php }}?>
<?php function urunBoxKategoriliVitrin($sorguAdi){
    global $db;
    global $userSorgusu;
    global $urunset;
    global $tip1Ayar;
    global $urunKutuRow;
    global $userCek;
    global $uyegruplariCek;
    global $uyegrup;
    global $varsayilankur;
    global $secilikur;
    global $dil;
    global $vitrintip1;
    global $ayar;
    global $uyeayar;
    global $odemeayar;
    global $box_gorunum_turu;
    global $box_gorunum_main_div;
    global $box_gorunum_img_div;
    global $box_gorunum_info_div;
    global $box_gorunum_price_div;
    global $box_gorunum_hiddenprice_div;
    global $gr;
    include 'includes/lang/'.$dil.'.php';
    ?>
    <?php foreach ($sorguAdi as $row) {

        $urunWhile = $db->prepare("select * from urun where id=:id and durum=:durum ");
        $urunWhile->execute(array(
            'id' => $row['urun_id'],
            'durum' => '1'
        ));
        $urunRow = $urunWhile->fetch(PDO::FETCH_ASSOC);


        $kutuMarka = $db->prepare("select * from urun_marka where id=:id and durum=:durum ");
        $kutuMarka->execute(array(
            'id' => $urunRow['marka'],
            'durum' => '1'
        ));
        $urunmarka = $kutuMarka->fetch(PDO::FETCH_ASSOC);
        /* Fiyatı Çıkar */
        if($userSorgusu->rowCount()>'0'  ) {
            if($uyegruplariCek->rowCount()>'0'  ) {
                if($uyegrup['fiyat_tip'] == '0'  ) {
                    $box_fiyat = $urunRow['fiyat'];
                    $box_fiyat_uyari = '0';
                }
                if($uyegrup['fiyat_tip'] == '1'  ) {
                    if($urunRow['fiyat_tip2'] >'0' ) {
                        $box_fiyat = $urunRow['fiyat_tip2'];
                        $box_fiyat_uyari = '1';
                    }else{
                        $box_fiyat = $urunRow['fiyat'];
                        $box_fiyat_uyari = '0';
                    }
                }
            }else{
                $box_fiyat = $urunRow['fiyat'];
                $box_fiyat_uyari = '0';
            }
        }else{
            $box_fiyat = $urunRow['fiyat'];
            $box_fiyat_uyari = '0';
        }
        /*  <========SON=========>>> Fiyatı Çıkar SON */
        /* İndirim Oranı */
        if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {
            $indirimorani = 100 - (($box_fiyat / $urunRow['eski_fiyat']) * 100);
        }
        /*  <========SON=========>>> İndirim Oranı SON */
        /* Ürünün Yorum ve Değerlendirme Ortalaması */
        $urunYildizlari = $db->prepare("SELECT SUM(yildiz) AS orta FROM urun_yorum where onay=:onay and urun_id=:urun_id; ");
        $urunYildizlari->execute(array(
            'onay' => '1',
            'urun_id' => $urunRow['id']
        ));
        $yildizToplami = $urunYildizlari->fetch(PDO::FETCH_ASSOC);

        $urunYorumToplamSayi = $db->prepare("select * from urun_yorum where onay=:onay and urun_id=:urun_id ");
        $urunYorumToplamSayi->execute(array(
            'onay' => '1',
            'urun_id' => $urunRow['id']
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
            'urun_id' => $urunRow['id']
        ));
        /*  <========SON=========>>> Varyant Sorgu SON */

        ?>
        <?php if($urunWhile->rowCount()>'0'  ) {?>
            <div class="cat-detail-products-box-caturunvitrin">
                <?php if ($urunKutuRow['kutu_yeni_ribbon'] == '1') { ?>
                    <?php if($urunRow['yeni'] == '1' ) {?>
                        <div class="ribbon"><span><?=$diller['urun-box-text4']?></span></div>
                    <?php }?>
                <?php } ?>
                <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '1') { ?>
                    <?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?>
                        <div class="cat-detail-products-box-cart-1">
                            <?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $urunRow['stok'] > '0') { ?>
                                <?php if($urunRow['fiyat_goster'] == '1' ) {?>
                                    <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                            <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                <i class="fa fa-shopping-basket"></i>
                                            </button>
                                        <?php }else { ?>
                                            <form action="addtocart" method="post" >
                                                <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                <input name="quantity" type="hidden" value="1">
                                                <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                    <i class="fa fa-shopping-basket"></i>
                                                </button>
                                            </form>
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                                <?php if($urunRow['fiyat_goster'] == '2' ) {?>
                                    <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                        <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                            <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                    <i class="fa fa-shopping-basket"></i>
                                                </button>
                                            <?php }else { ?>
                                                <form action="addtocart" method="post" >
                                                    <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                    <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                    <input name="quantity" type="hidden" value="1">
                                                    <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                        <i class="fa fa-shopping-basket"></i>
                                                    </button>
                                                </form>
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                                <?php if($urunRow['fiyat_goster'] == '3' ) {?>
                                    <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                                        <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                            <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                    <i class="fa fa-shopping-basket"></i>
                                                </button>
                                            <?php }else { ?>
                                                <form action="addtocart" method="post" >
                                                    <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                    <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
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
                                            'urun_id' => $urunRow['id']
                                        ));
                                        $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                            <a href="#" class="tooltip-right product-fav-del" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" style="background-color: #f08183; color: #FFF;">
                                                <i class="fa fa-heart-o"></i>
                                            </a>
                                        <?php }else { ?>
                                            <a href="#" class="tooltip-right product-fav-go" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>">
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
                                <?php if(isset($_SESSION['compare_product'][$urunRow['id']] )) {?>
                                    <a href="#" style="background-color: #f08183; color: #FFF;" data-code="<?php echo $urunRow['id']; ?>" class="tooltip-right product-compare-exit" data-tooltip="<?=$diller['urun-box-text8']?>">
                                        <i class="fa fa-random"></i>
                                    </a>
                                <?php }else { ?>
                                    <a href="#" class="tooltip-right product-compare" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>">
                                        <i class="fa fa-random"></i>
                                    </a>
                                <?php }?>
                            <?php } ?>


                        </div>
                    <?php } ?>
                <?php } ?>
                <div class="<?php if($vitrintip1['gorsel'] == !null) { ?>cat-detail-products-box-caturunvitrin-img<?php }else{?><?php if($tip1Ayar['vitrin_grid'] == '3' ) { ?>cat-detail-products-box-caturunvitrin-img-3<?php }?><?php if($tip1Ayar['vitrin_grid'] == '4' ) { ?>cat-detail-products-box-caturunvitrin-img-4<?php }?><?php if($tip1Ayar['vitrin_grid'] == '5' ) { ?>cat-detail-products-box-caturunvitrin-img-5<?php }?><?php }?> <?php if($urunRow['stok'] <= '0' ) { ?>product-grey-img<?php }?>">
                    <?php if ($urunKutuRow['kutu_kargo_goster'] == '1') { ?>
                        <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                            <?php if($urunRow['kargo'] == '0' ) {?>
                                <div class="cat-detail-products-box-kargo">
                                    <i class="fa fa-truck"></i> <?=$diller['urun-box-text5']?>
                                </div>
                            <?php }?>
                        <?php }?>
                    <?php } ?>
                    <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" >
                        <?php if($ayar['lazy'] == '1' ) {?>
                            <img class="lazy" src="images/load.gif" data-original="images/product/<?=$urunRow['gorsel']?>" alt="<?php echo $urunRow['baslik'] ?>">
                        <?php }else { ?>
                            <img src="images/product/<?=$urunRow['gorsel']?>" alt="<?=$urunRow['baslik']?>">
                        <?php }?>
                    </a>
                </div>

                <div class="cat-detail-products-box-caturunvitrin-info">



                    <?php if ($urunKutuRow['kutu_star_rate'] == '1') { ?>
                        <?php if($uyeayar['durum'] == '0' ) {
                            /* Üyelik Sistemi Devre Dışı ise Yöneticinin belirlediği yıldızları getir */
                            ?>
                            <div class="cat-detail-products-box-stars">
                                <?php if($urunRow['star_rate'] == '0' ) {?>
                                    <span class="pasif-span">★★★★★</span>
                                <?php }?>
                                <?php if($urunRow['star_rate'] == '1' ) {?>
                                    <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                                <?php }?>
                                <?php if($urunRow['star_rate'] == '2' ) {?>
                                    <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                                <?php }?>
                                <?php if($urunRow['star_rate'] == '3' ) {?>
                                    <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                                <?php }?>
                                <?php if($urunRow['star_rate'] == '4' ) {?>
                                    <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                                <?php }?>
                                <?php if($urunRow['star_rate'] == '5' ) {?>
                                    <span class="aktif-span">★★★★★</span>
                                <?php }?>
                            </div>
                        <?php }else {
                            /* Üyelik var. Ürünün yorum durumunu kontrol et yorumlanabilir ise bilgileri çek yorumlanamaz ise yöneticinin belirlediğini ekrana yazdır */
                            ?>
                            <?php if($urunRow['yorum_durum'] == '0' ) {
                                /* YORUM VE DEĞERLENDİRME YAPILAMAZ! */
                                ?>
                                <div class="cat-detail-products-box-stars">
                                    <?php if($urunRow['star_rate'] == '0' ) {?>
                                        <span class="pasif-span">★★★★★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '1' ) {?>
                                        <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '2' ) {?>
                                        <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '3' ) {?>
                                        <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '4' ) {?>
                                        <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '5' ) {?>
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
                        <?php if($urunRow['marka'] >'0' && $urunRow['marka'] == !null && $kutuMarka->rowCount()>'0') {?>
                            <div class="cat-detail-products-box-marka">
                                <a href="marka/<?=$urunmarka['seo_url']?>/" style="color: #<?= $urunKutuRow['kutu_marka_renk'] ?>;">
                                    <?=$urunmarka['baslik']?>
                                </a>
                            </div>
                        <?php }?>
                    <?php } ?>
                    <div class="cat-detail-products-box-caturunvitrin-h">
                        <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" style="color: #<?=$urunKutuRow['kutu_yazi_renk'] ?>;">
                            <?=$urunRow['baslik']?>
                        </a>
                    </div>
                </div>
                <?php if($urunRow['fiyat_goster'] == '1' && $urunRow['stok'] > '0' ) {?>
                    <div class="cat-detail-products-box-caturunvitrin-fiyat" >
                        <div class="cat-detail-products-box-fiyat-out">
                            <?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?>
                                <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                    <?=kur_cekimi($urunRow['eski_fiyat'])?>
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
                                                         <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                    <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?=kur_cekimi($box_fiyat)?>
                                    <?php }?>
                                <?php }else { ?>
                                    <?php if($box_fiyat_uyari == '1'  ) {?>
                                        <div class="cat-detail-products-box-special-out">
                                            <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                         <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <?=kur_cekimi($box_fiyat)?>
                                <?php }?>

                            </div>
                        </div>
                        <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                            <?php
                            if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {
                                ?>
                                <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                    % <?=(int)$indirimorani?>
                                </div>
                            <?php }} ?>
                    </div>
                <?php }?>
                <?php if($urunRow['fiyat_goster'] == '2' && $urunRow['stok'] > '0') {?>
                    <?php if($userSorgusu->rowCount()>'0'  ) {?>
                        <div class="cat-detail-products-box-caturunvitrin-fiyat" >
                            <div class="cat-detail-products-box-fiyat-out">
                                <?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?>
                                    <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                        <?=kur_cekimi($urunRow['eski_fiyat'])?>
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
                                                    <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                        <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?=kur_cekimi($box_fiyat)?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($box_fiyat_uyari == '1'  ) {?>
                                            <div class="cat-detail-products-box-special-out">
                                                <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                        <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                    <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?=kur_cekimi($box_fiyat)?>
                                    <?php }?>

                                </div>
                            </div>
                            <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                                <?php
                                if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {
                                    ?>
                                    <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                        % <?=(int)$indirimorani?>
                                    </div>
                                <?php }} ?>
                        </div>
                    <?php }else { ?>
                        <?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                            <div class="urun-box-special-area-caturunvitrin"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text22']?></div>
                        <?php }?>
                    <?php }?>
                <?php }?>
                <?php if($urunRow['fiyat_goster'] == '3' && $urunRow['stok'] > '0' ) {?>
                    <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                        <div class="cat-detail-products-box-caturunvitrin-fiyat" >
                            <div class="cat-detail-products-box-fiyat-out">
                                <?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?>
                                    <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                        <?=kur_cekimi($urunRow['eski_fiyat'])?>
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
                                                         <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                        <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?=kur_cekimi($box_fiyat)?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($box_fiyat_uyari == '1'  ) {?>
                                            <div class="cat-detail-products-box-special-out">
                                                <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                          <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                    <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?=kur_cekimi($box_fiyat)?>
                                    <?php }?>
                                </div>
                            </div>
                            <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                                <?php
                                if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {
                                    ?>
                                    <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                        % <?=(int)$indirimorani?>
                                    </div>
                                <?php }} ?>
                        </div>
                    <?php }else { ?>
                        <?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                            <div class="urun-box-special-area-caturunvitrin"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text23']?></div>
                        <?php }?>
                    <?php }?>
                <?php }?>
                <?php if($urunRow['stok'] <= '0' ) {?>
                    <div class="cat-detail-products-box-caturunvitrin-fiyat" >
                        <div class="cat-detail-products-box-fiyat-out button-red button-1x" style="width: 100%; text-align: center;">
                            <?=$diller['urun-detay-stok-durum-yok']?>
                        </div>
                    </div>
                <?php }?>

                <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '2') { ?>
                    <?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?>
                        <div class="cat-detail-products-box-cart-2">

                            <?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $urunRow['stok'] > '0') { ?>
                                <?php if($urunRow['fiyat_goster'] == '1' ) {?>
                                    <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                        <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                            <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                        <?php }else { ?>
                                            <form action="addtocart" method="post" >
                                                <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                <input name="quantity" type="hidden" value="1">
                                                <button name="addtocart" >
                                                    <i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?>
                                                </button>
                                            </form>
                                        <?php }} ?>
                                <?php } ?>

                                <?php if($urunRow['fiyat_goster'] == '2' ) {?>
                                    <?php if($userSorgusu->rowCount()>'0' ) {?>
                                        <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                            <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                            <?php }else { ?>
                                                <form action="addtocart" method="post" >
                                                    <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                    <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                    <input name="quantity" type="hidden" value="1">
                                                    <button name="addtocart" >
                                                        <i class="fa fa-shopping-cart"></i>  <?=$diller['urun-box-text1']?>
                                                    </button>
                                                </form>
                                            <?php } ?>
                                        <?php }?>
                                    <?php }?>
                                <?php } ?>
                                <?php if($urunRow['fiyat_goster'] == '3' ) {?>
                                    <?php if($uyegruplariCek->rowCount()>'0' ) {?>
                                        <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                            <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                            <?php }else { ?>
                                                <form action="addtocart" method="post" >
                                                    <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                    <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                    <input name="quantity" type="hidden" value="1">
                                                    <button name="addtocart" >
                                                        <i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?>
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
                                            'urun_id' => $urunRow['id']
                                        ));
                                        $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                            <a href="#" class="tooltip-bottom product-fav-del" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" >
                                                <i class="fa fa-heart"></i>
                                            </a>
                                        <?php }else { ?>
                                            <a href="#" class="tooltip-bottom product-fav-go compare-href" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>">
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
                                <?php if(isset($_SESSION['compare_product'][$urunRow['id']] )) {?>
                                    <a href="#" class=" tooltip-bottom product-compare-exit" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text8']?>">
                                        <i class="fa fa-random"></i>
                                    </a>
                                <?php }else { ?>
                                    <a href="#" class="compare-href tooltip-bottom product-compare" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>">
                                        <i class="fa fa-random"></i>
                                    </a>
                                <?php }?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

        <?php }?>
    <?php }}?>
<?php function urunBoxKategoriliVitrin_slider($sorguAdi){
    global $db;
    global $userSorgusu;
    global $urunset;
    global $tip1Ayar;
    global $userCek;
    global $uyegruplariCek;
    global $urunKutuRow;
    global $uyegrup;
    global $varsayilankur;
    global $secilikur;
    global $dil;
    global $vitrintip1;
    global $ayar;
    global $uyeayar;
    global $odemeayar;
    global $box_gorunum_turu;
    global $box_gorunum_main_div;
    global $box_gorunum_img_div;
    global $box_gorunum_info_div;
    global $box_gorunum_price_div;
    global $box_gorunum_hiddenprice_div;
    global $gr;
    global $diller;
    ?>
    <?php foreach ($sorguAdi as $row) {

        $urunWhile = $db->prepare("select * from urun where id=:id and durum=:durum ");
        $urunWhile->execute(array(
            'id' => $row['urun_id'],
            'durum' => '1'
        ));
        $urunRow = $urunWhile->fetch(PDO::FETCH_ASSOC);


        $kutuMarka = $db->prepare("select * from urun_marka where id=:id and durum=:durum ");
        $kutuMarka->execute(array(
            'id' => $urunRow['marka'],
            'durum' => '1'
        ));
        $urunmarka = $kutuMarka->fetch(PDO::FETCH_ASSOC);
        /* Fiyatı Çıkar */
        if($userSorgusu->rowCount()>'0'  ) {
            if($uyegruplariCek->rowCount()>'0'  ) {
                if($uyegrup['fiyat_tip'] == '0'  ) {
                    $box_fiyat = $urunRow['fiyat'];
                    $box_fiyat_uyari = '0';
                }
                if($uyegrup['fiyat_tip'] == '1'  ) {
                    if($urunRow['fiyat_tip2'] >'0' ) {
                        $box_fiyat = $urunRow['fiyat_tip2'];
                        $box_fiyat_uyari = '1';
                    }else{
                        $box_fiyat = $urunRow['fiyat'];
                        $box_fiyat_uyari = '0';
                    }
                }
            }else{
                $box_fiyat = $urunRow['fiyat'];
                $box_fiyat_uyari = '0';
            }
        }else{
            $box_fiyat = $urunRow['fiyat'];
            $box_fiyat_uyari = '0';
        }
        /*  <========SON=========>>> Fiyatı Çıkar SON */
        /* İndirim Oranı */
        if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {
            $indirimorani = 100 - (($box_fiyat / $urunRow['eski_fiyat']) * 100);
        }
        /*  <========SON=========>>> İndirim Oranı SON */
        /* Ürünün Yorum ve Değerlendirme Ortalaması */
        $urunYildizlari = $db->prepare("SELECT SUM(yildiz) AS orta FROM urun_yorum where onay=:onay and urun_id=:urun_id; ");
        $urunYildizlari->execute(array(
            'onay' => '1',
            'urun_id' => $urunRow['id']
        ));
        $yildizToplami = $urunYildizlari->fetch(PDO::FETCH_ASSOC);

        $urunYorumToplamSayi = $db->prepare("select * from urun_yorum where onay=:onay and urun_id=:urun_id ");
        $urunYorumToplamSayi->execute(array(
            'onay' => '1',
            'urun_id' => $urunRow['id']
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
            'urun_id' => $urunRow['id']
        ));
        /*  <========SON=========>>> Varyant Sorgu SON */

        ?>
        <?php if($urunWhile->rowCount()>'0'  ) {?>
            <div class="swiper-slide" style=" height: 100% !important;">
                <div class="cat-detail-products-box-caturunvitrin" style="width: 100%; margin:0; height: 100% !important ">

                    <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '1') { ?>
                        <?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?>
                            <div class="cat-detail-products-box-cart-1">
                                <?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $urunRow['stok'] > '0') { ?>
                                    <?php if($urunRow['fiyat_goster'] == '1' ) {?>
                                        <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                            <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                    <i class="fa fa-shopping-basket"></i>
                                                </button>
                                            <?php }else { ?>
                                                <form action="addtocart" method="post" >
                                                    <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                    <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                    <input name="quantity" type="hidden" value="1">
                                                    <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                        <i class="fa fa-shopping-basket"></i>
                                                    </button>
                                                </form>
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                    <?php if($urunRow['fiyat_goster'] == '2' ) {?>
                                        <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                            <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                                <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                    <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                        <i class="fa fa-shopping-basket"></i>
                                                    </button>
                                                <?php }else { ?>
                                                    <form action="addtocart" method="post" >
                                                        <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                        <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                        <input name="quantity" type="hidden" value="1">
                                                        <button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                            <i class="fa fa-shopping-basket"></i>
                                                        </button>
                                                    </form>
                                                <?php }?>
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                    <?php if($urunRow['fiyat_goster'] == '3' ) {?>
                                        <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                                            <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                                <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                    <button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>">
                                                        <i class="fa fa-shopping-basket"></i>
                                                    </button>
                                                <?php }else { ?>
                                                    <form action="addtocart" method="post" >
                                                        <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                        <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
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
                                                'urun_id' => $urunRow['id']
                                            ));
                                            $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                                <a href="#" class="tooltip-right product-fav-del" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" style="background-color: #f08183; color: #FFF;">
                                                    <i class="fa fa-heart-o"></i>
                                                </a>
                                            <?php }else { ?>
                                                <a href="#" class="tooltip-right product-fav-go" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>">
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
                                    <?php if(isset($_SESSION['compare_product'][$urunRow['id']] )) {?>
                                        <a href="#" style="background-color: #f08183; color: #FFF;" data-code="<?php echo $urunRow['id']; ?>" class="tooltip-right product-compare-exit" data-tooltip="<?=$diller['urun-box-text8']?>">
                                            <i class="fa fa-random"></i>
                                        </a>
                                    <?php }else { ?>
                                        <a href="#" class="tooltip-right product-compare" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>">
                                            <i class="fa fa-random"></i>
                                        </a>
                                    <?php }?>
                                <?php } ?>


                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="<?php if($vitrintip1['gorsel'] == !null) { ?>cat-detail-products-box-caturunvitrin-img<?php }else{?><?php if($tip1Ayar['vitrin_grid'] == '3' ) { ?>cat-detail-products-box-caturunvitrin-img-3<?php }?><?php if($tip1Ayar['vitrin_grid'] == '4' ) { ?>cat-detail-products-box-caturunvitrin-img-4<?php }?><?php if($tip1Ayar['vitrin_grid'] == '5' ) { ?>cat-detail-products-box-caturunvitrin-img-5<?php }?><?php }?> <?php if($urunRow['stok'] <= '0' ) { ?>product-grey-img<?php }?>">
                        <?php if ($urunKutuRow['kutu_kargo_goster'] == '1') { ?>
                            <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                                <?php if($urunRow['kargo'] == '0' ) {?>
                                    <div class="cat-detail-products-box-kargo">
                                        <i class="fa fa-truck"></i> <?=$diller['urun-box-text5']?>
                                    </div>
                                <?php }?>
                            <?php }?>
                        <?php } ?>
                        <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" >
                            <?php if($ayar['lazy'] == '1' ) {?>
                                <img class="lazy" src="images/load.gif" data-original="images/product/<?=$urunRow['gorsel']?>" alt="<?php echo $urunRow['baslik'] ?>">
                            <?php }else { ?>
                                <img src="images/product/<?=$urunRow['gorsel']?>" alt="<?=$urunRow['baslik']?>">
                            <?php }?>
                        </a>
                    </div>

                    <div class="cat-detail-products-box-caturunvitrin-info">



                        <?php if ($urunKutuRow['kutu_star_rate'] == '1') { ?>
                            <?php if($uyeayar['durum'] == '0' ) {
                                /* Üyelik Sistemi Devre Dışı ise Yöneticinin belirlediği yıldızları getir */
                                ?>
                                <div class="cat-detail-products-box-stars">
                                    <?php if($urunRow['star_rate'] == '0' ) {?>
                                        <span class="pasif-span">★★★★★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '1' ) {?>
                                        <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '2' ) {?>
                                        <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '3' ) {?>
                                        <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '4' ) {?>
                                        <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                                    <?php }?>
                                    <?php if($urunRow['star_rate'] == '5' ) {?>
                                        <span class="aktif-span">★★★★★</span>
                                    <?php }?>
                                </div>
                            <?php }else {
                                /* Üyelik var. Ürünün yorum durumunu kontrol et yorumlanabilir ise bilgileri çek yorumlanamaz ise yöneticinin belirlediğini ekrana yazdır */
                                ?>
                                <?php if($urunRow['yorum_durum'] == '0' ) {
                                    /* YORUM VE DEĞERLENDİRME YAPILAMAZ! */
                                    ?>
                                    <div class="cat-detail-products-box-stars">
                                        <?php if($urunRow['star_rate'] == '0' ) {?>
                                            <span class="pasif-span">★★★★★</span>
                                        <?php }?>
                                        <?php if($urunRow['star_rate'] == '1' ) {?>
                                            <span class="aktif-span">★</span><span class="pasif-span">★★★★</span>
                                        <?php }?>
                                        <?php if($urunRow['star_rate'] == '2' ) {?>
                                            <span class="aktif-span">★★</span><span class="pasif-span">★★★</span>
                                        <?php }?>
                                        <?php if($urunRow['star_rate'] == '3' ) {?>
                                            <span class="aktif-span">★★★</span><span class="pasif-span">★★</span>
                                        <?php }?>
                                        <?php if($urunRow['star_rate'] == '4' ) {?>
                                            <span class="aktif-span">★★★★</span><span class="pasif-span">★</span>
                                        <?php }?>
                                        <?php if($urunRow['star_rate'] == '5' ) {?>
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
                            <?php if($urunRow['marka'] >'0' && $urunRow['marka'] == !null && $kutuMarka->rowCount()>'0') {?>
                                <div class="cat-detail-products-box-marka">
                                    <a href="marka/<?=$urunmarka['seo_url']?>/" style="color: #<?= $urunKutuRow['kutu_marka_renk'] ?>;">
                                        <?=$urunmarka['baslik']?>
                                    </a>
                                </div>
                            <?php }?>
                        <?php } ?>
                        <div class="cat-detail-products-box-caturunvitrin-h">
                            <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" style="color: #<?=$urunKutuRow['kutu_yazi_renk'] ?>;">
                                <?=$urunRow['baslik']?>
                            </a>
                        </div>
                    </div>
                    <?php if($urunRow['fiyat_goster'] == '1' && $urunRow['stok'] > '0' ) {?>
                        <div class="cat-detail-products-box-caturunvitrin-fiyat" >
                            <div class="cat-detail-products-box-fiyat-out">
                                <?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?>
                                    <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                        <?=kur_cekimi($urunRow['eski_fiyat'])?>
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
                                                         <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                        <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?=kur_cekimi($box_fiyat)?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($box_fiyat_uyari == '1'  ) {?>
                                            <div class="cat-detail-products-box-special-out">
                                                <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                         <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                    <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?=kur_cekimi($box_fiyat)?>
                                    <?php }?>

                                </div>
                            </div>
                            <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                                <?php
                                if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {
                                    ?>
                                    <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                        % <?=(int)$indirimorani?>
                                    </div>
                                <?php }} ?>
                        </div>
                    <?php }?>
                    <?php if($urunRow['fiyat_goster'] == '2' && $urunRow['stok'] > '0') {?>
                        <?php if($userSorgusu->rowCount()>'0'  ) {?>
                            <div class="cat-detail-products-box-caturunvitrin-fiyat" >
                                <div class="cat-detail-products-box-fiyat-out">
                                    <?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?>
                                        <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                            <?=kur_cekimi($urunRow['eski_fiyat'])?>
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
                                                    <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                            <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?=kur_cekimi($box_fiyat)?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <?php if($box_fiyat_uyari == '1'  ) {?>
                                                <div class="cat-detail-products-box-special-out">
                                                    <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                        <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                        <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?=kur_cekimi($box_fiyat)?>
                                        <?php }?>

                                    </div>
                                </div>
                                <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                                    <?php
                                    if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {
                                        ?>
                                        <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                            % <?=(int)$indirimorani?>
                                        </div>
                                    <?php }} ?>
                            </div>
                        <?php }else { ?>
                            <?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                                <div class="urun-box-special-area-caturunvitrin"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text22']?></div>
                            <?php }?>
                        <?php }?>
                    <?php }?>
                    <?php if($urunRow['fiyat_goster'] == '3' && $urunRow['stok'] > '0' ) {?>
                        <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                            <div class="cat-detail-products-box-caturunvitrin-fiyat" >
                                <div class="cat-detail-products-box-fiyat-out">
                                    <?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?>
                                        <div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;">
                                            <?=kur_cekimi($urunRow['eski_fiyat'])?>
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
                                                         <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                            <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?=kur_cekimi($box_fiyat)?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <?php if($box_fiyat_uyari == '1'  ) {?>
                                                <div class="cat-detail-products-box-special-out">
                                                    <div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> :
                                                          <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                        ">
                                                        <i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?=kur_cekimi($box_fiyat)?>
                                        <?php }?>
                                    </div>
                                </div>
                                <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                                    <?php
                                    if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {
                                        ?>
                                        <div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                                            % <?=(int)$indirimorani?>
                                        </div>
                                    <?php }} ?>
                            </div>
                        <?php }else { ?>
                            <?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                                <div class="urun-box-special-area-caturunvitrin"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text23']?></div>
                            <?php }?>
                        <?php }?>
                    <?php }?>
                    <?php if($urunRow['stok'] <= '0' ) {?>
                        <div class="cat-detail-products-box-caturunvitrin-fiyat" >
                            <div class="cat-detail-products-box-fiyat-out button-red button-1x" style="width: 100%; text-align: center;">
                                <?=$diller['urun-detay-stok-durum-yok']?>
                            </div>
                        </div>
                    <?php }?>

                    <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '2') { ?>
                        <?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?>
                            <div class="cat-detail-products-box-cart-2">

                                <?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $urunRow['stok'] > '0') { ?>
                                    <?php if($urunRow['fiyat_goster'] == '1' ) {?>
                                        <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                            <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                            <?php }else { ?>
                                                <form action="addtocart" method="post" >
                                                    <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                    <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                    <input name="quantity" type="hidden" value="1">
                                                    <button name="addtocart" >
                                                        <i class="fa fa-shopping-cart"></i>  <?=$diller['urun-box-text1']?>
                                                    </button>
                                                </form>
                                            <?php }} ?>
                                    <?php } ?>

                                    <?php if($urunRow['fiyat_goster'] == '2' ) {?>
                                        <?php if($userSorgusu->rowCount()>'0' ) {?>
                                            <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                                <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                    <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                                <?php }else { ?>
                                                    <form action="addtocart" method="post" >
                                                        <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                        <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                        <input name="quantity" type="hidden" value="1">
                                                        <button name="addtocart" >
                                                            <i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?>
                                                        </button>
                                                    </form>
                                                <?php } ?>
                                            <?php }?>
                                        <?php }?>
                                    <?php } ?>
                                    <?php if($urunRow['fiyat_goster'] == '3' ) {?>
                                        <?php if($uyegruplariCek->rowCount()>'0' ) {?>
                                            <?php if($urunRow['siparis_islem'] == '0'  ) {?>
                                                <?php if($varyantVarmi->rowCount()>'0'  ) {?>
                                                    <button data-toggle="modal" data-target="#varyantModal"><i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?></button>
                                                <?php }else { ?>
                                                    <form action="addtocart" method="post" >
                                                        <input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>">
                                                        <input name="token" type="hidden" value="<?=md5('homepageCallBack')?>">
                                                        <input name="quantity" type="hidden" value="1">
                                                        <button name="addtocart" >
                                                            <i class="fa fa-shopping-cart"></i> <?=$diller['urun-box-text1']?>
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
                                                'urun_id' => $urunRow['id']
                                            ));
                                            $urfav = $favCek->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <?php if($urfav['uye_id'] == $userCek['id']) {?>
                                                <a href="#" class="product-fav-del" data-code="<?php echo $urunRow['id']; ?>" >
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            <?php }else { ?>
                                                <a href="#" class="product-fav-go compare-href" data-code="<?php echo $urunRow['id']; ?>" >
                                                    <i class="fa fa-heart-o"></i>
                                                </a>
                                            <?php }?>
                                        <?php } else { ?>
                                            <a href="" data-toggle="modal" data-target="#loginModal" class="compare-href" >
                                                <i class="fa fa-heart-o"></i>
                                            </a>
                                        <?php }?>
                                    <?php } ?>
                                <?php } ?>


                                <?php if ($urunKutuRow['kutu_compare_button'] == '1' && $odemeayar['urun_karsilastirma'] == '1') { ?>
                                    <?php if(isset($_SESSION['compare_product'][$urunRow['id']] )) {?>
                                        <a href="#" class="product-compare-exit" data-code="<?php echo $urunRow['id']; ?>">
                                            <i class="fa fa-random"></i>
                                        </a>
                                    <?php }else { ?>
                                        <a href="#" class="compare-href  product-compare" data-code="<?php echo $urunRow['id']; ?>">
                                            <i class="fa fa-random"></i>
                                        </a>
                                    <?php }?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php }?>
    <?php }}?>
<?php function benzer_urunbox_starrate(){
    global $urunKutuRow;
    global $uyeayar;
    global $benzurun;
    global $finalstarrate_hit;
    if($urunKutuRow['kutu_star_rate'] == '1') {
        ?>
        <div class="urun-detay-benzer-urun-box-text-star">
            <?php if($uyeayar['durum'] == '0'  ) {?>
                <?php if($benzurun['star_rate'] == '0'  ) {?>
                    <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($benzurun['star_rate'] == '1'  ) {?>
                    <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($benzurun['star_rate'] == '2'){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($benzurun['star_rate'] == '3'){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($benzurun['star_rate'] == '4'){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($benzurun['star_rate'] == '5'){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                <?php }?>
            <?php }?>
            <?php if($uyeayar['durum'] == '1'  ) {?>
                <?php if($benzurun['yorum_durum'] == '0' ) {?>
                    <?php if($benzurun['star_rate'] == '0'){ ?>
                        <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($benzurun['star_rate'] == '1'){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($benzurun['star_rate'] == '2'){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($benzurun['star_rate'] == '3'){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($benzurun['star_rate'] == '4'){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($benzurun['star_rate'] == '5'){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                    <?php }?>
                <?php } ?>
                <?php if($benzurun['yorum_durum'] == '1' ) {?>
                    <?php if($uyeayar['durum'] == '1' ) {?>
                        <?php if($finalstarrate_hit == '0'){ ?>
                            <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                        <?php }?>
                        <?php if($finalstarrate_hit == '1'){ ?>
                            <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                        <?php }?>
                        <?php if($finalstarrate_hit == '2'){ ?>
                            <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                        <?php }?>
                        <?php if($finalstarrate_hit == '3'){ ?>
                            <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                        <?php }?>
                        <?php if($finalstarrate_hit == '4'){ ?>
                            <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                        <?php }?>
                        <?php if($finalstarrate_hit == '5'){ ?>
                            <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                        <?php }?>
                    <?php } ?>
                <?php } ?>
            <?php }?>
        </div>
    <?php  }} ?>
<?php function benzer_urunbox_fiyatlar(){
    global $benzurun;
    global $diller;
    global $varsayilankur;
    global $secilikur;
    global $odemeayar;
    global $box_fiyat;
    global $urunKutuRow;
    global $indirimorani;
    global $userSorgusu;
    global $uyegruplariCek;
    ?>
    <?php if($benzurun['fiyat_goster'] == '1' && $benzurun['stok'] > '0') {?>
        <div class="urun-detay-benzer-urun-box-text-price">
            <div>
                <?php if($benzurun['indirim'] == '1' && $benzurun['eski_fiyat'] > '0') {?>
                    <span style="font-size: 14px ; text-decoration: line-through; color: #999;">
                       <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                           <?=$secilikur['sol_simge']?>
                       <?php }?>
                       <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                           <?=$secilikur['sag_simge']?>
                       <?php }?>

                       <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$benzurun['eski_fiyat'] ), $secilikur['para_format']); ?>

                       <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                           <?=$secilikur['sol_simge']?>
                       <?php }?>
                       <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                           <?=$secilikur['sag_simge']?>
                       <?php }?>
            </span><br>
                <?php } ?>
                <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                    <?php if($box_fiyat == '0'  ) {?>
                        <strong><?=$diller['kategori-detay-text24']?></strong>
                    <?php }else { ?>
                        <span style="font-weight: bold;">
                <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                    <?=$secilikur['sol_simge']?>
                <?php }?>
                <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                    <?=$secilikur['sag_simge']?>
                <?php }?>
                <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$box_fiyat ), $secilikur['para_format']); ?>

                <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                    <?=$secilikur['sol_simge']?>
                <?php }?>
                <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                    <?=$secilikur['sag_simge']?>
                <?php }?>
        </span>
                    <?php } ?>
                <?php }else { ?>
                    <span style="font-weight: bold;">
            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                <?=$secilikur['sol_simge']?>
            <?php }?>
            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                <?=$secilikur['sag_simge']?>
            <?php }?>

            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$box_fiyat ), $secilikur['para_format']); ?>

            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                <?=$secilikur['sol_simge']?>
            <?php }?>
            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                <?=$secilikur['sag_simge']?>
            <?php }?>
            </span>
                <?php }?>
            </div>
            <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                <?php
                if($benzurun['indirim'] == '1' && $benzurun['eski_fiyat'] >'0' ) {
                    ?>
                    <div class="urun-detay-benzer-urun-box-text-price-discount tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                        % <?=(int)$indirimorani?>
                    </div>
                <?php }} ?>
        </div>
    <?php }?>
    <?php if($benzurun['fiyat_goster'] == '2' && $benzurun['stok'] > '0') {?>
        <?php if($userSorgusu->rowCount()>'0'  ) {?>
            <div class="urun-detay-benzer-urun-box-text-price">
                <div>
                    <?php if($benzurun['indirim'] == '1' && $benzurun['eski_fiyat'] > '0') {?>
                        <span style="font-size: 14px ; text-decoration: line-through;">
                       <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                           <?=$secilikur['sol_simge']?>
                       <?php }?>
                       <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                           <?=$secilikur['sag_simge']?>
                       <?php }?>

                       <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$benzurun['eski_fiyat'] ), $secilikur['para_format']); ?>

                       <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                           <?=$secilikur['sol_simge']?>
                       <?php }?>
                       <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                           <?=$secilikur['sag_simge']?>
                       <?php }?>
            </span><br>
                    <?php } ?>
                    <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                        <?php if($box_fiyat == '0'  ) {?>
                            <?=$diller['kategori-detay-text24']?>
                        <?php }else { ?>
                            <span style="font-weight: bold;">
                <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                    <?=$secilikur['sol_simge']?>
                <?php }?>
                <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                    <?=$secilikur['sag_simge']?>
                <?php }?>
                <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$box_fiyat ), $secilikur['para_format']); ?>

                <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                    <?=$secilikur['sol_simge']?>
                <?php }?>
                <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                    <?=$secilikur['sag_simge']?>
                <?php }?>
        </span>
                        <?php } ?>
                    <?php }else { ?>
                        <span style="font-weight: bold;">
            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                <?=$secilikur['sol_simge']?>
            <?php }?>
            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                <?=$secilikur['sag_simge']?>
            <?php }?>

            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$box_fiyat ), $secilikur['para_format']); ?>

            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                <?=$secilikur['sol_simge']?>
            <?php }?>
            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                <?=$secilikur['sag_simge']?>
            <?php }?>
            </span>
                    <?php }?>
                </div>
                <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                    <?php
                    if($benzurun['indirim'] == '1' && $benzurun['eski_fiyat'] >'0' ) {
                        ?>
                        <div class="urun-detay-benzer-urun-box-text-price-discount tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                            % <?=(int)$indirimorani?>
                        </div>
                    <?php }} ?>
            </div>
        <?php }else { ?>
            <?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                <div class="urun-detay-benzer-urun-box-text-price-hidden"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text22']?></div>
            <?php }?>
        <?php }?>
    <?php }?>
    <?php if($benzurun['fiyat_goster'] == '3' && $benzurun['stok'] > '0') {?>
        <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
            <div class="urun-detay-benzer-urun-box-text-price">
                <div>
                    <?php if($benzurun['indirim'] == '1' && $benzurun['eski_fiyat'] > '0') {?>
                        <span style="font-size: 14px ; text-decoration: line-through;">
                       <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                           <?=$secilikur['sol_simge']?>
                       <?php }?>
                       <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                           <?=$secilikur['sag_simge']?>
                       <?php }?>

                       <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$benzurun['eski_fiyat'] ), $secilikur['para_format']); ?>

                       <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                           <?=$secilikur['sol_simge']?>
                       <?php }?>
                       <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                           <?=$secilikur['sag_simge']?>
                       <?php }?>
            </span><br>
                    <?php } ?>
                    <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                        <?php if($box_fiyat == '0'  ) {?>
                            <?=$diller['kategori-detay-text24']?>
                        <?php }else { ?>
                            <span style="font-weight: bold;">
                <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                    <?=$secilikur['sol_simge']?>
                <?php }?>
                <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                    <?=$secilikur['sag_simge']?>
                <?php }?>
                <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$box_fiyat ), $secilikur['para_format']); ?>

                <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                    <?=$secilikur['sol_simge']?>
                <?php }?>
                <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                    <?=$secilikur['sag_simge']?>
                <?php }?>
        </span>
                        <?php } ?>
                    <?php }else { ?>
                        <span style="font-weight: bold;">
            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                <?=$secilikur['sol_simge']?>
            <?php }?>
            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                <?=$secilikur['sag_simge']?>
            <?php }?>

            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$box_fiyat ), $secilikur['para_format']); ?>

            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                <?=$secilikur['sol_simge']?>
            <?php }?>
            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                <?=$secilikur['sag_simge']?>
            <?php }?>
            </span>
                    <?php }?>
                </div>
                <?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?>
                    <?php
                    if($benzurun['indirim'] == '1' && $benzurun['eski_fiyat'] >'0' ) {
                        ?>
                        <div class="urun-detay-benzer-urun-box-text-price-discount tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">
                            % <?=(int)$indirimorani?>
                        </div>
                    <?php }} ?>
            </div>
        <?php }else { ?>
            <?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                <div class="urun-detay-benzer-urun-box-text-price-hidden"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text23']?></div>
            <?php }?>
        <?php }?>
    <?php }?>
    <?php if($benzurun['stok'] <= '0' ) {?>
        <div class="cat-detail-products-box-caturunvitrin-fiyat" >
            <div class="cat-detail-products-box-fiyat-out button-red button-1x" style="width: 100%; text-align: center;">
                <?=$diller['urun-detay-stok-durum-yok']?>
            </div>
        </div>
    <?php }?>
<?php }?>
<?php function urundetay_Kategori_Agaci($row){
    global $db;
    $urunKatCek = $db->prepare("select * from urun_cat where id=:id and durum=:durum and dil=:dil ");
    $urunKatCek->execute(array(
        'id' => $row['iliskili_kat'],
        'durum' => '1',
        'dil' => $_SESSION['dil']
    ));
    $kat1 = $urunKatCek->fetch(PDO::FETCH_ASSOC);
    if($kat1['ust_id'] >'0' ) {
        $urunKatCek_2 = $db->prepare("select * from urun_cat where id=:id and durum=:durum and dil=:dil ");
        $urunKatCek_2->execute(array(
            'id' => $kat1['ust_id'],
            'durum' => '1',
            'dil' => $_SESSION['dil']
        ));
        $kat2 = $urunKatCek_2->fetch(PDO::FETCH_ASSOC);
        if($kat2['ust_id'] >'0' ) {
            $urunKatCek_3 = $db->prepare("select * from urun_cat where id=:id and durum=:durum and dil=:dil ");
            $urunKatCek_3->execute(array(
                'id' => $kat2['ust_id'],
                'durum' => '1',
                'dil' => $_SESSION['dil']
            ));
            $kat3 = $urunKatCek_3->fetch(PDO::FETCH_ASSOC);
            if($kat3['ust_id'] >'0' ) {
                $urunKatCek_4 = $db->prepare("select * from urun_cat where id=:id and durum=:durum and dil=:dil ");
                $urunKatCek_4->execute(array(
                    'id' => $kat3['ust_id'],
                    'durum' => '1',
                    'dil' => $_SESSION['dil']
                ));
                $kat4 = $urunKatCek_4->fetch(PDO::FETCH_ASSOC);
                if($kat4['ust_id'] >'0' ) {
                    $urunKatCek_5 = $db->prepare("select * from urun_cat where id=:id and durum=:durum and dil=:dil ");
                    $urunKatCek_5->execute(array(
                        'id' => $kat4['ust_id'],
                        'durum' => '1',
                        'dil' => $_SESSION['dil']
                    ));
                    $kat5 = $urunKatCek_5->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
    }
    ?>
    <?php if($kat4['ust_id'] >'0'  ) {?>
        <a href="<?=$kat5['seo_url']?>/"><?=$kat5['baslik']?></a> <i class="fa fa-angle-right"></i>
    <?php }?>
    <?php if($kat3['ust_id'] >'0'  ) {?>
        <a href="<?=$kat4['seo_url']?>/"><?=$kat4['baslik']?></a> <i class="fa fa-angle-right"></i>
    <?php }?>
    <?php if($kat2['ust_id'] >'0'  ) {?>
        <a href="<?=$kat3['seo_url']?>/"><?=$kat3['baslik']?></a> <i class="fa fa-angle-right"></i>
    <?php }?>
    <?php if($kat1['ust_id'] >'0'  ) {?>
        <a href="<?=$kat2['seo_url']?>/"><?=$kat2['baslik']?></a> <i class="fa fa-angle-right"></i>
    <?php }?>
    <a href="<?=$kat1['seo_url']?>/"><?=$kat1['baslik']?></a>
<?php }?>
<?php function urundetay_Star(){
    global $udetayRow;
    global $diller;
    global $icerik;
    global $uyeayar;
    global $finalstarrate;
    global $yorumcount;
    ?>
    <?php if($udetayRow['star_rate'] == '1') {?>
        <div class="urun-detay-sag-alan-yildiz">
            <?php if($uyeayar['durum'] == '0' ) {?>
                <?php if($icerik['star_rate'] == 0){ ?>
                    <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($icerik['star_rate'] == 1){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($icerik['star_rate'] == 2){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($icerik['star_rate'] == 3){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($icerik['star_rate'] == 4){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                <?php }?>
                <?php if($icerik['star_rate'] == 5){ ?>
                    <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                <?php }?>
            <?php } ?>

            <!-- ÜYELİK VARSA VE ÜRÜNE YORUMLAR KAPALIYSA YILDIZ SAYISINI GÖSTER !-->
            <?php if($uyeayar['durum'] == '1' ) {?>
                <?php if($icerik['yorum_durum'] == '0' ) {?>
                    <?php if($icerik['star_rate'] == 0){ ?>
                        <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($icerik['star_rate'] == 1){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($icerik['star_rate'] == 2){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($icerik['star_rate'] == 3){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($icerik['star_rate'] == 4){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($icerik['star_rate'] == 5){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                    <?php }?>
                <?php } ?>
            <?php } ?>
            <!-- ÜYELİK VARSA VE ÜRÜNE YORUMLAR KAPALIYSA YILDIZ SAYISINI GÖSTER SON !-->

            <!-- ÜYELİK VARSA VE ÜRÜNE YORUM YAPILABİLİR İSE OYLAMA ORTALAMASINI GÖSTER !-->
            <?php if($icerik['yorum_durum'] == '1' ) {?>
                <?php if($uyeayar['durum'] == '1' ) {?>

                    <?php if($finalstarrate == 0){ ?>
                        <span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($finalstarrate == 1){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($finalstarrate == 2){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($finalstarrate == 3){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($finalstarrate == 4){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#CCC">★</span>
                    <?php }?>
                    <?php if($finalstarrate == 5){ ?>
                        <span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span><span style="color:#ffb400">★</span>
                    <?php }?>
                    <a href="#tabs-comments"  class="scroll" rel="#tabs-comments" style="color: #000; margin-left: 10px;   "  >
                        <?php if($yorumcount > '0'  ) {?>
                            <span style="font-size: 13px ;   color: #777;">(<span style="font-weight: bold;"><?=$yorumcount?></span> <?=$diller['urun-detay-ustte-yorumu-gor-yazisi']?>)</span>
                        <?php }else { ?>
                            <span style="font-size: 13px ;   color: #777;">(<span style="font-weight: bold;"><?=$yorumcount?></span> <?=$diller['urun-detay-ustte-degerlendirme-yazisi']?>)</span>
                        <?php }?>
                    </a>

                <?php } ?>
            <?php } ?>
            <!-- ÜYELİK VARSA VE ÜRÜNE YORUM YAPILABİLİR İSE OYLAMA ORTALAMASINI GÖSTER !-->
        </div>
    <?php }?>
<?php } ?>
<?php function kur_cekimi($fiyat){
    global $secilikur;
    global $varsayilankur;
    ?>
    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
        <?=$secilikur['sol_simge']?>
    <?php }?>
    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
        <?=$secilikur['sag_simge']?>
    <?php }?>
    <span id="item-price"><?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$fiyat ), $secilikur['para_format']); ?></span>
    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
        <?=$secilikur['sol_simge']?>
    <?php }?>
    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
        <?=$secilikur['sag_simge']?>
    <?php }?>
<?php } ?>
<?php function kur_cekimi_nospan($fiyat){
    global $secilikur;
    global $varsayilankur;
    ?>
    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
        <?=$secilikur['sol_simge']?>
    <?php }?>
    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
        <?=$secilikur['sag_simge']?>
    <?php }?>
    <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$fiyat ), $secilikur['para_format']); ?>
    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
        <?=$secilikur['sol_simge']?>
    <?php }?>
    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
        <?=$secilikur['sag_simge']?>
    <?php }?>
<?php } ?>
