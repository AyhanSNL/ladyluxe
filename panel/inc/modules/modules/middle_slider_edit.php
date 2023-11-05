
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from slider2 where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <script src="assets/js/bs4inputfilename.js"></script>
    <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-916']?></h4>
                    </div>
                   <div class="row">
                       <div class="col-md-8">
                           <div class="rounded border shadow-sm">
                               <div class="card-body">
                                   <form action="post.php?process=middle_slider_post&status=update" method="post" enctype="multipart/form-data">
                                       <input type="hidden" name="slider_id" value="<?=$row['id']?>" >
                                       <div class="row">
                                           <div class="form-group col-md-12">
                                               <label  for="durum_edit" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                               <select name="durum" class="form-control" id="durum_edit" required>
                                                   <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                                   <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                               </select>
                                           </div>
                                           <div class="form-group col-md-12">
                                               <label for="baslik_edit">* <?=$diller['adminpanel-form-text-899']?></label>
                                               <input type="text" autocomplete="off"  name="baslik" id="baslik_edit" value="<?=$row['baslik']?>" required class="form-control">
                                           </div>
                                       </div>
                                       <div class="row ">
                                           <div class="form-group col-md-6">
                                               <label for="sira_edit">* <?=$diller['adminpanel-form-text-55']?></label>
                                               <input type="number" autocomplete="off" min="1"  name="sira" id="sira_edit" value="<?=$row['sira']?>" required class="form-control">
                                           </div>
                                           <div class="form-group col-md-6">
                                               <label for="yeni_sekme_edit"><?=$diller['adminpanel-form-text-859']?></label>
                                               <select name="yeni_sekme" class="form-control" id="yeni_sekme_edit" required>
                                                   <option value="0" <?php if($row['yeni_sekme'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-858']?></option>
                                                   <option value="1" <?php if($row['yeni_sekme'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-111']?></option>
                                               </select>
                                           </div>
                                           <div class="form-group col-md-12">
                                               <label for="link_url_edit"><?=$diller['adminpanel-form-text-908']?></label>
                                               <input type="text" autocomplete="off"  name="link_url" id="link_url_edit" placeholder="https://" value="<?=$row['link_url']?>"  class="form-control">
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="form-group col-md-12 mb-0">
                                               <label for="gorsel"><?=$diller['adminpanel-form-text-906']?>  <small>( png,  jpg, jpeg, svg, gif )</small></label>
                                               <div class="w-100 bg-light border p-3">
                                                   <div class="mx-auto" style="width: 100%">
                                                       <img class="img-fluid p-3 bg-white border" src="<?=$ayar['site_url']?>i/uploads/<?=$row['gorsel']?>" alt="">
                                                       <input type="hidden" name="old_img" value="<?=$row['gorsel']?>">
                                                   </div>
                                               </div>

                                               <div class="input-group ">
                                                   <div class="custom-file">
                                                       <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel" >
                                                       <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                                           <button class="btn btn-success btn-block  shadow-sm" name="update">
                                               <?=$diller['adminpanel-form-text-53']?>
                                           </button>
                                       </div>
                                   </form>
                               </div>
                           </div>
                       </div>
                       <div class="col-md-4">
                           <div class="rounded border shadow-sm">
                               <div class="card-body">
                                   <div class="border-bottom pb-2 mb-3" style="font-size: 16px ; font-weight: 500;">
                                       <?=$diller['adminpanel-form-text-917']?>
                                   </div>

                                   <div class="w-100 mb-3  ">
                                       <?php if($row['gorsel_mobil'] == !null  ) {?>
                                           <img src="<?=$ayar['site_url']?>/i/uploads/<?=$row['gorsel_mobil']?>" class="img-fluid" >
                                       <?php }else { ?>
                                        <div class="card border mb-0">
                                            <div class="card-body text-center">
                                                <i class="fa fa-ban"></i>
                                            </div>
                                        </div>
                                       <?php }?>
                                   </div>

                                   <div class="w-100">
                                       <form action="post.php?process=middle_slider_post&status=mobil_gorsel" method="post" enctype="multipart/form-data">
                                           <input type="hidden" name="slider_id" value="<?=$row['id']?>" >
                                           <input type="hidden" name="old_mobil" value="<?=$row['gorsel_mobil']?>" >
                                           <div class="input-group mb-3">
                                               <div class="custom-file">
                                                   <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel_mobil" >
                                                   <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                               </div>
                                           </div>
                                           <button class="btn btn-success btn-block" name="update"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                                           <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                               <small>png,  jpg, jpeg, svg, gif</small>
                                           </div>
                                       </form>
                                   </div>


                               </div>
                           </div>
                       </div>
                       <div class="col-md-12 mt-3">
                           <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border btn-block  ">
                               <?=$diller['adminpanel-modal-text-17']?>
                           </button>
                       </div>
                   </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

<?php }?>
