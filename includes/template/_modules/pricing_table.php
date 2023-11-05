<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$pricingayar = $db->prepare("select * from pricing_ayar where id='1'");
$pricingayar->execute();
$tabloset = $pricingayar->fetch(PDO::FETCH_ASSOC);
$tablolimit = $tabloset['tablo_limit'];
?>
<?php
$PCategories = $db->prepare("select * from pricing_kat where dil=:dil and durum=:durum and tab_durum=:tab_durum ");
$PCategories->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1',
    'tab_durum' => '1'
));

$PCategoriesContent = $db->prepare("select * from pricing_kat where dil=:dil and durum=:durum and tab_durum=:tab_durum ");
$PCategoriesContent->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1',
    'tab_durum' => '1'
));

?>
<?php if($PCategories->rowCount()>'0'  ) {?>
    <?php if($PCategories->rowCount() == '1'  ) {?>
        <style>
            .pricing-tab-system a:first-child{
                border-radius: <?=$tabloset['tab_radius']?>px !important;
            }
            .pricing-tab-system a:last-child{
                border-radius: <?=$tabloset['tab_radius']?>px  !important;
            }
        </style>
    <?php }?>
<div class="pricing-tablolar-module-main-div">
    <div class="pricing-tablolar-module-inside-area">
        <!-- Modül başlıgı ve üst başlıgı !-->
        <div class="modules-head-text-main" style="margin-bottom: 0;">
            <?php if($diller['anasayfa-paketler-baslik'] == !null  ) {?>
                <?php if($tabloset['pricing_basliktip'] == '0' ) {?>
                    <div class="modules-head-text-h <?=$tabloset['baslik_space']?>" style="color: #<?=$tabloset['baslik_renk']?>; margin-bottom: 0; font-size: 25px ; font-weight: bold;">
                        <?=$diller['anasayfa-paketler-baslik']?>
                    </div>
                <?php }?>
                <?php if($tabloset['pricing_basliktip'] == '1' ) {?>
                    <div class="modules-head-forbg-text-out" style="border-bottom: 1px solid #<?=$tabloset['pricing_baslik_cizgi']?>; ">
                        <div class="modules-head-forbg-text <?=$tabloset['baslik_space']?>" style="color: #<?=$tabloset['baslik_renk']?>;     background-color: #<?=$tabloset['pricing_baslik_bg']?>; ">
                            <?=$diller['anasayfa-paketler-baslik']?>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
            <div class="modules-head-text-s <?=$tabloset['baslik_space']?>" style="color: #<?=$tabloset['spot_renk']?>;">
                <?=$diller['anasayfa-paketler-altbaslik']?>
            </div>
        </div>
        <!-- Modül başlıgı ve üst başlıgı SON !-->

        <div class="pricing-tab-system">
            <ul class="nav nav-tabs" id="myTab" role="tablist" >
                <?php foreach ($PCategories as $pcatRow) {?>
                    <a class="nav-link <?php if($pcatRow['sira'] == '1' || $pcatRow['sira']  == '0') { ?>active<?php }?>" data-toggle="tab" href="#tabselect-<?=$pcatRow['id']?>" role="tab"  aria-selected="true"><?=$pcatRow['baslik']?></a>
                <?php }?>
            </ul>
        </div>

        <div class="tab-content">
        <?php foreach ($PCategoriesContent as $pcatRow2) {
            $pricing_liste = $db->prepare("select * from pricing where durum='1' and dil='$_SESSION[dil]' and kat_id='$pcatRow2[id]' order by sira asc limit $tablolimit");
            $pricing_liste->execute();
            ?>
            <div class="tab-pane fade  <?php if($pcatRow2['sira'] == '1' || $pcatRow2['sira']  == '0') { ?>show active<?php }?>" id="tabselect-<?=$pcatRow2['id']?>" role="tabpanel" >
                <div class="ptable-box-main-div">
                <?php foreach ($pricing_liste as $tablo) {
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
                </div>
            </div>
        <?php }?>
        </div>


    </div>
    <?php if($tabloset['bg_tip'] == '0'  ) {?>
        <?php if($tabloset['bg_dark'] == '1'  ) {?>
            <!-- Slider Karartma Var ise !-->
            <div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
            <!-- Slider Karartma Var ise !-->
        <?php }?>
    <?php }?>
</div>
<?php }?>