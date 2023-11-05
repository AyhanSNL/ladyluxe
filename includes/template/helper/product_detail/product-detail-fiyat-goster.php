<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$mevcutfiyat = $urunFiyat;
?>
<?php if($icerik['fiyat_goster'] == '1' ) {?>
<!-- Fiyat Herkese Açıktır !-->
<?php
    /* İndirimsiz Fiyat - İNDİRİM İŞARETLİ */
    if($icerik['indirim'] == '1' ) {
        if($icerik['eski_fiyat'] == !null &&  $icerik['eski_fiyat'] > '0') { ?>
            <div class="urun-detay-sag-alan-fiyatlar">
                <div class="urun-detay-sag-alan-fiyat-sol">
                    <span><?=$diller['urun-detay-eski-fiyat']?></span>
                    <span>:</span>
                </div>
                <div class="urun-detay-sag-alan-fiyat-sag" style="text-decoration:line-through">
                    <?=kur_cekimi_nospan($icerik['eski_fiyat'])?>
                    <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                </div>
            </div>
        <?php
        }
    }
    /*  <========SON=========>>> İndirimsiz Fiyat - İNDİRİM İŞARETLİ SON */
    ?>

        <!-- Ürünün mevcut fiyatı !-->
    <?php if($urunOzelFiyat == '1'  ) {?>
        <div class="ribbon3"><i class="fa fa-arrow-down" ></i><?=$diller['urun-detay-gruba-ozel-fiyat-uzun']?> <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="
                <?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($icerik['fiyat'])?>
            "></i></div>
    <?php }?>
            <div class="urun-detay-sag-alan-fiyatlar"  >

                <div class="urun-detay-sag-alan-fiyat-sol">
                    <?php if($icerik['indirim'] == '1' && $icerik['eski_fiyat'] == !null  ) {?>
                        <span style="font-weight: bold;"><i class="fa fa-tag"></i> <?=$diller['urun-detay-indirimli-fiyat']?>
                            <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                        </span>
                    <?php } else { ?>
                        <span style="font-weight: bold;"><?=$diller['urun-detay-normal-fiyat']?>
                            <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                       </span>
                    <?php }?>
                    <span>:</span>
                </div>

                <div class="urun-detay-sag-alan-fiyat-sag" style="font-size:23px ; font-weight: bold; color: #000; display: flex; justify-content: space-between; align-items: center;">
                        <?php if($mevcutfiyat <= '0'  ) {
                            /* Ürün ÜCRETSİZ veya 0 */
                            ?>
                        <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                        <?=$diller['urun-detay-ucretsiz-fiyat']?>
                        <?php } else { ?>
                                <?=kur_cekimi_nospan($mevcutfiyat)?>
                        <?php }?>
                        <?php }
                         /*  <========SON=========>>> Ürün ÜCRETSİZ veya 0 SON */
                        else {
                            /* Fiyat 0'dan fazla yani ürün ücretli */
                            ?>
                        <div>
                        <?php kur_cekimi($mevcutfiyat);?>
                        <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                        </div>
                        <?php
                            /* Fiyat kazancı ve İndirim Oranı */
                            if($udetayRow['detay_fiyatkazanc'] =='1' ) {
                            if ($icerik['eski_fiyat'] == !null && $icerik['eski_fiyat'] > '0' && $icerik['indirim'] == '1' && $mevcutfiyat == !null) {
                                $kazancfiyati = $icerik['eski_fiyat'] - $mevcutfiyat;
                                $indirimorani = 100 - (($mevcutfiyat / $icerik['eski_fiyat']) * 100);
                        ?>
                              <span class="btn btn-sm btn-danger kazanc-mobil-div" >
                              <i class="fa fa-arrow-down"></i> %<?=(int)$indirimorani?> <?=$diller['urun-detay-indirim-yazisi']?> <br>
                                  <?php kur_cekimi($kazancfiyati);?>
                                  <?=$diller['urun-detay-kazanc-yazisi']?>
                            </span>
                        <?php }}  /*  <========SON=========>>> Fiyat kazancı ve İndirim Oranı SON */ ?>
                        <?php } /*  <========SON=========>>> Fiyat 0'dan fazla yani ürün ücretli SON */?>

                </div>

            </div>
        <!--  <========SON=========>>> Ürünün mevcut fiyatı SON !-->



        <!-- Ürünün Havale Fiyatı varsa HAVALE Fİyatı Göster !-->
        <?php if($icerik['havale_indirim_tutar'] == !null && $icerik['havale_indirim_tutar'] > '0'  ) {?>
        <div class="urun-detay-sag-alan-fiyatlar" style="<?php if($odemeayar['kargo_sistemi'] == '1') { ?><?php if($icerik['kargo'] == '0' || $icerik['kargo'] == null) { ?>border-bottom: 1px solid #f8f8f8; margin-bottom: 20px;<?php }?><?php }?><?php if($odemeayar['kargo_sistemi'] == '0') { ?>border-bottom: 1px solid #f8f8f8; margin-bottom: 20px;<?php } ?>">
            <div class="urun-detay-sag-alan-fiyat-sol">
                                <span><?=$diller['urun-detay-havale-fiyat']?>
                                    <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                                </span>
                <span>:</span>
            </div>


            <div class="urun-detay-sag-alan-fiyat-sag" style="font-size:16px ; font-weight: bold; color: #333; display: flex; justify-content: space-between; align-items: center;">
                <?php if($icerik['havale_indirim_tur'] == '1' ) {
                    $havalefiyati_tutar = $mevcutfiyat*$icerik['havale_indirim_tutar']/100;
                    $havalefiyati = $mevcutfiyat-$havalefiyati_tutar;
                    $havaleindirimTur = '1';
                }
                if($icerik['havale_indirim_tur'] == '2' ) {
                    $havalefiyati = $mevcutfiyat-$icerik['havale_indirim_tutar'];
                    $havaleindirimTur = '2';
               }
                ?>

                <div>
                    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                        <?=$secilikur['sol_simge']?>
                    <?php }?>
                    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                        <?=$secilikur['sag_simge']?>
                    <?php }?>
                    <?php if($havaleindirimTur == '1'  ) {?>
                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ), $secilikur['para_format']); ?>
                    <?php }?>
                    <?php if($havaleindirimTur == '2'  ) {?>
                        <span id="item-price2"><?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ), $secilikur['para_format']); ?></span>
                    <?php }?>
                    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                        <?=$secilikur['sol_simge']?>
                    <?php }?>
                    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                        <?=$secilikur['sag_simge']?>
                    <?php }?>
                    <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                </div>

                <?php if($odemeayar['havale_odeme_bildirim'] == '1' ) {
                  if($udetayRow['detay_havale_info'] == '1' ) {
                ?>
                    <span class="btn btn-sm btn-light mobil-div-bildirim" style="font-size: 12px ; color: #000; border-radius: 0 !important;">
                     <i class="fa fa-info-circle"></i> <?=$diller['urun-detay-havale-bilgisi']?>
                    </span>
                <?php }} ?>

            </div>
        </div>
        <?php } ?>
        <!--  <========SON=========>>> Ürünün Havale Fiyatı varsa HAVALE Fİyatı Göster SON !-->


            <!-- Taksit Seçeneğe Git !-->
            <?php if($icerik['taksit'] == '1' ) {?>
                    <div style="width: 100%;  margin: 10px 0; padding: 10px 0;  font-size: 14px ; ">
                        <i class="fa fa-credit-card"></i>
                        <a style="font-weight: bold; color: #000;"  href="#tabs-taksitler" rel="#tabs-taksitler" class="scroll">
                            <?=$diller['urun-detay-taksit-gor']?>
                        </a>
                    </div>
            <?php }?>
            <!--  <========SON=========>>> Taksit Seçeneğe Git SON !-->

