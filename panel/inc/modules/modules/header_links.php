<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'header';
$urladdress = 'sss/';

if(isset($_GET['search'])  ) {
    if($_GET['search'] == null  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=header_links');
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

                $query = $db->query("UPDATE header_menu SET sira = '$count' WHERE id = '$idler2'");
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

        $statusCek = $db->prepare("select * from header_menu where id=:id ");
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

            $guncelle = $db->prepare("UPDATE header_menu SET
                 durum=:durum
          WHERE id={$_GET['status_update']}      
         ");
            $sonuc = $guncelle->execute(array(
                'durum' => $statusum
            ));
            if ($sonuc) {
                header('Location:' . $ayar['panel_url'] . 'pages.php?page=header_links' . $searchPage . '');
            } else {
                echo 'Veritabanı Hatası';
            }

        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=header_links');
        }

    } else {
        header('Location:' . $ayar['panel_url'] . 'pages.php?page=header_links');
    }
}
}
?>
<title><?=$diller['adminpanel-menu-text-46']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=header_links"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-46']?></a>
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

            $headerMenus = $db->prepare("select * from header_menu where  $search dil='$_SESSION[dil]' and ust_id='0'  order by sira asc ");
            $headerMenus->execute(array());


            $sabitButon = $db->prepare("select * from header_sabit_buton where dil=:dil ");
            $sabitButon->execute(array(
                    'dil' => $_SESSION['dil']
            ));
            $sabitB = $sabitButon->fetch(PDO::FETCH_ASSOC);


            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-6<?php }else{?>col-md-9<?php } ?>">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <h4> <?=$diller['adminpanel-menu-text-46']?></h4>
                            </div>
                            <div class="new-buttonu-main">
                                <a  class="btn btn-info text-white  " href="post.php?process=header_links_post&status=theme_settings"><?=$diller['adminpanel-form-text-838']?></a>
                                <a  class="btn btn-success text-white "  href="pages.php?page=new_header_link_add"><i class="fas fa-plus-circle "></i> <?=$diller['adminpanel-form-text-852']?></a>
                            </div>
                        </div>
                        <!-- Search Form !-->
                        <div class="w-100 pt-2 pb-2  bg-white  mb-2 ">
                            <div class="row ">
                                <div class="col-md-7 ">
                                    <?php if(isset($_GET['search'])  && $_GET['search']==!null ) {?>
                                        <h6><?=$diller['adminpanel-text-161']?> : <?=$headerMenus->rowCount()?></h6>
                                        <a href="pages.php?page=header_links" class="btn btn-sm btn-info shadow"><?=$_GET['search']?> <i class="fa fa-times"></i></a>
                                    <?php }?>
                                </div>
                                <div class="col-md-5 text-right">
                                    <form method="GET" action="pages.php">
                                        <div class="input-group ">
                                            <input type="hidden" name="page" value="header_links" id="" required class="form-control">
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

                                            $altmenuSayisi = $db->prepare("select * from header_menu where ust_id=:ust_id ");
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
                                                <td style="min-width: 165px">
                                                    <a href="pages.php?page=header_sub_links&parent=<?=$menuRows['id']?>" class="btn btn-sm alert-warning border border-warning text-dark  rounded">
                                                        <i class="mdi mdi-buffer"></i>   <?=$diller['adminpanel-form-text-864']?> (<?=$altmenuSayisi->rowCount()?>)
                                                    </a>
                                                </td>
                                                <td width="85">

                                                    <?php if($menuRows['durum'] == '0' ) {?>
                                                        <a class="btn btn-sm btn-outline-danger " href="pages.php?page=header_links&status_update=<?=$menuRows['id']?><?=$searchPage?>">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-times mr-2"></i>
                                                                <?=$diller['adminpanel-form-text-68']?>
                                                            </div>
                                                        </a>
                                                    <?php }?>
                                                    <?php if($menuRows['durum'] == '1' ) {?>
                                                        <a class="btn btn-sm btn-success " href="pages.php?page=header_links&status_update=<?=$menuRows['id']?><?=$searchPage?>">
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
                                                    <a href="pages.php?page=header_links_edit&link_id=<?=$menuRows['id']?>"  class="btn btn-sm btn-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-text-159']?>"><i class="fa fa-eye" ></i></a>
                                                    <a href="" data-href="post.php?process=header_links_post&status=delete&no=<?=$menuRows['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger "><i class="fa fa-trash" ></i></a>
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


                <div class="col-md-3">
                    <div class="card p-3">
                        <div class="in-header-page-main" >
                            <div class="in-header-page-text">
                                <?=$diller['adminpanel-form-text-862']?>
                            </div>
                        </div>
                        <div>
                            <?php if($sabitButon->rowCount()>'0'  ) {?>
                                <form method="post" action="post.php?process=header_links_post&status=fixed_button_update">
                                    <input type="hidden" name="button_id_number" value="<?=$sabitB['id']?>" >
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-843']?></label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="durum" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" <?php if($sabitB['durum'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                <label class="custom-control-label" for="durum"></label>
                                            </div>
                                        </div>
                                        <div id="actionBox" class="w-100 col-md-12  mt-2" <?php if($sabitB['durum'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="sabit_baslik"><?=$diller['adminpanel-form-text-849']?></label>
                                                    <input type="text" name="baslik" value="<?=$sabitB['baslik']?>" id="sabit_baslik" required  class="form-control ">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="renk"><?=$diller['adminpanel-form-text-863']?></label>
                                                    <select name="renk" class="form-control select2" id="renk" required style="width: 100%">
                                                        <option value="button-black-white" <?php if($sabitB['renk'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                        <option value="button-white-black" <?php if($sabitB['renk'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                        <option value="button-yellow" <?php if($sabitB['renk'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                        <option value="button-yellow-out" <?php if($sabitB['renk'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                        <option value="button-black" <?php if($sabitB['renk'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                        <option value="button-black-out" <?php if($sabitB['renk'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                        <option value="button-white" <?php if($sabitB['renk'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                        <option value="button-white-out" <?php if($sabitB['renk'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                        <option value="button-gold" <?php if($sabitB['renk'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                        <option value="button-gold-out" <?php if($sabitB['renk'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                        <option value="button-red" <?php if($sabitB['renk'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                        <option value="button-red-out" <?php if($sabitB['renk'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                        <option value="button-blue" <?php if($sabitB['renk'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                        <option value="button-blue-out" <?php if($sabitB['renk'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                        <option value="button-yellow" <?php if($sabitB['renk'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                        <option value="button-yellow-out" <?php if($sabitB['renk'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                        <option value="button-green" <?php if($sabitB['renk'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                        <option value="button-green-out" <?php if($sabitB['renk'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                        <option value="button-grey" <?php if($sabitB['renk'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                        <option value="button-grey-out" <?php if($sabitB['renk'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                        <option value="button-orange" <?php if($sabitB['renk'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                        <option value="button-orange-out" <?php if($sabitB['renk'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                        <option value="button-pink" <?php if($sabitB['renk'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 mb-0">
                                                    <label for="url_tur_sabit"><?=$diller['adminpanel-form-text-856']?></label>
                                                    <select name="url_tur_sabit" class="form-control rounded-0" id="url_tur_sabit" required style="height: 55px">
                                                        <option value="0" <?php if($sabitB['url_tur'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-860']?></option>
                                                        <option value="1" <?php if($sabitB['url_tur'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-853']?></option>
                                                        <option value="2" <?php if($sabitB['url_tur'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-854']?></option>
                                                    </select>
                                                </div>
                                                <div id="modul-choise-sabit" class="col-md-12 " <?php if($sabitB['url_tur'] !='1' ) { ?>style="display: none;"<?php }?>>
                                                    <div class="w-100 p-2 border bg-light  ">
                                                        <div class="w-100 ">
                                                            <select name="modul_url" class="select2 form-control rounded-0" id="modul_url"  style="height: 55px">
                                                                <?php
                                                                $urladdress = $sabitB['url'];
                                                                ?>
                                                                <?php include 'inc/modules/_helper/site_linkleri.php'; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="manuel-choise-sabit" class="col-md-12 " <?php if($sabitB['url_tur'] !='2' ) { ?>style="display: none;"<?php }?>   >
                                                    <div class="w-100 p-2 border bg-light  ">
                                                        <div class="w-100">
                                                            <input type="text" name="manuel_url" autocomplete="off" placeholder="https://" value="<?=$sabitB['url']?>"  class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 mt-3 ">
                                                    <label  for="yeni_sekme_2" class="w-100" ><?=$diller['adminpanel-form-text-111']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="yeni_sekme_2" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="yeni_sekme_2" name="yeni_sekme_2" value="1"  <?php if($sabitB['yeni_sekme'] == '1'  ) { ?>checked<?php }?> ">
                                                        <label class="custom-control-label" for="yeni_sekme_2"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group mb-0 mt-3">
                                            <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                        </div>
                                    </div>
                                </form>
                            <?php }else { ?>
                                <form method="post" action="post.php?process=header_links_post&status=fixed_button_add">
                                        <input type="hidden" name="button_id_number" value="<?=$sabitB['id']?>" >
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-843']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" <?php if($sabitB['durum'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                            <div id="actionBox" class="w-100 col-md-12  mt-2" <?php if($sabitB['durum'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="sabit_baslik"><?=$diller['adminpanel-form-text-849']?></label>
                                                        <input type="text" name="baslik" value="<?=$sabitB['baslik']?>" id="sabit_baslik" required  class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="renk"><?=$diller['adminpanel-form-text-863']?></label>
                                                        <select name="renk" class="form-control select2" id="renk" required style="width: 100%">
                                                            <option value="button-black-white" <?php if($sabitB['renk'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                            <option value="button-white-black" <?php if($sabitB['renk'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                            <option value="button-yellow" <?php if($sabitB['renk'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                            <option value="button-yellow-out" <?php if($sabitB['renk'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                            <option value="button-black" <?php if($sabitB['renk'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                            <option value="button-black-out" <?php if($sabitB['renk'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                            <option value="button-white" <?php if($sabitB['renk'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                            <option value="button-white-out" <?php if($sabitB['renk'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                            <option value="button-gold" <?php if($sabitB['renk'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                            <option value="button-gold-out" <?php if($sabitB['renk'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                            <option value="button-red" <?php if($sabitB['renk'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                            <option value="button-red-out" <?php if($sabitB['renk'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                            <option value="button-blue" <?php if($sabitB['renk'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                            <option value="button-blue-out" <?php if($sabitB['renk'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                            <option value="button-yellow" <?php if($sabitB['renk'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                            <option value="button-yellow-out" <?php if($sabitB['renk'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                            <option value="button-green" <?php if($sabitB['renk'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                            <option value="button-green-out" <?php if($sabitB['renk'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                            <option value="button-grey" <?php if($sabitB['renk'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                            <option value="button-grey-out" <?php if($sabitB['renk'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                            <option value="button-orange" <?php if($sabitB['renk'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                            <option value="button-orange-out" <?php if($sabitB['renk'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                            <option value="button-pink" <?php if($sabitB['renk'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12 mb-0">
                                                        <label for="url_tur_sabit"><?=$diller['adminpanel-form-text-856']?></label>
                                                        <select name="url_tur_sabit" class="form-control rounded-0" id="url_tur_sabit" required style="height: 55px">
                                                            <option value="0" <?php if($sabitB['url_tur'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-860']?></option>
                                                            <option value="1" <?php if($sabitB['url_tur'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-853']?></option>
                                                            <option value="2" <?php if($sabitB['url_tur'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-854']?></option>
                                                        </select>
                                                    </div>
                                                    <div id="modul-choise-sabit" class="col-md-12 " <?php if($sabitB['url_tur'] !='1' ) { ?>style="display: none;"<?php }?>>
                                                        <div class="w-100 p-2 border bg-light  ">
                                                            <div class="w-100 ">
                                                                <select name="modul_url" class="select2 form-control rounded-0" id="modul_url"  style="height: 55px">
                                                                    <?php
                                                                    $urladdress = $sabitB['url'];
                                                                    ?>
                                                                    <?php include 'inc/modules/_helper/site_linkleri.php'; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="manuel-choise-sabit" class="col-md-12 " <?php if($sabitB['url_tur'] !='2' ) { ?>style="display: none;"<?php }?>   >
                                                        <div class="w-100 p-2 border bg-light  ">
                                                            <div class="w-100">
                                                                <input type="text" name="manuel_url" placeholder="https://" value="<?=$sabitB['url']?>"  class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12 mt-3 ">
                                                        <label  for="yeni_sekme_2" class="w-100" ><?=$diller['adminpanel-form-text-111']?></label>
                                                        <div class="custom-control custom-switch custom-switch-lg">
                                                            <input type="hidden" name="yeni_sekme_2" value="0"">
                                                            <input type="checkbox" class="custom-control-input" id="yeni_sekme_2" name="yeni_sekme_2" value="1"  <?php if($sabitB['yeni_sekme'] == '1'  ) { ?>checked<?php }?> ">
                                                            <label class="custom-control-label" for="yeni_sekme_2"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 form-group mb-0 mt-3">
                                                <button class="btn  btn-success btn-block" name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                            </div>
                                        </div>
                                </form>
                            <?php }?>

                        </div>
                    </div>
                </div>





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
    $('#menu_sablon').on('change', function() {
        $('#sablon1_secim').css('display', 'none');
        if ( $(this).val() === '1' ) {
            $('#sablon1_secim').css('display', 'block');
        }
        $('#sablon2_secim').css('display', 'none');
        if ( $(this).val() === '2' ) {
            $('#sablon2_secim').css('display', 'block');
        }
    });

    $('#url_tur_sabit').on('change', function() {
        $('#modul-choise-sabit').css('display', 'none');
        if ( $(this).val() === '1' ) {
            $('#modul-choise-sabit').css('display', 'block');
        }
        $('#manuel-choise-sabit').css('display', 'none');
        if ( $(this).val() === '2' ) {
            $('#manuel-choise-sabit').css('display', 'block');
        }
    });
</script>
<script id="rendered-js" >
    function actionBox(selected)
    {
        if (selected)
        {
            document.getElementById("actionBox").style.display = "";
        } else

        {
            document.getElementById("actionBox").style.display = "none";
        }

    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>