<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'intro';

?>
<title><?=$diller['adminpanel-menu-text-61']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=intro"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-61']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['icerik_yonetim'] == '1' && $yetki['galeri'] == '1' ) {

            $introSQL = $db->prepare("select * from tanitim_video_icerik where dil=:dil");
            $introSQL->execute(array(
                    'dil' => $_SESSION['dil']
            ));
            
          ?>


            <div class="row">
                    <?php include 'inc/modules/_helper/contents_leftbar.php'; ?>
                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">
                    <div class="card p-3">
                        <div class="w-100 d-flex align-items-center justify-content-between flex-wrap mb-0 ">
                            <div class="new-buttonu-main-top mb-0">
                                <div class="new-buttonu-main-left">
                                    <h5><i class="fab fa-youtube"></i> <?=$diller['adminpanel-menu-text-61']?></h5>
                                </div>
                                <div class="new-buttonu-main">
                                    <a  class="btn btn-info text-white " href="pages.php?page=theme_intro"><?=$diller['adminpanel-form-text-838']?></a>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded p-3 ml-2 mr-2 mb-3 mt-3" style="font-size: 14px ;">
                            <?=$diller['adminpanel-form-text-1153']?>
                        </div>
                        <div class="w-100 p-2">
                            <?php if($introSQL->rowCount()<='0'  ) {?>
                                <form method="post" action="post.php?process=video_gallery_post&status=intro_add">
                                    <div class="row">
                                        <div class="col-md-12 mb-3 ">
                                            <div class="form-group bg-light col-auto mb-3 pt-3 pb-3 border rounded ">
                                                <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                    <div class="d-flex align-items-center justify-content-start">
                                                        <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                        <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                        <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="ustbaslik"><?=$diller['adminpanel-form-text-1155']?></label>
                                            <input type="text" autocomplete="off"  name="ustbaslik" id="ustbaslik"  value="<?=$row['ustbaslik']?>"  class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="baslik">* <?=$diller['adminpanel-form-text-1154']?></label>
                                            <input type="text" autocomplete="off"  name="baslik" id="baslik"   required  value="<?=$row['baslik']?>" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="video_kod">* <?=$diller['adminpanel-form-text-99']?></label>
                                            <input type="text" autocomplete="off"  name="video_kod" id="video_kod" value="<?=$row['video_kod']?>"  placeholder="<?=$diller['adminpanel-form-text-1150']?> : XULUBZcAU" required class="form-control">
                                        </div>
                                        <div class="col-md-12 text-right mt-3">
                                            <button class="btn  btn-success btn-block " name="insert"><?=$diller['adminpanel-form-text-53']?></button>
                                        </div>
                                    </div>
                                </form>
                            <?php }else { 
                                $row = $introSQL->fetch(PDO::FETCH_ASSOC);
                                ?>
                               <form method="post" action="post.php?process=video_gallery_post&status=intro_edit">
                                   <input type="hidden" name="intro_id" value="<?=$row['id']?>">
                                   <div class="row mb-3">
                                       <div class="col-md-12 ">
                                           <div class="form-group bg-light col-auto mb-3 pt-3 pb-3 border rounded ">
                                               <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                   <div class="d-flex align-items-center justify-content-start">
                                                       <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                       <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                       <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                   </div>
                                               </a>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="form-group col-md-6">
                                           <label for="ustbaslik"><?=$diller['adminpanel-form-text-1155']?></label>
                                           <input type="text" autocomplete="off"  name="ustbaslik" id="ustbaslik"  value="<?=$row['ustbaslik']?>"  class="form-control">
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label for="baslik">* <?=$diller['adminpanel-form-text-1154']?></label>
                                           <input type="text" autocomplete="off"  name="baslik" id="baslik"   required  value="<?=$row['baslik']?>" class="form-control">
                                       </div>
                                       <div class="form-group col-md-12">
                                           <label for="video_kod">* <?=$diller['adminpanel-form-text-99']?></label>
                                           <input type="text" autocomplete="off"  name="video_kod" id="video_kod" value="<?=$row['video_kod']?>"  placeholder="<?=$diller['adminpanel-form-text-1150']?> : XULUBZcAU" required class="form-control">
                                       </div>
                                       <div class="col-md-12 text-right mt-3">
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
