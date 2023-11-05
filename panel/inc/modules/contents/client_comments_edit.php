
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from yorum where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>
    <script src="assets/js/bs4inputfilename.js"></script>
    <style>
        .modal-content{
            border:1px solid #CCC !important;
            box-shadow:0 0 25px rgba(0,0,0,.2);
        }
    </style>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                    <h4><?=$diller['adminpanel-form-text-1184']?></h4>
                </div>
                <form action="post.php?process=client_comments_post&status=edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="comment_id" value="<?=$row['id']?>" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="form-group col-md-12 mb-4">
                                    <label  for="durum2" class="w-100" ><?=$diller['adminpanel-form-text-843']?></label>
                                    <div class="custom-control custom-switch custom-switch-lg">
                                        <input type="hidden" name="durum" value="0"">
                                        <input type="checkbox" class="custom-control-input" id="durum2" name="durum" value="1"  <?php if($row['durum'] == '1' ) { ?>checked<?php }?> >
                                        <label class="custom-control-label" for="durum2"></label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="sir2a">* <?=$diller['adminpanel-form-text-55']?></label>
                                    <input type="number" autocomplete="off" min="1"  name="sira" value="<?=$row['sira']?>" id="sir2a"  required class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="isim2">* <?=$diller['adminpanel-form-text-1185']?></label>
                                    <input type="text" autocomplete="off"  name="isim" id="isim2" value="<?=$row['isim']?>" required class="form-control">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="pozisyon2"><?=$diller['adminpanel-form-text-1188']?></label>
                                    <input type="text" autocomplete="off" value="<?=$row['pozisyon']?>" name="pozisyon" id="pozisyon2"  class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="icerik2">* <?=$diller['adminpanel-form-text-1113']?></label>
                                    <textarea name="icerik" id="icerik2" class="form-control" rows="2" required><?=$row['icerik']?></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="star_rate2"><?=$diller['adminpanel-form-text-1187']?></label><br>
                                    <input type="hidden"  value="<?=$row['star_rate']?>" name="star_rate" class="rating" data-filled="mdi mdi-star font-20 text-warning" data-empty="mdi mdi-star-outline font-20 text-muted"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-1186']?> (135x135)  <small>( png,  jpg, jpeg, gif, svg )</small></label>
                                    <div class="w-100 bg-light border p-3">
                                        <div class="mx-auto" style=" text-align: center;">
                                            <?php if($row['gorsel'] != 'no-image' ) {?>
                                                <input type="hidden" name="old_img" value="<?=$row['gorsel']?>">
                                                <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/comments/<?=$row['gorsel']?>" alt=""style="height: 100px; border-radius: 100px">
                                                <br>
                                                <a href="" data-href="post.php?process=client_comments_post&status=img_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger mt-2"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                            <?php }else { ?>
                                                <img src="../images/comments/def_com.jpg" class="img-fluid border p-1" style=" height: 100px; border-radius: 100px " >
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
<script src="plugins/bootstrap-rating/bootstrap-rating.min.js"></script>
<script src="assets/pages/rating-init.js"></script>