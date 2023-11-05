<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'usersettings';
$firsOrderCheck = $db->prepare("select * from indirim_ilk_siparis where id=:id ");
$firsOrderCheck->execute(array(
        'id' => '1'
));
$row = $firsOrderCheck->fetch(PDO::FETCH_ASSOC);

$yazilar = $db->prepare("select * from uyeler_yazilar where dil=:dil ");
$yazilar->execute(array(
        'dil' => $_SESSION['dil'],
));

?>
<title><?=$diller['adminpanel-menu-text-29']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-25']?></a>
                                <a href="pages.php?page=users_settings"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-29']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['uyelik'] == '1' && $yetki['uyelik_ayar'] == '1') {?>

            <div class="row">

                <?php include 'inc/modules/_helper/users_leftbar.php'; ?>

                <!-- Contents !-->

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="new-buttonu-main-top mb-0 border-bottom pb-2 ">
                                        <div class="new-buttonu-main-left">
                                            <h4><?=$diller['adminpanel-menu-text-29']?></h4>
                                        </div>
                                        <div class="new-buttonu-main">
                                            <a  class="btn btn-secondary text-white "  href="pages.php?page=users" target="_blank"><i class="fa fa-users"></i> <?=$diller['adminpanel-menu-text-26']?></a>
                                            <a  class="btn btn-secondary text-white "  href="pages.php?page=users_group" target="_blank"><i class="fa fa-users"></i> <?=$diller['adminpanel-menu-text-27']?></a>
                                            <a  class="btn btn-info text-white " target="_blank" href="pages.php?page=theme_users_settings"><?=$diller['adminpanel-form-text-838']?></a>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6 form-group">
                                           <div class="border shadow-sm">
                                               <div class="card-body">
                                                   <form  method="post" action="post.php?process=users_post&status=settings_update">
                                                       <div class="in-header-page-main" >
                                                           <div class="in-header-page-text">
                                                               <i class="fa fa-arrow-down"></i>
                                                               <?=$diller['adminpanel-form-text-1377']?>
                                                           </div>
                                                       </div>
                                                   <div class="row">
                                                       <div class="form-group col-md-12 mb-3 mt-2 border-bottom pb-3 ">
                                                           <label  for="durum" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                               <?=$diller['adminpanel-form-text-1378']?>
                                                           </label>
                                                           <div class="custom-control custom-switch custom-switch-lg">
                                                               <input type="hidden" name="durum" value="0"">
                                                               <input type="checkbox" class="custom-control-input" id="durum" name="durum" value="1"  <?php if($uyeayar['durum'] == '1'  ) { ?>checked<?php }?>  >
                                                               <label class="custom-control-label" for="durum"></label>
                                                           </div>
                                                       </div>
                                                       <div class="form-group col-md-6 mb-4">
                                                           <label  for="yeni_uyelik" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                               <?=$diller['adminpanel-form-text-1386']?>
                                                               <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1387']?>"></i>
                                                           </label>
                                                           <div class="custom-control custom-switch custom-switch-lg">
                                                               <input type="hidden" name="yeni_uyelik" value="0"">
                                                               <input type="checkbox" class="custom-control-input" id="yeni_uyelik" name="yeni_uyelik" value="1"  <?php if($uyeayar['yeni_uyelik'] == '1'  ) { ?>checked<?php }?>  >
                                                               <label class="custom-control-label" for="yeni_uyelik"></label>
                                                           </div>
                                                       </div>

                                                       <div class="form-group col-md-6 mb-4 ">
                                                           <label  for="oto_onay" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                               <?=$diller['adminpanel-form-text-1385']?>
                                                               <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1388']?>"></i>
                                                           </label>
                                                           <div class="custom-control custom-switch custom-switch-lg">
                                                               <input type="hidden" name="oto_onay" value="0"">
                                                               <input type="checkbox" class="custom-control-input" id="oto_onay" name="oto_onay" value="1"  <?php if($uyeayar['oto_onay'] == '1'  ) { ?>checked<?php }?>  >
                                                               <label class="custom-control-label" for="oto_onay"></label>
                                                           </div>
                                                       </div>
                                                       <div class="form-group col-md-12 mb-4">
                                                           <label  for="basit_form" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                               <?=$diller['adminpanel-form-text-1379']?>
                                                               <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1380']?>"></i>
                                                           </label>
                                                           <div class="custom-control custom-switch custom-switch-lg">
                                                               <input type="hidden" name="basit_form" value="0"">
                                                               <input type="checkbox" class="custom-control-input" id="basit_form" name="basit_form" value="1"  <?php if($uyeayar['basit_form'] == '1'  ) { ?>checked<?php }?>  >
                                                               <label class="custom-control-label" for="basit_form"></label>
                                                           </div>
                                                       </div>
                                                       <div class="form-group col-md-6 mb-4">
                                                           <label  for="sms_ekle" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                               <?=$diller['adminpanel-form-text-1389']?>
                                                           </label>
                                                           <div class="custom-control custom-switch custom-switch-lg">
                                                               <input type="hidden" name="sms_ekle" value="0"">
                                                               <input type="checkbox" class="custom-control-input" id="sms_ekle" name="sms_ekle" value="1"  <?php if($uyeayar['sms_ekle'] == '1'  ) { ?>checked<?php }?>  >
                                                               <label class="custom-control-label" for="sms_ekle"></label>
                                                           </div>
                                                       </div>
                                                       <div class="form-group col-md-6 mb-4">
                                                           <label  for="eposta_ekle" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                               <?=$diller['adminpanel-form-text-1390']?>
                                                           </label>
                                                           <div class="custom-control custom-switch custom-switch-lg">
                                                               <input type="hidden" name="eposta_ekle" value="0"">
                                                               <input type="checkbox" class="custom-control-input" id="eposta_ekle" name="eposta_ekle" value="1"  <?php if($uyeayar['eposta_ekle'] == '1'  ) { ?>checked<?php }?>  >
                                                               <label class="custom-control-label" for="eposta_ekle"></label>
                                                           </div>
                                                       </div>
                                                   </div>
                                                       <div class="in-header-page-main mt-4" >
                                                           <div class="in-header-page-text">
                                                               <i class="fa fa-arrow-down"></i>
                                                               <?=$diller['adminpanel-form-text-1391']?>
                                                           </div>
                                                       </div>
                                                       <div class="row">
                                                           <div class="form-group col-md-12 mb-4">
                                                               <label  for="adres_alani" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                                   <?=$diller['adminpanel-form-text-1392']?>
                                                               </label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="adres_alani" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="adres_alani" name="adres_alani" value="1"  <?php if($uyeayar['adres_alani'] == '1'  ) { ?>checked<?php }?>  >
                                                                   <label class="custom-control-label" for="adres_alani"></label>
                                                               </div>
                                                           </div>
                                                           <div class="form-group col-md-6 mb-4">
                                                               <label  for="destek_alani" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                                   <?=$diller['adminpanel-form-text-1393']?>
                                                               </label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="destek_alani" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="destek_alani" name="destek_alani" value="1"  <?php if($uyeayar['destek_alani'] == '1'  ) { ?>checked<?php }?>  >
                                                                   <label class="custom-control-label" for="destek_alani"></label>
                                                               </div>
                                                           </div>
                                                           <div class="form-group col-md-6 mb-4">
                                                               <label  for="destek_siparis_mecbur" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                                   <?=$diller['adminpanel-form-text-1394']?>
                                                                   <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1395']?>"></i>
                                                               </label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="destek_siparis_mecbur" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="destek_siparis_mecbur" name="destek_siparis_mecbur" value="1"  <?php if($uyeayar['destek_siparis_mecbur'] == '1'  ) { ?>checked<?php }?>  >
                                                                   <label class="custom-control-label" for="destek_siparis_mecbur"></label>
                                                               </div>
                                                           </div>
                                                           <div class="form-group col-md-6 mb-4">
                                                               <label  for="siparisler_alani" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                                   <?=$diller['adminpanel-form-text-1398']?>
                                                               </label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="siparisler_alani" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="siparisler_alani" name="siparisler_alani" value="1"  <?php if($uyeayar['siparisler_alani'] == '1'  ) { ?>checked<?php }?>  >
                                                                   <label class="custom-control-label" for="siparisler_alani"></label>
                                                               </div>
                                                           </div>
                                                           <div class="form-group col-md-6 mb-4">
                                                               <label  for="yorumlar_alani" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                                   <?=$diller['adminpanel-form-text-1399']?>
                                                               </label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="yorumlar_alani" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="yorumlar_alani" name="yorumlar_alani" value="1"  <?php if($uyeayar['yorumlar_alani'] == '1'  ) { ?>checked<?php }?>  >
                                                                   <label class="custom-control-label" for="yorumlar_alani"></label>
                                                               </div>
                                                           </div>
                                                           <div class="form-group col-md-6 mb-4">
                                                               <label  for="favori_alani" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                                   <?=$diller['adminpanel-form-text-1400']?>
                                                               </label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="favori_alani" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="favori_alani" name="favori_alani" value="1"  <?php if($uyeayar['favori_alani'] == '1'  ) { ?>checked<?php }?>  >
                                                                   <label class="custom-control-label" for="favori_alani"></label>
                                                               </div>
                                                           </div>
                                                           <div class="form-group col-md-6 mb-4">
                                                               <label  for="kupon_alani" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                                   <?=$diller['adminpanel-form-text-1401']?>
                                                               </label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="kupon_alani" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="kupon_alani" name="kupon_alani" value="1"  <?php if($uyeayar['kupon_alani'] == '1'  ) { ?>checked<?php }?>  >
                                                                   <label class="custom-control-label" for="kupon_alani"></label>
                                                               </div>
                                                           </div>
                                                           <div class="form-group col-md-6 mb-4">
                                                               <label  for="iptal_alani" class="w-100 d-flex align-items-center justify-content-start flex-wrap" >
                                                                   <?=$diller['adminpanel-form-text-1402']?>
                                                               </label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="iptal_alani" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="iptal_alani" name="iptal_alani" value="1"  <?php if($uyeayar['iptal_alani'] == '1'  ) { ?>checked<?php }?>  >
                                                                   <label class="custom-control-label" for="iptal_alani"></label>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <div class="row">
                                                           <div class="col-md-12 mt-3">
                                                               <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                           </div>
                                                       </div>
                                                   </form>
                                               </div>
                                           </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="border shadow-sm">
                                                <div class="card-body">

                                                    <?php if($yazilar->rowCount()>'0'  ) {
                                                        $yazi = $yazilar->fetch(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <form  method="post" action="post.php?process=users_post&status=page_text_update">
                                                            <input type="hidden" name="text_id" value="<?=$yazi['id']?>">
                                                            <div class="row">
                                                                <div class="col-md-12 form-group">
                                                                    <div class="in-header-page-main" style="margin-bottom: 10px;">
                                                                        <div class="in-header-page-text" style="font-size: 16px ;">
                                                                            <?=$diller['adminpanel-form-text-1403']?>
                                                                        </div>
                                                                    </div>
                                                                    <div style="font-size: 11px ; color: #999; margin-top:20px; margin-bottom: 15px;">
                                                                        <?=$diller['adminpanel-form-text-1405']?>
                                                                    </div>
                                                                    <textarea name="register_text" id="tiny" class="form-control" rows="3"><?=$yazi['register_text']?></textarea>
                                                                </div>
                                                                <div class="col-md-12 form-group mt-4">
                                                                    <div class="in-header-page-main" style="margin-bottom: 10px;">
                                                                        <div class="in-header-page-text" style="font-size: 16px ;">
                                                                            <?=$diller['adminpanel-form-text-1404']?>
                                                                        </div>
                                                                    </div>
                                                                    <div style="font-size: 11px ; color: #999; margin-top:20px; margin-bottom: 15px;">
                                                                        <?=$diller['adminpanel-form-text-1406']?>
                                                                    </div>
                                                                    <textarea name="login_text" id="tiny2" class="form-control" rows="3"><?=$yazi['login_text']?></textarea>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <?php }else { ?>
                                                        <form  method="post" action="post.php?process=users_post&status=page_text_insert">
                                                            <div class="row">
                                                                <div class="col-md-12 form-group">
                                                                    <div class="in-header-page-main" style="margin-bottom: 10px;">
                                                                        <div class="in-header-page-text" style="font-size: 16px ;">
                                                                            <?=$diller['adminpanel-form-text-1403']?>
                                                                        </div>
                                                                    </div>
                                                                    <div style="font-size: 11px ; color: #999; margin-top:20px; margin-bottom: 15px;">
                                                                        <?=$diller['adminpanel-form-text-1405']?>
                                                                    </div>
                                                                    <textarea name="register_text" id="tiny" class="form-control" rows="3"></textarea>
                                                                </div>
                                                                <div class="col-md-12 form-group mt-4">
                                                                    <div class="in-header-page-main" style="margin-bottom: 10px;">
                                                                        <div class="in-header-page-text" style="font-size: 16px ;">
                                                                            <?=$diller['adminpanel-form-text-1404']?>
                                                                        </div>
                                                                    </div>
                                                                    <div style="font-size: 11px ; color: #999; margin-top:20px; margin-bottom: 15px;">
                                                                        <?=$diller['adminpanel-form-text-1406']?>
                                                                    </div>
                                                                    <textarea name="login_text" id="tiny2" class="form-control" rows="3"></textarea>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <button class="btn  btn-success btn-block" name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <?php }?> 

                                                </div>
                                            </div>
                                        </div>
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
<script>

    $(document).ready(function(){0<$("#tiny").length&&tinymce.init({selector:"textarea#tiny2",
        height:300,
        <?php if($panelayar['editor_dil'] == 'tr' ) {?>
        language: 'tr_TR',
        <?php }?>
        <?php if($yetki['demo'] != '1'  ) {?>
        plugins:["advlist autolink link image responsivefilemanager lists charmap print preview hr anchor media  spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime  ","save table contextmenu directionality emoticons  paste textcolor"],
        <?php }else { ?>
        plugins:["advlist autolink link   lists charmap print preview hr anchor   spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime  ","save table contextmenu directionality emoticons  paste textcolor"],
        <?php }?>        toolbar:"insertfile undo redo | code | fontsizeselect | bold italic forecolor backcolor | l      ink image | responsivefilemanager | media | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | print preview fullpage | emoticons",
        fontsize_formats: "11px 12px 13px 14px 15px 16px 18px 20px 24px 30px 36px 45px 55px",
        setup : function(ed)
        {
            ed.on('init', function()
            {
                this.getDoc().body.style.fontSize = '14px';
            });
        },
        images_upload_url: 'editor_upload.php',

        // override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;

            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'editor_upload.php');

            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                success(json.location);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },
        external_filemanager_path:"../assets/responsive_filemanager/filemanager/",
        filemanager_title:"<?=$diller['adminpanel-text-285']?>" ,
        external_plugins: { "filemanager" : "../assets/responsive_filemanager/filemanager/plugin.min.js"},
        style_formats:[{title:"Bold text",inline:"b"},{title:"Red text",inline:"span",styles:{color:"#ff0000"}},{title:"Red header",block:"h1",styles:{color:"#ff0000"}},{title:"Example 1",inline:"span",classes:"example1"},{title:"Example 2",inline:"span",classes:"example2"},{title:"Table styles"},{title:"Table row 1",selector:"tr",classes:"tablerow1"}]})});



</script>