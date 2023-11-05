<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($_GET['cache']=='trash'  ) {?>
<?php
    if($yetki['demo'] != '1' ) {
        array_map('unlink', glob('../i/cache/d/*.html'));
        array_map('unlink', glob('../i/cache/s/*.html'));
         header('Location:'.$_SESSION['current_url'] .'');
        $_SESSION['cache_alert'] = 'success';
    }else{
         header('Location:'.$_SESSION['current_url'] .'');
        $_SESSION['main_alert'] = 'demo';
    }
?>
<?php }else { ?>
<?php
header('Location:'.$ayar['panel_url'].'');
?>
<?php }?>
