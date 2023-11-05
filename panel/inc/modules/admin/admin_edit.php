<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'admin';
$yoneticiCek = $db->prepare("select * from yonetici where random_id=:random_id ");
$yoneticiCek->execute(array(
        'random_id' => trim(strip_tags($_GET['no'])),
));
$yoneticiRow = $yoneticiCek->fetch(PDO::FETCH_ASSOC);
?>
<?php if($yoneticiCek->rowCount()>'0'  ) {?>
<title><?=$diller['adminpanel-text-165']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-151']?></a>
                                <a href="pages.php?page=admin_list"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-156']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-text-165']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['yonetici'] == '1') {?>

        <form action="post.php?process=admin_post&status=admin_edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="admin_no" value="<?=$yoneticiRow['random_id']?>" >
            <div class="row">
                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>
                <?php
                $yetkiList = $db->prepare("select * from yetki_grup order by sira asc ");
                $yetkiList->execute();
                ?>
                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-6<?php }else{?>col-md-9<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100  pb-2 mb-2 border-bottom d-flex align-items-center justify-content-between flex-wrap">
                            <h4> <?=$diller['adminpanel-text-165']?></h4>
                            <a href="pages.php?page=admin_list" class="btn btn-outline-dark btn-sm mb-2"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                        </div>
                        <div class="w-100">
                            <div class="row mt-3">
                                <div class=" col-md-12">
                                    <div class="form-group">
                                        <label for="tarih">* <?=$diller['adminpanel-form-text-54']?></label>
                                        <input type="text" name="tarih" id="tarih" value="<?php echo date_tr('j F Y, H:i, l ', ''.$yoneticiRow['tarih'].''); ?>" readonly required class="form-control border-info bg-info text-white " autocomplete="off">
                                    </div>
                                    <div class="form-group ">
                                        <label for="yetki">* <?=$diller['adminpanel-form-text-52']?></label>
                                        <select name="yetki" class="form-control" id="yetki" required>
                                            <?php foreach ($yetkiList as $yetkiRow) {?>
                                                <option value="<?=$yetkiRow['id']?>" <?php if($yoneticiRow['yetki'] == $yetkiRow['id'] ) { ?>selected<?php }?>><?=$yetkiRow['baslik']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_adi">* <?=$diller['adminpanel-form-text-45']?></label>
                                        <input type="text" name="user_adi" id="user_adi" value="<?=$yoneticiRow['user_adi']?>" required class="form-control bg-light" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="pass_sifre" class="w-100 d-flex align-items-center justify-content-between">* <?=$diller['adminpanel-form-text-46']?> <br><small><?=$diller['adminpanel-text-166']?></small></label>
                                        <input type="text" name="pass_sifre" id="pass_sifre"  class="form-control bg-light" autocomplete="off">
                                    </div>
                                    <div class="row">
                                        <div class="form-group  col-md-6">
                                            <label for="isim">* <?=$diller['adminpanel-form-text-47']?></label>
                                            <input type="text" name="isim" id="isim" value="<?=$yoneticiRow['isim']?>" required class="form-control " autocomplete="off">
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label for="soyisim">* <?=$diller['adminpanel-form-text-48']?></label>
                                            <input type="text" name="soyisim" id="soyisim" value="<?=$yoneticiRow['soyisim']?>" required class="form-control " autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="card mb-3 ">
                        <div class="card-body">
                            <div class="w-100 d-flex align-items-center justify-content-between flex-wrap border-bottom mb-2">
                                <h6><?=$diller['adminpanel-form-text-49']?></h6>
                                <small><?=$diller['adminpanel-form-text-51']?></small>
                            </div>
                            <div class="w-100 bg-light p-3 text-center mb-3 ">
                                <?php if($yoneticiRow['foto'] == !null  ) {?>
                                    <img src="assets/images/uploads/<?=$yoneticiRow['foto']?>" class="rounded-circle" style="width: 128px; height: 128px">
                                    <br><br>
                                    <a href="" data-href="post.php?process=admin_post&status=ppdelete&no=<?=$yoneticiRow['random_id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                    <input type="hidden" name="old_img" value="<?=$yoneticiRow['foto']?>">
                                <?php }else { ?>
                                    <img src="assets/images/users/avatar-1.jpg" class="rounded-circle ">
                                <?php }?>
                            </div>

                            <div class="w-100">
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="foto" >
                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-50']?></label>
                                    </div>
                                </div>
                                <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                    <small>png,  jpg, gif, svg</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card  ">
                        <div class="card-body">
                            <button name="adminEdit" class="btn btn-success pl-4 pr-4 btn-block ">
                                <?=$diller['adminpanel-form-text-53']?>
                            </button>
                        </div>
                    </div>
                </div>

                <!--  <========SON=========>>> Contents SON !-->

            </div>
        </form>




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
<?php }else {
header('Location:'.$ayar['panel_url'].'pages.php?page=admin_list');
}?>