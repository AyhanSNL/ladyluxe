<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$loaderCek = $db->prepare("select durum,icon,delay from loader where id='1'");
$loaderCek->execute();
$load = $loaderCek->fetch(PDO::FETCH_ASSOC);
?>
<?php
if($load['durum'] == '1') {
?>
<div class="preload-main">
    <div class="loader">
        <img src="images/loader/<?=$load['icon']?>" alt="<?=$ayar['site_baslik']?>">
    </div>
</div>
<script >
    $(window).on('load', function(){
        $('.preload-main').delay(<?=$load['delay']?>).fadeOut('slow', function(){
            $("body").removeClass("hidden");
        });

    });
</script>
<?php }?>