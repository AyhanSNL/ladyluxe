<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($userSorgusu->rowCount()<='0' && isset($_GET['hash'])  && $uyeayar['durum'] == '1'   ) {

    $hash = trim(strip_tags($_GET['hash']));

    $hashSorgu = $db->prepare("select * from uyeler_reset_sifre where kod=:kod and durum=:durum ");
    $hashSorgu->execute(array(
            'kod' => $hash,
            'durum' => '0'
    ));


    ?>
    <?php if($hashSorgu->rowCount()>'0'  ) {?>
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
                <form action="remembernewpassword" method="post" >
                    <input type="hidden" name="hash" value="<?=$hash?>">
                    <div class="row" >
                        <div class="form-group col-md-12 password-absolute">
                            <label for="password" style="font-weight: 600;">* <?=$diller['users-text47']?></label>
                            <input id="password-field" type="password" name="yenisifre" id="password"  required   class="form-control" autocomplete="off">
                            <span  toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group col-md-12 password-absolute">
                            <label for="password2" style="font-weight: 600;">* <?=$diller['users-text48']?></label>
                            <input id="password-field2" type="password" name="yenisifre_tekrar" id="password2"  required   class="form-control" autocomplete="off">
                            <span  toggle2="#password-field2" class="fa fa-fw fa-eye field-icon2 toggle-password2"></span>
                        </div>
                        <div class="form-group col-md-12 " >
                            <button name="newPassword"  class="button-blue button-2x" style="width: 100%;  " ><?=$diller['users-text49']?></button>
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
        <script id="rendered-js">
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
            /*  <========SON=========>>> Password See SON */
        </script>
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
<?php if($_SESSION['sifredegis_durum'] == 'sifrefarkli'  ) {?>
    <div class="modal fade" id="noArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                    <div>
                        <?=$diller['users-text50']?>
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
    <?php }else { ?>
        <?php
        header('Location:'.$ayar['site_url'].'');
        ?>
    <?php }?>
<?php }else { ?>
<?php
header('Location:'.$ayar['site_url'].'');
?>
<?php }?>