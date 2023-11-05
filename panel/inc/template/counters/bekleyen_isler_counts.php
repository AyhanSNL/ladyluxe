<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1') {
$headerOrderCheckTotal = $db->prepare("select * from siparisler where yeni=:yeni and onay=:onay ");
$headerOrderCheckTotal->execute(array(
    'yeni' => '1',
    'onay' => '1',
));
?>
<div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light" style="border: 1px solid #fff;">
    <div class="rounded bg-primary text-white p-2 d-flex justify-content-center align-items-center" style="font-size: 18px ; width: 40px">
        <i class="fa fa-shopping-basket"></i>
    </div>
    <div class="p-2" style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
        <?=$diller['adminpanel-text-26']?>
    </div>
    <?php if($headerOrderCheckTotal->rowCount()>'0'  ) {?>
        <a href="pages.php?page=orders" class="rounded bg-danger text-white p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
           <?=$headerOrderCheckTotal->rowCount()?>
        </a>
    <?php }else { ?>
        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            0
        </div>
    <?php }?>
</div>
<?php }?>

<?php if($odemeRow['siparis_iptal'] == '1'  && $yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1' ) {
$iptaltalepCheckTotal = $db->prepare("select * from siparis_iptal where yeni=:yeni ");
$iptaltalepCheckTotal->execute(array(
    'yeni' => '1',
));
?>
<div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light" style="border: 1px solid #fff;">
    <div class="rounded bg-dark text-white p-2 d-flex justify-content-center align-items-center" style="font-size: 18px ; width: 40px">
        <i class="fa fa-ban"></i>
    </div>
    <div class="p-2" style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
        <?=$diller['adminpanel-text-29']?>
    </div>
    <?php if($iptaltalepCheckTotal->rowCount()>'0'  ) {?>
        <a href="pages.php?page=order_cancel" class="rounded bg-danger text-white p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            <?=$iptaltalepCheckTotal->rowCount()?>
        </a>
    <?php }else { ?>
        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            0
        </div>
    <?php }?>
</div>
<?php }?>

<?php if($odemeRow['siparis_urun_iade'] == '1' && $yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1') {
$iadeTalepCheckTotal = $db->prepare("select * from siparis_urunler_iade where yeni=:yeni  ");
$iadeTalepCheckTotal->execute(array(
    'yeni' => '1',
));
?>
<div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light" style="border: 1px solid #fff;">
    <div class="rounded bg-pink text-white p-2 d-flex justify-content-center align-items-center" style="font-size: 18px ; width: 40px; ">
        <i class="fa fa-recycle"></i>
    </div>
    <div class="p-2" style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
        <?=$diller['adminpanel-text-33']?>
    </div>
    <?php if($iadeTalepCheckTotal->rowCount()>'0'  ) {?>
        <a href="pages.php?page=order_product_return" class="rounded bg-danger text-white p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            <?=$iadeTalepCheckTotal->rowCount()?>
        </a>
    <?php }else { ?>
        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            0
        </div>
    <?php }?>
</div>
<?php }?>



<?php if($yetki['uyelik'] == '1'  && $yetki['ticket'] == '1' ) {
$TicketCheckHeadTotal = $db->prepare("select * from destek_talebi where durum=:durum");
$TicketCheckHeadTotal->execute(array(
    'durum' => '0',
));
?>
<div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light" style="border: 1px solid #fff;">
    <div class="rounded bg-success text-white p-2 d-flex justify-content-center align-items-center" style="font-size: 18px ; width: 40px; ">
        <i class="fa fa-ticket-alt"></i>
    </div>
    <div class="p-2" style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
        <?=$diller['adminpanel-text-36']?>
    </div>
    <?php if($TicketCheckHeadTotal->rowCount()>'0'  ) {?>
        <a href="pages.php?page=tickets" class="rounded bg-danger text-white p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            <?=$TicketCheckHeadTotal->rowCount()?>
        </a>
    <?php }else { ?>
        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            0
        </div>
    <?php }?>
</div>
<?php }?>

