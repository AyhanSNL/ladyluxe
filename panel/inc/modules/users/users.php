<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'users';

$userGr = $db->prepare("select * from uyeler_grup ");
$userGr->execute();
$grp = $db->prepare("select * from uyeler_grup ");
$grp->execute();
$userAyar = $db->prepare("select * from uyeler_ayar ");
$userAyar->execute();
$userset = $userAyar->fetch(PDO::FETCH_ASSOC);


if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}

if(isset($_GET['search'])  ) {
    if(strip_tags(htmlspecialchars($_GET['search'])) <= '0'  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=users');
        exit();
    }
}



if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if (isset($_GET['usertype']) || isset($_GET['group']) || isset($_GET['email']) || isset($_GET['phone']) ) {
    $filterPage = "&usertype=$_GET[usertype]&group=$_GET[group]&email=$_GET[email]&phone=$_GET[phone]";
}


if(isset($_GET['status_update'])  ) {
    if ($yetki['demo'] != '1') {
        if($_GET['status_update'] == !null  ) {

            $statusCek = $db->prepare("select * from uyeler where id=:id ");
            $statusCek->execute(array(
                'id' => $_GET['status_update']
            ));

            if($statusCek->rowCount()>'0'  ) {
                $st = $statusCek->fetch(PDO::FETCH_ASSOC);



                if($st['onay'] == '1' ) {
                    $statusum = '0';
                }
                if($st['onay'] == '0' ) {
                    $statusum = '1';
                }

                $guncelle = $db->prepare("UPDATE uyeler SET
                 onay=:onay
          WHERE id={$_GET['status_update']}      
         ");
                $sonuc = $guncelle->execute(array(
                    'onay' => $statusum
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=users'.$sayfa.''.$searchPage.''.$filterPage.'');
                }else{
                    echo 'Veritabanı Hatası';
                }

            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=users');
            }

        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=users');
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=users');

    }
}


?>
<title><?=$diller['adminpanel-menu-text-26']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-25']?></a>
                                <a href="pages.php?page=users"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-26']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['uyelik'] == '1' && $yetki['uye_yonet'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (isim like '%$_GET[search]%' or soyisim like '%$_GET[search]%' or telefon like '%$_GET[search]%' or eposta like '%$_GET[search]%') ";
            }else{
                $search = "where (isim like '%$_GET[search]%' or soyisim like '%$_GET[search]%' or telefon like '%$_GET[search]%' or eposta like '%$_GET[search]%') ";
            }

            if($_GET['usertype'] == !null  ) {
                $userType = htmlspecialchars(addslashes(strip_tags($_GET['usertype'])));
             $tipSql = "and uye_tip='$userType'";
            }
            if($_GET['group'] == !null  ) {
                $GroupT = htmlspecialchars(addslashes(strip_tags($_GET['group'])));
                $grupSql = "and uye_grup='$GroupT'";
            }
            if($_GET['email'] == !null  ) {
                $mailKont = htmlspecialchars(addslashes(strip_tags($_GET['email'])));
                $maiLSql = "and eposta='$mailKont'";
            }
            if($_GET['phone'] == !null  ) {
                $pone = htmlspecialchars(addslashes(strip_tags($_GET['phone'])));
                $phnSql = "and telefon='$pone'";
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from uyeler $search $tipSql $grupSql $maiLSql $phnSql ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 30;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from uyeler $search $tipSql $grupSql $maiLSql $phnSql order by id desc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/users_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top mb-0 border-bottom pb-2 ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-26']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-primary text-white "  href="pages.php?page=users_settings"><i class="fa fa-wrench"></i> <?=$diller['adminpanel-menu-text-29']?></a>
                                <a  class="btn btn-secondary text-white "  href="pages.php?page=users_group"><i class="fa fa-users"></i> <?=$diller['adminpanel-menu-text-27']?></a>
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1278']?></a>
                            </div>
                        </div>

                        <div id="accordion" class="accordion">
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border border-top-0 pl-3 pr-3 pt-3 mb-0">
                                    <form action="post.php?process=users_post&status=user_add" method="post" enctype="multipart/form-data">
                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-white text-dark mt-n3 mb-3 border-bottom">
                                                <h5> <?=$diller['adminpanel-form-text-1278']?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12  mb-0">
                                                <div class=" w-100 border p-3  rounded alert alert-dismissible alert-warning border-warning text-dark">
                                                   <div style="font-size: 16px ; margin-bottom: 5px; font-weight: 600;">
                                                       <?=$diller['adminpanel-form-text-821']?>
                                                   </div>
                                                    <div style="font-size: 14px ;">
                                                        <?=$diller['adminpanel-form-text-1293']?>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php if($userset['basit_form'] == '0' ) {?>
                                                <div class="form-group col-md-6">
                                                    <label for="tip"><?=$diller['adminpanel-form-text-1294']?></label>
                                                    <select name="tip" class="form-control" id="tip" required>
                                                        <option value="1"><?=$diller['adminpanel-form-text-1289']?></option>
                                                        <option value="2"><?=$diller['adminpanel-form-text-1288']?></option>
                                                    </select>
                                                </div>
                                            <?php }?>
                                            <div class="form-group col-md-6">
                                                <label for="uye_grup"><?=$diller['adminpanel-form-text-1290']?></label>
                                                <select name="uye_grup" class="form-control" id="uye_grup" >
                                                    <option value="0"><?=$diller['adminpanel-form-text-1297']?></option>
                                                    <?php foreach ($grp as $gr) {?>
                                                        <option value="<?=$gr['id']?>"><?=$gr['baslik']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="isim"><?=$diller['adminpanel-form-text-47']?></label>
                                                <input type="text" name="isim"  autocomplete="off" id="isim" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="soyisim"><?=$diller['adminpanel-form-text-48']?></label>
                                                <input type="text" name="soyisim" autocomplete="off"  id="soyisim" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="eposta" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1107']?>
                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1295']?>"></i>
                                                </label>
                                                <input type="email" autocomplete="off"  name="eposta"  id="eposta" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="sifre"><?=$diller['adminpanel-form-text-1296']?></label>
                                                <input type="password" name="sifre"  id="sifre" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12 mb-0">
                                                <?php if($ayar['smtp_durum'] == '1' ) {?>
                                                    <div class="kustom-checkbox">
                                                        <input type="hidden" name="bildirim" value="0"">
                                                        <input type="checkbox" class="individual" id="bildirim" name='bildirim' value="1" onclick="actionBox(this.checked);">
                                                        <label for="bildirim"><u><?=$diller['adminpanel-form-text-1298']?></u></label>
                                                    </div>
                                                <?php }else { ?>
                                                    <div class="kustom-checkbox">
                                                        <input type="hidden" name="bildirim" value="0"">
                                                        <input type="checkbox" class="individual"  disabled >
                                                        <label for="bildirim"><del><?=$diller['adminpanel-form-text-1298']?></del> <span class="text-danger" style="font-style: italic">(<?=$diller['adminpanel-form-text-1300']?>)</span></label>
                                                    </div>
                                                <?php }?>
                                            </div>
                                            <div id="actionBox" class="w-100 col-md-12 mb-0  " style="display:none !important;" >
                                                <div class="row">
                                                    <div class="form-group col-md-12 mb-0">
                                                        <div class="kustom-checkbox">
                                                            <input type="hidden" name="bildirim_bilgiler" value="0"">
                                                            <input type="checkbox" class="individual" id="bildirim_bilgiler" name='bildirim_bilgiler' value="1" >
                                                            <label for="bildirim_bilgiler" ><u><?=$diller['adminpanel-form-text-1299']?></u></label>
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
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 mt-3 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=users" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="users" >
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

                        <!-- Fİlter !-->
                        <div class="w-100 mb-0  pt-2  d-flex align-items-center justify-content-start flex-wrap ">
                            <a class="btn btn-light  btn-block p-3 border" href="javascript:Void(0)" data-toggle="collapse" data-target="#filterAcc" aria-expanded="false" aria-controls="collapseForm" style="font-size: 15px; ">
                                <i class="fa fa-filter"></i>
                                <?=$diller['adminpanel-form-text-1292']?>
                            </a>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse  <?php if(isset($_GET['usertype']) || isset($_GET['group']) || isset($_GET['email']) || isset($_GET['phone'])) {?>show<?php } ?>" id="filterAcc" data-parent="#accordion">
                                <form method="GET" action="pages.php">
                                    <input type="hidden" name="page" value="users" >
                                    <div class="p-3  border border-top-0" style="padding-bottom: 0!important;">
                                        <div class="row">
                                            <?php if($userset['basit_form'] =='0' ) {?>
                                                <div class="col-md-3 form-group">
                                                    <select name="usertype" class="form-control"  required>
                                                        <option value="1" <?php if($_GET['usertype']=='1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1289']?></option>
                                                        <option value="2" <?php if($_GET['usertype']=='2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1288']?></option>
                                                    </select>
                                                </div>
                                            <?php }?>
                                            <div class=" <?php if($userset['basit_form'] == '1'   ) { ?>col-md-4<?php }else{?>col-md-3<?php } ?> form-group">
                                                <select name="group" class="form-control" id="type" >
                                                    <option value=""><?=$diller['adminpanel-form-text-1305']?></option>
                                                    <?php foreach ($userGr as $gr) {?>
                                                        <option value="<?=$gr['id']?>" <?php if($_GET['group']== $gr['id']  ) { ?>selected<?php }?>><?=$gr['baslik']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="<?php if($userset['basit_form'] == '1'   ) { ?>col-md-4<?php }else{?>col-md-3<?php } ?>  form-group">
                                                <input type="email" name="email" autocomplete="off" <?php if($_GET['email']==!null  ) { ?>value="<?=$_GET['email']?>" <?php }?> class="form-control" placeholder="<?=$diller['adminpanel-form-text-83']?>">
                                            </div>
                                            <div class="<?php if($userset['basit_form'] == '1'   ) { ?>col-md-4<?php }else{?>col-md-3<?php } ?>  form-group">
                                                <input type="number" name="phone" autocomplete="off"  <?php if($_GET['phone']==!null  ) { ?>value="<?=$_GET['phone']?>" <?php }?> class="form-control" placeholder="<?=$diller['adminpanel-form-text-81']?>">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <button class="btn  m-1 btn-primary  " style="width: 150px; margin-left: 0px !important;"><?=$diller['adminpanel-form-text-1292']?></button>
                                                <?php if(!isset($_GET['usertype']) || !isset($_GET['group']) || !isset($_GET['email']) || !isset($_GET['phone'])) {?>
                                                    <a class="btn  m-1 btn-secondary text-white" style="width: 90px;" data-toggle="collapse" data-target="#filterAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                                <?php } ?>
                                                <?php if(isset($_GET['usertype']) || isset($_GET['group']) || isset($_GET['email']) || isset($_GET['phone'])) {?>
                                                        <a class="btn btn-pink m-1  " href="pages.php?page=users" style="margin-left: 0px !important;">
                                                            <i class="fa fa-times"></i>
                                                            <?=$diller['adminpanel-form-text-1114']?>
                                                        </a>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!--  <========SON=========>>> Fİlter SON !-->


                        <div class="w-100 mt-3">
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0 table-bordered  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <?php if($userset['basit_form'] == '0'  ) {?>
                                        <th><?=$diller['adminpanel-form-text-1294']?></th>
                                        <?php } ?>
                                        <th><?=$diller['adminpanel-text-92']?></th>
                                        <th>
                                            <?=$diller['adminpanel-form-text-1290']?>
                                        </th>
                                        <th><?=$diller['adminpanel-form-text-83']?></th>
                                        <th><?=$diller['adminpanel-form-text-81']?></th>
                                        <th><?=$diller['adminpanel-form-text-1301']?></th>
                                        <th><?=$diller['adminpanel-form-text-1302']?></th>
                                        <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {?>
                                        <tr>
                                            <?php if($userset['basit_form'] == '0'  ) {?>
                                                <td width="100">
                                                    <?php if($row['uye_tip'] =='1' ) {?>
                                                        <div class="mb-2 badge badge-danger" style="font-weight: 100; font-size: 11px ;">
                                                            <?=$diller['adminpanel-form-text-1289']?>
                                                        </div>
                                                    <?php }?>
                                                    <?php if($row['uye_tip'] =='2' ) {?>
                                                        <div class="mb-2 badge  badge-dark" style="font-weight: 100; font-size: 11px ;">
                                                            <?=$diller['adminpanel-form-text-1288']?>
                                                        </div>
                                                    <?php }?>
                                                </td>
                                            <?php }?>
                                            <td width="165" style="min-width: 165px" >
                                                <i class="ion ion-md-person"></i> <?=$row['isim']?> <?=$row['soyisim']?>
                                            </td>
                                            <td style="min-width: 125px" >
                                               <?php
                                               $grupC = $db->prepare("select * from uyeler_grup where id=:id ");
                                               $grupC->execute(array(
                                                       'id' => $row['uye_grup']
                                               ));
                                               $gRow = $grupC->fetch(PDO::FETCH_ASSOC);
                                               ?>
                                                <?php if($grupC->rowCount()>'0'  ) {?>
                                                <div class="btn btn-sm btn-dark">
                                                    <?=$gRow['baslik']?>
                                                </div>
                                                <?php }else { ?>
                                                <?=$diller['adminpanel-form-text-1306']?>
                                                <?php }?>
                                            </td>
                                            <td style="min-width: 125px" >
                                              <i class="mdi mdi-email-outline"></i>  <?=$row['eposta']?>
                                            </td>
                                            <td >
                                                <div style="font-size: 12px ; min-width: 100px">
                                                    <?php if($row['telefon'] == !null ) {?>
                                                       <i class="mdi mdi-phone-in-talk"></i> <?=$row['telefon']?>
                                                    <?php }else { ?>
                                                    -
                                                    <?php }?>
                                                </div>
                                            </td>
                                            <td >
                                                <div style="font-size: 11px ; min-width: 110px">
                                                   <?php if($row['son_giris'] == !null ) {?>
                                                  <i class="mdi mdi-key"></i>  <?php echo date_tr('j F Y, H:i', ''.$row['son_giris'].''); ?>
                                                   <?php }else { ?>
                                                    -
                                                   <?php }?>
                                                </div>
                                            </td>
                                            <td style="min-width: 140px" width="140">
                                                <?php if($row['onay'] == '0' ) {?>
                                                    <a class="btn btn-sm btn-secondary " href="pages.php?page=users&status_update=<?=$row['id']?><?=$sayfa?><?=$searchPage?><?=$filterPage?>">
                                                        <div class="d-flex align-items-center">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <?=$diller['adminpanel-form-text-1304']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                                <?php if($row['onay'] == '1' ) {?>
                                                    <a class="btn btn-sm btn-success " href="pages.php?page=users&status_update=<?=$row['id']?><?=$sayfa?><?=$searchPage?><?=$filterPage?>">
                                                        <div class="d-flex align-items-center">
                                                         <i class="fa fa-check mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-1303']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                            </td>
                                            <td class="text-right" style="min-width: 90px">
                                                <?php if($row['onay'] == '1' && $userset['oto_onay'] == '0' ) {?>
                                                    <?php if($row['sms_durum'] == null || $row['eposta_durum'] == null) {?>
                                                        <div class="dropdown d-inline-block">
                                                            <a href="" class="btn btn-dark  btn-sm mr-2 " type="button" style="font-size: 13px ; font-weight: 400;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                                <i class="fas fa-bell"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right ssa border p-1  " style="margin-top: 4px !important;">
                                                                <div class="p-2  mb-1 bg-primary text-center text-white rounded" style="font-size: 11px ;">
                                                                    <?=$diller['adminpanel-form-text-1432']?>
                                                                </div>
                                                                <?php if($row['eposta_durum'] != '1' && $row['eposta_durum'] != '2' ) {?>
                                                                    <a id="waitButton" class="dropdown-item" href="post.php?process=users_post&status=noti_email&userID=<?=$row['id']?>"   class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;">
                                                                        <?=$diller['adminpanel-form-text-1208']?>
                                                                    </a>
                                                                <?php }?>
                                                                <?php if($row['eposta_durum'] == '1' ) {?>
                                                                    <a class="btn btn-success mb-1 text-white" style="font-size: 13px; font-weight: 400;">
                                                                       <i class="fa fa-check"></i> <?=$diller['adminpanel-form-text-1208']?>
                                                                    </a>
                                                                <?php }?>
                                                                <?php if($row['sms_durum'] != '1' && $row['sms_durum'] != '2' ) {?>
                                                                    <a class="dropdown-item mb-0" href="post.php?process=users_post&status=noti_sms&userID=<?=$row['id']?>"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;">
                                                                        <?=$diller['adminpanel-form-text-1209']?>
                                                                    </a>
                                                                <?php }?>
                                                                <?php if($row['sms_durum'] == '1' ) {?>
                                                                    <a class="btn btn-success mb-1" style="font-size: 13px; font-weight: 400;">
                                                                        <i class="fa fa-check"></i> <?=$diller['adminpanel-form-text-1209']?>
                                                                    </a>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                    <?php }?>
                                                <?php }?>
                                                <a href="pages.php?page=user_detail&userID=<?=$row['id']?>" class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <a href="" data-href="post.php?process=users_post&status=user_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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

                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=users<?=$searchPage?><?=$filterPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=users<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=users<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=users<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=users<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=users<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
</script>