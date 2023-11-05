<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'admin';

$adminLer = $db->prepare("select * from yonetici where random_id=:random_id ");
$adminLer->execute(array(
        'random_id' => $_GET['no'],
));
$admincek = $adminLer->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['search'])  ) {
 if($_GET['search'] == null  ) {
  header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
 }
}

if($adminLer->rowCount()>'0'){
?>
<title><?=$diller['adminpanel-text-239']?> - <?=$panelayar['baslik']?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="page-title-box" >
                    <div class="row align-items-center" >
                        <div class="col-md-8" >
                            <h4 class="page-title m-0" ><?=$diller['adminpanel-text-239']?></h4>
                            <div class="page-title-nav">
                                <a href="javascript:Void(0)"><?=$diller['adminpanel-menu-text-151']?></a>
                                <i class="fa fa-angle-right"></i>
                                <a href="pages.php?page=admin_list"><?=$diller['adminpanel-menu-text-156']?></a>
                                <i class="fa fa-angle-right"></i>
                                <a href="pages.php?page=admin_edit&no=<?=$_GET['no']?>"><?=$admincek['isim']?> <?=$admincek['soyisim']?></a>
                                <i class="fa fa-angle-right"></i>
                                <a href="pages.php?page=admin_log&no=<?=$_GET['no']?>"><?=$diller['adminpanel-text-239']?></a>
                            </div>
                            <div style="width: 5px; height: 20px" class=" d-sm-inline-block block d-md-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1') {



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from yonetici_log where admin_id='$admincek[id]'");
            $ToplamVeri = $Say->rowCount();
            $Limit = 50;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from yonetici_log where admin_id='$admincek[id]' order by id DESC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100  pb-2 mb-2 d-flex align-items-center justify-content-between flex-wrap">
                            <div>
                                <h6 style="font-weight: 400!important;"><?=$admincek['isim']?> <?=$admincek['soyisim']?></h6>
                                <h4> <?=$diller['adminpanel-text-239']?></h4>
                            </div>
                            <div>
                                <a href="pages.php?page=admin_list" class="btn btn-outline-dark btn-sm mb-2"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                                <?php if($ToplamVeri>'0'  ) {?>
                                    <a href="" data-href="post.php?process=log_delete&status=admin_logs&no=<?=$admincek['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-outline-danger btn-sm mb-2 ml-2"> <?=$diller['adminpanel-text-249']?></a>
                                <?php }?>
                            </div>
                        </div>
                        <?php if($ayar['yonetici_log'] == '0' ) {?>
                        <div class="w-100 bg-white border border-danger mb-3 p-3 text-danger">
                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-text-250']?>
                        </div>
                        <?php }?>

                        <div class="w-100">
                            <form method="post" action="post.php?process=admin_post&status=admin_multi_delete">
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th><?=$diller['adminpanel-text-240']?></th>
                                            <th><?=$diller['adminpanel-text-241']?></th>
                                            <th><?=$diller['adminpanel-text-242']?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($islemCek as $row) {?>
                                            <tr>
                                                <td><?php echo date_tr('j F Y, H:i, l ', ''.$row['tarih'].''); ?></td>
                                                <td>
                                                    <?php if($row['islem'] == '0' ) {?>
                                                        <div class="btn btn-sm btn-danger"><?=$diller['adminpanel-text-244']?></div>
                                                    <?php }?>
                                                    <?php if($row['islem'] == '1' ) {?>
                                                        <div class="btn btn-sm btn-success"><?=$diller['adminpanel-text-243']?></div>
                                                    <?php }?>
                                                </td>
                                                <td style="font-weight: 500;"><?=$row['ip']?></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if($ToplamVeri == '1') {?>
                                    <div class="border-top"> </div>
                                <?php } ?>

                                <?php if($ToplamVeri<='0' && !isset($_GET['search']) ) {?>
                                <div class="w-100  p-3 ">
                                   <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                </div>
                                <?php }?>



                            </form>
                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=admin_log&no=<?=$_GET['no']?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=admin_log&no=<?=$_GET['no']?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=admin_log&no=<?=$_GET['no']?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=admin_log&no=<?=$_GET['no']?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=admin_log&no=<?=$_GET['no']?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=admin_log&no=<?=$_GET['no']?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
<?php
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
}
?>