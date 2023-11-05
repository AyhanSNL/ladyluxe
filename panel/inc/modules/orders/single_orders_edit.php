
<?php if($_POST['postID']  ) {

        $queryControl = $db->prepare("select * from siparis_normal where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);

    if($row['yeni'] != '0' ) {
        $guncelle = $db->prepare("UPDATE siparis_normal SET
           yeni=:yeni
     WHERE id={$_POST['postID']}      
    ");
        $sonuc = $guncelle->execute(array(
            'yeni' => '0',
        ));
    }

    if($row['uye_id'] >'0' ) {
        $uyes = $db->prepare("select * from uyeler where id=:id ");
        $uyes->execute(array(
            'id' => $row['uye_id'],
        ));
        if($uyes->rowCount()>'0'  ) {
            $uyevar = '1';
        }else{
            $uyevar = '0';
        }
    }

    $urunCek = $db->prepare("select id,gorsel,baslik,seo_url,urun_kod from urun where id=:id ");
    $urunCek->execute(array(
        'id' => $row['urun_id'],
    ));
    $urun = $urunCek->fetch(PDO::FETCH_ASSOC);

    $sipDurum = $db->prepare("select * from siparis_durumlar where durum=:durum order by sira asc ");
    $sipDurum->execute(array(
        'durum' => '1',
    ));

    $kargofirma = $db->prepare("select * from kargo_firma where durum=:durum order by sira asc ");
    $kargofirma->execute(array(
        'durum' => '1',
    ));

    ?>

    <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100   pt-2 pb-2 ">
                        <h4>#<?=$row['siparis_no']?> <?=$diller['adminpanel-form-text-1451']?></h4>
                    </div>
                    <form action="post.php?process=order_post&status=op_order_update" method="post" enctype="multipart/form-data" id="orderCancel">
                        <input type="hidden" name="op_id" value="<?=$row['id']?>" >
                       <div class="row">
                           <div class="col-md-12">
                               <div class="row">
                                   <div class="form-group col-md-12">
                                       <div class="border border-grey  rounded p-3">
                                           <div style="font-size: 18px ; font-weight: 600;" class="mb-2">
                                               <?=$diller['adminpanel-form-text-1545']?>
                                           </div>
                                           <div class="d-flex align-items-start justify-content-start flex-wrap border-top border-grey pt-2 ">
                                               <div style="width: 90px">
                                                   <img src="../images/product/<?=$urun['gorsel']?>" style="width: 85%">
                                               </div>
                                               <div class="flex-grow-1">
                                                   <div>
                                                       <h6><?=$urun['baslik']?></h6>
                                                   </div>
                                                   <?php if($urun['urun_kod'] == !null  ) {?>
                                                       <div>
                                                           <?=$diller['adminpanel-form-text-1504']?> : <?=$urun['urun_kod']?>
                                                       </div>
                                                   <?php }?>
                                                   <div class="mt-2">
                                                       <a class="btn btn-sm btn-primary" href="pages.php?page=product_detail&productID=<?=$urun['id']?>" target="_blank">
                                                           <i class="fa fa-edit"></i> <?=$diller['adminpanel-text-115']?>
                                                       </a>
                                                       <a class="btn btn-sm btn-warning" href="<?=$ayar['site_url']?><?=$urun['seo_url']?>-P<?=$urun['id']?>" target="_blank">
                                                           <i class="fa fa-external-link-square-alt"></i> <?=$diller['adminpanel-text-116']?>
                                                       </a>
                                                   </div>

                                               </div>
                                           </div>
                                       </div>
                                   </div>

                                   <!-- Sipariş bilgileri !-->
                                   <div class="col-md-12 mb-3">
                                       <div class="border border-grey rounded pt-3 pl-3 pr-3 pb-0">
                                           <div class="row">
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-text-91']?></label>
                                                   <div class="text">
                                                       #<?=$row['siparis_no']?>
                                                   </div>
                                               </div>
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-1460']?></label>
                                                   <div class="text">
                                                       <?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?>
                                                   </div>
                                               </div>
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-1433']?></label>
                                                   <div class="text">
                                                       <?php if($row['uye_id'] >'0' ) {
                                                           $uyec = $db->prepare("select isim,soyisim,id from uyeler where id=:id ");
                                                           $uyec->execute(array(
                                                               'id' => $row['uye_id'],
                                                           ));
                                                           $u = $uyec->fetch(PDO::FETCH_ASSOC);
                                                           ?>
                                                           <?php if($uyec->rowCount()>'0'  ) {?>
                                                               <a href="pages.php?page=user_detail&userID=<?=$u['id']?>" target="_blank">
                                                                   <i class="fa fa-user"></i> <?=$u['isim']?> <?=$u['soyisim']?>
                                                               </a>
                                                           <?php }else { ?>
                                                               <?=$row['isim']?> <?=$row['soyisim']?>
                                                           <?php }?>
                                                       <?php }else { ?>
                                                           <?=$row['isim']?> <?=$row['soyisim']?>
                                                       <?php }?>
                                                   </div>
                                               </div>
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-83']?></label>
                                                   <div class="text">
                                                      <?=$row['eposta']?>
                                                   </div>
                                               </div>
                                               <div class="col-md-3 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-81']?></label>
                                                   <div class="text">
                                                       <?=$row['telefon']?>
                                                   </div>
                                               </div>
                                               <div class="col-md-9 order-top-form form-group">
                                                   <label class="text-uppercase"><?=$diller['adminpanel-form-text-1326']?></label>
                                                   <div class="text">
                                                       <?=$row['adres']?> /  <?=$diller['adminpanel-form-text-1474']?>: <?=$row['postakodu']?> / <?=$row['sehir']?> /  <?=$row['ulke']?>
                                                   </div>
                                               </div>
                                               <?php if($row['siparis_not'] == !null  ) {?>
                                                   <div class="col-md-12 order-top-form form-group">
                                                       <label class="text-uppercase"><?=$diller['adminpanel-form-text-1475']?></label>
                                                       <div class="text">
                                                           <?=$row['siparis_not']?>
                                                       </div>
                                                   </div>
                                               <?php }?>
                                           </div>
                                       </div>
                                   </div>
                                   <!--  <========SON=========>>> Sipariş bilgileri SON !-->

                                   <!-- Durum Ayarları !-->
                                   <div class="form-group col-md-12">
                                       <div class="border border-grey  rounded p-3">
                                           <div style="font-size: 18px ; font-weight: 600;" class="mb-2">
                                               <?=$diller['adminpanel-form-text-1438']?>
                                           </div>
                                           <div class="">
                                               <div class="form-group mb-1">
                                                   <select name="durum" class="form-control" style="height: 55px; font-size: 14px ; font-weight: 500;">
                                                       <?php foreach ($sipDurum as $s) {?>
                                                           <option value="<?=$s['id']?>" <?php if($s['id'] == $row['durum']  ) { ?>selected<?php }?>><?=$s['baslik']?></option>
                                                       <?php }?>
                                                   </select>
                                               </div>
                                               <?php if($odemeRow['kargo_sistemi'] == '1'  ) {?>
                                               <div class="d-flex align-items-start justify-content-start flex-wrap" >
                                                   <div class="kustom-checkbox mt-3">
                                                       <input type="checkbox"  id="kargo_ver" name="kargo_ver" value="1" <?php if($row['kargo_ver'] == '1' ) { ?>checked<?php }?> onclick="actionBox(this.checked);">
                                                       <label for="kargo_ver"><?=$diller['adminpanel-form-text-1546']?></label>
                                                   </div>
                                                   <div id="actionBox" class="flex-grow-1 " <?php if($row['kargo_ver'] != '1'  ) { ?>style="display:none !important;"<?php }?> >
                                                       <div class="row ml-3 mt-3">
                                                           <div class="col-md-6">
                                                               <label for="kargo_firma"><?=$diller['adminpanel-bildirim-text-21']?></label>
                                                               <select name="kargo_firma" class="form-control" id="kargo_firma">
                                                                   <?php foreach ($kargofirma as $k) {?>
                                                                       <option value="<?=$k['id']?>" <?php if($k['id'] == $row['kargo_firma'] ) { ?>selected<?php }?>><?=$k['baslik']?></option>
                                                                   <?php }?>
                                                               </select>
                                                           </div>
                                                           <div class="col-md-6">
                                                               <label for="kargo_takip"><?=$diller['adminpanel-bildirim-text-22']?></label>
                                                               <input type="text" name="kargo_takip" autocomplete="off" value="<?=$row['kargo_takip']?>" id="kargo_takip" class="form-control">
                                                           </div>
                                                       </div>
                                                   </div>
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
                                               </div>
                                               <?php }?>


                                               <div class="d-flex align-items-center justify-content-start flex-wrap mt-3">
                                                   <div>
                                                       <div class="mb-3" style="font-weight: 500;">
                                                           <i class="fa fa-arrow-down"></i> <?=$diller['adminpanel-form-text-1457']?>
                                                       </div>
                                                       <div class="d-flex align-items-center justify-content-start flex-wrap pb-2">
                                                           <?php if($sms['durum'] =='1' ) {?>
                                                               <div class="kustom-checkbox mr-4">
                                                                   <input type="checkbox"  id="sms_noti" name='sms_noti' value="1">
                                                                   <label for="sms_noti"><?=$diller['adminpanel-form-text-1454']?></label>
                                                               </div>
                                                           <?php }else { ?>
                                                               <div class="kustom-checkbox mr-4">
                                                                   <input type="checkbox"  id="smsDisabled" name='smsDisabled' disabled>
                                                                   <label for="smsDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1454']?></del>
                                                                       </span>
                                                                   </label>
                                                               </div>
                                                           <?php }?>
                                                           <?php if($ayar['smtp_durum'] == '1' ) {?>
                                                               <div class="kustom-checkbox mr-4">
                                                                   <input type="checkbox"  id="email_noti" name='email_noti' value="1">
                                                                   <label for="email_noti"><?=$diller['adminpanel-form-text-1455']?></label>
                                                               </div>
                                                           <?php }else { ?>
                                                               <div class="kustom-checkbox mr-4">
                                                                   <input type="checkbox"  id="emailDisabled" name='emailDisabled' disabled>
                                                                   <label for="emailDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1455']?></del>
                                                                       </span>
                                                                   </label>
                                                               </div>
                                                           <?php }?>
                                                           <?php if($uyevar == '1' && $notiSet['durum'] == '1'  ) {?>
                                                               <div class="kustom-checkbox mr-4">
                                                                   <input type="checkbox"  id="noti" name='noti' value="1">
                                                                   <label for="noti"><?=$diller['adminpanel-form-text-1456']?></label>
                                                               </div>
                                                           <?php }else { ?>
                                                               <div class="kustom-checkbox mr-4">
                                                                   <input type="checkbox"  id="notDisabled" name='notDisabled' value="1" disabled>
                                                                   <label for="notDisabled">
                                                                       <span style="color: #999">
                                                                          <del> <?=$diller['adminpanel-form-text-1456']?></del>
                                                                       </span>
                                                                   </label>
                                                               </div>
                                                           <?php }?>
                                                       </div>
                                                   </div>
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
                            <a  href="print.php?print=op_order&orderID=<?=$row['siparis_no']?>" class="btn btn-dark ml-1  " target="_blank">
                                <i class="fa fa-print"></i> <?=$diller['adminpanel-form-text-1547']?>
                            </a>
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
