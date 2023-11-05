
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from modul_yorum where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);
    $modulBilgi = $db->prepare("select baslik,id,seo_url from blog where id=:id ");
    $modulBilgi->execute(array(
        'id' => $row['icerik_id'],
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
                        <h4><?=$diller['adminpanel-form-text-1112']?></h4>
                    </div>
                    <form action="post.php?process=blog_post&status=blog_comments_edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="comment_id" value="<?=$row['id']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <div class="form-group col-md-12">
                                       <label for="date"><?=$diller['adminpanel-form-text-1109']?></label>
                                       <br>
                                       <a href="<?=$ayar['site_url']?>blog/<?=$modulRow['seo_url']?>/" target="_blank" class="btn btn-light btn-sm border shadow-sm ">
                                           <i class="fa fa-external-link-alt"></i>
                                           <?=$modulRow['baslik']?>
                                       </a>
                                   </div>
                                   <div class="form-group col-md-8 ">
                                       <label  for="durum2" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                       <select name="durum" class="form-control" id="2" required>
                                           <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1101']?></option>
                                           <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1098']?></option>
                                       </select>
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label for="date"><?=$diller['adminpanel-form-text-1081']?></label>
                                       <input type="text" autocomplete="off" value="<?php echo date_tr('j F Y, H:i, l ', ''.$row['tarih'].''); ?>"  name="date" id="date" required class="form-control" readonly>
                                   </div>
                                   <div class="form-group col-md-6">
                                       <label for="isim2"><?=$diller['adminpanel-form-text-1106']?></label>
                                       <input type="text" autocomplete="off" value="<?=$row['isim']?>"  name="isim" id="isim2" required class="form-control">
                                   </div>
                                   <div class="form-group col-md-6">
                                       <label for="eposta2" class="w-100 d-flex align-items-center justify-content-between"><?=$diller['adminpanel-form-text-1107']?> </label>
                                       <input type="email" autocomplete="off"  name="eposta" id="eposta2" value="<?=$row['eposta']?>"   class="form-control">
                                   </div>
                                   <div class="form-group col-md-12">
                                       <label  for="yorum2" class="w-100"><?=$diller['adminpanel-form-text-1113']?> </label>
                                       <textarea name="icerik" id="yorum2" class="form-control" rows="4" ><?=$row['icerik']?></textarea>
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
