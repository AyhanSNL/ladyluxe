<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='iletisim' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
$cagriTel = $ayar['site_musterihizmet_tel'];
$cagriTel = str_replace(' ', '', $cagriTel);
$siteTel = $ayar['site_tel'];
$siteTel = str_replace(' ', '', $siteTel);
$siteWP = $ayar['site_whatsapp'];
$siteWP = str_replace(' ', '', $siteWP);
$siteGsm = $ayar['site_gsm'];
$siteGsm = str_replace(' ', '', $siteGsm);
?>
<title><?php echo ucwords_tr($diller['iletisim-sayfasi-baslik']); ?> - <?php echo $ayar['site_baslik']?></title>
<meta name="description" content="<?php echo"$ayar[iletisim_sayfa_desc]" ?>">
<meta name="keywords" content="<?php echo"$ayar[iletisim_sayfa_tags]" ?>">
<meta name="news_keywords" content="<?php echo"$ayar[iletisim_sayfa_tags]" ?>">
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
<?php include 'includes/template/helper/page-headers-stil.php';  ?>


<!-- CONTENT AREA ============== !-->


<div id="MainDiv" style="background-color: #<?=$ayar['iletisim_sayfa_bg']?>; width: 100%; font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ; overflow: hidden  ">
    <?php if($pagehead['durum'] == '1' ) {?>
        <div class="page-banner-main" >
            <div class="page-banner-in-text">
                <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                    <?php echo ucwords_tr($diller['iletisim-sayfasi-baslik']); ?>
                </div>
                <div class="page-banner-links ">
                    <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                    <span style="font-weight: bold;">/</span>
                    <a>
                        <?php echo ucwords_tr($diller['iletisim-sayfasi-baslik']); ?>
                    </a>
                </div>
            </div>
            <?php if($pagehead['bg_tip'] == '0'  ) {?>
                <?php if($pagehead['bg_dark'] == '1'  ) { ?>
                    <!-- Karartma Var ise !-->
                    <div style="background: rgba(0,0,0,0.3); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                    <!-- Karartma Var ise !-->
                    <?php
                }}
            ?>
        </div>
    <?php }?>
