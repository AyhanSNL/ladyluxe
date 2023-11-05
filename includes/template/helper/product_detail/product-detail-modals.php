<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<!-- Üye Girişi Modal !-->
<?php if($userSorgusu->rowCount() <= '0') {?>
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg ">
                <div class="modal-in-login">
                    <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                        &times;
                    </a>
                    <div class="modal-in-login-head">
                        <div class="modal-in-login-head-h">
                            <div class="modal-in-login-head-h-text">
                                <?=$diller['uyegiris-modal-text1']?>
                            </div>
                        </div>
                        <div class="modal-in-login-head-s">
                           <?=$diller['uyegiris-modal-text2']?>
                        </div>
                    </div>
                    <div class="modal-in-login-form teslimat-form-area">
                        <form action="productloginpage" method="post" >
                            <input type="hidden" name="return_product" value="<?=$icerik['seo_url']?>">
                            <input type="hidden" name="return_id" value="<?=$icerik['id']?>">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="emailadress" style="font-weight: 600;">* <?=$diller['uyegiris-modal-text3']?></label>
                                    <input type="email" name="emailadress" id="emailadress" required   class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="password" style="font-weight: 600;">* <?=$diller['uyegiris-modal-text4']?></label>
                                    <input type="password" name="password" id="password" required   class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4 ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="rememberme" value="rememberme" class="custom-control-input" id="rememberme"  >
                                        <label class="custom-control-label" for="rememberme" style="font-size: 14px !important ;  ">
                                            <?=$diller['uyegiris-modal-text5']?>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-8" style="text-align: right;">
                                    <a class="modal-in-login-form-reset-password" href="sifremi-unuttum/" target="_blank" ><?=$diller['uyegiris-modal-text6']?></a>
                                </div>
                                <div class="form-group col-md-12 " style="margin-top: 20px;">
                                    <button name="userlogin" class="button-blue button-2x" style="width: 100%;  " ><?=$diller['uyegiris-modal-text7']?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if($uyeayar['yeni_uyelik'] == '1' ) { ?>
                    <div class="modal-in-login-foot">
                        <div class="modal-in-login-head-h">
                            <div class="modal-in-login-head-h-text">
                                <?=$diller['uyegiris-modal-text8']?>
                            </div>
                        </div>
                        <div class="modal-in-login-head-s" style="margin-bottom: 15px;">
                           <?=$diller['uyegiris-modal-text9']?>
                        </div>
                            <a href="uyelik/" class="button-green button-2x"
                               style="width: 100%; text-align: center; "><?= $diller['uyegiris-modal-text10'] ?></a>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
<?php }?>
<?php if($_SESSION['login_success'] == 'success'  ) {?>
    <script>
        $(window).on("load", function() {
            $('#AddCommentUser').modal('show');
        });
        $(window).load(function () {
            $('#AddCommentUser').modal('show');
        });
        var $modalDialog = $("#AddCommentUser");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['login_success'] ) ?>
<?php }?>
<?php if($_SESSION['uyelik_durum'] =='success_onay'  ) {?>
    <div class="modal fade" id="okArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">

                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #4b7ece;"><?=$diller['alert-warning-2']?></div>
                    <div>
                        <?=$diller['users-text14-onaysiz']?>
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
            $('#okArea').modal('show');
        });
        $(window).load(function () {
            $('#okArea').modal('show');
        });
        var $modalDialog = $("#okArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['uyelik_durum']); ?>
<?php }?>
<!-- Üye Girişi Modal  SON !-->

