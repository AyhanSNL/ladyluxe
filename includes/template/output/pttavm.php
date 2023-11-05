<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<Response>
    <Products/>
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
        $toplamOzelFiyat = '0';
        if($anarow['kar'] > '0'  ) {
            $karOran = $anarow['kar'];
            $anafiyatOran = kdvhesapla($urun['fiyat'],$karOran);
            $sonFiyat = $urun['fiyat']+$anafiyatOran;
        }else{
            $sonFiyat = $urun['fiyat'];
        }
        if($urun['kdv'] =='0' ) {
            $toplamFiyat = $sonFiyat;
            $kdvsizFiyat = $toplamFiyat;
        }
        if($urun['kdv'] =='1' ) {
            $kdvFiyat = kdvhesapla($sonFiyat,$urun['kdv_oran']);
            $toplamFiyat = $sonFiyat+$kdvFiyat;
            $kdvsizFiyat = $toplamFiyat;
        }
        if($urun['kdv'] =='2' ) {
            $toplamFiyat = $sonFiyat;
            $kdvsizFiyat = kdvcikar($toplamFiyat,$urun['kdv_oran']);
        }
        /*  <========SON=========>>> KDV li fiyat ve KDVli Özel Fiyat SON */
        ?>
        <?php if($urun['stok'] > '0' ) {?>
            <StokUrun>
                <Barkod><?=$urun['barkod']?></Barkod>
                <UrunID><?=$urun['id']?></UrunID>
                <UrunAdi><?=$urun['baslik']?>></UrunAdi>
                <KDVsiz><?php echo number_format($kdvsizFiyat, $paraFormat); ?></KDVsiz>
                <KDVOran><?=$urun['kdv_oran']?></KDVOran>
                <KDVli><?php echo number_format($toplamFiyat, $paraFormat); ?></KDVli>
                <para_cinsi><?=$moneyrow['sag_simge']?></para_cinsi>
                <Aciklama/>
                <UzunAciklama><![CDATA[<?=$icerik?>]]></UzunAciklama>
                <Miktar><?=$urun['stok']?></Miktar>
                <Iskonto>0</Iskonto>
                <Desi><?=$urun['kargo_desi']?></Desi>
                <UrunResim><?=$ayar['site_url']?>images/product/<?=$urun['gorsel']?></UrunResim>
            </StokUrun>
        <?php }?>
    <?php }?>
</Response>