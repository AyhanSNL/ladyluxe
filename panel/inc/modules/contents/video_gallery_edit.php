
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from video where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <script src="assets/js/bs4inputfilename.js"></script>
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-1152']?></h4>
                    </div>
                    <form action="post.php?process=video_gallery_post&status=edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="video_id" value="<?=$row['id']?>" >
                       <div class="border">
                           <ul class="nav nav-tabs bg-light pt-2" id="myTab" role="tablist">
                               <li class="nav-item">
                                   <a class="nav-link saas active" id="one-tab" data-toggle="tab" href="#one_e" role="tab"  aria-selected="true">
                                       <?=$diller['adminpanel-form-text-981']?>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a class="nav-link saas" id="gorsel-tab" data-toggle="tab" href="#gorsel" role="tab"  aria-selected="true">
                                       <?=$diller['adminpanel-form-text-1149']?>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a class="nav-link saas" id="two-tab" data-toggle="tab" href="#two_e" role="tab"  aria-selected="true">
                                       <?=$diller['adminpanel-text-311']?>
                                   </a>
                               </li>
                           </ul>
                           <div class="tab-content bg-white rounded-bottom">
                               <div class="tab-pane active p-4" id="one_e" role="tabpanel" >
                                   <div class="row">
                                       <div class="form-group col-md-12">
                                           <label for="date"><?=$diller['adminpanel-form-text-1081']?></label>
                                           <input type="text" autocomplete="off" value="<?php echo date_tr('j F Y, l, H:i ', ''.$row['tarih'].''); ?> "  name="date" id="date" required class="form-control" readonly>
                                       </div>
                                       <div class="form-group col-md-12 mb-4">
                                           <label  for="durum2" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                           <div class="custom-control custom-switch custom-switch-lg">
                                               <input type="hidden" name="durum" value="0"">
                                               <input type="checkbox" class="custom-control-input" id="durum2" name="durum" value="1"  <?php if($row['durum'] == '1' ) { ?>checked<?php }?> >
                                               <label class="custom-control-label" for="durum2"></label>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-4">
                                           <label for="baslik2">* <?=$diller['adminpanel-form-text-1147']?></label>
                                           <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                                       </div>
                                       <div class="form-group col-md-4">
                                           <label for="sira2">* <?=$diller['adminpanel-form-text-55']?></label>
                                           <input type="number" autocomplete="off" value="<?=$row['sira']?>"  name="sira" id="sira2" required class="form-control">
                                       </div>
                                       <div class="form-group col-md-4">
                                           <label for="embed2">* <?=$diller['adminpanel-form-text-99']?></label>
                                           <input type="text" autocomplete="off" value="<?=$row['embed']?>" name="embed" id="embed2"  placeholder="<?=$diller['adminpanel-form-text-1150']?> : XULUBZcAU" required class="form-control">
                                       </div>
                                       <div class="form-group col-md-12 mb-0">
                                           <label for="spot2"><?=$diller['adminpanel-form-text-1151']?></label>
                                           <textarea name="spot" id="tiny2" class="form-control" rows="3" ><?=$row['spot']?></textarea>
                                       </div>
                                   </div>
                               </div>

                               <div class="tab-pane fade p-4" id="gorsel" role="tabpanel" >
                                   <div class="row">
                                       <div class="form-group col-md-12">
                                           <label for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-1149']?>  <small>( png,  jpg, jpeg, gif, svg )</small></label>
                                           <div class="w-100 bg-light border p-3">
                                               <div class="mx-auto" style=" text-align: center;">
                                                   <?php if($row['gorsel'] == !null ) {?>
                                                       <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/videos/<?=$row['gorsel']?>" alt=""style="height: 160px">
                                                   <?php }else { ?>
                                                       <img src="assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 150px; " >
                                                   <?php }?>
                                               </div>
                                           </div>
                                           <div class="input-group ">
                                               <div class="custom-file">
                                                   <input type="hidden" name="old_img" value="<?=$row['gorsel']?>">
                                                   <input type="file" class="custom-file-input" id="inputGroupFile01_2" name="gorsel" >
                                                   <label class="custom-file-label" for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-106']?></label>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="tab-pane fade p-4" id="two_e" role="tabpanel" >
                                   <div class="row">
                                       <div class="form-group col-md-12">
                                           <label for="seo_url2" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1012']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1014']?>"></i></label>
                                           <input type="text" autocomplete="off" value="<?=$row['seo_url']?>" name="seo_url" id="seo_url2" placeholder="<?=$diller['adminpanel-form-text-1013']?>"  class="form-control">
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="seo_baslik2" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1015']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1016']?>"></i></label>
                                           <input type="text" autocomplete="off" value="<?=$row['seo_baslik']?>"  name="seo_baslik" id="seo_baslik2"  class="form-control">
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label  for="tags2" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                           <input type="text" name="tags"  id="tags2" data-role="tagsinput" value="<?=$row['tags']?>" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label  for="meta_desc2" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                           <textarea name="meta_desc" id="meta_desc2" class="form-control" rows="2" ><?=$row['meta_desc']?></textarea>
                                       </div>
                                   </div>
                               </div>

                           </div>
                       </div>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button class="btn btn-success btn-block  shadow-sm" name="update">
                                <?=$diller['adminpanel-form-text-53']?>
                            </button>
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                                <?=$diller['adminpanel-modal-text-17']?>
                            </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

<?php }?>


<script src='https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js'></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<!-- Editor !-->
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
        <?php }?>
        toolbar:"insertfile undo redo | code | fontsizeselect | bold italic forecolor backcolor | l      ink image | responsivefilemanager | media | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | print preview fullpage | emoticons",
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
<!--  <========SON=========>>> Editor SON !--><script>
    $(document).ready(function() {
        $('.select_ajax2').select2();
    });
</script>