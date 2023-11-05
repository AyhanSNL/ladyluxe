<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($_POST['postID']  ) {

    $DilCek = $db->prepare("select * from dil where id='$_POST[postID]' ");
    $DilCek->execute();
    $dil = $DilCek->fetch(PDO::FETCH_ASSOC);

    ?>

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-text-262']?></h4>
                    </div>
                    <form action="post.php?process=lang_post&status=lang_edit" method="post">
                        <input type="hidden" name="lang_id" value="<?=$dil['id']?>" >
                        <div class="row">
                            <div class="form-group col-md-12 mb-4">
                                <label  for="durum3" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                <select name="durum" class="form-control" id="durum3" required>
                                    <option value="0" <?php if($dil['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                    <option value="1" <?php if($dil['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="baslik">* <?=$diller['adminpanel-form-text-64']?></label>
                                <input type="text" name="baslik" id="baslik" value="<?=$dil['baslik']?>"  autocomplete="off"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="area">* <?=$diller['adminpanel-form-text-66']?></label>
                                <select name="area" class="form-control" id="area" required>
                                    <option value="ltr" <?php if($dil['area'] == 'ltr' ) { ?>selected<?php }?>><?=$diller['adminpanel-text-255']?></option>
                                    <option value="rtl" <?php if($dil['area'] == 'rtl' ) { ?>selected<?php }?>><?=$diller['adminpanel-text-256']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                <input type="number" name="sira" value="<?=$dil['sira']?>" id="sira" required class="form-control">
                            </div>
                        </div>
                        <?php if($yetki['demo'] != '1'  ) {?>
                        <div class="w-100 border border-warning alert-warning rounded text-dark p-3">
                           <?=$diller['adminpanel-text-257']?>
                            <br><br>
                            <u><?=$diller['adminpanel-text-258']?></u>
                            <br><br>
                            <?=$diller['adminpanel-text-259']?> : <strong><?=$ayar['site_url']?>includes/lang/<?=$dil['kisa_ad']?>.php</strong>
                            <br>
                            <?=$diller['adminpanel-text-260']?> : <strong><?=$ayar['site_url']?>includes/lang/<?=$dil['kisa_ad']?>-panel.php</strong>
                            <br>
                            <br>
                           <?=$diller['adminpanel-text-261']?>
                        </div>
                        <?php } ?>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button class="btn btn-success flex-grow-1  shadow" name="langEdit">
                                <?=$diller['adminpanel-form-text-53']?>
                            </button>
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-light mr-1 ">
                                <?=$diller['adminpanel-modal-text-17']?>
                            </button>

                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

<?php }else{
    header('Location:'.$ayar['site_url'].'404');
}?>
