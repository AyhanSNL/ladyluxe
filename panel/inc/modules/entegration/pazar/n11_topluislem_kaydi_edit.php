<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {

    $islemKontrolu = $db->prepare("select * from n11_islem where id=:id ");
    $islemKontrolu->execute(array(
            'id' => $_POST['postID']
    ));
    $row = $islemKontrolu->fetch(PDO::FETCH_ASSOC);

    $pazarYeri = $db->prepare("select n11_sablon from pazaryeri where id='1' ");
    $pazarYeri->execute();
    $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
    $anaKategori = $db->prepare("select id,baslik,ust_id from urun_cat where n11_kat_id >'0' and n11_ozellik > '0' and durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
    $anaKategori->execute(array(
        'durum' => '1',
        'dil' => $_SESSION['dil'],
        'ust_id' => '0',
    ));
    if($islemKontrolu->rowCount()>'0'  ) {
        ?>
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
                    <form action="post.php?process=pazar_post&status=n11_topluislem_edit" method="post" >
                        <input type="hidden" name="process_id" value="<?=$row['id']?>">
                        <div class="row">
                          <?php if($row['durum'] == '1'  ) {?>
                              <div class="col-md-12 form-group">
                                  <div class="w-100 bg-light border rounded p-2">
                                      <?=$diller['pazaryeri-text-52']?>
                                  </div>
                              </div>
                          <?php }?>
                            <div class="col-md-12 form-group">
                                <label for="sablon" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                    <?=$diller['adminpanel-form-text-2055']?>
                                    <small class="w-100 text-secondary">
                                       <?=$diller['pazaryeri-text-51']?>
                                    </small>
                                </label>
                                <input type="text" value="<?=$row['sablon']?>" name="sablon" id="sablon" required class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="baslik" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                    <?=$diller['adminpanel-form-text-989']?>
                                </label>
                                <input type="text" value="<?=$row['baslik']?>" name="baslik" id="baslik" required class="form-control">
                            </div>
                            <div class="form-group col-md-12 ">
                                <label for="ek_oran" class="w-100 d-flex align-items-center justify-content-between flex-wrap">
                                    <?=$diller['pazaryeri-text-24']?>
                                </label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text font-12 font-weight-bold">%</div>
                                    </div>
                                    <input type="number" class="form-control" id="ek_oran" value="<?=$row['oran']?>"  name="ek_oran">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="kargo_sure"><?= $diller['pazaryeri-text-25'] ?></label>
                                <input type="number" name="kargo_sure" id="kargo_sure" value="<?=$row['gun']?>" required class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="urun_durum"><?= $diller['pazaryeri-text-27'] ?></label>
                                <select name="urun_durum" class="form-control" id="urun_durum" required>
                                    <option value="1" <?php if($row['urun_durum'] == '1'  ) { ?>selected<?php }?>><?=$diller['pazaryeri-text-28']?></option>
                                    <option value="2" <?php if($row['urun_durum'] == '2'  ) { ?>selected<?php }?>><?=$diller['pazaryeri-text-29']?></option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="kustom-checkbox">
                                    <input type="hidden" name="yerli" value="0" >
                                    <input type="checkbox" class="individual" id="yerli" name='yerli' value="1" <?php if($row['yerli'] == '1' ) { ?>checked<?php }?> >
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
        <?php
    }else{
        echo 'hata';
    }
}
?>
<script type='text/javascript'>
    $(document).ready(function() {
        $('.selet2').select2();
    });
</script>
