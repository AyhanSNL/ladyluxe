
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from vitrin_tip1_grup where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);


    ?>
    <script src="assets/js/bs4inputfilename.js"></script>
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script>
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
    </script>
    <style>
        .modal-content{
            border:1px solid #CCC !important;
            box-shadow:0 0 25px rgba(0,0,0,.2);
        }
    </style>
    <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-960']?></h4>
                    </div>
                    <form action="post.php?process=showcase_post&status=bannerproduct_edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="grup_id" value="<?=$row['id']?>" >
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="card border mb-1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-8">
                                                <label  for="durum2" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                                <select name="durum" class="form-control" id="durum2" required>
                                                    <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                                    <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="sira2">* <?=$diller['adminpanel-form-text-55']?></label>
                                                <input type="number" autocomplete="off" min="1"  name="sira" id="sira2" value="<?=$row['sira']?>" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12 ">
                                                <label  for="tur2" class="w-100" ><?=$diller['adminpanel-form-text-955']?></label>
                                                <select name="tur" class="form-control" id="tur2" required>
                                                    <option value="0" <?php if($row['tur'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-954']?></option>
                                                    <option value="1" <?php if($row['tur'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-953']?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="baslik2">* <?=$diller['adminpanel-form-text-950']?></label>
                                                <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="spot2"><?=$diller['adminpanel-form-text-952']?></label>
                                                <textarea name="spot" id="spot2" class="form-control" rows="2" ><?=$row['spot']?></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <select name="baslik_durum" class="form-control" id="baslik_durum" required>
                                                    <option value="0" <?php if($row['baslik_durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-962']?></option>
                                                    <option value="1" <?php if($row['baslik_durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-961']?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="card border mb-1">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-951']?>  <small>( png,  jpg, jpeg )</small></label>
                                                <div class="w-100 bg-light border p-3">
                                                    <div class="mx-auto" style="max-width: 200px; text-align: center;">
                                                        <?php if($row['gorsel'] == !null ) {?>
                                                            <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/uploads/<?=$row['gorsel']?>" alt=""style="height: 130px">
                                                            <br>
                                                            <a href="" data-href="post.php?process=showcase_post&status=bannerproduct_img_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger mt-2"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                        <?php }else { ?>
                                                            <img src="assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 150px; " >
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="input-group ">
                                                    <div class="custom-file">
                                                        <input type="hidden" name="old_img" value="<?=$row['gorsel']?>">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01_2" name="gorsel" >
                                                        <label class="custom-file-label" for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-106']?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="gorsel_baslik2"><?=$diller['adminpanel-form-text-957']?></label>
                                                <input type="text" autocomplete="off"  name="gorsel_baslik" id="gorsel_baslik2" value="<?=$row['gorsel_baslik']?>"  class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="gorsel_baslik_renk"><?=$diller['adminpanel-form-text-958']?></label>
                                                <div data-color-format="default" data-color="#<?=$row['gorsel_baslik_renk']?>"  class="colorpicker-default input-group">
                                                    <input type="text" name="gorsel_baslik_renk"  value="" class="form-control">
                                                    <div class="input-group-append add-on">
                                                        <button class="btn btn-light border" type="button">
                                                            <i style="background-color: rgb(124, 66, 84);"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="adres_url2"><?=$diller['adminpanel-form-text-959']?></label>
                                                <input type="text" autocomplete="off" value="<?=$row['adres_url']?>"  name="adres_url" placeholder="https://" id="adres_url2"  class="form-control">
                                            </div>
                                        </div>
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
