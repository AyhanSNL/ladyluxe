<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($userSorgusu->rowCount()<='0'  && $uyeayar['durum'] == '1' && $uyeayar['yeni_uyelik'] == '1' ) {?>
<title><?php echo $diller['users-register-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$islemayar[meta_desc]" ?>">
<meta name="keywords" content="<?php echo"$islemayar[tags]" ?>">
<meta name="news_keywords" content="<?php echo"$islemayar[tags]" ?>">
<meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
<meta name="robots" content="index follow">
<meta name="googlebot" content="index follow">
<meta property="og:type" content="website" />

<?php include "includes/config/header_libs.php";?>

</head>
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>

<?php
$uyelerYazilar = $db->prepare("select * from uyeler_yazilar where dil=:dil ");
$uyelerYazilar->execute(array(
    'dil' => $_SESSION['dil'],
));
$uyeyazi = $uyelerYazilar->fetch(PDO::FETCH_ASSOC);
$sozlesmeCek = $db->prepare("select * from htmlsayfa_sozlesmeler where tur=:tur and dil=:dil  ");
$sozlesmeCek->execute(array(
    'tur' => '2',
    'dil' => $_SESSION['dil']
));
$sozlesme = $sozlesmeCek->fetch(PDO::FETCH_ASSOC);
?>
<!-- CONTENT AREA ============== !-->

<div class="users_main_div" style="background-color: #<?=$uyeayar['detay_bg']?>;  font-family : '<?=$uyeayar['font_select']?>',sans-serif ; ">

    <div class="user_login_register_div">
        
        <!-- Header !-->
        <div class="user_page_header dis-mob">
            <?=$diller['users-text15']?>
        </div>
        <!--  <========SON=========>>> Header SON !-->

        <!-- Login Form !-->
        <div class="user_page_login_form">
            <div class="teslimat-form-area">
                <form action="registerpage" method="post" >
                    <?php if($uyeayar['basit_form'] == '0' ) {?>
                        <div class="register-page-uyelik-tipi-main uye-tipi">
                            <div class="register-page-uyelik-tipi-h">
                                <div class="register-page-uyelik-tipi-h-in">
                                    <?=$diller['users-text38']?>
                                </div>
                            </div>
                            <div class="register-page-uyelik-tipi ">
                                <div class="rdio rdio-primary font-14 ">
                                    <input name="uye_tip" value="1" id="1" type="radio" <?php if(!isset($_SESSION['form_temp_register']['tip'])  ) { ?>checked<?php }else{?><?php if($_SESSION['form_temp_register']['tip'] == '1'  ) { ?>checked<?php }?><?php } ?>>
                                    <label for="1"><?=$diller['users-text29']?></label>
                                </div>
                                <div class="rdio rdio-primary font-14">
                                    <input name="uye_tip" value="2" id="2" type="radio" <?php if($_SESSION['form_temp_register']['tip'] == '2'  ) { ?>checked<?php }?>>
                                    <label for="2"><?=$diller['users-text30']?></label>
                                </div>
                            </div>
                        </div>

                        <div class="uye-tipi-bireysel row" >

                        </div>

                        <div class="uye-tipi-kurumsal row" >
                            <!-- Kurumsal !-->
                            <div class="form-group col-md-12">
                                <label for="firma_unvan" style="font-weight: 600;"><?=$diller['users-text22']?></label>
                                <input type="text" name="firma_unvan" value="<?=$_SESSION['form_temp_register']['firma']?>"  id="firma_unvan"  class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="vergi_dairesi" style="font-weight: 600;"><?=$diller['users-text23']?></label>
                                <input type="text" name="vergi_dairesi" value="<?=$_SESSION['form_temp_register']['vd']?>"  id="vergi_dairesi"  class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="vergi_no" style="font-weight: 600;">* <?=$diller['users-text24']?></label>
                                <input type="number" name="vergi_no" value="<?=$_SESSION['form_temp_register']['vergino']?>"  id="vergi_no"  class="form-control" autocomplete="off">
                            </div>
                            <!-- Kurumsal SON !-->
                        </div>
                    <?php }?>
                    <div class="row" >
                        <div class="form-group col-md-12">
                            <label for="name" style="font-weight: 600;">* <?=$diller['users-text18']?></label>
                            <input type="text" name="name" id="name"  value="<?=$_SESSION['form_temp_register']['isim']?>"   class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="surname" style="font-weight: 600;">* <?=$diller['users-text19']?></label>
                            <input type="text" name="surname" id="surname"  value="<?=$_SESSION['form_temp_register']['soyisim']?>"   class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="emailadress" style="font-weight: 600;">* <?=$diller['users-text20']?></label>
                            <input type="text" name="emailadress" id="emailadress" value="<?=$_SESSION['form_temp_register']['eposta']?>"    class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="gsm" style="font-weight: 600;">* <?=$diller['users-text21']?></label>
                            <input type="number" name="gsm" id="gsm" value="<?=$_SESSION['form_temp_register']['telefon']?>"  class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12 password-absolute">
                            <label for="password" style="font-weight: 600;">* <?=$diller['users-text33']?></label>
                            <input id="password-field" type="password" name="password" id="password"    class="form-control" autocomplete="off">
                            <span  toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group col-md-12" style="margin-top: 15px;">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="sozlesme_onayi" value="1" class="custom-control-input" id="sozlesmeOnay"  >
                                <label class="custom-control-label" for="sozlesmeOnay" style="font-size: 14px ; ">
                                    <a  data-toggle="modal" data-target="#sozlesmeModal" style="color: #333; cursor: pointer ">
                                        <strong style="text-decoration: underline;"><?=$diller['users-text25']?></strong></a>
                                    <?=$diller['users-text26']?>
                                </label>
                            </div>
                        </div>
                        <?php if($uyeayar['sms_ekle'] == '1' ) {?>
                            <div class="form-group col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="smsonay" value="1" class="custom-control-input" id="smsonay"  checked>
                                    <label class="custom-control-label" for="smsonay" style="font-size: 14px ; ">
                                        <?=$diller['users-text52']?>
                                    </label>
                                </div>
                            </div>
                        <?php }?>
                        <?php if($uyeayar['eposta_ekle'] == '1' ) {?>
                            <div class="form-group col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="epostaonay" value="1" class="custom-control-input" id="epostaonay"  checked>
                                    <label class="custom-control-label" for="epostaonay" style="font-size: 14px ; ">
                                        <?=$diller['users-text27']?>
                                    </label>
                                </div>
                            </div>
                        <?php }?>
                        <div class="form-group col-md-12 ">
                            <button id="shopButton" name="register" class="button-blue button-2x" style="width: 100%; margin-top: 10px;  " ><?=$diller['users-text28']?></button>
                        </div>
                        <div class="form-group col-md-12 " style="margin-bottom: 0; margin-top: 10px; font-size: 14px ;">
                            <?=$diller['users-text16']?> <a href="uye-girisi/" style="font-weight: bold; color: #000;"><?=$diller['users-text17']?></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--  <========SON=========>>> Login Form SON !-->

        <?php if($uyelerYazilar->rowCount()>'0' && $uyeyazi['register_text'] == !null  ) {?>
            <!-- Login Form Right Text !-->
            <div class="user_page_right_text_div">
                <?php
                $kaynak  = $uyeyazi['register_text'];
                $eski   = '../i';
                $yeni   = 'i/';
                $kaynak = str_replace($eski, $yeni, $kaynak);
                ?>
                <?=$kaynak?>
            </div>
            <!--  <========SON=========>>> Login Form Right Text SON !-->
        <?php }?>

        
    </div>


</div>
<!-- CONTENT AREA ============== !-->

<!-- Sözleşme Modal !-->

<div class="modal " id="sozlesmeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalCenterTitle" style="font-weight: bold;">
                    <?=$sozlesme['baslik']?>
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 14px ;" >
                <?=$sozlesme['icerik']?>
            </div>
            <div class="modal-footer">
                <button type="button" class="button-black button-1x" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
            </div>
        </div>
    </div>
</div>
<!--  <========SON=========>>> Sözleşme Modal SON !-->


<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

<?php if($_SESSION['uyelik_durum'] == 'empty'  ) {?>
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
    <?php unset($_SESSION['uyelik_durum'] ) ?>
<?php }?>
<?php if($_SESSION['uyelik_durum'] == 'eposta'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                    <div>
                        <?=$diller['users-text35']?>
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
    <?php unset($_SESSION['uyelik_durum'] ) ?>
<?php }?>
<?php if($_SESSION['uyelik_durum'] == 'epostavar'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text36']?>
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
        <?php unset($_SESSION['uyelik_durum'] ) ?>
    <?php }?>
<?php if($_SESSION['uyelik_durum'] == 'sozlesme'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text37']?>
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
        <?php unset($_SESSION['uyelik_durum'] ) ?>
    <?php }?>

<?php }else { ?>
<?php
header('Location:'.$ayar['site_url'].'');
?>
<?php }?>

<script id="rendered-js">
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
/*  <========SON=========>>> Password See SON */
</script>
<div id="shopButtonOverlay" style="font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ;">
    <div class="shopButtonT">
        <div><img src="images/load.svg" ></div>
        <div><?=$diller['teslimat-uye-text-4']?></div>
    </div>
</div>