<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($userSorgusu->rowCount()>'0'  && $uyeayar['durum'] == '1'   ) {
    $userpage = 'hesap';
    ?>
<title><?php echo $diller['users-ayarlar-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <META HTTP-EQUIV="Expire" CONTENT="now" />
    <META HTTP-EQUIV="pragma" CONTENT="no-cache" />
    <META HTTP-EQUIV="cache-control" CONTENT="no-cache" />
<?php include "includes/config/header_libs.php";?>

</head>
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>


<!-- CONTENT AREA ============== !-->

<div class="users_main_div" style="background-color: #<?=$uyeayar['altsayfa_bg']?>;  font-family : '<?=$uyeayar['font_select']?>',sans-serif ; ">

    <div class="user_subpage_div">

        <!-- Header !-->
        <div class="user_page_header_subpage">
            <a href="<?=$ayar['site_url']?>"><?=$diller['users-panel-baglanti-text1']?></a>
           <i class="las la-angle-double-right"></i>
            <a ><?=$diller['users-panel-baglanti-text2']?></a>
           <i class="las la-angle-double-right"></i>
            <a href="hesabim/ayarlar/"><?=$diller['users-panel-baglanti-text3']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->

        <?php include 'includes/template/helper/users/leftbar.php'; ?>


        <!-- Right Content !-->
        <div class="user_subpage_account_content">

            <!-- Account Detail !-->
            <div class="user_subpage_account_left">
                <div class="user_subpage_account_header">
                    <?=$diller['users-panel-text4']?>
                </div>
                <?php if($diller['users-panel-text1'] == !null  ) {?>
                    <div class="user_subpage_info_div_blue">
                        <?=$diller['users-panel-text1']?>
                    </div>
                <?php }?>
                <form action="useraccountchange" method="post">
                <div class="teslimat-form-area m-top-30">
                    <?php if($uyeayar['basit_form'] == '0' ) {?>
                        <div class="register-page-uyelik-tipi-main uye-tipi">
                            <div class="register-page-uyelik-tipi-h">
                                <div class="register-page-uyelik-tipi-h-in">
                                    <?=$diller['users-text38']?>
                                </div>
                            </div>
                            <div class="register-page-uyelik-tipi ">
                                <div class="rdio rdio-primary font-14 ">
                                    <input name="uye_tip" value="1" id="1" type="radio" <?php if($userCek['uye_tip'] == '1' ) { ?>checked<?php }?>>
                                    <label for="1"><?=$diller['users-text29']?></label>
                                </div>
                                <div class="rdio rdio-primary font-14">
                                    <input name="uye_tip" value="2" id="2" type="radio" <?php if($userCek['uye_tip'] == '2' ) { ?>checked<?php }?>>
                                    <label for="2"><?=$diller['users-text30']?></label>
                                </div>
                            </div>
                        </div>
                        <div class="uye-tipi-bireysel row" >
                            <!-- Bireysel !-->
                            <div class="form-group col-md-12">
                                <label for="tc_no" style="font-weight: 600;"><?=$diller['users-text53']?></label>
                                <input type="text" name="tc_no"  id="tc_no"  class="form-control" autocomplete="off" value="<?=$userCek['tc_no']?>">
                            </div>
                            <!-- Bireysel SON !-->
                        </div>
                        <div class="uye-tipi-kurumsal row" >
                            <!-- Kurumsal !-->
                            <div class="form-group col-md-12">
                                <label for="firma_unvan" style="font-weight: 600;"><?=$diller['users-text22']?></label>
                                <input type="text" name="firma_unvan"  id="firma_unvan"  class="form-control" autocomplete="off" value="<?=$userCek['firma_unvan']?>">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="vergi_dairesi" style="font-weight: 600;"><?=$diller['users-text23']?></label>
                                <input type="text" name="vergi_dairesi"  id="vergi_dairesi"  class="form-control" autocomplete="off" value="<?=$userCek['vergi_dairesi']?>">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="vergi_no" style="font-weight: 600;"><?=$diller['users-text24']?></label>
                                <input type="number" name="vergi_no"  id="vergi_no"  class="form-control" autocomplete="off" value="<?=$userCek['vergi_no']?>">
                            </div>
                            <!-- Kurumsal SON !-->
                        </div>
                    <?php }?>
                <div class="row" >
                    <div class="form-group col-md-12">
                        <label for="name" style="font-weight: 600;">* <?=$diller['users-text18']?></label>
                        <input type="text" name="name" id="name"    class="form-control" autocomplete="off" value="<?=$userCek['isim']?>">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="surname" style="font-weight: 600;">* <?=$diller['users-text19']?></label>
                        <input type="text" name="surname" id="surname"    class="form-control" autocomplete="off" value="<?=$userCek['soyisim']?>">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="emailadress" style="font-weight: 600;"><i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="<?=$diller['users-panel-text3']?>"></i> <?=$diller['users-text20']?> </label>
                        <input type="text" name="emailadress" id="emailadress" disabled  class="form-control" value="<?=$userCek['eposta']?>" autocomplete="off">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="gsm" style="font-weight: 600;"><i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="<?=$diller['users-panel-text10']?>"></i> <?=$diller['users-text21']?> </label>
                        <input type="number" name="gsm" id="gsm"  class="form-control" autocomplete="off" disabled="" value="<?=$userCek['telefon']?>">
                    </div>
                    <?php if($uyeayar['sms_ekle'] == '1' ) {?>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="smsonay" value="1" class="custom-control-input" id="smsonay"  <?php if($userCek['sms_ekle'] == '1'  ) { ?>checked<?php }?>>
                                <label class="custom-control-label" for="smsonay" style="font-size: 14px ; ">
                                    <?=$diller['users-text52']?>
                                </label>
                            </div>
                        </div>
                    <?php }?>
                    <?php if($uyeayar['eposta_ekle'] == '1' ) {?>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="epostaonay" value="1" class="custom-control-input" id="epostaonay"  <?php if($userCek['eposta_ekle'] == '1'  ) { ?>checked<?php }?>>
                                <label class="custom-control-label" for="epostaonay" style="font-size: 14px ; ">
                                    <?=$diller['users-text27']?>
                                </label>
                            </div>
                        </div>
                    <?php }?>
                    <div class="form-group col-md-12 " style="margin-bottom: 0; ">
                        <button  name="account" class="button-blue button-2x" style="width: 100%; margin-top: 10px;  " ><?=$diller['users-panel-text2']?></button>
                    </div>
                </div>
                </div>
                </form>
            </div>
            <!--  <========SON=========>>> Account Detail SON !-->


            <!-- Password Change !-->
            <div class="user_subpage_account_right">
                <div class="user_subpage_account_right_head">
                    <div class="user_subpage_account_right_head_in"><i class="las la-key"></i> <?=$diller['users-panel-text5']?></div>
                </div>
                <form action="userpasswordchange" method="post">
                    <div class="row">
                        <div class="teslimat-form-area">
                            <div class="form-group col-md-12 password-absolute">
                                <label for="password" style="font-weight: 600;">* <?=$diller['users-panel-text6']?></label>
                                <input id="password-field" type="password" name="old_password" id="password"  required   class="form-control" autocomplete="off">
                                <span  toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group col-md-12 password-absolute">
                                <label for="password2" style="font-weight: 600;">* <?=$diller['users-panel-text7']?></label>
                                <input id="password-field2" type="password" name="new_password" id="password2"  required   class="form-control" autocomplete="off">
                                <span  toggle2="#password-field2" class="fa fa-fw fa-eye field-icon2 toggle-password2"></span>
                            </div>
                            <div class="form-group col-md-12 password-absolute">
                                <label for="password3" style="font-weight: 600;">* <?=$diller['users-panel-text8']?></label>
                                <input id="password-field3" type="password" name="new_password_again" id="password3"  required   class="form-control" autocomplete="off">
                                <span  toggle3="#password-field3" class="fa fa-fw fa-eye field-icon2 toggle-password3"></span>
                            </div>
                            <div class="form-group col-md-12 "style="margin-bottom: 0; " >
                                <button name="userpasswordchange"  class="button-blue button-2x" style="width: 100%;  " ><?=$diller['users-panel-text9']?></button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <!--  <========SON=========>>> Password Change SON !-->

        </div>
        <!--  <========SON=========>>> Right Content SON !-->





    </div>


</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>
<script>
        $('.uye-tipi input').change(function () {
            $(this).closest('.uye-tipi').next('.uye-tipi-bireysel').toggle(this.value == '1').next('.uye-tipi-kurumsal').toggle(this.value == '2');
        }).filter(':checked').change();

        /* Password See */
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password2").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle2"));
            if (input.attr("type") == "password") {
                input.attr("type", "text2");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password3").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle3"));
            if (input.attr("type") == "password") {
                input.attr("type", "text3");
            } else {
                input.attr("type", "password");
            }
        });
        /*  <========SON=========>>> Password See SON */
