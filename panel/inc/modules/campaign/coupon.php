<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'coupon';

if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}
if (isset($_GET['userID']) && $_GET['userID'] == !null) {
    $userPage = "&userID=$_GET[userID]";
}
if (isset($_GET['userID']) && $_GET['userID'] <='0') {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=coupons');
}
if (isset($_GET['search']) && $_GET['search'] <='0') {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=coupons');
}
if (isset($_GET['date']) && $_GET['date'] == !null && isset($_GET['date_end']) && $_GET['date_end'] == !null) {
    $datePage = "&date=".$_GET['date']."&date_end=".$_GET['date_end']."";
}
if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}

if(isset($_GET['status_update'])  ) {
if ($yetki['demo'] != '1') {

    if(isset($_GET['status_update'])  ) {
        if ($_GET['status_update'] == !null) {

            $statusCek = $db->prepare("select * from kupon where id=:id ");
            $statusCek->execute(array(
                'id' => $_GET['status_update']
            ));

            if ($statusCek->rowCount() > '0') {
                $st = $statusCek->fetch(PDO::FETCH_ASSOC);


                if ($st['durum'] == '1') {
                    $statusum = '0';
                }
                if ($st['durum'] == '0') {
                    $statusum = '1';
                }

                $guncelle = $db->prepare("UPDATE kupon SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
                $sonuc = $guncelle->execute(array(
                    'durum' => $statusum
                ));
                if ($sonuc) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=coupons' . $sayfa . ''.$searchPage.''.$datePage.''.$userPage.'');
                } else {
                    echo 'Veritabanı Hatası';
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=coupons');
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=coupons');
        }
    }

}else{
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=coupons');
}
}


?>

<title><?=$diller['adminpanel-menu-text-31']?> - <?=$panelayar['baslik']?></title>
<style>
    .ssa:before{
        display: none;
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-30']?></a>
                                <a href="pages.php?page=coupons"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-31']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['kampanya'] == '1' && $yetki['indirimkod'] == '1' ) {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (baslik like '%$_GET[search]%' or kod like '%$_GET[search]%' or sepe_alt_limit like '%$_GET[search]%' or indirim_tutar like '%$_GET[search]%') ";
            }else{
                $search = "where (baslik like '%$_GET[search]%' or kod like '%$_GET[search]%' or sepe_alt_limit like '%$_GET[search]%' or indirim_tutar like '%$_GET[search]%') ";

            }

            if(isset($_GET['userID']) && $_GET['userID'] == !null  ) {
            $userFilter = 'and uye_id='.$_GET['userID'].'';
            }



            if (isset($_GET['date']) && $_GET['date'] == !null && isset($_GET['date_end']) && $_GET['date_end'] == !null) {
                $date1 = $_GET['date'];
                $date2= $_GET['date_end'];
                $minDate = "and baslangic >= '$date1'";
                $maxDate = "and bitis <= '$date2'";
            }else{
                $minDate = null;
                $maxDate = null;
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from  kupon  $search $userFilter $minDate $maxDate ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 30 ;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from kupon  $search $userFilter $minDate $maxDate order by id desc  limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/campaign_leftbar.php'; ?>
                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <?php if($odemeRow['sepet_kupon'] == '0' ) {?>
                            <div class="border rounded border-danger p-3 mb-3 " style="font-size: 14px ;">
                                <div style="font-size: 18px; font-weight: 500;" class="text-danger mb-2">
                                   <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-form-text-499']?>
                                </div>
                                <?=$diller['adminpanel-form-text-1195']?>
                            </div>
                        <?php }?>
                        <div class="new-buttonu-main-top border-bottom pb-2 mb-0">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-31']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1193']?></a>
                            </div>
                        </div>

                        <div id="accordion" class="accordion">
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3 mt-3">
                                    <form action="post.php?process=coupon_post&status=add" method="post" name="order">
                                        <div class="row">
                                            <div class="form-group col-md-12 text-center bg-white text-dark  border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-form-text-1193']?></h5>
                                            </div>
                                        </div>
                                        <div class="row mt-3 ">
                                            <div class="form-group col-md-12 mb-4">
                                                <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-1210']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  checked >
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="baslik">* <?=$diller['adminpanel-form-text-1198']?></label>
                                                <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="kod">* <?=$diller['adminpanel-form-text-1212']?></label>
                                                <div class="input-group">
                                                    <input id="kod" name="kod" class="form-control"  autocomplete="off" required  type="text">
                                                    <span class="input-group-addon btn btn-primary "  style="border-radius: 0 4px 4px 0; border-left:0" onclick="randomString();"><?=$diller['adminpanel-form-text-1213']?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label  for="tur" class="w-100">* <?=$diller['adminpanel-form-text-1214']?></label>
                                                <select name="tur" class="form-control" id="tur" >
                                                    <option value="1" ><?=$diller['adminpanel-form-text-1216']?></option>
                                                    <option value="2" ><?=$diller['adminpanel-form-text-1215']?></option>
                                                </select>
                                            </div>
                                            <div id="oran-choose" class="col-md-3"  >
                                                <div class="row">
                                                    <div class="form-group col-md-12 ">
                                                        <label for="oran_oran" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                          *  <?=$diller['adminpanel-form-text-1218']?>
                                                        </label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text font-12 font-weight-bold">%</div>
                                                            </div>
                                                            <input type="text" class="form-control" id="oran_oran"   autocomplete="off" name="oran_oran">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tutar-choose" class="col-md-3" style="display: none" >
                                                <div class="row">
                                                    <div class="form-group col-md-12 ">
                                                        <label for="tutar_tutar" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                            *  <?=$diller['adminpanel-form-text-1217']?>
                                                        </label>
                                                        <div class="input-group mb-2">
                                                            <input type="text" class="form-control" id="tutar_tutar"   autocomplete="off" name="tutar_tutar">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#tur').on('change', function() {
                                                    $('#tutar-choose').css('display', 'none');
                                                    if ( $(this).val() === '2' ) {
                                                        $('#tutar-choose').css('display', 'block');
                                                    }
                                                    $('#oran-choose').css('display', 'none');
                                                    if ( $(this).val() === '1' ) {
                                                        $('#oran-choose').css('display', 'block');
                                                    }
                                                });
                                            </script>
                                            <div class="form-group col-md-3 ">
                                                <label for="sepe_alt_limit" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                   <div>
                                                       * <?=$diller['adminpanel-form-text-1201']?>
                                                   </div>
                                                    <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1219']?>"></i>
                                                </label>
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" id="sepe_alt_limit"  autocomplete="off"  name="sepe_alt_limit" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <label for="adet" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                                    * <?=$diller['adminpanel-form-text-1199']?>
                                                </label>
                                                <input type="number" name="adet"   autocomplete="off" id="adet" required  class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="adet" class="w-100 d-flex align-items-center justify-content-start ">
                                                 <?=$diller['adminpanel-form-text-1220']?>
                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1221']?>"></i>
                                                </label>
                                                <select class="user_select_form_add form-control col-md-12" name="user_sec" id="user_sec" style="width: 100%!important;" >
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for=""><?=$diller['adminpanel-form-text-1088']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="baslangic" class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_first_coupon" autocomplete="off" required style="height: 40px">
                                                        <div class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for=""><?=$diller['adminpanel-form-text-1089']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="bitis" class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_ends_coupon" autocomplete="off" required style="height: 40px">
                                                        <div class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 mt-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=coupons<?=$datePage?>" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="coupons" >
                                            <input type="text" name="search" class="form-control" placeholder="<?=$diller['adminpanel-text-154']?>"  aria-describedby="button-addon2" required autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-dark rounded-0" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Search Form SON !-->
                        <div class="w-100 mb-2  pt-2 border-top d-flex align-items-center justify-content-start flex-wrap ">
                            <div>
                                <?php
                                if (isset($_GET['date']) && $_GET['date'] == !null && isset($_GET['date_end']) && $_GET['date_end'] == !null ) {
                                    ?>
                                    <a href="pages.php?page=coupons<?=$searchPage?>" class="btn btn-primary  m-1 "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1087']?></a>
                                <?php }else { ?>
                                    <a  data-toggle="collapse" data-target="#dateAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-light m-1 border"><i class="fa fa-calendar-check"></i> <?=$diller['adminpanel-form-text-1086']?></a>
                                <?php }?>
                                <?php
                                if (isset($_GET['userID']) && $_GET['userID'] == !null   ) {
                                    ?>
                                    <a href="pages.php?page=coupons<?=$searchPage?>" class="btn btn-primary  m-1 "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1196']?></a>
                                <?php }else { ?>
                                    <a  data-toggle="collapse" data-target="#userAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-light m-1 border"><i class="fa fa-user"></i> <?=$diller['adminpanel-form-text-1197']?></a>
                                <?php }?>
                            </div>
                        </div>
                        <div id="accordion2" class="accordion">
                         <!-- User Filter !-->
                            <div class="collapse " id="userAcc" data-parent="#accordion2">
                                <form action="pages.php" method="get">
                                    <input type="hidden" name="page" value="coupons" >
                                    <div class="border  p-3  ml-1 mr-1 mb-2 rounded " style="border:3px solid #CCC !important;">
                                        <div class="row">
                                                <div class="col-md-12  form-group">
                                                    <select class="user_select_form form-control col-md-12" name="userID" id="uye_id" style="width: 100%!important;" >
                                                    </select>
                                                </div>
                                            <div class="col-md-12 text-left">
                                                <button class="btn  btn-primary "><i class="fa fa-filter"></i> <?=$diller['adminpanel-form-text-1090']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#userAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                         <!--  <========SON=========>>> User Filter SON !-->
                            <!-- Date Filter !-->
                            <div class="collapse " id="dateAcc" data-parent="#accordion2">
                                <form action="pages.php" method="get">
                                    <input type="hidden" name="page" value="coupons" >
                                    <div class="border  p-3  ml-1 mr-1 mb-2 rounded " style="border:3px solid #CCC !important;">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for=""><?=$diller['adminpanel-form-text-1088']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date" class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_first" autocomplete="off" required style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for=""><?=$diller['adminpanel-form-text-1089']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date_end" class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_ends" autocomplete="off" required style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-left">
                                                <button class="btn  btn-primary "><i class="fa fa-filter"></i> <?=$diller['adminpanel-form-text-1090']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#dateAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!--  <========SON=========>>> Date Filter SON !-->
                        </div>

                        <div class="w-100">
                            <form method="post" action="post.php?process=coupon_post&status=multidelete">
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0 table-bordered  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th width="25">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                            </div>
                                        </th>
                                        <th><?=$diller['adminpanel-form-text-1198']?></th>
                                        <th><?=$diller['adminpanel-form-text-1199']?></th>
                                        <th><?=$diller['adminpanel-form-text-1200']?></th>
                                        <th><?=$diller['adminpanel-form-text-1201']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-1202']?></th>
                                        <th><?=$diller['adminpanel-form-text-1203']?></th>
                                        <th><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center" width="145" style="min-width: 145px"><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($islemCek as $row) {?>
                                        <tr >
                                            <th>
                                                <div class="custom-control custom-checkbox" >
                                                    <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                    <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                </div>
                                            </th>
                                            <td style="min-width: 180px; font-size: 13px ;" width="180" >
                                                <div class="d-flex align-items-start justify-content-start">
                                                    <div class="bg-dark text-white p-1 rounded mr-2" style="font-size: 11px ; cursor:pointer;" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$row['kod']?>">
                                                        <?=$diller['adminpanel-form-text-1211']?>
                                                    </div>
                                                    <?=$row['baslik']?>
                                                </div>
                                            </td>
                                            <td width="50" style="font-weight: 500; font-size: 14px ;">
                                                <?=$row['adet']?>
                                            </td>
                                            <td width="115" style="min-width: 115px">
                                                <?php if($row['tur'] == '1' ) {?>
                                                    <div class="border text-center rounded bg-white">
                                                        <i class="fa fa-arrow-down text-danger" style="font-size: 11px ;"></i> %<?php echo number_format($row['indirim_tutar'], 0); ?>
                                                    </div>
                                                <?php }else { ?>
                                                    <div class="border text-center rounded bg-white">
                                                        <i class="fa fa-arrow-down text-danger" style="font-size: 11px ;"></i> <?php echo number_format($row['indirim_tutar'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td width="110" style="min-width: 110px">
                                                <?php if($row['sepe_alt_limit'] >'0' ) {?>
                                                    <div class="border text-center rounded bg-primary text-white border-primary">
                                                        <?php echo number_format($row['sepe_alt_limit'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                    </div>
                                                <?php }else { ?>
                                                <div class="border text-center rounded bg-dark text-white border-dark" style="font-size: 11px ;">
                                                    <?=$diller['adminpanel-form-text-1204']?>
                                                </div>
                                                <?php }?>
                                            </td>
                                            <td style="font-size: 12px ; min-width: 300px"  width="300">
                                                <div class="d-flex align-items-center">
                                                    <div class=" border text-center rounded bg-white  pl-2 pr-2 mr-1 pt-1 pb-1">
                                                        <i class="far fa-calendar-check"></i> <?php echo date_tr('j F Y', ''.$row['baslangic'].''); ?>
                                                    </div>
                                                    -
                                                    <div class="border text-center rounded bg-white  pl-2 pr-2 ml-1 pt-1 pb-1 ">
                                                        <i class="far fa-calendar-times"></i> <?php echo date_tr('j F Y', ''.$row['bitis'].''); ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="min-width: 180px" width="180" >
                                                <?php if($row['uye_id'] == !null  ) {
                                                    $uyecekk = $db->prepare("select isim,soyisim,id from uyeler where id=:id ");
                                                    $uyecekk->execute(array(
                                                            'id' => $row['uye_id'],
                                                    ));
                                                    $uyee = $uyecekk->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                <a class="d-flex align-items-center justify-content-start" target="_blank"  href="pages.php?page=user_detail&userID=<?=$row['uye_id']?>" >
                                                    <i class="fa fa-user mr-1"></i>
                                                    <div>
                                                        <?=$uyee['isim']?> <?=$uyee['soyisim']?>
                                                    </div>
                                                </a>
                                                <?php }else { ?>
                                                   <i class="fa fa-users"></i> <?=$diller['adminpanel-form-text-1205']?>
                                                <?php }?>
                                            </td>
                                            <td width="50" >
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <a class="btn btn-sm btn-outline-danger " href="pages.php?page=coupons&status_update=<?=$row['id']?><?=$sayfa?><?=$searchPage?><?=$userPage?><?=$datePage?>">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-times mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-68']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <a class="btn btn-sm btn-success " href="pages.php?page=coupons&status_update=<?=$row['id']?><?=$sayfa?><?=$searchPage?><?=$userPage?><?=$datePage?>">
                                                        <div class="d-flex align-items-center">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <?=$diller['adminpanel-form-text-67']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                            </td>
                                            <td class="text-right">
                                                <?php if($row['uye_id'] == !null ) {?>
                                                    <div class="dropdown d-inline-block">
                                                        <a href="" class="btn btn-dark  btn-sm mr-2 " type="button" style="font-size: 13px ; font-weight: 400;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                            <i class="fas fa-bell"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right ssa border p-1  " style="margin-top: 4px !important;">
                                                            <?php if($row['noti_durum'] != '1' ) {?>
                                                                <a class="dropdown-item" href="post.php?process=coupon_post&status=noti&userID=<?=$row['uye_id']?>&couponID=<?=$row['id']?>"   class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"><?=$diller['adminpanel-form-text-1206']?></a>
                                                            <?php }else { ?>
                                                                <div class="dropdown-item btn btn-success mb-1 text-white" href="#" style="font-size: 13px; font-weight: 400;"><i class="fa fa-check"></i> <?=$diller['adminpanel-form-text-1229']?></div>
                                                            <?php }?>
                                                            <?php if($row['eposta_durum'] != '1' ) {?>
                                                                <a id="waitButton" class="dropdown-item" href="post.php?process=coupon_post&status=email&userID=<?=$row['uye_id']?>&couponID=<?=$row['id']?>"   class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-form-text-1208']?></a>
                                                            <?php }else { ?>
                                                                <a id="waitButton" class="dropdown-item btn btn-success mb-1 text-white" href="post.php?process=coupon_post&status=email&userID=<?=$row['uye_id']?>&couponID=<?=$row['id']?>" style="font-size: 13px; font-weight: 400;"><i class="fa fa-check"></i> <?=$diller['adminpanel-form-text-1228']?></a>
                                                            <?php }?>
                                                            <?php if($row['sms_durum'] != '1' ) {?>
                                                                <a class="dropdown-item mb-0" href="post.php?process=coupon_post&status=sms&userID=<?=$row['uye_id']?>&couponID=<?=$row['id']?>"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-form-text-1209']?></a>
                                                            <?php }else { ?>
                                                                <a class="dropdown-item btn btn-success mb-0 text-white" href="post.php?process=coupon_post&status=sms&userID=<?=$row['uye_id']?>&couponID=<?=$row['id']?>"  style="font-size: 13px; font-weight: 400;"><i class="fa fa-check"></i> <?=$diller['adminpanel-form-text-1227']?></a>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax mr-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <a href="" data-href="post.php?process=coupon_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                    <div class="border-top"> </div>
                                <?php }?>


                                <?php if($ToplamVeri > '0') {?>
                                    <div class="w-100 pt-3 pb-3 border-bottom border-top  " >
                                        <button class="btn btn-danger btn-sm rounded-0 shadow-lg pl-4 pr-4 " type="submit" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                                    </div>
                                    </form>
                                <?php }?>





                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=coupons<?=$datePage?><?=$userPage?><?=$searchPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=coupons<?=$datePage?><?=$userPage?><?=$searchPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=coupons<?=$datePage?><?=$userPage?><?=$searchPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=coupons<?=$datePage?><?=$userPage?><?=$searchPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=coupons<?=$datePage?><?=$userPage?><?=$searchPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=coupons<?=$datePage?><?=$userPage?><?=$searchPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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


<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=coupon_edit',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
</script>
<!--  <========SON=========>>> Editable Modal SON !-->

<script>
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#dateAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#dateAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#userAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#userAcc').offset().top - 80 },
                500);
        });
    });
</script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.user_select_form').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-1194']?>',
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
</script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.user_select_form_add').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-1221']?>',
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

</script>
<script type="text/javascript">
    function randomString() {
        var chars = "0123456789ABC234567DEFGHIJKLMNOPQRSTUVWXTZ";
        var string_length = 8;
        var randomstring = '';
        for (var i = 0; i < string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum, rnum + 1);
        }
        document.order.kod.value = randomstring;
    }

    function randomString2() {
        var chars = "0123456789ABC234567DEFGHIJKLMNOPQRSTUVWXTZ";
        var string_length = 8;
        var randomstring = '';
        for (var i = 0; i < string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum, rnum + 1);
        }
        document.order2.kod2.value = randomstring;
    }
</script>


