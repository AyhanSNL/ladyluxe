<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'sort';

if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=modules_sort');
    }
}


if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE moduller SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}


?>
<title><?=$diller['adminpanel-menu-text-68']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-67']?></a>
                                <a href="pages.php?page=modules_sort"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-68']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['modul'] == '1' &&  $yetki['sirala'] == '1') {



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from moduller where (baslik like '%$_GET[search]%' ) ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 50;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from moduller where (baslik like '%$_GET[search]%' )  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2 mb-2 border-bottom">
                            <h4> <?=$diller['adminpanel-menu-text-68']?></h4>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=modules_sort" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="modules_sort" id="" required class="form-control">
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
                            <div class="w-100 p-2 bg-light mb-2 font-12">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-text-171']?>
                            </div>
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th><?=$diller['adminpanel-text-170']?></th>
                                            <th><?=$diller['adminpanel-form-text-837']?></th>
                                            <th></th>
                                            <th></th>
                                            <th><?=$diller['adminpanel-form-text-62']?></th>
                                        </tr>
                                        </thead>
                                        <tbody class="row_position">
                                        <?php foreach ($islemCek as $row) { ?>
                                            <tr  id="<?php echo $row['id'] ?>" style="cursor: move">
                                                <td width="40">
                                                    <div class="btn btn-outline-pink btn-sm">
                                                        <?=$row['sira']?>
                                                    </div>
                                                </td>
                                                <td style="font-weight: 500; min-width: 150px"><?=$row['baslik']?></td>
                                                <td width="150"style="min-width: 150px">
                                                    <?php if($row['duzenle_url'] == !null ) {?>
                                                        <a href="<?=$row['duzenle_url']?>" class="btn btn-sm btn-warning shadow-sm"><?=$diller['adminpanel-form-text-838']?></a>
                                                    <?php }?>
                                                </td>
                                                <td width="135"style="min-width: 135px">
                                                    <?php if($row['modul_url'] == !null ) {?>
                                                    <a href="<?=$row['modul_url']?>" class="btn btn-sm btn-primary shadow-sm"><?=$diller['adminpanel-form-text-839']?></a>
                                                    <?php } ?>
                                                </td>
                                                <td width="100">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-outline-danger islemyap " data-code="<?=$row['id']?>" href="#">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success islemyap "  data-code="<?=$row['id']?>" href="#">
                                                            <div class="d-flex align-items-center">
                                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                <?=$diller['adminpanel-form-text-67']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
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
                                <div class="border-top"> </div>
                            <?php if($ToplamVeri<='0' && !isset($_GET['search']) ) {?>
                                <div class="w-100  p-3 ">
                                    <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                </div>
                            <?php }?>

                            <?php if($ToplamVeri<='0' && isset($_GET['search']) ) {?>
                                <div class="w-100  p-3 ">
                                    <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-163']?>
                                </div>
                            <?php }?>



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
<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=font_edit',
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