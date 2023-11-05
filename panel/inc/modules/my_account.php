<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;

?>
<title><?=$diller['adminpanel-text-9']?> - <?=$panelayar['baslik']?></title>

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
                                <a href="pages.php?page=my_account"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-text-9']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div style="font-size: 20px ; font-weight: 600;" class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                            <?=$diller['adminpanel-text-9']?> <i class="dripicons-wallet " style="font-size: 20px ;"></i>
                        </div>
                        <form method="post" action="post.php?process=other_post&status=account" enctype="multipart/form-data">
                           <div class="row">
                               <div class="col-md-7 ">
                                   <div class="row">
                                       <div class="col-md-12 form-group">
                                           <label for="name">* <?=$diller['adminpanel-form-text-47']?></label>
                                           <input type="text" name="isim" value="<?=$adminRow['isim']?>" id="name" required class="form-control">
                                       </div>
                                       <div class="col-md-12 form-group">
                                           <label for="surname">* <?=$diller['adminpanel-form-text-48']?></label>
                                           <input type="text" name="soyisim" value="<?=$adminRow['soyisim']?>" id="surname" required class="form-control">
                                       </div>
                                       <div class="form-group col-md-6">
                                           <label  for="sound" class="w-100" ><?=$diller['adminpanel-text-111']?></label>
                                           <div class="custom-control custom-switch custom-switch-lg">
                                               <input type="hidden" name="sound" value="0"">
                                               <input type="checkbox" class="custom-control-input" id="sound" name="sound" value="1"  <?php if($adminRow['sound'] == '1'  ) { ?>checked<?php }?> ">
                                               <label class="custom-control-label" for="sound"></label>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-5">
                                   <div class="card border">
                                       <div class="card-body">
                                           <div class="w-100 d-flex align-items-center justify-content-between flex-wrap border-bottom mb-2">
                                               <h6><?=$diller['adminpanel-form-text-49']?></h6>
                                               <small><?=$diller['adminpanel-form-text-51']?></small>
                                           </div>
                                           <div class="w-100 bg-light p-3 text-center mb-3 ">
                                               <?php if($adminRow['foto'] == !null  ) {?>
                                                   <img src="assets/images/uploads/<?=$adminRow['foto']?>" class="rounded-circle" style="width: 128px; height: 128px">
                                                   <br><br>
                                                   <a href="" data-href="post.php?process=other_post&status=ppdelete&no=<?=$adminRow['random_id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                   <input type="hidden" name="old_img" value="<?=$adminRow['foto']?>">
                                               <?php }else { ?>
                                                   <img src="assets/images/users/avatar-1.jpg" class="rounded-circle ">
                                               <?php }?>
                                           </div>
                                           <div class="w-100">
                                               <div class="input-group mb-3">
                                                   <div class="custom-file">
                                                       <input type="file" class="custom-file-input" id="inputGroupFile01" name="foto" >
                                                       <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-50']?></label>
                                                   </div>
                                               </div>
                                               <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                                   <small>png,  jpg, gif, svg</small>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                                <div class="col-md-12">
                                    <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                </div>
                           </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>
