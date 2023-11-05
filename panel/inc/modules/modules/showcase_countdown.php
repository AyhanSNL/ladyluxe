<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'countdown';


if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}


if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_countdown');
    }
}



if($_POST) {
if ($yetki['demo'] != '1') {
    $position = $_POST['position'];
    $count = 1;
    foreach ($position as $idler) {
        $idler2 = htmlspecialchars(trim($idler));
        try {

            $query = $db->query("UPDATE vitrin_firsat_urunler SET sira = '$count' WHERE id = '$idler2'");
        } catch (PDOException $ex) {
            echo "Hata İşlem Yapılamadı!";
            some_logging_function($ex->getMessage());
        }
        $count++;
    }
}
}

?>
<title><?=$diller['adminpanel-menu-text-15']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=showcase_countdown"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-15']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['modul'] == '1' &&  $yetki['modul_vitrin'] == '1') {
            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = " baslik like '%$_GET[search]%' and ";
            }else{
                $search = null;
            }

            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from vitrin_firsat_urunler where $search dil='$_SESSION[dil]'");
            $ToplamVeri = $Say->rowCount();
            $Limit = 28;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from vitrin_firsat_urunler where $search dil='$_SESSION[dil]'  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);



            ?>
            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top border-bottom pb-2 mb-0">
                            <div class="new-buttonu-main-left">
                                <h4><?=$grupRow['baslik']?> <?=$diller['adminpanel-menu-text-15']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-info text-white " href="pages.php?page=theme_showcase_countdown"><?=$diller['adminpanel-form-text-838']?></a>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 mt-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=showcase_countdown" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="showcase_countdown" >
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
                        <div class="w-100 border rounded mb-3">
                            <div class="p-3 border-bottom text-center bg-light" style="font-size: 20px ;">
                                <?=$diller['adminpanel-form-text-964']?>
                            </div>
                            <div class="  p-3 ">
                                <form method="post" action="post.php?process=showcase_post&status=firsat_add">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="urun_id">* <?=$diller['adminpanel-form-text-938']?></label>
                                            <select class="urunler_select form-control col-md-12" name="urun_id"   id="urun_id" style="width: 100%!important;" >
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="son_tarih">* <?=$diller['adminpanel-form-text-996']?></label>
                                            <div>
                                                <div class="input-group">
                                                    <input type="text" name="son_tarih" class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="dateSelected" autocomplete="off" required style="height: 40px">
                                                    <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                </div><!-- input-group -->
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="son_time">* <?=$diller['adminpanel-form-text-1957']?></label>
                                            <input type="text" autocomplete="off"   name="son_time" id="son_time" placeholder="<?=$diller['adminpanel-form-text-1958']?>" required class="form-control">
                                        </div>
                                        <div class="col-md-12 mb-0 form-group">
                                            <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <form method="post" action="post.php?process=showcase_post&status=firsat_multidelete">
                        <div class="w-100">

                            <div class="w-100 p-2 bg-light  font-12 mb-4">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-text-171']?>
                            </div>
                            <?php if($ToplamVeri>'0'  ) {?>
                                <div class="d-flex align-items-center justify-content-start mb-3">
                                    <div id="selectall" style="cursor:pointer;" class="btn btn-primary btn-sm ">
                                        <?=$diller['adminpanel-form-text-937']?>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="row row_position">
                                <?php foreach ($islemCek as $row) {

                                    $urunCek = $db->prepare("select * from urun where id=:id ");
                                    $urunCek->execute(array(
                                            'id' => $row['urun_id']
                                    ));
                                    $uruns = $urunCek->fetch(PDO::FETCH_ASSOC);

                                    ?>
                                    <div class="col-md-3" id="<?php echo $row['id'] ?>" style="cursor: move">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="text-center mb-3">
                                                    <div class="kustom-checkbox">
                                                        <input type="checkbox" class="individual" id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>">
                                                        <label for="checkSec-<?=$row['id']?>"></label>
                                                    </div>
                                                </div>
                                                <?php if($uruns['gorsel'] == !null ) {?>
                                                    <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                        <img src="../images/product/<?=$uruns['gorsel']?>" class="img-fluid border p-1" style="max-width: 130px; height: 130px; " >
                                                    </div>
                                                <?php }else { ?>
                                                    <div class="d-flex align-items-center justify-content-center w-100 mb-3" >
                                                        <img src="assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 130px; " >
                                                    </div>
                                                <?php }?>
                                                <div class="text-center mb-3">
                                                    <?=$row['baslik']?>
                                                </div>
                                                <div class="text-center mb-3">
                                                    <div class="btn btn-outline-pink btn-sm">
                                                        <?=$row['sira']?>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <?php
                                                    $timestamp = date('Y-m-d');
                                                    $zaman = date('H:i');
                                                    $tumzaman = date('Y-m-d H:i:s');
                                                    $gecerlizaman = ''.$row['son_tarih'].' '.$row['son_time'].'';
                                                    ?>
                                                    <?php if($tumzaman > $gecerlizaman  ) {?>
                                                        <div class="btn btn-secondary btn-sm btn-block">
                                                            <i class="fa fa-calendar-times"></i> <?=$diller['adminpanel-form-text-999']?>
                                                        </div>
                                                    <?php }else { ?>
                                                        <div class="btn btn-dark btn-sm btn-block" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-996']?>">
                                                            <i class="fa fa-clock"></i> <?php echo date_tr('j F Y', ''.$row['son_tarih'].''); ?> <?php echo date_tr('H:i', ''.$row['son_time'].''); ?>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                                <div class="text-center  pt-2 pb-2">
                                                    <a  href="javascript:Void(0)" data-id="<?=$row['id']?>"   class="btn btn-sm btn-primary  btn-block duzenleAjax"><i class="fa fa-plus"></i> <?=$diller['adminpanel-form-text-998']?></a>
                                                </div>
                                                <div class="text-center  pt-2 pb-2">
                                                    <a href="" data-href="post.php?process=showcase_post&status=firsat_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-outline-danger btn-block "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-965']?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                        <?php if($ToplamVeri > '0') {?>
                            <div class="w-100 pt-3 pb-3 border-bottom border-top  " >
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
                                            <li class="page-item "><a class="page-link " href="pages.php?page=showcase_countdown"><?=$diller['sayfalama-ilk']?></a></li>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=showcase_countdown&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                        <?php } ?>
                                        <?php
                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                            if($i == $Sayfa){
                                                ?>
                                                <li class="page-item active " aria-current="page">
                                                    <a class="page-link" href="pages.php?page=showcase_countdown&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                <li class="page-item "><a class="page-link" href="pages.php?page=showcase_countdown&p=<?=$i?>"><?=$i?></a></li>
                                                <?php
                                            }
                                        }
                                        }
                                        ?>

                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=showcase_countdown&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=showcase_countdown&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=showcase_countdown_edit',
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