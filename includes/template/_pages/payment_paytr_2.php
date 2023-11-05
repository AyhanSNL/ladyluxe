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
<div class="ccard-payment-paytr-2-main">
    <div class="ccard-payment-paytr-2-left">
        <div class="ccard-payment-paytr-2-left-in">
            <div class="ccard-payment-iyzico-left-h">
                <?=$diller['kart-odeme-text-1']?>
            </div>
            <div class="ccard-payment-iyzico-left-h2">
                <?=$diller['kart-odeme-text-2']?>
            </div>
            <div class="ccard-payment-iyzico-left-paycount-sm" >
                <div class="ccard-payment-iyzico-left-paycount-text1">
                    <?=$diller['sepet-ozet-ara-toplam']?>
                </div>
                <div class="ccard-payment-iyzico-left-paycount-text2-sm">

                    <?php if($para['simge_gosterim'] == '0' ) {?>
                        <?=$para['sol_simge']?>
                    <?php }?>
                    <?php if($para['simge_gosterim'] == '1' ) {?>
                        <?=$para['sag_simge']?>
                    <?php }?>
                    <?php echo number_format($siparisim['ara_tutar'], $para['para_format']); ?>
                    <?php if($para['simge_gosterim'] == '2' ) {?>
                        <?=$para['sol_simge']?>
                    <?php }?>
                    <?php if($para['simge_gosterim'] == '3' ) {?>
                        <?=$para['sag_simge']?>
                    <?php }?>
                </div>
            </div>
            <div class="ccard-payment-iyzico-left-paycount-sm">
                <div class="ccard-payment-iyzico-left-paycount-text1">
                    <?=$diller['sepet-ozet-kdv']?>
                </div>
                <div class="ccard-payment-iyzico-left-paycount-text2-sm">

                    <?php if($para['simge_gosterim'] == '0' ) {?>
                        <?=$para['sol_simge']?>
                    <?php }?>
                    <?php if($para['simge_gosterim'] == '1' ) {?>
                        <?=$para['sag_simge']?>
                    <?php }?>
                    <?php echo number_format($siparisim['kdv_tutar'], $para['para_format']); ?>
                    <?php if($para['simge_gosterim'] == '2' ) {?>
                        <?=$para['sol_simge']?>
                    <?php }?>
                    <?php if($para['simge_gosterim'] == '3' ) {?>
                        <?=$para['sag_simge']?>
                    <?php }?>
                </div>
            </div>
            <?php if($siparisim['kargo_tutar'] > '0' && $siparisim['kargo_tutar'] == !null ) {?>
                <div class="ccard-payment-iyzico-left-paycount-sm">
                    <div class="ccard-payment-iyzico-left-paycount-text1">
                        <?=$diller['sepet-ozet-kargo-tutar']?>
                    </div>
                    <div class="ccard-payment-iyzico-left-paycount-text2-sm">

                        <?php if($para['simge_gosterim'] == '0' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '1' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                        <?php echo number_format($siparisim['kargo_tutar'], $para['para_format']); ?>
                        <?php if($para['simge_gosterim'] == '2' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '3' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
            <?php if($siparisim['sepette_ek_indirim'] > '0' && $siparisim['sepette_ek_indirim'] == !null ) {?>
                <div class="ccard-payment-iyzico-left-paycount-sm">
                    <div class="ccard-payment-iyzico-left-paycount-text1">
                        <?=$diller['sepet-ek-indirim']?>
                    </div>
                    <div class="ccard-payment-iyzico-left-paycount-text2-sm">
                        -
                        <?php if($para['simge_gosterim'] == '0' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '1' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                        <?php echo number_format($siparisim['sepette_ek_indirim'], $para['para_format']); ?>
                        <?php if($para['simge_gosterim'] == '2' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '3' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
            <?php if($siparisim['ilk_siparis_indirim'] > '0' && $siparisim['ilk_siparis_indirim'] == !null ) {?>
                <div class="ccard-payment-iyzico-left-paycount-sm">
                    <div class="ccard-payment-iyzico-left-paycount-text1">
                        <?=$diller['sepet-ilk-siparis-indirim']?>
                    </div>
                    <div class="ccard-payment-iyzico-left-paycount-text2-sm">
                        -
                        <?php if($para['simge_gosterim'] == '0' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '1' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                        <?php echo number_format($siparisim['ilk_siparis_indirim'], $para['para_format']); ?>
                        <?php if($para['simge_gosterim'] == '2' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '3' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
            <?php if($siparisim['grup_indirim'] > '0' && $siparisim['grup_indirim'] == !null ) {?>
                <div class="ccard-payment-iyzico-left-paycount-sm">
                    <div class="ccard-payment-iyzico-left-paycount-text1">
                        <?=$diller['sepet-size-ozel-indirim']?>
                    </div>
                    <div class="ccard-payment-iyzico-left-paycount-text2-sm">
                        -
                        <?php if($para['simge_gosterim'] == '0' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '1' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                        <?php echo number_format($siparisim['grup_indirim'], $para['para_format']); ?>
                        <?php if($para['simge_gosterim'] == '2' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '3' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
            <?php if($siparisim['indirim_tutar'] > '0' && $siparisim['indirim_tutar'] == !null ) {?>
                <div class="ccard-payment-iyzico-left-paycount-sm">
                    <div class="ccard-payment-iyzico-left-paycount-text1">
                        <?=$diller['sepet-ozet-kupon-indirim-tutar']?>
                    </div>
                    <div class="ccard-payment-iyzico-left-paycount-text2-sm">
                        -
                        <?php if($para['simge_gosterim'] == '0' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '1' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                        <?php echo number_format($siparisim['indirim_tutar'], $para['para_format']); ?>
                        <?php if($para['simge_gosterim'] == '2' ) {?>
                            <?=$para['sol_simge']?>
                        <?php }?>
                        <?php if($para['simge_gosterim'] == '3' ) {?>
                            <?=$para['sag_simge']?>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
            <div class="ccard-payment-iyzico-left-paycount">
                <div class="ccard-payment-iyzico-left-paycount-text1">
                    <?=$diller['kart-odeme-text-4']?>
                </div>
                <div class="ccard-payment-iyzico-left-paycount-text2">
                    <?php if($para['simge_gosterim'] == '0' ) {?>
                        <?=$para['sol_simge']?>
                    <?php }?>
                    <?php if($para['simge_gosterim'] == '1' ) {?>
                        <?=$para['sag_simge']?>
                    <?php }?>
                    <?php echo number_format($siparisim['toplam_tutar'], $para['para_format']); ?>
                    <?php if($para['simge_gosterim'] == '2' ) {?>
                        <?=$para['sol_simge']?>
                    <?php }?>
                    <?php if($para['simge_gosterim'] == '3' ) {?>
                        <?=$para['sag_simge']?>
                    <?php }?>
                </div>

            </div>
        </div>
        <?php if($siparisim['taksit_durum'] == '0' ) {?>
            <?php if($odemeayar['taksit_max_paytr'] != '0' ) {?>
                <div class="ccard-payment-paytr-2-left-in-yellow">
                    <i class="fa fa-info-circle"></i>  <?=$diller['kart-odeme-text-5']?>
                </div>
            <?php }?>
        <?php }?>
    </div>
    <div class="ccard-payment-paytr-2-right">
        <div class="ccard-payment-paytr-2-right-in">


            <?php include 'includes/template/vpos/paytr/paytr.php'; ?>
        </div>
    </div>
</div>
<?php }else { ?>
    <?php
    header('Location:'.$siteurl.'404');
    ?>
<?php }?>
