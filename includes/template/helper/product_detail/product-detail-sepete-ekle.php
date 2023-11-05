<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
<?php if($icerik['siparis_islem'] == '0' ) {
    /* Ürün sepete eklenebilir */
    ?>
    <?php if($icerik['fiyat_goster'] =='1' ) {
        /* Fiyat Herkese Açık. */
        ?>
        <?php if($odemeayar['sepet_sistemi'] == '1'  ) {?>
        <form action="addtocart" method="post" id="entercancel">
         <input name="token" type="hidden" value="<?=md5('detailCallBack')?>">
            <!-- Varyantlar Buraya !-->
            <?php if($varyantSorgu->rowCount() > '0'  ) { ?>
        <style>
            #ui-datepicker-div {
            font-family : '<?=$udetayRow['detay_font']?>',Sans-serif ;
            }
        </style>
                <div style="width: 100%; display: flex; align-items: flex-start; flex-wrap: wrap; justify-content: flex-start; margin-top:20px;  ">
                    <?php foreach ($varyantSorgu as $var) { ?>
                            <?php
                            $vartyantOzellikSorgu = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            $vartyantOzellikSorgu2 = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu2->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            $vartyantOzellikSorgu3 = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu3->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            ?>
                            <?php if($var['tur'] =='1' ) {?>
                                <div class="product-detail-variant-div">
                                    <!-- Fiyat Değişkenli SelectBox !-->
                                    <label for="varyant<?=$var['id']?>">* <?=$var['baslik']?></label>
                                    <select name="var<?=$var['id']?>" class="form-control calculate" id="varyant<?=$var['id']?>" required style="width: 100% !;  ">
                                        <option data-price="0" value=""><?=$diller['varyant-secim-yapin-yazisi']?></option>
                                        <?php foreach ($vartyantOzellikSorgu as $varozellik) {?>
                                            <option data-price="<?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik['ek_fiyat'] ) ?>" value="<?=$varozellik['id']?>" <?php if($varozellik['disable'] == '1' ) { ?>disabled<?php }?>>

                                                <?=$varozellik['baslik']?> 
                                                <?php if($varozellik['disable'] != '1' ) {?>
                                                <?php if($varozellik['ek_fiyat'] > '0' && $varozellik['fiyat_goster'] == '1') { ?>
                                                    [+
                                                    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                    <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                    ]<?php } ?>
                                                <?php }else { ?>
                                                       <?php if($varozellik['disable_t'] == !null ) {?>
                                                           -- <?=$varozellik['disable_t']?>
                                                        <?php }?>
                                                <?php }?>
                                            </option>
                                        <?php }?>
                                    </select>
                                    <!-- Fiyat Değişkenli SelectBox SON !-->
                                </div>
                            <?php }?>
                            <?php if($var['tur'] =='2' ) {?>
                                <!-- Yazılabilir Textarea !-->
                                <div class="product-detail-variant-div" style="width: 100% ;  ">
                                    <?php foreach ($vartyantOzellikSorgu2 as $varozellik2) {?>
                                        <input type="hidden" name="var<?=$var['id']?>" value="<?=$varozellik2['id']?>">
                                    <?php }?>
                                    <label for="varyant<?=$var['id']?>">
                                        <?php if($var['zorunlu'] == '1' ) { ?>*<?php } ?>
                                        <?=$var['baslik']?>
                                        <?php if($varozellik2['ek_fiyat'] > '0' && $varozellik2['ek_fiyat'] == !null  && $varozellik2['fiyat_goster'] == '1') {?>
                                            <span style="font-size: 13px ; font-weight: 500; margin-left: 5px;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                    <?=$secilikur['sag_simge']?>
                                                <?php }?>
                                                <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik2['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                    <?=$secilikur['sol_simge']?>
                                                <?php }?>
                                                <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                    <?=$secilikur['sag_simge']?>
                                                <?php }?>
                                                                        ]
                                                        </span>
                                        <?php }?>
                                    </label>
                                    <input name="ek_var<?=$var['id']?>" id="varyant<?=$var['id']?>" class="form-control" <?php if($var['zorunlu'] == '1' ) { ?>required<?php }?> style="width: 100%;  ">
                                </div>
                                <!-- Yazılabilir Textarea SON !-->
                            <?php }?>
                            <?php if($var['tur'] =='3' ) {?>
                                <!-- Seçim Kutusu Radio Box !-->
                                <div class="product-detail-variant-div" style="width: 100% ; display: flex; justify-content: flex-start; flex-wrap: wrap ">
                                    <div style="width: 100%; font-weight: bold;">
                                        <label for="">
                                            * <?=$var['baslik']?>
                                        </label>
                                    </div>
                                    <?php foreach ($vartyantOzellikSorgu3 as $varozellik3) {?>
                                        <?php if($varozellik3['gorsel'] == !null && $varozellik3['gorsel'] > '0') {?>
                                            <style>
                                                .customVariantCheckbox .custom-control{
                                                    padding-left: 0 !important;
                                                }
                                                .customVariantCheckbox .custom-control-label{
                                                    border: 2px solid #fff;
                                                    padding: 5px;
                                                    transition-duration: 0.1s; transition-timing-function: linear;
                                                    cursor: pointer;
                                                }
                                                .customVariantCheckbox .custom-control input:checked +label{
                                                    border: 2px solid #<?=$udetayRow['urundetay_aktif_tab']?> !important;
                                                }
                                                .customVariantCheckbox .custom-control-label::before{
                                                    display: none !important;
                                                    width: 0 !important;
                                                }
                                            </style>
                                            <div class="customVariantCheckbox">
                                                 <div class="custom-control custom-radio" style="margin-right: 10px; ">
                                                <input type="radio" id="varyant<?=$varozellik3['id']+22565?>" value="<?=$varozellik3['id']?>" name="var<?=$var['id']?>" class="custom-control-input" required <?php if($varozellik3['disable'] == '1' ) { ?>disabled<?php }?>>
                                                <label class="custom-control-label" for="varyant<?=$varozellik3['id']+22565?>" style="font-weight: 500; font-size: 14px ;"  data-toggle="tooltip" data-placement="bottom" title="<?php if($varozellik3['disable'] != '1' ) { ?><?=$varozellik3['baslik']?><?php }else{?><?=$varozellik3['disable_t']?><?php } ?>">
                                                    <img src="i/variants/<?=$varozellik3['gorsel']?>" style="width: <?=$varozellik3['gorsel_w']?>px; height: <?=$varozellik3['gorsel_h']?>px">
                                                    <?php if($varozellik3['ek_fiyat'] > '0' && $varozellik3['ek_fiyat'] == !null && $varozellik3['fiyat_goster'] == '1') {?>
                                                        <span style="font-size: 13px ;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik3['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                                <?=$secilikur['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                                        ]
                                                        </span>
                                                    <?php }?>
                                                </label>
                                            </div>
                                            </div>
                                        <?php }else { ?>
                                            <div class="custom-control custom-radio" style="margin-right: 20px; ">
                                                <input type="radio" id="varyant<?=$varozellik3['id']+22565?>" value="<?=$varozellik3['id']?>" name="var<?=$var['id']?>" class="custom-control-input" required <?php if($varozellik3['disable'] == '1' ) { ?>disabled<?php }?>>
                                                <label class="custom-control-label" for="varyant<?=$varozellik3['id']+22565?>" style="font-weight: 500; font-size: 14px ;" >
                                                    <?=$varozellik3['baslik']?>
                                                    <?php if($varozellik3['disable'] != '1' ) {?>
                                                    <?php if($varozellik3['ek_fiyat'] > '0' && $varozellik3['ek_fiyat'] == !null && $varozellik3['fiyat_goster'] == '1') {?>
                                                        <br>
                                                        <span style="font-size: 13px ;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik3['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                                <?=$secilikur['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                                        ]
                                                        </span>
                                                    <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($varozellik3['disable_t'] == !null ) {?>
                                                           -- <?=$varozellik3['disable_t']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </label>
                                            </div>
                                        <?php }?>
                                    <?php }?>
                                </div>
                                <!-- Seçim Kutusu Radio Box SON !-->
                            <?php }?>
                            <?php if($var['tur'] =='4' ) {?>
                            <!-- Date Select !-->
                                <div class="product-detail-variant-div"  ">
                                    <?php foreach ($vartyantOzellikSorgu as $varRow) {?>
                                        <input type="hidden" name="var<?=$var['id']?>" value="<?=$varRow['id']?>">
                                    <?php }?>
                                    <label for="varyant<?=$varRow['id']?>">
                                        <?php if($var['zorunlu'] == '1' ) { ?>*<?php } ?>
                                        <?=$var['baslik']?>
                                        <?php if($varRow['ek_fiyat'] > '0' && $varRow['ek_fiyat'] == !null  && $varRow['fiyat_goster'] == '1') {?>
                                            <span style="font-size: 13px ; font-weight: 500; margin-left: 5px;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                    <?=$secilikur['sag_simge']?>
                                                <?php }?>
                                                <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varRow['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                    <?=$secilikur['sol_simge']?>
                                                <?php }?>
                                                <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                    <?=$secilikur['sag_simge']?>
                                                <?php }?>
                                                                        ]
                                               </span>
                                        <?php }?>
                                    </label>
                                        <div class="date-select-variant">
                                            <input type="text" name="ek_var<?=$var['id']?>" class="form-control date-variant" placeholder="<?=$diller['varyant-secim-tarih']?>"   id="varyant<?=$varRow['id']?>" autocomplete="off" <?php if($var['zorunlu'] == '1' ) { ?>required<?php }?> >
                                            <i class="ion-calendar"></i>
                                        </div>
                                </div>

                            <!--  <========SON=========>>> Date Select SON !-->
                            <?php }?>
                    <?php }?>
                </div>
            <?php }?>
            <!-- Varyantlar Buraya SON !-->
            <script>
                var basePrice = <?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$mevcutfiyat ) ?>

                    function formatCurrency(num)
                    {
                        num = num.toString().replace(/\$|\,/g, '');
                        if (isNaN(num))
                        {
                            num = "0";
                        }

                        sign = (num == (num = Math.abs(num)));
                        num = Math.floor(num * 100 + 0.50000000001);
                        cents = num % 100;
                        num = Math.floor(num / 100).toString();

                        if (cents < 10)
                        {
                            cents = "0" + cents;
                        }
                        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                        {
                            num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
                        }

                        return (((sign) ? '' : '-') + num + '.' + cents);
                    }

                $(".calculate").change(function () {
                    newPrice = basePrice;
                    $(".calculate option:selected").each(function () {
                        newPrice += parseFloat($(this).data('price'));
                        console.log(typeof newPrice);
                    });
                    newPrice = formatCurrency(newPrice);
                    $("#item-price").html(newPrice);
                });



                 var basePrice2 = <?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ) ?>

                    function formatCurrency(num)
                    {
                        num = num.toString().replace(/\$|\,/g, '');
                        if (isNaN(num))
                        {
                            num = "0";
                        }

                        sign = (num == (num = Math.abs(num)));
                        num = Math.floor(num * 100 + 0.50000000001);
                        cents = num % 100;
                        num = Math.floor(num / 100).toString();

                        if (cents < 10)
                        {
                            cents = "0" + cents;
                        }
                        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                        {
                            num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
                        }

                        return (((sign) ? '' : '-') + num + '.' + cents);
                    }

                $(".calculate").change(function () {
                    newPrice2 = basePrice2;
                    $(".calculate option:selected").each(function () {
                        newPrice2 += parseFloat($(this).data('price'));
                        console.log(typeof newPrice2);
                    });
                    newPrice2 = formatCurrency(newPrice2);
                    $("#item-price2").html(newPrice2);
                });
            </script>
            <?php } ?>

        <?php if($odemeayar['wp_siparis'] == '1' || $odemeayar['sepet_sistemi'] == '1' ) {?>
            <div class="urun-detay-sag-alan-sepet">
             <!-- Sepete EKle Button !-->
                <?php if($odemeayar['sepet_sistemi'] == '1'  ) {?>
                    <div class="urun-detay-sag-alan-sepet-box">
                        <input name="product_code" type="hidden" value="<?php echo $icerik["id"]; ?>">
                        <div class="quantity">
                            <input type="number" min="1" <?php if($icerik['fiyat'] >'0' ) { ?>max="<?=$icerik['stok']?>"<?php }else{?> max="1" <?php } ?>  step="1" value="1" name="quantity">
                        </div>
                    </div>
                    <div class="urun-detay-sag-alan-sepet-box" >
                        <button type="submit" name="addtocart" class=" <?=$udetayRow['detay_sepet_button']?> " >
                            <?=$diller['urun-detay-sepete-ekle']?>
                        </button>
                    </div>
                    </form>
                <?php }?>
                <!--  <========SON=========>>> Sepete EKle Button SON !-->
                <!-- Whatsapp sipariş button !-->
                <?php if($odemeayar['wp_siparis'] == '1'  ) {?>
                    <a style="" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo boslukSil($odemeayar['wp_no']) ?>&text=<?=$ayar['site_url']?><?=$icerik['seo_url']?>-P<?=$icerik['id']?>  <?=$diller['urun-detay-whatsapp-siparis-text']?>" class="urun-detay-sag-alan-sepet-box-wp" >
                        <i class="fa fa-whatsapp"></i> <?=$diller['urun-detay-wp-siparis']?>
                    </a>
                <?php }?>
                <!--  <========SON=========>>> Whatsapp sipariş button SON !-->
            </div>
        <?php } ?>
    <?php }/*  <========SON=========>>> Fiyat Herkese Açık. SON */?>

    <?php if($icerik['fiyat_goster'] =='2' ) {
        /* Fiyat Sadece Üyelere Açık. */
        if($userSorgusu->rowCount()>'0'  ) {
        ?>
        <?php if($odemeayar['sepet_sistemi'] == '1'  ) {?>
        <form action="addtocart" method="post" id="entercancel">
         <input name="token" type="hidden" value="<?=md5('detailCallBack')?>">
            <!-- Varyantlar Buraya !-->
            <?php if($varyantSorgu->rowCount() > '0'  ) { ?>
                <div style="width: 100%; display: flex; align-items: flex-start; flex-wrap: wrap; justify-content: flex-start; margin-top:20px;  ">
                         <?php foreach ($varyantSorgu as $var) { ?>
                            <?php
                            $vartyantOzellikSorgu = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            $vartyantOzellikSorgu2 = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu2->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            $vartyantOzellikSorgu3 = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu3->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            ?>
                            <?php if($var['tur'] =='1' ) {?>
                                <div class="product-detail-variant-div">
                                    <!-- Fiyat Değişkenli SelectBox !-->
                                    <label for="varyant<?=$var['id']?>">* <?=$var['baslik']?></label>
                                    <select name="var<?=$var['id']?>" class="form-control calculate" id="varyant<?=$var['id']?>" required style="width: 100% !;  ">
                                        <option data-price="0" value=""><?=$diller['varyant-secim-yapin-yazisi']?></option>
                                        <?php foreach ($vartyantOzellikSorgu as $varozellik) {?>
                                            <option data-price="<?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik['ek_fiyat'] ) ?>" value="<?=$varozellik['id']?>" <?php if($varozellik['disable'] == '1' ) { ?>disabled<?php }?>>

                                                <?=$varozellik['baslik']?>
                                                <?php if($varozellik['disable'] != '1' ) {?>
                                                <?php if($varozellik['ek_fiyat'] > '0' && $varozellik['fiyat_goster'] == '1') { ?>
                                                    [+
                                                    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                    <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                    ]<?php } ?>
                                                <?php }else { ?>
                                                       <?php if($varozellik['disable_t'] == !null ) {?>
                                                           -- <?=$varozellik['disable_t']?>
                                                        <?php }?>
                                                <?php }?>
                                            </option>
                                        <?php }?>
                                    </select>
                                    <!-- Fiyat Değişkenli SelectBox SON !-->
                                </div>
                            <?php }?>
                            <?php if($var['tur'] =='2' ) {?>
                                <!-- Yazılabilir Textarea !-->
                                <div class="product-detail-variant-div" style="width: 100% ;  ">
                                    <?php foreach ($vartyantOzellikSorgu2 as $varozellik2) {?>
                                        <input type="hidden" name="var<?=$var['id']?>" value="<?=$varozellik2['id']?>">
                                    <?php }?>
                                    <label for="varyant<?=$var['id']?>">
                                        <?php if($var['zorunlu'] == '1' ) { ?>*<?php } ?>
                                        <?=$var['baslik']?>
                                        <?php if($varozellik2['ek_fiyat'] > '0' && $varozellik2['ek_fiyat'] == !null  && $varozellik2['fiyat_goster'] == '1') {?>
                                            <span style="font-size: 13px ; font-weight: 500; margin-left: 5px;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                    <?=$secilikur['sag_simge']?>
                                                <?php }?>
                                                <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik2['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                    <?=$secilikur['sol_simge']?>
                                                <?php }?>
                                                <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                    <?=$secilikur['sag_simge']?>
                                                <?php }?>
                                                                        ]
                                                        </span>
                                        <?php }?>
                                    </label>
                                    <input name="ek_var<?=$var['id']?>" id="varyant<?=$var['id']?>" class="form-control" <?php if($var['zorunlu'] == '1' ) { ?>required<?php }?> style="width: 100%;  ">
                                </div>
                                <!-- Yazılabilir Textarea SON !-->
                            <?php }?>
                            <?php if($var['tur'] =='3' ) {?>
                                <!-- Seçim Kutusu Radio Box !-->
                                <div class="product-detail-variant-div" style="width: 100% ; display: flex; justify-content: flex-start; flex-wrap: wrap ">
                                    <div style="width: 100%; font-weight: bold;">
                                        <label for="">
                                            * <?=$var['baslik']?>
                                        </label>
                                    </div>
                                    <?php foreach ($vartyantOzellikSorgu3 as $varozellik3) {?>
                                        <?php if($varozellik3['gorsel'] == !null && $varozellik3['gorsel'] > '0') {?>
                                            <style>
                                                .customVariantCheckbox .custom-control{
                                                    padding-left: 0 !important;
                                                }
                                                .customVariantCheckbox .custom-control-label{
                                                    border: 2px solid #fff;
                                                    padding: 5px;
                                                    transition-duration: 0.1s; transition-timing-function: linear;
                                                    cursor: pointer;
                                                }
                                                .customVariantCheckbox .custom-control input:checked +label{
                                                    border: 2px solid #<?=$udetayRow['urundetay_aktif_tab']?> !important;
                                                }
                                                .customVariantCheckbox .custom-control-label::before{
                                                    display: none !important;
                                                    width: 0 !important;
                                                }
                                            </style>
                                            <div class="customVariantCheckbox">
                                                 <div class="custom-control custom-radio" style="margin-right: 10px; ">
                                                <input type="radio" id="varyant<?=$varozellik3['id']+22565?>" value="<?=$varozellik3['id']?>" name="var<?=$var['id']?>" class="custom-control-input" required <?php if($varozellik3['disable'] == '1' ) { ?>disabled<?php }?>>
                                                <label class="custom-control-label" for="varyant<?=$varozellik3['id']+22565?>" style="font-weight: 500; font-size: 14px ;"  data-toggle="tooltip" data-placement="bottom" title="<?php if($varozellik3['disable'] != '1' ) { ?><?=$varozellik3['baslik']?><?php }else{?><?=$varozellik3['disable_t']?><?php } ?>">
                                                    <img src="i/variants/<?=$varozellik3['gorsel']?>" style="width: <?=$varozellik3['gorsel_w']?>px; height: <?=$varozellik3['gorsel_h']?>px">
                                                    <?php if($varozellik3['ek_fiyat'] > '0' && $varozellik3['ek_fiyat'] == !null && $varozellik3['fiyat_goster'] == '1') {?>
                                                        <span style="font-size: 13px ;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik3['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                                <?=$secilikur['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                                        ]
                                                        </span>
                                                    <?php }?>
                                                </label>
                                            </div>
                                            </div>
                                        <?php }else { ?>
                                            <div class="custom-control custom-radio" style="margin-right: 20px; ">
                                                <input type="radio" id="varyant<?=$varozellik3['id']+22565?>" value="<?=$varozellik3['id']?>" name="var<?=$var['id']?>" class="custom-control-input" required <?php if($varozellik3['disable'] == '1' ) { ?>disabled<?php }?>>
                                                <label class="custom-control-label" for="varyant<?=$varozellik3['id']+22565?>" style="font-weight: 500; font-size: 14px ;" >
                                                    <?=$varozellik3['baslik']?>
                                                    <?php if($varozellik3['disable'] != '1' ) {?>
                                                    <?php if($varozellik3['ek_fiyat'] > '0' && $varozellik3['ek_fiyat'] == !null && $varozellik3['fiyat_goster'] == '1') {?>
                                                        <br>
                                                        <span style="font-size: 13px ;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik3['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                                <?=$secilikur['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                                        ]
                                                        </span>
                                                    <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($varozellik3['disable_t'] == !null ) {?>
                                                           -- <?=$varozellik3['disable_t']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </label>
                                            </div>
                                        <?php }?>
                                    <?php }?>
                                </div>
                                <!-- Seçim Kutusu Radio Box SON !-->
                            <?php }?>
                            <?php if($var['tur'] =='4' ) {?>
                                                        <!-- Date Select !-->
                                                            <div class="product-detail-variant-div"  ">
                                                                <?php foreach ($vartyantOzellikSorgu as $varRow) {?>
                                                                    <input type="hidden" name="var<?=$var['id']?>" value="<?=$varRow['id']?>">
                                                                <?php }?>
                                                                <label for="varyant<?=$varRow['id']?>">
                                                                    <?php if($var['zorunlu'] == '1' ) { ?>*<?php } ?>
                                                                    <?=$var['baslik']?>
                                                                    <?php if($varRow['ek_fiyat'] > '0' && $varRow['ek_fiyat'] == !null  && $varRow['fiyat_goster'] == '1') {?>
                                                                        <span style="font-size: 13px ; font-weight: 500; margin-left: 5px;">
                                                                                                   [+
                                                                                           <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                                               <?=$secilikur['sol_simge']?>
                                                                                           <?php }?>
                                                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                                                <?=$secilikur['sag_simge']?>
                                                                            <?php }?>
                                                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varRow['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                                                <?=$secilikur['sol_simge']?>
                                                                            <?php }?>
                                                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                                                <?=$secilikur['sag_simge']?>
                                                                            <?php }?>
                                                                                                    ]
                                                                           </span>
                                                                    <?php }?>
                                                                </label>
                                                                    <div class="date-select-variant">
                                                                        <input type="text" name="ek_var<?=$var['id']?>" class="form-control date-variant" placeholder="<?=$diller['varyant-secim-tarih']?>"   id="varyant<?=$varRow['id']?>" autocomplete="off" <?php if($var['zorunlu'] == '1' ) { ?>required<?php }?> >
                                                                        <i class="ion-calendar"></i>
                                                                    </div>
                                                            </div>

                                                        <!--  <========SON=========>>> Date Select SON !-->
                                                        <?php }?>
                    <?php }?>
                </div>
            <?php }?>
            <!-- Varyantlar Buraya SON !-->

            <!-- Dinamik Fiyat !-->
            <script>
                var basePrice = <?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$mevcutfiyat ) ?>

                    function formatCurrency(num)
                    {
                        num = num.toString().replace(/\$|\,/g, '');
                        if (isNaN(num))
                        {
                            num = "0";
                        }

                        sign = (num == (num = Math.abs(num)));
                        num = Math.floor(num * 100 + 0.50000000001);
                        cents = num % 100;
                        num = Math.floor(num / 100).toString();

                        if (cents < 10)
                        {
                            cents = "0" + cents;
                        }
                        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                        {
                            num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
                        }

                        return (((sign) ? '' : '-') + num + '.' + cents);
                    }

                $(".calculate").change(function () {
                    newPrice = basePrice;
                    $(".calculate option:selected").each(function () {
                        newPrice += parseFloat($(this).data('price'));
                        console.log(typeof newPrice);
                    });
                    newPrice = formatCurrency(newPrice);
                    $("#item-price").html(newPrice);
                });



                 var basePrice2 = <?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ) ?>

                    function formatCurrency(num)
                    {
                        num = num.toString().replace(/\$|\,/g, '');
                        if (isNaN(num))
                        {
                            num = "0";
                        }

                        sign = (num == (num = Math.abs(num)));
                        num = Math.floor(num * 100 + 0.50000000001);
                        cents = num % 100;
                        num = Math.floor(num / 100).toString();

                        if (cents < 10)
                        {
                            cents = "0" + cents;
                        }
                        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                        {
                            num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
                        }

                        return (((sign) ? '' : '-') + num + '.' + cents);
                    }

                $(".calculate").change(function () {
                    newPrice2 = basePrice2;
                    $(".calculate option:selected").each(function () {
                        newPrice2 += parseFloat($(this).data('price'));
                        console.log(typeof newPrice2);
                    });
                    newPrice2 = formatCurrency(newPrice2);
                    $("#item-price2").html(newPrice2);
                });
            </script>
            <!-- Dinamik Fiyat SON !-->
            <?php } ?>

        <?php if($odemeayar['wp_siparis'] == '1' || $odemeayar['sepet_sistemi'] == '1' ) {?>
            <div class="urun-detay-sag-alan-sepet">

             <!-- Sepete EKle Button !-->
                <?php if($odemeayar['sepet_sistemi'] == '1'  ) {?>
                    <div class="urun-detay-sag-alan-sepet-box">
                        <input name="product_code" type="hidden" value="<?php echo $icerik["id"]; ?>">
                        <div class="quantity">
                            <input type="number" min="1" <?php if($icerik['fiyat'] >'0' ) { ?>max="<?=$icerik['stok']?>"<?php }else{?> max="1" <?php } ?> step="1" value="1" name="quantity">
                        </div>
                    </div>
                    <div class="urun-detay-sag-alan-sepet-box" >
                        <button type="submit" name="addtocart" class=" <?=$udetayRow['detay_sepet_button']?> " >
                            <?=$diller['urun-detay-sepete-ekle']?>
                        </button>
                    </div>
                    </form>
                <?php }?>
                <!--  <========SON=========>>> Sepete EKle Button SON !-->

                <!-- Whatsapp sipariş button !-->
             <?php if($odemeayar['wp_siparis'] == '1'  ) {?>
                    <a style="" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo boslukSil($odemeayar['wp_no']) ?>&text=<?=$ayar['site_url']?><?=$icerik['seo_url']?>-P<?=$icerik['id']?>  <?=$diller['urun-detay-whatsapp-siparis-text']?>" class="urun-detay-sag-alan-sepet-box-wp" >
                        <i class="fa fa-whatsapp"></i> <?=$diller['urun-detay-wp-siparis']?>
                    </a>
                <?php }?>
                <!--  <========SON=========>>> Whatsapp sipariş button SON !-->

            </div>
        <?php } ?>


    <?php }}/*  <========SON=========>>> Fiyat Sadece Üyelere Açık. SON */?>
    <?php if($icerik['fiyat_goster'] =='3' ) {
        /* Fiyat Üye Gruplarına Açık. */
        if($userSorgusu->rowCount()>'0' && $uyegruplariCek->rowCount()>'0'  ) {
        ?>
        <?php if($odemeayar['sepet_sistemi'] == '1'  ) {?>
        <form action="addtocart" method="post" id="entercancel">
         <input name="token" type="hidden" value="<?=md5('detailCallBack')?>">
            <!-- Varyantlar Buraya !-->
            <?php if($varyantSorgu->rowCount() > '0'  ) { ?>
                <div style="width: 100%; display: flex; align-items: flex-start; flex-wrap: wrap; justify-content: flex-start; margin-top:20px;  ">
                           <?php foreach ($varyantSorgu as $var) { ?>
                            <?php
                            $vartyantOzellikSorgu = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            $vartyantOzellikSorgu2 = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu2->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            $vartyantOzellikSorgu3 = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id ");
                            $vartyantOzellikSorgu3->execute(array(
                                'varyant_id' => $var['varyant_id'],
                                'urun_id' => $icerik['id']
                            ));
                            ?>
                            <?php if($var['tur'] =='1' ) {?>
                                <div class="product-detail-variant-div">
                                    <!-- Fiyat Değişkenli SelectBox !-->
                                    <label for="varyant<?=$var['id']?>">* <?=$var['baslik']?></label>
                                    <select name="var<?=$var['id']?>" class="form-control calculate" id="varyant<?=$var['id']?>" required style="width: 100% !;  ">
                                        <option data-price="0" value=""><?=$diller['varyant-secim-yapin-yazisi']?></option>
                                        <?php foreach ($vartyantOzellikSorgu as $varozellik) {?>
                                            <option data-price="<?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik['ek_fiyat'] ) ?>" value="<?=$varozellik['id']?>" <?php if($varozellik['disable'] == '1' ) { ?>disabled<?php }?>>

                                                <?=$varozellik['baslik']?>
                                                <?php if($varozellik['disable'] != '1' ) {?>
                                                <?php if($varozellik['ek_fiyat'] > '0' && $varozellik['fiyat_goster'] == '1') { ?>
                                                    [+
                                                    <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                    <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                    <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                        <?=$secilikur['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                        <?=$secilikur['sag_simge']?>
                                                    <?php }?>
                                                    ]<?php } ?>
                                                <?php }else { ?>
                                                       <?php if($varozellik['disable_t'] == !null ) {?>
                                                           -- <?=$varozellik['disable_t']?>
                                                        <?php }?>
                                                <?php }?>
                                            </option>
                                        <?php }?>
                                    </select>
                                    <!-- Fiyat Değişkenli SelectBox SON !-->
                                </div>
                            <?php }?>
                            <?php if($var['tur'] =='2' ) {?>
                                <!-- Yazılabilir Textarea !-->
                                <div class="product-detail-variant-div" style="width: 100% ;  ">
                                    <?php foreach ($vartyantOzellikSorgu2 as $varozellik2) {?>
                                        <input type="hidden" name="var<?=$var['id']?>" value="<?=$varozellik2['id']?>">
                                    <?php }?>
                                    <label for="varyant<?=$var['id']?>">
                                        <?php if($var['zorunlu'] == '1' ) { ?>*<?php } ?>
                                        <?=$var['baslik']?>
                                        <?php if($varozellik2['ek_fiyat'] > '0' && $varozellik2['ek_fiyat'] == !null  && $varozellik2['fiyat_goster'] == '1') {?>
                                            <span style="font-size: 13px ; font-weight: 500; margin-left: 5px;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                    <?=$secilikur['sag_simge']?>
                                                <?php }?>
                                                <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik2['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                    <?=$secilikur['sol_simge']?>
                                                <?php }?>
                                                <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                    <?=$secilikur['sag_simge']?>
                                                <?php }?>
                                                                        ]
                                                        </span>
                                        <?php }?>
                                    </label>
                                    <input name="ek_var<?=$var['id']?>" id="varyant<?=$var['id']?>" class="form-control" <?php if($var['zorunlu'] == '1' ) { ?>required<?php }?> style="width: 100%;  ">
                                </div>
                                <!-- Yazılabilir Textarea SON !-->
                            <?php }?>
                            <?php if($var['tur'] =='3' ) {?>
                                <!-- Seçim Kutusu Radio Box !-->
                                <div class="product-detail-variant-div" style="width: 100% ; display: flex; justify-content: flex-start; flex-wrap: wrap ">
                                    <div style="width: 100%; font-weight: bold;">
                                        <label for="">
                                            * <?=$var['baslik']?>
                                        </label>
                                    </div>
                                    <?php foreach ($vartyantOzellikSorgu3 as $varozellik3) {?>
                                        <?php if($varozellik3['gorsel'] == !null && $varozellik3['gorsel'] > '0') {?>
                                            <style>
                                                .customVariantCheckbox .custom-control{
                                                    padding-left: 0 !important;
                                                }
                                                .customVariantCheckbox .custom-control-label{
                                                    border: 2px solid #fff;
                                                    padding: 5px;
                                                    transition-duration: 0.1s; transition-timing-function: linear;
                                                    cursor: pointer;
                                                }
                                                .customVariantCheckbox .custom-control input:checked +label{
                                                    border: 2px solid #<?=$udetayRow['urundetay_aktif_tab']?> !important;
                                                }
                                                .customVariantCheckbox .custom-control-label::before{
                                                    display: none !important;
                                                    width: 0 !important;
                                                }
                                            </style>
                                            <div class="customVariantCheckbox">
                                                 <div class="custom-control custom-radio" style="margin-right: 10px; ">
                                                <input type="radio" id="varyant<?=$varozellik3['id']+22565?>" value="<?=$varozellik3['id']?>" name="var<?=$var['id']?>" class="custom-control-input" required <?php if($varozellik3['disable'] == '1' ) { ?>disabled<?php }?>>
                                                <label class="custom-control-label" for="varyant<?=$varozellik3['id']+22565?>" style="font-weight: 500; font-size: 14px ;"  data-toggle="tooltip" data-placement="bottom" title="<?php if($varozellik3['disable'] != '1' ) { ?><?=$varozellik3['baslik']?><?php }else{?><?=$varozellik3['disable_t']?><?php } ?>">
                                                    <img src="i/variants/<?=$varozellik3['gorsel']?>" style="width: <?=$varozellik3['gorsel_w']?>px; height: <?=$varozellik3['gorsel_h']?>px">
                                                    <?php if($varozellik3['ek_fiyat'] > '0' && $varozellik3['ek_fiyat'] == !null && $varozellik3['fiyat_goster'] == '1') {?>
                                                        <span style="font-size: 13px ;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik3['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                                <?=$secilikur['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                                        ]
                                                        </span>
                                                    <?php }?>
                                                </label>
                                            </div>
                                            </div>
                                        <?php }else { ?>
                                            <div class="custom-control custom-radio" style="margin-right: 20px; ">
                                                <input type="radio" id="varyant<?=$varozellik3['id']+22565?>" value="<?=$varozellik3['id']?>" name="var<?=$var['id']?>" class="custom-control-input" required <?php if($varozellik3['disable'] == '1' ) { ?>disabled<?php }?>>
                                                <label class="custom-control-label" for="varyant<?=$varozellik3['id']+22565?>" style="font-weight: 500; font-size: 14px ;" >
                                                    <?=$varozellik3['baslik']?>
                                                    <?php if($varozellik3['disable'] != '1' ) {?>
                                                    <?php if($varozellik3['ek_fiyat'] > '0' && $varozellik3['ek_fiyat'] == !null && $varozellik3['fiyat_goster'] == '1') {?>
                                                        <br>
                                                        <span style="font-size: 13px ;">
                                                                       [+
                                                               <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                   <?=$secilikur['sol_simge']?>
                                                               <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varozellik3['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                                <?=$secilikur['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                                <?=$secilikur['sag_simge']?>
                                                            <?php }?>
                                                                        ]
                                                        </span>
                                                    <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($varozellik3['disable_t'] == !null ) {?>
                                                           -- <?=$varozellik3['disable_t']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </label>
                                            </div>
                                        <?php }?>
                                    <?php }?>
                                </div>
                                <!-- Seçim Kutusu Radio Box SON !-->
                            <?php }?>
                            <?php if($var['tur'] =='4' ) {?>
                                                        <!-- Date Select !-->
                                                            <div class="product-detail-variant-div"  ">
                                                                <?php foreach ($vartyantOzellikSorgu as $varRow) {?>
                                                                    <input type="hidden" name="var<?=$var['id']?>" value="<?=$varRow['id']?>">
                                                                <?php }?>
                                                                <label for="varyant<?=$varRow['id']?>">
                                                                    <?php if($var['zorunlu'] == '1' ) { ?>*<?php } ?>
                                                                    <?=$var['baslik']?>
                                                                    <?php if($varRow['ek_fiyat'] > '0' && $varRow['ek_fiyat'] == !null  && $varRow['fiyat_goster'] == '1') {?>
                                                                        <span style="font-size: 13px ; font-weight: 500; margin-left: 5px;">
                                                                                                   [+
                                                                                           <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                                                                               <?=$secilikur['sol_simge']?>
                                                                                           <?php }?>
                                                                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                                                                <?=$secilikur['sag_simge']?>
                                                                            <?php }?>
                                                                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$varRow['ek_fiyat'] ), $secilikur['para_format']); ?>
                                                                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                                                                <?=$secilikur['sol_simge']?>
                                                                            <?php }?>
                                                                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                                                                <?=$secilikur['sag_simge']?>
                                                                            <?php }?>
                                                                                                    ]
                                                                           </span>
                                                                    <?php }?>
                                                                </label>
                                                                    <div class="date-select-variant">
                                                                        <input type="text" name="ek_var<?=$var['id']?>" class="form-control date-variant" placeholder="<?=$diller['varyant-secim-tarih']?>"   id="varyant<?=$varRow['id']?>" autocomplete="off" <?php if($var['zorunlu'] == '1' ) { ?>required<?php }?> >
                                                                        <i class="ion-calendar"></i>
                                                                    </div>
                                                            </div>

                                                        <!--  <========SON=========>>> Date Select SON !-->
                                                        <?php }?>
                    <?php }?>
                </div>
            <?php }?>
            <!-- Varyantlar Buraya SON !-->

            <!-- Dinamik Fiyat !-->
            <script>
                var basePrice = <?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$mevcutfiyat ) ?>

                    function formatCurrency(num)
                    {
                        num = num.toString().replace(/\$|\,/g, '');
                        if (isNaN(num))
                        {
                            num = "0";
                        }

                        sign = (num == (num = Math.abs(num)));
                        num = Math.floor(num * 100 + 0.50000000001);
                        cents = num % 100;
                        num = Math.floor(num / 100).toString();

                        if (cents < 10)
                        {
                            cents = "0" + cents;
                        }
                        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                        {
                            num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
                        }

                        return (((sign) ? '' : '-') + num + '.' + cents);
                    }

                $(".calculate").change(function () {
                    newPrice = basePrice;
                    $(".calculate option:selected").each(function () {
                        newPrice += parseFloat($(this).data('price'));
                        console.log(typeof newPrice);
                    });
                    newPrice = formatCurrency(newPrice);
                    $("#item-price").html(newPrice);
                });



                 var basePrice2 = <?php echo kurhesapla($varsayilankur['deger'],$secilikur['deger'],$havalefiyati ) ?>

                    function formatCurrency(num)
                    {
                        num = num.toString().replace(/\$|\,/g, '');
                        if (isNaN(num))
                        {
                            num = "0";
                        }

                        sign = (num == (num = Math.abs(num)));
                        num = Math.floor(num * 100 + 0.50000000001);
                        cents = num % 100;
                        num = Math.floor(num / 100).toString();

                        if (cents < 10)
                        {
                            cents = "0" + cents;
                        }
                        for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
                        {
                            num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
                        }

                        return (((sign) ? '' : '-') + num + '.' + cents);
                    }

                $(".calculate").change(function () {
                    newPrice2 = basePrice2;
                    $(".calculate option:selected").each(function () {
                        newPrice2 += parseFloat($(this).data('price'));
                        console.log(typeof newPrice2);
                    });
                    newPrice2 = formatCurrency(newPrice2);
                    $("#item-price2").html(newPrice2);
                });
            </script>
            <!-- Dinamik Fiyat SON !-->
            <?php } ?>

        <?php if($odemeayar['wp_siparis'] == '1' || $odemeayar['sepet_sistemi'] == '1' ) {?>
            <div class="urun-detay-sag-alan-sepet">

             <!-- Sepete EKle Button !-->
                <?php if($odemeayar['sepet_sistemi'] == '1'  ) {?>
                    <div class="urun-detay-sag-alan-sepet-box">
                        <input name="product_code" type="hidden" value="<?php echo $icerik["id"]; ?>">
                        <div class="quantity">
                            <input type="number" min="1" <?php if($icerik['fiyat'] >'0' ) { ?>max="<?=$icerik['stok']?>"<?php }else{?> max="1" <?php } ?> step="1" value="1" name="quantity">
                        </div>
                    </div>
                    <div class="urun-detay-sag-alan-sepet-box" >
                        <button type="submit" name="addtocart" class=" <?=$udetayRow['detay_sepet_button']?> " >
                            <?=$diller['urun-detay-sepete-ekle']?>
                        </button>
                    </div>
                    </form>
                <?php }?>
                <!--  <========SON=========>>> Sepete EKle Button SON !-->

                <!-- Whatsapp sipariş button !-->
              <?php if($odemeayar['wp_siparis'] == '1'  ) {?>
                    <a style="" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo boslukSil($odemeayar['wp_no']) ?>&text=<?=$ayar['site_url']?><?=$icerik['seo_url']?>-P<?=$icerik['id']?>  <?=$diller['urun-detay-whatsapp-siparis-text']?>" class="urun-detay-sag-alan-sepet-box-wp" >
                        <i class="fa fa-whatsapp"></i> <?=$diller['urun-detay-wp-siparis']?>
                    </a>
                <?php }?>
                <!--  <========SON=========>>> Whatsapp sipariş button SON !-->

            </div>
        <?php } ?>

    <?php }}/*  <========SON=========>>> Fiyat Üye Gruplarına Açık. SON */?>
