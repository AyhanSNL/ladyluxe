<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from taksit_kart_ay where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-780']?></h4>
                    </div>
                    <form action="post.php?process=installment_rate_post&status=month_edit" method="post">
                        <input type="hidden" name="vade_id" value="<?=$row['id']?>" >
                        <input type="hidden" name="kart_id" value="<?=$row['kart_id']?>" >
                        <div class="row">
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
                            <div class="form-group col-md-6 mb-4">
                                <label for="ay"><?=$diller['adminpanel-form-text-776']?> </label>
                                <input type="text" name="ay" value="<?=$row['ay']?>" id="ay" required class="form-control">
                            </div>
                            <div class="form-group col-md-6 ">
                                <label for="vade_oran" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                    <?=$diller['adminpanel-form-text-774']?>
                                </label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-12 font-weight-bold">%</div>
                                    </div>
                                    <input type="number" class="form-control" id="vade_oran" required value="<?=$row['vade_oran']?>" name="vade_oran">
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