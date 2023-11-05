<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {
        ?>
        <div class="modal-dialog modal-dialog-centered  ">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close"
                     style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                        <h6><?= $diller['pazaryeri-text-104'] ?>(Trendyol)</h6>
                    </div>
                    <div class="w-100 bg-light mb-3 border p-3 rounded">
                        <ul style=" margin-bottom: 0; margin-left: 0px;
                        padding-left: 15px;
                         ">
                           <?=$diller['pazaryeri-text-108']?>
                        </ul>
                    </div>
                    <form action="post.php?process=ty_post&status=ty_urun_cek" method="post" id="commentForm">
                        <input type="hidden" name="cek" value="1">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="cek_limit" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                    <?=$diller['pazaryeri-text-109']?> (Min : 1 - Max : 100)
                                </label>
                                <input type="number" min="1" max="100" class="form-control" id="cek_limit" value="1"  name="cek_limit">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="cek_start">* <?=$diller['pazaryeri-text-111']?></label>
                                <div class="position-relative">
                                    <div id="focusin" ></div>
                                    <i class="fa fa-calendar-alt position-absolute" style="right: 10px; top:13px"></i>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="cek_end">* <?=$diller['pazaryeri-text-112']?></label>
                                <div class="position-relative">
                                    <div id="focusin_2" ></div>
                                    <i class="fa fa-calendar-alt position-absolute" style="right: 10px; top:13px"></i>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="kustom-checkbox">
                                    <input type="hidden" name="cek_kat" value="0" >
                                    <input type="checkbox" class="individual" id="cek_kat" name='cek_kat' value="1" onclick="actionBox(this.checked);">
                                    <label for="cek_kat"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                        <?=$diller['pazaryeri-text-110']?>
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
<script>
    /* DataPicker */
    $(function(){
        var dateToday = new Date();
        var selectedDate;
        $(document).on("focusin",".datePick", function () {
            $(this).datepicker({
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                dateFormat: "dd-mm-yy",
                firstDay:1,
            });
        });
        $('#focusin').append('<input class="datePick form-control w-100"  autocomplete="off" name="cek_start" value="<?=$row['cek_start']?>"  />');
    });
    /*  <========SON=========>>> DataPicker SON */

    /* DataPicker */
    $(function(){
        var dateToday = new Date();
        var selectedDate;
        $(document).on("focusin_2",".datePick", function () {
            $(this).datepicker({
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                dateFormat: "dd-mm-yy",
                firstDay:1,
            });
        });
        $('#focusin_2').append('<input class="datePick form-control w-100"  autocomplete="off" name="cek_end" value="<?=$row['cek_start']?>"  />');
    });
    /*  <========SON=========>>> DataPicker SON */
</script>

