<?php
include 'inc/session.php';
?> <?php
if ($adminSorgu->rowCount() <= '0') {
?><!doctype html><html lang="<?= $mevcutdil['kisa_ad'] ?>" dir="<?= $mevcutdil['area'] ?>"><head><base href="<?= $ayar['panel_url'] ?>"><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" /><meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge"><meta name="robots" content="noindex, nofollow"><link rel="stylesheet" href="assets/login/vegas.min.css"><link rel="stylesheet" href="assets/login/login.css"><link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<body class="atm"><div class="login-main"><div class="login-right-side">
<div class="vegas-container " id="vegas-slide"  data-vegas-options='{"delay":5200, "timer":false,"animation":"kenburns", "transition":"swirlLeft", "slides":[ {"src": "assets/images/login-img/login-w-1.jpg"},{"src": "assets/images/login-img/login-w-1.jpg"}, {"src": "assets/images/login-img/login-w-1.jpg"},{"src": "assets/images/login-img/login-w-1.jpg"}, {"src": "assets/images/login-img/login-w-1.jpg"},{"src": "assets/images/login-img/login-w-1.jpg"}]}'>
<div class="login-right-side-in-link"><div class="login-right-side-in-link-in"><a href="javascript:Void(0)" class="login-right-side-in-link-a"> <?= $diller['adminpanel-login-text-1'] ?></a></div></div></div></div><div class="login-left-side"><div class="login-left-side-in"><div class="login-left-side-in-logo"><img src="assets/images/login-img/lock.png" ></div><div class="login-left-side-in-text"><div class="login-left-side-in-text-1"><?= $diller['adminpanel-login-text-1'] ?></div><div class="login-left-side-in-text-2"><?= $diller['adminpanel-login-text-5'] ?></div></div><div class="login-left-side-in-form"><?php
    if ($_SESSION['login_alert'] == 'empty') {
?><div class="error-login-div"><i class="fa fa-exclamation-triangle"></i> <?= $diller['adminpanel-login-text-7'] ?></div><?php
        unset($_SESSION['login_alert']);
    }
?> <?php
    if ($_SESSION['login_alert'] == 'nouser') {
?><div class="error-login-div"><i class="fa fa-exclamation-triangle"></i> <?= $diller['adminpanel-login-text-7'] ?></div><?php
        unset($_SESSION['login_alert']);
    }
?><form action="logincontrol" method="post"><div class="login-left-side-in-form-input"><input type="text" name="username" placeholder="<?= $diller['adminpanel-login-text-2'] ?>"  autocomplete="off" ><i class="fa fa-envelope-o"></i></div><div class="login-left-side-in-form-input"><input type="password" name="password" placeholder="<?= $diller['adminpanel-login-text-3'] ?>"  required ><i class="fa fa-key"></i></div><div class="login-left-side-in-form-input"><button type="submit" name="login"><?= $diller['adminpanel-login-text-4'] ?></button></div></form></div></div></div></div><!-- jquery--><script src="assets/login/jquery-3.5.0.min.js"></script><script src="assets/login/imagesloaded.pkgd.min.js"></script><script src="assets/login/vegas.min.js"></script><script src="assets/login/main.js"></script></body></html><?php
} else {
?><?php
    header('Location:' . $ayar['panel_url'] . '');
?><?php
}
?>