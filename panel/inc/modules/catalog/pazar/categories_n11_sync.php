<?php
error_reporting(0);
$pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
$pazarYeri->execute();
$pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
include "inc/modules/entegration/pazar/n11_api.php";
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'sync_n11';

$IDGET = $_GET['catID'];
$ID = htmlspecialchars($IDGET);

$kate = $db->prepare("select * from urun_cat where id=:id ");
$kate->execute(array(
        'id' => $ID
));


if($kate->rowCount()<='0'  ) {
 header('Location:'.$ayar['panel_url'].'pages.php?page=categories');
 exit();
}

if($pazar['n11_durum'] != '1' ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=categories');
    exit();
}

$row = $kate->fetch(PDO::FETCH_ASSOC);
$aciklaDetayInfo  = $diller['pazaryeri-text-16'];
$eski   = '{cat}';
$yeni   = ''.$row['baslik'].'';
$aciklaDetayInfo = str_replace($eski, $yeni, $aciklaDetayInfo);
$ozellikcek = $row['n11_ozellik'];
$ozellikcek = explode('|', $ozellikcek);


$urunsayisi = $db->prepare("select id from urun where iliskili_kat=:iliskili_kat and durum=:durum ");
$urunsayisi->execute(array(
        'iliskili_kat' => $ID,
        'durum' => '1'
));

                $urunsay  = $diller['adminpanel-form-text-2154'];
                $eski   = '{urunsayi}';
                $yeni   = ''.$urunsayisi->rowCount().'';
                $urunsay = str_replace($eski, $yeni, $urunsay);