<!-- Yorum Ekle Modal !-->
<?php if($uyeayar['durum'] == '1' ) {?>
    <?php if($userSorgusu->rowCount() > '0') {?>
        <!-- Yorum Yaz Modal !-->
        <div class="modal fade" id="AddCommentUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content shadow-lg ">
                    <form action="productaddcomment" method="post" id="commentForm" >
                        <input type="hidden" name="pID" value="<?=$icerik['id']?>" >
                        <input type="hidden" name="hash" value="<?=md5($icerik['seo_url'])?>" >
                    <div class="modal-in-comment">
                        <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:none !important; border:0 !important;">
                            &times;
                        </a>
                        <div class="modal-in-comment-head">
                            <div class="modal-in-comment-head-h">
                                <div class="modal-in-comment-head-h-text">
                                    <?=$diller['urun-detay-modal-urunu-degerlendirin-baslik']?>
                                </div>
                            </div>
                            <div class="modal-in-comment-head-s">
                                <?=$diller['urun-detay-modal-urunu-degerlendirin']?>
                            </div>
                        </div>
                        <div class="modal-in-comment-form teslimat-form-area">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="emailadress" style="font-weight: 600;"><?=$diller['urun-detay-modal-puaniniz']?></label>
                                    <div class="modal-in-comment-form-star">
                                        <div class="rating" >
                                            <label >
                                                <input type="radio" name="star_rate" checked value="1" />
                                                <span class="icon" >★</span>
                                            </label>
                                            <label>
                                                <input type="radio" name="star_rate" value="2" />
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                            </label>
                                            <label>
                                                <input type="radio" name="star_rate" value="3" />
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                            </label>
                                            <label>
                                                <input type="radio" name="star_rate" value="4" />
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                            </label>
                                            <label>
                                                <input type="radio" name="star_rate" value="5" />
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                                <span class="icon">★</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="baslik" style="font-weight: 600;"><?=$diller['urun-detay-modal-yorum-basliginiz']?></label>
                                    <input type="text" name="baslik" id="baslik" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="yorum" style="font-weight: 600;"><?=$diller['urun-detay-modal-yorumunuz']?></label>
                                    <textarea name="yorum" id="yorum" class="form-control"  rows="3" style="-webkit-border-radius: 0 !important;-moz-border-radius: 0 !;border-radius: 0 !;"></textarea>
                                </div>
                                <div class="form-group col-md-12 ">
                                    <div class="custom-control custom-checkbox">
                                        <input type='hidden'  name='gizli' value='0'>
                                        <input type="checkbox" name="gizli" value="1" class="custom-control-input" id="gizli"  >
                                        <label class="custom-control-label" for="gizli" style="font-size: 14px !important ;  ">
                                            <?=$diller['urun-detay-modal-gizlilik']?>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 " style="margin-top: 20px;">
                                    <input type="hidden" name="commentAdd" value="1" >
                                    <button  name="addcomment" id="btnSubmit" class="button-blue button-2x" style="width: 100%;  "><i class="fa fa-send"></i> <?=$diller['urun-detay-modal-yorumu-gonder-button-yazisi']?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Yorum Yaz Modal SON !-->
        <!-- Comment Loading !-->
        <script>
            $("#btnSubmit").click(function () {
                $(this).text("<?=$diller['urun-detay-modal-yorumu-gonder-button-yazisi-post']?>");
            });
            $('#commentForm').bind('submit', function (e) {
                var button = $('#btnSubmit');
                button.prop('disabled', true);
                var valid = true;
                if (!valid) {
                    e.preventDefault();
                    button.prop('disabled', false);
                }
            });
        </script>
        <script id="rendered-js">
            $(':radio').change(function () {
                console.log('New star rating: ' + this.value);
            });
        </script>
        <!--  <========SON=========>>> Comment Loading SON !-->
    <?php } ?>
<?php }?>
<?php if($_SESSION['yorum_eklendi'] == 'success'   ) {?>
    <div class="modal fade" id="successLogin" >
        <div class="modal-dialog modal-dialog-centered  ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['urun-detay-yorum-basarili-baslik']?></div>
                    <?=$diller['urun-detay-yorum-basarili-aciklama']?>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  style=" " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successLogin').modal('show');
        });
        $(window).load(function () {
            $('#successLogin').modal('show');
        });
        var $modalDialog = $("#successLogin");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['yorum_eklendi'] ) ?>
