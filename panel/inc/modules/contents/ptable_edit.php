
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from pricing_kat where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-1036']?></h4>
                    </div>
                    <form action="post.php?process=ptable_post&status=catedit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="cat_id" value="<?=$row['id']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <div class="form-group col-md-6 ">
                                       <label  for="durum2" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                       <select name="durum" class="form-control" id="2" required>
                                           <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                           <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-6 ">
                                       <label  for="tab_durum2" class="w-100"><?=$diller['adminpanel-form-text-1034']?></label>
                                       <select name="tab_durum" class="form-control" id="tab_durum2" required>
                                           <option value="0" <?php if($row['tab_durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                           <option value="1" <?php if($row['tab_durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-8">
                                       <label for="baslik2">* <?=$diller['adminpanel-form-text-1009']?></label>
                                       <input type="text" autocomplete="off" value="<?=$row['baslik']?>"  name="baslik" id="baslik2" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label for="sira2">* <?=$diller['adminpanel-form-text-55']?></label>
                                       <input type="number" autocomplete="off" min="1" value="<?=$row['sira']?>" name="sira" id="sira2" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label for="seo_url2" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1012']?> </label>
                                       <input type="text" autocomplete="off"  name="seo_url" id="seo_url2" value="<?=$row['seo_url']?>" placeholder="<?=$diller['adminpanel-form-text-1013']?>"  class="form-control">
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label for="seo_baslik2" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1015']?> </label>
                                       <input type="text" autocomplete="off"  name="seo_baslik" id="seo_baslik2" value="<?=$row['seo_baslik']?>"  class="form-control">
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
