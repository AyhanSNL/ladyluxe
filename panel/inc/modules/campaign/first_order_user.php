<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'firstorder';
$firsOrderCheck = $db->prepare("select * from indirim_ilk_siparis where id=:id ");
$firsOrderCheck->execute(array(
        'id' => '1'
));
$row = $firsOrderCheck->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-179']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=first_order_discount"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-179']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-form-text-1964']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['kampanya'] == '1' && $yetki['indirimkod'] == '1' ) {?>


            <div class="row">

                <?php include 'inc/modules/_helper/campaign_leftbar.php'; ?>
                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-4">
                                    <a href="pages.php?page=first_order_discount" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                        <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                    </a>
                                    <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 ">
                                        <h6><?=$diller['adminpanel-menu-text-179']?> > <?=$diller['adminpanel-form-text-1964']?></h6>
                                    </div>
                                    <?php if($row['durum'] == '1' ) {


                                        if(isset($_GET['userID']) ) {
                                            if($_GET['userID'] == '0' || $_GET['userID'] == null  ) {
                                                header('Location:'.$ayar['panel_url'].'pages.php?page=first_order_user');
                                                exit();
                                            }
                                            $userID = htmlspecialchars($_GET['userID']);
                                            if($_GET['userID'] == htmlspecialchars($_GET['userID'])  ) {
                                                $userGet = "and uye_id='$userID'";
                                            }else{
                                                header('Location:'.$ayar['site_url'].'404');
                                                exit();
                                            }
                                        }

                                        if(isset($_GET['orderID']) ) {
                                            if($_GET['orderID'] == '0' || $_GET['orderID'] == null  ) {
                                                header('Location:'.$ayar['panel_url'].'pages.php?page=first_order_user');
                                                exit();
                                            }
                                            $orderID = htmlspecialchars($_GET['orderID']);
                                            if($_GET['orderID'] == htmlspecialchars($_GET['orderID'])  ) {
                                                $orderGET = "and siparis_id='$orderID'";
                                            }else{
                                                header('Location:'.$ayar['site_url'].'404');
                                                exit();
                                            }
                                        }

                                        $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
                                        $Say = $db->query("select * from indirim_ilk_siparis_kayit where onay='1' $userGet $orderGET ");
                                        $ToplamVeri = $Say->rowCount();
                                        $Limit = 40;
                                        $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
                                        $Goster = $Sayfa * $Limit - $Limit;
                                        $GorunenSayfa = 5;
                                        $islemListele = $db->query("select * from indirim_ilk_siparis_kayit where onay='1' $userGet $orderGET order by id desc limit $Goster,$Limit");
                                        $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

                                        ?>
                                        <div class="border-bottom pb-2">
                                            <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                                        </div>
                                        <?php if($ToplamVeri>'0') {?>
                                            <a  data-toggle="collapse" data-target="#userAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-light border mt-1 mb-1"><i class="fa fa-user"></i> <?=$diller['adminpanel-form-text-1197']?></a>
                                            <a  data-toggle="collapse" data-target="#orderAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-light border mt-1 mb-1"><i class="fa fa-shopping-basket"></i> <?=$diller['adminpanel-form-text-1969']?></a>
                                            <div id="accordion2" class="accordion">
                                                <!-- User Filter !-->
                                                <div class="collapse " id="userAcc" data-parent="#accordion2">
                                                    <form action="pages.php" method="get">
                                                        <input type="hidden" name="page" value="first_order_user" >
                                                        <div class="border  p-3 mb-2 rounded " style="border:3px solid #CCC !important;">
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
                                                <!-- User Filter !-->
                                                <div class="collapse " id="orderAcc" data-parent="#accordion2">
                                                    <form action="pages.php" method="get">
                                                        <input type="hidden" name="page" value="first_order_user" >
                                                        <div class="border  p-3  mb-2 rounded " style="border:3px solid #CCC !important;">
                                                            <div class="row">
                                                                <div class="col-md-12  form-group">
                                                                    <input type="number" name="orderID"  required placeholder="<?=$diller['adminpanel-text-91']?>"   class="form-control">
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
                                            <?php if(isset($_GET['userID'])) {?>
                                                <a class="btn btn-block btn-secondary" href="pages.php?page=first_order_user">
                                                    <i class="fa fa-times"></i>  <?=$diller['adminpanel-form-text-1196']?>
                                                </a>
                                            <?php }?>
                                            <?php if(isset($_GET['orderID'])) {?>
                                                <a class="btn btn-block btn-secondary" href="pages.php?page=first_order_user">
                                                    <i class="fa fa-times"></i>  <?=$diller['adminpanel-form-text-1114']?>
                                                </a>
                                            <?php }?>

                                        <?php }?>
                                        <div class="table-responsive ">
                                            <table class="table table-hover mb-0  ">
                                                <thead class="thead-default">
                                                <tr>
                                                    <th><?=$diller['adminpanel-form-text-1967']?></th>
                                                    <th><?=$diller['adminpanel-text-91']?></th>
                                                    <th><?=$diller['adminpanel-text-242']?></th>
                                                    <th  class="text-right" width="60"><?=$diller['adminpanel-text-157']?></th>
                                                </tr>
                                                </thead>
                                                <tbody  >
                                                <?php foreach ($islemCek as $islemrow) {
                                                    $uyeSql = $db->prepare("select id,isim,soyisim from uyeler where id=:id ");
                                                    $uyeSql->execute(array(
                                                            'id' => $islemrow['uye_id']
                                                    ));
                                                    $uyesqlRow = $uyeSql->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <tr>
                                                        <td style="font-weight: 500; min-width: 150px">
                                                            <?php if($uyeSql->rowCount()>'0'  ) {?>
                                                                <a href="pages.php?page=user_detail&userID=<?=$uyesqlRow['id']?>" class="btn btn-sm btn-primary" target="_blank">
                                                                    <?=$uyesqlRow['isim']?> <?=$uyesqlRow['soyisim']?>
                                                                </a>
                                                            <?php }else { ?>
                                                                <span style="font-style: italic">
                                                                    <?=$diller['adminpanel-form-text-1968']?>
                                                                </span>
                                                            <?php }?>
                                                        </td>
                                                        <td style="min-width: 135px" >
                                                            <a href="pages.php?page=order_detail&orderID=<?=$islemrow['siparis_id']?>" class="btn btn-sm btn-light border" target="_blank" style="font-weight: 600;">
                                                                #<?=$islemrow['siparis_id']?>
                                                            </a>
                                                        </td>
                                                        <td style="min-width: 150px" width="150" >
                                                                <?=$islemrow['ip_adres']?>
                                                        </td>
                                                        <td class="text-right" style="min-width: 100px">
                                                            <a href="" data-href="post.php?process=coupon_post&status=first_order_delete&no=<?=$islemrow['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=first_order_user<?=$getPack?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=first_order_user<?=$getPack?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                        <?php } ?>
                                                        <?php
                                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                            if($i == $Sayfa){
                                                                ?>
                                                                <li class="page-item active " aria-current="page">
                                                                    <a class="page-link" href="pages.php?page=first_order_user<?=$getPack?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                                </li>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <li class="page-item "><a class="page-link" href="pages.php?page=first_order_user<?=$getPack?>&p=<?=$i?>"><?=$i?></a></li>
                                                                <?php
                                                            }
                                                        }
                                                        }
                                                        ?>

                                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=first_order_user<?=$getPack?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=first_order_user<?=$getPack?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                                            <?php }} ?>
                                                        <?php if($Sayfa >= 1){?>
                                                    </ul>
                                                </nav>
                                            <?php } ?>
                                            </div>
                                        <?php }?>
                                        <!---- Sayfalama Elementleri ================== !-->



                                    <?php }else { ?>
                                        <div class="border border-warning alert-warning p-3 text-dark">
                                            <?=$diller['adminpanel-form-text-1966']?>
                                        </div>
                                    <?php }?>
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
        $('.user_select_form').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-1970']?>',
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
    $(function () {
        $('#userAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#userAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#orderAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#orderAcc').offset().top - 80 },
                500);
        });
    });
</script>