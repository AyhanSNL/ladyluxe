<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from sitemap_link where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  pt-2 pb-2">
                    <h4><?=$diller['adminpanel-form-text-1946']?></h4>
                </div>
                <form action="pages.php?page=sitemap&process=address_edit" method="post">
                    <input type="hidden" name="address_id" value="<?=$row['id']?>" >
                    <input type="hidden" name="address_item" value="edit" >
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input type="text" autocomplete="off"  name="adres_name" id="adres_name" value="<?=$row['adres']?>" required class="form-control">
                        </div>
                        <div class="form-group col-md-3 mb-0">
                            <label for="sira">
                                <?=$diller['adminpanel-form-text-55']?>
                            </label>
                            <input type="text" autocomplete="off"  name="sira" id="sira" value="<?=$row['sira']?>" required class="form-control">
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

