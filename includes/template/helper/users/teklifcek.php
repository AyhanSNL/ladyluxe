<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($_POST['teklifID']  ) {?>
    <?php
    $teklifCek = $db->prepare("select * from siparis_teklif where teklif_no=:teklif_no ");
    $teklifCek->execute(array(
        'teklif_no' => $_POST['teklifID'],
    ));
    $teklifRow = $teklifCek->fetch(PDO::FETCH_ASSOC);

    $urunCek = $db->prepare("select * from urun where id=:id ");
    $urunCek->execute(array(
        'id' => $teklifRow['urun_id'],
    ));
    $urun = $urunCek->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="normal-order-header">
          #<?=$teklifRow['teklif_no']?> <?=$diller['users-panel-text186']?>
            <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
        </div>
        <div class="normal-order-product-info-main">
            <div class="normal-order-product-info-img">
                <img src="images/product/<?=$urun['gorsel']?>" alt="">
            </div>
            <div class="normal-order-product-info-txt">
                <div class="normal-order-product-info-txt-h">
                    <?=$urun['baslik']?>
                    <br><br>
                    <span style="font-size: 13px ; font-weight: 500;">
                        <?=$diller['users-panel-text133']?> : <?=$urun['urun_kod']?> | <?=$diller['users-panel-text187']?> : #<?=$teklifRow['teklif_no']?>
                    </span>
                    <br><br>
                    <?php if($teklifRow['durum'] == '0' ) {?>
                        <div class="user_subpage_comment_box_status" style="border: 1px solid #9D9D9D; color: #9D9D9D;" >
                            <i class="fa fa-refresh fa-spin fa-fw"></i><span class="sr-only">Loading...</span> <?=$diller['users-panel-text172']?>
                        </div>
                    <?php }?>
                    <?php if($teklifRow['durum'] == '1' ) {?>
                        <div class="user_subpage_comment_box_status" style="border: 1px solid #66B483; color: #66B483;">
                            <i class="fa fa-check"></i> <?=$diller['users-panel-text184']?>
                        </div>
                        <div class="user_subpage_comment_box_status" style="border: 1px solid #7F99D8; color: #7F99D8; margin-left: 5px; ">
                            <i class="fa fa-check"></i> <?=$diller['users-panel-text185']?>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="normal-order-product-form-main mb-0">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="isim">* <?=$diller['urun-detay-normal-teklif-text-2']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$teklifRow['isim']?> <?=$teklifRow['soyisim']?>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="eposta">* <?=$diller['urun-detay-normal-teklif-text-4']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$teklifRow['eposta']?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="telefon">* <?=$diller['urun-detay-normal-teklif-text-5']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$teklifRow['telefon']?>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="adet"><?=$diller['urun-detay-normal-teklif-text-6']?></label>
                    <div class="mb-3 input-group border-bottom pb-2">
                        <?=$teklifRow['urun_adet']?>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="teklif_not">* <?=$diller['urun-detay-normal-teklif-text-7']?></label>
                    <div class="input-group border-bottom pb-2">
                        <?=$teklifRow['teklif_not']?>
                    </div>
                </div>
            </div>
        </div>
        <div class="normal-order-product-form-postarea" style="background-color: #fff; border-top: 0" >
            <?php if($teklifRow['teklif_icerik'] == !null  ) {?>
                <div style="width: 100%; font-size: 18px ; text-align: left; margin-bottom: 15px; font-weight: 600;  ">
                    <?=$diller['users-panel-text188']?>
                </div>
            <div class="user_subpage_info_div_blue user_subpage_info_overflow" style="text-align: left; font-size: 15px ;">
                <?=$teklifRow['teklif_icerik']?>
            </div>
            <?php }?>
            <?php if($teklifRow['teklif_icerik'] == null ) {?>
                <div class="user_subpage_info_div_blue" style="text-align: center; font-size: 14px ;">
                    <?=$diller['users-panel-text189']?>
                </div>
            <?php }?>

            <button type="button" data-dismiss="modal" class="button-black button-2x" ><?=$diller['alert-button-kapat']?></button>
        </div>

<?php }else { ?>
<?php
    header('Location:'.$ayar['site_url'].'404');
?>
<?php }?>



