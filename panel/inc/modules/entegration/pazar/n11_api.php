<?php
include "inc/modules/entegration/pazar/n11.class.php";
$n11Params = [
    'appKey' => $pazar['n11_api'],
    'appSecret' => $pazar['n11_secret']
];

$n11 = new N11($n11Params);
?>