<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'salecontract';



?>
<title><?=$diller['adminpanel-menu-text-50']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-41']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-48']?></a>
                                <a href="pages.php?page=sale_contract"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-50']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['icerik_yonetim'] == '1' &&  $yetki['sayfa_yonet'] == '1') {

            $sozlesmeSQL = $db->prepare("select * from htmlsayfa_sozlesmeler where dil=:dil and tur=:tur ");
            $sozlesmeSQL->execute(array(
                    'dil' => $_SESSION['dil'],
                'tur' => '1',
            ));
            
          ?>


            <div class="row">

                    <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100 d-flex align-items-center justify-content-between flex-wrap pb-2">
                            <div class="new-buttonu-main-top">
                                <div class="new-buttonu-main-left">
                                    <h5><?=$diller['adminpanel-menu-text-50']?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 p-2">
                            <?php if($sozlesmeSQL->rowCount()<='0'  ) {?>
                            <form method="post" action="post.php?process=contract_post&status=sale_contract_add">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group bg-light col-auto mb-3 pt-3 pb-3 border ">
                                        <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="baslik"><?=$diller['adminpanel-form-text-1019']?></label>
                                    <input type="text" name="baslik" id="baslik" required  class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="icerik"><?=$diller['adminpanel-form-text-1018']?></label>
                                    <textarea name="icerik" id="tiny" class="form-control" rows="3" ></textarea>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                </div>
                            </div>
                            </form>
                            <?php }else { 
                                $row = $sozlesmeSQL->fetch(PDO::FETCH_ASSOC);
                                ?>
                               <form method="post" action="post.php?process=contract_post&status=sale_contract_update">
                                   <input type="hidden" name="page_id" value="<?=$row['id']?>">
                                   <div class="row">
                                       <div class="col-md-12 ">
                                           <div class="form-group bg-light col-auto mb-3 pt-3 pb-3 border ">
                                               <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                   <div class="d-flex align-items-center justify-content-start">
                                                       <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                       <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                       <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                   </div>
                                               </a>
                                           </div>
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="baslik"><?=$diller['adminpanel-form-text-1019']?></label>
                                           <input type="text" name="baslik" id="baslik" required value="<?=$row['baslik']?>"  class="form-control">
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="icerik"><?=$diller['adminpanel-form-text-1018']?></label>
                                           <textarea name="icerik" id="tiny" class="form-control" rows="3" ><?=$row['icerik']?></textarea>
                                       </div>
                                       <div class="col-md-12 text-right">
                                           <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                       </div>
                                   </div>
                               </form>
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
