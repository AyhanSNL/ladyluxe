<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'kargo';

if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE kargo_firma SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}
if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}

if(isset($_GET['status_update'])  ) {
if ($yetki['demo'] != '1') {
 if($_GET['status_update'] == !null  ) {

     $statusCek = $db->prepare("select * from kargo_firma where id=:id ");
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

         $guncelle = $db->prepare("UPDATE kargo_firma SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
         $sonuc = $guncelle->execute(array(
             'durum' => $statusum
         ));
         if($sonuc){
             header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company'.$sayfa.'');
         }else{
         echo 'Veritabanı Hatası';
         }

     }else{
         header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
     }

 }else{
     header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_company');
 }
}}
?>
<title><?=$diller['adminpanel-menu-text-84']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-75']?></a>
                                <a href="pages.php?page=delivery_company"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-84']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['yapilandirma'] == '1') {


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from kargo_firma");
            $ToplamVeri = $Say->rowCount();
            $Limit = 20;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from kargo_firma order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/config_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top ">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-84']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-dark text-white mb-2"  href="" data-toggle="modal" data-target=".cargo_company"><i class="fas fa-truck "></i> <?=$diller['adminpanel-form-text-766']?></a>
                                <a  class="btn btn-success text-white mb-2"  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-759']?></a>
                            </div>
                        </div>

                        <div id="accordion" class="accordion">
                        <div class="collapse" id="genelAcc" data-parent="#accordion">
                            <div class="w-100 border pl-3 pr-3 pt-3 mb-3">
                            <form action="post.php?process=delivery_company_post&status=add" method="post"  enctype="multipart/form-data">
                                <div class="row ">
                                    <div class="form-group col-md-12 text-center bg-white text-dark mt-n3 mb-3 border-bottom">
                                        <h5> <?=$diller['adminpanel-form-text-759']?></h5>
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-start">
                                    <div class="form-group col-md-6">
                                        <label for="baslik">* <?=$diller['adminpanel-form-text-760']?></label>
                                        <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control" >
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-start">
                                    <div class="form-group col-md-6">
                                        <label for="gorsel">* <?=$diller['adminpanel-form-text-762']?>  <small>( png,  jpg, jpeg, svg, gif )</small></label>
                                        <div class="input-group mb-1">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel" >
                                                <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-start">
                                    <div class="form-group col-md-12">
                                        <label for="takip_url" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                            <?=$diller['adminpanel-form-text-761']?>
                                            <a href="" data-toggle="modal" data-target=".cargo_company"  class="ml-2">
                                                <i class="fa fa-external-link-alt"></i>
                                            </a>
                                        </label>
                                        <input type="text" autocomplete="off" style="height: 45px"  name="takip_url" id="takip_url"  class="form-control " placeholder="https://" >
                                        <div class="border border-top-0  p-2 bg-light  rounded" style="font-size: 12px ;">
                                            <?=$diller['adminpanel-form-text-765']?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-top pt-3 bg-light pb-3">
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
                            <div class="w-100 p-2 bg-light mb-2 font-12">
                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['adminpanel-text-171']?>
                            </div>
                            <form method="post" action="post.php?process=delivery_company_post&status=multidelete">
                            <div class="table-responsive ">
                                <table class="table table-hover mb-0  ">
                                    <thead class="thead-default">
                                    <tr>
                                        <th width="25">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input selectall"  id="hepsiniSecCheckBox" >
                                                <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                            </div>
                                        </th>
                                        <th><?=$diller['adminpanel-text-170']?></th>
                                        <th></th>
                                        <th><?=$diller['adminpanel-form-text-760']?></th>
                                        <th><?=$diller['adminpanel-form-text-62']?></th>
                                        <th  class="text-right" width="100"><?=$diller['adminpanel-text-157']?></th>
                                    </tr>
                                    </thead>
                                    <tbody  class="row_position">
                                    <?php foreach ($islemCek as $row) {?>
                                        <tr id="<?php echo $row['id'] ?>" style="cursor: move">
                                            <th>
                                                <div class="custom-control custom-checkbox" >
                                                    <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                    <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                </div>
                                            </th>
                                            <td width="40">
                                                <div class="btn btn-outline-pink btn-sm">
                                                    <?=$row['sira']?>
                                                </div>
                                            </td>
                                            <td width="110" style="min-width: 110px">
                                                <img class="img-fluid border p-2 bg-white" src="<?=$ayar['site_url']?>i/cargo/<?=$row['gorsel']?>" alt="">
                                            </td>
                                            <td style="min-width: 140px" >
                                                <?=$row['baslik']?>
                                            </td>
                                            <td width="85">
                                                <?php if($row['durum'] == '0' ) {?>
                                                    <a class="btn btn-sm btn-outline-danger " href="pages.php?page=delivery_company&status_update=<?=$row['id']?><?=$sayfa?>">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-times mr-2"></i>
                                                            <?=$diller['adminpanel-form-text-68']?>
                                                        </div>
                                                    </a>
                                                <?php }?>
                                                <?php if($row['durum'] == '1' ) {?>
                                                    <?php if($row['varsayilan'] != '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=delivery_company&status_update=<?=$row['id']?><?=$sayfa?>">
                                                    <?php }else { ?>
                                                            <a class="btn btn-sm btn-success " href="javascript:Void(0)>">
                                                    <?php }?>
                                                        <div class="d-flex align-items-center">
                                                            <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <?=$diller['adminpanel-form-text-67']?>
                                                        </div>
                                                    <?php if($row['varsayilan'] != '1' ) {?>
                                                        </a>
                                                    <?php }?>

                                                <?php }?>
                                            </td>
                                            <td class="text-right" style="min-width: 100px">
                                                <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                <?php if($ToplamVeri > '1') {?>
                                                    <a href="" data-href="post.php?process=delivery_company_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                <?php if($ToplamVeri<='0' ) {?>
                                    <div class="w-100  p-3 ">
                                        <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                    </div>
                                <?php }?>
                            <div class="border-top"> </div>
                            <?php if($ToplamVeri > '1') {?>
                                <div class="w-100 pt-3 pb-3 border-bottom border-top  " >
                                    <button class="btn btn-danger btn-sm rounded-0 shadow-lg pl-4 pr-4 " type="submit" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                                </div>
                                </form>
                            <?php }?>







                            <!---- Sayfalama Elementleri ================== !-->
                            <?php if($ToplamVeri > $Limit  ) {?>
                                <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                    <?php if($Sayfa >= 1){?>
                                    <nav aria-label="Page navigation example " >
                                        <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                            <?php } ?>
                                            <?php if($Sayfa > 1){  ?>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=delivery_company"><?=$diller['sayfalama-ilk']?></a></li>
                                                <li class="page-item "><a class="page-link " href="pages.php?page=delivery_company&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                            <?php } ?>
                                            <?php
                                            for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                if($i == $Sayfa){
                                                    ?>
                                                    <li class="page-item active " aria-current="page">
                                                        <a class="page-link" href="pages.php?page=delivery_company&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                    </li>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <li class="page-item "><a class="page-link" href="pages.php?page=delivery_company&p=<?=$i?>"><?=$i?></a></li>
                                                    <?php
                                                }
                                            }
                                            }
                                            ?>

                                            <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=delivery_company&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                    <li class="page-item"><a class="page-link" href="pages.php?page=delivery_company&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=delivery_company_edit',
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
    $(document).ready(function() {
        $('.icon_select2').select2();
    });
    jQuery('#kod').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });
</script>


