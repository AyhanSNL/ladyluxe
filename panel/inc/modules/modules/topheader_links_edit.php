
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from headertop_menu where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-861']?></h4>
                    </div>
                    <form action="post.php?process=topheader_links_post&status=update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="link_id" value="<?=$row['id']?>" >
                        <div class="row ">
                            <div class="form-group col-md-8 mb-4">
                                <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                <select name="durum" class="form-control" id="durum" required>
                                    <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                    <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                <input type="number" autocomplete="off" min="1" value="<?=$row['sira']?>" name="sira" id="sira" required  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="baslik">* <?=$diller['adminpanel-form-text-849']?></label>
                                <input type="text" autocomplete="off"  value="<?=$row['baslik']?>" name="baslik" id="baslik" required class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="spot"><?=$diller['adminpanel-form-text-855']?></label>
                                <input type="text" autocomplete="off" value="<?=$row['spot']?>" name="spot" id="spot"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ikon" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                    <?=$diller['adminpanel-form-text-675']?>
                                </label>
                                <input type="text" autocomplete="off" value="<?=$row['ikon']?>" name="ikon" id="ikon"  class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="area"><?=$diller['adminpanel-form-text-857']?></label>
                                <select name="area" class="form-control" id="area" required>
                                    <option value="1" <?php if($row['area'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-850']?></option>
                                    <option value="2" <?php if($row['area'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-851']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="yeni_sekme"><?=$diller['adminpanel-form-text-859']?></label>
                                <select name="yeni_sekme" class="form-control" id="yeni_sekme" required>
                                    <option value="0" <?php if($row['yeni_sekme'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-858']?></option>
                                    <option value="1" <?php if($row['yeni_sekme'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-111']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 mb-4">
                                <label  for="mobil" class="w-100"><?=$diller['adminpanel-form-text-894']?></label>
                                <input type="hidden" name="mobil" value="0"">
                                <input type="checkbox" id="mobil" name="mobil" value="1" <?php if($row['mobil'] == '1' ) { ?>checked<?php }?> style="width: 20px; height: 20px; ">
                            </div>
                            <div class="form-group col-md-12 ">
                                <label for="url_tur_edit"><?=$diller['adminpanel-form-text-856']?></label>
                                <select name="url_tur_edit" class="form-control rounded-0 " id="url_tur_edit" required style="height: 55px; font-size: 17px ;">
                                    <option value="0" <?php if($row['url_tur'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-860']?></option>
                                    <option value="1" <?php if($row['url_tur'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-853']?></option>
                                    <option value="2" <?php if($row['url_tur'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-854']?></option>
                                </select>
                            </div>
                            <div id="modul-choise-edit" class="col-md-12 up-arrow-2" <?php if($row['url_tur'] != '1' ) { ?>style="display: none;"<?php }?>    >
                                <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                        <select name="modul_url" class="select_ajax2 form-control rounded-0" id="modul_url"  style="height: 55px; width: 100% !important;  ">
                                            <?php if($row['url'] == !null  ) {?>
                                            <?php
                                                $urladdress = $row['url'];
                                            ?>
                                            <?php }?>
                                            <?php include 'inc/modules/_helper/site_linkleri.php'; ?>
                                        </select>
                                </div>
                            </div>
                            <div id="manuel-choise-edit" class="col-md-12 " <?php if($row['url_tur'] != '2' ) { ?>style="display: none;"<?php }?>   >
                                <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                        <input type="text" name="manuel_url" autocomplete="off" value="<?=$row['url']?>" placeholder="https://"  class="form-control">
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
    $('#url_tur_edit').on('change', function() {
        $('#modul-choise-edit').css('display', 'none');
        if ( $(this).val() === '1' ) {
            $('#modul-choise-edit').css('display', 'block');
        }
        $('#manuel-choise-edit').css('display', 'none');
        if ( $(this).val() === '2' ) {
            $('#manuel-choise-edit').css('display', 'block');
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('.select_ajax2').select2();
    });
</script>