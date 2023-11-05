<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'admin';

if(isset($_GET['search'])  ) {
 if($_GET['search'] == null  ) {
  header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
 }
}


?>
<title><?=$diller['adminpanel-menu-text-156']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=admin_list"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-156']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1') {



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from yonetici where  (isim like '%$_GET[search]%' or soyisim like '%$_GET[search]%'  or user_adi like '%$_GET[search]%') ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 15;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from yonetici where  (isim like '%$_GET[search]%' or soyisim like '%$_GET[search]%' or user_adi like '%$_GET[search]%') order by id DESC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-156']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a href="pages.php?page=admin_add" class="btn btn-success "><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-text-153']?></a>
                            </div>
                        </div>
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                      <a href="pages.php?page=admin_list" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="admin_list" id="" required class="form-control">
                                            <input type="text" name="search" class="form-control" placeholder="<?=$diller['adminpanel-text-154']?>"  aria-describedby="button-addon2" required autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-dark rounded-0" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="w-100">
                            <form method="post" action="post.php?process=admin_post&status=admin_multi_delete">
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th width="25">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                    <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                                </div>
                                            </th>
                                            <th><?=$diller['adminpanel-text-92']?></th>
                                            <th><?=$diller['adminpanel-text-155']?></th>
                                            <th><?=$diller['adminpanel-text-156']?></th>
                                            <th  class="text-center" width="130"><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($islemCek as $admins) {
                                            $yetkiBul = $db->prepare("select * from yetki_grup where id='$admins[yetki]' ");
                                            $yetkiBul->execute();
                                            $yetkiRow = $yetkiBul->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox" >
                                                        <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$admins['random_id']?>" name='sil[]' value="<?=$admins['random_id']?>" >
                                                        <label class="custom-control-label" for="checkSec-<?=$admins['random_id']?>" ></label>
                                                    </div>
                                                </th>
                                                <td style="min-width: 130px"><?=$admins['isim']?> <?=$admins['soyisim']?></td>
                                                <td style="min-width: 120px"><?=$admins['user_adi']?></td>
                                                <td style="font-weight: 500;min-width: 120px"><?=$yetkiRow['baslik']?></td>
                                                <td class="text-right" style="min-width: 100px">
                                                    <a href="pages.php?page=admin_log&no=<?=$admins['random_id']?>" class="btn btn-sm btn-dark " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-239']?>"><i class="fa fa-binoculars" ></i></a>
                                                    <a href="pages.php?page=admin_edit&no=<?=$admins['random_id']?>" class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <?php if($ToplamVeri > '1') {?>
                                                        <a href="" data-href="post.php?process=admin_post&status=admin_delete&no=<?=$admins['random_id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
                                                    <?php }?>
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
                                <?php if($ToplamVeri == '1') {?>
                                    <div class="border-top"> </div>
                                <?php } ?>

                                <?php if($ToplamVeri<='0' && !isset($_GET['search']) ) {?>
                                <div class="w-100  p-3 ">
                                   <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                </div>
                                <?php }?>

                                <?php if($ToplamVeri<='0' && isset($_GET['search']) ) {?>
                                    <div class="w-100  p-3 ">
                                       <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-163']?>
                                    </div>
                                <?php }?>
                                <?php if($ToplamVeri > '1') {?>
                                    <div class="w-100 pt-3 pb-3 border-bottom border-top  " >
                                        <button class="btn btn-danger btn-sm rounded-0 shadow-lg pl-4 pr-4 " type="submit" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=admin_list<?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=admin_list&p=<?=$Sayfa - 1?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=admin_list&p=<?=$i?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=admin_list&p=<?=$i?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=admin_list&p=<?=$Sayfa + 1?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=admin_list&p=<?=$Sayfa_Sayisi?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$diller['sayfalama-son']?></a></li>
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