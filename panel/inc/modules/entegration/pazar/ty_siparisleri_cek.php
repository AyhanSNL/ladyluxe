<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    $pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
    $pazarSql->execute(array(
        'id' => '1'
    ));
    $pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);
    if($pazar['ty_durum'] == '1' ) {

        $bayino = $pazar['ty_bayi'];
        $api = $pazar['ty_api'];
        $secret = $pazar['ty_secret'];
        $supplierId = ''.$bayino.'';
        $username = ''.$api.'';
        $password = ''.$secret.'';
        $authorization = base64_encode($username . ':' . $password);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$supplierId.'/orders?orderByDirection=DESC',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT =>0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'User-Agent: ' . $supplierId . ' - SelfIntegration',
                'Authorization: Basic ' . $authorization,
            )
        ));

        $siparisler = curl_exec($curl);

        curl_close($curl);
        $json = json_decode($siparisler);
        $jsonSorgu = json_decode($siparisler,true);

        if($jsonSorgu['totalElements'] == '0'  ) {
            echo "Sipariş Yok!";
        }else{
            /* Siparişler array'da var. İşlem yapabilirsin */
            foreach ($json->content as $a){
                $musteriAd = ''.$a->customerFirstName.' '.$a->customerLastName.'';

                $sipariKontrol = $db->prepare("select * from trendyol_siparis where siparis_no=:siparis_no ");
                $sipariKontrol->execute(array(
                    'siparis_no' => $a->orderNumber
                ));

                if($sipariKontrol->rowCount() > '0' ) {
                    /* Sipariş var! Güncelle */
                    $guncelle = $db->prepare("UPDATE trendyol_siparis SET
                            siparis_durum=:siparis_durum,
                            kargo_adi=:kargo_adi,
                            kargo_takip_url=:kargo_takip_url   
                     WHERE siparis_no={$a->orderNumber}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'siparis_durum' => $a->shipmentPackageStatus,
                        'kargo_adi' => $a->cargoProviderName,
                        'kargo_takip_url' => $a->cargoTrackingLink
                    ));
                    /*  <========SON=========>>> Sipariş var! Güncelle SON */
                }else{
                    /* Sipariş Yok sıfırdan kaydet. */
                    $kaydet = $db->prepare("INSERT INTO trendyol_siparis SET
                   siparis_no=:siparis_no,     
                   teslimat_isim=:teslimat_isim,
                   teslimat_adres=:teslimat_adres,
                   ara_toplam=:ara_toplam,
                   indirim=:indirim,
                   toplam=:toplam,
                   fatura_isim=:fatura_isim,
                   fatura_adres=:fatura_adres,
                   musteri_isim=:musteri_isim,
                   musteri_eposta=:musteri_eposta,
                   musteri_tc=:musteri_tc,
                   siparis_tarih=:siparis_tarih,
                   siparis_sade_tarih=:siparis_sade_tarih,
                   siparis_durum=:siparis_durum,
                   kargo_adi=:kargo_adi,
                   kargo_takip_url=:kargo_takip_url
                ");
                    $sonuc = $kaydet->execute(array(
                        'siparis_no' => $a->orderNumber,
                        'teslimat_isim' => $a->shipmentAddress->fullName,
                        'teslimat_adres' => $a->shipmentAddress->fullAddress,
                        'ara_toplam' => $a->grossAmount,
                        'indirim' => $a->totalDiscount,
                        'toplam' => $a->totalPrice,
                        'fatura_isim' => $a->invoiceAddress->fullName,
                        'fatura_adres' => $a->invoiceAddress->fullAddress,
                        'musteri_isim' => $musteriAd,
                        'musteri_eposta' => $a->customerEmail,
                        'musteri_tc' => $a->tcIdentityNumber,
                        'siparis_tarih' => date("Y-m-d H:i:s", ($a->orderDate / 1000) ),
                        'siparis_sade_tarih' => date("Y-m-d", ($a->orderDate / 1000) ),
                        'siparis_durum' => $a->shipmentPackageStatus,
                        'kargo_adi' => $a->cargoProviderName,
                        'kargo_takip_url' => $a->cargoTrackingLink
                    ));
                    /* ürünleri kaydet */
                    foreach ($a->lines as $s){
                        echo 'Adet :'; echo $s->quantity;
                        echo "<br>";
                        echo 'Ürün Adı :'; echo $s->productName;
                        echo "<br>";
                        echo 'Ürün Fiyatı :'; echo $s->amount;
                        echo "<br>";
                        echo 'İndirim :'; echo $s->discount;
                        echo "<br>";
                        echo 'Toplam :'; echo $s->price;
                        echo "<br>";
                        echo 'Ürün Kodu :'; echo $s->merchantSku;
                        echo "<br>";
                        $kaydet = $db->prepare("INSERT INTO trendyol_siparis_urun SET
                             siparis_no=:siparis_no,   
                             adet=:adet,
                             sku=:sku,
                             baslik=:baslik,
                             fiyat=:fiyat,
                             indirim=:indirim,
                             toplam=:toplam
                        ");
                        $sonuc = $kaydet->execute(array(
                            'siparis_no' => $a->orderNumber,
                            'adet' => $s->quantity,
                            'sku' => $s->merchantSku,
                            'baslik' => $s->productName,
                            'fiyat' => $s->amount,
                            'indirim' => $s->discount,
                            'toplam' => $s->price
                        ));
                    }
                    /*  <========SON=========>>> Sipariş Yok sıfırdan kaydet. SON */
                }
            }
            $_SESSION['main_alert'] = 'success';
            header('Location:'.$ayar['panel_url'].'pages.php?page=ty_orders');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }

}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}