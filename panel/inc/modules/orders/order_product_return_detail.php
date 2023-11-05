<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'order_product_return';
$returnDetail = $db->prepare("select * from siparis_urunler_iade where talep_no=:talep_no ");
$returnDetail->execute(array(
    'talep_no' => $_GET['no']
));
$row = $returnDetail->fetch(PDO::FETCH_ASSOC);

/* Yeni durumunu 0 yap */
if($row['yeni'] == '1' ) {
    $guncelle = $db->prepare("UPDATE siparis_urunler_iade SET
        yeni=:yeni
 WHERE talep_no={$_GET['no']}      
");
    $sonuc = $guncelle->execute(array(
        'yeni' => '0',
    ));
}
/*  <========SON=========>>> Yeni durumunu 0 yap SON */
if($returnDetail->rowCount()<='0'  ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=order_product_return');
    exit();
}
//todo ürün iadesi kabul ise iade edilen tutarı ekle
$siparisUrun = $db->prepare("select * from siparis_urunler where id=:id ");
$siparisUrun->execute(array(
        'id' => $row['urun_id'],
));
$sipUrun = $siparisUrun->fetch(PDO::FETCH_ASSOC);


$urunAsil = $db->prepare("select gorsel,id,seo_url,baslik from urun where id=:id ");
$urunAsil->execute(array(
        'id' => $sipUrun['urun_id'],
));
$urun =$urunAsil ->fetch(PDO::FETCH_ASSOC);

$varyant = $db->prepare("select * from siparis_varyant where urun_id=:urun_id and siparis_id=:siparis_id ");
$varyant->execute(array(
    'urun_id' => $sipUrun['urun_id'],
    'siparis_id' => $row['siparis_no'],
));

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

$siparisDetay = $db->prepare("select odeme_tur,parabirimi from siparisler where siparis_no=:siparis_no ");
$siparisDetay->execute(array(
        'siparis_no' => $row['siparis_no'],
));
$siparis = $siparisDetay->fetch(PDO::FETCH_ASSOC);

?>
<title>#<?=$row['talep_no']?> <?=$diller['adminpanel-form-text-1572']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=order_product_return"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-21']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> #<?=$row['talep_no']?> <?=$diller['adminpanel-form-text-1572']?></a>
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
                            <a href="pages.php?page=order_product_return" class="btn btn-outline-dark   btn-sm  " >
                                <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                            </a>
                            <div class="d-flex align-items-center flex-wrap justify-content-between  pb-2  mt-2" >
                                <h5>#<?=$row['talep_no']?> <?=$diller['adminpanel-form-text-1572']?></h5>
                            </div>
                            <!--  <========SON=========>>> Header SON !-->




                            <div class="row">

                                <div class="col-md-12 mb-3">
                                    <div class="border border-grey pt-3 pl-3 pr-3 pb-0">
                                        <div class="row">
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1471']?></label>
                                                <div class="text">
                                                    #<?=$row['talep_no']?>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-text-91']?></label>
                                                <div class="text">
                                                    <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>" target="_blank">
                                                        #<?=$row['siparis_no']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-top-form form-group">
                                                <label class="text-uppercase"><?=$diller['adminpanel-form-text-1472']?></label>
                                                <div class="text">
                                                    <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
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
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .urundiv{
                                        width: 100%;
                                        display: flex;
                                        align-items: flex-start;
                                        justify-content: flex-start;
                                        flex-wrap: wrap;
                                        box-sizing: border-box;
                                        margin-bottom: 20px;
                                        margin-top: 18px;
                                    }
                                    .urun-img{
                                        width: 100px;
                                        margin-right: 15px;
                                    }
                                    .urun-img img{
                                        width: 100%;
                                    }
                                    .urun-text{
                                        flex:1;
                                    }
                                    .urun-text-h{
                                        width: 100%;
                                        font-size: 15px ;
                                        font-weight: 600;
                                        margin-bottom: 8px;
                                    }
                                    .urun-text-s{
                                        font-size: 13px ;
                                        width: 100%;
                                    }
                                </style>
                                <div class="col-md-12 mb-3">
                                    <div class="border border-grey pt-3 pl-3 pr-3 pb-0">
                                        <div class="w-100 border-bottom border-grey pb-2 mb-2" style="font-size: 18px ; font-weight: 600;">
                                            <?=$diller['adminpanel-form-text-1566']?>
                                        </div>
                                        <div class="urundiv">
                                            <div class="urun-img">
                                                <img src="../images/product/<?=$urun['gorsel']?>">
                                            </div>
                                            <div class="urun-text">
                                                <div class="urun-text-h">
                                                    <?=$urun['baslik']?>
                                                </div>
                                                <!-- Varyantlar !-->
                                                <?php if($varyant->rowCount()>'0'  ) {?>
                                                    <div class="w-100 mt-2">
                                                        <?php foreach ($varyant as $var) {?>
                                                            <?php if($var['tur'] != '2' && $var['tur'] != '4' ) {?>
                                                                <div class="w-100 mb-2" style="background: #fff;">
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
                                                                    <div class="w-100  mb-2" style="background: #fff;">
                                                                        <?php if($var['tur'] == '2' ) {?>
                                                                            <strong><?=$var['grup_adi']?>:</strong> <?=$ek['icerik']?>
                                                                        <?php }?>
                                                                        <?php if($var['tur'] == '4' ) {?>
                                                                            <strong><?=$var['grup_adi']?>:</strong> <?php echo date_tr('j F Y', ''.$ek['icerik'].''); ?>
                                                                        <?php }?>
                                                                        <?php if($var['ek_fiyat'] >'0' ) {?>
                                                                            [ + <?php echo number_format($var['ek_fiyat'], 2); ?> <?=$row['parabirimi']?> ]
                                                                        <?php }?>
                                                                    </div>
                                                                <?php }?>
                                                            <?php }?>
                                                        <?php }?>
                                                    </div>
                                                <?php }?>
                                                <!--  <========SON=========>>> Varyantlar SON !-->
                                                <div class="urun-text-s border-top border-grey border-bottom bg-light">
                                                    <strong><?=$diller['adminpanel-form-text-1504']?> :</strong> <?=$sipUrun['stok_kodu']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-100 border p-3 mb-3">
                                            <div class="w-100" style="font-size: 18px ;">
                                             <?=$diller['adminpanel-form-text-1575']?>
                                            </div>
                                            <div class="border-top border-grey pt-3 mt-3">
                                                <?php if($siparis['odeme_tur'] == '2' ) {?>
                                                    <div class="row">
                                                        <?php if($sipUrun['ozel_fiyat_uye'] == '1'  ) {?>
                                                            <div class="col-md-12 mb-2 ">
                                                                <div class="border border-grey p-2 text-left bg-light">
                                                                    <span style="font-size: 14px ;"><?=$diller['adminpanel-form-text-1522']?></span>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                        <div class="col-md-2 mb-1 mt-1">
                                                            <div class="border border-grey p-2 text-center">
                                                                <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1518']?></label>
                                                                <span style="font-size: 14px ;"><?php echo number_format($sipUrun['havale_kdvsiz_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                            </div>
                                                        </div>
                                                        <?php if($sipUrun['havale_kdv_tutar']>'0'  ) {?>
                                                            <div class="col-md-2 mb-1 mt-1">
                                                                <div class="border border-grey p-2 text-center">
                                                                    <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1519']?></label>
                                                                    <span style="font-size: 14px ;"><?php echo number_format($sipUrun['havale_kdv_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                        <div class="col-md-2 mb-1 mt-1">
                                                            <div class="border border-grey p-2 text-center">
                                                                <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1199']?></label>
                                                                <span style="font-size: 14px ;"><?=$sipUrun['adet']?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-1 mt-1">
                                                            <div class="border border-grey p-2 text-center">
                                                                <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1521']?> </label>
                                                                <span style="font-size: 15px ; font-weight: 500;"><?php echo number_format($sipUrun['havale_kdvsiz_tutar']+$sipUrun['havale_kdv_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                            </div>
                                                        </div>
                                                        <?php if($row['sabit_kargo'] == '1'  ) {?>
                                                            <?php if($sipUrun['kargo_tutar'] >'0' ) {?>
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2 d-flex align-items-center justify-content-center">
                                                                            <?=$diller['adminpanel-form-text-1520']?>
                                                                            <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1523']?>"></i>
                                                                        </label>
                                                                        <span style="font-size: 14px ;"><?php echo number_format($sipUrun['kargo_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <div class="col-md-2 mb-1 mt-1">
                                                                <div class="border border-grey p-2 text-center">
                                                                    <label class="border-bottom border-grey w-100 pb-2 d-flex align-items-center justify-content-center">
                                                                        <?=$diller['adminpanel-form-text-1520']?>
                                                                        <?php if($sipUrun['kargo_tipi'] == '1'  ) {?>
                                                                            <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1527']?>"></i>
                                                                        <?php }?>
                                                                    </label>
                                                                    <span style="font-size: 14px ;"><?php echo number_format($sipUrun['kargo_tutar'], 2); ?> <?=$row['parabirimi']?></span>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                <?php }else { ?>
                                                    <?php if($sipUrun['ozel_fiyat_uye'] == '1'  ) {?>
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
                                                                <span style="font-size: 14px ;"><?php echo number_format($sipUrun['kdvsiz_tutar'], 2); ?> <?=$siparis['parabirimi']?></span>
                                                            </div>
                                                        </div>
                                                        <?php if($sipUrun['kdv_tutar']>'0'  ) {?>
                                                            <div class="col-md-2 mb-1 mt-1">
                                                                <div class="border border-grey p-2 text-center">
                                                                    <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1519']?></label>
                                                                    <span style="font-size: 14px ;"><?php echo number_format($sipUrun['kdv_tutar'], 2); ?> <?=$siparis['parabirimi']?></span>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                        <div class="col-md-2 mb-1 mt-1">
                                                            <div class="border border-grey p-2 text-center">
                                                                <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1199']?></label>
                                                                <span style="font-size: 14px ;"><?=$sipUrun['adet']?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-1 mt-1">
                                                            <div class="border border-grey p-2 text-center">
                                                                <label class="border-bottom border-grey w-100 pb-2"><?=$diller['adminpanel-form-text-1521']?> </label>
                                                                <span style="font-size: 15px ; font-weight: 500;"><?php echo number_format(($sipUrun['kdvsiz_tutar']+$sipUrun['kdv_tutar'])*$sipUrun['adet'], 2); ?> <?=$siparis['parabirimi']?></span>
                                                            </div>
                                                        </div>
                                                        <?php if($row['sabit_kargo'] == '1'  ) {?>
                                                            <?php if($sipUrun['kargo_tutar'] >'0' ) {?>
                                                                <div class="col-md-2 mb-1 mt-1">
                                                                    <div class="border border-grey p-2 text-center">
                                                                        <label class="border-bottom border-grey w-100 pb-2 d-flex align-items-center justify-content-center">
                                                                            <?=$diller['adminpanel-form-text-1520']?>
                                                                            <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1523']?>"></i>
                                                                        </label>
                                                                        <span style="font-size: 14px ;"><?php echo number_format($sipUrun['kargo_tutar'], 2); ?> <?=$siparis['parabirimi']?></span>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                        <?php }else { ?>
                                                            <div class="col-md-2 mb-1 mt-1">
                                                                <div class="border border-grey p-2 text-center">
                                                                    <label class="border-bottom border-grey w-100 pb-2 d-flex align-items-center justify-content-center">
                                                                        <?=$diller['adminpanel-form-text-1520']?>
                                                                        <?php if($sipUrun['kargo_tipi'] == '1'  ) {?>
                                                                            <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1527']?>"></i>
                                                                        <?php }?>
                                                                    </label>
                                                                    <span style="font-size: 14px ;"><?php echo number_format($sipUrun['kargo_tutar'], 2); ?> <?=$siparis['parabirimi']?></span>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="w-100 mb-3 border border-grey p-3 bg-light">
                                            <div class="w-100 mb-2 " style="font-size: 18px ; font-weight: 600;">
                                                <?=$diller['adminpanel-form-text-1573']?>
                                            </div>
                                            <?=$row['sebep']?>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 form-group bg-white status-request  ">
                                    <div class="border border-grey">
                                        <div class="border-bottom border-grey pt-2 pb-2 pl-3 pr-3 mb-2 d-flex align-items-center justify-content-between flex-wrap" >
                                            <h6 ><?=$diller['adminpanel-form-text-1574']?></h6>
                                        </div>
                                        <form action="post.php?process=order_post&status=return_product_update" method="post">
                                                <input type="hidden" name="request_id" value="<?=$row['talep_no']?>">
                                                <input type="hidden" name="order_id" value="<?=$row['siparis_no']?>">
                                                <div class="pt-1 pb-0 pl-3 pr-3">
                                                    <div class="form-group">
                                                        <select name="durum" class="form-control select_ajax2" id="durum" style="height: 55px; font-size: 14px ; font-weight: 500;">
                                                            <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1567']?></option>
                                                            <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1569']?></option>
                                                            <option value="2" <?php if($row['durum'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1570']?></option>
                                                            <option value="3" <?php if($row['durum'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1571']?></option>
                                                        </select>
                                                    </div>
                                                    <div id="onaylandi" class=" position-relative" <?php if($row['durum'] != '1'  ) { ?>style="display:none; width: 100%;"  <?php }?> >
                                                       <div class="p-3 bg-light mb-3 border up-arrow-2 ">

                                                           <?php if($siparis['odeme_tur'] == '2' ) {?>
                                                               <div class="kustom-checkbox mr-4">
                                                                   <input type="hidden" name="iban_iste" value="0"">
                                                                   <input type="checkbox"  id="iban_iste" name='iban_iste' value="1" onclick="ibanTalep(this.checked);" <?php if($row['iban_iste'] == '1' ) { ?>checked<?php }?>>
                                                                   <label for="iban_iste"><span style="font-weight: 600 !important;" ><?=$diller['adminpanel-form-text-1953']?></span></label>
                                                               </div>

                                                           <div id="ibanBox" class="w-100 col-md-12 mb-4 " <?php if($row['iban_iste'] != '1'  ) { ?>style="display:none !important;"<?php }?> >
                                                               <div class="row">
                                                                   <div class="p-3 border w-100 mt-2 bg-white">
                                                                       <div class="w-100 ">
                                                                           <?php if($row['iban'] == !null && $row['iban_isim'] == !null  ) {?>
                                                                           <div class="row">
                                                                               <div class="col-md-6  ">
                                                                                   <div class="border-bottom mt-1 mb-1">
                                                                                       <label for=""><?=$diller['adminpanel-form-text-1955']?></label>
                                                                                       <div class="mb-2">
                                                                                           <?=$row['iban']?>
                                                                                       </div>
                                                                                   </div>
                                                                               </div>
                                                                               <div class="col-md-6   ">
                                                                                   <div class="border-bottom mt-1 mb-1">
                                                                                   <label for=""><?=$diller['adminpanel-form-text-1956']?></label>
                                                                                   <div class="mb-2">
                                                                                       <?=$row['iban_isim']?>
                                                                                   </div>
                                                                                   </div>
                                                                               </div>
                                                                           </div>
                                                                           <?php }else { ?>
                                                                           <?=$diller['adminpanel-form-text-1954']?>
                                                                           <?php }?>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                           <?php }?>



                                                           <div class="kustom-checkbox mr-4">
                                                               <input type="hidden" name="durum_kargo" value="0"">
                                                               <input type="checkbox"  id="durum_kargo" name='durum_kargo' value="1" onclick="gonderiTalep(this.checked);" <?php if($row['durum_kargo'] == '1' ) { ?>checked<?php }?>>
                                                               <label for="durum_kargo"><span style="font-weight: 600 !important;" ><?=$diller['adminpanel-form-text-1576']?></span></label>
                                                           </div>

                                                           <div id="gonderiBoxInfo" class="w-100 col-md-12 " <?php if($row['durum_kargo'] != '1'  ) { ?>style="display:none !important;"<?php }?> >
                                                               <div class="row">
                                                                    <div class="p-3 border w-100 mt-2 bg-white">
                                                                        <div class="w-100 mb-3">
                                                                            <label for="kargo_idler"><?=$diller['adminpanel-form-text-1578']?></label>
                                                                            <select name="kargo_idler[]" class="form-control select_ajax2" id="kargo_idler" multiple data-placeholder="<?=$diller['adminpanel-form-text-1579']?>" style="width: 100%;  " >
                                                                                <?php
                                                                                $KargoFirmaları = $db->prepare("select * from kargo_firma where durum=:durum order by sira asc");
                                                                                $KargoFirmaları->execute(array(
                                                                                        'durum' => '1',
                                                                                ));
                                                                                ?>
                                                                                <?php foreach ($KargoFirmaları as $kargo) {
                                                                                    
                                                                                    $IDSorgula = $db->prepare("select * from siparis_urunler_iade where id='$row[id]' and (kargo_idler like '%$kargo[id],%')");
                                                                                    $IDSorgula->execute();

                                                                                    if($IDSorgula->rowCount()>'0'  ) { 
                                                                                     $selec = 'selected';
                                                                                    }else{
                                                                                        $selec = null;
                                                                                    }
                                                                                    
                                                                                    ?>
                                                                                    <option value="<?=$kargo['id']?>" <?=$selec?>><?=$kargo['baslik']?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="w-100 mb-3">
                                                                            <label for="adres"><?=$diller['adminpanel-form-text-1577']?></label>
                                                                            <textarea name="adres" id="adres" class="form-control"  rows="2" ><?=$row['adres']?></textarea>
                                                                        </div>
                                                                        <?php if($row['kargo_firma'] == !null && $row['kargo_takip'] == !null ) {?>
                                                                            <div class="w-100 mb-0 p-3 bg-primary text-white rounded">
                                                                              <div style="font-size: 18px ; font-weight: 600;" class="mb-3"><i class="fa fa-truck"></i> <?=$diller['adminpanel-form-text-1583']?></div>
                                                                                <div class="w-100 mb-3">
                                                                                 <?=$diller['adminpanel-form-text-1584']?>
                                                                                </div>
                                                                            <div class="bg-light text-dark p-2" style="font-size: 14px ;">
                                                                                <div>
                                                                                    <?=$diller['adminpanel-form-text-1501']?> : <strong><?=$row['kargo_firma']?></strong>
                                                                                </div>
                                                                                <div>
                                                                                    <?=$diller['adminpanel-form-text-1500']?> : <strong><?=$row['kargo_takip']?></strong>
                                                                                </div>
                                                                            </div>
                                                                            </div>
                                                                        <?php }else { ?>
                                                                            <div class="w-100 border border-warning alert-warning text-dark p-3">
                                                                                <?=$diller['adminpanel-form-text-1580']?>
                                                                            </div>
                                                                        <?php }?>
                                                                    </div>
                                                               </div>
                                                           </div>


                                                       </div>
                                                    </div>

                                                    <div id="olumlu" class=" position-relative" <?php if($row['durum'] != '2'  ) { ?>style="display:none; width: 100%;"  <?php }?> >
                                                        <div class="p-3 bg-light mb-3 border up-arrow-2 ">
                                                            <div class="w-100 ">
                                                                <div class="kustom-checkbox mr-4">
                                                                    <input type="hidden" name="para_iade" value="0"">
                                                                    <input type="checkbox"  id="para_iade" name='para_iade' value="1" <?php if($row['para_iade'] == '1' ) { ?>checked<?php }?>>
                                                                    <label for="para_iade"><span style="font-weight: 600 !important;" ><?=$diller['adminpanel-form-text-1586']?></span></label>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6 mt-3 mb-0 ">
                                                                        <label for="iade_tutar" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                                            <?=$diller['adminpanel-form-text-1952']?>
                                                                        </label>
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control" id="iade_tutar" value="<?=$row['iade_tutar']?>" name="iade_tutar">
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text font-12 font-weight-bold"><?=$siparis['parabirimi']?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div id="olumsuz" class=" position-relative" <?php if($row['durum'] != '3'  ) { ?>style="display:none; width: 100%;"  <?php }?> >
                                                        <div class="p-3 bg-light mb-3 border up-arrow-2 ">
                                                            <div class="w-100 ">
                                                                <label for="iade_olumsuz_sebep"><?=$diller['adminpanel-form-text-1585']?></label>
                                                                <textarea name="iade_olumsuz_sebep" id="iade_olumsuz_sebep" class="form-control"  rows="2" ><?=$row['iade_olumsuz_sebep']?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        function gonderiTalep(selected)
                                                        {
                                                            if (selected)
                                                            {
                                                                document.getElementById("gonderiBoxInfo").style.display = "";
                                                            } else

                                                            {
                                                                document.getElementById("gonderiBoxInfo").style.display = "none";
                                                            }

                                                        }
                                                        function ibanTalep(selected)
                                                        {
                                                            if (selected)
                                                            {
                                                                document.getElementById("ibanBox").style.display = "";
                                                            } else

                                                            {
                                                                document.getElementById("ibanBox").style.display = "none";
                                                            }

                                                        }

                                                        $('#durum').on('change', function() {
                                                            $('#onaylandi').css('display', 'none');
                                                            if ( $(this).val() === '1' ) {
                                                                $('#onaylandi').css('display', 'block');
                                                            }
                                                            $('#olumlu').css('display', 'none');
                                                            if ( $(this).val() === '2' ) {
                                                                $('#olumlu').css('display', 'block');
                                                            }
                                                            $('#olumsuz').css('display', 'none');
                                                            if ( $(this).val() === '3' ) {
                                                                $('#olumsuz').css('display', 'block');
                                                            }
                                                        });

                                                    </script>

                                                    <div class="d-flex align-items-center justify-content-start flex-wrap">
                                                        <div class="mb-2">
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

                                                    </div>
                                                </div>
                                                <div class="border-top border-grey p-3 bg-light">
                                                    <button name="update" class="btn btn-success btn-block"  id="waitButton">
                                                        <?=$diller['adminpanel-form-text-53']?>
                                                    </button>
                                                </div>
                                      </form>
                                    </div>
                                </div>



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
    $(document).ready(function() {
        $('.select_ajax2').select2();

    });
</script>
<?php if($_SESSION['collepse_status'] == 'status'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('.status-request').offset().top
            }, 300);
            return false;
        });
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>