<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'variant';

$urunBilgisi = $db->prepare("select * from urun where id=:id and dil=:dil ");
$urunBilgisi->execute(array(
    'id' => $_GET['productID'],
    'dil' => $_SESSION['dil'],
));

if($urunBilgisi->rowCount()>'0' ) {
    $row = $urunBilgisi->fetch(PDO::FETCH_ASSOC);
    $sayfaSorgu = $db->prepare("select * from urun_detay where id='1' ");
    $sayfaSorgu->execute();
    $urunDetay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=products');
    exit();
}

$addedUser = $row['ekleyen'];

$yoneticiBilgiCek = $db->prepare("select random_id from yonetici where user_adi=:user_adi ");
$yoneticiBilgiCek->execute(array(
    'user_adi' => $row['ekleyen'],
));
$useradi = $yoneticiBilgiCek->fetch(PDO::FETCH_ASSOC);

if($yoneticiBilgiCek->rowCount()>'0'  ) {
    $addedUser = '<a href="pages.php?page=admin_edit&no='.$useradi['random_id'].'" target="_blank">'.$row['ekleyen'].'</a>';
}else{
    $addedUser = $row['ekleyen'];
}

$urunAddInfo = $diller['adminpanel-form-text-1601'];
$urunAddInfo  = $urunAddInfo;
$eski   = array('{tarih}','{user}');
$yeni   = array(date_tr('j F Y, H:i', ''.$row['tarih'].''),$addedUser);
$urunAddInfo = str_replace($eski, $yeni, $urunAddInfo);

$satisCount = $row['satis_adet'];

$variantGroup = $db->prepare("select * from urun_varyant where durum=:durum order by sira asc ");
$variantGroup->execute(array(
    'durum' => '1',
));

$variantList = $db->prepare("select * from detay_varyant where urun_id=:urun_id group by baslik order by sira asc ");
$variantList->execute(array(
    'urun_id' => $row['id'],
));

if(isset($_GET['group_status']) ) {
    if ($yetki['demo'] != '1') {

        if($_GET['group_status'] == 'delete'  ) {
            $VarSorgu = $db->prepare("select * from detay_varyant where varyant_id=:varyant_id and urun_id=:urun_id ");
            $VarSorgu->execute(array(
                'varyant_id' => $_GET['group_id'],
                'urun_id' => $_GET['productID']
            ));
            if($VarSorgu->rowCount()>'0'  ) {
                $varSRow = $VarSorgu->fetch(PDO::FETCH_ASSOC);

                $silmeislem = $db->prepare("DELETE from detay_varyant WHERE id=:id");
                $sil = $silmeislem->execute(array(
                    'id' => $varSRow['id']
                ));
                if ($sil) {

                    $varOzellikSql = $db->prepare("select * from detay_varyant_ozellik WHERE varyant_id=:varyant_id and urun_id=:urun_id");
                    $varOzellikSql->execute(array(
                                  'varyant_id' => $_GET['group_id'],
                                   'urun_id' => $_GET['productID']
                    ));

                    if($varOzellikSql->rowCount()>'0'  ) {
                        foreach ($varOzellikSql as $varoz){
                            unlink('../i/variants/'.$varoz['gorsel'].'');
                            $silmeislem = $db->prepare("DELETE from detay_varyant_ozellik WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $varoz['id']
                            ));
                        }
                    }
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_GET['productID'].'&go=success');

                }else {
                    echo 'veritabanı hatası';
                }
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }

        if($_GET['group_status'] == 'variant_delete'  ) {
            $VarSorgu = $db->prepare("select * from detay_varyant_ozellik where id=:id ");
            $VarSorgu->execute(array(
                'id' => $_GET['item_id']
            ));
            if($VarSorgu->rowCount()>'0'  ) {
                $varoz = $VarSorgu->fetch(PDO::FETCH_ASSOC);

                /* Stok var ise oradan da kaldır */
                $stokKontrolet = $db->prepare("select * from detay_varyant_stok where urun_id=:urun_id ");
                $stokKontrolet->execute(array(
                    'urun_id' => $_GET['productID'],
                ));
                if($stokKontrolet->rowCount()>'0'  ) {
                 foreach ($stokKontrolet as $kon){
                     $kaynak = $kon['varyant'];
                     $kaynak  = $kaynak;
                     $eski   = ''.$varoz['id'].',';
                     $yeni   = '';
                     $kaynak = str_replace($eski, $yeni, $kaynak);
                     $guncelle = $db->prepare("UPDATE detay_varyant_stok SET
                             varyant=:varyant
                      WHERE id={$kon['id']}      
                     ");
                     $sonuc = $guncelle->execute(array(
                         'varyant' => $kaynak
                     ));
                 }
                }
                /*  <========SON=========>>> Stok var ise oradan da kaldır SON */

                unlink('../i/variants/'.$varoz['gorsel'].'');
                $silmeislem = $db->prepare("DELETE from detay_varyant_ozellik WHERE id=:id");
                $sil = $silmeislem->execute(array(
                'id' => $_GET['item_id']
                ));
                if ($sil) {
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_GET['productID'].'&go=success');
                }else {
                echo 'veritabanı hatası';
                }
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }

    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_GET['productID'].'');
    }
}

