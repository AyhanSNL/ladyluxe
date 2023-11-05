<?php
if($_SESSION['go_product'] == 'okay'  ) {
 $_SESSION['main_alert_product'] = 'main_alert_product';
 unset($_SESSION['go_product']);
}
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'info';

$urunBilgisi = $db->prepare("select * from urun where id=:id and dil=:dil ");
$urunBilgisi->execute(array(
        'id' => $_GET['productID'],
        'dil' => $_SESSION['dil'],
));
$urunKutuAyar = $db->prepare("select resim_big_w,resim_big_h from urun_kutu where id='1' ");
$urunKutuAyar->execute();
$urunboxRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
$resim_big_w = $urunboxRow['resim_big_w'];
$resim_big_h = $urunboxRow['resim_big_h'];

if($urunBilgisi->rowCount()>'0' ) {
 $row = $urunBilgisi->fetch(PDO::FETCH_ASSOC);
    $sayfaSorgu = $db->prepare("select * from urun_detay where id='1' ");
    $sayfaSorgu->execute();
    $urunDetay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
}else{

    header('Location:'.$ayar['panel_url'].'pages.php?page=products');
    exit();
}

$addedUser = $row['ekleyen'];

$yoneticiBilgiCek = $db->prepare("select random_id from yonetici where user_adi=:user_adi ");
$yoneticiBilgiCek->execute(array(
    'user_adi' => $row['ekleyen'],
));
$useradi = $yoneticiBilgiCek->fetch(PDO::FETCH_ASSOC);

if($yoneticiBilgiCek->rowCount()>'0'  ) {
    $addedUser = '<a href="pages.php?page=admin_edit&no='.$useradi['random_id'].'" target="_blank">'.$row['ekleyen'].'</a>';
}else{
    $addedUser = $row['ekleyen'];
}

$urunAddInfo = $diller['adminpanel-form-text-1601'];
$urunAddInfo  = $urunAddInfo;
$eski   = array('{tarih}','{user}');
$yeni   = array(date_tr('j F Y, H:i', ''.$row['tarih'].''),$addedUser);
$urunAddInfo = str_replace($eski, $yeni, $urunAddInfo);

$satisCount = $row['satis_adet'];

$marka = $db->prepare("select baslik,id from urun_marka where durum=:durum order by sira asc ");
$marka->execute(array(
        'durum' => '1',
));

$anaKategori = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
$anaKategori->execute(array(
    'durum' => '1',
    'dil' => $_SESSION['dil'],
    'ust_id' => '0',
));

$anaKategori_multi = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
$anaKategori_multi->execute(array(
    'durum' => '1',
    'dil' => $_SESSION['dil'],
    'ust_id' => '0',
));

/* Multiple Categories Parse */
$kats1 = $row['kat_id'];
$kats1 = explode(',', $kats1);
$kats2 = $row['kat_id'];
$kats2 = explode(',', $kats2);
$kats3 = $row['kat_id'];
$kats3 = explode(',', $kats3);
$kats4 = $row['kat_id'];
$kats4 = explode(',', $kats4);
$kats5 = $row['kat_id'];
$kats5 = explode(',', $kats5);
/*  <========SON=========>>> Multiple Categories Parse SON */

