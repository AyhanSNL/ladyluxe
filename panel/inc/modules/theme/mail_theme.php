<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$sayfaSorgu = $db->prepare("select * from eposta_tema where id='1' ");
$sayfaSorgu->execute();
$detay = $sayfaSorgu->fetch(PDO::FETCH_ASSOC);
?>
<title><?=$diller['adminpanel-menu-text-113']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="pages.php?page=theme_mail"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-113']?></a>
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
                <div class="col-md-8">
                        <!-- Düzen Ayarları  !-->
                        <div class="card mb-2 " >
                            <div class="card-body">
                                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2  border-bottom">
                                    <h4> <?=$diller['adminpanel-menu-text-113']?></h4>
                                </div>
                                <div class="w-100 bg-light p-2">
                                    <?=$diller['adminpanel-form-text-459']?>
                                </div>
                                <div class="collapse in show" id="genelAcc" data-parent="#accordion">
                                    <div class="w-100 border-top pt-3">
                                        <form action="post.php?process=theme_mail_post&status=main_update" method="post">
                                            <div class="row">
                                                <div class="form-group col-md-4">
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
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_width" class="w-100 d-flex align-items-center justify-content-between flex-wrap"><?=$diller['adminpanel-form-text-460']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-461']?>"></i></label>
                                                    <input type="number" name="ana_div_width" value="<?=$detay['ana_div_width']?>" id="ana_div_width" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div"><?=$diller['adminpanel-form-text-462']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['ana_div']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="ana_div"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_radius"><?=$diller['adminpanel-form-text-468']?></label>
                                                    <input type="text"  placeholder="100px" name="ana_div_radius" value="<?=$detay['ana_div_radius']?>" id="ana_div_radius" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_padding"><?=$diller['adminpanel-form-text-472']?></label>
                                                    <input type="text"   name="ana_div_padding" value="<?=$detay['ana_div_padding']?>" id="ana_div_padding" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_border_size"><?=$diller['adminpanel-form-text-470']?></label>
                                                    <select name="ana_div_border_size" class="form-control" id="ana_div_border_size" required>
                                                        <option value="1" <?php if($detay['ana_div_border_size'] == '1' ) { ?>selected<?php }?>>1px</option>
                                                        <option value="2" <?php if($detay['ana_div_border_size'] == '2' ) { ?>selected<?php }?>>2px</option>
                                                        <option value="3" <?php if($detay['ana_div_border_size'] == '3' ) { ?>selected<?php }?>>3px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_border"><?=$diller['adminpanel-form-text-469']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['ana_div_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="ana_div_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_in_border"><?=$diller['adminpanel-form-text-471']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['ana_div_in_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="ana_div_in_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_baslik_color"><?=$diller['adminpanel-form-text-463']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['ana_div_baslik_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="ana_div_baslik_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_baslik_size"><?=$diller['adminpanel-form-text-464']?></label>
                                                    <select name="ana_div_baslik_size" class="form-control" id="ana_div_baslik_size" required>
                                                        <option value="20" <?php if($detay['ana_div_baslik_size'] == '20' ) { ?>selected<?php }?>>20px</option>
                                                        <option value="24" <?php if($detay['ana_div_baslik_size'] == '24' ) { ?>selected<?php }?>>24px</option>
                                                        <option value="30" <?php if($detay['ana_div_baslik_size'] == '30' ) { ?>selected<?php }?>>30px</option>
                                                        <option value="36" <?php if($detay['ana_div_baslik_size'] == '36' ) { ?>selected<?php }?>>36px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_baslik_weight"><?=$diller['adminpanel-form-text-465']?></label>
                                                    <select name="ana_div_baslik_weight" class="form-control" id="ana_div_baslik_weight" required>
                                                        <option value="300" <?php if($detay['ana_div_baslik_weight'] == '300' ) { ?>selected<?php }?>>300</option>
                                                        <option value="400" <?php if($detay['ana_div_baslik_weight'] == '400' ) { ?>selected<?php }?>>400</option>
                                                        <option value="500" <?php if($detay['ana_div_baslik_weight'] == '500' ) { ?>selected<?php }?>>500</option>
                                                        <option value="600" <?php if($detay['ana_div_baslik_weight'] == '600' ) { ?>selected<?php }?>>600</option>
                                                        <option value="700" <?php if($detay['ana_div_baslik_weight'] == '700' ) { ?>selected<?php }?>>700</option>
                                                        <option value="800" <?php if($detay['ana_div_baslik_weight'] == '800' ) { ?>selected<?php }?>>800</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_font_size"><?=$diller['adminpanel-form-text-467']?></label>
                                                    <select name="ana_div_font_size" class="form-control" id="ana_div_font_size" required>
                                                        <option value="12" <?php if($detay['ana_div_font_size'] == '12' ) { ?>selected<?php }?>>12px</option>
                                                        <option value="13" <?php if($detay['ana_div_font_size'] == '13' ) { ?>selected<?php }?>>13px</option>
                                                        <option value="14" <?php if($detay['ana_div_font_size'] == '14' ) { ?>selected<?php }?>>14px</option>
                                                        <option value="15" <?php if($detay['ana_div_font_size'] == '15' ) { ?>selected<?php }?>>15px</option>
                                                        <option value="16" <?php if($detay['ana_div_font_size'] == '16' ) { ?>selected<?php }?>>16px</option>
                                                        <option value="18" <?php if($detay['ana_div_font_size'] == '18' ) { ?>selected<?php }?>>18px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_text"><?=$diller['adminpanel-form-text-466']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['ana_div_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="ana_div_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="ana_div_a_color"><?=$diller['adminpanel-form-text-473']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['ana_div_a_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="ana_div_a_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="in-header-page-main mt-3" >
                                                <div class="in-header-page-text">
                                                    <i class="fa fa-arrow-down"></i>
                                                    <?=$diller['adminpanel-form-text-474']?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label for="imza_bg"><?=$diller['adminpanel-form-text-475']?></label>
                                                    <div data-color-format="imza_bg" data-color="#<?=$detay['imza_bg']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="imza_bg"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="imza_text"><?=$diller['adminpanel-form-text-476']?></label>
                                                    <div data-color-format="imza_text" data-color="#<?=$detay['imza_text']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="imza_text"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="imza_font_size"><?=$diller['adminpanel-form-text-477']?></label>
                                                    <select name="imza_font_size" class="form-control" id="imza_font_size" required>
                                                        <option value="12" <?php if($detay['imza_font_size'] == '12' ) { ?>selected<?php }?>>12px</option>
                                                        <option value="13" <?php if($detay['imza_font_size'] == '13' ) { ?>selected<?php }?>>13px</option>
                                                        <option value="14" <?php if($detay['imza_font_size'] == '14' ) { ?>selected<?php }?>>14px</option>
                                                        <option value="15" <?php if($detay['imza_font_size'] == '15' ) { ?>selected<?php }?>>15px</option>
                                                        <option value="16" <?php if($detay['imza_font_size'] == '16' ) { ?>selected<?php }?>>16px</option>
                                                        <option value="18" <?php if($detay['imza_font_size'] == '18' ) { ?>selected<?php }?>>18px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="imza_border"><?=$diller['adminpanel-form-text-478']?></label>
                                                    <div data-color-format="default" data-color="#<?=$detay['imza_border']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="imza_border"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="imza_border_size"><?=$diller['adminpanel-form-text-479']?></label>
                                                    <select name="imza_border_size" class="form-control" id="imza_border_size" required>
                                                        <option value="1" <?php if($detay['imza_border_size'] == '1' ) { ?>selected<?php }?>>1px</option>
                                                        <option value="2" <?php if($detay['imza_border_size'] == '2' ) { ?>selected<?php }?>>2px</option>
                                                        <option value="3" <?php if($detay['imza_border_size'] == '3' ) { ?>selected<?php }?>>3px</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="imza_border_radius"><?=$diller['adminpanel-form-text-480']?></label>
                                                    <input type="text"  placeholder="100px" name="imza_border_radius" value="<?=$detay['imza_border_radius']?>" id="imza_border_radius" required class="form-control">
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="imza_icerik">
                                                        <?=$diller['adminpanel-form-text-481']?>
                                                    </label>
                                                    <textarea name="imza_icerik" id="tiny3"><?=$detay['imza_icerik']?></textarea>
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
                        </div>
                        <!--  <========SON=========>>> Düzen Ayarları  SON !-->
                </div>
                <!--  <========SON=========>>> Contents SON !-->

                <!-- LoGo Update !-->
                <!--  <========SON=========>>> LoGo Update SON !-->
                <div class="col-md-4  ">
                    <div class="card">
                        <div class="card-body">
                            <div class="in-header-page-main">
                                <div class="in-header-page-text">
                                    <?=$diller['adminpanel-form-text-482']?>
                                </div>
                            </div>

                            <div class="w-100  p-3 text-center mb-3 " style="background-color: #<?=$detay['arkaplan']?>;">
                                <?php if($panelayar['panel_logo'] == !null  ) {?>
                                    <img src="<?=$ayar['site_url']?>images/logo/<?=$ayar['smtp_logo']?>"  class="img-fluid">
                                    <br><br>
                                    <small class="bg-white p-1">
                                        <?=$diller['adminpanel-form-text-89']?> : 190x50
                                    </small>
                                <?php }?>
                            </div>

                            <div class="w-100">
                                <form action="post.php?process=theme_mail_post&status=logo_update" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="old_logo" value="<?=$ayar['smtp_logo']?>" >
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile01" name="smtp_logo" >
                                            <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-text-152']?></label>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-block" name="update"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                                    <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                        <small>png,  jpg, jpeg</small>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                   <div class="card">
                       <div class="w-100 mb-2 p-3 bg-primary text-white  text-center">
                           <h6><?=$diller['adminpanel-form-text-457']?></h6>
                           <small><?=$diller['adminpanel-form-text-458']?></small>
                       </div>
                       <!-- EPosta Görünümü !-->
                       <div class="w-100 p-3" style="background-color: #<?=$detay['arkaplan']?>; ">
                           <div id='Logo' style='margin-bottom: 20px; width: 100%; text-align: center; box-sizing: border-box;   '>
                               <img src="<?=$ayar['site_url']?>images/logo/<?=$ayar['smtp_logo']?>" style='max-height: 60px; '>
                           </div>
                            <div class="w-100" style="background-color: #<?=$detay['ana_div']?>; padding : <?=$detay['ana_div_padding']?>; color: #<?=$detay['ana_div_text']?>;  border-radius:<?=$detay['ana_div_radius']?>; border: <?=$detay['ana_div_border_size']?>px solid #<?=$detay['ana_div_border']?> !important; font-size: <?=$detay['ana_div_font_size']?>px ;">
                                <table width='100%' style='color: #<?=$detay['ana_div_baslik_color']?>; font-size:<?=$detay['ana_div_baslik_size']?>px; font-weight:<?=$detay['ana_div_baslik_weight']?>; margin-bottom: 25px;'>
                                <tr>
                                    <td width='100%' >Header Text Here</td>
                                </tr>
                                </table>
                                <div style='width: 95%;  margin-bottom: 25px; '>
                                   Random Content Phasellus tempus. Vivamus aliquet elit ac nisl.
                                </div>
                                <div style='width: 100%; border-top: 1px solid #<?=$detay['ana_div_in_border']?>; box-sizing: border-box; margin-bottom: 20px; margin-top:10px;  font-size: 13px ;  '>
                                <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #<?=$detay['ana_div_in_border']?>; font-size: <?=$detay['ana_div_font_size']?>px ;'>
                                <tr >
                                    <td width='31%'valign='top' style="padding:8px 0">Sample E-Mail</td>
                                    <td width='4%' valign='top' style="padding:8px 0">:</td>
                                    <td width='65%' valign='top' style='font-weight: 500;padding:8px 0'><a href="#" style="color: #<?=$detay['ana_div_a_color']?>;">info@google.com</a></td>
                                </tr>
                                </table>
                                    <table width='100%' style='padding: 8px 0; border-bottom: 1px solid #<?=$detay['ana_div_in_border']?>; font-size: <?=$detay['ana_div_font_size']?>px ;'>
                                        <tr >
                                            <td width='31%'valign='top' style="padding:8px 0">Sample Name</td>
                                            <td width='4%' valign='top' style="padding:8px 0">:</td>
                                            <td width='65%' valign='top' style='font-weight: 500;padding:8px 0'>John Janet</td>
                                        </tr>
                                    </table>
                            </div>
                            </div>
                           <div id='Signature' style='margin: 0 auto; background-color: #<?=$detay['imza_bg']?>; width: 100%; padding:<?=$detay['ana_div_padding']?>; box-sizing: border-box; color: #<?=$detay['imza_text']?>; font-size: <?=$detay['imza_font_size']?>px ; border-radius:<?=$detay['imza_border_radius']?>; border:<?=$detay['imza_border_size']?>px solid #<?=$detay['imza_border']?>;'>
                           <?=$detay['imza_icerik']?>
                       </div>
                       </div>
                       <!--  <========SON=========>>> EPosta Görünümü SON !-->
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

<script>

    $(document).ready(function(){0<$("#tiny3").length&&tinymce.init({selector:"textarea#tiny3",
        height:300,
        <?php if($panelayar['editor_dil'] == 'tr' ) {?>
        language: 'tr_TR',
        <?php }?>
        plugins:["advlist autolink link   lists charmap print preview hr anchor  image  spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime  ","save  contextmenu directionality emoticons  paste textcolor"],
        toolbar:"insertfile undo redo | code | fontsizeselect | bold italic forecolor backcolor | image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | print preview fullpage | emoticons",
        fontsize_formats: "11px 12px 13px 14px 15px 16px 18px 20px 24px 30px 36px 45px 55px",
        external_plugins: { "filemanager" : "../assets/responsive_filemanager/filemanager/plugin.min.js"},
        style_formats:[{title:"Bold text",inline:"b"},{title:"Red text",inline:"span",styles:{color:"#ff0000"}},{title:"Red header",block:"h1",styles:{color:"#ff0000"}},{title:"Example 1",inline:"span",classes:"example1"},{title:"Example 2",inline:"span",classes:"example2"},{title:"Table styles"},{title:"Table row 1",selector:"tr",classes:"tablerow1"}]})});



</script>