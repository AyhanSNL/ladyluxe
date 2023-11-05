<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'offers';


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




?>
<title><?=$diller['adminpanel-menu-text-19']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=offers"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-19']?></a>
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
                $orderNOGet = "and teklif_no='$_GET[orderNO]'";
            }else{
                $orderNOGet = null;
            }

            if(isset($_GET['orderStatus']) && $_GET['orderStatus'] >'0'  ) {
                if( $_GET['orderStatus'] == 'no' ) {
                    $orderStatusGet = "and durum='0'";
                }
                if( $_GET['orderStatus'] == 'ok' ) {
                    $orderStatusGet = "and durum='1'";
                }
            }else{
                $orderStatusGet = null;
            }


            if(isset($_GET['sort']) && $_GET['sort'] >'0'  ) {
                if($_GET['sort'] == '1' || $_GET['sort'] == '2'  || $_GET['sort'] == '3' || $_GET['sort'] == '4'  ) {
                    if($_GET['sort'] == '1'  ) {
                        $sortOrder = "tarih desc";
                    }
                    if($_GET['sort'] == '4'  ) {
                        $sortOrder = "tarih asc";
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
            $Say = $db->query("select * from 	siparis_teklif $search $orderNOGet $orderStatusGet  $uyeGet  ");
            $ToplamVeri = $Say->rowCount();
            $Limit = $limitGet;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from siparis_teklif $search $orderNOGet $orderStatusGet  $uyeGet  order by $sortOrder limit $Goster,$Limit");
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
                                <h4> <?=$diller['adminpanel-menu-text-19']?></h4>
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
                                    <input type="hidden" name="page" value="offers" >
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
                                                <label for="teklifno" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1552']?>
                                                </label>
                                                <input type="text" name="orderNO" autocomplete="off" <?php if($_GET['orderNO'] >'0'  ) { ?>value="<?=$_GET['orderNO']?>" <?php }?> id="teklifno"  class="form-control" >
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="orderStatus" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-62']?>
                                                </label>
                                                <select name="orderStatus" class="form-control" id="orderStatus" >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <option value="no" <?php if($_GET['orderStatus'] == 'no'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1554']?></option>
                                                    <option value="ok" <?php if($_GET['orderStatus'] == 'ok'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1555']?></option>
                                                </select>
                                            </div>


                                            <div class="col-md-12 form-group">
                                                <label for="sort" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1446']?>
                                                </label>
                                                <select name="sort" class="form-control" id="sort" >
                                                    <option value="1" <?php if( $_GET['sort'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1443']?></option>
                                                    <option value="4" <?php if( $_GET['sort'] == '4' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1449']?></option>
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
                                                    <a class="btn  m-1 btn-danger text-white" href="pages.php?page=offers" style="width: 150px">
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
                                        <th><?=$diller['adminpanel-form-text-1552']?></th>
                                        <th><?=$diller['adminpanel-form-text-1551']?></th>
                                        <th><?=$diller['adminpanel-form-text-83']?></th>
                                        <th><?=$diller['adminpanel-form-text-81']?></th>
                                        <th><?=$diller['adminpanel-form-text-1553']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {
                                         $siparisDurum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                         $siparisDurum->execute(array(
                                                 'id' => $row['durum'],
                                         ));
                                         $siDur = $siparisDurum->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <input type="hidden" name="export_id[]" value="<?=$row['id']?>" >
                                        <tr>
                                            <td width="165" style="min-width: 165px; font-weight: 500;" >
                                               #<?=$row['teklif_no']?>
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
                                                <td style="min-width: 125px; font-size: 12px ;" >
                                           <?=$row['eposta']?>
                                            </td>

                                            <td style="font-weight: 500;">
                                                <?=$row['telefon']?>
                                            </td>
                                            <td>
                                               <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                            </td>
                                            <td style="min-width: 140px; " width="185">
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <div class="btn btn-sm btn-block btn-info  "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                           <?=$diller['adminpanel-form-text-1549']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <div class="btn btn-sm btn-block  btn-success "  >
                                                        <div class="d-flex align-items-center justify-content-center " style="font-size: 11px !important; ;">
                                                         <i class="fa fa-check mr-1"></i> <?=$diller['adminpanel-form-text-1550']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td class="text-center" width="100" style="min-width: 100px">
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <a href="" data-href="post.php?process=order_post&status=offer_delete&no=<?=$row['teklif_no']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=offers<?=$searchPage?><?=$filterPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=offers<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=offers<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=offers<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=offers<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=offers<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=offer_edit',
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
</script>