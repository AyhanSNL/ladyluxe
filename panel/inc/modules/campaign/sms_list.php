<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'smslist';


if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if(isset($_GET['status_update'])  ) {
if ($yetki['demo'] != '1') {
 if($_GET['status_update'] == !null  ) {

     $statusCek = $db->prepare("select * from sms_numaralar where id=:id ");
     $statusCek->execute(array(
         'id' => $_GET['status_update']
     ));

     if($statusCek->rowCount()>'0'  ) {
         $st = $statusCek->fetch(PDO::FETCH_ASSOC);



         if($st['durum'] == '1' ) {
          $statusum = '0';
         }
         if($st['durum'] == '0' ) {
             $statusum = '1';
         }

         $guncelle = $db->prepare("UPDATE sms_numaralar SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
         $sonuc = $guncelle->execute(array(
             'durum' => $statusum
         ));
         if($sonuc){
             header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers'.$sayfa.'');
         }else{
         echo 'Veritabanı Hatası';
         }

     }else{
         header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
     }

 }else{
     header('Location:'.$ayar['panel_url'].'pages.php?page=sms_numbers');
 }
}}


?>
<title><?=$diller['adminpanel-menu-text-36']?> - <?=$panelayar['baslik']?></title>
<style>
    .ssa:before{
        display: none;
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-30']?></a>
                                <a href="pages.php?page=sms_numbers"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-36']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['kampanya'] == '1' && $yetki['sms_yonet'] == '1' ) {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "where (gsm like '%$_GET[search]%' or isim like '%$_GET[search]%' ) ";
            }else{
                $search = "where (gsm like '%$_GET[search]%' or isim like '%$_GET[search]%' ) ";

            }
            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from sms_numaralar $search");
            $ToplamVeri = $Say->rowCount();
            $Limit = 40;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from sms_numaralar $search  order by id ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/campaign_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top  pb-2 mb-0 ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-36']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1249']?></a>
                                <div class="dropdown">
                                    <a href="" class="btn btn-light border " type="button" style="font-size: 13px ; font-weight: 400;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right ssa border  " style="margin-top: 4px !important;">
                                        <a class="dropdown-item" href="pages.php?page=multi_sms"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-menu-text-37']?></a>
                                        <a class="dropdown-item" href="pages.php?page=sms_settings" target="_blank"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-menu-text-39']?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="accordion" class="accordion">
                        <div class="collapse " id="genelAcc" data-parent="#accordion">
                            <div class="w-100 border pl-3 pr-3 pt-3 mb-3">
                            <form action="post.php?process=sms_list_post&status=numbers_add" method="post" enctype="multipart/form-data">
                                <div class="row ">
                                    <div class="form-group col-md-12 text-center bg-white text-dark mt-n3 mb-3 border-bottom">
                                        <h5> <?=$diller['adminpanel-form-text-1249']?></h5>
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-center">
                                    <div class="form-group col-md-7 ">
                                        <label for="isim" class="font-weight-bold">* <?=$diller['adminpanel-text-92']?></label>
                                        <input type="text" id="isim" class="form-control" required name="isim" autocomplete="off"  />
                                    </div>
                                    <div class="form-group col-md-7 ">
                                        <label for="gsm" class="font-weight-bold">* <?=$diller['adminpanel-form-text-81']?></label>
                                        <input type="number" id="gsm" class="form-control" required name="gsm" autocomplete="off"  placeholder="5xxxxxxxxx" />
                                    </div>
                                </div>

                                <div class="row border-top pt-3 bg-light pb-3">
                                    <div class="col-md-12 text-right">
                                        <button class="btn  btn-success " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                        <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 mt-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=sms_numbers" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="sms_numbers" >
                                            <input type="text" name="search" class="form-control" placeholder="<?=$diller['adminpanel-text-154']?>"  aria-describedby="button-addon2" required autocomplete="off">
                                            <div class="input-group-append">
                                                <button class="btn btn-dark rounded-0" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Search Form SON !-->
                        <div class="new-buttonu-main-top  pb-2 mb-0 ">
                            <div class="new-buttonu-main">
                                <a  class="btn btn-light border border-grey text-dark "  data-toggle="collapse" data-target="#exportAcc" aria-expanded="false" aria-controls="collapseForm">
                                    <i class="fas fa-upload "></i>
                                    <?=$diller['adminpanel-form-text-1618']?>
                                </a>
                                <a  class="btn btn-light border border-grey text-dark "  href="pages.php?page=gsm_list_import">
                                    <i class="fas fa-download "></i>
                                    <?=$diller['adminpanel-form-text-1615']?>
                                </a>
                            </div>
                        </div>
                        <div id="accordion2" class="accordion">
                            <div class="collapse" id="exportAcc" data-parent="#accordion2">
                                <div class="w-100 border pl-3 pr-3 pt-3 mb-3">
                                    <form action="post.php?process=export_post&status=gsm_list_export" method="post" >
                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-white text-dark mt-n3 mb-3 border-bottom">
                                                <h5> <?=$diller['adminpanel-form-text-1618']?></h5>
                                            </div>
                                        </div>
                                        <div class="row align-items-center justify-content-center">
                                            <div  class="form-group col-md-4">
                                                <label for="sms_limit" class="font-weight-bold"><?=$diller['adminpanel-form-text-1616']?></label>
                                                <input type="number" id="sms_limit" class="form-control" autocomplete="off" required  name="sms_limit" />
                                            </div>
                                        </div>
                                        <div class="row align-items-center justify-content-center mb-3">
                                            <div class="col-md-4 d-flex align-items-center justify-content-start">
                                                <button class="btn  btn-success flex-grow-1 mr-1" name="exportXML"><?=$diller['adminpanel-form-text-1617']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#exportAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="w-100">
                            <form method="post" action="post.php?process=sms_list_post&status=numbers_multidelete">
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th width="25">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                            </div>
                                        </th>
                                        <th><?=$diller['adminpanel-text-92']?></th>
                                        <th><?=$diller['adminpanel-form-text-81']?></th>
                                        <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  >
                                    <?php foreach ($islemCek as $row) {?>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox" >
                                                    <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                    <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                </div>
                                            </th>
                                            <td style="font-weight: 500; min-width: 150px">
                                                <?=$row['isim']?>
                                            </td>
                                            <td >
                                             <i class="ion ion-ios-phone-portrait"></i> <?=$row['gsm']?>
                                            </td>
                                            <td class="text-right" style="min-width: 100px">
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=sms_list_post&status=numbers_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                    <div class="w-100 pt-3 pb-3 border-bottom border-top  " >
                                        <button class="btn btn-danger btn-sm rounded-0 shadow-lg pl-4 pr-4 " type="submit" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                                    </div>
                                    </form>
                                <?php }?>





                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=sms_numbers<?=$searchPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=sms_numbers<?=$searchPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=sms_numbers<?=$searchPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=sms_numbers<?=$searchPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=sms_numbers<?=$searchPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=sms_numbers<?=$searchPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=sms_list_edit',
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
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
    $(function () {
        $('#exportAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#exportAcc').offset().top - 80 },
                500);
        });
    });
    $(document).ready(function() {
        $('.icon_select2').select2();
    });
</script>
