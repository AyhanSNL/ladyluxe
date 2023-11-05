<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
require_once('IyzipayBootstrap.php');

IyzipayBootstrap::init();

class Config
{
    public static function options()
    {
        global $db;
        $statement = $db->prepare("select * from odeme_ayar where id='1'");
        $statement->execute();
        $setset = $statement->fetch(PDO::FETCH_ASSOC);

        $iyzico_api = $setset['iyzico_key'];
        $iyzico_secure = $setset['iyzico_secure'];


        $options = new \Iyzipay\Options();
        $options->setApiKey($iyzico_api);
        $options->setSecretKey($iyzico_secure);
        if($setset['iyzico_test'] == '1' ) {
            $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        }else{
           $options->setBaseUrl("https://api.iyzipay.com");
        }
        return $options;
    }
}


/* Ülke Çek */
$ulkeCek = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
$ulkeCek->execute(array(
    '3_iso' => $siparisim['ulke']
));
$ulkesi = $ulkeCek->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Ülke Çek SON */

$adsoyad = $siparisim['isim'].' '.$siparisim['soyisim'];
$user_name = $siparisim['isim'];
$user_surname = $siparisim['soyisim'];
$payment_amount	= $siparisim['toplam_tutar'];
$merchant_oid = $siparisim['siparis_no'];
$user_emaill = $siparisim['eposta'];
$user_address = $siparisim['adresbilgisi'];
$user_phone = $siparisim['telefon'];
$postakodu = $siparisim['postakodu'];
$sehir = $siparisim['sehir'];
$sehirilcesi = $siparisim['ilce'];
$ulke = $ulkesi['baslik'];
$timestamp = date('Y-m-d G:i:s');
if($siparisim['tc_no'] == !null && $siparisim['tc_no'] > '0' ) {
 $tc_cek = $siparisim['tc_no'];
}else{
$tc_cek = '11111111111';
}
$siparis_ipno = $siparisim['ipadres'];


# create request class
$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId("$merchant_oid");
$request->setPrice($payment_amount);
$request->setPaidPrice($payment_amount);
$request->setCurrency($siparisim['parabirimi']);
$request->setBasketId("$merchant_oid");
$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
if($demo != '1'  ) {
    $request->setCallbackUrl("".$siteurl."siparis/kredi-karti/?sID=".$merchant_oid."");
}else{
    $request->setCallbackUrl("".$siteurl."samplesuccess/");
}

if($siparisim['taksit_durum'] == '0'  ) {
        $request->setEnabledInstallments(array(0));
}else{
    if($odemeayar['iyzico_taksit_sayi'] == '0'  ) {
        $request->setEnabledInstallments(array(0));
    }
    if($odemeayar['iyzico_taksit_sayi'] == '1'  ) {
        $request->setEnabledInstallments(array(2));
    }
    if($odemeayar['iyzico_taksit_sayi'] == '2'  ) {
        $request->setEnabledInstallments(array(2,3));
    }
    if($odemeayar['iyzico_taksit_sayi'] == '3'  ) {
        $request->setEnabledInstallments(array(2,3,6));
    }
    if($odemeayar['iyzico_taksit_sayi'] == '4'  ) {
        $request->setEnabledInstallments(array(2,3,6,9));
    }
    if($odemeayar['iyzico_taksit_sayi'] == '5'  ) {
        $request->setEnabledInstallments(array(2,3,6,9,12));
    }
}


$buyer = new \Iyzipay\Model\Buyer();
$buyer->setId("$merchant_oid");
$buyer->setName("$user_name");
$buyer->setSurname("$user_surname");
$buyer->setGsmNumber("$user_phone");
$buyer->setEmail("$user_emaill");
$buyer->setIdentityNumber("$tc_cek");
$buyer->setLastLoginDate("$timestamp");
$buyer->setRegistrationDate("$timestamp");
$buyer->setRegistrationAddress("$user_address");
$buyer->setIp("$siparis_ipno");
$buyer->setCity("$sehir");
$buyer->setCountry("$ulke");
$buyer->setZipCode("$postakodu");
$request->setBuyer($buyer);

$shippingAddress = new \Iyzipay\Model\Address();
$shippingAddress->setContactName("$adsoyad");
$shippingAddress->setCity("$sehir");
$shippingAddress->setCountry("$ulke");
$shippingAddress->setAddress("$user_address");
$shippingAddress->setZipCode("$postakodu");
$request->setShippingAddress($shippingAddress);

$billingAddress = new \Iyzipay\Model\Address();
$billingAddress->setContactName("$adsoyad");
$billingAddress->setCity("$sehir");
$billingAddress->setCountry("$ulke");
$billingAddress->setAddress("$user_address");
$billingAddress->setZipCode("$postakodu");
$request->setBillingAddress($billingAddress);

$basketItems = array();
$firstBasketItem = new \Iyzipay\Model\BasketItem();
$firstBasketItem->setId("$merchant_oid");
$firstBasketItem->setName("$merchant_oid sipariş numaralı ürünler");
$firstBasketItem->setCategory1(".");
$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
$firstBasketItem->setPrice($payment_amount);
$basketItems[0] = $firstBasketItem;
$request->setBasketItems($basketItems);


# make request
$checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());

# print result
//print_r($checkoutFormInitialize);
//print_r($checkoutFormInitialize->getstatus());
print_r($checkoutFormInitialize->getErrorMessage());
print_r($checkoutFormInitialize->getCheckoutFormContent());
?>
<div  id="iyzipay-checkout-form" class="responsive"></div>