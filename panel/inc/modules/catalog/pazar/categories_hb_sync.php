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

if($pazar['hb_durum'] != '1' ) {
    header('Location:'.$ayar['panel_url'].'pages.php?page=categories');
    exit();
}

$row = $kate->fetch(PDO::FETCH_ASSOC);
$aciklaDetayInfo  = $diller['pazaryeri-text-161'];
$eski   = '{cat}';
$yeni   = ''.$row['baslik'].'';
$aciklaDetayInfo = str_replace($eski, $yeni, $aciklaDetayInfo);


$ozellikcek = $row['ty_ozellik'];
$ozellikcek = explode('|', $ozellikcek);

$ozellikcekValue = $row['ty_ozellik'];
$ozellikcekValue = explode('|', $ozellikcekValue);

$ozellikcekValue2 = $row['ty_ozellik'];
$ozellikcekValue2 = explode('|', $ozellikcekValue2);

$urunsayisi = $db->prepare("select id from urun where iliskili_kat=:iliskili_kat and durum=:durum ");
$urunsayisi->execute(array(
    'iliskili_kat' => $ID,
    'durum' => '1'
));

$urunsay  = $diller['adminpanel-form-text-2154'];
$eski   = '{urunsayi}';
$yeni   = ''.$urunsayisi->rowCount().'';
$urunsay = str_replace($eski, $yeni, $urunsay);


$pazarDevSql = $db->prepare("select hb_user,hb_pass,hb_merchant from pazaryeri where id=:id ");
$pazarDevSql->execute(array(
    'id' => '1'
));
$pazarDevRow = $pazarDevSql->fetch(PDO::FETCH_ASSOC);


