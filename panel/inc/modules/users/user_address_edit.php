<?php if($_POST['postID']  ) {

    $queryControl = $db->prepare("select * from uyeler_adres where id='$_POST[postID]' ");
    $queryControl->execute();
    $row = $queryControl->fetch(PDO::FETCH_ASSOC);


    $ulke = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
    $ulke->execute(array(
        '3_iso' => $row['ulke'],
    ));
    $ulk = $ulke->fetch(PDO::FETCH_ASSOC);


    $ulke2 = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
    $ulke2->execute(array(
        '3_iso' => $row['fatura_ulke'],
    ));
    $ulk2 = $ulke2->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                    <div class="w-100  border-bottom  pt-2 pb-2 mb-3">
                        <h4><?=$diller['adminpanel-form-text-1279']?></h4>
                        <div class="bg-light p-1">
                          <i class="fa fa-info-circle"></i>  <?=$diller['adminpanel-form-text-1333']?>
                        </div>
                    </div>
                        <div class="row ">


                            <div <?php if($odemeRow['faturasiz_teslimat'] == '0'   ) { ?>class="col-md-6"<?php }else{?>class="col-md-12"<?php } ?>>
                                <div class="card border">
                                    <div class="card-body">
                                        <h6><?=$diller['adminpanel-form-text-1324']?></h6>
                                        <div class="row border-top pt-3 ">
                                            <div class="col-md-12 form-group">
                                                <label for="baslik" ><?=$diller['adminpanel-form-text-1323']?></label>
                                                <input type="text"  value="<?=$row['baslik']?>" id="baslik" class="form-control" >
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="isimsoyisim" ><?=$diller['adminpanel-text-92']?></label>
                                                <input type="text"  value="<?=$row['isim']?> <?=$row['soyisim']?>" id="isimsoyisim" class="form-control" >
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="eposta" ><?=$diller['adminpanel-form-text-83']?></label>
                                                <input type="text"  value="<?=$row['eposta']?>" id="eposta" class="form-control" >
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="telefon" ><?=$diller['adminpanel-form-text-81']?></label>
                                                <input type="text"  value="<?=$row['alan_kodu']?> <?=$row['telefon']?>" id="telefon" class="form-control" >
                                            </div>
                                            <?php if($odemeRow['faturasiz_teslimat'] == '1') {?>
                                                <div class="col-md-12 form-group">
                                                    <label for="tc" ><?=$diller['adminpanel-form-text-1316']?></label>
                                                    <input type="text"  value="<?=$row['tc']?>" id="tc" class="form-control" >
                                                </div>
                                            <?php }?>
                                            <div class="col-md-12 form-group">
                                                <label for="ulke" ><?=$diller['adminpanel-form-text-718']?></label>
                                                <input type="text"  value="<?=$ulk['baslik']?>" id="ulke" class="form-control" >
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="ilce_sehir" ><?=$diller['adminpanel-form-text-1325']?></label>
                                                <input type="text"  value="<?=$row['ilce']?> / <?=$row['sehir']?> / <?=$row['postakodu']?>" id="ilce_sehir" class="form-control" >
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="adres" ><?=$diller['adminpanel-form-text-1326']?></label>
                                                <textarea name="adres" id="adres" class="form-control" rows="3"><?=$row['adresbilgisi']?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($odemeRow['faturasiz_teslimat'] == '0' ) {?>
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6><?=$diller['adminpanel-form-text-1327']?></h6>
                                        <div class="row border-top pt-3 ">
                                            <?php if($row['fatura_turu'] == '1' ) {?>
                                                <div class="col-md-12 form-group">
                                                    <label for="fatura" ><?=$diller['adminpanel-form-text-1328']?></label>
                                                    <input type="text"  value="<?=$diller['adminpanel-form-text-1320']?>" id="fatura" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="fatura_tc" ><?=$diller['adminpanel-form-text-1316']?></label>
                                                    <input type="text"  value="<?=$row['fatura_tc']?>" id="fatura_tc" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="ulke2" ><?=$diller['adminpanel-form-text-718']?></label>
                                                    <input type="text"  value="<?=$ulk2['baslik']?>" id="ulke2" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="ilce_sehir2" ><?=$diller['adminpanel-form-text-1325']?></label>
                                                    <input type="text"  value="<?=$row['fatura_ilce']?> / <?=$row['fatura_sehir']?> / <?=$row['fatura_postakodu']?>" id="ilce_sehir2" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="adres2" ><?=$diller['adminpanel-form-text-1326']?></label>
                                                    <textarea name="adres" id="adres2" class="form-control" rows="3"><?=$row['fatura_adresi']?></textarea>
                                                </div>
                                            <?php }else { ?>
                                                <div class="col-md-12 form-group">
                                                    <label for="fatura" ><?=$diller['adminpanel-form-text-1328']?></label>
                                                    <input type="text"  value="<?=$diller['adminpanel-form-text-1321']?>" id="fatura" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="unvan" ><?=$diller['adminpanel-form-text-1329']?></label>
                                                    <input type="text"  value="<?=$row['fatura_firma_unvan']?>" id="unvan" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="fatura_vergi_dairesi" ><?=$diller['adminpanel-form-text-1331']?></label>
                                                    <input type="text"  value="<?=$row['fatura_vergi_dairesi']?>" id="fatura_vergi_dairesi" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="fatura_vergi_no" ><?=$diller['adminpanel-form-text-1332']?></label>
                                                    <input type="text"  value="<?=$row['fatura_vergi_no']?>" id="fatura_vergi_no" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="ulke2" ><?=$diller['adminpanel-form-text-718']?></label>
                                                    <input type="text"  value="<?=$ulk2['baslik']?>" id="ulke2" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="ilce_sehir2" ><?=$diller['adminpanel-form-text-1325']?></label>
                                                    <input type="text"  value="<?=$row['fatura_ilce']?> / <?=$row['fatura_sehir']?> / <?=$row['fatura_postakodu']?>" id="ilce_sehir2" class="form-control" >
                                                </div>
                                                <div class="col-md-12 form-group">
                                                    <label for="adres2" ><?=$diller['adminpanel-form-text-1326']?></label>
                                                    <textarea name="adres" id="adres2" class="form-control" rows="3"><?=$row['fatura_adresi']?></textarea>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="col-md-12">
                                <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border btn-block ">
                                    <?=$diller['adminpanel-modal-text-17']?>
                                </button>
                            </div>
                        </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

<?php }?>

