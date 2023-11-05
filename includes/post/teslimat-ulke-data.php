<?php
if(!empty($_POST["ulke"])){?>

    <?php if($_POST['ulke'] == 'TUR'  ) {?>
        <div class="row" style="margin-left: 0; margin-right: 0; ">
            <div class="form-group col-md-4">
                <label for="il">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                <select name="il" id="il" class="form-control"  >
                    <option value=""><?=$diller['teslimat-sayfa-form-secim-yap']?></option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="ilce">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                <select name="ilce" id="ilce" class="form-control"  disabled="disabled" >
                    <option value=""><?=$diller['teslimat-sayfa-form-secim-yap']?></option>
                </select>
            </div><div class="form-group col-md-4">
                <label for="postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                <input type="text" name="postakodu" placeholder="______"  id="postakodu"  maxlength="5" class="form-control" autocomplete="off" >
            </div>
            <div class="form-group col-md-12">
                <label for="adresbilgisi">* <?=$diller['teslimat-sayfa-form-adres']?></label>
                <textarea name="adresbilgisi" id="adresbilgisi" class="form-control"  rows="2" ></textarea>
            </div>
        </div>
        <!-- Text - to password !-->
        <script>
            $("#postakodu").keyup(function() {
                $("#postakodu").val(this.value.match(/[0-9]*/));
            });

        </script>
        <!-- Text - to password SON !-->

        <!-- Şehir-İlçe !-->
        <script>
            $.getJSON("assets/json/il-bolge.json", function(sonuc){
                $.each(sonuc, function(index, value){
                    var row="";
                    row +='<option value="'+value.il+'">'+value.il+'</option>';
                    $("#il").append(row);
                })
            });


            $("#il").on("change", function(){
                var il=$(this).val();

                $("#ilce").attr("disabled", false).html("<option value=''><?=$diller['teslimat-sayfa-form-secim-yap']?></option>");
                $.getJSON("assets/json/il-ilce2.json", function(sonuc){
                    $.each(sonuc, function(index, value){
                        var row="";
                        if(value.il==il)
                        {
                            row +='<option value="'+value.ilce+'">'+value.ilce+'</option>';
                            $("#ilce").append(row);
                        }
                    });
                });
            });
        </script>
        <!-- Şehir-İlçe SON !-->
    <?php }else { ?>
        <div class="row" style="margin-left: 0; margin-right: 0; ">
            <div class="form-group col-md-4">
                <label for="il">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                <input type="text" name="il"  id="il"  class="form-control" autocomplete="off">
            </div>
            <div class="form-group col-md-4">
                <label for="ilce">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                <input type="text" name="ilce"  id="ilce"  class="form-control" autocomplete="off">
            </div>
            <div class="form-group col-md-4">
                <label for="postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                <input type="text" name="postakodu" placeholder="______"   id="postakodu" maxlength="5"class="form-control" autocomplete="off" >
            </div>
            <div class="form-group col-md-12">
                <label for="adresbilgisi">* <?=$diller['teslimat-sayfa-form-adres']?></label>
                <textarea name="adresbilgisi" id="adresbilgisi"  class="form-control" rows="2" ></textarea>
            </div>
        </div>
        <!-- Text - to password !-->
        <script>
            $("#postakodu").keyup(function() {
                $("#postakodu").val(this.value.match(/[0-9]*/));
            });

        </script>
        <!-- Text - to password SON !-->
    <?php }?>
        <?php } ?>
