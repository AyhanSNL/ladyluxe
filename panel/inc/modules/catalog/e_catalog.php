<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'e_catalog';


if(isset($_GET['search'])  ) {
    if(strip_tags(htmlspecialchars($_GET['search'])) <= '0'  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
        exit();
    }
}

if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
        exit();
    }
}

if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $pageGet = '&p='.$_GET['p'].'';
}else{
    $pageGet = null;
}


?>
<title><?=$diller['adminpanel-menu-text-182']?> - <?=$panelayar['baslik']?></title>
<style>
    .nav-link{
        color: #000;
        transition-duration: 0.1s; transition-timing-function: linear;
        font-weight: 500;
        font-size: 14px;
        padding: 15px 25px;

    }
    .nav-tabs li:first-child{
        margin-left: 10px;
    }
    .saas:hover{
        background-color: #fff;
        color: #000;
    }
    @media (max-width: 768px) {
        .nav-link{
            color: #000;
            transition-duration: 0.1s; transition-timing-function: linear;
            font-weight: 500;
            font-size: 14px;
            padding: 10px;
        }
        .nav-tabs{
            padding: 15px;
        }
        .nav-tabs li:first-child{
            margin-left: 0;
        }
        .nav-link.active{
            border-color: #dee2e6 #dee2e6 #dee2e6 !important;
            border-radius: 6px !important;
        }
    }
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-2']?></a>
                                <a href="pages.php?page=e_catalog"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-182']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['katalog'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $serc = trim(strip_tags(htmlspecialchars($_GET['search'])));
             $search = " and (baslik like '%$serc%' ) ";
            }else{
                $search = null;
            }
            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from katalog where dil='$_SESSION[dil]'  $search");
            $ToplamVeri = $Say->rowCount();
            $Limit = 50;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from katalog where dil='$_SESSION[dil]' $search order by id DESC limit $Goster,$Limit");
            $islemListele = $islemListele->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-182']?></h4>
                                <div>
                                    <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                                </div>
                            </div>
                            <div class="new-buttonu-main">
                                <div class="new-buttonu-main">
                                    <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1877']?></a>
                                </div>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse" id="genelAcc" data-parent="#accordion">
                                <form action="post.php?process=catalog_post2&status=ecatalog_add" method="post" class="border mb-5 " enctype="multipart/form-data">
                                    <div class="text-center bg-white text-dark border-bottom ">
                                        <h5 style="margin-top: 0; padding-top: 10px;"> <?=$diller['adminpanel-form-text-1877']?></h5>
                                    </div>
                                    <div class="tab-content bg-white rounded-bottom">
                                        <div class="tab-pane active p-4" id="one" role="tabpanel" >
                                            <div class="row">
                                                <div class="form-group col-auto mb-4  ">
                                                    <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                        <div class="d-flex align-items-center justify-content-start">
                                                            <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                            <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                            <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-7">
                                                    <label for="baslik">* <?=$diller['adminpanel-form-text-1878']?></label>
                                                    <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-12 mt-2">
                                                    <div class="border bg-light p-3 rounded ">
                                                        <label  for="url" class="w-100">* <?=$diller['adminpanel-form-text-1882']?> <small>( PDF )</small></label>
                                                        <div class="input-group ">
                                                            <div class="custom-file ">
                                                                <input type="file" class="custom-file-input" id="url" name="url" required >
                                                                <label class="custom-file-label" for="url"  ><?=$diller['adminpanel-form-text-1145']?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--  <========SON=========>>> Tab Alanı SON !-->
                                    <div class=" border-top pt-3 bg-light pb-3">
                                        <div class="col-md-12 text-right">
                                            <button class="btn  btn-success " name="add"><?=$diller['adminpanel-form-text-53']?></button>
                                            <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=e_catalog" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="e_catalog" id="" required class="form-control">
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
                        <div class="w-100">

                            <div class="w-100  mb-2 ">
                                <form method="post" action="post.php?process=catalog_post2&status=ecatalog_multidelete">
                                    <div class="w-100 alert-warning border border-warning text-dark p-3 mb-1 d-flex align-items-center">
                                        <i class="ti-help-alt mr-2 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1295']?>"></i>
                                        <?=$diller['adminpanel-form-text-1881']?>
                                    </div>
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0 table-bordered  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th width="40" class="text-center">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" data-id="chec" class="custom-control-input selectall"  id="hepsiniSecCheckBox"   >
                                                    <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                                </div>
                                            </th>
                                            <th><?=$diller['adminpanel-form-text-1878']?></th>
                                            <th></th>
                                            <th  class="text-center" width="70"><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody  class="row_position">
                                        <?php foreach ($islemListele as $row) { ?>
                                            <tr >
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox" >
                                                        <input type="checkbox" data-id="chec" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                        <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                    </div>
                                                </td>
                                                <td style="font-weight: 500; min-width: 150px">
                                                    <?=$row['baslik']?>
                                                </td>
                                                <td width="145" class="text-center">
                                                    <a class="btn btn-sm btn-primary " href="<?=$ayar['site_url']?>/i/e-catalog/<?=$row['url']?>" target="_blank">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-external-link-alt mr-2"></i> <?=$diller['adminpanel-form-text-1880']?>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="text-center" style="min-width: 70px">
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>"  class="btn btn-sm btn-primary duzenleAjax " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
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
                                    var checkboxes = $("input[data-id='chec']"),
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
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=e_catalog<?=$searchPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=e_catalog<?=$searchPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                <?php } ?>
                                                <?php
                                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                    if($i == $Sayfa){
                                                        ?>
                                                        <li class="page-item active " aria-current="page">
                                                            <a class="page-link" href="pages.php?page=e_catalog<?=$searchPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item "><a class="page-link" href="pages.php?page=e_catalog<?=$searchPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                        <?php
                                                    }
                                                }
                                                }
                                                ?>

                                                <?php if($islemListele <=0) { } else { ?>
                                                    <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=e_catalog<?=$searchPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=e_catalog<?=$searchPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=ecatalog_edit',
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
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

