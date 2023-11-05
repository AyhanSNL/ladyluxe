<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'orders';


if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if (isset($_GET['orderNO']) || isset($_GET['limit']) || isset($_GET['orderStatus']) || isset($_GET['orderType']) || isset($_GET['date']) || isset($_GET['date_end']) || isset($_GET['min']) || isset($_GET['max']) || isset($_GET['sort']) || isset($_GET['userID'])) {
    $filterPage = "&limit=$_GET[limit]&orderNO=$_GET[orderNO]&orderStatus=$_GET[orderStatus]&orderType=$_GET[orderType]&date=$_GET[date]&date_end=$_GET[date_end]&min=$_GET[min]&max=$_GET[max]&sort=$_GET[sort]&userID=$_GET[userID]";
}

if(isset($_GET['multidelete']) && $_GET['multidelete'] == 'delete') {
    if($_POST  ) {

    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=orders');
        exit();
    }
}


?>
<title><?=$diller['adminpanel-menu-text-17']?> - <?=$panelayar['baslik']?></title>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (isim like '%$_GET[search]%' or soyisim like '%$_GET[search]%' or telefon like '%$_GET[search]%' or eposta like '%$_GET[search]%') ";
            }else{
                $search = "where (isim like '%$_GET[search]%' or soyisim like '%$_GET[search]%' or telefon like '%$_GET[search]%' or eposta like '%$_GET[search]%') ";
            }

            if(isset($_GET['orderNO']) && $_GET['orderNO'] >'0'  ) {
                $orderNOGet = "and siparis_no='$_GET[orderNO]'";
            }else{
                $orderNOGet = null;
            }

            if(isset($_GET['orderStatus']) && $_GET['orderStatus'] >'0'  ) {
                $orderStatusGet = "and siparis_durum='$_GET[orderStatus]'";
            }else{
                $orderStatusGet = null;
            }
            if(isset($_GET['orderType']) && $_GET['orderType'] >'0'  ) {
                $orderTypeGet = "and odeme_tur='$_GET[orderType]'";
            }else{
                $orderTypeGet = null;
            }

            if(isset($_GET['date']) && $_GET['date'] >'0'  ) {
                $dateGet = "and sade_tarih >='$_GET[date]' ";
            }else{
                $dateGet = null;
            }

            if(isset($_GET['date_end']) && $_GET['date_end'] >'0'  ) {
                $dateEndGet = "and sade_tarih <='$_GET[date_end]'  ";
            }else{
                $dateEndGet = null;
            }

            if(isset($_GET['min']) && $_GET['min'] >'0'  ) {
                $minTutarGet = "and (toplam_tutar >='$_GET[min]' or havale_toplamtutar >='$_GET[min]')  ";
            }else{
                $minTutarGet = null;
            }
            if(isset($_GET['max']) && $_GET['max'] >'0'  ) {
                $maxTutarGet = "and (toplam_tutar <='$_GET[max]' or havale_toplamtutar <='$_GET[max]')  ";
            }else{
                $maxTutarGet = null;
            }


            if(isset($_GET['sort']) && $_GET['sort'] >'0'  ) {
                if($_GET['sort'] == '1' || $_GET['sort'] == '2'  || $_GET['sort'] == '3' || $_GET['sort'] == '4'  ) {
                    if($_GET['sort'] == '1'  ) {
                        $sortOrder = "siparis_tarih desc";
                    }
                    if($_GET['sort'] == '4'  ) {
                        $sortOrder = "siparis_tarih asc";
                    }
                    if($_GET['sort'] == '2'  ) {
                        $sortOrder = "toplam_tutar asc";
                    }
                    if($_GET['sort'] == '3'  ) {
                        $sortOrder = "toplam_tutar desc";
                    }
                }else{
                    $sortOrder = "id desc";
                }
            }
            if(!isset($_GET['sort'])  ) {
                $sortOrder = "id desc";
            }


            if(isset($_GET['userID']) && $_GET['userID'] >'0'  ) {
                $uyeGet = "and uye_id='$_GET[userID]'  ";
            }else{
                $uyeGet = null;
            }

            if(isset($_GET['limit']) && $_GET['limit'] >'0'  ) {
                $limitGet = $_GET['limit'];
            }else{
                $limitGet = '30';
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from siparisler $search $orderNOGet $orderStatusGet $orderTypeGet $dateGet $dateEndGet $minTutarGet $maxTutarGet $uyeGet and onay='1' ");
            $ToplamVeri = $Say->rowCount();
            $Limit = $limitGet;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from siparisler $search $orderNOGet $orderStatusGet $orderTypeGet $dateGet $dateEndGet $minTutarGet $maxTutarGet $uyeGet and onay='1' order by $sortOrder limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

            $sipD = $db->prepare("select * from siparis_durumlar where durum=:durum");
            $sipD->execute(array(
                'durum' => '1',
            ));


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/orders_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top mb-0 border-bottom pb-2 ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-17']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                        </div>

                        <!-- Fİlter !-->
                        <div class="w-100 mb-0  pt-2  d-flex align-items-center justify-content-start flex-wrap ">
                            <a class="btn btn-light  btn-block p-3 border" href="javascript:Void(0)" data-toggle="collapse" data-target="#filterAcc" aria-expanded="false" aria-controls="collapseForm" style="font-size: 15px; ">
                                <i class="fa fa-filter"></i>
                                <?=$diller['adminpanel-form-text-1292']?>
                            </a>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse <?php if (isset($_GET['search']) || isset($_GET['orderNO']) || isset($_GET['orderStatus']) || isset($_GET['orderType']) || isset($_GET['date']) || isset($_GET['date_end']) || isset($_GET['min']) || isset($_GET['max']) || isset($_GET['sort']) ) {?>show<?php } ?>" id="filterAcc" data-parent="#accordion">
                                <form method="GET" action="pages.php">
                                    <input type="hidden" name="page" value="orders" >
                                    <div class="p-3  border border-top-0" style="padding-bottom: 0!important;">
                                        <div class="row">
                                            <div class="col-md-2 form-group">
                                                <label for="limit" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1529']?>
                                                </label>
                                                <input type="text" name="limit" autocomplete="off" <?php if($_GET['limit'] >'0'  ) { ?>value="<?=$_GET['limit']?>" <?php }else{?>value="30"<?php } ?> id="limit"  class="form-control" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="search" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-154']?>
                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1437']?>"></i>
                                                </label>
                                                <input type="text" name="search" autocomplete="off" <?php if($_GET['search'] >'0'  ) { ?>value="<?=$_GET['search']?>" <?php }?> id="search"  class="form-control" >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="orderNO" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-91']?>
                                                </label>
                                                <input type="text" name="orderNO" autocomplete="off" <?php if($_GET['orderNO'] >'0'  ) { ?>value="<?=$_GET['orderNO']?>" <?php }?> id="orderNo"  class="form-control" >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="orderStatus" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1438']?>
                                                </label>
                                                <select name="orderStatus" class="form-control" id="orderStatus" >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <?php foreach ($sipD as  $d) {?>
                                                        <option value="<?=$d['id']?>" <?php if($d['id'] == $_GET['orderStatus']  ) { ?>selected<?php }?>><?=$d['baslik']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="orderType" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1434']?>
                                                </label>
                                                <select name="orderType" class="form-control" id="orderType" >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <?php if($odemeRow['kredi_kart'] == '1' ) {?>
                                                        <option value="1" <?php if($_GET['orderType'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-text-97']?></option>
                                                    <?php }?>
                                                    <?php if($odemeRow['havale_eft'] == '1' ) {?>
                                                        <option value="2" <?php if($_GET['orderType'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-text-98']?></option>
                                                    <?php }?>
                                                    <?php if($odemeRow['kapida_odeme_kart'] == '1' ) {?>
                                                        <option value="3" <?php if( $_GET['orderType'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-text-99']?></option>
                                                    <?php }?>
                                                    <?php if($odemeRow['kapida_odeme_nakit'] == '1' ) {?>
                                                        <option value="4" <?php if($_GET['orderType'] == '4'  ) { ?>selected<?php }?>><?=$diller['adminpanel-text-100']?></option>
                                                    <?php }?>
                                                    <?php if($odemeRow['ucretsiz_alisveris'] == '1' ) {?>
                                                        <option value="free" <?php if($_GET['orderType'] == 'free'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1447']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for=""><?=$diller['adminpanel-form-text-1088']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date" <?php if($_GET['date'] >'0'  ) { ?>value="<?=$_GET['date']?>" <?php }?> class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_first" autocomplete="off"  style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for=""><?=$diller['adminpanel-form-text-1089']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date_end" <?php if($_GET['date_end'] >'0'  ) { ?>value="<?=$_GET['date_end']?>" <?php }?> class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_ends" autocomplete="off"  style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label for="min" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                    <?=$diller['adminpanel-form-text-1441']?>
                                                </label>
                                                <div class="input-group mb-2">
                                                    <input type="number" class="form-control" <?php if($_GET['min'] >'0'  ) { ?>value="<?=$_GET['min']?>" <?php }?> id="min"  name="min">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text font-12 font-weight-bold"><i class="fas fa-tag"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label for="max" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                    <?=$diller['adminpanel-form-text-1442']?>
                                                </label>
                                                <div class="input-group mb-2">
                                                    <input type="number" class="form-control" id="max"  name="max" <?php if($_GET['max'] >'0'  ) { ?>value="<?=$_GET['max']?>" <?php }?>>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text font-12 font-weight-bold"><i class="fas fa-tag"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="sort" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1446']?>
                                                </label>
                                                <select name="sort" class="form-control" id="sort" >
                                                    <option value="1" <?php if( $_GET['sort'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1443']?></option>
                                                    <option value="4" <?php if( $_GET['sort'] == '4' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1449']?></option>
                                                    <option value="2" <?php if( $_GET['sort'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1444']?></option>
                                                    <option value="3" <?php if( $_GET['sort'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1445']?></option>
                                                </select>
                                            </div>

                                            <div class="col-md-12  form-group">
                                                <label for=""><?=$diller['adminpanel-form-text-1197']?></label>
                                                <select class="user_select_form form-control col-md-12" name="userID" id="uye_id" style="width: 100%!important;" >
                                                </select>

                                            </div>
                                            <div class="col-md-12 form-group">
                                                <button class="btn  m-1 btn-primary  " style="width: 150px; margin-left: 0px !important;"><?=$diller['adminpanel-form-text-1292']?></button>
                                                <?php if (isset($_GET['search']) || isset($_GET['orderNO']) || isset($_POST['orderStatus']) || isset($_POST['orderType']) || isset($_POST['date']) || isset($_POST['date_end']) || isset($_POST['min']) || isset($_POST['max']) || isset($_POST['sort']) || isset($_POST['userID'])) {?>
                                                    <a class="btn  m-1 btn-danger text-white" href="pages.php?page=orders" style="width: 150px">
                                                        <i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1114']?>
                                                    </a>
                                                <?php } ?>
                                                <a class="btn  m-1 btn-secondary text-white" style="width: 90px;" data-toggle="collapse" data-target="#filterAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!--  <========SON=========>>> Fİlter SON !-->


                        <div class="w-100 mt-3">

                            <?php if(isset($_GET['userID']) && $_GET['userID'] >'0' ) {
                                $uyeCeh = $db->prepare("select isim,soyisim from uyeler where id=:id ");
                                $uyeCeh->execute(array(
                                    'id' => $_GET['userID'],
                                ));
                                ?>
                                <?php if($uyeCeh->rowCount()>'0'  ) {
                                    $uyeRo = $uyeCeh->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <div class="w-100  bg-secondary p-3 mb-2 text-white rounded mt-2" style="font-size: 16px ;">
                                        <i class="fa fa-user"></i>  <?=$uyeRo['isim']?> <?=$uyeRo['soyisim']?> <?=$diller['adminpanel-form-text-1450']?>
                                    </div>
                                <?php }?>
                            <?php }?>


                            <form action="post.php?process=export_post&status=order_export" method="post">
                                <?php if($ToplamVeri>'0'  ) {?>
                                    <div class="d-flex align-items-center justify-content-end mb-1">
                                        <button name="exportXML"  class="btn  m-1 btn-light border" >
                                            <i class="fa fa-upload"></i> <?=$diller['adminpanel-form-text-1448']?> (XML)
                                        </button>
                                    </div>
                                <?php }?>
                                <div class="table-responsive ">
                                    <table class="table table-bordered table-hover mb-0  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th width="40" class="text-center" style="max-width: 40px !important; width: 40px !important;">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" data-id="chec" class="custom-control-input selectall"  id="hepsiniSecCheckBox"   >
                                                    <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                                </div>
                                            </th>
                                            <th><?=$diller['adminpanel-text-91']?></th>
                                            <th><?=$diller['adminpanel-form-text-1433']?></th>
                                            <th><?=$diller['adminpanel-form-text-1434']?></th>
                                            <th><?=$diller['adminpanel-text-94']?></th>
                                            <th><?=$diller['adminpanel-text-96']?></th>
                                            <th><?=$diller['adminpanel-form-text-1438']?></th>
                                            <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody  >
                                        <?php foreach ($islemCek as $row) {
                                            $faturaKontrol = $db->prepare("select * from siparis_fatura where siparis_no=:siparis_no  ");
                                            $faturaKontrol->execute(array(
                                                'siparis_no' => $row['siparis_no'],
                                            ));
                                            $fat =  $faturaKontrol->fetch(PDO::FETCH_ASSOC);

                                            $siparisDurum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                            $siparisDurum->execute(array(
                                                'id' => $row['siparis_durum'],
                                            ));
                                            $siDur = $siparisDurum->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <input type="hidden" name="export_id[]" value="<?=$row['id']?>" >
                                            <tr>
                                                <td class="text-center" width="40" class="text-center" style="max-width: 40px !important; width: 40px !important;">
                                                    <div class="custom-control custom-checkbox" >
                                                        <input type="checkbox" data-id="chec" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='item_id[]' value="<?=$row['id']?>" >
                                                        <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                    </div>
                                                </td>
                                                <td width="165" style="min-width: 165px; font-weight: 500;" >
                                                    #<?=$row['siparis_no']?>
                                                </td>
                                                <td style="min-width: 125px" >
                                                    <?php if($row['uye_id'] >'0' ) {
                                                        $uyeSorgu = $db->prepare("select isim,soyisim,id from uyeler where id=:id ");
                                                        $uyeSorgu->execute(array(
                                                            'id' => $row['uye_id']
                                                        ));
                                                        $uyee = $uyeSorgu->fetch(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <?php if($uyeSorgu->rowCount()>'0'  ) {?>
                                                            <a href="pages.php?page=user_detail&userID=<?=$uyee['id']?>" target="_blank" style="font-weight: 500;">
                                                                <i class="fa fa-user"></i> <?=$uyee['isim']?> <?=$uyee['soyisim']?>
                                                            </a>
                                                        <?php }else { ?>
                                                            <?=$row['isim']?> <?=$row['soyisim']?>
                                                        <?php }?>
                                                    <?php }else { ?>
                                                        <?=$row['isim']?> <?=$row['soyisim']?>
                                                    <?php }?>
                                                </td>
                                                <td style="min-width: 125px" >
                                                    <?php if($row['odeme_tur'] == '1' ) {?>
                                                        <?=$diller['adminpanel-text-97']?>
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
                                                        <?=$diller['adminpanel-form-text-1447']?>
                                                    <?php }?>
                                                </td>
                                                <td style="font-weight: 500;">
                                                    <?php if($row['odeme_tur'] == '2' ) {?>
                                                        <?php echo number_format($row['havale_toplamtutar'], 2); ?>
                                                        <?=$row['parabirimi']?>
                                                    <?php }else { ?>
                                                        <?php echo number_format($row['toplam_tutar'], 2); ?>
                                                        <?=$row['parabirimi']?>
                                                    <?php }?>
                                                </td>
                                                <td>
                                                    <?php echo date_tr('j F Y, H:i', ''.$row['siparis_tarih'].''); ?>
                                                </td>
                                                <td style="min-width: 140px; " width="185">
                                                    <?php if($row['iptal'] == '0' ) {?>
                                                        <div class="btn btn-sm <?=$siDur['bstrp_bg']?>  btn-block  "  >
                                                            <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                                <?=$siDur['baslik']?>
                                                            </div>
                                                        </div>
                                                    <?php }else { ?>
                                                        <div class="btn btn-sm btn-outline-danger  btn-block bg-light text-danger " style="border-width: 1px; font-weight: 500;"  >
                                                            <div class="d-flex align-items-center justify-content-center " >
                                                                <i class="fa fa-ban mr-2"></i>  <?=$diller['adminpanel-form-text-1468']?>
                                                            </div>
                                                        </div>
                                                    <?php }?>

                                                </td>
                                                <?php if($odemeRow['urun_stok_dus'] == '1' ) {?>
                                                <td class="text-center" width="230" style="min-width: 155px; ">
                                                    <?php }else { ?>
                                                <td class="text-right" width="160" style="min-width: 130px">
                                                    <?php }?>


                                                    <?php if($yetki['entegrasyon'] == '1' && $yetki['parasut'] == '1'  ) {
                                                        //todo paraşüt
                                                        //todo siparisler tablosuna parasut_id eklendi...
                                                        ?>
                                                        <?php if($row['parasut_id'] <= 0 && $row['parasut_id'] == null ) {?>
                                                            <a href="pages2.php?page=parasut_fatura_kes&orderID=<?=$row['siparis_no']?>" class="btn btn-sm btn-warning shadow " data-toggle="tooltip" data-placement="top" title="<?=$diller['parasut-text-7']?>">
                                                                <img src="assets/images/parsut.png" width="20">
                                                            </a>
                                                        <?php }else { ?>
                                                            <a href="pages2.php?page=parasut_fatura" class="btn btn-sm btn-success shadow " data-toggle="tooltip" data-placement="top" title="<?=$diller['parasut-text-11']?>">
                                                                <img src="assets/images/parsut.png" width="20">
                                                            </a>
                                                        <?php }?>
                                                    <?php }?>


                                                    <?php if($odemeRow['urun_stok_dus'] == '1' && $row['stok_alindi'] != '1' ) {?>
                                                        <a href="" data-href="post.php?process=order_post&status=stock_load&orderID=<?=$row['siparis_no']?>" class="btn btn-sm btn-light border " data-toggle="modal" data-target="#stock-load" rel="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1798']?>">
                                                            <i class="fa fa-sync" ></i>
                                                        </a>
                                                    <?php }?>



                                                    <div class="dropdown d-inline-block">
                                                        <a href="" class="btn btn-secondary  btn-sm  " type="button" style="font-size: 12px ; " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                            <i class="fas fa-print"></i>
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
                                                    <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>" class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1435']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=order_post&status=order_delete&no=<?=$row['siparis_no']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Kaydırılabilir Alert !-->
                                <div class="d-md-none d-sm-block p-2 bg-light  text-center">
                                    <?=$diller['adminpanel-text-340']?> <i class="fas fa-hand-pointer"></i>
                                </div>
                                <!--  <========SON=========>>> Kaydırılabilir Alert SON !-->
                                <?php if($ToplamVeri<='0' ) {?>
                                    <div class="border-top"> </div>
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                <?php }?>
                                <?php if($ToplamVeri > '0' && !isset($_GET['processget'])) {?>
                                <div class="w-100 pt-3 pb-3 border-bottom   " >
                                    <button id="waitButton" class="btn btn-danger btn-sm pl-4 pr-4 " disabled="disabled" name="multidelete" ><i class="fa fa-trash"></i> <?=$diller['pazaryeri-text-67']?></button>
                                </div>
                            </form>
                            <script>
                                var checkboxes = $("input[data-id='chec']"),
                                    submitButt = $("button[name='multidelete']");

                                checkboxes.click(function() {
                                    submitButt.attr("disabled", !checkboxes.is(":checked"));
                                });
                            </script>
                        <?php }?>
                            </form>
                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=orders<?=$searchPage?><?=$filterPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=orders<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=orders<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                                <?php }} ?>
                                            <?php if($Sayfa >= 1){?>
                                        </ul>
                                    </nav>
                                <?php } ?>
                                </div>
                            <?php }?>
                            <!---- Sayfalama Elementleri ================== !-->

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
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#filterAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#filterAcc').offset().top - 80 },
                500);
        });
    });
    $(document).ready(function() {
        $('.user_select_form').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-1440']?>',
            ajax: {
                url: 'masterpiece.php?page=user_select',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        q: data.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }

        });
    });
    $(document).ready(function(){
        $('[rel="tooltip"]').tooltip({trigger: "hover"});
    });
</script>
