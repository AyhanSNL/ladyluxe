
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from pricing_ozellik where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <script>
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
    </script>
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-1068']?></h4>
                    </div>
                    <form action="post.php?process=ptable_post&status=features_edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="oz_id" value="<?=$row['id']?>" >
                        <input type="hidden" name="parent_id" value="<?=$row['pr_id']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <div class="form-group col-md-8">
                                       <label for="baslik2">* <?=$diller['adminpanel-form-text-1074']?></label>
                                       <input type="text" autocomplete="off" value="<?=$row['baslik']?>"  name="baslik" id="baslik2" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label for="sira2">* <?=$diller['adminpanel-form-text-55']?></label>
                                       <input type="number" autocomplete="off" min="1" value="<?=$row['sira']?>" name="sira" id="sira2" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label for="spot2"><?=$diller['adminpanel-form-text-1069']?></label>
                                       <textarea name="spot" id="spot2" class="form-control" rows="2" ><?=$row['spot']?></textarea>
                                   </div>
                                   <div class="form-group col-md-6">
                                       <label for="bg_renk"><?=$diller['adminpanel-form-text-1070']?></label>
                                       <div data-color-format="default" data-color="#<?=$row['bg_renk']?>"  class="colorpicker-default input-group">
                                           <input type="text" name="bg_renk"  value="" class="form-control">
                                           <div class="input-group-append add-on">
                                               <button class="btn btn-light border" type="button">
                                                   <i style="background-color: rgb(124, 66, 84);"></i>
                                               </button>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="form-group col-md-6">
                                       <label for="yazi_renk"><?=$diller['adminpanel-form-text-1071']?></label>
                                       <div data-color-format="default" data-color="#<?=$row['yazi_renk']?>"  class="colorpicker-default input-group">
                                           <input type="text" name="yazi_renk"  value="" class="form-control">
                                           <div class="input-group-append add-on">
                                               <button class="btn btn-light border" type="button">
                                                   <i style="background-color: rgb(124, 66, 84);"></i>
                                               </button>
                                           </div>
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
