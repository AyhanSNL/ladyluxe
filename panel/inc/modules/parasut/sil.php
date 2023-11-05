
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from parasut_fatura where fatura_id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);
    $sayimiz = $queryControl->rowCount();
    ?>

    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                    <h4><?=$diller['adminpanel-form-text-821']?></h4>
                </div>
                <?php if($sayimiz >'0'  ) {?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="fatura_id" value="<?=$row['fatura_id']?>" >
                        <input type="hidden" name="siparis_id" value="<?=$row['siparis_no']?>" >
                        <input type="hidden" name="request" value="sil" >
                        <div class="w-100 pt-2 pb-2  rounded mb-3 ">
                            <div style="font-size: 16px ; font-weight: 600; margin-bottom: 20px;">
                                <?=$diller['parasut-text-36']?>
                            </div>
                            <?=$diller['parasut-text-34']?>
                        </div>
                        <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                            <button class="btn btn-danger btn-block  shadow-sm" name="update">
                                <?=$diller['adminpanel-modal-text-11']?>
                            </button>
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                                <?=$diller['adminpanel-modal-text-17']?>
                            </button>
                        </div>
                    </form>
                <?php }else { ?>
                    <div class="w-100 alert alert-warning border border-warning text-dark mb-0 text-center" style="font-weight: 600;">
                        Hatalı işlem!
                    </div>
                <?php }?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

<?php }?>
