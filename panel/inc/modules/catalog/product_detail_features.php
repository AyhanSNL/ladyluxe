<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'features';

$urunBilgisi = $db->prepare("select * from urun where id=:id and dil=:dil ");
$urunBilgisi->execute(array(
    'id' => $_GET['productID'],
    'dil' => $_SESSION['dil'],
));
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

$featuresGroup = $db->prepare("select * from urun_ozellik_grup where durum=:durum order by sira asc ");
$featuresGroup->execute(array(
    'durum' => '1',
));


/* Tab Gösterimi */
if(isset($_GET['tab_status']) && $_GET['tab_status'] == 'ok') {
    if ($yetki['demo'] != '1') {

        $UrunSorgu = $db->prepare("select * from urun where id=:id ");
        $UrunSorgu->execute(array(
            'id' => $_GET['productID']
        ));
        if($UrunSorgu->rowCount()>'0'  ) {

            $guncelle = $db->prepare("UPDATE urun SET
                ozellik_tab_durum=:ozellik_tab_durum
             WHERE id={$_GET['productID']}      
            ");
            $sonuc = $guncelle->execute(array(
                'ozellik_tab_durum' => '1',
            ));
            if($sonuc){
                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'');
            }else{
            echo 'Veritabanı Hatası';
            }

        }else{
            header('Location:'.$ayar['site_url'].'404');
        }


    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'');
    }
}
if(isset($_GET['tab_status']) && $_GET['tab_status'] == 'no') {
    if ($yetki['demo'] != '1') {

        $UrunSorgu = $db->prepare("select * from urun where id=:id ");
        $UrunSorgu->execute(array(
            'id' => $_GET['productID']
        ));
        if($UrunSorgu->rowCount()>'0'  ) {

            $guncelle = $db->prepare("UPDATE urun SET
                ozellik_tab_durum=:ozellik_tab_durum
             WHERE id={$_GET['productID']}      
            ");
            $sonuc = $guncelle->execute(array(
                'ozellik_tab_durum' => '0',
            ));
            if($sonuc){
                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'');
            }else{
                echo 'Veritabanı Hatası';
            }

        }else{
            header('Location:'.$ayar['site_url'].'404');
        }


    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'');
    }
}
/*  <========SON=========>>> Tab Gösterimi SON */

/* özellik & filtreleri listele */
$Filter_Features_list = $db->prepare("select * from filtre_ozellik_grup where urun_id=:urun_id group by baslik order by sira asc ");
$Filter_Features_list->execute(array(
        'urun_id' => $row['id'],
));
/*  <========SON=========>>> özellik & filtreleri listele SON */


