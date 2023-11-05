<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'bannerproduct';

$grupCek = $db->prepare("select * from vitrin_tip1_grup where id=:id ");
$grupCek->execute(array(
        'id' => $_GET['grup_id']
));
$grupRow = $grupCek->fetch(PDO::FETCH_ASSOC);

if($grupCek->rowCount()<='0'  ) {
 header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct');
}

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}


if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=showcase_bannerproduct_list&grup_id='.$_GET['grup_id'].'');
    }
}



if($_POST) {
if ($yetki['demo'] != '1') {
    $position = $_POST['position'];
    $count = 1;
    foreach ($position as $idler) {
        $idler2 = htmlspecialchars(trim($idler));
        try {

            $query = $db->query("UPDATE vitrin_tip1_urunler SET sira = '$count' WHERE id = '$idler2'");
        } catch (PDOException $ex) {
            echo "Hata İşlem Yapılamadı!";
            some_logging_function($ex->getMessage());
        }
        $count++;
    }
}}

?>
<title><?=$grupRow['baslik']?> <?=$diller['adminpanel-form-text-963']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=showcase_bannerproduct"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-12']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$grupRow['baslik']?> <?=$diller['adminpanel-form-text-963']?></a>
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
            $Say = $db->query("select * from vitrin_tip1_urunler where $search grup_id='$grupRow[id]'");
            $ToplamVeri = $Say->rowCount();
            $Limit = 28;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from vitrin_tip1_urunler where $search grup_id='$grupRow[id]'  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);



            ?>
            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="w-100">
                                <a href="pages.php?page=showcase_bannerproduct" class="btn btn-outline-dark btn-sm mb-2 d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                            </div>
                            <div class="new-buttonu-main-left">
                                <h5> <?=$grupRow['baslik']?> <?=$diller['adminpanel-form-text-963']?></h5>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=showcase_bannerproduct_list&grup_id=<?=$_GET['grup_id']?>" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="showcase_bannerproduct_list" >
                                            <input type="hidden" name="grup_id" value="<?=$_GET['grup_id']?>" >
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
                            <div class="  p-3 " >
                                <form method="post" action="post.php?process=showcase_post&status=bannerproduct_list_add">
                                    <input type="hidden" name="grup_id" value="<?=$_GET['grup_id']?>" >
                                    <div class="row">
                                        <div class="col-md-8 form-group">
                                            <label for="urun_id">* <?=$diller['adminpanel-form-text-938']?></label>
                                            <select class="urunler_select form-control col-md-12" name="urun_id"   id="urun_id" style="width: 100%!important;" >
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                            <input type="number" autocomplete="off" min="1"  name="sira" id="sira"   class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group mb-0">
                                            <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <form method="post" action="post.php?process=showcase_post&status=bannerproduct_list_multidelete&grup_id=<?=$_GET['grup_id']?>">
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
                                                <div class="text-center  pt-2 pb-2">
                                                    <a href="" data-href="post.php?process=showcase_post&status=bannerproduct_list_delete&grup_id=<?=$_GET['grup_id']?>&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-outline-danger "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-965']?></a>
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
                                            <li class="page-item "><a class="page-link " href="pages.php?page=showcase_bannerproduct_list&grup_id=<?=$_GET['grup_id']?>"><?=$diller['sayfalama-ilk']?></a></li>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=showcase_bannerproduct_list&grup_id=<?=$_GET['grup_id']?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                        <?php } ?>
                                        <?php
                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                            if($i == $Sayfa){
                                                ?>
                                                <li class="page-item active " aria-current="page">
                                                    <a class="page-link" href="pages.php?page=showcase_bannerproduct_list&grup_id=<?=$_GET['grup_id']?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                <li class="page-item "><a class="page-link" href="pages.php?page=showcase_bannerproduct_list&grup_id=<?=$_GET['grup_id']?>&p=<?=$i?>"><?=$i?></a></li>
                                                <?php
                                            }
                                        }
                                        }
                                        ?>

                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=showcase_bannerproduct_list&grup_id=<?=$_GET['grup_id']?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=showcase_bannerproduct_list&grup_id=<?=$_GET['grup_id']?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
<!--  <========SON=========>>> Editable Modal SON !-->