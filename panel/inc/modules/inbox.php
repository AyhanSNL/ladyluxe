<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;


?>
<title><?=$diller['adminpanel-text-210']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=inbox"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-text-210']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<?php if($yetki['gelenkutusu'] == '1') {?>
    <!-- end page title end breadcrumb -->
    <?php



    $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
    $Say = $db->query("select * from mesaj");
    $ToplamVeri = $Say->rowCount();
    $Limit = 30;
    $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
    $Goster = $Sayfa * $Limit - $Limit;
    $GorunenSayfa = 5;
    $islemListele = $db->query("select * from mesaj order by id DESC limit $Goster,$Limit");
    $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




    ?>
    <div class="row">


        <!-- Contents !-->
        <div class="col-md-12">
            <div class="card p-3">
                <div class="w-100  pb-2 mb-2 d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h6 style="font-weight: 400!important;"><?=$admincek['isim']?> <?=$admincek['soyisim']?></h6>
                        <h4> <?=$diller['adminpanel-text-210']?></h4>
                        <div>
                            <?=$diller['adminpanel-form-text-1124']?> : <strong><?=$ToplamVeri?></strong>
                        </div>
                    </div>

                </div>


                <div class="w-100">
                    <form method="post" action="post.php?process=other_post&status=inbox_delete">
                        <div class="table-responsive ">
                            <table class="table table-hover mb-0   ">
                                <thead class="thead-default">
                                <tr>
                                    <th width="25">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                            <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                        </div>
                                    </th>
                                    <th><?=$diller['adminpanel-form-text-1738']?></th>
                                    <th><?=$diller['adminpanel-form-text-1739']?></th>
                                    <th><?=$diller['adminpanel-form-text-1267']?></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($islemCek as $row) {?>
                                    <tr <?php if($row['durum'] == '1' ) { ?>style="background-color: #f8fdff;"<?php }?>>
                                        <td>
                                            <div class="custom-control custom-checkbox" >
                                                <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                            </div>
                                        </td>
                                        <td style="min-width: 140px">
                                            <?=$row['isim']?>
                                        </td>
                                        <td style="min-width: 140px" >
                                            <?=$row['konu']?>
                                        </td>
                                        <td style="min-width:140px;">
                                            <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                        </td>
                                        <td style="min-width: 155px" width="155">
                                            <?php if($row['durum'] == '0' ) {?>
                                                <div class="btn btn-success rounded-0 btn-sm d-flex align-items-center justify-content-center">
                                                    <i class="fa fa-check mr-2"></i>
                                                    <?=$diller['adminpanel-form-text-1268']?>
                                                </div>
                                            <?php }else { ?>
                                                <div class="btn btn-light border bg-white rounded-0 btn-sm d-flex align-items-center justify-content-center">
                                                    <div class="spinner-grow text-dark mr-2" role="status" style="width: 10px; height: 10px">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <?=$diller['adminpanel-form-text-1269']?>
                                                </div>
                                            <?php }?>
                                        </td>
                                        <td width="140" style="min-width: 140px; text-align: right;">
                                            <a href="pages.php?page=inbox_detail&messageID=<?=$row['id']?>" class="btn btn-primary rounded-0 btn-sm">
                                                <?=$diller['adminpanel-form-text-1741']?>
                                            </a>
                                        </td>
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
                        <?php if($ToplamVeri > '0') {?>
                        <div class="w-100 pt-3 pb-3 border-bottom border-top  " >
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
                                        <li class="page-item "><a class="page-link " href="pages.php?page=inbox"><?=$diller['sayfalama-ilk']?></a></li>
                                        <li class="page-item "><a class="page-link " href="pages.php?page=inbox&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                    <?php } ?>
                                    <?php
                                    for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                        if($i == $Sayfa){
                                            ?>
                                            <li class="page-item active " aria-current="page">
                                                <a class="page-link" href="pages.php?page=inbox&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                            </li>
                                            <?php
                                        }else{
                                            ?>
                                            <li class="page-item "><a class="page-link" href="pages.php?page=inbox&p=<?=$i?>"><?=$i?></a></li>
                                            <?php
                                        }
                                    }
                                    }
                                    ?>

                                    <?php if($islemListele->rowCount() <=0) { } else { ?>
                                        <?php if($Sayfa != $Sayfa_Sayisi){?>
                                            <li class="page-item"><a class="page-link" href="pages.php?page=inbox&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                            <li class="page-item"><a class="page-link" href="pages.php?page=inbox&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
