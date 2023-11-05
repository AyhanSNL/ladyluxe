<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'users';
$grp = $db->prepare("select * from uyeler_grup ");
$grp->execute();
$userAyar = $db->prepare("select * from uyeler_ayar ");
$userAyar->execute();
$userset = $userAyar->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['userID']) && $_GET['userID']== !null  ) {
    $Sql = $db->prepare("select * from uyeler where id=:id ");
    $Sql->execute(array(
        'id' => $_GET['userID']
    ));
    $row = $Sql->fetch(PDO::FETCH_ASSOC);


    if($Sql->rowCount()<='0'  ) {
        header('Location:'.$ayar['panel_url'].'pages.php?page=users');
        exit();
    }


}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=users');
    exit();
}




?>
<title><?=$diller['adminpanel-form-text-1307']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-25']?></a>
                                <a href="pages.php?page=users"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-26']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$row['isim']?> <?=$row['soyisim']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <?php if($yetki['uyelik'] == '1' && $yetki['uye_yonet'] == '1') {

         ?>


            <div class="row">

                <?php include 'inc/modules/_helper/users_leftbar.php'; ?>
                <style>
                    .nav-link{
                        color: #000;
                        transition-duration: 0.1s; transition-timing-function: linear;
                        font-weight: 500;
                        font-size: 14px;
                        padding: 15px 25px;

                    }

                    .saas:hover{
                        background-color: #fff;
                        color: #000;
                    }
                    @media (max-width: 768px) {
                        .nav-link{
                            color: #000;
                            transition-duration: 0.1s; transition-timing-function: linear;
                            font-weight: 500;
                            font-size: 14px;
                            padding: 10px;
                        }
                        .nav-tabs{
                            padding: 15px;
                        }
                        .nav-tabs li:first-child{
                            margin-left: 0;
                        }
                        .nav-link.active{
                            border-color: #dee2e6 #dee2e6 #dee2e6 !important;
                            border-radius: 6px !important;
                        }
                    }
                </style>
                <!-- Contents !-->
                <div class="col-md-12">
                    <div class="">
                        <div class="bg-primary text-white p-3 rounded d-flex align-items-center justify-content-between flex-wrap shadow-sm">
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 100px; background: #FFF; color: #000;">
                                    <i class="fa fa-user" style="font-size: 20px ;"></i>
                                </div>
                                <div class="ml-3">
                                    <h5><?=$row['isim']?> <?=$row['soyisim']?></h5>
                                </div>
                            </div>
                            <a href="pages.php?page=users" class="btn btn-outline-light btn-sm mt-2 mb-2 d-inline-block"><i class="fas fa-arrow-left"></i> <?=$diller['adminpanel-text-164']?></a>

                        </div>
                        <div class="w-100 d-flex flex-column pb-2 mb-2">

                        </div>
                            <!-- Tab Alanı !-->
                            <ul class="nav nav-tabs " id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link saas active"  href="pages.php?page=user_detail&userID=<?=$row['id']?>" >
                                       <?=$diller['adminpanel-form-text-1308']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas "  href="pages.php?page=user_detail_address&userID=<?=$row['id']?>" >
                                        <?=$diller['adminpanel-form-text-1309']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas "  href="pages.php?page=user_favorites&userID=<?=$row['id']?>" >
                                        <?=$diller['adminpanel-form-text-1310']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas "  href="pages.php?page=user_log&userID=<?=$row['id']?>" >
                                        <?=$diller['adminpanel-text-239']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas "  href="pages.php?page=user_coupon&userID=<?=$row['id']?>" >
                                       <?=$diller['adminpanel-menu-text-31']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas " href="pages.php?page=products_comments&userID=<?=$row['id']?>" target="_blank">
                                        <?=$diller['adminpanel-form-text-1311']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas " href="pages.php?page=orders&userID=<?=$row['id']?>" target="_blank">
                                        <?=$diller['adminpanel-form-text-1312']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas " href="pages.php?page=tickets&userID=<?=$row['id']?>" target="_blank">
                                       <?=$diller['adminpanel-menu-text-28']?>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link saas " href="pages.php?page=all_cart_list&userID=<?=$row['id']?>" target="_blank">
                                        <?=$diller['adminpanel-form-text-1313']?>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content bg-white rounded-bottom border border-top-0">
                                <div class="tab-pane active p-4" id="one" role="tabpanel" >
                                    <div class="row">
                                        <div class="col-md-8">
                                           <div class="border shadow-sm">
                                               <div class="card-body">
                                                   <form action="post.php?process=users_post&status=user_edit" method="post" >
                                                       <input type="hidden" name="user_id" value="<?=$row['id']?>">
                                                       <div class="row">
                                                           <div class="form-group col-md-6">
                                                               <label for=""><?=$diller['adminpanel-form-text-1314']?></label>
                                                               <input type="text" readonly name=""  id="" value="<?php echo date_tr('j F Y, H:i, l ', ''.$row['tarih'].''); ?>" class="form-control">
                                                           </div>
                                                           <?php if($row['son_giris'] == !null ) {?>
                                                               <div class="form-group col-md-6">
                                                                   <label for=""><?=$diller['adminpanel-form-text-1301']?></label>
                                                                   <input type="text" readonly name=""  id="" value="<?php echo date_tr('j F Y, H:i, l ', ''.$row['son_giris'].''); ?>" class="form-control">
                                                               </div>
                                                           <?php }?>

                                                           <div class="form-group col-md-12 mb-4">
                                                               <label  for="onay" class="w-100" ><?=$diller['adminpanel-form-text-1302']?></label>
                                                               <div class="custom-control custom-switch custom-switch-lg">
                                                                   <input type="hidden" name="onay" value="0"">
                                                                   <input type="checkbox" class="custom-control-input" id="onay" name="onay" value="1"  <?php if($row['onay'] == '1' ) { ?>checked<?php }?> >
                                                                   <label class="custom-control-label" for="onay"></label>
                                                               </div>
                                                           </div>

                                                       </div>
                                                       <div class="row">
                                                           <div class="form-group col-md-6">
                                                               <label for="uye_grup"><?=$diller['adminpanel-form-text-1290']?></label>
                                                               <select name="uye_grup" class="form-control" id="uye_grup" >
                                                                   <option value="0"><?=$diller['adminpanel-form-text-1297']?></option>
                                                                   <?php foreach ($grp as $gr) {?>
                                                                       <option value="<?=$gr['id']?>" <?php if($row['uye_grup'] == $gr['id'] ) { ?>selected<?php }?>><?=$gr['baslik']?></option>
                                                                   <?php }?>
                                                               </select>
                                                           </div>
                                                           <?php if($userset['basit_form'] == '0' ) {?>
                                                               <div class="form-group col-md-6">
                                                                   <label  for="tip" class="w-100"><?=$diller['adminpanel-form-text-1294']?></label>
                                                                   <select name="tip" class="form-control" id="tip" >
                                                                       <option value="1" <?php if($row['uye_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1289']?></option>
                                                                       <option value="2" <?php if($row['uye_tip'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1288']?></option>
                                                                   </select>
                                                               </div>
                                                           <?php } ?>
                                                       </div>
                                                       <?php if($userset['basit_form'] == '0' ) {?>
                                                           <div id="bireysel-choose" <?php if($row['uye_tip'] != '1'  ) { ?>style="display:none"<?php }?>>
                                                               <div class="row" >
                                                                   <div class="form-group col-md-4">
                                                                       <label for="tc"><?=$diller['adminpanel-form-text-1316']?></label>
                                                                       <input type="text" name="tc"  id="tc" value="<?=$row['tc_no']?>" class="form-control">
                                                                   </div>
                                                               </div>
                                                           </div>

                                                           <div id="kurumsal-choose" <?php if($row['uye_tip'] != '2'  ) { ?>style="display:none"<?php }?>>
                                                               <div class="row" >
                                                                   <div class="form-group col-md-4">
                                                                       <label for="firma_unvan"><?=$diller['adminpanel-form-text-1317']?></label>
                                                                       <input type="text" name="firma_unvan"  id="firma_unvan" value="<?=$row['firma_unvan']?>" class="form-control">
                                                                   </div>
                                                                   <div class="form-group col-md-4">
                                                                       <label for="vergi_dairesi"><?=$diller['adminpanel-form-text-1318']?></label>
                                                                       <input type="text" name="vergi_dairesi"  id="vergi_dairesi" value="<?=$row['vergi_dairesi']?>" class="form-control">
                                                                   </div>
                                                                   <div class="form-group col-md-4">
                                                                       <label for="vergi_no"><?=$diller['adminpanel-form-text-1319']?></label>
                                                                       <input type="text" name="vergi_no"  id="vergi_no" value="<?=$row['vergi_no']?>" class="form-control">
                                                                   </div>
                                                               </div>
                                                           </div>

                                                           <script>
                                                               $('#tip').on('change', function() {
                                                                   $('#bireysel-choose').css('display', 'none');
                                                                   if ( $(this).val() === '1' ) {
                                                                       $('#bireysel-choose').css('display', 'block');
                                                                   }
                                                                   $('#kurumsal-choose').css('display', 'none');
                                                                   if ( $(this).val() === '2' ) {
                                                                       $('#kurumsal-choose').css('display', 'block');
                                                                   }
                                                               });
                                                           </script>
                                                       <?php }?>
                                                       <div class="row">
                                                           <div class="form-group col-md-4">
                                                               <label for="isim"><?=$diller['adminpanel-form-text-47']?></label>
                                                               <input type="text" name="isim"  id="isim" value="<?=$row['isim']?>" class="form-control">
                                                           </div>
                                                           <div class="form-group col-md-4">
                                                               <label for="soyisim"><?=$diller['adminpanel-form-text-48']?></label>
                                                               <input type="text" name="soyisim"  id="soyisim" value="<?=$row['soyisim']?>"  class="form-control">
                                                           </div>
                                                           <div class="form-group col-md-4">
                                                               <label for="telefon"><?=$diller['adminpanel-form-text-81']?></label>
                                                               <input type="text" name="telefon"  id="telefon" value="<?=$row['telefon']?>"  class="form-control">
                                                           </div>
                                                       </div>
                                                       <div class="row">
                                                           <div class="form-group col-md-6">
                                                               <label for="eposta" class="d-flex align-items-center justify-content-start">
                                                                   <?=$diller['adminpanel-form-text-1107']?>
                                                                   <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1295']?>"></i>
                                                               </label>
                                                               <input type="email" name="eposta"  id="eposta" value="<?=$row['eposta']?>" required class="form-control">
                                                           </div>
                                                           <div class="form-group col-md-6">
                                                               <label for="sifre" class="d-flex align-items-center justify-content-start">
                                                                   <?=$diller['adminpanel-form-text-1296']?>
                                                                   <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-1315']?>"></i>
                                                               </label>
                                                               <input type="text" autocomplete="off" name="sifre"  id="sifre"  class="form-control">
                                                           </div>
                                                       </div>
                                                       <div class="row mt-2">
                                                           <div class="col-md-12 ">
                                                               <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                           </div>
                                                       </div>
                                                   </form>
                                               </div>
                                           </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="border shadow-sm mb-4">
                                                <form action="post.php?process=users_post&status=ticket_status_update" method="post" >
                                                    <input type="hidden" name="user_id" value="<?=$row['id']?>">
                                                <div class="card-body">
                                                   <div>
                                                       <h6><?=$diller['adminpanel-form-text-1344']?></h6>
                                                   </div>
                                                    <div class="row">
                                                        <?php if($uyeayar['destek_alani'] == '0' ) {?>
                                                            <div class="form-group col-md-12">
                                                                <div class="border-warning border text-dark alert-warning p-3">
                                                                    <div style="font-size: 18px; font-weight: 500;">
                                                                        <?=$diller['adminpanel-form-text-821']?>
                                                                    </div>
                                                                    <?=$diller['adminpanel-form-text-1396']?>

                                                                    <a href="pages.php?page=users_settings" target="_blank"><?=$diller['adminpanel-form-text-1397']?></a>
                                                                </div>
                                                            </div>
                                                        <?php }?>

                                                        <div class="form-group col-md-12">
                                                            <select name="destek" class="form-control" id="destek">
                                                                <option value="0" <?php if($row['destek'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1345']?></option>
                                                                <option value="1" <?php if($row['destek'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1346']?></option>
                                                                <option value="2" <?php if($row['destek'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1347']?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="destek-choose" <?php if($row['destek'] != '2'  ) { ?>style="display:none"<?php }?>>
                                                        <div class="row" >
                                                            <div class="col-md-12 form-group">
                                                                <label for="destek_sure_2">* <?=$diller['adminpanel-form-text-1089']?></label>
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input type="text" name="destek_sure_2" class="form-control" value="<?=$row['destek_sure_2']?>" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_ends" autocomplete="off" required style="height: 40px">
                                                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                                    </div><!-- input-group -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <script>
                                                            $('#destek').on('change', function() {
                                                                $('#destek-choose').css('display', 'none');
                                                                if ( $(this).val() === '2' ) {
                                                                    $('#destek-choose').css('display', 'block');
                                                                }
                                                            });
                                                        </script>
                                                    <div class="row">
                                                        <div class="form-group col-md-12 mb-0">
                                                            <?php if($uyeayar['destek_alani'] == '1' ) {?>
                                                                <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                            <?php }else { ?>
                                                                <button class="btn  btn-success btn-block " disabled ><?=$diller['adminpanel-form-text-53']?></button>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                            <div class="border shadow-sm">
                                                <form action="post.php?process=users_post&status=group_status_update" method="post" >
                                                    <input type="hidden" name="user_id" value="<?=$row['id']?>">
                                                    <div class="card-body">
                                                        <div class="">
                                                            <h6><?=$diller['adminpanel-form-text-1348']?></h6>
                                                            <div style="margin-bottom: 10px ; color: #999;">
                                                                <?=$diller['adminpanel-form-text-1349']?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <select name="uye_grup_sure_durum" class="form-control" id="uye_grup_sure_durum">
                                                                    <option value="0" <?php if($row['uye_grup_sure_durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1350']?></option>
                                                                    <option value="1" <?php if($row['uye_grup_sure_durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1351']?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div id="grup-choose" <?php if($row['uye_grup_sure_durum'] != '1'  ) { ?>style="display:none"<?php }?>>
                                                            <div class="row" >
                                                                <div class="col-md-12 form-group">
                                                                    <label for="uye_grup_sure_2">* <?=$diller['adminpanel-form-text-1089']?></label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input type="text" name="uye_grup_sure_2" class="form-control" value="<?=$row['uye_grup_sure_2']?>" placeholder="<?php echo $diller['adminpanel-form-text-73'] ?>"  id="date_ends_coupon" autocomplete="off" required style="height: 40px">
                                                                            <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="mdi mdi-calendar"></i></span></div>
                                                                        </div><!-- input-group -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            $('#uye_grup_sure_durum').on('change', function() {
                                                                $('#grup-choose').css('display', 'none');
                                                                if ( $(this).val() === '1' ) {
                                                                    $('#grup-choose').css('display', 'block');
                                                                }
                                                            });
                                                        </script>
                                                        <div class="row">
                                                            <div class="form-group col-md-12 mb-0">
                                                                <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--  <========SON=========>>> Tab Alanı SON !-->

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

