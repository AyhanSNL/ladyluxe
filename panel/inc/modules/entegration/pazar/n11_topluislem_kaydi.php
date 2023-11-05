<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {
    $pazarYeri = $db->prepare("select n11_sablon from pazaryeri where id='1' ");
    $pazarYeri->execute();
    $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
    $anaKategori = $db->prepare("select id,baslik,ust_id from urun_cat where n11_kat_id >'0' and n11_ozellik > '0' and durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
    $anaKategori->execute(array(
        'durum' => '1',
        'dil' => $_SESSION['dil'],
        'ust_id' => '0',
    ));
        ?>
    <?php if($_POST['postID'] == 'new_process'  ) {?>
        <div class="modal-dialog modal-dialog-centered  ">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close"
                     style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  pt-2 pb-0 border-bottom mb-3">
                        <h6><?= $diller['pazaryeri-text-43'] ?></h6>
                    </div>
                    <form action="post.php?process=pazar_post&status=n11_topluislem" method="post" >
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="kat_id" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                    <?=$diller['pazaryeri-text-49']?>
                                    <small class="w-100 text-secondary">
                                        <?=$diller['pazaryeri-text-50']?>
                                    </small>
                                </label>
                                <select name="kat_id" class="form-control selet2" id="kat_id" style="width: 100%; " required >
                                    <option value="">-- <?=$diller['adminpanel-form-text-1632']?></option>
                                    <?php foreach ($anaKategori as $anakatRow) {
                                        $anaKategori_2 = $db->prepare("select id,baslik,ust_id from urun_cat where n11_kat_id >'0' and n11_ozellik > '0' and durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                        $anaKategori_2->execute(array(
                                            'durum' => '1',
                                            'dil' => $_SESSION['dil'],
                                            'ust_id' => $anakatRow['id'],
                                        ));
                                        ?>
                                        <option value="<?=$anakatRow['id']?>" <?php if($row['kat_id'] == $anakatRow['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?></option>
                                        <?php foreach ($anaKategori_2 as $anakatRow2) {
                                            $anaKategori_3 = $db->prepare("select id,baslik,ust_id from urun_cat where n11_kat_id >'0' and n11_ozellik > '0' and durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                            $anaKategori_3->execute(array(
                                                'durum' => '1',
                                                'dil' => $_SESSION['dil'],
                                                'ust_id' => $anakatRow2['id'],
                                            ));
                                            ?>
                                            <option class="asd" value="<?=$anakatRow2['id']?>" <?php if($row['kat_id'] == $anakatRow2['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?></option>
                                            <?php foreach ($anaKategori_3 as $anakatRow3) {
                                                $anaKategori_4 = $db->prepare("select id,baslik,ust_id from urun_cat where n11_kat_id >'0' and n11_ozellik > '0' and durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                $anaKategori_4->execute(array(
                                                    'durum' => '1',
                                                    'dil' => $_SESSION['dil'],
                                                    'ust_id' => $anakatRow3['id'],
                                                ));
                                                ?>
                                                <option value="<?=$anakatRow3['id']?>" <?php if($row['kat_id'] == $anakatRow3['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?></option>
                                                <?php foreach ($anaKategori_4 as $anakatRow4) {
                                                    $anaKategori_5 = $db->prepare("select id,baslik,ust_id from urun_cat where n11_kat_id >'0' and n11_ozellik > '0' and durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                    $anaKategori_5->execute(array(
                                                        'durum' => '1',
                                                        'dil' => $_SESSION['dil'],
                                                        'ust_id' => $anakatRow4['id'],
                                                    ));?>
                                                    <option value="<?=$anakatRow4['id']?>" <?php if($row['kat_id'] == $anakatRow4['id'] ) { ?>selected<?php }?> > <?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?> > <?=$anakatRow4['baslik']?></option>
                                                    <?php foreach ($anaKategori_5 as $anakatRow5) {?>
                                                        <option value="<?=$anakatRow5['id']?>" <?php if($row['kat_id'] == $anakatRow5['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?> > <?=$anakatRow4['baslik']?> > <?=$anakatRow5['baslik']?></option>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="sablon"  class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                    <?=$diller['adminpanel-form-text-2055']?>
                                    <small class="w-100 text-secondary">
                                       <?=$diller['pazaryeri-text-51']?>
                                    </small>
                                </label>
                                <input type="text" autocomplete="off" value="<?=$pazar['n11_sablon']?>" name="sablon" id="sablon" required class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="baslik" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                    <?=$diller['adminpanel-form-text-989']?>
                                </label>
                                <input type="text" name="baslik"  autocomplete="off" id="baslik" required class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="islem" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                    <?=$diller['adminpanel-form-text-1362']?>
                                </label>
                                <select name="islem" class="form-control " id="islem" style="width: 100%; " required >
                                    <option value="import"><?=$diller['pazaryeri-text-46']?></option>
                                </select>
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
                                <label for="urun_durum"><?= $diller['pazaryeri-text-27'] ?></label>
                                <select name="urun_durum" class="form-control" id="urun_durum" required>
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
                               <?= $diller['adminpanel-form-text-53'] ?>
                            </button>
                            <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                                <?= $diller['adminpanel-modal-text-17'] ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    <?php }else { ?>
    Hata
    <?php }?>
        <?php
    }
?>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>
