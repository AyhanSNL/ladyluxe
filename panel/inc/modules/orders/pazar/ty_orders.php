<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'ty_orders';
$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);

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
     header('Location:'.$ayar['panel_url'].'pages.php?page=ty_orders');
     exit();
 }
}


?>
<title>Trendyol <?=$diller['pazaryeri-text-129']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=ty_orders"><i class="fa fa-angle-right"></i>Trendyol <?=$diller['pazaryeri-text-129']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1' && $pazar['ty_durum'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (teslimat_isim like '%$_GET[search]%' or teslimat_adres like '%$_GET[search]%' or musteri_isim like '%$_GET[search]%' or kargo_adi like '%$_GET[search]%') ";
            }else{
                $search = "where (teslimat_isim like '%$_GET[search]%' or teslimat_adres like '%$_GET[search]%' or musteri_isim like '%$_GET[search]%' or kargo_adi like '%$_GET[search]%') ";
            }

            if(isset($_GET['orderNO']) && $_GET['orderNO'] >'0'  ) {
                $orderNOGet = "and siparis_no='$_GET[orderNO]'";
            }else{
                $orderNOGet = null;
            }


            if(isset($_GET['date']) && $_GET['date'] >'0'  ) {
                $dateGet = "and siparis_sade_tarih >='$_GET[date]' ";
            }else{
                $dateGet = null;
            }

            if(isset($_GET['date_end']) && $_GET['date_end'] >'0'  ) {
                $dateEndGet = "and siparis_sade_tarih <='$_GET[date_end]'  ";
            }else{
                $dateEndGet = null;
            }


            if(isset($_GET['limit']) && $_GET['limit'] >'0'  ) {
                $limitGet = $_GET['limit'];
            }else{
                $limitGet = '30';
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from trendyol_siparis $search $orderNOGet  $dateGet $dateEndGet  ");
            $ToplamVeri = $Say->rowCount();
            $Limit = $limitGet;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from trendyol_siparis $search $orderNOGet  $dateGet $dateEndGet  order by id desc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

            

            ?>


            <div class="row">
                <style>
                    .pazar-alert-ul{
                        margin-bottom: 0;
                        margin-top: 10px;
                        font-size: 14px ;
                    }
                    .pazar-alert-ul li{
                        margin-bottom: 10px;
                    }
                    @media screen and (max-width: 768px) and (min-width: 0)  {
                        .pazar-alert-ul{
                            margin-bottom: 0;
                            margin-top: 10px;
                            font-size: 14px ;
                            padding:15px;
                            width: 100%;
                        }
                        .pazar-alert-ul li{
                            margin-bottom: 10px;
                        }
                    }
                </style>

                <?php include 'inc/modules/_helper/orders_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top mb-0 pb-2 ">
                            <div class="new-buttonu-main-left">
                                <h4> Trendyol <?=$diller['pazaryeri-text-129']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-dark text-white" href="post.php?process=ty_order_services_get" id="waitButton"><i class="fa fa-sync"></i> Trendyol <?=$diller['pazaryeri-text-130']?></a>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="w-100 border p-3 mb-2 up-arrow-2 mt-3 rounded-0 alert alert-dismissible bg-light border text-dark">
                                <div>
                                    <ul class="pazar-alert-ul">
                                     <?=$diller['pazaryeri-text-131']?>
                                    </ul>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
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
                            <div class="collapse <?php if (isset($_GET['search']) || isset($_GET['orderNO']) || isset($_GET['date']) || isset($_GET['date_end'])  ) {?>show<?php } ?>" id="filterAcc" data-parent="#accordion">
                                <form method="GET" action="pages.php">
                                    <input type="hidden" name="page" value="ty_orders" >
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
                                            <div class="col-md-6 form-group">
                                                <label for="search" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-154']?>
                                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1437']?>"></i>
                                                </label>
                                                <input type="text" name="search" autocomplete="off" <?php if($_GET['search'] >'0'  ) { ?>value="<?=$_GET['search']?>" <?php }?> id="search"  class="form-control" >
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="nonono" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-91']?>
                                                </label>
                                                <input type="text" name="orderNO" autocomplete="off" <?php if($_GET['orderNO'] >'0'  ) { ?>value="<?=$_GET['orderNO']?>" <?php }?> id="nonono"  class="form-control" >
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for=""><?=$diller['adminpanel-form-text-1088']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date" <?php if($_GET['date'] >'0'  ) { ?>value="<?=$_GET['date']?>" <?php }?> class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_first" autocomplete="off"  style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for=""><?=$diller['adminpanel-form-text-1089']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="date_end" <?php if($_GET['date_end'] >'0'  ) { ?>value="<?=$_GET['date_end']?>" <?php }?> class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_ends" autocomplete="off"  style="height: 40px">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <button class="btn  m-1 btn-primary  " style="width: 150px; margin-left: 0px !important;"><?=$diller['adminpanel-form-text-1292']?></button>
                                                <?php if (isset($_GET['search']) || isset($_GET['orderNO']) || isset($_POST['orderStatus']) || isset($_POST['orderType']) || isset($_POST['date']) || isset($_POST['date_end']) || isset($_POST['min']) || isset($_POST['max']) || isset($_POST['sort']) || isset($_POST['userID'])) {?>
                                                    <a class="btn  m-1 btn-danger text-white" href="pages.php?page=ty_orders" style="width: 150px">
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



                            <div class="table-responsive ">
                                <table class="table table-bordered table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th><?=$diller['adminpanel-text-91']?></th>
                                        <th><?=$diller['adminpanel-form-text-1433']?></th>
                                        <th><?=$diller['users-panel-text140']?></th>
                                        <th><?=$diller['adminpanel-form-text-1217']?></th>
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
                                            <td width="165" style="min-width: 165px; font-weight: 500;" >
                                               #<?=$row['siparis_no']?>
                                            </td>
                                            <td style="min-width: 125px" >
                                               <?=$row['musteri_isim']?>
                                            </td>
                                            <td style="min-width: 125px" >
                                                <?php echo number_format($row['ara_toplam'], 2); ?> TRY
                                            </td>
                                            <td style="min-width: 125px" >
                                            <?php echo number_format($row['indirim'], 2); ?> TRY
                                            </td>
                                            <td style="font-weight: 500;">
                                                <?php echo number_format($row['toplam'], 2); ?> TRY
                                            </td>
                                            <td>
                                               <?php echo date_tr('j F Y, H:i', ''.$row['siparis_tarih'].''); ?>
                                            </td>
                                            <td style="min-width: 140px; " width="185">
                                                <?php if($row['siparis_durum'] == 'Awaiting' ) {?>
                                                    <div class="btn btn-sm btn-light  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-132']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'Created' ) {?>
                                                    <div class="btn btn-sm btn-light  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-133']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'Picking' ) {?>
                                                    <div class="btn btn-sm btn-light  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-134']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'Invoiced' ) {?>
                                                    <div class="btn btn-sm btn-light  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-135']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'Shipped' ) {?>
                                                    <div class="btn btn-sm btn-light  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-136']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'AtCollectionPoint' ) {?>
                                                    <div class="btn btn-sm btn-light  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-137']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'Cancelled' ) {?>
                                                    <div class="btn btn-sm btn-danger  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-138']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'UnPacked' ) {?>
                                                    <div class="btn btn-sm btn-light  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-139']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'Delivered' ) {?>
                                                    <div class="btn btn-sm btn-success  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-140']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'UnDelivered' ) {?>
                                                    <div class="btn btn-sm btn-outline-danger  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-141']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['siparis_durum'] == 'UnDeliveredAndReturned' ) {?>
                                                    <div class="btn btn-sm btn-outline-danger  btn-block  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <?=$diller['pazaryeri-text-142']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td class="text-right" width="60" style="min-width: 60px; text-align: center;">
                                                <a href="pages.php?page=ty_order_detail&orderID=<?=$row['siparis_no']?>" class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1435']?>"><i class="fa fa-eye" ></i></a>
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

                        <?php }?>
                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=ty_orders<?=$searchPage?><?=$filterPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=ty_orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=ty_orders<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=ty_orders<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=ty_orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=ty_orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
