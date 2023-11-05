<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($odemeayar['sepet_sistemi'] == '1' ) {?>
    <?php
    $page_header_setting = $db->prepare("select * from page_header where page_id='cart' order by id");
    $page_header_setting->execute();
    $pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
    include 'includes/func/cartcalc.php';
    ?>
    <title><?=$diller['sepet-sayfa-baslik']?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="description" content="<?php echo"$ayar[site_desc]" ?>">
    <meta name="keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="news_keywords" content="<?php echo"$ayar[site_tags]" ?>">
    <meta name="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta itemprop="author" content="<?php echo"$ayar[site_baslik]" ?>" />
    <meta name="robots" content="index follow">
    <meta name="googlebot" content="index follow">
    <meta property="og:type" content="website" />

    <?php include "includes/config/header_libs.php";?>

    </head>
    <div>
        <?php include 'includes/template/pre-loader.php'?>
        <?php include 'includes/template/header.php'?>
        <?php include 'includes/template/helper/page-headers-stil.php';  ?>
        <style>
            .tooltip{
                font-size: 12px !important ;
            }
            .cart-main-div{
                font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
            }
            .no-cart-items-main-div{
                font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
                background-color: #<?=$odemeayar['alisveris_arkaplan']?>;
            }
            .no-cart-items-main-div a{
                font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
            }
        </style>
        <!-- CONTENT AREA ============== !-->
        <?php
        $ipcek = $_SERVER["REMOTE_ADDR"];
        $sepetteUrun = $db->prepare("select * from sepet where ip=:ip  ");
        $sepetteUrun->execute(array(
            'ip' => $ipcek,
        ));

        $aktifSepet = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum  ");
        $aktifSepet->execute(array(
            'ip' => $ipcek,
            'sepet_durum' => '1'
        ));
        ?>
        <?php if($sepetteUrun->rowCount() >'0') {?>
            <div style="width: 100%; background-color: #<?=$odemeayar['alisveris_arkaplan']?>; overflow: hidden">
                <?php if($pagehead['durum'] == '1' ) {?>
                    <div class="page-banner-main" >
                        <div class="page-banner-in-text">
                            <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                                <?=$diller['sepet-sayfa-baslik']?>
                            </div>
                            <div class="page-banner-links ">
                                <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                                <span>/</span>
                                <a><?=$diller['sepet-sayfa-baslik']?></a>
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
                <div class="cart-main-div" >
                    <!-- Ücretsiz Kargo Bilgilendirmesi !-->
                    <?php  if($odemeayar['kargo_sistemi'] == '1' && $odemeayar['kargo_limit_sepet'] == '1' && $kargotoplami>'0' ) {
                        if($odemeayar['kargo_limit'] > '0' && $odemeayar['kargo_limit'] == !null ){
                            ?>
                            <div class=" <?=$odemeayar['kargo_limit_sepet_button']?> <?=$odemeayar['kargo_limit_sepet_button_size']?>" style="text-align: center; width: 100%; margin-bottom: 20px; " >
                                <i class="fa fa-gift" style="font-size: 35px ;"></i>
                                <br>
                                <?=kur_cekimi($odemeayar['kargo_limit'])?>
                                <?=$diller['kargo-limit-aciklamasi']?>
                            </div>
                        <?php }} ?>
                    <!-- Ücretsiz Kargo Bilgilendirmesi SON !-->
                    <div class="cart-left-div">
                        <div id="output"></div>
                    </div>
                    <div class="cart-right-div">
                        <?php include 'includes/template/helper/cart/cart-onay-alani.php'; ?>
                    </div>
                </div>
            </div>
        <?php }else { ?>
            <div class="no-cart-items-main-div">
                <div class="no-cart-items-in-div">
                    <i class="ion-bag" style="font-size: 45px ;"></i>
                    <div class="no-cart-items-text-h">
                        <?=$diller['sepet-bos']?>
                    </div>
                    <div class="no-cart-items-text">
                        <?=$diller['sepet-bos-text']?>
                    </div>
                    <a href="<?=$ayar['site_url']?>" class="button-blue button-2x" ><?=$diller['sepet-alisverise-basla']?></a>
                </div>
            </div>
        <?php }?>
    </div>
    <!-- CONTENT AREA ============== !-->
    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
    <?php include "includes/config/footer_libs.php";?>
    <style>
        .modal-content {
            border:1px solid #FFF !important;
            box-sizing: border-box !important;
            background-clip: border-box !important;
        }
        .modal-footer{
            border-top: 1px solid #ebebeb !important;
        }
    </style>
    <div class="modal " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <div style="position: absolute; z-index: 9; right: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                        <i class="ion-ios-close-empty"></i>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">
                    <?=$diller['sepet-sil-uyari']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-green button-2x"   data-dismiss="modal"><?=$diller['sepet-sil-uyari-iptal']?></button>
                    <a class="button-red button-2x btn-ok" ><i class="fa fa-trash-o"></i> <?=$diller['sepet-sil-uyari-onayla']?></a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('a[data-confirm]').click(function(ev) {
                var href = $(this).attr('href');

                if (!$('#dataConfirmModal').length) {
                    $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Please Confirm</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">OK</a></div></div>');
                }
                $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
                $('#dataConfirmOK').attr('href', href);
                $('#dataConfirmModal').modal({show:true});
                return false;
            });
        });
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
    <?php  if($odemeayar['sepet_urunfiyat_uyari'] == '1' || $odemeayar['sepet_urunfiyat_uyari'] == '2' ) {?>
        <!-- Değişen Fiyat Uyarısı !-->
        <?php
        $degisenFiyatUrunGoster = $db->prepare("select * from sepet where ip=:ip and fiyat_durum=:fiyat_durum and sepet_durum=:sepet_durum and uye_ozel_fiyat=:uye_ozel_fiyat group by urun_id");
        $degisenFiyatUrunGoster->execute(array(
            'ip' => $ipcek,
            'fiyat_durum' => '1',
            'sepet_durum' => '1',
            'uye_ozel_fiyat' => '0',
        ));
        ?>
        <?php if($degisenFiyatUrunGoster->rowCount()>'0'  ) {?>
            <div class="modal fade" id="fiyatdegisti" >
                <div class="modal-dialog modal-dialog-centered modal-lg ">
                    <div class="modal-content" >
                        <div class="sepet-return-modal">
                            <div class="sepet-return-alert" style="background-color: indianred; padding: 30px 0;" >
                                <i class="las la-info-circle"></i> <?=$diller['sepet-fiyat-degisim-uyarisi']?>
                            </div>
                            <?php if($odemeayar['sepet_urunfiyat_uyari'] == '1') {?>
                                <?php foreach ($degisenFiyatUrunGoster as $degfiyat) {
                                    $urunbilgisi = $db->prepare("select * from urun where id=:id and durum=:durum ");
                                    $urunbilgisi->execute(array(
                                        'id' => $degfiyat['urun_id'],
                                        'durum' => '1'
                                    ));
                                    $degurun = $urunbilgisi->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <div class="sepet-return-product">
                                        <div class="sepet-return-product-left" >
                                            <div class="sepet-return-product-img">
                                                <img src="images/product/<?=$degurun['gorsel']?>" alt="<?=$degurun['baslik']?>">
                                            </div>
                                            <div class="sepet-return-product-head" >
                                                <div>
                                                    <?=$degurun['baslik']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sepet-return-product-quantity" style="text-align: right;">
                                            <div >
                                                <div style="font-weight: 400; font-size: 13px; margin-top: 10px;">
                                                    <?=$diller['sepet-fiyat-degisim-uyarisi-2']?> :
                                                    <?=kur_cekimi($degfiyat['fiyat_eski'])?>
                                                    <?php if($icerik['kdv'] == '1' ) {?>
                                                        <?=$diller['urunler-arti-kdv']?>
                                                    <?php }?>

                                                </div>
                                                <div style="font-weight: 700; font-size: 15px ; margin-top: 3px;">
                                                    <?=$diller['sepet-fiyat-degisim-uyarisi-3']?> :
                                                    <?=kur_cekimi($degurun['fiyat']+$degfiyat['ek_fiyat_tekil'])?>
                                                    <?php if($icerik['kdv'] == '1' ) {?>
                                                        <?=$diller['urunler-arti-kdv']?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            <?php }?>
                        </div>

                        <div class="urundetay-cart-add-success-modal-footer">
                            <a data-dismiss="modal" role="button" href="" class="button-2x button-black" >
                                <?=$diller['alert-button-ok']?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(window).on("load", function() {
                    $('#fiyatdegisti').modal('show');
                });
                $(window).load(function () {
                    $('#fiyatdegisti').modal('show');
                });
                var $modalDialog = $("#fiyatdegisti");
                $modalDialog.modal('show');

                setTimeout(function() {
                    $modalDialog.modal('hide');
                }, 0);
            </script>
        <?php }?>
        <!-- Değişen Fiyat Uyarısı SON !-->
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'empty'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'error'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama']?>
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'nologin'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama2']?>
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'nokupon'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama3']?>
                        </div>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center;" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(window).on("load", function() {
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'adetsizkupon'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama4']?>
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'baslangicsorun'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama5']?>
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'bitissorun'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama6']?>
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'sepetsorun'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama7']?>
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');


        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'baskauye'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama8']?>
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');

        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'kullanilmis'  ) {?>
        <div class="modal fade" id="warningCoupom" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-hata-aciklama10']?>
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
                $('#warningCoupom').modal('show');
            });
            $(window).load(function () {
                $('#warningCoupom').modal('show');
            });
            var $modalDialog = $("#warningCoupom");
            $modalDialog.modal('show');


        </script>
        <?php unset($_SESSION['sepet_modal'] ) ?>
    <?php }?>
    <?php if($_SESSION['sepet_modal'] == 'success') {?>
        <div class="modal fade" id="successCoupon" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
                        <?=$diller['alert-kupon-kodu-basarili']?>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(window).on("load", function() {
                $('#successCoupon').modal('show');
            });
            $(window).load(function () {
                $('#successCoupon').modal('show');
            });
            var $modalDialog = $("#successCoupon");
            $modalDialog.modal('show');
        </script>
        <?php unset($_SESSION['sepet_modal']); ?>
    <?php }?>
    <?php if($_SESSION['kupon_sil'] == 'success') {?>
        <div class="modal fade" id="deleteCoupon" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
                        <?=$diller['sepet-indirim-kupon-sil-ok']?>
                    </div>
                    <div class="category-cart-add-success-modal-footer">
                        <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(window).on("load", function() {
                $('#deleteCoupon').modal('show');
            });
            $(window).load(function () {
                $('#deleteCoupon').modal('show');
            });
            var $modalDialog = $("#deleteCoupon");
            $modalDialog.modal('show');
        </script>
        <?php unset($_SESSION['kupon_sil']); ?>
    <?php }?>
    <?php if($_SESSION['addtocart'] == 'nomorestok'  ) {?>
        <div class="modal fade" id="noStok" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div>
                            <?=$diller['urun-stok-asma-2']?>
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
<?php }else { ?>
    <?php
    header('Location:'.$siteurl.'404');
    ?>
<?php }?>
<style>
    .shopButtonT{
        font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
    }
</style>
<div id="shopButtonOverlay">
    <div class="shopButtonT">
        <div><img src="images/load.svg" alt=""></div>
        <div><?=$diller['teslimat-uye-text-4']?></div>
    </div>
</div>
<script type="text/javascript">
    function getPage(id) {
        $('#output').html('<div style="width: 100%; height: 200px; display: flex; align-items : center; justify-content: center; background-color: #fff; text-align: center;"><img src="images/spiner.gif" style="width: 30px" /></div>');
        jQuery.ajax({
            url: "cart-test",
            success:function(data){$('#output').html(data);}
        });
    }
    getPage(1);
</script>