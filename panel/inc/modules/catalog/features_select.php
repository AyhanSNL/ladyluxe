<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$features_list = $db->prepare("select * from urun_ozellik where grup_id=:grup_id order by sira asc");
$features_list->execute(array(
    'grup_id' => $_GET['grup_id']
));
?>
<?php if($features_list->rowCount()>'0'  ) {?>
<div class="col-md-12 form-group">
<label for="feature_id" >
    <?=$diller['adminpanel-form-text-1698']?>
</label>
<select name="feature_id" class="form-control selet3" style="width: 100%;  ">
    <?php foreach ($features_list as $featRow) {?>
        <option value="<?=$featRow['id']?>"><?=$featRow['baslik']?></option>
    <?php }?>
</select>
</div>
<div class="col-md-12 mb-3">
    <div class="kustom-checkbox">
        <input type="hidden" name='filtre' value="0" >
        <input type="checkbox" class="individual" id="filtre" name='filtre' value="1" onclick="filtreBox(this.checked);">
        <label for="filtre"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
            <?=$diller['adminpanel-form-text-1699']?>
        </label>
    </div>
</div>
<div id="filtreBox" class="w-100 col-md-12 " style="display:none !important;" >
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kisa_baslik"><?=$diller['adminpanel-form-text-1800']?></label>
            <input type="kisa_baslik" name="kisa_baslik" id="kisa_baslik"  class="form-control">
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.selet3').select2();
    });
</script>
<script id="rendered-js" >
    function filtreBox(selected)
    {
        if (selected)
        {
            document.getElementById("filtreBox").style.display = "none";
        } else

        {
            document.getElementById("filtreBox").style.display = "none";
        }

    }
</script>
<?php }?>