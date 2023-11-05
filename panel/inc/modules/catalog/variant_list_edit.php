<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from urun_varyant_ozellik where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  pt-2 pb-2">
                        <h4><?=$diller['adminpanel-form-text-1887']?></h4>
                    </div>
                    <form action="post.php?process=catalog_post2&status=variant_edit" method="post">
                        <input type="hidden" name="list_id" value="<?=$row['id']?>" >
                        <input type="hidden" name="var_id" value="<?=$row['var_id']?>" >
                        <div class="border">

                            <div class="tab-content bg-white rounded-bottom">
                                <div class="tab-pane active p-4" id="one_e" role="tabpanel" >
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="baslik2">* <?=$diller['adminpanel-form-text-1885']?></label>
                                            <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button class="btn btn-success btn-block  shadow-sm" name="edit">
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

