<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {
    $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
    $pazarYeri->execute();
    $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
    $urunSorgu = $db->prepare("select * from urun where id=:id ");
    $urunSorgu->execute(array(
        'id' => $_POST['postID']
    ));

    if($urunSorgu->rowCount()>0  ) {
        ?>

        <div class="modal-dialog modal-dialog-centered  ">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close"
                     style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                        <h6><?= $diller['pazaryeri-text-19'] ?></h6>
                    </div>
                    <form action="post.php?process=pazar_post&status=n11_aktarim" method="post" id="commentForm">
                        <input type="hidden" name="product_id" value="<?= $_POST['postID'] ?>">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="sablon"><?= $diller['adminpanel-form-text-2055'] ?></label>
                                <input type="text" name="sablon" id="sablon" value="<?=$pazar['n11_sablon']?>" required class="form-control">
                            </div>
                            <div class="form-group col-md-12 ">
                                <label for="ek_oran" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                    <?=$diller['pazaryeri-text-24']?>
                                </label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-12 font-weight-bold">%</div>
                                    </div>
                                    <input type="number" class="form-control" id="ek_oran" value="0"  name="ek_oran">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="kargo_sure"><?= $diller['pazaryeri-text-25'] ?></label>
                                <input type="number" name="kargo_sure" id="kargo_sure" value="3" required class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="durumu"><?= $diller['pazaryeri-text-27'] ?></label>
                                <select name="durumu" class="form-control" id="durumu" required>
                                    <option value="1" selected><?=$diller['pazaryeri-text-28']?></option>
                                    <option value="2"><?=$diller['pazaryeri-text-29']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="kustom-checkbox">
                                    <input type="hidden" name="yerli" value="0" >
                                    <input type="checkbox" class="individual" id="yerli" name='yerli' value="1" >
                                    <label for="yerli"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                        <?=$diller['pazaryeri-text-23']?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 pt-2 d-flex justify-content-end">
                            <input type="hidden" name="save">
                            <button id="btnSubmit" class="btn btn-success btn-block  shadow-sm">
                               <i class="fa fa-play"></i> <?= $diller['pazaryeri-text-26'] ?>
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
    }}
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

