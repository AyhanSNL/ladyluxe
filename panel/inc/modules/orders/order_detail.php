<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'orders';
$orderDetail = $db->prepare("select * from siparisler where siparis_no=:siparis_no and onay=:onay ");
$orderDetail->execute(array(
    'siparis_no' => $_GET['orderID'],
    'onay' => '1',
));

$guncelle = $db->prepare("UPDATE siparisler SET
        yeni=:yeni
 WHERE siparis_no={$_GET['orderID']}      
");
$sonuc = $guncelle->execute(array(
    'yeni' => '0',
));


$row = $orderDetail->fetch(PDO::FETCH_ASSOC);

/* Ülke */
$ulke = $db->prepare("select baslik from ulkeler where 3_iso=:3_iso ");
$ulke->execute(array(
    '3_iso' => $row['ulke'],
));
$ulk = $ulke->fetch(PDO::FETCH_ASSOC);
$ulke2 = $db->prepare("select baslik from ulkeler where 3_iso=:3_iso ");
$ulke2->execute(array(
    '3_iso' => $row['fatura_ulke'],
));
$ulk2 = $ulke2->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Ülke SON */

if($row['uye_id'] >'0' ) {
    $uyes = $db->prepare("select * from uyeler where id=:id ");
    $uyes->execute(array(
        'id' => $row['uye_id'],
    ));
    if($uyes->rowCount()>'0'  ) {
        $uyevar = '1';
    }else{
        $uyevar = '0';
    }
}

if($orderDetail->rowCount()<='0'  ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=orders');
    exit();
}

/* Sipariş Durumlar */
$sipDurum = $db->prepare("select * from siparis_durumlar where durum=:durum order by sira asc ");
$sipDurum->execute(array(
    'durum' => '1',
));
/*  <========SON=========>>> Sipariş Durumlar SON */


/* E-Fatura Kontrolü */
$faturaKontrol = $db->prepare("select * from siparis_fatura where siparis_no=:siparis_no  ");
$faturaKontrol->execute(array(
    'siparis_no' => $row['siparis_no'],
));
$fat =  $faturaKontrol->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> E-Fatura Kontrolü SON */

/* İptal Sorgusu */
$iptal = $db->prepare("select * from siparis_iptal where siparis_no=:siparis_no ");
$iptal->execute(array(
    'siparis_no' => $row['siparis_no'],
));

if($iptal->rowCount()>'0'  ) {
 $guncelle = $db->prepare("UPDATE siparis_iptal SET
         yeni=:yeni
  WHERE siparis_no={$row['siparis_no']}      
 ");
 $sonuc = $guncelle->execute(array(
     'yeni' => '0',
 ));
}
/*  <========SON=========>>> İptal Sorgusu SON */

/* Ödeme bildirimi sorgusu */
$odemeBildir = $db->prepare("select * from odeme_bildirim where siparis_no=:siparis_no ");
$odemeBildir->execute(array(
    'siparis_no' => $row['siparis_no'],
));
$o = $odemeBildir->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Ödeme bildirimi sorgusu SON */

/* Kargo İçin Ürün Listesi */
$siparis_urunler = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
$siparis_urunler->execute(array(
    'siparis_id' => $row['siparis_no'],
));
/*  <========SON=========>>> Kargo İçin Ürün Listesi SON */

/* Operatör Notları */
$notdefteri = $db->prepare("select * from operator_not where siparis_no=:siparis_no order by id desc ");
$notdefteri->execute(array(
    'siparis_no' => $row['siparis_no'],
));
/*  <========SON=========>>> Operatör Notları SON */

/* Sipariş Ürün Listesi */
$urunListesi = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
$urunListesi->execute(array(
    'siparis_id' => $row['siparis_no'],
));
/*  <========SON=========>>> Sipariş Ürün Listesi SON */

$parabiriMi = $db->prepare("select * from para_birimleri where kod=:kod ");
$parabiriMi->execute(array(
    'kod' => $row['parabirimi'],
));
$para = $parabiriMi->fetch(PDO::FETCH_ASSOC);


/* Kupon */
$KuponCek = $db->prepare("select * from sepet_kupon where siparis_id=:siparis_id and kullanim=:kullanim ");
$KuponCek->execute(array(
    'siparis_id' => $row['siparis_no'],
    'kullanim' => '1',
));
/*  <========SON=========>>> Kupon SON */
?>
<title>#<?=$row['siparis_no']?> <?=$diller['adminpanel-form-text-1451']?> - <?=$panelayar['baslik']?></title>
<style>
    .ssa:before{
        display: none;
    }
    .kustom-checkbox label:before{
        margin-right: 10px;
    }
    .kustom-checkbox label {
        font-size: 13px ;
        font-weight: 200 !important;
    }
    .show > .dropdown-menu{
        z-index: 99999 !important;
    }
</style>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-16']?></a>
                                <a href="pages.php?page=orders"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-17']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> #<?=$row['siparis_no']?> <?=$diller['adminpanel-form-text-1451']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1') {?>
            <div class="row">

                <?php include 'inc/modules/_helper/orders_leftbar.php'; ?>



                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">


                            <!-- Header !-->
                            <a href="pages.php?page=orders" class="btn btn-outline-dark   btn-sm  " >
                                <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                            </a>
                            <div class="d-flex align-items-center flex-wrap justify-content-between  pb-2  mt-2" >
                                <h5>#<?=$row['siparis_no']?> <?=$diller['adminpanel-form-text-1451']?></h5>
                                <div class="dropdown d-inline-block d-flex flex-wrap">
                                        <a href="" class="btn btn-light  border btn-sm  " type="button" style="font-size: 14px ; " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                            <i class="fa fa-print"></i> <?=$diller['adminpanel-form-text-1453']?>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right ssa border p-1  " style="margin-top: 4px !important;">
                                            <div>
                                                <a href="print.php?print=order&orderID=<?=$row['siparis_no']?>" target="_blank" class="dropdown-item cursor-pointer">
                                                    <?=$diller['adminpanel-form-text-1477']?>
                                                </a>
                                                <?php if($faturaKontrol->rowCount()>'0'  ) {?>
                                                    <a href="post.php?process=order_post&status=invoice_download&no=<?=$row['siparis_no']?>" target="_blank" class="dropdown-item cursor-pointer">
                                                        <?=$diller['adminpanel-form-text-1464']?>
                                                    </a>
                                                <?php }?>
                                                <a href="print.php?print=invoice&orderID=<?=$row['siparis_no']?>" target="_blank" class="dropdown-item cursor-pointer"><?=$diller['adminpanel-form-text-1478']?></a>

                                            </div>
                                        </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Header SON !-->




                            <div class="row">

                                <!-- Ödeme bildirimi !-->
                                <?php if($row['iptal'] != '1'  && $row['odeme_tur'] == '2'  && $odemeRow['havale_odeme_bildirim'] == '1') {?>
                                    <?php if($odemeBildir->rowCount()<= '0' ) {?>
                                        <div class="col-md-12 mb-3">
                                            <div class="pt-3 pb-3 pl-3 pr-3 d-flex align-items-center text-white justify-content-start flex-wrap bg-primary" >
                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <div>
                                                    <div style="font-size: 18px; font-weight: 600;">
                                                        <?=$diller['adminpanel-form-text-1480']?>
                                                    </div>
                                                    <div class="w-100">
                                                        <?=$diller['adminpanel-form-text-1481']?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }else {

                                        $banka = $db->prepare("select * from bankalar where id=:id ");
                                        $banka->execute(array(
                                            'id' => $o['banka'],
                                        ));
                                        $bankRow = $banka->fetch(PDO::FETCH_ASSOC);

                                        ?>
                                        <!-- ödeme bildirimi var !-->
                                        <?php if($o['durum'] == '0' ) {?>
                                            <div class="col-md-12 mb-3">
                                                <div class="pt-3 pb-3 pl-3 pr-3 d-flex align-items-center text-dark border border-success justify-content-between flex-wrap " >
                                                    <div class="d-flex align-items-center justify-content-start flex-wrap">
                                                        <div class="spinner-grow text-success mr-2" role="status" style="width: 10px; height: 10px">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <div>
                                                            <div class="text-success" style="font-size: 18px; font-weight: 600;">
                                                                <?=$diller['adminpanel-form-text-1482']?>
                                                            </div>
                                                            <div class="w-100 text-dark">
                                                                <?=$diller['adminpanel-form-text-1483']?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a  class="btn btn-success text-white d-flex align-items-center justify-content-center mt-2 mb-2"  data-toggle="collapse" data-target="#bildirimAcc" aria-expanded="false" aria-controls="collapseForm">
                                                        <?=$diller['adminpanel-form-text-1484']?>  <i class="fas fa-sort-down ml-1" style="line-height: 11px; margin-top: -6px;"></i>
                                                    </a>
                                                    <div id="accordion" class="accordion w-100">
                                                        <div class="collapse " id="bildirimAcc" data-parent="#accordion">
                                                            <div class="border-top border-grey mt-2 pt-2">
                                                                <div class="row mt-3">
                                                                    <div class="form-group col-md-9">
                                                                        <div class="row d-flex align-items-center justify-content-between flex-wrap">

                                                                            <?php if($banka->rowCount()>'0'  ) {?>
                                                                                <div class="col-md-3 form-group">
                                                                                    <div style="font-size: 14px ;">
                                                                                        <img src="../i/banks/<?=$bankRow['gorsel']?>"class="img-fluid border" style="width: 100%">
                                                                                        <div class="bg-light text-center p-1">
                                                                                            <?=$bankRow['banka_adi']?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php }else { ?>
                                                                                <div class="col-md-2 form-group">
                                                                                    <label ><?=$diller['adminpanel-form-text-1485']?></label>
                                                                                    <div style="font-size: 14px ;">
                                                                                        <div class="bg-light text-center p-1">
                                                                                            <?=$diller['adminpanel-form-text-1486']?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php }?>
                                                                            <div class="col-md-auto form-group">
                                                                                <label ><?=$diller['adminpanel-form-text-1487']?></label>
                                                                                <div style="font-size: 14px ;">
                                                                                    <?=$o['gonderen']?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-auto form-group">
                                                                                <label ><?=$diller['adminpanel-form-text-1488']?></label>
                                                                                <div style="font-size: 14px ;">
                                                                                    <?php echo number_format($o['odeme_tutar'], 2); ?> <?=$o['parabirimi']?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-auto form-group">
                                                                                <label ><?=$diller['adminpanel-form-text-1489']?></label>
                                                                                <div style="font-size: 14px ;">
                                                                                    <?php echo date_tr('j F Y, H:i', ''.$o['tarih'].''); ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-auto form-group">
                                                                                <label ><?=$diller['adminpanel-form-text-1490']?></label>
                                                                                <div style="font-size: 14px ;">
                                                                                    <?=$o['gonderen_not']?>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-3 justify-content-end d-flex align-items-center flex-wrap">
                                                                        <div class="w-100 text-right" style="font-size: 14px ;">
                                                                            <a href="" data-href-2="post.php?process=order_post&status=transfer_no&no=<?=$row['siparis_no']?>" data-href="post.php?process=order_post&status=transfer_confirm&no=<?=$row['siparis_no']?>"  data-toggle="modal" data-target="#bank-confirm" style="width: 150px"  class="btn btn-primary btn-sm m-1">
                                                                                <i class="fa fa-wrench"></i>  <?=$diller['adminpanel-form-text-1362']?>
                                                                            </a>
                                                                            <br>
                                                                            <a href="" data-href="post.php?process=order_post&status=transfer_delete&no=<?=$row['siparis_no']?>"   data-toggle="modal" data-target="#confirm-delete"  style="width: 150px" class="btn btn-danger  btn-sm m-1"><i class="fa fa-trash"></i> <?=$diller['adminpanel-form-text-1491']?></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?php if($o['durum'] == '1' ) {?>
                                            <div class="col-md-12 mb-3">
                                                <div class="pt-3 pb-3 pl-3 pr-3 d-flex align-items-center text-white bg-success border border-success justify-content-between flex-wrap " >
                                                    <div class="d-flex align-items-center justify-content-start ">
                                                        <i class="fa fa-check mr-2"></i>
                                                        <div  style="font-size: 18px; font-weight: 600;">
                                                            <?=$diller['adminpanel-form-text-1492']?>
                                                        </div>
                                                    </div>
                                                    <a href="post.php?process=order_post&status=transfer_pasive&no=<?=$row['siparis_no']?>" class="btn btn-light btn-sm  d-flex align-items-center justify-content-center mt-2 mb-2"  >
                                                        <?=$diller['adminpanel-form-text-1493']?>  <i class="fas fa-undo ml-2" style="font-size: 11px ;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <?php if($o['durum'] == '2' ) {?>
                                            <div class="col-md-12 mb-3">
                                                <div class="pt-3 pb-3 pl-3 pr-3 d-flex align-items-center text-white bg-danger  justify-content-between flex-wrap " >
                                                    <div class="d-flex align-items-center justify-content-start ">
                                                        <i class="fa fa-times mr-2"></i>
                                                        <div  style="font-size: 18px; font-weight: 600;">
                                                            <?=$diller['adminpanel-form-text-1494']?>
                                                        </div>
                                                    </div>
                                                    <a href="post.php?process=order_post&status=transfer_pasive&no=<?=$row['siparis_no']?>" class="btn btn-light btn-sm  d-flex align-items-center justify-content-center mt-2 mb-2"  >
                                                        <?=$diller['adminpanel-form-text-1493']?>  <i class="fas fa-undo ml-2" style="font-size: 11px ;"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php }?>
                                        <!--  <========SON=========>>>  SON !-->
                                    <?php }?>
                                <?php }?>
                                <!--  <========SON=========>>> Ödeme bildirimi SON !-->



                                <?php if($iptal->rowCount()>'0' && $row['iptal'] != '1'  ) {

                                    $talep = $iptal->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                    <div class="col-md-12 mb-3">
                                        <div class="border border-danger pt-3 pb-3 pl-3 pr-3 d-flex align-items-center justify-content-between flex-wrap" style="border-width: 1px !important;">
                                            <div class="d-flex align-items-center">
                                                <div class="spinner-grow text-danger mr-2" role="status" style="width: 10px; height: 10px">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <h6 class="text-danger" style="font-weight: 200;"><?=$diller['adminpanel-form-text-1469']?></h6>
                                            </div>
                                            <a  class="btn btn-danger text-white d-flex align-items-center justify-content-center"  data-toggle="collapse" data-target="#iptalAcc" aria-expanded="false" aria-controls="collapseForm">
                                                <?=$diller['adminpanel-form-text-1470']?>  <i class="fas fa-sort-down ml-1" style="line-height: 11px; margin-top: -6px;"></i>
                                            </a>
                                            <div id="accordion" class="accordion w-100">
                                                <div class="collapse" id="iptalAcc" data-parent="#accordion">
                                                    <div class="border-top border-grey mt-2 pt-2">
                                                        <div class="row mt-3">
                                                            <div class="form-group col-md-4">
                                                                <label ><?=$diller['adminpanel-form-text-1471']?></label>
                                                                <div style="font-size: 14px ;">
                                                                    #<?=$talep['talep_no']?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label><?=$diller['adminpanel-form-text-1472']?></label>
                                                                <div style="font-size: 14px ;">
                                                                    <?php echo date_tr('j F Y, H:i', ''.$talep['tarih'].''); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4 justify-content-end d-flex align-items-center flex-wrap">
                                                                <div class="w-100 text-right" style="font-size: 14px ;">
                                                                    <a href="" data-href="post.php?process=order_post&status=order_cancel&no=<?=$row['siparis_no']?>"  data-toggle="modal" data-target="#order-cancel-confirm" style="width: 150px"  class="btn btn-danger btn-sm m-1"><?=$diller['adminpanel-form-text-1452']?></a>
                                                                    <br>
                                                                    <a href="" data-href="post.php?process=order_post&status=cancel_request_delete&no=<?=$talep['talep_no']?>&orderID=<?=$row['siparis_no']?>"  data-toggle="modal" data-target="#confirm-delete"  style="width: 150px" class="btn btn-dark  btn-sm m-1"><i class="fa fa-trash"></i> <?=$diller['adminpanel-form-text-1473']?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>


                                <div class="col-md-12 mb-3">
                                    <div class="border border-grey pt-3 pl-3 pr-3 pb-0">
                                        <div class="row">
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-text-91']?></label>
                                                <div class="text">
                                                    #<?=$row['siparis_no']?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1460']?></label>
                                                <div class="text">
                                                    <?php echo date_tr('j F Y, H:i', ''.$row['siparis_tarih'].''); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1433']?></label>
                                                <div class="text">
                                                    <?php if($row['uye_id'] >'0' ) {
                                                        $uyec = $db->prepare("select isim,soyisim,id from uyeler where id=:id ");
                                                        $uyec->execute(array(
                                                            'id' => $row['uye_id'],
                                                        ));
                                                        $u = $uyec->fetch(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <?php if($uyec->rowCount()>'0'  ) {?>
                                                            <a href="pages.php?page=user_detail&userID=<?=$u['id']?>" target="_blank">
                                                                <i class="fa fa-user"></i> <?=$u['isim']?> <?=$u['soyisim']?>
                                                            </a>
                                                        <?php }else { ?>
                                                            <?=$row['isim']?> <?=$row['soyisim']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?=$row['isim']?> <?=$row['soyisim']?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1434']?></label>
                                                <div class="text">
                                                    <?php if($row['odeme_tur'] == '1' ) {?>
                                                        <?=$diller['adminpanel-text-97']?> (<?=$row['sanal_pos']?>)
                                                    <?php }?>
                                                    <?php if($row['odeme_tur'] == '2' ) {?>
                                                        <?=$diller['adminpanel-text-98']?>
                                                    <?php }?>
                                                    <?php if($row['odeme_tur'] == '3' ) {?>
                                                        <?=$diller['adminpanel-text-99']?>
                                                    <?php }?>
                                                    <?php if($row['odeme_tur'] == '4' ) {?>
                                                        <?=$diller['adminpanel-text-100']?>
                                                    <?php }?>
                                                    <?php if($row['odeme_tur'] == 'free' ) {?>
                                                        <?=$diller['adminpanel-text-342']?>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-text-354']?></label>
                                                <div class="text">
                                                    <?=$row['ipadres']?>
                                                </div>
                                            </div>
                                            <?php if($row['device'] == !null  ) {?>
                                                <div class="col-md-3 order-top-form form-group">
                                                    <label class="text-uppercase"><?=$diller['adminpanel-text-355']?></label>
                                                    <div class="text">
                                                        <?php if($row['device'] == 'desktop' ) {?>
                                                            <i class="fa fa-desktop"></i> <?=$diller['adminpanel-form-text-1415']?>
                                                        <?php }?>
                                                        <?php if($row['device'] == 'mobile' ) {?>
                                                            <i class="fas fa-mobile-alt"></i> <?=$diller['adminpanel-form-text-1414']?>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?php if($faturaKontrol->rowCount()<='0') {?>
                                                <div class="col-md-6 order-top-form form-group">
                                                    <form enctype="multipart/form-data" method="post" action="post.php?process=order_post&status=invoice_add">
                                                        <input type="hidden" name="order_id" value="<?=$row['siparis_no']?>">
                                                        <label class="text-uppercase d-flex align-items-center justify-content-start"><?=$diller['adminpanel-form-text-1461']?> (PDF) <i class="ti-help-alt text-primary ml-2 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1465']?>"></i></label>
                                                        <div class="text">
                                                            <div class="input-group ">
                                                                <div class="custom-file ">
                                                                    <input type="file" class="custom-file-input " id="inputGroupFile01" name="invoice" required >
                                                                    <label class="custom-file-label" for="inputGroupFile01"  ><?=$diller['adminpanel-form-text-1462']?></label>
                                                                </div>
                                                                <button name="insert" class="btn btn-success " style="border-radius: 0 4px 4px 0">
                                                                    <i class="fas fa-upload"></i>
                                                                    <?=$diller['adminpanel-text-144']?>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            <?php }else { ?>
                                                <div class="col-md-6 order-top-form form-group">
                                                    <label class="text-uppercase"><?=$diller['adminpanel-form-text-1463']?></label>
                                                    <div class="text">
                                                        <a href="post.php?process=order_post&status=invoice_download&no=<?=$row['siparis_no']?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> <?=$diller['adminpanel-form-text-1464']?></a>
                                                        <a  href="" data-href="post.php?process=order_post&status=invoice_delete&no=<?=$row['siparis_no']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-danger btn-sm"><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-878']?></a>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            <?php if($row['sanal_pos'] == 'Shopier' && $row['shopier_siparis_no'] == !null ) {?>
                                                <div class="col-md-6 order-top-form form-group">
                                                    <label class="text-uppercase"><?=$diller['adminpanel-form-text-2016']?></label>
                                                    <div class="text">
                                                        #<?=$row['shopier_siparis_no']?>
                                                    </div>
                                                </div>
                                            <?php }?>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 form-group bg-white   ">
                                    <div class="border border-grey">
                                        <div class="border-bottom border-grey pt-2 pb-2 pl-3 pr-3 mb-2 d-flex align-items-center justify-content-between flex-wrap" >
                                            <h6 ><?=$diller['adminpanel-form-text-1438']?></h6>
                                            <?php if($row['iptal'] == '0' ) {?>
                                                <a href="" data-href="post.php?process=order_post&status=order_cancel&no=<?=$row['siparis_no']?>"  data-toggle="modal" data-target="#order-cancel-confirm"  class="btn btn-danger btn-sm"><?=$diller['adminpanel-form-text-1452']?></a>
                                            <?php }?>
                                        </div>
                                        <?php if($row['iptal'] == '0' ) {?>
                                            <form action="post.php?process=order_post&status=change" method="post">
                                                <input type="hidden" name="order_id" value="<?=$row['siparis_no']?>">
                                                <div class="pt-3 pb-0 pl-3 pr-3">
                                                    <div class="form-group">
                                                        <select name="siparis_durum" class="form-control select_ajax2" style="height: 55px; font-size: 14px ; font-weight: 500;">
                                                            <?php foreach ($sipDurum as $s) {?>
                                                                <option value="<?=$s['id']?>" <?php if($s['id'] == $row['siparis_durum']  ) { ?>selected<?php }?>><?=$s['baslik']?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-start flex-wrap">
                                                        <div class="<?php if($odemeRow['siparis_iptal'] == '1' ) {?>order-right-border <?php } ?>  mb-2">
                                                            <div class="mb-3" style="font-weight: 500;">
                                                                <i class="fa fa-arrow-down"></i> <?=$diller['adminpanel-form-text-1457']?>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-start flex-wrap pb-2">
                                                                <?php if($sms['durum'] =='1' ) {?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="sms_noti" name='sms_noti' value="1">
                                                                        <label for="sms_noti"><?=$diller['adminpanel-form-text-1454']?></label>
                                                                    </div>
                                                                <?php }else { ?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="smsDisabled" name='smsDisabled' disabled>
                                                                        <label for="smsDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1454']?></del>
                                                                       </span>
                                                                        </label>
                                                                    </div>
                                                                <?php }?>
                                                                <?php if($ayar['smtp_durum'] == '1' ) {?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="email_noti" name='email_noti' value="1">
                                                                        <label for="email_noti"><?=$diller['adminpanel-form-text-1455']?></label>
                                                                    </div>
                                                                <?php }else { ?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="emailDisabled" name='emailDisabled' disabled>
                                                                        <label for="emailDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1455']?></del>
                                                                       </span>
                                                                        </label>
                                                                    </div>
                                                                <?php }?>

                                                                <?php if($uyevar == '1' && $notiSet['durum'] == '1'  ) {?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="noti" name='noti' value="1">
                                                                        <label for="noti"><?=$diller['adminpanel-form-text-1456']?></label>
                                                                    </div>
                                                                <?php }else { ?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="notDisabled" name='notDisabled' value="1" disabled>
                                                                        <label for="notDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1456']?></del>
                                                                       </span>
                                                                        </label>
                                                                    </div>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <?php if($odemeRow['siparis_iptal'] == '1' ) {?>
                                                            <div class=" flex-grow-1 mb-2">
                                                                <div class="mb-3" style="font-weight: 300; color: #999;">
                                                                    <?=$diller['adminpanel-form-text-1459']?>
                                                                </div>
                                                                <div class="d-flex align-items-center justify-content-start flex-wrap pb-2">
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="hidden" name="iptal_aksiyon" value="1">
                                                                        <input type="checkbox"  id="iptal_aksiyon" name='iptal_aksiyon' value="0" <?php if($row['iptal_aksiyon'] == '0' ) { ?>checked<?php }?>>
                                                                        <label for="iptal_aksiyon"><span style="color: red; font-weight: 500;"><?=$diller['adminpanel-form-text-1458']?></span></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }else { ?>
                                                            <input type="hidden" name="iptal_aksiyon" value="0">
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="border-top border-grey p-3 bg-light">
                                                    <button name="update" class="btn btn-success btn-block"  id="waitButton">
                                                        <?=$diller['adminpanel-form-text-53']?>
                                                    </button>
                                                </div>
                                            </form>
                                        <?php }else { ?>
                                            <form action="post.php?process=order_post&status=cancel_noti" method="post">
                                                <input type="hidden" name="order_id" value="<?=$row['siparis_no']?>">
                                                <div class="pt-1 pl-3 pr-3">
                                                    <div class="bg-danger border border-danger text-white p-3 text-center">
                                                        <i class="fa fa-ban" style="font-size: 30px ;"></i>
                                                        <br>
                                                        <h6><?=$diller['adminpanel-form-text-1466']?></h6>
                                                        <br>
                                                        <a href="" data-href="post.php?process=order_post&status=order_active&no=<?=$row['siparis_no']?>"  data-toggle="modal" data-target="#order-active-confirm"  class="btn btn-light btn-sm">
                                                            <i class="fas fa-undo"></i>
                                                            <?=$diller['adminpanel-form-text-1467']?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="pt-3 pb-0 pl-3 pr-3">
                                                    <div class="d-flex align-items-center justify-content-start flex-wrap">
                                                        <div class="  mb-2">
                                                            <div class="mb-3" style="font-weight: 500;">
                                                                <i class="fa fa-arrow-down"></i> <?=$diller['adminpanel-form-text-1457']?>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-start flex-wrap pb-2">
                                                                <?php if($sms['durum'] =='1' ) {?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="sms_noti" name='sms_noti' value="1" class="checkbox-group">
                                                                        <label for="sms_noti"><?=$diller['adminpanel-form-text-1454']?></label>
                                                                    </div>
                                                                <?php }else { ?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="smsDisabled" name='smsDisabled' disabled>
                                                                        <label for="smsDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1454']?></del>
                                                                       </span>
                                                                        </label>
                                                                    </div>
                                                                <?php }?>
                                                                <?php if($ayar['smtp_durum'] == '1' ) {?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="email_noti" name='email_noti' value="1" class="checkbox-group">
                                                                        <label for="email_noti"><?=$diller['adminpanel-form-text-1455']?></label>
                                                                    </div>
                                                                <?php }else { ?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="emailDisabled" name='emailDisabled' disabled>
                                                                        <label for="emailDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1455']?></del>
                                                                       </span>
                                                                        </label>
                                                                    </div>
                                                                <?php }?>

                                                                <?php if($uyevar == '1' && $notiSet['durum'] == '1'  ) {?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="noti" name='noti' value="1" class="checkbox-group">
                                                                        <label for="noti"><?=$diller['adminpanel-form-text-1456']?></label>
                                                                    </div>
                                                                <?php }else { ?>
                                                                    <div class="kustom-checkbox mr-4">
                                                                        <input type="checkbox"  id="notDisabled" name='notDisabled' value="1" disabled>
                                                                        <label for="notDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1456']?></del>
                                                                       </span>
                                                                        </label>
                                                                    </div>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="border-top border-grey p-3 bg-light">
                                                    <button name="cancelNotifi" class="btn btn-success btn-block" id="waitButton" disabled="disabled">
                                                        <?=$diller['adminpanel-text-350']?>
                                                    </button>
                                                </div>
                                            </form>
                                            <script>
                                                var checkboxes = $("input[class='checkbox-group']"),
                                                    submitButt = $("button[name='cancelNotifi']");

                                                checkboxes.click(function() {
                                                    submitButt.attr("disabled", !checkboxes.is(":checked"));
                                                });
                                            </script>
                                        <?php }?>
                                    </div>
                                </div>

                                <div class="col-md-8 form-group">
                                    <div class="row">



                                        <div class="<?php if($odemeRow['faturasiz_teslimat'] == '0' ) { ?>col-md-6<?php }else{?>col-md-12<?php } ?> form-group bg-white">
                                            <div class="border border-grey">
                                                <div class="border-bottom border-grey bg-white pt-2 pb-2 pl-3 pr-3 mb-2 d-flex align-items-center justify-content-between flex-wrap" >
                                                    <h6><i class="fas fa-map-marker-alt"></i> <?=$diller['adminpanel-form-text-1324']?></h6>
                                                </div>
                                                <ul class="list-group list-group-flush p-3 list-unstyled " style="font-size: 14px ;">
                                                    <li class="border-bottom border-grey pb-2" ><?=$row['isim']?> <?=$row['soyisim']?></li>
                                                    <?php if($row['tc_no'] == !null  ) {?>
                                                        <li class="border-bottom border-grey pb-2 pt-2" >
                                                            <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1316']?> :</strong> <?=$row['tc_no']?>
                                                        </li>
                                                    <?php }?>
                                                    <li class="border-bottom border-grey pb-2 pt-2" >
                                                        <strong class="text-uppercase"><?=$diller['adminpanel-form-text-81']?> :</strong> <?=$row['telefon_gosterim']?>
                                                    </li>
                                                    <li class="border-bottom border-grey pb-2 pt-2" >
                                                        <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1107']?> :</strong> <?=$row['eposta']?>
                                                    </li>
                                                    <li class="border-bottom border-grey pb-2 pt-2" >
                                                        <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1474']?> :</strong> <?=$row['postakodu']?>
                                                    </li>
                                                </ul>
                                                <div class="pt-1 pl-3 pr-3 pb-3" style="font-size: 14px ;">
                                                    <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1326']?> :</strong>
                                                    <br>
                                                    <?=$row['adresbilgisi']?>
                                                    <br>
                                                    <?=$row['ilce']?> / <?=$row['sehir']?> / <?=$ulk['baslik']?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if($odemeRow['faturasiz_teslimat'] == '0' ) { ?>
                                            <div class="col-md-6 form-group bg-white">
                                                <div class="border border-grey">
                                                    <div class="border-bottom border-grey bg-white pt-2 pb-2 pl-3 pr-3 mb-2 d-flex align-items-center justify-content-between flex-wrap" >
                                                        <h6><i class="fas fa-receipt"></i> <?=$diller['adminpanel-form-text-1327']?></h6>
                                                    </div>
                                                    <div class="pl-3 pr-3" style="font-weight: 600;">

                                                    </div>
                                                    <?php if($row['adres_fatura_farkli'] == '0'  ) {?>
                                                        <ul class="list-group list-group-flush p-3 list-unstyled " style="font-size: 14px ;">
                                                                <li class="border-bottom border-grey pb-2 pt-2" >
                                                                    <?=$row['isim']?> <?=$row['soyisim']?>
                                                                </li>
                                                            <?php if($row['tc_no'] == !null  ) {?>
                                                                <li class="border-bottom border-grey pb-2 pt-2" >
                                                                    <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1316']?> :</strong> <?=$row['tc_no']?>
                                                                </li>
                                                            <?php }?>
                                                            <li class="border-bottom border-grey pb-2 pt-2" >
                                                                <strong class="text-uppercase"><?=$diller['adminpanel-form-text-81']?> :</strong> <?=$row['telefon_gosterim']?>
                                                            </li>
                                                            <li class="border-bottom border-grey pb-2 pt-2" >
                                                                <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1107']?> :</strong> <?=$row['eposta']?>
                                                            </li>
                                                            <li class="border-bottom border-grey pb-2 pt-2" >
                                                                <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1474']?> :</strong> <?=$row['postakodu']?>
                                                            </li>
                                                        </ul>
                                                        <div class="pt-1 pl-3 pr-3 pb-3" style="font-size: 14px ;">
                                                            <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1326']?> :</strong>
                                                            <br>
                                                            <?=$row['adresbilgisi']?>
                                                            <br>
                                                            <?=$row['ilce']?> / <?=$row['sehir']?> / <?=$ulk['baslik']?>
                                                        </div>
                                                    <?php }else { ?>
                                                        <ul class="list-group list-group-flush p-3 list-unstyled " style="font-size: 14px ;">

                                                            <?php if($row['fatura_turu'] == '1' ) {?>
                                                                <li class="border-bottom border-grey pb-2 text-primary" style="font-weight: 500;" >
                                                                    <?=$diller['adminpanel-form-text-1320']?>
                                                                </li>
                                                                <li class="border-bottom border-grey pb-2 pt-2" >
                                                                    <?=$row['fatura_isim']?> <?=$row['fatura_soyisim']?>
                                                                </li>
                                                                <li class="border-bottom border-grey pb-2 pt-2" >
                                                                    <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1316']?> :</strong> <?=$row['fatura_tc']?>
                                                                </li>
                                                            <?php }?>
                                                            <?php if($row['fatura_turu'] == '2' ) {?>
                                                                <li class="border-bottom border-grey pb-2 text-danger" style="font-weight: 500;" >
                                                                    <?=$diller['adminpanel-form-text-1321']?>
                                                                </li>
                                                                <li class="border-bottom border-grey pb-2 pt-2" >
                                                                    <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1317']?> :</strong> <?=$row['fatura_firma_unvan']?>
                                                                </li>
                                                                <li class="border-bottom border-grey pb-2 pt-2" >
                                                                    <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1318']?> :</strong> <?=$row['fatura_vergi_dairesi']?>
                                                                </li>
                                                                <li class="border-bottom border-grey pb-2 pt-2" >
                                                                    <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1319']?> :</strong> <?=$row['fatura_vergi_no']?>
                                                                </li>
                                                            <?php }?>
                                                            <li class="border-bottom border-grey pb-2 pt-2" >
                                                                <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1474']?> :</strong> <?=$row['fatura_postakodu']?>
                                                            </li>
                                                        </ul>
                                                        <div class="pt-1 pl-3 pr-3 pb-3" style="font-size: 14px ;">
                                                            <strong class="text-uppercase"><?=$diller['adminpanel-form-text-1326']?> :</strong>
                                                            <br>
                                                            <?=$row['fatura_adresi']?>
                                                            <br>
                                                            <?=$row['fatura_ilce']?> / <?=$row['fatura_sehir']?> / <?=$ulk2['baslik']?>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="col-md-12 form-group bg-white">
                                            <div class="border border-grey pt-2 pb-2 pl-3 pr-3">
                                                <div style="font-size: 14px ; font-weight: 600; margin-bottom: 8px;"><?=$diller['adminpanel-form-text-1475']?></div>
                                                <?php if($row['siparis_notu'] == !null  ) {?>
                                                    <?=$row['siparis_notu']?>
                                                <?php }else { ?>
                                                    <div style="color:#999">
                                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-form-text-1476']?>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Order Product List !-->
                                <div class="col-md-12 mb-3 product-list-area">
                                    <div class="border border-grey " >
                                        <div class="p-3 border-bottom border-grey  d-flex align-items-center text-dark justify-content-between flex-wrap">
                                            <div class="d-flex align-items-center justify-content-start flex-wrap flex-grow-1 ">
                                                <i class="fas fa-shopping-basket mr-2" style="font-size: 20px;"></i>
                                                <div>
                                                    <div style="font-size: 18px; font-weight: 600;">
                                                        <?=$diller['adminpanel-form-text-1508']?> (<?=$urunListesi->rowCount()?>)
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($odemeRow['urun_stok_dus'] == '1' && $row['stok_alindi'] != '1' ) {?>
                                                <!-- Stokları Geri Al !-->
                                                <a href="" data-href="post.php?process=order_post&status=stock_load&orderID=<?=$row['siparis_no']?>" data-toggle="modal" data-target="#stock-load"  class="btn btn-light border btn-sm  " type="button" style="font-size: 14px ; " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                    <i class="fa fa-sync"></i> <?=$diller['adminpanel-form-text-1798']?>
                                                </a>
                                                <!--  <========SON=========>>> Stokları Geri Al SON !-->
                                            <?php }?>
                                        </div>
                                        <!-- Ürün Listesi  !-->
                                        <div class="w-100 pt-1 pb-1 pl-3 pr-3">
                                            <?php foreach ($urunListesi as $prow) {
                                                $urunGetir = $db->prepare("select gorsel,id,baslik,seo_url from urun where id=:id ");
                                                $urunGetir->execute(array(
                                                    'id' => $prow['urun_id'],
                                                ));
                                                $realP = $urunGetir->fetch(PDO::FETCH_ASSOC);

                                                $varyant = $db->prepare("select * from siparis_varyant where urun_id=:urun_id and siparis_id=:siparis_id and sepet_id=:sepet_id ");
                                                $varyant->execute(array(
                                                    'urun_id' => $prow['urun_id'],
                                                    'siparis_id' => $row['siparis_no'],
                                                    'sepet_id' => $prow['sepet_id'],
                                                ));
                                                
                                                /* Ürün iade sorgusu */
                                                $iadeUrun = $db->prepare("select * from siparis_urunler_iade where urun_id=:urun_id and siparis_no=:siparis_no ");
                                                $iadeUrun->execute(array(
                                                        'urun_id' => $prow['id'],
                                                        'siparis_no' => $row['siparis_no']
                                                ));
                                                /*  <========SON=========>>> Ürün iade sorgusu SON */
                                                
                                                ?>
                                                <div class="w-100 border p-3 mt-3 mb-3">
                                                    <div class="w-100 d-flex align-items-center justify-content-between flex-wrap ">
                                                        <div class="row" style="width: 120%;  ">
                                                            <div class="col-md-6 d-flex  justify-content-start flex-wrap">
                                                                <div class="mr-3">
                                                                    <img src="../images/product/<?=$realP['gorsel']?>" style="width: 80px; height: auto">
                                                                </div>
                                                                <div class="">
                                                                    <div class="mt-2 mb-2">
                                                                        <div class="w-100" style="font-size: 14px ; font-weight: 500;">
                                                                            <a href="<?=$ayar['site_url']?><?=seo($realP['seo_url'])?>-P<?=$realP['id']?>" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                                                                            <?=$prow['urun_baslik']?>
                                                                        </div>
                                                                        <?php if($prow['stok_kodu'] == !null  ) {?>
                                                                            <div  class="w-100" style="font-size: 12px ;">
                                                                                <?=$diller['adminpanel-form-text-1504']?> : <?=$prow['stok_kodu']?>
                                                                            </div>
                                                                        <?php }?>
                                                                        <!-- Varyantlar !-->
                                                                        <?php if($varyant->rowCount()>'0'  ) {?>
                                                                            <div class="w-100 mt-2">
                                                                            <?php foreach ($varyant as $var) {?>
                                                                                    <?php if($var['tur'] != '2' && $var['tur'] != '4' ) {?>
                                                                                        <div class="w-100 border border-grey mb-1 p-1" style="background: #f9f9f9;">
                                                                                            <strong><?=$var['grup_adi']?>:</strong> <?=$var['varyant_adi']?>

                                                                                            <?php if($var['ek_fiyat'] >'0' ) {?>
                                                                                                [ + <?php echo number_format($var['ek_fiyat'], 2); ?> <?=$row['parabirimi']?> ]
                                                                                            <?php }?>
                                                                                        </div>
                                                                                    <?php }else {

                                                                                        $varDetayBilgi = $db->prepare("select * from urun_varyant_ekler where id=:id ");
                                                                                        $varDetayBilgi->execute(array(
                                                                                            'id' => $var['ekbilgi_id'],
                                                                                        ));
                                                                                        $ek = $varDetayBilgi->fetch(PDO::FETCH_ASSOC);

                                                                                        ?>
                                                                                    <?php if($varDetayBilgi->rowCount()>'0'  ) {?>
                                                                                        <div class="w-100 border border-grey mb-1 p-1" style="background: #f9f9f9;">
                                                                                            <?php if($var['tur'] == '2' ) {?>
                                                                                                <strong><?=$var['grup_adi']?>:</strong> <?=$ek['icerik']?>
                                                                                                <?php if($var['ek_fiyat'] >'0' ) {?>
                                                                                                    [ + <?php echo number_format($var['ek_fiyat'], 2); ?> <?=$row['parabirimi']?> ]
                                                                                                <?php }?>
                                                                                            <?php }?>
                                                                                            <?php if($var['tur'] == '4' ) {?>
                                                                                                <strong><?=$var['grup_adi']?>:</strong> <?php echo date_tr('j F Y', ''.$ek['icerik'].''); ?>
                                                                                                <?php if($var['ek_fiyat'] >'0' ) {?>
                                                                                                    [ + <?php echo number_format($var['ek_fiyat'], 2); ?> <?=$row['parabirimi']?> ]
                                                                                                <?php }?>
                                                                                            <?php }?>
                                                                                        </div>
                                                                                    <?php }?>
                                                                                    <?php }?>
                                                                                <?php }?>
                                                                            </div>
                                                                        <?php }?>
                                                                        <!--  <========SON=========>>> Varyantlar SON !-->
                                                                         <?php if($odemeRow['urun_stok_dus'] == '1' && $prow['stok_alindi'] != '1'  ) {?>
                                                                                <a href="" data-href="post.php?process=order_post&status=product_stock&orderID=<?=$prow['id']?>&backID=<?=$row['siparis_no']?>" data-toggle="modal" data-target="#stock-load-2"  class="btn btn-dark  btn-sm  mt-2 " type="button" style="font-size: 11px ; " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                                                    <i class="fa fa-sync"></i> <?=$diller['adminpanel-text-361']?>
                                                                                </a>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <form action="post.php?process=order_post&status=product_update" method="post">
                                                                    <input type="hidden" name="pro_id" value="<?=$prow['id']?>">
                                                                    <input type="hidden" name="order_id" value="<?=$row['siparis_no']?>">
                                                                    <div class="row">
                                                                        <div class="col-md-12 form-group">
                                                                            <?php if($iadeUrun->rowCount()>'0'  ) {
                                                                                $iadeRow = $iadeUrun->fetch(PDO::FETCH_ASSOC);
                                                                                ?>
                                                                                <!-- İADE talebi !-->
                                                                                <?php if($iadeRow['durum'] == '0' ) {?>
                                                                                    <a href="pages.php?page=product_return&no=<?=$iadeRow['talep_no']?>" target="_blank" class="text-center p-2 mb-2 btn-block  btn btn-outline-danger  rounded  ">
                                                                                        <?=$diller['adminpanel-form-text-1517']?>
                                                                                    </a>
                                                                                <?php }?>
                                                                                <?php if($iadeRow['durum'] == '1' ) {?>
                                                                                    <a href="pages.php?page=product_return&no=<?=$iadeRow['talep_no']?>" target="_blank" class="bg-info text-white text-center p-2 mb-2 btn-block rounded  ">
                                                                                        <i class="fas fa-sync-alt"></i>  <?=$diller['adminpanel-form-text-1524']?>
                                                                                    </a>
                                                                                <?php }?>
                                                                                <?php if($iadeRow['durum'] == '2' ) {?>
                                                                                    <a href="pages.php?page=product_return&no=<?=$iadeRow['talep_no']?>" target="_blank" class="bg-primary text-white text-center p-2 mb-2 btn-block rounded  ">
                                                                                        <i class="fas fa-sync-alt"></i>  <?=$diller['adminpanel-form-text-1525']?>
                                                                                    </a>
                                                                                <?php }?>
                                                                                <?php if($iadeRow['durum'] == '3' ) {?>
                                                                                    <a href="pages.php?page=product_return&no=<?=$iadeRow['talep_no']?>" target="_blank" class="bg-danger text-white text-center p-2 mb-2 btn-block rounded  ">
                                                                                        <i class="fas fa-times"></i>  <?=$diller['adminpanel-form-text-1526']?>
                                                                                    </a>
                                                                                <?php }?>
                                                                                <!--  <========SON=========>>> İADE talebi SON !-->
                                                                            <?php }?>
                                                                            <select name="durum" class="form-control select_ajax2" >
                                                                                <option value="0" <?php if($prow['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1509']?></option>
                                                                                <option value="1" <?php if($prow['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1510']?></option>
                                                                                <option value="2" <?php if($prow['durum'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1511']?></option>
                                                                                <option value="3" <?php if($prow['durum'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1512']?></option>
                                                                                <option value="4" <?php if($prow['durum'] == '4' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1513']?></option>
                                                                                <option value="5" <?php if($prow['durum'] == '5' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1514']?></option>
                                                                                <option value="6" <?php if($prow['durum'] == '6' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1515']?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-12 d-flex align-items-center justify-content-end flex-wrap mb-0">
                                                                            <div>
                                                                                <div class="kustom-checkbox mr-4">
                                                                                    <input type="hidden" name="iade_aksiyon" value="1">
                                                                                    <input type="checkbox"  id="iade_aksiyon-<?=$prow['id']?>" name='iade_aksiyon' value="0" <?php if($prow['iade_aksiyon'] == '0' ) { ?>checked<?php }?>>
                                                                                    <label for="iade_aksiyon-<?=$prow['id']?>">
                                                                                       <span class="text-danger" style="font-weight: 500;">
                                                                                           <?=$diller['adminpanel-form-text-1516']?>
                                                                                       </span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <button name="productUpdate" style="width: 150px" class="btn btn-success "  >
                                                                                    <?=$diller['adminpanel-form-text-53']?>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="border-top border-grey pt-3 mt-3">
                                                        <?php if($row['odeme_tur'] == '2' ) {?>
                                                            <div class="row">
                                                                <?php if($prow['ozel_fiyat_uye'] == '1'  ) {?>
                                                                    <div class="col-md-12 mb-2 ">
                                                                        <div class="border border-grey p-2 text-left bg-light">
                                                                            <span style="font-size: 14px ;"><?=$diller['adminpanel-form-text-1522']?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1518']?></label>
                                                                        <span style="font-size: 14px ;"><?php echo number_format($prow['havale_kdvsiz_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                    </div>
                                                                </div>
                                                                <?php if($prow['havale_kdv_tutar']>'0'  ) {?>
                                                                    <div class="col-md-2 mb-1 mt-1">
                                                                        <div class="border border-grey p-2 text-center">
                                                                            <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1519']?></label>
                                                                            <span style="font-size: 14px ;"><?php echo number_format($prow['havale_kdv_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1199']?></label>
                                                                        <span style="font-size: 14px ;"><?=$prow['adet']?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1521']?> </label>
                                                                        <span style="font-size: 15px ; font-weight: 500;"><?php echo number_format($prow['havale_kdvsiz_tutar']+$prow['havale_kdv_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                    </div>
                                                                </div>
                                                                <?php if($row['sabit_kargo'] == '1'  ) {?>
                                                                    <?php if($prow['kargo_tutar'] >'0' ) {?>
                                                                        <div class="col-md-2 mb-1 mt-1">
                                                                            <div class="border border-grey p-2 text-center">
                                                                                <label class="border-bottom border-grey w-100 pb-2 d-flex align-items-center justify-content-center">
                                                                                    <?=$diller['adminpanel-form-text-1520']?>
                                                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1523']?>"></i>
                                                                                </label>
                                                                                <span style="font-size: 14px ;"><?php echo number_format($prow['kargo_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php }?>
                                                                <?php }else { ?>
                                                                    <div class="col-md-2 mb-1 mt-1">
                                                                        <div class="border border-grey p-2 text-center">
                                                                            <label class="border-bottom border-grey w-100 pb-2 d-flex align-items-center justify-content-center">
                                                                                <?=$diller['adminpanel-form-text-1520']?>
                                                                                <?php if($prow['kargo_tipi'] == '1'  ) {?>
                                                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1527']?>"></i>
                                                                                <?php }?>
                                                                            </label>
                                                                            <span style="font-size: 14px ;"><?php echo number_format($prow['kargo_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                            </div>
                                                        <?php }else { ?>
                                                            <?php if($prow['ozel_fiyat_uye'] == '1'  ) {?>
                                                                <div class="col-md-12 mb-2 ">
                                                                    <div class="border border-grey p-2 text-left bg-light">
                                                                        <span style="font-size: 14px ;"><?=$diller['adminpanel-form-text-1522']?></span>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                            <div class="row">
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1518']?></label>
                                                                        <span style="font-size: 14px ;"><?php echo number_format($prow['kdvsiz_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                    </div>
                                                                </div>
                                                                <?php if($prow['kdv_tutar']>'0'  ) {?>
                                                                    <div class="col-md-2 mb-1 mt-1">
                                                                        <div class="border border-grey p-2 text-center">
                                                                            <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1519']?></label>
                                                                            <span style="font-size: 14px ;"><?php echo number_format($prow['kdv_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1199']?></label>
                                                                        <span style="font-size: 14px ;"><?=$prow['adet']?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1521']?> </label>
                                                                        <span style="font-size: 15px ; font-weight: 500;"><?php echo number_format(($prow['kdvsiz_tutar']+$prow['kdv_tutar'])*$prow['adet'], 2); ?> <?=$row['parabirimi']?></span>
                                                                    </div>
                                                                </div>
                                                                <?php if($row['sabit_kargo'] == '1'  ) {?>
                                                                    <?php if($prow['kargo_tutar'] >'0' ) {?>
                                                                        <div class="col-md-2 mb-1 mt-1">
                                                                            <div class="border border-grey p-2 text-center">
                                                                                <label class="border-bottom border-grey w-100 pb-2 d-flex align-items-center justify-content-center">
                                                                                    <?=$diller['adminpanel-form-text-1520']?>
                                                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1523']?>"></i>
                                                                                </label>
                                                                                <span style="font-size: 14px ;"><?php echo number_format($prow['kargo_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                            </div>
                                                                        </div>
                                                                    <?php }?>
                                                                <?php }else { ?>
                                                                    <div class="col-md-2 mb-1 mt-1">
                                                                        <div class="border border-grey p-2 text-center">
                                                                            <label class="border-bottom border-grey w-100 pb-2 d-flex align-items-center justify-content-center">
                                                                                <?=$diller['adminpanel-form-text-1520']?>
                                                                                <?php if($prow['kargo_tipi'] == '1'  ) {?>
                                                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1527']?>"></i>
                                                                                <?php }?>
                                                                            </label>
                                                                            <span style="font-size: 14px ;"><?php echo number_format($prow['kargo_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <!--  <========SON=========>>> Ürün Listesi  SON !-->

                                        <style>
                                            .account_subpage_summary_order_main{
                                                width: 100%;
                                                box-sizing: border-box;
                                                display: flex;
                                                justify-content: flex-end;
                                            }
                                            .account_subpage_summary_order_in{
                                                width: 300px;
                                            }
                                            .account_subpage_summary_order_freedelivery,
                                            .account_subpage_summary_order_discount_coupon{
                                                width: 100%;
                                                box-sizing: border-box;
                                                border: 1px solid #ebebeb;
                                                display: flex;
                                                align-items: flex-start;
                                                justify-content: flex-start;
                                                padding: 20px 18px;
                                                margin-bottom: 10px;
                                            }
                                            .account_subpage_summary_order_coupon_icon{
                                                width: 45px;
                                                font-size: 24px ;
                                                line-height: 28px;
                                                color: #6e8ebe;
                                            }
                                            .account_subpage_summary_order_coupon_text{
                                                flex:1;
                                                font-size: 13px ;
                                                color: #333;
                                                font-weight: 500;
                                                line-height: 15px;
                                            }
                                            .account_subpage_summary_order_coupon_text_h{
                                                width: 100%;
                                                color: #999;
                                                font-weight: 500;
                                            }
                                            .account_subpage_summary_order_coupon_text_s{
                                                width: 100%;
                                                margin-top: 5px;
                                            }
                                            .account_subpage_summary_order_box{
                                                width: 100%;
                                                box-sizing: border-box;
                                                border: 1px solid #ebebeb;
                                                background-color: #f8f8f8;
                                                color: #000;
                                                padding: 20px;
                                            }
                                            .account_subpage_summary_order_box_h{
                                                font-size: 16px ;
                                                font-weight: 600;
                                                margin-bottom: 20px;
                                            }
                                            .account_subpage_summary_order_box_s{
                                                display: flex;
                                                align-items: flex-start;
                                                justify-content: space-between;
                                                flex-wrap: wrap;
                                                width: 100% ;
                                                border-bottom: 1px solid #EBEBEB;
                                                font-size: 14px ;
                                                padding-bottom: 8px;
                                                margin-bottom: 8px;
                                            }
                                            .account_subpage_summary_order_box_s:last-child{
                                                border-bottom: 0;
                                                margin-bottom: 0;
                                                padding-bottom: 0;
                                            }
                                            .account_subpage_summary_order_box_s_left{
                                                width: 50%;
                                            }
                                            .account_subpage_summary_order_box_s_right{
                                                width: 50%;
                                                text-align: right;
                                                font-weight: 600;
                                            }
                                            .orderdetail_coupon_total{
                                                box-sizing: border-box;
                                                text-align: center;
                                                border: 1px solid #EBEBEB;
                                                padding: 5px;
                                                margin-top: 5px;
                                                border-radius: 10px;
                                                background-color: #f8f8f8;
                                            }
                                        </style>

                                        <div class="w-100 pt-0 pb-3 pl-3 pr-3">
                                            <div class="account_subpage_summary_order_main">
                                                <div class="account_subpage_summary_order_in">
                                                    <?php if($row['kargo_limit_durum'] == '1' ) {?>
                                                        <!-- Ücretsiz kargo kampanyası !-->
                                                        <div class="account_subpage_summary_order_freedelivery">
                                                            <div class="account_subpage_summary_order_coupon_icon">
                                                                <i class="fa fa-truck"></i>
                                                            </div>
                                                            <div class="account_subpage_summary_order_coupon_text" style="font-weight: 200;">
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
                                                            <div class="account_subpage_summary_order_coupon_text" style="font-weight: 200;">
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
                                                                    <div class="account_subpage_summary_order_coupon_text_h" style="font-weight: 200;">
                                                                        <?=$diller['users-panel-text138']?>
                                                                    </div>
                                                                    <div class="account_subpage_summary_order_coupon_text_s">
                                                                        <i class="fa fa-angle-right"></i> <?=$realKuponRow['baslik']?>
                                                                        <div class="orderdetail_coupon_total">
                                                                            <?php if($realKuponRow['tur'] == '1' ) {?>
                                                                                <?=$diller['users-panel-text45']?> : %<?php echo number_format($realKuponRow['indirim_tutar'], 0); ?>
                                                                            <?php }?>
                                                                            <?php if($realKuponRow['tur'] == '2' ) {?>
                                                                                <?=$diller['users-panel-text44']?> : <?php echo number_format($realKuponRow['indirim_tutar'], 2); ?> <?=$row['parabirimi']?>
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
                                                                <i class="far fa-money-bill-alt"></i>
                                                            </div>
                                                            <div class="account_subpage_summary_order_coupon_text">
                                                                <div class="account_subpage_summary_order_coupon_text_h" style="margin-bottom: 10px; font-weight: 200;">
                                                                    <?=$diller['users-panel-text147']?>
                                                                </div>
                                                                <div class="account_subpage_summary_order_coupon_text_s">
                                                                    <?=$diller['users-panel-text145']?> : <?=$para['baslik']?> / <?=$para['kod']?>
                                                                </div>
                                                                <div class="account_subpage_summary_order_coupon_text_s d-flex align-items-center justify-content-start mt-2">
                                                                    <i class="ti-help-alt text-primary mr-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['users-panel-text148']?>"></i>  <?=$diller['users-panel-text146']?> : <?=$row['odeme_kuru']?>
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
                                                        <?php if($odemeRow['faturasiz_teslimat'] == '0'  ) {?>
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
                                                        <?php if($odemeRow['kargo_sistemi'] == '1' ) {?>
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
                                                                    <?=$diller['adminpanel-form-text-1963']?>
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
                                                                    <?=$diller['adminpanel-form-text-1965']?>
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
                                                                    <?=$diller['adminpanel-form-text-1974']?>
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
                                        </div>
                                    </div>

                                </div>
                                <!--  <========SON=========>>> Order Product List SON !-->


                                <!-- Cargo Settings !-->
                                <div class="col-md-12 mb-3 ">
                                    <div class="bg-light border border-grey " >
                                        <div class="p-3  d-flex align-items-center text-dark  bg-light justify-content-between flex-wrap">
                                            <div class="d-flex align-items-center justify-content-start flex-wrap ">
                                                <i class="fa fa-truck mr-3" style="font-size: 20px ;"></i>
                                                <div>
                                                    <div style="font-size: 18px; font-weight: 600;">
                                                        <?=$diller['adminpanel-form-text-1495']?>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php if($odemeRow['kargo_sistemi'] == '1' ) {?>
                                                <a  class="btn btn-secondary text-white d-flex align-items-center justify-content-center mt-2 mb-2"  data-toggle="collapse" data-target="#kargoAcc" aria-expanded="false" aria-controls="collapseForm">
                                                    <?=$diller['adminpanel-form-text-1496']?> <i class="fas fa-sort-down ml-1" style="line-height: 11px; margin-top: -6px;"></i>
                                                </a>
                                            <?php }else { ?>
                                                <div class="mt-2 mb-2 text-danger">
                                                    <strong><i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-1502']?></strong>
                                                    <br>
                                                    <?=$diller['adminpanel-form-text-1503']?>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <?php if($odemeRow['kargo_sistemi'] == '1' ) {

                                            $kargofirma = $db->prepare("select * from kargo_firma where durum=:durum order by sira asc ");
                                            $kargofirma->execute(array(
                                                'durum' => '1',
                                            ));

                                            ?>
                                            <div id="accordion" class="accordion w-100 bg-white ">
                                                <div class="collapse " id="kargoAcc" data-parent="#accordion">
                                                    <div class="border-top border-grey p-3">
                                                        <div class="row">
                                                            <div class="form-group col-md-5">
                                                                <label for="kargo_sekli"><?=$diller['adminpanel-form-text-1497']?></label>
                                                                <select name="kargo_sekli" class="form-control" id="kargo_sekli">
                                                                    <option value="0" <?php if($row['kargo_sekli'] == '0' || $row['kargo_sekli'] == null) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1498']?></option>
                                                                    <?php if($siparis_urunler->rowCount()>'1'  ) {?>
                                                                        <option value="1" <?php if($row['kargo_sekli'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1499']?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div id="tek-paket" <?php if($row['kargo_sekli'] == '1' ) { ?>style="display:none"<?php }?>>
                                                                    <form method="post" action="post.php?process=order_post&status=cargo_settings">
                                                                        <input type="hidden" name="order_id" value="<?=$row['siparis_no']?>">
                                                                        <div class="row">
                                                                            <div class="form-group col-md-5">
                                                                                <label for="kargo_firma"><?=$diller['adminpanel-form-text-1501']?></label>
                                                                                <select name="kargo_firma" class="form-control select_ajax2" id="kargo_firma" style="width: 100%;  ">
                                                                                    <?php foreach ($kargofirma as $k) {?>
                                                                                        <option value="<?=$k['id']?>" <?php if($k['id'] == $row['kargo_firma'] ) { ?>selected<?php }?>><?=$k['baslik']?></option>
                                                                                    <?php }?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group col-md-5">
                                                                                <label for="kargo_takip"><?=$diller['adminpanel-form-text-1500']?></label>
                                                                                <input type="text" autocomplete="off" name="kargo_takip" value="<?=$row['kargo_takip']?>" id="kargo_takip" class="form-control">
                                                                            </div>
                                                                            <div class="form-group col-md-2 d-flex align-items-center justify-content-start flex-wrap">
                                                                                <label class="text-white btn-block">.</label>
                                                                                <div class="dropdown d-inline-block mr-2">
                                                                                    <a href="" class="btn btn-primary  " type="button" style="font-size: 14px ; " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                                                        <i class="fa fa-bell"></i>
                                                                                    </a>
                                                                                    <div class="dropdown-menu dropdown-menu-right ssa border p-1  checkbox-menu allow-focus " >
                                                                                        <div class="p-2" style="" >
                                                                                            <div class="mb-3" style="font-weight: 500; width: 180px">
                                                                                                <i class="fa fa-arrow-down"></i> <?=$diller['adminpanel-form-text-1457']?>
                                                                                            </div>
                                                                                            <?php if($sms['durum'] =='1' ) {?>
                                                                                                <div class="w-100">
                                                                                                    <label style="font-size: 14px ;font-weight: 200 !important; ">
                                                                                                        <input type="checkbox" id="sms_noti" name='sms_noti' value="1"> <?=$diller['adminpanel-form-text-1454']?>
                                                                                                    </label>
                                                                                                </div>
                                                                                            <?php }else { ?>
                                                                                                <div class="w-100">
                                                                                                    <label style="font-size: 14px ; font-weight: 200 !important;">
                                                                                                        <input type="checkbox" id="smsDisabled" name='smsDisabled' disabled >  <del> <?=$diller['adminpanel-form-text-1454']?></del>
                                                                                                    </label>
                                                                                                </div>
                                                                                            <?php }?>
                                                                                            <?php if($ayar['smtp_durum'] == '1' ) {?>
                                                                                                <div class="w-100">
                                                                                                    <label style="font-size: 14px ;font-weight: 200 !important;">
                                                                                                        <input type="checkbox" id="email_noti" name='email_noti' value="1"> <?=$diller['adminpanel-form-text-1455']?>
                                                                                                    </label>
                                                                                                </div>
                                                                                            <?php }else { ?>
                                                                                                <div class="w-100">
                                                                                                    <label style="font-size: 14px ;font-weight: 200 !important;">
                                                                                                        <input type="checkbox" id="mailDisabled" name='mailDisabled' disabled >  <del> <?=$diller['adminpanel-form-text-1455']?></del>
                                                                                                    </label>
                                                                                                </div>
                                                                                            <?php }?>
                                                                                            <?php if($uyevar == '1' && $notiSet['durum'] == '1'  ) {?>
                                                                                                <div class="w-100">
                                                                                                    <label style="font-size: 14px ;font-weight: 200 !important;">
                                                                                                        <input type="checkbox" id="noti" name='noti' value="1"> <?=$diller['adminpanel-form-text-1456']?>
                                                                                                    </label>
                                                                                                </div>
                                                                                            <?php }else { ?>
                                                                                                <div class="w-100">
                                                                                                    <label style="font-size: 14px ;font-weight: 200 !important;">
                                                                                                        <input type="checkbox" id="notDisabled" name='notDisabled' disabled >  <del> <?=$diller['adminpanel-form-text-1456']?></del>
                                                                                                    </label>
                                                                                                </div>
                                                                                            <?php }?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <button id="waitButton2" name="kargoTip1" class="btn btn-success flex-grow-1 " ><?=$diller['adminpanel-form-text-53']?></button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <?php if($siparis_urunler->rowCount()>'1'  ) {?>
                                                                    <div id="cok-paket" <?php if($row['kargo_sekli'] != '1' ) { ?>style="display:none"<?php }?>>
                                                                        <div class="row">
                                                                            <?php foreach ($siparis_urunler as $urunKargoRow) {
                                                                                $urunkargocek = $db->prepare("select gorsel,id from urun where id=:id ");
                                                                                $urunkargocek->execute(array(
                                                                                    'id' => $urunKargoRow['urun_id'],
                                                                                ));
                                                                                $uro = $urunkargocek->fetch(PDO::FETCH_ASSOC);

                                                                                $varyantKargo = $db->prepare("select * from siparis_varyant where urun_id=:urun_id and siparis_id=:siparis_id and sepet_id=:sepet_id ");
                                                                                $varyantKargo->execute(array(
                                                                                    'urun_id' => $uro['id'],
                                                                                    'siparis_id' => $row['siparis_no'],
                                                                                    'sepet_id' => $urunKargoRow['sepet_id'],
                                                                                ));

                                                                                $kargofirmaSQL = $db->prepare("select * from kargo_firma where durum=:durum order by sira asc ");
                                                                                $kargofirmaSQL->execute(array(
                                                                                    'durum' => '1',
                                                                                ));

                                                                                $kargoUrunSQL = $db->prepare("select * from siparis_kargo where siparis_urun_id=:siparis_urun_id");
                                                                                $kargoUrunSQL->execute(array(
                                                                                    'siparis_urun_id' => $urunKargoRow['id']
                                                                                ));
                                                                                $k2Row = $kargoUrunSQL->fetch(PDO::FETCH_ASSOC);

                                                                                ?>
                                                                                <div class="form-group col-md-12">
                                                                                    <form method="post" action="post.php?process=order_post&status=product_cargo_update">
                                                                                        <input type="hidden" name="pro_id" value="<?=$urunKargoRow['id']?>">
                                                                                        <input type="hidden" name="order_id" value="<?=$row['siparis_no']?>">
                                                                                        <div class="border border-grey p-2">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6 d-flex align-items-start justify-content-start mt-2 mb-2">
                                                                                                    <div style="width: 85px;" class="mr-2">
                                                                                                        <img src="../images/product/<?=$uro['gorsel']?>" style="width: 100%; max-height: 100px">
                                                                                                    </div>
                                                                                                    <div>
                                                                                                        <div class="mb-2" style="font-weight: 500;">
                                                                                                            <?=$urunKargoRow['urun_baslik']?>
                                                                                                        </div>
                                                                                                        <?php if($varyantKargo->rowCount()>'0'  ) {?>
                                                                                                            <div class="mb-2" >
                                                                                                                <?php foreach ($varyantKargo as $var) {?>
                                                                                                                    <?php if($var['tur'] != '2' && $var['tur'] !='4' ) {?>
                                                                                                                        <strong><?=$var['grup_adi']?>:</strong> <?=$var['varyant_adi']?>,
                                                                                                                    <?php }else {

                                                                                                                        $varDetayBilgi = $db->prepare("select * from urun_varyant_ekler where id=:id ");
                                                                                                                        $varDetayBilgi->execute(array(
                                                                                                                            'id' => $var['ekbilgi_id'],
                                                                                                                        ));
                                                                                                                        $ek = $varDetayBilgi->fetch(PDO::FETCH_ASSOC);

                                                                                                                        ?>
                                                                                                                        <?php if($var['tur'] == '2' ) {?>
                                                                                                                            <strong><?=$var['grup_adi']?>:</strong> <?=$ek['icerik']?>,
                                                                                                                        <?php }?>
                                                                                                                        <?php if($var['tur'] == '4' ) {?>
                                                                                                                            <strong><?=$var['grup_adi']?>:</strong> <?php echo date_tr('j F Y, H:i', ''.$ek['icerik'].''); ?>,
                                                                                                                        <?php }?>
                                                                                                                    <?php }?>
                                                                                                                <?php }?>
                                                                                                            </div>
                                                                                                        <?php }?>
                                                                                                        <span style="font-size: 11px ;"><?=$diller['adminpanel-form-text-1504']?> : <?=$urunKargoRow['stok_kodu']?></span>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group col-md-6 mt-2 mb-0">
                                                                                                    <div class="row">
                                                                                                        <div class="form-group col-md-6">
                                                                                                            <label for="product_cargo_delivery_<?=$urunKargoRow['id']?>"><?=$diller['adminpanel-form-text-1501']?></label>
                                                                                                            <select name="kargo_firma" class="form-control select_ajax2" id="product_cargo_delivery_<?=$urunKargoRow['id']?>" style="width: 100%">
                                                                                                                <?php foreach ($kargofirmaSQL as $k2) {?>
                                                                                                                    <option value="<?=$k2['id']?>" <?php if($k2['id'] == $k2Row['kargo_firma'] ) { ?>selected<?php }?>><?=$k2['baslik']?></option>
                                                                                                                <?php }?>
                                                                                                            </select>
                                                                                                        </div>
                                                                                                        <div class="form-group col-md-6">
                                                                                                            <label for="product_cargo_code_<?=$urunKargoRow['id']?>"><?=$diller['adminpanel-form-text-1501']?></label>
                                                                                                            <input type="text" autocomplete="off" name="kargo_takip" value="<?=$k2Row['kargo_takip']?>" id="product_cargo_code_<?=$urunKargoRow['id']?>" class="form-control">
                                                                                                        </div>
                                                                                                        <div class="form-group col-md-12 d-flex align-items-center justify-content-end flex-wrap">
                                                                                                            <div class="dropdown d-inline-block mr-2">
                                                                                                                <a href="" class="btn btn-primary  " type="button" style="font-size: 14px ; " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                                                                                    <i class="fa fa-bell"></i>
                                                                                                                </a>
                                                                                                                <div class="dropdown-menu dropdown-menu-right ssa border p-1  checkbox-menu allow-focus " >
                                                                                                                    <div class="p-2" style="" >
                                                                                                                        <div class="mb-3" style="font-weight: 500; width: 180px">
                                                                                                                            <i class="fa fa-arrow-down"></i> <?=$diller['adminpanel-form-text-1457']?>
                                                                                                                        </div>
                                                                                                                        <?php if($sms['durum'] =='1' ) {?>
                                                                                                                            <div class="w-100">
                                                                                                                                <label style="font-size: 14px ;font-weight: 200 !important; ">
                                                                                                                                    <input type="checkbox" id="sms_noti" name='sms_noti' value="1"> <?=$diller['adminpanel-form-text-1454']?>
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                        <?php }else { ?>
                                                                                                                            <div class="w-100">
                                                                                                                                <label style="font-size: 14px ; font-weight: 200 !important;">
                                                                                                                                    <input type="checkbox" id="smsDisabled" name='smsDisabled' disabled >  <del> <?=$diller['adminpanel-form-text-1454']?></del>
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                        <?php }?>
                                                                                                                        <?php if($ayar['smtp_durum'] == '1' ) {?>
                                                                                                                            <div class="w-100">
                                                                                                                                <label style="font-size: 14px ;font-weight: 200 !important;">
                                                                                                                                    <input type="checkbox" id="email_noti" name='email_noti' value="1"> <?=$diller['adminpanel-form-text-1455']?>
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                        <?php }else { ?>
                                                                                                                            <div class="w-100">
                                                                                                                                <label style="font-size: 14px ;font-weight: 200 !important;">
                                                                                                                                    <input type="checkbox" id="mailDisabled" name='mailDisabled' disabled >  <del> <?=$diller['adminpanel-form-text-1455']?></del>
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                        <?php }?>
                                                                                                                        <?php if($uyevar == '1' && $notiSet['durum'] == '1'  ) {?>
                                                                                                                            <div class="w-100">
                                                                                                                                <label style="font-size: 14px ;font-weight: 200 !important;">
                                                                                                                                    <input type="checkbox" id="noti" name='noti' value="1"> <?=$diller['adminpanel-form-text-1456']?>
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                        <?php }else { ?>
                                                                                                                            <div class="w-100">
                                                                                                                                <label style="font-size: 14px ;font-weight: 200 !important;">
                                                                                                                                    <input type="checkbox" id="notDisabled" name='notDisabled' disabled >  <del> <?=$diller['adminpanel-form-text-1456']?></del>
                                                                                                                                </label>
                                                                                                                            </div>
                                                                                                                        <?php }?>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <button id="waitButton-<?=$urunKargoRow['id']?>" name="kargoTip2" class="btn btn-success " style="width: 150px" ><?=$diller['adminpanel-form-text-53']?></button>
                                                                                                            <script>
                                                                                                                $('#waitButton-<?=$urunKargoRow['id']?>').click(function () {
                                                                                                                    $(document).ajaxSend(function () {
                                                                                                                        $("#waitProcessOverlay").fadeIn(300);
                                                                                                                    });
                                                                                                                    $.ajax({
                                                                                                                        type: 'GET',
                                                                                                                        success: function (data) {
                                                                                                                            console.log(data);
                                                                                                                        } }).
                                                                                                                    done(function () {
                                                                                                                        setTimeout(function () {
                                                                                                                            $("#waitProcessOverlay").fadeOut(300);
                                                                                                                        }, 15000);
                                                                                                                    });
                                                                                                                });
                                                                                                            </script>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            <?php }?>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <script>
                                                                $('#kargo_sekli').on('change', function() {
                                                                    $('#tek-paket').css('display', 'none');
                                                                    if ( $(this).val() === '0' ) {
                                                                        $('#tek-paket').css('display', 'block');
                                                                    }
                                                                    $('#cok-paket').css('display', 'none');
                                                                    if ( $(this).val() === '1' ) {
                                                                        $('#cok-paket').css('display', 'block');
                                                                    }
                                                                });
                                                            </script>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--  <========SON=========>>> Cargo Settings SON !-->




                                <!-- Operator Notepad !-->
                                <div class="col-md-12 mb-3 operator-notes">
                                    <div class="border border-grey " >
                                        <div class="p-3 border-bottom border-grey  d-flex align-items-center text-dark justify-content-between flex-wrap">
                                            <div class="d-flex align-items-center justify-content-start flex-wrap ">
                                                <i class="fa fa-edit mr-3" style="font-size: 20px ;"></i>
                                                <div>
                                                    <div style="font-size: 18px; font-weight: 600;">
                                                        <?=$diller['adminpanel-form-text-1505']?> (<?=$notdefteri->rowCount()?>)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="post.php?process=order_post&status=note_add" method="post">
                                            <div class="row p-3">
                                                <input type="hidden" name="order_id" value="<?=$row['siparis_no']?>">
                                                <!-- Note Contents !-->
                                                <div class="form-group col-md-12">
                                                    <?php foreach ($notdefteri as $nots ) {?>
                                                        <div class="border border-grey form-group">
                                                            <div class=" p-3 d-flex align-items-center justify-content-start flex-wrap ">
                                                                <div style="width: 150px">
                                                                    <div style="font-size: 13px ; font-weight: 500;">
                                                                        <?=$nots['operator']?>
                                                                    </div>
                                                                    <div style="font-size: 11px ; margin-bottom: 8px;" >
                                                                        <?php echo date_tr('j F Y, H:i', ''.$nots['tarih'].''); ?>
                                                                    </div>
                                                                    <?php if($nots['open'] =='1' ) {?>
                                                                        <div  style="font-size: 11px ;" class="mb-1" >
                                                                            <a href="javascript:Void(0)" class="bg-success" style="width: 15px; height: 15px; color: #FFF; padding: 2px 8px; border-radius: 2px  ">
                                                                                <i class="fa fa-eye"></i>  <?=$diller['adminpanel-form-text-1507']?>
                                                                            </a>
                                                                        </div>
                                                                    <?php }?>
                                                                    <div>
                                                                        <a href="" data-href="post.php?process=order_post&status=note_delete&no=<?=$nots['id']?>&orderID=<?=$row['siparis_no']?>"  data-toggle="modal" data-target="#confirm-delete" class="bg-danger" style="width: 15px; height: 15px; color: #FFF; padding: 2px 8px; border-radius: 2px  ">
                                                                            <i class="fa fa-trash" style="font-size: 10px ;"></i>  <?=$diller['adminpanel-text-160']?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="p-3 bg-light border-left border-right flex-grow-1 mt-2 mb-2">
                                                                    <?=$nots['icerik']?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                                <!--  <========SON=========>>> Note Contents SON !-->
                                                <div class="form-group col-md-12">
                                                    <textarea name="order_note" class="form-control" rows="3"   placeholder="* <?=$diller['adminpanel-form-text-1506']?>"></textarea>
                                                </div>
                                                <div class="form-group col-md-12 d-flex align-items-center justify-content-end flex-wrap">
                                                    <div>
                                                        <div class="kustom-checkbox mr-4">
                                                            <input type="checkbox"  id="open_note" name='open_note' value="1">
                                                            <label for="open_note"><?=$diller['adminpanel-form-text-1507']?></label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <button name="noteAdd" style="width: 150px" class="btn btn-success "  >
                                                            <?=$diller['adminpanel-form-text-53']?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--  <========SON=========>>> Operator Notepad SON !-->

                            </div>




                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Contents SON !-->


            </div>
        <?php }else { ?>
            <div class="card p-xl-5">
                <h3><?=$diller['adminpanel-text-136']?></h3>
                <h6><?=$diller['adminpanel-text-137']?></h6>
                <div  class="mt-3">
                    <a href="<?=$ayar['panel_url']?>" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                </div>
            </div>
        <?php }?>
    </div>
</div>
<script>
    $(function () {
        $('#iptalAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#iptalAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#bildirimAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#bildirimAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#kargoAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#kargoAcc').offset().top - 80 },
                500);
        });
    });
</script>
<?php if($_SESSION['collepse_status'] == 'kargoAcc'  ) {?>
    <script>
        $('#kargoAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#kargoAcc').offset().top - 80 },
            0);
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'operatorNote'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('.operator-notes').offset().top
            }, 300);
            return false;
        });
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'product_list'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('.product-list-area').offset().top
            }, 300);
            return false;
        });
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<script>    $(document).ready(function() {
        $('.select_ajax2').select2();
    });</script>