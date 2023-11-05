<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {
    $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
    $pazarYeri->execute();
    $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);

    $envanterCek = $db->prepare("select * from hb_envanter where id=:id ");
    $envanterCek->execute(array(
        'id' => $_POST['postID']
    ));
    $en = $envanterCek->fetch(PDO::FETCH_ASSOC);

    ?>
        <div class="modal-dialog modal-dialog-centered   ">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close"
                     style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                        <h6><?= $diller['pazaryeri-text-193'] ?></h6>
                    </div>
                    <form action="" method="post" id="commentForm">
                        <input type="hidden" name="inv_id" value="<?=$_POST['postID']?>">
                        <input type="hidden" name="satisa_ac_btn">
                        <input type="hidden" name="merchant" value="process">
                        <div class="row">
                            <div class="form-group col-md-12 ">
                                <div class="w-100 bg-light p-3 border">
                                  <?=$diller['pazaryeri-text-205']?>
                                </div>
                            </div>

                            <div class="form-group col-md-12 ">
                                <label for="hb_sku" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                    <?=$diller['pazaryeri-text-187']?>
                                </label>
                                <input type="text" class="form-control" id="hb_sku" required value="<?=$en['hb_sku']?>"  name="hb_sku">
                            </div>

                            <div class="form-group col-md-12 ">
                                <div class="d-flex">
                                    <input type="hidden" name="satisa_ac_onayla" value="0" >
                                    <input type="checkbox" class="" id="satisa_ac_onayla" name='satisa_ac_onayla' value="1" required >
                                    <label for="satisa_ac_onayla"  class="d-flex ml-2 align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                        <?=$diller['pazaryeri-text-204']?>
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="w-100 pt-2 d-flex justify-content-end">
                            <input type="hidden" name="save">
                            <button id="btnSubmit" class="btn btn-success btn-block  shadow-sm">
                                <?= $diller['pazaryeri-text-193'] ?>
                            </button>
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                                <?= $diller['adminpanel-modal-text-17'] ?>
                            </button>
                        </div>
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

