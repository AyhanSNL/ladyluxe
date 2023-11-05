<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($userSorgusu->rowCount()>'0'  ) {?>
    <?php
    header('Location:'.$ayar['site_url'].'hesabim/siparisler/');
    ?>
<?php }else { ?>
    <?php
    $page_header_setting = $db->prepare("select * from page_header where page_id='takip' order by id");
    $page_header_setting->execute();
    $pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
    ?>
    <title><?php echo $diller['altsayfa-siparis-takibi-title'] ?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="description" content="<?php echo"$ayar[siparis_takip_desc]" ?>">
    <meta name="keywords" content="<?php echo"$ayar[siparis_takip_tags]" ?>">
    <meta name="news_keywords" content="<?php echo"$ayar[siparis_takip_tags]" ?>">
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


    <div id="MainDiv" style="width: 100%;  overflow: hidden; background-color: #<?=$ayar['siparis_takip_bg']?>; font-family : '<?=$ayar['siparis_takip_font']?>',Sans-serif ; ">
        <?php if($pagehead['durum'] == '1' ) {?>
            <div class="page-banner-main" >
                <div class="page-banner-in-text">
                    <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                        <?php echo $diller['siparis-takip-baslik']; ?>
                    </div>
                    <div class="page-banner-links ">
                        <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                        <span>/</span>
                        <a>
                            <?php echo ucwords_tr($diller['siparis-takip-baslik']); ?>
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
        <?php } ?>

        <div class="user_login_register_div">
            <?php if(isset($_GET['sID']) ) {?>
                <?php if(trim(strip_tags($_GET['sID'])) == !null   ) {

                    if(strip_tags(htmlspecialchars($_GET['sID'])) != $_GET['sID']  ) {
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }

                    ?>
                    <?php
                    $siparisCek = $db->prepare("select * from siparisler where siparis_no=:siparis_no and onay=:onay");
                    $siparisCek->execute(array(
                        'siparis_no' => trim(strip_tags($_GET['sID'])),
                        'onay' => '1',
                    ));
                    ?>
                    <?php if($siparisCek->rowCount()>'0'  ) {

                        $siparis = $siparisCek->fetch(PDO::FETCH_ASSOC);
                        $siparisID = $siparis['siparis_no'];

                        if(isset($_GET['invoice'])  ) {
                            if($_GET['invoice'] == 'download'  ) {
                                $invoiceKontrol = $db->prepare("select * from siparis_fatura where siparis_no=:siparis_no ");
                                $invoiceKontrol->execute(array(
                                    'siparis_no' => $siparisID,
                                ));
                                $s = $invoiceKontrol->fetch(PDO::FETCH_ASSOC);
                                if($invoiceKontrol->rowCount()>'0'  ) {
                                    $file = 'i/invoice/'.$s['fatura_url'].'';
                                    header('Content-Description: File Transfer');
                                    header('Content-Type: application/octet-stream');
                                    header('Content-Disposition: attachment; filename='.basename($file));
                                    header('Content-Transfer-Encoding: binary');
                                    header('Expires: 0');
                                    header('Cache-Control: must-revalidate');
                                    header('Pragma: public');
                                    header('Content-Length: ' . filesize($file));
                                    ob_clean();
                                    flush();
                                    readfile($file);
                                    exit;
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }else{
                                header('Location:'.$ayar['site_url'].'404');
                            }
                        }


                        $siparisDurum = $db->prepare("select * from siparis_durumlar where id=:id  ");
                        $siparisDurum->execute(array(
                            'id' => $siparis['siparis_durum'],
                        ));
                        $durum = $siparisDurum->fetch(PDO::FETCH_ASSOC);

                        $ulkeCek = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
                        $ulkeCek->execute(array(
                            '3_iso' => $siparis['ulke']
                        ));
                        $ulke = $ulkeCek->fetch(PDO::FETCH_ASSOC);

                        $ulkeCek2 = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
                        $ulkeCek2->execute(array(
                            '3_iso' => $siparis['fatura_ulke']
                        ));
                        $ulke2 = $ulkeCek2->fetch(PDO::FETCH_ASSOC);

                        $parabiriMi = $db->prepare("select * from para_birimleri where kod=:kod ");
                        $parabiriMi->execute(array(
                            'kod' => $siparis['parabirimi'],
                        ));
                        $para = $parabiriMi->fetch(PDO::FETCH_ASSOC);
                        if($siparis['kargo_sekli'] == '0' && $siparis['kargo_firma'] == !null && $siparis['kargo_takip'] == !null ) {
                            $kargoFirmasi = $db->prepare("select * from kargo_firma where id=:id ");
                            $kargoFirmasi->execute(array(
                                'id' => $siparis['kargo_firma'],
                            ));
                            $kargoRow = $kargoFirmasi->fetch(PDO::FETCH_ASSOC);
                            $kargo_sekil_1 = $kargoFirmasi->rowCount();
                        }else{
                            $kargo_sekil_1 = '0';
                        }

                        /* Kupon */
                        $KuponCek = $db->prepare("select * from sepet_kupon where siparis_id=:siparis_id and kullanim=:kullanim ");
                        $KuponCek->execute(array(
                            'siparis_id' => $siparisID,
                            'kullanim' => '1',
                        ));

                        /*  <========SON=========>>> Kupon SON */
                        ?>
                        <div class="user_subpage_coupon_content">
                            <!-- Head !-->
                            <div class="user_subpage_flex_header" style="flex-direction: column">
                                <div class="user_subpage_flex_header_h">
                                    #<?=$siparisID?> <?=$diller['users-panel-text113']?>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Head SON !-->
                            <?php if($siparis['iptal'] == '1' ) {?>
                                <div class="user_subpage_info_div_blue" style="text-align: center; font-size: 18px ; color: #fff; background-color: #ea5455; border: 1px solid #ea5455;">
                                    <?=$diller['users-panel-text108']?>
                                </div>
                            <?php }?>

                            <!-- Sipariş Detayları !-->
                            <div class="row " style="border: 1px solid #EBEBEB;  padding-top: 20px; margin-right: 0;    margin-left: 0; margin-bottom: 15px;">
                                <div class="form-group col-md-4 ticket-detail-form-area">
                                    <label ><?=$diller['users-panel-text102']?></label><br>
                                    <?=$siparisID?>
                                </div>
                                <div class="form-group col-md-4 ticket-detail-form-area">
                                    <label ><?=$diller['users-panel-text127']?></label><br>
                                    <?php echo date_tr('j F Y, H:i, l ', ''.$siparis['siparis_tarih'].''); ?>
                                </div>
                                <div class="form-group col-md-4 ticket-detail-form-area">
                                    <label ><?=$diller['users-panel-text128']?></label><br>
                                    <?php if($siparis['odeme_tur'] == '1' ) {?>
                                        <?=$diller['users-panel-text105']?>
                                    <?php }?>
                                    <?php if($siparis['odeme_tur'] == '2' ) {?>
                                        <?=$diller['users-panel-text104']?>
                                    <?php }?>
                                    <?php if($siparis['odeme_tur'] == '3' ) {?>
                                        <?=$diller['users-panel-text107']?>
                                    <?php }?>
                                    <?php if($siparis['odeme_tur'] == '4' ) {?>
                                        <?=$diller['users-panel-text106']?>
                                    <?php }?>
                                    <?php if($siparis['odeme_tur'] == 'free' ) {?>
                                        <?=$diller['users-panel-text130']?>
                                    <?php }?>
                                </div>
                                <div class="form-group col-md-4 ticket-detail-form-area">
                                    <label ><?=$diller['users-panel-text129']?></label><br>
                                    <?=$durum['baslik']?>
                                </div>

                                <?php if($odemeayar['faturasiz_teslimat'] == '0' ) {
                                    $faturaCek = $db->prepare("select * from siparis_fatura where siparis_no=:siparis_no ");
                                    $faturaCek->execute(array(
                                        'siparis_no' => $siparisID,
                                    ));
                                    $fatura = $faturaCek->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php if($faturaCek->rowCount()>'0'  ) {?>
                                        <div class="form-group col-md-4 ticket-detail-form-area">
                                            <label><?=$diller['users-panel-text124']?></label><br>
                                            <a href="siparis-takip/?sID=<?=$siparisID?>&invoice=download" class="button-blue button-1x"><i class="fa fa-download"></i> <?=$diller['users-panel-text125']?></a>
                                        </div>
                                    <?php }?>
                                <?php }?>

                            </div>
                            <!--  <========SON=========>>> Sipariş Detayları SON !-->

                            <?php
                            $notVarmi = $db->prepare("select * from siparis_notlar where siparis_no=:siparis_no and gorunum=:gorunum order by id asc");
                            $notVarmi->execute(array(
                                'siparis_no' => $siparis['siparis_no'],
                                'gorunum' => '1',
                            ));
                            ?>

                            <?php foreach ($notVarmi as $notRow) {?>
                                <!-- site yönetici notu !-->
                                <div class="user_subpage_info_div_blue_2" style="background-color: #ffebd9; border: 1px solid #ffc8bd; text-align: left; ">
                                    <div style="font-size: 11px !important ;  ">
                                        <?php echo date_tr('j F Y, H:i ', ''.$notRow['tarih'].''); ?>
                                    </div>
                                    <div style="font-weight: 600; margin-top: 10px; font-size: 13px ;">
                                        <?=$notRow['icerik']?>
                                    </div>
                                </div>
                                <!--  <========SON=========>>> site yönetici notu SON !-->
                            <?php }?>



                            <?php if($odemeayar['havale_odeme_bildirim'] == '1' && $siparis['odeme_tur'] == '2' && $siparis['iptal'] != '1'  ) {?>
                                <?php
                                $bildirimSorgusu = $db->prepare("select * from odeme_bildirim where siparis_no=:siparis_no order by id desc limit 1 ");
                                $bildirimSorgusu->execute(array(
                                    'siparis_no' => $siparis['siparis_no'],
                                ));
                                $bilRow = $bildirimSorgusu->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <?php if($bildirimSorgusu->rowCount()>'0'  ) {?>
                                    <?php if($bilRow['durum'] == '0' ) {?>
                                        <div class="user_subpage_info_div_blue_2 m-top-10" style="font-weight: 600; text-align: center;">
                                            <i class="fa fa-refresh fa-spin fa-fw"></i>
                                            <?=$diller['users-panel-text121']?>
                                        </div>
                                    <?php }?>
                                    <?php if($bilRow['durum'] == '1' ) {?>
                                        <div class="user_subpage_info_div_blue_2 m-top-10" style="font-weight: 600; border: 1px solid #75daad; background-color: #d1f5d3; text-align: center;">
                                            <i class="fa fa-check"></i> <?=$diller['users-panel-text122']?>
                                        </div>
                                    <?php }?>
                                    <?php if($bilRow['durum'] == '2' ) {?>
                                        <div class="user_subpage_info_div_blue_2 m-top-10" style="font-weight: 600; border: 1px solid #c5473e; background-color: #FFD3CD; text-align: center;">
                                            <i class="fa fa-times"></i> <?=$diller['users-panel-text122-b']?>
                                            <br>
                                            <a href="odeme-bildirimi/?sID=<?=$_GET['sID']?>&delete=yes&order=new"  class="button-red button-2x m-top-20">
                                                <?=$diller['users-panel-text122-c']?>
                                            </a>
                                        </div>
                                    <?php }?>
                                <?php }else { ?>
                                    <!-- Havale/EFT Bildirim !-->
                                    <div class="user_subpage_info_div_blue_2 m-top-10">
                        <span style="font-size: 18px ;">
                            <strong>
                               <i class="fa fa-info-circle"></i> <?=$diller['users-panel-text120']?>
                            </strong>
                        </span>
                                        <br><br>
                                        <?=$diller['users-panel-text118']?>
                                        <br><br>
                                        <strong>
                                            <?=$diller['users-panel-text123']?> :
                                            <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                <?php if($para['simge_gosterim'] == '0' ) {?>
                                                    <?=$para['sol_simge']?>
                                                <?php }?>
                                                <?php if($para['simge_gosterim'] == '1' ) {?>
                                                    <?=$para['sag_simge']?>
                                                <?php }?>
                                                <?php echo number_format($siparis['havale_toplamtutar'], $para['para_format']); ?>
                                                <?php if($para['simge_gosterim'] == '2' ) {?>
                                                    <?=$para['sol_simge']?>
                                                <?php }?>
                                                <?php if($para['simge_gosterim'] == '3' ) {?>
                                                    <?=$para['sag_simge']?>
                                                <?php }?>
                                            <?php }else { ?>
                                                <?php echo number_format($siparis['havale_toplamtutar'], 2); ?> <?=$siparis['parabirimi']?>
                                            <?php }?>
                                        </strong>
                                        <br><br>
                                        <a href="odeme-bildirimi/?sID=<?=$siparis['siparis_no']?>" class="button-orange button-2x"><?=$diller['users-panel-text119']?></a>
                                    </div>
                                    <!--  <========SON=========>>> Havale/EFT Bildirim SON !-->
                                <?php }?>
                            <?php }?>

                            <!-- Sipariş adresleri !-->
                            <div class="account_subpage_order_address_main">
                                <div class="account_subpage_order_address_left">
                                    <div class="account_subpage_order_address_h">
                                        <i class="fa fa-map-marker"></i> <?=$diller['users-panel-text115']?>
                                    </div>
                                    <div class="account_subpage_order_address_name">
                                        <?=$siparis['isim']?> <?=$siparis['soyisim']?>
                                    </div>
                                    <div class="account_subpage_order_address_txt">
                                        <?=$siparis['adresbilgisi']?>
                                    </div>
                                    <div class="account_subpage_order_address_txt">
                                        <?=$siparis['ilce']?> / <?=$siparis['sehir']?>
                                    </div>
                                    <div class="account_subpage_order_address_txt">
                                        <?=$diller['users-panel-text117']?> : <?=$siparis['postakodu']?>
                                    </div>
                                    <div class="account_subpage_order_address_txt" style="font-weight: 600; margin-bottom: 10px;">
                                        <?=$ulke['baslik']?>
                                    </div>
                                    <div class="account_subpage_order_address_phone">
                                        <i class="fa fa-phone"></i> +<?=$siparis['alan_kodu']?> <?=$siparis['telefon_gosterim']?>
                                    </div>
                                    <div class="account_subpage_order_address_phone">
                                        <i class="fa fa-envelope-open-o"></i> <?=$siparis['eposta']?>
                                    </div>
                                </div>
                                <?php if($odemeayar['faturasiz_teslimat'] == '0' ) {?>
                                    <?php if($siparis['adres_fatura_farkli'] == '0'  ) {?>
                                        <div class="account_subpage_order_address_right">
                                            <div class="account_subpage_order_address_h">
                                                <i class="las la-file-invoice"></i> <?=$diller['users-panel-text116']?>
                                            </div>
                                            <div class="account_subpage_order_address_name">
                                                <?=$siparis['isim']?> <?=$siparis['soyisim']?>
                                            </div>
                                            <div class="account_subpage_order_address_txt">
                                                <?=$siparis['adresbilgisi']?>
                                            </div>
                                            <div class="account_subpage_order_address_txt">
                                                <?=$siparis['ilce']?> / <?=$siparis['sehir']?>
                                            </div>
                                            <div class="account_subpage_order_address_txt">
                                                <?=$diller['users-panel-text117']?> : <?=$siparis['postakodu']?>
                                            </div>
                                            <div class="account_subpage_order_address_txt" style="font-weight: 600; margin-bottom: 10px;">
                                                <?=$ulke['baslik']?>
                                            </div>
                                        </div>
                                    <?php }else { ?>
                                        <div class="account_subpage_order_address_right">
                                            <div class="account_subpage_order_address_h">
                                                <i class="las la-file-invoice"></i> <?=$diller['users-panel-text116']?>
                                            </div>
                                            <?php if($siparis['fatura_turu'] == '1'  ) {?>
                                                <div class="account_subpage_order_address_name">
                                                    <?=$siparis['fatura_isim']?> <?=$siparis['fatura_soyisim']?>
                                                </div>
                                                <div class="account_subpage_order_address_name">
                                                    <?=$siparis['fatura_tc']?>
                                                </div>
                                            <?php }?>
                                            <?php if($siparis['fatura_turu'] == '2'  ) {?>
                                                <div class="account_subpage_order_address_name">
                                                    <?=$siparis['fatura_firma_unvan']?>
                                                </div>
                                                <div class="account_subpage_order_address_name">
                                                    <?=$siparis['fatura_vergi_dairesi']?> <?=$siparis['fatura_vergi_no']?>
                                                </div>
                                            <?php }?>

                                            <div class="account_subpage_order_address_txt">
                                                <?=$siparis['fatura_adresi']?>
                                            </div>
                                            <div class="account_subpage_order_address_txt">
                                                <?=$siparis['fatura_ilce']?> / <?=$siparis['fatura_sehir']?>
                                            </div>
                                            <div class="account_subpage_order_address_txt">
                                                <?=$diller['users-panel-text117']?> : <?=$siparis['postakodu']?>
                                            </div>
                                            <div class="account_subpage_order_address_txt" style="font-weight: 600; margin-bottom: 10px;">
                                                <?=$ulke2['baslik']?>
                                            </div>
                                            <div class="account_subpage_order_address_phone" style="font-weight: 600; color: orangered;">
                                                <?php if($siparis['fatura_turu'] == '1'  ) {?>
                                                    <?=$diller['users-panel-text82']?>
                                                <?php }?>
                                                <?php if($siparis['fatura_turu'] == '2'  ) {?>
                                                    <?=$diller['users-panel-text83']?>
                                                <?php }?>
                                            </div>

                                        </div>
                                    <?php }?>
                                <?php }?>
                            </div>
                            <!--  <========SON=========>>> Sipariş adresleri SON !-->

                            <?php if($siparis['siparis_notu'] == !null ) {?>
                                <!-- Mğşteri Notu !-->
                                <div class="user_subpage_info_div_grey" style="padding: 25px;">
                                    <strong><?=$diller['users-panel-text114']?></strong>
                                    <br><br>
                                    <?=$siparis['siparis_notu']?>
                                </div>
                                <!--  <========SON=========>>> Mğşteri Notu SON !-->
                            <?php }?>


                            <?php if($odemeayar['kargo_sistemi'] == '1' && $siparis['kargo_sekli'] == '0'  && $kargo_sekil_1 > '0' ) {?>
                                <!-- Kargo İekli 0 = Tek Kargo Takip !-->
                                <div class="account_subpage_order_cargo_main">
                                    <div class="account_subpage_order_cargo_left">
                                        <img src="i/cargo/<?=$kargoRow['gorsel']?>" class="border p-2"  >
                                    </div>
                                    <div class="account_subpage_order_cargo_right">
                                        <?php if($kargoRow['takip_url'] == !null ) {?>
                                            <a href="<?=$kargoRow['takip_url']?><?=$siparis['kargo_takip']?>" target="_blank" class="button-blue button-2x">
                                                <i class="fa fa-truck"></i>
                                                <?=$diller['users-panel-text136']?>
                                            </a>
                                        <?php }else { ?>
                                            <div class="button-blue button-2x" style="cursor: text">
                                                <?=$diller['users-panel-text136']?> :
                                                <?=$siparis['kargo_takip']?>
                                            </div>
                                        <?php }?>

                                    </div>
                                </div>
                                <!--  <========SON=========>>> Kargo İekli 1 = Tek Kargo Takip SON !-->
                            <?php } ?>

                            <!-- Ürünler !-->
                            <div class="account_subpage_order_products_main">

                                <?php
                                $urunleriCek = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
                                $urunleriCek->execute(array(
                                    'siparis_id' => $siparisID,
                                ));
                                ?>
                                <?php foreach ($urunleriCek as $urunRow) {
                                    $realProduct = $db->prepare("select * from urun where id=:id ");
                                    $realProduct->execute(array(
                                        'id' => $urunRow['urun_id'],
                                    ));
                                    $realurunRow = $realProduct->fetch(PDO::FETCH_ASSOC);

                                    /* varyantSorgu */
                                    $varyantSorgu = $db->prepare("select * from siparis_varyant where siparis_id=:siparis_id and urun_id=:urun_id and sepet_id=:sepet_id ");
                                    $varyantSorgu->execute(array(
                                        'siparis_id' => $siparis['siparis_no'],
                                        'urun_id' => $urunRow['urun_id'],
                                        'sepet_id' => $urunRow['sepet_id'],
                                    ));

                                    /*  <========SON=========>>> varyantSorgu SON */
                                    /* İade Talep Sorgusu */
                                    $iadeSorgusu = $db->prepare("select * from siparis_urunler_iade where siparis_no=:siparis_no and urun_id=:urun_id and durum=:durum and uye_id=:uye_id ");
                                    $iadeSorgusu->execute(array(
                                        'siparis_no' => $siparisID,
                                        'urun_id' => $urunRow['id'],
                                        'durum' => '0',
                                        'uye_id' => $userCek['id'],
                                    ));
                                    $iadeRow = $iadeSorgusu->fetch(PDO::FETCH_ASSOC);
                                    /*  <========SON=========>>> İade Talep Sorgusu SON */
                                    ?>
                                    <div class="account_subpage_order_products_box">
                                        <div class="account_subpage_order_products_box_hed">
                                            <?php if($realurunRow['gorsel'] == !null && $realProduct->rowCount()>'0' ) {?>
                                                <div class="account_subpage_order_products_box_hed_img">
                                                    <img src="images/product/<?=$realurunRow['gorsel']?>" >
                                                </div>
                                            <?php }?>
                                            <div class="account_subpage_order_products_box_hed_name">
                                                <?=$urunRow['urun_baslik']?>
                                                <?php if($urunRow['stok_kodu'] == !null ) {?>
                                                    <div class="order_products_box_hed_name_sub" style="margin-top: 9px;">
                                                        <?=$diller['users-panel-text133']?> : <?=$urunRow['stok_kodu']?>
                                                    </div>
                                                <?php }?>
                                                <?php if($varyantSorgu->rowCount()>'0'  ) {?>
                                                    <?php foreach ($varyantSorgu as $varyant) {?>
                                                        <?php if($varyant['tur'] == '1' ) {?>
                                                            <div class="order_products_box_hed_name_sub">
                                                                <?=$varyant['grup_adi']?> : <?=$varyant['varyant_adi']?>  <?php if($varyant['ek_fiyat'] == !null ) { ?>
                                                                    <span  class="button-red " style="font-size: 11px ; padding: 0 5px; border-radius: 50px; margin-left: 5px;">
                                                    +
                                                <?php if($para['simge_gosterim'] == '0' ) {?>
                                                    <?=$para['sol_simge']?>
                                                <?php }?>
                                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                            <?=$para['sag_simge']?>
                                                                        <?php }?>
                                                                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$siparis['odeme_kuru'],$varyant['ek_fiyat'] ), $para['para_format']); ?>
                                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                            <?=$para['sol_simge']?>
                                                                        <?php }?>
                                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                            <?=$para['sag_simge']?>
                                                                        <?php }?>
                                              </span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }?>
                                                        <?php if($varyant['tur'] == '2' ) {
                                                            $varyantEklenti = $db->prepare("select * from urun_varyant_ekler where id=:id ");
                                                            $varyantEklenti->execute(array(
                                                                'id' => $varyant['ekbilgi_id'],
                                                            ));
                                                            $ekbilgi = $varyantEklenti->fetch(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <div class="order_products_box_hed_name_sub">
                                                                <?=$varyant['grup_adi']?> : <?=$ekbilgi['icerik']?>  <?php if($varyant['ek_fiyat'] == !null ) { ?>
                                                                    <span  class="button-red " style="font-size: 11px ; padding: 0 5px; border-radius: 50px; margin-left: 5px;">
                                                    +
                                                <?php if($para['simge_gosterim'] == '0' ) {?>
                                                    <?=$para['sol_simge']?>
                                                <?php }?>
                                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                            <?=$para['sag_simge']?>
                                                                        <?php }?>
                                                                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$siparis['odeme_kuru'],$varyant['ek_fiyat'] ), $para['para_format']); ?>
                                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                            <?=$para['sol_simge']?>
                                                                        <?php }?>
                                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                            <?=$para['sag_simge']?>
                                                                        <?php }?>
                                              </span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }?>
                                                        <?php if($varyant['tur'] == '4' ) {
                                                            $varyantEklenti = $db->prepare("select * from urun_varyant_ekler where id=:id ");
                                                            $varyantEklenti->execute(array(
                                                                'id' => $varyant['ekbilgi_id'],
                                                            ));
                                                            $ekbilgi = $varyantEklenti->fetch(PDO::FETCH_ASSOC);
                                                            ?>
                                                            <div class="order_products_box_hed_name_sub">
                                                                <?=$varyant['grup_adi']?> : <?php echo date_tr('j F Y', ''.$ekbilgi['icerik'].''); ?>  <?php if($varyant['ek_fiyat'] == !null ) { ?>
                                                                    <span  class="button-red " style="font-size: 11px ; padding: 0 5px; border-radius: 50px; margin-left: 5px;">
                                                    +
                                                <?php if($para['simge_gosterim'] == '0' ) {?>
                                                    <?=$para['sol_simge']?>
                                                <?php }?>
                                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                            <?=$para['sag_simge']?>
                                                                        <?php }?>
                                                                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$siparis['odeme_kuru'],$varyant['ek_fiyat'] ), $para['para_format']); ?>
                                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                            <?=$para['sol_simge']?>
                                                                        <?php }?>
                                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                            <?=$para['sag_simge']?>
                                                                        <?php }?>
                                              </span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }?>
                                                        <?php if($varyant['tur'] == '3' ) {?>
                                                            <div class="order_products_box_hed_name_sub">
                                                                <?=$varyant['grup_adi']?> : <?=$varyant['varyant_adi']?>  <?php if($varyant['ek_fiyat'] == !null ) { ?>
                                                                    <span  class="button-red " style="font-size: 11px ; padding: 0 5px; border-radius: 50px; margin-left: 5px;">
                                                    +
                                                <?php if($para['simge_gosterim'] == '0' ) {?>
                                                    <?=$para['sol_simge']?>
                                                <?php }?>
                                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                            <?=$para['sag_simge']?>
                                                                        <?php }?>
                                                                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$siparis['odeme_kuru'],$varyant['ek_fiyat'] ), $para['para_format']); ?>
                                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                            <?=$para['sol_simge']?>
                                                                        <?php }?>
                                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                            <?=$para['sag_simge']?>
                                                                        <?php }?>
                                                          </span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }?>
                                                    <?php }?>
                                                <?php }?>
                                            </div>
                                            <div class="account_subpage_order_products_box_hed_status">
                                                <?php if($iadeSorgusu->rowCount()<='0'  ) {?>
                                                    <?php if($urunRow['durum'] == '0' || $urunRow['durum'] == null ) {?>
                                                        <div class="button-white button-1x orderDetail_product_button" style="background-color: #ebebeb;border:1px solid #EBEBEB">
                                                            <i class="fa fa-refresh fa-spin fa-fw"></i> <?=$diller['users-panel-text134']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($urunRow['durum'] == '1' ) {?>
                                                        <div class="button-green-out button-1x orderDetail_product_button" >
                                                            <i class="las la-check"></i> <?=$diller['users-panel-text150']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($urunRow['durum'] == '2' ) {?>
                                                        <div class="button-yellow-out button-1x orderDetail_product_button" >
                                                            <i class="fa fa-gift"></i> <?=$diller['users-panel-text151']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($urunRow['durum'] == '3' ) {?>
                                                        <div class="button-blue-out button-1x orderDetail_product_button" >
                                                            <i class="las la-store"></i> <?=$diller['users-panel-text152']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($urunRow['durum'] == '4' ) {?>
                                                        <div class="button-black-out button-1x orderDetail_product_button" >
                                                            <i class="las la-truck"></i> <?=$diller['users-panel-text153']?>
                                                        </div>
                                                    <?php }?>
                                                <?php }?>
                                                <?php if($urunRow['durum'] == '5' ) {?>
                                                    <div class="button-red-out button-1x orderDetail_product_button" >
                                                        <?=$diller['users-panel-text154']?>
                                                    </div>
                                                <?php }?>
                                                <?php if($urunRow['durum'] == '6' ) {?>
                                                    <div class="button-pink button-1x orderDetail_product_button" >
                                                        <i class="fa fa-times"></i> <?=$diller['users-panel-text155']?>
                                                    </div>
                                                <?php }?>

                                                <?php if($odemeayar['kargo_sistemi'] == '1' && $siparis['kargo_sekli'] == '1' && $urunRow['durum'] != '6' && $urunRow['durum'] != '5' ) {
                                                    /* Kargo Çek */
                                                    $teklikargoCek = $db->prepare("select * from siparis_kargo where siparis_id=:siparis_id and siparis_urun_id=:siparis_urun_id ");
                                                    $teklikargoCek->execute(array(
                                                        'siparis_id' => $siparisID,
                                                        'siparis_urun_id' => $urunRow['id'],
                                                    ));
                                                    $siparisKargoRow = $teklikargoCek->fetch(PDO::FETCH_ASSOC);

                                                    $kargoFirmasi = $db->prepare("select * from kargo_firma where id=:id ");
                                                    $kargoFirmasi->execute(array(
                                                        'id' => $siparisKargoRow['kargo_firma'],
                                                    ));
                                                    $kargoRow = $kargoFirmasi->fetch(PDO::FETCH_ASSOC);
                                                    /*  <========SON=========>>> Kargo Çek SON */
                                                    ?>
                                                    <?php if($teklikargoCek->rowCount()>'0'  ) {?>
                                                        <?php if($kargoRow['takip_url'] == !null ) {?>
                                                            <?php if($siparisKargoRow['kargo_takip'] == !null  ) {?>
                                                                <a href="<?=$kargoRow['takip_url']?><?=$siparisKargoRow['kargo_takip']?>" target="_blank" class="button-grey button-1x orderDetail_product_button">
                                                                    <i class="fa fa-truck"></i>
                                                                    <?=$diller['users-panel-text136']?>
                                                                </a>
                                                            <?php } ?>
                                                        <?php }else { ?>
                                                            <?php if($siparisKargoRow['kargo_takip'] == !null  ) {?>
                                                                <div class="ml-2">
                                                                    <div class="d-flex flex-column flex-wrap align-items-start bg-light p-2 ">
                                                                        <img src="i/cargo/<?=$kargoRow['gorsel']?>" style="max-height: 40px" class="border mb-2">
                                                                        <div class="font-12"><?=$diller['users-panel-text136']?></div>
                                                                        <div><?=$siparisKargoRow['kargo_takip']?></div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php }?>
                                                    <?php }?>

                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="account_subpage_order_products_box_fot">
                                            <div class="account_subpage_order_products_box_fot_birim">
                                                <div class="account_subpage_order_products_box_fot_h">
                                                    <?=$diller['sepet-liste-birim-yazisi']?>
                                                </div>
                                                <div class="account_subpage_order_products_box_fot_s">
                                                    <?php if($urunRow['ozel_fiyat_uye'] == '1' ) {?>
                                                        <span style="color: red; font-size: 11px ;"><?=$diller['urun-detay-gruba-ozel-fiyat-uzun']?></span>
                                                        <br>
                                                    <?php }?>
                                                    <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($urunRow['havale_kdvsiz_tutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <?php echo number_format($urunRow['havale_kdvsiz_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($urunRow['kdvsiz_tutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <?php echo number_format($urunRow['kdvsiz_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>

                                            <?php if($siparis['odeme_tur'] == '2' ) {?>
                                                <?php if($urunRow['havale_kdv_tutar'] >'0' ) {?>
                                                    <div class="account_subpage_order_products_box_fot_kdv">
                                                        <div class="account_subpage_order_products_box_fot_h">
                                                            <?=$diller['sepet-liste-kdv-yazisi']?>
                                                        </div>
                                                        <div class="account_subpage_order_products_box_fot_s">
                                                            <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                                <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                    <?=$para['sol_simge']?>
                                                                <?php }?>
                                                                <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                    <?=$para['sag_simge']?>
                                                                <?php }?>
                                                                <?php echo number_format($urunRow['havale_kdv_tutar'], $para['para_format']); ?>
                                                                <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                    <?=$para['sol_simge']?>
                                                                <?php }?>
                                                                <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                    <?=$para['sag_simge']?>
                                                                <?php }?>
                                                            <?php }else { ?>
                                                                <?php echo number_format($urunRow['havale_kdv_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            <?php }else { ?>
                                                <?php if($urunRow['kdv_tutar'] >'0' ) {?>
                                                    <div class="account_subpage_order_products_box_fot_kdv">
                                                        <div class="account_subpage_order_products_box_fot_h">
                                                            <?=$diller['sepet-liste-kdv-yazisi']?>
                                                        </div>
                                                        <div class="account_subpage_order_products_box_fot_s">
                                                            <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                                <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                    <?=$para['sol_simge']?>
                                                                <?php }?>
                                                                <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                    <?=$para['sag_simge']?>
                                                                <?php }?>
                                                                <?php echo number_format($urunRow['kdv_tutar'], $para['para_format']); ?>
                                                                <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                    <?=$para['sol_simge']?>
                                                                <?php }?>
                                                                <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                    <?=$para['sag_simge']?>
                                                                <?php }?>
                                                            <?php }else { ?>
                                                                <?php echo number_format($urunRow['kdv_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            <?php }?>



                                            <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                                                <div class="account_subpage_order_products_box_fot_kargo">
                                                    <div class="account_subpage_order_products_box_fot_h">
                                                        <?=$diller['sepet-ozet-kargo-tutar']?>
                                                    </div>
                                                    <div class="account_subpage_order_products_box_fot_s">
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($urunRow['kargo_tutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <?php echo number_format($urunRow['kargo_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php }?>

                                            <div class="account_subpage_order_products_box_fot_adet">
                                                <div class="account_subpage_order_products_box_fot_h">
                                                    <?=$diller['sepet-liste-adet-yazisi']?>
                                                </div>
                                                <div class="account_subpage_order_products_box_fot_s">
                                                    <?=$urunRow['adet']?>
                                                </div>
                                            </div>
                                            <div class="account_subpage_order_products_box_fot_total">
                                                <div class="account_subpage_order_products_box_fot_h">
                                                    <?=$diller['sepet-liste-toplam-yazisi']?>
                                                </div>
                                                <div class="account_subpage_order_products_box_fot_s">
                                                    <?php if($urunRow['ozel_fiyat_uye'] == '1' ) {?>
                                                        <span style="color: red; font-size: 11px ;"><?=$diller['urun-detay-gruba-ozel-fiyat-uzun']?></span>
                                                        <br>
                                                    <?php }?>
                                                    <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($urunRow['havale_kdvsiz_tutar']+$urunRow['havale_kdv_tutar']+$urunRow['kargo_tutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <?php echo number_format($urunRow['havale_kdvsiz_tutar']+$urunRow['havale_kdv_tutar']+$urunRow['kargo_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($urunRow['kdvsiz_tutar']+$urunRow['kdv_tutar']+$urunRow['kargo_tutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <?php echo number_format($urunRow['kdvsiz_tutar']+$urunRow['kdv_tutar']+$urunRow['kargo_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                            <!--  <========SON=========>>> Ürünler SON !-->


                            <!-- Toplam Ödenen !-->
                            <div class="account_subpage_summary_order_main">
                                <div class="account_subpage_summary_order_in">

                                    <?php if($siparis['kargo_limit_durum'] == '1' ) {?>
                                        <!-- Ücretsiz kargo kampanyası !-->
                                        <div class="account_subpage_summary_order_freedelivery">
                                            <div class="account_subpage_summary_order_coupon_icon">
                                                <i class="fa fa-truck"></i>
                                            </div>
                                            <div class="account_subpage_summary_order_coupon_text">
                                                <?=$diller['users-panel-text137']?>
                                            </div>
                                        </div>
                                        <!--  <========SON=========>>> Ücretsiz kargo kampanyası SON !-->
                                    <?php }?>

                                    <?php if($siparis['havale_kargo_limit_durum'] == '1' ) {?>
                                        <!-- Ücretsiz kargo kampanyası !-->
                                        <div class="account_subpage_summary_order_freedelivery">
                                            <div class="account_subpage_summary_order_coupon_icon">
                                                <i class="fa fa-truck"></i>
                                            </div>
                                            <div class="account_subpage_summary_order_coupon_text">
                                                <?=$diller['users-panel-text137']?>
                                            </div>
                                        </div>
                                        <!--  <========SON=========>>> Ücretsiz kargo kampanyası SON !-->
                                    <?php }?>

                                    <?php if($KuponCek->rowCount()>'0'  ) {?>
                                        <!-- İnidirm kuponu  !-->
                                        <?php foreach ($KuponCek as $kuponRow) {
                                            $realKupon = $db->prepare("select * from kupon where id=:id ");
                                            $realKupon->execute(array(
                                                'id' => $kuponRow['kupon_id'],
                                            ));
                                            $realKuponRow = $realKupon->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <div class="account_subpage_summary_order_discount_coupon">
                                                <div class="account_subpage_summary_order_coupon_icon">
                                                    <i class="fa fa-tags"></i>
                                                </div>
                                                <div class="account_subpage_summary_order_coupon_text">
                                                    <div class="account_subpage_summary_order_coupon_text_h">
                                                        <?=$diller['users-panel-text138']?>
                                                    </div>
                                                    <div class="account_subpage_summary_order_coupon_text_s">
                                                        <i class="fa fa-angle-right"></i> <?=$realKuponRow['baslik']?>
                                                        <div class="orderdetail_coupon_total">
                                                            <?php if($realKuponRow['tur'] == '1' ) {?>
                                                                <?=$diller['users-panel-text45']?> : %<?php echo number_format($realKuponRow['indirim_tutar'], 0); ?>
                                                            <?php }?>
                                                            <?php if($realKuponRow['tur'] == '2' ) {?>
                                                                <?=$diller['users-panel-text44']?> : <?=kur_cekimi($realKuponRow['indirim_tutar'])?>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <!--  <========SON=========>>> İnidirm kuponu  SON !-->
                                    <?php }?>

                                    <?php if($siparis['doviz_durum'] == '1'  ) {?>
                                        <div class="account_subpage_summary_order_discount_coupon ">
                                            <div class="account_subpage_summary_order_coupon_icon">
                                                <i class="fa fa-money"></i>
                                            </div>
                                            <div class="account_subpage_summary_order_coupon_text">
                                                <div class="account_subpage_summary_order_coupon_text_h" style="margin-bottom: 10px;">
                                                    <?=$diller['users-panel-text147']?>
                                                </div>
                                                <div class="account_subpage_summary_order_coupon_text_s">
                                                    <?=$diller['users-panel-text145']?> : <?=$para['baslik']?> / <?=$para['kod']?>
                                                </div>
                                                <div class="account_subpage_summary_order_coupon_text_s">
                                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['users-panel-text148']?>"></i>  <?=$diller['users-panel-text146']?> : <?=$siparis['odeme_kuru']?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>



                                    <!-- Summary !-->
                                    <div class="account_subpage_summary_order_box">
                                        <div class="account_subpage_summary_order_box_h">
                                            <?=$diller['users-panel-text139']?>
                                        </div>

                                        <div class="account_subpage_summary_order_box_s">
                                            <div class="account_subpage_summary_order_box_s_left">
                                                <?=$diller['users-panel-text140']?>
                                            </div>
                                            <div class="account_subpage_summary_order_box_s_right">
                                                <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                        <?php echo number_format($siparis['havale_aratutar'], $para['para_format']); ?>
                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php echo number_format($siparis['havale_aratutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                    <?php }?>
                                                <?php }else { ?>
                                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                        <?php echo number_format($siparis['ara_tutar'], $para['para_format']); ?>
                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php echo number_format($siparis['ara_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                    <?php }?>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <?php if($odemeayar['faturasiz_teslimat'] == '0'  ) {?>
                                            <?php if($siparis['odeme_tur'] == '2' && $siparis['havale_kdvtutar'] >'0' ) { ?>
                                                <div class="account_subpage_summary_order_box_s">
                                                    <div class="account_subpage_summary_order_box_s_left">
                                                        <?=$diller['users-panel-text141']?>
                                                    </div>
                                                    <div class="account_subpage_summary_order_box_s_right">
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['havale_kdvtutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <?php echo number_format($siparis['havale_kdvtutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php }else { ?>
                                                <?php if($siparis['kdv_tutar'] >'0'  ) {?>
                                                    <div class="account_subpage_summary_order_box_s">
                                                        <div class="account_subpage_summary_order_box_s_left">
                                                            <?=$diller['users-panel-text141']?>
                                                        </div>
                                                        <div class="account_subpage_summary_order_box_s_right">
                                                            <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                                <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                    <?=$para['sol_simge']?>
                                                                <?php }?>
                                                                <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                    <?=$para['sag_simge']?>
                                                                <?php }?>
                                                                <?php echo number_format($siparis['kdv_tutar'], $para['para_format']); ?>
                                                                <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                    <?=$para['sol_simge']?>
                                                                <?php }?>
                                                                <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                    <?=$para['sag_simge']?>
                                                                <?php }?>
                                                            <?php }else { ?>
                                                                <?php echo number_format($siparis['kdv_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            <?php }?>
                                        <?php }?>
                                        <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                                            <div class="account_subpage_summary_order_box_s">
                                                <div class="account_subpage_summary_order_box_s_left">
                                                    <?=$diller['users-panel-text149']?>
                                                </div>
                                                <div class="account_subpage_summary_order_box_s_right">
                                                    <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['havale_kargotutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <?php echo number_format($siparis['havale_kargotutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['kargo_tutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <?php echo number_format($siparis['kargo_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>

                                        <?php if($siparis['indirim_tutar'] >'0' ) {?>
                                            <div class="account_subpage_summary_order_box_s">
                                                <div class="account_subpage_summary_order_box_s_left">
                                                    <?=$diller['users-panel-text142']?>
                                                </div>
                                                <div class="account_subpage_summary_order_box_s_right">
                                                    <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['indirim_tutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            - <?php echo number_format($siparis['indirim_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['indirim_tutar'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            - <?php echo number_format($siparis['indirim_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?php if($siparis['sepette_ek_indirim'] >'0' ) {?>
                                            <div class="account_subpage_summary_order_box_s">
                                                <div class="account_subpage_summary_order_box_s_left">
                                                    <?=$diller['sepet-ek-indirim']?>
                                                </div>
                                                <div class="account_subpage_summary_order_box_s_right">
                                                    <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['sepette_ek_indirim'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            - <?php echo number_format($siparis['sepette_ek_indirim'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['sepette_ek_indirim'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            - <?php echo number_format($siparis['sepette_ek_indirim'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?php if($siparis['ilk_siparis_indirim'] >'0' ) {?>
                                            <div class="account_subpage_summary_order_box_s">
                                                <div class="account_subpage_summary_order_box_s_left">
                                                    <?=$diller['sepet-ilk-siparis-indirim']?>
                                                </div>
                                                <div class="account_subpage_summary_order_box_s_right">
                                                    <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['ilk_siparis_indirim'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            - <?php echo number_format($siparis['ilk_siparis_indirim'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['ilk_siparis_indirim'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            - <?php echo number_format($siparis['ilk_siparis_indirim'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?php if($siparis['grup_indirim'] >'0' ) {?>
                                            <div class="account_subpage_summary_order_box_s">
                                                <div class="account_subpage_summary_order_box_s_left">
                                                    <?=$diller['sepet-size-ozel-indirim']?>
                                                </div>
                                                <div class="account_subpage_summary_order_box_s_right">
                                                    <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['grup_indirim'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            - <?php echo number_format($siparis['grup_indirim'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                            <?php echo number_format($siparis['grup_indirim'], $para['para_format']); ?>
                                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                                <?=$para['sol_simge']?>
                                                            <?php }?>
                                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                                <?=$para['sag_simge']?>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            - <?php echo number_format($siparis['grup_indirim'], 2); ?> <?=$siparis['parabirimi']?>
                                                        <?php }?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?php if($siparis['kapida_odeme_bedeli'] >'0' ) {?>
                                            <div class="account_subpage_summary_order_box_s">
                                                <div class="account_subpage_summary_order_box_s_left">
                                                    <?=$diller['users-panel-text143']?>
                                                </div>
                                                <div class="account_subpage_summary_order_box_s_right">
                                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                        <?php echo number_format($siparis['kapida_odeme_bedeli'], $para['para_format']); ?>
                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php echo number_format($siparis['kapida_odeme_bedeli'], 2); ?> <?=$siparis['parabirimi']?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php }?>

                                        <div class="account_subpage_summary_order_box_s">
                                            <div class="account_subpage_summary_order_box_s_left" style="font-size: 15px ;">
                                                <?=$diller['users-panel-text144']?>
                                            </div>
                                            <div class="account_subpage_summary_order_box_s_right" style="font-size: 18px ;">
                                                <?php if($siparis['odeme_tur'] == '2' ) { ?>
                                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                        <?php echo number_format($siparis['havale_toplamtutar'], $para['para_format']); ?>
                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php echo number_format($siparis['havale_toplamtutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                    <?php }?>
                                                <?php }else { ?>
                                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                        <?php echo number_format($siparis['toplam_tutar'], $para['para_format']); ?>
                                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                                            <?=$para['sol_simge']?>
                                                        <?php }?>
                                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                                            <?=$para['sag_simge']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?php echo number_format($siparis['toplam_tutar'], 2); ?> <?=$siparis['parabirimi']?>
                                                    <?php }?>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  <========SON=========>>> Summary SON !-->



                                </div>
                            </div>
                            <!--  <========SON=========>>> Toplam Ödenen SON !-->

                            <style>
                                .striped{
                                    background: #f8f8f8;
                                }
                                .striped:nth-child(2n){
                                    background-color: #fff;
                                }
                            </style>
                            <?php
                            $notdefteri = $db->prepare("select * from operator_not where siparis_no=:siparis_no and open=:open order by id desc ");
                            $notdefteri->execute(array(
                                'siparis_no' => $siparis['siparis_no'],
                                'open' => '1',
                            ));

                            ?>
                            <?php if($notdefteri->rowCount()>'0'  ) {?>
                                <div class="account_subpage_order_address_main mt-4">
                                    <div class="account_subpage_order_address_left ">
                                        <div class="account_subpage_order_address_h">
                                            <i class="fa fa-edit"></i> <?=$diller['users-panel-text197']?>
                                        </div>
                                        <?php foreach ($notdefteri as $not) {?>
                                            <div class="w-100 p-2 border form-group striped">
                                                <div style="font-size: 11px ;" class="mb-2">
                                                    <i class="fa fa-clock-o"></i> <?php echo date_tr('j F Y, H:i', ''.$not['tarih'].''); ?>
                                                </div>
                                                <div style="font-size: 13px ; font-weight: 600;">
                                                    <?=$not['icerik']?>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                            <?php }?>



                        </div>
                    <?php }else { ?>
                        <div class="iletisim-container-in">
                            <div class="user_subpage_favorites_noitems" >
                                <img src="i/uploads/noOrder.svg" alt="">
                                <div class="user_subpage_favorites_noitems_head m-top-10" >
                                    <?=$diller['siparis-takip-text5']?>
                                </div>
                                <div class="user_subpage_favorites_noitems_s">
                                    <?=$diller['siparis-takip-text6']?>
                                </div>
                                <a href="siparis-takip/" class="button-blue button-2x m-top-20">
                                    <?=$diller['siparis-takip-text7']?>
                                </a>
                            </div>
                        </div>
                    <?php }?>
                <?php }else { ?>
                    <?php
                    header('Location:'.$ayar['site_url'].'siparis-takip/');
                    ?>
                <?php }?>
            <?php }else { ?>
                <div class="user_page_login_form" style="width: 100%; display: flex; align-items: center; justify-content: center;  ">
                    <div class="user_page_login_form" style="border: 0; padding: 0;">
                        <div class=" teslimat-form-area">
                            <form action="" method="get" >
                                <div class="row" >
                                    <div class="form-group col-md-12">
                                        <label for="orderNumber" style="font-weight: 600;">* <?=$diller['siparis-takip-text1']?></label>
                                        <input type="number" name="sID" id="orderNumber" class="form-control" autocomplete="off" required>
                                    </div>
                                    <div class="form-group col-md-12 " style="margin-bottom: 0;" >
                                        <button  class="button-blue button-2x" style="width: 100%;  font-weight: 600 !important; " ><?=$diller['siparis-takip-text3']?> </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php }?>

        </div>







    </div>
    <!-- CONTENT AREA ============== !-->



    <?php include 'includes/template/footer.php'?>
    </body>
    </html>
    <?php include "includes/config/footer_libs.php";?>
    <?php if($_SESSION['bildirim_alert'] == 'success') {?>
        <div class="modal fade" id="succesMessagePost" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['alert-success']?></div>
                        <div>
                            <?=$diller['odeme-bildirimi-text21']?>
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
        <?php unset($_SESSION['bildirim_alert']); ?>
    <?php }?>
    <?php if($_SESSION['bildirim_alert'] == 'empty') {?>
        <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['odeme-bildirimi-text20']?>
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
        <?php unset($_SESSION['bildirim_alert']); ?>
    <?php }?>
    <?php if($_SESSION['bildirim_alert'] == 'bankasec') {?>
        <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['odeme-bildirimi-text19']?>
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
        <?php unset($_SESSION['bildirim_alert']); ?>
    <?php }?>
    <div id="shopButtonOverlay" style="font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ;">
        <div class="shopButtonT">
            <div><img src="images/load.svg" ></div>
            <div><?=$diller['teslimat-uye-text-4']?></div>
        </div>
    </div>
<?php }?>