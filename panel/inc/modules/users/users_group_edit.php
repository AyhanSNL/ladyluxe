
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from uyeler_grup where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                    <h4><?=$diller['adminpanel-form-text-1343']?></h4>
                </div>
                <form action="post.php?process=users_post&status=group_edit" method="post"  >
                    <input type="hidden" name="g_id" value="<?=$row['id']?>" >
                    <div class="row mt-3 justify-content-center">
                        <div class="form-group col-md-12">
                            <label for="baslik2"><?=$diller['adminpanel-form-text-1339']?></label>
                            <input type="text" autocomplete="off"  value="<?=$row['baslik']?>" name="baslik" id="baslik2" required class="form-control">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-md-12 ">
                            <label for="fiyat2"><?=$diller['adminpanel-form-text-1340']?></label>
                            <select name="fiyat_tip" class="form-control" id="fiyat2" required>
                                <option value="0" <?php if($row['fiyat_tip'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1341']?></option>
                                <option value="1" <?php if($row['fiyat_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1342']?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="form-group col-md-12 mb-3 ">
                            <label for="ozel_indirim2"><?=$diller['adminpanel-form-text-1971']?></label>
                            <select name="ozel_indirim" class="form-control" id="ozel_indirim2" required>
                                <option value="0" <?php if($row['ozel_indirim'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1972']?></option>
                                <option value="1" <?php if($row['ozel_indirim'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1973']?></option>
                            </select>
                        </div>
                    </div>
                    <div id="myself-choise2" class="w-100" <?php if($row['ozel_indirim'] != '1' ) { ?>style="display:none"<?php }?>>
                        <div class="row justify-content-center">
                            <div class="form-group col-md-12 mb-2">
                                <label for="indirim_oran2"><?=$diller['adminpanel-form-text-1218']?></label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" autocomplete="off"  id="indirim_oran2" name="indirim_oran" value="<?=$row['indirim_oran']?>" placeholder="<?=$diller['adminpanel-form-text-1660']?>">
                                    <div class="input-group-append">
                                        <div class="input-group-text font-12 font-weight-bold">
                                            <div id="oran">
                                                <i class="fas fa-percent"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        $('#ozel_indirim2').on('change', function() {
                            $('#myself-choise2').css('display', 'none');
                            if ( $(this).val() === '1' ) {
                                $('#myself-choise2').css('display', 'block');
                            }
                        });
                    </script>


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
<?php }?>