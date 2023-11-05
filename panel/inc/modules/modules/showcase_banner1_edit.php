
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from vitrin_tip2 where id='$_POST[postID]' ");
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
                        <h4><?=$diller['adminpanel-form-text-974']?></h4>
                    </div>
                    <form action="post.php?process=showcase_post&status=banner1_edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="vitrin_id" value="<?=$row['id']?>" >
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
                                            <div class="form-group col-md-12">
                                                <label for="baslik2">* <?=$diller['adminpanel-form-text-967']?></label>
                                                <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="spot2"><?=$diller['adminpanel-form-text-969']?></label>
                                                <textarea name="spot" id="spot2" class="form-control" rows="2" ><?=$row['spot']?></textarea>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="col_md2"><?=$diller['adminpanel-form-text-968']?></label>
                                                <select name="col_md" class="form-control" id="col_md2" required>
                                                    <option value="col-md-3" <?php if($row['col_md'] == 'col-md-3' ) { ?>selected<?php }?>>col 3</option>
                                                    <option value="col-md-4" <?php if($row['col_md'] == 'col-md-4' ) { ?>selected<?php }?>>col 4</option>
                                                    <option value="col-md-6" <?php if($row['col_md'] == 'col-md-6' ) { ?>selected<?php }?>>col 6</option>
                                                    <option value="col-md-8" <?php if($row['col_md'] == 'col-md-8' ) { ?>selected<?php }?>>col 8</option>
                                                    <option value="col-md-9" <?php if($row['col_md'] == 'col-md-9' ) { ?>selected<?php }?>>col 9</option>
                                                    <option value="col-md-12" <?php if($row['col_md'] == 'col-md-12' ) { ?>selected<?php }?>>col 12</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="adres_url2"><?=$diller['adminpanel-form-text-908']?></label>
                                                <input type="text" name="adres_url" id="adres_url2" value="<?=$row['adres_url']?>" placeholder="https://"  autocomplete="off" class="form-control">
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
                                                    <div class="mx-auto" style=" text-align: center;">
                                                        <?php if($row['gorsel'] == !null ) {?>
                                                            <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/uploads/<?=$row['gorsel']?>" alt=""style="height: 160px">
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
                                            <div class="form-group col-md-12 mb-0">
                                                <label for="yazi_durum2"><?=$diller['adminpanel-form-text-971']?></label>
                                                <select name="yazi_durum" class="form-control rounded-0 " id="yazi_durum2" required style="height: 55px">
                                                    <option value="0" <?php if($row['yazi_durum'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-975']?></option>
                                                    <option value="1" <?php if($row['yazi_durum'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-976']?></option>
                                                </select>
                                            </div>
                                            <div id="yazi-durum-1" class="col-md-12 " <?php if($row['yazi_durum'] != '1' ) { ?>style="display: none;"<?php }?>   >
                                                <div class="w-100 p-3 border bg-light  ">
                                                    <div class="form-group col-md-12">
                                                        <label for="yazi_color"><?=$diller['adminpanel-form-text-973']?></label>
                                                        <div data-color-format="default" data-color="#<?=$row['yazi_color']?>"  class="colorpicker-default input-group">
                                                            <input type="text" name="yazi_color"  value="" class="form-control">
                                                            <div class="input-group-append add-on">
                                                                <button class="btn btn-light border" type="button">
                                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12 mb-0">
                                                        <div class="kustom-checkbox">
                                                            <input type="hidden" name="dark" value="0"">
                                                            <input type="checkbox" class="individual" id="dark2" name='dark' value="1" <?php if($row['dark'] == '1' ) { ?>checked<?php }?>>
                                                            <label for="dark2"><span style="font-size: 14px ;"><?=$diller['adminpanel-form-text-972']?></span></label>
                                                        </div>
                                                    </div>
                                                </div>
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
    <script>
        $('#yazi_durum2').on('change', function() {
            $('#yazi-durum-1').css('display', 'none');
            if ( $(this).val() === '1' ) {
                $('#yazi-durum-1').css('display', 'block');
            }
        });
    </script>
<?php }?>
