<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);



$aktarilanlar = $db->prepare("select id from hb_urun_bilgi where hb_aktarim=:hb_aktarim ");
$aktarilanlar->execute(array(
    'hb_aktarim' => '1'
));
$aktarilanSayisi = $aktarilanlar->rowCount();

if(isset($_GET['q'])  ) {
    if(strip_tags(htmlspecialchars($_GET['q'])) != $_GET['q']  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }
    $qGet = '&q='.$_GET['q'].'';
    $qSql = "and (hb_kod like '%$_GET[q]%' or hb_barkod like '%$_GET[q]%')";
}

if(isset($_GET['show']) && $_GET['show'] == 'open'  ) {
    $opGet = '&show=open';
    $opSql = "and hb_durumu = 'Incelenecek'";
}

if(isset($_GET['show']) && $_GET['show'] == 'close'  ) {
    $opGet = '&show=close';
    $opSql = "and hb_durumu = 'Satışa Hazır'";
}

$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from hb_urun_bilgi where hb_aktarim='1' $qSql  $opSql ");
$ToplamVeri = $Say->rowCount();
$Limit = 40;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from hb_urun_bilgi where hb_aktarim='1' $qSql $opSql order by id desc limit $Goster,$Limit");
$islemListeleFetch = $islemListele->fetchAll(PDO::FETCH_ASSOC);


