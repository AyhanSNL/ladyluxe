<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'price';

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
                                            <form action="post.php?process=catalog_post&status=product_post" method="post" >
                                                <input type="hidden" name="tab" value="product_price" >
                                                <input type="hidden" name="product_id" value="<?=$row['id']?>" >
                                                <div class="row">



                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="border rounded p-3 mb-3">
                                                                    <div class="in-header-page-main" >
                                                                        <div class="in-header-page-text">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1643']?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-12">
                                                                            <label for="fiyat_goster" class="w-100 d-flex align-items-center justify-content-start" >
                                                                                <?=$diller['adminpanel-form-text-1647']?>
                                                                            </label>
                                                                            <select name="fiyat_goster" class="form-control selet2" id="fiyat_goster" style="width: 100%;  " >
                                                                                <option value="0" <?php if($row['fiyat_goster'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1648']?></option>
                                                                                <option value="1" <?php if($row['fiyat_goster'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1649']?></option>
                                                                                <option value="2" <?php if($row['fiyat_goster'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1650']?></option>
                                                                                <option value="3" <?php if($row['fiyat_goster'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1651']?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-8 ">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="hidden" name="indirim" value="0" >
                                                                                <input type="checkbox" class="individual" id="indirim" name='indirim' value="1" <?php if($row['indirim'] == '1' ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                                                <label for="indirim"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1654']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div id="actionBox" class="col-md-12 mb-4" <?php if($row['indirim'] != '1'  ) { ?>style="display:none !important;"<?php }?> >
                                                                            <div class="border bg-light rounded p-3 up-arrow-2">
                                                                                <div class="row">
                                                                                    <div class="form-group col-md-8 mb-0">
                                                                                        <label for="eski_fiyat" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                            <?=$diller['adminpanel-form-text-1655']?>
                                                                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1656']?>"></i>
                                                                                        </label>
                                                                                        <div class="input-group mb-2">
                                                                                            <input type="text" class="form-control" autocomplete="off" id="eski_fiyat" value="<?=$row['eski_fiyat']?>" name="eski_fiyat" placeholder="<?=$diller['adminpanel-form-text-442']?> : 1255">
                                                                                            <div class="input-group-append">
                                                                                                <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                                            </div>
                                                                                        </div>
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
                                                                        <div class="form-group col-md-8 ">
                                                                            <label for="alis_fiyat" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                <?=$diller['adminpanel-form-text-1645']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1646']?>"></i>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <input type="text" class="form-control" id="alis_fiyat" autocomplete="off" value="<?=$row['alis_fiyat']?>" name="alis_fiyat" placeholder="<?=$diller['adminpanel-form-text-442']?> : 1255">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-8 ">
                                                                            <label for="fiyat" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                <?=$diller['adminpanel-form-text-1765']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1652']?>"></i>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <input type="text" class="form-control" id="fiyat" autocomplete="off" value="<?=$row['fiyat']?>" name="fiyat" placeholder="<?=$diller['adminpanel-form-text-442']?> : 1255">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-8 ">
                                                                            <label for="fiyat_tip2" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                <?=$diller['adminpanel-form-text-1342']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1653']?>"></i>
                                                                            </label>
                                                                            <div class="input-group mb-2">
                                                                                <input type="text" class="form-control" id="fiyat_tip2" autocomplete="off" value="<?=$row['fiyat_tip2']?>" name="fiyat_tip2" placeholder="<?=$diller['adminpanel-form-text-442']?> : 1255">
                                                                                <div class="input-group-append">
                                                                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-8 ">
                                                                            <label for="havale_indirim_tur" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                               <?=$diller['adminpanel-form-text-1659']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1657']?>"></i>

                                                                            </label>
                                                                            <select name="havale_indirim_tur" class="form-control " id="havale_indirim_tur"  >
                                                                                <option value="1" <?php if($row['havale_indirim_tur']  == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1216']?></option>
                                                                                <option value="2" <?php if($row['havale_indirim_tur']  == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1215']?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div  class="col-md-12 " >
                                                                            <div class="border bg-light rounded p-3 up-arrow-2">
                                                                                <div class="row">
                                                                                    <div class="form-group col-md-8 mb-0">
                                                                                        <label for="havale_indirim_tutar" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                            <?=$diller['adminpanel-form-text-1658']?>
                                                                                        </label>
                                                                                        <div class="input-group mb-2">
                                                                                            <input type="text" class="form-control" autocomplete="off" id="havale_indirim_tutar" value="<?=$row['havale_indirim_tutar']?>" name="havale_indirim_tutar" placeholder="<?=$diller['adminpanel-form-text-1660']?>">
                                                                                            <div class="input-group-append">
                                                                                                <div class="input-group-text font-12 font-weight-bold">
                                                                                                    <div id="oran" <?php if($row['havale_indirim_tur'] == '2' || $row['havale_indirim_tur'] == '0' ) { ?>style="display: none;" <?php }?>>
                                                                                                        <i class="fas fa-percent"></i>
                                                                                                    </div>
                                                                                                    <div id="tutar" <?php if($row['havale_indirim_tur'] != '2' ) { ?>style="display: none;" <?php }?>>
                                                                                                        <?=$Current_Money['sag_simge']?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <script>
                                                                            $('#havale_indirim_tur').on('change', function() {
                                                                                $('#oran').css('display', 'none');
                                                                                if ( $(this).val() === '1' ) {
                                                                                    $('#oran').css('display', 'block');
                                                                                }
                                                                                $('#tutar').css('display', 'none');
                                                                                if ( $(this).val() === '2' ) {
                                                                                    $('#tutar').css('display', 'block');
                                                                                }
                                                                            });
                                                                        </script>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="col-md-5">


                                                                <div class="border rounded p-3 bg-light mb-3">
                                                                    <div class="in-header-page-main" >
                                                                        <div class="in-header-page-text" style="background-color: #f8f9fa;" >
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1661']?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-12 mb-1 ">
                                                                            <label for="kdv" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                               * <?=$diller['adminpanel-form-text-1662']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1666']?>"></i>
                                                                            </label>
                                                                            <select name="kdv" class="form-control selet2" id="kdv"  required style="width: 100%;  ">
                                                                                <option value="" >-- <?=$diller['adminpanel-form-text-50']?></option>
                                                                                <option value="0" <?php if($row['kdv']  == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1663']?></option>
                                                                                <option value="1" <?php if($row['kdv']  == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1664']?></option>
                                                                                <option value="2" <?php if($row['kdv']  == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1665']?></option>
                                                                            </select>
                                                                        </div>
                                                                        <div id="kdv_oran" class="mt-2" <?php if($row['kdv'] == '0' ||  $row['kdv'] == null  ) { ?>style="display: none;" <?php }?>>
                                                                            <div class="form-group col-md-8 mb-0">
                                                                                <label for="kdv_oran2" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                    * <?=$diller['adminpanel-form-text-1667']?>
                                                                                </label>
                                                                                <div class="input-group mb-2">
                                                                                    <input type="text" class="form-control" autocomplete="off" id="kdv_oran2" value="<?=$row['kdv_oran']?>" name="kdv_oran" >
                                                                                    <div class="input-group-append">
                                                                                        <div class="input-group-text font-12 font-weight-bold">
                                                                                            <i class="fas fa-percent"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <script>
                                                                            $('#kdv').on('change', function() {
                                                                                $('#kdv_oran').css('display', 'none');
                                                                                if ( $(this).val() === '1' || $(this).val() === '2' ) {
                                                                                    $('#kdv_oran').css('display', 'block');
                                                                                }
                                                                            });
                                                                        </script>
                                                                    </div>
                                                                </div>


                                                                <?php if($odemeRow['kargo_sistemi'] == '1' ) {?>
                                                                <div class="border rounded p-3  mb-3">
                                                                    <div class="in-header-page-main" >
                                                                        <div class="in-header-page-text" style="background-color: #fff;" >
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1668']?>
                                                                        </div>
                                                                    </div>
                                                                    <?php if($odemeRow['kargo_sabit'] == '1' ) {?>
                                                                        <div class="w-100 border-warning text-dark alert-warning p-3 border mb-3 rounded">
                                                                            <?=$diller['adminpanel-form-text-1673']?>
                                                                                <?php echo number_format($odemeRow['kargo_sabit_ucret'], 2); ?>  <?=$Current_Money['sag_simge']?></strong>
                                                                        </div>
                                                                    <?php }?>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-12 mb-1 ">
                                                                            <label for="kargo" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                * <?=$diller['adminpanel-form-text-1669']?>
                                                                            </label>
                                                                            <select name="kargo" class="form-control selet2" id="kargo"  required style="width: 100%;  ">
                                                                                <option value="0" <?php if($row['kargo']  == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1670']?></option>
                                                                                <option value="1" <?php if($row['kargo']  == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1671']?></option>
                                                                            </select>
                                                                        </div>
                                                                     <?php if($odemeRow['kargo_sabit'] != '1'  ) {?>
                                                                         <div id="kargo_ucreti" class="mt-2 w-100" <?php if($row['kargo'] == '0' || $row['kargo'] == null ) { ?>style="display: none;" <?php }?>>
                                                                             <div class="form-group col-md-8 mb-3  ">
                                                                                 <label for="kargo_tipi" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                     * <?=$diller['adminpanel-form-text-1669']?>
                                                                                 </label>
                                                                                 <select name="kargo_tipi" class="form-control " id="kargo_tipi"  required style="width: 100%;  ">
                                                                                     <option value="0" <?php if($row['kargo_tipi']  == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1676']?></option>
                                                                                     <option value="1" <?php if($row['kargo_tipi']  == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1677']?></option>
                                                                                 </select>
                                                                             </div>
                                                                             <div class="form-group col-md-5 mb-0">
                                                                                 <label for="kargo_ucret" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                     * <?=$diller['adminpanel-form-text-1672']?>
                                                                                 </label>
                                                                                 <div class="input-group mb-2">
                                                                                     <input type="text" class="form-control" autocomplete="off" id="kargo_ucret" value="<?=$row['kargo_ucret']?>" name="kargo_ucret" >
                                                                                     <div class="input-group-append">
                                                                                         <div class="input-group-text font-12 font-weight-bold">
                                                                                             <?=$Current_Money['sag_simge']?>
                                                                                         </div>
                                                                                     </div>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                         <script>
                                                                             $('#kargo').on('change', function() {
                                                                                 $('#kargo_ucreti').css('display', 'none');
                                                                                 if ( $(this).val() === '1' ) {
                                                                                     $('#kargo_ucreti').css('display', 'block');
                                                                                 }
                                                                             });
                                                                         </script>
                                                                     <?php }?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-4 mt-2 ">
                                                                            <label for="kargo_desi" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                <?=$diller['adminpanel-form-text-1674']?>
                                                                            </label>
                                                                            <input type="number" name="kargo_desi" value="<?=$row['kargo_desi']?>" id="kargo_desi"  class="form-control">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="form-group col-md-12 ">
                                                                            <label for="kargo_sure" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                                <?=$diller['adminpanel-form-text-1679']?>
                                                                            </label>
                                                                            <input type="text" name="kargo_sure" autocomplete="off" value="<?=$row['kargo_sure']?>" id="kargo_sure" placeholder="<?=$diller['adminpanel-form-text-1680']?>"  class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-12 mb-0  ">
                                                                            <div class="kustom-checkbox">
                                                                                <input type="hidden" name="hizli_kargo" value="0" >
                                                                                <input type="checkbox" class="individual" id="hizli_kargo" name='hizli_kargo' value="1" <?php if($row['hizli_kargo'] == '1' ) { ?>checked<?php }?> >
                                                                                <label for="hizli_kargo"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                    <?=$diller['adminpanel-form-text-1678']?>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php }?>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button class="btn  btn-success btn-block buttonTextStyle "  name="price_shipping_update">
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