$hbuser = $pazarDevRow['hb_user'];
$hbpass = $pazarDevRow['hb_pass'];
$hbmerchant = $pazarDevRow['hb_merchant'];
?>
<title><?=$diller['pazaryeri-text-156']?> - <?=$panelayar['baslik']?></title>
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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['pazaryeri-text-156']?></a>
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
                                <h5> <?=$row['baslik']?> <i class="fa fa-caret-right"></i> <?=$diller['pazaryeri-text-156']?></h5>
                            </div>

                        </div>

                        <div class="w-100">
                                <div class="w-100 p-3 border border-warning alert-warning text-dark mb-3  rounded">
                                    <?=$aciklaDetayInfo?>
                                    <br><br>
                                    <?=$diller['pazaryeri-text-163']?>
                                </div>
                            <?php if($row['hb_kat_id'] == '0'  ) {?>
                                <div class="w-100 p-3 bg-light mb-3 font-12 rounded ">
                                    <i class="fa fa-info-circle mr-1"></i> <?=$diller['pazaryeri-text-162']?>
                                </div>
                            <?php } ?>

                            <?php if($row['hb_kat_id'] !='0'  ) {  ?>
                           <div class="row">
                                <!-- Kategori Sekronizasyonu !-->
                               <div class="col-md-12">
                                   <div class="rounded bg-light border border-grey p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                       <div class="flex-grow-1">
                                           <strong> <?=$diller['pazaryeri-text-4']?> :</strong> <?=$row['hb_kat_isim']?> (#<?=$row['hb_kat_id']?>)
                                       </div>
                                       <div class="d-sm-block mt-2 mb-2">
                                           <a href="javascript:Void(0)" data-page="category" data-id="<?=$ID?>" class="btn btn-secondary w-100 syncDO" href="" style="margin-left: auto;">
                                               <i class="fa fa-sync"></i> <?=$diller['pazaryeri-text-5']?>
                                           </a>
                                       </div>
                                   </div>
                                   <?php if($row['hb_ozellik'] == '0' ) {?>
                                       <div class="rounded bg-danger text-white p-3 mb-3 w-100 " style="font-size: 14px ;">
                                           <i class="fa fa-arrow-down"></i> <?=$diller['pazaryeri-text-165']?>
                                       </div>
                                   <?php }?>
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
                                       <form method="post" action="post.php?process=hb_post&status=hb_ozellik">
                                           <input type="hidden" name="cat_id" value="<?=$ID?>" >
                                           <input type="hidden" name="return" value="category" >
                                           <input type="hidden" name="hb_kat_id" value="<?=$row['hb_kat_id']?>" >
                                           <div class="row">
                                               <?php
                                               $AttGetir = file_get_contents(''.$ayar['panel_url'].'assets/hb_features/'.$row['hb_kat_id'].'.json');
                                               $attJson = json_decode($AttGetir);
                                               $ozellikcekValue = $row['hb_ozellik'];
                                               $ozellikcekValue = explode('|', $ozellikcekValue);

                                               ?>
                                               <?php foreach ($attJson->data->baseAttributes as $f){

                                                   $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$row['hb_kat_id'].'/attribute/'.$f->id.'/values?page=0&size=100';
                                                   $service_url = $istek;
                                                   $curl = curl_init($service_url);
                                                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                   $header = array(
                                                       'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                                                   );
                                                   curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                                   $curl_response = curl_exec($curl);
                                                   $final = json_decode($curl_response);

                                                   if($f->mandatory == '1'  ) {
                                                       if($f->id != 'Image1' && $f->id != 'tax_vat_rate' && $f->id != 'Barcode'  && $f->id != 'UrunAciklamasi'  && $f->id !='UrunAdi' && $f->id != 'merchantSku'  ) {
                                                           ?>
                                                           <?php if($f->type == 'enum'  ) {?>
                                                               <div class="col-md-6 form-group">
                                                                   <label for="<?=$f->id?>"><?=$f->name?></label>
                                                                   <select name="ozellik[<?=$f->id?>]" class="form-control" id="<?=$f->id?>" <?php if($f->mandatory == '1'  ) { ?>required<?php }?>>
                                                                       <?php foreach ($final as $ks) {?>
                                                                           <option value="<?=$ks->value?>"

                                                                               <?php foreach ($ozellikcekValue as $omcV) {
                                                                                   $omcV2 = $omcV;
                                                                                   $omcV2 = explode('___', $omcV2);
                                                                                   foreach ($omcV2 as $a =>$key){
                                                                                       if($key !='' && $a == '0') {
                                                                                           if($omcV2[1] == $ks->value  ) { ?>
                                                                                               selected
                                                                                           <?php }
                                                                                       }
                                                                                   }}
                                                                               ?>

                                                                           ><?=$ks->value?></option>
                                                                       <?php } ?>
                                                                   </select>
                                                               </div>
                                                               <?php }else{ ?>
                                                               <div class="col-md-6 form-group">
                                                               <label for="<?=$f->id?>"><?php if($f->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$f->name?></label>
                                                               <input
                                                                       <?php if($f->type == 'integer'  ) { ?>type="number"<?php } ?>
                                                                       <?php if($f->type == 'string'  ) { ?>type="text"<?php } ?>
                                                                       name="ozellik[<?=$f->id?>]" <?php if($f->mandatory == '1'  ) { ?>required<?php } ?> autocomplete="off" id="<?=$f->id?>"  class="form-control"
                                                                       <?php foreach ($ozellikcekValue as $omcV) {
                                                                           $omcV2 = $omcV;
                                                                           $omcV2 = explode('___', $omcV2);
                                                                           foreach ($omcV2 as $a =>$key){
                                                                               if($key !='' && $a == '0') {
                                                                                   if($omcV2[0] == $f->id  ) { ?>
                                                                                       value="<?=$omcV2[1]?>"
                                                                                   <?php }
                                                                               }
                                                                           }}
                                                                           ?>
                                                                   >
                                                               </div>
                                                               <?php } ?>
                                                           <?php
                                                       }
                                                   }
                                               }?>
                                               <?php foreach ($attJson->data->attributes as $d){
                                                   $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$row['hb_kat_id'].'/attribute/'.$d->id.'/values?page=0&size=100';
                                                   $service_url = $istek;
                                                   $curl = curl_init($service_url);
                                                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                   $header = array(
                                                      'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                                                   );
                                                   curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                                   $curl_response = curl_exec($curl);
                                                   $final = json_decode($curl_response);
                                                   ?>

                                                   <?php if($d->type == 'enum'  ) {?>
                                                       <div class="col-md-6 form-group">
                                                           <label for="<?=$d->id?>"><?=$d->name?></label>
                                                           <select name="ozellik[<?=$d->id?>]" class="form-control" id="<?=$d->id?>" <?php if($d->mandatory == '1'  ) { ?>required<?php }?>>
                                                           <?php foreach ($final as $ks) {?>
                                                               <option value="<?=$ks->value?>"

                                                                   <?php foreach ($ozellikcekValue as $omcV) {
                                                                       $omcV2 = $omcV;
                                                                       $omcV2 = explode('___', $omcV2);
                                                                       foreach ($omcV2 as $a =>$key){
                                                                           if($key !='' && $a == '0') {
                                                                               if($omcV2[1] == $ks->value  ) { ?>
                                                                                  selected
                                                                               <?php }
                                                                           }
                                                                       }}
                                                                   ?>

                                                               ><?=$ks->value?></option>
                                                           <?php } ?>
                                                           </select>
                                                       </div>
                                                   <?php }else{ ?>
                                                       <div class="col-md-6 form-group">
                                                           <label for="<?=$d->id?>"><?php if($d->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$d->name?></label>
                                                           <input
                                                               <?php if($d->type == 'integer'  ) { ?>type="number"<?php } ?>
                                                               <?php if($d->type == 'string'  ) { ?>type="text"<?php } ?>
                                                               name="ozellik[<?=$d->id?>]" <?php if($d->mandatory == '1'  ) { ?>required<?php } ?> autocomplete="off" id="<?=$d->id?>"  class="form-control"
                                                               <?php foreach ($ozellikcekValue as $omcV) {
                                                                   $omcV2 = $omcV;
                                                                   $omcV2 = explode('___', $omcV2);
                                                                   foreach ($omcV2 as $a =>$key){
                                                                       if($key !='' && $a == '0') {
                                                                           if($omcV2[0] == $d->id  ) { ?>
                                                                               value="<?=$omcV2[1]?>"
                                                                           <?php }
                                                                       }
                                                                   }}
                                                               ?>
                                                           >
                                                       </div>
                                                   <?php } ?>
                                                   <?php
                                               } ?>
                                               <?php foreach ($attJson->data->variantAttributes as $d){
                                                   $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$row['hb_kat_id'].'/attribute/'.$d->id.'/values?page=0&size=100';
                                                   $service_url = $istek;
                                                   $curl = curl_init($service_url);
                                                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                   $header = array(
                                                       'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                                                   );
                                                   curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                                   $curl_response = curl_exec($curl);
                                                   $final = json_decode($curl_response);
                                                   ?>
                                                   <?php if($d->type == 'enum'  ) {?>
                                                       <div class="col-md-6 form-group">
                                                           <label for="<?=$d->id?>"><?=$d->name?></label>
                                                           <select name="ozellik[<?=$d->id?>]" class="form-control" id="<?=$d->id?>" <?php if($d->mandatory == '1'  ) { ?>required<?php }?>>
                                                               <?php foreach ($final as $ks2) {?>
                                                                   <option value="<?=$ks2->value?>"

                                                                       <?php foreach ($ozellikcekValue as $omcV) {
                                                                           $omcV2 = $omcV;
                                                                           $omcV2 = explode('___', $omcV2);
                                                                           foreach ($omcV2 as $a =>$key){
                                                                               if($key !='' && $a == '0') {
                                                                                   if($omcV2[1] == $ks2->value  ) { ?>
                                                                                       selected
                                                                                   <?php }
                                                                               }
                                                                           }}
                                                                       ?>

                                                                   ><?=$ks2->value?></option>
                                                               <?php }?>
                                                           </select>
                                                       </div>
                                                   <?php }else{ ?>
                                                       <div class="col-md-6 form-group">
                                                           <label for="<?=$d->id?>"><?php if($d->mandatory == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$d->name?></label>
                                                           <input
                                                               <?php if($d->type == 'integer'  ) { ?>type="number"<?php } ?>
                                                               <?php if($d->type == 'string'  ) { ?>type="text"<?php } ?>
                                                               name="ozellik[<?=$d->id?>]" <?php if($d->mandatory == '1'  ) { ?>required<?php } ?> autocomplete="off" id="<?=$d->id?>"  class="form-control"
                                                               <?php foreach ($ozellikcekValue as $omcV) {
                                                                   $omcV2 = $omcV;
                                                                   $omcV2 = explode('___', $omcV2);
                                                                   foreach ($omcV2 as $a =>$key){
                                                                       if($key !='' && $a == '0') {
                                                                           if($omcV2[0] == $d->id  ) { ?>
                                                                               value="<?=$omcV2[1]?>"
                                                                           <?php }
                                                                       }
                                                                   }}
                                                               ?>
                                                           >
                                                       </div>
                                                   <?php } ?>
                                                   <?php
                                               }?>
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
                url: 'masterpiece.php?page=hbCatSelect',
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

