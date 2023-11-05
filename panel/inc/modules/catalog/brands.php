<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'brands';


if(isset($_GET['search'])  ) {
    if(strip_tags(htmlspecialchars($_GET['search'])) <= '0'  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
        exit();
    }
}

if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
        exit();
    }
}

if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $pageGet = '&p='.$_GET['p'].'';
}else{
    $pageGet = null;
}



if($_POST) {
    if ($yetki['demo'] != '1') {
        $position = $_POST['position'];
        $count = 1;
        foreach ($position as $idler) {
            $idler2 = htmlspecialchars(trim($idler));
            try {

                $query = $db->query("UPDATE urun_marka SET sira = '$count' WHERE id = '$idler2'");
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

        $statusCek = $db->prepare("select * from urun_marka where id=:id ");
        $statusCek->execute(array(
            'id' => trim(strip_tags($_GET['status_update']))
        ));

        $stUp = trim(strip_tags($_GET['status_update']));
        if ($statusCek->rowCount() > '0') {
            $st = $statusCek->fetch(PDO::FETCH_ASSOC);


            if ($st['durum'] == '1') {
                $statusum = '0';
            }
            if ($st['durum'] == '0') {
                $statusum = '1';
            }

            $guncelle = $db->prepare("UPDATE urun_marka SET
                 durum=:durum
          WHERE id={$stUp}      
         ");
            $sonuc = $guncelle->execute(array(
                'durum' => $statusum
            ));
            if ($sonuc) {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=brands' . $searchPage . ''.$pageGet.'');
            } else {
                echo 'Veritabanı Hatası';
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=brands');
        }

    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=brands');
    }
}
}
if(isset($_GET['home_show'])  ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['home_show'] == !null) {

            $statusCek = $db->prepare("select * from urun_marka where id=:id ");
            $statusCek->execute(array(
                'id' => trim(strip_tags($_GET['home_show']))
            ));

            $stUp = trim(strip_tags($_GET['home_show']));
            if ($statusCek->rowCount() > '0') {
                $st = $statusCek->fetch(PDO::FETCH_ASSOC);


                if ($st['anasayfa'] == '1') {
                    $statusum = '0';
                }
                if ($st['anasayfa'] == '0') {
                    $statusum = '1';
                }

                $guncelle = $db->prepare("UPDATE urun_marka SET
                 anasayfa=:anasayfa
          WHERE id={$stUp}      
         ");
                $sonuc = $guncelle->execute(array(
                    'anasayfa' => $statusum
                ));
                if ($sonuc) {
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=brands' . $searchPage . ''.$pageGet.'');
                } else {
                    echo 'Veritabanı Hatası';
                }

            } else {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=brands');
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=brands');
        }
    }
}
?>
<title><?=$diller['adminpanel-menu-text-5']?> - <?=$panelayar['baslik']?></title>
<style>
    .nav-link{
        color: #000;
        transition-duration: 0.1s; transition-timing-function: linear;
        font-weight: 500;
        font-size: 14px;
        padding: 15px 25px;

    }
    .nav-tabs li:first-child{
        margin-left: 10px;
    }
    .saas:hover{
        background-color: #fff;
        color: #000;
    }
    @media (max-width: 768px) {
        .nav-link{
            color: #000;
            transition-duration: 0.1s; transition-timing-function: linear;
            font-weight: 500;
            font-size: 14px;
            padding: 10px;
        }
        .nav-tabs{
            padding: 15px;
        }
        .nav-tabs li:first-child{
            margin-left: 0;
        }
        .nav-link.active{
            border-color: #dee2e6 #dee2e6 #dee2e6 !important;
            border-radius: 6px !important;
        }
    }
    .ssa:before{
        display: none;
    }
</style>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-2']?></a>
                                <a href="pages.php?page=brands"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-5']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['katalog'] == '1' && $yetki['marka'] == '1') {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $serc = trim(strip_tags(htmlspecialchars($_GET['search'])));
             $search = " where (baslik like '%$serc%' or baslik_seo like '%$serc%' or spot like '%$serc%' or seo_url like '%$serc%') ";
            }else{
                $search = null;
            }
            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from urun_marka  $search");
            $ToplamVeri = $Say->rowCount();
            $Limit = 30;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from urun_marka $search order by sira ASC limit $Goster,$Limit");
            $islemListele = $islemListele->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-5']?></h4>
                                <div>
                                    <?=$diller['adminpanel-form-text-1124']?> : <?=$ToplamVeri?>
                                </div>
                            </div>
                            <div class="new-buttonu-main">
                                <div class="new-buttonu-main">
                                    <a  class="btn btn-success text-white "  data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-1871']?></a>
                                    <div class="dropdown">
                                        <a href="" class="btn btn-light border " type="button" style="font-size: 13px ; font-weight: 400;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right ssa border  " style="margin-top: 4px !important;">
                                            <a class="dropdown-item" href="pages.php?page=theme_brand"  target="_blank" class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-menu-text-98']?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse" id="genelAcc" data-parent="#accordion">
                                <form action="post.php?process=catalog_post2&status=brand_add" method="post" class="border mb-5 " enctype="multipart/form-data">
                                    <div class="text-center bg-white text-dark border-bottom ">
                                        <h5 style="margin-top: 0; padding-top: 10px;"> <?=$diller['adminpanel-form-text-1871']?></h5>
                                    </div>
                                    <!-- Tab Alanı !-->
                                    <ul class="nav nav-tabs bg-light pt-2" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link saas active" id="one-tab" data-toggle="tab" href="#one" role="tab"  aria-selected="true">
                                                <?=$diller['adminpanel-form-text-981']?>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link saas" id="two-tab" data-toggle="tab" href="#two" role="tab"  aria-selected="true">
                                                <?=$diller['adminpanel-text-311']?>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content bg-white rounded-bottom">
                                        <div class="tab-pane active p-5" id="one" role="tabpanel" >
                                            <div class="row border mb-3">
                                                <div class="form-group col-md-6 mt-2 mb-3">
                                                    <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="durum" value="0">
                                                        <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  checked >
                                                        <label class="custom-control-label" for="durum"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 mt-2 mb-3">
                                                    <label  for="anasayfa" class="w-100 d-flex align-items-center justify-content-start" >
                                                        <?=$diller['adminpanel-form-text-1080']?>
                                                        <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1873']?>"></i>
                                                    </label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="anasayfa" value="0">
                                                        <input type="checkbox" class="custom-control-input" id="anasayfa" name="anasayfa" value="1"   >
                                                        <label class="custom-control-label" for="anasayfa"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                                    <input type="number" autocomplete="off"  name="sira" id="sira" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-7">
                                                    <label for="baslik">* <?=$diller['adminpanel-form-text-1869']?></label>
                                                    <input type="text" autocomplete="off"  name="baslik" id="baslik" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-12 mb-0">
                                                    <label for="spot"><?=$diller['adminpanel-form-text-1874']?></label>
                                                    <textarea name="spot" id="spot" class="form-control" rows="2" ></textarea>
                                                </div>
                                                <div class="form-group col-md-12 mt-3">
                                                    <div class="border bg-light p-3 rounded ">
                                                        <label  for="gorsel" class="w-100">* <?=$diller['adminpanel-form-text-1875']?> <small>( png,  jpg, jpeg, gif )</small></label>
                                                        <div class="input-group ">
                                                            <div class="custom-file ">
                                                                <input type="file" class="custom-file-input " id="gorsel" name="gorsel" required >
                                                                <label class="custom-file-label" for="gorsel"  ><?=$diller['adminpanel-form-text-106']?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 mb-0">
                                                    <div class="border bg-light p-3 rounded ">
                                                        <label  for="gorsel_anasayfa" class="w-100">* <?=$diller['adminpanel-form-text-1876']?> <small>( png,  jpg, jpeg, gif )</small></label>
                                                        <div class="input-group ">
                                                            <div class="custom-file ">
                                                                <input type="file" class="custom-file-input " id="gorsel_anasayfa" name="gorsel_anasayfa" required >
                                                                <label class="custom-file-label" for="gorsel_anasayfa"  ><?=$diller['adminpanel-form-text-106']?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-5" id="two" role="tabpanel" >
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="seo_url" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1012']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1014']?>"></i></label>
                                                    <input type="text" autocomplete="off"  name="seo_url" id="seo_url" placeholder="<?=$diller['adminpanel-form-text-1013']?>"  class="form-control">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="seo_baslik" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1015']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1016']?>"></i></label>
                                                    <input type="text" autocomplete="off"  name="seo_baslik" id="seo_baslik"  class="form-control">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="tags2" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                                    <input type="text" name="tags"  id="tags2" data-role="tagsinput" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                                </div>
                                                <div class="form-group col-md-12 mb-0">
                                                    <label  for="meta_desc" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                                    <textarea name="meta_desc" id="meta_desc" class="form-control" rows="2" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  <========SON=========>>> Tab Alanı SON !-->
                                    <div class=" border-top pt-3 bg-light pb-3">
                                        <div class="col-md-12 text-right">
                                            <button class="btn  btn-success " name="brandAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                            <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=brands" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="brands" id="" required class="form-control">
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
                                <form method="post" action="post.php?process=catalog_post2&status=brand_multidelete">
                                <div class="table-responsive ">
                                    <table class="table table-hover mb-0 table-bordered  ">
                                        <thead class="thead-default">
                                        <tr>
                                            <th width="40" class="text-center">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" data-id="chec" class="custom-control-input selectall"  id="hepsiniSecCheckBox"   >
                                                    <label class="custom-control-label" for="hepsiniSecCheckBox"></label>
                                                </div>
                                            </th>
                                            <th></th>
                                            <th><?=$diller['adminpanel-form-text-1869']?></th>
                                            <th></th>
                                            <th class="text-center" style="font-size: 12px ;"><?=$diller['adminpanel-form-text-1080']?></th>
                                            <th><?=$diller['adminpanel-form-text-62']?></th>
                                            <th  class="text-center" width="100"><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody  class="row_position">
                                        <?php foreach ($islemListele as $row) { ?>
                                            <tr id="<?php echo $row['id'] ?>" style="cursor: move">
                                                <td class="text-center">
                                                    <div class="custom-control custom-checkbox" >
                                                        <input type="checkbox" data-id="chec" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                        <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                    </div>
                                                </td>
                                                <td width="65">
                                                    <?php if($row['gorsel'] == !null ) {?>
                                                        <img src="../images/uploads/<?=$row['gorsel']?>" alt="" style="width: 100%">
                                                    <?php }else{ ?>
                                                        <img src="assets/images/no-img.jpg" alt="" style="width: 100%">
                                                    <?php }?>
                                                </td>
                                                <td style="font-weight: 500; min-width: 150px">
                                                    <a  target="_blank" href="<?=$ayar['site_url']?>marka/<?=$row['seo_url']?>/" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1690']?>"><i class="fa fa-external-link-alt"></i></a>
                                                    <?=$row['baslik']?>
                                                </td>
                                                <td width="120" class="text-center">
                                                    <a class="btn btn-sm btn-primary " href="pages.php?page=products&brand=<?=$row['id']?>" target="_blank">
                                                        <div class="d-flex align-items-center">
                                                            <?=$diller['adminpanel-form-text-1872']?>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td style="min-width: 135px" width="135">
                                                 <div class="d-flex align-items-center justify-content-center flex-wrap">

                                                     <?php if($row['anasayfa'] == '0' ) {?>
                                                         <a class="btn btn-sm btn-outline-danger " href="pages.php?page=brands&home_show=<?=$row['id']?><?=$searchPage?><?=$pageGet?>">
                                                             <div class="d-flex align-items-center">
                                                                 <i class="fa fa-times mr-2"></i>
                                                                 <?=$diller['adminpanel-form-text-68']?>
                                                             </div>
                                                         </a>
                                                     <?php }?>
                                                     <?php if($row['anasayfa'] == '1' ) {?>
                                                         <a class="btn btn-sm btn-success " href="pages.php?page=brands&home_show=<?=$row['id']?><?=$searchPage?><?=$pageGet?>">
                                                             <div class="d-flex align-items-center">
                                                                 <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                     <span class="sr-only">Loading...</span>
                                                                 </div>
                                                                 <?=$diller['adminpanel-form-text-67']?>
                                                             </div>
                                                         </a>
                                                     <?php }?>

                                                 </div>
                                                </td>
                                                <td width="85">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-outline-danger " href="pages.php?page=brands&status_update=<?=$row['id']?><?=$searchPage?><?=$pageGet?>">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=brands&status_update=<?=$row['id']?><?=$searchPage?><?=$pageGet?>">
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
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>"  class="btn btn-sm btn-primary duzenleAjax " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=catalog_post2&status=brand_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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
                                <?php if($ToplamVeri > '0') {?>
                                    <div class="w-100 pt-3 pb-3 border-bottom   " >
                                        <button class="btn btn-danger btn-sm pl-4 pr-4 " disabled="disabled" name="deleteMulti" ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                                    </div>
                                </form>
                                <script>
                                    var checkboxes = $("input[data-id='chec']"),
                                        submitButt = $("button[name='deleteMulti']");

                                    checkboxes.click(function() {
                                        submitButt.attr("disabled", !checkboxes.is(":checked"));
                                    });
                                </script>
                                <?php }?>

                                <!---- Sayfalama Elementleri ================== !-->
                                <?php if($ToplamVeri > $Limit  ) {?>
                                    <div id="SayfalamaElementi" class="w-100 p-2  border-bottom bg-light  ">
                                        <?php if($Sayfa >= 1){?>
                                        <nav aria-label="Page navigation example " >
                                            <ul class="pagination pagination-sm justify-content-end mb-0 ">
                                                <?php } ?>
                                                <?php if($Sayfa > 1){  ?>
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=brands<?=$searchPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=brands<?=$searchPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                <?php } ?>
                                                <?php
                                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                    if($i == $Sayfa){
                                                        ?>
                                                        <li class="page-item active " aria-current="page">
                                                            <a class="page-link" href="pages.php?page=brands<?=$searchPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item "><a class="page-link" href="pages.php?page=brands<?=$searchPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                        <?php
                                                    }
                                                }
                                                }
                                                ?>

                                                <?php if($islemListele <=0) { } else { ?>
                                                    <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=brands<?=$searchPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=brands<?=$searchPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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

<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.duzenleAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=brand_edit',
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
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
    });
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

