<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'bank_transfer';


if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if (isset($_GET['orderNO']) || isset($_GET['limit']) || isset($_GET['requestStatus']) || isset($_GET['bank']) || isset($_GET['date']) || isset($_GET['date_end']) || isset($_GET['min']) || isset($_GET['max']) || isset($_GET['sort']) || isset($_GET['userID'])) {
    $filterPage = "&limit=$_GET[limit]&orderNO=$_GET[orderNO]&requestStatus=$_GET[requestStatus]&bank=$_GET[bank]&date=$_GET[date]&date_end=$_GET[date_end]&sort=$_GET[sort]";
}




?>
<title><?=$diller['adminpanel-menu-text-22']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=bank_transfer"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-22']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['siparis'] == '1' && $yetki['odeme_bildirim'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (gonderen like '%$_GET[search]%' or gonderen_not like '%$_GET[search]%' )";
            }else{
                $search = "where (gonderen like '%$_GET[search]%' or gonderen_not like '%$_GET[search]%' )";
            }

            if(isset($_GET['orderNO']) && $_GET['orderNO'] >'0'  ) {
                $orderNOGet = "and siparis_no='$_GET[orderNO]'";
            }else{
                $orderNOGet = null;
            }


            if(isset($_GET['bank']) && $_GET['bank'] >'0'  ) {
                $bankGET = "and banka='$_GET[bank]'";
            }else{
                $bankGET = null;
            }

            if(isset($_GET['requestStatus'])  ) {
                $durumGet = "and durum='$_GET[requestStatus]'";
            }else{
                $durumGet = null;
            }

            if($_GET['requestStatus'] == null  ) {
                $durumGet = null;
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



            if(isset($_GET['limit']) && $_GET['limit'] >'0'  ) {
                $limitGet = $_GET['limit'];
            }else{
                $limitGet = '30';
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from odeme_bildirim $search $orderNOGet $durumGet $bankGET  $dateGet $dateEndGet    ");
            $ToplamVeri = $Say->rowCount();
            $Limit = $limitGet;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from odeme_bildirim $search $orderNOGet $durumGet $bankGET  $dateGet $dateEndGet   order by id desc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

            $sipD = $db->prepare("select * from siparis_durumlar where durum=:durum");
            $sipD->execute(array(
                    'durum' => '1',
            ));

            $banks = $db->prepare("select banka_adi,doviz,id from bankalar where durum=:durum order by sira asc ");
            $banks->execute(array(
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
                                <h4> <?=$diller['adminpanel-menu-text-22']?></h4>
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
                            <div class="collapse  <?php if (isset($_GET['search']) || isset($_GET['orderNO']) || isset($_GET['requestStatus']) || isset($_GET['orderType']) || isset($_GET['date']) || isset($_GET['date_end']) || isset($_GET['min']) || isset($_GET['max']) || isset($_GET['sort']) ) {?>show<?php } ?>" id="filterAcc" data-parent="#accordion">
                                <form method="GET" action="pages.php">
                                    <input type="hidden" name="page" value="bank_transfer" >
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
                                                    <?=$diller['adminpanel-form-text-1587']?>
                                                </label>
                                                <input type="text" name="search" autocomplete="off" <?php if($_GET['search'] >'0'  ) { ?>value="<?=$_GET['search']?>" <?php }?> id="search"  class="form-control" >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="ordenum" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-91']?>
                                                </label>
                                                <input type="text" name="orderNO" autocomplete="off" <?php if($_GET['orderNO'] >'0'  ) { ?>value="<?=$_GET['orderNO']?>" <?php }?> id="ordenum"  class="form-control" >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="requestStatus" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1588']?>
                                                </label>
                                                <select name="requestStatus" class="form-control" id="requestStatus" >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <option value="0" <?php if($_GET['requestStatus'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1101']?></option>
                                                    <option value="1" <?php if($_GET['requestStatus'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1098']?></option>
                                                    <option value="2" <?php if($_GET['requestStatus'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1589']?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="bank" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1590']?>
                                                </label>
                                                <select name="bank" class="form-control" id="bank" >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <?php foreach ($banks as $bank) {?>
                                                        <option value="<?=$bank['id']?>" <?php if($bank['id'] == $_GET['bank'] ) { ?>selected<?php }?>><?=$bank['banka_adi']?> - <?=$bank['doviz']?></option>
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

                                            <div class="col-md-12 form-group">
                                                <button class="btn  m-1 btn-primary  " style="width: 150px; margin-left: 0px !important;"><?=$diller['adminpanel-form-text-1292']?></button>
                                                <?php if (isset($_GET['search']) || isset($_GET['orderNO']) || isset($_GET['requestStatus']) || isset($_POST['orderType']) || isset($_POST['date']) || isset($_POST['date_end']) || isset($_POST['min']) || isset($_POST['max']) || isset($_POST['sort']) || isset($_POST['userID'])) {?>
                                                    <a class="btn  m-1 btn-danger text-white" href="pages.php?page=bank_transfer" style="width: 150px">
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

                            <div class="table-responsive ">
                                <table class="table table-bordered table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th><?=$diller['adminpanel-text-91']?></th>
                                        <th><?=$diller['adminpanel-form-text-1587']?></th>
                                        <th><?=$diller['adminpanel-form-text-1591']?></th>
                                        <th><?=$diller['adminpanel-form-text-1592']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-1593']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-1588']?></th>
                                        <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {
                                        $banks2 = $db->prepare("select banka_adi,doviz,id,hesap_iban from bankalar where durum=:durum and id=:id order by sira asc ");
                                        $banks2->execute(array(
                                            'durum' => '1',
                                            'id' => $row['banka'],
                                        ));
                                        $bank2 = $banks2->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <tr>
                                            <td width="165" style="min-width: 165px; font-weight: 500;" >
                                                <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>" target="_blank">
                                                    #<?=$row['siparis_no']?>
                                                </a>
                                            </td>
                                            <td style="min-width: 145px" >
                                               <?=$row['gonderen']?>
                                            </td>
                                            <td style="min-width: 145px; font-size: 12px ;" >
                                              <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                            </td>
                                            <td style="font-weight: 500; min-width: 125px">
                                              <?php echo number_format($row['odeme_tutar'], 2); ?> <?=$row['parabirimi']?>
                                            </td>
                                            <td class="text-center" style="min-width: 235px" width="235">
                                               <strong><?=$bank2['banka_adi']?> <?=$bank2['doviz']?></strong>
                                                <div class="p-1 bg-white border border-grey text-center mt-1 shadow-sm" style="font-size: 11px ;">
                                                    <?=$bank2['hesap_iban']?>
                                                </div>
                                            </td>
                                            <td style="min-width: 140px; " width="185">
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <div class="btn btn-sm btn-block btn-secondary  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <?=$diller['adminpanel-form-text-1101']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>

                                                    <div class="btn btn-sm btn-block btn-success  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <i class="fa fa-check mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-1098']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['durum'] == '2' ) {?>
                                                    <div class="btn btn-sm btn-block btn-danger  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <i class="fa fa-times mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-1589']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td class="text-center" width="100" style="min-width: 100px">
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <a href="" data-href="post.php?process=bank_transfer_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=bank_transfer<?=$searchPage?><?=$filterPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=bank_transfer<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=bank_transfer<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=bank_transfer<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=bank_transfer<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=bank_transfer<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=bank_transfer_detail',
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
        $('#filterAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#filterAcc').offset().top - 80 },
                500);
        });
    });
</script>