<?php if($yetki['katalog'] == '1'  && $yetki['urun_yorum'] == '1' ) {
$urunYorumHeadercheckTotal = $db->prepare("select * from urun_yorum where onay=:onay");
$urunYorumHeadercheckTotal->execute(array(
    'onay' => '0',
));
?>
<div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light" style="border: 1px solid #fff;">
    <div class="rounded bg-warning text-dark p-2 d-flex justify-content-center align-items-center" style="font-size: 18px ; width: 40px; ">
        <i class="fa fa-comment"></i>
    </div>
    <div class="p-2" style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
        <?=$diller['adminpanel-text-41']?>
    </div>
    <?php if($urunYorumHeadercheckTotal->rowCount()>'0'  ) {?>
        <a href="pages.php?page=products_comments" class="rounded bg-danger text-white p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            <?=$urunYorumHeadercheckTotal->rowCount()?>
        </a>
    <?php }else { ?>
        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            0
        </div>
    <?php }?>
</div>
<?php }?>


<?php if($yetki['siparis'] == '1'  && $yetki['odeme_bildirim'] == '1' ) {
$havaleEftKontrol = $db->prepare("select * from odeme_bildirim where durum=:durum");
$havaleEftKontrol->execute(array(
    'durum' => '0',
));
?>
<div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light" style="border: 1px solid #fff;">
    <div class="rounded bg-white text-dark p-2 d-flex justify-content-center align-items-center" style="font-size: 18px ; width: 40px; ">
        <i class="fa fa-money-bill-alt"></i>
    </div>
    <div class="p-2" style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
        <?=$diller['adminpanel-text-86']?>
    </div>
    <?php if($havaleEftKontrol->rowCount()>'0'  ) {?>
        <a href="pages.php?page=bank_transfer" class="rounded bg-danger text-white p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            <?=$havaleEftKontrol->rowCount()?>
        </a>
    <?php }else { ?>
        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            0
        </div>
    <?php }?>
</div>
<?php }?>


<?php if($yetki['siparis'] == '1'  && $yetki['siparis_yonet'] == '1' ) {
$tekurunSiparis = $db->prepare("select * from siparis_normal where yeni=:yeni");
$tekurunSiparis->execute(array(
    'yeni' => '1',
));
?>
<div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light" style="border: 1px solid #fff;">
    <div class="rounded bg-info text-white p-2 d-flex justify-content-center align-items-center" style="font-size: 18px ; width: 40px; ">
        <i class="fas fa-gift"></i>
    </div>
    <div class="p-2" style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
        <?=$diller['adminpanel-text-87']?>
    </div>
    <?php if($tekurunSiparis->rowCount()>'0'  ) {?>
        <a href="pages.php?page=op_orders" class="rounded bg-danger text-white p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            <?=$tekurunSiparis->rowCount()?>
        </a>
    <?php }else { ?>
        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            0
        </div>
    <?php }?>
</div>
<?php }?>

<?php if($yetki['siparis'] == '1'  && $yetki['siparis_yonet'] == '1' ) {
$teklifSiparis = $db->prepare("select * from siparis_teklif where yeni=:yeni");
$teklifSiparis->execute(array(
    'yeni' => '1',
));
?>
<div class="col-md-12 p-2 d-flex justify-content-between mb-1 bg-light" style="border: 1px solid #fff;">
    <div class="rounded bg-secondary text-white p-2 d-flex justify-content-center align-items-center" style="font-size: 18px ; width: 40px; ">
        <i class="fas fa-handshake"></i>
    </div>
    <div class="p-2" style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
        <?=$diller['adminpanel-text-88']?>
    </div>
    <?php if($teklifSiparis->rowCount()>'0'  ) {?>
        <a href="pages.php?page=offers" class="rounded bg-danger text-white p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            <?=$teklifSiparis->rowCount()?>
        </a>
    <?php }else { ?>
        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center " style="font-size: 18px ; font-weight: 600; border: 1px solid #EBEBEB; width: 50px">
            0
        </div>
    <?php }?>
</div>
<?php }?>
