<?php
$currentURL = $ayar['panel_url'] . 'pages.php?' . $_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
error_reporting(0);
$currentMenu = 'product_import';
$id = htmlspecialchars($_GET['id']);
$Sorgula = $db->prepare("select * from urun_import where id=:id ");
$Sorgula->execute(array(
    'id' => $id
));
$row = $Sorgula->fetch(PDO::FETCH_ASSOC);
$xml_file = simplexml_load_file("inc/input/product/$row[dosya]");
if($Sorgula->rowCount()<='0'  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}
?>
<title><?= $diller['adminpanel-form-text-2065'] ?> (XML) - <?= $panelayar['baslik'] ?></title>

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
                                <a href="pages.php?page=product_import_process&id=<?=$_GET['id']?>"><i
                                            class="fa fa-angle-right"></i> <?= $diller['adminpanel-form-text-2062'] ?></a>
                                <a href="javascript:Void(0)"><i
                                            class="fa fa-angle-right"></i> <?= $diller['adminpanel-form-text-2065'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if ($yetki['entegrasyon'] == '1' && $yetki['entegrasyon_urun'] == '1') { ?>
            <?php
            if(!$xml_file) { ?>
                <div class="card p-xl-5">
                    <h3><?= $diller['adminpanel-text-136'] ?></h3>
                    <h6><?= $diller['adminpanel-form-text-2076'] ?></h6>
                    <div class="mt-3">
                        <a href="pages.php?page=product_import_process&id=<?=$_GET['id']?>"
                           class="btn btn-primary"><?= $diller['adminpanel-text-138'] ?></a>
                    </div>
                </div>
            <?php }else{?>
                <?php if($_POST && isset($_POST['sync'])  ) {
                    if($_POST['ana_etiket'] && $_POST['id_etiket'] && $_POST['baslik_etiket'] && $_POST['stok_etiket'] && $_POST['fiyat_etiket']) {
                        $anaTag = $_POST['ana_etiket'];
                        $idTag = $_POST['id_etiket'];
                        $baslikTag = $_POST['baslik_etiket'];
                        $stokTag = $_POST['stok_etiket'];
                        $fiyatTag = $_POST['fiyat_etiket'];
                        $katTag = $_POST['kat_etiket'];
                        $markaTag = $_POST['marka_etiket'];
                        $gorselTag = $_POST['gorsel_etiket'];
                        $barkodTag = $_POST['barkod_etiket'];
                        $stokkodTag = $_POST['kod_etiket'];
                        $aciklamaTag = $_POST['aciklama_etiket'];
                        if(isset($xml_file->$anaTag)) {
                            if(isset($xml_file->$anaTag->$idTag)  )
                            {
                                if(isset($xml_file->$anaTag->$baslikTag)  )
                                {
                                    if(isset($xml_file->$anaTag->$stokTag)  )
                                    {
                                        if(isset($xml_file->$anaTag->$fiyatTag)  )
                                        {
                                            if($_POST['kaydet']  ) {
                                                if($_POST['kaydet'] == '1') {
                                                    $guncelle = $db->prepare("UPDATE urun_import SET
                                                             kaydet=:kaydet,   
                                                             e_ana=:e_ana,
                                                             e_id=:e_id,
                                                             e_baslik=:e_baslik,
                                                             e_stok=:e_stok,
                                                             e_fiyat=:e_fiyat,
                                                             e_kat=:e_kat,
                                                             e_marka=:e_marka,
                                                             e_foto=:e_foto,
                                                             e_barkod=:e_barkod,
                                                             e_kod=:e_kod,
                                                             e_spot=:e_spot
                                                         WHERE id={$id}      
                                                        ");
                                                    $guncelle->execute(array(
                                                            'kaydet' => '1',
                                                            'e_ana' => $anaTag,
                                                            'e_id' => $idTag,
                                                        'e_baslik' => $baslikTag,
                                                        'e_stok' => $stokTag,
                                                        'e_fiyat' => $fiyatTag,
                                                        'e_kat' => $katTag,
                                                        'e_marka' => $markaTag,
                                                        'e_foto' => $gorselTag,
                                                        'e_barkod' => $barkodTag,
                                                        'e_kod' => $stokkodTag,
                                                        'e_spot' => $aciklamaTag
                                                    ));
                                                }
                                                if($_POST['kaydet'] == '2') {
                                                    $guncelle = $db->prepare("UPDATE urun_import SET
                                                             kaydet=:kaydet,   
                                                             e_ana=:e_ana,
                                                             e_id=:e_id,
                                                             e_baslik=:e_baslik,
                                                             e_stok=:e_stok,
                                                             e_fiyat=:e_fiyat,
                                                             e_kat=:e_kat,
                                                             e_marka=:e_marka,
                                                             e_foto=:e_foto,
                                                             e_barkod=:e_barkod,
                                                             e_kod=:e_kod,
                                                             e_spot=:e_spot
                                                         WHERE id={$id}      
                                                        ");
                                                    $guncelle->execute(array(
                                                        'kaydet' => '0',
                                                        'e_ana' => null,
                                                        'e_id' => null,
                                                        'e_baslik' => null,
                                                        'e_stok' => null,
                                                        'e_fiyat' => null,
                                                        'e_kat' => null,
                                                        'e_marka' => null,
                                                        'e_foto' => null,
                                                        'e_barkod' => null,
                                                        'e_kod' => null,
                                                        'e_spot' => null
                                                    ));
                                                }
                                            }
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card p-3">
                                                        <div>
                                                            <a href="pages.php?page=product_import_process&id=<?=$_GET['id']?>" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                                                <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                                            </a>
                                                        </div>
                                                        <div class="new-buttonu-main-top ">
                                                            <div class="new-buttonu-main-left">
                                                                <h5><?=$diller['adminpanel-form-text-2072']?> </h5>
                                                            </div>
                                                        </div>
                                                        <div class="w-100 bg-primary  bordbg-primary rounded p-3 mb-3 text-white" style="font-size: 16px ;">
                                                            <?=$diller['adminpanel-form-text-2073']?> : <?=count($xml_file)?>
                                                        </div>
                                                        <form action="post.php?process=product_laststep_post&status=import" method="post">
                                                            <div class="w-100 border bg-light  rounded pt-3 pl-3 pr-3 mb-3" >
                                                                <div class="w-100 " style="font-size: 16px ; font-weight: 500;">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    <?=$diller['adminpanel-form-text-2106']?>
                                                                </div>
                                                                <div class="row border-top mt-3 pt-3 bg-white">
                                                                    <div class="form-group col-auto mb-3  ">
                                                                        <a class=" p-2 border d-inline-block bg-white rounded pl-3 pr-3  ">
                                                                            <div class="d-flex align-items-center justify-content-start">
                                                                                <div class="mr-2 flag-icon-<?=$mevcutdil['flag']?>" style="width:18px; height:13px; display: inline-block; vertical-align: middle"></div>
                                                                                <?=$mevcutdil['baslik']?> <?=$diller['adminpanel-form-text-259']?>
                                                                                <i class="ti-help-alt text-danger ml-2 " style="cursor: pointer" data-container="body" data-toggle="popover" data-placement="right" data-content="<?=$diller['adminpanel-form-text-722']?>"></i>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="row border-top pt-3 bg-white">
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="pasif" value="0">
                                                                            <input type="checkbox" class="individual" id="pasif" name='pasif' value="1" >
                                                                            <label for="pasif"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                               <?=$diller['adminpanel-form-text-2112']?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="gorunmez" value="0">
                                                                            <input type="checkbox" class="individual" id="gorunmez" name='gorunmez' value="1" >
                                                                            <label for="gorunmez"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2113']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2108']?>"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row border-top pt-3 bg-white">
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="kat_ayar" value="0">
                                                                            <input type="checkbox" class="individual" id="katayar" name='kat_ayar' value="1" >
                                                                            <label for="katayar"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2114']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2109']?>"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="marka_ayar" value="0">
                                                                            <input type="checkbox" class="individual" id="marka_ayar" name='marka_ayar' value="1" >
                                                                            <label for="marka_ayar"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2115']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2110']?>"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="yorum_ayar" value="0">
                                                                            <input type="checkbox" class="individual" id="yorum_ayar" name='yorum_ayar' value="1" >
                                                                            <label for="yorum_ayar"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                               <?=$diller['adminpanel-form-text-2116']?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="taksit_ayar" value="0">
                                                                            <input type="checkbox" class="individual" id="taksit_ayar" name='taksit_ayar' value="1" >
                                                                            <label for="taksit_ayar"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2117']?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="stokkod_ayar" value="0">
                                                                            <input type="checkbox" class="individual" id="stokkod_ayar" name='stokkod_ayar' value="1" >
                                                                            <label for="stokkod_ayar"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2121']?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row border-top pt-3 bg-white">
                                                                    <div class="form-group col-md-6 mb-2 ">
                                                                        <label for="kdv" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                           <?=$diller['adminpanel-form-text-2118']?>
                                                                        </label>
                                                                        <select name="kdv" class="form-control " id="kdv"  required style="width: 100%;  ">
                                                                            <option value="1" ><?=$diller['adminpanel-form-text-1664']?></option>
                                                                            <option value="2" ><?=$diller['adminpanel-form-text-1665']?></option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4 ">
                                                                        <label for="kdv_oran2" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                             * <?=$diller['adminpanel-form-text-1667']?> (<?=$diller['adminpanel-text-364']?>)
                                                                        </label>
                                                                        <div class="input-group mb-2">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text font-12 font-weight-bold">
                                                                                    <i class="fas fa-percent"></i>
                                                                                </div>
                                                                            </div>
                                                                            <input type="text" class="form-control" autocomplete="off" id="kdv_oran2" value="<?=$row['kdv_oran']?>" name="kdv_oran" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row border-top pt-3 bg-white">
                                                                    <div class="form-group col-md-6 mb-3 ">
                                                                        <label for="kargo" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                            <?=$diller['adminpanel-form-text-2119']?>
                                                                        </label>
                                                                        <select name="kargo" class="form-control " id="kargo"  required style="width: 100%;  ">
                                                                            <option value="0" ><?=$diller['adminpanel-form-text-1670']?></option>
                                                                            <option value="1" ><?=$diller['adminpanel-form-text-1671']?></option>
                                                                        </select>
                                                                    </div>
                                                                    <div  id="kargo_ucreti" class="form-group col-md-4 " style="display: none">
                                                                        <label for="kargo_ucret" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                            <?=$diller['adminpanel-form-text-1672']?>
                                                                        </label>
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" class="form-control" autocomplete="off" id="kargo_ucret"  name="kargo_ucret" >
                                                                            <div class="input-group-append">
                                                                                <div class="input-group-text font-12 font-weight-bold">
                                                                                    <?=$Current_Money['sag_simge']?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <script>
                                                                        $('#kargo').on('change', function() {
                                                                            $('#kargo_ucreti').css('display', 'none');
                                                                            if ( $(this).val() === '1' ) {
                                                                                $('#kargo_ucreti').css('display', 'block');
                                                                            }
                                                                        });
                                                                    </script>
                                                                </div>
                                                                <div class="row border-top pt-3 bg-white">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="fiyat_goster" class="w-100 d-flex align-items-center justify-content-start" >
                                                                            <?=$diller['adminpanel-form-text-1647']?>
                                                                        </label>
                                                                        <select name="fiyat_goster" class="form-control selet2" id="fiyat_goster" style="width: 100%;  " >
                                                                            <option value="0" ><?=$diller['adminpanel-form-text-1648']?></option>
                                                                            <option value="1" selected ><?=$diller['adminpanel-form-text-1649']?></option>
                                                                            <option value="2" ><?=$diller['adminpanel-form-text-1650']?></option>
                                                                            <option value="3" ><?=$diller['adminpanel-form-text-1651']?></option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-4 ">
                                                                        <label for="ek_oran" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                           <?=$diller['adminpanel-form-text-2120']?>
                                                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2024']?>"></i>
                                                                        </label>
                                                                        <div class="input-group mb-2">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text font-12 font-weight-bold">
                                                                                    <i class="fas fa-percent"></i>
                                                                                </div>
                                                                            </div>
                                                                            <input type="text" class="form-control" autocomplete="off" id="ek_oran" value="0" name="ek_oran" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="w-100 border bg-light  rounded pt-3 pl-3 pr-3 mb-3" >
                                                                <div class="w-100 " style="font-size: 16px ; font-weight: 500;">
                                                                    <i class="fa fa-arrow-down"></i>
                                                                    <?=$diller['adminpanel-form-text-2122']?>
                                                                </div>
                                                                <div class="row border-top pt-3 mt-3 bg-white">
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="upd_baslik" value="0">
                                                                            <input type="checkbox" class="individual" id="upd_baslik" name='upd_baslik' value="1" >
                                                                            <label for="upd_baslik"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2123']?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="upd_fiyat" value="0">
                                                                            <input type="checkbox" class="individual" id="upd_fiyat" name='upd_fiyat' value="1" >
                                                                            <label for="upd_fiyat"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2131']?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="upd_foto" value="0">
                                                                            <input type="checkbox" class="individual" id="upd_foto" name='upd_foto' value="1" >
                                                                            <label for="upd_foto"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2124']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2129']?>"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="upd_stok" value="0">
                                                                            <input type="checkbox" class="individual" id="upd_stok" name='upd_stok' value="1" >
                                                                            <label for="upd_stok"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2125']?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="upd_stokkod" value="0">
                                                                            <input type="checkbox" class="individual" id="upd_stokkod" name='upd_stokkod' value="1" >
                                                                            <label for="upd_stokkod"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2126']?>
                                                                                <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2127']?>"></i>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group col-md-4 mb-3">
                                                                        <div class="kustom-checkbox">
                                                                            <input type="hidden" name="upd_aciklama" value="0">
                                                                            <input type="checkbox" class="individual" id="upd_aciklama" name='upd_aciklama' value="1" >
                                                                            <label for="upd_aciklama"  class="d-flex align-items-center justify-content-start" style="font-weight: 200 !important;font-size: 14px ; ">
                                                                                <?=$diller['adminpanel-form-text-2128']?>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row border-top pt-3 bg-white">
                                                                    <div class="form-group col-md-2 ">
                                                                        <label for="upd_ek_oran" class="w-100 d-flex align-items-center justify-content-start flex-wrap">
                                                                            <?=$diller['adminpanel-form-text-2120']?>
                                                                            <i class="ti-help-alt text-primary ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['adminpanel-form-text-2024']?>"></i>
                                                                        </label>
                                                                        <div class="input-group mb-2">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text font-12 font-weight-bold">
                                                                                    <i class="fas fa-percent"></i>
                                                                                </div>
                                                                            </div>
                                                                            <input type="text" class="form-control" autocomplete="off" id="upd_ek_oran" value="0" name="upd_ek_oran" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="xml_id" value="<?=$id?>">
                                                            <input type="hidden" name="dosya" value="<?=$row['dosya']?>">
                                                            <input type="hidden" name="anatag" value="<?=$anaTag?>">
                                                            <input type="hidden" name="idtag" value="<?=$idTag?>">
                                                            <input type="hidden" name="basliktag" value="<?=$baslikTag?>">
                                                            <input type="hidden" name="stoktag" value="<?=$stokTag?>">
                                                            <input type="hidden" name="fiyattag" value="<?=$fiyatTag?>">
                                                            <input type="hidden" name="gorseltag" value="<?=$gorselTag?>">
                                                            <input type="hidden" name="kattag" value="<?=$katTag?>">
                                                            <input type="hidden" name="markatag" value="<?=$markaTag?>">
                                                            <input type="hidden" name="barkodtag" value="<?=$barkodTag?>">
                                                            <input type="hidden" name="stokkodtag" value="<?=$stokkodTag?>">
                                                            <input type="hidden" name="aciklamatag" value="<?=$aciklamaTag?>">
                                                            <div class="row d-flex align-items-center justify-content-center ">
                                                                <div class="form-group col-md-12">
                                                                    <input type="hidden" name="sync">
                                                                    <button class="btn btn-success btn-block" id="waitButton" style="height: 50px; font-size: 18px ;">
                                                                        <i class="fa fa-cloud-upload-alt"></i> <?=$diller['adminpanel-form-text-2074']?>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php  }else{
                                            echo '<div class="row">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <div>
                                            <a href="pages.php?page=product_import_process&id='.$_GET['id'].'" class="btn btn-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> '.$diller['adminpanel-text-138'].'
                                            </a>
                                        </div>
                                        <div class="w-100 bg-danger text-white border border-danger rounded p-3 " style="font-size: 16px ;">
                                            '.$diller['adminpanel-form-text-2075'].'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                                        }
                                    }else{
                                        echo '<div class="row">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <div>
                                            <a href="pages.php?page=product_import_process&id='.$_GET['id'].'" class="btn btn-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> '.$diller['adminpanel-text-138'].'
                                            </a>
                                        </div>
                                        <div class="w-100 bg-danger text-white border border-danger rounded p-3 " style="font-size: 16px ;">
                                            '.$diller['adminpanel-form-text-2075'].'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                                    }
                                }else{
                                    echo '<div class="row">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <div>
                                            <a href="pages.php?page=product_import_process&id='.$_GET['id'].'" class="btn btn-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> '.$diller['adminpanel-text-138'].'
                                            </a>
                                        </div>
                                        <div class="w-100 bg-danger text-white border border-danger rounded p-3 " style="font-size: 16px ;">
                                            '.$diller['adminpanel-form-text-2075'].'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                                }
                            }else{
                                echo '<div class="row">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <div>
                                            <a href="pages.php?page=product_import_process&id='.$_GET['id'].'" class="btn btn-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> '.$diller['adminpanel-text-138'].'
                                            </a>
                                        </div>
                                        <div class="w-100 bg-danger text-white border border-danger rounded p-3 " style="font-size: 16px ;">
                                            '.$diller['adminpanel-form-text-2075'].'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            }
                        }else{
                            echo '<div class="row">
                                <div class="col-md-12">
                                    <div class="card p-3">
                                        <div>
                                            <a href="pages.php?page=product_import_process&id='.$_GET['id'].'" class="btn btn-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> '.$diller['adminpanel-text-138'].'
                                            </a>
                                        </div>
                                        <div class="w-100 bg-danger text-white border border-danger rounded p-3 " style="font-size: 16px ;">
                                            '.$diller['adminpanel-form-text-2075'].'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_import_process&id='.$_GET['id'].'');
                        exit();
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }?>
            <?php } ?>
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