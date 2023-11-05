<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php if($_POST['postID']  ) {
    $dilselect = $db->prepare("select * from dil where durum='1' order by sira asc ");
    $dilselect->execute();
    $moneytalk = $db->prepare("select * from para_birimleri where durum='1' order by sira asc  ");
    $moneytalk->execute();
    $anaKategori = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
    $anaKategori->execute(array(
        'durum' => '1',
        'dil' => $_SESSION['dil'],
        'ust_id' => '0',
    ));

        $n11Sorgu = $db->prepare("select n11_durum from pazaryeri where id=:id");
    $n11Sorgu->execute(array(
        'id' => '1'
    ));
    $n11Row = $n11Sorgu->fetch(PDO::FETCH_ASSOC);
?>

    <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content" style="box-shadow: 0 0 10px 0 rgba(0,0,0,.3); border:1px solid #ccc">
                <div class="btn btn-light btn-sm close border" data-dismiss="modal" aria-label="Close" style=" background-color: #e4e8ec;font-weight: 400 !important; z-index: 99 !important; width: 40px; font-size: 18px ; position: absolute; margin-top:5px; right: 5px;">
                    <i class="fa fa-times"></i>
                </div>
                <div class="modal-body  pt-1 pl-4 pr-4 pb-4">
                        <?php if($_POST['postID'] == 'xmlAdd'  ) {?>
                            <style>
                                .bootstrap-tagsinput{
                                    width: 100% !important;
                                }
                                .bootstrap-tagsinput input{
                                    width: 100% !important;
                                }
                                .select2-container--default.select2-container .select2-selection--multiple {
                                    border: solid #ced4da 1px;
                                    outline: 0;
                                }
                            </style>
                            <div class="w-100  pt-2 pb-2 border-bottom mb-3">
                                <h4><?=$diller['adminpanel-menu-text-88']?></h4>
                            </div>
                            <form action="post.php?process=product_export_post&status=xml_export" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="baslik"><?=$diller['adminpanel-form-text-2018']?></label>
                                        <input type="text" name="baslik"  id="baslik"autocomplete="off" required class="form-control">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="dil" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2019']?>
                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2020']?>"></i>
                                        </label>
                                        <select name="dil" class="form-control" id="dil" required>
                                            <?php foreach ($dilselect as $dilrow) {?>
                                                <option value="<?=$dilrow['kisa_ad']?>"><?=$dilrow['baslik']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="parabirimi" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2021']?>
                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2022']?>"></i>
                                        </label>
                                        <select name="parabirimi" class="form-control" id="parabirimi" required>
                                            <?php foreach ($moneytalk as $monemyRow) {?>
                                                <option value="<?=$monemyRow['kod']?>"><?=$monemyRow['baslik']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="kar" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2023']?>
                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2024']?>"></i>
                                        </label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text font-12 font-weight-bold">%</div>
                                            </div>
                                            <input type="text" class="form-control" id="kar" autocomplete="off" name="kar" value="0" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="limit_start"><?=$diller['adminpanel-form-text-2025']?></label>
                                        <input type="number" name="limit_start" autocomplete="off" id="limit_start" required min="0" class="form-control" value="0">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="limit_end"><?=$diller['adminpanel-form-text-2026']?></label>
                                        <input type="number" name="limit_end" autocomplete="off" id="limit_end" required class="form-control" value="100">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="ipler"><?=$diller['adminpanel-form-text-2027']?></label>
                                        <br>
                                        <input type="text" name="ipler"  id="tags2" data-role="tagsinput" placeholder="<?=$diller['adminpanel-form-text-2028']?>" class="form-control" style="width: 100% !important;" />
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="kategoriler" class="w-100 d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2029']?>
                                            <i class="ti-help-alt text-primary ml-2" data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2030']?>"></i>
                                        </label>
                                        <select name="kategoriler[]" class="form-control selet2" multiple id="kategoriler" style="width: 100%; font-size: 11px !important ;  "  >
                                            <?php foreach ($anaKategori as $anakatRow) {
                                                $anaKategori_2 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                $anaKategori_2->execute(array(
                                                    'durum' => '1',
                                                    'dil' => $_SESSION['dil'],
                                                    'ust_id' => $anakatRow['id'],
                                                ));
                                                ?>
                                                <option value="<?=$anakatRow['id']?>"><?=$anakatRow['baslik']?></option>
                                                <?php foreach ($anaKategori_2 as $anakatRow2) {
                                                    $anaKategori_3 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                    $anaKategori_3->execute(array(
                                                        'durum' => '1',
                                                        'dil' => $_SESSION['dil'],
                                                        'ust_id' => $anakatRow2['id'],
                                                    ));
                                                    ?>
                                                    <option class="asd" value="<?=$anakatRow2['id']?>" ><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?></option>
                                                    <?php foreach ($anaKategori_3 as $anakatRow3) {
                                                        $anaKategori_4 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                        $anaKategori_4->execute(array(
                                                            'durum' => '1',
                                                            'dil' => $_SESSION['dil'],
                                                            'ust_id' => $anakatRow3['id'],
                                                        ));
                                                        ?>
                                                        <option value="<?=$anakatRow3['id']?>"  > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?></option>
                                                        <?php foreach ($anaKategori_4 as $anakatRow4) {
                                                            $anaKategori_5 = $db->prepare("select id,baslik,ust_id from urun_cat where durum=:durum and dil=:dil and ust_id=:ust_id order by sira asc ");
                                                            $anaKategori_5->execute(array(
                                                                'durum' => '1',
                                                                'dil' => $_SESSION['dil'],
                                                                'ust_id' => $anakatRow4['id'],
                                                            ));?>
                                                            <option value="<?=$anakatRow4['id']?>"  > <?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?> > <?=$anakatRow4['baslik']?></option>
                                                            <?php foreach ($anaKategori_5 as $anakatRow5) {?>
                                                                <option value="<?=$anakatRow5['id']?>" <?php if($row['kategoriler'] == $anakatRow5['id'] ) { ?>selected<?php }?>><?=$anakatRow['baslik']?> > <?=$anakatRow2['baslik']?> > <?=$anakatRow3['baslik']?> > <?=$anakatRow4['baslik']?> > <?=$anakatRow5['baslik']?></option>
                                                            <?php }?>
                                                        <?php }?>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="tur" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2031']?>
                                        </label>
                                        <select name="tur" class="form-control" id="tur" required>
                                            <option value="">-- <?=$diller['adminpanel-form-text-2033']?> --</option>
                                            <option value="standart"><?=$diller['adminpanel-form-text-2032']?></option>
                                            <option value="google">Google Merchant</option>
                                            <option value="akakce">Akakçe</option>
                                            <option value="cimri">Cimri</option>
                                            <option value="pttavm">pttAVM</option>
                                            <option value="hepsiburada">Hepsiburada</option>
                                            <option value="facebook">Facebook</option>
                                        </select>
                                    </div>
                                    <div id="ozel-cikti"  class="col-md-12 mb-2" style="display:none">
                                        <div class="border bg-white rounded pt-3 pl-3 pr-3 pb-0 up-arrow-2-white">
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-0 ">
                                                    <div class="row">
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_id" value="0" >
                                                                <input type="checkbox" class="individual" name="ok_id" checked id="ok_id" value="1">
                                                                <label for="ok_id"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2044']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_baslik" value="0" >
                                                                <input type="checkbox" class="individual" checked  name="ok_baslik" id="ok_baslik" value="1">
                                                                <label for="ok_baslik"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2035']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_gorsel" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_gorsel"  name="ok_gorsel" value="1">
                                                                <label for="ok_gorsel"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2036']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_kat" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_kat" value="1" name="ok_kat">
                                                                <label for="ok_kat"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2037']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_aciklama" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_aciklama" value="1" name="ok_aciklama">
                                                                <label for="ok_aciklama"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2038']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_marka" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_marka" value="1" name="ok_marka">
                                                                <label for="ok_marka"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2039']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_parabirimi" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_parabirimi" value="1" name="ok_parabirimi">
                                                                <label for="ok_parabirimi"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2040']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_eskifiyat" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_eskifiyat" value="1" name="ok_eskifiyat">
                                                                <label for="ok_eskifiyat"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2041']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_fiyat" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_fiyat" value="1" name="ok_fiyat">
                                                                <label for="ok_fiyat"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2042']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_ozelfiyat" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_ozelfiyat" value="1" name="ok_ozelfiyat">
                                                                <label for="ok_ozelfiyat"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2054']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_alisfiyat" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_alisfiyat" value="1"  name="ok_alisfiyat">
                                                                <label for="ok_alisfiyat"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2043']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_stok" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_stok" value="1"  name="ok_stok">
                                                                <label for="ok_stok"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2045']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_stokkod" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_stokkod" value="1" name="ok_stokkod">
                                                                <label for="ok_stokkod"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2046']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_barkod" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_barkod" value="1" name="ok_barkod">
                                                                <label for="ok_barkod"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2047']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_kargodesi" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_kargodesi" value="1" name="ok_kargodesi">
                                                                <label for="ok_kargodesi"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2048']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <div class="kustom-checkbox">
                                                                <input type="hidden" name="ok_kargotutar" value="0" >
                                                                <input type="checkbox" class="individual" checked id="ok_kargotutar" value="1" name="ok_kargotutar">
                                                                <label for="ok_kargotutar"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                    <span class="ml-2" style="font-weight: 200;"><?=$diller['adminpanel-form-text-2049']?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="n11-ozel"  class="col-md-12 mb-2" style="display:none">
                                        <div class="border bg-white rounded pt-3 pl-3 pr-3 pb-0 up-arrow-2-white">
                                            <div class="row">
                                                <div class="form-group col-md-6  ">
                                                    <label for="n11_sablon"><?=$diller['adminpanel-form-text-2055']?></label>
                                                    <input type="text" name="n11_sablon" id="n11_sablon" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $('#tur').on('change', function() {
                                            $('#ozel-cikti').css('display', 'none');
                                            if ( $(this).val() === 'standart' ) {
                                                $('#ozel-cikti').css('display', 'block');
                                            }
                                            $('#n11-ozel').css('display', 'none');
                                            if ( $(this).val() === 'n11' ) {
                                                $('#n11-ozel').css('display', 'block');
                                            }
                                        });
                                    </script>
                                </div>
                                <div class="w-100 pt-2 mt-2 d-flex justify-content-end">
                                    <button class="btn btn-success btn-block  shadow-sm" name="exportDo">
                                        <?=$diller['adminpanel-form-text-53']?>
                                    </button>
                                    <button data-dismiss="modal" aria-label="Close" class="btn btn-light ml-1 border ">
                                        <?=$diller['adminpanel-modal-text-17']?>
                                    </button>
                                </div>
                            </form>
                            <script type='text/javascript'>
                                $(document).ready(function() {
                                    $('.selet2').select2();
                                });
                            </script>
                            <script src='https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js'></script>
                        <?php }?>
                    <?php if($_POST['postID'] == 'xlsAdd'  ) {?>
                        xls
                    <?php } ?>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

<?php }?>

