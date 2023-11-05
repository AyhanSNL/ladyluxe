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
        $markaCek = $db->prepare("select * from urun_marka where id=id ");
        $markaCek->execute(array(
            'id' => $urun['marka']
        ));
        $markaRow = $markaCek->fetch(PDO::FETCH_ASSOC);
        $brand = $markaRow['baslik'];
        $katCek = $db->prepare("select * from urun_cat where id=id ");
        $katCek->execute(array(
            'id' => $urun['iliskili_kat']
        ));
        $catRow = $katCek->fetch(PDO::FETCH_ASSOC);
        $catName = $catRow['baslik'];

        /* KDV li fiyat ve KDVli Özel Fiyat */
        $toplamFiyat = '0';
        $toplamOzelFiyat = '0';
        if($urun['kdv'] =='0' ) {
            $toplamFiyat = $urun['fiyat'];
            $toplamOzelFiyat = $urun['fiyat_tip2'];
        }
        if($urun['kdv'] =='1' ) {
            $kdvFiyat = kdvhesapla($urun['fiyat'],$urun['kdv_oran']);
            $kdvOzelFiyat = kdvhesapla($urun['fiyat_tip2'],$urun['kdv_oran']);
            $toplamFiyat = $urun['fiyat']+$kdvFiyat;
            $toplamOzelFiyat = $urun['fiyat_tip2']+$kdvOzelFiyat;
        }
        if($urun['kdv'] =='2' ) {
            $toplamFiyat = $urun['fiyat'];
            $toplamOzelFiyat = $urun['fiyat_tip2'];
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
                <Urun>
                    <UrunKodu/>
                    <Kod><?=$urun['id']?></Kod>
                    <Baslik><?=$urun['baslik']?>></Baslik>
                    <AltBaslik><?=$urun['seo_baslik']?>></AltBaslik>
                    <Aciklama><![CDATA[<?=$icerik?>]]></Aciklama>
                    <UrunOnayi>1</UrunOnayi>
                    <HazirlamaSuresi>1</HazirlamaSuresi>
                    <Kategori no="<?=$catRow['n11_id']?>" isim="<?=$catRow['n11_adi']?>">
                        <Ozellikler>
                            <Ozellik no="<?=$markaRow['n11_id']?>" isim="Marka"><?=$brand?></Ozellik>
                        </Ozellikler>
                    </Kategori>
                    <Fiyat><?php echo number_format($sonFiyat, $paraFormat); ?></Fiyat>
                    <UretimTarihi/>
                    <SonTuketimTarihi/>
                    <SatisBaslangicTarihi>07/07/2020</SatisBaslangicTarihi>
                    <SatisBitisTarihi>01/01/2050</SatisBitisTarihi>
                    <Stoklar>
                        <Stok>
                            <Miktar><?=$urun['stok']?></Miktar>
                            <StokKodu/>
                            <StokFiyati/>
                            <Gtin/>
                            <Mpn><?=$urun['id']?></Mpn>
                            <Bundle>false</Bundle>
                            <N11KatalogId/>
                        </Stok>
                    </Stoklar>
                    <IndirimTuru/>
                    <IndirimTutari>0.00</IndirimTutari>
                    <IndirimBaslangicTarihi/>
                    <IndirimBitisTarihi/>
                    <TeslimatSablonu><?=$anarow['n11_sablon']?></TeslimatSablonu>
                    <Resimler>
                        <Resim><?=$ayar['site_url']?>images/product/<?=$urun['gorsel']?></Resim>
                    </Resimler>
                    <ParaBirimi><?=$moneyrow['sag_simge']?></ParaBirimi>
                </Urun>
        <?php }?>
    <?php }?>
</Urunler>

