
<?php if($_POST['postID']  ) {

        $queryControl = $db->prepare("select * from odeme_bildirim where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);
    $banks2 = $db->prepare("select banka_adi,doviz,id,hesap_iban from bankalar where durum=:durum and id=:id order by sira asc ");
    $banks2->execute(array(
        'durum' => '1',
        'id' => $row['banka'],
    ));
    $bank2 = $banks2->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100   pt-2 pb-2 ">
                        <h4><?=$diller['adminpanel-form-text-1594']?></h4>
                    </div>
                    <form action="post.php?process=bank_transfer_post&status=update" method="post" enctype="multipart/form-data" id="orderCancel">
                       <input type="hidden" name="transfer_no" value="<?=$row['id']?>" >
                        <input type="hidden" name="order_no" value="<?=$row['siparis_no']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <!-- Sipariş bilgileri !-->
                                   <div class="col-md-12 mb-3">
                                       <div class="border border-grey rounded pt-3 pl-3 pr-3 pb-0">
                                           <div class="row">
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-text-91']?></label>
                                                   <div class="text">
                                                       <a href="pages.php?page=order_detail&orderID=<?=$row['siparis_no']?>" target="_blank">
                                                           #<?=$row['siparis_no']?>
                                                       </a>
                                                   </div>
                                               </div>
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-1587']?></label>
                                                   <div class="text">
                                                       <?=$row['gonderen']?>
                                                   </div>
                                               </div>
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-1591']?></label>
                                                   <div class="text">
                                                       <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                                   </div>
                                               </div>
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-1592']?></label>
                                                   <div class="text">
                                                       <?php echo number_format($row['odeme_tutar'], 2); ?> <?=$row['parabirimi']?>
                                                   </div>
                                               </div>
                                               <div class="col-md-12 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-1490']?></label>
                                                   <div class="text">
                                                      <?=$row['gonderen_not']?>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="border border-grey rounded pt-3 pl-3 pr-3 pb-0 mt-3">
                                           <div class="row">
                                               <div class="col-md-12 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-1593']?></label>
                                                   <div class="text">
                                                       <?=$bank2['banka_adi']?> <?=$bank2['doviz']?>
                                                       <br>
                                                       <?=$bank2['hesap_iban']?>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <!--  <========SON=========>>> Sipariş bilgileri SON !-->

                                   <!-- Durum Ayarları !-->
                                   <div class="form-group col-md-12">
                                       <div class="border border-grey  rounded p-3">
                                           <div style="font-size: 18px ; font-weight: 600;" class="mb-2">
                                               <?=$diller['adminpanel-form-text-1588']?>
                                               <div style="font-size: 12px; font-weight: 300; color: #999;">
                                                   <?=$diller['adminpanel-form-text-1595']?>
                                               </div>
                                           </div>
                                           <div class="">
                                               <div class="form-group mb-1">
                                                   <select name="durum" class="form-control" style="height: 55px; font-size: 14px ; font-weight: 500;">
                                                       <option value="0" <?php if($row['durum'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1101']?></option>
                                                       <option value="1" <?php if($row['durum'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1098']?></option>
                                                       <option value="2" <?php if($row['durum'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-1589']?></option>
                                                   </select>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <!--  <========SON=========>>> Durum Ayarları SON !-->

                               </div>
                           </div>
                       </div>
                        <input type="hidden" name="update" >
                        <div class="w-100  d-flex justify-content-end">
                            <button id="btnCancelOrder" class="btn btn-success  shadow-sm flex-grow-1" name="update">
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
    $("#btnCancelOrder").click(function () {
        $(this).text("<?=$diller['adminpanel-text-358']?>");
    });
    $('#orderCancel').bind('submit', function (e) {
        var button = $('#btnCancelOrder');
        button.prop('disabled', true);
        var valid = true;
        if (!valid) {
            e.preventDefault();
            button.prop('disabled', false);
        }
    });
</script>
