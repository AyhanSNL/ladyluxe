<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
<channel>
    <title><?=$ayar['site_baslik']?></title>
    <description><?=$ayar['site_desc']?></description>
    <link><?=$ayar['site_url']?></link>
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
            $kdvsizFiyat = $toplamFiyat;
        }
        if($urun['kdv'] =='1' ) {
            $kdvFiyat = kdvhesapla($urun['fiyat'],$urun['kdv_oran']);
            $toplamFiyat = $urun['fiyat']+$kdvFiyat;
            $kdvsizFiyat = $toplamFiyat;
        }
        if($urun['kdv'] =='2' ) {
            $toplamFiyat = $urun['fiyat'];
            $kdvsizFiyat = kdvcikar($toplamFiyat,$urun['kdv_oran']);
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
            <item>
                <g:id><?=$urun['id']?></g:id>
                <g:link><?=$ayar['site_url']?><?=$urun['seo_url']?>-P<?=$urun['id']?></g:link>
                <g:title><?=$urun['baslik']?>></g:title>
                <g:description><![CDATA[<?=$icerik?>]]></g:description>
                <g:image_link><?=$ayar['site_url']?>images/product/<?=$urun['gorsel']?></g:image_link>
                <g:brand><?=$brand?></g:brand>
                <g:condition>new</g:condition>
                <g:availability>in stock</g:availability>
                <g:price><?php echo number_format($sonFiyat, $paraFormat); ?> <?=$anarow['parabirimi']?></g:price>
                <g:shipping>
                    <g:country>TR</g:country>
                    <g:service>Standart</g:service>
                    <g:price> <?=$anarow['parabirimi']?></g:price>
                </g:shipping>
                <g:google_product_category/>
            </item>
        <?php }?>
    <?php }?>
</channel>
</rss>