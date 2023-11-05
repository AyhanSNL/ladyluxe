<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'extra';

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

$katalog = $db->prepare("select * from katalog where dil=:dil order by id desc");
$katalog->execute(array(
        'dil' => $_SESSION['dil'],
));

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
                                                <input type="hidden" name="tab" value="extra" >
                                                <input type="hidden" name="product_id" value="<?=$row['id']?>" >
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="row">


                                                            <div class="col-md-6">
                                                                <div class="border p-3 rounded mb-3">
                                                                    <div class="in-header-page-main">
                                                                        <div class="in-header-page-text">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1684']?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <input type="text" name="embed" value="<?=$row['embed']?>" id="embed" autocomplete="off" placeholder="<?=$diller['adminpanel-form-text-1150']?> : XULUBZcAU" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="border p-3 rounded mb-3">
                                                                    <div class="in-header-page-main">
                                                                        <div class="in-header-page-text">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1686']?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <select name="katalog" class="form-control selet2" id="katalog">
                                                                                <option value=""><?=$diller['adminpanel-form-text-1222']?></option>
                                                                                <?php foreach ($katalog as $kata) {?>
                                                                                    <option value="<?=$kata['id']?>" <?php if($kata['id'] == $row['katalog'] ) { ?>selected<?php }?>><?=$kata['baslik']?></option>
                                                                                <?php }?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="border p-3 rounded mb-3">
                                                                    <div class="in-header-page-main">
                                                                        <div class="in-header-page-text">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                            <?=$diller['adminpanel-form-text-1688']?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6 form-group">
                                                                            <label for="ek_tabs_baslik"><?=$diller['adminpanel-form-text-1479']?></label>
                                                                            <input type="text" autocomplete="off" name="ek_tabs_baslik" value="<?=$row['ek_tabs_baslik']?>" id="ek_tabs_baslik" class="form-control">
                                                                        </div>
                                                                        <div class="col-md-12 form-group">
                                                                            <label for="ek_tabs"><?=$diller['adminpanel-form-text-1691']?></label>
                                                                            <textarea name="ek_tabs" id="tiny" class="form-control" rows="3" ><?=$row['ek_tabs']?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button class="btn  btn-success btn-block buttonTextStyle "  name="extra_update">
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


