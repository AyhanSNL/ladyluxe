<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'tickets';
if (isset($_GET['userID']) && $_GET['userID'] == !null) {
    $userPage = "&userID=$_GET[userID]";

}
if($_GET['userID'] == '0' && isset($_GET['userID']) ) {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=tickets');
    exit();
}

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}
if (isset($_GET['show']) && $_GET['show'] == !null) {
    $showingTYpe = "&show=$_GET[show]";
}




?>
<title><?=$diller['adminpanel-menu-text-28']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=tickets"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-28']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['uyelik'] == '1' && $yetki['ticket'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (baslik like '%$_GET[search]%' or destek_no like '%$_GET[search]%') ";
            }else{
                $search = "where (baslik like '%$_GET[search]%' or destek_no like '%$_GET[search]%') ";
            }
            if(isset($_GET['userID']) && $_GET['userID'] == !null  ) {
                $userFilter = 'and uye_id='.$_GET['userID'].'';
            }
            if(isset($_GET['show']) && $_GET['show'] == !null  ) {
                if($_GET['show'] == 'open'  ) {
                    $turFilter = "and durum='0' ";
                }
                if($_GET['show']=='close'  ) {
                    $turFilter = "and durum='1' ";
                }
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from destek_talebi $search $userFilter $turFilter ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 30;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from destek_talebi $search $userFilter $turFilter order by son_islem desc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

            $acikTalep = $db->prepare("select id from destek_talebi  $search $userFilter and  durum='0' ");
            $acikTalep->execute();
            $kapTalep = $db->prepare("select id from destek_talebi  $search $userFilter  and durum='1' ");
            $kapTalep->execute();

            ?>


            <div class="row">


                <?php include 'inc/modules/_helper/users_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-28']?></h4>
                            </div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <?php if(isset($_GET['show']) && $_GET['show'] == 'open'  ) { ?>
                                    <a href="pages.php?page=tickets<?=$searchPage?><?=$userPage?>" class="btn btn-success   "><?=$diller['adminpanel-form-text-1359']?> (<?=$acikTalep->rowCount()?>)</a>
                                <?php }else{ ?>
                                    <a href="pages.php?page=tickets&show=open<?=$searchPage?><?=$userPage?>"  class="btn btn-light border"><?=$diller['adminpanel-form-text-1359']?> (<?=$acikTalep->rowCount()?>)</a>
                                <?php }?>
                                <?php if(isset($_GET['show']) && $_GET['show'] == 'close'  ) { ?>
                                    <a href="pages.php?page=tickets<?=$searchPage?><?=$userPage?>" class="btn btn-primary  "><?=$diller['adminpanel-form-text-1360']?> (<?=$kapTalep->rowCount()?>)</a>
                                <?php }else{ ?>
                                    <a href="pages.php?page=tickets&show=close<?=$searchPage?><?=$userPage?>" class="btn btn-light border "><?=$diller['adminpanel-form-text-1360']?> (<?=$kapTalep->rowCount()?>)</a>
                                <?php }?>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=tickets<?=$showingTYpe?><?=$userPage?>" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="tickets" >
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
                        <div class="w-100   pt-2  d-flex align-items-center justify-content-start flex-wrap ">
                                <?php
                                if (isset($_GET['userID']) && $_GET['userID'] == !null   ) {

                                    $uyeCeks = $db->prepare("select isim,soyisim from uyeler where id=:id ");
                                    $uyeCeks->execute(array(
                                        'id' => $_GET['userID']
                                    ));
                                    $uyem = $uyeCeks->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                    <a href="pages.php?page=tickets<?=$searchPage?><?=$showingTYpe?>" class="btn btn-primary btn-block rounded-0  p-2">
                                       <div style="font-size: 20px ; font-weight: 500;">
                                           <?=$uyem['isim']?> <?=$uyem['soyisim']?>
                                       </div>
                                        <i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1196']?>
                                    </a>
                                <?php }else { ?>
                                    <a  data-toggle="collapse" data-target="#userAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-light btn-block rounded-0  p-3 border"><i class="fa fa-user"></i> <?=$diller['adminpanel-form-text-1197']?></a>
                                <?php }?>
                        </div>
                        <div id="accordion2" class="accordion">
                            <!-- User Filter !-->
                            <div class="collapse " id="userAcc" data-parent="#accordion2">
                                <form action="pages.php" method="get">
                                    <input type="hidden" name="page" value="tickets" >
                                    <div class="border  p-4   border-top-0 " >
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

                        <div class="w-100 mt-3">
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0  table-bordered ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th><?=$diller['adminpanel-form-text-1352']?></th> 
                                        <th><?=$diller['adminpanel-form-text-1353']?></th>
                                        <th><?=$diller['adminpanel-form-text-1354']?></th>
                                        <th><?=$diller['adminpanel-form-text-1355']?></th>
                                        <th><?=$diller['adminpanel-form-text-1356']?></th>
                                        <th><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center"><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {

                                        $uye = $db->prepare("select isim,soyisim,id from uyeler where id=:id ");
                                        $uye->execute(array(
                                                'id' => $row['uye_id'],
                                        ));
                                        $uyee = $uye->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <tr <?php if($row['durum'] == '0' ) { ?>style="background: #F4FFEF;  " <?php }?>  >
                                            <td style="font-weight: 500; min-width: 125px; " width="125">
                                                #<?=$row['destek_no']?>
                                            </td>
                                            <td style=" min-width: 125px; " width="125">
                                                <?=$row['baslik']?>
                                            </td>
                                            <td style=" min-width: 125px; " >
                                                <a href="pages.php?page=user_detail&userID=<?=$uyee['id']?>" target="_blank">
                                                    <i class="fa fa-user"></i> <?=$uyee['isim']?> <?=$uyee['soyisim']?>
                                                </a>
                                            </td>
                                            <td style=" min-width: 125px; " >
                                                <?php
                                                $date=$row['ilk_islem'];
                                                substr($date, 0, 10) //todo istediğim zaman parseleme
                                                ?>
                                                <?php echo date_tr('j F Y, H:i', ''.$row['ilk_islem'].''); ?>
                                            </td>
                                            <td style=" min-width: 125px; " >
                                                <?php echo date_tr('j F Y, H:i', ''.$row['son_islem'].''); ?>
                                            </td>
                                            <td style="min-width: 125px; " width="125">
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <div class="btn btn-sm btn-success " >
                                                        <div class="d-flex align-items-center">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <?=$diller['adminpanel-form-text-1358']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <div class="btn btn-sm btn-primary  " >
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-check mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-1357']?>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td class="text-right" style="min-width: 100px; " width="125">
                                                <a href="pages.php?page=ticket_detail&ticketID=<?=$row['destek_no']?>"  class="btn btn-sm btn-dark  mb-1" data-toggle="tooltip" data-placement="top" title=""><i class="fa fa-edit" ></i> <?=$diller['adminpanel-form-text-1362']?> </a>
                                                    <a href="" data-href="post.php?process=ticket_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger mb-1 "><i class="fa fa-trash" ></i></a>
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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=tickets<?=$searchPage?><?=$showingTYpe?><?=$userPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=tickets<?=$searchPage?><?=$showingTYpe?><?=$userPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=tickets<?=$searchPage?><?=$userPage?><?=$showingTYpe?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=tickets<?=$searchPage?><?=$userPage?><?=$showingTYpe?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=tickets<?=$searchPage?><?=$userPage?><?=$showingTYpe?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=tickets<?=$searchPage?><?=$userPage?><?=$showingTYpe?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
            placeholder: ' <?=$diller['adminpanel-form-text-1361']?>',
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