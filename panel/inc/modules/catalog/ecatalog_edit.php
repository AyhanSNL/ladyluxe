<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from katalog where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <script src="assets/js/bs4inputfilename.js"></script>

    <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  pt-2 pb-2">
                        <h4><?=$diller['adminpanel-form-text-1879']?></h4>
                    </div>
                    <form action="post.php?process=catalog_post2&status=ecatalog_edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="catalog_id" value="<?=$row['id']?>" >
                        <div class="border">

                            <div class="tab-content bg-white rounded-bottom">
                                <div class="tab-pane active p-4" id="one_e" role="tabpanel" >
                                    <div class="row">
                                        <div class="form-group col-md-10">
                                            <label for="baslik2">* <?=$diller['adminpanel-form-text-1878']?></label>
                                            <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-12 mb-0">
                                            <label for="url2"><?=$diller['adminpanel-form-text-1882']?> <small>( PDF )</small></label>
                                            <div class="w-100 bg-light border p-3">
                                                <a href="<?=$ayar['site_url']?>/i/e-catalog/<?=$row['url']?>" target="_blank" class="mx-auto" style=" text-align: center;">
                                                    <i class="fa fa-external-link-alt"></i>
                                                    <?=$diller['adminpanel-form-text-1880']?>
                                                </a>
                                            </div>
                                            <div class="input-group  mt-2">
                                                <div class="custom-file">
                                                    <input type="hidden" name="dosya" value="<?=$row['url']?>">
                                                    <input type="file" class="custom-file-input" id="url2" name="url" >
                                                    <label class="custom-file-label" for="url2"><?=$diller['adminpanel-form-text-1145']?></label>
                                                </div>
                                            </div>
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

