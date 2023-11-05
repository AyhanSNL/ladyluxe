<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);

$GETID = htmlspecialchars(strip_tags($_GET['process_id']));

$islemKontrolu = $db->prepare("select * from n11_islem where id=:id ");
$islemKontrolu->execute(array(
    'id' => $GETID,
));
$islemRows = $islemKontrolu->fetch(PDO::FETCH_ASSOC);

if($islemKontrolu->rowCount()<='0'  ) {
 header('Location:'.$ayar['site_url'].'404');
 exit();
}

if(isset($_GET['processget']) && $_GET['processget'] == 'log'  ) {
    $sorguGet = "n11_log>'0'";
    $GETALL = "&processget=log";
}else{
    $sorguGet = "n11_aktarim = '1' and n11_kod >'0' ";
    $GETALL = null;
}

if(isset($_GET['p'])) {
$PAGEALL = '&p='.$_GET['p'].'';
}else{
    $PAGEALL = null;
}


$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from urun where $sorguGet and iliskili_kat='$islemRows[kat_id]' ");
$ToplamVeri = $Say->rowCount();
$Limit = 30;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from urun where $sorguGet  and iliskili_kat='$islemRows[kat_id]' order by id desc limit $Goster,$Limit");
$islemListeleFetch = $islemListele->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['merchant'])  ) {
    if ($yetki['demo'] != '1') {
        if($_GET['merchant'] == 'stockupdate'  ) {
            include "inc/modules/entegration/pazar/n11_api.php";
            $stokUrunListesi = $db->prepare("select * from urun where n11_aktarim = '1' and n11_kod >'0' and iliskili_kat='$islemRows[kat_id]' ");
            $stokUrunListesi->execute();
            foreach ($stokUrunListesi as $stokrow){
                $n11kod = $stokrow['n11_kod'];
                $urunStokCekSorgu = $n11->GetProductBySellerCode('' . $n11kod . '');
                $stoksayisicek= $urunStokCekSorgu->product->stockItems->stockItem->quantity;
                $guncelle = $db->prepare("UPDATE n11_urun SET
                            n11_stok=:n11_stok
                            WHERE urun_id={$stokrow['id']}
                            ");
                $sonuc = $guncelle->execute(array(
                    'n11_stok' => $stoksayisicek
                ));
            }
            header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process_products&process_id='.$_GET['process_id'].''.$PAGEALL.'');
            exit();
        }

        if($_GET['merchant'] == 'itemdelete'  ) {
            include "inc/modules/entegration/pazar/n11_api.php";
            if($_POST && $_POST['item_id']) {
                foreach ($_POST['item_id'] as $item){
                    $urunCekDelete = $db->prepare("select id,n11_kod from urun where id=:id ");
                    $urunCekDelete->execute(array(
                        'id' => $item
                    ));
                    if($urunCekDelete->rowCount()>'0'  ) {
                        $itemRow = $urunCekDelete->fetch(PDO::FETCH_ASSOC);
                        $n11kod = $itemRow['n11_kod'];
                        $deleteProductBySeller = $n11->DeleteProductBySellerCode(''.$n11kod.'');
                        $silmeislem = $db->prepare("DELETE from n11_urun WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $itemRow['id']
                        ));
                        $guncelle = $db->prepare("UPDATE urun SET
                          n11_aktarim=:n11_aktarim,
                          n11_log=:n11_log,
                          n11_kod=:n11_kod
                         WHERE id={$itemRow['id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'n11_aktarim' => '0',
                            'n11_log' => '0',
                            'n11_kod' => '0'
                        ));
                    }
                }
                header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process_products&process_id='.$_GET['process_id'].''.$PAGEALL.'');
                exit();
            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process_products&process_id='.$_GET['process_id'].''.$PAGEALL.'');
                exit();
            }
        }


    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process_products&process_id='.$_GET['process_id'].''.$PAGEALL.'');
        exit();
    }
}

?>
<title><?=$diller['pazaryeri-text-42']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-86']?></a>
                                <a href="pages.php?page=n11_process"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-42']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$islemRows['baslik']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-48']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') {?>
            <?php if($pazar['n11_durum'] == '1' ) {?>
                <div class="row">
                    <!-- Contents !-->
                    <style>
                        .ust-pazar-header{
                            width: 100%;
                            display: flex;
                            justify-content: flex-start;
                            flex-wrap:wrap ;
                            margin-bottom: 20px;
                        }
                        .ust-pazar-header-logo{
                            width: 185px;
                            display: flex;
                            align-items: center;
                            justify-content: flex-start;
                            border-right: 2px solid #EBEBEB;
                            margin-right: 30px;
                        }
                        .ust-pazar-header-text{
                            width: auto;
                            font-size: 17px ;
                            font-weight: 600;
                            color: #000;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .ust-pazar-header-link{
                            margin-left: auto;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        .pazar-alert-ul{
                            margin-bottom: 0;
                            margin-top: 10px;
                            font-size: 14px ;
                        }
                        .pazar-alert-ul li{
                            margin-bottom: 10px;
                        }

                        @media screen and (max-width: 768px) and (min-width: 0)  {
                            .ust-pazar-header-logo{
                                width: 100%;
                                border-right:0;
                                margin-right: 0;
                                justify-content: center;
                                margin-bottom: 10px;
                            }
                            .ust-pazar-header-text{
                                text-align: center;
                                width: 100%;
                                margin-bottom: 10px;
                            }
                            .ust-pazar-header-link{
                                margin-left: 0;
                                width: 100%;
                                text-align: center;
                                display: block;
                            }
                            .ust-pazar-header-link a{
                                display: block !important;
                            }
                            .pazar-alert-ul{
                                margin-bottom: 0;
                                margin-top: 10px;
                                font-size: 14px ;
                                padding:15px;
                                width: 100%;
                            }
                            .pazar-alert-ul li{
                                margin-bottom: 10px;
                            }
                        }

                    </style>
                    <div class="col-md-12" >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card p-3">
                                    <div class="border-bottom pb-1 mb-3">
                                        <a href="pages.php?page=n11_process" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                            <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                        </a>
                                    </div>
                                    <div class="ust-pazar-header">
                                        <div class="ust-pazar-header-logo">
                                            <img src="assets/images/n11_logo.png">
                                        </div>
                                        <div class="ust-pazar-header-text">
                                            <?=$islemRows['baslik']?> - <?=$diller['pazaryeri-text-48']?> (<?=$ToplamVeri?>)
                                        </div>
                                        <?php if(!isset($_GET['processget'])  ) {?>
                                            <div class="ust-pazar-header-link">
                                                <a  class="btn btn-primary text-white yeni_islem" data-id="<?=$GETID?>" ><i class="fas fa-sync "></i> <?=$diller['pazaryeri-text-59']?></a>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <div class="w-100 mb-2 border-bottom pb-2 pt-2 border-top ">
                                        <?php if(isset($_GET['processget']) && $_GET['processget'] == 'log'  ) {?>
                                            <a href="pages.php?page=n11_process_products&process_id=<?=$GETID?>" class="btn btn-danger ">
                                              <i class="fa fa-times"></i>  <?=$diller['pazaryeri-text-64']?> (<?=$diller['adminpanel-form-text-1114']?>)
                                            </a>
                                        <?php }else { ?>
                                            <a href="pages.php?page=n11_process_products&process_id=<?=$GETID?>&processget=log" class="btn btn-danger ">
                                                <?=$diller['pazaryeri-text-64']?>
                                            </a>
                                            <?php if($ToplamVeri >'0'  ) {?>
                                                <a id="waitButton" href="pages.php?page=n11_process_products&process_id=<?=$GETID?>&merchant=stockupdate" class="btn btn-dark " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-66']?>">
                                                    <?=$diller['pazaryeri-text-65']?>
                                                </a>
                                            <?php }?>
                                        <?php }?>
                                    </div>
                                    <?php if($ToplamVeri<='0'  ) {?>
                                        <div class="rounded border p-xl-5 text-center" >
                                            <h5 style="font-weight: 100 !important;"><?=$diller['pazaryeri-text-60']?></h5>
                                        </div>
                                    <?php }else { ?>
                                        <form method="post" action="pages.php?page=n11_process_products&process_id=<?=$GETID?>&merchant=itemdelete">
                                        <div class="table-responsive ">
                                            <table class="table table-bordered table-hover mb-0  ">
                                                <thead class="thead-default">
                                                <tr>
                                                    <th width="40" class="text-center" style="max-width: 40px !important; width: 40px !important;">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" data-id="chec" class="custom-control-input selectall"  id="hepsiniSecCheckBox"   >
                                                            <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                                        </div>
                                                    </th>
                                                    <th><?=$diller['adminpanel-form-text-989']?></th>
                                                    <th style="font-size: 11px ;"><?=$diller['pazaryeri-text-61']?></th>
                                                    <th style="font-size: 11px ;"><?=$diller['pazaryeri-text-62']?></th>
                                                    <th style="font-size: 11px ; text-align: center;"><?=$diller['pazaryeri-text-63']?></th>
                                                    <th><?=$diller['pazaryeri-text-4']?></th>
                                                    <th><?=$diller['adminpanel-form-text-1356']?></th>
                                                    <th  class="text-center" ></th>
                                                </tr>
                                                </thead>
                                                <tbody  >
                                                <?php foreach ($islemListeleFetch as $row) {
                                                    $katAdi = $row['n11_kat_isim'];
                                                    $n11UrunuCek = $db->prepare("select * from n11_urun where urun_id=:urun_id ");
                                                    $n11UrunuCek->execute(array(
                                                            'urun_id' => $row['id'],
                                                    ));
                                                    $n11row = $n11UrunuCek->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <tr>
                                                        <td class="text-center" width="40" class="text-center" style="max-width: 40px !important; width: 40px !important;">
                                                            <div class="custom-control custom-checkbox" >
                                                                <input type="checkbox" data-id="chec" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='item_id[]' value="<?=$row['id']?>" >
                                                                <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                            </div>
                                                        </td>
                                                        <td style="min-width: 290px" width="290"  >
                                                            <?=$row['baslik']?>
                                                            <?php if(isset($_GET['processget']) && $_GET['processget'] == 'log' && $row['n11_log'] > '0'  ) {?>
                                                                <div class="bg-danger text-white  p-2 rounded mt-2" >
                                                                    <div class="mb-2" style="font-size: 11px ;">
                                                                       <i class="fa fa-info-circle"></i> <?=$diller['pazaryeri-text-30']?> :
                                                                    </div>
                                                                    <div >
                                                                        <?php
                                                                        $jsonCevir = json_decode($row['n11_log']);
                                                                        $logmesaj  = $jsonCevir->result->errorMessage;
                                                                        $eski   = array('shipmentTemplate','product altmış saniye boyunca guncellenemez');
                                                                        $yeni   = array('Teslimat Şablonu',''.$diller['pazaryeri-text-38'].'');
                                                                        $logmesaj = str_replace($eski, $yeni, $logmesaj);

                                                                        echo $logmesaj;
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td style="min-width: 125px" width="125"  >
                                                      <?=$row['n11_kod']?>
                                                        </td>
                                                        <td style="min-width: 90px" width="90"  >
                                                           <?php echo number_format($n11row['n11_fiyat'], 2); ?>
                                                        </td>
                                                        <td style="min-width: 110px; text-align: center;" width="110"  >
                                                           <?=$n11row['n11_stok']?>
                                                        </td>
                                                        <td style="min-width: 290px; font-weight: 500;" class="text-primary" width="290" >
                                                         <?=$katAdi?>
                                                        </td>
                                                        <td style="min-width: 165px"  >
                                                            <?php echo date_tr('j F Y, H:i', ''.$row['n11_tarih'].''); ?>
                                                        </td>
                                                        <td style="min-width: 100px" width="100"  >
                                                            <div class="w-100 d-flex align-items-center justify-content-center ">
                                                                <a href="pages.php?page=product_detail&productID=<?=$row['id']?>" class="btn btn-sm btn-primary mr-1" target="_blank" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-115']?>"><i class="fa fa-eye" ></i></a>
                                                                <a href="pages.php?page=product_detail_entegration&productID=<?=$row['id']?>" target="_blank" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-13']?>"><i class="fas fa-store-alt"></i></a>
                                                            </div>
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
                                    <?php if($ToplamVeri > '0' && !isset($_GET['processget'])) {?>
                                        <div class="w-100 pt-3 pb-3 border-bottom   " >
                                            <button id="waitButton" class="btn btn-danger btn-sm pl-4 pr-4 " disabled="disabled" name="deleteMulti" ><i class="fa fa-trash"></i> <?=$diller['pazaryeri-text-67']?></button>
                                        </div>
                                        </form>
                                        <script>
                                            var checkboxes = $("input[data-id='chec']"),
                                                submitButt = $("button[name='deleteMulti']");

                                            checkboxes.click(function() {
                                                submitButt.attr("disabled", !checkboxes.is(":checked"));
                                            });
                                        </script>
                                    <?php }?>
                                        <?php if($ToplamVeri > $Limit  ) {?>
                                            <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light border-top  ">
                                                <?php if($Sayfa >= 1){?>
                                                <nav aria-label="Page navigation example " >
                                                    <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                                        <?php } ?>
                                                        <?php if($Sayfa > 1){  ?>
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=n11_process_products&process_id=<?=$GETID?><?=$GETALL?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=n11_process_products&process_id=<?=$GETID?><?=$GETALL?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                        <?php } ?>
                                                        <?php
                                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                            if($i == $Sayfa){
                                                                ?>
                                                                <li class="page-item active " aria-current="page">
                                                                    <a class="page-link" href="pages.php?page=n11_process_products&process_id=<?=$GETID?><?=$GETALL?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                                </li>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <li class="page-item "><a class="page-link" href="pages.php?page=n11_process_products&process_id=<?=$GETID?><?=$GETALL?>&p=<?=$i?>"><?=$i?></a></li>
                                                                <?php
                                                            }
                                                        }
                                                        }
                                                        ?>

                                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=n11_process_products&process_id=<?=$GETID?><?=$GETALL?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=n11_process_products&process_id=<?=$GETID?><?=$GETALL?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                    </div>
                    <!--  <========SON=========>>> Contents SON !-->


                </div>
            <?php }else { ?>
                <div class="card p-xl-5">
                    <div class="col-md-12 p-3 text-center">
                        <h3><?=$diller['adminpanel-text-136']?></h3>
                        <h6><?=$diller['pazaryeri-text-15']?></h6>
                    </div>
                </div>
            <?php }?>
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
<script type='text/javascript'>
    $(document).ready(function(){

        $('.yeni_islem').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=n11_topluguncelle_modal',
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