<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$paytr_id = $odemeayar["paytr_id"];
$paytr_key = $odemeayar["paytr_key"];
$paytr_salt = $odemeayar["paytr_salt"];
$merchant_id 	= $paytr_id;
$merchant_key 	= $paytr_key;
$merchant_salt	= $paytr_salt;

$email = $siparisim['eposta'];
$payment_amount	= (int)($siparisim['toplam_tutar']*100);
$merchant_oid = $siparisim['siparis_no'];
$user_name = $siparisim['isim'].' '.$siparisim['soyisim'];
$user_address = $siparisim['adresbilgisi'];
$user_phone = $siparisim['telefon'];
if($demo != '1'  ) {
    $merchant_ok_url = "".$siteurl."siparis/kredi-karti/?sID=".$_SESSION['siparis_islem_id']."";
}else{
    $merchant_ok_url = "".$siteurl."samplesuccess/";
}
$merchant_fail_url = "".$siteurl."404";

$user_basket = base64_encode(json_encode(array(
    array("".$merchant_oid." numaralı siparisteki ürünler", "$payment_amount", 1),
)));

############################################################################################


if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
    $ip = $_SERVER["HTTP_CLIENT_IP"];
} elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
    $ip = $_SERVER["REMOTE_ADDR"];
}

$user_ip=$ip;
$timeout_limit = "30";
$debug_on = 1;

/* Test Modu durumunu çek */
if($odemeayar['paytr_test'] =='1' ) {
    $test_mode = 1;
}
if($odemeayar['paytr_test'] =='0' ) {
    $test_mode = 0;
}
/*  <========SON=========>>> Test Modu durumunu çek SON */

/* Siparişteki taksit son durumu */
if($siparisim['taksit_durum'] == '1' ) {
    if($odemeayar['taksit_max_paytr'] != '0'   ) {
        $no_installment	= 0;
    }else{
        $no_installment	= 1;
    }
}else{
    $no_installment	= 1;
}
/*  <========SON=========>>> Siparişteki taksit son durumu SON */

/* Taksit sayısı çekilsin */
    $max_installment = $odemeayar['taksit_max_paytr'];
/*  <========SON=========>>> Taksit sayısı çekilsin SON */

//todo Paytr bildirim sayfası için siparişin db üzerinden onay='1' olmasını sağla. Ayrıca o sayfada e-posta ile bildirimler yapılacaktır

/* Döviz durumu - TL */
$currency = $para['kod'];
/*  <========SON=========>>> Döviz durumu - TL SON */


$hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
$paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
$post_vals=array(
    'merchant_id'=>$merchant_id,
    'user_ip'=>$user_ip,
    'merchant_oid'=>$merchant_oid,
    'email'=>$email,
    'payment_amount'=>$payment_amount,
    'paytr_token'=>$paytr_token,
    'user_basket'=>$user_basket,
    'debug_on'=>$debug_on,
    'no_installment'=>$no_installment,
    'max_installment'=>$max_installment,
    'user_name'=>$user_name,
    'user_address'=>$user_address,
    'user_phone'=>$user_phone,
    'merchant_ok_url'=>$merchant_ok_url,
    'merchant_fail_url'=>$merchant_fail_url,
    'timeout_limit'=>$timeout_limit,
    'currency'=>$currency,
    'test_mode'=>$test_mode
);

$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1) ;
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
$result = @curl_exec($ch);

if(curl_errno($ch))
    die("PAYTR IFRAME connection error. err:".curl_error($ch));

curl_close($ch);

$result=json_decode($result,1);

if($result['status']=='success')
    $token=$result['token'];
else
    die("PAYTR IFRAME failed. reason:".$result['reason']);
#########################################################################

?>

<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
<iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
<script>iFrameResize({},'#paytriframe');</script>
