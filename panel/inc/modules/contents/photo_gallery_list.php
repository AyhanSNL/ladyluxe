<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'photo';

$galeriKat = $db->prepare("select * from galeri_kat where id=:id ");
$galeriKat->execute(array(
        'id' => $_GET['parent'],
));
$albumRow = $galeriKat->fetch(PDO::FETCH_ASSOC);

if($galeriKat->rowCount()<='0'  ) {
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=photo_gallery');
    exit();
}

if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE galeri_resim SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
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
<title><?=$albumRow['baslik']?> <?=$diller['adminpanel-menu-text-59']?> - <?=$panelayar['baslik']?></title>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box  bg-white card mb-0 pl-3" >
                    <div class="row align-items-center" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-67']?></a>
                                <a href="pages.php?page=photo_gallery"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-59']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$albumRow['baslik']?> <?=$diller['adminpanel-form-text-1143']?></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['galeri'] == '1' ) {



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from galeri_resim where kat_id='$_GET[parent]' ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 50;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from galeri_resim where kat_id='$_GET[parent]'  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);



            ?>
            <div class="row">

                    <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="w-100">
                                <a href="pages.php?page=photo_gallery" class="btn btn-outline-dark btn-sm mb-2 d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                            </div>
                            <div class="new-buttonu-main-left bg-light w-100 p-3 rounded  border">
                                <h6> <?=$diller['adminpanel-menu-text-59']?> <i class="fa fa-caret-right"></i></h6>
                                <h5><?=$albumRow['baslik']?> <?=$diller['adminpanel-form-text-1143']?></h5>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                        </div>
                        <div class="mt-2 mb-3 ">
                            <form action="post.php?process=photo_gallery_post&status=photo_add&parent=<?=$_GET['parent']?>" class="dropzone" id="dropzoneFrom">
                                <div class="dz-message" data-dz-message>
                                    <span>
                                        <i class="fa fa-cloud-download-alt" style="font-size: 40px ;"></i><br>
                                       <?=$diller['adminpanel-form-text-1144']?><br>
                                        <div class="btn btn-primary mt-3"><i class="fa fa-folder-open"></i> <?=$diller['adminpanel-form-text-1145']?></div>
                                    </span>
                                </div>
                            </form>
                        </div>

                        <form method="post" action="post.php?process=photo_gallery_post&status=photo_multidelete&parent=<?=$_GET['parent']?>">
                        <div class="w-100">

                            <?php if($ToplamVeri>'0'  ) {?>
                                <div class="d-flex align-items-center justify-content-start mb-3">
                                    <div id="selectall" style="cursor:pointer;" class="btn btn-primary btn-sm ">
                                        <?=$diller['adminpanel-form-text-937']?>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="row row_position">
                                <?php foreach ($islemCek as $row) {?>
                                    <div class=" mb-4 <?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-3 <?php }else{ ?>col-md-2<?php } ?>" id="<?php echo $row['id'] ?>" style="cursor: move">
                                        <div class=" bg-white border">
                                                <div class="text-center mb-1">
                                                    <div class="kustom-checkbox">
                                                        <input type="checkbox" class="individual" id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>">
                                                        <label for="checkSec-<?=$row['id']?>"></label>
                                                    </div>
                                                </div>
                                               <div class="d-flex align-items-center justify-content-center w-100 p-2" >
                                                   <img src="../images/gallery/<?=$row['gorsel']?>" class="img-fluid border p-1 " style="height: 100px"  >
                                               </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <?php if($ToplamVeri > '0') {?>
                            <div class="w-100 pt-3 pb-3 border-bottom border-top mt-2  " >
                                <button class="btn btn-danger btn-sm rounded-0 shadow-lg pl-4 pr-4 " type="submit" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                            </div>
                            </form>
                        <?php }?>
                        <?php if($ToplamVeri<='0' ) {?>
                            <div class="w-100  p-3 border bg-light ">
                                <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                            </div>
                        <?php }?>
                        <!---- Sayfalama Elementleri ================== !-->
                        <?php if($ToplamVeri > $Limit  ) {?>
                            <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light border-top  ">
                                <?php if($Sayfa >= 1){?>
                                <nav aria-label="Page navigation example " >
                                    <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                        <?php } ?>
                                        <?php if($Sayfa > 1){  ?>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=photo_gallery_list&parent=<?=$_GET['parent']?>"><?=$diller['sayfalama-ilk']?></a></li>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=photo_gallery_list&parent=<?=$_GET['parent']?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                        <?php } ?>
                                        <?php
                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                            if($i == $Sayfa){
                                                ?>
                                                <li class="page-item active " aria-current="page">
                                                    <a class="page-link" href="pages.php?page=photo_gallery_list&parent=<?=$_GET['parent']?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                <li class="page-item "><a class="page-link" href="pages.php?page=photo_gallery_list&parent=<?=$_GET['parent']?>&p=<?=$i?>"><?=$i?></a></li>
                                                <?php
                                            }
                                        }
                                        }
                                        ?>

                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=photo_gallery_list&parent=<?=$_GET['parent']?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=photo_gallery_list&parent=<?=$_GET['parent']?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url:"post.php?process=photo_gallery_post&status=photo_add&parent=<?=$_GET['parent']?>",
                success: function(){
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 0);
                }
            });
        }



    });
</script>