if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE detay_varyant SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }}



?>

<title><?=$row['baslik']?> <?=$diller['adminpanel-form-text-1799']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=products"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-3']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$row['baslik']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['katalog'] == '1' && $yetki['urun'] == '1') { ?>

            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body ">
                            <div class="new-buttonu-main-top mb-0  pb-2 ">
                                <div class="new-buttonu-main-left w-100">
                                    <a href="pages.php?page=products" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                        <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                    </a>
                                    <div style="font-size: 20px; font-weight: 600; width: 100%;  " class="d-flex align-items-center justify-content-between flex-wrap pt-2 pb-2">
                                        <div>
                                            <div>
                                                <?=$row['baslik']?>
                                                <a href="<?=$ayar['site_url']?><?=$row['seo_url']?>-P<?=$row['id']?>" target="_blank">
                                                    <i class="fa fa-external-link-alt"></i>
                                                </a>
                                            </div>
                                            <div style="font-size: 13px ; font-weight: 200; color: #666;" class="mt-2">
                                                <?=$urunAddInfo?>
                                            </div>
                                            <?php if($satisCount >'0'  ) {
                                                $satisKaynak = $diller['adminpanel-form-text-1602'];
                                                $satisKaynak  = $satisKaynak;
                                                $eski   = '{count}';
                                                $yeni   = '<strong style="font-weight: 600; color: #cc4f5d">' .$row['satis_adet'].'</strong>';
                                                $satisKaynak = str_replace($eski, $yeni, $satisKaynak);
                                                ?>
                                                <!-- Total Sale !-->
                                                <div style="font-size: 13px ; font-weight: 200; color: #999;" class="mt-2">
                                                    <?=$satisKaynak?>
                                                </div>
                                                <!--  <========SON=========>>> Total Sale SON !-->
                                            <?php }?>

                                        </div>
                                    </div>

                                </div>
                            </div>


                            <?php include 'inc/modules/catalog/product_tabs.php'; ?>


                            <div class="tab-content bg-white rounded-bottom border border-top-0">
                                <div class="tab-pane active p-3" id="one" role="tabpanel" >

                                    <div class="row" style="position: relative !important;">

                                        <?php include 'inc/modules/catalog/variant_stock.php'; ?>

                                        <div class="col-md-12">
                                            <form action="post.php?process=catalog_post&status=product_post" method="post" enctype="multipart/form-data" >
                                                <input type="hidden" name="tab" value="variant" >
                                                <input type="hidden" name="product_id" value="<?=$row['id']?>" >
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="border pt-3 pl-3 pr-3 rounded mb-3">
                                                            <div class="in-header-page-main">
                                                                <div class="in-header-page-text">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    <?=$diller['adminpanel-menu-text-7']?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 form-group">
                                                                    <label for="varyant_grup"><?=$diller['adminpanel-form-text-1809']?></label>
                                                                    <select name="varyant_grup" class="form-control selet2" required style="width: 100%">
                                                                        <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                                                                        <?php foreach ($variantGroup as $varGRow) {?>
                                                                            <option value="<?=$varGRow['id']?>"><?=$varGRow['baslik']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                                <div id="ajaxcall" style="display:none; width: 100%;  "></div>
                                                                <div class="col-md-12 form-group mb-0 border-top pt-3 pb-3 bg-light">
                                                                    <button class="btn  btn-success"  name="variant_add">
                                                                        <?=$diller['adminpanel-form-text-1810']?>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <style>
                                            .filter-stil-group-name{
                                                width: 200px;
                                                background-color: #f8f8f8;
                                                padding: 15px 10px;
                                                box-sizing: border-box;
                                                font-weight: 600;
                                                font-size: 14px ;
                                                text-align: center;
                                                border-right: 1px solid #EBEBEB;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                flex-wrap: wrap;
                                            }
                                            .filter-stil-features-name{
                                                flex:1;
                                                padding: 15px 10px;
                                                font-size: 14px ;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                flex-wrap: wrap;
                                            }
                                            .one-more-features{
                                                margin-bottom: 15px;
                                                border-bottom: 1px solid #EBEBEB;
                                                padding-bottom: 15px;
                                            }
                                            .one-more-features:last-child{
                                                margin-bottom: 0;
                                                border-bottom: 0;
                                                padding-bottom: 0;
                                            }
                                            @media (max-width: 768px) {
                                                .filter-stil-group-name{
                                                    width: 100% !important;
                                                    border-right: 0 !important;
                                                    border-bottom: 1px solid #EBEBEB;
                                                }
                                                .ozellik-div{
                                                    width: 100% !important;
                                                    margin-bottom: 10px;
                                                }
                                                .canini{
                                                    padding-bottom: 20px;
                                                    padding-left: 14px;
                                                }
                                                .canini li{
                                                    margin-top: 15px;
                                                }
                                            }
                                            .canini li{
                                                margin-bottom: 10px;
                                            }
                                            .canini li:last-child{
                                                margin-bottom: 0;
                                            }
                                        </style>
                                        <div class="col-md-12 row_position" id="scrollArea" style="position: relative !important; overflow: hidden">
                                            <?php foreach ($variantList as $listRow) {
                                                $degerListele = $db->prepare("select * from detay_varyant_ozellik where varyant_id=:varyant_id and urun_id=:urun_id order by id asc");
                                                $degerListele->execute(array(
                                                    'varyant_id' => $listRow['varyant_id'],
                                                    'urun_id' => $row['id'],
                                                ));
                                                ?>
                                                <div class="border rounded  d-flex  justify-content-start flex-wrap mb-3" id="<?php echo $listRow['id'] ?>" style="cursor:move; position: relative;">
                                                    <div class="filter-stil-group-name">
                                                        <div class="w-100">
                                                            <div class="w-100">
                                                                <?=$listRow['baslik']?>
                                                                <div class="btn btn-sm btn-outline-primary btn-block mb-2 mt-2 bg-white text-primary" style="font-weight: 500;">
                                                                 <?php if($listRow['tur'] == '1' ) {?>
                                                                 <?=$diller['adminpanel-form-text-1824']?>
                                                                 <?php }?>
                                                                 <?php if($listRow['tur'] == '2' ) {?>
                                                                     <?=$diller['adminpanel-form-text-1815']?>
                                                                 <?php }?>
                                                                 <?php if($listRow['tur'] == '3' ) {?>
                                                                     <?=$diller['adminpanel-form-text-1814']?>
                                                                 <?php }?>
                                                                 <?php if($listRow['tur'] == '4' ) {?>
                                                                     <?=$diller['adminpanel-form-text-1820']?>
                                                                 <?php }?>
                                                                </div>
                                                            </div>
                                                            <div class="w-100 mt-2">
                                                                <a href="" data-href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>&group_status=delete&group_id=<?=$listRow['varyant_id']?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger">
                                                                    <?=$diller['adminpanel-form-text-1823']?>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="filter-stil-features-name">
                                                        <?php if($degerListele->rowCount()<='0'  ) {?>
                                                        <div class="border border-danger p-3" style="background-color:#FFEEEB">
                                                          <i class="fa fa-exclamation-triangle"></i>  <?=$diller['adminpanel-form-text-1826']?>
                                                        </div>
                                                        <?php }?>
                                                            <?php foreach ($degerListele as $ozellikRow) {?>
                                                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap <?php if($degerListele->rowCount()>'1'  ) { ?>one-more-features<?php }?> ">
                                                                    <div class="ozellik-div">
                                                                        <?php if($listRow['tur'] == '3' && $ozellikRow['gorsel'] == !null) {?>
                                                                        <img src="../i/variants/<?=$ozellikRow['gorsel']?>" style="width: 30px">
                                                                        <?php }?>
                                                                        <i class="fa fa-caret-right"></i> <?=$ozellikRow['baslik']?>
                                                                        <?php if($ozellikRow['ek_fiyat'] >'0' ) {?>
                                                                        <span class="badge badge-success">
                                                                          + <?php echo number_format($ozellikRow['ek_fiyat'], 2); ?> <?=$Current_Money['sag_simge']?>
                                                                        </span>
                                                                        <?php }?>
                                                                    </div>
                                                                    <div>
                                                                        <a href="javascript:Void(0)" data-id="<?=$ozellikRow['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>">
                                                                            <i class="fa fa-edit" ></i>
                                                                        </a>
                                                                        <a href="" data-href="pages.php?page=product_detail_variant&productID=<?=$row['id']?>&group_status=variant_delete&item_id=<?=$ozellikRow['id']?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger">
                                                                            <?=$diller['adminpanel-text-160']?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php }?>

                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>



                                    </div>
                                </div>
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
<script type='text/javascript'>
    $(document).ready(function() {
        $('.selet2').select2();
    });
    $(function () {
        $('#stokAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#stokAcc').offset().top - 80 },
                500);
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("select[name='varyant_grup']").on('change',function(){
            var varyant_grup_id = $("select[name='varyant_grup']").val();
            jQuery.ajax({
                type: "GET",
                url: "masterpiece.php?page=variant_select&urun_id=<?=$_GET['productID']?>",
                data: "varyant_grup_id="+varyant_grup_id,
                success: function(response){
                    $("#ajaxcall").html(response);
                    $("#ajaxcall").show();
                }
            });
        });

    });
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>
<?php if($_SESSION['collepse_status'] == 'go_scroll'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('#scrollArea').offset().top
            }, 300);
            return false;
        });
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_GET['go'] == 'success'  ) {?>
    <script>
        $(function(){
            $('html, body').animate({
                scrollTop: $('#scrollArea').offset().top
            }, 300);
            return false;
        });
    </script>
<?php }?>


<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=variant_edit',
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
                url: 'masterpiece.php?page=variant_stock_edit',
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
            $('.row_position>div').each(function() {
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

<?php if($_SESSION['collepse_status'] == 'stokAcc' || $_GET['address'] == 'stock'  ) {?>
    <script>
        $('#stokAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#stokAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
