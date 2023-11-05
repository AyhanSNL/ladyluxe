
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from pricing where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <script>
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
    </script>
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-1038']?></h4>
                    </div>
                    <form action="post.php?process=ptable_post&status=table_edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="table_id" value="<?=$row['id']?>" >
                        <input type="hidden" name="parent_id" value="<?=$row['kat_id']?>" >
                       <div class="border">
                           <ul class="nav nav-tabs bg-light pt-2" id="myTab" role="tablist">
                               <li class="nav-item">
                                   <a class="nav-link saas active" id="one-tab" data-toggle="tab" href="#one_e" role="tab"  aria-selected="true">
                                       <?=$diller['adminpanel-form-text-1044']?>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a class="nav-link saas" id="two-tab" data-toggle="tab" href="#two_e" role="tab"  aria-selected="true">
                                       <?=$diller['adminpanel-form-text-1046']?>
                                   </a>
                               </li>
                               <li class="nav-item">
                                   <a class="nav-link saas" id="three-tab" data-toggle="tab" href="#three_e" role="tab"  aria-selected="true">
                                       <?=$diller['adminpanel-form-text-1045']?>
                                   </a>
                               </li>
                           </ul>
                           <div class="tab-content bg-white rounded-bottom">
                               <div class="tab-pane active p-4" id="one_e" role="tabpanel" >
                                   <div class="row">
                                       <div class="form-group col-md-12 mb-4">
                                           <label  for="durum2" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                           <div class="custom-control custom-switch custom-switch-lg">
                                               <input type="hidden" name="durum" value="0"">
                                               <input type="checkbox" class="custom-control-input" id="durum2" name="durum" value="1"  <?php if($row['durum'] == '1' ) { ?>checked<?php }?> >
                                               <label class="custom-control-label" for="durum2"></label>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-4">
                                           <label for="sira2">* <?=$diller['adminpanel-form-text-55']?></label>
                                           <input type="number" autocomplete="off"  name="sira" id="sira2" value="<?=$row['sira']?>" required  class="form-control">
                                       </div>
                                       <div class="form-group col-md-8">
                                           <label for="baslik_kat2"><?=$diller['adminpanel-form-text-1047']?></label>
                                           <input type="text" autocomplete="off"  name="baslik_kat" id="baslik_kat2" value="<?=$row['baslik_kat']?>"  placeholder="<?=$diller['adminpanel-form-text-1050']?>" class="form-control">
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="form-group col-md-12">
                                           <label for="baslik2">* <?=$diller['adminpanel-form-text-1048']?></label>
                                           <input type="text" autocomplete="off"  name="baslik" id="baslik2" required value="<?=$row['baslik']?>" class="form-control">
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="form-group col-md-4">
                                           <label for="fiyat2"><?=$diller['adminpanel-form-text-1040']?></label>
                                           <input type="number" autocomplete="off"  name="fiyat" id="fiyat2" value="<?=$row['fiyat']?>" placeholder="ÖRN : 100.00"  class="form-control">
                                       </div>
                                       <div class="form-group col-md-8">
                                           <label for="odeme_sure2"><?=$diller['adminpanel-form-text-1041']?></label>
                                           <input type="text" autocomplete="off"  name="odeme_sure" id="odeme_sure2" value="<?=$row['odeme_sure']?>" placeholder="<?=$diller['adminpanel-form-text-1051']?>"  class="form-control">
                                       </div>
                                       <div class="form-group col-md-12 ">
                                           <label  for="tavsiye2" class="w-100"><?=$diller['adminpanel-form-text-1052']?></label>
                                           <div class="custom-control custom-switch custom-switch-lg">
                                               <input type="hidden" name="tavsiye" value="0"">
                                               <input type="checkbox" class="custom-control-input" id="tavsiye2" name="tavsiye" value="1" <?php if($row['tavsiye'] == '1' ) { ?>checked<?php }?> onclick="actionBox2(this.checked);">
                                               <label class="custom-control-label" for="tavsiye2"></label>
                                           </div>
                                       </div>
                                       <div id="actionBox2" class="w-100 col-md-12 mt-2 " <?php if($row['tavsiye'] != '1' ) { ?>style="display:none !important;"<?php }?> >
                                           <div class="col-md-12 border p-3 pt-4 rounded mb-0 bg-light up-arrow">
                                               <div class="row">
                                                   <div class="form-group col-md-6">
                                                       <label for="tavsiye_renk"><?=$diller['adminpanel-form-text-1053']?></label>
                                                       <div data-color-format="default" data-color="#<?=$row['tavsiye_renk']?>" class="colorpicker-default input-group">
                                                           <input type="text" name="tavsiye_renk"  value="" class="form-control">
                                                           <div class="input-group-append add-on">
                                                               <button class="btn btn-light border" type="button">
                                                                   <i style="background-color: rgb(124, 66, 84);"></i>
                                                               </button>
                                                           </div>
                                                       </div>
                                                   </div>
                                                   <div class="form-group col-md-6">
                                                       <label for="tavsiye_yazi_renk"><?=$diller['adminpanel-form-text-1054']?></label>
                                                       <div data-color-format="default" data-color="#<?=$row['tavsiye_yazi_renk']?>" class="colorpicker-default input-group">
                                                           <input type="text" name="tavsiye_yazi_renk"  value="" class="form-control">
                                                           <div class="input-group-append add-on">
                                                               <button class="btn btn-light border" type="button">
                                                                   <i style="background-color: rgb(124, 66, 84);"></i>
                                                               </button>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="tab-pane fade p-4" id="two_e" role="tabpanel" >
                                   <div class="row">
                                       <div class="form-group col-md-12 mb-3">
                                           <label for="url_tur2"><?=$diller['adminpanel-form-text-1055']?></label>
                                           <select name="url_tur" class="form-control rounded-0" id="url_tur2"  style="height: 55px; font-size: 15px ;">
                                               <option value="0" <?php if($row['url_tur'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1056']?></option>
                                               <option value="1" <?php if($row['url_tur'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1057']?></option>
                                               <option value="2" <?php if($row['url_tur'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1058']?></option>
                                           </select>
                                       </div>
                                       <div id="modul-choise2" class="col-md-12 " <?php if($row['url_tur'] !='1' ) { ?> style="display: none;" <?php }?>  >
                                           <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                               <div class="">
                                                   <div class="col-md-12 form-group mb-0">
                                                       <div class="border-warning alert-warning p-2 mb-3 text-dark rounded border">
                                                           <?=$diller['adminpanel-form-text-1075']?>
                                                       </div>
                                                       <label for="urun_id2"><?=$diller['adminpanel-form-text-1060']?></label>
                                                       <select class="urunler_select_2 form-control col-md-12" name="urun_id" id="urun_id2" style="width: 100%!important;" >
                                                       </select>
                                                       <?php if($row['urun_id'] == !null  ) {?>
                                                           <div class="pt-2  border-top mb-0 mt-2" style="font-size: 11px ;">
                                                               <?=$diller['adminpanel-form-text-1067']?>
                                                           </div>
                                                       <?php }?>
                                                   </div>
                                                   <?php if($row['url_tur'] =='1'  && $row['urun_id'] == !null ) {?>
                                                       <div class="col-md-12 mt-4 form-group">
                                                           <label for="">
                                                               <?=$diller['adminpanel-form-text-1066']?>
                                                           </label>
                                                           <?php
                                                           $uruNCek = $db->prepare("select id,seo_url,baslik from urun where id=:id ");
                                                           $uruNCek->execute(array(
                                                                   'id' => $row['urun_id']
                                                           ));
                                                           $urun = $uruNCek->fetch(PDO::FETCH_ASSOC);
                                                           ?>
                                                           <br>
                                                           <a href="<?=$ayar['site_url']?><?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                                              <i class="fa fa-external-link-alt"></i> <?=$urun['baslik']?>
                                                           </a>
                                                       </div>
                                                   <?php }?>
                                               </div>
                                           </div>
                                       </div>
                                       <div id="manuel-choise2" class="col-md-12 " <?php if($row['url_tur'] !='2' ) { ?> style="display: none;" <?php }?>   >
                                           <div class="w-100 p-3 border bg-light up-arrow-2 ">
                                               <div class="">
                                                   <div class="form-group col-md-12 ">
                                                       <input type="text" name="url_adres" placeholder="https://" value="<?=$row['url_adres']?>" autocomplete="off" class="form-control">
                                                   </div>
                                                   <div class="form-group col-md-12 mb-0">
                                                       <label for="url_yazi2"><?=$diller['adminpanel-form-text-911']?></label>
                                                       <input type="text" name="url_yazi" id="url_yazi2"  value="<?=$row['url_yazi']?>" placeholder="<?=$diller['adminpanel-form-text-1059']?>"  class="form-control">
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-12 mt-4">
                                           <label for="url_button"><?=$diller['adminpanel-form-text-863']?></label>
                                           <select name="url_button" class="form-control select_ajax2" id="url_button" required style="width: 100%;  ">
                                               <option value="button-black-white" <?php if($row['url_button'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                               <option value="button-white-black" <?php if($row['url_button'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                               <option value="button-yellow" <?php if($row['url_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                               <option value="button-yellow-out" <?php if($row['url_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                               <option value="button-black" <?php if($row['url_button'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                               <option value="button-black-out" <?php if($row['url_button'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                               <option value="button-white" <?php if($row['url_button'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                               <option value="button-white-out" <?php if($row['url_button'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                               <option value="button-gold" <?php if($row['url_button'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                               <option value="button-gold-out" <?php if($row['url_button'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                               <option value="button-red" <?php if($row['url_button'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                               <option value="button-red-out" <?php if($row['url_button'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                               <option value="button-blue" <?php if($row['url_button'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                               <option value="button-blue-out" <?php if($row['url_button'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                               <option value="button-yellow" <?php if($row['url_button'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                               <option value="button-yellow-out" <?php if($row['url_button'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                               <option value="button-green" <?php if($row['url_button'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                               <option value="button-green-out" <?php if($row['url_button'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                               <option value="button-grey" <?php if($row['url_button'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                               <option value="button-grey-out" <?php if($row['url_button'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                               <option value="button-orange" <?php if($row['url_button'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                               <option value="button-orange-out" <?php if($row['url_button'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                               <option value="button-pink" <?php if($row['url_button'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                           </select>
                                       </div>

                                   </div>
                               </div>

                               <div class="tab-pane fade p-4" id="three_e" role="tabpanel" >
                                   <div class="row">
                                       <div class="form-group col-md-6">
                                           <label for="kutu_arkaplan"><?=$diller['adminpanel-form-text-1061']?></label>
                                           <div data-color-format="default" data-color="#<?=$row['kutu_arkaplan']?>" class="colorpicker-default input-group">
                                               <input type="text" name="kutu_arkaplan"  value="" class="form-control">
                                               <div class="input-group-append add-on">
                                                   <button class="btn btn-light border" type="button">
                                                       <i style="background-color: rgb(124, 66, 84);"></i>
                                                   </button>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label for="kutu_baslik_renk"><?=$diller['adminpanel-form-text-1062']?></label>
                                           <div data-color-format="default" data-color="#<?=$row['kutu_baslik_renk']?>" class="colorpicker-default input-group">
                                               <input type="text" name="kutu_baslik_renk"  value="" class="form-control">
                                               <div class="input-group-append add-on">
                                                   <button class="btn btn-light border" type="button">
                                                       <i style="background-color: rgb(124, 66, 84);"></i>
                                                   </button>
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

<?php }?>
<script>
    $('#url_tur2').on('change', function() {
        $('#modul-choise2').css('display', 'none');
        if ( $(this).val() === '1' ) {
            $('#modul-choise2').css('display', 'block');
        }
        $('#manuel-choise2').css('display', 'none');
        if ( $(this).val() === '2' ) {
            $('#manuel-choise2').css('display', 'block');
        }
    });
    function actionBox2(selected)
    {
        if (selected)
        {
            document.getElementById("actionBox2").style.display = "";
        } else

        {
            document.getElementById("actionBox2").style.display = "none";
        }

    }
</script>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.urunler_select_2').select2({
            maximumSelectionLength: 6,
            placeholder: ' <?=$diller['adminpanel-form-text-880']?>',
            ajax: {
                url: 'masterpiece.php?page=headermenu_product_select',
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
    $(document).ready(function() {
        $('.select_ajax2').select2();
    });
</script>