<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from urun_yorum where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);
    $modulBilgi = $db->prepare("select baslik,id,seo_url from urun where id=:id ");
    $modulBilgi->execute(array(
        'id' => $row['urun_id'],
    ));
    $modulRow = $modulBilgi->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-1894']?></h4>
                    </div>
                    <form action="post.php?process=catalog_post2&status=comment_edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="comment_id" value="<?=$row['id']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <div class="form-group col-md-12">
                                       <label for="date"><?=$diller['adminpanel-form-text-1081']?></label>
                                       <input type="text" autocomplete="off" value="<?php echo date_tr('j F Y, H:i, l ', ''.$row['tarih'].''); ?>"  name="date" id="date" required class="form-control" readonly>
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label for="date"><?=$diller['adminpanel-text-116']?></label>
                                       <br>
                                       <a href="<?=$ayar['site_url']?><?=$modulRow['seo_url']?>-P<?=$modulRow['id']?>" target="_blank" class="btn btn-light btn-sm border shadow-sm ">
                                           <i class="fa fa-external-link-alt"></i>
                                           <?=$modulRow['baslik']?>
                                       </a>
                                   </div>
                                   <div class="form-group col-md-12 ">
                                       <label  for="durum2" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                       <select name="onay" class="form-control" id="2" required>
                                           <option value="0" <?php if($row['onay'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1101']?></option>
                                           <option value="1" <?php if($row['onay'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1098']?></option>
                                           <option value="2" <?php if($row['onay'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1589']?></option>
                                       </select>
                                   </div>
                               </div>
                               <div class="row">
                                   <div class="form-group col-md-6">
                                       <label for="baslik_2" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1889']?> </label>
                                       <input type="text" autocomplete="off"  name="baslik" id="baslik_2" value="<?=$row['baslik']?>"   class="form-control">
                                   </div>
                                   <div class="form-group col-md-3">
                                       <label for="star_rate2"><?=$diller['adminpanel-form-text-1187']?></label><br>
                                       <input type="hidden"  value="<?=$row['yildiz']?>" name="yildiz" class="rating" data-filled="mdi mdi-star font-20 text-warning" data-empty="mdi mdi-star-outline font-20 text-muted"/>
                                   </div>
                                   <div class="form-group col-md-12 mb-3">
                                       <div class="kustom-checkbox">
                                           <input type="hidden" name="gizli" value="0">
                                           <input type="checkbox" class="individual" id="gizli" name='gizli' value="1" <?php if($row['gizli'] == '1'  ) { ?>checked<?php }?>>
                                           <label for="gizli"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                               <?=$diller['adminpanel-form-text-1895']?>
                                           </label>
                                       </div>
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label  for="yorum2" class="w-100"><?=$diller['adminpanel-form-text-1113']?> </label>
                                       <textarea name="yorum" id="yorum2" class="form-control" rows="2" ><?=$row['yorum']?></textarea>
                                   </div>
                               </div>
                           </div>
                       </div>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button class="btn btn-success btn-block  shadow-sm" name="edit">
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

<script src="plugins/bootstrap-rating/bootstrap-rating.min.js"></script>
<script src="assets/pages/rating-init.js"></script>