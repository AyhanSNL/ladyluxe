<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'n11process';

$pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
$pazarSql->execute(array(
    'id' => '1'
));
$pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);

$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->query("select * from n11_islem ");
$ToplamVeri = $Say->rowCount();
$Limit = 20;
$Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$islemListele = $db->query("select * from n11_islem order by id desc limit $Goster,$Limit");
$islemListeleFetch = $islemListele->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['process'])  ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['process'] == 'delete' && $_GET['process_id'] >'0') {

          $processSorgu = $db->prepare("select * from n11_islem where id=:id ");
          $processSorgu->execute(array(
                  'id' => $_GET['process_id']
          ));
          if($processSorgu->rowCount()>'0'  ) {
           $silmeislem = $db->prepare("DELETE from n11_islem WHERE id=:id");
           $sil = $silmeislem->execute(array(
           'id' => $_GET['process_id']
           ));
           if ($sil) {
               header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
               exit();
           }else {
               header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
               exit();
           }
          }else{
              header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
              exit();
          }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
            exit();
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['pazaryeri-text-42']?></a>
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
                    <?php include 'inc/modules/_helper/entegration_leftbar.php'; ?>
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
                            font-size: 20px ;
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
                                    <div class="ust-pazar-header">
                                        <div class="ust-pazar-header-logo">
                                            <img src="assets/images/n11_logo.png">
                                        </div>
                                        <div class="ust-pazar-header-text">
                                            <?=$diller['pazaryeri-text-42']?>
                                        </div>
                                        <div class="ust-pazar-header-link">
                                            <a  class="btn btn-success text-white yeni_islem" data-id="new_process" ><i class="fas fa-plus-circle "></i> <?=$diller['pazaryeri-text-43']?></a>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <div class="w-100 border p-3 mb-2 up-arrow-2 rounded-0 alert alert-dismissible bg-light border text-dark">
                                            <div>
                                                <ul class="pazar-alert-ul">
                                                    <?=$diller['pazaryeri-text-44']?>
                                                </ul>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                    <?php if($ToplamVeri<='0'  ) {?>
                                        <div class="rounded border p-xl-5 text-center">
                                            <h6><?=$diller['pazaryeri-text-45']?></h6>
                                        </div>
                                    <?php }else { ?>
                                        <div class="table-responsive ">
                                            <table class="table table-bordered table-hover mb-0  ">
                                                <thead class="thead-default">
                                                <tr>
                                                    <th><?=$diller['adminpanel-form-text-989']?></th>
                                                    <th><?=$diller['adminpanel-form-text-1362']?></th>
                                                        <th><?=$diller['pazaryeri-text-47']?></th>
                                                    <th><?=$diller['adminpanel-form-text-1356']?></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th  class="text-center" ></th>
                                                </tr>
                                                </thead>
                                                <tbody  >
                                                <?php foreach ($islemListeleFetch as $row) {
                                                    $katCek = $db->prepare("select baslik from urun_cat where id=:id ");
                                                    $katCek->execute(array(
                                                            'id' => $row['kat_id']
                                                    ));
                                                    if($katCek->rowCount()>'0'  ) {
                                                        $catrow = $katCek->fetch(PDO::FETCH_ASSOC);
                                                     $katAdi = $catrow['baslik'];
                                                    }else{
                                                        $katAdi = 'NaN';
                                                    }

                                                    /* Kuyruğa Ekle */
                                                    $kuyrukEkle = $db->prepare("select id from urun where iliskili_kat ='$row[kat_id]' and n11_izin='1' and n11_aktarim='0' and (NOT n11_ozellik < '0' and NOT n11_kat_id < '0')");
                                                    $kuyrukEkle->execute();
                                                    foreach ($kuyrukEkle as $kuy){
                                                        $guncelle = $db->prepare("UPDATE urun SET
                                                              n11_kuyruk=:n11_kuyruk  
                                                         WHERE id={$kuy['id']}      
                                                        ");
                                                        $sonuc = $guncelle->execute(array(
                                                            'n11_kuyruk' => '1'
                                                        ));
                                                    }
                                                    /*  <========SON=========>>> Kuyruğa Ekle SON */

                                                    $aktarilanlar = $db->prepare("select id from urun where iliskili_kat ='$row[kat_id]'and n11_kuyruk='1' and n11_izin='1' and n11_aktarim='0' and (NOT n11_ozellik = '0' and NOT n11_kat_id = '0' and NOT n11_kod >'0')");
                                                    $aktarilanlar->execute(array());
                                                    ?>
                                                    <tr>
                                                        <td style="min-width: 165px"  >
                                                            <?=$row['baslik']?>
                                                        </td>
                                                        <td style="min-width: 165px"  >
                                                           <?php if($row['islem'] == 'import' ) {?>
                                                           <?=$diller['pazaryeri-text-46']?>
                                                           <?php }?> 
                                                        </td>
                                                        <td style="min-width: 165px; font-weight: 500;" class="text-primary"  >
                                                            <?php if($row['islem'] == 'import' ) {?>
                                                                <?=$katAdi?>
                                                            <?php }else { ?>
                                                            <i class="fa fa-ban"></i>
                                                            <?php }?>
                                                        </td>
                                                        <td style="min-width: 165px"  >
                                                            <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                                        </td>
                                                        <td style="min-width: 165px">
                                                            <?php if($row['durum']  == '1' ) {?>
                                                                <a class="btn btn-sm btn-success  btn-block" href="pages.php?page=n11_process_products&process_id=<?=$row['id']?>">
                                                                    <?=$diller['pazaryeri-text-48']?>
                                                                </a>
                                                            <?php }else { ?>
                                                                <a class="btn btn-sm  flex-grow-1  btn-block" style="color: #E5E5E5; background-color: #BABABA">
                                                                  <i class="fa fa-ban"></i>  <?=$diller['pazaryeri-text-48']?>
                                                                </a>
                                                            <?php }?>
                                                        </td>
                                                        <td style="min-width: 250px" width="250"  >
                                                            <div class="w-100 d-flex align-items-center justify-content-between">
                                                                <?php if($aktarilanlar->rowCount()<='0'  ) {?>
                                                                     <a class="btn btn-sm  flex-grow-1 mr-1" style="color: #E5E5E5; background-color: #BABABA" data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-53']?>">
                                                                        <i class="fa fa-ban"></i>
                                                                        <?=$diller['pazaryeri-text-26']?>
                                                                    </a>
                                                                <?php }else { ?>
                                                                    <a href="" data-href="pages.php?page=n11_process_post&process=import&process_id=<?=$row['id']?>" data-toggle="modal" data-target="#n11-import" class="btn btn-sm btn-primary  flex-grow-1 mr-1">
                                                                        <i class="fa fa-play"></i>
                                                                        <?=$diller['pazaryeri-text-26']?> (<?=$aktarilanlar->rowCount()?> <?=$diller['pazaryeri-text-58']?>)
                                                                    </a>
                                                                <?php }?>
                                                            </div>
                                                        </td>
                                                        <td style="min-width: 100px" width="100"  >
                                                            <div class="w-100 d-flex align-items-center justify-content-center ">
                                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax mr-1" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>">
                                                                    <i class="fa fa-eye" ></i>
                                                                </a>
                                                                <a href="" data-href="pages.php?page=n11_process&process=delete&process_id=<?=$row['id']?>" data-toggle="modal" data-target="#n11-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                        <?php if($ToplamVeri > $Limit  ) {?>
                                            <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light border-top  ">
                                                <?php if($Sayfa >= 1){?>
                                                <nav aria-label="Page navigation example " >
                                                    <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                                        <?php } ?>
                                                        <?php if($Sayfa > 1){  ?>
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=n11_process"><?=$diller['sayfalama-ilk']?></a></li>
                                                            <li class="page-item "><a class="page-link " href="pages.php?page=n11_process&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                        <?php } ?>
                                                        <?php
                                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                            if($i == $Sayfa){
                                                                ?>
                                                                <li class="page-item active " aria-current="page">
                                                                    <a class="page-link" href="pages.php?page=n11_process&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                                </li>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <li class="page-item "><a class="page-link" href="pages.php?page=n11_process&p=<?=$i?>"><?=$i?></a></li>
                                                                <?php
                                                            }
                                                        }
                                                        }
                                                        ?>

                                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=n11_process&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                                <li class="page-item"><a class="page-link" href="pages.php?page=n11_process&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=n11_toplu_islem_kaydi',
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

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=n11_toplu_islem_kaydi_edit',
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