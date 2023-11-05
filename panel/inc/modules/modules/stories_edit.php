
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from story_grup where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    $storyAyar = $db->prepare("select tur from story_ayar where id='1' ");
    $storyAyar->execute();
    $stAyar = $storyAyar->fetch(PDO::FETCH_ASSOC);
    
    ?>
    <script src="assets/js/bs4inputfilename.js"></script>
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-930']?></h4>
                    </div>
                    <form action="post.php?process=stories_post&status=update_group" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="story_id" value="<?=$row['id']?>" >
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label  for="durum" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                <select name="durum" class="form-control" id="durum" required>
                                    <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                    <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="sira">* <?=$diller['adminpanel-form-text-55']?></label>
                                <input type="number" autocomplete="off" min="1"  name="sira" id="sira" value="<?=$row['sira']?>" required class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="baslik"><?php if($stAyar['tur'] == '1' ) { ?>* <?=$diller['adminpanel-form-text-920']?><?php }else{?><?=$diller['adminpanel-form-text-920']?> (<?=$diller['adminpanel-form-text-933']?>)<?php } ?></label>
                                <input type="text" autocomplete="off"  name="baslik" id="baslik" value="<?=$row['baslik']?>" <?php if($stAyar['tur'] == '1' ) { ?>required<?php } ?> class="form-control">
                            </div>
                            <?php if($stAyar['tur'] == '2' ) {?>
                                <div class="form-group col-md-12">
                                    <label for="url_adres">* <?=$diller['adminpanel-form-text-921']?></label>
                                    <input type="text" name="url_adres" id="url_adres" value="<?=$row['url_adres']?>"  placeholder="https://"   autocomplete="off" class="form-control">
                                </div>
                            <?php }?>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="gorsel"><?=$diller['adminpanel-form-text-922']?>  <small>(png, jpg, jpeg, webp, jp2, gif )</small></label>
                                <div class="w-100 bg-light border p-3">
                                    <div class="mx-auto" style="max-width: 200px">
                                        <img class="img-fluid p-3 bg-white border" src="<?=$ayar['site_url']?>i/stories/<?=$row['gorsel']?>" alt="">
                                    </div>
                                </div>
                                <div class="input-group ">
                                    <div class="custom-file">
                                        <input type="hidden" name="old_img" value="<?=$row['gorsel']?>">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel" >
                                        <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
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
