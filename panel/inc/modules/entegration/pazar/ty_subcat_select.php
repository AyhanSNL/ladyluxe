<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
error_reporting(0);
$pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
$pazarYeri->execute();
$pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
$altid = $_GET['option'];

$katJsonDosya = file_get_contents(''.$ayar['panel_url'].'assets/ty/catlist/kategoriler.php');
$subJson = json_decode($katJsonDosya);
    ?>
<?php if($_GET['level'] == '1'  ) {
    foreach ($subJson->categories as $a){
            if($a->id == $altid  ) { ?>
                <input type="hidden" name="anakategori_adi" value="<?=$a->name?>" >
            <?php }
    }
    ?>
    <div class="form-group col-md-12">
            <label for=""><?=$diller['pazaryeri-text-11']?></label>
            <select name="category_sub" class="form-control selet2" style="width: 100% !important;" id="category_sub_1" data-id1="<?=$altid?>"  required>
                <option value=""><?=$diller['adminpanel-form-text-50']?></option>
            <?php
            foreach ($subJson->categories as $a){
                foreach ($a->subCategories as $b){
                    if($b->parentId == $altid  ) { ?>
                            <option value="<?=$b->id?>"><?=$b->name?> (#<?=$b->id?>)</option>
                    <?php }
                }
            }
            ?>
            </select>
        </div>
        <div id="sub2" class="w-100" style="display:none"></div>
        <script type="text/javascript">
            $(document).ready(function(){
                $("select[id='category_sub_1']").on('change',function(){
                    var option = $("select[id='category_sub_1']").val();
                    var id1 = $(this).data('id1');
                    jQuery.ajax({
                        type: "GET",
                        url: "masterpiece.php?page=ty_subcat&level=2",
                        data: {option:option,id1: id1},
                        success: function(response){
                            $("#sub2").html(response);
                            $("#sub2").show();
                        }
                    });
                });
            });
        </script>
<?php }?>

<?php if($_GET['level'] == '2'  ) {?>
   <?php
    $subCatControl = file_get_contents(''.$ayar['panel_url'].'assets/ty/catlist/kategoriler.php');
    $controlPoint = json_decode($subCatControl);
    foreach ($controlPoint->categories as $a){
        foreach ($a->subCategories as $b){
            if($b->parentId == ''.$_GET['id1'].''  ) {
                if($b->id == ''.$_GET['option'].''  ) {?>
                    <input type="hidden" name="altkat_1_adi" value="<?=$b->name?>" >
                <?php
                }
                foreach ($b->subCategories as $c){
                    if($c->parentId == ''.$_GET['option'].''  ) {
                      if(empty($c->parentId)  ) {
                       $durum = '0';
                      }else{
                          $durum = '1';  }
                    }
                }
            }
        }
    }
   ?>
    <?php if($durum == '1'  ) {?>
        <div class="form-group col-md-12">
            <label for="">2.<?=$diller['pazaryeri-text-11']?></label>
            <select name="category_sub" class="form-control selet2" style="width: 100% !important;" id="category_sub_2" data-id1="<?=$_GET['id1']?>" data-id2="<?=$_GET['option']?>" required>
                <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                <?php
                foreach ($subJson->categories as $a){
                    foreach ($a->subCategories as $b){
                        if($b->parentId == ''.$_GET['id1'].''  ) {
                            foreach ($b->subCategories as $c){
                                if($c->parentId == ''.$_GET['option'].''  ) {
                                    ?>
                                    <option value="<?=$c->id?>"><?=$c->name?> (#<?=$c->id?>)</option>
                                    <?php
                                }
                            }
                        }
                    }
                }
                ?>
            </select>
        </div>
        <div id="sub3" class="w-100" style="display:none"></div>
        <script type="text/javascript">
            $(document).ready(function(){
                $("select[id='category_sub_2']").on('change',function(){
                    var option = $("select[id='category_sub_2']").val();
                    var id1 = $(this).data('id1');
                    var id2 = $(this).data('id2');
                    jQuery.ajax({
                        type: "GET",
                        url: "masterpiece.php?page=ty_subcat&level=3",
                        data: {option:option,id1: id1,id2: id2},
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
    $subCatControl = file_get_contents(''.$ayar['panel_url'].'assets/ty/catlist/kategoriler.php');
    $controlPoint = json_decode($subCatControl);
    foreach ($subJson->categories as $a){
        foreach ($a->subCategories as $b){
            if($b->parentId == ''.$_GET['id1'].''  ) {
                foreach ($b->subCategories as $c){
                    if($c->parentId == ''.$_GET['id2'].''  ) {
                        if($c->id == ''.$_GET['option'].''  ) { ?>
                            <input type="hidden" name="altkat_2_adi" value="<?=$c->name?>" >
                        <?php }
                        foreach ($c->subCategories as $d){
                            if($d->parentId == ''.$_GET['option'].''  ) {
                                if(empty($d->parentId)  ) {
                                    $durum = '0';
                                }else{
                                    $durum = '1';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
<?php if($durum == '1'  ) {?>
    <div class="form-group col-md-12">
        <label for="">3.<?=$diller['pazaryeri-text-11']?></label>
        <select name="category_sub" class="form-control selet2" style="width: 100% !important;" id="category_sub_3" data-id1="<?=$_GET['id1']?>" data-id2="<?=$_GET['id2']?>" data-id3="<?=$_GET['option']?>" required>
            <option value=""><?=$diller['adminpanel-form-text-50']?></option>
            <?php
            foreach ($subJson->categories as $a){
                foreach ($a->subCategories as $b){
                    if($b->parentId == ''.$_GET['id1'].''  ) {
                        foreach ($b->subCategories as $c){
                            if($c->parentId == ''.$_GET['id2'].''  ) {
                                foreach ($c->subCategories as $d){
                                    if($d->parentId == ''.$_GET['option'].''  ) {
                                ?>
                                        <option value="<?=$d->id?>"><?=$d->name?> (#<?=$d->id?>)</option>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ?>
        </select>
    </div>
    <div id="sub4" class="w-100" style="display:none"></div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("select[id='category_sub_3']").on('change',function(){
                var option = $("select[id='category_sub_3']").val();
                var id1 = $(this).data('id1');
                var id2 = $(this).data('id2');
                var id3 = $(this).data('id3');
                jQuery.ajax({
                    type: "GET",
                    url: "masterpiece.php?page=ty_subcat&level=4",
                    data: {option:option,id1: id1,id2: id2,id3: id3},
                    success: function(response){
                        $("#sub4").html(response);
                        $("#sub4").show();
                    }
                });
            });
        });
    </script>
    <?php } ?>
<?php }?>

<?php if($_GET['level'] == '4'  ) {
    $subCatControl = file_get_contents(''.$ayar['panel_url'].'assets/ty/catlist/kategoriler.php');
    $controlPoint = json_decode($subCatControl);
    foreach ($controlPoint->categories as $a){
        foreach ($a->subCategories as $b){
            if($b->parentId == ''.$_GET['id1'].''  ) {
                foreach ($b->subCategories as $c){
                    if($c->parentId == ''.$_GET['id2'].''  ) {
                        foreach ($c->subCategories as $d){
                            if($d->parentId == ''.$_GET['id3'].''  ) {
                                if($d->id == ''.$_GET['option'].''  ) {?>
                                    <input type="hidden" name="altkat_3_adi" value="<?=$d->name?>" >
                                <?php }
                                    foreach ($d->subCategories as $e){
                                    if($e->parentId == ''.$_GET['option'].''  ) {
                                        if(empty($e->parentId)  ) {
                                            $durum = '0';
                                        }else{
                                            $durum = '1';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
    <?php if($durum == '1'  ) {?>
        <div class="form-group col-md-12">
            <label for="">4.<?=$diller['pazaryeri-text-11']?></label>
            <select name="category_sub" class="form-control selet2" style="width: 100% !important;" id="category_sub_4"  data-id1="<?=$_GET['id1']?>" data-id2="<?=$_GET['id2']?>" data-id3="<?=$_GET['id3']?>"  data-id4="<?=$_GET['option']?>"   required>
                <option value=""><?=$diller['adminpanel-form-text-50']?></option>
                <?php
                foreach ($subJson->categories as $a){
                    foreach ($a->subCategories as $b){
                        if($b->parentId == ''.$_GET['id1'].''  ) {
                            foreach ($b->subCategories as $c){
                                if($c->parentId == ''.$_GET['id2'].''  ) {
                                    foreach ($c->subCategories as $d){
                                        if($d->parentId == ''.$_GET['id3'].''  ) {
                                            foreach ($d->subCategories as $e){
                                                if($e->parentId == ''.$_GET['option'].''  ) {
                                            ?>
                                            <option value="<?=$e->id?>"><?=$e->name?> (#<?=$e->id?>)</option>
                                            <?php
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                ?>
            </select>
        </div>
        <div id="sub5" class="w-100" style="display:none"></div>
        <script type="text/javascript">
            $(document).ready(function(){
                $("select[id='category_sub_4']").on('change',function(){
                    var option = $("select[id='category_sub_4']").val();
                    var id1 = $(this).data('id1');
                    var id2 = $(this).data('id2');
                    var id3 = $(this).data('id3');
                    var id4 = $(this).data('id4');
                    jQuery.ajax({
                        type: "GET",
                        url: "masterpiece.php?page=ty_subcat&level=5",
                        data: {option:option,id1: id1,id2: id2,id3: id3,id4: id4},
                        success: function(response){
                            $("#sub5").html(response);
                            $("#sub5").show();
                        }
                    });
                });
            });
        </script>
    <?php } ?>
<?php }?>

<?php if($_GET['level'] == '5'  ) {
    $subCatControl = file_get_contents(''.$ayar['panel_url'].'assets/ty/catlist/kategoriler.php');
    $controlPoint = json_decode($subCatControl);
    foreach ($subJson->categories as $a){
        foreach ($a->subCategories as $b){
            if($b->parentId == ''.$_GET['id1'].''  ) {
                foreach ($b->subCategories as $c){
                    if($c->parentId == ''.$_GET['id2'].''  ) {
                        foreach ($c->subCategories as $d){
                            if($d->parentId == ''.$_GET['id3'].''  ) {
                                foreach ($d->subCategories as $e){
                                    if($e->parentId == ''.$_GET['id4'].''  ) {
                                        if($e->id == ''.$_GET['option'].''  ) { ?>
                                            <input type="hidden" name="altkat_4_adi" value="<?=$e->name?>" >
                                        <?php }
                                        foreach ($e->subCategories as $f){
                                            if($f->parentId ==  ''.$_GET['option'].''  ) {
                                                if(empty($f->parentId)  ) {
                                                    $durum = '0';
                                                }else{
                                                    $durum = '1';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
    <?php if($durum == '1'  ) {?>
        <div class="form-group col-md-12">
        <label for="">5.<?=$diller['pazaryeri-text-11']?></label>
        <select name="category_sub" class="form-control selet2" style="width: 100% !important;" id="category_sub_5" data-id1="<?=$_GET['id1']?>" data-id2="<?=$_GET['id2']?>" data-id3="<?=$_GET['id3']?>"  data-id4="<?=$_GET['id4']?>"   data-id5="<?=$_GET['option']?>" required>
        <option value=""><?=$diller['adminpanel-form-text-50']?></option>
        <?php
        foreach ($subJson->categories as $a){
            foreach ($a->subCategories as $b){
                if($b->parentId == ''.$_GET['id1'].''  ) {
                    foreach ($b->subCategories as $c){
                        if($c->parentId == ''.$_GET['id2'].''  ) {
                            foreach ($c->subCategories as $d){
                                if($d->parentId == ''.$_GET['id3'].''  ) {
                                    foreach ($d->subCategories as $e){
                                        if($e->parentId == ''.$_GET['id4'].''  ) {
                                            foreach ($e->subCategories as $f){
                                                if($f->parentId ==  ''.$_GET['option'].''  ) { ?>
                                                <option value="<?=$f->id?>"><?=$f->name?> (#<?=$f->id?>)</option>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
                ?>
            </select>
        </div>
        <div id="sub6" class="w-100" style="display:none"></div>
        <script type="text/javascript">
            $(document).ready(function(){
                $("select[id='category_sub_5']").on('change',function(){
                    var option = $("select[id='category_sub_5']").val();
                    var id1 = $(this).data('id1');
                    var id2 = $(this).data('id2');
                    var id3 = $(this).data('id3');
                    var id4 = $(this).data('id4');
                    var id5 = $(this).data('id5');
                    jQuery.ajax({
                        type: "GET",
                        url: "masterpiece.php?page=ty_subcat&level=6",
                        data: {option:option,id1: id1,id2: id2,id3: id3,id4: id4,id5: id5},
                        success: function(response){
                            $("#sub6").html(response);
                            $("#sub6").show();
                        }
                    });
                });
            });
        </script>
    <?php } ?>
<?php }?>

<?php if($_GET['level'] == '6'  ) {
    $subCatControl = file_get_contents(''.$ayar['panel_url'].'assets/ty/catlist/kategoriler.php');
    $controlPoint = json_decode($subCatControl);
    foreach ($subJson->categories as $a){
        foreach ($a->subCategories as $b){
            if($b->parentId == ''.$_GET['id1'].''  ) {
                foreach ($b->subCategories as $c){
                    if($c->parentId == ''.$_GET['id2'].''  ) {
                        foreach ($c->subCategories as $d){
                            if($d->parentId == ''.$_GET['id3'].''  ) {
                                foreach ($d->subCategories as $e){
                                    if($e->parentId == ''.$_GET['id4'].''  ) {
                                        foreach ($e->subCategories as $f){
                                            if($f->parentId ==  ''.$_GET['id5'].''  ) {
                                                if($f->id == ''.$_GET['option'].''  ) { ?>
                                                    <input type="hidden" name="altkat_5_adi" value="<?=$f->name?>" >
                                                <?php }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
<?php }?>

<script>
    $(document).ready(function() {
        $('.selet2').select2({

        })})
</script>



