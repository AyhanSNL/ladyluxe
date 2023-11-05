
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from vitrin_firsat_urunler where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    
    ?>

    <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-997']?></h4>
                    </div>
                    <form action="post.php?process=showcase_post&status=firsat_time" method="post">
                        <input type="hidden" name="firsat_id" value="<?=$row['id']?>" >
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="son_tarih">* <?=$diller['adminpanel-form-text-996']?></label>
                                <div class="position-relative"> 
                                    <div id="focusin" ></div>
                                    <i class="fa fa-calendar-alt position-absolute" style="right: 10px; top:13px"></i>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="son_time">* <?=$diller['adminpanel-form-text-1957']?></label>
                                <input type="text" autocomplete="off"   name="son_time" id="son_time" value="<?=$row['son_time']?>" placeholder="<?=$diller['adminpanel-form-text-1958']?>" required class="form-control">
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
    /* DataPicker */
    $(function(){
        var dateToday = new Date();
        var selectedDate;
        $(document).on("focusin",".datePick", function () {
            $(this).datepicker({
                monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                dateFormat: "yy-mm-dd",
                firstDay:1,
                minDate: dateToday,
            });
        });
        $('#focusin').append('<input class="datePick form-control w-100" name="son_tarih" value="<?=$row['son_tarih']?>"  />');
    });
    /*  <========SON=========>>> DataPicker SON */
</script>