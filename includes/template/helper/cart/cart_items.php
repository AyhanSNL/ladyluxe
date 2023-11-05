<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$ipcek = $_SERVER["REMOTE_ADDR"];
$sepetteUrun = $db->prepare("select * from sepet where ip=:ip  ");
$sepetteUrun->execute(array(
    'ip' => $ipcek,
));

$aktifSepet = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum  ");
$aktifSepet->execute(array(
    'ip' => $ipcek,
    'sepet_durum' => '1'
));
?>
<?php if($aktifSepet->rowCount()>'0'  ) {?>
    <div class="cart-left-box-main cart-head " style="padding: 0; border-top: 1px solid #EBEBEB " >
        <div class="cart-left-box-1" >
        </div><div class="cart-left-box-2">
            <?=$diller['sepet-liste-urun-yazisi']?>
        </div><div class="cart-left-box-3">
            <?=$diller['sepet-liste-birim-yazisi']?>
        </div><div class="cart-left-box-4">
                            <span style="padding: 0 0 0 28px">
                                <?=$diller['sepet-liste-adet-yazisi']?>
                            </span>
        </div><div class="cart-left-box-4">
            <?=$diller['sepet-liste-toplam-yazisi']?>
        </div>
    </div>
<?php }?>


<!-- Sepet Itemleri !-->
<?php foreach ($sepetteUrun as $sepetcek) {

    $sepetUrunuGoster = $db->prepare("select * from urun where id=:id ");
    $sepetUrunuGoster->execute(array(
        'id' => $sepetcek['urun_id']
    ));
    $urun = $sepetUrunuGoster->fetch(PDO::FETCH_ASSOC);
    ?>
    <?php if($sepetUrunuGoster->rowCount()>'0' && $urun['durum'] == '1'  ) {

        ?>
        <?php if($urun['stok'] > '0') {?>
            <!-- ANA ÜRÜN STOK KONTROLLÜ SEPET İTEMLERİ !-->
            <?php if($sepetcek['varyant_stok_durum'] == '0' ) {?>
                <?php if($urun['stok'] >= $sepetcek['adet']) {?>
                    <div class="cart-left-box-main Item<?=$sepetcek['sepetno']?>"  >
                        <div class="cart-left-box-1" >
                            <?php if($urun['gorunmez'] == '1' ) {?>
                                <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                            <?php }else { ?>
                                <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                    <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                                </a>
                            <?php }?>
                        </div><div class="cart-left-box-2">
                            <div class="cart-left-box-2-txt">
                                <?php if($urun['gorunmez'] == '1' ) {?>
                                    <?=$urun['baslik']?>
                                <?php }else { ?>
                                    <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                        <?=$urun['baslik']?>
                                    </a>
                                <?php }?>

                                <div style="height: 10px"></div>
                                <!-- Varyantlar buraya !-->
                                <?php $varyantekfiyattoplami=0; $varyantekfiyattoplami_tekil=0; ?>
                                <?php if($sepetcek['varyant'] == !null || $sepetcek['varyant'] > '0') {?>
                                    <?php
                                    $varyantayir = $sepetcek['varyant'];
                                    $varyantayir = explode(',', $varyantayir);
                                    ?>
                                    <?php foreach ($varyantayir as $varkey) { ?>
                                        <?php if($varkey !='' ) {
                                            $varyantOzellikCekelim = $db->prepare("select * from detay_varyant_ozellik where id=:id and urun_id=:urun_id ");
                                            $varyantOzellikCekelim->execute(array(
                                                'id' => $varkey,
                                                'urun_id' => $sepetcek['urun_id']
                                            ));
                                            ?>
                                            <?php if($varyantOzellikCekelim->rowCount()>'0'  ) {?>
                                                <?php foreach ($varyantOzellikCekelim as $varyantozellik) {

                                                $var_ek_fiyat = $varyantozellik['ek_fiyat'];

                                                ?>

                                                <!-- Önce varyantın Grubunu çek !-->
                                                <?php
                                                $varyantGrubuCek = $db->prepare("select * from detay_varyant where urun_id=:urun_id and varyant_id=:varyant_id ");
                                                $varyantGrubuCek->execute(array(
                                                    'urun_id' => $sepetcek['urun_id'],
                                                    'varyant_id' => $varyantozellik['varyant_id']
                                                ));
                                                $vargrubu = $varyantGrubuCek->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <!-- Önce varyantın Grubunu çek SON !-->

                                                <?php if($vargrubu['tur'] == '1' ) {?>
                                                <div class="cart-left-variant-div">
                                                    <strong>* <?=$vargrubu['baslik']?> :</strong> <?=$varyantozellik['baslik']?>
                                                    <?php if($varyantozellik['ek_fiyat'] > '0' && $varyantozellik['ek_fiyat'] == !null ) {?>
                                                        [+
                                                        <?=kur_cekimi($varyantozellik['ek_fiyat'])?>
                                                        ]
                                                    <?php }?>
                                                </div>
                                                <?php }?>
                                                <?php if($vargrubu['tur'] == '2' ) {
                                                $varyantEkCek = $db->prepare("select * from urun_varyant_ekler where urun_id=:urun_id and sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id order by id desc limit 1 ");
                                                $varyantEkCek->execute(array(
                                                    'urun_id' => $sepetcek['urun_id'],
                                                    'sepet_id' => $sepetcek['sepetno'],
                                                    'detay_ozellik_id' => $varyantozellik['id']
                                                ));
                                                $varyanteki = $varyantEkCek->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <?php if($varyantEkCek->rowCount()>'0') {?>
                                                <div class="cart-left-variant-div">
                                                    <strong>* <?=$vargrubu['baslik']?> :</strong> <?=$varyanteki['icerik']?>
                                                    <?php if($varyantozellik['ek_fiyat'] > '0' && $varyantozellik['ek_fiyat'] == !null ) {?>
                                                        [+
                                                        <?=kur_cekimi($varyantozellik['ek_fiyat'])?>
                                                        ]
                                                    <?php }?>
                                                </div>
                                            <?php }else { ?>
                                                <?php
                                                $var_ek_fiyat = 0;
                                                ?>
                                            <?php }?>
                                            <?php }?>
                                                <?php if($vargrubu['tur'] == '3' ) {?>
                                                <div class="cart-left-variant-div">
                                                    <strong>* <?=$vargrubu['baslik']?> :</strong> <?=$varyantozellik['baslik']?>
                                                    <?php if($varyantozellik['ek_fiyat'] > '0' && $varyantozellik['ek_fiyat'] == !null ) {?>
                                                        [+
                                                        <?=kur_cekimi($varyantozellik['ek_fiyat'])?>
                                                        ]
                                                    <?php }?>
                                                </div>
                                            <?php }?>
                                                <?php if($vargrubu['tur'] == '4' ) {
                                                $varyantEkCek = $db->prepare("select * from urun_varyant_ekler where urun_id=:urun_id and sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id order by id desc limit 1 ");
                                                $varyantEkCek->execute(array(
                                                    'urun_id' => $sepetcek['urun_id'],
                                                    'sepet_id' => $sepetcek['sepetno'],
                                                    'detay_ozellik_id' => $varyantozellik['id']
                                                ));
                                                $varyanteki = $varyantEkCek->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <?php if($varyantEkCek->rowCount()>'0') {?>
                                                <div class="cart-left-variant-div">
                                                    <strong>* <?=$vargrubu['baslik']?> :</strong> <?php echo date_tr('j F Y', ''.$varyanteki['icerik'].''); ?>
                                                    <?php if($varyantozellik['ek_fiyat'] > '0' && $varyantozellik['ek_fiyat'] == !null ) {?>
                                                        [+
                                                        <?=kur_cekimi($varyantozellik['ek_fiyat'])?>
                                                        ]
                                                    <?php }?>
                                                </div>
                                            <?php }else { ?>
                                                <?php
                                                $var_ek_fiyat = 0;
                                                ?>
                                            <?php }?>
                                            <?php }?>
                                                <?php
                                                /* Varyant Ek Fiyatlar Toplaması */
                                                $varyantekfiyattoplami = $varyantekfiyattoplami + ($var_ek_fiyat*$sepetcek['adet']);
                                                $varyantekfiyattoplami_tekil = $varyantekfiyattoplami_tekil + ($var_ek_fiyat);
                                                /* Varyant Ek Fiyatlar Toplaması SON */
                                                ?>
                                            <?php }?>
                                            <?php }else { ?>
                                                <!--///////////////////////// Varyant yok veya sorun varsa bu sepet itemini otomatik kaldır !-->
                                                <?php
                                                /* Önce tür 2 varyant var ise onun varyant ekini sil */
                                                $sepet = $db->prepare("select * from sepet where sepetno=:sepetno ");
                                                $sepet->execute(array(
                                                    'sepetno' => $sepetcek['sepetno']
                                                ));
                                                $sep = $sepet->fetch(PDO::FETCH_ASSOC);

                                                $urunvaryantEkler = $db->prepare("select * from urun_varyant_ekler where sepet_id=:sepet_id and urun_id=:urun_id ");
                                                $urunvaryantEkler->execute(array(
                                                    'sepet_id' => $sep['sepetno'],
                                                    'urun_id' => $sep['urun_id']
                                                ));
                                                if($urunvaryantEkler->rowCount() >'0'  ) {

                                                    $silmeislem_ekler = $db->prepare("DELETE from urun_varyant_ekler WHERE sepet_id=:sepet_id");
                                                    $silmeislem_ekler->execute(array(
                                                        'sepet_id' => $sepetcek['sepetno']
                                                    ));
                                                }
                                                /* Önce tür 2 varyant var ise onun varyant ekini sil SON */
                                                $silmeislem = $db->prepare("DELETE from sepet WHERE sepetno=:sepetno");
                                                $sil = $silmeislem->execute(array(
                                                    'sepetno' => $sepetcek['sepetno']
                                                ));
                                            if($sil) { ?>
                                                <?php unset($_SESSION['siparis_islem_id'] ); ?>
                                                <div class="modal " id="varyantsorun" data-backdrop="static">
                                                    <div class="modal-dialog modal-dialog-centered ">
                                                        <div class="modal-content">
                                                            <div class="sepet-return-modal">
                                                                <div class="sepet-return-alert" style="background-color: indianred" >
                                                                    <div>
                                                                        <i class="fa fa-info-circle"></i> <?=$diller['sepet-varyant-sorun-uyarisi']?>
                                                                    </div>
                                                                    <div>
                                                                        <a  class="close" href="sepet/" style="color: #FFF">&times;</a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(window).on("load", function() {
                                                        $('#varyantsorun').modal('show');
                                                    });
                                                    $(window).load(function () {
                                                        $('#varyantsorun').modal('show');
                                                    });
                                                    var $modalDialog = $("#varyantsorun");
                                                    $modalDialog.modal('show');

                                                    setTimeout(function() {
                                                        $modalDialog.modal('hide');
                                                    }, 0);
                                                </script>
                                            <?php }?>
                                                <!--//////////////////////////////////////////// Varyant yok veya sorun varsa bu sepet itemini otomatik kaldır SON !-->
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                                <!-- Varyantlar buraya SON !-->

                                <?php if($odemeayar['sepet_kdv_goster'] == '1' ) {?>
                                    <!-- KDV Bilgisi !-->
                                    <?php if($sepetcek['kdv_tutar'] > '0') {?>
                                        <div class="cart-left-variant-div"  style="font-size: 12px ; ">
                                            <strong>+ %<?=$urun['kdv_oran']?> <?=$diller['sepet-liste-kdv-yazisi']?> :</strong>
                                            <?=kur_cekimi($sepetcek['kdv_tutar'])?>
                                            x <?=$sepetcek['adet']?> <?=$diller['sepet-adet']?>
                                        </div>
                                    <?php }?>
                                    <!-- KDV Bilgisi SON !-->
                                <?php } ?>

                                <?php if($odemeayar['sepet_havale_goster'] == '1' ) {?>
                                    <!-- Havale İndirimi Göster !-->
                                    <?php if($urun['havale_indirim_tutar'] >'0' && $urun['havale_indirim_tutar'] == !null ) {?>
                                        <div class="cart-left-variant-div" style="font-size: 13px ;  margin-bottom: 5px; border: 1px dashed black; padding-left: 10px;">
                                            <?php if($urun['havale_indirim_tur'] == '1'  ) {?>
                                                <i class="fa fa-percent" style="font-size: 12px"></i> <?php echo number_format($urun['havale_indirim_tutar'], 0); ?> <?=$diller['sepet-liste-havale-indirimi-yazi']?>
                                            <?php }?>
                                            <?php if($urun['havale_indirim_tur'] == '2'  ) {?>
                                                <i class="fa fa-tag"></i>
                                                <?=kur_cekimi($urun['havale_indirim_tutar'])?>
                                                <?=$diller['sepet-liste-havale-indirimi-yazi']?>
                                            <?php }?>
                                        </div>
                                    <?php } ?>
                                    <!-- Havale İndirimi Göster SON !-->
                                <?php }?>

                                <!-- Kargo Bilgisi !-->
                                <?php if($odemeayar['kargo_sistemi'] == '1' && $odemeayar['kargo_sabit'] == '0') {?>
                                    <div class="cart-left-variant-div" style="font-size: 11px ; background-color: #f8f8f8; padding-left: 5px;">
                                        <?php if($urun['kargo'] == '1' ) {?>
                                            <?php if($urun['kargo_tipi'] == '0' ) {?>
                                                <strong><i class="fa fa-truck"></i> <?=$diller['sepet-ozet-kargo-tutar']?> :</strong>
                                                <?=kur_cekimi($urun['kargo_ucret'])?>
                                            <?php }?>
                                            <?php if($urun['kargo_tipi'] == '1' ) {?>
                                                <strong><i class="fa fa-truck"></i> <?=$diller['sepet-ozet-kargo-tutar']?> :</strong>
                                                <?=kur_cekimi($urun['kargo_ucret'])?>
                                                x <?=$sepetcek['adet']?> <?=$diller['sepet-adet']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <i class="fa fa-gift"></i> <?=$diller['urunler-ucretsiz-kargo-yazisi']?>
                                        <?php }?>
                                    </div>
                                <?php }?>
                                <!-- Kargo Bilgisi SON !-->




                            </div>

                        </div><div class="cart-left-box-3">

                            <?php if($urun['kdv'] == '0' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                            </strong>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil)?>
                                                </strong>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                                </strong>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                        </strong>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                    </strong>
                                <?php }?>
                            <?php }?>

                            <?php if($urun['kdv'] == '1' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                            </strong>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil)?>
                                                </strong>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                                </strong>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                        </strong>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                    </strong>
                                <?php }?>
                            <?php }?>

                            <?php if($urun['kdv'] == '2' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi(kdvcikar($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                            </strong>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi(kdvcikar($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                                </strong>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi(kdvcikar($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                                </strong>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi(kdvcikar($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                        </strong>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi(kdvcikar($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                    </strong>
                                <?php }?>
                            <?php }?>


                        </div><div class="cart-left-box-4">

                            <?php if($urun['fiyat'] > '0'  ) {?>
                                <?php if($sepetcek['adet'] == '1' ) {?>
                                    <a class="btn btn-sm btn-light rounded-0" style="border-color:#DDD; background-color: #fff; width: 25px; " data-href="removebasket?move=<?=$sepetcek['sepetno']?>" href="" data-toggle="modal" data-target="#confirm-delete">-</a>
                                <?php }?>

                                <?php if($sepetcek['adet'] > '1' ) {?>
                                    <form method="POST" action="cart-item-request" class="d-inline-block">
                                        <input type="hidden" name="cartitem" value="<?=$sepetcek['sepetno']?>">
                                        <input type="hidden" name="token" value="<?=md5('minusquantity')?>">
                                        <button type="submit" class="btn btn-sm  btn-light  rounded-0" style="border-color:#DDD;  width: 25px;background-color: #fff;">
                                            -
                                        </button>
                                    </form>
                                <?php }?>

                                <input type="text"  value="<?=$sepetcek['adet']?>" class="form-control btn-sm rounded-0" style="width:50px; height: 31px;border-color:#DDD; text-align: center; display: inline-block;vertical-align: top; background-color: #fff; " disabled>

                                <?php if($urun['stok'] > $sepetcek['adet'] ) {?>
                                    <form method="POST" action="cart-item-request" class="d-inline-block">
                                        <input type="hidden" name="cartitem" value="<?=$sepetcek['sepetno']?>">
                                        <input type="hidden" name="token" value="<?=md5('plusquantity')?>">
                                        <button type="submit" class="btn btn-sm  btn-light  rounded-0" style="border-color:#DDD;  width: 25px;background-color: #fff;">
                                            +
                                        </button>
                                    </form>
                                <?php }else { ?>
                                    <a href="javascript:void(0)" class="btn btn-sm  btn-light" data-toggle="tooltip" data-placement="top" title="<?=$diller['sepet-adet-ekle-uyari']?>" style="border-color:#DDD;  width: 25px;background-color: #fff;">+</a>
                                <?php }?>
                            <?php }?>


                        </div><div class="cart-left-box-5">

                            <!-- Ürünün Sepet Toplamı !-->
                            <?php if($urun['kdv'] == '0' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                            </strong>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi(($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                                </strong>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                                </strong>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                        </strong>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                    </strong>
                                <?php }?>
                            <?php }?>

                            <?php if($urun['kdv'] == '1' ) {

                                $listetoplamfiyat_1 = $urun['fiyat']+$varyantekfiyattoplami_tekil+kdvhesapla($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']);
                                $listetoplamfiyat_2 = $urun['fiyat_tip2']+$varyantekfiyattoplami_tekil+kdvhesapla($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']);

                                ?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi($listetoplamfiyat_1*$sepetcek['adet'] )?>
                                            </strong>
                                            <br>
                                            <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) { ?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi($listetoplamfiyat_2*$sepetcek['adet'])?>
                                                </strong>
                                                <br>
                                                <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi($listetoplamfiyat_1*$sepetcek['adet'] )?>
                                                </strong>
                                                <br>
                                                <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi($listetoplamfiyat_1*$sepetcek['adet'])?>
                                        </strong>
                                        <br>
                                        <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi($listetoplamfiyat_1*$sepetcek['adet'])?>
                                    </strong>
                                    <br>
                                    <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                <?php }?>
                            <?php }?>

                            <?php if($urun['kdv'] == '2' ) {?>

                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                            </strong>
                                            <br>
                                            <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi(($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                                </strong>
                                                <br>
                                                <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                                </strong>
                                                <br>
                                                <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                        </strong>
                                        <br>
                                        <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                    </strong>
                                    <br>
                                    <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                <?php }?>
                            <?php }?>
                            <!-- Ürünün Sepet Toplamı SON !-->

                        </div><div class="cart-left-box-6">

                            <a  data-href="removebasket?move=<?=$sepetcek['sepetno']?>" class="btn btn-sm btn-danger" style="border-radius: 0 !important;    padding: 5px 6px !important;   font-size: 12px !important;  line-height: 10px !important;" href="" data-toggle="modal" data-target="#confirm-delete"><i class="ion-close-round"></i></a>

                        </div>
                    </div>
                <?php }else { ?>
                    <!-- Ana Ürün Stokta kalmamış ürün bilgilendirmesi !-->

                    <div class="cart-left-box-main" style=" background-color: #FFF3EE; box-sizing: border-box; padding-left: 5px ">
                        <div class="cart-left-box-1">
                            <?php if($urun['gorunmez'] == '1' ) {?>
                                <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                            <?php }else { ?>
                                <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                    <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                                </a>
                            <?php }?>

                        </div><div class="cart-left-box-2">
                            <div class="cart-left-box-2-txt">
                                <?php if($urun['gorunmez'] == '1' ) {?>
                                    <?=$urun['baslik']?>
                                <?php }else { ?>
                                    <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                        <?=$urun['baslik']?>
                                    </a>
                                <?php }?>
                                <br><br>
                                <div class=" badge-dark" style="padding: 5px ; font-size: 13px ;"><i class="fa fa-info-circle"></i> <?=$diller['sepet-stok-yok-uyarisi']?></div>

                            </div>

                        </div><div class="cart-left-box-3">

                        </div><div class="cart-left-box-4">


                        </div><div class="cart-left-box-5">

                        </div><div class="cart-left-box-6">

                            <a  data-href="removebasket?move=<?=$sepetcek['sepetno']?>" class="btn btn-sm btn-danger" style="border-radius: 0 !important;    padding: 5px 6px !important;   font-size: 12px !important;  line-height: 10px !important;" href="" data-toggle="modal" data-target="#confirm-delete"><i class="ion-close-round"></i></a>

                        </div>
                    </div>
                    <!-- Ana Ürün Stokta kalmamış ürün bilgilendirmesi SON !-->
                <?php }?>
            <?php }?>
            <!-- ANA ÜRÜN STOK KONTROLLÜ SEPET İTEMLERİ SON !-->



            <!-- VARYANT STOK KONTROLLÜ SEPET İTEMLERİ !-->
            <?php if($sepetcek['varyant_stok_durum'] == '1' ) {
                $varyantStokBilgisi = $db->prepare("select * from detay_varyant_stok where urun_id=:urun_id and varyant=:varyant ");
                $varyantStokBilgisi->execute(array(
                    'urun_id' => $sepetcek['urun_id'],
                    'varyant' => $sepetcek['varyant']
                ));
                $varStokCek = $varyantStokBilgisi->fetch(PDO::FETCH_ASSOC);
                ?>
                <?php if($varStokCek['stok'] >= $sepetcek['adet']) {?>



                    <div class="cart-left-box-main Item<?=$sepetcek['sepetno']?>">
                        <div class="cart-left-box-1">
                            <?php if($urun['gorunmez'] == '1' ) {?>
                                <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                            <?php }else { ?>
                                <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                    <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                                </a>
                            <?php }?>
                        </div><div class="cart-left-box-2">
                            <div class="cart-left-box-2-txt">
                                <?php if($urun['gorunmez'] == '1' ) {?>
                                    <?=$urun['baslik']?>
                                <?php }else { ?>
                                    <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                        <?=$urun['baslik']?>
                                    </a>
                                <?php }?>



                                <div style="height: 10px"></div>

                                <!-- Varyantlar buraya !-->
                                <?php $varyantekfiyattoplami=0; $varyantekfiyattoplami_tekil=0; ?>
                                <?php if($sepetcek['varyant'] == !null || $sepetcek['varyant'] > '0') {?>
                                    <?php
                                    $varyantayir = $sepetcek['varyant'];
                                    $varyantayir = explode(',', $varyantayir);
                                    ?>
                                    <?php foreach ($varyantayir as $varkey) { ?>
                                        <?php if($varkey !='' ) {
                                            $varyantOzellikCekelim = $db->prepare("select * from detay_varyant_ozellik where id=:id and urun_id=:urun_id ");
                                            $varyantOzellikCekelim->execute(array(
                                                'id' => $varkey,
                                                'urun_id' => $sepetcek['urun_id']
                                            ));
                                            ?>
                                            <?php if($varyantOzellikCekelim->rowCount()>'0'  ) {?>
                                                <?php foreach ($varyantOzellikCekelim as $varyantozellik) {

                                                $var_ek_fiyat = $varyantozellik['ek_fiyat'];

                                                ?>

                                                <!-- Önce varyantın Grubunu çek !-->
                                                <?php
                                                $varyantGrubuCek = $db->prepare("select * from detay_varyant where urun_id=:urun_id and varyant_id=:varyant_id ");
                                                $varyantGrubuCek->execute(array(
                                                    'urun_id' => $sepetcek['urun_id'],
                                                    'varyant_id' => $varyantozellik['varyant_id']
                                                ));
                                                $vargrubu = $varyantGrubuCek->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <!-- Önce varyantın Grubunu çek SON !-->

                                                <?php if($vargrubu['tur'] == '1' ) {?>
                                                <div class="cart-left-variant-div">
                                                    <strong>* <?=$vargrubu['baslik']?> :</strong> <?=$varyantozellik['baslik']?>
                                                    <?php if($varyantozellik['ek_fiyat'] > '0' && $varyantozellik['ek_fiyat'] == !null ) {?>
                                                        [+
                                                        <?=kur_cekimi($varyantozellik['ek_fiyat'])?>
                                                        ]
                                                    <?php }?>
                                                </div>
                                                <?php }?>
                                                <?php if($vargrubu['tur'] == '2' ) {
                                                $varyantEkCek = $db->prepare("select * from urun_varyant_ekler where urun_id=:urun_id and sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id order by id desc limit 1 ");
                                                $varyantEkCek->execute(array(
                                                    'urun_id' => $sepetcek['urun_id'],
                                                    'sepet_id' => $sepetcek['sepetno'],
                                                    'detay_ozellik_id' => $varyantozellik['id']
                                                ));
                                                $varyanteki = $varyantEkCek->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <?php if($varyantEkCek->rowCount()>'0') {?>
                                                <div class="cart-left-variant-div">
                                                    <strong>* <?=$vargrubu['baslik']?> :</strong> <?=$varyanteki['icerik']?>
                                                    <?php if($varyantozellik['ek_fiyat'] > '0' && $varyantozellik['ek_fiyat'] == !null ) {?>
                                                        [+
                                                        <?=kur_cekimi($varyantozellik['ek_fiyat'])?>
                                                        ]
                                                    <?php }?>
                                                </div>
                                            <?php }else { ?>
                                                <?php
                                                $var_ek_fiyat = 0;
                                                ?>
                                            <?php }?>
                                            <?php }?>
                                                <?php if($vargrubu['tur'] == '3' ) {?>
                                                <div class="cart-left-variant-div">
                                                    <strong>* <?=$vargrubu['baslik']?> :</strong> <?=$varyantozellik['baslik']?>
                                                    <?php if($varyantozellik['ek_fiyat'] > '0' && $varyantozellik['ek_fiyat'] == !null ) {?>
                                                        [+
                                                        <?=kur_cekimi($varyantozellik['ek_fiyat'])?>
                                                        ]
                                                    <?php }?>
                                                </div>
                                            <?php }?>
                                                <?php if($vargrubu['tur'] == '4' ) {
                                                $varyantEkCek = $db->prepare("select * from urun_varyant_ekler where urun_id=:urun_id and sepet_id=:sepet_id and detay_ozellik_id=:detay_ozellik_id order by id desc limit 1 ");
                                                $varyantEkCek->execute(array(
                                                    'urun_id' => $sepetcek['urun_id'],
                                                    'sepet_id' => $sepetcek['sepetno'],
                                                    'detay_ozellik_id' => $varyantozellik['id']
                                                ));
                                                $varyanteki = $varyantEkCek->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <?php if($varyantEkCek->rowCount()>'0') {?>
                                                <div class="cart-left-variant-div">
                                                    <strong>* <?=$vargrubu['baslik']?> :</strong> <?php echo date_tr('j F Y', ''.$varyanteki['icerik'].''); ?>
                                                    <?php if($varyantozellik['ek_fiyat'] > '0' && $varyantozellik['ek_fiyat'] == !null ) {?>
                                                        [+
                                                        <?=kur_cekimi($varyantozellik['ek_fiyat'])?>
                                                        ]
                                                    <?php }?>
                                                </div>
                                            <?php }else { ?>
                                                <?php
                                                $var_ek_fiyat = 0;
                                                ?>
                                            <?php }?>
                                            <?php }?>
                                                <?php
                                                /* Varyant Ek Fiyatlar Toplaması */
                                                $varyantekfiyattoplami = $varyantekfiyattoplami + ($var_ek_fiyat*$sepetcek['adet']);
                                                $varyantekfiyattoplami_tekil = $varyantekfiyattoplami_tekil + ($var_ek_fiyat);
                                                /* Varyant Ek Fiyatlar Toplaması SON */
                                                ?>
                                            <?php }?>
                                            <?php }else { ?>
                                                <!--///////////////////////// Varyant yok veya sorun varsa bu sepet itemini otomatik kaldır !-->
                                                <?php
                                                /* Önce tür 2 varyant var ise onun varyant ekini sil */
                                                $sepet = $db->prepare("select * from sepet where sepetno=:sepetno ");
                                                $sepet->execute(array(
                                                    'sepetno' => $sepetcek['sepetno']
                                                ));
                                                $sep = $sepet->fetch(PDO::FETCH_ASSOC);

                                                $urunvaryantEkler = $db->prepare("select * from urun_varyant_ekler where sepet_id=:sepet_id and urun_id=:urun_id ");
                                                $urunvaryantEkler->execute(array(
                                                    'sepet_id' => $sep['sepetno'],
                                                    'urun_id' => $sep['urun_id']
                                                ));
                                                if($urunvaryantEkler->rowCount() >'0'  ) {

                                                    $silmeislem_ekler = $db->prepare("DELETE from urun_varyant_ekler WHERE sepet_id=:sepet_id");
                                                    $silmeislem_ekler->execute(array(
                                                        'sepet_id' => $sepetcek['sepetno']
                                                    ));
                                                }
                                                /* Önce tür 2 varyant var ise onun varyant ekini sil SON */
                                                $silmeislem = $db->prepare("DELETE from sepet WHERE sepetno=:sepetno");
                                                $sil = $silmeislem->execute(array(
                                                    'sepetno' => $sepetcek['sepetno']
                                                ));
                                            if($sil) { ?>
                                                <?php unset($_SESSION['siparis_islem_id'] ); ?>
                                                <div class="modal " id="varyantsorun" data-backdrop="static">
                                                    <div class="modal-dialog modal-dialog-centered ">
                                                        <div class="modal-content">
                                                            <div class="sepet-return-modal">
                                                                <div class="sepet-return-alert" style="background-color: indianred" >
                                                                    <div>
                                                                        <i class="fa fa-info-circle"></i> <?=$diller['sepet-varyant-sorun-uyarisi']?>
                                                                    </div>
                                                                    <div>
                                                                        <a  class="close" href="sepet/" style="color: #FFF">&times;</a>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    $(window).on("load", function() {
                                                        $('#varyantsorun').modal('show');
                                                    });
                                                    $(window).load(function () {
                                                        $('#varyantsorun').modal('show');
                                                    });
                                                    var $modalDialog = $("#varyantsorun");
                                                    $modalDialog.modal('show');

                                                    setTimeout(function() {
                                                        $modalDialog.modal('hide');
                                                    }, 0);
                                                </script>
                                            <?php }?>
                                                <!--//////////////////////////////////////////// Varyant yok veya sorun varsa bu sepet itemini otomatik kaldır SON !-->
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                                <!-- Varyantlar buraya SON !-->



                                <?php if($odemeayar['sepet_kdv_goster'] == '1' ) {?>
                                    <!-- KDV Bilgisi !-->
                                    <?php if($sepetcek['kdv_tutar'] > '0') {?>
                                        <div class="cart-left-variant-div"  style="font-size: 12px ; ">
                                            <strong>+ %<?=$urun['kdv_oran']?> <?=$diller['sepet-liste-kdv-yazisi']?> :</strong>
                                            <?=kur_cekimi($sepetcek['kdv_tutar'])?>
                                            x <?=$sepetcek['adet']?> <?=$diller['sepet-adet']?>
                                        </div>
                                    <?php }?>
                                    <!-- KDV Bilgisi SON !-->
                                <?php } ?>

                                <?php if($odemeayar['sepet_havale_goster'] == '1' ) {?>
                                    <!-- Havale İndirimi Göster !-->
                                    <?php if($urun['havale_indirim_tutar'] >'0' && $urun['havale_indirim_tutar'] == !null ) {?>
                                        <div class="cart-left-variant-div" style="font-size: 13px ;  margin-bottom: 5px; border: 1px dashed black; padding-left: 10px;">
                                            <?php if($urun['havale_indirim_tur'] == '1'  ) {?>
                                                <i class="fa fa-percent" style="font-size: 12px"></i> <?php echo number_format($urun['havale_indirim_tutar'], 0); ?> <?=$diller['sepet-liste-havale-indirimi-yazi']?>
                                            <?php }?>
                                            <?php if($urun['havale_indirim_tur'] == '2'  ) {?>
                                                <i class="fa fa-tag"></i>
                                                <?=kur_cekimi($urun['havale_indirim_tutar'])?>
                                                <?=$diller['sepet-liste-havale-indirimi-yazi']?>
                                            <?php }?>
                                        </div>
                                    <?php } ?>
                                    <!-- Havale İndirimi Göster SON !-->
                                <?php }?>


                                <!-- Kargo Bilgisi !-->
                                <?php if($odemeayar['kargo_sistemi'] == '1' && $odemeayar['kargo_sabit'] == '0') {?>
                                    <div class="cart-left-variant-div" style="font-size: 11px ; background-color: #f8f8f8; padding-left: 2px;">
                                        <?php if($urun['kargo'] == '1' ) {?>
                                            <?php if($urun['kargo_tipi'] == '0' ) {?>
                                                <strong><i class="fa fa-truck"></i> <?=$diller['sepet-ozet-kargo-tutar']?> :</strong>
                                                <?=kur_cekimi($urun['kargo_ucret'])?>
                                            <?php }?>
                                            <?php if($urun['kargo_tipi'] == '1' ) {?>
                                                <strong><i class="fa fa-truck"></i> <?=$diller['sepet-ozet-kargo-tutar']?> :</strong>
                                                <?=kur_cekimi($urun['kargo_ucret'])?>
                                                x <?=$sepetcek['adet']?> <?=$diller['sepet-adet']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <i class="fa fa-gift"></i> <?=$diller['urunler-ucretsiz-kargo-yazisi']?>
                                        <?php }?>
                                    </div>
                                <?php }?>
                                <!-- Kargo Bilgisi SON !-->


                            </div>

                        </div><div class="cart-left-box-3">

                            <?php if($urun['kdv'] == '0' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                            </strong>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil)?>
                                                </strong>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                                </strong>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                        </strong>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil )?>
                                    </strong>
                                <?php }?>
                            <?php }?>

                            <?php if($urun['kdv'] == '1' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                            </strong>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil)?>
                                                </strong>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                                </strong>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                        </strong>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi($urun['fiyat']+$varyantekfiyattoplami_tekil)?>
                                    </strong>
                                <?php }?>
                            <?php }?>

                            <?php if($urun['kdv'] == '2' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi(kdvcikar($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                            </strong>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi(kdvcikar($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                                </strong>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi(kdvcikar($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                                </strong>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi(kdvcikar($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                        </strong>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi(kdvcikar($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']))?>
                                    </strong>
                                <?php }?>
                            <?php }?>


                        </div><div class="cart-left-box-4">

                            <?php if($urun['fiyat'] > '0'  ) {?>
                                <?php if($sepetcek['adet'] == '1' ) {?>
                                    <a class="btn btn-sm btn-light rounded-0" style="border-color:#DDD; background-color: #fff; width: 25px; " data-href="removebasket?move=<?=$sepetcek['sepetno']?>" href="" data-toggle="modal" data-target="#confirm-delete">-</a>
                                <?php }?>

                                <?php if($sepetcek['adet'] > '1' ) {?>
                                    <form method="POST" action="cart-item-request" class="d-inline-block">
                                        <input type="hidden" name="cartitem" value="<?=$sepetcek['sepetno']?>">
                                        <input type="hidden" name="token" value="<?=md5('minusquantity')?>">
                                        <button type="submit" class="btn btn-sm  btn-light  rounded-0" style="border-color:#DDD;  width: 25px;background-color: #fff;">
                                            -
                                        </button>
                                    </form>
                                <?php }?>

                                <input type="text"  value="<?=$sepetcek['adet']?>" class="form-control btn-sm rounded-0" style="width:50px; height: 31px;border-color:#DDD; text-align: center; display: inline-block;vertical-align: top; background-color: #fff; " disabled>

                                <?php if($urun['stok'] > $sepetcek['adet'] ) {?>
                                    <form method="POST" action="cart-item-request" class="d-inline-block">
                                        <input type="hidden" name="cartitem" value="<?=$sepetcek['sepetno']?>">
                                        <input type="hidden" name="token" value="<?=md5('plusquantity')?>">
                                        <button type="submit" class="btn btn-sm  btn-light  rounded-0" style="border-color:#DDD;  width: 25px;background-color: #fff;">
                                            +
                                        </button>
                                    </form>
                                <?php }else { ?>
                                    <a href="javascript:void(0)" class="btn btn-sm  btn-light" data-toggle="tooltip" data-placement="top" title="<?=$diller['sepet-adet-ekle-uyari']?>" style="border-color:#DDD;  width: 25px;background-color: #fff;">+</a>
                                <?php }?>
                            <?php }?>

                        </div><div class="cart-left-box-5">

                            <!-- Ürünün Sepet Toplamı !-->
                            <?php if($urun['kdv'] == '0' ) {?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'] )?>
                                            </strong>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi(($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                                </strong>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                                </strong>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                        </strong>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                    </strong>
                                <?php }?>
                            <?php }?>

                            <?php if($urun['kdv'] == '1' ) {

                                $listetoplamfiyat_1 = $urun['fiyat']+$varyantekfiyattoplami_tekil+kdvhesapla($urun['fiyat']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']);
                                $listetoplamfiyat_2 = $urun['fiyat_tip2']+$varyantekfiyattoplami_tekil+kdvhesapla($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil,$urun['kdv_oran']);

                                ?>
                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi($listetoplamfiyat_1*$sepetcek['adet'])?>
                                            </strong>
                                            <br>
                                            <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) { ?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi($listetoplamfiyat_2*$sepetcek['adet'])?>
                                                </strong>
                                                <br>
                                                <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi($listetoplamfiyat_1*$sepetcek['adet'])?>
                                                </strong>
                                                <br>
                                                <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi($listetoplamfiyat_1*$sepetcek['adet'])?>
                                        </strong>
                                        <br>
                                        <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi($listetoplamfiyat_1*$sepetcek['adet'])?>
                                    </strong>
                                    <br>
                                    <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                <?php }?>
                            <?php }?>

                            <?php if($urun['kdv'] == '2' ) {?>

                                <?php if($userSorgusu->rowCount()>'0'  ) {?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  !-->
                                    <?php if($uyegruplariCek->rowCount() >'0'  ) {?>
                                        <?php if($uyegrup['fiyat_tip'] == '0'  ) {?>
                                            <strong>
                                                <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                            </strong>
                                            <br>
                                            <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                        <?php }?>
                                        <?php if($uyegrup['fiyat_tip'] == '1'  ) {?>
                                            <?php if($urun['fiyat_tip2'] == !null && $urun['fiyat_tip2'] > '0'  ) {?>
                                                <div style="font-size: 11px; margin-bottom: 4px; line-height: 12px" >
                                                    <div style="display: inline-block; background-color: #f8f8f8;color: #000; border: 1px dashed #EBEBEB;padding: 2px 5px; cursor: pointer " data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-detay-gruba-ozel-fiyat-aciklama']?>">
                                                        <?=$diller['urun-detay-gruba-ozel-fiyat']?>
                                                    </div>
                                                </div>
                                                <strong>
                                                    <?=kur_cekimi(($urun['fiyat_tip2']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                                </strong>
                                                <br>
                                                <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                            <?php }else { ?>
                                                <strong>
                                                    <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                                </strong>
                                                <br>
                                                <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <strong>
                                            <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                        </strong>
                                        <br>
                                        <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                    <?php }?>
                                    <!-- Giriş var! Üyenin grubu varsa ve grup fiyatı ne ise ona göre fiyat göster  SON !-->
                                <?php } else { ?>
                                    <strong>
                                        <?=kur_cekimi(($urun['fiyat']+$varyantekfiyattoplami_tekil)*$sepetcek['adet'])?>
                                    </strong>
                                    <br>
                                    <span style="font-size: 11px;">(<?=$diller['urunler-dahil-kdv']?>)</span>
                                <?php }?>
                            <?php }?>
                            <!-- Ürünün Sepet Toplamı SON !-->


                        </div><div class="cart-left-box-6">

                            <a  data-href="removebasket?move=<?=$sepetcek['sepetno']?>" class="btn btn-sm btn-danger" style="border-radius: 0 !important;    padding: 5px 6px !important;   font-size: 12px !important;  line-height: 10px !important;" href="" data-toggle="modal" data-target="#confirm-delete"><i class="ion-close-round"></i></a>

                        </div>
                    </div>
                <?php }else { ?>
                    <!-- Varyant Stok  kalmamış ürün bilgilendirmesi !-->


                    <div class="cart-left-box-main" style=" background-color: #FFF3EE; box-sizing: border-box; padding-left: 5px ">
                        <div class="cart-left-box-1">
                            <?php if($urun['gorunmez'] == '1' ) {?>
                                <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                            <?php }else { ?>
                                <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                    <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                                </a>
                            <?php }?>
                        </div><div class="cart-left-box-2">
                            <div class="cart-left-box-2-txt">
                                <?php if($urun['gorunmez'] == '1' ) {?>
                                    <?=$urun['baslik']?>
                                <?php }else { ?>
                                    <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                        <?=$urun['baslik']?>
                                    </a>
                                <?php }?>
                                <br><br>
                                <div class=" badge-dark" style="padding: 5px ; font-size: 13px ;"><i class="fa fa-info-circle"></i> <?=$diller['sepet-stok-yok-uyarisi']?></div>

                            </div>

                        </div><div class="cart-left-box-3">

                        </div><div class="cart-left-box-4">


                        </div><div class="cart-left-box-5">

                        </div><div class="cart-left-box-6">

                            <a  data-href="removebasket?move=<?=$sepetcek['sepetno']?>" class="btn btn-sm btn-danger" style="border-radius: 0 !important;    padding: 5px 6px !important;   font-size: 12px !important;  line-height: 10px !important;" href="" data-toggle="modal" data-target="#confirm-delete"><i class="ion-close-round"></i></a>

                        </div>
                    </div>
                    <!-- Varyant Stok  kalmamış ürün bilgilendirmesi SON !-->
                <?php }?>
            <?php }?>
            <!-- VARYANT STOK KONTROLLÜ SEPET İTEMLERİ SON !-->



        <?php }else { ?>

            <!-- ANA ÜRÜN Stokta kalmamış ürün bilgilendirmesi !-->
            <div class="cart-left-box-main" style=" background-color: #FFF3EE; box-sizing: border-box; padding-left: 5px ">
                <div class="cart-left-box-1">
                    <?php if($urun['gorunmez'] == '1' ) {?>
                        <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                    <?php }else { ?>
                        <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                            <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
                        </a>
                    <?php }?>
                </div><div class="cart-left-box-2">
                    <div class="cart-left-box-2-txt">
                        <?php if($urun['gorunmez'] == '1' ) {?>
                            <?=$urun['baslik']?>
                        <?php }else { ?>
                            <a href="<?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                <?=$urun['baslik']?>
                            </a>
                        <?php }?>
                        <br><br>
                        <div class=" badge-dark" style="padding: 5px ; font-size: 13px ;"><i class="fa fa-info-circle"></i> <?=$diller['sepet-stok-yok-uyarisi']?></div>

                    </div>

                </div><div class="cart-left-box-3">

                </div><div class="cart-left-box-4">


                </div><div class="cart-left-box-5">

                </div><div class="cart-left-box-6">

                    <a  data-href="removebasket?move=<?=$sepetcek['sepetno']?>" class="btn btn-sm btn-danger" style="border-radius: 0 !important;    padding: 5px 6px !important;   font-size: 12px !important;  line-height: 10px !important;" href="" data-toggle="modal" data-target="#confirm-delete"><i class="ion-close-round"></i></a>

                </div>
            </div>
            <!-- ANA ÜRÜN Stokta kalmamış ürün bilgilendirmesi SON !-->

        <?php }?>
    <?php }else { ?>
        <!-- Ürün silinmiş veya kaldırılmış !-->
        <div class="cart-left-box-main" style=" background-color: #FFF3EE; box-sizing: border-box; padding-left: 5px ">
            <div class="cart-left-box-1">
                <img src="images/product/<?=$urun['gorsel']?>" alt="<?=$urun['baslik']?>">
            </div><div class="cart-left-box-2">
                <div class="cart-left-box-2-txt">
                    <?=$urun['baslik']?>
                    <br><br>
                    <div class=" badge-dark" style="padding: 5px ; font-size: 13px ;"><i class="fa fa-info-circle"></i> <?=$diller['sepet-urun-yok-uyarisi']?></div>
                </div>

            </div><div class="cart-left-box-3">

            </div><div class="cart-left-box-4">


            </div><div class="cart-left-box-5">

            </div><div class="cart-left-box-6">

                <a  data-href="removebasket?move=<?=$sepetcek['sepetno']?>" class="btn btn-sm btn-danger" style="border-radius: 0 !important;    padding: 5px 6px !important;   font-size: 12px !important;  line-height: 10px !important;" href="" data-toggle="modal" data-target="#confirm-delete"><i class="ion-close-round"></i></a>

            </div>
        </div>

        <!-- Ürün silinmiş veya kaldırılmış SON !-->
    <?php }?>


<?php }?>
<script src="assets/js/custom.js"></script>
<?php if (isset($_SESSION['item_go_scroll'])) { ?>
    <script>
        $(function () {
            $('html, body').animate({
                scrollTop: $('.Item<?=$_SESSION['item_go_scroll']?>').offset().top
            }, 250);
            return false;
        });
    </script>
    <?php
    unset($_SESSION['item_go_scroll']);
} ?>