<?php }?>
<?php if($_SESSION['yorum_eklendi'] == 'empty'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-detay-yorum-bos-alan-baslik']?></div>
                    <div>
                        <?=$diller['urun-detay-yorum-bos-alan-aciklama']?>
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
<?php unset($_SESSION['yorum_eklendi'] ) ?>
<?php }?>
<?php if($_SESSION['yorum_eklendi'] == 'starproblem'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-detay-yorum-yildizsorun-baslik']?></div>
                    <div>
                        <?=$diller['urun-detay-yorum-yildizsorun-aciklama']?>
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
    <?php unset($_SESSION['yorum_eklendi'] ) ?>
<?php }?>
<!-- Yorum Ekle Modal SON !-->

<!-- Ürün Eklendi Modal 1 !-->
<?php if($_SESSION['addtocart'] == 'success'   ) {?>
<div class="modal fade" id="successCart" >
    <div class="modal-dialog modal-dialog-centered modal-sm ">
    <div class="modal-content">
    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
<div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
    <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
    <?=$diller['urun-sepete-eklendi']?>
    </div>
    <div class="category-cart-add-success-modal-footer">
    <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  data-dismiss="modal"><?=$diller['sepet-alisverise-devam']?></button>
    <a href="sepet/" class="button-2x button-black-out" style="width: 100%; text-align: center;text-transform: uppercase; "><i class="fa fa-shopping-bag"></i> <?=$diller['header-sepete-git-yazisi']?></a>
</div>
</div>
</div>
</div>
<script>
    $(window).on("load", function() {
        $('#successCart').modal('show');
    });
    $(window).load(function () {
        $('#successCart').modal('show');
    });
    var $modalDialog = $("#successCart");
    $modalDialog.modal('show');

    setTimeout(function() {
        $modalDialog.modal('hide');
    }, 0);
    </script>
<?php unset($_SESSION['addtocart'] ) ?>
<?php }?>
    <!-- Ürün Eklendi Modal 1 SON !-->

<?php if($_SESSION['addtocart'] == 'modalsuccess'   ) {?>
<!-- Ürün Eklendi Gelişmiş Modal 2 !-->
<div class="modal fade" id="successcartmodal" >
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="sepet-return-modal">
                <div class="sepet-return-alert" >
                    <i class="ion-ios-checkmark-outline"></i> <?=$diller['urun-sepete-eklendi']?>
                </div>
                <div class="sepet-return-product">
                    <div class="sepet-return-product-left">
                        <div class="sepet-return-product-img">
                            <img src="images/product/<?=$icerik['gorsel']?>" alt="<?=$icerik['baslik']?>">
                        </div>
                        <div class="sepet-return-product-head" >
                            <div>
                                <?=$icerik['baslik']?>
                            </div>
                            <div style="font-weight: 400;">
                                <?=$diller['sepet-adet']?> : <strong><?=$_SESSION['adetdetay']?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="sepet-return-product-quantity">
                                <span style="font-size: 18px; font-weight: bold;">
                                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                            <?=$secilikur['sol_simge']?>
                                        <?php }?>
                                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                            <?=$secilikur['sag_simge']?>
                                        <?php }?>
                                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$mevcutfiyat ), $secilikur['para_format']); ?>
                                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                            <?=$secilikur['sol_simge']?>
                                        <?php }?>
                                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                            <?=$secilikur['sag_simge']?>
                                        <?php }?>

                                        <?php if($icerik['kdv'] == '1' ) {?>
                                            <?=$diller['urunler-arti-kdv']?>
                                        <?php }?>
                                </span>


                        <?php unset($_SESSION['adetdetay']); ?>
                    </div>
                </div>
            </div>

            <div class="urundetay-cart-add-success-modal-footer">
                <a data-dismiss="modal" role="button" href="" class="button-2x button-blue" >
                    <?=$diller['sepet-alisverise-devam']?>
                </a>
                <a href="sepet/" class="button-2x button-black-out" >
                    <i class="fa fa-shopping-bag"></i> <?=$diller['header-sepete-git-yazisi']?>
                </a>
            </div>
        </div>
    </div>
