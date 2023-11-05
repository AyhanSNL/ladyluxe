<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;


?>
<title><?=$diller['adminpanel-text-10']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=account_log"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-text-10']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- end page title end breadcrumb -->
        <?php



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from yonetici_log where admin_id='$adminRow[id]'");
            $ToplamVeri = $Say->rowCount();
            $Limit = 50;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from yonetici_log where admin_id='$adminRow[id]' order by id DESC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




            ?>


            <div class="row">


                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="w-100  pb-2 mb-2 d-flex align-items-center justify-content-between flex-wrap">
                            <div>
                                <h6 style="font-weight: 400!important;"><?=$admincek['isim']?> <?=$admincek['soyisim']?></h6>
                                <h4> <?=$diller['adminpanel-text-10']?></h4>
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
                                    <table class="table table-hover mb-0 table-bordered  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th><?=$diller['adminpanel-text-240']?></th>
                                            <th class="text-center"><?=$diller['adminpanel-text-241']?></th>
                                            <th><?=$diller['adminpanel-text-242']?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($islemCek as $row) {?>
                                            <tr>
                                                <td><?php echo date_tr('j F Y, H:i, l ', ''.$row['tarih'].''); ?></td>
                                                <td class="text-center">
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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=account_log"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=account_log&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=account_log&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=account_log&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=account_log&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=account_log&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
    </div>
</div>
