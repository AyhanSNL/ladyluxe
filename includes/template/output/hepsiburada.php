<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<Urunler>
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
            <Urun>
                <KategoriAdi><?=$catName?></KategoriAdi>
                <UrunID><?=$urun['id']?></UrunID>
                <UrunAdi><?=$urun['baslik']?>></UrunAdi>
                <KDV><?=$urun['kdv_oran']?></KDV>
                <Garanti>12</Garanti>
                <UrunAciklamasi><![CDATA[<?=$icerik?>]]></UrunAciklamasi>
                <ImageName1><?=$ayar['site_url']?>images/product/<?=$urun['gorsel']?></ImageName1>
                <hb_alis_kdv_haric><?php echo number_format($kdvsizFiyat, $paraFormat); ?></hb_alis_kdv_haric>
                <piyasa_fiyati_kdv_haric>0</piyasa_fiyati_kdv_haric>
                <son_kullanici_satis_kdv_haric><?php echo number_format($kdvsizFiyat, $paraFormat); ?></son_kullanici_satis_kdv_haric>
                <Kur><?=$moneyrow['sag_simge']?></Kur>
                <Desi><?=$urun['kargo_desi']?></Desi>
                <TedarikSuresi>3</TedarikSuresi>
                <Marka><?=$brand?></Marka>
                <Barcode/>
                <Barkod/>
                <StokAdedi><?=$urun['stok']?></StokAdedi>
                <HepsiburadaSKU><?=$urun['id']?></HepsiburadaSKU>
                <HepsiburadaProductID><?=$urun['id']?></HepsiburadaProductID>
                <HepsiburadaCatalog><?=$catName?></HepsiburadaCatalog>
            </Urun>
        <?php }?>
    <?php }?>
</Urunler>