</div>
    <script>
        $(window).on("load", function() {
            $('#successcartmodal').modal('show');
        });
        $(window).load(function () {
            $('#successcartmodal').modal('show');
        });
        var $modalDialog = $("#successcartmodal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
<?php unset($_SESSION['addtocart'] ) ?>
<?php }?>
    <!-- Ürün Eklendi Gelişmiş Modal 2 SON !-->

<!-- Boş alan uyarısı !-->
<?php if($_SESSION['addtocart'] == 'empty'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['alert-warning-bos-alan']?>
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
    <?php unset($_SESSION['addtocart'] ) ?>
<?php }?>
<!-- Boş alan uyarısı SON !-->

<!-- Stok yok !-->
<?php if($_SESSION['addtocart'] == 'nostok'  ) {?>
    <div class="modal fade" id="noStok" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-yetersiz-stok']?></div>
                    <div>
                        <?=$diller['urun-yetersiz-stok-aciklama']?>
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
            $('#noStok').modal('show');
        });
        $(window).load(function () {
            $('#noStok').modal('show');
        });
        var $modalDialog = $("#noStok");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['addtocart'] ) ?>
<?php }?>
<!-- Stok yok SON !-->

<!-- Stok aşılmış !-->
<?php if($_SESSION['addtocart'] == 'nomorestok'  ) {?>
    <div class="modal fade" id="noStok" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['urun-stok-asma-baslik']?></div>
                    <div>
                        <?=$diller['urun-stok-asma']?>
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
            $('#noStok').modal('show');
        });
        $(window).load(function () {
            $('#noStok').modal('show');
        });
        var $modalDialog = $("#noStok");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['addtocart'] ) ?>
<?php }?>
<!-- Stok aşılmış SON !-->

<?php if($_SESSION['compare_status'] == 'success'  ) {?>
    <!-- Karşılaştırma !-->
    <div class="modal fade" id="compareModal" >
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                    <?=$diller['urun-detay-karsilastirma-listeye-eklendi-text']?>
                </div>
                <div style="width: 100%; display: flex; align-items: center; justify-content: center;  padding: 20px; background-color: #f8f8f8; box-sizing: border-box">
                    <a href="karsilastirmalar/" class="button-2x button-blue" style="text-transform: uppercase;"><?=$diller['urun-detay-karsilastirma-listeye-git']?></a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#compareModal').modal('show');
        });
        $(window).load(function () {
            $('#compareModal').modal('show');
        });
        var $modalDialog = $("#compareModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['compare_status']); ?>
    <!--  <========SON=========>>> Karşılaştırma SON !-->
<?php } ?>
<?php if($_SESSION['favorite_status'] == 'success'  ) {?>
    <!-- Favorilere eklendi !-->
    <div class="modal fade" id="favModal" >
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-heart" style="font-size: 60px ; color: #f7acaa;"></i><br>
                    <?=$diller['urun-detay-favori-listeye-eklendi-text']?>
                </div>
                <div style="width: 100%; display: flex; align-items: center; justify-content: center;  padding: 20px; background-color: #f8f8f8; box-sizing: border-box">
                    <a href="hesabim/favoriler/" class="button-2x button-pink" style="text-transform: uppercase;"><?=$diller['urun-detay-favori-listeye-git']?></a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#favModal').modal('show');
        });
        $(window).load(function () {
            $('#favModal').modal('show');
        });
        var $modalDialog = $("#favModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['favorite_status']); ?>
    <!--  <========SON=========>>> Favorilere eklendi SON !-->
<?php } ?>

<!-- Favori Uyarı Popup !-->
<div class="modal fade" id="favModal"  >
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
            <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                <i class="ion-ios-locked" style="font-size: 45px ; color: #558cff;"></i><br>
                <?=$diller['kategori-detay-text31']?>
            </div>
            <div class="category-cart-add-success-modal-footer">
                <a href="uye-girisi/" class="button-2x button-blue" style="width: 100%; text-align: center; text-transform: uppercase;"><?=$diller['kategori-detay-text37']?></a>
            </div>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Favori Uyarı Popup SON !-->






