<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($_POST['siparisID']) {?>
    <?php
    $siparisCek = $db->prepare("select * from siparis_normal where siparis_no=:siparis_no ");
    $siparisCek->execute(array(
        'siparis_no' => $_POST['siparisID'],
    ));
    $Row = $siparisCek->fetch(PDO::FETCH_ASSOC);

    $urunCek = $db->prepare("select * from urun where id=:id ");
    $urunCek->execute(array(
        'id' => $Row['urun_id'],
    ));
    $urun = $urunCek->fetch(PDO::FETCH_ASSOC);

    $duruMCek = $db->prepare("select * from siparis_durumlar where id=:id ");
    $duruMCek->execute(array(
        'id' => $Row['durum'],
    ));
    $durum = $duruMCek->fetch(PDO::FETCH_ASSOC);

    $ulkeCikar = $db->prepare("select * from ulkeler where dil=:dil and durum=:durum order by sira asc ");
    $ulkeCikar->execute(array(
        'dil' => $_SESSION['dil'],
        'durum' => '1'
    ));

    ?>
        <div class="normal-order-header">
          #<?=$Row['siparis_no']?> <?=$diller['users-panel-text193']?>
            <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
        </div>
        <div class="normal-order-product-info-main">
            <div class="normal-order-product-info-img">
                <img src="images/product/<?=$urun['gorsel']?>" alt="">
            </div>
            <div class="normal-order-product-info-txt">
                <div class="normal-order-product-info-txt-h">
                    <?=$urun['baslik']?>
                    <div class="w-100 mt-2 mb-2 d-flex justify-content-start flex-wrap" >
                        <div class="border mt-1 mb-1 rounded normal-order-in-div">
                            <?=$diller['users-panel-text133']?> : <?=$urun['urun_kod']?>
                        </div>
                        <div class="border  mt-1 mb-1 rounded normal-order-in-div">
                            <?=$diller['users-panel-text102']?> : #<?=$Row['siparis_no']?>
                        </div>
                        <div  class="border mt-1 mb-1 rounded normal-order-in-div">
                            <?=$diller['users-panel-text127']?> : <?php echo date_tr('j F Y, H:i', ''.$Row['tarih'].''); ?>
                        </div>
                    </div>
                    <div class="user_subpage_comment_box_status <?=$durum['renk']?>" style=" text-align: center;">
                        <?=$durum['baslik']?>
                    </div>
                    <?php if($Row['kargo_firma'] > '0' && $Row['kargo_takip'] == !null) {?>
                        <?php
                        $KarGOFirma = $db->prepare("select * from kargo_firma where id=:id ");
                        $KarGOFirma->execute(array(
                            'id' => $Row['kargo_firma'],
                        ));
                        $kargo = $KarGOFirma->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <?php if($kargo['takip_url'] == !null ) {?>
                            <a href="<?=$kargo['takip_url']?><?=$Row['kargo_takip']?>" target="_blank" class="user_subpage_comment_box_status button-blue" style=" text-align: center;">
                                <i class="fa fa-truck"></i> <?=$diller['users-panel-text136']?>
                            </a>
                        <?php }else { ?>
                            <a href="javascript:Void(0)" class="user_subpage_comment_box_status button-blue" style=" text-align: center;">
                                <?=$kargo['baslik']?>
                            </a>
                            <a href="javascript:Void(0)" class="user_subpage_comment_box_status button-blue" style=" text-align: center;">
                               <?=$diller['users-panel-text136']?> : <?=$Row['kargo_takip']?>
                            </a>
                        <?php }?>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="normal-order-product-form-main">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="isim"><?=$diller['urun-detay-normal-siparis-text-1']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$Row['isim']?> <?=$Row['soyisim']?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="eposta"><?=$diller['urun-detay-normal-siparis-text-3']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$Row['eposta']?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="telefon"><?=$diller['urun-detay-normal-siparis-text-4']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$Row['telefon']?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="ulke"><?=$diller['urun-detay-normal-siparis-text-7']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?php foreach ($ulkeCikar as $ulke) {?>
                            <?=$ulke['baslik']?>
                        <?php }?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="sehir_ilce"><?=$diller['urun-detay-normal-siparis-text-6']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$Row['sehir']?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="postakodu"><?=$diller['urun-detay-normal-siparis-text-8']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$Row['postakodu']?>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="adres"><?=$diller['urun-detay-normal-siparis-text-9']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$Row['adres']?>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="siparis_not"><?=$diller['urun-detay-normal-siparis-text-10']?></label>
                    <div class="input-group border-bottom pb-2">
                        <?=$Row['siparis_not']?>
                    </div>
                </div>
            </div>
        </div>
        <div class="normal-order-product-form-postarea">
            <button type="button" data-dismiss="modal" class="button-black button-2x" ><?=$diller['alert-button-kapat']?></button>
        </div>
<?php }else { ?>
<?php
    header('Location:'.$ayar['site_url'].'404');
?>
<?php }?>



