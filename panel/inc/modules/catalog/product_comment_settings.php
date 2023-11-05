<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>

<?php if($_POST['postID'] == '1' ) {
    $ayar = $db->prepare("select * from urun_detay where id=:id ");
    $ayar->execute(array(
            'id' => '1'
    ));
    $row = $ayar->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-1896']?></h4>
                    </div>
                    <form action="post.php?process=catalog_post2&status=comment_set" method="post" >
                        <div class="row">
                            <div class="form-group col-md-12 mb-4">
                                <label  for="urun_yorum_onay" class="w-100" ><?=$diller['adminpanel-form-text-313']?></label>
                                <div class="custom-control custom-switch custom-switch-lg">
                                    <input type="hidden" name="urun_yorum_onay" value="0"">
                                    <input type="checkbox" class="custom-control-input" id="urun_yorum_onay" name="urun_yorum_onay" value="1"  <?php if($row['urun_yorum_onay'] == '1'  ) { ?>checked<?php }?> ">
                                    <label class="custom-control-label" for="urun_yorum_onay"></label>
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

<?php }else { ?>
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                    <h4><?=$diller['adminpanel-modal-text-4']?></h4>
                </div>
                <div class="row">
                   <div class="col-md-12">
                       <?=$diller['adminpanel-modal-text-5']?>
                   </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
<?php }?>

