<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'product_import';
$ID = htmlspecialchars($_GET['id']);
$dosyaSql = $db->prepare("select * from urun_import where id=:id ");
$dosyaSql->execute(array(
    'id' => $ID,
));
$row = $dosyaSql->fetch(PDO::FETCH_ASSOC);

$urunBirTane = $db->prepare("select * from urun where xml_id=:xml_id order by id desc limit 1 ");
$urunBirTane->execute(array(
    'xml_id' => $ID
));
$urunDil = $urunBirTane->fetch(PDO::FETCH_ASSOC);

$dilGetir = $db->prepare("select * from dil where kisa_ad='$urunDil[dil]' ");
$dilGetir->execute();
$dilRow = $dilGetir->fetch(PDO::FETCH_ASSOC);
$urunDiliGetir = $dilRow['baslik'];

$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from urun where xml_id='$ID' and dil='$_SESSION[dil]' ");
$ToplamVeri = $Say->rowCount();
$Limit = 35;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from urun where xml_id='$ID' and dil='$_SESSION[dil]' order by id DESC limit $Goster,$Limit");
$islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);
if($ToplamVeri<='0'  ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
    exit();
}
if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if(isset($_GET['status_update'])  ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['status_update'] == !null) {

            $statusCek = $db->prepare("select * from urun where id=:id ");
            $statusCek->execute(array(
                'id' => $_GET['status_update']
            ));

            if ($statusCek->rowCount() > '0') {
                $st = $statusCek->fetch(PDO::FETCH_ASSOC);


                if ($st['durum'] == '1') {
                    $statusum = '0';
                }
                if ($st['durum'] == '0') {
                    $statusum = '1';
                }

                $guncelle = $db->prepare("UPDATE urun SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
                $sonuc = $guncelle->execute(array(
                    'durum' => $statusum
                ));
                if ($sonuc) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_import_data&id='.$ID.''.$sayfa.'');
                } else {
                    echo 'Veritabanı Hatası';
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_import_data&id='.$ID.''.$sayfa.'');
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_import_data&id='.$ID.''.$sayfa.'');
        }
    }else{
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_import_data&id='.$ID.''.$sayfa.'');
    }
}
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
                                <a href="pages.php?page=product_import"><i
                                            class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-87'] ?> (XML)</a>
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
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_urun'] == '1') { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3 mb-3">
                    <div>
                        <a href="pages.php?page=product_import" class="btn btn-outline-dark  mb-2 btn-sm  " >
                            <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                        </a>
                    </div>
                    <?php if( $urunDil['dil'] != $_SESSION['dil'] ) {?>
                        <div class="w-100 bg-primary text-white p-3 rounded" style="font-size: 15px ;">
                            <?=$diller['adminpanel-form-text-2132']?>
                            <br>
                            <div class="mt-3">
                                <div class="bg-white rounded text-dark p-2 d-inline-block">
                                    <strong><?=$urunDiliGetir?></strong> <?=$diller['adminpanel-form-text-2133']?>
                                </div>
                            </div>
                        </div>
                    <?php }else { ?>

                    <div class="new-buttonu-main-top"">
                    <div class="new-buttonu-main-left">
                        <h5><?=$row['baslik']?> > <?=$diller['adminpanel-form-text-2077']?></h5>
                        <div class="mb-2">
                            <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                        </div>
                    </div>
                </div>
                <form action="post.php?process=product_import_post&status=data_multidelete&id=<?=$ID?>" method="post">
                    <div class="table-responsive ">
                        <table class="table table-bordered table-hover mb-0  ">
                            <thead class="thead-default">
                            <tr>
                                <th width="40" class="text-center">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                        <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                    </div>
                                </th>
                                <th class="text-center"><?=$diller['adminpanel-form-text-1758']?></th>
                                <th><?=$diller['adminpanel-form-text-1748']?></th>
                                <th><?=$diller['adminpanel-form-text-1765']?></th>
                                <th class="text-center"><?=$diller['adminpanel-form-text-1767']?></th>
                                <th><?=$diller['adminpanel-form-text-1081']?></th>
                                <th class="text-center" style="font-size: 11px ;"><?=$diller['adminpanel-form-text-843']?></th>
                                <th></th>
                                <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                            </tr>
                            </thead>
                            <tbody  >
                            <?php foreach ($islemCek as $row) {
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="custom-control custom-checkbox" >
                                            <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                            <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                        </div>
                                    </td>
                                    <td width="110" style="min-width: 110px; font-weight: 500; text-align: center;" >
                                        <?=$row['urun_kod']?>
                                    </td>
                                    <td width="280" style="min-width: 280px">
                                        <a  target="_blank" href="<?=$ayar['site_url']?><?=$row['seo_url']?>-P<?=$row['id']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1690']?>"><i class="fa fa-external-link-alt"></i></a>
                                        <?=$row['baslik']?>
                                    </td>
                                    <td width="120" style="min-width: 120px; font-weight: 500;">
                                        <?php if($row['kdv'] == '0' ) {?>
                                            <?php echo number_format($row['fiyat'], 2); ?> <?=$Current_Money['sag_simge']?>
                                        <?php }?>
                                        <?php if($row['kdv'] == '1' ) {?>
                                            <!-- +KDV !-->
                                            <?php
                                            $kdvtutar= kdvhesapla($row['fiyat'],$row['kdv_oran']);
                                            ?>
                                            <?php echo number_format($row['fiyat']+$kdvtutar, 2); ?> <?=$Current_Money['sag_simge']?>
                                            <div style="font-size: 11px ;font-weight: 200;">
                                                (<?=$diller['adminpanel-form-text-1766']?>)
                                            </div>
                                            <!--  <========SON=========>>> +KDV SON !-->
                                        <?php }?>
                                        <?php if($row['kdv'] == '2' ) {?>
                                            <!-- KDV DAHİL !-->
                                            <?php echo number_format($row['fiyat'], 2); ?> <?=$Current_Money['sag_simge']?>
                                            <div style="font-size: 11px ;font-weight: 200;">
                                                (<?=$diller['adminpanel-form-text-1766']?>)
                                            </div>
                                            <!--  <========SON=========>>> KDV DAHİL !-->
                                        <?php }?>
                                    </td>
                                    <td width="80" style="min-width: 80px; text-align: center; font-weight: 600;" >
                                        <?=$row['stok']?>
                                    </td>
                                    <td width="155" style="min-width: 155px" >
                                        <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                    </td>
                                    <td width="100" style="min-width: 100px; text-align: center;">
                                        <?php if($row['durum'] == '0' ) {?>
                                            <a class="btn btn-sm btn-outline-danger " href="pages.php?page=product_import_data&id=<?=$ID?>&status_update=<?=$row['id']?><?=$sayfa?>">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-times mr-2"></i>
                                                    <?=$diller['adminpanel-form-text-68']?>
                                                </div>
                                            </a>
                                        <?php }?>
                                        <?php if($row['durum'] == '1' ) {?>
                                            <a class="btn btn-sm btn-success " href="pages.php?page=product_import_data&id=<?=$ID?>&status_update=<?=$row['id']?><?=$sayfa?>">
                                                <div class="d-flex align-items-center">
                                                    <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <?=$diller['adminpanel-form-text-67']?>
                                                </div>
                                            </a>
                                        <?php }?>
                                    </td>
                                    <td class="text-center" style="min-width: 100px" width="100">
                                        <?php if($row['gorunmez'] == '1' ) {?>
                                            <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-info mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1769']?>">
                                                <?=$diller['adminpanel-form-text-1768']?>
                                            </div>
                                        <?php }?>
                                        <?php if($row['anasayfa'] == '1' ) {?>
                                            <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-warning text-dark mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1777']?>">
                                                <?=$diller['adminpanel-form-text-1776']?>
                                            </div>
                                        <?php } ?>
                                        <?php if($row['yeni'] == '1' ) {?>
                                            <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-dark text-white mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1681']?>">
                                                <?=$diller['adminpanel-form-text-1682']?>
                                            </div>
                                        <?php } ?>
                                        <?php if($row['indirim'] == '1' ) {?>
                                            <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-pink mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1771']?>">
                                                <?=$diller['adminpanel-form-text-1770']?>
                                            </div>
                                        <?php } ?>
                                        <?php if($row['firsat'] == '1' ) {?>
                                            <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-success mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1773']?>">
                                                <?=$diller['adminpanel-form-text-1772']?>
                                            </div>
                                        <?php } ?>
                                        <?php if($row['hizli_kargo'] == '1' ) {?>
                                            <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-secondary mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1775']?>">
                                                <?=$diller['adminpanel-form-text-1774']?>
                                            </div>
                                        <?php } ?>
                                        <?php if($row['editor_secim'] == '1' ) {?>
                                            <div style="font-size: 11px ; padding:2px 5px" class="btn btn-sm btn-primary mt-1 mb-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1779']?>">
                                                <?=$diller['adminpanel-form-text-1778']?>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center" width="200" style="min-width: 200px">
                                        <a target="_blank" href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>" class="btn btn-sm btn-dark " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-menu-text-7']?>"><i class=" fa fa-sitemap " ></i></a>
                                        <a target="_blank" href="pages.php?page=product_detail_features&productID=<?=$row['id']?>" class="btn btn-sm btn-dark  " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1611']?>"><i class="fa fa-bars fa-fw" ></i></a>
                                        <a target="_blank" href="pages.php?page=product_detail_gallery&productID=<?=$row['id']?>" class="btn btn-sm btn-dark  " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1600']?>"><i class="fas fa-images"></i></a>
                                        <a target="_blank" href="pages.php?page=product_detail&productID=<?=$row['id']?>" class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-115']?>"><i class="fa fa-eye" ></i></a>
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
                    <?php if($ToplamVeri > '0') {?>
                    <div class="w-100 pt-3 pb-3 border-bottom   " >
                        <button class="btn btn-danger btn-sm pl-4 pr-4 " disabled="disabled" name="deleteMulti" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
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
                <!---- Sayfalama Elementleri ================== !-->
                <?php if($ToplamVeri > $Limit  ) {?>
                    <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                        <?php if($Sayfa >= 1){?>
                        <nav aria-label="Page navigation example " >
                            <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                <?php } ?>
                                <?php if($Sayfa > 1){  ?>
                                    <li class="page-item "><a class="page-link " href="pages.php?page=product_import_data&id=<?=$ID?>"><?=$diller['sayfalama-ilk']?></a></li>
                                    <li class="page-item "><a class="page-link " href="pages.php?page=product_import_data&id=<?=$ID?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                <?php } ?>
                                <?php
                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                    if($i == $Sayfa){
                                        ?>
                                        <li class="page-item active " aria-current="page">
                                            <a class="page-link" href="pages.php?page=product_import_data&id=<?=$ID?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                        </li>
                                        <?php
                                    }else{
                                        ?>
                                        <li class="page-item "><a class="page-link" href="pages.php?page=product_import_data&id=<?=$ID?>&p=<?=$i?>"><?=$i?></a></li>
                                        <?php
                                    }
                                }
                                }
                                ?>

                                <?php if($islemListele->rowCount() <=0) { } else { ?>
                                    <?php if($Sayfa != $Sayfa_Sayisi){?>
                                        <li class="page-item"><a class="page-link" href="pages.php?page=product_import_data&id=<?=$ID?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                        <li class="page-item"><a class="page-link" href="pages.php?page=product_import_data&id=<?=$ID?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
                                    <?php }} ?>
                                <?php if($Sayfa >= 1){?>
                            </ul>
                        </nav>
                    <?php } ?>
                    </div>
                <?php }?>
                <!---- Sayfalama Elementleri ================== !-->
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