<div class="iletisim-container-main">

    

    <?php if($ayar['iletisim_sayfa_nav'] == '1' ) {?>
      <?php include 'includes/template/helper/pages_nav/navigation.php'; ?>
    <?php }?>

    <div class="iletisim-container-in">

        <div class="iletisim-container-in-top row">

            <?php if($ayar['iletisim_sayfa_maps'] == !null   ) {?>
                <div class=" mb-md-4 col-md-12 " >
                    <iframe src="<?=$ayar['iletisim_sayfa_maps']?>"  frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
            <?php }?>


            <?php
            $iletisimBoxCek = $db->prepare("select * from iletisim_bilgileri where durum=:durum and dil=:dil order by sira asc");
            $iletisimBoxCek->execute(array(
                    'durum' => '1',
                    'dil' => $_SESSION['dil'],
            ));
            ?>

            <?php foreach ($iletisimBoxCek as $iletBox) {?>
                <div class=" mb-md-4 col-md-<?=$iletBox['col_md']?>" style="text-align: center;">
                    <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                            <i class="<?=$iletBox['ikon']?>"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h">
                            <?=$iletBox['baslik']?>
                        </div>
                        <div class="iletisim-container-in-top-box-s">
                            <?php if($iletBox['adres_url'] == !null ) {?>
                            <a href="<?=$iletBox['adres_url']?>">
                                <?php }?>
                                <?=$iletBox['icerik']?>
                                <?php if($iletBox['adres_url'] == !null ) {?>
                            </a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            <?php }?>




            <?php
            $SocialMedia = $db->prepare("select * from sosyal order by sira asc");
            $SocialMedia->execute();
            ?>

            <?php if($SocialMedia->rowCount()>'0'  ) {?>
                <div class=" mb-md-4 col-md-12" style="text-align: center; ">
                    <div class="iletisim-container-in-top-box iletisim-container-in-top-box-social-flex">
                        <?php foreach ($SocialMedia as $sosyal) {?>
                            <a href="<?=$sosyal['url']?>" target="_blank" class="iletisim-container-in-top-box-social" data-toggle="tooltip" data-placement="top" title="<?=$sosyal['baslik']?>">
                                <i class="fa <?=$sosyal['icon']?>"   ></i>
                            </a>
                        <?php }?>
                    </div>
                </div>
            <?php }?>

            <?php if($ayar['iletisim_sayfa_form'] == '1' ) {?>
            <?php if($diller['iletisim-sayfasi-aciklama'] == !null  ) {?>
                <div class=" mb-md-4 col-md-12" style="text-align: center; ">
                    <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-h">
                            <?=$diller['iletisim-sayfasi-aciklama']?>
                        </div>

                    </div>
                </div>
            <?php }}?>

            <?php
            $WorkHour = $db->prepare("select * from calisma_saatleri where dil=:dil ");
            $WorkHour->execute(array(
                    'dil' => $_SESSION['dil'],
            ));
            $work = $WorkHour->fetch(PDO::FETCH_ASSOC);
            ?>

            <?php if($work['icerik'] == !null   ) {?>
                <div <?php if($ayar['iletisim_sayfa_form'] == '1' ) { ?>class="col-md-3"<?php }else{?>class="col-md-12"<?php } ?>  style="text-align: center;">
                    <div class="iletisim-container-in-top-box">
                        <div class="iletisim-container-in-top-box-i">
                            <i class="las la-stopwatch"></i>
                        </div>
                        <div class="iletisim-container-in-top-box-h">
                            <?=$diller['iletisim-sayfasi-calisma-saatleri']?>
                        </div>
                        <div class="iletisim-container-in-top-box-s">
                            <?=$work['icerik']?>
                        </div>
                    </div>
                </div>
            <?php }?>


            <?php if($ayar['iletisim_sayfa_form'] == '1' ) {?>
            <div class="<?php if($work['icerik'] == null   ) { ?>col-md-12<?php }else{?>col-md-9<?php } ?>" style="text-align: center;">
                <form action="contactpost" method="post">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" name="isim"   class="form-control" placeholder="<?=$diller['iletisim-sayfasi-form-isim']?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" name="eposta"   class="form-control" placeholder="<?=$diller['iletisim-sayfasi-form-posta']?>"  autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" name="telno"   class="form-control" placeholder="<?=$diller['iletisim-sayfasi-form-tel']?>"  autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="text" name="konu"   class="form-control" placeholder="<?=$diller['iletisim-sayfasi-form-konu']?>"  autocomplete="off">
                        </div>
                        <div class="form-group col-md-12">
                            <textarea name="mesaj" class="form-control" rows="2" placeholder="<?=$diller['iletisim-sayfasi-form-mesaj']?>" ></textarea>
                        </div>
                        <?php if($ayar['site_captcha'] =='1' ) {?>
                            <div class="form-group col-md-6 " >
                                <div class="input-group mb-2 mr-sm-2" >
                                    <div class="input-group-prepend" >
                                        <div class="input-group-text" style="border-radius: 0!important;"><img  src='includes/template/captcha.php'/></div>
                                    </div>
                                    <input type="text" class="form-control " id="inputCaptcha"   name="secure_code" maxlength="5" style="flex:0; width:100px !important;"  >
                                </div>
                            </div>
                        <?php }?>
                        <div class="form-group col-md-12" style="text-align: right;" >
                            <button type="submit" id="shopButton" name="iletisimpost" class="button-red button-2x" style="font-weight: 300; width: 100%;  ">
                                <?=$diller['iletisim-sayfasi-form-gonder']?>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
            <?php }?>



        </div>


    </div>



</div>
</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php if($_SESSION['mesaj_sonuc'] == 'success') {?>

    <div class="modal fade" id="succesMessagePost" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
                    <div>
                        <?=$diller['alert-iletisim-success']?>
                    </div>
                    <div style="font-size: 12px; margin-top: 20px; line-height: 15px!important; color: #666;">
                        <?=$diller['alert-iletisim-success-aciklama']?>
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
    <?php unset($_SESSION['mesaj_sonuc']); ?>
<?php }?>

<?php if($_SESSION['mesaj_sonuc'] == 'bos') {?>
    <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
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
            $('#errorModal').modal('show');
        });
        $(window).load(function () {
            $('#errorModal').modal('show');
        });
        var $modalDialog = $("#errorModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['mesaj_sonuc']); ?>
<?php }?>
<?php if($_SESSION['mesaj_sonuc'] == 'epostasorun') {?>
    <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['alert-warning-eposta-hata']?>
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
            $('#errorModal').modal('show');
        });
        $(window).load(function () {
            $('#errorModal').modal('show');
        });
        var $modalDialog = $("#errorModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['mesaj_sonuc']); ?>
<?php }?>
<?php
if($_SESSION['mesaj_sonuc'] == 'secure') {
    ?>
    <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                    <div>
                        <?=$diller['alert-warning-captcha']?>
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
            $('#errorModal').modal('show');
        });
        $(window).load(function () {
            $('#errorModal').modal('show');
        });
        var $modalDialog = $("#errorModal");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['mesaj_sonuc']); ?>
<?php }?>
<?php if($_SESSION['mesaj_sonuc'] == 'wrong') {?>
    <script>
        $(document).ready(function () {
            swal({
                title: "<?=$diller['alert-warning']?>",
                type: "warning",
                animation: false,
                timer: '4500',
                showConfirmButton: true,
                confirmButtonText:"<?=$diller['alert-button-ok']?>",
            });
        });
    </script>
    <?php unset($_SESSION['mesaj_sonuc']); ?>
<?php }?>


<div id="shopButtonOverlay" style="font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ;">
    <div class="shopButtonT">
        <div><img src="images/load.svg" ></div>
        <div><?=$diller['teslimat-uye-text-4']?></div>
    </div>
</div>

<?php include "includes/config/footer_libs.php";?>

