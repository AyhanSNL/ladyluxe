<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($userSorgusu->rowCount()<='0'  && $uyeayar['durum'] == '1'  ) {?>
<title><?php echo $diller['users-sifremi-unuttum-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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


<!-- CONTENT AREA ============== !-->

<div class="users_main_div" style="background-color: #<?=$uyeayar['detay_bg']?>;  font-family : '<?=$uyeayar['font_select']?>',sans-serif ; ">

    <div class="user_login_register_div">
        
        <!-- Header !-->
        <div class="user_page_header">
           <?=$diller['users-text39']?>
        </div>
        <!--  <========SON=========>>> Header SON !-->


        <div class="user_page_login_form">
            <div class=" teslimat-form-area">
                <form action="rememberpassword" method="post" >
                    <div class="row" >
                        <div class="form-group col-md-12">
                            <label for="emailadress" style="font-weight: 600;">* <?=$diller['users-text2']?></label>
                            <input type="text" name="emailadress" id="emailadress" class="form-control" autocomplete="off">
                        </div>
                        <?php if($ayar['smtp_durum'] == '1' ) {?>
                            <div class="form-group col-md-12 " >
                                <button id="shopButton"  class="button-blue button-2x" style="width: 100%;  " ><?=$diller['users-text40']?></button>
                            </div>
                        <?php }else { ?>
                            <div class="form-group col-md-12 " >
                                <a class="button-blue button-2x" href="#"   data-toggle="modal" data-target="#hata" style="width: 100%; text-align: center; "><?=$diller['users-text40']?></a>
                            </div>
                            <div class="modal fade" id="hata" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered  " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="exampleModalCenterTitle" style="font-weight: bold;">
                                                <?=$diller['users-text44']?>
                                            </h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="font-size: 14px ;" >
                                            <?=$diller['users-text45']?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="button-black button-1x" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                    <div class="register-page-uyelik-tipi-main uye-tipi" style="margin-top: 25px; margin-bottom: 0;" >
                        <div class="register-page-uyelik-tipi-h">
                            <div class="register-page-uyelik-tipi-h-in" >
                                <?=$diller['users-text41']?>
                            </div>
                        </div>
                        <div style="font-size: 13px ; margin-bottom: 10px;">
                            <?=$diller['users-text42']?>
                        </div>
                    </div>
                </form>
            </div>
        </div>




        
    </div>


</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>
    <div id="shopButtonOverlay" style="font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ;">
        <div class="shopButtonT">
            <div><img src="images/load.svg" ></div>
            <div><?=$diller['teslimat-uye-text-4']?></div>
        </div>
    </div>
<?php if($_SESSION['epostasifirla_durum'] == 'empty'  ) {?>
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
    <?php unset($_SESSION['epostasifirla_durum'] ) ?>
<?php }?>
<?php if($_SESSION['epostasifirla_durum'] == 'emailerror'  ) {?>
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
    <?php unset($_SESSION['epostasifirla_durum'] ) ?>
<?php }?>
<?php if($_SESSION['epostasifirla_durum'] == 'nouser'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                    <div>
                        <?=$diller['users-text43']?>
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
    <?php unset($_SESSION['epostasifirla_durum'] ) ?>
<?php }?>
<?php if($_SESSION['epostasifirla_durum'] =='success'  ) {?>
        <div class="modal fade" id="okArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['users-text46']?>
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
        <?php unset($_SESSION['epostasifirla_durum']); ?>
<?php }?>
<?php }else { ?>
<?php
header('Location:'.$ayar['site_url'].'');
?>
<?php }?>