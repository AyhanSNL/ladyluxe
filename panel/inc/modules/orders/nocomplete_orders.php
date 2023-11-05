<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'nocomplete_orders';


if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}


if (isset($_GET['limit']) || isset($_GET['userID']) ) {
    $filterPage = "&limit=$_GET[limit]&userID=$_GET[userID]";
}
/* Multidelete */
if($_GET['status'] == 'multidelete'  ) {
if ($yetki['demo'] != '1') {
    if($_POST) {
        $liste = $_POST['sil'];
        foreach ($liste as $idler){
            $sorgu = $db->prepare("select * from siparisler where id='$idler' ");
            $sorgu->execute();
            if($sorgu->rowCount()>'0'  ) {
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                /* Ürünleri de sil */
                $silmeislem = $db->prepare("DELETE from siparis_urunler WHERE siparis_id=:siparis_id");
                $sil = $silmeislem->execute(array(
                    'siparis_id' => $row['siparis_no']
                ));
                /*  <========SON=========>>> Ürünleri de sil SON */

                /* Varyant varsa sil */
                $silmeislem = $db->prepare("DELETE from siparis_varyant WHERE siparis_id=:siparis_id");
                $sil = $silmeislem->execute(array(
                    'siparis_id' => $row['siparis_no']
                ));
                /*  <========SON=========>>> Varyant varsa sil SON */

                $silmeislem = $db->prepare("DELETE from siparisler WHERE id=:id");
                $silmeislem->execute(array(
                    'id' => $idler
                ));

            }
        }
        header('Location:'.$ayar['panel_url'].'pages.php?page=nocomplete_orders');
    }
}else{
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=nocomplete_orders');
}

}
/*  <========SON=========>>> Multidelete SON */
/* Delete */
if(isset($_GET['status'])  ) {
    if($_GET['status']=='delete'  ) {
        if ($yetki['demo'] != '1') {
            if($_GET['no'] >'0' && $_GET['orderNo'] >'0'  ) {
                $silmeislem = $db->prepare("DELETE from siparisler WHERE id=:id");
                $sil = $silmeislem->execute(array(
                    'id' => $_GET['no']
                ));
                if ($sil) {

                    /* Ürünleri de sil */
                    $silmeislem = $db->prepare("DELETE from siparis_urunler WHERE siparis_id=:siparis_id");
                    $sil = $silmeislem->execute(array(
                        'siparis_id' => $_GET['orderNo']
                    ));
                    /*  <========SON=========>>> Ürünleri de sil SON */

                    /* Varyant varsa sil */
                    $silmeislem = $db->prepare("DELETE from siparis_varyant WHERE siparis_id=:siparis_id");
                    $sil = $silmeislem->execute(array(
                        'siparis_id' => $_GET['orderNo']
                    ));
                    /*  <========SON=========>>> Varyant varsa sil SON */


                    header('Location:'.$ayar['panel_url'].'pages.php?page=nocomplete_orders');
                }else {
                    echo 'veritabanı hatası';
                }
            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=nocomplete_orders');
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=nocomplete_orders');
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=nocomplete_orders');
    }
}
/*  <========SON=========>>> Delete SON */


?>
<title><?=$diller['adminpanel-menu-text-24']?> - <?=$panelayar['baslik']?></title>
<style>
    .ssa:before{
        display: none;
    }
    .kustom-checkbox label:before{
        margin-right: 10px;
    }
    .kustom-checkbox label {
       font-size: 13px ;
        font-weight: 200 !important;
    }
    .show > .dropdown-menu{
        z-index: 99999 !important;
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-16']?></a>
                                <a href="pages.php?page=nocomplete_orders"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-24']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['siparis'] == '1' && $yetki['siparis_diger'] == '1') {


            if(isset($_GET['limit']) && $_GET['limit'] >'0'  ) {
                $limitGet = $_GET['limit'];
            }else{
                $limitGet = '30';
            }



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from siparisler  where onay='0'   ");
            $ToplamVeri = $Say->rowCount();
            $Limit = $limitGet;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from siparisler where onay='0'  order by id desc limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/orders_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top mb-0 border-bottom pb-2 ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-24']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12  ">
                                <div class=" w-100 border p-3 rounded alert alert-dismissible alert-warning border-warning text-dark mb-0">
                                    <div style="font-size: 14px ; width: 95%">
                                       <?=$diller['adminpanel-form-text-1703']?>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="w-100 mt-3">
                            <form method="post" action="pages.php?page=nocomplete_orders&status=multidelete">
                            <div class="table-responsive ">
                                <table class="table table-bordered table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th class="text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                            </div>
                                        </th>
                                        <th><?=$diller['adminpanel-text-91']?></th>
                                        <th><?=$diller['adminpanel-form-text-1433']?></th>
                                        <th><?=$diller['adminpanel-form-text-1521']?></th>
                                        <th><?=$diller['adminpanel-form-text-1460']?></th>
                                        <th><?=$diller['adminpanel-text-242']?></th>
                                        <th class="text-center"><?=$diller['adminpanel-text-355']?></th>
                                        <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {
                                        ?>
                                        <tr>
                                            <th style="width: 15px" width="15" class="text-center">
                                                <div class="custom-control custom-checkbox" >
                                                    <input type="checkbox" class="custom-control-input individual "   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                    <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                </div>
                                            </th>
                                            <td width="125" style="min-width: 125px; font-weight: 500;" >
                                                #<?=$row['siparis_no']?>
                                            </td>
                                            <td style="min-width: 165px" width="165" >
                                              <?php if($row['uye_id'] == !null ) {
                                                  $uyeCek = $db->prepare("select isim,soyisim,id from uyeler where id=:id ");
                                                  $uyeCek->execute(array(
                                                          'id' => $row['uye_id'],
                                                  ));
                                                  $uye = $uyeCek->fetch(PDO::FETCH_ASSOC);
                                                  ?>
                                                  <a href="pages.php?page=user_detail&userID=<?=$uye['id']?>" target="_blank">
                                                      <?=$uye['isim']?> <?=$uye['soyisim']?>
                                                  </a>
                                              <?php }else { ?>
                                              <?=$row['isim']?> <?=$row['soyisim']?>
                                              <?php }?>
                                            </td>
                                            <td style="font-weight: 500; min-width: 125px" width="125" >
                                                <?php echo number_format($row['ara_tutar']+$row['kdv_tutar'], 2); ?>
                                                <?=$row['parabirimi']?>
                                            </td>
                                            <td style="font-weight: 300; min-width: 120px; " width="120">
                                                <?php echo date_tr('j F Y, H:i', ''.$row['siparis_tarih'].''); ?>
                                            </td>
                                            <td style="min-width: 140px; font-size: 12px ;" width="120">
                                                <?=$row['ipadres']?>
                                            </td>
                                            <td style="font-weight: 500; min-width: 90px; text-align: center;" width=90">
                                                <?php if($row['device']  == 'mobile' ) {?>
                                                    <div class="btn btn-sm btn-success">
                                                        <i class="fa fa-mobile-alt"></i> <?=$diller['adminpanel-form-text-1414']?>
                                                    </div>
                                                <?php }?>
                                                <?php if($row['device']  == 'desktop' ) {?>
                                                    <div class="btn btn-sm btn-primary">
                                                        <i class="fa fa-desktop"></i> <?=$diller['adminpanel-form-text-1415']?>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td class="text-center" width="50" style="min-width: 50px">
                                                <a href="" data-href="pages.php?page=nocomplete_orders&status=delete&no=<?=$row['id']?>&orderNo=<?=$row['siparis_no']?><?=$filterPage?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                            <?php }?>



                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=nocomplete_orders<?=$searchPage?><?=$filterPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=nocomplete_orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=nocomplete_orders<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=nocomplete_orders<?=$searchPage?><?=$filterPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=nocomplete_orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=nocomplete_orders<?=$searchPage?><?=$filterPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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

<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=nocomplete_orders_detail',
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
<script>
    $(function () {
        $('#filterAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#filterAcc').offset().top - 80 },
                500);
        });
    });
    $(document).ready(function() {
        $('.user_select_form').select2({
            maximumSelectionLength: 6,
            ajax: {
                url: 'masterpiece.php?page=user_select',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        q: data.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }

        });
    });
</script>