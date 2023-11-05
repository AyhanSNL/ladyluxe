<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$ulkeCikar = $db->prepare("select * from ulkeler where dil=:dil and durum=:durum order by sira asc ");
$ulkeCikar->execute(array(
    'dil' => $_SESSION['dil'],
    'durum' => '1'
));
?>
<?php if($icerik['siparis_islem'] == '1' || $icerik['siparis_islem'] == '2' || $icerik['siparis_islem'] == '3' ) { ?>
    <!-- Sipariş Modal !-->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content shadow-lg">
                <?php if($icerik['siparis_islem'] == '1' ) {?>
                    <form action="normalOrder" method="post" id="orderForm" >
                        <input type="hidden" name="pid" value="<?=$icerik['id']?>">
                        <input type="hidden" name="hash" value="<?=md5($icerik['seo_url'])?>">
                        <div class="modal-in-comment">
                            <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                                &times;
                            </a>
                            <div class="modal-in-comment-head">
                                <div class="modal-in-comment-head-h">
                                    <div class="modal-in-comment-head-h-text">
                                        <?=$diller['urun-detay-normal-siparis-text-11']?>
                                    </div>
                                </div>
                            </div>
                            <div class="normal-order-product-info-main p-0 mb-4" style="border-bottom: 0;">
                                <div class="normal-order-product-info-img">
                                    <img src="images/product/<?=$icerik['gorsel']?>" alt="">
                                </div>
                                <div class="normal-order-product-info-txt">
                                    <div class="normal-order-product-info-txt-h">
                                        <?=$icerik['baslik']?>
                                    </div>
                                    <?php if($icerik['urun_kod'] == !null || $icerik['urun_kod'] > '0') {?>
                                        <div class="normal-order-product-info-txt-s">
                                            <strong><?=$diller['urun-detay-urun-kodu']?> :</strong> <?=$icerik['urun_kod']?>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="modal-in-comment-form teslimat-form-area">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="isim">* <?=$diller['urun-detay-normal-siparis-text-1']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="text" name="isim" autocomplete="off"  id="isim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['isim']?>" <?php }?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="soyisim">* <?=$diller['urun-detay-normal-siparis-text-2']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="text" name="soyisim" autocomplete="off"   id="soyisim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['soyisim']?>" <?php }?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="eposta">* <?=$diller['urun-detay-normal-siparis-text-3']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="text" name="eposta" autocomplete="off"  id="eposta"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['eposta']?>" <?php }?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="telefon">* <?=$diller['urun-detay-normal-siparis-text-4']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="number" name="telefon" autocomplete="off"   id="telefon"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['telefon']?>" <?php }?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="ulke">* <?=$diller['urun-detay-normal-siparis-text-7']?></label>
                                        <div class="mb-6 input-group">
                                            <select name="ulke" class="form-control" id="ulke" >
                                                <?php foreach ($ulkeCikar as $ulke) {?>
                                                    <option value="<?=$ulke['baslik']?>"><?=$ulke['baslik']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="sehir_ilce">* <?=$diller['urun-detay-normal-siparis-text-6']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="text" name="sehir_ilce"  autocomplete="off"  id="sehir_ilce"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="postakodu">* <?=$diller['urun-detay-normal-siparis-text-8']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="number" name="postakodu" autocomplete="off"  id="postakodu"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="adres">* <?=$diller['urun-detay-normal-siparis-text-9']?></label>
                                        <textarea name="adres" id="adres" class="form-control" rows="2" ></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="siparis_not">* <?=$diller['urun-detay-normal-siparis-text-10']?></label>
                                        <textarea name="siparis_not" id="siparis_not" class="form-control" rows="2" ></textarea>
                                    </div>
                                    <?php if($ayar['site_captcha'] == '1'  ) {?>
                                        <div class="form-group col-md-6 " >
                                            <div class="input-group mb-2 mr-sm-2" >
                                                <div class="input-group-prepend" >
                                                    <div class="input-group-text" style="border-radius: 0!important; background-color: #eaecef !important;"><img  src='includes/template/captcha.php'/></div>
                                                </div>
                                                <input type="text" class="form-control " id="inputCaptcha"   name="secure_code" maxlength="5" style="flex:0; width:100px !important;"  >
                                            </div>
                                        </div>
                                    <?php }?>
                                    <div class="form-group col-md-12 mb-0">
                                        <button   type="submit"  name="normalOrder" id="btnSubmit"  class="button-blue button-2x" style="width: 100%;  ">
                                            <?=$diller['urun-detay-normal-siparis-text-17']?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php }?>
                <?php if($icerik['siparis_islem'] == '2' ) {?>
                    <?php if($userSorgusu->rowCount()>'0'  ) {?>
                        <form action="normalOrder" method="post" id="orderForm" >
                            <input type="hidden" name="pid" value="<?=$icerik['id']?>">
                            <input type="hidden" name="hash" value="<?=md5($icerik['seo_url'])?>">
                            <div class="modal-in-comment">
                                <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                                    &times;
                                </a>
                                <div class="modal-in-comment-head">
                                    <div class="modal-in-comment-head-h">
                                        <div class="modal-in-comment-head-h-text">
                                            <?=$diller['urun-detay-normal-siparis-text-11']?>
                                        </div>
                                    </div>
                                </div>
                                <div class="normal-order-product-info-main p-0 mb-4" style="border-bottom: 0;">
                                    <div class="normal-order-product-info-img">
                                        <img src="images/product/<?=$icerik['gorsel']?>" alt="">
                                    </div>
                                    <div class="normal-order-product-info-txt">
                                        <div class="normal-order-product-info-txt-h">
                                            <?=$icerik['baslik']?>
                                        </div>
                                        <?php if($icerik['urun_kod'] == !null || $icerik['urun_kod'] > '0') {?>
                                            <div class="normal-order-product-info-txt-s">
                                                <strong><?=$diller['urun-detay-urun-kodu']?> :</strong> <?=$icerik['urun_kod']?>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="modal-in-comment-form teslimat-form-area">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="isim">* <?=$diller['urun-detay-normal-siparis-text-1']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="text" name="isim" autocomplete="off"  id="isim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['isim']?>" <?php }?>>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="soyisim">* <?=$diller['urun-detay-normal-siparis-text-2']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="text" name="soyisim" autocomplete="off"  id="soyisim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['soyisim']?>" <?php }?>>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="eposta">* <?=$diller['urun-detay-normal-siparis-text-3']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="text" name="eposta" autocomplete="off"  id="eposta"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['eposta']?>" <?php }?>>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="telefon">* <?=$diller['urun-detay-normal-siparis-text-4']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="number" name="telefon" autocomplete="off"  id="telefon"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['telefon']?>" <?php }?>>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="ulke">* <?=$diller['urun-detay-normal-siparis-text-7']?></label>
                                            <div class="mb-6 input-group">
                                                <select name="ulke" class="form-control" id="ulke" >
                                                    <?php foreach ($ulkeCikar as $ulke) {?>
                                                        <option value="<?=$ulke['baslik']?>"><?=$ulke['baslik']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="sehir_ilce">* <?=$diller['urun-detay-normal-siparis-text-6']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="text" name="sehir_ilce" autocomplete="off"  id="sehir_ilce"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="postakodu">* <?=$diller['urun-detay-normal-siparis-text-8']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="number" name="postakodu" autocomplete="off"  id="postakodu"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="adres">* <?=$diller['urun-detay-normal-siparis-text-9']?></label>
                                            <textarea name="adres" id="adres" class="form-control" rows="2" ></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="siparis_not">* <?=$diller['urun-detay-normal-siparis-text-10']?></label>
                                            <textarea name="siparis_not" id="siparis_not" class="form-control" rows="2" ></textarea>
                                        </div>
                                        <?php if($ayar['site_captcha'] == '1'  ) {?>
                                            <div class="form-group col-md-6 " >
                                                <div class="input-group mb-2 mr-sm-2" >
                                                    <div class="input-group-prepend" >
                                                        <div class="input-group-text" style="border-radius: 0!important; background-color: #eaecef !important;"><img  src='includes/template/captcha.php'/></div>
                                                    </div>
                                                    <input type="text" class="form-control " id="inputCaptcha"   name="secure_code" maxlength="5" style="flex:0; width:100px !important;"  >
                                                </div>
                                            </div>
                                        <?php }?>
                                        <div class="form-group col-md-12 mb-0">
                                            <button   type="submit"  name="normalOrder" id="btnSubmit"  class="button-blue button-2x" style="width: 100%;  ">
                                                <?=$diller['urun-detay-normal-siparis-text-17']?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php }else { ?>
                        <div class="normal-order-nologin-main">
                            <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                            <div class="normal-order-nologin-main-in">
                                <div class="normal-order-nologin-main-in-i">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <div class="normal-order-nologin-main-in-h">
                                    <?=$diller['urun-detay-normal-siparis-text-12']?>
                                </div>
                                <div class="normal-order-nologin-main-in-s">
                                    <?=$diller['urun-detay-normal-siparis-text-14']?>
                                </div>
                                <div class="normal-order-nologin-main-in-buttons">
                                    <a href="uye-girisi/" class="button-blue button-2x"><?=$diller['urun-detay-normal-siparis-text-15']?></a>
                                    <?php if($uyeayar['yeni_uyelik'] == '1'  ) {?>
                                        <a href="uyelik/" class="button-green button-2x"><?=$diller['urun-detay-normal-siparis-text-16']?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>
                <?php if($icerik['siparis_islem'] == '3' ) {?>
                    <?php if($userSorgusu->rowCount()>'0'  ) {?>
                        <?php if($uyegruplariCek->rowCount()> '0'  ) {?>
                            <form action="normalOrder" method="post" id="orderForm" >
                                <input type="hidden" name="pid" value="<?=$icerik['id']?>">
                                <input type="hidden" name="hash" value="<?=md5($icerik['seo_url'])?>">
                                <div class="modal-in-comment">
                                    <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                                        &times;
                                    </a>
                                    <div class="modal-in-comment-head">
                                        <div class="modal-in-comment-head-h">
                                            <div class="modal-in-comment-head-h-text">
                                                <?=$diller['urun-detay-normal-siparis-text-11']?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="normal-order-product-info-main p-0 mb-4" style="border-bottom: 0;">
                                        <div class="normal-order-product-info-img">
                                            <img src="images/product/<?=$icerik['gorsel']?>" alt="">
                                        </div>
                                        <div class="normal-order-product-info-txt">
                                            <div class="normal-order-product-info-txt-h">
                                                <?=$icerik['baslik']?>
                                            </div>
                                            <?php if($icerik['urun_kod'] == !null || $icerik['urun_kod'] > '0') {?>
                                                <div class="normal-order-product-info-txt-s">
                                                    <strong><?=$diller['urun-detay-urun-kodu']?> :</strong> <?=$icerik['urun_kod']?>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <div class="modal-in-comment-form teslimat-form-area">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="isim">* <?=$diller['urun-detay-normal-siparis-text-1']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="text" name="isim" autocomplete="off"  id="isim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['isim']?>" <?php }?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="soyisim">* <?=$diller['urun-detay-normal-siparis-text-2']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="text" name="soyisim" autocomplete="off"  id="soyisim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['soyisim']?>" <?php }?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="eposta">* <?=$diller['urun-detay-normal-siparis-text-3']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="text" name="eposta" autocomplete="off"  id="eposta"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['eposta']?>" <?php }?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="telefon">* <?=$diller['urun-detay-normal-siparis-text-4']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="number" name="telefon" autocomplete="off"  id="telefon"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['telefon']?>" <?php }?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="ulke">* <?=$diller['urun-detay-normal-siparis-text-7']?></label>
                                                <div class="mb-6 input-group">
                                                    <select name="ulke" class="form-control" id="ulke" >
                                                        <?php foreach ($ulkeCikar as $ulke) {?>
                                                            <option value="<?=$ulke['baslik']?>"><?=$ulke['baslik']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="sehir_ilce">* <?=$diller['urun-detay-normal-siparis-text-6']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="text" name="sehir_ilce"  autocomplete="off"  id="sehir_ilce"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="postakodu">* <?=$diller['urun-detay-normal-siparis-text-8']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="number" name="postakodu" autocomplete="off"   id="postakodu"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="adres">* <?=$diller['urun-detay-normal-siparis-text-9']?></label>
                                                <textarea name="adres" id="adres" class="form-control" rows="2" ></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="siparis_not">* <?=$diller['urun-detay-normal-siparis-text-10']?></label>
                                                <textarea name="siparis_not" id="siparis_not" class="form-control" rows="2" ></textarea>
                                            </div>
                                            <?php if($ayar['site_captcha'] == '1'  ) {?>
                                                <div class="form-group col-md-6 " >
                                                    <div class="input-group mb-2 mr-sm-2" >
                                                        <div class="input-group-prepend" >
                                                            <div class="input-group-text" style="border-radius: 0!important; background-color: #eaecef !important;"><img  src='includes/template/captcha.php'/></div>
                                                        </div>
                                                        <input type="text" class="form-control " id="inputCaptcha"   name="secure_code" maxlength="5" style="flex:0; width:100px !important;"  >
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <div class="form-group col-md-12 mb-0">
                                                <button   type="submit"  name="normalOrder" id="btnSubmit"  class="button-blue button-2x" style="width: 100%;  ">
                                                    <?=$diller['urun-detay-normal-siparis-text-17']?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php }else { ?>
                            <div class="normal-order-nologin-main">
                                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                                <div class="normal-order-nologin-main-in">
                                    <div class="normal-order-nologin-main-in-i">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    <div class="normal-order-nologin-main-in-h">
                                        <?=$diller['urun-detay-normal-siparis-text-13']?>
                                    </div>
                                    <div class="normal-order-nologin-main-in-s">
                                        <?=$diller['urun-detay-normal-siparis-text-18']?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php }else { ?>
                        <div class="normal-order-nologin-main">
                            <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                            <div class="normal-order-nologin-main-in">
                                <div class="normal-order-nologin-main-in-i">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <div class="normal-order-nologin-main-in-h">
                                    <?=$diller['urun-detay-normal-siparis-text-13']?>
                                </div>
                                <div class="normal-order-nologin-main-in-s">
                                    <?=$diller['urun-detay-normal-siparis-text-18']?>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                <?php }?>
            </div>
        </div>
    </div>
    <!--  <========SON=========>>> Sipariş Modal SON !-->
<?php }?>


<?php if ($icerik['siparis_islem'] == '4' || $icerik['siparis_islem'] == '5' || $icerik['siparis_islem'] == '6'){ ?>
    <!-- Teklif Modal !-->
    <div class="modal fade" id="offerModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content  shadow-lg">
                <?php if($icerik['siparis_islem'] == '4' ) {?>
                    <form action="offerOrder" method="post" id="orderForm" >
                        <input type="hidden" name="pid" value="<?=$icerik['id']?>">
                        <input type="hidden" name="hash" value="<?=md5($icerik['seo_url'])?>">
                        <div class="modal-in-comment">
                            <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                                &times;
                            </a>
                            <div class="modal-in-comment-head">
                                <div class="modal-in-comment-head-h">
                                    <div class="modal-in-comment-head-h-text">
                                        <?=$diller['urun-detay-normal-teklif-text-1']?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-in-comment-form teslimat-form-area">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="isim">* <?=$diller['urun-detay-normal-teklif-text-2']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="text" name="isim" autocomplete="off"  id="isim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['isim']?>" <?php }?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="soyisim">* <?=$diller['urun-detay-normal-teklif-text-3']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="text" name="soyisim" autocomplete="off"  id="soyisim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['soyisim']?>" <?php }?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="eposta">* <?=$diller['urun-detay-normal-teklif-text-4']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="text" name="eposta" autocomplete="off"  id="eposta"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['eposta']?>" <?php }?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="telefon">* <?=$diller['urun-detay-normal-teklif-text-5']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="number" name="telefon" autocomplete="off"  id="telefon"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['telefon']?>" <?php }?>>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="adet"><?=$diller['urun-detay-normal-teklif-text-6']?></label>
                                        <div class="mb-6 input-group">
                                            <input type="number" name="adet" autocomplete="off"  id="adet"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="teklif_not">* <?=$diller['urun-detay-normal-teklif-text-7']?></label>
                                        <textarea name="teklif_not" id="teklif_not" class="form-control" rows="2" ></textarea>
                                    </div>
                                    <?php if($ayar['site_captcha'] == '1'  ) {?>
                                        <div class="form-group col-md-6 " >
                                            <div class="input-group mb-2 mr-sm-2" >
                                                <div class="input-group-prepend" >
                                                    <div class="input-group-text" style="border-radius: 0!important;"><img  src='includes/template/captcha.php'/></div>
                                                </div>
                                                <input type="text" class="form-control " id="inputCaptcha"   name="secure_code" maxlength="5" style="flex:0; width:100px !important;"  >
                                            </div>
                                        </div>
                                    <?php }?>
                                    <div class="form-group col-md-12 mb-0">
                                        <button  type="submit"  name="offerOrder" id="btnSubmit" class="button-blue button-2x" style="width: 100%;  ">
                                            <?=$diller['urun-detay-normal-teklif-text-8']?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php }?>
                <?php if($icerik['siparis_islem'] == '5' ) {?>
                    <?php if($userSorgusu->rowCount()>'0'  ) {?>
                        <form action="offerOrder" method="post" id="orderForm" >
                            <input type="hidden" name="pid" value="<?=$icerik['id']?>">
                            <input type="hidden" name="hash" value="<?=md5($icerik['seo_url'])?>">
                            <div class="modal-in-comment">
                                <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                                    &times;
                                </a>
                                <div class="modal-in-comment-head">
                                    <div class="modal-in-comment-head-h">
                                        <div class="modal-in-comment-head-h-text">
                                            <?=$diller['urun-detay-normal-teklif-text-1']?>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-in-comment-form teslimat-form-area">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="isim">* <?=$diller['urun-detay-normal-teklif-text-2']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="text" name="isim"  autocomplete="off"  id="isim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['isim']?>" <?php }?>>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="soyisim">* <?=$diller['urun-detay-normal-teklif-text-3']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="text" name="soyisim"  autocomplete="off"  id="soyisim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['soyisim']?>" <?php }?>>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="eposta">* <?=$diller['urun-detay-normal-teklif-text-4']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="text" name="eposta"  autocomplete="off"  id="eposta"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['eposta']?>" <?php }?>>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="telefon">* <?=$diller['urun-detay-normal-teklif-text-5']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="number" name="telefon"  autocomplete="off"  id="telefon"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['telefon']?>" <?php }?>>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="adet"><?=$diller['urun-detay-normal-teklif-text-6']?></label>
                                            <div class="mb-6 input-group">
                                                <input type="number" name="adet" autocomplete="off"   id="adet"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="teklif_not">* <?=$diller['urun-detay-normal-teklif-text-7']?></label>
                                            <textarea name="teklif_not" id="teklif_not" class="form-control" rows="2" ></textarea>
                                        </div>
                                        <?php if($ayar['site_captcha'] == '1'  ) {?>
                                            <div class="form-group col-md-6 " >
                                                <div class="input-group mb-2 mr-sm-2" >
                                                    <div class="input-group-prepend" >
                                                        <div class="input-group-text" style="border-radius: 0!important;"><img  src='includes/template/captcha.php'/></div>
                                                    </div>
                                                    <input type="text" class="form-control " id="inputCaptcha"   name="secure_code" maxlength="5" style="flex:0; width:100px !important;"  >
                                                </div>
                                            </div>
                                        <?php }?>
                                        <div class="form-group col-md-12 mb-0">
                                            <button  type="submit"  name="offerOrder" id="btnSubmit" class="button-blue button-2x" style="width: 100%;  ">
                                                <?=$diller['urun-detay-normal-teklif-text-8']?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php }else { ?>
                        <!-- Giriş yok !-->
                        <!-- Üyelere özel bildirimi !-->
                        <div class="normal-order-nologin-main">
                            <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                            <div class="normal-order-nologin-main-in" style="border: 0;">
                                <div class="normal-order-nologin-main-in-i">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <div class="normal-order-nologin-main-in-h">
                                    <?=$diller['urun-detay-normal-teklif-text-9']?>
                                </div>
                                <div class="normal-order-nologin-main-in-s">
                                    <?=$diller['urun-detay-normal-teklif-text-10']?>
                                </div>
                                <div class="normal-order-nologin-main-in-buttons">
                                    <a href="uye-girisi/" class="button-blue button-2x"><?=$diller['urun-detay-normal-siparis-text-15']?></a>
                                    <?php if($uyeayar['yeni_uyelik'] == '1'  ) {?>
                                        <a href="uyelik/" class="button-green button-2x"><?=$diller['urun-detay-normal-siparis-text-16']?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Üyelere özel bildirimi SON !-->
                        <!--  <========SON=========>>> Giriş yok SON !-->
                    <?php }?>
                <?php }?>
                <?php if($icerik['siparis_islem'] == '6' ) {?>
                    <?php if($userSorgusu->rowCount()>'0'  ) {?>
                        <?php if($uyegruplariCek->rowCount()> '0'  ) {?>
                            <form action="offerOrder" method="post" id="orderForm" >
                                <input type="hidden" name="pid" value="<?=$icerik['id']?>">
                                <input type="hidden" name="hash" value="<?=md5($icerik['seo_url'])?>">
                                <div class="modal-in-comment">
                                    <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                                        &times;
                                    </a>
                                    <div class="modal-in-comment-head">
                                        <div class="modal-in-comment-head-h">
                                            <div class="modal-in-comment-head-h-text">
                                                <?=$diller['urun-detay-normal-teklif-text-1']?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-in-comment-form teslimat-form-area">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="isim">* <?=$diller['urun-detay-normal-teklif-text-2']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="text" name="isim"  autocomplete="off"  id="isim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['isim']?>" <?php }?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="soyisim">* <?=$diller['urun-detay-normal-teklif-text-3']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="text" name="soyisim"  autocomplete="off"  id="soyisim"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['soyisim']?>" <?php }?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="eposta">* <?=$diller['urun-detay-normal-teklif-text-4']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="text" name="eposta"  autocomplete="off"  id="eposta"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['eposta']?>" <?php }?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="telefon">* <?=$diller['urun-detay-normal-teklif-text-5']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="number" name="telefon" autocomplete="off"  id="telefon"  class="form-control" <?php if($userSorgusu->rowCount()>'0'  ) { ?>value="<?=$userCek['telefon']?>" <?php }?>>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="adet"><?=$diller['urun-detay-normal-teklif-text-6']?></label>
                                                <div class="mb-6 input-group">
                                                    <input type="number" name="adet" autocomplete="off"   id="adet"  class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="teklif_not">* <?=$diller['urun-detay-normal-teklif-text-7']?></label>
                                                <textarea name="teklif_not" id="teklif_not" class="form-control" rows="2" ></textarea>
                                            </div>
                                            <?php if($ayar['site_captcha'] == '1'  ) {?>
                                                <div class="form-group col-md-6 " >
                                                    <div class="input-group mb-2 mr-sm-2" >
                                                        <div class="input-group-prepend" >
                                                            <div class="input-group-text" style="border-radius: 0!important;"><img  src='includes/template/captcha.php'/></div>
                                                        </div>
                                                        <input type="text" class="form-control " id="inputCaptcha"   name="secure_code" maxlength="5" style="flex:0; width:100px !important;"  >
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <div class="form-group col-md-12 mb-0">
                                                <button  type="submit"  name="offerOrder" id="btnSubmit" class="button-blue button-2x" style="width: 100%;  ">
                                                    <?=$diller['urun-detay-normal-teklif-text-8']?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php }else { ?>
                            <!-- ÜYE GRUPLARINA özel bildirimi !-->
                            <div class="normal-order-nologin-main">
                                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                                <div class="normal-order-nologin-main-in" style="border: 0;">
                                    <div class="normal-order-nologin-main-in-i">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    <div class="normal-order-nologin-main-in-h">
                                        <?=$diller['urun-detay-normal-teklif-text-11']?>
                                    </div>
                                    <div class="normal-order-nologin-main-in-s" style="margin-top: 20px;">
                                        <?=$diller['urun-detay-normal-teklif-text-12']?>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> ÜYE GRUPLARINA özel bildirimi SON !-->
                        <?php }?>
                    <?php }else { ?>
                        <!-- ÜYE GRUPLARINA özel bildirimi !-->
                        <div class="normal-order-nologin-main">
                            <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                            <div class="normal-order-nologin-main-in" style="border: 0;">
                                <div class="normal-order-nologin-main-in-i">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <div class="normal-order-nologin-main-in-h">
                                    <?=$diller['urun-detay-normal-teklif-text-11']?>
                                </div>
                                <div class="normal-order-nologin-main-in-s" style="margin-top: 20px;">
                                    <?=$diller['urun-detay-normal-teklif-text-12']?>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> ÜYE GRUPLARINA özel bildirimi SON !-->
                    <?php }?>

                <?php }?>
            </div>
        </div>
    </div>
    <!--  <========SON=========>>> Teklif Modal SON !-->
<?php }?>


<?php if($_SESSION['normal_siparis_alert'] == 'empty'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-detay-normal-teklif-text-13']?></div>
                    <div>
                        <?=$diller['urun-detay-normal-teklif-text-14']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#noArea').modal('show');
        });
        $(window).load(function () {
            $('#noArea').modal('show');
        });
        var $modalDialog = $("#noArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['normal_siparis_alert'] ) ?>
<?php }?>
<?php if($_SESSION['normal_siparis_alert'] == 'eposta'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-detay-normal-teklif-text-13']?></div>
                    <div>
                        <?=$diller['urun-detay-normal-teklif-text-15']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#noArea').modal('show');
        });
        $(window).load(function () {
            $('#noArea').modal('show');
        });
        var $modalDialog = $("#noArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['normal_siparis_alert'] ) ?>
<?php }?>
<?php if($_SESSION['normal_siparis_alert'] == 'secure'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-detay-normal-teklif-text-13']?></div>
                    <div>
                        <?=$diller['urun-detay-normal-teklif-text-16']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#noArea').modal('show');
        });
        $(window).load(function () {
            $('#noArea').modal('show');
        });
        var $modalDialog = $("#noArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['normal_siparis_alert'] ) ?>
<?php }?>
<?php if($_SESSION['normal_siparis_alert'] == 'success') {?>

    <div class="modal fade" id="succesMessagePost" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
                    <div>
                        <?=$diller['urun-detay-normal-teklif-text-17']?>
                    </div>
                    <div style="font-size: 12px; margin-top: 20px; line-height: 15px!important; color: #666;">
                        <?=$diller['urun-detay-normal-teklif-text-18']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  style=" " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#succesMessagePost').modal('show');
        });
        $(window).load(function () {
            $('#succesMessagePost').modal('show');
        });
        var $modalDialog = $("#succesMessagePost");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['normal_siparis_alert']); ?>
