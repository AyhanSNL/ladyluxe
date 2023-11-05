<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'product_export';

error_reporting(0);

$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from urun_export where dosya_tur='xml' ");
$ToplamVeri = $Say->rowCount();
$Limit = 15;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from urun_export where dosya_tur='xml' order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

?>
<title><?= $diller['adminpanel-menu-text-88'] ?> (XML) - <?= $panelayar['baslik'] ?></title>

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
                                <a href="pages.php?page=product_export"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-88'] ?> (XML)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_urun'] == '1') { ?>
            <div class="row">
                <?php include 'inc/modules/_helper/entegration_leftbar.php'; ?>
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-88']?> (XML)</h4>
                                <div>
                                    <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                                </div>
                            </div>
                            <div class="new-buttonu-main">
                                <div class="new-buttonu-main">
                                    <a href="javascript:Void(0)" data-id="xmlAdd"  class="btn btn-success duzenleAjax "  ><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-2017']?></a>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="post.php?process=product_export_post&status=xml_delete">
                            <div class="table-responsive ">
                                <table class="table table-bordered table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th width="35" style="max-width: 35px">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                            </div>
                                        </th>
                                        <th><?=$diller['adminpanel-form-text-2050']?></th>
                                        <th><?=$diller['adminpanel-form-text-2018']?></th>
                                        <th><?=$diller['adminpanel-form-text-2053']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-2051']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-form-text-2023']?></th>
                                        <th><?=$diller['adminpanel-form-text-54']?></th>
                                        <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) { ?>
                                        <tr>
                                            <th width="28" style="max-width: 28px">
                                                <div class="custom-control custom-checkbox" >
                                                    <input type="checkbox" class="custom-control-input individual "   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                    <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                </div>
                                            </th>
                                            <td width="135" style="min-width: 135px; font-weight: 500;" >
                                                <?php if($row['tur'] == 'standart'  ) {?>
                                                    <div class="btn btn-sm btn-block btn-outline-dark" style="font-size: 11px ;">
                                                        <?=$diller['adminpanel-form-text-2032']?>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['tur'] == 'google'  ) {?>
                                                    <div class="btn btn-block btn-sm btn-outline-primary">
                                                        Google Merchant
                                                    </div>
                                                <?php }?>
                                                <?php if($row['tur'] == 'n11'  ) {?>
                                                    <div class="btn btn-block btn-sm btn-outline-danger">
                                                       n11
                                                    </div>
                                                <?php }?>
                                                <?php if($row['tur'] == 'akakce'  ) {?>
                                                    <div class="btn btn-block btn-sm btn-outline-info">
                                                        Akakçe
                                                    </div>
                                                <?php }?>
                                                <?php if($row['tur'] == 'cimri'  ) {?>
                                                    <div class="btn btn-block btn-sm btn-outline-success">
                                                        Cimri
                                                    </div>
                                                <?php }?>
                                                <?php if($row['tur'] == 'hepsiburada'  ) {?>
                                                    <div class="btn btn-block btn-sm btn-outline-warning">
                                                        Hepsiburada
                                                    </div>
                                                <?php }?>
                                                <?php if($row['tur'] == 'pttavm'  ) {?>
                                                    <div class="btn btn-block btn-sm btn-outline-warning">
                                                        pttAVM
                                                    </div>
                                                <?php }?>
                                                <?php if($row['tur'] == 'facebook'  ) {?>
                                                    <div class="btn btn-block btn-sm btn-outline-primary">
                                                        Facebook
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td style="min-width: 165px" width="165" >
                                              <?=$row['baslik']?>
                                            </td>
                                            <td style="font-weight: 500; min-width: 50px" width="50">
                                             <?=$row['limit_start']?>
                                                -
                                                <?=$row['limit_end']?>
                                            </td>
                                            <td style="font-weight: 600; min-width: 120px; " width="120">
                                                <?php if($row['ipler'] == null  ) {?>
                                                    <div class="w-100 text-center "><?=$diller['adminpanel-form-text-2052']?></div>
                                                <?php }else { ?>
                                                    <?php
                                                    $ipler = $row['ipler'];
                                                    $ipler = explode(',', $ipler);
                                                    ?>
                                                    <?php foreach ($ipler as $iprow) {?>
                                                        <div class="border p-1 mb-1 rounded bg-white text-center ">
                                                            <?=$iprow?>
                                                        </div>
                                                    <?php }?>
                                                <?php }?>
                                            </td>
                                            <td style="font-weight: 500; min-width: 50px; text-align: center;" width="50">
                                              <?php if($row['kar'] >'0' ) {?>
                                              %<?=$row['kar']?>
                                              <?php }else { ?>
                                              0
                                              <?php }?>
                                            </td>
                                            <td style="min-width: 90px; font-size: 12px ;" width="90">
                                               <?php echo date_tr('j F Y', ''.$row['tarih'].''); ?> -
                                               <?php echo date_tr('H:i', ''.$row['saat'].''); ?>
                                            </td>
                                            <td class="text-center" width="105" style="min-width: 105px">
                                                <a href="<?=$ayar['site_url']?>output/xml/<?=$row['output_key']?>/?limit_start=<?=$row['limit_start']?>&limit_end=<?=$row['limit_end']?>" target="_blank" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-external-link-alt"></i> XML URL
                                                </a>
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax2" ><i class="fa fa-eye" ></i></a>
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
                            <div class="w-100 pt-3 pb-3 border-bottom  " >
                                <button class="btn btn-danger btn-sm rounded-0 shadow-lg pl-4 pr-4 " disabled="disabled" name="deleteMulti" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                            </div>
                        </form>
                        <script>
                            var checkboxes = $("input[type='checkbox']"),
                                submitButt = $("button[name='deleteMulti']");

                            checkboxes.click(function() {
                                submitButt.attr("disabled", !checkboxes.is(":checked"));
                            });
                        </script>
                        <?php if($ToplamVeri > $Limit  ) {?>
                            <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light border-top  ">
                                <?php if($Sayfa >= 1){?>
                                <nav aria-label="Page navigation example " >
                                    <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                        <?php } ?>
                                        <?php if($Sayfa > 1){  ?>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=product_export"><?=$diller['sayfalama-ilk']?></a></li>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=product_export&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                        <?php } ?>
                                        <?php
                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                            if($i == $Sayfa){
                                                ?>
                                                <li class="page-item active " aria-current="page">
                                                    <a class="page-link" href="pages.php?page=product_export&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                <li class="page-item "><a class="page-link" href="pages.php?page=product_export&p=<?=$i?>"><?=$i?></a></li>
                                                <?php
                                            }
                                        }
                                        }
                                        ?>

                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=product_export&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=product_export&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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

<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=product_export_modal',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
    $(document).ready(function(){

        $('.duzenleAjax2').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=product_export_xml_edit',
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