<!--  <========SON=========>>> Fiyat Herkese Açıktır SON !-->
<?php }?>

<?php if($icerik['fiyat_goster'] == '2' ) {
    if($userSorgusu->rowCount()>'0'  ) {
    ?>
    <!-- Fiyat Sadece Üyelere Açık !-->
    <?php
    /* İndirimsiz Fiyat - İNDİRİM İŞARETLİ */
    if($icerik['indirim'] == '1' ) {
        if($icerik['eski_fiyat'] == !null &&  $icerik['eski_fiyat'] > '0') { ?>
            <div class="urun-detay-sag-alan-fiyatlar">
                <div class="urun-detay-sag-alan-fiyat-sol">
                    <span><?=$diller['urun-detay-eski-fiyat']?></span>
                    <span>:</span>
                </div>
                <div class="urun-detay-sag-alan-fiyat-sag" style="text-decoration:line-through">
                    <?php kur_cekimi($icerik['eski_fiyat']);?>
                    <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                </div>
            </div>
            <?php
        }
    }
    /*  <========SON=========>>> İndirimsiz Fiyat - İNDİRİM İŞARETLİ SON */
    ?>

    <!-- Ürünün mevcut fiyatı !-->
        <?php if($urunOzelFiyat == '1'  ) {?>
            <div class="ribbon3"><i class="fa fa-arrow-down" ></i><?=$diller['urun-detay-gruba-ozel-fiyat-uzun']?> <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="
                <?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($icerik['fiyat'])?>
            "></i></div>
        <?php }?>

    <div class="urun-detay-sag-alan-fiyatlar"  >

        <div class="urun-detay-sag-alan-fiyat-sol">
            <?php if($icerik['indirim'] == '1' && $icerik['eski_fiyat'] == !null  ) {?>
                <span style="font-weight: bold;"><i class="fa fa-tag"></i> <?=$diller['urun-detay-indirimli-fiyat']?>
                    <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                        </span>
            <?php } else { ?>
                <span style="font-weight: bold;"><?=$diller['urun-detay-normal-fiyat']?>
                    <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                       </span>
            <?php }?>
            <span>:</span>
        </div>

        <div class="urun-detay-sag-alan-fiyat-sag" style="font-size:23px ; font-weight: bold; color: #000; display: flex; justify-content: space-between; align-items: center;">
            <?php if($mevcutfiyat <= '0'  ) {
                /* Ürün ÜCRETSİZ veya 0 */
                ?>

                <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                    <?=$diller['urun-detay-ucretsiz-fiyat']?>
                <?php } else { ?>
                    <?php kur_cekimi($mevcutfiyat);?>
                <?php }?>
            <?php }
            /*  <========SON=========>>> Ürün ÜCRETSİZ veya 0 SON */
            else {
                /* Fiyat 0'dan fazla yani ürün ücretli */
                ?>
                <div>
                    <?php kur_cekimi($mevcutfiyat);?>
                    <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                </div>

                <?php
                /* Fiyat kazancı ve İndirim Oranı */
                if($udetayRow['detay_fiyatkazanc'] =='1' ) {
                    if ($icerik['eski_fiyat'] == !null && $icerik['eski_fiyat'] > '0' && $icerik['indirim'] == '1' && $mevcutfiyat == !null) {
                        $kazancfiyati = $icerik['eski_fiyat'] - $mevcutfiyat;
                        $indirimorani = 100 - (($mevcutfiyat / $icerik['eski_fiyat']) * 100);
                        ?>
                        <span class="btn btn-sm btn-danger kazanc-mobil-div" style=" ">
                              <i class="fa fa-arrow-down"></i> %<?=(int)$indirimorani?> <?=$diller['urun-detay-indirim-yazisi']?> <br>
                                <?php kur_cekimi($kazancfiyati);?>
                                <?=$diller['urun-detay-kazanc-yazisi']?>
                            </span>
                    <?php }}  /*  <========SON=========>>> Fiyat kazancı ve İndirim Oranı SON */ ?>
            <?php } /*  <========SON=========>>> Fiyat 0'dan fazla yani ürün ücretli SON */?>

        </div>

    </div>
    <!--  <========SON=========>>> Ürünün mevcut fiyatı SON !-->



    <!-- Ürünün Havale Fiyatı varsa HAVALE Fİyatı Göster !-->
    <?php if($icerik['havale_indirim_tutar'] == !null && $icerik['havale_indirim_tutar'] > '0'  ) {?>
        <div class="urun-detay-sag-alan-fiyatlar" style="<?php if($odemeayar['kargo_sistemi'] == '1') { ?><?php if($icerik['kargo'] == '0' || $icerik['kargo'] == null) { ?>border-bottom: 1px solid #f8f8f8; margin-bottom: 20px;<?php }?><?php }?><?php if($odemeayar['kargo_sistemi'] == '0') { ?>border-bottom: 1px solid #f8f8f8; margin-bottom: 20px;<?php } ?>">
            <div class="urun-detay-sag-alan-fiyat-sol">
                                <span><?=$diller['urun-detay-havale-fiyat']?>
                                    <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                                </span>
                <span>:</span>
            </div>


            <div class="urun-detay-sag-alan-fiyat-sag" style="font-size:16px ; font-weight: bold; color: #333; display: flex; justify-content: space-between; align-items: center;">
                <?php if($icerik['havale_indirim_tur'] == '1' ) {
                    $havalefiyati_tutar = $mevcutfiyat*$icerik['havale_indirim_tutar']/100;
                    $havalefiyati = $mevcutfiyat-$havalefiyati_tutar;
                    $havaleindirimTur = '1';
                }
                if($icerik['havale_indirim_tur'] == '2' ) {
                    $havalefiyati = $mevcutfiyat-$icerik['havale_indirim_tutar'];
                    $havaleindirimTur = '2';
                }
                ?>

                <div>
                    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                        <?=$secilikur['sol_simge']?>
                    <?php }?>
                    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                        <?=$secilikur['sag_simge']?>
                    <?php }?>
                    <?php if($havaleindirimTur == '1'  ) {?>
                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ), $secilikur['para_format']); ?>
                    <?php }?>
                    <?php if($havaleindirimTur == '2'  ) {?>
                        <span id="item-price2"><?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ), $secilikur['para_format']); ?></span>
                    <?php }?>
                    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                        <?=$secilikur['sol_simge']?>
                    <?php }?>
                    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                        <?=$secilikur['sag_simge']?>
                    <?php }?>
                    <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                </div>

                <?php if($odemeayar['havale_odeme_bildirim'] == '1' ) {
                    if($udetayRow['detay_havale_info'] == '1' ) {
                        ?>
                        <span class="btn btn-sm btn-light mobil-div-bildirim" style="font-size: 12px ; color: #000; border-radius: 0 !important;">
                     <i class="fa fa-info-circle"></i> <?=$diller['urun-detay-havale-bilgisi']?>
                    </span>
                    <?php }} ?>

            </div>
        </div>
    <?php } ?>
    <!--  <========SON=========>>> Ürünün Havale Fiyatı varsa HAVALE Fİyatı Göster SON !-->

        <!-- Taksit Seçeneğe Git !-->
        <?php if($icerik['taksit'] == '1' ) {?>
            <div style="width: 100%;  margin: 10px 0; padding: 10px 0;  font-size: 14px ; ">
                <i class="fa fa-credit-card"></i>
                <a style="font-weight: bold; color: #000;"  href="#tabs-taksitler" rel="#tabs-taksitler" class="scroll">
                    <?=$diller['urun-detay-taksit-gor']?>
                </a>
            </div>
        <?php }?>
        <!--  <========SON=========>>> Taksit Seçeneğe Git SON !-->

    <!--  <========SON=========>>> Fiyat Sadece Üyelere Açık  SON !-->
