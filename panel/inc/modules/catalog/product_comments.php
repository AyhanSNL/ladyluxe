<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products_comments';
/* sonra incele modalını tamamla */
/* sonra butonlarla post işlemlerini yap ve toplu ürün işine geç */

if(isset($_GET['search']) || isset($_GET['userID']) || isset($_GET['productID']) || isset($_GET['limit']) || isset($_GET['commentStatus']) ) { 
 $getFilter = '&search='.$_GET['search'].'&userID='.$_GET['userID'].'&productID='.$_GET['productID'].'&limit='.$_GET['limit'].'&commentStatus='.$_GET['commentStatus'].'';
}


?>
<title><?=$diller['adminpanel-menu-text-8']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=products_comments"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-8']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['katalog'] == '1' && $yetki['urun_yorum'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $searchSql = htmlspecialchars($_GET['search']);
                $search = " where (isim like '%$searchSql%' or soyisim like '%$searchSql%' or baslik like '%$searchSql%' or yorum like '%$searchSql%') ";
            }else{
                $searchSql = htmlspecialchars($_GET['search']);
                $search = " where (isim like '%$searchSql%' or soyisim like '%$searchSql%' or baslik like '%$searchSql%' or yorum like '%$searchSql%') ";
            }

            if(isset($_GET['limit']) && $_GET['limit'] >'0'  ) {
                $limitGet = $_GET['limit'];
            }else{
                $limitGet = '30';
            }

            if(isset($_GET['userID']) && $_GET['userID'] >'0'  ) {
                $uyeID = htmlspecialchars($_GET['userID']);
                $userGet = "and uye_id='$uyeID'";
            }
            if(isset($_GET['productID']) && $_GET['productID'] >'0'  ) {
                $urunID = htmlspecialchars($_GET['productID']);
                $urunGet = "and urun_id='$urunID'";
            }
            if(isset($_GET['commentStatus'])  ) {
                if($_GET['commentStatus'] == '0'  ) {
                    $statusGet = "and onay='0'";
                }else{
                    $statusDurum = htmlspecialchars($_GET['commentStatus']);
                    $statusGet = "and onay='$statusDurum'";
                }
            }
            if($_GET['commentStatus'] == null  ) {
                $statusGet = null;
            }


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from urun_yorum  $search $userGet $urunGet $statusGet ");
            $ToplamVeri = $Say->rowCount();
            $Limit = $limitGet;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from urun_yorum  $search $userGet $urunGet $statusGet order by id DESC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);

            ?>
            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-8']?></h4>
                                <div>
                                    <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                                </div>
                            </div>
                            <div class="new-buttonu-main">
                                <div class="new-buttonu-main">
                                    <a href="javascript:Void(0)" data-id="1" class="btn  btn-primary duzenleAjax2" ><i class="fa fa-cog" ></i>  <?=$diller['adminpanel-form-text-1896']?></a>
                                    <a  class="btn btn-info text-white "  target="_blank" href="pages.php?page=theme_product_detail" > <?=$diller['adminpanel-text-182']?></a>
                                </div>
                            </div>
                        </div>
                        <!-- Fİlter !-->
                        <div class="w-100 mb-0  pt-2  d-flex align-items-center justify-content-start flex-wrap ">
                            <a class="btn btn-light  btn-block p-3 border" href="javascript:Void(0)" data-toggle="collapse" data-target="#filterAcc" aria-expanded="false" aria-controls="collapseForm" style="font-size: 15px; ">
                                <i class="fa fa-filter"></i>
                                <?=$diller['adminpanel-form-text-1292']?>
                            </a>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse  <?php if (isset($_GET['search'])) {?>show<?php } ?>" id="filterAcc" data-parent="#accordion">
                                <form method="GET" action="pages.php">
                                    <input type="hidden" name="page" value="products_comments" >
                                    <div class="p-3  border border-top-0" style="padding-bottom: 0!important;">
                                        <div class="row">
                                            <div class="col-md-2 form-group">
                                                <label for="limit" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1529']?>
                                                </label>
                                                <input type="text" name="limit" autocomplete="off" <?php if($_GET['limit'] >'0'  ) { ?>value="<?=$_GET['limit']?>" <?php }else{?>value="30"<?php } ?> id="limit"  class="form-control" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="search" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-text-154']?>
                                                </label>
                                                <input type="text" name="search" autocomplete="off" <?php if($_GET['search'] >'0'  ) { ?>value="<?=trim(strip_tags($_GET['search']))?>" <?php }?> id="search"  class="form-control" >
                                            </div>
                                            <div class="col-md-6  form-group">
                                                <label for=""><?=$diller['adminpanel-form-text-1197']?></label>
                                                <select class="user_select_form form-control col-md-12" name="userID" id="uye_id" style="width: 100%!important;" >
                                                </select>
                                            </div>
                                            <div class="col-md-6  form-group">
                                                <label for="productSelect"><?=$diller['adminpanel-form-text-1888']?></label>
                                                <select class="urunler_select form-control col-md-12" name="productID"   id="productSelect" style="width: 100%!important;"  >
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="commentStatus" class="d-flex align-items-center justify-content-start">
                                                    <?=$diller['adminpanel-form-text-1563']?>
                                                </label>
                                                <select name="commentStatus" class="form-control" id="commentStatus" >
                                                    <option value=""><?=$diller['adminpanel-form-text-1439']?></option>
                                                    <option value="0" <?php if($_GET['commentStatus'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-text-41']?></option>
                                                    <option value="1" <?php if($_GET['commentStatus'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-text-73']?></option>
                                                    <option value="2" <?php if($_GET['commentStatus'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1893']?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <button class="btn  m-1 btn-primary  " style="width: 150px; margin-left: 0px !important;"><?=$diller['adminpanel-form-text-1292']?></button>
                                                <?php if (isset($_GET['search']) ) {?>
                                                    <a class="btn  m-1 btn-danger text-white" href="pages.php?page=products_comments" style="width: 150px">
                                                        <i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1114']?>
                                                    </a>
                                                <?php } ?>
                                                <a class="btn  m-1 btn-secondary text-white" style="width: 90px;" data-toggle="collapse" data-target="#filterAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <?php if(isset($_GET['userID']) && $_GET['userID'] >'0' ) {
                            $uyeCeh = $db->prepare("select isim,soyisim from uyeler where id=:id ");
                            $uyeCeh->execute(array(
                                'id' => $_GET['userID'],
                            ));
                            ?>
                            <?php if($uyeCeh->rowCount()>'0'  ) {
                                $uyeRo = $uyeCeh->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div class="w-100  bg-secondary p-3 mb-0  text-white rounded mt-3" style="font-size: 16px ;">
                                    <i class="fa fa-user"></i>  <?=$uyeRo['isim']?> <?=$uyeRo['soyisim']?> <?=$diller['adminpanel-form-text-1891']?> (<?=$ToplamVeri?>)
                                </div>
                            <?php }?>
                        <?php }?>


                        <?php if(isset($_GET['productID']) && $_GET['productID'] >'0' ) {
                            $productRow = $db->prepare("select baslik from urun where id=:id ");
                            $productRow->execute(array(
                                'id' => $_GET['productID']
                            ));
                            ?>
                            <?php if($productRow->rowCount()>'0'  ) {
                                $proRow = $productRow->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <div class="w-100  bg-secondary p-3 mb-0  text-white rounded mt-3" style="font-size: 16px ;">
                                  <?=$proRow['baslik']?> <?=$diller['adminpanel-form-text-1892']?> (<?=$ToplamVeri?>)
                                </div>
                            <?php }?>
                        <?php }?>


                        <div class="w-100 mt-3">
                            <div class="w-100  mb-2 ">
                                <form method="post" action="post.php?process=catalog_post2&status=comment_process">
                                    <div class="table-responsive ">
                                        <table class="table table-hover mb-0  ">
                                            <thead class="thead-default">
                                            <tr>
                                                <th width="25">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input selectall" data-id="chec"  id="hepsiniSecCheckBox" >
                                                        <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                                    </div>
                                                </th>
                                                <th><?=$diller['adminpanel-form-text-1748']?></th>
                                                <th><?=$diller['adminpanel-form-text-1889']?></th>
                                                <th><?=$diller['adminpanel-form-text-1187']?></th>
                                                <th><?=$diller['adminpanel-form-text-1106']?></th>
                                                <th><?=$diller['adminpanel-form-text-1081']?></th>
                                                <th><?=$diller['adminpanel-form-text-62']?></th>
                                                <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($islemCek as $row) {
                                                $modulBilgi = $db->prepare("select baslik,id,seo_url from urun where id=:id ");
                                                $modulBilgi->execute(array(
                                                    'id' => $row['urun_id'],
                                                ));
                                                $urunRows = $modulBilgi->fetch(PDO::FETCH_ASSOC);
                                                $user = $db->prepare("select isim,soyisim,id from uyeler where id=:id ");
                                                $user->execute(array(
                                                        'id' => $row['uye_id']
                                                ));
                                                $usRow = $user->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                <tr >
                                                    <td>
                                                        <div class="custom-control custom-checkbox" >
                                                            <input type="checkbox" class="custom-control-input individual" data-id="chec"  id="checkSec-<?=$row['id']?>" name='processID[]' value="<?=$row['id']?>" >
                                                            <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                        </div>
                                                    </td>
                                                    <td style="min-width: 230px; " width="230" >
                                                        <?php if($modulBilgi->rowCount()>'0'  ) {?>
                                                            <a href="<?=$ayar['site_url']?><?=$urunRows['seo_url']?>-P<?=$urunRows['id']?>" target="_blank" class="btn btn-light btn-sm " style="font-weight: 500 !important;">
                                                                <i class="fa fa-external-link-alt"></i>
                                                                <?php echo mb_substr($urunRows['baslik'],0,25, 'UTF-8'); ?>
                                                                <?php if(strlen($urunRows['baslik']) > '25'  ) {?>
                                                                    ...
                                                                <?php }?>
                                                            </a>
                                                        <?php }else { ?>
                                                            <div class="btn btn-sm btn-outline-secondary">
                                                                <i class="fa fa-exclamation-triangle"></i>  <?=$diller['adminpanel-form-text-1123']?>
                                                            </div>
                                                        <?php }?>
                                                    </td>
                                                    <td style="min-width: 150px" >
                                                           <?php echo mb_substr($row['baslik'],0,20, 'UTF-8'); ?>
                                                        <?php if(strlen($row['baslik']) > '20'  ) {?>
                                                            ...
                                                        <?php }?>
                                                    </td>
                                                    <td width="100" style="min-width: 100px"  >
                                                        <?php if($row['yildiz'] == '1'  ) {?>
                                                            ★
                                                        <?php }?>
                                                        <?php if($row['yildiz'] == '2'  ) {?>
                                                            ★★
                                                        <?php }?>
                                                        <?php if($row['yildiz'] == '3'  ) {?>
                                                            ★★★
                                                        <?php }?>
                                                        <?php if($row['yildiz'] == '4'  ) {?>
                                                            ★★★★
                                                        <?php }?>
                                                        <?php if($row['yildiz'] == '5'  ) {?>
                                                            ★★★★★
                                                        <?php }?>
                                                    </td>
                                                    <td style="min-width: 150px">
                                                        <?php if($user->rowCount()>'0'  ) {?>
                                                            <a href="pages.php?page=user_detail&userID=<?=$usRow['id']?>" target="_blank">
                                                                <i class="fa fa-user"></i> <?=$usRow['isim']?> <?=$usRow['soyisim']?>
                                                            </a>
                                                        <?php }else { ?>
                                                            <?=$row['isim']?>
                                                            <?=$row['soyisim']?>
                                                        <?php }?>
                                                    </td>
                                                    <td style="min-width: 150px; font-size: 12px ;" >
                                                        <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                                    </td>
                                                    <td width="135" style="min-width: 135px">
                                                        <?php if($row['onay'] == '0' ) {?>
                                                            <a class="btn btn-sm btn-secondary " href="javascript:Void(0)">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                        <span class="sr-only">Loading...</span>
                                                                    </div>
                                                                    <?=$diller['adminpanel-form-text-1101']?>
                                                                </div>
                                                            </a>
                                                        <?php }?>
                                                        <?php if($row['onay'] == '1' ) {?>
                                                            <a class="btn btn-sm btn-success " href="javascript:Void(0)">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fa fa-check mr-2"></i>
                                                                    <?=$diller['adminpanel-form-text-1098']?>
                                                                </div>
                                                            </a>
                                                        <?php }?>
                                                        <?php if($row['onay'] == '2' ) {?>
                                                            <a class="btn btn-sm btn-danger " href="javascript:Void(0)">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fa fa-times mr-2"></i>
                                                                    <?=$diller['adminpanel-form-text-1589']?>
                                                                </div>
                                                            </a>
                                                        <?php }?>
                                                    </td>
                                                    <td class="text-right" style="min-width: 100px" width="100">
                                                        <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" ><i class="fa fa-eye" ></i>  <?=$diller['adminpanel-form-text-1108']?></a>
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
                                        <button class="btn btn-danger btn-sm pl-4 pr-4 " disabled="disabled" data-id="DisabledControl"  name="delete" value="1"><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                                        <button class="btn btn-success btn-sm pl-4 pr-4 " disabled="disabled" data-id="DisabledControl" name="active" value="1" ><?=$diller['adminpanel-text-347']?></button>
                                        <button class="btn btn-info  btn-sm pl-4 pr-4 " disabled="disabled" data-id="DisabledControl" name="noposition" value="1" ><?=$diller['adminpanel-text-363']?></button>
                                        <button class="btn btn-secondary btn-sm pl-4 pr-4 " disabled="disabled" data-id="DisabledControl" name="pasive" value="1" ><?=$diller['adminpanel-text-362']?></button>
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

                                <!---- Sayfalama Elementleri ================== !-->
                                <?php if($ToplamVeri > $Limit  ) {?>
                                    <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                        <?php if($Sayfa >= 1){?>
                                        <nav aria-label="Page navigation example " >
                                            <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                                <?php } ?>
                                                <?php if($Sayfa > 1){  ?>
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=products_comments<?=$getFilter?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=products_comments<?=$getFilter?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                <?php } ?>
                                                <?php
                                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                    if($i == $Sayfa){
                                                        ?>
                                                        <li class="page-item active " aria-current="page">
                                                            <a class="page-link" href="pages.php?page=products_comments<?=$getFilter?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item "><a class="page-link" href="pages.php?page=products_comments<?=$getFilter?>&p=<?=$i?>"><?=$i?></a></li>
                                                        <?php
                                                    }
                                                }
                                                }
                                                ?>

                                                <?php if($islemListele <=0) { } else { ?>
                                                    <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=products_comments<?=$getFilter?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=products_comments<?=$getFilter?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=product_comment_edit',
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
                url: 'masterpiece.php?page=product_comment_settings',
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
<!-- Sıralama Kodu !-->
<script type="text/javascript">
    $( ".row_position" ).sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.row_position>tr').each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    });
    function updateOrder(data) {
        $.ajax({
            url:"",
            type:'post',
            data:{position:data},
            success:function(){
                setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 1);
            }
        })
    }

</script>
<!-- Sıralama Kodu Son !-->
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
            placeholder: ' <?=$diller['adminpanel-form-text-1890']?>',
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
    $(document).ready(function() {
        $('.urunler_select').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-880']?>',
            ajax: {
                url: 'masterpiece.php?page=headermenu_product_select',
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