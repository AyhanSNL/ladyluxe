<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'email_import';
$ID = htmlspecialchars($_GET['id']);
$dosyaSql = $db->prepare("select * from eposta_import where id=:id ");
$dosyaSql->execute(array(
    'id' => $ID,
));
$row = $dosyaSql->fetch(PDO::FETCH_ASSOC);



$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from ebulten where xml_id='$ID' ");
$ToplamVeri = $Say->rowCount();
$Limit = 50;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from ebulten where xml_id='$ID' order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

?>
<title><?= $diller['adminpanel-form-text-2062'] ?> (XML) - <?= $panelayar['baslik'] ?></title>

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
                                <a href="javascript:Void(0)"><i
                                            class="fa fa-angle-right"></i> <?=$row['baslik']?></a>
                                <a href="javascript:Void(0)"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-form-text-2077'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_eposta'] == '1') { ?>
            <?php if($row['durum'] == '0' ) {?>
                <div class="card p-xl-5">
                    <h6><?= $diller['adminpanel-form-text-2066'] ?></h6>
                    <div class="mt-3">
                        <a href="<?= $ayar['panel_url'] ?>pages.php?page=email_list_import"
                           class="btn btn-primary"><?= $diller['adminpanel-text-138'] ?></a>
                    </div>
                </div>
            <?php }else { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3 mb-3">
                            <div>
                                <a href="pages.php?page=email_list_import" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                    <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                </a>
                            </div>
                            <div class="new-buttonu-main-top"">
                                <div class="new-buttonu-main-left">
                                    <h5><?=$row['baslik']?> > <?=$diller['adminpanel-form-text-2077']?></h5>
                                    <div class="mb-2">
                                        <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                                    </div>
                                </div>
                            </div>
                        <div class="w-100 alert-warning border-warning border p-3 text-dark mb-3">
                          <i class="fa fa-info-circle"></i> 
                            <?=$diller['adminpanel-form-text-2078']?>
                        </div>
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th><?=$diller['adminpanel-form-text-83']?></th>
                                        <th><?=$diller['adminpanel-form-text-1081']?></th>
                                        <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {?>
                                        <tr>
                                            <td style="font-weight: 500; min-width: 150px">
                                                <?=$row['eposta']?>
                                            </td>

                                            <td >
                                                <div style="min-width: 200px">
                                                    <?php echo date_tr('j F Y, H:i, l ', ''.$row['tarih'].''); ?>
                                                </div>
                                            </td>
                                            <td class="text-right" style="min-width: 100px">
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <a href="" data-href="post.php?process=email_list_post&status=account_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                            <div class="border-top"> </div>
                            <?php if($ToplamVeri<='0' ) {?>
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
                                                <li class="page-item "><a class="page-link " href="pages.php?page=email_list_import_data&id=<?=$ID?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=email_list_import_data&id=<?=$ID?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=email_list_import_data&id=<?=$ID?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=email_list_import_data&id=<?=$ID?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=email_list_import_data&id=<?=$ID?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=email_list_import_data&id=<?=$ID?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
            <?php }?>
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

<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=email_list_edit',
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