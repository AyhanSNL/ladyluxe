<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from fontlar where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-440']?></h4>
                    </div>
                    <form action="post.php?process=theme_font_post&status=font_edit" method="post">
                        <input type="hidden" name="font_id" value="<?=$row['id']?>" >
                        <div class="row">
                            <div class="form-group col-md-12 ">
                                <div class="border border-warning mb-1 p-3  font-16">
                                    <?=$diller['adminpanel-text-314']?>
                                </div>
                            </div>
                            <div class="form-group col-md-9 mb-4">
                                <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                <select name="durum" class="form-control" id="durum" required>
                                    <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                    <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 mb-4">
                                <label  for="sira" class="w-100"><?=$diller['adminpanel-form-text-55']?></label>
                                <input type="number" name="sira" value="<?=$row['sira']?>" id="sira" required class="form-control">
                            </div>
                            <div class="form-group col-md-12 mb-4">
                                <label for="font_adi"><?=$diller['adminpanel-form-text-439']?> </label>
                                <input type="text" name="font_adi" value="<?=$row['font_adi']?>" id="font_adi" required class="form-control">
                                <small class="bg-light border p-1">
                                  <strong><?=$diller['adminpanel-form-text-442']?></strong> font-family: 'Open Sans', sans-serif; <?=$diller['adminpanel-form-text-443']?>
                                </small>
                            </div>
                            <div class="form-group col-md-12 mb-4">
                                <label for="kod"><?=$diller['adminpanel-form-text-441']?> </label>
                                <textarea name="kod" id="kod" class="form-control" rows="2" required><?=$row['kod']?></textarea>
                                <small class="bg-light border p-1">
                                    <strong><?=$diller['adminpanel-form-text-442']?></strong> : https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800
                                </small>
                            </div>
                        </div>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-light mr-1 ">
                                <?=$diller['adminpanel-modal-text-17']?>
                            </button>
                            <button class="btn btn-success  shadow" name="update">
                                <?=$diller['adminpanel-form-text-53']?>
                            </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

<?php }?>
