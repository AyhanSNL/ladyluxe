<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['iptal_alani'] == '1') {
    $talepNO = htmlspecialchars($_GET['talepNO']);
    $iadeKontrol = $db->prepare("select * from siparis_urunler_iade where talep_no=:talep_no and uye_id=:uye_id ");
    $iadeKontrol->execute(array(
        'talep_no' => $talepNO,
        'uye_id' => $userCek['id']
    ));
    $row = $iadeKontrol->fetch(PDO::FETCH_ASSOC);
    if($iadeKontrol->rowCount()<='0'  ) {
        header('Location:'.$ayar['site_url'].'404');
    }
    $userpage = 'iptal';

    $urunSorgusu = $db->prepare("select * from siparis_urunler where id=:id ");
    $urunSorgusu->execute(array(
        'id' => $row['urun_id']
    ));
    $urunRow = $urunSorgusu->fetch(PDO::FETCH_ASSOC);

    $urunSorgusu = $db->prepare("select gorsel,baslik,seo_url,id,gorunmez from urun where id=:id ");
    $urunSorgusu->execute(array(
        'id' => $urunRow['urun_id']
    ));
    $urunRow = $urunSorgusu->fetch(PDO::FETCH_ASSOC);

    $sipariscek = $db->prepare("select parabirimi,odeme_tur from siparisler where siparis_no=:siparis_no ");
    $sipariscek->execute(array(
        'siparis_no' => $row['siparis_no']
    ));
    $siparis = $sipariscek->fetch(PDO::FETCH_ASSOC);

    /* IBAN Eklet */
    if(isset($_POST['iban_request'])  ) {
        if($_POST['iban_request'] == '1'  ) {
            if($_POST) {
                if(isset($_POST['iban_request_form'])  ) {
                    $iban_number = trim(strip_tags($_POST['iban_number']));
                    $iban_name = trim(strip_tags($_POST['iban_name']));
                    $siparisUrun_ID = trim(strip_tags($_POST['requestid']));
                    if($demo != '1'  ){
                        if($siparisUrun_ID  ) {
                            if($iban_number && $iban_name) {
                                $talepKontrol = $db->prepare("select * from siparis_urunler_iade where talep_no=:talep_no and uye_id=:uye_id ");
                                $talepKontrol->execute(array(
                                    'talep_no' => $siparisUrun_ID,
                                    'uye_id' => $userCek['id']
                                ));
                                $talepRow = $talepKontrol->fetch(PDO::FETCH_ASSOC);
                                if($talepKontrol->rowCount()>'0'  ) {
                                    $guncelle = $db->prepare("UPDATE siparis_urunler_iade SET
                                     iban=:iban,
                                     iban_isim=:iban_isim
                                      WHERE talep_no={$siparisUrun_ID}      
                                     ");
                                    $sonuc = $guncelle->execute(array(
                                        'iban' => $iban_number,
                                        'iban_isim' => $iban_name
                                    ));
                                    if($sonuc){
                                        header('Location:'.$ayar['site_url'].'hesabim/iade-talebi/'.$siparisUrun_ID.'/?process=account');
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }else{
                                header('Location:'.$ayar['site_url'].'hesabim/iade-talebi/'.$siparisUrun_ID.'/?process=shipping');
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        $_SESSION['demo_alert'] = 'demo';
                        header('Location:'.$ayar['site_url'].'hesabim/iade-talebi/'.$siparisUrun_ID.'/?process=account');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }
    /*  <========SON=========>>> IBAN Eklet SON */

    /* Kargo bilgisi ekle */
    if(isset($_POST['shipping_request'])  ) {
        if($_POST['shipping_request'] == '1'  ) {
            if($_POST) {
                if(isset($_POST['cargo_information_button'])  ) {
                    $kargoAdi = trim(strip_tags($_POST['cargo_name']));
                    $kargoTakip = trim(strip_tags($_POST['cargo_track']));
                    $siparisUrun_ID = trim(strip_tags($_POST['requestid']));
                    if($demo != '1'  ){
                        if($siparisUrun_ID  ) {

                            if(!$kargoAdi  || !$kargoTakip  ) {
                                header('Location:'.$ayar['site_url'].'hesabim/iade-talebi/'.$siparisUrun_ID.'/?process=shippingRequestError');
                                exit();
                            }

                            if($kargoAdi && $kargoTakip) {
                                $talepKontrol = $db->prepare("select * from siparis_urunler_iade where talep_no=:talep_no and uye_id=:uye_id ");
                                $talepKontrol->execute(array(
                                    'talep_no' => $siparisUrun_ID,
                                    'uye_id' => $userCek['id']
                                ));
                                $talepRow = $talepKontrol->fetch(PDO::FETCH_ASSOC);
                                if($talepKontrol->rowCount()>'0'  ) {
                                    if($talepRow['kargo_firma'] == null && $talepRow['kargo_takip'] == null ) {
                                        $guncelle = $db->prepare("UPDATE siparis_urunler_iade SET
                                     kargo_firma=:kargo_firma,
                                     kargo_takip=:kargo_takip
                              WHERE talep_no={$siparisUrun_ID}      
                             ");
                                        $sonuc = $guncelle->execute(array(
                                            'kargo_firma' => $kargoAdi,
                                            'kargo_takip' => $kargoTakip
                                        ));
                                        if($sonuc){
                                            if($ayar['smtp_durum'] == '1' ) {
                                                include 'includes/post/mailtemp/users/urun_iade_kargo_temp.php';
                                            }
                                            header('Location:'.$ayar['site_url'].'hesabim/iade-talebi/'.$siparisUrun_ID.'/?process=shipping');
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                    }else{
                                        header('Location:'.$ayar['site_url'].'404');
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }else{
                                header('Location:'.$ayar['site_url'].'hesabim/iade-talebi/'.$siparisUrun_ID.'/?process=shipping');
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        $_SESSION['demo_alert'] = 'demo';
                        header('Location:'.$ayar['site_url'].'hesabim/iade-talebi/'.$siparisUrun_ID.'/?process=shipping');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }
    /*  <========SON=========>>> Kargo bilgisi ekle SON */

    ?>
    <title>#<?=$row['talep_no']?> <?php echo $diller['users-panel-text202']; ?> - <?php echo $ayar['site_baslik']?></title>
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
                <a href="hesabim/iptal-iade-talepleri/"><?=$diller['users-panel-baglanti-text15']?></a>
                <i class="las la-angle-double-right"></i>
                <a href="hesabim/iade-talepleri/"><?=$diller['users-panel-baglanti-text16']?></a>
                <i class="las la-angle-double-right"></i>
                <a href="javascript:Void(0)">#<?=$row['talep_no']?> <?php echo $diller['users-panel-text202']; ?></a>
            </div>
            <!--  <========SON=========>>> Header SON !-->
            <?php include 'includes/template/helper/users/leftbar.php'; ?>

            <!-- Right Content !-->
            <div class="user_subpage_coupon_content">

                <!-- Head !-->
                <div class="user_subpage_flex_header" style="flex-direction: column">
                    <div class="user_subpage_flex_header_back_href">
                        <?=$diller['users-panel-text66']?>
                        <a href="hesabim/iade-talepleri/">
                            <?=$diller['users-panel-text67']?>
                        </a>
                    </div>
                    <div class="user_subpage_flex_header_h">
                        #<?=$row['talep_no']?> <?php echo $diller['users-panel-text202']; ?>
                    </div>
                </div>
                <!--  <========SON=========>>> Head SON !-->



                <div class="row rounded mb-3" style="border: 1px solid #EBEBEB;  padding-top: 20px; margin-right: 0;    margin-left: 0; ">
                    <div class="form-group col-md-4 ticket-detail-form-area">
                        <label ><?=$diller['users-panel-text102']?></label><br>
                        <?=$row['siparis_no']?>
                    </div>
                    <div class="form-group col-md-4 ticket-detail-form-area">
                        <label ><?=$diller['users-panel-text175']?></label><br>
                        <?=$row['talep_no']?>
                    </div>
                    <div class="form-group col-md-4 ticket-detail-form-area">
                        <label ><?=$diller['users-panel-text176']?></label><br>
                        <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                    </div>
                    <div class="form-group col-md-4 ticket-detail-form-area">
                        <label ><?=$diller['users-panel-text169']?></label><br>
                        <?=$row['sebep']?>
                    </div>
                </div>

                <?php if($urunSorgusu->rowCount()>'0'  ) {?>
                    <div class="rounded w-100 p-3 d-flex align-items-center justify-content-start flex-wrap mb-3" style="border: 1px solid #EBEBEB;">
                        <div class="return-pro-img">
                            <?php if($urunRow['gorsel'] == !null  ) {?>
                                <img src="images/product/<?=$urunRow['gorsel']?>">
                            <?php }else { ?>
                                <img src="images/product/no-img.jpg">
                            <?php }?>
                        </div>
                        <div class="return-pro-txt">
                            <?php if($urunRow['gorunmez'] == '0' ) {?>
                                <a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" target="_blank" style="text-decoration: none;">
                                    <i class="fa fa-external-link"></i>
                                </a>
                            <?php }?>
                            <?=$urunRow['baslik']?>
                        </div>
                    </div>
                <?php }?>

                <?php if($row['durum'] == '0' ) {?>
                    <div class="w-100" >
                        <!-- İptal Durum !-->
                        <div class="button-blue-out button-1x rounded" style="font-size: 13px ; font-weight: 600 !important;">
                            <?=$diller['users-panel-text203']?>
                        </div>
                        <!--  <========SON=========>>> İptal Durum SON !-->
                        <!-- Description !-->
                        <div class="w-100 p-3 rounded mt-3 up-arrow-blue" style="border:1px solid #558cff; font-size: 13px ; color: #6A7FA9; line-height:22px; position: relative ">
                            <?=$diller['users-panel-text204']?>
                        </div>
                        <!--  <========SON=========>>> Description SON !-->
                    </div>
                <?php }?>

                <?php if($row['durum'] == '1' ) {?>
                    <div class="w-100 mb-3" >
                        <!-- İptal Durum !-->
                        <div class="button-green-out button-1x rounded" style="font-size: 13px ; font-weight: 700 !important; padding-left: 20px; padding-right: 20px;">
                            <?=$diller['users-panel-text200']?>
                        </div>
                        <!--  <========SON=========>>> İptal Durum SON !-->
                        <!-- Description !-->
                        <div class="w-100 p-3 rounded mt-3 up-arrow-green" style="border:1px solid #279c3d; font-size: 13px ; color: #3E7C58; line-height:22px; position: relative ">
                            <strong><?=$diller['users-panel-text205']?></strong>
                            <?php if($row['durum_kargo'] == '1'  ) {?>
                                <div class="mt-2" style="font-size: 12px ; line-height: 14px">
                                   <i class="fa fa-dot-circle-o" style="float: left ; margin-right: 8px; margin-bottom: 10px;"></i> <?=$diller['users-panel-text206']?>
                                </div>
                            <?php }?>
                            <?php if($siparis['odeme_tur'] == '2' && $row['iban_iste'] == '1') {?>
                                <div class="mt-2" style="font-size: 12px ; line-height: 14px">
                                    <i class="fa fa-dot-circle-o" style="float: left ; margin-right: 8px; margin-bottom: 10px;"></i> <?=$diller['users-panel-text223']?>
                                </div>
                            <?php }?>
                        </div>
                        <!--  <========SON=========>>> Description SON !-->
                    </div>

                <?php if($siparis['odeme_tur'] == '2' && $row['iban_iste'] == '1') {?>
                    <div class="rounded w-100 p-3 kargo-form-user mb-3 scroll-account" style="border: 1px solid #EBEBEB; background-color: #f8f8f8;">
                        <div class="iban-user-area-heading">
                            <?=$diller['users-panel-text222']?>
                        </div>
                        <form class="iban-user-area-form" method="post" action="">
                            <input type="hidden" name="iban_request" value="1" >
                            <input type="hidden" name="requestid" value="<?=$row['talep_no']?>" >
                            <input type="text" name="iban_number"  autocomplete="off" value="<?=$row['iban']?>" required placeholder="<?=$diller['users-panel-text224']?>"  class="form-control user-iban-control">
                            <input type="text" name="iban_name"  autocomplete="off" value="<?=$row['iban_isim']?>" required placeholder="<?=$diller['users-panel-text225']?>"  class="form-control user-iban-name-control">
                            <?php if($row['iban'] == null && $row['iban_isim'] == null) {?>
                                <button class="button-blue button-1x" name="iban_request_form">
                                    <?=$diller['users-panel-text213']?>
                                </button>
                            <?php }else { ?>
                                <button class="button-blue button-1x" name="iban_request_form">
                                    <?=$diller['users-panel-text226']?>
                                </button>
                            <?php }?>

                        </form>
                    </div>

                <?php if ($_GET['process'] == 'account') { ?>
                    <script>
                        $(function () {
                            $('html, body').animate({
                                scrollTop: $('.scroll-account').offset().top
                            }, 300);
                            return false;
                        });
                    </script>
                <?php } ?>
                <?php }?>

                <?php if($row['durum_kargo'] == '1'  ) {
                $kargolar = $row['kargo_idler'];
                $kargolar_select = $row['kargo_idler'];
                ?>
                <?php if($row['kargo_takip'] == !null && $row['kargo_takip'] == !null ) {?>
                    <div class="rounded w-100 p-3 kargo-form-user mb-3 scroll-process" style="border: 1px solid #EBEBEB;">
                        <div class="kargo-form-user-ok-value">
                            <?=$diller['users-panel-text214']?>
                            <div style="font-weight: 400;">
                                <?=$row['kargo_firma']?>
                            </div>
                        </div>
                        <div class="kargo-form-user-ok-value text-uppercase">
                            <?=$diller['users-panel-text212']?>
                            <div style="font-weight: 400;">
                                <?=$row['kargo_takip']?>
                            </div>
                        </div>
                        <div class="kargo-form-user-ok-right rounded ">
                            <?=$diller['users-panel-text215']?>
                        </div>
                    </div>
                <?php if ($_GET['process'] == 'shipping') { ?>
                    <script>
                        $(function () {
                            $('html, body').animate({
                                scrollTop: $('.scroll-process').offset().top
                            }, 300);
                            return false;
                        });
                    </script>
                <?php } ?>
                <?php }else { ?>
                    <div class="rounded w-100 p-3 kargo-form-user mb-3 " style="border: 1px solid #EBEBEB;">
                        <div class="kargo-form-user-h">
                            <?=$diller['users-panel-text209']?>
                            <div style="font-size: 11px ; color: #999; font-weight: 200;">
                                <?=$diller['users-panel-text210']?>
                            </div>
                        </div>
                        <form class="kargo-form-user-inputarea" method="post" action="" id="returnShipping">
                            <input type="hidden" name="shipping_request" value="1" >
                            <input type="hidden" name="requestid" value="<?=$row['talep_no']?>" >
                            <input type="hidden" name="cargo_information_button" value="<?=$row['talep_no']?>" >
                            <?php
                            $explodEtSelect = $kargolar_select;
                            $explodEtSelect = explode(',', $explodEtSelect);
                            ?>
                            <select name="cargo_name" class="form-control" >
                                <option value=""><?=$diller['users-panel-text211']?></option>
                                <?php foreach ($explodEtSelect as $kargokeyselect) {
                                    $kargoCekSelect = $db->prepare("select baslik from kargo_firma where id=:id and durum=:durum ");
                                    $kargoCekSelect->execute(array(
                                        'id' => $kargokeyselect,
                                        'durum' => '1'
                                    ));
                                    $kargoRowSelect = $kargoCekSelect->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                    <?php if($kargoCekSelect->rowCount()>'0'  ) {?>
                                        <option value="<?=$kargoRowSelect['baslik']?>"><?=$kargoRowSelect['baslik']?></option>
                                    <?php }?>
                                <?php }?>
                            </select>
                            <input type="text" name="cargo_track"  autocomplete="off"  placeholder="<?=$diller['users-panel-text212']?>"  class="form-control">
                            <button id="btnShipping" class="button-blue button-1x" name="">
                                <?=$diller['users-panel-text213']?>
                            </button>
                        </form>
                    </div>
                    <script>
                        $("#btnShipping").click(function () {
                            $(this).text("<?=$diller['users-panel-text165']?>");
                        });
                        $('#returnShipping').bind('submit', function (e) {
                            var button = $('#btnShipping');
                            button.prop('disabled', true);
                            var valid = true;
                            if (!valid) {
                                e.preventDefault();
                                button.prop('disabled', false);
                            }
                        });
                    </script>
                <?php if ($_GET['process'] == 'shippingRequestError') { ?>
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
                <?php
                header('Refresh:2; url='.$ayar['site_url'].'hesabim/iade-talebi/'.$talepNO.'/');
                } ?>
                <?php }?>


                <?php if($kargolar == !null || $row['adres'] == !null ) {?>
                    <div class="user-kargo-return-main mb-3" >
                        <?php if($kargolar == !null  ) {?>
                            <div class="user-kargo-return-left rounded">
                                <div class="user-kargo-return-heading">
                                    <?=$diller['users-panel-text207']?>
                                </div>
                                <?php
                                $explodEt = $kargolar;
                                $explodEt = explode(',', $explodEt);
                                ?>
                                <div class="kargolari-sirala">
                                    <?php foreach ($explodEt as $kargokey) {
                                        $kargoCek = $db->prepare("select gorsel from kargo_firma where id=:id and durum=:durum ");
                                        $kargoCek->execute(array(
                                            'id' => $kargokey,
                                            'durum' => '1'
                                        ));
                                        $kargoRow = $kargoCek->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php if($kargoCek->rowCount()>'0'  ) {?>
                                            <img src="i/cargo/<?=$kargoRow['gorsel']?>" >
                                        <?php }?>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>
                        <?php if($row['adres'] == !null  ) {?>
                            <div class="user-kargo-return-right rounded">
                                <div class="user-kargo-return-heading">
                                    <i class="fa fa-map-marker"></i> <?=$diller['users-panel-text208']?>
                                </div>
                                <div class="user-kargo-return-address">
                                    <?=$row['adres']?>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                <?php }?>
                <?php } ?>
                <?php }?>

                <?php if($row['durum'] == '2'  ) {?>
                    <div class="w-100 mb-3" >
                        <!-- İptal Durum !-->
                        <div class="button-green button-1x rounded" style="font-size: 13px ; font-weight: 600 !important; padding-left: 20px; padding-right: 20px;">
                            <?=$diller['users-panel-text173']?>
                        </div>
                        <!--  <========SON=========>>> İptal Durum SON !-->
                        <!-- Description !-->
                        <div class="w-100 p-3 rounded mt-3 up-arrow-green" style="border:1px solid #279c3d; font-size: 13px ; color: #3E7C58; line-height:22px; position: relative ">
                            <?=$diller['users-panel-text216']?>
                        </div>
                        <!--  <========SON=========>>> Description SON !-->

                        <?php if($row['para_iade'] == '1' ) {?>
                            <div class="button-green-out button-1x rounded mt-4" style="font-size: 13px ; font-weight: 600 !important; padding-left: 20px; padding-right: 20px;">
                                <?=$diller['users-panel-text217']?>
                            </div>
                            <div class="w-100 p-3 rounded mt-3 up-arrow-grey" style="border:1px solid #EBEBEB; background-color: #f8f8f8; font-size: 13px ; color: #333; line-height:22px; position: relative ">
                                <?=$diller['users-panel-text218']?>
                                <?php if($row['iade_tutar'] >'0'  ) {?>
                                    <div class="mt-2" style="font-weight: 700; font-size: 12px ;">
                                        <?=$diller['users-panel-text219']?> : <?php echo number_format($row['iade_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                    </div>
                                <?php }?>
                            </div>
                        <?php }?>


                    </div>
                <?php }?>


                <?php if($row['durum'] == '3'  ) {?>
                    <div class="w-100 mb-3" >
                        <div class="button-red button-1x rounded" style="font-size: 13px ; font-weight: 600 !important; padding-left: 20px; padding-right: 20px;">
                            <?=$diller['users-panel-text201']?>
                        </div>

                        <div class="w-100 p-3 rounded mt-3 up-arrow-grey-white" style="border:1px solid #ebebeb; font-size: 13px ; color: #000; line-height:22px; position: relative ">
                            <div style="font-weight: 600;"><?=$diller['users-panel-text220']?></div>
                            <?php if($row['iade_olumsuz_sebep'] == !null ) {?>
                                <div class="iade-onaysiz-user-main mt-3">
                                    <div class="iade-onaysiz-user-left">
                                        <?=$diller['users-panel-text221']?>
                                    </div>
                                    <div class="iade-onaysiz-user-right rounded">
                                        <div class="iade-onaysiz-in-txt">
                                            <?=$row['iade_olumsuz_sebep']?>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>

                    </div>
                <?php }?>






            </div>
            <!--  <========SON=========>>> Right Content SON !-->



        </div>


    </div>
    <!-- CONTENT AREA ============== !-->



    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
    <?php include "includes/config/footer_libs.php";?>
    <?php if($_SESSION['destek_alert'] == 'empty'  ) {?>
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
        <?php unset($_SESSION['destek_alert'] ) ?>
    <?php }?>
    <div id="shopButtonOverlay" style="font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ;">
        <div class="shopButtonT">
            <div><img src="images/load.svg" ></div>
            <div><?=$diller['teslimat-uye-text-4']?></div>
        </div>
    </div>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
<?php if($_SESSION['iade_status'] =='success'  ) {?>
    <div class="modal fade" id="okArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                    <div>
                        <?=$diller['users-panel-text158']?>
                    </div>
                    <div style="font-size: 13px ; margin-top: 15px;">
                        <?=$diller['users-panel-text159']?>
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
    <?php unset($_SESSION['iade_status']); ?>
<?php }?>