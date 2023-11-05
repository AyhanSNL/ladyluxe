<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?php echo $ayar['site_url'] ?>images/<?php echo $ayar['site_favicon']; ?>">
<link rel="apple-touch-icon" sizes="57x57" href="images/icons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="images/icons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/icons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="images/icons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/icons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="images/icons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="images/icons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="images/icons/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="images/icons/apple-touch-icon-180x180.png">
<link rel="stylesheet" href="assets/css/font-awesome/font-awesome.min.css" rel="preload" />
<link rel="stylesheet" href="assets/css/line-awesome/css/line-awesome.min.css" rel="preload">
<link rel="stylesheet" href="assets/css/style.css"rel="preload" >
<link rel="stylesheet" href="assets/css/responsive.css" rel="preload">
<link rel="stylesheet" href="assets/helper/bootstrap/css/bootstrap.min.css" rel="preload">
<link rel="stylesheet" href="assets/css/site_style.css" rel="preload" >
<link rel="stylesheet" href="assets/css/jquery-ui/jquery-ui.css"rel="preload">
<link rel='stylesheet' href='assets/css/slider/swiper.min.css'rel="preload">
<link rel="stylesheet" href="assets/css/flag/flag-icon.css" rel="preload">
<noscript id="deferred-styles">
    <?php
    $fontCek = $db->prepare("select kod from fontlar where durum=:durum ");
    $fontCek->execute(array(
        'durum' => '1'
    ));
    ?>
    <?php foreach ($fontCek as $font) {?>
        <link href="<?=$font['kod']?>" rel="stylesheet" type="text/css" rel="preload">
    <?php }?>
</noscript>
<script src="assets/js/jquery.min.js"></script><script src="assets/js/custom.js"></script><!-- ToTop Module --><?php if ($ayar['totop'] == '1') {?><a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a><?php }?> <!-- ToTop Module End --><?php $cerezlerCek = $db->prepare("select * from cerez_ayar where dil='$_SESSION[dil]' and durum='1' order by id desc limit 1");$cerezlerCek->execute();$cer = $cerezlerCek->fetch(PDO::FETCH_ASSOC);if ($cerezlerCek->rowCount() > '0') { ?><link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" /><style> .cc-window{box-shadow: 0 0 5px rgba(0,0,0,.1);border:1px solid #<?=$cer['border']?>;}  .cc-message{color: #<?=$cer['bg_text_color']?> !important;font-size: 11px ;font-family : '<?=$cer['font']?>',Sans-serif ;}  .cc-btn{font-size: 13px ;font-family : '<?=$cer['font']?>',Sans-serif ;}  .cc-btn:hover{text-decoration: none !important;}</style><script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script><script> window.cookieconsent.initialise({"palette": {"popup": {"background": "#<?=$cer['bg_color']?>", "text": "#<?=$cer['bg_text_color']?>"}, "button": {"background": "#<?=$cer['button_bg']?>", "text": "#<?=$cer['button_text_color']?>"}}, "content": {"message": "<?=$cer['spot']?>", "dismiss": "<?=$cer['button_text']?>", "link": "<?=$cer['link_text']?>", "href": "<?=$cer['link']?>"}, "position": "<?=$cer['area']?>",});</script><?php }?>