<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<MerchantItems xmlns:i="http://www.cimri.com/schema/merchant/upload" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
               xsi:schemaLocation="http://www.cimri.com/schema/merchant/upload ">
    <?php foreach ($urunler as $urun) {
        $icerik = $urun['icerik'];
        $eski = '../i/uploads/';
        $yeni = '' . $ayar['site_url'] . 'i/uploads/';
        $icerik = str_replace($eski, $yeni, $icerik);
        if ($urun['kargo_ucret'] > '0') {
            if ($odemeayar['kargo_sabit'] == '1') {
                $kargoTutar = $odemeayar['kargo_sabit_ucret'];
            } else {
                $kargoTutar = $urun['kargo_ucret'];
            }
        } else {
            $kargoTutar = '0';
        }
        $markaCek = $db->prepare("select baslik from urun_marka where id=id ");
        $markaCek->execute(array(
            'id' => $urun['marka']
        ));
        $markaRow = $markaCek->fetch(PDO::FETCH_ASSOC);
        $brand = $markaRow['baslik'];
        $katCek = $db->prepare("select baslik,id from urun_cat where id=id ");
        $katCek->execute(array(
            'id' => $urun['iliskili_kat']
        ));
        $catRow = $katCek->fetch(PDO::FETCH_ASSOC);
        $catName = $catRow['baslik'];

        /* KDV li fiyat ve KDVli Özel Fiyat */
        $toplamFiyat = '0';
        if ($urun['kdv'] == '0') {
            $toplamFiyat = $urun['fiyat'];
        }
        if ($urun['kdv'] == '1') {
            $kdvFiyat = kdvhesapla($urun['fiyat'], $urun['kdv_oran']);
            $toplamFiyat = $urun['fiyat'] + $kdvFiyat;
        }
        if ($urun['kdv'] == '2') {
            $toplamFiyat = $urun['fiyat'];
        }
        /*  <========SON=========>>> KDV li fiyat ve KDVli Özel Fiyat SON */

        /* havale fiyatı */
        if ($urun['havale_indirim_tutar'] > '0') {
            if ($urun['havale_indirim_tur'] == '1') {
                $oranBul = ($toplamFiyat * $urun['havale_indirim_tutar']) / 100;
                $havaleFiyat = $toplamFiyat - $oranBul;
            }
            if ($urun['havale_indirim_tur'] == '2') {
                $havaleFiyat = $toplamFiyat - $urun['havale_indirim_tutar'];
            }
        } else {
            $havaleFiyat = $toplamFiyat;
        }
        /*  <========SON=========>>> havale fiyatı SON */
        if ($anarow['kar'] > '0') {
            $karOran = $anarow['kar'];
            $anafiyatOran = kdvhesapla($toplamFiyat, $karOran);
            $havaleOran = kdvhesapla($havaleFiyat, $karOran);
            $sonFiyat = $toplamFiyat + $anafiyatOran;
            $sonHavaleFiyat = $toplamFiyat + $havaleOran;
        } else {
            $sonFiyat = $toplamFiyat;
            $sonHavaleFiyat = $havaleFiyat;
        }
        ?>
        <?php if($urun['stok'] > '0' ) {?>
            <MerchantItem>
                <brand><![CDATA[<?=$brand?>]]></brand>
                <merchantItemCategoryName><![CDATA[<?=$catName?>]]></merchantItemCategoryName>
                <merchantItemId><?=$urun['id']?></merchantItemId>
                <merchantItemCategoryId><?=$catRow['id']?></merchantItemCategoryId>
                <merchantItemField><![CDATA[<?=$urun['baslik']?>]]></merchantItemField>
                <itemTitle><![CDATA[<?=$urun['baslik']?>]]></itemTitle>
                <itemUrl><?=$ayar['site_url']?><?=$urun['seo_url']?>-P<?=$urun['id']?></itemUrl>
                <priceEft><?php echo number_format($sonHavaleFiyat, $paraFormat); ?></priceEft>
                <pricePlusTax><?php echo number_format($sonFiyat, $paraFormat); ?></pricePlusTax>
                <shippingFee>0</shippingFee>
                <stockStatus><?=$urun['stok']?></stockStatus>
                <shippingDay>0</shippingDay>
            </MerchantItem>
        <?php }?>
    <?php }?>
</MerchantItems>

