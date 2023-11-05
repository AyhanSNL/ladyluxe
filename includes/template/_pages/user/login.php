<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($userSorgusu->rowCount()<='0' && $uyeayar['durum'] == '1'  ) {?>
<title><?php echo $diller['users-login-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
?>
<!-- CONTENT AREA ============== !-->

<div class="users_main_div" style="background-color: #<?=$uyeayar['detay_bg']?>;  font-family : '<?=$uyeayar['font_select']?>',sans-serif ; ">

    <div class="user_login_register_div">
        
        <!-- Header !-->
        <div class="user_page_header dis-mob">
            <i class="las la-user"></i> <?=$diller['users-text1']?>
        </div>
        <!--  <========SON=========>>> Header SON !-->

        <!-- Login Form !-->
        <div class="user_page_login_form">
            <div class=" teslimat-form-area">
                <form action="loginpage" method="post" >
                    <div class="row" >
                        <div class="form-group col-md-12">
                            <label for="emailadress" style="font-weight: 600;">* <?=$diller['users-text2']?></label>
                            <input type="email" name="emailadress" id="emailadress" required   class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="password" style="font-weight: 600;">* <?=$diller['users-text3']?></label>
                            <input type="password" name="password" id="password" required   class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group col-md-12 " >
                            <button name="userlogin" class="button-blue button-2x" style="width: 100%;  " ><?=$diller['users-text6']?></button>
                        </div>
                        <div class="form-group col-md-12" >
                            <a class="modal-in-login-form-reset-password" href="sifremi-unuttum/" ><?=$diller['users-text5']?></a>
                        </div>
                        <?php if($uyeayar['yeni_uyelik'] == '1'  ) {?>
                            <div class="form-group col-md-12 " style="margin-bottom: 0; margin-top: 10px; font-size: 14px ;">
                                <?=$diller['users-text7']?> <a href="uyelik/" style="font-weight: bold; color: #000;"><?=$diller['users-text8']?></a>
                            </div>
                        <?php }?>
                    </div>
                </form>
            </div>
        </div>
        <!--  <========SON=========>>> Login Form SON !-->

        <?php if($uyelerYazilar->rowCount()>'0' && $uyeyazi['login_text'] == !null  ) {?>
            <!-- Login Form Right Text !-->
            <div class="user_page_right_text_div">
                <?php
                $kaynak  = $uyeyazi['login_text'];
                $eski   = '../i';
                $yeni   = 'i/';
                $kaynak = str_replace($eski, $yeni, $kaynak);
                ?>
                <?=$kaynak?>
                <?php if($uyeayar['yeni_uyelik'] == '1'  ) {?>
                <div style="margin-top: 25px;">
                    <a href="uyelik/" class="button-green button-2x"><?=$diller['users-text9']?></a>
                </div>
                <?php } ?>
            </div>
            <!--  <========SON=========>>> Login Form Right Text SON !-->
        <?php }?>

        
    </div>


</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>

    <?php if($_SESSION['login_error'] == 'empty'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text11']?>
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
        <?php unset($_SESSION['login_error'] ) ?>
    <?php }?>
    <?php if($_SESSION['login_error'] == 'emailerror'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text11']?>
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
        <?php unset($_SESSION['login_error'] ) ?>
    <?php }?>
    <?php if($_SESSION['login_error'] == 'nouser'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text12']?>
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
        <?php unset($_SESSION['login_error'] ) ?>
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
                            <?=$diller['users-text51']?>
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
<?php }else { ?>
<?php
header('Location:'.$ayar['site_url'].'');
?>
<?php }?>