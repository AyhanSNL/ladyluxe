<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'noti';

$bildirimAyar = $db->prepare("select * from bildirimler_ayar where id=:id ");
$bildirimAyar->execute(array(
        'id' => '1'
));
$notiSet = $bildirimAyar->fetch(PDO::FETCH_ASSOC);
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();


if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}
if (isset($_GET['userID']) && $_GET['userID'] == !null) {
    $userPage = "&userID=$_GET[userID]";
}
if (isset($_GET['show']) && $_GET['show'] == !null) {
    $showPage = "&show=$_GET[show]";
}

if (isset($_GET['userID']) && $_GET['userID'] <='0') {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=notifications');
}
if (isset($_GET['search']) && $_GET['search'] <='0') {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=notifications');
}

if (isset($_GET['show']) && $_GET['show'] <='0') {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=notifications');
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

            $statusCek = $db->prepare("select * from bildirimler where id=:id ");
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

                $guncelle = $db->prepare("UPDATE bildirimler SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
                $sonuc = $guncelle->execute(array(
                    'durum' => $statusum
                ));
                if ($sonuc) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=notifications' . $sayfa . ''.$searchPage.''.$userPage.''.$showPage.'');
                } else {
                    echo 'Veritabanı Hatası';
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=notifications');
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=notifications');
        }
    }

}else{
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=notifications');
}
}


?>

