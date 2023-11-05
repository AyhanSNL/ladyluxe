<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'product_import';
$ID = htmlspecialchars($_GET['id']);
$dosyaSql = $db->prepare("select * from urun_import where id=:id ");
$dosyaSql->execute(array(
    'id' => $ID,
));
$row = $dosyaSql->fetch(PDO::FETCH_ASSOC);




?>
<title><?= $diller['adminpanel-form-text-2062'] ?> (XML) - <?= $panelayar['baslik'] ?></title>

<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="page-title-nav">
                                <a href="<?= $ayar['panel_url'] ?>"><i
                                        class="ion ion-md-home"></i> <?= $diller['adminpanel-text-341'] ?></a>
                                <a href="javascript:Void(0)"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-86'] ?></a>
                                <a href="pages.php?page=product_import"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-menu-text-87'] ?> (XML)</a>
                                <a href="javascript:Void(0)"><i
                                        class="fa fa-angle-right"></i> <?= $diller['adminpanel-form-text-2062'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_urun'] == '1') { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3 mb-3">
                            <div>
                                <a href="pages.php?page=product_import" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                    <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                </a>
                            </div>
                            <div class="new-buttonu-main-top">
                                <div class="new-buttonu-main-left">
                                    <h4> <?=$diller['adminpanel-form-text-2062']?> (XML)</h4>
                                </div>
                            </div>
                            <div class="sitemap-div-main p-0">
                                <div class="sitemap-link-main">
                                    <div class="sitemap-link-icon">
                                        <img src="assets/images/icon/href_icon.png">
                                    </div>
                                    <div class="sitemap-link-address">
                                        <a href="<?=$ayar['panel_url'] ?>inc/input/product/<?=$row['dosya']?>" target="_blank">
                                            <?=$ayar['panel_url'] ?>inc/input/product/<?=$row['dosya']?>
                                        </a>
                                    </div>
                                    <a class="sitemap-link-download text-white" style="cursor:pointer;"  data-toggle="collapse" data-target="#updateAcc" aria-expanded="false" aria-controls="collapseForm">
                                        <i class="fas fa-sync"></i> <?= $diller['adminpanel-form-text-2090'] ?>
                                    </a>
                                    <a class="sitemap-link-refresh" href="<?=$ayar['panel_url'] ?>inc/input/product/<?=$row['dosya']?>" target="_blank">
                                        <i class="fas fa-eye"></i> <?= $diller['adminpanel-form-text-2063'] ?>
                                    </a>
                                </div>
                            </div>
                            <div id="accordion" class="accordion">
                                <div class="collapse" id="updateAcc" data-parent="#accordion">
                                    <div class="w-100 border pl-3 pr-3 pt-3  mt-2 rounded">
                                        <form action="post.php?process=product_import_post&status=file_edit" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="file_id" value="<?=$row['id']?>" >
                                            <div class="row ">
                                                <div class="form-group col-md-12 text-center bg-white text-dark mt-n3 mb-3 border-bottom">
                                                    <h5> <?=$diller['adminpanel-form-text-2090']?></h5>
                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-center justify-content-center ">
                                                <div class="form-group col-md-6">
                                                    <label for="upload_type">
                                                        <?=$diller['adminpanel-form-text-2086']?>
                                                    </label>
                                                    <select name="upload_type" class="form-control" id="upload_type" required>
                                                        <option value="">-- <?=$diller['adminpanel-form-text-50']?> --</option>
                                                        <option value="1" <?php if($row['upload_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-2087']?></option>
                                                        <option value="2" <?php if($row['upload_tip'] == '2' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-2088']?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="manuel-upload"  <?php if($row['upload_tip'] != '1' ) { ?> style="display:none" <?php }?>>
                                                <div class="row d-flex align-items-center justify-content-center ">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputGroupFile01">
                                                            * <?=$diller['adminpanel-form-text-2059']?>
                                                        </label>
                                                        <div class="input-group mb-1">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="dosya"  >
                                                                <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-50']?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="url-upload" <?php if($row['upload_tip'] != '2' ) { ?> style="display:none" <?php }?>>
                                                <div class="row d-flex align-items-center justify-content-center ">
                                                    <div class="form-group col-md-6">
                                                        <label for="dosya_url">
                                                            * <?=$diller['adminpanel-form-text-2089']?>
                                                        </label>
                                                        <input type="text" name="dosya_url" autocomplete="off"  id="dosya_url" placeholder="https://"  value="<?=$row['dosya_url']?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#upload_type').on('change', function() {
                                                    $('#manuel-upload').css('display', 'none');
                                                    if ( $(this).val() === '1' ) {
                                                        $('#manuel-upload').css('display', 'block');
                                                    }
                                                    $('#url-upload').css('display', 'none');
                                                    if ( $(this).val() === '2' ) {
                                                        $('#url-upload').css('display', 'block');
                                                    }
                                                });
                                            </script>
                                            <div class="row d-flex align-items-center justify-content-center ">
                                                <div class="col-md-6">
                                                    <div class="w-100 bg-light border border-primary text-primary p-2 rounded mb-3 text-center">
                                                        <?=$diller['adminpanel-form-text-2095']?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row border-top pt-3 bg-light pb-3">
                                                <div class="col-md-12 text-right">
                                                    <button class="btn  btn-success " name="editDo"><?=$diller['adminpanel-form-text-2090']?></button>
                                                    <a class="btn  btn-secondary text-white" data-toggle="collapse" data-target="#updateAcc" aria-expanded="false" aria-controls="collapseForm"><?=$diller['adminpanel-modal-text-17']?></a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-md-12 mb-3">
                        <div class="rounded border border-warning alert-warning text-dark text-center ">
                            <div class="card-body">
                                <?=$diller['adminpanel-form-text-2064']?>
                            </div>
                        </div>
                    </div>
                    <?php if($row['durum'] == '1' ) {?>
                        <div class=" col-md-12 mb-3">
                            <div class="rounded bg-primary text-white   text-center ">
                                <div class="card-body" style="font-size: 18px;">
                                <?=$diller['adminpanel-form-text-2091']?>    
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="new-buttonu-main-top border-bottom border-grey pb-2 mb-3">
                                <div class="new-buttonu-main-left">
                                    <h5><i class="fa fa-code"></i> <?=$diller['adminpanel-form-text-2065']?> </h5>
                                </div>
                            </div>
                            <form action="pages.php?page=product_import_process_step&id=<?=$row['id']?>" method="post">
                                <input type="hidden" name="xml_id" value="<?=$row['id']?>">
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="ana_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2092']?>
                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2105']?>"></i>
                                        </label>
                                        <input type="text" name="ana_etiket" autocomplete="off"  id="ana_etiket" required class="form-control" value="<?=$row['e_ana']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="id_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2093']?>
                                        </label>
                                        <input type="text" name="id_etiket" autocomplete="off"  id="id_etiket" required class="form-control" value="<?=$row['e_id']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="baslik_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2094']?>
                                        </label>
                                        <input type="text" name="baslik_etiket" autocomplete="off"  id="baslik_etiket" required class="form-control" value="<?=$row['e_baslik']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="stok_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2096']?>
                                        </label>
                                        <input type="text" name="stok_etiket" autocomplete="off"  id="stok_etiket" required class="form-control" value="<?=$row['e_stok']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="fiyat_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2097']?>
                                        </label>
                                        <input type="text" name="fiyat_etiket" autocomplete="off"  id="fiyat_etiket" required class="form-control" value="<?=$row['e_fiyat']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="kat_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2098']?>
                                        </label>
                                        <input type="text" name="kat_etiket" autocomplete="off"  id="kat_etiket"  class="form-control" value="<?=$row['e_kat']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="marka_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2099']?>
                                        </label>
                                        <input type="text" name="marka_etiket" autocomplete="off"  id="marka_etiket"  class="form-control" value="<?=$row['e_marka']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="gorsel_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2101']?>
                                        </label>
                                        <input type="text" name="gorsel_etiket" autocomplete="off"  id="gorsel_etiket"  class="form-control" value="<?=$row['e_foto']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="barkod_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2100']?>
                                        </label>
                                        <input type="text" name="barkod_etiket" autocomplete="off"  id="barkod_etiket"  class="form-control" value="<?=$row['e_barkod']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="kod_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2102']?>
                                        </label>
                                        <input type="text" name="kod_etiket" autocomplete="off"  id="kod_etiket"  class="form-control" value="<?=$row['e_kod']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <label for="aciklama_etiket" class="d-flex align-items-center justify-content-start">
                                            <?=$diller['adminpanel-form-text-2103']?>
                                        </label>
                                        <input type="text" name="aciklama_etiket" autocomplete="off"  id="aciklama_etiket"  class="form-control" value="<?=$row['e_spot']?>">
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4 mb-3">
                                        <div class="kustom-checkbox">
                                            <input type="hidden" name="kaydet" value="2">
                                            <input type="checkbox" class="individual" id="kaydet" name='kaydet' value="1" <?php if($row['kaydet'] == '1' ) { ?>checked<?php }?> >
                                            <label for="kaydet"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                <?=$diller['adminpanel-form-text-2130']?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex align-items-center justify-content-center ">
                                    <div class="form-group col-md-4">
                                        <button class="btn btn-success btn-block" name="sync">
                                            <i class="fa fa-sync"></i> <?=$diller['adminpanel-form-text-2071']?>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
        <?php } else { ?>
            <div class="card p-xl-5">
                <h3><?= $diller['adminpanel-text-136'] ?></h3>
                <h6><?= $diller['adminpanel-text-137'] ?></h6>
                <div class="mt-3">
                    <a href="<?= $ayar['panel_url'] ?>"
                       class="btn btn-primary"><?= $diller['adminpanel-text-138'] ?></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    $(function () {
        $('#updateAcc').on('shown.bs.collapse', function (e) {
            $('html,body').animate({
                    scrollTop: $('#updateAcc').offset().top - 80 },
                500);
        });
    });
</script>