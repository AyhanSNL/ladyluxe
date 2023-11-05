
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from modul_yorum_ayar where id='1' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <style>
        .modal-content{
            border:1px solid #CCC !important;
            box-shadow:0 0 25px rgba(0,0,0,.2);
        }
    </style>
    <script src="assets/js/bs4inputfilename.js"></script>
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-1097']?></h4>
                    </div>
                    <form action="post.php?process=modul_comment_post&status=update" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="cat_id" value="<?=$row['id']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <div class="form-group col-md-6 ">
                                       <label  for="blog_durum" class="w-100"><?=$diller['adminpanel-form-text-1115']?></label>
                                       <select name="blog_durum" class="form-control" id="blog_durum" required>
                                           <option value="0" <?php if($row['blog_durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                           <option value="1" <?php if($row['blog_durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-6 ">
                                       <label  for="hizmet_durum" class="w-100"><?=$diller['adminpanel-form-text-1116']?></label>
                                       <select name="hizmet_durum" class="form-control" id="hizmet_durum" required>
                                           <option value="0" <?php if($row['hizmet_durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                           <option value="1" <?php if($row['hizmet_durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-6 ">
                                       <label  for="oto_onay" class="w-100"><?=$diller['adminpanel-form-text-1118']?></label>
                                       <select name="oto_onay" class="form-control" id="oto_onay" required>
                                           <option value="0" <?php if($row['oto_onay'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                           <option value="1" <?php if($row['oto_onay'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-6">
                                       <label for="yorumlimit">* <?=$diller['adminpanel-form-text-1117']?></label>
                                       <input type="number" autocomplete="off" min="1" value="<?=$row['yorumlimit']?>" name="yorumlimit" id="yorumlimit" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-6">
                                       <label for="tumu_button_bg"><?=$diller['adminpanel-form-text-1119']?></label>
                                       <select name="tumu_button_bg" class="form-control" id="tumu_button_bg" required>
                                           <option value="button-black-white" <?php if($row['tumu_button_bg'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                           <option value="button-white-black" <?php if($row['tumu_button_bg'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                           <option value="button-yellow" <?php if($row['tumu_button_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                           <option value="button-yellow-out" <?php if($row['tumu_button_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                           <option value="button-black" <?php if($row['tumu_button_bg'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                           <option value="button-black-out" <?php if($row['tumu_button_bg'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                           <option value="button-white" <?php if($row['tumu_button_bg'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                           <option value="button-white-out" <?php if($row['tumu_button_bg'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                           <option value="button-gold" <?php if($row['tumu_button_bg'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                           <option value="button-gold-out" <?php if($row['tumu_button_bg'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                           <option value="button-red" <?php if($row['tumu_button_bg'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                           <option value="button-red-out" <?php if($row['tumu_button_bg'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                           <option value="button-blue" <?php if($row['tumu_button_bg'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                           <option value="button-blue-out" <?php if($row['tumu_button_bg'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                           <option value="button-yellow" <?php if($row['tumu_button_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                           <option value="button-yellow-out" <?php if($row['tumu_button_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                           <option value="button-green" <?php if($row['tumu_button_bg'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                           <option value="button-green-out" <?php if($row['tumu_button_bg'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                           <option value="button-grey" <?php if($row['tumu_button_bg'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                           <option value="button-grey-out" <?php if($row['tumu_button_bg'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                           <option value="button-orange" <?php if($row['tumu_button_bg'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                           <option value="button-orange-out" <?php if($row['tumu_button_bg'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                           <option value="button-pink" <?php if($row['tumu_button_bg'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-6">
                                       <label for="gonder_button_bg"><?=$diller['adminpanel-form-text-1120']?></label>
                                       <select name="gonder_button_bg" class="form-control" id="gonder_button_bg" required>
                                           <option value="button-black-white" <?php if($row['gonder_button_bg'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                           <option value="button-white-black" <?php if($row['gonder_button_bg'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                           <option value="button-yellow" <?php if($row['gonder_button_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                           <option value="button-yellow-out" <?php if($row['gonder_button_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                           <option value="button-black" <?php if($row['gonder_button_bg'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                           <option value="button-black-out" <?php if($row['gonder_button_bg'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                           <option value="button-white" <?php if($row['gonder_button_bg'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                           <option value="button-white-out" <?php if($row['gonder_button_bg'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                           <option value="button-gold" <?php if($row['gonder_button_bg'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                           <option value="button-gold-out" <?php if($row['gonder_button_bg'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                           <option value="button-red" <?php if($row['gonder_button_bg'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                           <option value="button-red-out" <?php if($row['gonder_button_bg'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                           <option value="button-blue" <?php if($row['gonder_button_bg'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                           <option value="button-blue-out" <?php if($row['gonder_button_bg'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                           <option value="button-yellow" <?php if($row['gonder_button_bg'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                           <option value="button-yellow-out" <?php if($row['gonder_button_bg'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                           <option value="button-green" <?php if($row['gonder_button_bg'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                           <option value="button-green-out" <?php if($row['gonder_button_bg'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                           <option value="button-grey" <?php if($row['gonder_button_bg'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                           <option value="button-grey-out" <?php if($row['gonder_button_bg'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                           <option value="button-orange" <?php if($row['gonder_button_bg'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                           <option value="button-orange-out" <?php if($row['gonder_button_bg'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                           <option value="button-pink" <?php if($row['gonder_button_bg'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-12 mb-0">
                                       <div class="card border mb-0">
                                           <div class="card-body">
                                               <div class="row">
                                                   <div class="form-group col-md-12">
                                                       <label for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-1121']?> (50x50)  <small>( png,  jpg, jpeg, gif, svg )</small></label>
                                                       <div class="w-100 bg-light border p-3">
                                                           <div class="mx-auto" style=" text-align: center;">
                                                               <?php if($row['gorsel'] == !null ) {?>
                                                                   <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/uploads/<?=$row['gorsel']?>" alt=""style="height: 50px; width: 50px">
                                                                   <br><br>
                                                                   <a href="" data-href="post.php?process=modul_comment_post&status=delete"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                               <?php }else { ?>
                                                                   <img src="assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 50px; " >
                                                               <?php }?>
                                                           </div>
                                                       </div>
                                                       <div class="input-group ">
                                                           <div class="custom-file">
                                                               <input type="hidden" name="old_img" value="<?=$row['gorsel']?>">
                                                               <input type="file" class="custom-file-input" id="inputGroupFile01_2" name="gorsel" >
                                                               <label class="custom-file-label" for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-106']?></label>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button class="btn btn-success btn-block  shadow-sm" name="update">
                                <?=$diller['adminpanel-form-text-53']?>
                            </button>
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                                <?=$diller['adminpanel-modal-text-17']?>
                            </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

<?php }?>
