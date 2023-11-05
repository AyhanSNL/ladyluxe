<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'login_log';


?>
<title><?=$diller['adminpanel-menu-text-160']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-151']?></a>
                                <a href="pages.php?page=login_log"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-160']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1') {



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from login_log ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 50;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from login_log order by id DESC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




            ?>


            <div class="row">
                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100  pb-2  d-flex align-items-center justify-content-between flex-wrap">
                            <div>
                                <h4> <?=$diller['adminpanel-menu-text-160']?></h4>
                                <div class="mb-2">
                                    <?=$diller['adminpanel-menu-text-161']?>
                                </div>
                            </div>
                            <?php if($ToplamVeri>'0'  ) {?>
                                <a href="" data-href="post.php?process=log_delete&status=login_logs"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-outline-danger btn-sm mb-2"> <?=$diller['adminpanel-text-249']?></a>
                            <?php }?>
                        </div>
                        <?php if($ayar['login_log'] == '0' ) {?>
                            <div class="w-100 bg-white border border-danger mb-3 p-3 text-danger">
                                <i class="fa fa-exclamation-triangle"></i> <?=$diller['adminpanel-text-251']?>
                            </div>
                        <?php }?>
                        <div class="w-100">
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th><?=$diller['adminpanel-text-240']?></th>
                                            <th><?=$diller['adminpanel-text-241']?></th>
                                            <th><?=$diller['adminpanel-text-245']?></th>
                                            <th><?=$diller['adminpanel-text-242']?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($islemCek as $row) {?>
                                            <tr>
                                                <td style="min-width: 150px;  "><?php echo date_tr('j F Y, H:i, l ', ''.$row['tarih'].''); ?></td>
                                                <td style="min-width: 100px">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <div class="btn btn-sm btn-danger"><?=$diller['adminpanel-text-247']?></div>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <div class="btn btn-sm btn-success"><?=$diller['adminpanel-text-243']?></div>
                                                    <?php }?>
                                                </td>
                                                <td style="min-width: 100px">
                                                <?php if($row['admin_id'] == null ) {?>
                                                <?=$diller['adminpanel-text-246']?>
                                                <?php }?>
                                                <?php if($row['admin_id'] == !null ) {
                                                    $adminLer = $db->prepare("select * from yonetici where id=:id ");
                                                    $adminLer->execute(array(
                                                        'id' => $row['admin_id'],
                                                    ));
                                                    $admincek = $adminLer->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <?php if($adminLer->rowCount()>'0'  ) {?>
                                                        <span style="font-weight: 600;"><?=$admincek['user_adi']?></span>
                                                    <?php }else { ?>
                                                        <span style="font-style: italic; color: #999"><?=$diller['adminpanel-text-248']?></span>
                                                    <?php }?>
                                                <?php }?>
                                                </td>
                                                <td style="font-weight: 500; min-width: 120px"><?=$row['ip']?></td>
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



                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=login_log"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=login_log&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=login_log&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=login_log&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=login_log&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=login_log&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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