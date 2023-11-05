<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'users';
$grp = $db->prepare("select * from uyeler_grup ");
$grp->execute();
$userAyar = $db->prepare("select * from uyeler_ayar ");
$userAyar->execute();
$userset = $userAyar->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['userID']) && $_GET['userID']== !null  ) {
    $Sql = $db->prepare("select * from uyeler where id=:id ");
    $Sql->execute(array(
        'id' => $_GET['userID']
    ));
    $row = $Sql->fetch(PDO::FETCH_ASSOC);


    if($Sql->rowCount()<='0'  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=users');
        exit();
    }


}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=users');
    exit();
}




?>
<title><?=$diller['adminpanel-form-text-1307']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$row['isim']?> <?=$row['soyisim']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <?php if($yetki['uyelik'] == '1' && $yetki['uye_yonet'] == '1') {

         ?>


            <div class="row">

                <?php include 'inc/modules/_helper/users_leftbar.php'; ?>
                <style>
                    .nav-link{
                        color: #000;
                        transition-duration: 0.1s; transition-timing-function: linear;
                        font-weight: 500;
                        font-size: 14px;
                        padding: 15px 25px;

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
                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="">
                        <div class="bg-primary text-white p-3 rounded d-flex align-items-center justify-content-between flex-wrap shadow-sm">
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 100px; background: #FFF; color: #000;">
                                    <i class="fa fa-user" style="font-size: 20px ;"></i>
                                </div>
                                <div class="ml-3">
                                    <h5><?=$row['isim']?> <?=$row['soyisim']?></h5>
                                </div>
                            </div>
                            <a href="pages.php?page=users" class="btn btn-outline-light btn-sm mt-2 mb-2 d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                        </div>
                        <div class="w-100 d-flex flex-column pb-2 mb-2">

                        </div>
                            <!-- Tab Alanı !-->
                            <ul class="nav nav-tabs " id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link saas "  href="pages.php?page=user_detail&userID=<?=$row['id']?>" >
                                       <?=$diller['adminpanel-form-text-1308']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas "  href="pages.php?page=user_detail_address&userID=<?=$row['id']?>" >
                                        <?=$diller['adminpanel-form-text-1309']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas active"  href="pages.php?page=user_favorites&userID=<?=$row['id']?>" >
                                        <?=$diller['adminpanel-form-text-1310']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas "  href="pages.php?page=user_log&userID=<?=$row['id']?>" >
                                        <?=$diller['adminpanel-text-239']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas "  href="pages.php?page=user_coupon&userID=<?=$row['id']?>" >
                                        <?=$diller['adminpanel-menu-text-31']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas " href="pages.php?page=products_comments&userID=<?=$row['id']?>" target="_blank">
                                        <?=$diller['adminpanel-form-text-1311']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas " href="pages.php?page=orders&userID=<?=$row['id']?>" target="_blank">
                                        <?=$diller['adminpanel-form-text-1312']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas " href="pages.php?page=tickets&userID=<?=$row['id']?>" target="_blank">
                                       <?=$diller['adminpanel-menu-text-28']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas " href="pages.php?page=all_cart_list&userID=<?=$row['id']?>" target="_blank">
                                        <?=$diller['adminpanel-form-text-1313']?>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content bg-white rounded-bottom border border-top-0">
                                <div class="tab-pane active p-4" id="one" role="tabpanel" >
                                    <?php
                                    $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
                                    $Say = $db->query("select * from urun_favori where uye_id='$row[id]'  ");
                                    $ToplamVeri = $Say->rowCount();
                                    $Limit = 32;
                                    $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
                                    $Goster = $Sayfa * $Limit - $Limit;
                                    $GorunenSayfa = 5;
                                    $islemListele = $db->query("select * from urun_favori where uye_id='$row[id]'  order by id asc limit $Goster,$Limit");
                                    $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <div class="row">
                                    <?php foreach ($islemCek as $row) {
                                        $urunCek = $db->prepare("select id,gorsel,baslik,fiyat,seo_url from urun where id=:id ");
                                        $urunCek->execute(array(
                                            'id' => $row['urun_id'],
                                        ));
                                        $urun = $urunCek->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                    <div class="col-md-3">
                                        <div class="border">
                                            <div class="card-body">
                                                <div class="bg-light text-center p-3 mb-3">
                                                    <img src="../images/product/<?=$urun['gorsel']?>" style="width: 80px;">
                                                </div>
                                                <div style="font-size: 14px ; font-weight: 500;">
                                                    <?=$urun['baslik']?>
                                                </div>
                                                <?php if($urun['fiyat'] > '0'  ) {?>
                                                    <div >
                                                        <?php echo number_format($urun['fiyat'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                    </div>
                                                <?php }else { ?>
                                                    <?php if($odemeRow['ucretsiz_alisveris'] == '1' ) {?>
                                                        <div ><?=$diller['adminpanel-form-text-1335']?></div>
                                                    <?php }else { ?>
                                                        <div > <?php echo number_format($urun['fiyat'], 2); ?> <?=$Current_Money['sag_simge']?></div>
                                                    <?php }?>
                                                <?php }?>
                                                <br>
                                                <a href="<?=$ayar['site_url']?><?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank"  class="btn btn-primary btn-sm rounded-0">
                                                    <i class="fa fa-external-link-alt"></i>
                                                    <?=$diller['adminpanel-text-116']?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                        <?php if($ToplamVeri<='0'  ) {?>
                                        <div class="border border-warning alert-warning col-md-12 text-dark p-3">
                                            <?=$diller['adminpanel-form-text-1334']?>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <!---- Sayfalama Elementleri ================== !-->
                                    <?php if($ToplamVeri > $Limit  ) {?>
                                        <div id="SayfalamaElementi" class="w-100 p-2 mt-3  border-bottom bg-light  ">
                                            <?php if($Sayfa >= 1){?>
                                            <nav aria-label="Page navigation example " >
                                                <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                                    <?php } ?>
                                                    <?php if($Sayfa > 1){  ?>
                                                        <li class="page-item "><a class="page-link " href="pages.php?page=user_favorites&userID=<?=$_GET['userID']?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                        <li class="page-item "><a class="page-link " href="pages.php?page=user_favorites&userID=<?=$_GET['userID']?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                    <?php } ?>
                                                    <?php
                                                    for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                        if($i == $Sayfa){
                                                            ?>
                                                            <li class="page-item active " aria-current="page">
                                                                <a class="page-link" href="pages.php?page=user_favorites&userID=<?=$_GET['userID']?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                            </li>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <li class="page-item "><a class="page-link" href="pages.php?page=user_favorites&userID=<?=$_GET['userID']?>&p=<?=$i?>"><?=$i?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    }
                                                    ?>

                                                    <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                        <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                            <li class="page-item"><a class="page-link" href="pages.php?page=user_favorites&userID=<?=$_GET['userID']?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                            <li class="page-item"><a class="page-link" href="pages.php?page=user_favorites&userID=<?=$_GET['userID']?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                            <!--  <========SON=========>>> Tab Alanı SON !-->

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