?>
<title><?=$row['baslik']?> <?=$diller['adminpanel-form-text-1799']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-2']?></a>
                                <a href="pages.php?page=products"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-3']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$row['baslik']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['katalog'] == '1' && $yetki['urun'] == '1') { ?>

            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="new-buttonu-main-top mb-0  pb-2 ">
                                        <div class="new-buttonu-main-left w-100">
                                            <a href="pages.php?page=products" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                            </a>
                                            <div style="font-size: 20px; font-weight: 600; width: 100%;  " class="d-flex align-items-center justify-content-between flex-wrap pt-2 pb-2">
                                                <div>
                                                    <div>
                                                        <?=$row['baslik']?>
                                                        <a href="<?=$ayar['site_url']?><?=$row['seo_url']?>-P<?=$row['id']?>" target="_blank">
                                                            <i class="fa fa-external-link-alt"></i>
                                                        </a>
                                                    </div>
                                                    <div style="font-size: 13px ; font-weight: 200; color: #666;" class="mt-2">
                                                        <?=$urunAddInfo?>
                                                    </div>
                                                    <?php if($satisCount >'0'  ) {
                                                        $satisKaynak = $diller['adminpanel-form-text-1602'];
                                                        $satisKaynak  = $satisKaynak;
                                                        $eski   = '{count}';
                                                        $yeni   = '<strong style="font-weight: 600; color: #cc4f5d">' .$row['satis_adet'].'</strong>';
                                                        $satisKaynak = str_replace($eski, $yeni, $satisKaynak);
                                                        ?>
                                                        <!-- Total Sale !-->
                                                        <div style="font-size: 13px ; font-weight: 200; color: #999;" class="mt-2">
                                                            <?=$satisKaynak?>
                                                        </div>
                                                        <!--  <========SON=========>>> Total Sale SON !-->
                                                    <?php }?>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                
                                    <?php include 'inc/modules/catalog/product_tabs.php'; ?>


                                    <div class="tab-content bg-white rounded-bottom border border-top-0">
                                        <div class="tab-pane active p-3" id="one" role="tabpanel" >
                                            <form action="post.php?process=catalog_post&status=product_post" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="tab" value="product_info" >
                                                <input type="hidden" name="product_id" value="<?=$row['id']?>" >
                                                <div class="row">

                                                    <div class="col-md-12 mb-3">
                                                        <div class="border p-3 rounded  text-dark ">
                                                            <div class="in-header-page-main" >
                                                                <div class="in-header-page-text">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    <?=$diller['adminpanel-form-text-1637']?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-3">
                                                                    <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-1749']?></label>
                                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                                        <input type="hidden" name="durum" value="0"">
                                                                        <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  <?php if($row['durum'] == '1'  ) { ?>checked<?php }?> ">
                                                                        <label class="custom-control-label" for="durum"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-3 ">
                                                                    <label  for="gorunmez" class="w-100 d-flex align-items-center justify-content-start" >
                                                                        <?=$diller['adminpanel-form-text-1754']?>
                                                                        <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1755']?>"></i>
                                                                    </label>
                                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                                        <input type="hidden" name="gorunmez" value="0"">
                                                                        <input type="checkbox" class="custom-control-input" id="gorunmez" name="gorunmez" value="1"  <?php if($row['gorunmez'] == '1'  ) { ?>checked<?php }?> ">
                                                                        <label class="custom-control-label" for="gorunmez"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6 ">
                                                                    <label for="siparis_islem" class="w-100 d-flex align-items-center justify-content-start" >
                                                                        <?=$diller['adminpanel-form-text-1619']?>
                                                                    </label>
                                                                    <select name="siparis_islem" class="form-control selet2" id="siparis_islem" style="width: 100%;  " >
                                                                        <option value="0" <?php if($row['siparis_islem'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1620']?></option>
                                                                        <option value="1" <?php if($row['siparis_islem'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1621']?></option>
                                                                        <option value="2" <?php if($row['siparis_islem'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1622']?></option>
                                                                        <option value="3" <?php if($row['siparis_islem'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1623']?></option>
                                                                        <option value="4" <?php if($row['siparis_islem'] == '4' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1624']?></option>
                                                                        <option value="5" <?php if($row['siparis_islem'] == '5' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1625']?></option>
                                                                        <option value="6" <?php if($row['siparis_islem'] == '6' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1626']?></option>
                                                                        <?php if($odemeRow['wp_siparis'] == '1' ) {?>
                                                                            <option value="7" <?php if($row['siparis_islem'] == '7' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1627']?></option>
                                                                        <?php }else { ?>
                                                                            <option disabled <?php if($row['siparis_islem'] == '7' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1627']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="border rounded p-3">
                                                                    <div class="in-header-page-main" >
                                                                        <div class="in-header-page-text">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1636']?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12 form-group">
                                                                            <label for="baslik"><?=$diller['adminpanel-form-text-1748']?></label>
                                                                            <input type="text" name="baslik" autocomplete="off" value="<?=$row['baslik']?>" id="baslik" required class="form-control">
                                                                        </div>
                                                                        <div class="col-md-4 form-group">
                                                                            <label for="barkod"><?=$diller['adminpanel-form-text-1781']?></label>
                                                                            <input type="text" name="barkod" autocomplete="off" value="<?=$row['barkod']?>" id="barkod"  class="form-control">
                                                                        </div>
                                                                        <div class="col-md-4 form-group">
                                                                            <label for="urun_kod" class="w-100 d-flex align-items-center justify-content-start">
                                                                                <?=$diller['adminpanel-form-text-1758']?>
                                                                                <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1760']?>"></i>
                                                                            </label>
                                                                            <input type="text" name="urun_kod" autocomplete="off" value="<?=$row['urun_kod']?>" id="urun_kod"  class="form-control">
                                                                        </div>
                                                                        <div class="col-md-4 form-group">
                                                                            <label for="stok"><?=$diller['adminpanel-form-text-1836']?></label>
                                                                            <input type="number" name="stok" autocomplete="off" value="<?=$row['stok']?>" id="stok" required class="form-control">
                                                                        </div>
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="marka"><?=$diller['adminpanel-form-text-1628']?></label>
                                                                            <select name="marka" class="form-control selet2" id="marka" style="width: 100%;  " >
                                                                                <option value="0" <?php if($row['marka'] == null ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1629']?></option>
                                                                                <?php foreach ($marka as $markarow) {?>
                                                                                    <option value="<?=$markarow['id']?>" <?php if($row['marka'] == $markarow['id'] ) { ?>selected<?php }?>><?=$markarow['baslik']?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                        <style>
                                                                            .select2-results__option {
                                                                                font-size: 12px;
                                                                            }
                                                                        </style>
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="iliskili_kat" class="w-100 d-flex align-items-center justify-content-start">
                                                                                <?=$diller['adminpanel-form-text-1630']?>
                                                                                <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1631']?>"></i>
                                                                            </label>
                                                                            <select name="iliskili_kat" class="form-control selet2" id="iliskili_kat" style="width: 100%; font-size: 11px !important ;  " required >
                                                                                <option value="">-- <?=$diller['adminpanel-form-text-1632']?></option>
                                                                                <?php foreach ($anaKategori as $anakatRow) {
                                                                                    $anaKategori_2 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                                                    $anaKategori_2->execute(array(
                                                                                            'durum' => '1',
                                                                                            'dil' => $_SESSION['dil'],
                                                                                            'ust_id' => $anakatRow['id'],
                                                                                    ));
                                                                                    ?>
                                                                                    <option value="<?=$anakatRow['id']?>" <?php if($row['iliskili_kat'] == $anakatRow['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?></option>
                                                                                    <?php foreach ($anaKategori_2 as $anakatRow2) {
                                                                                        $anaKategori_3 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                                                        $anaKategori_3->execute(array(
                                                                                            'durum' => '1',
                                                                                            'dil' => $_SESSION['dil'],
                                                                                            'ust_id' => $anakatRow2['id'],
                                                                                        ));
                                                                                        ?>
                                                                                        <option class="asd" value="<?=$anakatRow2['id']?>" <?php if($row['iliskili_kat'] == $anakatRow2['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?></option>
                                                                                        <?php foreach ($anaKategori_3 as $anakatRow3) {
                                                                                            $anaKategori_4 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                                                            $anaKategori_4->execute(array(
                                                                                                'durum' => '1',
                                                                                                'dil' => $_SESSION['dil'],
                                                                                                'ust_id' => $anakatRow3['id'],
                                                                                            ));
                                                                                            ?>
                                                                                            <option value="<?=$anakatRow3['id']?>" <?php if($row['iliskili_kat'] == $anakatRow3['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?></option>
                                                                                            <?php foreach ($anaKategori_4 as $anakatRow4) {
                                                                                                $anaKategori_5 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                                                                $anaKategori_5->execute(array(
                                                                                                    'durum' => '1',
                                                                                                    'dil' => $_SESSION['dil'],
                                                                                                    'ust_id' => $anakatRow4['id'],
                                                                                                ));?>
                                                                                                <option value="<?=$anakatRow4['id']?>" <?php if($row['iliskili_kat'] == $anakatRow4['id'] ) { ?>selected<?php }?> > <?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?> > <?=$anakatRow4['baslik']?></option>
                                                                                                <?php foreach ($anaKategori_5 as $anakatRow5) {?>
                                                                                                    <option value="<?=$anakatRow5['id']?>" <?php if($row['iliskili_kat'] == $anakatRow5['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?> > <?=$anakatRow4['baslik']?> > <?=$anakatRow5['baslik']?></option>
                                                                                                <?php }?>
                                                                                            <?php }?>
                                                                                        <?php }?>
                                                                                    <?php }?>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12 form-group">
                                                                            <label for="kat_id" class="w-100 d-flex align-items-center justify-content-start">
                                                                                <?=$diller['adminpanel-form-text-1634']?>
                                                                                <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1635']?>"></i>
                                                                            </label>
                                                                            <select name="kat_id[]" class="form-control selet2" id="kat_id" style="width: 100%; font-size: 11px !important ;  " multiple required >
                                                                                <?php foreach ($anaKategori_multi as $anakatRow) {
                                                                                    $anaKategori_2 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                                                    $anaKategori_2->execute(array(
                                                                                        'durum' => '1',
                                                                                        'dil' => $_SESSION['dil'],
                                                                                        'ust_id' => $anakatRow['id'],
                                                                                    ));
                                                                                    ?>

                                                                                    <option value="<?=$anakatRow['id']?>"
                                                                                        <?php foreach ($kats1 as $key1) {?>
                                                                                            <?php if($anakatRow['id'] == $key1  ) {?>
                                                                                                selected
                                                                                            <?php }?>
                                                                                        <?php }?>
                                                                                    ><?=$anakatRow['baslik']?></option>

                                                                                    <?php foreach ($anaKategori_2 as $anakatRow2) {
                                                                                        $anaKategori_3 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                                                        $anaKategori_3->execute(array(
                                                                                            'durum' => '1',
                                                                                            'dil' => $_SESSION['dil'],
                                                                                            'ust_id' => $anakatRow2['id'],
                                                                                        ));
                                                                                        ?>

                                                                                        <option class="asd" value="<?=$anakatRow2['id']?>"
                                                                                            <?php foreach ($kats2 as $key2) {?>
                                                                                                <?php if($anakatRow2['id'] == $key2  ) {?>
                                                                                                    selected
                                                                                                <?php }?>
                                                                                            <?php }?>
                                                                                        ><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?></option>

                                                                                        <?php foreach ($anaKategori_3 as $anakatRow3) {
                                                                                            $anaKategori_4 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                                                            $anaKategori_4->execute(array(
                                                                                                'durum' => '1',
                                                                                                'dil' => $_SESSION['dil'],
                                                                                                'ust_id' => $anakatRow3['id'],
                                                                                            ));
                                                                                            ?>

                                                                                            <option value="<?=$anakatRow3['id']?>"
                                                                                                <?php foreach ($kats3 as $key3) {?>
                                                                                                    <?php if($anakatRow3['id'] == $key3  ) {?>
                                                                                                        selected
                                                                                                    <?php }?>
                                                                                                <?php }?>
                                                                                            > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?></option>

                                                                                            <?php foreach ($anaKategori_4 as $anakatRow4) {
                                                                                                $anaKategori_5 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                                                                $anaKategori_5->execute(array(
                                                                                                    'durum' => '1',
                                                                                                    'dil' => $_SESSION['dil'],
                                                                                                    'ust_id' => $anakatRow4['id'],
                                                                                                ));?>

                                                                                                <option value="<?=$anakatRow4['id']?>"
                                                                                                    <?php foreach ($kats4 as $key4) {?>
                                                                                                        <?php if($anakatRow4['id'] == $key4  ) {?>
                                                                                                            selected
                                                                                                        <?php }?>
                                                                                                    <?php }?>
                                                                                                > <?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?> > <?=$anakatRow4['baslik']?></option>

                                                                                                <?php foreach ($anaKategori_5 as $anakatRow5) {?>

                                                                                                    <option value="<?=$anakatRow5['id']?>"
                                                                                                        <?php foreach ($kats5 as $key5) {?>
                                                                                                            <?php if($anakatRow5['id'] == $key5  ) {?>
                                                                                                                selected
                                                                                                            <?php }?>
                                                                                                        <?php }?>
                                                                                                    ><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?> > <?=$anakatRow4['baslik']?> > <?=$anakatRow5['baslik']?></option>

                                                                                                <?php }?>
                                                                                            <?php }?>
                                                                                        <?php }?>
                                                                                    <?php }?>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="border rounded p-3 mt-3 mb-3">
                                                                    <div class="in-header-page-main" >
                                                                        <div class="in-header-page-text">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1638']?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="checkbox" class="individual" id="anasayfa" name='anasayfa' value="1" <?php if($row['anasayfa'] == '1' ) { ?>checked<?php }?>>
                                                                                <label for="anasayfa"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1777']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="checkbox" class="individual" id="yeni" name='yeni' value="1" <?php if($row['yeni'] == '1' ) { ?>checked<?php }?>>
                                                                                <label for="yeni"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1681']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="checkbox" class="individual" id="firsat" name='firsat' value="1" <?php if($row['firsat'] == '1' ) { ?>checked<?php }?>>
                                                                                <label for="firsat"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1773']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="checkbox" class="individual" id="editor_secim" name='editor_secim' value="1" <?php if($row['editor_secim'] == '1' ) { ?>checked<?php }?>>
                                                                                <label for="editor_secim"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1779']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mb-3">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="checkbox" class="individual" id="taksit" name='taksit' value="1" <?php if($row['taksit'] == '1' ) { ?>checked<?php }?>>
                                                                                <label for="taksit"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1633']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="hidden" name="yorum_durum" value="1">
                                                                                <input type="checkbox" class="individual" id="yorum_durum" name='yorum_durum' value="0" <?php if($row['yorum_durum'] == '0' ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                                                <label for="yorum_durum"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1639']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <?php if($urunDetay['star_rate'] == '1' ) {?>
                                                                            <div id="actionBox" class="col-md-12 mt-3" <?php if($row['yorum_durum'] != '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                                                <div class="border bg-light rounded p-3 up-arrow-2">
                                                                                    <div class="row">
                                                                                        <div class=" col-md-12">
                                                                                            <label for="star_rate"><?=$diller['adminpanel-form-text-1640']?></label><br>
                                                                                            <input type="hidden" name="star_rate" value="<?=$row['star_rate']?>" class="rating" data-filled="mdi mdi-star font-20 text-warning" data-empty="mdi mdi-star-outline font-20 text-muted"/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <script id="rendered-js" >
                                                                                function actionBox(selected)
                                                                                {
                                                                                    if (selected)
                                                                                    {
                                                                                        document.getElementById("actionBox").style.display = "";
                                                                                    } else

                                                                                    {
                                                                                        document.getElementById("actionBox").style.display = "none";
                                                                                    }

                                                                                }
                                                                            </script>
                                                                        <?php }?>



                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="border rounded p-3">
                                                                    <div class="in-header-page-main" >
                                                                        <div class="in-header-page-text">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1761']?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-12 mb-0">
                                                                            <div class="w-100 bg-light border p-3 border-bottom-0">
                                                                                <div class="mx-auto" style=" text-align: center;">
                                                                                    <?php if($row['gorsel'] != 'no-img.jpg' ) {?>
                                                                                        <input type="hidden" name="old_img" value="<?=$row['gorsel']?>">
                                                                                        <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/product/<?=$row['gorsel']?>" >
                                                                                    <?php }else { ?>
                                                                                        <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/product/<?=$row['gorsel']?>" >
                                                                                    <?php }?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <div class="custom-file">
                                                                                    <input type="file" class="custom-file-input" id="inputGroupFile01_2" name="gorsel" >
                                                                                    <label class="custom-file-label" for="inputGroupFile01_2" style="border-radius: 0"><?=$diller['adminpanel-form-text-106']?></label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="w-100 text-center bg-light rounded text-dark mt-2 p-2">
                                                                                <small>[<?=$resim_big_w?>x<?=$resim_big_h?>] - png,  jpg, gif, webp, bmp</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 ">
                                                        <button class="btn  btn-success btn-block buttonTextStyle "  name="info_update">
                                                            <?=$diller['adminpanel-form-text-1641']?>
                                                            <div style="font-size: 11px ; font-weight: 100;"><?=$diller['adminpanel-form-text-1642']?></div>
                                                        </button>
                                                    </div>


                                                </div>
                                            </form>
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
<script type='text/javascript'>
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>
<script src="plugins/bootstrap-rating/bootstrap-rating.min.js"></script>
<script src="assets/pages/rating-init.js"></script>

