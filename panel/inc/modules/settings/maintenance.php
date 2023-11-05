<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'bakim';

$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();

?>
<title><?=$diller['adminpanel-menu-text-164']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-151']?></a>
                                <a href="pages.php?page=maintenance"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-164']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['site_ayarlar'] == '1' &&  $yetki['ayar_diger'] == '1') {?>


            <div class="row">

                <?php include 'inc/modules/_helper/settings_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-6<?php }else{?>col-md-9<?php } ?>">
                    <div class="card p-4">
                        <form method="post" action="post.php?process=maintenance_post&status=update">

                            <div class="w-100">
                                <div class="w-100 text-left border-bottom mb-3 pb-2">
                                    <h4><?=$diller['adminpanel-menu-text-164']?></h4>
                                </div>
                               <div class="row">
                                   <div class="form-group col-md-4 mb-4">
                                       <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-74']?></label>
                                       <div class="custom-control custom-switch custom-switch-lg">
                                           <input type="hidden" name="durum" value="0"">
                                           <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1" <?php if($bakim['durum'] == '1'  ) { ?>checked<?php }?>>
                                           <label class="custom-control-label" for="durum"></label>
                                       </div>
                                   </div>
                               </div>
                                <div class="form-group">
                                    <label  for="baslik" class="w-100">* <?=$diller['adminpanel-form-text-75']?> </label>
                                    <input type="text" name="baslik" value="<?=$bakim['baslik']?>" id="baslik" required  class="form-control ">
                                </div>
                                <div class="form-group">
                                    <label  for="spot" class="w-100"><?=$diller['adminpanel-form-text-76']?> </label>
                                    <textarea name="spot" id="spot" class="form-control" rows="3" ><?=$bakim['spot']?></textarea>
                                </div>
                                <div class="form-group">
                                    <label  for="font_select" class="w-100">* <?=$diller['adminpanel-form-text-77']?></label>
                                    <select name="font_select" class="form-control" id="font_select" >
                                        <?php foreach ($fontlar as $font) {?>
                                            <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $bakim['font_select'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>

                            <!-- Butonlar !-->
                            <div class="w-100 mt-4">
                                <div class="in-header-page-main">
                                    <div class="in-header-page-text">
                                      <?=$diller['adminpanel-form-text-91']?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="ebulten" class="w-100"><?=$diller['adminpanel-form-text-78']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="ebulten" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="ebulten" name="ebulten" value="1" <?php if($bakim['ebulten'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="ebulten"></label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-4">
                                        <label  for="sosyal" class="w-100"><?=$diller['adminpanel-form-text-79']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-85']?>"></i> </label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="sosyal" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="sosyal" name="sosyal" value="1" <?php if($bakim['sosyal'] == '1'  ) { ?>checked<?php }?>>
                                            <label class="custom-control-label" for="sosyal"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="iletisim" class="w-100" ><?=$diller['adminpanel-form-text-80']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="iletisim" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="iletisim" name="iletisim" value="1"  <?php if($bakim['iletisim'] == '1'  ) { ?>checked<?php }?> onclick="iletisimButton(this.checked);">
                                            <label class="custom-control-label" for="iletisim"></label>
                                        </div>
                                    </div>
                                    <div id="iletisimButton" class="w-100" <?php if($bakim['iletisim'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                       <div class="row  pl-3 pr-3">
                                           <div class="form-group col-md-6 mb-4">
                                               <label for="tel"><?=$diller['adminpanel-form-text-81']?></label>
                                               <input type="text" name="tel" value="<?=$bakim['tel']?>" id="tel" class="form-control">
                                           </div>
                                           <div class="form-group col-md-6 mb-4">
                                               <label for="whatsapp"><?=$diller['adminpanel-form-text-82']?></label>
                                               <input type="text" name="whatsapp" value="<?=$bakim['whatsapp']?>" id="whatsapp" class="form-control">
                                           </div>
                                           <div class="form-group col-md-12 mb-4">
                                               <label for="eposta"><?=$diller['adminpanel-form-text-83']?></label>
                                               <input type="email" name="eposta" value="<?=$bakim['eposta']?>" id="eposta" class="form-control">
                                           </div>
                                           <div class="form-group col-md-12 mb-4">
                                               <label for="adres"><?=$diller['adminpanel-form-text-84']?></label>
                                               <textarea name="adres" id="adres" class="form-control" rows="2" required><?=$bakim['adres']?></textarea>
                                           </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-4">
                                        <label  for="tarih_durum" class="w-100" ><?=$diller['adminpanel-form-text-86']?></label>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="hidden" name="tarih_durum" value="0"">
                                            <input type="checkbox" class="custom-control-input" id="tarih_durum" name="tarih_durum" value="1"  <?php if($bakim['tarih_durum'] == '1'  ) { ?>checked<?php }?> onclick="tarihButton(this.checked);">
                                            <label class="custom-control-label" for="tarih_durum"></label>
                                        </div>
                                    </div>
                                    <div id="tarihButton" class="w-100" <?php if($bakim['tarih_durum'] == '0'  ) { ?>style="display:none !important;"<?php }?> >
                                        <div class="row  pl-3 pr-3">
                                            <div class="form-group col-md-12 mb-4">
                                                <label for="tarih"><?=$diller['adminpanel-form-text-87']?></label>
                                                <div>
                                                    <div class="input-group">
                                                        <input type="text" name="tarih" class="form-control" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>" value="<?=$bakim['tarih']?>" id="dateSelected" autocomplete="off">
                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> Butonlar SON !-->
                            <div class="w-100 border-top pt-3">
                                <button class="btn btn-success btn-block" name="update">
                                    <?=$diller['adminpanel-form-text-53']?>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
                <!--  <========SON=========>>> Contents SON !-->


                <!-- Logo !-->
                <div class="col-md-3">
                    <div class="card p-4">

                        <div class="in-header-page-main">
                            <div class="in-header-page-text">
                             <?=$diller['adminpanel-form-text-88']?>
                            </div>
                        </div>

                        <div class="w-100 bg-light   p-3 text-center mb-3 ">
                            <?php if($bakim['bg'] == !null  ) {?>
                                <small class="text-dark">
                                    <?=$diller['adminpanel-form-text-90']?>
                                </small>
                                <br><br>
                                <img src="<?=$ayar['site_url']?>i/uploads/<?=$bakim['bg']?>" class="img-fluid" >
                                <small>
                                    <br><br>
                                    <?=$diller['adminpanel-form-text-89']?> : 1000x1000
                                </small>
                                <br><br>
                                <a href="" data-href="post.php?process=maintenance_post&status=bg_delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                            <?php }else { ?>
                                <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                <small>
                                    <br><br>
                                    <?=$diller['adminpanel-form-text-89']?> : 1000x1000
                                </small>
                            <?php }?>
                        </div>

                        <div class="w-100">
                            <form action="post.php?process=maintenance_post&status=bg_update" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="old_bg" value="<?=$bakim['bg']?>" >
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="bg" >
                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-92']?></label>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-block" name="update"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                                <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                    <small>png,  jpg, jpeg</small>
                                </div>
                            </form>
                        </div>




                    </div>
                    <div class="card p-4">
                        <div class="in-header-page-main">
                            <div class="in-header-page-text">
                               <?=$diller['adminpanel-form-text-93']?>
                            </div>
                        </div>
                        <div class="w-100 bg-light p-3 text-center mb-3 ">
                            <?php if($bakim['logo'] == !null  ) {?>
                                <small class="text-dark"><?=$diller['adminpanel-text-151']?></small>
                                <br><br>
                                <img src="<?=$ayar['site_url']?>i/uploads/<?=$bakim['logo']?>" class="img-fluid" >
                                <small>
                                    <br><br>
                                    <?=$diller['adminpanel-form-text-94']?> : 130px
                                </small>
                                <br><br>
                                <a href="" data-href="post.php?process=maintenance_post&status=logo_delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                            <?php }else { ?>
                                <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                <small>
                                    <br><br>
                                    <?=$diller['adminpanel-form-text-94']?> : 130px
                                </small>
                            <?php }?>
                        </div>

                        <div class="w-100">
                            <form action="post.php?process=maintenance_post&status=logo_update" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="old_logo" value="<?=$bakim['logo']?>" >
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="logo" >
                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-95']?></label>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-block" name="update"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                                <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                    <small> png,  jpg, jpeg, svg, gif</small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Logo SON !-->



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
    function iletisimButton(selected)
    {
        if (selected)
        {
            document.getElementById("iletisimButton").style.display = "";
        } else

        {
            document.getElementById("iletisimButton").style.display = "none";
        }

    }
    function tarihButton(selected)
    {
        if (selected)
        {
            document.getElementById("tarihButton").style.display = "";
        } else

        {
            document.getElementById("tarihButton").style.display = "none";
        }

    }
</script>
