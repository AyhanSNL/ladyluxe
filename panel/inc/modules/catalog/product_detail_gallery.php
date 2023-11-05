<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'gallery';

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

$galeri = $db->prepare("select * from urun_galeri where urun_id=:urun_id order by sira asc ");
$galeri->execute(array(
        'urun_id' => $row['id'],
));

if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE urun_galeri SET sira = '$count' WHERE id = '$idler2'");
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

    $galeriSor = $db->prepare("select * from urun_galeri where id=:id and urun_id=:urun_id ");
    $galeriSor->execute(array(
            'id' => $_GET['item_id'],
            'urun_id' => $_GET['productID'],
    ));
    if($galeriSor->rowCount()>'0'  ) {
        $galeriDelete = $galeriSor->fetch(PDO::FETCH_ASSOC);

        unlink('../images/product/'.$galeriDelete['gorsel'].'');

        $silmeislem = $db->prepare("DELETE from urun_galeri WHERE id=:id");
        $sil = $silmeislem->execute(array(
        'id' => $_GET['item_id']
        ));
        if ($sil) {
            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_gallery&productID='.$_GET['productID'].'');
        }else {
        echo 'veritabanı hatası';
        }

    }else{
        header('Location:'.$ayar['site_url'].'404');
    }


}else{
   header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_gallery&productID='.$_GET['productID'].'');
}
}
?>
<link rel="stylesheet" href="plugins/dropzone/dropzone.css" />
<style>
    .dropzone {
        min-height: 150px;
        border:3px dashed rgba(0, 0, 0, 0.3);
        background: #fff;
        padding: 20px 20px;
    }
</style>
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
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form action="post.php?process=catalog_post&status=product_gallery&productID=<?=$row['id']?>" class="dropzone" id="dropzoneFrom">
                                                                    <div class="dz-message" data-dz-message>
                                                                            <span>
                                                                                <i class="fa fa-cloud-download-alt" style="font-size: 40px ;"></i><br>
                                                                               <?=$diller['adminpanel-form-text-1144']?><br>
                                                                                <div class="btn btn-primary mt-3"><i class="fa fa-folder-open"></i> <?=$diller['adminpanel-form-text-1145']?></div>
                                                                            </span>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <?php if($galeri->rowCount()>'0'  ) {?>
                                                                <div class="col-md-12 mt-4">
                                                                    <div class="row d-flex  justify-content-start flex-wrap row_position">
                                                                        <?php foreach ($galeri as $galRow) {?>
                                                                            <div class="product_gallery_box" id="<?php echo $galRow['id'] ?>">
                                                                                <div>
                                                                                    <div class="d-block mb-2 w-100">
                                                                                        <a href="" data-href="pages.php?page=product_detail_gallery&productID=<?=$row['id']?>&item_delete=yes&item_id=<?=$galRow['id']?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger"><i class="fa fa-times"></i></a>
                                                                                    </div>
                                                                                    <img src="../images/product/<?=$galRow['gorsel']?>" >
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="plugins/dropzone/dropzone.js"></script>
<script>

    $(document).ready(function(){

        Dropzone.options.dropzoneFrom = {
            autoProcessQueue: true,

            acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
            init: function(){
                this.on("complete", function(){
                    if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
                    {

                    }
                    list_image();
                });
            },

        };



        function list_image()
        {
            $.ajax({
                type: "POST",
                success: function(){
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 0);
                }
            });
        }



    });
</script>