<?php }
/*  <========SON=========>>> Ürün sepete eklenebilir SON */?>
<?php
if ($icerik['siparis_islem'] == '1' || $icerik['siparis_islem'] == '2' || $icerik['siparis_islem'] == '3'){
    /* Sipariş Formu */
   ?>
<div class="urun-detay-sag-alan-sepet">
    <div class="urun-detay-sag-alan-sepet-box">
    <button data-toggle="modal" data-target="#orderModal" class=" <?=$udetayRow['detay_sepet_button']?>" >
      <?=$diller['urun-detay-siparis-button-text']?>
    </button>
    </div>
    <?php if($odemeayar['wp_siparis'] == '1'  ) {?>
        <a style="" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo boslukSil($odemeayar['wp_no']) ?>&text=<?=$ayar['site_url']?><?=$icerik['seo_url']?>-P<?=$icerik['id']?>  <?=$diller['urun-detay-whatsapp-siparis-text']?>" class="urun-detay-sag-alan-sepet-box-wp" >
            <i class="fa fa-whatsapp"></i> <?=$diller['urun-detay-wp-siparis']?>
        </a>
    <?php }?>
</div>
    <?php /*  <========SON=========>>> Sipariş Formu SON */
}
?>
<?php
if ($icerik['siparis_islem'] == '4' || $icerik['siparis_islem'] == '5' || $icerik['siparis_islem'] == '6'){
    /* Teklif Formu */
    ?>
    <div class="urun-detay-sag-alan-sepet">
        <div class="urun-detay-sag-alan-sepet-box">
            <button data-toggle="modal" data-target="#offerModal" class=" <?=$udetayRow['detay_sepet_button']?>" >
                <?=$diller['urun-detay-siparis-teklif-text']?>
            </button>
        </div>
        <?php if($odemeayar['wp_siparis'] == '1'  ) {?>
            <a style="" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo boslukSil($odemeayar['wp_no']) ?>&text=<?=$ayar['site_url']?><?=$icerik['seo_url']?>-P<?=$icerik['id']?>  <?=$diller['urun-detay-whatsapp-siparis-text']?>" class="urun-detay-sag-alan-sepet-box-wp" >
                <i class="fa fa-whatsapp"></i> <?=$diller['urun-detay-wp-siparis']?>
            </a>
        <?php }?>
    </div>
    <?php /*  <========SON=========>>> Teklif Formu SON */
}
?>
<?php
if ($icerik['siparis_islem'] == '7'){
    /* Sadece WhatsApp Siparişi */
    ?>
    <?php if($odemeayar['wp_siparis'] == '1'  ) {?>
        <div class="urun-detay-sag-alan-sepet">
            <a style="" target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo boslukSil($odemeayar['wp_no']) ?>&text=<?=$ayar['site_url']?><?=$icerik['seo_url']?>-P<?=$icerik['id']?>  <?=$diller['urun-detay-whatsapp-siparis-text']?>" class="urun-detay-sag-alan-sepet-box-wp" >
                <i class="fa fa-whatsapp"></i> <?=$diller['urun-detay-wp-siparis']?>
            </a>
        </div>
    <?php }?>
<?php }    /*  <========SON=========>>> Sadece WhatsApp Siparişi SON */?>
<?php include 'includes/template/helper/product_detail/siparis-teklif-modal.php'; ?>




