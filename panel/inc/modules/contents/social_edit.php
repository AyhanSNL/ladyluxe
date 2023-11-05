
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from sosyal where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-1172']?></h4>
                    </div>
                    <form action="post.php?process=social_post&status=edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="sos_id" value="<?=$row['id']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row  mt-3">
                                   <div class="form-group col-md-4 mb-4">
                                       <label  for="footer2" class="w-100" ><?=$diller['adminpanel-form-text-1166']?></label>
                                       <div class="custom-control custom-switch custom-switch-lg">
                                           <input type="hidden" name="footer" value="0"">
                                           <input type="checkbox" class="custom-control-input" id="footer2" name="footer" value="1" <?php if($row['footer'] == '1' ) { ?>checked<?php }?>   ">
                                           <label class="custom-control-label" for="footer2"></label>
                                       </div>
                                   </div>
                                   <div class="form-group col-md-4 mb-4">
                                       <label  for="bakim2" class="w-100" ><?=$diller['adminpanel-form-text-1167']?></label>
                                       <div class="custom-control custom-switch custom-switch-lg">
                                           <input type="hidden" name="bakim" value="0"">
                                           <input type="checkbox" class="custom-control-input" id="bakim2" name="bakim" value="1"  <?php if($row['bakim'] == '1' ) { ?>checked<?php }?> ">
                                           <label class="custom-control-label" for="bakim2"></label>
                                       </div>
                                   </div>
                               </div>
                               <div class="row ">
                                   <div class="form-group col-md-4">
                                       <label for="sir2a">* <?=$diller['adminpanel-form-text-55']?></label>
                                       <input type="number" autocomplete="off" min="1"  name="sira" id="sir2a"  value="<?=$row['sira']?>" required class="form-control">
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="form-group col-md-6">
                                       <label for="basli2k">* <?=$diller['adminpanel-form-text-1164']?></label>
                                       <input type="text" autocomplete="off"  name="baslik" id="basli2k" value="<?=$row['baslik']?>" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label for="url2"><?=$diller['adminpanel-form-text-1165']?></label>
                                       <input type="text" autocomplete="off"  name="url" value="<?=$row['url']?>" id="url2" placeholder="https://"  class="form-control">
                                   </div>
                                   <div class="form-group col-md-6">
                                       <label for="icon2"><?=$diller['adminpanel-form-text-675']?></label>
                                       <select class="icon_select3 form-control col-md-12" name="icon" id="icon2" style="width: 100%!important;" >
                                           <option value="<?=$row['icon']?>" selected><?=$row['icon']?></option>
                                           <?php include 'inc/modules/_helper/icon.php'?>
                                       </select>
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
<script>
    $(document).ready(function() {
        $('.icon_select3').select2();
    });
</script>