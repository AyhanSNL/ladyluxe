<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);



$loglular = $db->prepare("select id from trendyol_urun_bilgi where ty_log != '0' and ty_aktarim=:ty_aktarim ");
$loglular->execute(array(
    'ty_aktarim' => '0'
));
$logsayi = $loglular->rowCount();


$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from trendyol_urun_bilgi where ty_log != '0' and ty_aktarim='0'  ");
$ToplamVeri = $Say->rowCount();
$Limit = 30;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from trendyol_urun_bilgi where ty_log != '0' and ty_aktarim='0'   order by id desc limit $Goster,$Limit");
$islemListeleFetch = $islemListele->fetchAll(PDO::FETCH_ASSOC);


if(isset($_GET['merchant'])  ) {
    if ($yetki['demo'] != '1') {
        if($_GET['merchant'] == 'process'  ) {

            if($_POST['item_id'] && $_POST) {
                foreach ($_POST['item_id'] as $item) {
                    $tybili = $db->prepare("select * from trendyol_urun_bilgi where id=:id ");
                    $tybili->execute(array(
                            'id' => $item,
                    ));
                    $tybilgi = $tybili->fetch(PDO::FETCH_ASSOC);

                    $urunceks = $db->prepare("select urun_kod,barkod from urun where id=:id ");
                    $urunceks->execute(array(
                            'id' => $tybilgi['urun_id']
                    ));
                    $urunrow = $urunceks->fetch(PDO::FETCH_ASSOC);

                    if($urunceks->rowCount()<= '0'  ) {
                        header('Location:'.$ayar['panel_url'].'pages.php?page=ty_rapor_urunler');
                        exit();
                    }

                    if($urunrow['barkod'] == !null ) {
                     $kod = $urunrow['barkod'];
                    }else{
                        $kod = $urunrow['urun_kod'];
                    }

                    $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                        ty_log=:ty_log,    
                        ty_aktarim=:ty_aktarim,
                        ty_kod=:ty_kod
                     WHERE id={$item}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'ty_log' => '0',
                        'ty_aktarim' => '1',
                        'ty_kod' => $kod
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=ty_rapor_urunler');
                        exit();
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                }
            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=ty_rapor_urunler');
                exit();
            }


        }

    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=ty_rapor_urunler');
        exit();
    }
}

?>
<title><?=$diller['pazaryeri-text-105']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=ty_process"><i class="fa fa-angle-right"></i> Trendyol <?=$diller['pazaryeri-text-100']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-105']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') {?>
            <?php if($pazar['ty_durum'] == '1' ) {?>
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
                                        <a href="pages.php?page=ty_process" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                            <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                        </a>
                                    </div>
                                    <div class="ust-pazar-header">
                                        <div class="ust-pazar-header-logo">
                                            <img src="assets/images/ty_logo.png">
                                        </div>
                                        <div class="ust-pazar-header-text">
                                            <?=$diller['pazaryeri-text-105']?> (<?=$logsayi?>)
                                        </div>
                                    </div>
                                    <?php if($ToplamVeri>'0'  ) {?>
                                        <div class="w-100 border p-3 mb-2 up-arrow-2 rounded-0 alert alert-dismissible bg-light border text-dark">
                                            <div>
                                                <ul class="pazar-alert-ul">
                                                    <?=$diller['pazaryeri-text-107']?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php }?>
                                    <?php if($ToplamVeri<='0'  ) {?>
                                        <div class="rounded border p-xl-5 text-center" >
                                            <h5 style="font-weight: 100 !important;"><?=$diller['pazaryeri-text-60']?></h5>
                                        </div>
                                    <?php }else { ?>
                                        <form method="post" action="pages.php?page=ty_rapor_urunler&merchant=process">
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
                                                    <th><?=$diller['adminpanel-form-text-940']?></th>
                                                    <th><?=$diller['pazaryeri-text-30']?></th>
                                                    <th><?=$diller['adminpanel-form-text-1356']?></th>
                                                    <th  class="text-center" ></th>
                                                </tr>
                                                </thead>
                                                <tbody  >
                                                <?php foreach ($islemListeleFetch as $row) {
                                                    $uruncek = $db->prepare("select baslik,id from urun where id=:id ");
                                                    $uruncek->execute(array(
                                                            'id' => $row['urun_id']
                                                    ));
                                                    $urun = $uruncek->fetch(PDO::FETCH_ASSOC);

                                                    ?>
                                                    <?php if($uruncek->rowCount()>'0'  ) {?>
                                                        <tr>
                                                            <td class="text-center" width="40" class="text-center" style="max-width: 40px !important; width: 40px !important;">
                                                                <div class="custom-control custom-checkbox" >
                                                                    <input type="checkbox" data-id="chec" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='item_id[]' value="<?=$row['id']?>" >
                                                                    <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                                </div>
                                                            </td>
                                                            <td style="min-width: 250px" width="250"  >
                                                                <?=$urun['baslik']?>
                                                            </td>
                                                            <td style="min-width: 400px"   >
                                                                <div class="bg-white p-2 border rounded">
                                                                    <?=$row['baslik']?>
                                                                    <?php
                                                                    $josns = json_decode($row['ty_log']);
                                                                    echo'<pre>';
                                                                    print_r($josns);
                                                                    echo'<pre>';
                                                                    if(!isset($josns[0])  ) {
                                                                        echo $row['ty_log'];
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td style="min-width: 165px"  >
                                                                <?php echo date_tr('j F Y, H:i', ''.$row['ty_tarih'].''); ?>
                                                            </td>
                                                            <td style="min-width: 100px" width="100"  >
                                                                <div class="w-100 d-flex align-items-center justify-content-center ">
                                                                    <a href="pages.php?page=product_detail&productID=<?=$row['urun_id']?>" class="btn btn-sm btn-primary mr-1" target="_blank" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-115']?>"><i class="fa fa-eye" ></i></a>
                                                                    <a href="pages.php?page=product_detail_entegration_ty&productID=<?=$row['urun_id']?>" target="_blank" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-13']?>"><i class="fas fa-store-alt"></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php }?>
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
                                                <button id="waitButton" class="btn btn-success btn-sm pl-4 pr-4 " disabled="disabled" name="aktarildi" ><i class="fa fa-check"></i> <?=$diller['pazaryeri-text-113']?></button>
                                            </div>
                                        </form>
                                        <script>
                                            var checkboxes = $("input[data-id='chec']"),
                                                submitButt = $("button[name='aktarildi']");

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
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=ty_rapor_urunler"><?=$diller['sayfalama-ilk']?></a></li>
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=ty_rapor_urunler&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                        <?php } ?>
                                                        <?php
                                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                            if($i == $Sayfa){
                                                                ?>
                                                                <li class="page-item active " aria-current="page">
                                                                    <a class="page-link" href="pages.php?page=ty_rapor_urunler&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                                </li>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <li class="page-item "><a class="page-link" href="pages.php?page=ty_rapor_urunler&p=<?=$i?>"><?=$i?></a></li>
                                                                <?php
                                                            }
                                                        }
                                                        }
                                                        ?>

                                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=ty_rapor_urunler&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=ty_rapor_urunler&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