<?php if($varyantSorguFooter->rowCount()>0  ) {?>
<!-- Date Script !-->
<script>
    window.onload=function(){
        var dateToday = new Date();
        var selectedDate;
        <?php }?>
        <?php foreach ($varyantSorguFooter as $var) { ?>
        <?php
        $vartyantOzellikSorgu = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id  ");
        $vartyantOzellikSorgu->execute(array(
            'varyant_id' => $var['varyant_id'],
            'urun_id' => $icerik['id']
        ));
        if($vartyantOzellikSorgu->rowCount()>'0'  ) { ?>
        <?php foreach ($vartyantOzellikSorgu as $dateSorguVar) {?>
        $("#varyant<?=$dateSorguVar['id']?>").datepicker(    {
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                monthNamesShort : [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                firstDay:1,
                currentText: "<?=$diller['varyant-secim-tarih-bugun']?>",
                closeText: "<?=$diller['varyant-secim-tarih-kapat']?>",
                <?php if($dateSorguVar['tarih_yil'] == '1'  ) {?>
                changeMonth: true,
                changeYear: true,
                <?php }?>
                dateFormat: "yy-mm-dd",
                showButtonPanel: true,
                <?php if($dateSorguVar['tarih_bugun'] == '1'  ) {?>
                minDate: dateToday,
                <?php } ?>
            },
        );
        <?php } } } ?>
<?php if($varyantSorguFooter->rowCount()>0  ) {?>
        $(document).on('click', "button.ui-datepicker-current", function() {
            $.datepicker._curInst.input.datepicker('setDate', new Date())
        });
    }
</script>
<!--  <========SON=========>>> Date Script SON !-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<?php } ?>


