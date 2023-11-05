<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='banka' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);

$islemCek = $db->prepare("select * from compare_ayar where id='1' ");
$islemCek->execute();
$islemR = $islemCek->fetch(PDO::FETCH_ASSOC);
if(isset($_GET['remove'])  ) {
    if(strip_tags(htmlspecialchars($_GET['remove'])) != $_GET['remove']  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }
    if($_GET['remove'] == 'all' ) {
        if(strip_tags(htmlspecialchars($_GET['all'])) != $_GET['all']  ) {
            header('Location:'.$ayar['site_url'].'404');
            exit();
        }
        unset($_SESSION['compare_product'] );
        header('Location:'.$siteurl.'karsilastirmalar/');
    }
}
if(isset($_GET['delete'])  ) {
    if(strip_tags(htmlspecialchars($_GET['delete'])) != $_GET['delete']  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }
    unset($_SESSION['compare_product'][$_GET['delete']] );
    header('Location:'.$siteurl.'karsilastirmalar/');
}
?>
    <title><?php echo $diller['altsayfa-compare-title'] ?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta property="og:type" content="website" />

<?php include "includes/config/header_libs.php";?>
    </head>
    <body>
    <?php include 'includes/template/pre-loader.php'?>
    <?php include 'includes/template/header.php'?>
    <!-- CONTENT AREA ============== !-->
    <div id="MainDiv" style="background-color: #<?=$islemR['sayfa_bg']?>; width: 100%; font-family : '<?=$islemR['sayfa_font']?>',Sans-serif ; overflow: hidden  ">
        <div class="compare-container-main">
            <?php if(isset($_SESSION['compare_product'] ) && $_SESSION['compare_product'] == !null ) {?>
                <!-- Header !-->
                <div class="compare_header_div" >
                    <?=$diller['compare-text1']?>
                    <a href="karsilastirmalar/?remove=all" class="button-red-out button-1x"><i class="las la-trash-alt"></i> <?=$diller['compare-text2']?></a>
                </div>
                <!--  <========SON=========>>> Header SON !-->
                <div class="compare-container-table-div">
                    <table class="compare-container-table-1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="190" ></td>
                            <?php foreach ($_SESSION['compare_product']  as $com) {
                                ?>
                                <td style="text-align: center;">
                                    <a href="karsilastirmalar/?delete=<?=$com?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['compare-text22']?>" style="color: red;">
                                        <i class="fa fa-times" style="font-size: 18px ;"></i>
                                    </a>
                                </td>
                            <?php }?>
                        </tr>
                        <tr>
                            <td ><?=$diller['compare-text3']?></td>
                            <?php foreach ($_SESSION['compare_product']  as $com) {
                                $urun = $db->prepare("select * from urun where id=:id  ");
                                $urun->execute(array(
                                    'id' => $com
                                ));
                                $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <td class="compare-container-table-1-content">
                                    <?=$urunRow['baslik']?>
                                    <br><br>
                                    <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" class="button-blue button-1x" target="_blank">
                                        <?=$diller['urun-detay-benzer-urunler-urune-git']?>
                                    </a>
                                </td>
                            <?php }?>
                        </tr>
                        <tr>
                            <td ><?=$diller['compare-text4']?></td>
                            <?php foreach ($_SESSION['compare_product']  as $com) {
                                $urun = $db->prepare("select * from urun where id=:id  ");
                                $urun->execute(array(
                                    'id' => $com
                                ));
                                $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <td class="compare-container-table-1-content">
                                    <img src="images/product/<?=$urunRow['gorsel']?>" alt="">
                                </td>
                            <?php }?>
                        </tr>
                        <?php if($islemR['fiyat'] == '1'  ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text5']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['fiyat_goster'] == '1' ) {?>
                                            <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                                                <?php if($urunRow['fiyat'] <='0'  ) {?>
                                                    <?=$diller['urun-detay-ucretsiz-fiyat']?>
                                                <?php }else { ?>
                                                    <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                <?php }?>
                                            <?php }else { ?>
                                                <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                            <?php }?>
                                        <?php }?>
                                        <?php if($urunRow['fiyat_goster'] == '2' ) {?>
                                            <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                                <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                                                    <?php if($urunRow['fiyat'] <='0'  ) {?>
                                                        <?=$diller['urun-detay-ucretsiz-fiyat']?>
                                                    <?php }else { ?>
                                                        <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                    <?php }?>
                                                <?php }else { ?>
                                                    <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                <?php }?>
                                            <?php }else { ?>
                                                <div class="user_subpage_info_div_blue" style="margin-bottom: 0;">
                                                    <i class="fa fa-lock"></i>  <?=$diller['compare-text18']?>
                                                </div>
                                            <?php }?>
                                        <?php }?>
                                        <?php if($urunRow['fiyat_goster'] == '3' ) {?>
                                            <?php if($uyegruplariCek->rowCount()>'0'  ) {?>
                                                <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                                                    <?php if($urunRow['fiyat'] <='0'  ) {?>
                                                        <?=$diller['urun-detay-ucretsiz-fiyat']?>
                                                    <?php }else { ?>
                                                        <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                    <?php }?>
                                                <?php }else { ?>
                                                    <?=kur_cekimi_nospan($urunRow['fiyat'])?>
                                                <?php }?>
                                            <?php }else { ?>
                                                <div class="user_subpage_info_div_grey" style="margin-bottom: 0;">
                                                    <i class="fa fa-lock"></i>  <?=$diller['compare-text19']?>
                                                </div>
                                            <?php }?>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['marka'] == '1' ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text6']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);

                                    $marka = $db->prepare("select * from urun_marka where id='$urunRow[marka]' ");
                                    $marka->execute();
                                    $mark = $marka->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?=$mark['baslik']?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['indirim'] == '1' ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text7']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['indirim'] == '1' ) {?>
                                            <span style="color: #E74E45;"><?=$diller['compare-text20']?></span>
                                        <?php }else { ?>
                                            <i class="ion-close-circled" style="color: #E74E45;"></i>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['kargo'] == '1' ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text8']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['kargo'] == '1' ) {?>
                                            <?php if($odemeayar['kargo_sabit'] == '1' ) {?>
                                                <?=kur_cekimi_nospan($odemeayar['kargo_sabit_ucret'])?>
                                            <?php }else { ?>
                                                <?=kur_cekimi_nospan($urunRow['kargo_ucret'])?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <?=$diller['compare-text21']?>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['hizli'] == '1' ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text9']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['hizli_kargo'] == '1' ) {?>
                                            <i class="ion-ios-checkmark " style="color: mediumseagreen;"></i>
                                        <?php }else { ?>
                                            <i class="ion-close-circled" style="color: #E74E45;"></i>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['stok']  == '1') {?>
                            <tr>
                                <td  ><?=$diller['compare-text10']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['stok'] <= '0' ) {?>
                                            <i class="ion-close-circled" style="color: #E74E45;"></i>
                                        <?php }else { ?>
                                            <i class="ion-ios-checkmark " style="color: mediumseagreen;"></i>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['taksit'] == '1' ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text11']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['taksit'] == '1' ) {?>
                                            <i class="ion-ios-checkmark " style="color: mediumseagreen;"></i>
                                        <?php }else { ?>
                                            <i class="ion-close-circled" style="color: #E74E45;"></i>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['puan'] == '1' ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text12']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
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
                                    ?>
                                    <td class="compare-container-table-1-content">

                                        <?php if($uyeayar['durum'] == '0' ) {
                                            /* Üyelik Sistemi Devre Dışı ise Yöneticinin belirlediği yıldızları getir */
                                            ?>
                                            <div class="cat-detail-products-box-stars">
                                                <span style="font-size: 16px ;"> <?=$urunRow['star_rate']?><br></span>
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
                                                    <span style="font-size: 16px ;"> <?=$urunRow['star_rate']?><br></span>
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
                                                    <span style="font-size: 16px ;"> <?=$urun_comment_star?><br></span>
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

                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['yeni'] == '1' ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text13']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['yeni'] == '1' ) {?>
                                            <i class="ion-ios-checkmark " style="color: mediumseagreen;"></i>
                                        <?php }else { ?>
                                            <i class="ion-close-circled" style="color: #E74E45;"></i>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['firsat'] == '1' ) {?>

                            <tr>
                                <td  ><?=$diller['compare-text14']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['firsat'] == '1' ) {?>
                                            <i class="ion-ios-checkmark " style="color: mediumseagreen;"></i>
                                        <?php }else { ?>
                                            <i class="ion-close-circled" style="color: #E74E45;"></i>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        <?php if($islemR['editor'] == '1' ) {?>
                            <tr>
                                <td  ><?=$diller['compare-text15']?></td>
                                <?php foreach ($_SESSION['compare_product']  as $com) {
                                    $urun = $db->prepare("select * from urun where id=:id  ");
                                    $urun->execute(array(
                                        'id' => $com
                                    ));
                                    $urunRow = $urun->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <td class="compare-container-table-1-content">
                                        <?php if($urunRow['editor_secim'] == '1' ) {?>
                                            <i class="ion-ios-checkmark " style="color: mediumseagreen;"></i>
                                        <?php }else { ?>
                                            <i class="ion-close-circled" style="color: #E74E45;"></i>
                                        <?php }?>
                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                    </table>
                </div>
            <?php }else { ?>
                <div class="iletisim-container-in">
                    <div class="user_subpage_favorites_noitems" >
                        <i class="las la-random" style="color: #999;"></i>
                        <div class="user_subpage_favorites_noitems_head m-top-10" >
                            <?=$diller['compare-text16']?>
                        </div>
                        <div class="user_subpage_favorites_noitems_s">
                            <?=$diller['compare-text17']?>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
    <!-- CONTENT AREA ============== !-->
    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
<?php include "includes/config/footer_libs.php";?>