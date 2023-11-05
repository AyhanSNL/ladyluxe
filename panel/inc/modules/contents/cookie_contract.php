<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'cookie';

$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();

?>
<title><?=$diller['adminpanel-menu-text-73']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-48']?></a>
                                <a href="pages.php?page=cookie_contract"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-73']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['icerik_yonetim'] == '1' &&  $yetki['sayfa_yonet'] == '1') {

            $sozlesmeSQL = $db->prepare("select * from cerez_ayar where dil=:dil");
            $sozlesmeSQL->execute(array(
                    'dil' => $_SESSION['dil']
            ));
            
          ?>


            <div class="row">

                    <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2">
                            <div class="new-buttonu-main-top ">
                                <div class="new-buttonu-main-left">
                                    <h5><?=$diller['adminpanel-menu-text-73']?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 p-2">
                            <?php if($sozlesmeSQL->rowCount()<='0'  ) {?>
                                <form method="post" action="post.php?process=contract_post&status=cookie_add">
                                    <div class="row">
                                        <div class="col-md-12 ">
                                            <div class="form-group bg-light col-auto mb-3 pt-3 pb-3 border ">
                                                <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                        <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                        <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 mb-4">
                                            <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="durum" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"   ">
                                                <label class="custom-control-label" for="durum"></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label  for="font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                            <select name="font" class="form-control" id="font" >
                                                <?php foreach ($fontlar as $font) {?>
                                                    <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $row['font']  ) { ?>selected<?php }?> ><?=$font['font_adi']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label  for="area" class="w-100"><?=$diller['adminpanel-form-text-857']?></label>
                                            <select name="area" class="form-control" id="area" >
                                                <option value="top" ><?=$diller['adminpanel-form-text-1026']?></option>
                                                <option value="bottom" ><?=$diller['adminpanel-form-text-1027']?></option>
                                                <option value="bottom-left"  ><?=$diller['adminpanel-form-text-1028']?></option>
                                                <option value="bottom-right" ><?=$diller['adminpanel-form-text-1029']?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="border"><?=$diller['adminpanel-form-text-1030']?></label>
                                            <div data-color-format="default" data-color=""  class="colorpicker-default input-group">
                                                <input type="text" name="border"  value="" class="form-control">
                                                <div class="input-group-append add-on">
                                                    <button class="btn btn-light border" type="button">
                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="bg_color"><?=$diller['adminpanel-form-text-1024']?></label>
                                            <div data-color-format="default" data-color="#000000"  class="colorpicker-default input-group">
                                                <input type="text" name="bg_color"  value="" class="form-control">
                                                <div class="input-group-append add-on">
                                                    <button class="btn btn-light border" type="button">
                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="bg_text_color"><?=$diller['adminpanel-form-text-1025']?></label>
                                            <div data-color-format="default" data-color="#FFFFFF"  class="colorpicker-default input-group">
                                                <input type="text" name="bg_text_color"  value="" class="form-control">
                                                <div class="input-group-append add-on">
                                                    <button class="btn btn-light border" type="button">
                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="spot" class="w-100" ><?=$diller['adminpanel-form-text-1018']?></label>
                                            <textarea name="spot" id="spot" class="form-control" rows="2" required><?=$row['spot']?></textarea>
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="link" class="w-100" ><i class="fa fa-external-link-alt"></i> <?=$diller['adminpanel-form-text-977']?></label>
                                            <input type="text" autocomplete="off" name="link" value="<?=$row['link']?>" id="link" placeholder="https://"  class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 ">
                                            <label  for="link_text" class="w-100" ><?=$diller['adminpanel-form-text-1020']?></label>
                                            <input type="text" autocomplete="off" name="link_text" value="<?=$row['link_text']?>" id="link_text" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4 ">
                                            <label  for="button_text" class="w-100" >* <?=$diller['adminpanel-form-text-1021']?></label>
                                            <input type="text" autocomplete="off" name="button_text" required value="<?=$row['button_text']?>" id="button_text" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="button_bg"><?=$diller['adminpanel-form-text-1022']?></label>
                                            <div data-color-format="default" data-color="#FFFFFF"  class="colorpicker-default input-group">
                                                <input type="text" name="button_bg"  value="" class="form-control">
                                                <div class="input-group-append add-on">
                                                    <button class="btn btn-light border" type="button">
                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="button_text_color"><?=$diller['adminpanel-form-text-1023']?></label>
                                            <div data-color-format="default" data-color="#000000"  class="colorpicker-default input-group">
                                                <input type="text" name="button_text_color"  value="" class="form-control">
                                                <div class="input-group-append add-on">
                                                    <button class="btn btn-light border" type="button">
                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                        </div>
                                    </div>
                                </form>
                            <?php }else { 
                                $row = $sozlesmeSQL->fetch(PDO::FETCH_ASSOC);
                                ?>
                               <form method="post" action="post.php?process=contract_post&status=cookie_update">
                                   <input type="hidden" name="page_id" value="<?=$row['id']?>">
                                   <div class="row">
                                       <div class="col-md-12 ">
                                           <div class="form-group bg-light col-auto mb-3 pt-3 pb-3 border ">
                                               <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                   <div class="d-flex align-items-center justify-content-start">
                                                       <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                       <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                       <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                   </div>
                                               </a>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-12 mb-4">
                                           <label  for="durum" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                           <div class="custom-control custom-switch custom-switch-lg">
                                               <input type="hidden" name="durum" value="0"">
                                               <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  <?php if($row['durum'] == '1'  ) { ?>checked<?php }?> ">
                                               <label class="custom-control-label" for="durum"></label>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label  for="font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                           <select name="font" class="form-control" id="font" >
                                               <?php foreach ($fontlar as $font) {?>
                                                   <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $row['font']  ) { ?>selected<?php }?> ><?=$font['font_adi']?></option>
                                               <?php }?>
                                           </select>
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label  for="area" class="w-100"><?=$diller['adminpanel-form-text-857']?></label>
                                           <select name="area" class="form-control" id="area" >
                                               <option value="top" <?php if($row['area'] == 'top'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1026']?></option>
                                               <option value="bottom" <?php if($row['area'] == 'bottom'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1027']?></option>
                                               <option value="bottom-left" <?php if($row['area'] == 'bottom-left'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1028']?></option>
                                               <option value="bottom-right" <?php if($row['area'] == 'bottom-right'  ) { ?>selected<?php }?> ><?=$diller['adminpanel-form-text-1029']?></option>
                                           </select>
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="border"><?=$diller['adminpanel-form-text-1030']?></label>
                                           <div data-color-format="default" data-color="#<?=$row['border']?>"  class="colorpicker-default input-group">
                                               <input type="text" name="border"  value="" class="form-control">
                                               <div class="input-group-append add-on">
                                                   <button class="btn btn-light border" type="button">
                                                       <i style="background-color: rgb(124, 66, 84);"></i>
                                                   </button>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="form-group col-md-6">
                                           <label for="bg_color"><?=$diller['adminpanel-form-text-1024']?></label>
                                           <div data-color-format="default" data-color="#<?=$row['bg_color']?>"  class="colorpicker-default input-group">
                                               <input type="text" name="bg_color"  value="" class="form-control">
                                               <div class="input-group-append add-on">
                                                   <button class="btn btn-light border" type="button">
                                                       <i style="background-color: rgb(124, 66, 84);"></i>
                                                   </button>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label for="bg_text_color"><?=$diller['adminpanel-form-text-1025']?></label>
                                           <div data-color-format="default" data-color="#<?=$row['bg_text_color']?>"  class="colorpicker-default input-group">
                                               <input type="text" name="bg_text_color"  value="" class="form-control">
                                               <div class="input-group-append add-on">
                                                   <button class="btn btn-light border" type="button">
                                                       <i style="background-color: rgb(124, 66, 84);"></i>
                                                   </button>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-12 ">
                                           <label  for="spot" class="w-100" ><?=$diller['adminpanel-form-text-1018']?></label>
                                           <textarea name="spot" id="spot" class="form-control" rows="2" required><?=$row['spot']?></textarea>
                                       </div>
                                       <div class="form-group col-md-12 ">
                                           <label  for="link" class="w-100" ><i class="fa fa-external-link-alt"></i> <?=$diller['adminpanel-form-text-977']?></label>
                                           <input type="text" autocomplete="off" name="link" value="<?=$row['link']?>" id="link" placeholder="https://"  class="form-control">
                                       </div>
                                       <div class="form-group col-md-12 ">
                                           <label  for="link_text" class="w-100" ><?=$diller['adminpanel-form-text-1020']?></label>
                                           <input type="text" autocomplete="off" name="link_text" value="<?=$row['link_text']?>" id="link_text" class="form-control">
                                       </div>
                                       <div class="form-group col-md-4 ">
                                           <label  for="button_text" class="w-100" >* <?=$diller['adminpanel-form-text-1021']?></label>
                                           <input type="text" autocomplete="off" name="button_text" required value="<?=$row['button_text']?>" id="button_text" class="form-control">
                                       </div>
                                       <div class="form-group col-md-4">
                                           <label for="button_bg"><?=$diller['adminpanel-form-text-1022']?></label>
                                           <div data-color-format="default" data-color="#<?=$row['button_bg']?>"  class="colorpicker-default input-group">
                                               <input type="text" name="button_bg"  value="" class="form-control">
                                               <div class="input-group-append add-on">
                                                   <button class="btn btn-light border" type="button">
                                                       <i style="background-color: rgb(124, 66, 84);"></i>
                                                   </button>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-4">
                                           <label for="button_text_color"><?=$diller['adminpanel-form-text-1023']?></label>
                                           <div data-color-format="default" data-color="#<?=$row['button_text_color']?>"  class="colorpicker-default input-group">
                                               <input type="text" name="button_text_color"  value="" class="form-control">
                                               <div class="input-group-append add-on">
                                                   <button class="btn btn-light border" type="button">
                                                       <i style="background-color: rgb(124, 66, 84);"></i>
                                                   </button>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-12 text-right">
                                           <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                       </div>
                                   </div>
                               </form>
                            <?php }?>
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