?>
<title><?=$diller['pazaryeri-text-2']?> - <?=$panelayar['baslik']?></title>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">


        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-2']?></a>
                                <a href="pages.php?page=categories"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-4']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$row['baslik']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['pazaryeri-text-2']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->


        <?php if($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') {?>
            <div class="row">
                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="new-buttonu-main-top">
                            <div class="new-buttonu-main-left">
                                <div>
                                    <a href="pages.php?page=categories" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                        <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                    </a>
                                </div>
                                <div>
                                    <?=$urunsay?>
                                </div>
                                <h5> <?=$row['baslik']?> <i class="fa fa-caret-right"></i> <?=$diller['pazaryeri-text-2']?></h5>
                            </div>

                        </div>

                        <div class="w-100">
                                <div class="w-100 p-3 border border-warning alert-warning text-dark mb-3  rounded">
                                    <?=$aciklaDetayInfo?>
                                </div>
                            <?php if($row['n11_kat_id'] == '0'  ) {?>
                                <div class="w-100 p-3 bg-light mb-3 font-12 rounded ">
                                    <i class="fa fa-info-circle mr-1"></i> <?=$diller['pazaryeri-text-6']?>
                                </div>
                            <?php } ?>

                            <?php if($row['n11_kat_id'] !='0'  ) {
                                $fileCheck = file_get_contents(''.$ayar['panel_url'].'assets/n11/cat/'.$row['n11_kat_id'].'.php');
                                $attrb= json_decode($fileCheck);
                                $att_area= json_decode($fileCheck,true);
                                ?>
                                <div class="rounded bg-light border border-grey p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                    <div class="flex-grow-1">
                                        <strong> <?=$diller['pazaryeri-text-4']?> :</strong> <?=$row['n11_kat_isim']?> (#<?=$row['n11_kat_id']?>)
                                    </div>
                                  <div class="d-sm-block mt-2 mb-2">
                                      <a href="javascript:Void(0)" data-page="category" data-id="<?=$ID?>" class="btn btn-secondary w-100 syncDo" href="" style="margin-left: auto;">
                                          <i class="fa fa-sync"></i> <?=$diller['pazaryeri-text-5']?>
                                      </a>
                                  </div>
                                </div>
                                <?php if($row['n11_ozellik'] == '0' ) {?>
                                    <div class="rounded bg-danger text-white p-3 mb-3 w-100 " style="font-size: 14px ;">
                                        <i class="fa fa-arrow-down"></i> <?=$diller['pazaryeri-text-14']?>
                                    </div>
                                <?php }?>
                            <div class="rounded border border-grey p-3 w-100 " style="font-size: 14px ;">
                                <div class="in-header-page-main2">
                                    <div class="in-header-page-text2 text-primary">
                                        <i class="fa fa-arrow-down"></i>
                                        <?=$diller['pazaryeri-text-8']?>
                                    </div>
                                </div>
                                <form method="post" action="post.php?process=pazar_post&status=n11_ozellik">
                                    <input type="hidden" name="cat_id" value="<?=$ID?>" >
                                    <input type="hidden" name="return" value="category" >
                                <div class="row">
                                    <?php if(isset($att_area['category']['attributeList']['attribute'][0])  ) {?>
                                        <?php
                                        // 1 den fazla attribute için
                                        foreach ($attrb->category->attributeList as $ats) {
                                            foreach ($ats as $at =>$key){
                                                ?>
                                                <div class="col-md-6 form-group">
                                                    <label for="<?=$key->name?>"><?php if($key->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$key->name?></label>
                                                    <select name="ozellik[]" class="form-control selet2" style="width: 100%" id="<?=$key->name?>" <?php if($key->mandatory == '1'  ) { ?>required<?php }?>>
                                                        <?php if($key->mandatory != '1'  ) { ?>
                                                            <option value="" selected><?=$diller['adminpanel-form-text-1222']?></option>
                                                        <?php } ?>
                                                        <?php foreach ($key->valueList as $val ) {?>
                                                            <?php foreach ($val as $va =>$vas) {?>
                                                                <option value="<?=$key->name?>_<?=$vas->name?>"
                                                                    <?php foreach ($ozellikcek as $omc) {?>
                                                                        <?php if($omc == ''.$key->name.'_'.$vas->name.'' ) {?>
                                                                            selected
                                                                        <?php }?>
                                                                    <?php }?>
                                                                ><?=$vas->name?></option>
                                                            <?php }?>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                    <?php }else { 
                                        // tek attribute için
                                        ?>
                                        <div class="col-md-6 form-group">
                                            <label for="<?=$attrb->category->attributeList->attribute->name?>"><?php if($attrb->category->attributeList->attribute->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$attrb->category->attributeList->attribute->name?></label>
                                            <select name="ozellik[]" class="form-control selet2" style="width: 100%" id="<?=$attrb->category->attributeList->attribute->name?>" <?php if($attrb->category->attributeList->attribute->mandatory == '1') { ?>required<?php }?>>
                                                <?php if($attrb->category->attributeList->attribute->mandatory != '1'  ) {?>
                                                    <option value="" selected><?=$diller['adminpanel-form-text-1222']?></option>
                                                <?php }?>
                                                <?php
                                                foreach ($attrb->category->attributeList->attribute->valueList as $val){
                                                foreach ($val as $mam => $des) {
                                                    ?>
                                                    <option value="<?=$attrb->category->attributeList->attribute->name?>_<?=$des->name?>"
                                                    <?php foreach ($ozellikcek as $omc) {?>
                                                        <?php if($omc == ''.$attrb->category->attributeList->attribute->name.'_'.$des->name.'' ) {?>
                                                            selected
                                                        <?php }?>
                                                    <?php }?>
                                                    ><?=$des->name?></option>
                                                    <?php
                                                }}
                                                ?>
                                            </select>
                                        </div>
                                    <?php }?>
                                    <div class="col-md-12 form-group mb-0 mt-2">
                                        <button class="btn btn-block  btn-success " name="attAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <?php } else { ?>
                            <div class="w-100 d-flex align-items-center justify-content-center pt-4 pb-4 border">
                                <a href="javascript:Void(0)" data-id="<?=$ID?>" data-page="category" class="btn btn-lg btn-success syncDo"><i class="fa fa-sync mr-2"></i> <?=$diller['pazaryeri-text-9']?></a>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <!--  <========SON=========>>> Contents SON !-->


            </div>
        <?php }else { ?>
            <div class="card p-xl-5">
                <h3><?=$diller['adminpanel-text-136']?></h3>
                <h6><?=$diller['adminpanel-text-137']?></h6>
                <div  class="mt-3">
                    <a href="<?=$ayar['panel_url']?>" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                </div>
            </div>
        <?php }?>
    </div>
</div>
<!-- Editable Modal !-->
<script type='text/javascript'>
    $(document).ready(function(){

        $('.syncDo').click(function(){

            var postID = $(this).data('id');
            var turnPage = $(this).data('page');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=n11CatSelect',
                type: 'post',
                data: {postID: postID,turnPage: turnPage},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
    $(document).ready(function() {
        $('.selet2').select2({

        })})
</script>
<!--  <========SON=========>>> Editable Modal SON !-->

