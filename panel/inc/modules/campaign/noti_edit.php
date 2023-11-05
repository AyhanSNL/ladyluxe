
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from bildirimler where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                    <h4><?=$diller['adminpanel-form-text-1275']?></h4>
                </div>
                <form action="post.php?process=noti_post&status=edit" method="post"  >
                    <input type="hidden" name="noti_id" value="<?=$row['id']?>" >
                    <div class="row">
                        <div class="form-group col-md-12 mb-4">
                            <label  for="durums" class="w-100" ><?=$diller['adminpanel-form-text-62']?></label>
                            <div class="custom-control custom-switch custom-switch-lg">
                                <input type="hidden" name="durum" value="0"">
                                <input type="checkbox" class="custom-control-input" id="durums" name="durum" value="1"  <?php if($row['durum'] == '1' ) { ?>checked<?php }?> >
                                <label class="custom-control-label" for="durums"></label>
                            </div>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="baslik2">* <?=$diller['adminpanel-form-text-1180']?></label>
                            <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                        </div>
                        <div class="form-group col-md-4 ">
                            <label  for="ikon2" class="w-100" >
                                <?=$diller['adminpanel-form-text-1260']?>
                                <a href="https://html-css-js.com/html/character-codes/icons/" target="_blank"><i class="fa fa-external-link-alt"></i></a>
                            </label>
                            <input type="text" name="ikon" id="ikon2" value="<?=$row['ikon']?>" placeholder="<?=$diller['adminpanel-form-text-1150']?> : &#127881;"  class="form-control">
                        </div>
                        <div class="form-group col-md-12 ">
                            <label  for="icerik" class="w-100" >
                                * <?=$diller['adminpanel-form-text-1261']?>
                            </label>
                            <textarea name="icerik" id="tiny2" class="form-control" rows="3"  ><?=$row['icerik']?></textarea>
                        </div>
                    </div>
                    <div class="w-100 pt-2  d-flex justify-content-end">
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
    <script src="plugins/tinymce/tinymce.min.js"></script>
    <!-- Editor !-->
    <script>

        $(document).ready(function(){0<$("#tiny2").length&&tinymce.init({selector:"textarea#tiny2",
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
<?php } ?>