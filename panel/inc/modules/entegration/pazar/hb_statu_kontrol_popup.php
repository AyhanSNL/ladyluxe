<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {
    $dtSql = $db->prepare("select * from hb_track ");
    $dtSql->execute();


    $dtSql2 = $db->prepare("select * from hb_track ");
    $dtSql2->execute();
    ?>
    <style>
        .modal-content {

            box-shadow: 0 0 90px rgba(0,0,0,.3) !important;
        }
    </style>
    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close"
                 style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                    <h6><?= $diller['pazaryeri-text-168'] ?></h6>
                </div>
                <form action="post.php?process=hb_post&status=hb_track_control" method="post" id="commentForm">
                <div class="row" style="">
                    <?php if($dtSql->rowCount()>'0'  ) {?>
                        <div class="col-md-12">
                            <div class="bg-light border mb-3 p-3">
                                <?=$diller['pazaryeri-text-176']?>
                            </div>
                        </div>
                        <div class="form-group col-md-12 ">
                            <label for="tarih_sec" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                <?=$diller['adminpanel-form-text-1820']?>
                            </label>
                            <select name="tarih_sec" class="form-control" id="tarih_sec" required>
                                <?php foreach ($dtSql as $dt) {
                                    $originalDate = $dt['tarih'];
                                    $newDate = date("d.m.Y H:i", strtotime($originalDate));
                                    $tarihgetirdim = $newDate;?>
                                    <option value="<?=$dt['id']?>"><?=$tarihgetirdim?> <?=$diller['pazaryeri-text-178']?></option>
                                <?php }?>
                            </select>
                        </div>
                    <?php }else { ?>
                        <div class="form-group col-md-12 ">
                           <?=$diller['pazaryeri-text-182']?>
                        </div>
                    <?php }?>
                </div>
                <div class="w-100 pt-2 d-flex justify-content-end">
                    <input type="hidden" name="save">
                    <?php if($dtSql->rowCount()>'0'  ) {?>
                        <button id="btnSubmit" class="btn btn-success btn-block  shadow-sm">
                            <?= $diller['pazaryeri-text-177'] ?>
                        </button>
                    <?php }?>
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                        <?= $diller['adminpanel-modal-text-17'] ?>
                    </button>
                </div>
                    <?php if($dtSql->rowCount()>'0'  ) {?>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="w-100 rounded bg-primary pt-3 pb-3 pl-1 pr-1">
                                <div class=" col-md-12">
                                    <label  for="box_action" class="w-100 text-white" style="cursor: pointer; margin-bottom: 0 !important; font-weight: 300;"><i class="fa fa-list mr-1"></i> <?=$diller['pazaryeri-text-181']?></label>
                                    <input type="checkbox" style="display: none" id="box_action" name="box_action" value="1"  onclick="actionBox(this.checked);">
                                </div>
                                <div id="actionBox" class="col-md-12 mt-3" style="display:none !important;" >
                                    <div class="border bg-light rounded p-3 up-arrow-2">
                                        <div class="row">
                                            <div class="form-group col-md-12 mb-0">
                                                <?php foreach ($dtSql2 as $dt2) {
                                                    $originalDate = $dt2['tarih'];
                                                    $newDate = date("d.m.Y H:i", strtotime($originalDate));
                                                    ?>
                                                    <div class="mb-1 mt-1 pb-2 pt-2 btn-block border-bottom"><a href="" data-href="post.php?process=hb_post&status=hb_track_delete&id=<?=$dt2['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="text-danger "><i class="fa fa-times mr-2"></i></a><?=$newDate?> <?=$diller['pazaryeri-text-178']?></div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <?php
}
?>
<script>
    $("#btnSubmit").click(function () {
        $(this).text("<?=$diller['adminpanel-text-358']?>");
    });
    $('#commentForm').bind('submit', function (e) {
        var button = $('#btnSubmit');
        button.prop('disabled', true);
        var valid = true;
        if (!valid) {
            e.preventDefault();
            button.prop('disabled', false);
        }
    });
</script>



<script id="rendered-js" >
    function actionBox(selected)
    {
        if (selected)
        {
            document.getElementById("actionBox").style.display = "";
        } else

        {
            document.getElementById("actionBox").style.display = "none";
        }

    }
</script>