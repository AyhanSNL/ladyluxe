<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
error_reporting(0);
$pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
$pazarYeri->execute();
$pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
include "inc/modules/entegration/pazar/n11_api.php";
$altid = $_GET['option'];
    ?>
<?php if($_GET['level'] == '1'  ) {
    $subCats = $n11->GetSubCategories($altid);
    $subCatss = $n11->GetSubCategories($altid);
    $sayi = count($subCatss->category->subCategoryList);
    $isim = $subCatss->category->name;
    ?>
    <?php if($sayi>'0'  ) {?>
        <div class="form-group col-md-12">
            <label for=""><?=$diller['pazaryeri-text-11']?></label>
            <?php foreach ($subCats->category->subCategoryList as $s) { ?>
                <select name="category_sub" class="form-control selet2" style="width: 100% !important;" id="category_sub_1" required>
                    <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                    <?php foreach ($s as $ss => $key) { ?>
                        <option value="<?= $key->id ?>"><?= $key->name ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>
        <div id="sub2" class="w-100" style="display:none"></div>

        <script type="text/javascript">
            $(document).ready(function(){
                $("select[id='category_sub_1']").on('change',function(){
                    var option = $("select[id='category_sub_1']").val();
                    jQuery.ajax({
                        type: "GET",
                        url: "masterpiece.php?page=n11_subcat&level=2",
                        data: "option="+option,
                        success: function(response){
                            $("#sub2").html(response);
                            $("#sub2").show();
                        }
                    });
                });
            });
        </script>
    <?php }?>
<?php }?>
<?php if($_GET['level'] == '2'  ) {
    $subCats2 = $n11->GetSubCategories($altid);
    $subCats22 = $n11->GetSubCategories($altid);
    $sayi2 = count($subCats22->category->subCategoryList);
    $isim_2 = $subCats22->category->name
    ?>
    <?php if($sayi2>'0'  ) {?>
        <div class="form-group col-md-12">
            <label for=""><?=$diller['pazaryeri-text-11']?></label>
            <?php foreach ($subCats2->category->subCategoryList as $s) { ?>
                <select name="category_sub" class="form-control selet2" id="category_sub_2" style="width: 100% !important;" required>
                    <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                    <?php foreach ($s as $ss => $key) { ?>
                        <option value="<?= $key->id ?>"><?= $key->name ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>
        <div id="sub3" class="w-100" style="display:none"></div>
        <script type="text/javascript">
            $(document).ready(function(){
                $("select[id='category_sub_2']").on('change',function(){
                    var option = $("select[id='category_sub_2']").val();
                    jQuery.ajax({
                        type: "GET",
                        url: "masterpiece.php?page=n11_subcat&level=3",
                        data: "option="+option,
                        success: function(response){
                            $("#sub3").html(response);
                            $("#sub3").show();
                        }
                    });
                });

            });
        </script>
    <?php }?>
<?php }?>
<?php if($_GET['level'] == '3'  ) {
    $subCats3 = $n11->GetSubCategories($altid);
    $sayi3 = count($subCats3->category->subCategoryList);
    $isim3 = $subCats3->category->name
    ?>
    <?php if($sayi3 > '0'  ) {?>
        <div class="form-group col-md-12">
            <label for=""><?=$diller['pazaryeri-text-11']?></label>
            <?php foreach ($subCats3->category->subCategoryList as $s) { ?>
            <select name="category_sub" class="form-control selet2" id="category_sub_3" required>
                <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                <?php foreach ($s as $ss => $key) { ?>
                    <option value="<?= $key->id ?>"><?= $key->name ?></option>
                <?php } ?>
            </select>
        </div>
        <?php } ?>
        <div id="sub4" class="w-100" style="display:none"></div>

        <script type="text/javascript">
            $(document).ready(function(){
                $("select[id='category_sub_3']").on('change',function(){
                    var option = $("select[id='category_sub_3']").val();
                    jQuery.ajax({
                        type: "GET",
                        url: "masterpiece.php?page=n11_subcat&level=4",
                        data: "option="+option,
                        success: function(response){
                            $("#sub4").html(response);
                            $("#sub4").show();
                        }
                    });
                });

            });
        </script>
    <?php }?>
<?php }?>
<?php if($_GET['level'] == '4'  ) {
    $subCats4 = $n11->GetSubCategories($altid);
    $sayi4 = count($subCats4->category->subCategoryList);
    ?>
    <?php if($sayi4>'0'  ) {?>
        <div class="form-group col-md-12">
        <label for=""><?=$diller['pazaryeri-text-11']?></label>
        <?php foreach ($subCats4->category->subCategoryList as $s) { ?>
            <select name="category_sub" class="form-control" id="category_sub_4" required>
                <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                <?php foreach ($s as $ss => $key) { ?>
                    <option value="<?= $key->id ?>"><?= $key->name ?></option>
                <?php } ?>
            </select>
            </div>
        <?php } ?>
    <?php }?>
<?php }?>
<script>
    $(document).ready(function() {
        $('.selet2').select2({

        })})
</script>



