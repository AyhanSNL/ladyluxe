<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<ProductsList>
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

    if($anarow['kar'] > '0'  ) {
        $karOran = $anarow['kar'];

        $anafiyatOran = kdvhesapla($toplamFiyat,$karOran);
        $anaOzelfiyatOran = kdvhesapla($toplamOzelFiyat,$karOran);

        $sonFiyat = $toplamFiyat+$anafiyatOran;
        $sonOzelFiyat = $toplamOzelFiyat+$anaOzelfiyatOran;

    }else{
        $sonFiyat = $toplamFiyat;
        $sonOzelFiyat = $toplamOzelFiyat;
    }

    /*  <========SON=========>>> KDV li fiyat ve KDVli Özel Fiyat SON */
    ?>
    <Product>
        <?php if($anarow['ok_id'] == '1'  ) {?>
            <ProductID><?=$urun['id']?></ProductID>
        <?php }?>
        <?php if($anarow['ok_baslik'] == '1'  ) {?>
            <ProductName><![CDATA[<?=$urun['baslik']?>]]></ProductName>
        <?php }?>
        <?php if($anarow['ok_aciklama'] == '1'  ) {?>
            <ProductDescription><![CDATA[<?=$icerik?>]]></ProductDescription>
        <?php }?>
        <?php if($anarow['ok_kat'] == '1'  ) {?>
            <CategoryName><![CDATA[<?=$catName?>]]></CategoryName>
        <?php }?>
        <?php if($anarow['ok_marka'] == '1'  ) {?>
            <Brand><![CDATA[<?=$brand?>]]></Brand>
        <?php }?>
        <?php if($anarow['ok_gorsel'] == '1'  ) {?>
            <Photo><![CDATA[<?=$ayar['site_url']?>images/product/<?=$urun['gorsel']?>]]></Photo>
        <?php }?>
        <?php if($anarow['ok_gorsel'] == '1'  ) {?>
            <Images>
                <Image1><![CDATA[<?=$ayar['site_url']?>images/product/<?=$urun['gorsel']?>]]></Image1>
            </Images>
        <?php }?>
        <?php if($anarow['ok_stok'] == '1'  ) {?>
            <Stock><?=$urun['stok']?></Stock>
        <?php }?>
        <?php if($anarow['ok_stokkod'] == '1'  ) {?>
            <StockCode><![CDATA[<?=$urun['urun_kod']?>]]></StockCode>
        <?php }?>
        <?php if($anarow['ok_barkod'] == '1'  ) {?>
            <Barcode><?=$urun['barkod']?></Barcode>
        <?php }?>
        <?php if($anarow['ok_parabirimi'] == '1'  ) {?>
            <Currency><?=$anarow['parabirimi']?></Currency>
        <?php }?>
        <?php if($anarow['ok_alisfiyat'] == '1'  ) {?>
            <PurchasePrice><?php echo number_format($urun['alis_fiyat'], $paraFormat); ?></PurchasePrice>
        <?php }?>
        <?php if($anarow['ok_eskifiyat'] == '1'  ) {?>
            <OldPrice><?php echo number_format($urun['eski_fiyat'], $paraFormat); ?></OldPrice>
        <?php }?>
        <?php if($anarow['ok_fiyat'] == '1'  ) {?>
            <Price><?php echo number_format($sonFiyat, $paraFormat); ?></Price>
        <?php }?>
        <?php if($anarow['ok_ozelfiyat'] == '1'  ) {?>
            <SpecialPrice><?php echo number_format($sonOzelFiyat, $paraFormat); ?></SpecialPrice>
        <?php }?>
        <?php if($anarow['ok_kargodesi'] == '1'  ) {?>
            <CargoDeci><?=$urun['kargo_desi']?></CargoDeci>
        <?php }?>
        <?php if($anarow['ok_kargotutar'] == '1'  ) {?>
            <CargoAmount><?php echo number_format($kargoTutar, $paraFormat); ?></CargoAmount>
        <?php }?>
    </Product>
<?php }?>
</ProductsList>
