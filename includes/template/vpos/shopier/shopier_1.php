<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
include_once 'Shopier.php';

$Api_Key= $odemeayar['shopier_user'];
$Api_Secret= $odemeayar['shopier_pass'];

$firstname=htmlspecialchars($siparisim['isim']);
$lastname=htmlspecialchars($siparisim['soyisim']);
$email=htmlspecialchars($siparisim['eposta']);
$phone=htmlspecialchars($siparisim['telefon']);
$address=htmlspecialchars($siparisim['adresbilgisi']);
$city=htmlspecialchars($siparisim['sehir']);
$price=htmlspecialchars($siparisim['toplam_tutar']);
$postacode=htmlspecialchars($siparisim['postakodu']);
$country=htmlspecialchars('Turkiye');


$shopier = new Shopier($Api_Key, $Api_Secret);
$shopier->setBuyer([
    'id' => 52,
    'first_name' => $firstname, 'last_name' => $lastname, 'email' => $email, 'phone' => $phone]);
$shopier->setOrderBilling([
    'billing_address' => $address,
    'billing_city' => $city,
    'billing_country' => $country,
    'billing_postcode' => $postacode,
]);
$shopier->setOrderShipping([
    'shipping_address' => $address,
    'shipping_city' => $city,
    'shipping_country' => $country,
    'shipping_postcode' => $postacode,
]);

die($shopier->run(time(), $price, ''.$ayar['site_url'].'pages.php=shopierOrderSuccess'));





?>
