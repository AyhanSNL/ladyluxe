
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from ticaret_bilgi where id='$_POST[postID]' ");
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
                    <h4><?=$diller['adminpanel-form-text-1182']?></h4>
                </div>
                <form action="post.php?process=tbox_post&status=edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="tbox_id" value="<?=$row['id']?>" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="form-group col-md-4">
                                    <label for="sira2">* <?=$diller['adminpanel-form-text-55']?></label>
                                    <input type="number" autocomplete="off" min="1"  name="sira" value="<?=$row['sira']?>" id="sira2"  required class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="baslik2">* <?=$diller['adminpanel-form-text-1180']?></label>
                                    <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="spot2">* <?=$diller['adminpanel-form-text-1181']?></label>
                                    <input type="text" autocomplete="off"  value="<?=$row['spot']?>" name="spot" id="spot2" required class="form-control">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="icon2" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                        <?=$diller['adminpanel-form-text-675']?>
                                    </label>
                                    <input type="text" autocomplete="off" value="<?=$row['icon']?>"  name="icon" id="icon2"  class="form-control">
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