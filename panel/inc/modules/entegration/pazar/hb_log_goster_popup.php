<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {
    $LogSql = $db->prepare("select * from hb_urun_bilgi where id=:id ");
    $LogSql->execute(array(
        'id' => $_POST['postID']
    ));
    $logrow = $LogSql->fetch(PDO::FETCH_ASSOC);
    $logText = $logrow['hb_log'];
    $logText = json_decode($logText);

    ?>

    <div class="modal-dialog modal-dialog-centered  ">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close"
                 style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                    <h6><?= $diller['pazaryeri-text-173'] ?></h6>
                </div>
                <div class="row" style="max-height: 250px; overflow-y: auto; overflow-x: auto">
               <?php
               echo "<pre>";
               print_r($logText);
               echo "</pre>";
               ?>
                </div>
                <div class="w-100 pt-2 d-flex justify-content-end">
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                        <?= $diller['adminpanel-modal-text-17'] ?>
                    </button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    <?php
}
?>


