<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'social';

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

                $query = $db->query("UPDATE sosyal SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}
?>
<title><?=$diller['adminpanel-menu-text-63']?> - <?=$panelayar['baslik']?></title>
<link rel="stylesheet" href="../assets/css/font-awesome/font-awesome.min.css" />

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
                                <a href="pages.php?page=social_accounts"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-63']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['icerik_diger'] == '1' ) {


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from sosyal ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 30;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from sosyal   order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);



            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>
                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-63']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-success text-white "   data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1162']?></a>
                            </div>
                        </div>

                        <div class="p-2 border border-warning alert-warning text-dark" style="font-size: 14px ;">
                            <?=$diller['adminpanel-form-text-1163']?>
                        </div>

                        <div id="accordion" class="accordion">

                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3 mt-3">
                                    <form action="post.php?process=social_post&status=add" method="post" >
                                        <div class="row">
                                            <div class="form-group col-md-12 text-center bg-white text-dark  border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-form-text-1162']?></h5>
                                            </div>
                                        </div>
                                        <div class="row  mt-3">
                                            <div class="form-group col-md-4 mb-4">
                                                <label  for="footer" class="w-100" ><?=$diller['adminpanel-form-text-1166']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="footer" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="footer" name="footer" value="1"   ">
                                                    <label class="custom-control-label" for="footer"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4 mb-4">
                                                <label  for="bakim" class="w-100" ><?=$diller['adminpanel-form-text-1167']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="bakim" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="bakim" name="bakim" value="1"   ">
                                                    <label class="custom-control-label" for="bakim"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="form-group col-md-4">
                                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                                <input type="number" autocomplete="off" min="1"  name="sira" id="sira"  required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="baslik">* <?=$diller['adminpanel-form-text-1164']?></label>
                                                <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="url"><?=$diller['adminpanel-form-text-1165']?></label>
                                                <input type="text" autocomplete="off"  name="url" id="url" placeholder="https://" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="icon"><?=$diller['adminpanel-form-text-675']?></label>
                                                <select class="icon_select2 form-control col-md-12" name="icon" id="icon" style="width: 100%!important;" >
                                                    <?php include 'inc/modules/_helper/icon.php'?>
                                                </select>
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


                        <div class="w-100">
                            <div class="w-100 p-2 bg-light  font-12 mb-4">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-text-171']?>
                            </div>
                            <div class="row row_position">
                                <?php foreach ($islemCek as $row) {?>
                                    <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-6<?php }else{?>col-md-4<?php } ?>" id="<?php echo $row['id'] ?>" style="cursor: move">
                                        <div class="card border pt-2 pb-2 pl-4 pr-3">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                <div class=" d-flex align-items-center justify-content-start flex-wrap" >
                                                    <i class="fa <?=$row['icon']?> mr-3 mt-2" style="font-size: 40px ;"></i>
                                                    <?php if($row['footer'] == '1' ) {?>
                                                        <div class="btn btn-success ml-2 btn-sm mt-2" style="font-size: 12px ;" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1168']?>"><i class="fa fa-check"></i> <?=$diller['adminpanel-form-text-1170']?></div>
                                                    <?php }?>
                                                    <?php if($row['bakim'] == '1' ) {?>
                                                        <div class="btn btn-warning ml-2 btn-sm mt-2" style="font-size: 12px ;" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1169']?>"><i class="fa fa-check"></i> <?=$diller['adminpanel-form-text-1171']?></div>
                                                    <?php }?>
                                                </div>
                                                <div class="text-center bg-light border rounded p-3  mt-2 mb-2 ml-2  flex-1">
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=social_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                            <li class="page-item "><a class="page-link " href="pages.php?page=social_accounts"><?=$diller['sayfalama-ilk']?></a></li>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=social_accounts&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                        <?php } ?>
                                        <?php
                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                            if($i == $Sayfa){
                                                ?>
                                                <li class="page-item active " aria-current="page">
                                                    <a class="page-link" href="pages.php?page=social_accounts&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                <li class="page-item "><a class="page-link" href="pages.php?page=social_accounts&p=<?=$i?>"><?=$i?></a></li>
                                                <?php
                                            }
                                        }
                                        }
                                        ?>

                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=social_accounts&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=social_accounts&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=social_edit',
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
    $(document).ready(function() {
        $('.icon_select2').select2();
    });
</script>
<!--  <========SON=========>>> Editable Modal SON !-->