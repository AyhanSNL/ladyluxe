<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'blogcom';
$_SESSION['modul_comment_url']= 'blog_comments';
$AyarSorgusuComment = $db->prepare("select * from modul_yorum_ayar where id='1' ");
$AyarSorgusuComment->execute();
$yorumAyarRow = $AyarSorgusuComment->fetch(PDO::FETCH_ASSOC);

if (isset($_GET['search']) && $_GET['search'] == !null) {
    $searchPage = "&search=$_GET[search]";
}

if (isset($_GET['blogID']) && $_GET['blogID'] == !null) {
    $blogPage = "&blogID=$_GET[blogID]";
}

if (isset($_GET['status']) && $_GET['status'] == !null && $_GET['status']=='active') {
    $yayinPage = "&status=$_GET[status]";
}
if (isset($_GET['status']) && $_GET['status'] == !null && $_GET['status']=='deactive') {
    $yayinPage = "&status=$_GET[status]";
}

if(isset($_GET['p']) && $_GET['p'] == !null ) {
    $sayfa = '&p='.$_GET['p'].'';
}else{
    $sayfa = null;
}
if(isset($_GET['status_update'])  ) {
if ($yetki['demo'] != '1') {
    if ($_GET['status_update'] == !null) {

        $statusCek = $db->prepare("select * from modul_yorum where id=:id ");
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

            $guncelle = $db->prepare("UPDATE modul_yorum SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
            $sonuc = $guncelle->execute(array(
                'durum' => $statusum
            ));
            if ($sonuc) {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=blog_comments' . $searchPage . ''.$sayfa.''.$yayinPage.''.$blogPage.'');
            } else {
                echo 'Veritabanı Hatası';
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=blog_comments');
        }

    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=blog_comments');
    }
}else{
    header('Location:' . $ayar['panel_url'] . 'pages.php?page=blog_comments');
}
}

?>
<title><?=$diller['adminpanel-menu-text-55']?> - <?=$panelayar['baslik']?></title>
<style>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-41']?></a>
                                <a href="pages.php?page=blog_comments"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-55']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['blog_hizmet'] == '1' ) {

            if(isset($_GET['search']) && $_GET['search']== !null  ) {
                $search = " (icerik like '%$_GET[search]%' or eposta like '%$_GET[search]%' or isim like '%$_GET[search]%') and ";
            }else{
                $search = null;
            }

            if(isset($_GET['status']) && $_GET['status']== !null && $_GET['status']== 'active' ) {
                $yayin = "and durum='1' ";
            }
            if(isset($_GET['status']) && $_GET['status']== !null && $_GET['status']== 'deactive' ) {
                $yayin = "and durum='0' ";
            }
            if(isset($_GET['blogID'])   ) {
                if($_GET['blogID']== !null  ) {
                    $blogide = "and icerik_id='$_GET[blogID]' ";
                }else{
                    header('Location:' . $ayar['panel_url'] . 'pages.php?page=blog_comments' . $searchPage . ''.$sayfa.''.$yayinPage.'');
                }
            }


            $Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
            $Say = $db->query("select * from modul_yorum where $search modul='blog' $yayin $blogide  ");
            $ToplamVeri = $Say->rowCount();
            $Limit = 40;
            $Sayfa_Sayisi = ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
            $Goster = $Sayfa * $Limit - $Limit;
            $GorunenSayfa = 5;
            $islemListele = $db->query("select * from modul_yorum where $search modul='blog' $yayin $blogide order by id DESC limit $Goster,$Limit");
            $islemCek = $islemListele->fetchAll(PDO::FETCH_ASSOC);
            
            /* Onay bekleyenler count */
            $onaybekleyenler = $db->prepare("select * from modul_yorum where modul='blog' $blogide and durum='0' ");
            $onaybekleyenler->execute();
            /*  <========SON=========>>> Onay bekleyenler count SON */


            ?>


            <div class="row">

                    <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top border-bottom pb-2 ">
                            <?php if($yorumAyarRow['blog_durum'] == '0' ) {?>
                            <div class="w-100 border border-danger mb-2 p-3 text-center rounded" style="background-color: #FFF2ED; font-size: 15px ;">
                                <?=$diller['adminpanel-form-text-1125']?>
                            </div>
                            <?php }?>
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-55']?></h4>
                                <?=$diller['adminpanel-form-text-1124']?> <?=$ToplamVeri?>
                            </div>
                            <div class="new-buttonu-main">
                                <a href="javascript:Void(0)" data-id="setting"  class="btn btn-primary text-white duzenleSetAjax " ><i class="fas fa-wrench "></i> <?=$diller['adminpanel-form-text-1097']?></a>
                                <div class="dropdown">
                                    <a href="" class="btn btn-light border " type="button" style="font-size: 13px ; font-weight: 400;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right ssa border  " style="margin-top: 4px !important;">
                                        <a class="dropdown-item" href="pages.php?page=theme_blogs"  target="_blank" class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-menu-text-98']?></a>
                                        <a class="dropdown-item" href="pages.php?page=blogs_categories" target="_blank"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-menu-text-54-2']?></a>
                                        <a class="dropdown-item" href="pages.php?page=blogs" target="_blank"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-menu-text-54']?></a>
                                        <a class="dropdown-item" href="pages.php?page=blog_comments" target="_blank"  class="btn btn-primary mb-1" style="font-size: 13px; font-weight: 400;"> <?=$diller['adminpanel-menu-text-55']?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$ToplamVeri?></h6>
                                        <a href="pages.php?page=blog_comments<?=$yayinPage?>" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="blog_comments" >
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
                        <div class="w-100 mb-2  pt-2 border-top d-flex align-items-center justify-content-start flex-wrap ">
                            <div>
                                <?php
                                if (isset($_GET['status']) && $_GET['status'] == 'active'  ) {
                                    ?>
                                    <a href="pages.php?page=blog_comments<?=$searchPage?><?=$blogPage?>" class="btn btn-primary  m-1 "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1099']?></a>
                                <?php }else { ?>
                                    <a href="pages.php?page=blog_comments&status=active<?=$searchPage?><?=$blogPage?>"  class="btn btn-light m-1 border "><i class="fa fa-check"></i> <?=$diller['adminpanel-form-text-1099']?></a>
                                <?php }?>
                                <?php
                                if (isset($_GET['status']) && $_GET['status'] == 'deactive') {
                                    ?>
                                    <a href="pages.php?page=blog_comments<?=$searchPage?><?=$blogPage?>" class="btn btn-primary  m-1 "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1100']?></a>
                                <?php }else { ?>
                                    <a href="pages.php?page=blog_comments&status=deactive<?=$searchPage?><?=$blogPage?>" class="btn btn-light m-1 border ">
                                        <div class="d-flex align-items-center justify-content-center ">
                                            <div class="spinner-grow text-dark mr-2" role="status" style="width: 10px; height: 10px">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <?=$diller['adminpanel-form-text-1100']?> <span class="badge badge-danger ml-2" style="font-size: 12px ;"><?=$onaybekleyenler->rowCount()?></span>
                                        </div>
                                    </a>
                                <?php }?>
                                <?php if(isset($_GET['blogID']) && $_GET['blogID'] == !null  ) {?>
                                    <a href=""  data-toggle="collapse" data-target="#selectAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-primary  m-1 "><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1103']?></a>
                                <?php }else { ?>
                                    <a  data-toggle="collapse" data-target="#selectAcc" aria-expanded="false" aria-controls="collapseForm" class="btn btn-light m-1 border"><i class="fa fa-pencil-alt"></i> <?=$diller['adminpanel-form-text-1103']?></a>
                                <?php }?>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">
                            <div class="collapse " id="selectAcc" data-parent="#accordion">
                                <?php if (isset($_GET['blogID']) && $_GET['blogID'] == !null) {
                                    $blogSorgu = $db->prepare("select baslik,id,gorsel from blog where id=:id ");
                                    $blogSorgu->execute(array(
                                            'id' => $_GET['blogID'],
                                    ));
                                    $blogRow = $blogSorgu->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php if($blogSorgu->rowCount()>'0'  ) {?>
                                            <div class="row">
                                                <div class="col-md-12 text-left mb-3">
                                                    <div class="border rounded shadow-sm p-2 d-flex align-items-center justify-content-between flex-wrap ">
                                                        <div class="d-flex flex-wrap align-items-center justify-content-start">
                                                            <img src="../images/blog/<?=$blogRow['gorsel']?>" class="mr-4" style="width: 80px">
                                                            <div class="mt-2 mb-2" style="font-size: 15px; font-weight: 500;">
                                                                <?=$blogRow['baslik']?>
                                                            </div>
                                                        </div>
                                                        <a class="btn  btn-danger btn-sm " href="pages.php?page=blog_comments<?=$searchPage?><?=$yayinPage?>"><i class="fa fa-times"></i> <?=$diller['adminpanel-form-text-1114']?></a>
                                                    </div>
                                                </div>
                                            </div>
                                    <script>
                                        $('#selectAcc').addClass('show');
                                        $('html,body').animate({
                                                scrollTop: $('#selectAcc').offset().top - 80 },
                                            0);
                                    </script>
                                    <?php }else { ?>
                                    <?php
                                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=blog_comments' . $searchPage . ''.$sayfa.''.$yayinPage.'');
                                    ?>
                                    <?php }?>
                                <?php }else { ?>
                                    <form action="pages.php" method="get">
                                        <input type="hidden" name="page" value="blog_comments" >
                                        <div class="border  p-3  ml-1 mr-1 mb-2 rounded " style="border:3px solid #CCC !important;">
                                            <div class="row">
                                                <div class="col-md-8 form-group">
                                                    <label for="blogID">* <?=$diller['adminpanel-form-text-1104']?></label>
                                                    <select class="blog_select form-control col-md-12" name="blogID"   id="blogID" style="width: 100%!important;" >
                                                    </select>
                                                </div>
                                                <div class="col-md-12 text-left">
                                                    <button class="btn  btn-primary "><i class="fa fa-filter"></i> <?=$diller['adminpanel-form-text-1090']?></button>
                                                    <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#selectAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php }?>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="w-100  mb-2 ">
                                <form method="post" action="post.php?process=blog_post&status=comment_multidelete">
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
                                            <th><?=$diller['adminpanel-form-text-1109']?></th>
                                            <th><?=$diller['adminpanel-form-text-1106']?></th>
                                            <th><?=$diller['adminpanel-form-text-1107']?></th>
                                            <th><?=$diller['adminpanel-form-text-1081']?></th>
                                            <th><?=$diller['adminpanel-form-text-62']?></th>
                                            <th  class="text-center" ><?=$diller['adminpanel-text-157']?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <style>
                                            .popover-body{
                                                font-size: 12px !important;
                                            }
                                            .popover .arrow{
                                                display: none !important;
                                            }
                                        </style>
                                        <?php foreach ($islemCek as $row) {
                                            $modulBilgi = $db->prepare("select baslik,id,seo_url from blog where id=:id ");
                                            $modulBilgi->execute(array(
                                                    'id' => $row['icerik_id'],
                                            ));
                                            $modulRow = $modulBilgi->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <tr >
                                                <td>
                                                    <div class="custom-control custom-checkbox" >
                                                        <input type="checkbox" class="custom-control-input individual"   id="checkSec-<?=$row['id']?>" name='sil[]' value="<?=$row['id']?>" >
                                                        <label class="custom-control-label" for="checkSec-<?=$row['id']?>" ></label>
                                                    </div>
                                                </td>
                                                <td style="min-width: 150px; " >
                                                    <?php if($modulBilgi->rowCount()>'0'  ) {?>
                                                        <a href="<?=$ayar['site_url']?>blog/<?=$modulRow['seo_url']?>/" target="_blank" class="btn btn-light btn-sm " style="font-weight: 500 !important;">
                                                            <i class="fa fa-external-link-alt"></i>
                                                            <?php echo mb_substr($modulRow['baslik'],0,25, 'UTF-8'); ?>
                                                            <?php if(strlen($modulRow['baslik']) > '25'  ) {?>
                                                                ...
                                                            <?php }?>
                                                        </a>
                                                    <?php }else { ?>
                                                    <div class="btn btn-sm btn-outline-secondary">
                                                      <i class="fa fa-exclamation-triangle"></i>  <?=$diller['adminpanel-form-text-1123']?>
                                                    </div>
                                                    <?php }?>
                                                </td>
                                                <td style="min-width: 150px">
                                                    <?=$row['isim']?>
                                                </td>
                                                <td style="min-width: 150px" >
                                                    <?=$row['eposta']?>
                                                </td>
                                                <td style="min-width: 150px; font-size: 12px ;" >
                                                   <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                                </td>
                                                <td width="125" style="min-width: 125px">
                                                    <?php if($row['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-secondary " href="pages.php?page=blog_comments&status_update=<?=$row['id']?><?=$searchPage?><?=$sayfa?><?=$yayinPage?><?=$blogPage?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1102']?>">
                                                            <div class="d-flex align-items-center">
                                                                <div class="spinner-grow text-white mr-2" role="status" style="width: 10px; height: 10px">
                                                                    <span class="sr-only">Loading...</span>
                                                                </div>
                                                                <?=$diller['adminpanel-form-text-1101']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($row['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=blog_comments&status_update=<?=$row['id']?><?=$searchPage?><?=$sayfa?><?=$yayinPage?><?=$blogPage?>">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-check mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-1098']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                </td>
                                                <td class="text-right" style="min-width: 135px" width="135">
                                                    <a href="javascript:Void(0)" data-id="<?=$row['id']?>" class="btn btn-sm btn-primary duzenleAjax" ><i class="fa fa-eye" ></i>  <?=$diller['adminpanel-form-text-1108']?></a>
                                                    <a href="" data-href="post.php?process=blog_post&status=comment_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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


                                <?php if($ToplamVeri > '0') {?>
                                    <div class="w-100 pt-3 pb-3 border-bottom border-top  " >
                                        <button class="btn btn-danger btn-sm rounded-0 shadow-lg pl-4 pr-4 m-1 " name="multidelete"  ><i class="fa fa-trash"></i> <?=$diller['adminpanel-text-158']?></button>
                                        <button class="btn btn-success btn-sm rounded-0 shadow-lg pl-4 pr-4  m-1" name="active"  ><?=$diller['adminpanel-text-347']?></button>
                                        <button class="btn btn-secondary btn-sm rounded-0 shadow-lg pl-4 pr-4  m-1" name="deactive"  > <?=$diller['adminpanel-text-348']?></button>
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
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=blog_comments<?=$searchPage?><?=$yayinPage?><?=$blogPage?>"><?=$diller['sayfalama-ilk']?></a></li>
                                                    <li class="page-item "><a class="page-link " href="pages.php?page=blog_comments<?=$searchPage?><?=$yayinPage?><?=$blogPage?>&p=<?=$Sayfa - 1?>"><?=$diller['sayfalama-onceki']?></a></li>
                                                <?php } ?>
                                                <?php
                                                for($i = $Sayfa - $GorunenSayfa; $i < $Sayfa + $GorunenSayfa +1; $i++){ if($i > 0 and $i <= $Sayfa_Sayisi){
                                                    if($i == $Sayfa){
                                                        ?>
                                                        <li class="page-item active " aria-current="page">
                                                            <a class="page-link" href="pages.php?page=blog_comments<?=$searchPage?><?=$yayinPage?><?=$blogPage?>&p=<?=$i?>"><?=$i?><span class="sr-only">(current)</span></a>
                                                        </li>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <li class="page-item "><a class="page-link" href="pages.php?page=blog_comments<?=$searchPage?><?=$yayinPage?><?=$blogPage?>&p=<?=$i?>"><?=$i?></a></li>
                                                        <?php
                                                    }
                                                }
                                                }
                                                ?>

                                                <?php if($islemListele->rowCount() <=0) { } else { ?>
                                                    <?php if($Sayfa != $Sayfa_Sayisi){?>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=blog_comments<?=$searchPage?><?=$yayinPage?><?=$blogPage?>&p=<?=$Sayfa + 1?>"><?=$diller['sayfalama-sonraki']?></a></li>
                                                        <li class="page-item"><a class="page-link" href="pages.php?page=blog_comments<?=$searchPage?><?=$yayinPage?><?=$blogPage?>&p=<?=$Sayfa_Sayisi?>"><?=$diller['sayfalama-son']?></a></li>
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
                url: 'masterpiece.php?page=blog_comments_edit',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
        $('.duzenleSetAjax').click(function(){

            var postID = $(this).data('id');

            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=modul_comment_settings',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable-settings').html(response);
                    $('#duzenle-settings').modal('show');
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
    $(function () {
        $('#selectAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#selectAcc').offset().top - 80 },
                500);
        });
    });
</script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.blog_select').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-1105']?>',
            ajax: {
                url: 'masterpiece.php?page=blog_select',
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