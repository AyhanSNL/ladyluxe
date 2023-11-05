<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from urun_marka where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <script src="assets/js/bs4inputfilename.js"></script>

    <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  pt-2 pb-2">
                        <h4><?=$diller['adminpanel-form-text-1870']?></h4>
                    </div>
                    <form action="post.php?process=catalog_post2&status=brand_edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="brand_id" value="<?=$row['id']?>" >
                        <div class="border">
                            <ul class="nav nav-tabs bg-light pt-2" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link saas active" id="one-tab" data-toggle="tab" href="#one_e" role="tab"  aria-selected="true">
                                        <?=$diller['adminpanel-form-text-981']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas" id="two-tab" data-toggle="tab" href="#two_e" role="tab"  aria-selected="true">
                                        <?=$diller['adminpanel-text-311']?>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content bg-white rounded-bottom">
                                <div class="tab-pane active p-4" id="one_e" role="tabpanel" >
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-4">
                                            <label  for="durum2" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="durum" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="durum2" name="durum" value="1"  <?php if($row['durum'] == '1' ) { ?>checked<?php }?> >
                                                <label class="custom-control-label" for="durum2"></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 mb-4">
                                            <label  for="ana2" class="w-100" ><?=$diller['adminpanel-form-text-1080']?></label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="anasayfa" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="ana2" name="anasayfa" value="1"  <?php if($row['anasayfa'] == '1' ) { ?>checked<?php }?> >
                                                <label class="custom-control-label" for="ana2"></label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="sira2">* <?=$diller['adminpanel-form-text-55']?></label>
                                            <input type="number" autocomplete="off"  name="sira" id="sira2" value="<?=$row['sira']?>" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-10">
                                            <label for="baslik2">* <?=$diller['adminpanel-form-text-1869']?></label>
                                            <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="icerik2"><?=$diller['adminpanel-form-text-1849']?></label>
                                            <textarea name="spot" id="tiny2" class="form-control" rows="3" ><?=$row['spot']?></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="gorsel22"><?=$diller['adminpanel-form-text-1875']?> <small>( png,  jpg, jpeg, gif )</small></label>
                                            <div class="w-100 bg-light border p-3">
                                                <div class="mx-auto" style=" text-align: center;">
                                                    <?php if($row['gorsel'] == !null ) {?>
                                                        <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/uploads/<?=$row['gorsel']?>" style="max-height: 90px">
                                                    <?php }else { ?>
                                                        <img src="assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 150px; " >
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="input-group ">
                                                <div class="custom-file">
                                                    <input type="hidden" name="gorsel_old" value="<?=$row['gorsel']?>">
                                                    <input type="file" class="custom-file-input" id="gorsel22" name="gorsel" >
                                                    <label class="custom-file-label" for="gorsel22"><?=$diller['adminpanel-form-text-106']?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="gorselHome"><?=$diller['adminpanel-form-text-1876']?> <small>( png,  jpg, jpeg, gif )</small></label>
                                            <div class="w-100 bg-light border p-3">
                                                <div class="mx-auto" style=" text-align: center;">
                                                    <?php if($row['gorsel_anasayfa'] == !null ) {?>
                                                        <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/uploads/<?=$row['gorsel_anasayfa']?>" style="max-height: 90px">
                                                    <?php }else { ?>
                                                        <img src="assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 150px; " >
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="input-group ">
                                                <div class="custom-file">
                                                    <input type="hidden" name="gorsel_anasayfa_old" value="<?=$row['gorsel_anasayfa']?>">
                                                    <input type="file" class="custom-file-input" id="gorselHome" name="gorsel_anasayfa" >
                                                    <label class="custom-file-label" for="gorselHome"><?=$diller['adminpanel-form-text-106']?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-4" id="two_e" role="tabpanel" >
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="seo_url2" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1012']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1014']?>"></i></label>
                                            <input type="text" autocomplete="off" value="<?=$row['seo_url']?>" name="seo_url" id="seo_url2" placeholder="<?=$diller['adminpanel-form-text-1013']?>"  class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="seo_baslik2" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1015']?> <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1016']?>"></i></label>
                                            <input type="text" autocomplete="off" value="<?=$row['baslik_seo']?>"  name="baslik_seo" id="seo_baslik2"  class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label  for="tags2" class="w-100"><?=$diller['adminpanel-form-text-6']?> </label>
                                            <input type="text" name="tags"  id="tags2" data-role="tagsinput" value="<?=$row['tags']?>" placeholder="<?=$diller['adminpanel-form-text-7']?>" class="form-control" />
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label  for="meta_desc2" class="w-100"><?=$diller['adminpanel-form-text-5']?> </label>
                                            <textarea name="meta_desc" id="meta_desc2" class="form-control" rows="2" ><?=$row['meta_desc']?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button class="btn btn-success btn-block  shadow-sm" name="brandEdit">
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

