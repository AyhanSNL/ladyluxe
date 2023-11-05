<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from para_birimleri where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-741']?></h4>
                    </div>
                    <form action="post.php?process=currency_post&status=edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="para_id" value="<?=$row['id']?>" >
                        <div class="row ">
                            <div class="form-group col-md-5 mb-4">
                                <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                <select name="durum" class="form-control" id="durum" required>
                                    <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                    <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-5 mb-4">
                                <label  for="varsayilan" class="w-100"><?=$diller['adminpanel-form-text-69-c']?></label>
                                <select name="varsayilan" class="form-control" id="varsayilan" required>
                                    <option value="0" <?php if($row['varsayilan'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-69-b']?></option>
                                    <option value="1" <?php if($row['varsayilan'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-69']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-2 mb-4">
                                <label  for="sira" class="w-100"><?=$diller['adminpanel-form-text-55']?></label>
                                <input type="number" name="sira" value="<?=$row['sira']?>" id="sira" required class="form-control">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="baslik"><?=$diller['adminpanel-form-text-725']?></label>
                                <input type="text" autocomplete="off" value="<?=$row['baslik']?>" name="baslik" id="baslik" required class="form-control" placeholder="<?=$diller['adminpanel-form-text-731']?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="kod" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                    <?=$diller['adminpanel-form-text-726']?>
                                    <a href="https://www.tcmb.gov.tr/kurlar/today.xml" target="_blank">
                                        <i class="fa fa-external-link-alt"></i>
                                    </a>
                                </label>
                                <input type="text" autocomplete="off" value="<?=$row['kod']?>" name="kod" id="kod" required class="form-control" placeholder="<?=$diller['adminpanel-form-text-730']?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="deger"><?=$diller['adminpanel-form-text-727']?></label>
                                <input type="text" autocomplete="off"   name="deger" value="<?=$row['deger']?>" id="deger" required class="form-control" placeholder="<?=$diller['adminpanel-form-text-734']?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sol_simge"><?=$diller['adminpanel-form-text-732']?></label>
                                <input type="text" autocomplete="off"  maxlength="1" value="<?=$row['sol_simge']?>" name="sol_simge" id="sol_simge" required class="form-control" placeholder="₺">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sag_simge"><?=$diller['adminpanel-form-text-733']?></label>
                                <input type="text" autocomplete="off"  name="sag_simge" value="<?=$row['sag_simge']?>" id="sag_simge" required class="form-control" placeholder="TL" maxlength="3">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="bozuk_para2"><?=$diller['adminpanel-form-text-1544']?></label>
                                <input type="text" autocomplete="off"  name="bozuk_para"  value="<?=$row['bozuk_para']?>" id="bozuk_para2" required class="form-control" placeholder="Kr" maxlength="3">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="para_format"><?=$diller['adminpanel-form-text-736']?></label>
                                <input type="text" autocomplete="off"  name="para_format"  id="para_format" required class="form-control" value="<?=$row['para_format']?>" maxlength="1">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="simge_gosterim"><?=$diller['adminpanel-form-text-735']?></label>
                                <select name="simge_gosterim" class="form-control" id="simge_gosterim" required>
                                    <option value="0" <?php if($row['simge_gosterim'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-737']?></option>
                                    <option value="1" <?php if($row['simge_gosterim'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-738']?></option>
                                    <option value="2" <?php if($row['simge_gosterim'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-739']?></option>
                                    <option value="3" <?php if($row['simge_gosterim'] == '3' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-740']?></option>
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
