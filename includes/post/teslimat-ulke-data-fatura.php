<?php
if(!empty($_POST["fatura_ulke"])){?>
    <?php if($_POST['fatura_ulke'] == 'TUR'  ) {?>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="il2">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                <select name="fatura_il" id="il2" class="form-control">
                    <option value=""><?=$diller['teslimat-sayfa-form-secim-yap']?></option>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="ilce2">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                <select name="fatura_ilce" id="ilce2" class="form-control" disabled="disabled">
                    <option value=""><?=$diller['teslimat-sayfa-form-secim-yap']?></option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="fatura_postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                <input type="text" name="fatura_postakodu" placeholder="______"  id="fatura_postakodu" maxlength="5"  class="form-control" autocomplete="off" >
            </div>
            <div class="form-group col-md-12">
                <label for="fatura_adresbilgisi">* <?=$diller['teslimat-sayfa-form-fatura-adres']?></label>
                <textarea name="fatura_adresbilgisi" id="fatura_adresbilgisi" class="form-control" rows="2" ></textarea>
            </div>
        </div>
        <script>
            $("#fatura_postakodu").keyup(function() {
                $("#fatura_postakodu").val(this.value.match(/[0-9]*/));
            });
        </script>
        <script>
            $.getJSON("assets/json/il-bolge.json", function(sonuc){
                $.each(sonuc, function(index, value){
                    var row="";
                    row +='<option value="'+value.il+'">'+value.il+'</option>';
                    $("#il2").append(row);
                })
            });


            $("#il2").on("change", function(){
                var il=$(this).val();

                $("#ilce2").attr("disabled", false).html("<option value=''><?=$diller['teslimat-sayfa-form-secim-yap']?></option>");
                $.getJSON("assets/json/il-ilce2.json", function(sonuc){
                    $.each(sonuc, function(index, value){
                        var row="";
                        if(value.il==il)
                        {
                            row +='<option value="'+value.ilce+'">'+value.ilce+'</option>';
                            $("#ilce2").append(row);
                        }
                    });
                });
            });
        </script>
    <?php }else { ?>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="il2">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                <input type="text" name="fatura_il"  id="il2"  class="form-control" autocomplete="off">
            </div>
            <div class="form-group col-md-4">
                <label for="ilce2">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                <input type="text" name="fatura_ilce"  id="ilce2"  class="form-control" autocomplete="off">
            </div>
            <div class="form-group col-md-4">
                <label for="fatura_postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                <input type="text" name="fatura_postakodu" placeholder="______"  id="fatura_postakodu" maxlength="5" class="form-control" autocomplete="off" >
            </div>
            <div class="form-group col-md-12">
                <label for="fatura_adresbilgisi">* <?=$diller['teslimat-sayfa-form-fatura-adres']?></label>
                <textarea name="fatura_adresbilgisi" id="fatura_adresbilgisi" class="form-control" rows="2" ></textarea>
            </div>
        </div>
        <!-- Text - to password !-->
        <script>
            $("#fatura_postakodu").keyup(function() {
                $("#fatura_postakodu").val(this.value.match(/[0-9]*/));
            });

        </script>
        <!-- Text - to password SON !-->
    <?php }?>
        <?php } ?>
