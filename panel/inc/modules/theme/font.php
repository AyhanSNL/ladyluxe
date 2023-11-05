<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'fonts';

if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=fonts');
    }
}


if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE fontlar SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}


if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}
if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}

if(isset($_GET['status_update'])  ) {
    if($yetki['demo'] != '1' ) {
        if($_GET['status_update'] == !null  ) {

            $statusCek = $db->prepare("select * from fontlar where id=:id ");
            $statusCek->execute(array(
                'id' => $_GET['status_update']
            ));

            if($statusCek->rowCount()>'0'  ) {
                $st = $statusCek->fetch(PDO::FETCH_ASSOC);



                if($st['durum'] == '1' ) {
                    $statusum = '0';
                }
                if($st['durum'] == '0' ) {
                    $statusum = '1';
                }

                $guncelle = $db->prepare("UPDATE fontlar SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
                $sonuc = $guncelle->execute(array(
                    'durum' => $statusum
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=fonts'.$searchPage.''.$sayfa.'');
                }else{
                    echo 'Veritabanı Hatası';
                }

            }else{
                header('Location:'.$ayar['panel_url'].'pages.php?page=fonts');
            }

        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=fonts');
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=fonts');
    }

}

?>
<title><?=$diller['adminpanel-menu-text-109']?> - <?=$panelayar['baslik']?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box  bg-white card mb-0 pl-3" >
                    <div class="row align-items-center d-flex justify-content-between" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-98']?></a>
                                <a href="pages.php?page=fonts"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-109']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1') {



            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from fontlar where (font_adi like '%$_GET[search]%' ) ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 25;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from fontlar where (font_adi like '%$_GET[search]%' )  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);




            ?>


            <div class="row">

                <!-- Left Bar !-->
                <div class="col-md-3">
                    <div class="card p-3">
                        <div class="card-body">
                            <div class="w-100 mb-2 d-flex align-items-center justify-content-between flex-wrap">
                                <h5><?=$diller['adminpanel-text-12']?></h5>
                                <i class="ti-help-alt text-primary " ></i>
                            </div>
                            <div class="w-100 font-13">
                                <?=$diller['adminpanel-text-315']?>
                                <br><br>
                                <div class="font-12" style="color: #999;">
                                    <?=$diller['adminpanel-text-316']?>
                                </div>
                                <br>
                            </div>
                            <a href="https://fonts.google.com/" class="w-100 d-block border border-danger text-center" target="_blank">
                                <img src="assets/images/google_font.png">
                            </a>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Left Bar SON !-->



                <!-- Contents !-->
                <div class="col-md-6">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-109']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a href="" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-success "><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-text-313']?></a>

                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3">
                                    <form action="post.php?process=theme_font_post&status=font_add" method="post" >
                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-white text-dark border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-text-313']?></h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12 mt-3">
                                                <div class="border border-warning alert-warning text-dark mb-1 p-3" style="font-size: 14px ;">
                                                    <?=$diller['adminpanel-text-314']?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                                <select name="durum" class="form-control" id="durum" required>
                                                    <option value="0"><?=$diller['adminpanel-form-text-68']?></option>
                                                    <option value="1" selected ><?=$diller['adminpanel-form-text-67']?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="sira" class="w-100"><?=$diller['adminpanel-form-text-55']?></label>
                                                <input type="number" name="sira"  id="sira" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="font_adi"><?=$diller['adminpanel-form-text-439']?> </label>
                                                <input type="text" name="font_adi" id="font_adi" required class="form-control" style="border-radius: 5px 5px 0 0 ">
                                                <div class="bg-light border p-2 rounded-bottom border-top-0" style="font-size: 11px ;">
                                                    <strong><?=$diller['adminpanel-form-text-442']?></strong> font-family: 'Open Sans', sans-serif; <?=$diller['adminpanel-form-text-443']?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="kod"><?=$diller['adminpanel-form-text-441']?> </label>
                                                <textarea name="kod" id="kod" class="form-control" rows="2" required style="border-radius: 5px 5px 0 0 "></textarea>
                                                <div class="bg-light border p-2 rounded-bottom border-top-0" style="font-size: 11px ;">
                                                    <strong><?=$diller['adminpanel-form-text-442']?></strong> : https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success " name="add"><?=$diller['adminpanel-form-text-53']?></button>
                                                <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=fonts" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="fonts" id="" required class="form-control">
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
                                            <th><?=$diller['adminpanel-form-text-439']?></th>
                                            <th><?=$diller['adminpanel-form-text-62']?></th>
                                            <th  class="text-right" width="100"><?=$diller['adminpanel-text-157']?></th>
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
                                                <td style="font-weight: 500; min-width: 140px"><?=$row['font_adi']?></td>
                                                <td width="100">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-outline-danger " href="pages.php?page=fonts&status_update=<?=$row['id']?><?=$searchPage?><?=$sayfa?>">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=fonts&status_update=<?=$row['id']?><?=$searchPage?><?=$sayfa?>">
                                                            <div class="d-flex align-items-center">
                                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                <?=$diller['adminpanel-form-text-67']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                </td>
                                                <td class="text-right" style="min-width: 100px">
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <?php if($ToplamVeri > '1') {?>
                                                        <a href="" data-href="post.php?process=theme_font_post&status=font_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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



                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=fonts<?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=fonts&p=<?=$Sayfa - 1?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=fonts&p=<?=$i?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=fonts&p=<?=$i?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=fonts&p=<?=$Sayfa + 1?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=fonts&p=<?=$Sayfa_Sayisi?><?php if( isset($_GET['search']) ) { ?>&search=<?=$_GET['search']?><?php }?>"><?=$diller['sayfalama-son']?></a></li>
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
                <!--  <========SON=========>>> Contents SON !-->


                <?php include 'inc/modules/_helper/theme_all_links.php'; ?>




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

<script>
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
</script>