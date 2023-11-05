<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'tophtml';







?>
<title><?=$diller['adminpanel-menu-text-44']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=tophtml_area"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-44']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['modul'] == '1' &&  $yetki['modul_header_footer'] == '1') {

            $topHTMLSorgu = $db->prepare("select * from headertop_html where dil=:dil ");
            $topHTMLSorgu->execute(array(
                'dil' => $_SESSION['dil'],
            ));

            ?>


            <div class="row ">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2">
                            <h4> <?=$diller['adminpanel-menu-text-44']?></h4>
                        </div>
                        <div class="w-100">
                            <div class="w-100 p-3  text-dark  rounded-top  border shadow-xl border-bottom-0 d-flex align-items-center justify-content-start " style="font-size: 14px ;">
                              <i class="mdi mdi-information-outline mr-1 " style="font-size: 16px ;"></i> <?=$diller['adminpanel-form-text-842']?>
                            </div>
                            <div class="w-100  pl-3 pr-3  mb-3 border rounded-bottom shadow-sm">

                                <?php if($topHTMLSorgu->rowCount()>'0'  ) {
                                    $detay = $topHTMLSorgu->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <!-- Update !-->
                                    <form action="post.php?process=tophtml_area_post&status=update" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="update_id" value="<?=$detay['id']?>" >
                                        <div class="row bg-light pt-3 pb-3  ">
                                            <div class="form-group col-md-3 mb-0 ">
                                                <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                        <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                        <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3">
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" <?php if($detay['durum'] == '1' ) { ?>checked<?php }?>   ">
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="mobil" class="w-100" ><?=$diller['adminpanel-form-text-894']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="mobil" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="mobil" name="mobil" value="1" <?php if($detay['mobil'] == '1' ) { ?>checked<?php }?>   ">
                                                    <label class="custom-control-label" for="mobil"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 ">
                                            <div class="form-group col-md-12 mb-3">
                                                <label for="icerik"><?=$diller['adminpanel-form-text-848']?></label>
                                                <textarea name="icerik" id="tiny"><?=$detay['icerik']?></textarea>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light">
                                            <div class="form-group col-md-3">
                                                <label for="arkaplan"><?=$diller['adminpanel-form-text-254']?></label>
                                                <div data-color-format="default" data-color="#<?=$detay['arkaplan']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="arkaplan"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="text_color"><?=$diller['adminpanel-form-text-844']?></label>
                                                <div data-color-format="default" data-color="#<?=$detay['text_color']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="text_color"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="a_color"><?=$diller['adminpanel-form-text-845']?></label>
                                                <div data-color-format="default" data-color="#<?=$detay['a_color']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="a_color"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="a_hover_color"><?=$diller['adminpanel-form-text-846']?></label>
                                                <div data-color-format="default" data-color="#<?=$detay['a_hover_color']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="a_hover_color"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="padding"><?=$diller['adminpanel-form-text-847']?></label>
                                                <input type="number" name="padding" id="padding" value="<?=$detay['padding']?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--  <========SON=========>>> Update SON !-->
                                <?php }else { ?>
                                    <!-- Insert !-->
                                    <form action="post.php?process=tophtml_area_post&status=add" method="post" enctype="multipart/form-data">
                                        <div class="row bg-light pt-3 pb-3  ">
                                            <div class="form-group col-md-3 mb-0 ">
                                                <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                        <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                        <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3">
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="durum" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="durum" name="durum" checked value="1"   ">
                                                    <label class="custom-control-label" for="durum"></label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 mb-4">
                                                <label  for="mobil" class="w-100" ><?=$diller['adminpanel-form-text-894']?></label>
                                                <div class="custom-control custom-switch custom-switch-lg">
                                                    <input type="hidden" name="mobil" value="0"">
                                                    <input type="checkbox" class="custom-control-input" id="mobil" name="mobil" value="1"   ">
                                                    <label class="custom-control-label" for="mobil"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 ">
                                            <div class="form-group col-md-12 mb-3">
                                                <label for="icerik"><?=$diller['adminpanel-form-text-848']?></label>
                                                <textarea name="icerik" id="tiny"><?=$detay['icerik']?></textarea>
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light">
                                            <div class="form-group col-md-3">
                                                <label for="arkaplan"><?=$diller['adminpanel-form-text-254']?></label>
                                                <div data-color-format="default" data-color="#<?=$detay['arkaplan']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="arkaplan"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="text_color"><?=$diller['adminpanel-form-text-844']?></label>
                                                <div data-color-format="default" data-color="#<?=$detay['text_color']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="text_color"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="a_color"><?=$diller['adminpanel-form-text-845']?></label>
                                                <div data-color-format="default" data-color="#<?=$detay['a_color']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="a_color"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="a_hover_color"><?=$diller['adminpanel-form-text-846']?></label>
                                                <div data-color-format="default" data-color="#<?=$detay['a_hover_color']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="a_hover_color"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="padding"><?=$diller['adminpanel-form-text-847']?></label>
                                                <input type="number" name="padding" id="padding" value="<?=$detay['padding']?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row border-top pt-3 bg-light pb-3">
                                            <div class="col-md-12 text-right">
                                                <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--  <========SON=========>>> Insert SON !-->
                                <?php }?>


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

