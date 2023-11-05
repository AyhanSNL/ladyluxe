<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
    <products>
        <?php foreach ($urunler as $urun) {
            $icerik  = $urun['icerik'];
            $eski   = '../i/uploads/';
            $yeni   = ''.$ayar['site_url'].'i/uploads/';
            $icerik = str_replace($eski, $yeni, $icerik);
            if($urun['kargo_ucret'] >'0' ) {
                if($odemeayar['kargo_sabit'] == '1' ) {
                    $kargoTutar = $odemeayar['kargo_sabit_ucret'];
                }else{
                    $kargoTutar = $urun['kargo_ucret'];
                }
            }else{
                $kargoTutar = '0';
            }
            $markaCek = $db->prepare("select baslik from urun_marka where id=id ");
            $markaCek->execute(array(
                'id' => $urun['marka']
            ));
            $markaRow = $markaCek->fetch(PDO::FETCH_ASSOC);
            $brand = $markaRow['baslik'];
            $katCek = $db->prepare("select baslik from urun_cat where id=id ");
            $katCek->execute(array(
                'id' => $urun['iliskili_kat']
            ));
            $catRow = $katCek->fetch(PDO::FETCH_ASSOC);
            $catName = $catRow['baslik'];

            /* KDV li fiyat ve KDVli Özel Fiyat */
            $toplamFiyat = '0';
            if($urun['kdv'] =='0' ) {
                $toplamFiyat = $urun['fiyat'];
            }
            if($urun['kdv'] =='1' ) {
                $kdvFiyat = kdvhesapla($urun['fiyat'],$urun['kdv_oran']);
                $toplamFiyat = $urun['fiyat']+$kdvFiyat;
            }
            if($urun['kdv'] =='2' ) {
                $toplamFiyat = $urun['fiyat'];
            }
            /*  <========SON=========>>> KDV li fiyat ve KDVli Özel Fiyat SON */
            if($anarow['kar'] > '0'  ) {
                $karOran = $anarow['kar'];
                $anafiyatOran = kdvhesapla($toplamFiyat,$karOran);
                $sonFiyat = $toplamFiyat+$anafiyatOran;
            }else{
                $sonFiyat = $toplamFiyat;
            }
            ?>
            <?php if($urun['stok'] > '0' ) {?>
                <product>
                    <sku><?=$urun['urun_kod']?></sku>
                    <name><?=$urun['baslik']?>></name>
                    <url><?=$ayar['site_url']?><?=$urun['seo_url']?>-P<?=$urun['id']?></url>
                    <imgUrl><?=$ayar['site_url']?>images/product/<?=$urun['gorsel']?></imgUrl>
                    <description><![CDATA[<?=$icerik?>]]></description>
                    <distributor/>
                    <price><?php echo number_format($sonFiyat, $paraFormat); ?></price>
                    <shipPrice><?php echo number_format($kargoTutar, $paraFormat); ?></shipPrice>
                    <shipmentVolume>0</shipmentVolume>
                    <dayOfDelivery>3</dayOfDelivery>
                    <expressDeliveryTime>16:00</expressDeliveryTime>
                    <quantity><?=$urun['stok']?></quantity>
                    <productBrand><?=$brand?></productBrand>
                    <productCategory><?=$catName?></productCategory>
                    <barcode><?=$urun['barkod']?></barcode>
                </product>
            <?php }?>
        <?php }?>
    </products>

