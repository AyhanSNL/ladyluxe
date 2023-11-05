<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'email_import';

error_reporting(0);

$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from eposta_import ");
$ToplamVeri = $Say->rowCount();
$Limit = 20;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from eposta_import order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

?>
<title><?= $diller['adminpanel-menu-text-91'] ?> (XML) - <?= $panelayar['baslik'] ?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="page-title-nav">
                                <a href="<?= $ayar['panel_url'] ?>"><i
                                        class="ion ion-md-home"></i> <?= $diller['adminpanel-text-341'] ?></a>
                                <a href="javascript:Void(0)"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-86'] ?></a>
                                <a href="pages.php?page=email_list_import"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-91'] ?> (XML)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_eposta'] == '1') { ?>
            <div class="row">
                <?php include 'inc/modules/_helper/entegration_leftbar.php'; ?>
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-91']?> (XML)</h4>
                                <div>
                                    <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                                </div>
                            </div>
                            <div class="new-buttonu-main">
                                <div class="new-buttonu-main">
                                    <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-2056']?></a>
                                </div>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse" id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 pt-3 mb-3">
                                    <form action="post.php?process=email_import_post&status=import" method="post" enctype="multipart/form-data">
                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-white text-dark mt-n3 mb-3 border-bottom">
                                                <h5> <?=$diller['adminpanel-form-text-2056']?></h5>
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center ">
                                            <div class="form-group col-md-6">
                                                <label for="baslik">
                                                    <?=$diller['adminpanel-form-text-2057']?>
                                                </label>
                                                <input type="text" name="baslik" autocomplete="off"  id="baslik" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row d-flex align-items-center justify-content-center ">
                                            <div class="form-group col-md-6">
                                                <label for="inputGroupFile01">
                                                    <?=$diller['adminpanel-form-text-2059']?>
                                                </label>
                                                <div class="input-group mb-1">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="dosya" required >
                                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-50']?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success " name="importDo"><?=$diller['adminpanel-form-text-53']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                            <div class="table-responsive ">
                                <table class="table table-bordered table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th><?=$diller['adminpanel-form-text-2057']?></th>
                                        <th><?=$diller['adminpanel-form-text-2058']?></th>
                                        <th><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-center" ></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) { ?>
                                        <tr>
                                            <td style="min-width: 165px"  >
                                                <?=$row['baslik']?>
                                            </td>
                                            <td style="min-width: 165px"  >
                                                <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                            </td>
                                            <td style="min-width: 165px"  >
                                                <?php if($row['durum'] == '0' ) {?>
                                                  <div class="btn btn-sm btn-light border">
                                                      <?=$diller['adminpanel-form-text-2060']?>
                                                  </div>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                   <a class="btn btn-sm btn-success " href="pages.php?page=email_list_import_data&id=<?=$row['id']?>">
                                                       <i class="fa fa-arrow-right"></i> <?=$diller['adminpanel-form-text-2061']?>
                                                    </a>
                                                <?php }?>
                                            </td>
                                            <td style="min-width: 200px" width="200"  >
                                                <a href="pages.php?page=email_list_import_process&id=<?=$row['id']?>" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-sync"></i> 
                                                    <?=$diller['adminpanel-form-text-2062']?>
                                                </a>
                                                <a href="" data-href="post.php?process=email_import_post&status=delete&no=<?=$row['id']?>"  data-href-2="post.php?process=email_import_post&status=delete&no=<?=$row['id']?>&type=all" data-toggle="modal" data-target="#import-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                            <?php if($ToplamVeri > '0') {?>
                        <?php if($ToplamVeri > $Limit  ) {?>
                            <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light border-top  ">
                                <?php if($Sayfa >= 1){?>
                                <nav aria-label="Page navigation example " >
                                    <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                        <?php } ?>
                                        <?php if($Sayfa > 1){  ?>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=email_list_import"><?=$diller['sayfalama-ilk']?></a></li>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=email_list_import&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                        <?php } ?>
                                        <?php
                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                            if($i == $Sayfa){
                                                ?>
                                                <li class="page-item active " aria-current="page">
                                                    <a class="page-link" href="pages.php?page=email_list_import&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                <li class="page-item "><a class="page-link" href="pages.php?page=email_list_import&p=<?=$i?>"><?=$i?></a></li>
                                                <?php
                                            }
                                        }
                                        }
                                        ?>

                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=email_list_import&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=email_list_import&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                            <?php }} ?>
                                        <?php if($Sayfa >= 1){?>
                                    </ul>
                                </nav>
                            <?php } ?>
                            </div>
                        <?php }?>
                        <?php }?>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="card p-xl-5">
                <h3><?= $diller['adminpanel-text-136'] ?></h3>
                <h6><?= $diller['adminpanel-text-137'] ?></h6>
                <div class="mt-3">
                    <a href="<?= $ayar['panel_url'] ?>"
                       class="btn btn-primary"><?= $diller['adminpanel-text-138'] ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<script>
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
</script>