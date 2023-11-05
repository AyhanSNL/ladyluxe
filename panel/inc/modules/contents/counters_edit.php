
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from sayac where id='$_POST[postID]' ");
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
                    <h4><?=$diller['adminpanel-form-text-1174']?></h4>
                </div>
                <form action="post.php?process=counters_post&status=edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="counter_id" value="<?=$row['id']?>" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="form-group col-md-12 mb-4">
                                    <label  for="durum2" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="hidden" name="durum" value="0"">
                                        <input type="checkbox" class="custom-control-input" id="durum2" name="durum" value="1"  <?php if($row['durum'] == '1' ) { ?>checked<?php }?> >
                                        <label class="custom-control-label" for="durum2"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                    <input type="number" autocomplete="off" min="1"  name="sira" value="<?=$row['sira']?>" id="sira"  required class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="baslik">* <?=$diller['adminpanel-form-text-1175']?></label>
                                    <input type="text" autocomplete="off"  name="baslik" id="baslik" value="<?=$row['baslik']?>" required class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="count">* <?=$diller['adminpanel-form-text-1176']?></label>
                                    <input type="number" autocomplete="off" min="1"  name="count" value="<?=$row['count']?>" id="count"  required class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="icon2"><?=$diller['adminpanel-form-text-675']?></label>
                                    <select class="icon_select3 form-control col-md-12" name="icon" id="icon2" style="width: 100%!important;" >
                                        <?php if($row['icon'] == !null ) {?>
                                            <option value="<?=$row['icon']?>" selected><?=$row['icon']?></option>
                                        <?php }?>
                                        <option value=""><?=$diller['adminpanel-form-text-1178']?></option>
                                        <?php include 'inc/modules/_helper/icon.php'?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label  for="plus2" class="w-100" ><?=$diller['adminpanel-form-text-1177']?></label>
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="hidden" name="plus" value="0"">
                                        <input type="checkbox" class="custom-control-input" id="plus2" name="plus" value="1"  <?php if($row['plus'] == '1' ) { ?>checked<?php }?> >
                                        <label class="custom-control-label" for="plus2"></label>
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