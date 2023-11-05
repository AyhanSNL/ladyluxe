<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'faq';

if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

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

                $query = $db->query("UPDATE sss SET sira = '$count' WHERE id = '$idler2'");
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

                $statusCek = $db->prepare("select * from sss where id=:id ");
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

                    $guncelle = $db->prepare("UPDATE sss SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $statusum
                    ));
                    if ($sonuc) {
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=faq' . $sayfa . ''.$searchPage.'');
                    } else {
                        echo 'Veritabanı Hatası';
                    }

                } else {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=faq');
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=faq');
            }
        }


    }else{
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=faq');
    }
}
?>
<title><?=$diller['adminpanel-menu-text-52']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=faq"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-52']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['icerik_diger'] == '1' ) {


            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = "and (soru like '%$_GET[search]%' or cevap like '%$_GET[search]%' ) ";
            }else{
                $search = null;
            }
            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from sss where dil='$_SESSION[dil]' $search");
            $ToplamVeri = $Say->rowCount();
            $Limit = 30;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from sss where dil='$_SESSION[dil]' $search  order by sira ASC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);



            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>
                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-52']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-info text-white  " href="pages.php?page=theme_faq"><?=$diller['adminpanel-form-text-838']?></a>
                                <a  class="btn btn-success text-white "   data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1189']?></a>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse " id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3 mt-3">
                                    <form action="post.php?process=faq_post&status=add" method="post" enctype="multipart/form-data" >
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
                                                <h5> <?=$diller['adminpanel-form-text-1189']?></h5>
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
                                                <label for="soru">* <?=$diller['adminpanel-form-text-1191']?></label>
                                                <input type="text" autocomplete="off"  name="soru" id="soru" required class="form-control">
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="cevap">* <?=$diller['adminpanel-form-text-1192']?></label>
                                                <textarea name="cevap" id="cevap" class="form-control" rows="2" required></textarea>
                                            </div>

                                            <div class="form-group col-md-12 mb-3">
                                                <label  for="inputGroupFile01" class="w-100"><?=$diller['adminpanel-form-text-98']?> (150x150)  <small>( png,  jpg, jpeg, gif, svg )</small></label>
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
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2  ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=faq" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="faq" >
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
                        <form method="post" action="post.php?process=faq_post&status=multidelete">
                        <div class="w-100 ">
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
                                <?php foreach ($islemCek as $row) {?>
                                    <div class="col-md-12" id="<?php echo $row['id'] ?>" style="cursor: move">
                                        <div class="card mb-2 shadow-sm border">
                                            <div class="card-body d-flex align-items-center justify-content-between flex-wrap ">
                                                <div class="text-center mb-2 mr-3">
                                                    <div class="kustom-checkbox">
                                                        <input type="checkbox" class="individual" id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>">
                                                        <label for="checkSec-<?=$row['id']?>"></label>
                                                    </div>
                                                </div>
                                              <div class="flex-grow-1" >
                                                  <div class=" mb-3" style="font-size: 14px ; font-weight: 500;">
                                                      <?=$row['soru']?>
                                                  </div>
                                                  <div class=" mb-3">
                                                      <?php echo mb_substr($row['cevap'],0,90, 'UTF-8'); ?>
                                                      <?php if(strlen($row['cevap']) > '90'  ) {?>
                                                          ...
                                                      <?php }?>
                                                  </div>
                                              </div>
                                                <div class="text-right pt-2 pb-2" style="min-width: 120px">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-outline-danger " href="pages.php?page=faq&status_update=<?=$row['id']?><?=$sayfa?><?=$searchPage?>">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=faq&status_update=<?=$row['id']?><?=$sayfa?><?=$searchPage?>">
                                                            <div class="d-flex align-items-center">
                                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                <?=$diller['adminpanel-form-text-67']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=faq_post&status=delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                            <li class="page-item "><a class="page-link " href="pages.php?page=faq<?=$searchPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                            <li class="page-item "><a class="page-link " href="pages.php?page=faq<?=$searchPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                        <?php } ?>
                                        <?php
                                        for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                            if($i == $Sayfa){
                                                ?>
                                                <li class="page-item active " aria-current="page">
                                                    <a class="page-link" href="pages.php?page=faq<?=$searchPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                </li>
                                                <?php
                                            }else{
                                                ?>
                                                <li class="page-item "><a class="page-link" href="pages.php?page=faq<?=$searchPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                <?php
                                            }
                                        }
                                        }
                                        ?>

                                        <?php if($islemListele->rowCount() <=0) { } else { ?>
                                            <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=faq<?=$searchPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                <li class="page-item"><a class="page-link" href="pages.php?page=faq<?=$searchPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=faq_edit',
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

