<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($userSorgusu->rowCount()>'0' && $uyeayar['siparisler_alani'] == '1') {
$userpage = 'siparis';
$siparisID = trim(strip_tags($_GET['siparisID']));
    $siparisCek = $db->prepare("select * from siparisler where siparis_no=:siparis_no and uye_id=:uye_id ");
    $siparisCek->execute(array(
            'siparis_no' => $siparisID,
            'uye_id' => $userCek['id'],
    ));
    $row = $siparisCek->fetch(PDO::FETCH_ASSOC);
    
    $siparisDurum = $db->prepare("select * from siparis_durumlar where id=:id  ");
    $siparisDurum->execute(array(
        'id' => $row['siparis_durum'],
    ));
    $durum = $siparisDurum->fetch(PDO::FETCH_ASSOC);

    $ulkeCek = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
    $ulkeCek->execute(array(
        '3_iso' => $row['ulke']
    ));
    $ulke = $ulkeCek->fetch(PDO::FETCH_ASSOC);

    $ulkeCek2 = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
    $ulkeCek2->execute(array(
        '3_iso' => $row['fatura_ulke']
    ));
    $ulke2 = $ulkeCek2->fetch(PDO::FETCH_ASSOC);

    $parabiriMi = $db->prepare("select * from para_birimleri where kod=:kod ");
    $parabiriMi->execute(array(
        'kod' => $row['parabirimi'],
    ));
    $para = $parabiriMi->fetch(PDO::FETCH_ASSOC);

    /* İptal Talebi Sorgusu */
    $iptalSorgusuSiparis = $db->prepare("select * from siparis_iptal where siparis_no=:siparis_no and uye_id=:uye_id and durum=:durum ");
    $iptalSorgusuSiparis->execute(array(
        'siparis_no' => $row['siparis_no'],
        'uye_id' => $userCek['id'],
        'durum' => '0'
    ));
    /*  <========SON=========>>> İptal Talebi Sorgusu SON */

    /* Sipariş İptali */
    if($_POST  ) {
        if($demo != '1'  ){
            $sipID = trim(strip_tags($_POST['orderNo']));
            $sipariSorgula = $db->prepare("select * from siparisler where siparis_no=:siparis_no and uye_id=:uye_id ");
            $sipariSorgula->execute(array(
                'siparis_no' => $sipID,
                'uye_id' => $userCek['id']
            ));
            $sorguRow = $sipariSorgula->fetch(PDO::FETCH_ASSOC);
            if($sipariSorgula->rowCount()>'0'  ) {
                if($sorguRow['iptal'] != '1' && $sorguRow['iptal_aksiyon'] == '1' && $odemeayar['siparis_iptal']  == '1') {
                    $guncelle = $db->prepare("UPDATE siparisler SET
                            iptal_aksiyon=:iptal_aksiyon
                     WHERE siparis_no={$sipID}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'iptal_aksiyon' => '0'
                    ));
                    if($sonuc){
                        $timestamp = date('Y-m-d G:i:s');
                        $rand = rand(0,(int) 99999999);
                        $kaydet = $db->prepare("INSERT INTO siparis_iptal SET
                                    siparis_no=:siparis_no,
                                    tarih=:tarih,
                                    durum=:durum,
                                    yeni=:yeni,
                                    talep_no=:talep_no,
                                    uye_id=:uye_id
                            ");
                        $sonuc = $kaydet->execute(array(
                            'siparis_no' => $sipID,
                            'tarih' => $timestamp,
                            'durum' => '0',
                            'yeni' => '1',
                            'talep_no' => $rand,
                            'uye_id' => $userCek['id']
                        ));
                        if($sonuc){
                            /* E-Posta Bildirimleri */
                            if($ayar['smtp_durum'] == '1' ) {
                                include 'includes/post/mailtemp/users/siparis_iptal_mail_temp.php';
                            }

                            /* SMS */
                            if($sms['durum'] == '1' ) {
                                if($sms['sms_siparisiptal_site'] == '1' || $sms['sms_siparisiptal_user'] == '1') {
                                    include 'includes/post/smstemp/users/order_cancel_sms.php';
                                    include 'includes/post/smstemp/sms_api.php';
                                }
                            }
                            /*  <========SON=========>>> SMS SON */

                            /* Panel bildirim */
                            $kaydet = $db->prepare("INSERT INTO panel_bildirim SET
                                durum=:durum,
                                tarih=:tarih,
                                modul=:modul,
                                icerik_id=:icerik_id
                                ");
                            $sonuc = $kaydet->execute(array(
                                'durum' => '1',
                                'tarih' => $timestamp,
                                'modul' => 'siparisiptal',
                                'icerik_id' => $sipID,
                            ));
                            /*  <========SON=========>>> Panel bildirim SON */

                            /* E-Posta Bildirimleri SON */
                            $_SESSION['iptal_status'] = 'success';
                            header('Location:'.$ayar['site_url'].'hesabim/siparisler/');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }else{
            $_SESSION['demo_alert'] = 'demo';
            header('Location:'.$ayar['site_url'].'hesabim/siparis-detay/'.$_POST['orderNo'].'/');
        }
    }
    /*  <========SON=========>>> Sipariş İptali SON */
    
    if($row['kargo_sekli'] == '0' && $row['kargo_firma'] == !null && $row['kargo_takip'] == !null ) {
     $kargoFirmasi = $db->prepare("select * from kargo_firma where id=:id ");
     $kargoFirmasi->execute(array(
             'id' => $row['kargo_firma'],
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



    if($siparisCek->rowCount()>'0'  ) {
?>
<title><?php echo $diller['users-siparis-detay-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
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
            <a href="hesabim/siparisler/"><?=$diller['users-panel-baglanti-text13']?></a>
            <i class="las la-angle-double-right"></i>
            <a >#<?=$siparisID?> <?=$diller['users-panel-baglanti-text14']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->
        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_coupon_content">


            <!-- Head !-->
            <div class="user_subpage_flex_header" style="flex-direction: column">
                <div class="user_subpage_flex_header_back_href">
                    <?=$diller['users-panel-text112']?>
                    <a href="hesabim/siparisler/">
                        <?=$diller['users-panel-text67']?>
                    </a>
                </div>
                <div class="user_subpage_flex_header_h">
                    #<?=$siparisID?> <?=$diller['users-panel-text113']?>
                </div>
            </div>
            <!--  <========SON=========>>> Head SON !-->


            <?php if($row['iptal'] == '1' ) {?>
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
                    <?php echo date_tr('j F Y, H:i, l ', ''.$row['siparis_tarih'].''); ?>
                </div>
                <div class="form-group col-md-4 ticket-detail-form-area">
                    <label ><?=$diller['users-panel-text128']?></label><br>
                    <?php if($row['odeme_tur'] == '1' ) {?>
                        <?=$diller['users-panel-text105']?>
                    <?php }?>
                    <?php if($row['odeme_tur'] == '2' ) {?>
                        <?=$diller['users-panel-text104']?>
                    <?php }?>
                    <?php if($row['odeme_tur'] == '3' ) {?>
                        <?=$diller['users-panel-text107']?>
                    <?php }?>
                    <?php if($row['odeme_tur'] == '4' ) {?>
                        <?=$diller['users-panel-text106']?>
                    <?php }?>
                    <?php if($row['odeme_tur'] == 'free' ) {?>
                        <?=$diller['users-panel-text130']?>
                    <?php }?>
                </div>
                <div class="form-group col-md-4 ticket-detail-form-area">
                    <label ><?=$diller['users-panel-text129']?></label><br>
                       <?=$durum['baslik']?>
                </div>

                <?php if($row['iptal'] == '0' ||$row['iptal'] == null ) {?>

                        <?php if($odemeayar['siparis_iptal'] == '1' ) {?>
                            <?php if($row['iptal_aksiyon'] == '1' && $iptalSorgusuSiparis->rowCount()<='0' ) {?>
                                <div class="form-group col-md-4 ticket-detail-form-area">
                                    <label><?=$diller['users-panel-text126']?></label><br>
                                        <button data-toggle="modal" data-target="#cancelForm"  class="button-red rounded button-1x " name="cancelRequest">
                                            <i class="fa fa-times"></i> <?=$diller['users-panel-text103']?>
                                        </button>
                                    <div class="modal " id="cancelForm"  data-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered modal-sm  ">
                                            <div class="modal-content rounded shadow-lg">
                                                <div style="position: absolute; z-index: 9; right: 10px">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                                                        <i class="ion-ios-close-empty"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body mt-2" style="font-size: 13px ; font-weight: 600;  padding:  20px !important; letter-spacing: 0.04em!important;">
                                                    <?=$diller['users-panel-text131']?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="button-grey button-2x" data-dismiss="modal"><?=$diller['users-panel-text38']?></button>
                                                    <form action="" method="post" id="orderCancel">
                                                        <input type="hidden" name="orderNo" value="<?=$row['siparis_no']?>" >
                                                        <button id="btnCancelOrder"  class="button-green button-2x" name="cancelRequest">
                                                            <?=$diller['users-panel-text132']?>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($iptalSorgusuSiparis->rowCount()>'0'  ) {?>
                                <div class="form-group col-md-4 ticket-detail-form-area">
                                    <label><?=$diller['users-panel-text126']?></label><br>
                                    <div class="button-red-out button-1x rounded">
                                        <i class="fa fa-refresh fa-spin fa-fw"></i> <?=$diller['users-panel-text111']?>
                                    </div>
                                </div>
                            <?php }?>
                        <?php }?>
                <?php }?>

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
                            <a href="hesabim/siparis-detay/<?=$row['siparis_no']?>/?invoice=download"class="button-blue rounded button-1x">
                                <i class="fa fa-download"></i>
                                <?=$diller['users-panel-text125']?>
                            </a>
                        </div>
                    <?php }?>
                <?php }?>

            </div>
            <!--  <========SON=========>>> Sipariş Detayları SON !-->

            <?php
            $notVarmi = $db->prepare("select * from siparis_notlar where siparis_no=:siparis_no and gorunum=:gorunum order by id asc");
            $notVarmi->execute(array(
                'siparis_no' => $row['siparis_no'],
                'gorunum' => '1',
            ));
            ?>

            <?php foreach ($notVarmi as $notRow) {?>
                <div class="user_subpage_info_div_blue_2" style="background-color: #ffebd9; border: 1px solid #ffc8bd; text-align: left; ">
                    <div style="font-size: 11px !important ;  ">
                        <?php echo date_tr('j F Y, H:i ', ''.$notRow['tarih'].''); ?>
                    </div>
                    <div style="font-weight: 600; margin-top: 10px; font-size: 13px ;">
                        <?=$notRow['icerik']?>
                    </div>
                </div>
            <?php }?>


            
            <?php if($odemeayar['havale_odeme_bildirim'] == '1' && $row['odeme_tur'] == '2' && $iptalSorgusuSiparis->rowCount()<='0' && $row['iptal'] != '1'  ) {?>
                    <?php
                    $bildirimSorgusu = $db->prepare("select * from odeme_bildirim where siparis_no=:siparis_no order by id desc limit 1 ");
                    $bildirimSorgusu->execute(array(
                        'siparis_no' => $row['siparis_no'],
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
                            <a href="odeme-bildirimi/?sID=<?=$row['siparis_no']?>&delete=yes&order=new"  class="button-red button-2x m-top-20">
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
                            <?php echo number_format($row['havale_toplamtutar'], $para['para_format']); ?>
                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                <?=$para['sol_simge']?>
                            <?php }?>
                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                <?=$para['sag_simge']?>
                            <?php }?>
                        <?php }else { ?>
                            <?php echo number_format($row['havale_toplamtutar'], 2); ?> <?=$row['parabirimi']?>
                        <?php }?>
                        </strong>
                        <br><br>
                        <a href="odeme-bildirimi/?sID=<?=$row['siparis_no']?>" class="button-orange shadow rounded button-2x"><?=$diller['users-panel-text119']?></a>
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
                        <?=$row['isim']?> <?=$row['soyisim']?>
                    </div>
                    <div class="account_subpage_order_address_txt">
                        <?=$row['adresbilgisi']?>
                    </div>
                    <div class="account_subpage_order_address_txt">
                         <?=$row['ilce']?> / <?=$row['sehir']?>
                    </div>
                    <div class="account_subpage_order_address_txt">
                    <?=$diller['users-panel-text117']?> : <?=$row['postakodu']?>
                    </div>
                    <div class="account_subpage_order_address_txt" style="font-weight: 600; margin-bottom: 10px;">
                        <?=$ulke['baslik']?>
                    </div>
                    <div class="account_subpage_order_address_phone">
                       <i class="fa fa-phone"></i> +<?=$row['alan_kodu']?> <?=$row['telefon_gosterim']?>
                    </div>
                    <div class="account_subpage_order_address_phone">
                        <i class="fa fa-envelope-open-o"></i> <?=$row['eposta']?>
                    </div>
                </div>
                <?php if($odemeayar['faturasiz_teslimat'] == '0' ) {?>
                    <div class="account_subpage_order_address_right">
                        <div class="account_subpage_order_address_h">
                            <i class="las la-file-invoice"></i> <?=$diller['users-panel-text116']?>
                        </div>
                        <div class="account_subpage_order_address_name">
                            <?=$row['fatura_isim']?> <?=$row['fatura_soyisim']?>
                        </div>
                        <div class="account_subpage_order_address_txt">
                            <?=$row['fatura_adresi']?>
                        </div>
                        <div class="account_subpage_order_address_txt">
                            <?=$row['fatura_ilce']?> / <?=$row['fatura_sehir']?>
                        </div>
                        <div class="account_subpage_order_address_txt">
                            <?=$diller['users-panel-text117']?> : <?=$row['postakodu']?>
                        </div>
                        <div class="account_subpage_order_address_txt" style="font-weight: 600; margin-bottom: 10px;">
                            <?=$ulke2['baslik']?>
                        </div>
                        <div class="account_subpage_order_address_phone" style="font-weight: 600; color: orangered;">
                           <?php if($row['fatura_turu'] == '1'  ) {?>
                            <?=$diller['users-panel-text82']?>
                           <?php }?>
                           <?php if($row['fatura_turu'] == '2'  ) {?>
                            <?=$diller['users-panel-text83']?>
                           <?php }?>
                        </div>
                   
                    </div>
                <?php }?>
            </div>
            <!--  <========SON=========>>> Sipariş adresleri SON !-->

            <?php if($row['siparis_notu'] == !null ) {?>
                <!-- Mğşteri Notu !-->
                <div class="user_subpage_info_div_grey" style="padding: 25px;">
                    <strong><?=$diller['users-panel-text114']?></strong>
                    <br><br>
                    <?=$row['siparis_notu']?>
                </div>
                <!--  <========SON=========>>> Mğşteri Notu SON !-->
            <?php }?>


            <?php if($odemeayar['kargo_sistemi'] == '1' && $row['kargo_sekli'] == '0'  && $kargo_sekil_1 > '0' ) {?>
                <!-- Kargo İekli 0 = Tek Kargo Takip !-->
                <div class="account_subpage_order_cargo_main">
                    <div class="account_subpage_order_cargo_left">
                        <img src="i/cargo/<?=$kargoRow['gorsel']?>" class="border p-2"  >
                    </div>
                    <div class="account_subpage_order_cargo_right">
                        <?php if($kargoRow['takip_url'] == !null ) {?>
                            <a href="<?=$kargoRow['takip_url']?><?=$row['kargo_takip']?>" target="_blank" class="button-blue button-2x">
                                <i class="fa fa-truck"></i>
                                <?=$diller['users-panel-text136']?>
                            </a>
                        <?php }else { ?>
                            <div class="button-blue button-2x" style="cursor: text">
                                <?=$diller['users-panel-text136']?> :
                                <?=$row['kargo_takip']?>
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
                        'siparis_id' => $row['siparis_no'],
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
                                                  <?php echo number_format(kurhesapla($varsayilankur['deger'],$row['odeme_kuru'],$varyant['ek_fiyat'] ), $para['para_format']); ?>
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
                                                    <?php echo number_format(kurhesapla($varsayilankur['deger'],$row['odeme_kuru'],$varyant['ek_fiyat'] ), $para['para_format']); ?>
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
                                                    <?php echo number_format(kurhesapla($varsayilankur['deger'],$row['odeme_kuru'],$varyant['ek_fiyat'] ), $para['para_format']); ?>
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
                                                    <?php echo number_format(kurhesapla($varsayilankur['deger'],$row['odeme_kuru'],$varyant['ek_fiyat'] ), $para['para_format']); ?>
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
                                <div class="button-white button-1x rounded orderDetail_product_button" style="background-color: #ebebeb; border:1px solid #EBEBEB">
                                    <i class="fa fa-refresh fa-spin fa-fw"></i> <?=$diller['users-panel-text134']?>
                                </div>
                            <?php }?>
                            <?php if($urunRow['durum'] == '1' ) {?>
                                <div class="button-green-out button-1x rounded orderDetail_product_button" >
                                    <i class="las la-check"></i> <?=$diller['users-panel-text150']?>
                                </div>
                            <?php }?>
                            <?php if($urunRow['durum'] == '2' ) {?>
                                <div class="button-yellow-out button-1x rounded orderDetail_product_button" >
                                    <i class="fa fa-gift"></i> <?=$diller['users-panel-text151']?>
                                </div>
                            <?php }?>
                            <?php if($urunRow['durum'] == '3' ) {?>
                                <div class="button-blue-out button-1x rounded orderDetail_product_button" >
                                    <i class="las la-store"></i> <?=$diller['users-panel-text152']?>
                                </div>
                            <?php }?>
                            <?php if($urunRow['durum'] == '4' ) {?>
                                <div class="button-black-out button-1x rounded orderDetail_product_button" >
                                    <i class="las la-truck"></i> <?=$diller['users-panel-text153']?>
                                </div>
                            <?php }?>
                            <?php }?>
                            <?php if($urunRow['durum'] == '5' ) {?>
                                <div class="button-red shadow button-1x rounded orderDetail_product_button" >
                                  <i class="fa fa-reply-all"></i>  <?=$diller['users-panel-text154']?>
                                </div>
                            <?php }?>
                            <?php if($urunRow['durum'] == '6' ) {?>
                                <div class=" button-1x rounded orderDetail_product_button button-grey-out" >
                                   <i class="fa fa-times"></i> <?=$diller['users-panel-text155']?>
                                </div>
                            <?php }?>
                            <?php if($urunRow['iade_aksiyon'] == '1' && $odemeayar['siparis_urun_iade'] == '1' && $urunRow['durum'] != '6' && $urunRow['durum'] != '5'  ) {?>
                                <button data-toggle="modal" data-target="#returnOrder<?=$urunRow['stok_kodu']?>"  class="button-black button-1x rounded orderDetail_product_button">
                                    <?=$diller['users-panel-text135']?>
                                </button>
                                <div class="modal " id="returnOrder<?=$urunRow['stok_kodu']?>" data-backdrop="static"  >
                                    <div class="modal-dialog modal-dialog-centered  " >
                                        <div class="modal-content rounded shadow-lg">
                                            <form id="order_process" action="return-order-product" method="post">
                                                <div style="position: absolute; z-index: 9; right: 10px">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none">
                                                        <i class="ion-ios-close-empty"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important;">
                                                    <span style="font-weight: 700;"><?=$urunRow['urun_baslik']?></span>
                                                    <hr>
                                                    <div class="user_subpage_info_div_blue">
                                                        <?=$diller['users-panel-text156']?>
                                                    </div>
                                                    <div class="teslimat-form-area m-top-10">
                                                        <input type="text" name="sebep"   class="form-control" autocomplete="off" placeholder="<?=$diller['users-panel-text161']?>" style="height: 50px">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="button-grey button-2x"   data-dismiss="modal"><?=$diller['users-panel-text163']?></button>
                                                    <input type="hidden" name="product" value="<?=md5($urunRow['id'])?>" >
                                                    <input type="hidden" name="productNo" value="<?=$urunRow['id']?>" >
                                                    <button id="btnSubmit"  class="button-green button-2x" name="returnProduct">
                                                        <?=$diller['users-panel-text162']?>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($urunRow['iade_aksiyon'] == '0'  && $urunRow['durum'] != '6' && $urunRow['durum'] != '5') {
                                ?>
                                <?php if($iadeSorgusu->rowCount()>'0'  ) {?>
                                    <style>
                                        .tooltip{
                                            font-size: 12px;
                                        }
                                    </style>
                                <div class="button-black-out button-1x rounded orderDetail_product_button">
                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['users-panel-text160']?>"></i> <?=$diller['users-panel-text157']?>
                                </div>
                                <?php }?>
                            <?php }?>
                            <?php if($odemeayar['kargo_sistemi'] == '1' && $row['kargo_sekli'] == '1' && $urunRow['durum'] != '6' && $urunRow['durum'] != '5' ) {
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
                                        <?php }?>
                                    <?php }else { ?>
                                       <?php if($siparisKargoRow['kargo_takip'] == !null  ) {?>
                                        <div class="ml-2">
                                            <div class="d-flex flex-column flex-wrap align-items-start bg-light p-2 ">
                                                <img src="i/cargo/<?=$kargoRow['gorsel']?>" style="max-height: 40px" class="border mb-2">
                                                <div class="font-12"><?=$diller['users-panel-text136']?></div>
                                                <div><?=$siparisKargoRow['kargo_takip']?></div>
                                            </div>
                                        </div>
                                        <?php }?>
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
                                <?php if($row['odeme_tur'] == '2' ) { ?>
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
                                        <?php echo number_format($urunRow['havale_kdvsiz_tutar'], 2); ?> <?=$row['parabirimi']?>
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
                                        <?php echo number_format($urunRow['kdvsiz_tutar'], 2); ?> <?=$row['parabirimi']?>
                                    <?php }?>
                               <?php }?>
                            </div>
                        </div>

                        <?php if($row['odeme_tur'] == '2' ) {?>
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
                                            <?php echo number_format($urunRow['havale_kdv_tutar'], 2); ?> <?=$row['parabirimi']?>
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
                                            <?php echo number_format($urunRow['kdv_tutar'], 2); ?> <?=$row['parabirimi']?>
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
                                        <?php echo number_format($urunRow['kargo_tutar'], 2); ?> <?=$row['parabirimi']?>
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
                                <?php if($row['odeme_tur'] == '2' ) { ?>
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
                                        <?php echo number_format($urunRow['havale_kdvsiz_tutar']+$urunRow['havale_kdv_tutar']+$urunRow['kargo_tutar'], 2); ?> <?=$row['parabirimi']?>
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
                                        <?php echo number_format($urunRow['kdvsiz_tutar']+$urunRow['kdv_tutar']+$urunRow['kargo_tutar'], 2); ?> <?=$row['parabirimi']?>
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

                    <?php if($row['kargo_limit_durum'] == '1' ) {?>
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

                    <?php if($row['havale_kargo_limit_durum'] == '1' ) {?>
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
                    
                    <?php if($row['doviz_durum'] == '1'  ) {?>
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
                                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['users-panel-text148']?>"></i>  <?=$diller['users-panel-text146']?> : <?=$row['odeme_kuru']?>
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
                                <?php if($row['odeme_tur'] == '2' ) { ?>
                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                            <?=$para['sol_simge']?>
                                        <?php }?>
                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                            <?=$para['sag_simge']?>
                                        <?php }?>
                                        <?php echo number_format($row['havale_aratutar'], $para['para_format']); ?>
                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                            <?=$para['sol_simge']?>
                                        <?php }?>
                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                            <?=$para['sag_simge']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php echo number_format($row['havale_aratutar'], 2); ?> <?=$row['parabirimi']?>
                                    <?php }?>
                                <?php }else { ?>
                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                            <?=$para['sol_simge']?>
                                        <?php }?>
                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                            <?=$para['sag_simge']?>
                                        <?php }?>
                                        <?php echo number_format($row['ara_tutar'], $para['para_format']); ?>
                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                            <?=$para['sol_simge']?>
                                        <?php }?>
                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                            <?=$para['sag_simge']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php echo number_format($row['ara_tutar'], 2); ?> <?=$row['parabirimi']?>
                                    <?php }?>
                                <?php }?>
                            </div>
                        </div>
                        <?php if($odemeayar['faturasiz_teslimat'] == '0'  ) {?>
                            <?php if($row['odeme_tur'] == '2' && $row['havale_kdvtutar'] >'0' ) { ?>
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
                                                <?php echo number_format($row['havale_kdvtutar'], $para['para_format']); ?>
                                                <?php if($para['simge_gosterim'] == '2' ) {?>
                                                    <?=$para['sol_simge']?>
                                                <?php }?>
                                                <?php if($para['simge_gosterim'] == '3' ) {?>
                                                    <?=$para['sag_simge']?>
                                                <?php }?>
                                            <?php }else { ?>
                                                <?php echo number_format($row['havale_kdvtutar'], 2); ?> <?=$row['parabirimi']?>
                                            <?php }?>
                                    </div>
                                </div>
                            <?php }else { ?>
                                <?php if($row['kdv_tutar'] >'0'  ) {?>
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
                                                    <?php echo number_format($row['kdv_tutar'], $para['para_format']); ?>
                                                    <?php if($para['simge_gosterim'] == '2' ) {?>
                                                        <?=$para['sol_simge']?>
                                                    <?php }?>
                                                    <?php if($para['simge_gosterim'] == '3' ) {?>
                                                        <?=$para['sag_simge']?>
                                                    <?php }?>
                                                <?php }else { ?>
                                                    <?php echo number_format($row['kdv_tutar'], 2); ?> <?=$row['parabirimi']?>
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
                                    <?php if($row['odeme_tur'] == '2' ) { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['havale_kargotutar'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <?php echo number_format($row['havale_kargotutar'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['kargo_tutar'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <?php echo number_format($row['kargo_tutar'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>

                        <?php if($row['sepette_ek_indirim'] >'0' ) {?>
                            <div class="account_subpage_summary_order_box_s">
                                <div class="account_subpage_summary_order_box_s_left">
                                    <?=$diller['sepet-ek-indirim']?>
                                </div>
                                <div class="account_subpage_summary_order_box_s_right">
                                    <?php if($row['odeme_tur'] == '2' ) { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['sepette_ek_indirim'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            - <?php echo number_format($row['sepette_ek_indirim'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['sepette_ek_indirim'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            - <?php echo number_format($row['sepette_ek_indirim'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>

                        <?php if($row['ilk_siparis_indirim'] >'0' ) {?>
                            <div class="account_subpage_summary_order_box_s">
                                <div class="account_subpage_summary_order_box_s_left">
                                    <?=$diller['sepet-ilk-siparis-indirim']?>
                                </div>
                                <div class="account_subpage_summary_order_box_s_right">
                                    <?php if($row['odeme_tur'] == '2' ) { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['ilk_siparis_indirim'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            - <?php echo number_format($row['ilk_siparis_indirim'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['ilk_siparis_indirim'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            - <?php echo number_format($row['ilk_siparis_indirim'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>

                        <?php if($row['grup_indirim'] >'0' ) {?>
                            <div class="account_subpage_summary_order_box_s">
                                <div class="account_subpage_summary_order_box_s_left">
                                    <?=$diller['sepet-size-ozel-indirim']?>
                                </div>
                                <div class="account_subpage_summary_order_box_s_right">
                                    <?php if($row['odeme_tur'] == '2' ) { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['grup_indirim'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            - <?php echo number_format($row['grup_indirim'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['grup_indirim'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            - <?php echo number_format($row['grup_indirim'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>

                        <?php if($row['indirim_tutar'] >'0' ) {?>
                            <div class="account_subpage_summary_order_box_s">
                                <div class="account_subpage_summary_order_box_s_left">
                                    <?=$diller['users-panel-text142']?>
                                </div>
                                <div class="account_subpage_summary_order_box_s_right">
                                    <?php if($row['odeme_tur'] == '2' ) { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['indirim_tutar'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            - <?php echo number_format($row['indirim_tutar'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                            - <?php if($para['simge_gosterim'] == '0' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '1' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                            <?php echo number_format($row['indirim_tutar'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            - <?php echo number_format($row['indirim_tutar'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>

                        <?php if($row['kapida_odeme_bedeli'] >'0' ) {?>
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
                                            <?php echo number_format($row['kapida_odeme_bedeli'], $para['para_format']); ?>
                                            <?php if($para['simge_gosterim'] == '2' ) {?>
                                                <?=$para['sol_simge']?>
                                            <?php }?>
                                            <?php if($para['simge_gosterim'] == '3' ) {?>
                                                <?=$para['sag_simge']?>
                                            <?php }?>
                                        <?php }else { ?>
                                            <?php echo number_format($row['kapida_odeme_bedeli'], 2); ?> <?=$row['parabirimi']?>
                                        <?php }?>
                                </div>
                            </div>
                        <?php }?>

                        <div class="account_subpage_summary_order_box_s">
                            <div class="account_subpage_summary_order_box_s_left" style="font-size: 15px ;">
                                <?=$diller['users-panel-text144']?>
                            </div>
                            <div class="account_subpage_summary_order_box_s_right" style="font-size: 18px ;">
                                <?php if($row['odeme_tur'] == '2' ) { ?>
                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                            <?=$para['sol_simge']?>
                                        <?php }?>
                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                            <?=$para['sag_simge']?>
                                        <?php }?>
                                        <?php echo number_format($row['havale_toplamtutar'], $para['para_format']); ?>
                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                            <?=$para['sol_simge']?>
                                        <?php }?>
                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                            <?=$para['sag_simge']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php echo number_format($row['havale_toplamtutar'], 2); ?> <?=$row['parabirimi']?>
                                    <?php }?>
                                <?php }else { ?>
                                    <?php if($parabiriMi->rowCount()>'0'  ) {?>
                                        <?php if($para['simge_gosterim'] == '0' ) {?>
                                            <?=$para['sol_simge']?>
                                        <?php }?>
                                        <?php if($para['simge_gosterim'] == '1' ) {?>
                                            <?=$para['sag_simge']?>
                                        <?php }?>
                                        <?php echo number_format($row['toplam_tutar'], $para['para_format']); ?>
                                        <?php if($para['simge_gosterim'] == '2' ) {?>
                                            <?=$para['sol_simge']?>
                                        <?php }?>
                                        <?php if($para['simge_gosterim'] == '3' ) {?>
                                            <?=$para['sag_simge']?>
                                        <?php }?>
                                    <?php }else { ?>
                                        <?php echo number_format($row['toplam_tutar'], 2); ?> <?=$row['parabirimi']?>
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
                'siparis_no' => $row['siparis_no'],
                'open' => '1'
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
        <!--  <========SON=========>>> Right Content SON !-->



    </div>


</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>
        <?php if($_SESSION['iade_status'] == 'empty'  ) {?>
            <div class="modal fade" id="noArea" data-backdrop="static" >
                <div class="modal-dialog modal-dialog-centered modal-sm ">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                        <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                            <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                            <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                            <div>
                                <?=$diller['users-panel-text164']?>
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
            <?php unset($_SESSION['iade_status'] ) ?>
        <?php }?>
        <script>
            $("#btnSubmit").click(function () {
                $(this).text("<?=$diller['users-panel-text165']?>");
            });
            $('#order_process').bind('submit', function (e) {
                var button = $('#btnSubmit');
                button.prop('disabled', true);
                var valid = true;
                if (!valid) {
                    e.preventDefault();
                    button.prop('disabled', false);
                }
            });
            $("#btnCancelOrder").click(function () {
                $(this).text("<?=$diller['users-panel-text165']?>");
            });
            $('#orderCancel').bind('submit', function (e) {
                var button = $('#btnCancelOrder');
                button.prop('disabled', true);
                var valid = true;
                if (!valid) {
                    e.preventDefault();
                    button.prop('disabled', false);
                }
            });
        </script>
    <?php
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
