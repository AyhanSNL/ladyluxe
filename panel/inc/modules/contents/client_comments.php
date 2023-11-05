<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'com';

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE yorum SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}
if(isset($_GET['status_update']) ) {
    if ($yetki['demo'] != '1') {

        if(isset($_GET['status_update'])  ) {
            if ($_GET['status_update'] == !null) {

                $statusCek = $db->prepare("select * from yorum where id=:id ");
                $statusCek->execute(array(
                    'id' => $_GET['status_update']
                ));

                if ($statusCek->rowCount() > '0') {
                    $st = $statusCek->fetch(PDO::FETCH_ASSOC);


                    if ($st['durum'] == '1') {
                        $statusum = '0';
                    }
                    if ($st['durum'] == '0') {
                        $statusum = '1';
                    }

                    $guncelle = $db->prepare("UPDATE yorum SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $statusum
                    ));
                    if ($sonuc) {
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=client_comments' . $sayfa . '');
                    } else {
                        echo 'Veritabanı Hatası';
                    }

                } else {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=client_comments');
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=client_comments');
            }
        }


    }else{
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=client_comments');
    }
}
?>
<title><?=$diller['adminpanel-menu-text-66']?> - <?=$panelayar['baslik']?></title>
<link href="plugins/bootstrap-rating/bootstrap-rating.css" rel="stylesheet" type="text/css">

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-41']?></a>
                                <a href="pages.php?page=client_comments"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-66']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['icerik_diger'] == '1' ) {


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from yorum where dil='$_SESSION[dil]'");
            $ToplamVeri = $Say->rowCount();
            $Limit = 30;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from yorum where dil='$_SESSION[dil]'  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);



            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>
                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-66']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-info text-white  " href="pages.php?page=theme_client_comments"><?=$diller['adminpanel-form-text-838']?></a>
                                <a  class="btn btn-success text-white "   data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1183']?></a>
                            </div>
                        </div>


                        <div id="accordion" class="accordion">
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3 mt-3">
                                    <form action="post.php?process=client_comments_post&status=add" method="post" enctype="multipart/form-data" >
                                        <div class="row bg-light border-bottom  ">
                                            <div class="form-group col-md-3 mb-3 pt-3 ">
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
                                            <div class="form-group col-md-12 text-center bg-white text-dark  border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-form-text-1183']?></h5>
                                            </div>
                                        </div>
                                        <div class="row mt-3 ">
                                            <div class="form-group col-md-12 mb-4">
                                                <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  checked >
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                                <input type="number" autocomplete="off" min="1"  name="sira" id="sira"  required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-7">
                                                <label for="isim">* <?=$diller['adminpanel-form-text-1185']?></label>
                                                <input type="text" autocomplete="off"  name="isim" id="isim" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-5">
                                                <label for="pozisyon"><?=$diller['adminpanel-form-text-1188']?></label>
                                                <input type="text" autocomplete="off"  name="pozisyon" id="pozisyon"  class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="icerik">* <?=$diller['adminpanel-form-text-1113']?></label>
                                                <textarea name="icerik" id="icerik" class="form-control" rows="2" required></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="star_rate"><?=$diller['adminpanel-form-text-1187']?></label><br>
                                                <input type="hidden" name="star_rate" class="rating" data-filled="mdi mdi-star font-20 text-warning" data-empty="mdi mdi-star-outline font-20 text-muted"/>
                                            </div>
                                            <div class="form-group col-md-12 mb-3">
                                                <label  for="inputGroupFile01" class="w-100"><?=$diller['adminpanel-form-text-1186']?> (135x135)  <small>( png,  jpg, jpeg, gif, svg )</small></label>
                                                <div class="input-group ">
                                                    <div class="custom-file ">
                                                        <input type="file" class="custom-file-input " id="inputGroupFile01" name="gorsel" >
                                                        <label class="custom-file-label" for="inputGroupFile01"  ><?=$diller['adminpanel-form-text-106']?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="w-100 ">
                            <div class="w-100 p-2 bg-light  font-12 mb-4">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-text-171']?>
                            </div>
                            <div class="row row_position">
                                <?php foreach ($islemCek as $row) {?>
                                    <div class="col-md-6" id="<?php echo $row['id'] ?>" style="cursor: move">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                    <?php if($row['gorsel'] == 'no-image'  ) {?>
                                                        <img src="../images/comments/def_com.jpg" class="img-fluid border p-1" style="width: 135px; height: 135px; border-radius: 100px;" >
                                                    <?php }else { ?>
                                                        <img src="../images/comments/<?=$row['gorsel']?>" class="img-fluid border p-1" style="width: 135px; height: 135px; border-radius: 100px;" >
                                                    <?php }?>
                                                </div>
                                                <div class="text-center mb-3">
                                                    <?=$row['isim']?>
                                                </div>
                                                <div class="text-center mb-3">
                                                    <?=$row['pozisyon']?>
                                                </div>
                                                <div class="text-center mb-3">
                                                    <?php if($row['star_rate'] == '0' ) {?>
                                                       <div style="font-size: 18px ; color: #ccc;">
                                                           ★★★★★
                                                       </div>
                                                    <?php }?>
                                                    <?php if($row['star_rate'] == '1' ) {?>
                                                        <div style="font-size: 18px ; color: #ccc;">
                                                            <span style="color: #fdba45 ;">★</span>★★★★
                                                        </div>
                                                    <?php }?>
                                                     <?php if($row['star_rate'] == '2' ) {?>
                                                        <div style="font-size: 18px ; color: #ccc;">
                                                            <span style="color: #fdba45 ;">★★</span>★★★
                                                        </div>
                                                    <?php }?>
                                                     <?php if($row['star_rate'] == '3' ) {?>
                                                        <div style="font-size: 18px ; color: #ccc;">
                                                            <span style="color: #fdba45 ;">★★★</span>★★
                                                        </div>
                                                    <?php }?>
                                                        <?php if($row['star_rate'] == '4' ) {?>
                                                        <div style="font-size: 18px ; color: #ccc;">
                                                            <span style="color: #fdba45 ;">★★★★</span>★
                                                        </div>
                                                    <?php }?>
                                                             <?php if($row['star_rate'] == '5' ) {?>
                                                        <div style="font-size: 18px ; color: #ccc;">
                                                            <span style="color: #fdba45 ;">★★★★★</span>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                                <div class="text-center mb-3">
                                                   <?php echo mb_substr($row['icerik'],0,90, 'UTF-8'); ?>
                                                     <?php if(strlen($row['icerik']) > '90'  ) {?>
                                                    ...
                                                  <?php }?>
                                                </div>

                                                <div class="text-center bg-light pt-2 pb-2">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-outline-danger " href="pages.php?page=client_comments&status_update=<?=$row['id']?><?=$sayfa?>">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=client_comments&status_update=<?=$row['id']?><?=$sayfa?>">
                                                            <div class="d-flex align-items-center">
                                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                <?=$diller['adminpanel-form-text-67']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=client_comments_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
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
                                            <li class="page-item "><a class="page-link " href="pages.php?page=client_comments"><?=$diller['sayfalama-ilk']?></a></li>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=client_comments&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                        <?php } ?>
                                        <?php
                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                            if($i == $Sayfa){
                                                ?>
                                                <li class="page-item active " aria-current="page">
                                                    <a class="page-link" href="pages.php?page=client_comments&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                <li class="page-item "><a class="page-link" href="pages.php?page=client_comments&p=<?=$i?>"><?=$i?></a></li>
                                                <?php
                                            }
                                        }
                                        }
                                        ?>

                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=client_comments&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=client_comments&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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

<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=client_comments_edit',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
</script>
<!--  <========SON=========>>> Editable Modal SON !-->

<script src="plugins/bootstrap-rating/bootstrap-rating.min.js"></script>
<script src="assets/pages/rating-init.js"></script>