<?php }
        /* FiyatGösterim Uyarısı */
       if($userSorgusu->rowCount() <= '0'  ) {
           if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?>
                <div class="urun-detay-fiyat-durumu" style="margin-bottom: 15px;">
                    <i class="fa fa-lock" ></i>
                    <?=$diller['urun-detay-uyelere-acik-fiyat-bilgisi']?>
                </div>
            <?php }
           /*  <========SON=========>>> FiyatGösterim Uyarısı SON */
           }}?>

<?php if($icerik['fiyat_goster'] == '3' ) {
    if($userSorgusu->rowCount()>'0'  ) {
        if($uyegruplariCek->rowCount()>'0'  ) {
         /* Üyenin grubu var */
        ?>
        <!-- Fiyat Sadece Üye Gruplarına Açık !-->
        <?php
        /* İndirimsiz Fiyat - İNDİRİM İŞARETLİ */
        if($icerik['indirim'] == '1' ) {
            if($icerik['eski_fiyat'] == !null &&  $icerik['eski_fiyat'] > '0') { ?>
                <div class="urun-detay-sag-alan-fiyatlar">
                    <div class="urun-detay-sag-alan-fiyat-sol">
                        <span><?=$diller['urun-detay-eski-fiyat']?></span>
                        <span>:</span>
                    </div>
                    <div class="urun-detay-sag-alan-fiyat-sag" style="text-decoration:line-through">


                        <?php kur_cekimi($icerik['eski_fiyat']);?>

                        <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                    </div>
                </div>
                <?php
            }
        }
        /*  <========SON=========>>> İndirimsiz Fiyat - İNDİRİM İŞARETLİ SON */
        ?>

        <!-- Ürünün mevcut fiyatı !-->
            <?php if($urunOzelFiyat == '1'  ) {?>
                <div class="ribbon3"><i class="fa fa-arrow-down" ></i><?=$diller['urun-detay-gruba-ozel-fiyat-uzun']?> <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="
                <?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($icerik['fiyat'])?>
            "></i></div>
            <?php }?>
        <div class="urun-detay-sag-alan-fiyatlar"  >

            <div class="urun-detay-sag-alan-fiyat-sol">
                <?php if($icerik['indirim'] == '1' && $icerik['eski_fiyat'] == !null  ) {?>
                    <span style="font-weight: bold;"><i class="fa fa-tag"></i> <?=$diller['urun-detay-indirimli-fiyat']?>
                        <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                        </span>
                <?php } else { ?>
                    <span style="font-weight: bold;"><?=$diller['urun-detay-normal-fiyat']?>
                        <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                       </span>
                <?php }?>
                <span>:</span>
            </div>

            <div class="urun-detay-sag-alan-fiyat-sag" style="font-size:23px ; font-weight: bold; color: #000; display: flex; justify-content: space-between; align-items: center;">
                <?php if($mevcutfiyat <= '0'  ) {
                    /* Ürün ÜCRETSİZ veya 0 */
                    ?>
                    <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                        <?=$diller['urun-detay-ucretsiz-fiyat']?>
                    <?php } else { ?>
                        <?php kur_cekimi($mevcutfiyat);?>
                    <?php }?>
                <?php }
                /*  <========SON=========>>> Ürün ÜCRETSİZ veya 0 SON */
                else {
                    /* Fiyat 0'dan fazla yani ürün ücretli */
                    ?>
                    <div>
                        <?php kur_cekimi($mevcutfiyat);?>
                        <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                    </div>

                    <?php
                    /* Fiyat kazancı ve İndirim Oranı */
                    if($udetayRow['detay_fiyatkazanc'] =='1' ) {
                        if ($icerik['eski_fiyat'] == !null && $icerik['eski_fiyat'] > '0' && $icerik['indirim'] == '1' && $mevcutfiyat == !null) {
                            $kazancfiyati = $icerik['eski_fiyat'] - $mevcutfiyat;
                            $indirimorani = 100 - (($mevcutfiyat / $icerik['eski_fiyat']) * 100);
                            ?>
                            <span class="btn btn-sm btn-danger kazanc-mobil-div" style=" ">
                              <i class="fa fa-arrow-down"></i> %<?=(int)$indirimorani?> <?=$diller['urun-detay-indirim-yazisi']?> <br>
                        <?php kur_cekimi($kazancfiyati);?>
                                <?=$diller['urun-detay-kazanc-yazisi']?>
                            </span>
                        <?php }}  /*  <========SON=========>>> Fiyat kazancı ve İndirim Oranı SON */ ?>
                <?php } /*  <========SON=========>>> Fiyat 0'dan fazla yani ürün ücretli SON */?>

            </div>

        </div>
        <!--  <========SON=========>>> Ürünün mevcut fiyatı SON !-->



        <!-- Ürünün Havale Fiyatı varsa HAVALE Fİyatı Göster !-->
        <?php if($icerik['havale_indirim_tutar'] == !null && $icerik['havale_indirim_tutar'] > '0'  ) {?>
            <div class="urun-detay-sag-alan-fiyatlar" style="<?php if($odemeayar['kargo_sistemi'] == '1') { ?><?php if($icerik['kargo'] == '0' || $icerik['kargo'] == null) { ?>border-bottom: 1px solid #f8f8f8; margin-bottom: 20px;<?php }?><?php }?><?php if($odemeayar['kargo_sistemi'] == '0') { ?>border-bottom: 1px solid #f8f8f8; margin-bottom: 20px;<?php } ?>">
                <div class="urun-detay-sag-alan-fiyat-sol">
                                <span><?=$diller['urun-detay-havale-fiyat']?>
                                    <?php if($icerik['kdv'] == '2' ) { ?><br>(<?=$diller['urunler-dahil-kdv']?>)<?php }?>
                                </span>
                    <span>:</span>
                </div>


                <div class="urun-detay-sag-alan-fiyat-sag" style="font-size:16px ; font-weight: bold; color: #333; display: flex; justify-content: space-between; align-items: center;">
                    <?php if($icerik['havale_indirim_tur'] == '1' ) {
                        $havalefiyati_tutar = $mevcutfiyat*$icerik['havale_indirim_tutar']/100;
                        $havalefiyati = $mevcutfiyat-$havalefiyati_tutar;
                        $havaleindirimTur = '1';
                    }
                    if($icerik['havale_indirim_tur'] == '2' ) {
                        $havalefiyati = $mevcutfiyat-$icerik['havale_indirim_tutar'];
                        $havaleindirimTur = '2';
                    }
                    ?>

                    <div>
                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                            <?=$secilikur['sol_simge']?>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                            <?=$secilikur['sag_simge']?>
                        <?php }?>
                        <?php if($havaleindirimTur == '1'  ) {?>
                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ), $secilikur['para_format']); ?>
                        <?php }?>
                        <?php if($havaleindirimTur == '2'  ) {?>
                            <span id="item-price2"><?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ), $secilikur['para_format']); ?></span>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                            <?=$secilikur['sol_simge']?>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                            <?=$secilikur['sag_simge']?>
                        <?php }?>
                        <?php if($icerik['kdv'] == '1' ) { ?><?=$diller['urunler-arti-kdv']?><?php }?>
                    </div>

                    <?php if($odemeayar['havale_odeme_bildirim'] == '1' ) {
                        if($udetayRow['detay_havale_info'] == '1' ) {
                            ?>
                            <span class="btn btn-sm btn-light mobil-div-bildirim" style="font-size: 12px ; color: #000; border-radius: 0 !important;">
                     <i class="fa fa-info-circle"></i> <?=$diller['urun-detay-havale-bilgisi']?>
                    </span>
                        <?php }} ?>

                </div>
            </div>
        <?php } ?>
        <!--  <========SON=========>>> Ürünün Havale Fiyatı varsa HAVALE Fİyatı Göster SON !-->

            <!-- Taksit Seçeneğe Git !-->
            <?php if($icerik['taksit'] == '1' ) {?>
                <div style="width: 100%;  margin: 10px 0; padding: 10px 0;  font-size: 14px ; ">
                    <i class="fa fa-credit-card"></i>
                    <a style="font-weight: bold; color: #000;"  href="#tabs-taksitler" rel="#tabs-taksitler" class="scroll">
                        <?=$diller['urun-detay-taksit-gor']?>
                    </a>
                </div>
            <?php }?>
            <!--  <========SON=========>>> Taksit Seçeneğe Git SON !-->


        <!--  <========SON=========>>> Fiyat Sadece Üyelere Açık  SON !-->
    <?php }else{
            /* Üyenin Grubu YoK!!!! Fiyatı Göremez! */
            /* FiyatGösterim Uyarısı */
            if ($odemeayar['fiyat_gosterim_uyari'] == '1') { ?>
                <div class="urun-detay-fiyat-durumu">
                    <i class="fa fa-lock"></i>
                    <?= $diller['urun-detay-uye-grubuna-acik-fiyat-bilgisi'] ?>
                </div>
        <?php }
            /*  <========SON=========>>> FiyatGösterim Uyarısı SON */
            /*  <========SON=========>>> Üyenin Grubu YoK!!!! Fiyatı Göremez! SON */
           }
    }else{
        if ($odemeayar['fiyat_gosterim_uyari'] == '1') { ?>
            <div class="urun-detay-fiyat-durumu" style="margin-bottom: 15px;">
                <i class="fa fa-lock"></i>
                <?= $diller['urun-detay-uye-grubuna-acik-fiyat-bilgisi'] ?>
            </div>
       <?php }
    }
} ?>