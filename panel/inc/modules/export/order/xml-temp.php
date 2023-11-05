<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$xml_Content .= '<?xml version="1.0" encoding="UTF-8"?>';
$xml_Content .= '<OrderList>';
foreach ($orderId as $order){
    $siparisler = $db->prepare("select * from siparisler where id=:id ");
    $siparisler->execute(array(
        'id' => $order
    ));
    $s = $siparisler->fetch(PDO::FETCH_ASSOC);
    $durum = $db->prepare("select baslik from siparis_durumlar where id=:id ");
    $durum->execute(array(
        'id' => $s['siparis_durum'],
    ));
    $dur = $durum->fetch(PDO::FETCH_ASSOC);
    $ulkecek = $db->prepare("select baslik from ulkeler where 3_iso=:3_iso ");
    $ulkecek->execute(array(
        '3_iso' => $s['ulke']
    ));
    $ulkeRow = $ulkecek->fetch(PDO::FETCH_ASSOC);
    $ulke = $ulkeRow['baslik'];
    $ulkecek2 = $db->prepare("select baslik from ulkeler where 3_iso=:3_iso ");
    $ulkecek2->execute(array(
        '3_iso' => $s['fatura_ulke']
    ));
    $ulkeRow2 = $ulkecek2->fetch(PDO::FETCH_ASSOC);
    $ulke2 = $ulkeRow2['baslik'];
    if($siparisler->rowCount()>'0'  ) {
        $date = $s['siparis_tarih'];
        $date = date("Y-m-d H:i:s", strtotime($date));
        $date = date("c", strtotime($date));
        /* Product List */
        $urunListesi = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
        $urunListesi->execute(array(
            'siparis_id' => $s['siparis_no'],
        ));
        /*  <========SON=========>>> Product List SON */
        $xml_Content .= '
<Order>
<OrderNumber>'.$s['siparis_no'].'</OrderNumber>
<OrderDate>'.$date.'</OrderDate>';
        $xml_Content .='<OrderStatus>'.$dur['baslik'].'</OrderStatus>';
        if($s['odeme_tur'] == '1' ) {
            $xml_Content .='<PaymentType>'.$diller['adminpanel-text-97'].'</PaymentType>';
        }
        if($s['odeme_tur'] == '2' ) {
            $xml_Content .='<PaymentType>'.$diller['adminpanel-text-98'].'</PaymentType>';
        }
        if($s['odeme_tur'] == '3' ) {
            $xml_Content .='<PaymentType>'.$diller['adminpanel-text-99'].'</PaymentType>';
            $xml_Content .='<ShippingExtraPay>'.number_format($s['kapida_odeme_bedeli'], 2).'</ShippingExtraPay>';
        }
        if($s['odeme_tur'] == '4' ) {
            $xml_Content .='<PaymentType>'.$diller['adminpanel-text-100'].'</PaymentType>';
            $xml_Content .='<ShippingExtraPay>'.number_format($s['kapida_odeme_bedeli'], 2).'</ShippingExtraPay>';
        }
        if($s['odeme_tur'] == 'free' ) {
            $xml_Content .='<PaymentType>'.$diller['adminpanel-form-text-1447'].'</PaymentType>';
        }
        $xml_Content .='<Currency>'.$s['parabirimi'].'</Currency>';
        if($s['odeme_tur'] == '2' ) {
            $xml_Content .='<TotalAmount>'.number_format($s['havale_toplamtutar'], 2).'</TotalAmount>';
        }else{
            $xml_Content .='<TotalAmount>'.number_format($s['toplam_tutar'], 2).'</TotalAmount>';
        }
        $xml_Content .='<CustomerNameSurname>'.$s['isim'].' '.$s['soyisim'].'</CustomerNameSurname>';
        $xml_Content .='<CustomerPhone>'.$s['alan_kodu'].''.$s['telefon'].'</CustomerPhone>';
        $xml_Content .='<CustomerEmail>'.$s['eposta'].'</CustomerEmail>';
        $xml_Content .='<ShippingAmount>'.number_format($s['kargo_tutar'], 2).'</ShippingAmount>';
        $xml_Content .='<ShippingAddress>'.$s['adresbilgisi'].'</ShippingAddress>';
        $xml_Content .='<ShippingZipCode>'.$s['postakodu'].'</ShippingZipCode>';
        $xml_Content .='<ShippingCity>'.$s['ilce'].' / '.$s['sehir'].'</ShippingCity>';
        $xml_Content .='<ShippingCountry>'.$ulke.'</ShippingCountry>';
        if($odemeRow['faturasiz_teslimat'] == '0' ) {
            if($s['fatura_turu'] == '1' ) {
                $xml_Content .='<BillingNameSurname>'.$s['fatura_isim'].' '.$s['fatura_soyisim'].'</BillingNameSurname>';
                $xml_Content .='<BillingCustomerIdentity>'.$s['fatura_tc'].'</BillingCustomerIdentity>';
                $xml_Content .='<BillingAddress>'.$s['fatura_adresi'].'</BillingAddress>';
                $xml_Content .='<BillingZipCode>'.$s['fatura_postakodu'].'</BillingZipCode>';
                $xml_Content .='<BillingCity>'.$s['fatura_ilce'].' / '.$s['fatura_sehir'].'</BillingCity>';
                $xml_Content .='<BillingCountry>'.$ulke2.'</BillingCountry>';
            }
            if($s['fatura_turu'] == '2' ) {
                $xml_Content .='<BillingCompanyName>'.$s['fatura_firma_unvan'].'</BillingCompanyName>';
                $xml_Content .='<BillingTax>'.$s['fatura_vergi_dairesi'].'</BillingTax>';
                $xml_Content .='<BillingTaxNumber>'.$s['fatura_vergi_no'].'</BillingTaxNumber>';
                $xml_Content .='<BillingAddress>'.$s['fatura_adresi'].'</BillingAddress>';
                $xml_Content .='<BillingZipCode>'.$s['fatura_postakodu'].'</BillingZipCode>';
                $xml_Content .='<BillingCity>'.$s['fatura_ilce'].' / '.$s['fatura_sehir'].'</BillingCity>';
                $xml_Content .='<BillingCountry>'.$ulke2.'</BillingCountry>';
            }
        }
        if($urunListesi->rowCount()>'0'  ) {
            $xml_Content .= '<OrderProductList>';
                foreach ($urunListesi as $urun){
                    $xml_Content .= '<ProductItem>';
                    $xml_Content .= '<ProductName>'.$urun['urun_baslik'].'</ProductName>';
                    $xml_Content .= '<ProductStockCode>'.$urun['stok_kodu'].'</ProductStockCode>';
                    $xml_Content .= '<ProductQuantity>'.$urun['adet'].'</ProductQuantity>';
                    $xml_Content .= '<ProductShippingAmount>'.number_format($urun['kargo_tutar'], 2).'</ProductShippingAmount>';
                    if($s['odeme_tur'] == '2' ) {
                        $xml_Content .= '<ProductTotalAmount>'.number_format(($urun['havale_kdvsiz_tutar']+$urun['havale_kdv_tutar'])*$urun['adet'], 2).'</ProductTotalAmount>';
                    }else{
                        $xml_Content .= '<ProductTotalAmount>'.number_format(($urun['kdvsiz_tutar']+$urun['kdv_tutar'])*$urun['adet'], 2).'</ProductTotalAmount>';
                    }
                    $xml_Content .= '</ProductItem>';
                }
            $xml_Content .= '</OrderProductList>';
        }
        $xml_Content .= '</Order>';
    }
}
$xml_Content .= '</OrderList>';
?>