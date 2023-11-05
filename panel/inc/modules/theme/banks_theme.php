<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'bank';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$fontlar2 = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar2->execute();
$fontlar3 = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar3->execute();
$sayfaSorgu = $db->prepare("select * from ayarlar where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-133']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_banks"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-133']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['tema_ayarlar'] == '1' ) {?>
            <div class="row">

                <!-- Nav Menu !-->
                    <div class="col-md-3 d-none d-md-inline-block" id="sidebarWrap" style="overflow: hidden; position: relative">
                        <div id="sidebar" class="mr-3">
                            <div class="btn-group w-100 d-flex flex-wrap" role="group">
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0 <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?>" type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-form-text-551']?>
                                </button>
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'otherAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#otherAcc" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-form-text-552']?>
                                </button>
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'otherAcc2'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#otherAcc2" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-form-text-553']?>
                                </button>
                            </div>

                        </div>
                    </div>
                    <!-- Mobile !-->
                    <div class="col-md-3 d-md-none d-sm-inline-block ">
                        <a class="btn btn-pink mo-mb-2 btn-block d-flex align-items-center justify-content-between" data-toggle="collapse" href="#navigasyon" aria-expanded="false" aria-controls="collapseExample">
                            <?=$diller['adminpanel-text-269']?> <i class="fa fa-plus"></i>
                        </a>
                        <div class="collapse mb-3" id="navigasyon">
                            <div class="btn-group w-100 d-flex flex-wrap" role="group">
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0 <?php if(isset($_SESSION['collepse_status'])   ) { ?><?php if($_SESSION['collepse_status'] == 'genelAcc'  ) { ?>active<?php }?><?php }else{ ?> active<?php } ?>" type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-form-text-551']?>
                                </button>
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'otherAcc'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#otherAcc" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-form-text-552']?>
                                </button>
                                <button class="btn btn-lg card btn-block text-left pt-3 pb-3 mb-0 mt-0  <?php if($_SESSION['collepse_status'] == 'otherAcc2'  ) { ?>active<?php }?>" type="button" data-toggle="collapse" data-target="#otherAcc2" aria-expanded="false" aria-controls="collapseForm">
                                    <?=$diller['adminpanel-form-text-553']?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!--  <========SON=========>>> Mobile SON !-->
                <!--  <========SON=========>>> Nav Menu SON !-->

                <!-- Contents !-->
                <div class="col-md-6">

                    <div id="accordion" class="accordion">
                        <!-- Banks  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#genelAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-551']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3 ">
                                        <form action="post.php?process=theme_banks_post&status=banks_update" method="post" >
                                            <div class="row">
											   <div class="form-group col-md-6">
                                                    <label for="banka_sayfa_bg"><?=$diller['adminpanel-form-text-555']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['banka_sayfa_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="banka_sayfa_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="banka_sayfa_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="banka_sayfa_font" class="form-control" id="banka_sayfa_font" >
                                                        <?php foreach ($fontlar as $font) {?>
                                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $detay['banka_sayfa_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-12 mb-4">
                                                    <label  for="banka_sayfa_nav" class="w-100 d-flex justify-content-start align-items-center flex-wrap">
                                                        <?=$diller['adminpanel-form-text-516']?>
                                                        <a href="pages.php?page=sub_navigations" class="text-pink ml-2" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                                                    </label>
                                                    <div class="custom-control custom-switch custom-switch-lg">
                                                        <input type="hidden" name="banka_sayfa_nav" value="0"">
                                                        <input type="checkbox" class="custom-control-input" id="banka_sayfa_nav" name="banka_sayfa_nav" value="1" <?php if($detay['banka_sayfa_nav'] == '1'  ) { ?>checked<?php }?> >
                                                        <label class="custom-control-label" for="banka_sayfa_nav"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-text-311']?> <i class="ti-help-alt text-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-556']?>"></i>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="form-group col-md-12">
                                                    <label  for="banka_sayfa_tags" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                                    <input type="text" name="banka_sayfa_tags" value="<?=$detay['banka_sayfa_tags']?>" id="banka_sayfa_tags" data-role="tagsinput" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="banka_sayfa_desc" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                                    <textarea name="banka_sayfa_desc" id="banka_sayfa_desc" class="form-control" rows="2" ><?=$detay['banka_sayfa_desc']?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group mb-0">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Banks  SON !-->


                        <!-- Odeme Bildirim  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#otherAcc" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-552']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="otherAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3 mt-3">
                                        <form action="post.php?process=theme_banks_post&status=payment_report" method="post" >
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="odeme_bildirim_bg"><?=$diller['adminpanel-form-text-295']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['odeme_bildirim_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="odeme_bildirim_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="odeme_bildirim_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="odeme_bildirim_font" class="form-control" id="odeme_bildirim_font" >
                                                        <?php foreach ($fontlar2 as $font2) {?>
                                                            <option value="<?=$font2['font_adi']?>" <?php if($font2['font_adi'] == $detay['odeme_bildirim_font'] ) { ?>selected<?php }?>><?=$font2['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group mb-0">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> Odeme Bildirim   SON !-->


                        <!-- SipariŞ Takip  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <button class="btn btn-block text-left pl-0 " type="button" data-toggle="collapse" data-target="#otherAcc2" aria-expanded="false" aria-controls="collapseForm" style="background-color: #fff; ">
                                    <div class="font-20 w-100 d-flex align-items-center justify-content-between font-weight-bold">
                                        <?=$diller['adminpanel-form-text-553']?>
                                        <i class="far fa-plus-square"></i>
                                    </div>
                                </button>
                                <div class="collapse" id="otherAcc2" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3 mt-3">
                                        <form action="post.php?process=theme_banks_post&status=order_track" method="post" >
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="siparis_takip_bg"><?=$diller['adminpanel-form-text-295']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['siparis_takip_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="siparis_takip_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label  for="siparis_takip_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                                    <select name="siparis_takip_font" class="form-control" id="siparis_takip_font" >
                                                        <?php foreach ($fontlar3 as $font3) {?>
                                                            <option value="<?=$font3['font_adi']?>" <?php if($font3['font_adi'] == $detay['siparis_takip_font'] ) { ?>selected<?php }?>><?=$font3['font_adi']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-4" >
                                                <div class="in-header-page-text">
                                                    <?=$diller['adminpanel-text-311']?> <i class="ti-help-alt text-primary " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-557']?>"></i>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="form-group col-md-12">
                                                    <label  for="siparis_takip_tags" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                                    <input type="text" name="siparis_takip_tags" value="<?=$detay['siparis_takip_tags']?>" id="siparis_takip_tags" data-role="tagsinput" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label  for="siparis_takip_desc" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                                    <textarea name="siparis_takip_desc" id="siparis_takip_desc" class="form-control" rows="2" ><?=$detay['siparis_takip_desc']?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 form-group mb-0">
                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> SipariŞ Takip   SON !-->

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
<script id="rendered-js" >
    $(function () {
        $('#genelAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#genelAcc').offset().top - 80 },
                500);
        });
        $('#otherAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#otherAcc').offset().top - 80 },
                500);
        });
        $('#otherAcc2').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#otherAcc2').offset().top - 80 },
                500);
        });
    });
</script>
<?php //todo collepse tab açtırma kodu ?>
<?php if($_SESSION['collepse_status'] == 'genelAcc'  ) {?>
    <script>
        $('#genelAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#genelAcc').offset().top - 80 },
            0);
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'otherAcc'  ) {?>
    <script>
        $('#otherAcc').addClass('show');
        $('html,body').animate({
                scrollTop: $('#otherAcc').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
<?php if($_SESSION['collepse_status'] == 'otherAcc2'  ) {?>
    <script>
        $('#otherAcc2').addClass('show');
        $('html,body').animate({
                scrollTop: $('#otherAcc2').offset().top - 80 },
            0);
        $('#genelAcc').removeClass('show');
    </script>
    <?php
    unset($_SESSION['collepse_status'])
    ?>
<?php }?>
