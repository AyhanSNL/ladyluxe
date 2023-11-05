
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from footer_link where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-887']?></h4>
                    </div>
                    <form action="post.php?process=footer_links_post&status=update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="link_no" value="<?=$row['id']?>" >
                        <div class="row ">
                            <div class="form-group col-md-12 mb-4">
                                <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                <select name="durum" class="form-control" id="durum" required>
                                    <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                    <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="baslik">* <?=$diller['adminpanel-form-text-849']?></label>
                                <input type="text" autocomplete="off"  name="baslik" id="baslik" value="<?=$row['baslik']?>" required class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                <input type="number" autocomplete="off" min="1"  name="sira" id="sira"  required value="<?=$row['sira']?>" class="form-control">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="ikon"><?=$diller['adminpanel-form-text-675']?></label>
                                <input type="text" autocomplete="off"  name="ikon" id="ikon" value="<?=$row['ikon']?>"  class="form-control">
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