<title><?=$diller['adminpanel-menu-text-40']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=notifications"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-40']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['kampanya'] == '1' && $yetki['bildirim_gonder'] == '1' ) {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (baslik like '%$_GET[search]%' ) ";
            }else{
                $search = "where (baslik like '%$_GET[search]%' ) ";

            }

            if(isset($_GET['userID']) && $_GET['userID'] == !null  ) {
            $userFilter = 'and uye_id='.$_GET['userID'].'';
            }

            if(isset($_GET['show']) && $_GET['show'] == 'all'  ) {
                $allFilter = "and tur='0'";
            }

            if(isset($_GET['show']) && $_GET['show'] == 'users'  ) {
                $allFilter = "and tur='1'";
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from  bildirimler  $search $userFilter $allFilter ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 30 ;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from bildirimler  $search $userFilter $allFilter order by id desc  limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/campaign_leftbar.php'; ?>
                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top border-bottom pb-2 mb-0">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-40']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-primary text-white "  data-toggle="collapse" data-target="#setAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-wrench"></i> <?=$diller['adminpanel-form-text-1270']?></a>
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-836']?></a>
                            </div>
                        </div>
                        <div class=" w-100 border p-3 mb-0 mt-3 pr-4 rounded alert alert-dismissible alert-warning border-warning text-dark">
                            <div style="font-size: 14px ;">
                                <?=$diller['adminpanel-form-text-1262']?>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse  " id="setAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3 mt-3">
                                    <form action="post.php?process=noti_post&status=settings" method="post" >
                                        <div class="row">
                                            <div class="form-group col-md-12 text-center bg-white text-dark  border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-form-text-1270']?></h5>
                                            </div>
                                        </div>
                                        <div class="row mt-3 ">
                                            <div class="form-group col-md-12 mb-4">
                                                <label  for="durum_set" class="w-100" ><?=$diller['adminpanel-menu-text-40']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum_set" name="durum" value="1"  <?php if($notiSet['durum'] == '1' ) { ?>checked<?php }?> >
                                                    <label class="custom-control-label" for="durum_set"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label  for="font_select" class="w-100"> <?=$diller['adminpanel-form-text-77']?></label>
                                                <select name="font_select" class="form-control" id="font_select" >
                                                    <?php foreach ($fontlar as $font) {?>
                                                        <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $notiSet['font_select'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label  for="tu2r" class="w-100"> <?=$diller['adminpanel-form-text-1272']?></label>
                                                <select name="tur" class="form-control" id="tu2r" >
                                                    <option value="0" <?php if($notiSet['tur'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1273']?></option>
                                                    <option value="1" <?php if($notiSet['tur'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1274']?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="detay_bg"><?=$diller['adminpanel-form-text-295']?></label>
                                                <div data-color-format="default" data-color="#<?=$notiSet['detay_bg']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="detay_bg"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="in-header-page-main mt-4" >
                                            <div class="in-header-page-text">
                                                <i class="fa fa-arrow-down"></i>
                                                <?=$diller['adminpanel-text-311']?> <i class="ti-help-alt text-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1271']?>"></i>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="form-group col-md-12">
                                                <label  for="tags" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                                <input type="text" name="tags" value="<?=$detay['tags']?>" id="tags" data-role="tagsinput" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label  for="meta_desc" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                                <textarea name="meta_desc" id="meta_desc" class="form-control" rows="2" ><?=$detay['meta_desc']?></textarea>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#setAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3 mt-3">
                                    <form action="post.php?process=noti_post&status=add" method="post" >
                                        <div class="row">
                                            <div class="form-group col-md-12 text-center bg-white text-dark  border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-form-text-836']?></h5>
                                            </div>
                                        </div>
                                        <div class="row bg-light border-bottom">
                                            <div class="form-group col-auto mb-3 pt-3 ">
                                                <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                        <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                        <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row mt-3 ">
                                            <div class="form-group col-md-12 mb-4">
                                                <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-62']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  checked >
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="tur"><?=$diller['adminpanel-form-text-1244']?></label>
                                                <select name="tur" class="form-control" id="tur" >
                                                    <option value="0"><?=$diller['adminpanel-form-text-1257']?></option>
                                                    <option value="1"><?=$diller['adminpanel-form-text-1258']?></option>
                                                    <option value="2"><?=$diller['adminpanel-form-text-1259']?></option>
                                                </select>
                                            </div>
                                            <div id="special-choose" class="col-md-12 form-group" style="display:none; ">
                                                <div class="bg-light p-3 border rounded  up-arrow-2">
                                                    <label for="adet" class="w-100 d-flex align-items-center justify-content-start ">
                                                        <?=$diller['adminpanel-form-text-1256']?>
                                                    </label>
                                                    <select class="user_select_form_add form-control col-md-12" name="user_sec" id="user_sec" style="width: 100%!important;" >
                                                    </select>
                                                </div>
                                            </div>
                                            <script>
                                                $('#tur').on('change', function() {
                                                    $('#special-choose').css('display', 'none');
                                                    if ( $(this).val() === '2' ) {
                                                        $('#special-choose').css('display', 'block');
                                                    }
                                                });
                                            </script>
                                            <div class="form-group col-md-8 ">
                                                <label  for="baslik" class="w-100" >* <?=$diller['adminpanel-form-text-1180']?></label>
                                                <input type="text" name="baslik" id="baslik" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label  for="ikon" class="w-100" >
                                                    <?=$diller['adminpanel-form-text-1260']?>
                                                    <a href="https://html-css-js.com/html/character-codes/icons/" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                                                </label>
                                                <input type="text" name="ikon" id="ikon" placeholder="<?=$diller['adminpanel-form-text-1150']?> : &#127881;"  class="form-control">
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label  for="icerik" class="w-100" >
                                                    * <?=$diller['adminpanel-form-text-1261']?>
                                                </label>
                                                <textarea name="icerik" id="tiny" class="form-control" rows="3"  ></textarea>
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
                                        <a href="pages.php?page=notifications" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="notifications" >
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

                                <?php if($_GET['show']== 'all'  ) {?>
                                    <a href="pages.php?page=notifications<?=$searchPage?>" class="btn btn-primary  m-1 "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1264']?></a>
                                <?php }else { ?>
                                    <a  href="pages.php?page=notifications&show=all" class="btn btn-light m-1 border"> <i class="fa fa-eye"></i> <?=$diller['adminpanel-form-text-1264']?></a>
                                <?php }?>

                                <?php if($_GET['show']== 'users'  ) {?>
                                    <a href="pages.php?page=notifications<?=$searchPage?>" class="btn btn-primary  m-1 "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1265']?></a>
                                <?php }else { ?>
                                    <a  href="pages.php?page=notifications&show=users" class="btn btn-light m-1 border"> <i class="fa fa-users"></i> <?=$diller['adminpanel-form-text-1265']?></a>
                                <?php }?>
                                <?php
                                if (isset($_GET['userID']) && $_GET['userID'] == !null   ) {
                                    ?>
                                    <a href="pages.php?page=notifications<?=$searchPage?>" class="btn btn-primary  m-1 "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1196']?></a>
                                <?php }else { ?>
                                    <a  data-toggle="collapse" data-target="#userAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-light m-1 border"><i class="fa fa-user"></i> <?=$diller['adminpanel-form-text-1277']?></a>
                                <?php }?>
                            </div>
                        </div>
                        <div id="accordion2" class="accordion">
                         <!-- User Filter !-->
                            <div class="collapse " id="userAcc" data-parent="#accordion2">
                                <form action="pages.php" method="get">
                                    <input type="hidden" name="page" value="notifications" >
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

                        </div>

                        <div class="w-100">
                            <form method="post" action="post.php?process=noti_post&status=multidelete">
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th width="25">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                            </div>
                                        </th>
                                        <th><?=$diller['adminpanel-form-text-1180']?></th>
                                        <th><?=$diller['adminpanel-form-text-1266']?></th>
                                        <th><?=$diller['adminpanel-form-text-1267']?></th>
                                        <th><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center" width="80" style="min-width: 80px"><?=$diller['adminpanel-text-157']?></th>
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
                                            <td style="min-width: 225px; font-size: 13px ;" width="225" >
                                                <div class="d-flex align-items-start justify-content-start">
                                                   <?=$row['ikon']?>
                                                    <?=$row['baslik']?>
                                                </div>
                                            </td>
                                            <td style="min-width: 180px" width="180px">
                                                <?php if($row['tur'] == '0' ) {?>
                                                   <i class="fa fa-eye"></i> <?=$diller['adminpanel-form-text-1264']?>
                                                <?php }?>
                                                <?php if($row['tur'] == '1' ) {?>
                                                   <i class="fa fa-users"></i> <?=$diller['adminpanel-form-text-1265']?>
                                                <?php }?>
                                                <?php if($row['tur'] == '2' ) {
                                                    $uyeCek = $db->prepare("select isim,soyisim,id from uyeler where id=:id ");
                                                    $uyeCek->execute(array(
                                                            'id' => $row['uye_id']
                                                    ));
                                                    $uye = $uyeCek->fetch(PDO::FETCH_ASSOC);
                                                    $bildirimKontrol = $db->prepare("select * from bildirimler_ip where uye_id=:uye_id and bildirim_id=:bildirim_id ");
                                                    $bildirimKontrol->execute(array(
                                                            'uye_id' => $uye['id'],
                                                            'bildirim_id' => $row['bildirim_id'],
                                                    ));
                                                    
                                                    ?>
                                                    <i class="fa fa-user"></i>
                                                    <a href="pages.php?page=user_detail&userID=<?=$uye['id']?>" target="_blank">
                                                        <?=$uye['isim']?> <?=$uye['soyisim']?>
                                                    </a>
                                                    <br>
                                                    <a class=" mt-2 p-1 bg-light" style="font-size: 11px ;">
                                                        <?php if($bildirimKontrol->rowCount()<='0' ) {?>
                                                            <?=$diller['adminpanel-form-text-1269']?>
                                                        <?php }else { ?>
                                                            <i class="fa fa-check mr-1"></i> <?=$diller['adminpanel-form-text-1268']?>
                                                        <?php }?>
                                                    </a>
                                                <?php }?>
                                            </td>
                                            <td width="145" style="min-width: 145px">
                                                <?php echo date_tr('j F Y, H:i ', ''.$row['tarih'].''); ?>
                                            </td>

                                            <td width="50" >
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <a class="btn btn-sm btn-outline-danger " href="pages.php?page=notifications&status_update=<?=$row['id']?><?=$sayfa?><?=$searchPage?><?=$userPage?><?=$showPage?>">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-times mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-68']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <a class="btn btn-sm btn-success " href="pages.php?page=notifications&status_update=<?=$row['id']?><?=$sayfa?><?=$searchPage?><?=$userPage?><?=$showPage?>">
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
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <a href="" data-href="post.php?process=noti_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                <?php }?>
                            <div class="border-top"> </div>


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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=notifications<?=$userPage?><?=$showPage?><?=$searchPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=notifications<?=$userPage?><?=$showPage?><?=$searchPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=notifications<?=$userPage?><?=$showPage?><?=$searchPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=notifications<?=$userPage?><?=$showPage?><?=$searchPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=notifications<?=$userPage?><?=$showPage?><?=$searchPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=notifications<?=$userPage?><?=$showPage?><?=$searchPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=noti_edit',
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
        $('#setAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#setAcc').offset().top - 80 },
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
            placeholder: ' <?=$diller['adminpanel-form-text-1263']?>',
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
            placeholder: ' <?=$diller['adminpanel-form-text-1276']?>',
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


