
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from iletisim_bilgileri where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-1161']?></h4>
                    </div>
                    <form action="post.php?process=contact_post&status=edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="contact_id" value="<?=$row['id']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <div class="form-group col-md-8 ">
                                       <label  for="durum2" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                       <select name="durum" class="form-control" id="2" required>
                                           <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                           <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label for="sira2">* <?=$diller['adminpanel-form-text-55']?></label>
                                       <input type="number" autocomplete="off" min="1" value="<?=$row['sira']?>" name="sira" id="sira2" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label for="basli2k">* <?=$diller['adminpanel-form-text-1158']?></label>
                                       <input type="text" autocomplete="off"  name="baslik" value="<?=$row['baslik']?>" id="basli2k" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label for="col_md"><?=$diller['adminpanel-form-text-968']?></label>
                                       <select name="col_md" class="form-control" id="col_md" required>
                                           <option value="3" <?php if($row['col_md'] == '3' ) { ?>selected<?php }?>>col 3</option>
                                           <option value="4" <?php if($row['col_md'] == '4' ) { ?>selected<?php }?>>col 4</option>
                                           <option value="6" <?php if($row['col_md'] == '6' ) { ?>selected<?php }?>>col 6</option>
                                           <option value="8" <?php if($row['col_md'] == '8' ) { ?>selected<?php }?>>col 8</option>
                                           <option value="9" <?php if($row['col_md'] == '9' ) { ?>selected<?php }?>>col 9</option>
                                           <option value="12" <?php if($row['col_md'] == '12' ) { ?>selected<?php }?>>col 12</option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-4">
                                       <label for="ikon2" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                           <?=$diller['adminpanel-form-text-675']?>
                                       </label>
                                       <input type="text" autocomplete="off"  name="ikon" id="ikon2" value="<?=$row['ikon']?>"  class="form-control">
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label for="icerik2">* <?=$diller['adminpanel-form-text-1159']?></label>
                                       <input type="text" autocomplete="off"  name="icerik" id="icerik2" value="<?=$row['icerik']?>" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label for="adres_url2"><?=$diller['adminpanel-form-text-1160']?> (<?=$diller['adminpanel-form-text-933']?>)</label>
                                       <input type="text" autocomplete="off"  name="adres_url" id="adres_url2" value="<?=$row['adres_url']?>" placeholder="https://"  class="form-control">
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
