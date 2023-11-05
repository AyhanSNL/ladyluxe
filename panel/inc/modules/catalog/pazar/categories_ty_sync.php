<?php
error_reporting(0);
$pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
$pazarYeri->execute();
$pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'sync_ty';

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

if($pazar['ty_durum'] != '1' ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=categories');
    exit();
}

$row = $kate->fetch(PDO::FETCH_ASSOC);
$aciklaDetayInfo  = $diller['pazaryeri-text-76'];
$eski   = '{cat}';
$yeni   = ''.$row['baslik'].'';
$aciklaDetayInfo = str_replace($eski, $yeni, $aciklaDetayInfo);


$ozellikcek = $row['ty_ozellik'];
$ozellikcek = explode('|', $ozellikcek);

$ozellikcekValue = $row['ty_ozellik'];
$ozellikcekValue = explode('|', $ozellikcekValue);

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
<title><?=$diller['pazaryeri-text-75']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['pazaryeri-text-75']?></a>
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
                                <h5> <?=$row['baslik']?> <i class="fa fa-caret-right"></i> <?=$diller['pazaryeri-text-75']?></h5>
                            </div>

                        </div>

                        <div class="w-100">
                                <div class="w-100 p-3 border border-warning alert-warning text-dark mb-3  rounded">
                                    <?=$aciklaDetayInfo?>
                                </div>
                            <?php if($row['ty_kat'] == '0'  ) {?>
                                <div class="w-100 p-3 bg-light mb-3 font-12 rounded ">
                                    <i class="fa fa-info-circle mr-1"></i> <?=$diller['pazaryeri-text-77']?>
                                </div>
                            <?php } ?>

                            <?php if($row['ty_kat'] !='0'  ) {
                                $fileCheck = file_get_contents(''.$ayar['panel_url'].'assets/ty/ozellik/'.$row['ty_kat'].'.php');
                                $attrb= json_decode($fileCheck);
                                $att_area= json_decode($fileCheck,true);
                                ?>
                           <div class="row">

                               <!-- Marka Col !-->
                               <div class="col-md-4">
                                   <div class="rounded border border-grey p-3 w-100 mb-3" style="font-size: 14px ;">
                                       <div class="in-header-page-main2">
                                           <div class="in-header-page-text2 text-primary">
                                               <i class="fa fa-arrow-down"></i>
                                               <?=$diller['pazaryeri-text-81']?>
                                           </div>
                                       </div>

                                       <!-- Marka Eklenmemişse uyar !-->
                                       <?php if($row['ty_marka'] == '0' || $row['ty_marka'] == null  ) {?>
                                           <div class="rounded bg-danger text-white p-3 w-100 " style="font-size: 14px ;">
                                               <i class="fa fa-arrow-down"></i> <?=$diller['pazaryeri-text-88']?>
                                           </div>
                                       <?php }?>
                                       <!--  <========SON=========>>> Marka Eklenmemişse uyar SON !-->

                                       <?php if(isset($_GET['markaAra']) && $_GET['markaAra'] == !null ) {?>
                                           <!-- Arama yapıldı. Sonuçları Getir. !-->
                                           <div class="row">
                                               <div class="col-md-12 form-group">
                                                   <div class="alert-secondary   p-3 rounded mb-2" style="font-size: 13px ;">
                                                       <strong><?=$_GET['markaAra']?></strong> <?=$diller['pazaryeri-text-86']?>
                                                       <br><br>
                                                       <a class="btn btn-dark btn-sm " href="pages.php?page=ty_sync&catID=<?=$row['id']?>">
                                                           <i class="fa fa-arrow-left"></i> <?=$diller['pazaryeri-text-85']?>
                                                       </a>
                                                   </div>
                                               </div>
                                           </div>
                                           <form method="post" action="post.php?process=ty_post&status=ty_marka_ekle">
                                               <input type="hidden" name="cat_id" value="<?=$ID?>" >
                                               <input type="hidden" name="return" value="category" >
                                               <input type="hidden" name="ty_kat_id" value="<?=$row['ty_kat']?>">
                                               <div class="row">
                                                   <div class="col-md-12 form-group">
                                                       <?php
                                                       $markaURLSearch = file_get_contents('https://api.trendyol.com/sapigw/brands/by-name?name='.urlencode($_GET['markaAra']).'');
                                                       $markaSearch= json_decode($markaURLSearch);
                                                       ?>
                                                       <label for=""><?=$diller['pazaryeri-text-87']?></label>
                                                       <br>
                                                       <select name="ty_marka_post" class="form-control selet2" required>
                                                           <?php foreach ($markaSearch as $mark ) {?>
                                                               <option value="<?=$mark->id?>_<?=$mark->name?>"><?=$mark->name?></option>
                                                           <?php }?>
                                                       </select>
                                                   </div>
                                                   <div class="col-md-12 form-group mb-0 mt-2">
                                                       <button class="btn btn-block  btn-success " name="attAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                                   </div>
                                               </div>
                                           </form>
                                           <!--  <========SON=========>>> Arama yapıldı. Sonuçları Getir. SON !-->
                                       <?php }else {?>
                                           <!-- Arama Yaptırma Formu !-->
                                           <form method="GET" action="pages.php">
                                               <input type="hidden" name="page" value="ty_sync" >
                                               <input type="hidden" name="catID" value="<?=$row['id']?>" >
                                               <div class="row">
                                                   <div class="col-md-12 form-group">
                                                       <?php if($row['ty_marka_adi'] == !null ) {?>
                                                           <div class=" alert-info  text-dark p-3 rounded">
                                                               <?php
                                                               $markaCevir  = $diller['pazaryeri-text-82'];
                                                               $eskiMarka   = '{marka}';
                                                               $yeniMarka   = '<strong>'.$row['ty_marka_adi'].'(#'.$row['ty_marka'].')</strong>';
                                                               $markaCevir = str_replace($eskiMarka, $yeniMarka, $markaCevir);
                                                               ?>
                                                               <?=$markaCevir?>
                                                           </div>
                                                       <?php }?>
                                                   </div>
                                                   <div class="col-md-12 form-group">
                                                       <label for="ara"><?=$diller['pazaryeri-text-83']?></label>
                                                       <input type="text" name="markaAra" id="ara" required  autocomplete="off"  class="form-control">
                                                   </div>
                                                   <div class="col-md-12 form-group mb-0 mt-2">
                                                       <button class="btn btn-block  btn-success "><?=$diller['pazaryeri-text-84']?></button>
                                                   </div>
                                               </div>
                                           </form>
                                           <!--  <========SON=========>>> Arama Yaptırma Formu SON !-->
                                       <?php }?>


                                   </div>
                               </div>
                               <!--  <========SON=========>>> Marka Col SON !-->

                                <!-- Kategori Sekronizasyonu !-->
                               <div class="col-md-8">
                                   <div class="rounded bg-light border border-grey p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                       <div class="flex-grow-1">
                                           <strong> <?=$diller['pazaryeri-text-4']?> :</strong> <?=$row['ty_kat_adi']?> (#<?=$row['ty_kat']?>)
                                       </div>
                                       <div class="d-sm-block mt-2 mb-2">
                                           <a href="javascript:Void(0)" data-page="category" data-id="<?=$ID?>" class="btn btn-secondary w-100 syncDO" href="" style="margin-left: auto;">
                                               <i class="fa fa-sync"></i> <?=$diller['pazaryeri-text-5']?>
                                           </a>
                                       </div>
                                   </div>
                                   <?php if($row['ty_ozellik'] == '0' && isset($att_area['categoryAttributes'][0])  ) {?>
                                       <div class="rounded bg-danger text-white p-3 mb-3 w-100 " style="font-size: 14px ;">
                                           <i class="fa fa-arrow-down"></i> <?=$diller['pazaryeri-text-80']?>
                                       </div>
                                   <?php }?>
                                   <div class="rounded border border-grey p-3 w-100 " style="font-size: 14px ;">
                                       <div class="in-header-page-main2">
                                           <div class="in-header-page-text2 text-primary">
                                               <i class="fa fa-arrow-down"></i>
                                               <?=$diller['pazaryeri-text-8']?>
                                           </div>
                                       </div>
                                       <form method="post" action="post.php?process=ty_post&status=ty_ozellik">
                                           <input type="hidden" name="cat_id" value="<?=$ID?>" >
                                           <input type="hidden" name="return" value="category" >
                                           <input type="hidden" name="ty_kat_id" value="<?=$row['ty_kat']?>" >
                                           <div class="row">
                                               <?php if(isset($att_area['categoryAttributes'][0])  ) {?>
                                                   <?php foreach ($attrb->categoryAttributes as $at) {?>
                                                       <div class="col-md-6 form-group">
                                                           <label for="<?=$at->attribute->id?>"><?php if($at->required == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$at->attribute->name?></label>
                                                           <?php if($at->allowCustom == '1'  ) {?>
                                                               <input type="text"
                                                                   <?php foreach ($ozellikcekValue as $omcV) {
                                                                       $omcV2 = $omcV;
                                                                       $omcV2 = explode('_', $omcV2);
                                                                       foreach ($omcV2 as $a =>$key){
                                                                           if($key !='' && $a == '0') {
                                                                               if($omcV2[0] == $at->attribute->id  ) { ?>
                                                                                   value="<?=$omcV2[1]?>"
                                                                               <?php }
                                                                           }
                                                                       }
                                                                       ?>
                                                                   <?php }?>
                                                                      name="ozellik[<?=$at->attribute->id?>]" id="<?=$at->attribute->id?>" <?php if($at->required == '1'  ) { ?>required <?php } ?> class="form-control">
                                                           <?php }else { ?>
                                                               <select name="ozellik[<?=$at->attribute->id?>]" class="form-control selet2" style="width: 100%" id="<?=$at->attribute->id?>" <?php if($at->required == '1'  ) { ?>required<?php }?>>
                                                                   <?php if($at->required != '1'  ) { ?>
                                                                       <option value="" selected><?=$diller['adminpanel-form-text-1222']?></option>
                                                                   <?php } ?>
                                                                   <?php foreach ($at->attributeValues as $at2) {?>
                                                                       <option value="<?=$at2->id?>"
                                                                           <?php foreach ($ozellikcek as $omc) {?>
                                                                               <?php if($omc == ''.$at->attribute->id.'_'.$at2->id.'' ) {?>
                                                                                   selected
                                                                               <?php }?>
                                                                           <?php }?>
                                                                       ><?=$at2->name?></option>
                                                                   <?php }?>
                                                               </select>
                                                           <?php }?>
                                                       </div>
                                                   <?php }
                                               }else { ?>
                                                   yok
                                               <?php }?>
                                               <div class="col-md-12 form-group mb-0 mt-2">
                                                   <button class="btn btn-block  btn-success " name="attAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                               </div>
                                           </div>
                                       </form>
                                   </div>
                               </div>
                               <!--  <========SON=========>>> Kategori Sekronizasyonu SON !-->

                           </div>
                            <?php } else { ?>
                            <div class="w-100 d-flex align-items-center justify-content-center pt-4 pb-4 border">
                                <a href="javascript:Void(0)" data-id="<?=$ID?>" data-page="category" class="btn btn-lg btn-success syncDO"><i class="fa fa-sync mr-2"></i> <?=$diller['pazaryeri-text-9']?></a>
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

        $('.syncDO').click(function(){

            var postID = $(this).data('id');
            var turnPage = $(this).data('page');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=tyCatSelect',
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

