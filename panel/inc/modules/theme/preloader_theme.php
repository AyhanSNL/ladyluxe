<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'loader';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$sayfaSorgu = $db->prepare("select * from loader where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-123']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=preloader"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-123']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['tema_ayarlar'] == '1' ) {?>
            <div class="row">

                <!-- Contents !-->
                <div class="col-md-9">
                        <!-- Düzen Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2  ">
                                    <h4><?=$diller['adminpanel-menu-text-123']?></h4>
                                </div>
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_preloader_post&status=main_update" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-517']?></label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="durum" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" <?php if($detay['durum'] != '0'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                        <label class="custom-control-label" for="durum"></label>
                                                    </div>
                                                </div>
                                                <div id="actionBox" class="w-100 col-md-12 mb-4 " <?php if($detay['durum'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="back_color"><?=$diller['adminpanel-form-text-295']?></label>
                                                            <div data-color-format="default" data-color="#<?=$detay['back_color']?>"  class="colorpicker-default input-group">
                                                                <input type="text" name="back_color"  value="" class="form-control">
                                                                <div class="input-group-append add-on">
                                                                    <button class="btn btn-light border" type="button">
                                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="delay"><?=$diller['adminpanel-form-text-518']?></label>
                                                            <input type="number" name="delay" id="delay" value="<?=$detay['delay']?>" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="inputGroupFile01"><?=$diller['adminpanel-form-text-520']?></label>
                                                            <div class="w-100  p-3 text-center mb-3 " style="background-color: #<?=$detay['back_color']?>;">
                                                                <?php if($detay['icon'] == !null  ) {?>
                                                                    <small class="text-dark bg-white p-1 rounded pl-3 pr-3">
                                                                        <?=$diller['adminpanel-form-text-521']?>
                                                                    </small>
                                                                    <br><br>
                                                                    <img src="<?=$ayar['site_url']?>images/loader/<?=$detay['icon']?>" class="img-fluid" >
                                                                    <br><br>
                                                                    <small class="bg-white p-1 rounded pl-3 pr-3">
                                                                        <?=$diller['adminpanel-form-text-89']?> : 85x85
                                                                    </small>
                                                                <?php }else{ ?>
                                                                    <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                                    <br><br>

                                                                    <small class="bg-white p-1 rounded pl-3 pr-3">
                                                                        <?=$diller['adminpanel-form-text-89']?> : 85x85
                                                                    </small>
                                                                <?php }?>
                                                            </div>
                                                            <div class="w-100">
                                                                <input type="hidden" name="old_icon" value="<?=$detay['icon']?>" >
                                                                <div class="input-group mb-3">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="icon" >
                                                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                                                    <small>png,  jpg, jpeg, svg, gif</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12 form-group mb-0">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Düzen Ayarları  SON !-->
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