/* Özellik Grubu Durum Değişimi */
if(isset($_GET['group_status'] )) {

    if($_GET['group_status']  == 'update' || $_GET['group_status']  == 'delete' || $_GET['group_status'] == 'features_delete' || $_GET['group_status'] == 'filterno' || $_GET['group_status'] == 'filterok') {

        if ($yetki['demo'] != '1') {

            if($_GET['group_status'] == 'filterok'  ) {
                $sqlSorgu = $db->prepare("select * from filtre_ozellik where urun_id=:urun_id and id=:id ");
                $sqlSorgu->execute(array(
                    'urun_id' => $_GET['productID'],
                    'id' => $_GET['item_id']
                ));
                if($sqlSorgu->rowCount()>'0') {

                    $guncelle = $db->prepare("UPDATE filtre_ozellik SET
                            filtre=:filtre
                     WHERE id={$_GET['item_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'filtre' => '1'
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'&go=success');
                    }else{
                    echo 'Veritabanı Hatası';
                    }

                }else{
                    echo "hata";
                }
            }
            if($_GET['group_status'] == 'filterno'  ) {
                $sqlSorgu = $db->prepare("select * from filtre_ozellik where urun_id=:urun_id and id=:id ");
                $sqlSorgu->execute(array(
                    'urun_id' => $_GET['productID'],
                    'id' => $_GET['item_id']
                ));
                if($sqlSorgu->rowCount()>'0') {

                    $guncelle = $db->prepare("UPDATE filtre_ozellik SET
                            filtre=:filtre
                     WHERE id={$_GET['item_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'filtre' => '0'
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'&go=success');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    echo "hata";
                }
            }

            if($_GET['group_status'] == 'update'  ) {
                $ozellikGrubuKontrol = $db->prepare("select * from filtre_ozellik_grup where kontrol=:kontrol and urun_id=:urun_id ");
                $ozellikGrubuKontrol->execute(array(
                    'kontrol' => $_GET['group_id'],
                    'urun_id' => $_GET['productID']
                ));
                $durumRowGruo = $ozellikGrubuKontrol->fetch(PDO::FETCH_ASSOC);

                if($ozellikGrubuKontrol->rowCount()>'0'  ) {
                    if($durumRowGruo['durum']  == '1' ) {
                        $yenidurum = '0';
                    }else{
                        $yenidurum = '1';
                    }

                    $guncelle = $db->prepare("UPDATE filtre_ozellik_grup SET
                    durum=:durum
             WHERE kontrol='$_GET[group_id]' and urun_id='$_GET[productID]'      
            ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $yenidurum
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'&go=success');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['group_status'] == 'features_delete'  ) {
                $sqlSorgu = $db->prepare("select * from filtre_ozellik where urun_id=:urun_id and id=:id ");
                $sqlSorgu->execute(array(
                        'urun_id' => $_GET['productID'],
                        'id' => $_GET['item_id']
                ));
                if($sqlSorgu->rowCount()>'0') {
                 $sqlRow = $sqlSorgu->fetch(PDO::FETCH_ASSOC);
                    /* IDleri Güncelle */
                    $urunSql = $db->prepare("select ozellikler from urun where id=:id ");
                    $urunSql->execute(array(
                        'id' => $sqlRow['urun_id']
                    ));
                    $sqlUrun = $urunSql->fetch(PDO::FETCH_ASSOC);
                    $yeniozellikidleri  = $sqlUrun['ozellikler'];
                    $eski   = ''.$sqlRow['ozellik_id'].',';
                    $yeni   = null;
                    $yeniozellikidleri = str_replace($eski, $yeni, $yeniozellikidleri);
                    /*  <========SON=========>>> IDleri Güncelle SON */
                    $guncelle = $db->prepare("UPDATE urun SET
                                        ozellikler=:ozellikler
                                 WHERE id={$sqlRow['urun_id']}      
                                ");
                    $sonuc = $guncelle->execute(array(
                        'ozellikler' => $yeniozellikidleri
                    ));
                    if($sonuc){
                        $silmeislem = $db->prepare("DELETE from filtre_ozellik_grup WHERE kontrol=:kontrol and urun_id=:urun_id and random=:random");
                        $sil = $silmeislem->execute(array(
                            'kontrol' => $sqlRow['kontrol'],
                            'urun_id' => $sqlRow['urun_id'],
                            'random' => $sqlRow['random'],
                        ));
                        if ($sil) {
                            $silmeislem = $db->prepare("DELETE from filtre_ozellik WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $sqlRow['id']
                            ));
                        }else {
                        echo 'veritabanı hatası';
                        }
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'&go=success');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'');
                }
            }

            if($_GET['group_status'] == 'delete'  ) {
                $sqlSorgu = $db->prepare("select * from filtre_ozellik_grup where kontrol=:kontrol and urun_id=:urun_id");
                $sqlSorgu->execute(array(
                        'kontrol' => $_GET['group_id'],
                        'urun_id' => $_GET['productID']
                ));
                if($sqlSorgu->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from filtre_ozellik_grup WHERE kontrol=:kontrol and urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                        'kontrol' => $_GET['group_id'],
                        'urun_id' => $_GET['productID']
                        ));
                        if ($sil) {

                            $sql2 = $db->prepare("select * from filtre_ozellik where kontrol=:kontrol and urun_id=:urun_id ");
                            $sql2->execute(array(
                                'kontrol' => $_GET['group_id'],
                                'urun_id' => $_GET['productID']
                            ));

                            foreach ($sql2 as $sqlRow){
                                /* IDleri Güncelle */
                                $urunSql = $db->prepare("select ozellikler from urun where id=:id ");
                                $urunSql->execute(array(
                                        'id' => $sqlRow['urun_id']
                                ));
                                $sqlUrun = $urunSql->fetch(PDO::FETCH_ASSOC);
                                $yeniozellikidleri  = $sqlUrun['ozellikler'];
                                $eski   = ''.$sqlRow['ozellik_id'].',';
                                $yeni   = null;
                                $yeniozellikidleri = str_replace($eski, $yeni, $yeniozellikidleri);
                                /*  <========SON=========>>> IDleri Güncelle SON */

                                $guncelle = $db->prepare("UPDATE urun SET
                                        ozellikler=:ozellikler
                                 WHERE id={$sqlRow['urun_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'ozellikler' => $yeniozellikidleri
                                ));
                                if($sonuc){
                                    $silmeislem = $db->prepare("DELETE from filtre_ozellik WHERE id=:id");
                                    $sil = $silmeislem->execute(array(
                                        'id' => $sqlRow['id']
                                    ));
                                }else{
                                echo 'Veritabanı Hatası';
                                }
                            }
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'&go=success');

                        }else {
                        echo 'veritabanı hatası';
                        }
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=products');
                    exit();
                }
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_GET['productID'].'');
        }




    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=products');
        exit();
    }
}
/*  <========SON=========>>> Özellik Grubu Durum Değişimi SON */


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

                                    <div class="row">

                                        <div class="col-md-12">
                                            <form action="post.php?process=catalog_post&status=product_post" method="post" >
                                                <input type="hidden" name="tab" value="features" >
                                                <input type="hidden" name="product_id" value="<?=$row['id']?>" >
                                                <input type="hidden" name="categories_id" value="<?=$row['kat_id']?>" >
                                                <?php if($row['kat_id'] == null  ) {?>
                                                    <div class="p-4 border bg-light" style="font-size: 15px ;">
                                                        <?=$diller['adminpanel-form-text-1853']?>
                                                    </div>
                                                <?php }else { ?>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="border border-warning alert-warning text-dark p-3 rounded mb-3">
                                                                <ul class="mb-0 canini">
                                                                    <li><?=$diller['adminpanel-form-text-1802']?></li>
                                                                    <li><?=$diller['adminpanel-form-text-1803']?></li>
                                                                </ul>
                                                            </div>
                                                            <div class="border p-3 rounded mb-3">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="kustom-checkbox">
                                                                            <?php if($row['ozellik_tab_durum'] == '1'  ) {?>
                                                                                <input type="checkbox" class="individual" checked id="ozellik_tab_durum" onclick="javascript:window.location='pages.php?page=product_detail_features&productID=<?=$row['id']?>&tab_status=no'" >
                                                                            <?php }else { ?>
                                                                                <input type="checkbox" class="individual" id="ozellik_tab_durum" onclick="javascript:window.location='pages.php?page=product_detail_features&productID=<?=$row['id']?>&tab_status=ok'" >
                                                                            <?php }?>
                                                                            <label for="ozellik_tab_durum"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                <span class="ml-2" style="font-weight: 600;"><?=$diller['adminpanel-form-text-1801']?></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="border pt-3 pl-3 pr-3 rounded mb-3">
                                                                <div class="in-header-page-main">
                                                                    <div class="in-header-page-text">
                                                                        <i class="fa fa-arrow-down"></i>
                                                                        <?=$diller['adminpanel-menu-text-6']?>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12 form-group">
                                                                        <label for="kontrol"><?=$diller['adminpanel-form-text-1697']?></label>
                                                                        <select name="kontrol" class="form-control selet2" required style="width: 100%">
                                                                            <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                                                                            <?php foreach ($featuresGroup as $grupRow) {?>
                                                                                <option value="<?=$grupRow['id']?>"><?=$grupRow['baslik']?></option>
                                                                            <?php }?>
                                                                        </select>
                                                                    </div>
                                                                    <div id="ajaxcall" style="display:none; width: 100%;  "></div>
                                                                    <div class="col-md-12 form-group mb-0 border-top pt-3 pb-3 bg-light">
                                                                        <button class="btn  btn-success"  name="features_add">
                                                                            <?=$diller['adminpanel-form-text-1696']?>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </form>
                                        </div>


                                        <?php if($Filter_Features_list->rowCount()>'0'  ) {?>
                                           <div class="col-md-12 ">
                                            <div class="p-3 border border-info alert-info text-dark rounded mb-3 " style="background-color: #DBEDFF">
                                                <?=$diller['adminpanel-form-text-1807']?>
                                            </div>
                                        </div>
                                        <?php }?>


                                        <style>
                                            .filter-stil-group-name{
                                                width: 200px;
                                                background-color: #f8f8f8;
                                                padding: 15px 10px;
                                                box-sizing: border-box;
                                                font-weight: 600;
                                                font-size: 14px ;
                                                text-align: center;
                                                border-right: 1px solid #EBEBEB;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                flex-wrap: wrap;
                                            }
                                            .filter-stil-features-name{
                                               flex:1;
                                                padding: 15px 10px;
                                                font-size: 14px ;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                flex-wrap: wrap;
                                            }
                                            .one-more-features{
                                                margin-bottom: 15px;
                                                border-bottom: 1px solid #EBEBEB;
                                                padding-bottom: 15px;
                                            }
                                            .one-more-features:last-child{
                                                margin-bottom: 0;
                                                border-bottom: 0;
                                                padding-bottom: 0;
                                            }
                                            @media (max-width: 768px) {
                                                .filter-stil-group-name{
                                                    width: 100% !important;
                                                    border-right: 0 !important;
                                                    border-bottom: 1px solid #EBEBEB;
                                                }
                                                .ozellik-div{
                                                    width: 100% !important;
                                                    margin-bottom: 10px;
                                                }
                                                .canini{
                                                    padding-bottom: 20px;
                                                    padding-left: 14px;
                                                }
                                                .canini li{
                                                    margin-top: 15px;
                                                }
                                            }
                                            .canini li{
                                                margin-bottom: 10px;
                                            }
                                            .canini li:last-child{
                                                margin-bottom: 0;
                                            }
                                        </style>
                                        <div class="col-md-12 " id="scrollArea">
                                            <?php foreach ($Filter_Features_list as $listRow) {
                                                $ozellikListele = $db->prepare("select * from filtre_ozellik where grup_id=:grup_id and urun_id=:urun_id order by sira asc");
                                                $ozellikListele->execute(array(
                                                        'grup_id' => $listRow['real_grup_id'],
                                                        'urun_id' => $row['id'],
                                                ));
                                                ?>
                                                <div class="border rounded  d-flex  justify-content-start flex-wrap mb-3" >
                                                    <div class="filter-stil-group-name">
                                                       <div class="w-100">
                                                           <div class="w-100">
                                                               <?=$listRow['baslik']?>
                                                           </div>
                                                           <div class="w-100 mt-3">
                                                               <?php if($listRow['durum'] == '1' ) {?>
                                                                   <a href="pages.php?page=product_detail_features&productID=<?=$row['id']?>&group_status=update&group_id=<?=$listRow['kontrol']?>" class="btn btn-sm btn-success">
                                                                       <?=$diller['adminpanel-form-text-67']?>
                                                                   </a>
                                                               <?php }else { ?>
                                                                   <a href="pages.php?page=product_detail_features&productID=<?=$row['id']?>&group_status=update&group_id=<?=$listRow['kontrol']?>" class="btn btn-sm btn-secondary">
                                                                       <?=$diller['adminpanel-form-text-68']?>
                                                                   </a>
                                                               <?php }?>

                                                               <a href="" data-href="pages.php?page=product_detail_features&productID=<?=$row['id']?>&group_status=delete&group_id=<?=$listRow['kontrol']?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger">
                                                                   <?=$diller['adminpanel-form-text-1804']?>
                                                               </a>
                                                           </div>
                                                       </div>
                                                    </div>
                                                    <div class="filter-stil-features-name">
                                                        <?php if($ozellikListele->rowCount()>'0'  ) {?>
                                                            <?php foreach ($ozellikListele as $ozellikRow) {?>
                                                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap <?php if($ozellikListele->rowCount()>'1'  ) { ?>one-more-features<?php }?> ">
                                                                    <div class="ozellik-div">
                                                                        <i class="fa fa-caret-right"></i> <?=$ozellikRow['baslik']?>
                                                                    </div>
                                                                    <div>
                                                                        <?php if($ozellikRow['filtre'] == '1' ) {?>
                                                                            <a href="pages.php?page=product_detail_features&productID=<?=$row['id']?>&group_status=filterno&item_id=<?=$ozellikRow['id']?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1808']?>">
                                                                                <i class="fa fa-filter"></i> <?=$diller['adminpanel-form-text-1772']?>
                                                                            </a>
                                                                        <?php }else { ?>
                                                                            <a href="pages.php?page=product_detail_features&productID=<?=$row['id']?>&group_status=filterok&item_id=<?=$ozellikRow['id']?>" data-id="<?=$ozellikRow['id']?>"   class="btn btn-sm btn-primary " >
                                                                                <?=$diller['adminpanel-form-text-1806']?>
                                                                            </a>
                                                                        <?php }?>


                                                                        <?php if($ozellikListele->rowCount()>'1'  ) {?>
                                                                            <a href="" data-href="pages.php?page=product_detail_features&productID=<?=$row['id']?>&group_status=features_delete&item_id=<?=$ozellikRow['id']?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger">
                                                                                <?=$diller['adminpanel-text-160']?>
                                                                            </a>
                                                                        <?php }?>
                                                                    </div>
                                                                </div>
                                                            <?php }?>


                                                        <?php }else { ?>
                                                        <?=$diller['adminpanel-form-text-1805']?>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
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
<script type='text/javascript'>
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("select[name='kontrol']").on('change',function(){
            var grup_id = $("select[name='kontrol']").val();
            jQuery.ajax({
                type: "GET",
                url: "masterpiece.php?page=features_select",
                data: "grup_id="+grup_id,
                success: function(response){
                    $("#ajaxcall").html(response);
                    $("#ajaxcall").show();
                }
            });
        });

    });
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>
<?php if($_SESSION['collepse_status'] == 'go_scroll'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('#scrollArea').offset().top
            }, 300);
            return false;
        });
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_GET['go'] == 'success'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('#scrollArea').offset().top
            }, 300);
            return false;
        });
    </script>
<?php }?>

