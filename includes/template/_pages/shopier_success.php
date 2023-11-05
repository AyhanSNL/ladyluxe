<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($odemeayar['sepet_sistemi'] == '1' ) {
//todo ioncube
?>
<?php
$page_header_setting = $db->prepare("select * from page_header where page_id='ordersuccess' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);
?>
    <title><?=$diller['siparis-basarili-anabaslik']?> - <?php echo $ayar['site_baslik']?></title>
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
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>
<?php include 'includes/template/helper/page-headers-stil.php';  ?>
<style>
    .tooltip{
        font-size: 12px !important ;
    }
    .success-order-main-div{
        font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
    }
    .success-order-buttons-area a{
        font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
    }
</style>
<?php if($odemeayar['pos_tur'] == 'shopier' ) {?>
    <?php
    include_once 'includes/template/vpos/shopier/Shopier.php';
    $Api_Key= $odemeayar['shopier_user'];
    $Api_Secret= $odemeayar['shopier_pass'];
    $shopier = new Shopier($Api_Key, $Api_Secret);
    if ($shopier->verifyShopierSignature($_POST))  // eğer shopierin hash ile sisteminizdeki hash verify ise bu alan sadece 2 taraflı güvenlik içindir.
    {
        $order_id = $_POST['platform_order_id'];
        $random_nr = $_POST['random_nr'];
        $payment_id = $_POST['payment_id'];
        $status = $_POST['status'];

        $orderToMe = $db->prepare("select * from siparisler where shopier_id=:shopier_id and onay=:onay ");
        $orderToMe->execute(array(
            'shopier_id' => $order_id,
            'onay' => '0'
        ));
        $sip = $orderToMe->fetch(PDO::FETCH_ASSOC);
        if($orderToMe->rowCount()<='0'  ) {
            header('Location:'.$ayar['site_url'].'404');
            exit();
        }
        $sID = $sip['siparis_no'];
        $orderMoneyType = $db->prepare("select * from para_birimleri where kod=:kod  ");
        $orderMoneyType->execute(array(
            'kod' => $sip['parabirimi']
        ));
        $ordermoney = $orderMoneyType->fetch(PDO::FETCH_ASSOC);

        /* Veritabanından siparişi onayla */
        $guncelle = $db->prepare("UPDATE siparisler SET
                yeni=:yeni,
                shopier_siparis_no=:shopier_siparis_no,
                 onay=:onay   
             WHERE siparis_no={$sip['siparis_no']}      
            ");
        $sonuc = $guncelle->execute(array(
            'yeni' => '1',
            'shopier_siparis_no' => $payment_id,
            'onay' => '1'
        ));
        /* Kupon indirimi var ise kullanımı güncelle */
        $guncelle_kupon = $db->prepare("UPDATE sepet_kupon SET
                        kullanim=:kullanim,
                        siparis_id=:siparis_id
                        WHERE durum='1' and uye_id={$sip['uye_id']} and kullanim='0'  
                ");
        $sonuc = $guncelle_kupon->execute(array(
            'kullanim' => '1',
            'siparis_id' => $sip['siparis_no']
        ));
        /*  <========SON=========>>> Kupon indirimi var ise kullanımı güncelle SON */

        /* E-Posta Bildirimleri */
        if($ayar['smtp_durum'] == '1' ) {
            include "includes/post/mailtemp/siparisler/kredi_kart_mail_temp.php";
        }
        /* E-Posta Bildirimleri SON */

        /* SMS */
        if($sms['durum'] == '1' ) {
            if($sms['sms_siparis_site'] == '1' || $sms['sms_siparis_user'] == '1') {
                $yenitelefon = $sip['telefon'];
                $isim = $sip['isim'];
                $soyisim = $sip['soyisim'];
                $siparis_id = $sID;
                include 'includes/post/smstemp/siparis/siparis_sms.php';
                include 'includes/post/smstemp/sms_api.php';
            }
        }
        /*  <========SON=========>>> SMS SON */

        /* Site içi bildirim */
        $timestamp = date('Y-m-d G:i:s');
        if($bildirimayar['durum'] == '1' ) {
            $user = $sip['uye_id'];
            $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
            $kullaniciCek->execute(array(
                'id' => $user
            ));
            if($kullaniciCek->rowCount()>'0'  ) {
                $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                $rand = rand(0,(int) 9999999999);
                $baslik = $diller['bildirimler-text15'];
                $icerik = ''.$diller['oto-eposta-content-text1'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$sip['siparis_no'].' '.$diller['bildirimler-text17'].' ';
                /* Site içi bildirim gönder */
                $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                                    bildirim_id=:bildirim_id,
                                                                    baslik=:baslik,
                                                                    icerik=:icerik,
                                                                    tarih=:tarih,
                                                                    tur=:tur,
                                                                    ikon=:ikon,
                                                                    uye_id=:uye_id,
                                                                    durum=:durum,
                                                                    dil=:dil
                                                                    ");
                $sonuc = $kaydet->execute(array(
                    'bildirim_id' => $rand,
                    'baslik' => $baslik,
                    'icerik' => $icerik,
                    'tarih' => $timestamp,
                    'tur' => '2',
                    'ikon' => '&#128722',
                    'uye_id' => $user,
                    'durum' => '1',
                    'dil' => $_SESSION['dil']
                ));
                /*  <========SON=========>>> Site içi bildirim gönder SON */

            }
        }
        /*  <========SON=========>>> Site içi bildirim SON */

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
            'modul' => 'siparis',
            'icerik_id' => $sip['siparis_no']
        ));
        /*  <========SON=========>>> Panel bildirim SON */

        /* Sipariş ürün satış sayıları */
        $siparisUrunListesi = $db->prepare("select adet,urun_id,varyant_stok_durum,varyantlar from siparis_urunler where siparis_id=:siparis_id ");
        $siparisUrunListesi->execute(array(
            'siparis_id' => $sip['siparis_no'],
        ));
        foreach ($siparisUrunListesi as $sis){
            $urun = $db->prepare("select satis_adet from urun where id=:id ");
            $urun->execute(array(
                'id' => $sis['urun_id'],
            ));
            $u = $urun->fetch(PDO::FETCH_ASSOC);
            $satisCount = $u['satis_adet'];

            $guncelle = $db->prepare("UPDATE urun SET
                                        satis_adet=:satis_adet
                                 WHERE id={$sis['urun_id']}      
                                ");
            $sonuc = $guncelle->execute(array(
                'satis_adet' => $satisCount+$sis['adet'],
            ));
            /* varyant ve ana ürün stok işlemleri */
            if($sis['varyant_stok_durum'] == '0'  ) {
                $mainProductStock_Query = $db->prepare("select * from urun where id=:id ");
                $mainProductStock_Query->execute(array(
                    'id' => $sis['urun_id']
                ));
                $stokMainRow = $mainProductStock_Query->fetch(PDO::FETCH_ASSOC);
                if($odemeayar['urun_stok_dus'] == '1' ) {
                    $guncelle = $db->prepare("UPDATE urun SET
                         stok=:stok
                  WHERE id={$sis['urun_id']}      
                 ");
                    $sonuc = $guncelle->execute(array(
                        'stok' => $stokMainRow['stok']-$sis['adet']
                    ));
                }
            }
            if($sis['varyant_stok_durum'] == '1'  ) {
                /* varyant Stok İşlemleri */
                $detailVariant_Stok_Query = $db->prepare("select * from detay_varyant_stok where varyant=:varyant and urun_id=:urun_id ");
                $detailVariant_Stok_Query->execute(array(
                    'varyant' => $sis['varyantlar'],
                    'urun_id' => $sis['urun_id']
                ));
                $stokRow = $detailVariant_Stok_Query->fetch(PDO::FETCH_ASSOC);
                if($detailVariant_Stok_Query->rowCount()>'0' ) {
                    if($odemeayar['urun_stok_dus'] == '1' ) {
                        /* Stoktan Düşme için mevcut stok - adet yap */
                        $guncelle = $db->prepare("UPDATE detay_varyant_stok SET
                         stok=:stok
                          WHERE id={$stokRow['id']}      
                         ");
                        $sonuc = $guncelle->execute(array(
                            'stok' => $stokRow['stok']-$sis['adet']
                        ));
                        /* Stoktan Düşme için mevcut stok - adet yap SON */
                    }
                }
                /* varyant Stok İşlemleri SON */
            }
            /* varyant ve ana ürün stok işlemleri SON */
        }
        /*  <========SON=========>>>  Sipariş ürün satış sayıları SON */

        /* Üye satın aldı ise onu tekrar session'a ekle */
        if($sip['uye_id'] >'0' ) {
            $uyeSorgusuYap = $db->prepare("select * from uyeler where id=:id and onay=:onay ");
            $uyeSorgusuYap->execute(array(
                'id' => $sip['uye_id'],
                'onay' => '1'
            ));
            if($uyeSorgusuYap->rowCount()>'0'  ) {
                $uyeRows = $uyeSorgusuYap->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_email_address'] = $uyeRows['eposta'];
            }
        }
        /*  <========SON=========>>> Üye satın aldı ise onu tekrar session'a ekle SON */

        /* İlk siparişe özel indirim kontrolü */
        $ilkSiparisSorgu = $db->prepare("select * from indirim_ilk_siparis_kayit where siparis_id=:siparis_id and onay=:onay ");
        $ilkSiparisSorgu->execute(array(
            'siparis_id' => $sip['siparis_no'],
            'onay' => '0'
        ));
        if($ilkSiparisSorgu->rowCount()>'0'  ) {
            $guncelle = $db->prepare("UPDATE indirim_ilk_siparis_kayit SET
              onay=:onay   
          WHERE siparis_id={$sip['siparis_no']}      
         ");
            $sonuc = $guncelle->execute(array(
                'onay' => '1'
            ));
        }
        /*  <========SON=========>>> İlk siparişe özel indirim kontrolü SON */

        $ip = $_SERVER["REMOTE_ADDR"];
        $silmeislem = $db->prepare("DELETE from sepet WHERE ip=:ip");
        $silmeislem->execute(array(
            'ip' => $ip
        ));


        ?>
        <div class="success-order-main-div" style="background-color: #<?=$odemeayar['alisveris_arkaplan']?>;">
            <?php if($pagehead['durum'] == '1' ) {?>
                <div class="page-banner-main" >
                    <div class="page-banner-in-text">
                        <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                            <i class="fa fa-check"></i> <?=$diller['siparis-basarili-anabaslik']?>
                        </div>
                        <div class="page-banner-links ">
                            <a href="index.html"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                            <span>/</span>
                            <a><?=$diller['siparis-basarili-anabaslik']?></a>
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
            <div class="sucess-order-in-div">

                <div class="success-order-check-mark"></div>
                <div class="success-order-h">
                    <?=$diller['siparis-basarili-aciklama1']?>
                </div>
                <div class="success-order-h-2">
                    <?=$diller['siparis-basarili-aciklama2']?> <span id="orderNumber"><?=$sip['siparis_no']?></span>
                    <button onclick="copyToClipboard('orderNumber')" data-toggle="tooltip" data-placement="top" title="<?=$diller['siparis-basarili-aciklama3']?>">
                        <i class="fa fa-copy"></i>
                    </button>
                </div>
                <div class="success-order-h-3" >
                    <?=$diller['siparis-basarili-aciklama8']?>
                </div>

                <div class="success-order-buttons-area-ccard">

                    <!-- Alışverişe Devam !-->
                    <a href="<?=$siteurl?>" class="button-blue button-2x" target="_blank" style="text-transform: uppercase;"><?=$diller['sepet-alisverise-devam']?></a>
                    <!--  Alışverişe Devam !-->

                    <!-- Sipariş Detayı !-->
                    <a href="siparis-takip/?sID=<?=$sip['siparis_no']?>" class="button-grey button-2x" target="_blank"><?=$diller['siparis-basarili-button3']?></a>
                    <!-- Sipariş Detayı SON !-->
                </div>
                <div class="sucess-order-bottom-div">
                    <i class="fa fa-exclamation-triangle"></i>  <?=$diller['siparis-basarili-aciklama6']?>
                </div>
            </div>
        </div>
    <?php }else {
        header('Location:'.$siteurl.'404');
        exit();
    }
}
}else {
    header('Location:'.$siteurl.'404');
}
include 'includes/template/footer.php'?>
</body>
</html>
<?php include "includes/config/footer_libs.php";?>
