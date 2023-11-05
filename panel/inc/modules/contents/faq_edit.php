
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from sss where id='$_POST[postID]' ");
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
                    <h4><?=$diller['adminpanel-form-text-1190']?></h4>
                </div>
                <form action="post.php?process=faq_post&status=edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="faq_id" value="<?=$row['id']?>" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="form-group col-md-9 mb-4">
                                    <label  for="durum2" class="w-100"><?=$diller['adminpanel-form-text-62']?></label>
                                    <select name="durum" class="form-control" id="durum2" required>
                                        <option value="0" <?php if($row['durum'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-68']?></option>
                                        <option value="1" <?php if($row['durum'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-67']?></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 mb-4">
                                    <label  for="sira2" class="w-100"><?=$diller['adminpanel-form-text-55']?></label>
                                    <input type="number" name="sira" value="<?=$row['sira']?>" id="sira2" required class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-9">
                                    <label for="soru2">* <?=$diller['adminpanel-form-text-1191']?></label>
                                    <input type="text" autocomplete="off"  name="soru" id="soru2" value="<?=$row['soru']?>" required class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="cevap2">* <?=$diller['adminpanel-form-text-1192']?></label>
                                    <textarea name="cevap" id="cevap2" class="form-control" rows="2" required><?=$row['cevap']?></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputGroupFile01_2"><?=$diller['adminpanel-form-text-98']?> (150x150)  <small>( png,  jpg, jpeg, gif, svg )</small></label>
                                    <div class="w-100 bg-light border p-3">
                                        <div class="mx-auto" style=" text-align: center;">
                                            <?php if($row['gorsel'] == !null ) {?>
                                                <img class="img-fluid p-1 bg-white border" src="<?=$ayar['site_url']?>images/uploads/<?=$row['gorsel']?>" alt=""style="height: 100px; ">
                                                <br>
                                                <a href="" data-href="post.php?process=faq_post&status=img_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger mt-2"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                            <?php }else { ?>
                                                <img src="<?=$ayar['panel_url']?>assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 100px;  " >
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
<script>
    $(document).ready(function() {
        $('.icon_select3').select2();
    });
</script>