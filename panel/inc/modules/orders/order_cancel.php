<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'order_cancel';


if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if (isset($_GET['orderNO']) || isset($_GET['limit']) || isset($_GET['cancelStatus']) || isset($_GET['orderType']) || isset($_GET['date']) || isset($_GET['date_end']) || isset($_GET['min']) || isset($_GET['max']) || isset($_GET['sort']) || isset($_GET['userID'])) {
    $filterPage = "&limit=$_GET[limit]&orderNO=$_GET[orderNO]&cancelStatus=$_GET[cancelStatus]&orderType=$_GET[orderType]&date=$_GET[date]&date_end=$_GET[date_end]&min=$_GET[min]&max=$_GET[max]&sort=$_GET[sort]&userID=$_GET[userID]";
}




?>
<title><?=$diller['adminpanel-menu-text-20']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=order_cancel"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-20']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['siparis'] == '1' && $yetki['siparis_yonet'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (siparis_no like '%$_GET[search]%' or talep_no like '%$_GET[search]%') ";
            }else{
                $search = "where (siparis_no like '%$_GET[search]%' or talep_no like '%$_GET[search]%') ";
            }


            if(isset($_GET['orderNO']) && $_GET['orderNO'] >'0'  ) {
                $orderNOGet = "and siparis_no='$_GET[orderNO]'";
            }else{
                $orderNOGet = null;
            }

            if(isset($_GET['cancelNO']) && $_GET['cancelNO'] >'0'  ) {
                $talepNOGet = "and talep_no='$_GET[cancelNO]'";
            }else{
                $talepNOGet = null;
            }

            if(isset($_GET['cancelStatus'])  ) {
                if($_GET['cancelStatus'] <= '0'  ) {
                    $statuGet = "and durum='0'";
                }else{
                    $statuGet = "and durum='$_GET[cancelStatus]'";
                }
            }else{
                $statuGet = null;
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
            $Say = $db->query("select * from siparis_iptal $search $orderNOGet $talepNOGet $uyeGet $statuGet  ");
            $ToplamVeri = $Say->rowCount();
            $Limit = $limitGet;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from siparis_iptal $search $orderNOGet $talepNOGet $uyeGet $statuGet order by id desc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/orders_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top mb-0 border-bottom pb-2 ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-20']?></h4>
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
                                    <input type="hidden" name="page" value="order_cancel" >
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
                                                <label for="orderNO" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-91']?>
                                                </label>
                                                <input type="text" name="orderNO" autocomplete="off" <?php if($_GET['orderNO'] >'0'  ) { ?>value="<?=$_GET['orderNO']?>" <?php }?> id="orderNo"  class="form-control" >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="cancelNO" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1471']?>
                                                </label>
                                                <input type="text" name="cancelNO" autocomplete="off" <?php if($_GET['cancelNO'] >'0'  ) { ?>value="<?=$_GET['cancelNO']?>" <?php }?> id="cancelNO"  class="form-control" >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="cancelStatus" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1364']?>
                                                </label>
                                                <select name="cancelStatus" class="form-control" id="cancelStatus" >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <option value="0" <?php if($_GET['cancelStatus'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1564']?></option>
                                                    <option value="1" <?php if($_GET['cancelStatus'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1468']?></option>
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
                                                    <a class="btn  m-1 btn-danger text-white" href="pages.php?page=order_cancel" style="width: 150px">
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
                                        <i class="fa fa-user"></i>  <?=$uyeRo['isim']?> <?=$uyeRo['soyisim']?> <?=$diller['adminpanel-menu-text-20']?>
                                    </div>
                                <?php }?>
                            <?php }?>



                            <div class="table-responsive ">
                                <table class="table table-bordered table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th><?=$diller['adminpanel-form-text-1471']?></th>
                                        <th><?=$diller['adminpanel-text-91']?></th>
                                        <th><?=$diller['adminpanel-form-text-1433']?></th>

                                        <th><?=$diller['adminpanel-form-text-1472']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) { ?>
                                        <tr>
                                            <td width="135" style="min-width: 135px; font-weight: 500;" >
                                                #<?=$row['talep_no']?>
                                            </td>
                                            <td width="165" style="min-width: 165px; font-weight: 500;" >
                                                <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>">
                                                    #<?=$row['siparis_no']?>
                                                </a>
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
                                            <td style="min-width: 165px" width="165">
                                                <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                            </td>
                                            <td style="min-width: 140px; " width="185">
                                            <?php if($row['durum'] == '0' ) {?>
                                                <div class="btn btn-sm btn-block btn-info  "  >
                                                    <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                        <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <?=$diller['adminpanel-form-text-1564']?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <div class="btn btn-sm btn-outline-danger  btn-block bg-light text-danger " style="border-width: 1px; font-weight: 500;"  >
                                                        <div class="d-flex align-items-center justify-content-center " >
                                                            <i class="fa fa-ban mr-2"></i>  <?=$diller['adminpanel-form-text-1468']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td class="text-center" width="135" style="min-width: 135px">
                                                <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>" class="btn btn-sm btn-primary " ><i class="fa fa-eye" ></i> <?=$diller['users-panel-text53']?></a>
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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=order_cancel<?=$searchPage?><?=$filterPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=order_cancel<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=order_cancel<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=order_cancel<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=order_cancel<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=order_cancel<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
        $('#filterAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#filterAcc').offset().top - 80 },
                500);
        });
    });
    $(document).ready(function() {
        $('.user_select_form').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-1562']?>',
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