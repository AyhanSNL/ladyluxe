<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'header';
$urladdress = 'sss/';
?>
<title><?=$diller['adminpanel-form-text-852']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-form-text-852']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <?php if($yetki['modul'] == '1' &&  $yetki['modul_header_footer'] == '1') {


            
            
            ?>


            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100 d-flex flex-column pb-2 mb-1">
                            <div>
                                <a href="pages.php?page=header_links" class="btn btn-outline-dark btn-sm mb-2 d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>
                            </div>
                        </div>
                        <div class="w-100 border shadow-sm pl-3 pr-3 pt-3 mb-3 rounded">
                            <form action="post.php?process=header_links_post&status=add" method="post" enctype="multipart/form-data">
                                <div class="row ">
                                    <div class="form-group col-md-12 text-center bg-light text-dark mt-n3 mb-3 p-3  border-bottom d-flex flex-wrap align-items-center justify-content-start">
                                        <div style="font-size: 16px ;"> <?=$diller['adminpanel-menu-text-46']?> <i class="fa fa-caret-right ml-2 mr-2"></i></div>
                                        <div>
                                            <h6> <?=$diller['adminpanel-form-text-852']?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row border-bottom mb-3   ">
                                    <div class="form-group col-md-3 ">
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
                                        <input type="number" autocomplete="off" min="1"  name="sira" id="sira"  required class="form-control">
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
                                        <div class="w-100 p-3 border bg-light  up-arrow-2 ">
                                            <div class="">
                                                <select name="modul_url" class="select_ajax2 form-control rounded-0" id="modul_url"  style="height: 55px; width: 100%!important;  ">
                                                    <?php include 'inc/modules/_helper/site_linkleri.php'; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="manuel-choise" class="col-md-12 " style="display: none;"   >
                                        <div class="w-100 p-3 border bg-light  up-arrow-2 ">
                                            <div class="">
                                                <input type="text" name="manuel_url" placeholder="https://"  autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group col-md-12 mt-3">
                                        <label for="menu_sablon"><?=$diller['adminpanel-form-text-867']?></label>
                                        <select name="menu_sablon" class="form-control rounded-0" id="menu_sablon" required style="height: 55px; font-size: 15px ;">
                                            <option value="1"><?=$diller['adminpanel-form-text-865']?></option>
                                            <option value="2"><?=$diller['adminpanel-form-text-866']?></option>
                                        </select>
                                    </div>
                                    <div id="sablon2_secim" class="col-md-12 " style="display: none;"   >
                                        <div class="w-100 p-3 border bg-light  up-arrow-2 ">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="sablon_content_bg"><?=$diller['adminpanel-form-text-868']?></label>
                                                    <div data-color-format="default" data-color=""  class="colorpicker-default input-group">
                                                        <input type="text" name="sablon_content_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="sablon_content_text_color"><?=$diller['adminpanel-form-text-869']?></label>
                                                    <div data-color-format="default" data-color=""  class="colorpicker-default input-group">
                                                        <input type="text" name="sablon_content_text_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="sablon_content_border"><?=$diller['adminpanel-form-text-870']?></label>
                                                    <div data-color-format="default" data-color=""  class="colorpicker-default input-group">
                                                        <input type="text" name="sablon_content_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12 mt-2">
                                                    <label for="sablon2_content_tip"><?=$diller['adminpanel-form-text-871']?></label>
                                                    <select name="sablon2_content_tip" class="form-control rounded-0" id="sablon2_content_tip" required style="height: 55px; font-size: 15px ;">
                                                        <option value="0"><?=$diller['adminpanel-form-text-874']?></option>
                                                        <option value="1"><?=$diller['adminpanel-form-text-872']?></option>
                                                        <option value="2"><?=$diller['adminpanel-form-text-873']?></option>
                                                    </select>
                                                </div>
                                                <div id="html-content-area" class="col-md-12 " style="display: none;"   >
                                                    <div class="w-100 p-3 border bg-white  up-arrow-2">
                                                        <label for="sablon_2_icerik"><?=$diller['adminpanel-form-text-848']?></label>
                                                        <textarea name="sablon_2_icerik" id="tiny"><?=$detay['icerik']?></textarea>
                                                    </div>
                                                </div>
                                                <div id="product-area" class="col-md-12 " style="display: none;"   >
                                                    <div class="w-100 p-3 border bg-white  up-arrow-2 ">
                                                        <label for="sablon2_urunler"><?=$diller['adminpanel-form-text-875']?></label>
                                                        <select class="urunler_select form-control col-md-12" name="sablon2_urunler[]" multiple  id="sablon2_urunler" style="width: 100%!important;"  >
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row border-top pt-3 bg-light pb-3 mt-3">
                                    <div class="col-md-12 text-right">
                                        <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                    </div>
                                </div>
                            </form>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.urunler_select').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-880']?>',
            ajax: {
                url: 'masterpiece.php?page=headermenu_product_select',
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
    $('#sablon2_content_tip').on('change', function() {
        $('#html-content-area').css('display', 'none');
        if ( $(this).val() === '1' ) {
            $('#html-content-area').css('display', 'block');
        }
        $('#product-area').css('display', 'none');
        if ( $(this).val() === '2' ) {
            $('#product-area').css('display', 'block');
        }
    });
    $('#menu_sablon').on('change', function() {
        $('#sablon2_secim').css('display', 'none');
        if ( $(this).val() === '2' ) {
            $('#sablon2_secim').css('display', 'block');
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('.select_ajax2').select2();
    });
</script>