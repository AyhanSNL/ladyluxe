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
            <item>
                <title><?=$urun['baslik']?>></title>
                <description><![CDATA[<?=$icerik?>]]></description>
                <link><?=$ayar['site_url']?><?=$urun['seo_url']?>-P<?=$urun['id']?></link>
                <g:id><?=$urun['id']?></g:id>
                <g:custom_label_0/>
                <g:gtin/>
                <g:availability>in stock</g:availability>
                <g:condition>new</g:condition>
                <g:product_type><?=$catName?></g:product_type>
                <g:google_product_category/>
                <g:price><?php echo number_format($sonFiyat, $paraFormat); ?> <?=$anarow['parabirimi']?></g:price>
                <g:brand><?=$brand?></g:brand>
                <g:mpn><?=$urun['urun_kod']?></g:mpn>
                <g:image_link><?=$ayar['site_url']?>images/product/<?=$urun['gorsel']?></g:image_link>
            </item>
            <?php }?>
        <?php }?>
    </channel>
</rss>