<?php }?>

<?php if($_SESSION['teklif_siparis_alert'] == 'empty'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-detay-normal-teklif-text-19']?></div>
                    <div>
                        <?=$diller['urun-detay-normal-teklif-text-20']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#noArea').modal('show');
        });
        $(window).load(function () {
            $('#noArea').modal('show');
        });
        var $modalDialog = $("#noArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teklif_siparis_alert'] ) ?>
<?php }?>
<?php if($_SESSION['teklif_siparis_alert'] == 'eposta'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-detay-normal-teklif-text-13']?></div>
                    <div>
                        <?=$diller['urun-detay-normal-teklif-text-21']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#noArea').modal('show');
        });
        $(window).load(function () {
            $('#noArea').modal('show');
        });
        var $modalDialog = $("#noArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teklif_siparis_alert'] ) ?>
<?php }?>
<?php if($_SESSION['teklif_siparis_alert'] == 'secure'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-detay-normal-teklif-text-13']?></div>
                    <div>
                        <?=$diller['urun-detay-normal-teklif-text-22']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#noArea').modal('show');
        });
        $(window).load(function () {
            $('#noArea').modal('show');
        });
        var $modalDialog = $("#noArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teklif_siparis_alert'] ) ?>
<?php }?>
<?php if($_SESSION['teklif_siparis_alert'] == 'success') {?>

    <div class="modal fade" id="succesMessagePost" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
                    <div>
                        <?=$diller['urun-detay-normal-teklif-text-23']?>
                    </div>
                    <div style="font-size: 12px; margin-top: 20px; line-height: 15px!important; color: #666;">
                        <?=$diller['urun-detay-normal-teklif-text-24']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  style=" " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#succesMessagePost').modal('show');
        });
        $(window).load(function () {
            $('#succesMessagePost').modal('show');
        });
        var $modalDialog = $("#succesMessagePost");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teklif_siparis_alert']); ?>
<?php }?>
<!-- Disabled button !-->
<script>
    $('#orderForm').bind('submit', function (e) {
        var button = $('#btnSubmit');
        button.prop('disabled', true);
        var valid = true;
        if (!valid) {
            e.preventDefault();
            button.prop('disabled', false);
        }
    });
</script>
<!--  <========SON=========>>> Disabled button SON !-->