</script>


    <!-- Account Alerts !-->
    <?php if($_SESSION['ayardegis_durum'] == 'tcuzunluk'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text61']?>
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
        <?php unset($_SESSION['ayardegis_durum'] ) ?>
    <?php }?>
    <?php if($_SESSION['ayardegis_durum'] == 'empty'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text34']?>
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
        <?php unset($_SESSION['ayardegis_durum'] ) ?>
    <?php }?>
    <?php if($_SESSION['ayardegis_durum'] == 'telefonhata'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text59']?>
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
        <?php unset($_SESSION['ayardegis_durum'] ) ?>
    <?php }?>
    <?php if($_SESSION['ayardegis_durum'] =='success'  ) {?>
        <div class="modal fade" id="okArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['users-text60']?>
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
        <?php unset($_SESSION['ayardegis_durum']); ?>
    <?php }?>

    <!--  <========SON=========>>> Account Alerts SON !-->


<!-- Şifre Alert !-->
    <?php if($_SESSION['sifredegis_durum'] == 'empty'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text34']?>
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
        <?php unset($_SESSION['sifredegis_durum'] ) ?>
    <?php }?>
    <?php if($_SESSION['sifredegis_durum'] == 'sifreayni'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text58']?>
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
        <?php unset($_SESSION['sifredegis_durum'] ) ?>
    <?php }?>
    <?php if($_SESSION['sifredegis_durum'] == 'sifrefarkli'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text56']?>
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
        <?php unset($_SESSION['sifredegis_durum'] ) ?>
    <?php }?>
    <?php if($_SESSION['sifredegis_durum'] == 'eskisifrefarkli'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text55']?>
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
        <?php unset($_SESSION['sifredegis_durum'] ) ?>
    <?php }?>
    <?php if($_SESSION['sifredegis_durum'] =='success'  ) {?>
        <div class="modal fade" id="okArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['users-text57']?>
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
        <?php unset($_SESSION['sifredegis_durum']); ?>
    <?php }?>
<!--  <========SON=========>>> Şifre Alert SON !-->



<?php }else { ?>
<?php
header('Location:'.$ayar['site_url'].'404');
?>
<?php }?>