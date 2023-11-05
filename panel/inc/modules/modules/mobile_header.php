<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'mobilheader';
$urladdress = 'sss/';

if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=mobile_header_links');
    }
}

if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}


if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE header_mobil SET sira = '$count' WHERE id = '$idler2'");
            } catch (PDOException $ex) {
                echo "Hata İşlem Yapılamadı!";
                some_logging_function($ex->getMessage());
            }
            $count++;
        }
    }
}
if(isset($_GET['status_update'])  ) {
if ($yetki['demo'] != '1') {
    if ($_GET['status_update'] == !null) {

        $statusCek = $db->prepare("select * from header_mobil where id=:id ");
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

            $guncelle = $db->prepare("UPDATE header_mobil SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
            $sonuc = $guncelle->execute(array(
                'durum' => $statusum
            ));
            if ($sonuc) {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=mobile_header_links' . $searchPage . '');
            } else {
                echo 'Veritabanı Hatası';
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=mobile_header_links');
        }

    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=mobile_header_links');
    }
}
}
?>
<title><?=$diller['adminpanel-menu-text-177']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=mobile_header_links"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-177']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['modul'] == '1' &&  $yetki['modul_header_footer'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
             $search = " baslik like '%$_GET[search]%' and ";
            }else{
                $search = null;
            }

            $headerMenus = $db->prepare("select * from header_mobil where  $search dil='$_SESSION[dil]' and ust_id='0'  order by sira asc ");
            $headerMenus->execute(array());

            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-177']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-info text-white  " href="post.php?process=mobile_header_post&status=theme_settings"><?=$diller['adminpanel-form-text-838']?></a>
                                <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-852']?></a>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse" id="genelAcc" data-parent="#accordion">
                                <div class="w-100 border pl-3 pr-3 mb-3">
                                    <form action="post.php?process=mobile_header_post&status=add" method="post" >
                                        <div class="row ">
                                            <div class="form-group col-md-12 text-center bg-white text-dark border-bottom mb-0 ">
                                                <h5> <?=$diller['adminpanel-form-text-852']?></h5>
                                            </div>
                                        </div>
                                        <div class="row bg-light mb-3 border-bottom ">
                                            <div class="form-group col-md-3 mt-3  ">
                                                <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                        <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                        <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <div class="form-group col-md-12 mb-4">
                                                <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  checked >
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="baslik">* <?=$diller['adminpanel-form-text-849']?></label>
                                                <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                                <input type="number" autocomplete="off" min="1"  name="sira" id="sira" required  class="form-control">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="yeni_sekme"><?=$diller['adminpanel-form-text-859']?></label>
                                                <select name="yeni_sekme" class="form-control" id="yeni_sekme" required>
                                                    <option value="0"><?=$diller['adminpanel-form-text-858']?></option>
                                                    <option value="1"><?=$diller['adminpanel-form-text-111']?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label for="url_tur"><?=$diller['adminpanel-form-text-856']?></label>
                                                <select name="url_tur" class="form-control rounded-0" id="url_tur" required style="height: 55px; font-size: 15px ;">
                                                    <option value="0"><?=$diller['adminpanel-form-text-860']?></option>
                                                    <option value="1"><?=$diller['adminpanel-form-text-853']?></option>
                                                    <option value="2"><?=$diller['adminpanel-form-text-854']?></option>
                                                </select>
                                            </div>
                                            <div id="modul-choise" class="col-md-12 " style="display: none;"   >
                                                <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                                    <div class="">
                                                        <select name="modul_url" class="select_ajax2 form-control rounded-0" id="modul_url"  style="height: 55px; width: 100%!important;  ">
                                                            <?php include 'inc/modules/_helper/site_linkleri.php'; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="manuel-choise" class="col-md-12 " style="display: none;"   >
                                                <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                                    <div class="">
                                                        <input type="text" name="manuel_url" placeholder="https://"  autocomplete="off" class="form-control">
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
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$headerMenus->rowCount()?></h6>
                                        <a href="pages.php?page=mobile_header_links" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="mobile_header_links" id="" required class="form-control">
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
                            <div class="w-100  mb-2 ">
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th><?=$diller['adminpanel-text-170']?></th>
                                            <th><?=$diller['adminpanel-form-text-849']?></th>
                                            <th></th>
                                            <th><?=$diller['adminpanel-form-text-62']?></th>
                                            <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody  class="row_position">
                                        <?php foreach ($headerMenus as $menuRows) {

                                            $altmenuSayisi = $db->prepare("select * from header_mobil where ust_id=:ust_id ");
                                            $altmenuSayisi->execute(array(
                                                'ust_id' => $menuRows['id'],
                                            ));

                                            ?>
                                            <tr id="<?php echo $menuRows['id'] ?>" style="cursor: move">
                                                <td width="40">
                                                    <div class="btn btn-outline-pink btn-sm">
                                                        <?=$menuRows['sira']?>
                                                    </div>
                                                </td>
                                                <td style="font-weight: 500; min-width: 150px">
                                                    <?php if($menuRows['yeni_sekme'] == '1' ) {?>
                                                        <a href="javascript:Void(0)" class="badge badge-danger btn-sm mr-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-890']?>"><?=$diller['adminpanel-form-text-891']?></a>
                                                    <?php }else { ?>
                                                        <a href="javascript:Void(0)" class="badge badge-info btn-sm mr-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-893']?>" ><?=$diller['adminpanel-form-text-892']?></a>
                                                    <?php }?>
                                                    <?=$menuRows['baslik']?>
                                                </td>
                                                <td style="min-width: 165px" width="165">
                                                    <a href="pages.php?page=mobile_header_list&parent=<?=$menuRows['id']?>" class="btn btn-sm alert-warning border border-warning text-dark  rounded">
                                                        <i class="mdi mdi-buffer"></i>   <?=$diller['adminpanel-form-text-864']?> (<?=$altmenuSayisi->rowCount()?>)
                                                    </a>
                                                </td>
                                                <td width="85">

                                                    <?php if($menuRows['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-outline-danger " href="pages.php?page=mobile_header_links&status_update=<?=$menuRows['id']?><?=$searchPage?>">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($menuRows['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=mobile_header_links&status_update=<?=$menuRows['id']?><?=$searchPage?>">
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
                                                    <a href="javascript:Void(0)" data-id="<?=$menuRows['id']?>" class="btn btn-sm btn-primary duzenleAjax" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=mobile_header_post&status=delete&no=<?=$menuRows['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                    <?php if($headerMenus->rowCount()<='0' ) {?>
                                        <div class="w-100  p-3 ">
                                            <i class="fa fa-ban"></i> <?=$diller['adminpanel-text-162']?>
                                        </div>
                                    <?php }?>
                                </div>
                                <!-- Kaydırılabilir Alert !-->
                                <div class="d-md-none d-sm-block p-2 bg-light  text-center">
                                    <?=$diller['adminpanel-text-340']?> <i class="fas fa-hand-pointer"></i>
                                </div>
                                <!--  <========SON=========>>> Kaydırılabilir Alert SON !-->
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

<script>
        $('#url_tur').on('change', function() {
            $('#modul-choise').css('display', 'none');
            if ( $(this).val() === '1' ) {
                $('#modul-choise').css('display', 'block');
            }
            $('#manuel-choise').css('display', 'none');
            if ( $(this).val() === '2' ) {
                $('#manuel-choise').css('display', 'block');
            }
        });
</script>
<script>
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
    $(document).ready(function() {
        $('.select_ajax2').select2();
    });
</script>
<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=mobile_header_edit',
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