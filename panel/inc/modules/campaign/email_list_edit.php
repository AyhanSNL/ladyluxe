
<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from ebulten where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
            <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                    <h4><?=$diller['adminpanel-form-text-1236']?></h4>
                </div>
                <form action="post.php?process=email_list_post&status=account_edit" method="post"  >
                    <input type="hidden" name="mail_id" value="<?=$row['id']?>" >
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="eposta2">* <?=$diller['adminpanel-form-text-83']?></label>
                            <input type="text" autocomplete="off"  name="eposta" id="eposta2" value="<?=$row['eposta']?>" required class="form-control">
                        </div>
                    </div>
                    <div class="w-100 pt-2  d-flex justify-content-end">
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
                });
            });
            $('#focusin').append('<input class="datePick form-control w-100" name="baslangic" autocomplete="off" value="<?=$row['baslangic']?>"  />');
        });
        $(function(){
            var dateToday = new Date();
            var selectedDate;
            $(document).on("focusin2",".datePick", function () {
                $(this).datepicker({
                    monthNames: [ "<?=$diller['tarih-text8']?>", "<?=$diller['tarih-text9']?>", "<?=$diller['tarih-text10']?>", "<?=$diller['tarih-text11']?>", "<?=$diller['tarih-text12']?>", "<?=$diller['tarih-text13']?>", "<?=$diller['tarih-text14']?>", "<?=$diller['tarih-text15']?>", "<?=$diller['tarih-text16']?>", "<?=$diller['tarih-text17']?>", "<?=$diller['tarih-text18']?>", "<?=$diller['tarih-text19']?>" ],
                    dayNamesMin: [ "<?=$diller['tarih-text-20']?>", "<?=$diller['tarih-text-21']?>", "<?=$diller['tarih-text-22']?>", "<?=$diller['tarih-text-23']?>", "<?=$diller['tarih-text-24']?>", "<?=$diller['tarih-text-25']?>", "<?=$diller['tarih-text-26']?>" ],
                    dateFormat: "yy-mm-dd",
                    firstDay:1,
                });
            });
            $('#focusin2').append('<input class="datePick form-control w-100" name="bitis" autocomplete="off" value="<?=$row['bitis']?>"  />');
        });
        /*  <========SON=========>>> DataPicker SON */
    </script>
<?php }?>

<script>
    $(document).ready(function() {
        $('.user_select_form_add2').select2({
            maximumSelectionLength: 6,
            <?php if($row['uye_id'] >'0'  ) {?>
            placeholder: ' <?=$diller['adminpanel-form-text-1224']?>',
            <?php }else { ?>
            placeholder: ' <?=$diller['adminpanel-form-text-1221']?>',
            <?php }?>
            ajax: {
                url: 'masterpiece.php?page=user_select',
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        q: data.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }

        });
    });
</script>
