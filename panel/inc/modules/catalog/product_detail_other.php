<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'other';

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


$urunListe = $db->prepare("select * from urundetay_benzer_urun where detay_id=:detay_id order by sira asc ");
$urunListe->execute(array(
        'detay_id' => $row['id'],
));

if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE urundetay_benzer_urun SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}

if(isset($_GET['item_delete']) && $_GET['item_delete'] == 'yes') {
    if ($yetki['demo'] != '1') {

        $galeriSor = $db->prepare("select * from urundetay_benzer_urun where id=:id and detay_id=:detay_id ");
        $galeriSor->execute(array(
            'id' => $_GET['item_id'],
            'detay_id' => $_GET['productID'],
        ));
        if($galeriSor->rowCount()>'0'  ) {
            $galeriDelete = $galeriSor->fetch(PDO::FETCH_ASSOC);

            $silmeislem = $db->prepare("DELETE from urundetay_benzer_urun WHERE id=:id");
            $sil = $silmeislem->execute(array(
                'id' => $_GET['item_id']
            ));
            if ($sil) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_other&productID='.$_GET['productID'].'');
            }else {
                echo 'veritabanı hatası';
            }

        }else{
            header('Location:'.$ayar['site_url'].'404');
        }


    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_other&productID='.$_GET['productID'].'');
    }
}

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

                                    <div class="row">

                                        <div class="col-md-12">
                                            <form action="post.php?process=catalog_post&status=product_post" method="post" >
                                                <input type="hidden" name="tab" value="other" >
                                                <input type="hidden" name="product_id" value="<?=$row['id']?>" >
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="border p-3 rounded mb-3">
                                                            <div class="in-header-page-main">
                                                                <div class="in-header-page-text">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    <?=$diller['adminpanel-form-text-1692']?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12 form-group">
                                                                    <select class="urunler_select form-control col-md-12" name="urun_id[]" multiple  id="urun_id" style="width: 100%!important;"  >
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-12 form-group mb-0">
                                                                    <button class="btn  btn-success"  name="other_update">
                                                                        <?=$diller['adminpanel-form-text-1693']?>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                      <div class=" rounded d-flex justify-content-start flex-wrap row_position">
                                                          <?php foreach ($urunListe as $urunRow) {
                                                              $urunReal = $db->prepare("select baslik,id,gorsel from urun where id=:id ");
                                                              $urunReal->execute(array(
                                                                      'id' => $urunRow['urun_id'],
                                                              ));
                                                              ?>
                                                              <?php if($urunReal->rowCount()>'0'  ) {
                                                                  $realRow = $urunReal->fetch(PDO::FETCH_ASSOC);?>
                                                                  <div  class="boxes" id="<?php echo $urunRow['id'] ?>">
                                                                      <div class="d-block mb-2 w-100">
                                                                          <a href="" data-href="pages.php?page=product_detail_other&productID=<?=$row['id']?>&item_delete=yes&item_id=<?=$urunRow['id']?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                                                      </div>
                                                                      <div class="boxes_img" >
                                                                          <img src="../images/product/<?=$realRow['gorsel']?>" >
                                                                      </div>
                                                                      <div class="boxes_heading" style="font-size: 14px ; font-weight: 600; margin-top: 15px ; margin-bottom: 15px;">
                                                                          <?=$realRow['baslik']?>
                                                                      </div>
                                                                      <div style="margin-top: auto;">
                                                                          <a href="pages.php?page=product_detail&productID=<?=$urunRow['urun_id']?>" target="_blank" class="btn btn-primary btn-block btn-sm">
                                                                            <?=$diller['adminpanel-text-115']?>
                                                                          </a>
                                                                      </div>
                                                                  </div>
                                                              <?php }?>
                                                          <?php }?>
                                                      </div>
                                                    </div>


                                                </div>
                                            </form>
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
</script>


<script type='text/javascript'>
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


    <style>
        .alert-box {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            text-align: center;
            font-size: 16px ;
            position: absolute;
            top:50px;
            right: 10px;
            z-index: 9;

        }
        .warning-div {
            color: #fff;
            background-color: #cc4f5d;
            border-color: #cc4f5d;
            font-size: 12px;
            opacity: .9;
        }

    </style>

<?php if($_SESSION['adding_problem'] == 'problem'  ) {?>
    <div class="alert-box warning-div">
      <i class="fa fa-exclamation-triangle mr-2"></i>  <?=$diller['adminpanel-form-text-1694']?>
    </div>

    <script>
        $( "div.warning-div" ).fadeIn( 300 ).delay( 2500 ).fadeOut( 400 );
    </script>
    <?php
    unset($_SESSION['adding_problem']);
    ?>
<?php }?>



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