if($_POST) {
    if($yetki['demo'] != '1') {
        if($_POST['merchant'] == 'process'  ) {
            if(isset($_POST['trash'])  ) {

                $IDler = $_POST['item_id'];
                foreach ($_POST['item_id'] as $a){
                    $silmeislem = $db->prepare("DELETE from hb_urun_bilgi WHERE id=:id");
                    $sil = $silmeislem->execute(array(
                    'id' => $a
                    ));
                }
                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_aktarilan_urunler');
                exit();
            }
            if(isset($_POST['inventory'])  ) {
                $IDler = $_POST['item_id'];
                foreach ($_POST['item_id'] as $a){
                    $sor = $db->prepare("select * from hb_urun_bilgi where id=:id and hb_durumu=:hb_durumu");
                    $sor->execute(array(
                            'id' => $a,
                            'hb_durumu' => 'Satışa Hazır'
                    ));
                    
                    if($sor->rowCount()>'0' ) {
                        $timestamp = date('Y-m-d G:i:s');
                     $row = $sor->fetch(PDO::FETCH_ASSOC);
                     $kaydet = $db->prepare("INSERT INTO hb_envanter SET
                            urun_id=:urun_id, 
                            hb_sku=:hb_sku,
                            barkod=:barkod,
                            hb_stokkodu=:hb_stokkodu,
                            hb_fiyat=:hb_fiyat,
                            tarih=:tarih,
                            hb_stok=:hb_stok,
                            hb_yayin=:hb_yayin
                     ");
                     $sonuc = $kaydet->execute(array(
                         'urun_id' => $row['urun_id'],
                         'hb_sku' => $row['hb_sku'],
                         'barkod' => $row['hb_barkod'],
                         'hb_stokkodu' => $row['hb_kod'],
                         'hb_fiyat' => $row['hb_fiyat'],
                         'tarih' => $timestamp,
                         'hb_stok' => $row['hb_stok'],
                         'hb_yayin' => '0'
                     ));
                     if($sonuc){
                        $silmeislem = $db->prepare("DELETE from hb_urun_bilgi WHERE id=:id");
                        $sil = $silmeislem->execute(array(
                        'id' => $a
                        ));
                     }
                    }else{
                    $_SESSION['main_alert'] = 'hb_envanter_go_sorun';
                    }
                }
                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_aktarilan_urunler');
                exit();
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=hb_aktarilan_urunler');
            exit();
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=hb_aktarilan_urunler');
        exit();
    }
}



?>
<title><?=$diller['pazaryeri-text-154']?> - <?=$panelayar['baslik']?></title>
<style>
    .urun_serch{
        width: 500px;
        margin:30px 0;
        position: relative;
    }
    .urun_serch input{
        border-radius: 0 !important;
    }
    .urun_serch button{
        border: 0;
        background-color: transparent;
        position: absolute;
        top:6px;
        right: 6px;
        font-size: 18px ;
        color: tomato;
    }
</style>
<style>
    .ust-secr{
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
</style>
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
                                <a href="pages.php?page=hb_process"><i class="fa fa-angle-right"></i> Hepsiburada <?=$diller['pazaryeri-text-100']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-154']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') {?>
            <?php if($pazar['hb_durum'] == '1' ) {?>
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
                                        <a href="pages.php?page=hb_process" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                            <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                        </a>
                                    </div>
                                    <div class="ust-pazar-header">
                                        <div class="ust-pazar-header-logo">
                                            <img src="assets/images/hb_logo.png">
                                        </div>
                                        <div class="ust-pazar-header-text">
                                            <?=$diller['pazaryeri-text-154']?> (<?=$aktarilanSayisi?>)
                                        </div>
                                        <?php if($ToplamVeri>'0'  ) {?>
                                            <div class="ust-pazar-header-link">
                                                <a href="javascript:Void(0)" data-id="posting" class="btn btn-danger text-white statu_control  mt-1 mb-1 mr-1" > <i class="fa fa-sync"></i> <?=$diller['pazaryeri-text-168']?></a>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <?php if($ToplamVeri>'0'  ) {?>
                                        <div class="w-100 border p-3 mb-2 up-arrow-2 rounded-0 alert alert-dismissible bg-light border text-dark">
                                            <div>
                                                <ul class="pazar-alert-ul">
                                                    <?=$diller['pazaryeri-text-169']?>
                                                </ul>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    <?php }?>
                                    <?php if($ToplamVeri<='0'  ) {?>
                                        <div class="rounded border p-xl-5 text-center" >
                                            <h5 style="font-weight: 100 !important;"><?=$diller['pazaryeri-text-60']?></h5>
                                                <?php if(isset($_GET['q']) || isset($_GET['show']) ) {?>
                                                    <a href="pages.php?page=hb_aktarilan_urunler" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                                                <?php }?>
                                        </div>
                                    <?php }else { ?>


                                        <div class="w-100">
                                            <div class="ust-secr">
                                                <div class="urun_serch">
                                                    <form action="pages.php" method="get">
                                                        <input type="hidden" name="page" value="hb_aktarilan_urunler">
                                                        <?php if(isset($_GET['show']) && $_GET['show'] == 'open'  ) {?>
                                                            <input type="hidden" name="show" value="open">
                                                        <?php }?>
                                                        <?php if(isset($_GET['show']) && $_GET['show'] == 'close'  ) {?>
                                                            <input type="hidden" name="show" value="close">
                                                        <?php }?>
                                                        <input type="text" name="q"  autocomplete="off" placeholder="<?=$diller['pazaryeri-text-170']?>" id="" required   class="form-control">
                                                        <button type="submit">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </form>
                                                    <?php if(isset($_GET['q'])  ) {?>
                                                        <div class="w-100">
                                                            <a href="pages.php?page=hb_aktarilan_urunler<?=$opGet?>" class="btn btn-sm btn-danger mt-3">
                                                                <?=$_GET['q']?> <i class="fa fa-times"></i>
                                                            </a>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                                <div class="btn-group mb-2" role="group" aria-label="Basic example">
                                                    <?php if(isset($_GET['show']) && $_GET['show'] == 'open'  ) { ?>
                                                        <a href="pages.php?page=hb_aktarilan_urunler<?=$qGet?>" class="btn btn-info   "><?=$diller['pazaryeri-text-179']?></a>
                                                    <?php }else{ ?>
                                                        <a href="pages.php?page=hb_aktarilan_urunler&show=open<?=$qGet?>"  class="btn btn-light border"><?=$diller['pazaryeri-text-179']?></a>
                                                    <?php }?>

                                                    <?php if(isset($_GET['show']) && $_GET['show'] == 'close'  ) { ?>
                                                        <a href="pages.php?page=hb_aktarilan_urunler<?=$qGet?>" class="btn btn-success  "><?=$diller['pazaryeri-text-180']?></a>
                                                    <?php }else{ ?>
                                                        <a href="pages.php?page=hb_aktarilan_urunler&show=close<?=$qGet?>" class="btn btn-light border "><?=$diller['pazaryeri-text-180']?></a>
                                                    <?php }?>
                                                </div>
                                            </div>

                                        </div>

                                        <form method="post" action="pages.php?page=hb_aktarilan_urunler">
                                            <input type="hidden" name="merchant" value="process">
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
                                                        <th class="text-center"><?=$diller['adminpanel-form-text-1302']?></th>
                                                        <th><?=$diller['adminpanel-form-text-940']?></th>
                                                        <th class="text-center"><?=$diller['pazaryeri-text-174']?></th>
                                                        <th class="text-center">HB - Barcode</th>
                                                        <th><?=$diller['pazaryeri-text-183']?></th>
                                                        <th  class="text-center" ></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody  >
                                                    <?php foreach ($islemListeleFetch as $row) {
                                                        $uruncek = $db->prepare("select baslik,id,stok,fiyat from urun where id=:id ");
                                                        $uruncek->execute(array(
                                                            'id' => $row['urun_id']
                                                        ));
                                                        $urun = $uruncek->fetch(PDO::FETCH_ASSOC);

                                                        ?>
                                                        <?php if($uruncek->rowCount()>'0'  ) {?>
                                                            <tr>
                                                                <td class="text-center" width="40" class="text-center" style="max-width: 40px !important; width: 40px !important;">
                                                                    <div class="custom-control custom-checkbox" >
                                                                        <input type="checkbox" data-id="chec"  data-id2="chec2" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='item_id[]' value="<?=$row['id']?>" >
                                                                        <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                                    </div>
                                                                </td>
                                                                <td style="min-width: 150px; text-align: center;" width="150"   >
                                                                   <?php if($row['hb_durumu'] == 'Incelenecek' ) {?>
                                                                   <div class="btn btn-sm btn-info">
                                                                       <div class="d-flex align-items-center">
                                                                           <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                               <span class="sr-only">Loading...</span>
                                                                           </div>
                                                                           <?=$row['hb_durumu']?>
                                                                       </div>
                                                                   </div>
                                                                   <?php }?>
                                                                    <?php if($row['hb_durumu'] == 'Satisa Hazir' || $row['hb_durumu'] == 'Satışa Hazır' ||$row['hb_durumu'] == 'Satışa hazır' ||$row['hb_durumu'] == 'Satışa Hazır' ) {?>
                                                                        <div class="btn btn-sm btn-success">
                                                                           <i class="fa fa-check"></i> <?=$row['hb_durumu']?>
                                                                        </div>
                                                                    <?php }?>
                                                                </td>
                                                                <td style="min-width: 350px" width="400"  >
                                                                    <?=$urun['baslik']?>
                                                                </td>
                                                                <td style="min-width: 150px; text-align: center;" width="150"   >
                                                                    <?=$row['hb_kod']?>
                                                                </td>
                                                                <td style="min-width: 150px; text-align: center; font-weight: 500;" width="150"   >
                                                                    <?=$row['hb_barkod']?>
                                                                </td>
                                                                <td style="min-width: 165px" width="165" >
                                                                    <?php echo date_tr('j F Y, H:i', ''.$row['hb_tarih'].''); ?>
                                                                </td>
                                                                <td style="min-width: 100px" width="100"  >
                                                                    <div class="w-100 d-flex align-items-center justify-content-center ">
                                                                        <a href="javascript:Void(0)" class="btn btn-sm btn-dark mr-1 log_book" data-id="<?=$row['id']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-173']?>"><i class="fa fa-bug"></i></a>
                                                                        <a href="pages.php?page=product_detail&productID=<?=$row['urun_id']?>" class="btn btn-sm btn-primary mr-1" target="_blank" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-115']?>"><i class="fa fa-eye" ></i></a>
                                                                        <a href="pages.php?page=product_detail_entegration_hb&productID=<?=$row['urun_id']?>" target="_blank" class="btn btn-sm btn-warning " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-13']?>"><i class="fas fa-store-alt"></i></a>
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
                                            <div class="w-100 pt-3 pb-3    " >
                                                <button id="waitButton" class="btn btn-danger btn-sm pl-4 pr-4 mb-2 "  disabled="disabled" data-id="DisabledControl" name="trash" > <?=$diller['pazaryeri-text-116']?></button>
                                                <button id="waitButton" class="btn btn-success btn-sm pl-4 pr-4 mb-2 "  disabled="disabled" data-id="DisabledControl" name="inventory" > <?=$diller['pazaryeri-text-171']?></button>
                                            </div>
                                            <div class="w-100 alert-warning text-dark  border border-warning p-2 rounded">
                                               <ul class="pazar-alert-ul" style="font-size: 12px ;">
                                                   <?=$diller['pazaryeri-text-172']?>
                                               </ul>
                                            </div>
                                        </form>
                                        <script>
                                                var checkboxes = $("input[data-id='chec']"),
                                        submitButt = $("button[data-id='DisabledControl']");

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
                                                        <li class="page-item "><a class="page-link " href="pages.php?page=hb_aktarilan_urunler<?=$qGet?><?=$opGet?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                        <li class="page-item "><a class="page-link " href="pages.php?page=hb_aktarilan_urunler&p=<?=$Sayfa - 1?><?=$qGet?><?=$opGet?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                    <?php } ?>
                                                    <?php
                                                    for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                        if($i == $Sayfa){
                                                            ?>
                                                            <li class="page-item active " aria-current="page">
                                                                <a class="page-link" href="pages.php?page=hb_aktarilan_urunler&p=<?=$i?><?=$qGet?><?=$opGet?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                            </li>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <li class="page-item "><a class="page-link" href="pages.php?page=hb_aktarilan_urunler&p=<?=$i?><?=$qGet?><?=$opGet?>"><?=$i?></a></li>
                                                            <?php
                                                        }
                                                    }
                                                    }
                                                    ?>

                                                    <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                        <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                            <li class="page-item"><a class="page-link" href="pages.php?page=hb_aktarilan_urunler&p=<?=$Sayfa + 1?><?=$qGet?><?=$opGet?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                            <li class="page-item"><a class="page-link" href="pages.php?page=hb_aktarilan_urunler&p=<?=$Sayfa_Sayisi?><?=$qGet?><?=$opGet?>"><?=$diller['sayfalama-son']?></a></li>
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
                        <h6><?=$diller['pazaryeri-text-151']?></h6>
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


<script>
        $(document).ready(function(){

        $('.log_book').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_log_popup',
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

        $('.statu_control').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=hb_statu_popup',
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