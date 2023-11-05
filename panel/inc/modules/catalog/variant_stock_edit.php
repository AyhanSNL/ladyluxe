<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from detay_varyant_stok where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-text-159']?></h4>
                    </div>
                    <form action="post.php?process=catalog_post&status=product_post" method="post" >
                        <input type="hidden" name="product_id" value="<?=$row['urun_id']?>" >
                        <input type="hidden" name="tab" value="variant_stock_edit" >
                        <input type="hidden" name="stock_id" value="<?=$row['id']?>" >

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="stok_name2">* <?=$diller['adminpanel-form-text-1758']?></label>
                                <input type="text" name="stok_kodu" value="<?=$row['stok_kodu']?>" autocomplete="off"  id="stok_name2" required class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="stok_adet2">* <?=$diller['adminpanel-form-text-1759']?></label>
                                <input type="number" name="stok"  id="stok_adet2" value="<?=$row['stok']?>" required class="form-control">
                            </div>
                        </div>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button class="btn btn-success btn-block  shadow-sm" name="stockEdit">
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

