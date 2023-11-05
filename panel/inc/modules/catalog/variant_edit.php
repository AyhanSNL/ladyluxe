<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from detay_varyant_ozellik where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    $varGrupSorgusu = $db->prepare("select * from detay_varyant where varyant_id=:varyant_id and urun_id=:urun_id ");
    $varGrupSorgusu->execute(array(
        'varyant_id' => $row['varyant_id'],
        'urun_id' => $row['urun_id'],
    ));
    $grups = $varGrupSorgusu->fetch(PDO::FETCH_ASSOC);

    ?>
    <script src="assets/js/bs4inputfilename.js"></script>
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-1829']?></h4>
                    </div>
                    <form action="post.php?process=catalog_post&status=product_post" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="variant_id" value="<?=$row['id']?>" >
                        <input type="hidden" name="group_id" value="<?=$grups['id']?>" >
                        <input type="hidden" name="product_id" value="<?=$grups['urun_id']?>" >
                        <input type="hidden" name="tab" value="variant_edit" >

                        <?php if($grups['tur'] == '1' ) {?>
                            <input type="hidden" name="grup_tur" value="1" >
                        <?php }?>
                        <?php if($grups['tur'] == '2' ) {?>
                            <input type="hidden" name="grup_tur" value="2" >
                        <?php }?>
                        <?php if($grups['tur'] == '3' ) {?>
                            <input type="hidden" name="grup_tur" value="3" >
                        <?php }?>
                        <?php if($grups['tur'] == '4' ) {?>
                            <input type="hidden" name="grup_tur" value="4" >
                        <?php }?>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="ek_fiyat2" >
                                    <?=$diller['adminpanel-form-text-1817']?>
                                </label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="ek_fiyat2"  name="ek_fiyat" value="<?=$row['ek_fiyat']?>">
                                    <div class="input-group-append">
                                        <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="kustom-checkbox">
                                    <input type="hidden" name='fiyat_goster' value="0" >
                                    <input type="checkbox" class="individual" id="fiyat_goster2" name='fiyat_goster' value="1" <?php if($row['fiyat_goster'] == '1'  ) { ?>checked<?php }?> >
                                    <label for="fiyat_goster2"  class="" style="font-weight: 200;font-size: 13px ; ">
                                        <?=$diller['adminpanel-form-text-1822']?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php if($grups['tur'] == '3'  ) {?>
                        <?php if($row['gorsel']  == !null  ) {?>
                            <div class="row border-top pt-3">
                                <div class="form-group col-md-12">
                                    <label for="inputGroupFile02"><?=$diller['adminpanel-form-text-1818']?>  <small>( png,  jpg, jpeg,  gif )</small></label>
                                    <div class="w-100 bg-light border p-3 text-center">
                                        <img class=" bg-white border" src="<?=$ayar['site_url']?>i/variants/<?=$row['gorsel']?>" >
                                        <input type="hidden" name="old_img" value="<?=$row['gorsel']?>" >
                                    </div>
                                    <div class="input-group ">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputGroupFile02" name="gorsel" >
                                            <label class="custom-file-label" for="inputGroupFile02"><?=$diller['adminpanel-form-text-106']?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="gorsel_w"><?=$diller['adminpanel-form-text-1827']?></label>
                                    <input type="number" name="gorsel_w"  id="gorsel_w" value="<?=$row['gorsel_w']?>"  class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="gorsel_h"><?=$diller['adminpanel-form-text-1828']?></label>
                                    <input type="number" name="gorsel_h"  id="gorsel_h" value="<?=$row['gorsel_h']?>"  class="form-control">
                                </div>
                            </div>
                        <?php }else { ?>
                                <div class="row border-top pt-3">
                                    <div class="form-group col-md-12">
                                        <label for="inputGroupFile02">
                                            <?=$diller['adminpanel-form-text-1818']?>  <small>( png,  jpg, jpeg,  gif )</small>
                                            <div class="mt-2" style="font-size: 11px ; color: #999; font-weight: 100;">
                                                <?=$diller['adminpanel-form-text-1819']?>
                                            </div>
                                        </label>
                                        <div class="input-group ">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="inputGroupFile02" name="gorsel" >
                                                <label class="custom-file-label" for="inputGroupFile02"><?=$diller['adminpanel-form-text-106']?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gorsel_w"><?=$diller['adminpanel-form-text-1827']?></label>
                                        <input type="number" name="gorsel_w"  id="gorsel_w" value="<?=$row['gorsel_w']?>"  class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gorsel_h"><?=$diller['adminpanel-form-text-1828']?></label>
                                        <input type="number" name="gorsel_h"  id="gorsel_h" value="<?=$row['gorsel_h']?>"  class="form-control">
                                    </div>
                                </div>
                        <?php }?>
                        <?php }?>

                        <?php if($grups['tur'] == '2'  ) {?>
                            <div class="row border-top pt-3">
                                <div class="col-md-12 form-group">
                                    <div class="kustom-checkbox">
                                        <input type="hidden" name='zorunlu' value="0" >
                                        <input type="checkbox" class="individual" id="zorunlu2" name='zorunlu' value="1" <?php if($grups['zorunlu'] == '1'  ) { ?>checked<?php }?> >
                                        <label for="zorunlu2"  class="" style="font-weight: 200;font-size: 13px ; ">
                                            <?=$diller['adminpanel-form-text-1816']?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if($grups['tur'] == '4'  ) {?>
                            <div class="row border-top pt-3">
                                <div class="col-md-12 form-group">
                                    <div class="kustom-checkbox">
                                        <input type="hidden" name='zorunlu' value="0" >
                                        <input type="checkbox" class="individual" id="zorunlu2" name='zorunlu' value="1" <?php if($grups['zorunlu'] == '1'  ) { ?>checked<?php }?> >
                                        <label for="zorunlu2"  class="" style="font-weight: 200;font-size: 13px ; ">
                                            <?=$diller['adminpanel-form-text-1816']?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top pt-3">
                                <div class="col-md-12 form-group">
                                    <div class="kustom-checkbox">
                                        <input type="hidden" name='tarih_bugun' value="0" >
                                        <input type="checkbox" class="individual" id="tarih_bugun2" name='tarih_bugun' value="1" <?php if($row['tarih_bugun'] == '1'  ) { ?>checked<?php }?> >
                                        <label for="tarih_bugun2"  class="" style="font-weight: 200;font-size: 13px ; ">
                                            <?=$diller['adminpanel-form-text-1975']?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top pt-3">
                                <div class="col-md-12 form-group">
                                    <div class="kustom-checkbox">
                                        <input type="hidden" name='tarih_yil' value="0" >
                                        <input type="checkbox" class="individual" id="tarih_yil2" name='tarih_yil' value="1" <?php if($row['tarih_yil'] == '1'  ) { ?>checked<?php }?> >
                                        <label for="tarih_yil2"  class="" style="font-weight: 200;font-size: 13px ; ">
                                            <?=$diller['adminpanel-form-text-1976']?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if($grups['tur'] != '2' && $grups['tur'] != '4'  ) {?>
                            <div class="row ">
                                <div class="col-md-12 form-group">
                                    <div class="kustom-checkbox">
                                        <input type="hidden" name='disable' value="0" >
                                        <input type="checkbox" class="individual" id="disable" name='disable' value="1" <?php if($row['disable'] == '1'  ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                        <label for="disable"  class="" style="font-weight: 200;font-size: 13px ; ">
                                            <?=$diller['adminpanel-form-text-1948']?>
                                        </label>
                                    </div>
                                </div>
                                <div id="actionBox" class="col-md-12 form-group" <?php if($row['disable'] != '1'  ) { ?>style="display:none !important;"<?php }?> >
                                    <div class="border bg-light rounded p-3 up-arrow-2">
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-0">
                                                <label for="disable_t"><?=$diller['adminpanel-form-text-1949']?></label>
                                                <input type="text" name="disable_t" placeholder="<?=$diller['adminpanel-form-text-1950']?>" value="<?=$row['disable_t']?>" id="disable_t"  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>



                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">

                            <button class="btn btn-success btn-block  shadow-sm" name="variantID_update">
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

    <script id="rendered-js" >
        function actionBox(selected)
        {
            if (selected)
            {
                document.getElementById("actionBox").style.display = "";
            } else

            {
                document.getElementById("actionBox").style.display = "none";
            }

        }
    </script>


<?php }?>

