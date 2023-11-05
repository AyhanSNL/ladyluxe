<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'ptable';

$parentSQL = $db->prepare("select * from pricing_kat where id='$_GET[parent]' and dil='$_SESSION[dil]' ");
$parentSQL->execute();

if($parentSQL->rowCount()<='0'  ) {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=pricing_table');
    die();
}else{
    $kat = $parentSQL->fetch(PDO::FETCH_ASSOC);
}


if($_POST) {
if ($yetki['demo'] != '1') {
    $position = $_POST['position'];
    $count = 1;
    foreach ($position as $idler) {
        $idler2 = htmlspecialchars(trim($idler));
        try {

            $query = $db->query("UPDATE pricing SET sira = '$count' WHERE id = '$idler2'");
        } catch (PDOException $ex) {
            echo "Hata İşlem Yapılamadı!";
            some_logging_function($ex->getMessage());
        }
        $count++;
    }
}
}
if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}
if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if(isset($_GET['status_update'])  ) {
if ($yetki['demo'] != '1') {
    if ($_GET['status_update'] == !null) {

        $statusCek = $db->prepare("select * from pricing where id=:id ");
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

            $guncelle = $db->prepare("UPDATE pricing SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
            $sonuc = $guncelle->execute(array(
                'durum' => $statusum
            ));
            if ($sonuc) {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=pricing_table_list&parent='.$_GET['parent'].'' . $searchPage . ''.$sayfa.'');
            } else {
                echo 'Veritabanı Hatası';
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=pricing_table_list&parent='.$_GET['parent'].'');
        }

    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=pricing_table_list&parent='.$_GET['parent'].'');
    }
}else{
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=pricing_table_list&parent='.$_GET['parent'].'');
}
}


?>
<title><?=$kat['baslik']?> - <?=$diller['adminpanel-menu-text-51']?> - <?=$panelayar['baslik']?></title>
<style>
    .nav-link{
        color: #000;
        transition-duration: 0.1s; transition-timing-function: linear;
        font-weight: 500;
        font-size: 14px;
        padding: 15px 25px;

    }
    .nav-tabs li:first-child{
        margin-left: 10px;
    }
    .saas:hover{
        background-color: #fff;
        color: #000;
    }
    @media (max-width: 768px) {
        .nav-link{
            color: #000;
            transition-duration: 0.1s; transition-timing-function: linear;
            font-weight: 500;
            font-size: 14px;
            padding: 10px;
        }
        .nav-tabs{
            padding: 15px;
        }
        .nav-tabs li:first-child{
            margin-left: 0;
        }
        .nav-link.active{
            border-color: #dee2e6 #dee2e6 #dee2e6 !important;
            border-radius: 6px !important;
        }
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-41']?></a>
                                <a href="pages.php?page=pricing_table"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-51']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$kat['baslik']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['ptable'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "( baslik like '%$_GET[search]%' or  fiyat like '%$_GET[search]%' or  baslik_kat like '%$_GET[search]%' or  odeme_sure like '%$_GET[search]%') and ";
            }else{
                $search = null;
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from pricing where $search dil='$_SESSION[dil]' and kat_id='$_GET[parent]'  ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 25;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from pricing where $search dil='$_SESSION[dil]' and kat_id='$_GET[parent]'  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                    <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top border-bottom pb-2 mb-0">
                            <div class="w-100">
                                <a href="pages.php?page=pricing_table" class="btn btn-outline-dark btn-sm mb-2 d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                            </div>
                            <div class="new-buttonu-main-left">
                                <h6> <?=$diller['adminpanel-menu-text-51']?> <i class="fa fa-caret-right"></i></h6>
                                <h4><?=$kat['baslik']?> (<?=$ToplamVeri?>)</h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1037']?></a>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <form action="post.php?process=ptable_post&status=table_add" method="post" class="border border-top-0 mb-5 ">
                                    <input type="hidden" name="parent_id" value="<?=$_GET['parent']?>">
                                    <div class="text-center bg-white text-dark border-bottom ">
                                        <h5 style="margin-top: 0; padding-top: 10px;"> <?=$diller['adminpanel-form-text-1037']?></h5>
                                    </div>
                                    <!-- Tab Alanı !-->
                                    <ul class="nav nav-tabs bg-light pt-2" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link saas active" id="one-tab" data-toggle="tab" href="#one" role="tab"  aria-selected="true">
                                                <?=$diller['adminpanel-form-text-1044']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" id="two-tab" data-toggle="tab" href="#two" role="tab"  aria-selected="true">
                                                <?=$diller['adminpanel-form-text-1046']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" id="three-tab" data-toggle="tab" href="#three" role="tab"  aria-selected="true">
                                                <?=$diller['adminpanel-form-text-1045']?>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content bg-white rounded-bottom">
                                        <div class="tab-pane active p-4" id="one" role="tabpanel" >
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="durum" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  checked >
                                                        <label class="custom-control-label" for="durum"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                                    <input type="number" autocomplete="off"  name="sira" id="sira" required  class="form-control">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label for="baslik_kat"><?=$diller['adminpanel-form-text-1047']?></label>
                                                    <input type="text" autocomplete="off"  name="baslik_kat" id="baslik_kat"  placeholder="<?=$diller['adminpanel-form-text-1050']?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-8">
                                                    <label for="baslik">* <?=$diller['adminpanel-form-text-1048']?></label>
                                                    <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="fiyat"><?=$diller['adminpanel-form-text-1040']?></label>
                                                    <input type="number" autocomplete="off"  name="fiyat" id="fiyat" placeholder="ÖRN : 100.00"  class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="odeme_sure"><?=$diller['adminpanel-form-text-1041']?></label>
                                                    <input type="text" autocomplete="off"  name="odeme_sure" id="odeme_sure" placeholder="<?=$diller['adminpanel-form-text-1051']?>"  class="form-control">
                                                </div>
                                                <div class="form-group col-md-12 ">
                                                    <label  for="tavsiye" class="w-100"><?=$diller['adminpanel-form-text-1052']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="tavsiye" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="tavsiye" name="tavsiye" value="1" onclick="actionBox(this.checked);">
                                                        <label class="custom-control-label" for="tavsiye"></label>
                                                    </div>
                                                </div>
                                                <div id="actionBox" class="w-100 col-md-12 mt-2 " style="display:none !important;" >
                                                   <div class="col-md-12 border p-3 pt-4 rounded mb-0 bg-light up-arrow">
                                                       <div class="row">
                                                           <div class="form-group col-md-6">
                                                               <label for="tavsiye_renk"><?=$diller['adminpanel-form-text-1053']?></label>
                                                               <div data-color-format="default" data-color="#ff0000" class="colorpicker-default input-group">
                                                                   <input type="text" name="tavsiye_renk"  value="" class="form-control">
                                                                   <div class="input-group-append add-on">
                                                                       <button class="btn btn-light border" type="button">
                                                                           <i style="background-color: rgb(124, 66, 84);"></i>
                                                                       </button>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                           <div class="form-group col-md-6">
                                                               <label for="tavsiye_yazi_renk"><?=$diller['adminpanel-form-text-1054']?></label>
                                                               <div data-color-format="default" data-color="#FFFFFF" class="colorpicker-default input-group">
                                                                   <input type="text" name="tavsiye_yazi_renk"  value="" class="form-control">
                                                                   <div class="input-group-append add-on">
                                                                       <button class="btn btn-light border" type="button">
                                                                           <i style="background-color: rgb(124, 66, 84);"></i>
                                                                       </button>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade p-4" id="two" role="tabpanel" >
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-3">
                                                        <label for="url_tur"><?=$diller['adminpanel-form-text-1055']?></label>
                                                        <select name="url_tur" class="form-control rounded-0" id="url_tur"  style="height: 55px; font-size: 16px ;">
                                                        <option value="0"><?=$diller['adminpanel-form-text-1056']?></option>
                                                        <option value="1"><?=$diller['adminpanel-form-text-1057']?></option>
                                                        <option value="2"><?=$diller['adminpanel-form-text-1058']?></option>
                                                    </select>
                                                </div>
                                                <div id="modul-choise" class="col-md-12 " style="display: none;"   >
                                                    <div class="w-100 p-3 border bg-light up-arrow-2  ">
                                                        <div class="">
                                                            <div class="col-md-12 mb-0 form-group">
                                                                <div class="border-warning alert-warning p-2 mb-3 text-dark rounded border">
                                                                    <?=$diller['adminpanel-form-text-1075']?>
                                                                </div>
                                                                <label for="urun_id"><?=$diller['adminpanel-form-text-1060']?></label>
                                                                <select class="urunler_select form-control col-md-12" name="urun_id" id="urun_id" style="width: 100%!important;" >
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="manuel-choise" class="col-md-12 " style="display: none;"   >
                                                    <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                                        <div class="">
                                                            <div class="form-group col-md-12 ">
                                                                <input type="text" name="url_adres" placeholder="https://"  autocomplete="off" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-12 mb-0">
                                                                <label for="url_yazi"><?=$diller['adminpanel-form-text-911']?></label>
                                                                <input type="text" name="url_yazi" id="url_yazi" placeholder="<?=$diller['adminpanel-form-text-1059']?>"  class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 mt-4">
                                                    <label for="url_button"><?=$diller['adminpanel-form-text-863']?></label>
                                                    <select name="url_button" class="form-control select_ajax2" id="url_button"style="width: 100%;  " >
                                                        <option value="button-black-white" ><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" ><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" ><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" ><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" ><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" ><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" ><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" ><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" ><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" ><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red"><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" ><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" ><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out"><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow"><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out"><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green"><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out"><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" ><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" ><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange"><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out"><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" ><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane fade p-4" id="three" role="tabpanel" >
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="kutu_arkaplan"><?=$diller['adminpanel-form-text-1061']?></label>
                                                    <div data-color-format="default" data-color="#FFFFFF" class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_arkaplan"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="kutu_baslik_renk"><?=$diller['adminpanel-form-text-1062']?></label>
                                                    <div data-color-format="default" data-color="#000000" class="colorpicker-default input-group">
                                                        <input type="text" name="kutu_baslik_renk"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  <========SON=========>>> Tab Alanı SON !-->
                                    <div class=" border-top pt-3 bg-light pb-3">
                                        <div class="col-md-12 text-right">
                                            <button class="btn  btn-success " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                            <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 mt-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?>" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="pricing_table_list" >
                                            <input type="hidden" name="parent" value="<?=$_GET['parent']?>" >
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
                        <div class="w-100">
                            <div class="w-100 p-2 bg-light mb-2 font-12">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-text-171']?>
                            </div>
                            <div class="w-100  mb-2 ">
                                <form method="post" action="post.php?process=ptable_post&status=list_multidelete&parent=<?=$_GET['parent']?>">
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
                                            <th><?=$diller['adminpanel-text-170']?></th>
                                            <th><?=$diller['adminpanel-form-text-1039']?></th>
                                            <th><?=$diller['adminpanel-form-text-1040']?></th>
                                            <th><?=$diller['adminpanel-form-text-1041']?></th>
                                            <th></th>
                                            <th><?=$diller['adminpanel-form-text-62']?></th>
                                            <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody  class="row_position">
                                        <?php foreach ($islemCek as $row) {


                                            $tabloSay = $db->prepare("select * from pricing_ozellik where pr_id=:pr_id  ");
                                            $tabloSay->execute(array(
                                                    'pr_id' => $row['id'],
                                            ));
                                            

                                            ?>
                                            <tr id="<?php echo $row['id'] ?>" style="cursor: move">
                                                <td>
                                                    <div class="custom-control custom-checkbox" >
                                                        <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                        <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                    </div>
                                                </td>
                                                <td width="40">
                                                    <div class="btn btn-outline-pink btn-sm">
                                                        <?=$row['sira']?>
                                                    </div>
                                                </td>
                                                <td style="font-weight: 500; min-width: 200px" >
                                                   <?php if($row['tavsiye'] == '1' ) {?>
                                                       <div class="badge badge-purple btn-sm" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1052']?>"><?=$diller['adminpanel-form-text-1065']?></div>
                                                   <?php }?>
                                                    <?=$row['baslik']?>
                                                </td>
                                                <td style="font-weight: 500; min-width: 120px" >
                                                    <?php if($row['fiyat'] == !null  ) {?>
                                                        <?php echo number_format($row['fiyat'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                    <?php }else { ?>
                                                        <?=$diller['adminpanel-form-text-1042']?>
                                                    <?php }?>
                                                </td>
                                                <td style="font-weight: 500; min-width: 130px" >
                                                    <?php if($row['odeme_sure'] == !null ) {?>
                                                    <?=$row['odeme_sure']?>
                                                    <?php }else { ?>
                                                    -
                                                    <?php }?>
                                                </td>
                                                <td width="160" style="min-width: 160px">
                                                    <a href="pages.php?page=pricing_table_features&parent=<?=$row['id']?>" class="btn btn-sm btn-warning rounded">
                                                         <?=$diller['adminpanel-form-text-1043']?> (<?=$tabloSay->rowCount()?>)
                                                    </a>
                                                </td>
                                                <td width="85">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-outline-danger " href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?>&status_update=<?=$row['id']?><?=$searchPage?><?=$sayfa?>">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?>&status_update=<?=$row['id']?><?=$searchPage?><?=$sayfa?>">
                                                            <div class="d-flex align-items-center">
                                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                <?=$diller['adminpanel-form-text-67']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                </td>
                                                <td class="text-right" style="min-width: 100px">
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=ptable_post&status=list_delete&no=<?=$row['id']?>&parent=<?=$_GET['parent']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?><?=$searchPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?><?=$searchPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                <?php } ?>
                                                <?php
                                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                    if($i == $Sayfa){
                                                        ?>
                                                        <li class="page-item active " aria-current="page">
                                                            <a class="page-link" href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?><?=$searchPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item "><a class="page-link" href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?><?=$searchPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                        <?php
                                                    }
                                                }
                                                }
                                                ?>

                                                <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                    <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?><?=$searchPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=pricing_table_list&parent=<?=$_GET['parent']?><?=$searchPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=ptable_list_edit',
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

<!-- Sıralama Kodu !-->
<script type="text/javascript">
    $( ".row_position" ).sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    });

    function updateOrder(data) {
        $.ajax({
            url:"",
            type:'post',
            data:{position:data},
            success:function(){
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1);
            }
        })
    }
</script>
<!-- Sıralama Kodu Son !-->

<script>
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
</script>
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
    $('#url_tur').on('change', function() {
        $('#modul-choise').css('display', 'none');
        if ( $(this).val() === '1' ) {
            $('#modul-choise').css('display', 'block');
        }
        $('#manuel-choise').css('display', 'none');
        if ( $(this).val() === '2' ) {
            $('#manuel-choise').css('display', 'block');
        }
    });
</script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.urunler_select').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-880']?>',
            ajax: {
                url: 'masterpiece.php?page=pricing_list_product_select',
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
    $(document).ready(function() {
        $('.select_ajax2').select2();
    });
</script>