
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from kupon where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                    <h4><?=$diller['adminpanel-form-text-1223']?></h4>
                </div>
                <form action="post.php?process=coupon_post&status=edit" method="post" enctype="multipart/form-data" name="order2">
                    <input type="hidden" name="coupon_id" value="<?=$row['id']?>" >
                    <div class="row">
                        <div class="form-group col-md-12 mb-4">
                            <label  for="durum2" class="w-100" ><?=$diller['adminpanel-form-text-1210']?></label>
                            <div class="custom-control custom-switch custom-switch-lg">
                                <input type="hidden" name="durum" value="0"">
                                <input type="checkbox" class="custom-control-input" id="durum2" name="durum" value="1"  <?php if($row['durum'] == '1' ) { ?>checked<?php }?> >
                                <label class="custom-control-label" for="durum2"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="baslik2">* <?=$diller['adminpanel-form-text-1198']?></label>
                            <input type="text" autocomplete="off"  name="baslik" id="baslik2" value="<?=$row['baslik']?>" required class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kod2">* <?=$diller['adminpanel-form-text-1212']?></label>
                            <div class="input-group">
                                <input id="kod2" value="<?=$row['kod']?>" name="kod2" class="form-control" required autocomplete="off"  type="text">
                                <span class="input-group-addon btn btn-primary " style="border-radius: 0 4px 4px 0; border-left:0" onclick="randomString2();"><?=$diller['adminpanel-form-text-1213']?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label  for="tur2" class="w-100">* <?=$diller['adminpanel-form-text-1214']?></label>
                            <select name="tur" class="form-control" id="tur2" >
                                <option value="1" <?php if($row['tur'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1216']?></option>
                                <option value="2" <?php if($row['tur'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1215']?></option>
                            </select>
                        </div>
                        <div id="oran-choose-2" class="col-md-3"  <?php if($row['tur'] != '1' ) { ?>style="display: none" <?php }?>>
                            <div class="row">
                                <div class="form-group col-md-12 ">
                                    <label for="oran_oran" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                        *  <?=$diller['adminpanel-form-text-1218']?>
                                    </label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text font-12 font-weight-bold">%</div>
                                        </div>
                                        <input type="text" class="form-control" id="oran_oran"  name="oran_oran" value="<?=$row['indirim_tutar']?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tutar-choose-2" class="col-md-3" <?php if($row['tur'] != '2' ) { ?>style="display: none" <?php }?> >
                            <div class="row">
                                <div class="form-group col-md-12 ">
                                    <label for="tutar_tutar" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                        *  <?=$diller['adminpanel-form-text-1217']?>
                                    </label>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" id="tutar_tutar"  name="tutar_tutar"  value="<?=$row['indirim_tutar']?>">
                                        <div class="input-group-append">
                                            <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            $('#tur2').on('change', function() {
                                $('#tutar-choose-2').css('display', 'none');
                                if ( $(this).val() === '2' ) {
                                    $('#tutar-choose-2').css('display', 'block');
                                }
                                $('#oran-choose-2').css('display', 'none');
                                if ( $(this).val() === '1' ) {
                                    $('#oran-choose-2').css('display', 'block');
                                }
                            });
                        </script>
                        <div class="form-group col-md-3 ">
                            <label for="sepe_alt_limit" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                <div>
                                    * <?=$diller['adminpanel-form-text-1201']?>
                                </div>
                                <i class="ti-help-alt text-primary float-right" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1219']?>"></i>
                            </label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="sepe_alt_limit"  name="sepe_alt_limit" required value="<?=$row['sepe_alt_limit']?>">
                                <div class="input-group-append">
                                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-3 ">
                            <label for="adet" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                * <?=$diller['adminpanel-form-text-1199']?>
                            </label>
                            <input type="number" name="adet"  id="adet"  required  class="form-control" value="<?=$row['adet']?>">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="adet" class="w-100 d-flex align-items-center justify-content-start ">
                                <?=$diller['adminpanel-form-text-1220']?>
                                <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1224']?>"></i>
                            </label>
                            <select class="user_select_form_add2 form-control col-md-12" name="user_sec" id="user_sec" style="width: 100%!important;" >
                            </select>

                            <?php if($row['uye_id'] >'0' ) {
                                $uyeCeks = $db->prepare("select * from uyeler where id=:id ");
                                $uyeCeks->execute(array(
                                    'id' => $row['uye_id'],
                                ));
                                $uyeR = $uyeCeks->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <input type="hidden" name="user_durum" value="1" >
                                <input type="hidden" name="user_id_hidden" value="<?=$row['uye_id']?>" >
                                <div class="bg-light mt-2 p-2 rounded-bottom border">
                                    <i class="fa fa-user"></i> <?=$uyeR['isim']?> <?=$uyeR['soyisim']?>
                                </div>
                                <div class="border mt-2 p-2">
                                    <div class="kustom-checkbox">
                                        <input type="hidden" name="herkes" value="0" >
                                        <input type="checkbox" class="individual" id="herkes" name='herkes' value="1">
                                        <label for="herkes">
                                            <?=$diller['adminpanel-form-text-1225']?>
                                            <br>
                                            <small><?=$diller['adminpanel-form-text-1226']?></small>
                                        </label>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="son_tarih">* <?=$diller['adminpanel-form-text-1088']?></label>
                            <div class="position-relative">
                                <div id="focusin" ></div>
                                <i class="fa fa-calendar-alt position-absolute" style="right: 10px; top:13px"></i>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="son_tarih">* <?=$diller['adminpanel-form-text-1089']?></label>
                            <div class="position-relative">
                                <div id="focusin2" ></div>
                                <i class="fa fa-calendar-alt position-absolute" style="right: 10px; top:13px"></i>
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
        /* DataPicker */
        $(function(){
            var dateToday = new Date();
            var selectedDate;
            $(document).on("focusin",".datePick", function () {
                $(this).datepicker({
                    monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                    dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                    dateFormat: "yy-mm-dd",
                    firstDay:1,
                });
            });
            $('#focusin').append('<input class="datePick form-control w-100" name="baslangic" autocomplete="off" value="<?=$row['baslangic']?>"  />');
        });
        $(function(){
            var dateToday = new Date();
            var selectedDate;
            $(document).on("focusin2",".datePick", function () {
                $(this).datepicker({
                    monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                    dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                    dateFormat: "yy-mm-dd",
                    firstDay:1,
                });
            });
            $('#focusin2').append('<input class="datePick form-control w-100" name="bitis" autocomplete="off" value="<?=$row['bitis']?>"  />');
        });
        /*  <========SON=========>>> DataPicker SON */
    </script>
<?php }?>

<script>
    $(document).ready(function() {
        $('.user_select_form_add2').select2({
            maximumSelectionLength: 6,
            <?php if($row['uye_id'] >'0'  ) {?>
            placeholder: ' <?=$diller['adminpanel-form-text-1224']?>',
            <?php }else { ?>
            placeholder: ' <?=$diller['adminpanel-form-text-1221']?>',
            <?php }?>
            ajax: {
                url: 'masterpiece.php?page=user_select',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        q: data.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }

        });
    });
</script>
