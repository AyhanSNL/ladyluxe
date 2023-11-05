<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from siparis_durumlar where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-673']?></h4>
                    </div>
                    <form action="post.php?process=order_status_post&status=edit" method="post">
                        <input type="hidden" name="status_id" value="<?=$row['id']?>" >
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
                            <div class="form-group col-md-12 mb-4">
                                <label for="baslik"><?=$diller['adminpanel-form-text-674']?> </label>
                                <input type="text" name="baslik" value="<?=$row['baslik']?>" id="baslik" required class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="renk"><?=$diller['adminpanel-form-text-676']?></label>
                                <select name="renk" class="form-control icon_select2" id="renk" required style="width: 100%;  ">
                                    <option value="button-black-white" <?php if($row['renk'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                    <option value="button-white-black" <?php if($row['renk'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                    <option value="button-yellow" <?php if($row['renk'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                    <option value="button-yellow-out" <?php if($row['renk'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                    <option value="button-black" <?php if($row['renk'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                    <option value="button-black-out" <?php if($row['renk'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                    <option value="button-white" <?php if($row['renk'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                    <option value="button-white-out" <?php if($row['renk'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                    <option value="button-gold" <?php if($row['renk'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                    <option value="button-gold-out" <?php if($row['renk'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                    <option value="button-red" <?php if($row['renk'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                    <option value="button-red-out" <?php if($row['renk'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                    <option value="button-blue" <?php if($row['renk'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                    <option value="button-blue-out" <?php if($row['renk'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                    <option value="button-yellow" <?php if($row['renk'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                    <option value="button-yellow-out" <?php if($row['renk'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                    <option value="button-green" <?php if($row['renk'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                    <option value="button-green-out" <?php if($row['renk'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                    <option value="button-grey" <?php if($row['renk'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                    <option value="button-grey-out" <?php if($row['renk'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                    <option value="button-orange" <?php if($row['renk'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                    <option value="button-orange-out" <?php if($row['renk'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                    <option value="button-pink" <?php if($row['renk'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="bstrp_bg " class="d-flex align-items-center justify-content-start">
                                    <?=$diller['adminpanel-form-text-676']?> / Bootstrap
                                    <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1436']?>"></i>
                                </label>
                                <select name="bstrp_bg" class="form-control" id="bstrp_bg" required>
                                    <option value="btn-dark" <?php if($row['bstrp_bg'] == 'btn-dark' ) { ?>selected<?php }?>>Dark</option>
                                    <option value="btn-danger" <?php if($row['bstrp_bg'] == 'btn-danger' ) { ?>selected<?php }?>>Danger </option>
                                    <option value="btn-primary" <?php if($row['bstrp_bg'] == 'btn-primary' ) { ?>selected<?php }?>>Primary </option>
                                    <option value="btn-success" <?php if($row['bstrp_bg'] == 'btn-success' ) { ?>selected<?php }?>>Success </option>
                                    <option value="btn-info" <?php if($row['bstrp_bg'] == 'btn-info' ) { ?>selected<?php }?>>Info </option>
                                    <option value="btn-light" <?php if($row['bstrp_bg'] == 'btn-light' ) { ?>selected<?php }?>>Light </option>
                                    <option value="btn-secondary" <?php if($row['bstrp_bg'] == 'btn-secondary' ) { ?>selected<?php }?>>Secondary </option>
                                    <option value="btn-warning" <?php if($row['bstrp_bg'] == 'btn-warning' ) { ?>selected<?php }?>>Warning </option>
                                    <option value="btn-pink" <?php if($row['bstrp_bg'] == 'btn-pink' ) { ?>selected<?php }?>>Pink </option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="ikon"><?=$diller['adminpanel-form-text-675']?></label>
                                <select class="icon_select2 form-control col-md-12" name="ikon" id="ikon" style="width: 100%!important;" >
                                    <option value="<?=$row['ikon']?>"><?=$row['ikon']?></option>
                                    <?php include 'inc/modules/_helper/icon.php'?>
                                </select>
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
        $('.icon_select2').select2();
    });
</script>