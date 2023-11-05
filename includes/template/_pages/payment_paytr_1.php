<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$SiparisiAl = $db->prepare("select * from siparisler where siparis_no=:siparis_no and onay=:onay");
$SiparisiAl->execute(array(
    'siparis_no' => $_SESSION['siparis_islem_id'],
    'onay' => '0'
));
$siparisim = $SiparisiAl->fetch(PDO::FETCH_ASSOC);

$paraFormati = $db->prepare("select * from para_birimleri where kod=:kod ");
$paraFormati->execute(array(
    'kod' => $siparisim['parabirimi']
));
$para = $paraFormati->fetch(PDO::FETCH_ASSOC);
?>
<?php if($SiparisiAl->rowCount()>'0'  ) {?>
<div class="ccard-payment-paytr-1-main">
    <div class="ccard-payment-paytr-1-h-main">
        <div class="ccard-payment-paytr-1-h">
            <?=$diller['kart-odeme-text-1']?>
        </div>
        <div class="ccard-payment-paytr-1-h2">
            <?=$diller['kart-odeme-text-2']?>
        </div>
        <?php if($siparisim['taksit_durum'] == '0' ) {?>
            <?php if($odemeayar['taksit_max_paytr'] != '0' ) {?>
                <div class="ccard-payment-paytr-2-left-in-yellow">
                    <i class="fa fa-info-circle"></i>  <?=$diller['kart-odeme-text-5']?>
                </div>
            <?php }?>
        <?php }?>
    </div>
   <div class="ccard-payment-paytr-1-frame">
       <div style="margin-top: -45px;">
           <?php include 'includes/template/vpos/paytr/paytr.php'; ?>
       </div>
   </div>
</div>
<?php }else { ?>
    <?php
    header('Location:'.$siteurl.'404');
    ?>
<?php }?>
