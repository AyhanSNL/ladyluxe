<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$varyantGrupSql = $db->prepare("select * from detay_varyant where varyant_id=:varyant_id and urun_id=:urun_id ");
$varyantGrupSql->execute(array(
        'varyant_id' => $_GET['varyant_grup_id'],
        'urun_id' => $_GET['urun_id'],
));
$vargrow = $varyantGrupSql->fetch(PDO::FETCH_ASSOC);




$variantList = $db->prepare("select * from urun_varyant_ozellik where var_id=:var_id order by id asc");
$variantList->execute(array(
    'var_id' => $_GET['varyant_grup_id']
));

/* hiç ekleme yapılmadı ise kontrol et sıfır ise aşağısı komple çıksın */
/* eklenen bir varyant grubunun kontrolünü sağla ve eğer ki eklenmiş ise türü otomatik çıksın sadece varyant seçenekleri belirsin */
/* tür 2 olan bir varyant grubu seçildiğinde zaten yazı alanı oluşturmussunuz uyarısı ver ki tekrar ekleyemesin. */


?>
<script src="assets/js/bs4inputfilename.js"></script>
<?php if($varyantGrupSql->rowCount()>'0'  ) {?>
    <?php if($vargrow['tur'] == '1'  ) {?>
        <input type="hidden" name='tur' value="1" >
        <div class="col-md-12 form-group">
            <label for="variant_id" >
                <?=$diller['adminpanel-form-text-1811']?> (<?=$diller['adminpanel-form-text-1824']?>)
            </label>
            <select name="variant_id" class="form-control selet3" style="width: 100%">
                <?php foreach ($variantList as $variantRow) {?>
                    <option value="<?=$variantRow['id']?>"><?=$variantRow['baslik']?></option>
                <?php }?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="ek_fiyat" >
                <?=$diller['adminpanel-form-text-1817']?>
            </label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="ek_fiyat"  name="ek_fiyat" value="0">
                <div class="input-group-append">
                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <div class="kustom-checkbox">
                <input type="hidden" name='fiyat_goster' value="0" >
                <input type="checkbox" class="individual" id="fiyat_goster" name='fiyat_goster' value="1" >
                <label for="fiyat_goster"  class="" style="font-weight: 200;font-size: 13px ; ">
                    <?=$diller['adminpanel-form-text-1822']?>
                </label>
            </div>
        </div>
    <?php }?>
    <?php if($vargrow['tur'] == '2'  ) {?>
        <input type="hidden" name='ekli_tur' value="2" >
        <input type="hidden" name='variant_grup' value="<?=$_GET['varyant_grup_id']?>" >
        <input type="hidden" name='variant_id' value="1" >
        <input type="hidden" name='tur' value="2" >
        <div class="col-md-12 form-group">
            <div class="border border-danger rounded p-3 " style="background-color: #FFF2ED;">
                <?=$diller['adminpanel-form-text-1825']?>
            </div>
        </div>
    <?php }?>
    <?php if($vargrow['tur'] == '3'  ) {?>
        <input type="hidden" name='tur' value="3" >
        <div class="col-md-12 form-group">
            <label for="variant_id" >
                <?=$diller['adminpanel-form-text-1811']?> (<?=$diller['adminpanel-form-text-1814']?>)
            </label>
            <select name="variant_id" class="form-control selet3" style="width: 100%">
                <?php foreach ($variantList as $variantRow) {?>
                    <option value="<?=$variantRow['id']?>"><?=$variantRow['baslik']?></option>
                <?php }?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="ek_fiyat" >
                <?=$diller['adminpanel-form-text-1817']?>
            </label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="ek_fiyat"  name="ek_fiyat" value="0">
                <div class="input-group-append">
                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <div class="kustom-checkbox">
                <input type="hidden" name='fiyat_goster' value="0" >
                <input type="checkbox" class="individual" id="fiyat_goster" name='fiyat_goster' value="1" >
                <label for="fiyat_goster"  class="" style="font-weight: 200;font-size: 13px ; ">
                    <?=$diller['adminpanel-form-text-1822']?>
                </label>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="border p-3 bg-light ">
                <label  for="inputGroupFile01" class="w-100">
                    <?=$diller['adminpanel-form-text-1818']?> <small>( png, jpg, jpeg, gif)</small>
                    <div style="font-size: 11px ; font-weight: 200;">
                        <?=$diller['adminpanel-form-text-1819']?>
                    </div>
                </label>
                <div class="input-group ">
                    <div class="custom-file ">
                        <input type="file" class="custom-file-input " id="inputGroupFile01" name="gorsel" >
                        <label class="custom-file-label" for="inputGroupFile01"  ><?=$diller['adminpanel-form-text-106']?></label>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2 mb-3">
                        <label for="gorsel_w"><?=$diller['adminpanel-form-text-1827']?></label>
                        <input type="number" name="gorsel_w"  id="gorsel_w"  class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="gorsel_h"><?=$diller['adminpanel-form-text-1828']?></label>
                        <input type="number" name="gorsel_h"  id="gorsel_h"  class="form-control">
                    </div>
                </div>
            </div>
        </div>
    <?php }?>
    <?php if($vargrow['tur'] == '4'  ) {?>
        <input type="hidden" name='ekli_tur' value="2" >
        <input type="hidden" name='variant_grup' value="<?=$_GET['varyant_grup_id']?>" >
        <input type="hidden" name='variant_id' value="1" >
        <input type="hidden" name='tur' value="2" >
        <div class="col-md-12 form-group">
            <div class="border border-danger rounded p-3 " style="background-color: #FFF2ED;">
                <?=$diller['adminpanel-form-text-1825']?>
            </div>
        </div>
    <?php }?>
<?php }else { ?>
<?php if($variantList->rowCount()>'0'  ) {?>
        <div class="col-md-12 form-group">
            <label for="variant_id" >
                <?=$diller['adminpanel-form-text-1811']?>
            </label>
            <select name="variant_id" class="form-control selet3" style="width: 100%">
                <?php foreach ($variantList as $variantRow) {?>
                    <option value="<?=$variantRow['id']?>"><?=$variantRow['baslik']?></option>
                <?php }?>
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="ek_fiyat" >
                <?=$diller['adminpanel-form-text-1817']?>
            </label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="ek_fiyat"  name="ek_fiyat" value="0">
                <div class="input-group-append">
                    <div class="input-group-text font-12 font-weight-bold"><?=$Current_Money['sag_simge']?></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <div class="kustom-checkbox">
                <input type="hidden" name='fiyat_goster' value="0" >
                <input type="checkbox" class="individual" id="fiyat_goster" name='fiyat_goster' value="1" >
                <label for="fiyat_goster"  class="" style="font-weight: 200;font-size: 13px ; ">
                    <?=$diller['adminpanel-form-text-1822']?>
                </label>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <label for="tur" >
                <?=$diller['adminpanel-form-text-1812']?>
            </label>
            <select name="tur" id="tur" class="form-control selet3" style="width: 100%">
                <option value="1"><?=$diller['adminpanel-form-text-1813']?></option>
                <option value="2"><?=$diller['adminpanel-form-text-1815']?></option>
                <option value="3"><?=$diller['adminpanel-form-text-1814']?></option>
                <option value="4"><?=$diller['adminpanel-form-text-1820']?></option>
            </select>
        </div>

        <div id="tur-2" style="display:none">
            <div class="col-md-12 mb-3">
                <div class="border p-3 bg-light up-arrow-2">
                    <div class="kustom-checkbox">
                        <input type="hidden" name='zorunlu' value="0" >
                        <input type="checkbox" class="individual" id="zorunlu" name='zorunlu' value="1" >
                        <label for="zorunlu"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                            <?=$diller['adminpanel-form-text-1816']?>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div id="tur-3" style="display:none">
            <div class="col-md-12 mb-3">
                <div class="border p-3 bg-light up-arrow-2">
                    <label  for="inputGroupFile01" class="w-100">
                        <?=$diller['adminpanel-form-text-1818']?> <small>( png, jpg, jpeg, gif)</small>
                        <div style="font-size: 11px ; font-weight: 200;">
                            <?=$diller['adminpanel-form-text-1819']?>
                        </div>
                    </label>
                    <div class="input-group ">
                        <div class="custom-file ">
                            <input type="file" class="custom-file-input " id="inputGroupFile01" name="gorsel" >
                            <label class="custom-file-label" for="inputGroupFile01"  ><?=$diller['adminpanel-form-text-106']?></label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-2 mb-3">
                            <label for="gorsel_w"><?=$diller['adminpanel-form-text-1827']?></label>
                            <input type="number" name="gorsel_w"  id="gorsel_w"  class="form-control">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="gorsel_h"><?=$diller['adminpanel-form-text-1828']?></label>
                            <input type="number" name="gorsel_h"  id="gorsel_h"  class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tur-4" style="display:none">
            <div class="col-md-12 mb-3">
                <div class="border p-3 bg-light up-arrow-2">
                    <div class="kustom-checkbox mb-4">
                        <input type="hidden" name='zorunlu_tur4' value="0" >
                        <input type="checkbox" class="individual" id="zorunlu_tur4" name='zorunlu_tur4' value="1" >
                        <label for="zorunlu_tur4"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                            <?=$diller['adminpanel-form-text-1816']?>
                        </label>
                    </div>
                    <div class="kustom-checkbox mb-4">
                        <input type="hidden" name='tarih_bugun' value="0" >
                        <input type="checkbox" class="individual" id="tarih_bugun" name='tarih_bugun' value="1"  >
                        <label for="tarih_bugun"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                            <?=$diller['adminpanel-form-text-1975']?>
                        </label>
                    </div>
                    <div class="kustom-checkbox ">
                        <input type="hidden" name='tarih_yil' value="0" >
                        <input type="checkbox" class="individual" id="tarih_yil" name='tarih_yil' value="1" >
                        <label for="tarih_yil"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                            <?=$diller['adminpanel-form-text-1976']?>
                        </label>
                    </div>
                </div>
            </div>
        </div>


    <?php }else { ?>
        <div class="col-md-12 mb-3">
            <div class="alert-warning border border-warning text-dark p-3" style="font-size: 15px ;">
                <?=$diller['adminpanel-form-text-1883']?>
            </div>
        </div>
    <?php }?>
<?php }?>


<script>
    $('#tur').on('change', function() {
        $('#tur-2').css('display', 'none');
        if ( $(this).val() === '2' ) {
            $('#tur-2').css('display', 'block');
        }
        $('#tur-3').css('display', 'none');
        if ( $(this).val() === '3' ) {
            $('#tur-3').css('display', 'block');
        }
        $('#tur-4').css('display', 'none');
        if ( $(this).val() === '4' ) {
            $('#tur-4').css('display', 'block');
        }
    });
</script>


<script>
    $(document).ready(function() {
        $('.selet3').select2();
    });
</script>





